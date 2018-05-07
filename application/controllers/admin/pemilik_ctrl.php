<?php
class pemilik_ctrl extends CI_Controller{

	public $data;
	public $filter;
	public $limit = 16;
	public static $CURRENT_CONTEXT = '/admin/pemilik_ctrl';
	public static $TITLE = "PEMILIK";

	public function __construct(){
		parent::__construct();

		$this->load->helper('string');
		$this->load->helper('url');
		// $this->load->helper('acl');
		$this->load->library('session');
        // $this->load->library('dao/user_role_dao');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
		$this->load->library('pagination');
		$this->load->library('tank_auth');
		$this->load->model('Kosts','',TRUE);

		$this->data = array();
		$this->logged_in();
		$this->role_user();
		// $this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
		// $this->data['idAccessMsg'] = $this->session->userdata(SESSION_USERMSGID);
		// $this->data['user_id'] = '5ae977774b77e8711e0c4e92';
		// $this->data['user_id'] = '5ae039b33e0b2a360b304585'; // p ddg
		$this->data['user_id'] = $this->session->userdata('user_id');
	}

	private function validate(){
		$this->form_validation->set_rules('poi_lat', 'poi_lat', '');
		$this->form_validation->set_rules('poi_lon', 'poi_lon', '');	
		return $this->form_validation->run();
	}
	/**
		prepare data for view 
	*/
	public function preload(){
		$this->data['current_context'] = self::$CURRENT_CONTEXT;
		$this->data['title'] = self::$TITLE;
	}

	public function load_view($page, $data = null){
		$this->load->view('template/template_header',$data);
		$this->load->view('template/template_menu',$this->data);
		$this->load->view($page, $data);
		$this->load->view('template/template_footer');
	}

	public function index($offset=0 ,$limit=16){
		$this->preload();
		$this->data['obj'] = $this->Kosts->getUserById($this->data['user_id']);
		$this->load_view('admin/kost/pemilik_detail', $this->data);
	}

	private function fetch_input(){
		$data = array(
			'namauser' => $this->input->post('username'),
			'password' => $this->input->post('userhp'),
			'hpuser' => $this->input->post('userhp'),
			'alamatuser' => $this->input->post('useralamat')
		);
		// yg belum tinggal passnya
		return $data;
	}

	public function save() {
		$obj = $this->fetch_input();
		$id_user = $this->data['user_id'];
		$this->Kosts->editPemilik($id_user, $obj);

		$this->session->set_flashdata("info", "Data Pemilik berhasil diubah. ");
		redirect(self::$CURRENT_CONTEXT);
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