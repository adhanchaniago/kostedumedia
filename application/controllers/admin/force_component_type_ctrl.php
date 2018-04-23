<?php

class enemy_force_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 1000;
    public $offset = 0;
    public static $CURRENT_CONTEXT = '/admin/enemy_force_ctrl';
    public static $TITLE = "Kekuatan Musuh";

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('geodesics');
        $this->load->helper('acl');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('dao/user_role_dao');
        $this->load->library('dao/enemy_force_dao');
        $this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
        $this->load->library('pagination');
        $this->load->library('tank_auth');

        $this->logged_in();
        $this->role_user();
        $this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
    }
    

    private function validate() {

        $this->form_validation->set_rules('eforcetype_id', 'eforcetype_id', '');
        $this->form_validation->set_rules('enmap_name', 'enmap_name', '');       
       
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
        $this->load_view('admin/enemy_force/list_enemy_force', $this->data);
    }

    public function fetch_record($keys) {
        $this->data['enemy_force'] = $this->enemy_force_dao->by_id($keys);
    }

    private function fetch_data($limit, $offset, $filter = null) {

        $this->data['enemy_force'] = $this->enemy_force_dao->table_fetch($filter, 'enmap_name', true, $limit , $offset);
        $this->data['force_types'] = $this->enemy_force_dao->fetch_force_type();
    }

    private function getValue($inputid) {
        return $this->input->post($inputid) == '' ? 0 : $this->input->post($inputid);
    }

    private function getValue2($var) {
        return $var == '' ? 0 : (float) $var;
    }


    private function fetch_input() {

        $id = $this->input->post('enmap_id');
        $data = array(
            'eforcetype_id' => trim($this->input->post('eforcetype_id')),
            'enmap_name' => trim($this->input->post('enmap_name')),
            'enmap_lat' => (double) toGeoDec($this->getValue('enmap_dlat'), $this->getValue('enmap_mlat'), $this->getValue('enmap_slat'), $this->getValue('enmap_rlat')),
            'enmap_lon' => (double) toGeoDec($this->getValue('enmap_dlon'), $this->getValue('enmap_mlon'), $this->getValue('enmap_slon'), $this->getValue('enmap_rlon')),
            'enmap_desc' => trim($this->input->post('enmap_desc'))
        );

        if(isset($id) && $id != '')
        {
            $data['enmap_id'] = intval(trim($id));
        }

        return $data;
    }

    public function save() {
        $obj = $this->fetch_input();

        print_r($obj);
        // exit;
        if ($this->validate()) {
            echo "VALID!";

            if (isset($obj['enmap_id']) && $this->enemy_force_dao->by_id(array('enmap_id' => $obj['enmap_id'])) != null) {

                echo 'UPDATING...';
                $obj_id = array('enmap_id' => $obj['enmap_id']);
                $this->enemy_force_dao->update($obj, $obj_id);
                $saving_aer_id = $obj['enmap_id'];
            } else {
                echo 'SAVING...';
                $this->enemy_force_dao->insert($obj);
                $saving_aer_id = $this->enemy_force_dao->insert_id();
            }

            $this->session->set_flashdata("info", "Data Kekuatan Musuh berhasil disimpan.");
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        } else {

            echo 'NOT VALID';
            /* invalid input will be redirected to edit view with error message included */
            $this->preload();
            $this->get_list($this->limit, $this->offset);
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/enemy_force/list_enemy_force', $this->data);
        }
    }

    /**

      @description
      viewing editing form. repopulation for every data needed in form done here.
     */
    public function edit($enmap_id = null) {
        $this->preload();
        if ($enmap_id == null) {
            $this->load_view('admin/enemy_force/list_enemy_force');
        } else {
            $this->get_list($this->limit);
//            $this->get_list_logistic($this->limit);
//            $this->data['aeroplane_logistics'] = $this->aeroplane_logistics_dao->table_fetch($aer_id, $this->limit);
            $obj_id = array('enmap_id' => $enmap_id);

            $to_edit = $this->enemy_force_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;

            // print_r($this->data);
            $this->load_view('admin/enemy_force/list_enemy_force', $this->data);
        }
    }

   

    /**

      @description
      viewing record. repopulation for every data needed for view.
     */
    public function view($aer_id = null) {
        $this->preload();
        if ($aer_id == null) {
            $this->load_view('admin/enemy_force/list_enemy_force');
        } else {
            $this->get_list($this->limit);
//            $this->get_list_logistic($this->limit);
//            $this->data['aeroplane_logistics'] = $this->aeroplane_logistics_dao->table_fetch($aer_id, $this->limit);
            $obj_id = array('aer_id' => $aer_id);

            $to_edit = $this->enemy_force_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            $this->data['view'] = true;
            $this->load_view('admin/enemy_force/list_enemy_force', $this->data);
        }
    }

    public function delete($aer_id = null) {
        $obj_id = array('enmap_id' => $aer_id);
        
        $status_del = $this->enemy_force_dao->delete($obj_id);
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

            $ename = $this->input->get('enmapname_filter');
            if(isset($ename) && $ename != '' ){
                $filter['enmap_name'] = $ename;
            }

            $forcetype = $this->input->get('eforcetypeid_filter');
            if(isset($forcetype) && $forcetype != ''){
                $filter['eforcetype_id'] = $forcetype;
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

        $config['total_rows'] = $this->enemy_force_dao->count_table_fetch(null, $filter);
        $config['per_page'] = 16;//$limit;
        $config['uri_segment'] = $uri;
        $config['filter_param'] = $_SERVER['QUERY_STRING'];
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['offset'] = $offset;
        $this->data['filter_param'] = (object) $filter;
        $this->fetch_data(16, $offset, $filter);
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