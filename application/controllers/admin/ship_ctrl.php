<?php

class ship_ctrl extends CI_Controller {

	public $data;
	public $filter;
	public $limit = 16;
	public static $CURRENT_CONTEXT = '/admin/ship_ctrl';
	public static $TITLE = "KRI";
	private $neptunus_client;

	public function __construct() {
		parent::__construct();
		$this->data = array();
		$this->load->helper('string');
		$this->load->helper('url');
		$this->load->helper('stringify');
		$this->load->helper('geodesics');
		$this->load->helper('acl');
		$this->load->library('session');
		if ($this->config->item('use_mongo')) {
			$this->load->library('position_mapsys');
		}
		$this->load->helper('acl');
		$this->load->library('dao/unit_dao');
		$this->load->library('dao/logistic_item_dao');
		$this->load->library('dao/ship_viewability_dao');
		$this->load->library('dao/ship_dao');
		$this->load->library('dao/ship_type_dao');
		$this->load->library('dao/ship_status_dao');
		$this->load->library('dao/ship_logistics_dao');
		$this->load->library('dao/corps_dao');
		$this->load->library('dao/station_dao');
		$this->load->library('dao/personnel_dao');
		$this->load->library('dao/personnel_reff_dao');
		$this->load->library('dao/ship_ado_dao');
		$this->load->library('dao/ship_dislocation_history_dao');
		$this->load->library('dao/operation_dao'); // added by SKM17
		$this->load->library('dao/port_dao'); // added by SKM17

		$this->load->library('dao/user_role_dao');
		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->library('session');
		$this->load->library('tank_auth');
		$this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
		$this->load->library('pagination');

		$this->load->library('shipmgupdater');

		$this->logged_in();
		$this->role_user();
		$this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
		$this->data['idAccessMsg'] = $this->session->userdata(SESSION_USERMSGID);

		$this->neptunus_client = new NeptunusClient(
			$this->config->item('neptunus_host'), 
			$this->config->item('neptunus_port')
		);
	}

	private function validate() {

		$this->form_validation->set_rules('ship_stat_id', 'ship_stat_id', '');
		$this->form_validation->set_rules('ship_imo', 'ship_imo', '');


		return $this->form_validation->run();
	}

	/**
	  prepare data for view
	 */
	public function preload($context = '') {
		$this->data['current_context'] = self::$CURRENT_CONTEXT . $context;
		$this->data['title'] = self::$TITLE;
	}

	public function load_view($page, $data = null) {
		$this->load->view('template/template_header', $data);
		$this->load->view('template/template_menu', $this->data);
		$this->load->view($page);
		$this->load->view('template/template_footer');
	}

	public function load_position($page, $data = null) {
		$this->load->view('template/template_header', $data);
		$this->load->view('template/template_menu', $this->data);
		$this->load->view($page);
		$this->load->view('template/template_footer');
	}

	public function index($offset = 0) {
		$this->preload();
		$this->get_list($this->limit, $offset);
//        $this->get_list_logistic($this->limit, $offset);
		$this->load_view('admin/ship/list_ship', $this->data);
	}

	public function position() {
		$this->preload('/position');
		$obj = $this->filter_param();
		$filter = (!empty($obj)) ? $obj : null; 
		$filter['ship_is_in_operation'] = 'TRUE'; // added by SKM17

		if ($this->uri->segment(4) == "") {
			$offset = 0;
		} else {
			$offset = $this->uri->segment(4);
		}

		$user_group = get_data_restriction($this->session->userdata(SESSION_USERGROUP));
		if ($user_group != null)
			$filter['corps_id'] = $user_group; // added by SKM17
		
		if (!empty($obj) && ($obj['ship_timestamp_date'] != "" || $obj['ship_timestamp_time'] != "")) {
			//lookup to history
			$this->data['ship'] = $this->ship_dislocation_history_dao->table_fetch($this->limit, $offset, $filter, null, true);
			$count_data_ship = $this->ship_dislocation_history_dao->count_table_fetch($filter);
			$this->data['isSearchTime'] = true; // added by SKM17
		} else {
			//lookup to current data. 
			$this->data['ship'] = $this->ship_dao->table_fetch($this->limit, $offset, $filter, null, true, true);
			$count_data_ship = $this->ship_dao->count_table_fetch($filter);
		}

		$config['base_url'] = base_url() . self::$CURRENT_CONTEXT . '/position';
		$config['total_rows'] = $count_data_ship;
		$config['per_page'] = $this->limit;
		$config['uri_segment'] = 4;
		$config['filter_param'] = $_SERVER['QUERY_STRING'];  //added by D3
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['offset'] = $offset;
		$this->data['ship_status'] = $this->ship_status_dao->fetch();
		//ship logistic
		$this->data['logistic_item'] = $this->logistic_item_dao->fetch('1');

		$this->data['ship_logistics'] = null; //$this->ship_logistics_dao->table_fetch($limit, $offset);
		//ship personel
		$this->data['personel'] = $this->personnel_reff_dao->fetch();
		$this->data['ship_personel'] = null;
		//ship ado
		$this->data['ship_ado'] = null;

		$this->data['corps'] = $this->corps_dao->fetch(1000, 0, 'corps_name', array('corps_type_id' => '1')); // edited by SKM17
		$this->data['ship_status'] = $this->ship_status_dao->fetch();
		$this->data['ship_type'] = $this->ship_type_dao->fetch(1000, 0, 'shiptype_desc'); // edited by SKM17
		$this->data['realtime'] = array('TRUE' => 'Ya', 'FALSE' => 'Tidak');
		
		// Added by D3 KP
		$this->data['type']=$this->ship_type_dao->fetch();
		$this->data['operation'] = $this->operation_dao->fetch(1000, 0, 'operation_name'); 
		// end Added

		/*
			update ship mongo and
			(   
				lat,
				lon,
				direction,
				speed,
				isRealtime,
				postTime
			)
		*/


		$this->load_position('admin/ship/ship_position', $this->data);
	}

	public function fetch_record($keys) {
		$this->data['ship'] = $this->ship_dao->by_id($keys);
	}

	private function fetch_data($limit = null, $offset = null, $filter = null) {
		$criteria = null;
		$restriction = get_data_restriction($this->session->userdata(SESSION_USERGROUP));
		if (!is_null($restriction) && $restriction != "") {

			$filter['corps_id'] = $restriction;
		}

		//print_r($filter);
		$this->data['ship'] = $this->ship_dao->table_fetch($limit, $offset, $filter, null, true);

		//print_r($this->data['ship']);
		$this->data['corps'] = $this->corps_dao->fetch(1000, 0, 'corps_name', array('corps_type_id' => '1'));
		$this->data['ship_type'] = $this->ship_type_dao->fetch(1000, 0, 'shiptype_desc');
		$this->data['ship_status'] = $this->ship_status_dao->fetch();
		$this->data['realtime'] = array('TRUE' => 'Ya', 'FALSE' => 'Tidak');
		
		$units = $this->unit_dao->fetch_data(null, 1000, 0, 'unit_name');
		$unit_pv = array();
		$unit_pv[''] = '-Pilih Kesatuan-';
		foreach ($units as $u) {
			if ($u->unitcat_id == 1) {
				$unit_pv[$u->unit_id] = $u->unit_name;
			}
		}
		$this->data['unit'] = $unit_pv;

		// $stations = $this->station_dao->table_fetch();
		// $stat_pv = array();
		// $stat_pv[''] = '-Pilih Satuan-';
		// foreach ($stations as $st) {
		// $stat_pv[$st->station_id] = $st->station_name;
		// }
		// $this->data['stations'] = $stat_pv;
	}

	private function getValue($inputid) {
		return $this->input->post($inputid) == '' ? 0 : (float) $this->input->post($inputid);
	}

	private function getValue2($var) {
		return $var == '' ? 0 : (float) $var;
	}

	public function ops_update_() {
		$ship_id = $_POST['ship_id'];

		$ship_dlat = $_POST['ship_dlat'];
		$ship_mlat = $_POST['ship_mlat'];
		$ship_slat = $_POST['ship_slat'];
		$ship_rlat = $_POST['ship_rlat'];

		$ship_dlon = $_POST['ship_dlon'];
		$ship_mlon = $_POST['ship_mlon'];
		$ship_slon = $_POST['ship_slon'];
		$ship_rlon = $_POST['ship_rlon'];
		
		$ship_speed = $_POST['ship_speed'];
		$ship_direction = $_POST['ship_direction'];
		$ship_location = $_POST['ship_location'];
		$ship_timestamp = $_POST['ship_timestamp'];
		
		$operation_id = $_POST['operation_id'];
//        $ship_cond = $_POST['ship_cond'];

		$data['ship_lat'] = toGeoDec($this->getValue2($ship_dlat), $this->getValue2($ship_mlat), $this->getValue2($ship_slat), $this->getValue2($ship_rlat));
		$data['ship_lon'] = toGeoDec($this->getValue2($ship_dlon), $this->getValue2($ship_mlon), $this->getValue2($ship_slon), $this->getValue2($ship_rlon));
//        $data['shipcond_id'] = $ship_cond;
		$data['ship_speed'] = $ship_speed;
		$data['ship_direction'] = $ship_direction;
		$data['ship_water_location'] = $ship_location;
		$data['ship_timestamp_location'] = date("Y-m-d").' '.$ship_timestamp;
		//save historikal
		$his['ship_lat'] = $data['ship_lat'];
		$his['ship_lon'] = $data['ship_lon'];
		$his['ship_direction'] = $ship_direction;
		$his['ship_speed'] = $ship_speed;
		$his['ship_water_location'] = $ship_location;
		$his['operation_id'] = $operation_id;
		$his['ship_timestamp'] = $ship_timestamp;
		$his['ship_id'] = $ship_id;
		$this->save_historical_position($his, true);
		
		$obj_id = array('ship_id' => $ship_id);
		$save = $this->ship_dao->update($data, $obj_id);

		/* updating state to mongo database */
		if ($this->config->item('use_mongo')) {
			$this->position_mapsys->update_position($ship_id, $data['ship_lat'], $data['ship_lon']);
		}

		if ($save) {
			echo 'success';
		} else {
			echo 'failed';
		}
	}

	public function save() {
		$obj = $this->fetch_input();

		$infoSession = ''; // added by SKM17
		if ($this->validate() != false) {
			$ship_image = '';
			$ship_icon = '';
			//$this->data['error_main_image'] = false;
			//$this->data['msg_error_main_image'] = '';
			//$this->data['error_icon'] = false;
			$this->data['msg_error_icon'] = '';
			$config_main_image['upload_path'] = './assets/img/upload/main/';
			$config_main_image['allowed_types'] = 'gif|jpg|png|jpeg';
			$config_main_image['max_size'] = '2000';  //edited by D3

			$config_main_image['max_width'] = ''; //edited by D3
			$config_main_image['max_height'] = '';//edited by D3

			$config_main_image['encrypt_name'] = true; 
			$this->upload->initialize($config_main_image);


			$info='';
			if($_FILES['ship_image']['name']!=''){    
				if ($this->upload->do_upload('ship_image')) {
					$info = $this->upload->data();
					$ship_image = $info['file_name'];
					// $this->_resize_image('./assets/img/upload/main/'.$ship_image,'./assets/img/upload/main/'.$ship_image,1024,768);
					$infoSession .= "Gambar KRI berhasil diunggah. ";
				} else {
					$this->data['error_main_image'] = true;
					$this->data['msg_error_main_image'] = strip_tags($this->upload->display_errors());
					$infoSession.= "<font color='red'>Gambar KRI GAGAL diunggah. Silakan masukan gambar dibawah 2MB dan maksimal 1000x1000 px.</font> ";
					$this->session->set_flashdata("info", $infoSession);
					//redirect(self::$CURRENT_CONTEXT);
				}
			}
			/* mongo updates */


			if (intval($obj['shipcond_id']) != 1) {
				if ($this->config->item('use_mongo')) {
					$status = $this->position_mapsys->delete($obj['ship_id']);
				}
			}

			/* ENDOF mongo updates */
			$config_icon['upload_path'] = './assets/img/upload/icon/';
			$config_icon['allowed_types'] = 'gif|jpg|png|jpeg';
			$config_icon['max_width'] = '100'; //edited by D3
			$config_icon['max_height'] = '100';//edited by D3
			$config_icon['max_size'] = '1000';
			$config_icon['encrypt_name'] = true;
			$this->upload->initialize($config_icon);
			$obj_id = array('ship_id' => $obj['ship_id']);
			if($_FILES['ship_icon']['name']!=''){    
				if ($this->upload->do_upload('ship_icon')) {
					$info = $this->upload->data();
					$ship_icon = $info['file_name'];
					$this->_resize_image('./assets/img/upload/icon/' . $ship_icon, './assets/img/upload/icon/' . $ship_icon, 75, 75);
					$infoSession .= "Icon KRI berhasil diunggah. ";
				} else {
					$this->data['error_icon'] = true;
					$this->data['msg_error_icon'] = strip_tags($this->upload->display_errors());
					$infoSession.= "<font color='red'>Icon KRI GAGAL diunggah. Silakan masukan icon dibawah 1MB dan maksimal 100x100 px.</font> ";
					$this->session->set_flashdata("info", $infoSession);
				}
				$obj_id = array('ship_id' => $obj['ship_id']);
				if ($this->data['error_main_image'] != true) {
					$obj['ship_image'] = $ship_image;
				}
				if ($this->data['error_icon'] != true) {
					$obj['ship_icon'] = $ship_icon;
				}
			}else{
				// $infoSession.="<font color='red'>Icon tidak diubah.</font>";   
			}
			/*if id exists update, save if isn't*/
			$saved; // added by SKM17
			if ($this->ship_dao->by_id($obj_id) != null) 
			{
				$saved = $this->ship_dao->update($obj, $obj_id);
				$this->save_gallery_image($this->input->post('count_gallery_image'), $obj['ship_id']);
				$infoSession .= "Data KRI berhasil diubah. ";
				$this->data['saving'] = true;
			} 
			else {
				$obj['ship_image'] = $ship_image;
				$obj['ship_icon'] = $ship_icon;
				$saved = $this->ship_dao->insert($obj);
				$this->save_gallery_image($this->input->post('count_gallery_image'), $obj['ship_id']);
				$infoSession .= "Data KRI berhasil ditambah. ";
			}
			
			if (!$saved) {
				$infoSession .= "Data KRI gagal ditambah/diubah. ";
			} else {
//	            $this->neptunus_client->sendSyncNewKRI($obj['ship_id']); // ini ga jalan ternyata
				$this->session->set_flashdata("trigger_io", "true"); // added by SKM17 for synchronizing ship in mongo
			}
	
			$this->session->set_flashdata("info", $infoSession);
			$this->data['saving'] = true;
			redirect(self::$CURRENT_CONTEXT);
//            $this->save_logistic();
//            $this->save_personel();
//            $this->save_ado();
		} else {
			/* invalid input will be redirected to edit view with error message included */
			$this->get_list($this->limit, 0);
			$this->preload();
			$this->data['edit'] = false;
			#prepare link for back to view list
			$this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
			$this->load_view('admin/ship/list_ship', $this->data);
		}
	}

	private function fetch_input() {
		if ($this->input->post('ship_id')) {
			$data['ship_id'] = $this->input->post('ship_id');
		}
		$data['ship_abbr'] = $this->input->post('ship_abbr');
		$data['ship_name'] = $this->input->post('ship_name');
		$data['ship_commander'] = $this->input->post('ship_commander');
		$data['ship_stat_id'] = 3; // dijadikan statik, defaultnya SANDAR alias 3
		$data['unit_id'] = $this->input->post('unit_id');
		$data['corps_id'] = $this->input->post('corps_id');
		$data['shiptype_id'] = $this->input->post('shiptype_id');
		$data['shipcond_id'] = $this->input->post('shipcond_id');
		$data['ship_is_in_operation'] = ($this->input->post('ship_is_in_operation') == '') ? 'f' : $this->input->post('ship_is_in_operation'); // added by SKM17
		$data['ship_dsp'] = $this->input->post('ship_dsp');
		$data['ship_condition'] = $this->input->post('ship_condition');
		$puskodalid = $this->input->post('ship_id');
		$data['ship_pjl_ops'] = ($this->input->post('ship_pjl_ops') == '') ? 0 : $this->input->post('ship_pjl_ops');
		$data['ship_realitation'] = ($this->input->post('ship_realitation') == '') ? 0 : $this->input->post('ship_realitation');
		$data['ship_riil'] = ($this->input->post('ship_riil') == '') ? 0 : $this->input->post('ship_riil');
		$data['ship_skep_kasal'] = $this->input->post('ship_skep_kasal');
		$data['ship_created'] = ($this->input->post('ship_created') == '') ? null : $this->input->post('ship_created');
		$data['ship_factory'] = $this->input->post('ship_factory');
		$data['ship_country_created'] = $this->input->post('ship_country_created');
		$data['ship_work_year'] = $this->input->post('ship_work_year');
		$data['ship_nickname'] = $this->input->post('ship_nickname');
		$data['ship_weight'] = $this->input->post('ship_weight');
		$data['ship_length'] = $this->input->post('ship_length');
		$data['ship_width'] = $this->input->post('ship_width');
		$data['ship_draft'] = $this->input->post('ship_draft');
		$data['ship_machine'] = $this->input->post('ship_machine');
		$data['ship_speed_desc'] = $this->input->post('ship_speed_desc');
		$data['ship_people'] = $this->input->post('ship_people');
//        $data['ship_icon'] = $this->input->post('ship_icon'); // added by SKM17, sementara dikomen dulu karena belum tau ngefeknya kemana
		$data['ship_history'] = $this->input->post('ship_history');
		$data['ship_weapon'] = $this->input->post('ship_weapon');
		$data['ship_helicopter'] = $this->input->post('ship_helicopter');
		$data['ship_radar'] = $this->input->post('ship_radar');
		$data['ship_sonar'] = $this->input->post('ship_sonar');
		$data['ship_cctv_ip'] = $this->input->post('ship_cctv_ip');
		$data['ship_cctv_uname'] = $this->input->post('ship_cctv_uname');
		$data['ship_cctv_pwd'] = $this->input->post('ship_cctv_pwd');
//        $data = array('ship_id' => $this->input->post('ship_id'),
		// $data['station_id'] = $this->input->post('station_id');
		// $data['ship_imo'] = $this->input->post('ship_imo'); // commented by SKM17 karena udah ga ada di form
		return $data;
	}

	function save_gallery_image($count_gallery, $ship_id) {
		$config_gallery['upload_path'] = './assets/img/upload/gallery/';
		$config_gallery['allowed_types'] = 'gif|jpg|png';
		$config_gallery['max_size'] = '2000';
		$config_gallery['max_width'] = '0';
		$config_gallery['max_height'] = '0';
		$config_gallery['encrypt_name'] = true;
		for ($i = 0; $i < $count_gallery; $i++) {
			$this->upload->initialize($config_gallery);
			if ($this->upload->do_upload('galeri' . $i)) {
				$info = $this->upload->data();
				$this->ship_dao->save_gallery_image($info['file_name'], $ship_id);
			}
		}
	}

	function _resize_image($source, $dest, $width, $height) {
		// $config['image_library'] = 'gd2';
		$config['source_image'] = $source;
		$config['new_image'] = $dest;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = $width;
		$config['height'] = $height;

		$this->image_lib->initialize($config);

		$this->image_lib->resize();
	}

	private function fetch_input_position() {
		$data['ship_id'] = $this->input->post('ship_id');
		if ($this->input->post('kodal_id')) $data['kodal_id'] = $this->input->post('kodal_id'); // added by SKM17
		$data['ship_lat'] = toGeoDec($this->getValue('ship_dlat'), $this->getValue('ship_mlat'), $this->getValue('ship_slat'), $this->getValue('ship_rlat'));
		$data['ship_lon'] = toGeoDec($this->getValue('ship_dlon'), $this->getValue('ship_mlon'), $this->getValue('ship_slon'), $this->getValue('ship_rlon'));
		$data['ship_direction'] = $this->input->post('ship_direction') == '' ? 0 : $this->input->post('ship_direction');
		$data['ship_speed'] = $this->input->post('ship_speed') == '' ? 0 : $this->input->post('ship_speed');
		$data['operation_id'] = $this->input->post('operation_id'); // uncommented by SKM17
		$data['ship_stat_id'] = ($this->input->post('ship_stat_id') == '') ? null : $this->input->post('ship_stat_id');
		$data['ship_dock'] = $this->input->post('ship_dock');
		$data['ship_water_location'] = $this->input->post('ship_water_location');
		$data['ship_lasttrans'] = ($this->input->post('ship_lasttrans') == '') ? null : $this->input->post('ship_lasttrans');
		$data['ship_iskri'] = ($this->input->post('ship_iskri') == '') ? 'f' : $this->input->post('ship_iskri');
		$data['ship_isrealtime'] = ($this->input->post('ship_isrealtime') == '') ? 'f' : $this->input->post('ship_isrealtime');
		// $data['ship_timestamp_location'] = date("Y-m-d") . ' ' . $this->input->post('ship_timestamp_location'); // commented and edited below by SKM17
		$data['ship_timestamp_location'] = $this->input->post('ship_lasttrans') . ' ' . $this->input->post('ship_timestamp_location'); // added by SKM17
		// $data['ship_image'] = $this->input->post('ship_image');
		// $data['ship_machinehour'] = $this->input->post('ship_machinehour') == '' ? 0 : $this->input->post('ship_machinehour');
		// $data['ship_currenthour'] = $this->input->post('ship_currenthour') == '' ? 0 : $this->input->post('ship_currenthour');
		// $data['ship_desc'] = $this->input->post('ship_desc');
		
		return $data;
	}

	public function save_position() {
		$obj = $this->fetch_input_position();
		if (isset($obj['ship_id']) && $obj['ship_id'] != null) {
			$obj_id = array('ship_id' => $obj['ship_id']);
			//saving historical
			$save_historical = $this->save_historical_position($obj);
			$update = $this->ship_dao->update($obj, $obj_id);
			$this->save_logistic();
			$this->ship_dao->updateOperation($obj);
			// $this->save_personel();
			$this->save_ado();

			if ($update) {
				$this->session->set_flashdata("trigger_io", "true");
				if ($save_historical == true) {
					$this->session->set_flashdata("info", "Perubahan Unsur Dislokasi dan Data Historikal berhasil disimpan.");
				} else {
					$this->session->set_flashdata("info", "Perubahan Unsur Dislokasi berhasil disimpan. Data historikal gagal disimpan!");
				}

				$ticShip = $this->ship_dao->by_id(array('ship_id'=>$obj['ship_id']));

				// print_r($ticShip); exit();
/*
				$this->shipmgupdater->update(
					array(
						"shipId" => $ticShip->ship_id,
						"lat"=> $obj["ship_lat"],
						"lon"=> $obj["ship_lon"],
						"direction"=> $obj["ship_direction"],
						"speed"=> $obj["ship_speed"],
						"postTime"=>new MongoDate(strtotime($obj["ship_timestamp_location"]))
					)
				);*/

			} else {
				$this->session->set_flashdata("info", "Perubahan Unsur Dislokasi gagal disimpan!");
			}

			redirect(self::$CURRENT_CONTEXT . '/' . 'position');
		}
	}

	public function save_historical_position($obj,$ops_update = false) {
		$insert = true;
		$data['ship_id'] = $obj['ship_id'];
		$data['shipdis_time'] = ($ops_update == true)?$obj['ship_timestamp']:$this->input->post('ship_timestamp_location');
		// $data['shipdis_date'] = date("Y-m-d");
		$data['shipdis_date'] = $obj['ship_lasttrans'];
		$data['shipdis_lat'] = $obj['ship_lat'];
		$data['shipdis_lon'] = $obj['ship_lon'];
		$data['shipdis_direction'] = $obj['ship_direction'];
		$data['shipdis_speed'] = $obj['ship_speed'];
		$data['operation_id'] = ($ops_update==true)?$obj['operation_id']:$this->input->post('operation_id');
		$data['shipdis_water_location'] = $obj['ship_water_location'];

		//to prevent duplicate date, delete first
		$this->ship_dislocation_history_dao->delete(array('ship_id' => $data['ship_id'], 'shipdis_time' => $data['shipdis_time'], 'shipdis_date' => $data['shipdis_date']));
		$insert = $this->ship_dislocation_history_dao->insert($data);
		return $insert;
	}

	public function save_logistic() {
		$status_insert = true;

		$ship_id = $this->input->post('ship_id');
		$totalRow = $this->input->post('totalRow');
		//delete logistik in ship first
		$this->ship_logistics_dao->delete(array('ship_id' => $ship_id));
		//insert new logistik
		for ($i = 1; $i <= $totalRow; $i++) {
			$shiplog = $this->input->post('shipLog_' . $i);
			$shipvalue = $this->input->post('shipValue_' . $i);

			$new_logistics = array('logitem_id' => $shiplog, 'ship_id' => $ship_id, 'shiplog_value' => $shipvalue);
			$this->ship_logistics_dao->insert($new_logistics);
		}

		return $status_insert;
	}

	public function save_personel() {
		$status_insert = true;

		$ship_id = $this->input->post('ship_id');
		$totalRow = $this->input->post('totalRowPersonel');
		//delete logistik in ship first
		$this->personnel_dao->delete(array('ship_id' => $ship_id));
		//insert new logistik
		for ($i = 1; $i <= $totalRow; $i++) {
			$personel = $this->input->post('personel_' . $i);
			$personel_value = $this->input->post('personelValue_' . $i);

			$new_personel = array('psnreff_nrp' => $personel, 'ship_id' => $ship_id, 'psn_value' => $personel_value);
			$this->personnel_dao->insert($new_personel);
		}
		return $status_insert;
	}

	public function save_ado() {
		$status_insert = true;

		$ship_id = $this->input->post('ship_id');
		$totalRow = $this->input->post('totalRowAdo');
		//delete logistik in ship first
		$this->ship_ado_dao->delete(array('ship_id' => $ship_id));
		//insert new logistik
		for ($i = 1; $i <= $totalRow; $i++) {
			$ado_report = $this->input->post('ado_' . $i);
			$ado_time = $this->input->post('adoDate_' . $i);

			$new_ado = array('ship_id' => $ship_id, 'ado_report' => $ado_report, 'ado_time' => $ado_time);
			$this->ship_ado_dao->insert($new_ado);
		}
		return $status_insert;
	}

	/**
	  repopulation for reference data done here.
	  add different reference data to different array.
	  and pass it to views using $this->data[] parameter.
	 */
	public function repopulate() {
		
	}

	/**
	  @description
	  viewing record. repopulation for every data needed for view.
	 */
	public function view($ship_id = null) {
		$this->preload();
		if ($ship_id == null
		) {
			$this->load_view('admin/ship/list_ship');
		} else {
			$this->get_list($this->limit);
//            $this->get_list_logistic($this->limit);

			$obj_id = array('ship_id' => $ship_id);

			$to_edit = $this->ship_dao->by_id($obj_id);
			$this->data['obj'] = $to_edit;
			$this->data['obj']->gallery_image = $this->ship_dao->get_gallery_image($obj_id);
			$this->data['view'] = true;
			$this->load_view('admin/ship/list_ship', $this->data);
		}
	}

	/**
	  @description
	  viewing editing form. repopulation for every data needed in form done here.
	 */
	public function edit($ship_id = null) {
		$this->preload();
		if ($ship_id == null
		) {
			$this->load_view('admin/ship/list_ship');
		} else {
			$this->get_list($this->limit, $this->uri->segment(5));
//            $this->get_list_logistic($this->limit);

			$obj_id = array('ship_id' => $ship_id);

			$to_edit = $this->ship_dao->by_id($obj_id);
			$this->data['obj'] = $to_edit;
			$this->data['obj']->gallery_image = $this->ship_dao->get_gallery_image($obj_id);
			$this->load_view('admin/ship/list_ship', $this->data);
		}
	}

	public function delete($ship_id = null) {
		$obj_id = array('ship_id' => $ship_id);
		//menghapus gambar di folder added by D3 Polban
		$image = $this->ship_dao->by_id($obj_id);
		unlink($this->config->item('root_path')."assets/img/upload/main/".$image->ship_image);
		unlink($this->config->item('root_path')."assets/img/upload/icon/".$image->ship_icon);
		//end added
		
		$this->ship_logistics_dao->delete($obj_id);
		$this->ship_viewability_dao->delete($obj_id);
		$this->ship_dao->delete_gallery_image($ship_id);
		$status_del = $this->ship_dao->delete($obj_id);
		if ($status_del == false) {
			$this->session->set_flashdata("info", "Hapus Data KRI Gagal, Data KRI terhubung dengan data lain!");
		} else {
			$this->neptunus_client->sendShipDelete($ship_id);
			$this->session->set_flashdata("trigger_io", "true"); // added by SKM17
			$this->session->set_flashdata("info", "Hapus Data KRI Berhasil!");
		}
		redirect(self::$CURRENT_CONTEXT);
	}

	public function view_position($ship_id = null) {
		$this->preload('/position');
		if ($ship_id == null) {
			// $this->session->set_flashdata("info", "Nomor lambung tidak teridentifikasi"); // commented by SKM17
			$this->load_view('admin/ship/ship_position');
		} else {
			$obj = $this->filter_param();
			$filter = (!empty($obj)) ? $obj : null;
			$filter['ship_is_in_operation'] = 'TRUE'; // added by SKM17
			if ($this->uri->segment(5) == "") {
				$offset = 0;
			} else {
				$offset = $this->uri->segment(5);
			}

			$user_group = get_data_restriction($this->session->userdata(SESSION_USERGROUP));
			if ($user_group != null)
				$filter['corps_id'] = $user_group; // added by SKM17
			
			$this->data['ship'] = $this->ship_dao->table_fetch($this->limit, $offset, $filter, null, true, true);
			$count_data_ship = $this->ship_dao->count_table_fetch($filter);
			$config['base_url'] = base_url() . self::$CURRENT_CONTEXT . '/view_position/' . $ship_id;
			$config['total_rows'] = $count_data_ship;
			$config['per_page'] = 5;
			$config['uri_segment'] = 5;
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$this->data['offset'] = $offset;
			$this->data['ship_status'] = $this->ship_status_dao->fetch();
			$this->data['logistic_item'] = $this->logistic_item_dao->fetch('1');
			$this->data['personel'] = $this->personnel_reff_dao->fetch();

			$this->data['ship_logistics'] = $this->ship_logistics_dao->table_fetch($ship_id);
			// $this->data['ship_personel'] = $this->personnel_dao->table_fetch($ship_id);
			$this->data['ship_ado'] = $this->ship_ado_dao->table_fetch($ship_id, 10, "ship_ado.ado_time", false);

			$obj_id = array('ship_id' => $ship_id);

			$to_view = $this->ship_dao->by_id_($ship_id);
			$this->data['obj'] = $to_view;
			$this->data['view'] = true;
			$this->data['corps'] = $this->corps_dao->fetch(1000, 0, 'corps_name', array('corps_type_id' => '1'));
		   
		   //added by d3 
			$this->data['type']=$this->ship_type_dao->fetch();

			$this->load_view('admin/ship/ship_position', $this->data);
		}
	}

	public function edit_position($ship_id = null) {
		$this->preload('/position');
		if ($ship_id == null) {
			$this->session->set_flashdata("info", "Nomor lambung tidak teridentifikasi");
			$this->load_view('admin/ship/ship_position');
		} else {
			$obj = $this->filter_param();
			$filter = (!empty($obj)) ? $obj : null;
			$filter['ship_is_in_operation'] = 'TRUE'; // added by SKM17
			
			if ($this->uri->segment(5) == "") {
				$offset = 0;
			} else {
				$offset = $this->uri->segment(5);
			}

			$user_group = get_data_restriction($this->session->userdata(SESSION_USERGROUP));
			if ($user_group != null)
				$filter['corps_id'] = $user_group; // added by SKM17
			
			$this->data['ship'] = $this->ship_dao->table_fetch($this->limit, $offset, $filter, null, true, true);
			$count_data_ship = $this->ship_dao->count_table_fetch($filter);
			$config['base_url'] = base_url() . self::$CURRENT_CONTEXT . '/edit_position/' . $ship_id;
			$config['total_rows'] = $count_data_ship;
			$config['per_page'] = $this->limit;
			$config['uri_segment'] = 5;
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$this->data['offset'] = $offset;
			$this->data['ship_status'] = $this->ship_status_dao->fetch();
			$this->data['logistic_item'] = $this->logistic_item_dao->fetch('1');
			$this->data['personel'] = $this->personnel_reff_dao->fetch();

			$this->data['ship_logistics'] = $this->ship_logistics_dao->table_fetch($ship_id);
			//$this->data['ship_personel'] = $this->personnel_dao->table_fetch($ship_id);
			$this->data['ship_ado'] = $this->ship_ado_dao->table_fetch($ship_id,10,"ship.ship_time", false);
			$this->data['corps'] = $this->corps_dao->fetch(1000, 0, 'corps_name', array('corps_type_id' => '1'));
			$this->data['ship_status'] = $this->ship_status_dao->fetch();
			$this->data['ship_type'] = $this->ship_type_dao->fetch(1000, 0, 'shiptype_desc'); // edited by SKM17
			$this->data['realtime'] = array('TRUE' => 'Ya', 'FALSE' => 'Tidak');
			$this->data['operation'] = $this->operation_dao->fetch(1000, 0, 'operation_name'); // added by SKM17
			$this->data['ports'] = $this->port_dao->fetch();    // added by SKM17

			$obj_id = array('ship_id' => $ship_id);

			$to_edit = $this->ship_dao->by_id_($ship_id);
			$this->data['obj'] = $to_edit;

			//added by d3
			$this->data['type']=$this->ship_type_dao->fetch();

			$this->load_view('admin/ship/ship_position', $this->data);
		}
	}

	/**
	  getting filter parameter when user
	  doing searching.
	 */
	public function filter_param() {
		$filter = array();
		if (isset($_GET['filter'])) {
			$filter['ship_name'] = $this->input->get('ship_name');
			$filter['ship_abbr'] = $this->input->get('ship_abbr');
			$filter['ship_id'] = $this->input->get('ship_id');
			$filter['shipcond_id'] = $this->input->get('shipcond_id');
			$filter['shiptype_id'] = $this->input->get('shiptype_id');
			$filter['ship_stat_id'] = $this->input->get('ship_stat_id');
			$filter['corps_id'] = $this->input->get('corps_id'); // uncommented by SKM17
			$filter['kodal_id'] = $this->input->get('kodal_id'); // added by SKM17
			$filter['operation_id'] = $this->input->get('operation_id'); // added by KP D3 
			$filter['ship_timestamp_date'] = $this->input->get('ship_timestamp_date');
			$filter['ship_timestamp_time'] = $this->input->get('ship_timestamp_time');
		}
		
		// other input receive
		return $filter;
	}

	public function get_list($limit = 16, $offset = 0) {
		$obj = $this->filter_param();
		$filter = (!empty($obj)) ? $obj : null;
		#generate pagination
		if ($this->uri->segment(3) == 'edit') {
			$base_url = self::$CURRENT_CONTEXT . '/edit/' . $this->uri->segment(4);
			$uri = 5;
		} else {
			$base_url = self::$CURRENT_CONTEXT . '/index/';
			$uri = 4;
		}
		$config['base_url'] = site_url($base_url);

		$config['total_rows'] = $this->ship_dao->count_table_fetch($filter);
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri;
		$config['filter_param'] = $_SERVER['QUERY_STRING'];
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['offset'] = $offset;
		$this->fetch_data($limit, $offset, $filter);
	}

	public function get_list_logistic($limit = 16, $offset = 0) {
		$obj = array();
		if (empty($obj)) {
			// non conditional data fetching
			$this->fetch_data($limit, $offset);
		} else {
			// apply filter
		}
	}

	/*     * role and permission* */

	function role_user() {
		$user_id = $this->tank_auth->get_user_id();
		$user = $this->user_role_dao->fetch_record($user_id);

		if (trim($user->role_name) == 'viewer') {
			redirect('html/map_clean');
		}
	}

	function logged_in() {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('home/login');
		}
	}

}
