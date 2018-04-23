<?php

class station_type_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 16;
    public static $CURRENT_CONTEXT = '/admin/station_type_ctrl';
    public static $TITLE = "Tipe Pangkalan";

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('acl');
        $this->load->library('dao/station_type_dao');
        $this->load->library('dao/user_role_dao');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
        $this->load->library('pagination');
        $this->load->library('tank_auth');
        $this->load->library('upload');
        $this->load->library('image_lib');

        $this->logged_in();
        $this->role_user();
        $this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
        $this->data['idAccessMsg'] = $this->session->userdata(SESSION_USERMSGID);
    }

    private function validate() {
        $this->form_validation->set_rules('stype_id', 'stype_id', '');
        $this->form_validation->set_rules('stype_name', 'stype_name', 'required');

        return $this->form_validation->run();
    }

    /**
      prepare data for view
     */
    public function preload() {
        $this->data['current_context'] = self::$CURRENT_CONTEXT;
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
        $this->load_view('admin/station_type/list_station_type', $this->data);
    }

    /**
      getting filter parameter when user
      doing searching.
     */
    public function filter_param() {
        $filter = array();
        $par = $this->input->post('sample');
        if ($par != NULL || $par != '') {
            $filter['sample'] = $par;
        }
        // other input receive
        return $filter;
    }

    public function get_list($limit = 16, $offset = 0) {
        $obj = $this->filter_param();

        #generate pagination
        $config['base_url'] = site_url(self::$CURRENT_CONTEXT . 'index');
        $config['total_rows'] = $this->station_type_dao->count_all();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        if (empty($obj)) {
            // non conditional data fetching
            $this->fetch_data($limit, $offset);
        } else {
            // apply filter
        }
    }

    private function fetch_data($limit, $offset) {
        $this->data['station_type'] = $this->station_type_dao->fetch($limit, $offset, 'stype_name');
    }

    public function fetch_record($keys) {
        $this->data['station_type'] = $this->station_type_dao->by_id($keys);
    }

    private function fetch_input() {
        $data = array('stype_name' => $this->input->post('stype_name'));

        return $data;
    }

    public function save() {
        $obj = $this->fetch_input();
        $id = $this->input->post('stype_id');
        $infoSession = ''; // added by SKM17
        
        if ($this->validate() != false) {
			$config_upload['upload_path'] = './assets/img/icon-station/';
			$config_upload['allowed_types'] = 'gif|jpg|png';
			$config_upload['max_width'] = 100;
			$config_upload['max_height'] = 100;
			$config_upload['max_size'] = 1000;
			$this->upload->initialize($config_upload);
			if ($this->upload->do_upload('stype_icon')) {
				$info = $this->upload->data();
				$obj['stype_icon'] = $info['file_name'];
				$infoSession .= "Ikon Jenis Pangkalan berhasil diunggah. ";
			}
            if ($id != null) {
                $obj_id = array('stype_id' => $this->input->post('stype_id'));
                $this->station_type_dao->update($obj, $obj_id);
				$infoSession .= "Data Jenis Pangkalan berhasil diubah. ";
            } else {
				$this->station_type_dao->insert($obj);
				$infoSession .= "Data Jenis Pangkalan berhasil ditambah. ";
            }
            
            $this->session->set_flashdata("info", $infoSession);
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        } else {
            /* invalid input will be redirected to edit view with error message included */
            $this->preload();
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/station_type/list_station_type', $this->data);
        }
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
    public function edit($stype_id = null) {
        $this->preload();
        if ($stype_id == null) {
            $this->load_view('admin/station_type/list_station_type');
        } else {
            $param = $this->get_list($this->limit);
            $obj_id = array('stype_id' => $stype_id);

            $to_edit = $this->station_type_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            $this->load_view('admin/station_type/list_station_type', $this->data);
        }
    }

    /**

      @description
      viewing record. repopulation for every data needed for view.
     */
    public function view($stype_id = null) {
        $obj_id = array('stype_id' => $stype_id);

        $this->preload();
        $this->fetch_record($obj_id);
        #prepare link for back to view list
        $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
        $this->load_view('admin/station_type/view_station_type', $this->data);
    }

    public function delete($stype_id = null) {
        $obj_id = array('stype_id' => $stype_id);

        //menghapus gambar di folder added d3 POLBAN
        $image=$this->station_type_dao->by_id($obj_id);
        unlink($this->config->item('root_path')."assets/img/icon-station/".$image->stype_icon);


        $status_del = $this->station_type_dao->delete($obj_id);
        if ($status_del == false) {
            $this->session->set_flashdata("info", "Hapus jenis pangkalan gagal!");
        } else {
            $this->session->set_flashdata("info", "Hapus jenis pangkalan berhasil!");
        }
        redirect(self::$CURRENT_CONTEXT);
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
