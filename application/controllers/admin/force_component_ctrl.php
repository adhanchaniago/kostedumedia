<?php

class force_component_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 1000;
    public $offset = 0;
    public static $CURRENT_CONTEXT = '/admin/force_component_ctrl';
    public static $TITLE = "Kekuatan Musuh";

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('geodesics');
        $this->load->helper('acl');
        $this->load->library('session');
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->load->library('dao/user_role_dao');
        $this->load->library('dao/force_component_dao');
        $this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
        $this->load->library('pagination');
        $this->load->library('tank_auth');

        $this->logged_in();
        $this->role_user();
        $this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
    }
    

    private function validate() {

        $this->form_validation->set_rules('fcomp_name', 'fcomponent_name', '');       
       // $this->form_validation->set_rules('fcomp_icon', 'fcomponent_icon', '');
        $this->form_validation->set_rules('fcomptype_id', 'fcomptype_id', '');
       
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

    public function index($offset = 0) {
        $this->preload();
        $this->get_list($this->limit, $offset);
        $this->load_view('admin/force_component/list_force_component', $this->data);
    }

    public function fetch_record($keys) {
        $this->data['force_component'] = $this->force_component_dao->by_id($keys);
    }

    private function fetch_data($limit, $offset, $filter = null) {

        $this->data['force_component'] = $this->force_component_dao->table_fetch($filter, 'enmap_name', true, $limit , $offset);
        $this->data['force_component_type'] = $this->force_component_dao->fetch_force_component_type();
    }

    private function getValue($inputid) {
        return $this->input->post($inputid) == '' ? 0 : $this->input->post($inputid);
    }

    private function getValue2($var) {
        return $var == '' ? 0 : (float) $var;
    }


    private function fetch_input() {

        $id = $this->input->post('fcomp_id');
        $typeid = $this->input->post('fcomptype_id');
        $data = array(
            'fcomp_name' => trim($this->input->post('fcomp_name')),
            'fcomp_icon' => trim($this->input->post('fcomp_icon'))            
        );

        if(isset($typeid) && $typeid != '')
        {
            $data['fcomptype_id'] = intval(trim($typeid));
        }

        if(isset($id) && $id != '')
        {
            $data['fcomp_id'] = intval(trim($id));
        }

        return $data;
    }

    public function save() {
        $obj = $this->fetch_input();

        // exit;
        if ($this->validate()) {

            $config_upload['upload_path'] = './assets/img/nato-icon/';
            $config_upload['allowed_types'] = 'gif|jpg|png';
            /*$config_upload['max_width'] = 100;
            $config_upload['max_height'] = 100;
            $config_upload['max_size'] = 1000;*/
            $this->upload->initialize($config_upload);

            if ($this->upload->do_upload('fcomp_icon')) {
                $info = $this->upload->data();
                $obj['fcomp_icon'] = $info['file_name'];
                print_r($info);
            }else{

                $upload_err = $this->upload->display_errors();
                echo $upload_err;
                echo getcwd();
                exit;
            }

            if (isset($obj['fcomp_id']) && $this->force_component_dao->by_id(array('fcomp_id' => $obj['fcomp_id'])) != null) {
                
                $obj_id = array('fcomp_id' => $obj['fcomp_id']);
                $this->force_component_dao->update($obj, $obj_id);
                $saving_aer_id = $obj['fcomp_id'];
            } else {
                
                $this->force_component_dao->insert($obj);
                $saving_aer_id = $this->force_component_dao->insert_id();
            }

            $this->session->set_flashdata("info", "Data Komponen Kekuatan Musuh berhasil disimpan.");
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        } else {

            
            /* invalid input will be redirected to edit view with error message included */
            $this->preload();
            $this->get_list($this->limit, $this->offset);
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/force_component/list_force_component', $this->data);
        }
    }

    /**

      @description
      viewing editing form. repopulation for every data needed in form done here.
     */
    public function edit($fcomp_id = null) {
        $this->preload();
        if ($fcomp_id == null) {
            $this->load_view('admin/force_component/list_force_component');
        } else {
            $this->get_list($this->limit);
//            $this->get_list_logistic($this->limit);
//            $this->data['aeroplane_logistics'] = $this->aeroplane_logistics_dao->table_fetch($aer_id, $this->limit);
            $obj_id = array('fcomp_id' => $fcomp_id);

            $to_edit = $this->force_component_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;

            // print_r($this->data);
            $this->load_view('admin/force_component/list_force_component', $this->data);
        }
    }

   

    /**

      @description
      viewing record. repopulation for every data needed for view.
     */
    public function view($aer_id = null) {
        $this->preload();
        if ($aer_id == null) {
            $this->load_view('admin/force_component/list_force_component');
        } else {
            $this->get_list($this->limit);
//            $this->get_list_logistic($this->limit);
//            $this->data['aeroplane_logistics'] = $this->aeroplane_logistics_dao->table_fetch($aer_id, $this->limit);
            $obj_id = array('aer_id' => $aer_id);

            $to_edit = $this->force_component_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            $this->data['view'] = true;
            $this->load_view('admin/force_component/list_force_component', $this->data);
        }
    }

    public function delete($aer_id = null) {
        $obj_id = array('enmap_id' => $aer_id);
        
        $status_del = $this->force_component_dao->delete($obj_id);
        if ($status_del == false) {
            $this->session->set_flashdata("info", "Penghapusan data kekuatan musuh gagal");
        } else {
            $this->session->set_flashdata("info", "Penghapusan data kekuatan musuh berhasil!");
        }
        redirect(self::$CURRENT_CONTEXT);
    }

    /*
        'enmap_id' => 'enmap_id',
        'eforcetype_id'=> 'eforcetype_id',
        'enmap_name' => 'enmap_name',
        'enmap_lat' => 'enmap_lat',
        'enmap_lon' => 'enmap_lon',
        'enmap_desc' => 'enmap_desc',
    */

    /**
      getting filter parameter when user
      doing searching.
     */
    public function filter_param() {
        $filter = array();
         if (isset($_GET['filter'])) {

            $ename = $this->input->get('fcomp_filter');
            if(isset($ename) && $ename != '' ){
                $filter['fcomp_name'] = $ename;
            }

            $forcetype = $this->input->get('eforcetypeid_filter');
            if(isset($forcetype) && $forcetype != ''){
                $filter['fcomptype_id'] = $forcetype;
            }
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

        $config['total_rows'] = $this->force_component_dao->count_table_fetch(null, $filter);
        $config['per_page'] = 16;//$limit;
        $config['uri_segment'] = $uri;
        $config['filter_param'] = $_SERVER['QUERY_STRING'];
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['offset'] = $offset;
        $this->data['filter_param'] = (object) $filter;
        $this->fetch_data(16, $offset, $filter);
    }

    public function upload_handler(){
        /*
        Uploadify
        Copyright (c) 2012 Reactive Apps, Ronnie Garcia
        Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
        */

        // Define a destination
        $targetFolder = '/uploads'; // Relative to the root

        $verifyToken = md5('unique_salt' . $_POST['timestamp']);

        if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            $targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
            
            echo 'target path : '.$targetFile;
            // Validate the file type
            $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            
            if (in_array($fileParts['extension'],$fileTypes)) {
                move_uploaded_file($tempFile,$targetFile);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
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