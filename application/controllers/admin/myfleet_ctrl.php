<?php

class myfleet_ctrl extends CI_Controller {

	public $data;
	public $filter;
	public $limit = 16;
	public static $CURRENT_CONTEXT = '/admin/myfleet_ctrl';
	public static $TITLE = "Kapal MyFleet";

	public function __construct() {
		parent::__construct();
		$this->data = array();
		$this->load->helper('string');
		$this->load->helper('url');
		$this->load->helper('geodesics');
		$this->load->helper('acl');
		$this->load->library('session');
		$this->load->library('dao/myfleet_dao');
		$this->load->library('dao/myfleet_history_dao');
		$this->load->library('dao/user_role_dao');
		$this->load->library('pagination');
		$this->load->library('tank_auth');

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
		$this->get_list($this->limit, $offset);

		$this->load_view('admin/myfleet/list_myfleet', $this->data);
	}

	public function get_list($limit = 16, $offset = 0) {
        $obj = $this->filter_param();
        $filter = (!empty($obj)) ? $obj : null;
        #generate pagination
        if ($this->uri->segment(3) == 'view') {
            $base_url = self::$CURRENT_CONTEXT . '/view/' . $this->uri->segment(4);
            $uri = 5;
        } else {
            $base_url = self::$CURRENT_CONTEXT . '/index/';
            $uri = 4;
        }
        // echo 'LOLOS'; die();
        $config['base_url'] = site_url($base_url);
        $config['total_rows'] = $this->myfleet_dao->count_table_fetch($filter);
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri;

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['offset'] = $offset;
        $this->fetch_data($limit , $offset, $filter);
	}

	/*     * role and permission* */

	private function fetch_data($limit, $offset, $filter=null) {
		$this->data['myfleets'] = $this->myfleet_dao->table_fetch($limit, $offset, $filter);
	}

	/**
	  getting filter parameter when user
	  doing searching.
	 */
	public function filter_param() {
		$filter = array();
		/* komen sementara by SKM17
		$par = $this->input->post('sample');
		if ($par != NULL || $par != '') {
			$filter['sample'] = $par;
		}
		*/
		// other input receive
		return $filter;
	}

	/**

	  @description
	  viewing record. repopulation for every data needed for view.
	 */
	public function view($mmsi = null) {
		$this->preload();
		if ($mmsi == null) {
			$this->load_view('admin/myfleet/list_myfleet');
		} else {
			$this->get_list($this->limit);
			$obj_id = array('mf_mmsi' => $mmsi);

			$to_edit = $this->myfleet_dao->by_id($obj_id);
			$this->data['obj'] = $to_edit;
			$this->load_view('admin/myfleet/list_myfleet', $this->data);
		}
	}

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
