<?php
class csv_ctrl extends CI_Controller{

	public $data;
	public $filter;
	public $limit = 16;
	public static $CURRENT_CONTEXT = '/admin/csv_ctrl';
	public static $TITLE = "CSV UPLOAD";

	public function __construct(){
		parent::__construct();

		$this->load->helper('string');
		$this->load->helper('url');
		// $this->load->helper('acl');
		$this->load->library('session');
		$this->load->library('dao/keluarga_dao');
		$this->load->library('dao/individu_dao');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
		$this->load->library('pagination');
		$this->load->library('tank_auth');
		// $this->load->model('Kosts','',TRUE);

		$this->data = array();
		$this->logged_in();
		$this->role_user();
		// $this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
		// $this->data['idAccessMsg'] = $this->session->userdata(SESSION_USERMSGID);
		// $this->data['user_id'] = '5ae977774b77e8711e0c4e92';
		// $this->data['user_id'] = '5ae039b33e0b2a360b304585'; // p ddg
		$this->data['user_id'] = $this->session->userdata('user_id');
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
		$this->load_view('admin/upload_csv', $this->data);
	}

	private function fetch_input(){
		$data = null;
		$data = array(
			'username' => $this->input->post('username'),
			'nama_lengkap' => $this->input->post('userfullname'),
			'hp' => $this->input->post('userhp'),
			'alamat' => $this->input->post('useralamat')
		);

		return $data;
	}

	public function upload() {
		// $this->load->library('upload'); // Load librari upload

		// $config['upload_path'] = './aset/csv/';
		// $config['allowed_types'] = 'csv';
		// $config['max_size']  = '2048';
		// $config['overwrite'] = true;
		// $config['file_name'] = $_FILES['csvfile']['name'];
		// echo $_FILES['csvfile']['name'];

		// $this->upload->initialize($config); // Load konfigurasi uploadnya

		// $info='';
		// if($_FILES['csvfile']['name']!='') {
		// 	 if ($this->upload->do_upload('csvfile')) {
		// 		$info = $this->upload->data();
		// 		print_r($info);

				$handle = fopen("./aset/csv/PESERTA_BPJS_0137B072.csv","r");
				$lastAddress = "";
				$lastIdKeluarga = 0;
				$objKel = null;
				$objIndiv = null;
				while (($row = fgetcsv($handle, 10000, ";")) != FALSE) //get row vales
				{
					// print_r($row); //rows in array

					// here you can manipulate the values by accessing the array
					if ($row[0] != "NO") { 
						if (trim($row[4]) == $lastAddress) { // alamat sama, tgl tambahkan individu baru
							// $objIndiv = getDataIndividu($row, $lastIdKeluarga);
						$objIndiv = null;
						$objIndiv = array(
							'nama' => $row[1],
							'kelamin' => ($row[2] == "Perempuan") ? "P" : "L",
							'ttl' => $row[3],
							'id_rumah' => $lastIdKeluarga
						);
							$this->individu_dao->saveNewIndividu($objIndiv);
						}
						else { // alamat baru
							// $objKel = getDataRumah($row);
						$objKel = null;
						$objKel = array(
							'alamat' => trim($row[4])
						);
							$this->keluarga_dao->saveNewKeluarga($objKel);
							$lastIdKeluarga = $this->keluarga_dao->insert_id();

							// $objIndiv = getDataIndividu($row, $lastIdKeluarga);
						$objIndiv = null;
						$objIndiv = array(
							'nama' => $row[1],
							'kelamin' => ($row[2] == "Perempuan") ? "P" : "L",
							'ttl' => $row[3],
							'id_rumah' => $lastIdKeluarga
						);
							$this->individu_dao->saveNewIndividu($objIndiv);
						}
					}
					$lastAddress = trim($row[4]);
				}
// 				$this->load->library('curl');
// 				$result = $this->curl->simple_get('https://nominatim.openstreetmap.org/search?format=json&q={india}');
// 				var_dump($result);
// 				// Errors
// echo 'error_code ' . $this->curl->error_code; // int
// echo 'error_string ' . $this->curl->error_string;

// // Information
// echo 'info ' . $this->curl->info; // array
		// 	} else {
		// 		$this->data['error_main_image'] = TRUE;
		// 		$this->data['msg_error_main_image'] = strip_tags($this->upload->display_errors());
		// 		echo $this->data['msg_error_main_image'];
		// 		$this->session->set_flashdata("failed", "File CSV gagal di-upload.");
		// 	 }
		// } else {
		// 	// $infoSession.="<font color='red'>Ikon Jenis Pesawat tidak diubah.</font>";
		// }
		// die();
		redirect(self::$CURRENT_CONTEXT);
	}

	function getDataRumah($row) {
		$data = null;
		$data = array(
			'alamat' => $row[4]
		);

		return $data;
	}

	function getDataIndividu($row, $id_rumah) {
		$data = null;
		$data = array(
			'nama' => $row[1],
			'kelamin' => ($row[2] == "Perempuan") ? "P" : "L",
			'ttl' => $row[3],
			'id_rumah' => $id_rumah
		);

		return $data;
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