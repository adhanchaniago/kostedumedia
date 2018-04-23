<?php

class dashboard_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 16;
    public static $CURRENT_CONTEXT = '/admin/dashboard_ctrl';
    public static $TITLE = "Dashboard";

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('geodesics');
        $this->load->helper('acl');
        $this->load->library('session');
        $this->load->library('tank_auth');
        $this->load->library('dao/user_role_dao');
        $this->load->library('dao/ship_dao');
        $this->load->library('dao/aeroplane_dao');

        $this->logged_in();
        $this->role_user();
        $this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
        $this->data['idAccessMsg'] = $this->session->userdata(SESSION_USERMSGID);
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
        $this->get_list(); // mengambil jumlah kri & pesud berdasarkan pembina
        $this->load_view('admin/dashboard/dashboard', $this->data);
    }

    public function get_list() {
        // jumlah kri & pesud dg pembina armabar
        $filter['corps_id'] = 1;
        $this->data['ship']['armabar'] = $this->ship_dao->count_table_fetch($filter);
        $this->data['aeroplane']['armabar'] = $this->aeroplane_dao->count_table_fetch(null, $filter);
        // jumlah kri & pesud dg pembina armatim
        $filter['corps_id'] = 2;
        $this->data['ship']['armatim'] = $this->ship_dao->count_table_fetch($filter);
        $this->data['aeroplane']['armatim'] = $this->aeroplane_dao->count_table_fetch(null, $filter);
        // jumlah kri & pesud dg pembina kolinlamil
        $filter['corps_id'] = 40;
        $this->data['ship']['kolinlamil'] = $this->ship_dao->count_table_fetch($filter);
        $this->data['aeroplane']['kolinlamil'] = $this->aeroplane_dao->count_table_fetch(null, $filter);
        // jumlah kri & pesud dg pembina selain yg di atas
        $filter['corps_id'] = null;
        $filter['corps_id_not'] = array (1, 2, 40);
        $this->data['ship']['lainlain'] = $this->ship_dao->count_table_fetch($filter);
        $this->data['aeroplane']['lainlain'] = $this->aeroplane_dao->count_table_fetch(null, $filter);
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
