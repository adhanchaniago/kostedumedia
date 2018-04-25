<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Html extends CI_Controller {

	public $data;
	private $role;

	function __construct() {
		parent::__construct();
		$this->load->helper('acl');
		$this->load->helper('url');
		$this->load->helper('string');
		$this->load->library('session');
		$this->load->library('tank_auth');
		$this->load->database();
		$this->load->library('dao/user_role_dao');
		$this->load->library('dao/role_dao');
		$this->logged_in();
	}
	
	function logged_in() {
		if (!$this->tank_auth->is_logged_in()) {
			// $this->map_clean();
		}
	}

	public function index() {

		$this->load->view('html/side-menu');
	}

	public function operasi() {
		$this->load->view('html/form-operasi');
	}

	public function lapsithar() {
		$this->load->view('html/lapsithar');
	}

	public function map_clean() {
		$this->role_user();
		$this->load->view('html/map_clean',$this->data);
	}
	
	/**role and permission**/
	private function role_user(){
		$user_id = $this->tank_auth->get_user_id();
		
		if ($user_id) {
			$user = $this->user_role_dao->fetch_record($user_id);
			$this->role = $this->role_dao->by_id(array('role_id'=>$user->role_id));

			// added by SKM17 for checking backend access {
			$permission = all_permission_string($user_id); 
			if (is_has_access('backend', $permission)) { 
				$user->backend_access = true;
			} else { 
				$user->backend_access = false;
			}
			$user->user_group = get_data_restriction($this->session->userdata(SESSION_USERGROUP));
			// } end ADDED */
			
			$this->data['user'] = $user;
			$this->data['permission'] = $permission;
		} else
			$this->data['permission'] = '';
	}

	public function backend() {
		$this->load->view('html/back-end');
	}

	public function dashboard() {
		$this->load->view('html/dashboard');
	}

	public function justmaps() {
		$this->load->view('html/justmaps');
	}

	public function pdfgenerator() {
		$this->load->view('html/pdf-generator');
	}

	public function perintahmalam() {
		$this->load->view('html/pdf-perintah-malam');
	}

	public function pdfperintahmalam() {
		$this->load->helper('dompdf');

		$html = $this->load->view('html/pdf-perintah-malam', '', true);
		pdf_create($html, "Perintah Malam");
	}

	public function laporansiaga() {
		$this->load->view('html/pdf-laporan-siaga');
	}

	public function pdflaporansiaga() {
		$this->load->helper('dompdf');

		$html = $this->load->view('html/pdf-laporan-siaga', '', true);
		pdf_create($html, "Laporan Siaga");
	}

	public function lampiranlaporansiaga() {
		$this->load->view('html/pdf-lampiran-laporan-siaga');
	}

	public function pdflampiranlaporansiaga() {
		$this->load->helper('dompdf');

		$html = $this->load->view('html/pdf-lampiran-laporan-siaga', '', true);
		pdf_create($html, "Lampiran Laporan Siaga");
	}

	public function dislokasiKRI() {
		$this->load->helper('dompdf');
		$this->load->library('dao/ship_dao');
		$ships = $this->ship_dao->table_fetch();
		$this->data['ships'] = $ships;
		$html = $this->load->view('html/dislokasi-KRI', $this->data, true);
		pdf_create($html, "Dislokasi Kapal");
	}

	public function dislokasiPESUD() {
		$this->load->helper('dompdf');
		$this->load->library('dao/aeroplane_dao');
		$aeroplanes = $this->aeroplane_dao->table_fetch();
		$this->data['aeroplanes'] = $aeroplanes;
		$html = $this->load->view('html/dislokasi-PESUD', $this->data, true);
		pdf_create($html, "Dislokasi Pesawat");
	}

	public function dislokasiMARINIR() {
		$this->load->helper('dompdf');
		$this->load->library('dao/marines_dao');
		$marines = $this->marines_dao->table_fetch();
		$this->data['marines'] = $marines;
		$html = $this->load->view('html/dislokasi-MARINIR', $this->data, true);
		pdf_create($html, "Dislokasi Marinir");
	}

	public function pdflaporandislokasi() {
		$this->load->helper('dompdf');

		$html = $this->load->view('html/pdf-laporan-dislokasi', '', true);
		pdf_create($html, "Laporan Dislokasi");
	}

	public function laporanhariankesiapankal() {
		$this->load->view('html/pdf-laporan-harian-kesiapan-kal');
	}

	public function pdflaporanhariankesiapankal() {
		$this->load->helper('dompdf');

		$html = $this->load->view('html/pdf-laporan-harian-kesiapan-kal', '', true);
		pdf_create($html, "Laporan Harian Kesiapan KAL");
	}

	public function laporanhariankesiapankri() {
		$this->load->view('html/pdf-laporan-harian-kesiapan-kri');
	}

	public function pdflaporanhariankesiapankri() {
		$this->load->helper('dompdf');

		$html = $this->load->view('html/pdf-laporan-harian-kesiapan-kri', '', true);
		pdf_create($html, "Laporan Harian Kesiapan KRI");
	}

	public function laporanhariankesiapanpesud() {
		$this->load->view('html/pdf-laporan-harian-kesiapan-pesud');
	}

	public function pdflaporanhariankesiapanpesud() {
		$this->load->helper('dompdf');

		$html = $this->load->view('html/pdf-laporan-harian-kesiapan-pesud', '', true);
		pdf_create($html, "Laporan Harian Kesiapan PESUD");
	}

	public function laporanhariankesiapanranpurmarinir() {
		$this->load->view('html/pdf-laporan-harian-kesiapan-ranpur-marinir');
	}

	public function pdflaporanhariankesiapanranpurmarinir() {
		$this->load->helper('dompdf');

		$html = $this->load->view('html/pdf-laporan-harian-kesiapan-ranpur-marinir', '', true);
		pdf_create($html, "Laporan Harian Kesiapan RANPUR MARINIR");
	}

}
