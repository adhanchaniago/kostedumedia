<?php

class marines_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 16;
    public static $CURRENT_CONTEXT = '/admin/marines_ctrl';
    public static $TITLE = "Marinir";

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('geodesics');
        $this->load->library('session');
        $this->load->helper('acl');
        $this->load->helper('sanitizer');
        $this->load->library('session');
        $this->load->library('dao/marines_dao');
        $this->load->library('dao/station_dao');
        $this->load->library('dao/marines_type_dao');
        $this->load->library('dao/corps_dao');
        $this->load->library('dao/unit_dao');
        $this->load->library('dao/logistic_item_dao');
        $this->load->library('dao/marine_logistics_dao');
        $this->load->library('dao/user_role_dao');
        $this->load->library('dao/marines_kolak_dao');
        $this->load->library('dao/mar_dislocation_history_dao');
        $this->load->library('dao/marines_dislocation_dao'); // added by SKM17
        $this->load->library('dao/marine_icon_dao'); // added by SKM17
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
        $this->form_validation->set_rules('mar_id', 'mar_id', '');
        $this->form_validation->set_rules('corps_id', 'corps_id', 'required');
        $this->form_validation->set_rules('mar_name', 'mar_name', '');
        $this->form_validation->set_rules('mar_description', 'mar_description', '');
        $this->form_validation->set_rules('mar_lat', 'mar_lat', '');
        $this->form_validation->set_rules('mar_lon', 'mar_lon', '');
        $this->form_validation->set_rules('mar_personel_count', 'mar_personel_count', '');

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
        $this->get_list_logistic($this->limit, $offset);
        $this->load_view('admin/marines/list_marines', $this->data);
    }

    public function position() {
        $this->preload('/position');
        $obj = $this->position_filter_param();
        $filter = (!empty($obj)) ? $obj : null;
        
        if ($this->uri->segment(4) == "") {
            $offset = 0;
        } else {
            $offset = $this->uri->segment(4);
        }
        
        $this->data['marines_dislocation'] = $this->marines_dislocation_dao->table_fetch($this->limit, $offset, $filter);
        $count_data_mar = $this->marines_dislocation_dao->count_table_fetch($filter); 
        
        $config['base_url'] = base_url() . self::$CURRENT_CONTEXT . '/position';
        $config['total_rows'] = $count_data_mar;
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = 4;
        $config['filter_param'] = $_SERVER['QUERY_STRING'];
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['offset'] = $offset;
        $this->data['marine_icon'] = $this->marine_icon_dao->fetch(1000, 0, 'maricon_desc'); // added by SKM17
        $this->load_position('admin/marines/marines_position', $this->data);
    }

    /**
      getting position filter parameter when user
      doing searching.
     */
    public function position_filter_param() {
        $filter = array();
        if (isset($_GET['filter'])) {
            $filter['operation_name'] = $this->input->get('operation_name');
            $filter['mardis_location'] = $this->input->get('mardis_location');
            $filter['mardis_dpp'] = $this->input->get('mardis_dpp');
        }
        // other input receive
        return $filter;
    }

    public function fetch_record($keys) {
        $this->data['marines'] = $this->marines_dao->by_id($keys);
    }

    private function getValue($inputid) {
        return $this->input->post($inputid) == '' ? 0 : $this->input->post($inputid);
    }

    private function getValue2($var) {
        return $var == '' ? 0 : (float) $var;
    }

    private function fetch_input_logistic() {
        $data = array('logitem_id' => $this->input->post('logitem_id'),
            'mar_id' => $this->input->post('mar_id'),
            'marinelog_value' => $this->input->post('marinelog_value'));

        return $data;
    }

    public function ops_update_() {
        $mar_id = $_POST['mar_id'];

        $mar_dlat = $_POST['mar_dlat'];
        $mar_mlat = $_POST['mar_mlat'];
        $mar_slat = $_POST['mar_slat'];
        $mar_rlat = $_POST['mar_rlat'];

        $mar_dlon = $_POST['mar_dlon'];
        $mar_mlon = $_POST['mar_mlon'];
        $mar_slon = $_POST['mar_slon'];
        $mar_rlon = $_POST['mar_rlon'];
        
        $mar_location = $_POST['mar_location'];
        $mar_personel = $_POST['mar_personel'];
        $mar_matpur = $_POST['mar_matpur'];
        $mar_dpp = $_POST['mar_dpp'];
        $mar_timestamp = $_POST['mar_timestamp'];
        
        $operation_id = $_POST['operation_id'];
//        $mar_cond = $_POST['mar_cond'];

        $data['mar_lat'] = toGeoDec($this->getValue2($mar_dlat), $this->getValue2($mar_mlat), $this->getValue2($mar_slat), $this->getValue2($mar_rlat));
        $data['mar_lon'] = toGeoDec($this->getValue2($mar_dlon), $this->getValue2($mar_mlon), $this->getValue2($mar_slon), $this->getValue2($mar_rlon));
        $data['mar_location'] = $mar_location;
        $data['mar_personel_desc'] = $mar_personel;
        $data['mar_matpur_desc'] = $mar_matpur;
        $data['mar_dpp'] = $mar_dpp;
        
        $data['mar_timestamp_location'] = date("Y-m-d").' '.$mar_timestamp;
        
        //save historikal
        $his['mar_lat'] = $data['mar_lat'];
        $his['mar_lon'] = $data['mar_lon'];
        $his['mar_location'] = $data['mar_location'];
        $his['mar_personel_desc'] = $data['mar_personel_desc'];
        $his['mar_matpur_desc'] = $data['mar_matpur_desc'];
        $his['operation_id'] = $operation_id;
        $his['mar_id'] = $mar_id;
        $his['mar_timestamp'] = $mar_timestamp;
        $his['mar_dpp'] = $mar_dpp;
        $this->save_historical_position($his,true);
//        $data['aercond_id'] = $mar_cond;

        $obj_id = array('mar_id' => $mar_id);
        $save = $this->marines_dao->update($data, $obj_id);

        if ($save) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }

    public function view_position($mardis_id = null) {
        $this->preload('/position');
        if ($mardis_id == null) {
            $this->session->set_flashdata("info", "Marinir tidak ter-identifikasi");
            $this->load_view('admin/marines/marines_position');
        } else {
            $obj = $this->position_filter_param();
            $filter = (!empty($obj)) ? $obj : null;
            if ($this->uri->segment(5) == "") {
                $offset = 0;
            } else {
                $offset = $this->uri->segment(5);
            }
            $config['base_url'] = base_url() . self::$CURRENT_CONTEXT . '/view_position/' . $mardis_id;
            $config['total_rows'] = $this->marines_dislocation_dao->count_table_fetch($filter); 
            $config['per_page'] = $this->limit;
            $config['uri_segment'] = 5;
            $config['filter_param'] = $_SERVER['QUERY_STRING'];
            $this->pagination->initialize($config);
            $this->data['pagination'] = $this->pagination->create_links();
            $this->data['offset'] = $offset;
            // $this->data['marines'] = $this->marines_dao->table_fetch(1000, $offset, $filter, null, null, true, true);
            $this->data['marines_dislocation'] = $this->marines_dislocation_dao->table_fetch($this->limit, $offset, $filter);
            $obj_id = array('mardis_id' => $mardis_id);

	        $this->data['marine_icon'] = $this->marine_icon_dao->fetch(1000, 0, 'maricon_desc'); // added by SKM17
            //$this->data['logistic_item'] = $this->logistic_item_dao->fetch('3');
            //$this->data['marine_logistics'] = $this->marine_logistics_dao->table_fetch($mardis_id);

            $to_edit = $this->marines_dislocation_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
//            print_r($this->data['obj']);exit();
            $this->data['view'] = true;

            // Added by D3 KP 
        $this->data['icon'] = $this->marine_icon_dao->fetch();
        
            $this->load_view('admin/marines/marines_position', $this->data);
        }
    }

    public function edit_position($mardis_id = null) {
        $this->preload('/position');
        $obj = $this->filter_param();
        $filter = (!empty($obj)) ? $obj : null;
        if ($mardis_id == null) {
            $this->session->set_flashdata("info", "Marinir tidak ter-identifikasi");
            $this->load_view('admin/marines/marines_position');
        } else {
            $obj = $this->position_filter_param();
            $filter = (!empty($obj)) ? $obj : null;
            if ($this->uri->segment(5) == "") {
                $offset = 0;
            } else {
                $offset = $this->uri->segment(5);
            }
            $config['base_url'] = base_url() . self::$CURRENT_CONTEXT . '/edit_position/' . $mardis_id;
            $config['total_rows'] = $this->marines_dislocation_dao->count_table_fetch($filter);
            $config['per_page'] = $this->limit;
            $config['uri_segment'] = 5;
            $config['filter_param'] = $_SERVER['QUERY_STRING'];
            $this->pagination->initialize($config);
            $this->data['pagination'] = $this->pagination->create_links();
            $this->data['offset'] = $offset;
	        $this->data['marine_icon'] = $this->marine_icon_dao->fetch(1000, 0, 'maricon_desc'); // added by SKM17
            // $this->data['marines'] = $this->marines_dao->table_fetch(1000, $offset, null, null, null, true, true);
            $this->data['marines_dislocation'] = $this->marines_dislocation_dao->table_fetch($this->limit, $offset, $filter);
            $obj_id = array('mardis_id' => $mardis_id);

            //$this->data['logistic_item'] = $this->logistic_item_dao->fetch('3');
            //$this->data['marine_logistics'] = $this->marine_logistics_dao->table_fetch($mardis_id);

            $to_edit = $this->marines_dislocation_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            
            //added by d3
             $this->data['icon'] = $this->marine_icon_dao->fetch();

            $this->load_view('admin/marines/marines_position', $this->data);
        }
    }

    private function fetch_input_position() {
        $data['operation_name'] = $this->input->post('operation_name');
        $data['mardis_lat'] = toGeoDec($this->getValue('mardis_dlat'), $this->getValue('mardis_mlat'), $this->getValue('mardis_slat'), $this->getValue('mardis_rlat'));
        $data['mardis_lon'] = toGeoDec($this->getValue('mardis_dlon'), $this->getValue('mardis_mlon'), $this->getValue('mardis_slon'), $this->getValue('mardis_rlon'));
        $data['mardis_location'] = $this->input->post('mardis_location');
        $data['mardis_dpp'] = $this->input->post('mardis_dpp');
        // $data['mardis_date'] = $this->input->post('mardis_date');
        $data['mardis_date'] = date("Y-m-d");
        $data['mardis_time'] = date("H:i:s");
        $data['mardis_personnel'] = $this->input->post('mardis_personnel');
        $data['mardis_matpur'] = $this->input->post('mardis_matpur');
        $data['maricon_id'] = $this->input->post('maricon_id'); // added by SKM17
        $data['mardis_in_ops'] = ($this->input->post('mardis_in_ops') == '') ? 'f' : $this->input->post('mardis_in_ops'); // added by SKM17
        
        if ($this->input->post('mardis_id')) {
            $data['mardis_id'] = $this->input->post('mardis_id');
        }
        
        return $data;
    }

		public function save_position() {
			$obj = $this->fetch_input_position();
			$infoSession = ''; // added by SKM17

			// added by SKM17 {
			$this->data['error_main_image'] = false;
			$this->data['msg_error_main_image'] = '';
			$config_main_image['upload_path'] = './assets/img/upload/main/marinir/';
			$config_main_image['allowed_types'] = 'png|gif|jpg|jpeg';
			$config_main_image['encrypt_name'] = true; 
            $config_main_image['size']=2000;            


			$this->upload->initialize($config_main_image);

            $info = '';        
            if ($_FILES['mardis_image']['name']!=''){
    			if ($this->upload->do_upload('mardis_image')) {
    				$info = $this->upload->data();
    				$infoSession .= "Gambar Satgas berhasil diunggah. ";
    				$obj['mardis_image'] = $info['file_name'];
    			} else {
    				$this->data['error_main_image'] = true;
    				$this->data['msg_error_main_image'] = strip_tags($this->upload->display_errors());
                    $infoSession .= "<font color='red'>Gambar Satuan Marinir GAGAL diunggah. Silakan masukan gambar dibawah 1MB. </font>";

    			}
            }else {
                $infoSession .= "<font color='red'>Gambar tidak diubah.</font> ";
            }
			// } END ADDED
            

			$saved; // added by SKM17
			if (isset($obj['mardis_id']) && $obj['mardis_id'] != null) {
			/*
				$obj_id = array('mardis_id' => $obj['mardis_id']);
				$updated = $this->update_marines_dislocation($obj, $obj_id);

				if ($updated) {
					$infoSession .= "Data Satgas Marinir berhasil diubah. ";
				} else {
					$infoSession .= "Data Satgas Marinir gagal diubah. ";
				}*/
				
				$obj_id = array('mardis_id' => $obj['mardis_id']);
				$saved = $this->marines_dislocation_dao->update($obj, $obj_id);
				$infoSession .= "Data Satgas berhasil diubah. ";
			} 
			else { // simpan dislokasi marinir baru
			/*
				$inserted = $mardis_id = $this->save_marines_dislocation($obj);

				if ($inserted) {
					$infoSession .= "Data Satgas Marinir berhasil ditambah. ";
				} else {
					$infoSession .= "Data Satgas Marinir gagal ditambah. ";
				}
			*/
				$saved = $this->marines_dislocation_dao->insert($obj);
				$infoSession .= "Data Satgas berhasil ditambah. ";
			}
			
			if (!$saved) {
				$infoSession .= "Data Satgas gagal ditambah/disimpan. ";
            }
	        
			$this->session->set_flashdata("info", $infoSession);	
			redirect(self::$CURRENT_CONTEXT . '/' . 'position');
		}

    public function delete_position($mardis_id = null) {
        $obj_id = array('mardis_id' => $mardis_id);
        //menghapus gambar di folder by D3 Polban
        $name_file = $this->marines_dislocation_dao->by_id($obj_id);
        unlink($this->config->item('root_path')."assets/img/upload/main/marinir/".$name_file->mardis_image);
        //
        $status_del = $this->marines_dislocation_dao->delete($obj_id);

        if ($status_del == false) {
            $this->session->set_flashdata("info", "Data Satgas gagal dihapus!");
        } else {
            $this->session->set_flashdata("info", "Data Satgas berhasil dihapus!");
        }
        redirect(self::$CURRENT_CONTEXT . '/' . 'position');
    }

    public function save_historical_position($obj,$ops_update = false) {
        $data['mar_id'] = $obj['mar_id'];
        $data['mardis_lat'] = $obj['mar_lat'];
        $data['mardis_lon'] = $obj['mar_lon'];
        $data['mardis_location'] = $obj['mar_location'];
        $data['mardis_dpp'] = $obj['mar_dpp'];
        $data['mardis_personel_desc'] = $obj['mar_personel_desc'];
        $data['mardis_matpur_desc'] = $obj['mar_matpur_desc'];
        $data['mardis_date'] = date("Y-m-d");
        $data['mardis_time'] = ($ops_update == true)?$obj['mar_timestamp']:$this->input->post('mar_timestamp_location');
        $data['operation_id'] = ($ops_update==true)?$obj['operation_id']:$this->input->post('operation_id');

        //to prevent duplicate data, delete first
        $this->mar_dislocation_history_dao->delete(array('mar_id'=>$data['mar_id'],'mardis_date'=>$data['mardis_date'],'mardis_time'=>$data['mardis_time']));
        $insert = $this->mar_dislocation_history_dao->insert($data);
        return $insert;
    }

    public function save_logistic($mar_id) {
        $status_insert = true;

        $marlog = array();
        $marvalue = array();

        $totalRow = $this->input->post('totalRow');
        //delete logistik in aeroplane first
        $this->marine_logistics_dao->delete(array('mar_id' => $mar_id));
        //insert new logistik
        for ($i = 1; $i <= $totalRow; $i++) {
            $marlog = $this->input->post('marLog_' . $i);
            $marvalue = $this->input->post('marValue_' . $i);

            $new_logistics = array('logitem_id' => $marlog, 'mar_id' => $mar_id, 'marinelog_value' => $marvalue);
            $this->marine_logistics_dao->insert($new_logistics);
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
    public function view($mar_id = null) {
        $this->preload();
        $this->get_list_logistic($this->limit);
        if ($mar_id == null) {
            $this->load_view('admin/marines/list_marines');
        } else {
            $this->get_list($this->limit);

            $obj_id = array('mar_id' => $mar_id);

            $to_edit = $this->marines_dao->by_id($obj_id);
            $this->data['marines_kolak_exist'] = $this->marines_kolak_dao->fetch(1000, 0, null, array('corps_id' => $to_edit->corps_id));
            $this->data['obj'] = $to_edit;
            $this->data['view'] = true;
            $this->load_view('admin/marines/list_marines', $this->data);
        }
    }

    /**

      @description
      viewing editing form. repopulation for every data needed in form done here.
     */
    public function edit($mar_id = null) {
        $this->preload();
        $this->get_list_logistic($this->limit);
        if ($mar_id == null) {
            $this->load_view('admin/marines/list_marines');
        } else {
            $this->get_list($this->limit, $this->uri->segment(5));

            $obj_id = array('mar_id' => $mar_id);

            $to_edit = $this->marines_dao->by_id($obj_id);
            $this->data['marines_kolak_exist'] = $this->marines_kolak_dao->fetch(1000, 0, null, array('corps_id' => $to_edit->corps_id));
            $this->data['obj'] = $to_edit;
            $this->load_view('admin/marines/list_marines', $this->data);
        }
    }

    private function fetch_input() {
        $data = array(
            'corps_id' => $this->input->post('corps_id'),
            'unit_id' => $this->input->post('unit_id'),
            'mar_personel_desc' => $this->input->post('mar_personel_desc'),
            'mar_matpur_desc' => $this->input->post('mar_matpur_desc'),
            'maricon_id' => $this->input->post('maricon_id'), // added by SKM17
        	//'martype_id' => $this->input->post('martype_id'),
            //'station_id' => $this->input->post('station_id'),
            //'mar_name' => $this->input->post('mar_name'),
            // 'mar_description' => $this->input->post('mar_description'),
            'mar_lat' => toGeoDec($this->getValue('mar_dlat'), $this->getValue('mar_mlat'), $this->getValue('mar_slat'), $this->getValue('mar_rlat')),
            'mar_lon' => toGeoDec($this->getValue('mar_dlon'), $this->getValue('mar_mlon'), $this->getValue('mar_slon'), $this->getValue('mar_rlon')),
            //'mar_personel_count' => $this->input->post('mar_personel_count') == '' ? 0 : $this->input->post('mar_personel_count'),
            //'kolak_id' => $this->input->post('kolak_id'),
            //'marcond_id' => $this->input->post('marcond_id'),
            //'mar_personel_ready' => $this->input->post('mar_personel_ready') == '' ? 0 : $this->input->post('mar_personel_ready'),
            //'mar_personel_notready' => $this->input->post('mar_personel_notready') == '' ? 0 : $this->input->post('mar_personel_notready'),
            'mar_in_ops' => $this->input->post('mar_in_ops') == '' ? 'f' : $this->input->post('mar_in_ops'), // added by SKM17
        );

        if ($this->input->post('mar_id')) {
            $data['mar_id'] = $this->input->post('mar_id');
        }
        return $data;
    }

    public function save() {
        $obj = $this->fetch_input();
        $id = $this->input->post('mar_id');
        $infoSession = ''; // added by SKM17
//        $obj_logistic = $this->fetch_input_logistic();
        // echo "mau ngesave nyet";
        if ($this->validate() != false) {
           // echo "asuuuuuu";
           // die();
           // $obj_id = array('mar_id' => $obj['mar_id']);

			// added by SKM17 {
			// $this->data['error_main_image'] = false;
			// $this->data['msg_error_main_image'] = '';

			$config_main_image['upload_path'] = './assets/img/upload/main/marinir/';
			$config_main_image['allowed_types'] = 'png|gif|jpg|jpeg';
            // $config_main_image['max_width'] = 100;
            // $config_main_image['max_height'] = 100;
            $config_main_image['size']=2000;            
			$config_main_image['encrypt_name'] = TRUE; 

			$this->upload->initialize($config_main_image);

            $info = '';        
            if ($_FILES['mar_image']['name']!=''){
                if ($this->upload->do_upload('mar_image')) {
                    // echo "if truenyet";
                    // die();
                    $info = $this->upload->data();
                    $obj['mar_image'] = $info['file_name'];
                    $infoSession .= "Gambar Satuan Marinir berhasil diunggah. ";
                    // die();
                    
                } else {
                    // echo "if falsese";
                    // die();
                    $this->data['error_main_image'] = TRUE;
                    $this->data['msg_error_main_image'] = strip_tags($this->upload->display_errors());
                    $infoSession .= "<font color='red'>Gambar Satuan Marinir GAGAL diunggah. Silakan masukan gambar dibawah 2MB. </font>";
                    // $infoSession .= "Gambar tidak diubah. ";
                }                
            } else {
                $infoSession .= "<font color='red'>Gambar tidak diubah.</font> ";
            }


			// } END ADDED

			$saved; // added by SKM17
            if (isset($obj['mar_id']) && $this->marines_dao->by_id(array('mar_id' => $obj['mar_id'])) != null) {
                $obj_id = array('mar_id' => $obj['mar_id']);
                $saved = $this->marines_dao->update($obj, $obj_id);
                $saving_mar_id = $obj['mar_id'];
                $infoSession .= "Data Satuan Marinir berhasil diubah. ";
            } else {
                $saved = $this->marines_dao->insert($obj);
                $saving_mar_id = $this->marines_dao->insert_id();
//                if($obj_logistic['logitem_id']!=''){
//                    $this->marine_logistics_dao->insert($obj_logistic);
//                }
                $infoSession .= "Data Satuan Marinir berhasil ditambah. ";
            }
//            $this->save_logistic($saving_mar_id);
            if ($saved == FALSE) 
                $infoSession .= "Data Satuan Marinir gagal disimpan. ";
            
            $this->session->set_flashdata("info", $infoSession);
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        } else {
            /* invalid input will be redirected to edit view with error message included */
            // echo "jancuuuuk";
            // die();
            $this->preload();
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/marines/marines_edit', $this->data);
        }
    }

    public function delete($mar_id = null) {
        $obj_id = array('mar_id' => $mar_id);
        $name_file = $this->marines_dao->by_id($obj_id);
        unlink($this->config->item('root_path')."assets/img/upload/main/marinir/".$name_file->mar_image);
        $this->marine_logistics_dao->delete($obj_id);
        $status_del = $this->marines_dao->delete($obj_id);

        if ($status_del == false) {
            $this->session->set_flashdata("info", "Data Satuan Marinir gagal dihapus!");
        } else {
            $this->session->set_flashdata("info", "Data Satuan Marinir berhasil dihapus!");
        }
        redirect(self::$CURRENT_CONTEXT);
    }

    public function edit_logistic($logitem_id = null, $mar_id = null) {
        if ($logitem_id == null || $mar_id == null) {
            $this->load_view('admin/marines/list_marines');
        } else {
            $this->get_list($this->limit);
            $this->get_list_logistic($this->limit);
            $this->data['marine_logistics'] = $this->marine_logistics_dao->table_fetch($mar_id, $this->limit);
            //get marine
            $obj_id = array('mar_id' => $mar_id);

            $marine = $this->marines_dao->by_id($obj_id);
            $this->data['obj'] = $marine;

            //get marine logistik
            $obj_id = array('logitem_id' => $logitem_id, 'mar_id' => $mar_id);

            $to_edit = $this->marine_logistics_dao->by_id($obj_id);
            $this->data['obj_logistic'] = $to_edit;
            $this->load_view('admin/marines/list_marines', $this->data);
        }
    }

    public function delete_logistic($logitem_id = null, $mar_id = null) {
        $obj_id = array('logitem_id' => $logitem_id, 'mar_id' => $mar_id);

        $this->marine_logistics_dao->delete($obj_id);
        redirect(self::$CURRENT_CONTEXT);
    }

    /**
      getting filter parameter when user
      doing searching.
     */
    public function filter_param() {
        $filter = array();
        if (isset($_GET['filter'])) {
            //$filter['mar_name'] = $this->input->get('mar_name');
            //$filter['mar_isrealtime'] = $this->input->get('mar_isrealtime');
            //$filter['martype_id'] = $this->input->get('martype_id');
            $filter['corps_id'] = $this->input->get('corps_id');
            $filter['unit_id'] = $this->input->get('unit_id');
            //$filter['mar_timestamp_date'] = $this->input->get('mar_timestamp_date');
            //$filter['mar_timestamp_time'] = $this->input->get('mar_timestamp_time');
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

        $config['total_rows'] = $this->marines_dao->count_table_fetch($filter);
        $config['per_page'] = $limit;
        $config['uri_segment'] = $uri;
        $config['filter_param'] = $_SERVER['QUERY_STRING'];
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['offset'] = $offset;
        $this->fetch_data($limit, $offset, $filter);
        $this->data['marines_unit']  = $this->unit_dao->fetch_data(array('unitcat_id'=>'2'), 1000, 0, 'unit_name'); 
        $this->data['marine_icon'] = $this->marine_icon_dao->fetch(1000, 0, 'maricon_desc'); // added by SKM17
    }

    private function fetch_data($limit, $offset, $filter = null) {

        $restrict = get_data_restriction($this->session->userdata('user_group'));
        $criteria = null;
        if (!is_null($restrict) && $restrict != '') {
            $criteria = array('c.corps_id' => $restrict);
        }
        $criteria['unit.unitcat_id'] = '2';
        /* station reference */
        $stats = $this->station_dao->table_fetch();
        $stats_pv = array();
        $stats_pv[''] = '- Pilih Pangkalan Induk -';
        foreach ($stats as $st) {
            $stats_pv[$st->station_id] = $st->station_name;
        }
        /* end of reference */

        $this->data['stations'] = $stats_pv;

        $this->data['marines'] = $this->marines_dao->table_fetch($limit, $offset, $filter, $criteria);
        $this->data['corps'] = $this->corps_dao->fetch(1000, 0, 'corps_name', array('corps_type_id' => '3'),true);
        $this->data['marines_type'] = $this->marines_type_dao->key_value();
        $this->data['realtime'] = array('TRUE' => 'Ya', 'FALSE' => 'Tidak');
        $this->data['marines_kolak'] = $this->marines_kolak_dao->fetch();
    }

    public function get_list_logistic($limit = 16, $offset = 0) {
        // $obj = $this->filter_param();
        // #generate pagination
        // $config['base_url'] = site_url(self::$CURRENT_CONTEXT . 'index');
        // $config['total_rows'] = $this->marine_logistics_dao->count_all();
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

    function get_kolak() {
        if (isset($_POST['parent_id'])) {
            $response = $this->marines_kolak_dao->fetch(1000, 0, null, array('corps_id' => $_POST['parent_id']));
            die(json_encode($response)); // convert variable respon menjadi JSON, lalu tampilkan
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
