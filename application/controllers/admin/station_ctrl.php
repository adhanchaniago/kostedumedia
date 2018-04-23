<?php

class station_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 16;
    public static $CURRENT_CONTEXT = '/admin/station_ctrl';
    public static $TITLE = "Pangkalan";

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('geodesics');
        $this->load->library('session');
        $this->load->helper('acl');
        $this->load->library('dao/logistic_item_dao');
        $this->load->library('dao/station_dao');
        $this->load->library('dao/station_class_dao');
        $this->load->library('dao/station_type_dao');
        $this->load->library('dao/station_logistics_dao');
        $this->load->library('dao/corps_dao');
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
        $this->form_validation->set_rules('station_id', 'station_id', '');
        $this->form_validation->set_rules('corps_id', 'corps_id', '');
        $this->form_validation->set_rules('station_name', 'station_name', 'required');
//        $this->form_validation->set_rules('station_lat', 'station_lat', 'required');
//        $this->form_validation->set_rules('station_lon', 'station_lon', 'required');

        return $this->form_validation->run();
    }

    /**
      prepare data for view
     */
    public function preload() {
        $this->data['current_context'] = self::$CURRENT_CONTEXT;
        $this->data['station_class'] = $this->station_class_dao->key_value();
        $this->data['title'] = self::$TITLE;
    }

    public function load_view($page, $data = null) {
        $this->load->view('template/template_header', $data);
        $this->load->view('template/template_menu', $this->data);
        $this->load->view($page);
        $this->load->view('template/template_footer');
    }

    public function index($offset = 0) {
        $this->preload();
        $this->get_list($this->limit, $offset);
//        $this->get_list_logistic($this->limit, $offset);
        $this->load_view('admin/station/list_station', $this->data);
    }

    /**
      getting filter parameter when user
      doing searching.

     */
    public function filter_param() {
        $filter = array();
        if (isset($_GET['filter'])) {
            $filter['station_name'] = $this->input->get('station_name');
            $filter['station_id'] = $this->input->get('station_id');
            $filter['stype_id'] = $this->input->get('stype_id');
            $filter['sclass_id'] = $this->input->get('sclass_id');
            $filter['corps_id'] = $this->input->get('corps_id');
        }
        // other input receive
        return $filter;
    }

    public function get_list($limit = 16, $offset = 0) {
        $obj = $this->filter_param();
        $filter = (!empty($obj)) ? $obj : null;
        #generate pagination
        if($this->uri->segment(3)=='edit'){
			$base_url = self::$CURRENT_CONTEXT . '/edit/'.$this->uri->segment(4);
			$uri = 5;
		}else{
			$base_url = self::$CURRENT_CONTEXT . '/index/';
			$uri = 4;
		}
        $config['base_url'] = site_url($base_url);
		
        $config['total_rows'] = $this->station_dao->count_table_fetch($filter);
        $config['per_page'] = $limit;
        $config['uri_segment'] = $uri;
        $config['filter_param'] = $_SERVER['QUERY_STRING'];
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        
		$this->data['offset'] = $offset;
        $this->data['station_class'] = $this->station_class_dao->key_value();
        $this->fetch_data($limit, $offset, $filter);
    }

    private function fetch_data($limit, $offset, $filter = null) {

        $criteria = null;
        $group = get_data_restriction($this->session->userdata(SESSION_USERGROUP));
        if (!is_null($group) && $group != '') {
            $criteria = array('corps_id' => $group);
        }

        $this->data['station'] = $this->station_dao->table_fetch($limit, $offset, $filter, 'station_name');
        $this->data['corps'] = $this->corps_dao->fetch(1000, 0, 'corps_name', $criteria);
        $this->data['station_type'] = $this->station_type_dao->fetch(5000, 0);


        $parstats = $this->station_dao->fetch_parent_stations();
        $parstat_arr = array();
        $parstat_arr[''] = '-Pilih Pangkalan Induk-';
        foreach ($parstats as $parstat) {
            $parstat_arr[$parstat->station_id] = $parstat->station_name;
        }

        $this->data['parent_station'] = $parstat_arr;
        //station logistic
//        $this->data['logistic_item'] = $this->logistic_item_dao->fetch('4', $limit, $offset);
//
//        $this->data['station_logistics'] = null;
    }

    public function fetch_record($keys) {
        $this->data['station'] = $this->station_dao->by_id($keys);
    }

    private function getValue($inputid) {
        return $this->input->post($inputid) == '' ? 0 : $this->input->post($inputid);
    }

    private function fetch_input() {
        $data = array(
            'station_name' => $this->input->post('station_name'),
            'station_commander' => $this->input->post('station_commander'),
            'stype_id' => $this->input->post('stype_id'),
            'corps_id' => $this->input->post('corps_id') == '' ? null : $this->input->post('corps_id'),
        	'station_parent' => $this->input->post('station_parent'),
            'sclass_id' => $this->input->post('sclass_id'),
            'station_lat' => toGeoDec($this->getValue('station_dlat'), $this->getValue('station_mlat'), $this->getValue('station_slat'), $this->getValue('station_rlat')),
            'station_lon' => toGeoDec($this->getValue('station_dlon'), $this->getValue('station_mlon'), $this->getValue('station_slon'), $this->getValue('station_rlon')),
            'station_desc' => $this->input->post('station_desc'),
            'station_people' => $this->input->post('station_people') == '' ? 0 : $this->input->post('station_people'),
            'station_dsp' => $this->input->post('station_dsp'),
            'station_fac_sandar' => $this->input->post('station_fac_sandar'),
            'station_fac_perbekalan' => $this->input->post('station_fac_perbekalan'),
            'station_fac_perawatan' => $this->input->post('station_fac_perawatan'),
            'station_fac_power' => $this->input->post('station_fac_power'),
            'station_arpaid' => $this->input->post('station_arpaid'),
            'station_fasharkan' => $this->input->post('station_fasharkan'), // added by SKM17
            'station_location' => $this->input->post('station_location') // added by SKM17
        );
        if ($this->input->post('station_id')) {
            $data['station_id'] = $this->input->post('station_id');
        }
        return $data;
    }

    public function save() {
        $obj = $this->fetch_input();
        $id=$this->input->post('station_id');
        $infoSession = ''; // added by SKM17

        if ($this->validate() != false) {
//            $obj_id = array('station_id' => $obj['station_id']);

			// added by SKM17 {
            $this->data['error_main_image'] = false;
            $this->data['msg_error_main_image'] = '';
            $config_main_image['upload_path'] = './assets/img/upload/main/pangkalan/';
            $config_main_image['allowed_types'] = 'gif|jpg|png|jpeg';
            // $config_main_image['max_width'] = 100;
            // $config_main_image['max_height'] = 100;
            $config_main_image['size'] = 2000;
            $config_main_image['encrypt_name'] = true; 
            $this->upload->initialize($config_main_image);

            $info='';
            if($_FILES['station_image']['name']!=''){
                if ($this->upload->do_upload('station_image')) {
                    $info = $this->upload->data();
                    $obj['station_image'] = $info['file_name'];
				    $infoSession .= "Gambar Utama berhasil diunggah. ";
                } else {
                    $this->data['error_main_image'] = true;
                    $this->data['msg_error_main_image'] = strip_tags($this->upload->display_errors());
                    $infoSession.= "<font color='red'> Gambar Utama GAGAL diunggah. Silakan masukan gambar  dibawah 2MB.</font> ";
                }
            }else{
                // $infoSession.="<font color='red'>Gambar Utama tidak diubah.</font>";
            }

			// } END ADDED

			// added by SKM17 {
            $config_main_image['upload_path'] = './assets/img/upload/main/pangkalan/fac_sandar/';
            $config_main_image['allowed_types'] = 'gif|jpg|png|jpeg';
            // $config_main_image['max_width'] = 100;
            // $config_main_image['max_height'] = 100;
            $config_main_image['size'] = 2000;
            $config_main_image['encrypt_name'] = true; 
            $this->upload->initialize($config_main_image);

            $info='';
            if($_FILES['station_fac_sandar_image']['name']!=''){
                if ($this->upload->do_upload('station_fac_sandar_image')) {
                    $info = $this->upload->data();
                    $obj['station_fac_sandar_image'] = $info['file_name'];
				    $infoSession .= "Gambar Fasilitas Sandar berhasil diunggah. ";
                } else {
                    $this->data['error_main_image'] = true;
                    $this->data['msg_error_main_image'] = strip_tags($this->upload->display_errors());
                    $infoSession.= "<font color='red'> Gambar Fasilitas GAGAL diunggah. Silakan masukan gambar dibawah 2MB.</font> ";
                }
            }else{
                // $infoSession.="<font color='red'>Gambar Fasilitas tidak diubah.</font>";
            }
			// } END ADDED

			// added by SKM17 {
            $config_main_image['upload_path'] = './assets/img/upload/main/pangkalan/fac_perbekalan/';
            $config_main_image['allowed_types'] = 'gif|jpg|png|jpeg';
            // $config_main_image['max_width'] = 100;
            // $config_main_image['max_height'] = 100;
            $config_main_image['size'] = 2000;
            $config_main_image['encrypt_name'] = true; 
            $this->upload->initialize($config_main_image);

            $info='';
            if($_FILES['station_fac_perbekalan_image']['name']!=''){
                if ($this->upload->do_upload('station_fac_perbekalan_image')) {
                    $info = $this->upload->data();
                    $obj['station_fac_perbekalan_image'] = $info['file_name'];
				    $infoSession .= "Gambar Fasilitas Perbekalan berhasil diunggah. ";
                } else {
                    $this->data['error_main_image'] = true;
                    $this->data['msg_error_main_image'] = strip_tags($this->upload->display_errors());
                    $infoSession.= "<font color='red'> Gambar Fasilitas Perbekalan GAGAL diunggah. Silakan masukan gambar dibawah 2MB.</font> ";
                }
            }else{
                // $infoSession.="<font color='red'>Gambar Fasilitas Perbekalan tidak diubah.</font>";
            }
			// } END ADDED

			$status; // added by SKM17
            if (isset($obj['station_id']) && $this->station_dao->by_id(array('station_id' => $obj['station_id'])) != null) {
                $obj_id = array('station_id' => $obj['station_id']);
                $status = $this->station_dao->update($obj, $obj_id);
                $saving_station_id = $obj['station_id'];
				$infoSession .= "Data Pangkalan berhasil diubah. ";
            } else {
                $status = $this->station_dao->insert($obj);
                $saving_station_id = $this->station_dao->insert_id();
				$infoSession .= "Data Pangkalan berhasil ditambah. ";
            }
//            $this->save_logistic($saving_station_id);
			if ($status == FALSE)
				$infoSession .= "Data Pangkalan gagal ditambah/disimpan. ";
	        
            $this->session->set_flashdata("info", $infoSession);
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        } else {
            /* invalid input will be redirected to edit view with error message included */
            $this->preload();
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/station/list_station', $this->data);
        }
    }

    public function save_logistic($station_id) {
        $status_insert = true;

        $stationlog = array();
        $stationvalue = array();

        $totalRow = $this->input->post('totalRow');
        //delete logistik in aeroplane first
        $this->station_logistics_dao->delete(array('station_id' => $station_id));
        //insert new logistik
        for ($i = 1; $i <= $totalRow; $i++) {
            $stationlog = $this->input->post('stationLog_' . $i);
            $stationvalue = $this->input->post('stationValue_' . $i);

            $new_logistics = array('logitem_id' => $stationlog, 'station_id' => $station_id, 'stationlog_value' => $stationvalue);
            $this->station_logistics_dao->insert($new_logistics);
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
      viewing editing form. repopulation for every data needed in form done here.
     */
    public function edit($station_id = null) {
        $this->preload();
        if ($station_id == null
        ) {
            $this->load_view('admin/station/station_edit');
        } else {
            $this->get_list($this->limit,$this->uri->segment(5));
            $this->get_list_logistic($this->limit);
            $this->data['station_logistics'] = $this->station_logistics_dao->table_fetch($station_id, $this->limit);
            //get station
            $obj_id = array('station_id' => $station_id);

            $to_edit = $this->station_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            $this->load_view('admin/station/list_station', $this->data);
        }
    }

    /**

      @description
      viewing record. repopulation for every data needed for view.
     */
    public function view($station_id = null) {
        $this->preload();
        if ($station_id == null
        ) {
            $this->load_view('admin/station/station_edit');
        } else {
            $this->get_list($this->limit);
            $this->get_list_logistic($this->limit);
            $this->data['station_logistics'] = $this->station_logistics_dao->table_fetch($station_id, $this->limit);
            //get station
            $obj_id = array('station_id' => $station_id);

            $to_edit = $this->station_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            $this->data['view'] = true;
            $this->load_view('admin/station/list_station', $this->data);
        }
    }

    public function delete($station_id = null) {
        $obj_id = array('station_id' => $station_id);
        //menghapus gambar di folder added by D3 Polban
        $image = $this->station_dao->by_id($obj_id);
        unlink($this->config->item('root_path')."assets/img/upload/main/pangkalan/".$image->station_image);
        unlink($this->config->item('root_path')."assets/img/upload/main/pangkalan/fac_sandar/".$image->station_fac_sandar_image);
        unlink($this->config->item('root_path')."assets/img/upload/main/pangkalan/fac_perbekalan/".$image->station_fac_perbekalan_image);
        //end added

        $this->station_logistics_dao->delete($obj_id);
        $status_del = $this->station_dao->delete($obj_id);
        if ($status_del == false) {
            $this->session->set_flashdata("info", "Hapus Data Pangkalan gagal!");
        } else {
            $this->session->set_flashdata("info", "Hapus Data Pangkalan berhasil!");
        }
        redirect(self::$CURRENT_CONTEXT);
    }

    public function get_list_logistic($limit = 16, $offset = 0) {
        // $obj = $this->filter_param();
        #generate pagination
        // $config['base_url'] = site_url(self::$CURRENT_CONTEXT . 'index');
        // $config['total_rows'] = $this->station_logistics_dao->count_all();
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
