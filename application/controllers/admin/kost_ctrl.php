<?php
class kost_ctrl extends CI_Controller{

	public $data;
	public $filter;
	public $limit = 16;
	public static $CURRENT_CONTEXT = '/admin/kost_ctrl';
	public static $TITLE = "KOST";

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
		$this->load->library('dao/kosan_dao');
		$this->load->library('dao/kamar_dao');
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
		$this->load_view('admin/list_kost', $this->data);
	}

	public function preload(){
		$this->data['current_context'] = self::$CURRENT_CONTEXT;
		$this->data['title'] = self::$TITLE;

		$this->data['obj'] = null;
		$this->data['kamars'] = null;
		$this->data['objkamar'] = null;
		// $this->data['kosts'] = $this->Kosts->getDaftarKosan($this->data['user_id']);
		$this->data['kosts'] = $this->kosan_dao->getDaftarKosan($this->data['user_id']);
		// $this->data['kosts'] = $this->kosan_dao->getDaftarKosan(1);
	}

	public function load_view($page, $data = null){
		$this->load->view('template/template_header',$data);
		$this->load->view('template/template_menu',$this->data);
		$this->load->view($page, $data);
		$this->load->view('template/template_footer');
	}

	public function edit($id_kosan, $id_kamar = null){
		$this->preload();

		if ($id_kosan == null) {
			$this->load_view('admin/list_kost');
		} else {
			// $this->data['obj'] = $this->Kosts->getInfoKosan($this->data['user_id'], urldecode($kosan_judul));
			$this->data['obj'] = $this->kosan_dao->getInfoKosan($id_kosan);
			$this->data['kamars'] = $this->kamar_dao->getDaftarKamar($id_kosan);
			$this->session->set_userdata('user_url', self::$CURRENT_CONTEXT . '/edit/' . $id_kosan);
			if ($id_kamar)
				$this->data['objkamar'] = $this->kamar_dao->getInfoKamar($id_kamar);
			
			$this->load_view('admin/list_kost', $this->data);
		}
	}

	private function fetch_input(){
		// $data = array(
		// 	'type' => "Feature",
		// 	'properties' => array(
		// 		'judul' => $this->input->post('judul_kosan'),
		// 		'desc' => $this->input->post('alamat_kosan'),
		// 		'kamar' => $this->get_list_kamar()
		// 	)
		// );
		// return $data;

		$data = null;
		$data = array(
			'nama_kosan' => $this->input->post('judul_kosan'),
			'alamat' => $this->input->post('alamat_kosan'),
			'deskripsi' => $this->input->post('desk_kosan'),
			'fasum' => $this->input->post('fasum'),
			'deskripsilokasi' => $this->input->post('desk_lokasi'),
			'lokasi' => $this->input->post('lokasi'),
			'kamarmandi' => $this->input->post('kamarmandi'),
			'kontak' => $this->input->post('kontak')
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
		$obj['id_pengguna'] = $this->input->post('user_id');
		
		if ($this->kosan_dao->saveNewKosan($obj))
			$infoSession .= "Kosan baru berhasil disimpan. ";
		else
			$infoSession .= "<font color='red'>Kosan baru gagal disimpan. </font>";

		$this->session->set_flashdata("info", $infoSession);
		redirect($this->session->userdata('user_url'));
	}

	public function edit_kosan() {
		$infoSession = ''; // added by SKM17

		$obj = $this->fetch_input();
		// $id_user = $this->input->post('user_id');
		$id_kosan = $this->input->post('id_kosan');
		// $kosan_judul = $this->input->post('kosan_judul');
		// $this->Kosts->editKosan($id_user, $kosan_judul, $obj);
		if ($this->kosan_dao->editKosan($id_kosan, $obj))
			$infoSession .= "Data Kosan berhasil diubah. ";
		else
			$infoSession .= "<font color='red'>Data Kosan gagal diubah. </font>";

		$this->session->set_flashdata("info", $infoSession);
		redirect(self::$CURRENT_CONTEXT);
	}

	public function delete($kosan_judul = null){
		$id_user = $this->data['user_id'];
		$this->Kosts->deleteKosan($id_user, urldecode($kosan_judul));
		$this->session->set_flashdata("info", "Hapus Data Kosan berhasil!");

		redirect(self::$CURRENT_CONTEXT);
	}

	private function fetch_input_kamar(){
		$data = null;
		$data = array(
			'nama_kamar' => $this->input->post('nama_kmr'),
			'luas' => $this->input->post('luas_kmr'),
			'fasilitas' => $this->input->post('fasilitas_kmr'),
			'hargath' => $this->input->post('harga_kmr'),
			'terisi' => $this->input->post('terisi_kmr')
		);

		return $data;
	}

	public function add_kamar() {
		$infoSession = ''; // added by SKM17

		$objkamar = $this->fetch_input_kamar();
		$objkamar['id_kosan'] = $this->input->post('id_kosan');

		if ($this->kamar_dao->saveNewKamar($objkamar))
			$infoSession .= "Kamar baru berhasil disimpan. ";
		else
			$infoSession .= "<font color='red'>Kamar baru gagal disimpan. </font>";

		$this->session->set_flashdata("info", $infoSession);
		redirect($this->session->userdata('user_url'));
	}

	public function edit_kamar() {
		$infoSession = ''; // added by SKM17

		$objkamar = $this->fetch_input_kamar();
		$id_kamar = $this->input->post('id_kamar');
		
		if ($this->kamar_dao->editKamar($id_kamar, $objkamar))
			$infoSession .= "Data Kamar berhasil diubah. ";
		else
			$infoSession .= "<font color='red'>Data Kamar gagal diubah. </font>";

		$this->session->set_flashdata("info", $infoSession);
		redirect($this->session->userdata('user_url'));
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