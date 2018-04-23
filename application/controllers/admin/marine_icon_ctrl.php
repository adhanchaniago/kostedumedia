<?php

class marine_icon_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 16;
    public static $CURRENT_CONTEXT = '/admin/marine_icon_ctrl';
    public static $TITLE = "Jenis Satuan Marinir";

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('acl');
        $this->load->library('dao/marine_icon_dao');
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
        $this->form_validation->set_rules('maricon_id', 'maricon_id', '');
        $this->form_validation->set_rules('maricon_desc', 'maricon_desc', 'required');

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
        $this->load_view('admin/marine_icon/list_marine_icon', $this->data);
    }

    /**
      getting filter parameter when user
      doing searching.
     */
    public function filter_param() {
        $filter = array();
        if (isset($_GET['filter'])) {
            $filter['maricon_desc'] = $this->input->get('maricon_desc');
        }
        // other input receive
        return $filter;
    }

    public function get_list($limit = 16, $offset = 0) {
        $obj = $this->filter_param();
        $filter = (!empty($obj)) ? $obj : null;

        #generate pagination
        if ($this->uri->segment(3)=='edit') {
		$base_url = self::$CURRENT_CONTEXT . '/edit/'.$this->uri->segment(4);
		$uri = 5;
	} else {
		$base_url = self::$CURRENT_CONTEXT . '/index/';
		$uri = 4;
	}
        $config['base_url'] = site_url($base_url);
        $config['total_rows'] = $this->marine_icon_dao->count_table_fetch($filter);
        $config['per_page'] = $limit;
        $config['uri_segment'] = $uri;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        $this->data['offset'] = $offset;
	$this->fetch_data($limit, $offset, $filter);
    }

    private function fetch_data($limit, $offset, $filter) {
        $this->data['marine_icon'] = $this->marine_icon_dao->table_fetch($limit, $offset, $filter, 'maricon_desc');
    }

    public function fetch_record($keys) {
        $this->data['marine_icon'] = $this->marine_icon_dao->by_id($keys);
    }

    private function fetch_input() {
        $data = array('maricon_desc' => $this->input->post('maricon_desc'));
        if ($this->input->post('maricon_id')) {
            $data['maricon_id'] = $this->input->post('maricon_id');
        }

        return $data;
    }

    public function save() {
        $obj = $this->fetch_input();
        $id=$this->input->post('maricon_id');
        $infoSession = ''; // added by SKM17
        
        if ($this->validate() != false) {
			$config_upload['upload_path'] = './assets/img/icon-marine/';
			$config_upload['allowed_types'] = 'gif|jpg|png';
			$config_upload['max_width'] = 100;
			$config_upload['max_height'] = 100;
			$config_upload['max_size'] = 1000;
			$config_upload['encrypt_name'] = true;
			$this->upload->initialize($config_upload);

            $info='';
            if($_FILES['maricon_file']['name']!=''){
			     if ($this->upload->do_upload('maricon_file')) {
				    $info = $this->upload->data();
				    $obj['maricon_file'] = $info['file_name'];
				    $infoSession .= "Ikon Jenis Satuan berhasil diunggah. ";
			     }else{
                    $this->data['error_main_image']= TRUE;
                    $this->data['msg_error_main_image'] = strip_tags($this->upload->display_errors());
                    $infoSession.= "<font color='red'> IKon Jenis GAGAL diunggah. Silakan masukan gambar dibawah 1MB.</font> ";
                 }
            }else{
                // $infoSession.="<font color='red'>IKon Jenis tidak diubah.</font>";
            }
			
			$saved; // added by SKM17
            if (isset($obj['maricon_id']) && $this->marine_icon_dao->by_id(array('maricon_id' => $obj['maricon_id'])) != null) {
                $obj_id = array('maricon_id' => $obj['maricon_id']);
                $saved = $this->marine_icon_dao->update($obj, $obj_id);
				$infoSession .= "Data Jenis Satuan berhasil diubah. ";
            } else {
				$saved = $this->marine_icon_dao->insert($obj);
				$infoSession .= "Data Jenis Satuan berhasil ditambah. ";
            }
            
            if (!$saved)
            	$infoSession .= "Data Jenis Satuan gagal ditambah/diubah. ";
            
            $this->session->set_flashdata("info", $infoSession);
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        } else {
            /* invalid input will be redirected to edit view with error message included */
            $this->preload();
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/marine_icon/list_marine_icon', $this->data);
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
    public function edit($maricon_id = null) {
        $this->preload();
        if ($maricon_id == null) {
            $this->load_view('admin/marine_icon/list_marine_icon');
        } else {
            $param = $this->get_list($this->limit);
            $obj_id = array('maricon_id' => $maricon_id);

            $to_edit = $this->marine_icon_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            $this->load_view('admin/marine_icon/list_marine_icon', $this->data);
        }
    }

    /**

      @description
      viewing record. repopulation for every data needed for view.
     */
    public function view($maricon_id = null) {
        $obj_id = array('maricon_id' => $maricon_id);

        $this->preload();
        $this->fetch_record($obj_id);
        #prepare link for back to view list
        $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
        $this->load_view('admin/marine_icon/list_marine_icon', $this->data);
    }

    public function delete($maricon_id = null) {
        $obj_id = array('maricon_id' => $maricon_id);

        //menghapus gambar di folder added d3 POLBAN
        $image=$this->marine_icon_dao->by_id($obj_id);
        unlink($this->config->item('root_path')."assets/img/icon-marine/".$image->maricon_file);

        $status_del = $this->marine_icon_dao->delete($obj_id);
        if ($status_del == false) {
            $this->session->set_flashdata("info", "Hapus jenis satuan gagal!");
        } else {
            $this->session->set_flashdata("info", "Hapus jenis satuan berhasil!");
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
