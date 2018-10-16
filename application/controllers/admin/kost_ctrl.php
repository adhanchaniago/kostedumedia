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
		$this->load->helper('geodesics');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
		$this->load->library('pagination'); // GA KEPAKE
		$this->load->library('tank_auth');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->library('dao/kosan_dao');
		$this->load->library('dao/kamar_dao');
		$this->load->library('dao/penghuni_dao');
		$this->load->library('dao/hist_penghuni_dao');
		$this->load->library('dao/daftar_agama_dao');
		// $this->load->model('Kosts','',TRUE);

		$this->logged_in();
		$this->role_user();

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
			$this->data['obj'] = $this->kosan_dao->getInfoKosan($id_kosan);
			$this->data['kamars'] = $this->kamar_dao->getDaftarKamar($id_kosan);
			$this->session->set_userdata('user_url', self::$CURRENT_CONTEXT . '/edit/' . $id_kosan);
			if ($id_kamar) {
				$this->data['agama'] = $this->daftar_agama_dao->getDaftar();
				$this->data['objkamar'] = $this->kamar_dao->getInfoKamar($id_kamar);
				$this->data['penghuni'] = $this->penghuni_dao->getPenghuni($this->data['objkamar']->id_penghuni);
			}

			$this->load_view('admin/list_kost', $this->data);
		}
	}

	private function fetch_input(){
		$data = null;
		$data = array(
			'nama_kosan' => $this->input->post('judul_kosan'),
			'alamat' => $this->input->post('alamat_kosan'),
			'deskripsi' => $this->input->post('desk_kosan'),
			'fasum' => $this->input->post('fasum'),
			'deskripsilokasi' => $this->input->post('desk_lokasi'),
			'lokasi' => $this->input->post('lokasi'),
			'kamarmandi' => $this->input->post('kamarmandi'),
			'kontak' => $this->input->post('kontak'),
			'lat' => $this->input->post('lat'),
			'lon' => $this->input->post('lon')
		);

		return $data;
	}

	public function add_kosan() {
		$obj = $this->fetch_input();
		$obj['id_pengguna'] = $this->input->post('user_id');
		
		if ($this->kosan_dao->saveNewKosan($obj))
			$this->session->set_flashdata("success", "Kosan baru berhasil disimpan.");
		else
			$this->session->set_flashdata("failed", "Kosan baru gagal disimpan.");

		redirect($this->session->userdata('user_url'));
	}

	public function edit_kosan() {
		$obj = $this->fetch_input();
		$id_kosan = $this->input->post('id_kosan');

		if ($this->kosan_dao->editKosan($id_kosan, $obj))
			$this->session->set_flashdata("success", "Data Kosan berhasil diubah.");
		else
			$this->session->set_flashdata("failed", "Data Kosan gagal diubah.");

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
			'hargath' => $this->input->post('harga_kmr')
		);

		return $data;
	}

	public function add_kamar() {
		$objkamar = $this->fetch_input_kamar();
		$objkamar['id_kosan'] = $this->input->post('id_kosan');

		if ($this->kamar_dao->saveNewKamar($objkamar))
			$this->session->set_flashdata("success", "Kamar baru berhasil disimpan.");
		else
			$this->session->set_flashdata("failed", "Kamar baru gagal disimpan.");

		redirect($this->session->userdata('user_url'));
	}

	public function edit_kamar() {
		$objkamar = $this->fetch_input_kamar();
		$id_kamar = $this->input->post('id_kamar');
		
		if ($this->kamar_dao->editKamar($id_kamar, $objkamar))
			$this->session->set_flashdata("success", "Data Kamar berhasil diubah.");
		else
			$this->session->set_flashdata("failed", "Data Kamar gagal diubah.");

		redirect($this->session->userdata('user_url'));
	}

	private function fetch_input_penghuni(){
		$data = null;
		$data = array(
			'nama_penghuni' => $this->input->post('nama_penghuni'),
			'ttl' => $this->input->post('ttl'),
			'gender' => $this->input->post('gender'),
			'agama' => $this->input->post('agama'),
			'no_ktp' => $this->input->post('noktp'),
			'alamat' => $this->input->post('alamat'),
			'hp' => $this->input->post('hp'),
			'hp2' => $this->input->post('hp2'),
			'jurusan' => $this->input->post('jurusan'),
			'fakultas' => $this->input->post('fakultas'),
			'nim' => $this->input->post('nim'),
			'tglmasuk' => $this->input->post('tglmasuk'),
			'ket_ayah' => $this->input->post('ket_ayah'),
			'ket_ibu' => $this->input->post('ket_ibu'),
			'hpdarurat' => $this->input->post('hpdarurat'),
			'pembayaran' => $this->input->post('pembayaran'),
			'sisa_pelunasan' => $this->input->post('sisa_pelunasan'),
			'email' => $this->input->post('email'),
			'fb' => $this->input->post('fb'),
			'twitter' => $this->input->post('twitter'),
			'bbm' => $this->input->post('bbm'),
			'ig' => $this->input->post('ig')
		);

		return $data;
	}

	public function add_penghuni() {
		$objpenghuni = $this->fetch_input_penghuni();

		$gen_id_penghuni = $this->penghuni_dao->saveNewPenghuni($objpenghuni);

		if ($gen_id_penghuni) {
			$this->kamar_dao->setPenghuni($this->input->post('id_kamar'), $gen_id_penghuni);
			$this->session->set_flashdata("success", "Penghuni baru berhasil disimpan.");
		}
		else
			$this->session->set_flashdata("failed", "Penghuni baru gagal disimpan.");

		redirect($this->session->userdata('user_url'));
	}

	public function edit_penghuni() {
		$objpenghuni = $this->fetch_input_penghuni();
		$id_penghuni = $this->input->post('id_penghuni');
		
		if ($this->penghuni_dao->editPenghuni($id_penghuni, $objpenghuni))
			$this->session->set_flashdata("success", "Data Penghuni berhasil diubah.");
		else
			$this->session->set_flashdata("failed", "Data Penghuni gagal diubah.");

		redirect($this->session->userdata('user_url'));
	}

	public function del_penghuni($id_penghuni) {
		$objpenghuni = $this->penghuni_dao->getCompletePenghuni($id_penghuni);
		$id_penghuni = $objpenghuni->id_penghuni;
		$id_kamar = $objpenghuni->id_kamar;
		$objpenghuni['tglkeluar'] = date('Y-m-d'); 

		if ($this->hist_penghuni_dao->saveNewHistPenghuni($objpenghuni)) { // delete dr tabel penghuni
			$this->kamar_dao->setPenghuni($id_kamar, 0);
			$this->penghuni_dao->deletePenghuni($id_penghuni);
			$this->session->set_flashdata("success", "Penghuni berhasil dipindahkan ke history penghuni.");
		}
		else
			$this->session->set_flashdata("failed", "Penghuni gagal dipindahkan ke history penghuni.");

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