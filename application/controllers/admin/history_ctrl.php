<?php
class history_ctrl extends CI_Controller{

	public $data;
	public $filter;
	public $limit = 16;
	public static $CURRENT_CONTEXT = '/admin/history_ctrl';
	public static $TITLE = "HISTORY PENGHUNI";

	public function __construct(){
		parent::__construct();
		$this->data = array();
		$this->load->helper('string');
		$this->load->helper('url');
		$this->load->helper('file');
		$this->load->helper('stringify');
		// $this->load->helper('acl');
		$this->load->helper('geodesics');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
		$this->load->library('pagination'); // GA KEPAKE
		$this->load->library('tank_auth');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->library('dao/hist_penghuni_dao');

		$this->logged_in();
		$this->role_user();

		$this->data['user_id'] = $this->session->userdata('user_id');
	}

	public function index($offset=0 ,$limit=16){
		$this->preload();
		$this->load_view('admin/list_hist_penghuni', $this->data);
	}

	public function preload(){
		$this->data['current_context'] = self::$CURRENT_CONTEXT;
		$this->data['title'] = self::$TITLE;

		$this->data['hists'] = $this->hist_penghuni_dao->getDaftarHistPenghuni();
		$this->data['hist'] = null;
	}

	public function load_view($page, $data = null){
		$this->load->view('template/template_header',$data);
		$this->load->view('template/template_menu',$this->data);
		$this->load->view($page, $data);
		$this->load->view('template/template_footer');
	}

	public function view($id_history = null) {
		$this->preload();
		if ($id_history == null) {
			$this->load_view('admin/list_hist_penghuni');
		} 
		else {
			$this->data['hist'] = $this->hist_penghuni_dao->getDataHistPenghuni($id_history);
			$this->load_view('admin/list_hist_penghuni', $this->data);
		}
	}

	function role_user() {
		$user_id = $this->tank_auth->get_user_id();
		// $user = $this->user_role_dao->fetch_record($user_id);
		$this->data['permission'] = 'admin';

		// if (trim($user->role_name) == 'viewer') {
		// 	redirect('html/map_clean');
		// }
	}
	
	function logged_in() {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('home/login');
		}
	}
}