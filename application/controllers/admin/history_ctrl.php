<?php
class history_ctrl extends CI_Controller{

	public $data;
	public $filter;
	public $limit = 16;
	public static $CURRENT_CONTEXT = '/admin/history_ctrl';
	public static $TITLE = "HISTORY";

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
		// $this->load->library('dao/poi_dao');  // GA KEPAKE
		// $this->load->library('dao/operation_dao');  // GA KEPAKE
		// $this->load->library('dao/aoipoi_type_dao');  // GA KEPAKE
		// $this->load->library('dao/user_role_dao');  // GA KEPAKE
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
		$this->load->library('pagination'); // GA KEPAKE
		$this->load->library('tank_auth');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->model('Kosts','',TRUE);

		$this->logged_in();
		$this->role_user();
		// $this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
		// $this->data['idAccessMsg'] = $this->session->userdata(SESSION_USERMSGID);
		// $this->data['user_id'] = '5ae977774b77e8711e0c4e92';
		// $this->data['user_id'] = '5ae039b33e0b2a360b304585'; // p ddg
		$this->data['user_id'] = $this->session->userdata('user_id');
	}

	public function index($offset=0 ,$limit=16){
		$this->preload();
		$this->load_view('admin/kost/history', $this->data);
	}

	public function preload(){
		$this->data['current_context'] = self::$CURRENT_CONTEXT;
		$this->data['title'] = self::$TITLE;

		$this->data['obj'] = null;
		$this->data['kosts'] = $this->Kosts->getDaftarKosan($this->data['user_id']);
	}

	public function load_view($page, $data = null){
		$this->load->view('template/template_header',$data);
		$this->load->view('template/template_menu',$this->data);
		$this->load->view($page, $data);
		$this->load->view('template/template_footer');
	}

	public function edit($kosan_judul = null){
		$this->preload();
		if ($kosan_judul == null) {
			$this->load_view('admin/kost/list_kost');
		} else {
			$this->data['obj'] = $this->Kosts->getInfoKosan($this->data['user_id'], urldecode($kosan_judul));
			$this->load_view('admin/kost/list_kost', $this->data);
		}
	}

	private function fetch_input(){
		$data = array(
			'type' => "Feature",
			'properties' => array(
				'judul' => $this->input->post('judul_kosan'),
				'desc' => $this->input->post('alamat_kosan'),
				'kamar' => $this->get_list_kamar()
			)
		);
		return $data;
	}

	private function get_list_kamar() {
		$totalRow = $this->input->post('totalRowKmr');

		$listkamar = array();
		for ($i = 1; $i <= $totalRow; $i++) {
			$namakamar = $this->input->post('kmr_' . $i);
			$terisi = $this->input->post('filledKmr_' . $i);
			array_push($listkamar, array('nama' => $namakamar, 'terisi' => $terisi));
		}
		return $listkamar;
	}

	public function add_kosan() {
		$infoSession = ''; // added by SKM17

		$obj = $this->fetch_input();
		$id_user = $this->input->post('user_id');
		$kosan_judul = $this->input->post('kosan_judul');
		$this->Kosts->saveNewKosan($id_user, $obj);
		$infoSession .= "Data Kosan berhasil ditambah. ";

		$this->session->set_flashdata("info", $infoSession);
		redirect(self::$CURRENT_CONTEXT);
	}

	public function edit_kosan() {
		$infoSession = ''; // added by SKM17

		$obj = $this->fetch_input();
		$id_user = $this->input->post('user_id');
		$kosan_judul = $this->input->post('kosan_judul');
		$this->Kosts->editKosan($id_user, $kosan_judul, $obj);
		$infoSession .= "Data Kosan berhasil diubah. ";

		$this->session->set_flashdata("info", $infoSession);
		redirect(self::$CURRENT_CONTEXT);
	}

	public function delete($kosan_judul = null){
		$id_user = $this->data['user_id'];
		$this->Kosts->deleteKosan($id_user, urldecode($kosan_judul));
		$this->session->set_flashdata("info", "Hapus Data Kosan berhasil!");

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