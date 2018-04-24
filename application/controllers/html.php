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
        // print_r($this->role); exit();
        $map_url = $this->config->item('map_url');
        if(!is_null($this->role->role_mapurl) && $this->role->role_mapurl != '' ){
            $map_url = $this->role->role_mapurl;
        }

        $this->data['map_url'] = $map_url;
		// $this->data['marker_category'] = $this->db->query("SELECT * FROM generic_marker_category ORDER BY gmarkcat_id ASC")->result();
        // $this->data['ship_types'] = json_encode($this->db->query("SELECT shiptype_id AS id, shiptype_icon AS file FROM ship_type")->result());
        
        //TODO running text di non aktifkan untuk keperluan running di database lokal, nyalain lagi kalau udah beres
        // $obj_run_text = $this->db->query("SELECT * FROM running_text WHERE status = 'on'")->result();
        // if($obj_run_text != null){
        //    $date = new DateTime($obj_run_text[0]->datetime);                
        //    $this->data['running_text'] = $obj_run_text[0]->status_desc;
        //    // $this->data['running_text'] = $obj_run_text[0]->day.", ".$date->format('d-m-Y H:i:s').": ".$obj_run_text[0]->status_desc;

        //    // kl jd current day
        //    //  $dayNames = array(                      
        //    //      0=>'Senin', 
        //    //      1=>'Selasa', 
        //    //      2=>'Rabu', 
        //    //      3=>'Kamis', 
        //    //      4=>'Jumat', 
        //    //      5=>'Sabtu', 
        //    //      6=>'Minggu'
        //    //   );
        //    //  $day_of_week = date('N', strtotime(date("l")));

        //    // $date = new DateTime();
        //    // $this->data['running_text'] = $dayNames[$day_of_week-1].", ".$date->format('d-m-Y H:i:s').": ".$obj_run_text[0]->status_desc;
        // } else
        //     $this->data['running_text'] = '';

        // Get status for displaying kri's hull number
        // $obj_kri_numb_display = $this->db->query("SELECT value FROM setting WHERE id_param = 2")->result();
        // $this->data['display_kri_number'] = $obj_kri_numb_display[0]->value;

        // // Get status for displaying pesud's hull number
        // $obj_pesud_numb_display = $this->db->query("SELECT value FROM setting WHERE id_param = 3")->result();
        // $this->data['display_pesud_number'] = $obj_pesud_numb_display[0]->value;

        // // Get status for displaying myfleet
        // $obj_myfleet_display = $this->db->query("SELECT value FROM setting WHERE id_param = 4")->result();
        // $this->data['display_myfleet'] = $obj_myfleet_display[0]->value;

        $this->load->view('html/map_clean',$this->data);
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
    
    /**role and permission**/
    private function role_user(){
        $user_id = $this->tank_auth->get_user_id();
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
    }
    
    function logged_in() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('home/login');
        }
    }

}
