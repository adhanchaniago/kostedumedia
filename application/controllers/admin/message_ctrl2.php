<?php

class message_ctrl2 extends CI_Controller {

	public $data;
	public $filter;
	public $limit = 16;
	public static $CURRENT_CONTEXT = '/admin/message_ctrl2';
	public static $TITLE = "Pesan";
	
	public function __construct(){
		parent::__construct();
		$this->data = array();
		$this->load->helper('string');
		$this->load->helper('url');
		$this->load->helper('stringify');
		$this->load->helper('acl');
		$this->load->library('dao/message_dao');
		$this->load->library('dao/ship_dao');
		$this->load->library('dao/user_role_dao');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
		$this->load->library('pagination');
		$this->load->library('tank_auth');

		$this->logged_in();
		$this->role_user();
		$this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
		$this->data['idAccessMsg'] = $this->session->userdata(SESSION_USERMSGID);
	}

	private function validate() {
		$this->form_validation->set_rules('id_pesan', 'id_pesan', '');

		return $this->form_validation->run();
	}

	public function preload($url = '') {
		$this->data['current_context'] = self::$CURRENT_CONTEXT . '/' . $url;
		$this->data['title'] = self::$TITLE;
	}

	public function load_message_count() {
		$this->data['n_new_inbox'] = $this->message_dao->count('state', '6');
	   $this->data['n_new_draf'] = $this->message_dao->count('state', '0');
		$this->data['n_new_status'] = $this->message_dao->count('state', '5');
	}
	
	public function load_view($page, $data = null) {
		$this->load_message_count();
		$this->load->view('template/template_header', $data);
		$this->load->view('template/template_menu', $this->data);
		$this->load->view($page);
		$this->load->view('template/template_footer');
	}
	
	public function get_list($limit = 16, $offset = 0) {
	// note: hilangin filternya??
		$obj = $this->filter_param();
		$filter = (!empty($obj)) ? $obj : null;
		$filter['ship_isrealtime'] = 'true';
		#generate pagination
		if ($this->uri->segment(3)=='edit'){
			$base_url = self::$CURRENT_CONTEXT . '/edit/'.$this->uri->segment(4);
			$uri = 5;
		} else {
			$base_url = self::$CURRENT_CONTEXT . '/index/';
			$uri = 4;
		}
		$config['base_url'] = site_url($base_url);
		$config['total_rows'] = $this->ship_dao->count_table_fetch($filter);
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri;
		$config['filter_param'] = $_SERVER['QUERY_STRING'];
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		
		$this->fetch_ships($limit, $offset, $filter);  
		$this->data['offset'] = $offset;
	}

	private function fetch_ships($limit, $offset, $filter = null) {
		$this->data['ships'] = $this->ship_dao->fetch_in_ops();
	}

	public function index($offset = 0) {
		$this->preload();
		$this->get_list($this->limit, $offset);
		$this->load_view('admin/message/messages', $this->data);
	}

	public function filter_param() {
		$filter = array();
		if (isset($_GET['filter'])) {
			$filter['id_from'] = $this->input->get('id_from');
			$filter['id_to'] = $this->input->get('id_to');
			//$filter['msg'] = $this->input->get('msg');
		}

		return $filter;
	}
	
	public function view_msg($ship_id = null) {
		$this->preload();
		if ($ship_id == null) {
			$this->load_view('admin/message/messages');
		} else {
			$this->get_list($this->limit);

			$to_view = $this->message_dao->fetch_msg_thread($ship_id);
			$this->data['messages'] = $to_view;
			$this->data['ship_id'] = $ship_id;
			$this->load_view('admin/message/messages', $this->data);
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
?>
