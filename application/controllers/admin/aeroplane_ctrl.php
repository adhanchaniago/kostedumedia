<?php

class aeroplane_ctrl extends CI_Controller {

	public $data;
	public $filter;
	public $limit = 16;
	public static $CURRENT_CONTEXT = '/admin/aeroplane_ctrl';
	public static $TITLE = "Pesawat Udara";

	public function __construct() {
		parent::__construct();
		$this->data = array();
		$this->load->helper('string');
		$this->load->helper('url');
		$this->load->helper('geodesics');
		$this->load->helper('acl');
		$this->load->library('session');
		$this->load->library('dao/unit_dao');
		$this->load->library('dao/personnel_reff_dao');
		$this->load->library('dao/station_dao');
		$this->load->library('dao/logistic_item_dao');
		$this->load->library('dao/aeroplane_dao');
		$this->load->library('dao/aeroplane_type_dao');
		$this->load->library('dao/aeroplane_icon_dao'); // added by SKM17
		$this->load->library('dao/aeroplane_logistics_dao');
		$this->load->library('dao/corps_dao');
		$this->load->library('dao/aer_dislocation_history_dao');
		$this->load->library('dao/operation_dao'); // added by SKM17
		$this->load->library('dao/port_dao'); // added by SKM17
		$this->load->library('dao/ship_dao'); // added by SKM17
		
		$this->load->library('dao/user_role_dao');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
		$this->load->library('pagination');
		$this->load->library('tank_auth');
		$this->load->library('upload'); // added by SKM17

		$this->logged_in();
		$this->role_user();
		$this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
		$this->data['idAccessMsg'] = $this->session->userdata(SESSION_USERMSGID);
	}

	private function validate() {
		$this->form_validation->set_rules('logitem_id', 'logitem_id', '');
		$this->form_validation->set_rules('aerlog_value', 'aerlog_value', '');
		$this->form_validation->set_rules('station_id', 'station_id', '');
		$this->form_validation->set_rules('psnreff_nrp', 'psnreff_nrp', '');
		$this->form_validation->set_rules('aertype_id', 'aertype_id', 'required');
		$this->form_validation->set_rules('aer_id', 'aer_id', '');
		$this->form_validation->set_rules('corps_id', 'corps_id', 'required');
		$this->form_validation->set_rules('aer_lat', 'aer_lat', '');
		$this->form_validation->set_rules('aer_lon', 'aer_lon', '');
		$this->form_validation->set_rules('aer_name', 'aer_name', '');
		$this->form_validation->set_rules('aer_speed', 'aer_speed', '');
		$this->form_validation->set_rules('aer_endurance', 'aer_endurance', '');
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
//		$this->get_list_logistic($this->limit, $offset);
		$this->load_view('admin/aeroplane/list_aeroplane', $this->data);
	}

	/**

	  getting filter parameter when user
	  doing searching.
	 */
	public function filter_param() {
		$filter = array();
		if (isset($_GET['filter'])) {
			$filter['aer_name'] = $this->input->get('aer_name');
//			$filter['aer_isrealtime'] = ($this->input->get('aer_isrealtime') == '') ? 'f' : $this->input->get('aer_isrealtime');
			$filter['station_id'] = $this->input->get('station_id');
			$filter['aertype_id'] = $this->input->get('aertype_id');
			$filter['corps_id'] = $this->input->get('corps_id');
			$filter['kodal_id'] = $this->input->get('kodal_id'); // added by SKM17
			$filter['aer_timestamp_date'] = $this->input->get('aer_timestamp_date');
			$filter['aer_timestamp_time'] = $this->input->get('aer_timestamp_time');
			$filter['operation_id'] = $this->input->get('operation_id'); // added by KP D3
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

		$config['total_rows'] = $this->aeroplane_dao->count_table_fetch(null, $filter);
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri;
		$config['filter_param'] = $_SERVER['QUERY_STRING'];
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['offset'] = $offset;
		$this->fetch_data(16, $offset, $filter);
	}

	public function position() {
		$this->preload('/position');
		$obj = $this->filter_param();
		$filter = (!empty($obj)) ? $obj : null; // added by SKM17
		$filter['aer_is_in_operation'] = 'TRUE'; // added by SKM17
		
		if ($this->uri->segment(4) == "") {
			$offset = 0;
		} else {
			$offset = $this->uri->segment(4);
		}
		
		if (!empty($obj) && ($obj['aer_timestamp_date'] != "" || $obj['aer_timestamp_time'] != "")) {
			// lookup to history
			$this->data['aeroplane'] = $this->aer_dislocation_history_dao->table_fetch(null,16, $offset, $filter, null, true);
			$count_data_aer = $this->aer_dislocation_history_dao->count_table_fetch(null,$filter);
			$this->data['isSearchTime'] = true; // added by SKM17
		} else { 
			//lookup to current data. 
			// $filter = null; // commented by SKM17
			$this->data['aeroplane'] = $this->aeroplane_dao->table_fetch(null, 16, $offset, $filter, array('aer_name'), true,true);
			$count_data_aer = $this->aeroplane_dao->count_table_fetch(null, $filter);
		}
		$config['base_url'] = base_url() . self::$CURRENT_CONTEXT . '/position';
		$config['total_rows'] = $count_data_aer;
		$config['per_page'] = 16;
		$config['uri_segment'] = 4;
		$config['filter_param'] = $_SERVER['QUERY_STRING'];
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['offset'] = $offset;
		//aeroplane logistic
		$this->data['logistic_item'] = $this->logistic_item_dao->fetch('2');
		$this->data['aeroplane_logistics'] = null; //$this->aeroplane_logistics_dao->table_fetch($limit, $offset);
		$this->data['realtime'] = array('TRUE' => 'Ya', 'FALSE' => 'Tidak');
//		$this->data['skuadron'] = $this->station_dao->fetch_skuadron($limit, $offset);
//		$this->data['pilots'] = $this->personnel_reff_dao->fetch_pilots($limit, $offset);
		$this->data['corps'] = $this->corps_dao->fetch(1000, 0, 'corps_name', array('corps_type_id' => '2')); // edited by SKM17
		$this->data['aeroplane_type'] = $this->aeroplane_type_dao->fetch(1000, $offset, 'aertype_name'); // edited by SKM17
		$this->data['kodals'] = $this->corps_dao->fetch(1000, 0, 'corps_name'); // added by SKM17
		// Added by D3 KP 
        $this->data['operation'] = $this->operation_dao->fetch(1000, 0, 'operation_name'); 
        $this->data['aeroplane_icon'] = $this->aeroplane_icon_dao->fetch(); 
        // end Added
		$this->load_position('admin/aeroplane/aeroplane_position', $this->data);

	}

	public function view_position($aer_id = null) {
		$this->preload('/position');
		if ($aer_id == null) {
			$this->session->set_flashdata("info", "Pesawat Udara tidak ter-identifikasi");
			$this->load_view('admin/aeroplane/aeroplane_position');
		} else {
			$obj = $this->filter_param();
			$filter = (!empty($obj)) ? $obj : null;
			$filter['aer_is_in_operation'] = 'TRUE'; // added by SKM17
			
			if ($this->uri->segment(5) == "") {
				$offset = 0;
			} else {
				$offset = $this->uri->segment(5);
			}
			$config['base_url'] = base_url() . self::$CURRENT_CONTEXT . '/view_position/' . $aer_id;
			$config['total_rows'] = $this->aeroplane_dao->count_table_fetch(null, $filter);
			$config['per_page'] = 16;
			$config['uri_segment'] = 5;
			$config['filter_param'] = $_SERVER['QUERY_STRING'];
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$this->data['offset'] = $offset;
			$this->data['aeroplane'] = $this->aeroplane_dao->table_fetch(null, 16, $offset, $filter, array('aer_name'), true, true);
			$this->data['logistic_item'] = $this->logistic_item_dao->fetch('2');
			$this->data['aeroplane_logistics'] = $this->aeroplane_logistics_dao->table_fetch($aer_id);
			$this->data['operation'] = $this->operation_dao->fetch(1000, 0, 'operation_name'); // added by SKM17
			$this->data['kodals'] = $this->corps_dao->fetch(1000, 0, 'corps_name'); // added by SKM17
			$obj_id = array('aer_id' => $aer_id);

			$to_edit = $this->aeroplane_dao->by_id_($aer_id);
			$this->data['obj'] = $to_edit;
			$this->data['view'] = true;
			// Added by D3 KP
	        $this->data['aeroplane_icon'] = $this->aeroplane_icon_dao->fetch();
	        //end added
			$this->load_view('admin/aeroplane/aeroplane_position', $this->data);
		}
	}

	public function edit_position($aer_id = null) {
		$this->preload('/position');
		if ($aer_id == null) {
			$this->session->set_flashdata("info", "Pesawat Udara tidak ter-identifikasi");
			$this->load_view('admin/aeroplane/aeroplane_position');
		} else {
			$obj = $this->filter_param();
			$filter = (!empty($obj)) ? $obj : null;
			$filter['aer_is_in_operation'] = 'TRUE'; // added by SKM17
			
			if ($this->uri->segment(5) == "") {
				$offset = 0;
			} else {
				$offset = $this->uri->segment(5);
			}
			$config['base_url'] = base_url() . self::$CURRENT_CONTEXT . '/edit_position/' . $aer_id;
			$config['total_rows'] = $this->aeroplane_dao->count_table_fetch(null, $filter);
			$config['per_page'] = 16;
			$config['uri_segment'] = 5;
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$this->data['offset'] = $offset;
			$this->data['aeroplane'] = $this->aeroplane_dao->table_fetch(null, 16, $offset, $filter, array('aer_name'), true, true);
			$this->data['logistic_item'] = $this->logistic_item_dao->fetch('2');
			$this->data['aeroplane_logistics'] = $this->aeroplane_logistics_dao->table_fetch($aer_id);
			$obj_id = array('aer_id' => $aer_id);
			$this->data['operation'] = $this->operation_dao->fetch(1000, 0, 'operation_name'); // added by SKM17

			$to_edit = $this->aeroplane_dao->by_id_($aer_id);
			$this->data['realtime'] = array('TRUE' => 'Ya', 'FALSE' => 'Tidak');
			//		$this->data['skuadron'] = $this->station_dao->fetch_skuadron($limit, $offset);
			//		$this->data['pilots'] = $this->personnel_reff_dao->fetch_pilots($limit, $offset);
			$this->data['corps'] = $this->corps_dao->fetch(1000, 0, 'corps_name', array('corps_type_id' => '2')); // edited by SKM17
			$this->data['aeroplane_type'] = $this->aeroplane_type_dao->fetch(1000, $offset, 'aertype_name'); // edited by SKM17
			$this->data['kodals'] = $this->corps_dao->fetch(1000, 0, 'corps_name'); // added by SKM17
			$this->data['ports'] = $this->port_dao->fetch();    // added by SKM17
			$this->data['onboards'] = $this->ship_dao->fetch_for_onboards();    // added by SKM17
			$this->data['obj'] = $to_edit;

			//added by d3
			$this->data['aeroplane_icon'] = $this->aeroplane_icon_dao->fetch(); 
			
			$this->load_view('admin/aeroplane/aeroplane_position', $this->data);
		}
	}

	public function save_position() {
		$obj = $this->fetch_input_position();
		if (isset($obj['aer_id']) && $obj['aer_id'] != null) {
			$obj_id = array('aer_id' => $obj['aer_id']);
			//saving historical
			$save_historical = $this->save_historical_position($obj);
			$update = $this->aeroplane_dao->update($obj, $obj_id);
			$this->save_logistic($obj['aer_id']);

			if ($update) {
				if($save_historical == true){
					$this->session->set_flashdata("info", "Perubahan Posisi berhasil disimpan.");
				}else{
					$this->session->set_flashdata("info", "Perubahan Posisi berhasil disimpan. Data historikal gagal disimpan!");
				}
			} else {
				$this->session->set_flashdata("info", "Perubahan Posisi gagal disimpan!");
			}

			redirect(self::$CURRENT_CONTEXT . '/' . 'position');
		}
	}

	private function fetch_input_position() {
		$data['aer_id'] = $this->input->post('aer_id');
		$data['pilot_name'] = $this->input->post('pilot_name'); // added by SKM17
		if ($this->input->post('kodal_id')) $data['kodal_id'] = $this->input->post('kodal_id'); // added by SKM17
		$data['aer_lat'] = toGeoDec($this->getValue('aer_dlat'), $this->getValue('aer_mlat'), $this->getValue('aer_slat'), $this->getValue('aer_rlat'));
		$data['aer_lon'] = toGeoDec($this->getValue('aer_dlon'), $this->getValue('aer_mlon'), $this->getValue('aer_slon'), $this->getValue('aer_rlon'));
		$data['aer_speed'] = $this->input->post('aer_speed') == '' ? 0 : $this->input->post('aer_speed');
		$data['aer_endurance'] = $this->input->post('aer_endurance') == '' ? 0 : $this->input->post('aer_endurance');
		$data['aer_location'] = $this->input->post('aer_location');
		$data['operation_id'] = $this->input->post('operation_id'); // added by SKM17
		$data['aer_isrealtime'] = ($this->input->post('aer_isrealtime') == '') ? 'f' : $this->input->post('aer_isrealtime');
		// $data['aer_desc'] = $this->input->post('aer_desc'); // commented by SKM17
		$data['aer_timestamp_location'] = date("Y-m-d H:i:s");
		return $data;
	}

	private function fetch_data($limit, $offset, $filter = null) {

		$criteria = null;
		$restrict = get_data_restriction($this->session->userdata(SESSION_USERGROUP));

		if (!is_null($restrict) && $restrict != '') {
			$criteria = array('aer.corps_id' => $restrict);
		}
		$this->data['aeroplane'] = $this->aeroplane_dao->table_fetch($criteria, $limit, $offset, $filter, array('aer_name'), true);

		$this->data['realtime'] = array('TRUE' => 'Ya', 'FALSE' => 'Tidak');
//		$this->data['skuadron'] = $this->station_dao->fetch_skuadron($limit, $offset);
//		$this->data['pilots'] = $this->personnel_reff_dao->fetch_pilots($limit, $offset);
		$this->data['corps'] = $this->corps_dao->fetch(1000, 0, 'corps_name', array('corps_type_id' => '2')); // edited by SKM17
		$this->data['aeroplane_type'] = $this->aeroplane_type_dao->fetch(1000, 0, 'aertype_name'); // edited by SKM17
		$this->data['aeroplane_icon'] = $this->aeroplane_icon_dao->fetch(1000, 0, 'aericon_desc'); // added by SKM17
		
		$units = $this->unit_dao->fetch_data(null, 1000, 0, 'unit_name');
		$unit_pv = array();
		$unit_pv[''] = '-Pilih Kesatuan-';
		foreach ($units as $u) {
			if ($u->unitcat_id == 3) {
				$unit_pv[$u->unit_id] = $u->unit_name;
			}
		}
		$this->data['unit'] = $unit_pv;
	}

	private function getValue($inputid) {
		return $this->input->post($inputid) == '' ? 0 : $this->input->post($inputid);
	}

	private function getValue2($var) {
		return $var == '' ? 0 : (float) $var;
	}

	public function ops_update_() {
		$aer_id = $_POST['aer_id'];

		$aer_dlat = $_POST['aer_dlat'];
		$aer_mlat = $_POST['aer_mlat'];
		$aer_slat = $_POST['aer_slat'];
		$aer_rlat = $_POST['aer_rlat'];

		$aer_dlon = $_POST['aer_dlon'];
		$aer_mlon = $_POST['aer_mlon'];
		$aer_slon = $_POST['aer_slon'];
		$aer_rlon = $_POST['aer_rlon'];
		
		$aer_location = $_POST['aer_location'];
		$aer_endurance = $_POST['aer_endurance'];
		$aer_speed = $_POST['aer_speed'];
		$aer_timestamp = $_POST['aer_timestamp'];
		
		$operation_id = $_POST['operation_id'];
//		$aer_cond = $_POST['aer_cond'];

		$data['aer_lat'] = toGeoDec($this->getValue2($aer_dlat), $this->getValue2($aer_mlat), $this->getValue2($aer_slat), $this->getValue2($aer_rlat));
		$data['aer_lon'] = toGeoDec($this->getValue2($aer_dlon), $this->getValue2($aer_mlon), $this->getValue2($aer_slon), $this->getValue2($aer_rlon));
//		$data['aercond_id'] = $aer_cond;
		$data['aer_location'] = $aer_location;
		$data['aer_endurance'] = $aer_endurance;
		$data['aer_speed'] = $aer_speed;
		$data['aer_timestamp_location'] = date("Y-m-d").' '.$aer_timestamp;
		//save historikal
		$his['aer_lat'] = $data['aer_lat'];
		$his['aer_lon'] = $data['aer_lon'];
		$his['aer_speed'] = $data['aer_speed'];
		$his['aer_location'] = $data['aer_location'];
		$his['aer_endurance'] = $data['aer_endurance'];
		$his['aer_id'] = $aer_id;
		$his['aer_timestamp'] = $aer_timestamp;
		$his['operation_id'] = $operation_id;
		$this->save_historical_position($his,true);
		
		$obj_id = array('aer_id' => $aer_id);
		$save = $this->aeroplane_dao->update($data, $obj_id);

		if ($save) {
			echo 'success';
		} else {
			echo 'failed';
		}
	}

	private function fetch_input() {
		$data = array(
			'aer_name' => $this->input->post('aer_name'),
			'aer_commander' => $this->input->post('aer_commander'),
			'aertype_id' => trim($this->input->post('aertype_id')),
			'corps_id' => $this->input->post('corps_id'),
			'aercond_id' => $this->input->post('aercond_id'),
			'unit_id' => $this->input->post('unit_id'),
			'aer_is_in_operation' => ($this->input->post('aer_is_in_operation') == '') ? 'f' : $this->input->post('aer_is_in_operation'), // added by SKM17
			'aer_pjl_ops' => ($this->input->post('aer_pjl_ops') == '') ? 0 : $this->input->post('aer_pjl_ops'),
			'aer_realitation' => ($this->input->post('aer_realitation') == '') ? 0 : $this->input->post('aer_realitation'),
			'aer_data_taktis' => $this->input->post('aer_data_taktis'),
			'aer_data_utama' => $this->input->post('aer_data_utama'),
			'aer_sistem_penggerak' => $this->input->post('aer_sistem_penggerak'),
			'aer_alat_penolong' => $this->input->post('aer_alat_penolong'),
			'aer_sistem_kendali' => $this->input->post('aer_sistem_kendali'),
			'aer_logistik' => $this->input->post('aer_logistik'),
			'aer_facility_needed' => $this->input->post('aer_facility_needed'),
			'aericon_id' => $this->input->post('aericon_id') // added by SKM17
//			'aer_lat' => toGeoDec($this->getValue('aer_dlat'), $this->getValue('aer_mlat'), $this->getValue('aer_slat'), $this->getValue('aer_rlat')),
//			'aer_lon' => toGeoDec($this->getValue('aer_dlon'), $this->getValue('aer_mlon'), $this->getValue('aer_slon'), $this->getValue('aer_rlon')),
//			'aer_speed' => $this->input->post('aer_speed') == '' ? 0 : $this->input->post('aer_speed'),
//			'aer_endurance' => $this->input->post('aer_endurance') == '' ? 0 : $this->input->post('aer_endurance'),
//			'aer_isrealtime' => $this->input->post('aer_isrealtime')
		);
		if ($this->input->post('aer_id')) {
			$data['aer_id'] = $this->input->post('aer_id');
		}
		return $data;
	}

	public function save() {
		$obj = $this->fetch_input();
		$id=$this->input->post('aer_id');
		$infoSession = ''; // added by SKM17

		if ($this->validate() != false) {
			$status;
			if(isset($obj['aer_id']) && $this->aeroplane_dao->by_id(array('aer_id'=>$obj['aer_id']))!=null){

			// added by SKM17 {
			// $aer_image = '';
			// $this->data['error_main_image'] = false;
			// $this->data['msg_error_main_image'] = '';
				$config_main_image['upload_path'] = './assets/img/upload/main/pesud/';
				$config_main_image['allowed_types'] = 'gif|jpg|png|jpeg';
			// 	$config_main_image['max_width'] = 100;
    		//  $config_main_image['max_height'] = 100;
                $config_main_image['size']=2000;
				$config_main_image['encrypt_name'] = true; 
				$this->upload->initialize($config_main_image);

				$info='';
				if($_FILES['aer_image']['name']!=''){
					if ($this->upload->do_upload('aer_image')) {
						$info = $this->upload->data();
						$obj['aer_image'] = $info['file_name'];
						$infoSession .= "Gambar Pesawat Udara berhasil diunggah. ";
					} else {
						$this->data['error_main_image'] = true;
						$this->data['msg_error_main_image'] = strip_tags($this->upload->display_errors());
						$infoSession.="<font color='red'>Gambar Pesawat GAGAL diunggah. Silakan masukan gambar dibawah 2MB.</font>";
						$this->session->set_flashdata("info",$infoSession);
					}
				}
			}else{
				// $infoSession.="<font color='red'>Gambar tidak diubah.</font>";
			}
			
			// if ($this->data['error_main_image'] != true) {
			// 	$obj['aer_image'] = $aer_image;
			// }
			// } END ADDED
			
			$saved; // added by SKM17
			if($id !=null){
			// if (isset($obj['aer_id']) && $this->aeroplane_dao->by_id(array('aer_id' => $obj['aer_id'])) != null) {
				$obj_id = array('aer_id' => $obj['aer_id']);
				$saved = $this->aeroplane_dao->update($obj, $obj_id);
				$saving_aer_id = $obj['aer_id'];
				$infoSession .= "Data Pesawat Udara berhasil diubah. ";
			} else {
				$saved = $this->aeroplane_dao->insert($obj);
				// $saving_aer_id = $this->aeroplane_dao->insert_id();
				$infoSession .= "Data Pesawat Udara berhasil ditambah. ";
			}

			$this->session->set_flashdata("info", $infoSession);
			$this->data['saving']=true;
			redirect(self::$CURRENT_CONTEXT);
		} else {
			/* invalid input will be redirected to edit view with error message included */
			$this->preload();
			$this->data['edit'] = false;
			#prepare link for back to view list
			$this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
			$this->load_view('admin/aeroplane/list_aeroplane', $this->data);
		}
	}
	
	public function save_historical_position($obj,$ops_update = false){
		$data['aerdis_date'] = date("Y-m-d");
		$data['aerdis_time'] = ($ops_update == true)?$obj['aer_timestamp']:$this->input->post('aer_timestamp_location');
		$data['aer_id'] = $obj['aer_id'];
		$data['aerdis_lat'] = $obj['aer_lat'];
		$data['aerdis_lon'] = $obj['aer_lon'];
		$data['aerdis_speed'] = $obj['aer_speed'];
		$data['operation_id'] = ($ops_update==true)?$obj['operation_id']:$this->input->post('operation_id');
		$data['aerdis_location'] = $obj['aer_location'];
		$data['aerdis_endurance'] = $obj['aer_endurance'];
		
		//to prevent duplicate data, delete first
		$this->aer_dislocation_history_dao->delete(array('aer_id'=>$data['aer_id'],'aerdis_date'=>$data['aerdis_date'],'aerdis_time'=>$data['aerdis_time']));
		$insert = $this->aer_dislocation_history_dao->insert($data);
		return $insert;
	}
	private function fetch_input_logistic() {
		$data = array('logitem_id' => $this->input->post('logitem_id'),
			'aer_id' => $this->input->post('aer_id'),
			'aerlog_value' => $this->input->post('aerlog_value'));
		return $data;
	}

	public function save_logistic($aer_id) {
		$status_insert = true;

		$aerolog = array();
		$aerovalue = array();

		$totalRow = $this->input->post('totalRow');
		//delete logistik in aeroplane first
		$this->aeroplane_logistics_dao->delete(array('aer_id' => $aer_id));
		//insert new logistik
		for ($i = 1; $i <= $totalRow; $i++) {
			$aerolog = $this->input->post('aeroLog_' . $i);
			$aerovalue = $this->input->post('aeroValue_' . $i);

			$new_logistics = array('logitem_id' => $aerolog, 'aer_id' => $aer_id, 'aerlog_value' => $aerovalue);
			$this->aeroplane_logistics_dao->insert($new_logistics);
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

	public function edit_logistic($logitem_id = null, $aer_id = null) {
		if ($logitem_id == null || $aer_id == null
		) {
			$this->load_view('admin/aeroplane/list_aeroplane');
		} else {
			$this->get_list($this->limit);
//			$this->get_list_logistic($this->limit);
			$this->data['aeroplane_logistics'] = $this->aeroplane_logistics_dao->table_fetch($aer_id, $this->limit);
			//get aeroplane
			$obj_id = array('aer_id' => $aer_id);

			$aeroplane = $this->aeroplane_dao->by_id($obj_id);
			$this->data['obj'] = $aeroplane;

			//get aeroplane logistik
			$obj_id = array('logitem_id' => $logitem_id, 'aer_id' => $aer_id);

			$to_edit = $this->aeroplane_logistics_dao->by_id($obj_id);
			$this->data['obj_logistic'] = $to_edit;
			$this->load_view('admin/aeroplane/list_aeroplane', $this->data);
		}
	}

	/**

	  @description
	  viewing record. repopulation for every data needed for view.
	 */
	public function view($aer_id = null) {
		$this->preload();
		if ($aer_id == null) {
			$this->load_view('admin/aeroplane/list_aeroplane');
		} else {
			$this->get_list($this->limit);
//			$this->get_list_logistic($this->limit);
//			$this->data['aeroplane_logistics'] = $this->aeroplane_logistics_dao->table_fetch($aer_id, $this->limit);
			$obj_id = array('aer_id' => $aer_id);

			$to_edit = $this->aeroplane_dao->by_id($obj_id);
			$this->data['obj'] = $to_edit;
			$this->data['view'] = true;
			$this->load_view('admin/aeroplane/list_aeroplane', $this->data);
		}
	}

	/**

	  @description
	  viewing editing form. repopulation for every data needed in form done here.

	 */
	public function edit($aer_id = null) {
		$this->preload();
		if ($aer_id == null) {
			$this->load_view('admin/aeroplane/list_aeroplane');
		} else {
			$this->get_list($this->limit, $this->uri->segment(5));
//			$this->get_list_logistic($this->limit);
//			$this->data['aeroplane_logistics'] = $this->aeroplane_logistics_dao->table_fetch($aer_id, $this->limit);
			$obj_id = array('aer_id' => $aer_id);

			$to_edit = $this->aeroplane_dao->by_id($obj_id);
			$this->data['obj'] = $to_edit;
			$this->load_view('admin/aeroplane/list_aeroplane', $this->data);
		}
	}

	public function delete($aer_id = null) {
		$obj_id = array('aer_id' => $aer_id);
		$log_id = array('aer_id' => $aer_id);
		//unlink gambar by D3
		$image = $this->aeroplane_dao->by_id($obj_id);
        unlink($this->config->item('root_path')."assets/img/upload/main/pesud/".$image->aer_image);

		$this->aeroplane_logistics_dao->delete($log_id);
		$status_del = $this->aeroplane_dao->delete($obj_id);
		if ($status_del == false) {
			$this->session->set_flashdata("info", "Hapus Data Pesawat Udara gagal!");
		} else {
			$this->session->set_flashdata("info", "Hapus Data Pesawat Udara berhasil!");
		}
		redirect(self::$CURRENT_CONTEXT);
	}

	public function delete_logistic($logitem_id = null, $aer_id = null) {
		$obj_id = array('logitem_id' => $logitem_id,
			'aer_id' => $aer_id);

		$this->aeroplane_logistics_dao->delete($obj_id);
		redirect(self::$CURRENT_CONTEXT . '#addAeroLogistic');
	}

	public function get_list_logistic($limit = 16, $offset = 0) {
		$obj = array(); //$this->filter_param();
		#generate pagination
		// $config['base_url'] = site_url(self::$CURRENT_CONTEXT . 'index');
		// $config['total_rows'] = $this->aeroplane_logistics_dao->count_all();
		// $config['per_page'] = $limit;
		// $config['uri_segment'] = 3;
		// $this->pagination->initialize($config);
		// $this->data['pagination'] = $this->pagination->create_links();
		// if (empty($obj)) {
		// non conditional data fetching
		// $this->fetch_data($limit, $offset);
		// } else {
		// apply filter
		// }
	}

	/*	 * role and permission* */

	function role_user() {
		$user_id = $this->tank_auth->get_user_id();
		$user = $this->user_role_dao->fetch_record($user_id);

		if (trim($user->role_name) == 'viewer') {
			redirect('html/map_clean');
		}
	}

	public function fetch_record($keys) {
		$this->data['aeroplane'] = $this->aeroplane_dao->by_id($keys);
	}

	function logged_in() {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('home/login');
		}
	}

}
