<?php

class personnel_reff_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 16;
    public static $CURRENT_CONTEXT = '/admin/personnel_reff_ctrl';
    public static $TITLE = 'Personel';

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->library('dao/personnel_reff_dao');
        $this->load->library('dao/user_role_dao');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('acl');
        $this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
        $this->load->library('pagination');
        $this->load->library('tank_auth');

        $this->logged_in();
        $this->role_user();
        $this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
    }

    private function validate() {
        $this->form_validation->set_rules('psnreff_nrp', 'psnreff_nrp', 'required');
//        $this->form_validation->set_rules('psnreff_name', 'psnreff_name', 'required');

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
        $this->load_view('admin/personnel_reff/list_personnel_reff', $this->data);
    }

    public function fetch_record($keys) {
        $this->data['personnel_reff'] = $this->personnel_reff_dao->by_id($keys);
    }

    private function fetch_data($limit, $offset,$filter=null) {
        
        $this->data['personnel_reff'] = $this->personnel_reff_dao->fetch_data($limit, $offset, null, true, $filter);
    }

    private function fetch_input() {
        $data = array('psnreff_nrp' => str_replace('/', '_', $this->input->post('psnreff_nrp')),
            'psnreff_name' => $this->input->post('psnreff_name'));

        return $data;
    }

    public function save() {
        $obj = $this->fetch_input();

        if ($this->validate() != false) {
            $obj_id = array('psnreff_nrp' => $obj['psnreff_nrp']);

            if ($this->personnel_reff_dao->by_id($obj_id) != null) {
                $this->personnel_reff_dao->update($obj, $obj_id);
            } else {
                $this->personnel_reff_dao->insert($obj);
            }
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        } else {
            /* invalid input will be redirected to edit view with error message included */
            $this->preload();
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/personnel_reff/personnel_reff_edit', $this->data);
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
    public function edit($psnreff_nrp = null) {
        $this->preload();
        if ($psnreff_nrp == null
        ) {
            $this->load_view('admin/personnel_reff/list_personnel_reff');
        } else {
            $param = $this->get_list($this->limit);
            $obj_id = array('psnreff_nrp' => $psnreff_nrp);

            $to_edit = $this->personnel_reff_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            $this->load_view('admin/personnel_reff/list_personnel_reff', $this->data);
        }
    }

    /**

      @description
      viewing record. repopulation for every data needed for view.
     */
    public function view($psnreff_nrp = null) {
        $obj_id = array('psnreff_nrp' => $psnreff_nrp);

        $this->preload();
        $this->fetch_record($obj_id);
        #prepare link for back to view list
        $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
        $this->load_view('admin/personnel_reff/view_personnel_reff', $this->data);
    }

    public function delete($psnreff_nrp = null) {
        $obj_id = array('psnreff_nrp' => $psnreff_nrp);

        $status_del = $this->personnel_reff_dao->delete($obj_id);
        if ($status_del == false) {
            $this->session->set_flashdata("info", "Delete Personel failed!");
        } else {
            $this->session->set_flashdata("info", "Delete Personle succeed!");
        }
        redirect(self::$CURRENT_CONTEXT);
    }

    /**
      getting filter parameter when user
      doing searching.
     */
    public function filter_param() {
        $filter = array();
        if (isset($_GET['filter'])) {
            $filter['psnreff_nrp'] = $this->input->get('psnreff_nrp');
            $filter['psnreff_name'] = $this->input->get('psnreff_name');
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
		
        $config['total_rows'] = $this->personnel_reff_dao->count_fetch_data($filter);
        $config['per_page'] = $limit;
        $config['uri_segment'] = $uri;
		$config['filter_param'] = $_SERVER['QUERY_STRING'];
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
		$this->data['offset'] = $offset;
		$this->fetch_data($limit, $offset,$filter);
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