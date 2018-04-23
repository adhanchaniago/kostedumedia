<?php

class aeroplane_icon_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 1000;
    public static $CURRENT_CONTEXT = '/admin/aeroplane_icon_ctrl';
    public static $TITLE = "Jenis Pesawat";

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('acl');
        $this->load->library('dao/aeroplane_icon_dao');
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
        $this->form_validation->set_rules('aericon_id', 'aericon_id', '');
        $this->form_validation->set_rules('aericon_desc', 'aericon_desc', 'required');

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
        $this->load_view('admin/aeroplane_icon/list_aeroplane_icon', $this->data);
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
        $config['total_rows'] = $this->aeroplane_icon_dao->count_all();
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
        $this->data['aeroplane_icon'] = $this->aeroplane_icon_dao->fetch($limit, $offset, 'aericon_desc');
    }

    public function fetch_record($keys) {
        $this->data['aeroplane_icon'] = $this->aeroplane_icon_dao->by_id($keys);
    }

    private function fetch_input() {
        $data = array('aericon_desc' => $this->input->post('aericon_desc'));
        if ($this->input->post('aericon_id')) {
            $data['aericon_id'] = $this->input->post('aericon_id');
        }

        return $data;
    }

    public function save() {
        $obj = $this->fetch_input();
        $id=$this->input->post('aericon_id');
        $infoSession = ''; // added by SKM17
        
        if ($this->validate() != false) {
			$config_upload['upload_path'] = './assets/img/icon-aeroplane/';
			$config_upload['allowed_types'] = 'gif|jpg|png';
			$config_upload['max_width'] = 100;
			$config_upload['max_height'] = 100;
			$config_upload['max_size'] = 1000;
			$config_upload['encrypt_name'] = true;
			$this->upload->initialize($config_upload);

            $info='';
            if($_FILES['aericon_file']['name']!=''){
			     if ($this->upload->do_upload('aericon_file')) {
				    $info = $this->upload->data();
				    $obj['aericon_file'] = $info['file_name'];
				    $infoSession .= "Ikon Jenis Pesawat berhasil diunggah. ";
			     }else{
                    $this->data['error_main_image'] = TRUE;
                    $this->data['msg_error_main_image'] = strip_tags($this->upload->display_errors());
                    $infoSession.= "<font color='red'> Ikon Jenis Pesawat GAGAL diunggah. Silakan masukan gambar dibawah 1MB.</font> ";
                 }
            }else{
                // $infoSession.="<font color='red'>Ikon Jenis Pesawat tidak diubah.</font>";
            }

			
			$saved; // added by SKM17
            if (isset($obj['aericon_id']) && $this->aeroplane_icon_dao->by_id(array('aericon_id' => $obj['aericon_id'])) != null) {
                $obj_id = array('aericon_id' => $obj['aericon_id']);
                $saved = $this->aeroplane_icon_dao->update($obj, $obj_id);
				$infoSession .= "Data Jenis Pesawat berhasil diubah. ";
            } else {
				$saved = $this->aeroplane_icon_dao->insert($obj);
				$infoSession .= "Data Jenis Pesawat berhasil ditambah. ";
            }
            
            if (!$saved)
            	$infoSession .= "Data Jenis Pesawat gagal ditambah/diubah. ";
            
            $this->session->set_flashdata("info", $infoSession);
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        } else {
            /* invalid input will be redirected to edit view with error message included */
            $this->preload();
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/aeroplane_icon/list_aeroplane_icon', $this->data);
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
    public function edit($aericon_id = null) {
        $this->preload();
        if ($aericon_id == null) {
            $this->load_view('admin/aeroplane_icon/list_aeroplane_icon');
        } else {
            $param = $this->get_list($this->limit);
            $obj_id = array('aericon_id' => $aericon_id);

            $to_edit = $this->aeroplane_icon_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            $this->load_view('admin/aeroplane_icon/list_aeroplane_icon', $this->data);
        }
    }

    /**

      @description
      viewing record. repopulation for every data needed for view.
     */
    public function view($aericon_id = null) {
        $obj_id = array('aericon_id' => $aericon_id);

        $this->preload();
        $this->fetch_record($obj_id);
        #prepare link for back to view list
        $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
        $this->load_view('admin/aeroplane_icon/list_aeroplane_icon', $this->data);
    }

    public function delete($aericon_id = null) {
        $obj_id = array('aericon_id' => $aericon_id);


        //menghapus gambar di folder added d3 POLBAN
        $image=$this->aeroplane_icon_dao->by_id($obj_id);
        unlink($this->config->item('root_path')."assets/img/icon-aeroplane/".$image->aericon_file);


        $status_del = $this->aeroplane_icon_dao->delete($obj_id);
        if ($status_del == false) {
            $this->session->set_flashdata("info", "Hapus jenis pesawat gagal!");
        } else {
            $this->session->set_flashdata("info", "Hapus jenis pesawat berhasil!");
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
