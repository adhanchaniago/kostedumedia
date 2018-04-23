<?php

/**
 * @author Wira Sakti G
 * @added Oct 11, 2013
 */
class reporting_ctrl extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('string');
        $this->load->helper('acl');
        //dao list
        $this->load->library('dao/ship_dao');
        $this->load->library('dao/aeroplane_dao');
        $this->load->library('dao/user_role_dao');
        $this->load->library('tank_auth');

        $this->logged_in();
        $this->role_user();
        $this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
    }

    public function index() {
        $this->load->view('template/template_header');
        $this->load->view('template/template_menu', $this->data);
        $this->load->view('admin/reporting/list_report');
        $this->load->view('template/template_footer');
    }

    public function pdflaporanhariankesiapankal() {
        $this->load->helper('dompdf');

        $html = $this->load->view('admin/reporting/pdf-laporan-harian-kesiapan-kal', '', true);
        pdf_create($html, "Laporan Harian Kesiapan KAL");
    }

    public function pdflaporanhariankesiapankri() {
        $this->load->helper('dompdf');

        $this->data['ships'] = $this->ship_dao->table_fetch();

        $html = $this->load->view('admin/reporting/pdf-laporan-harian-kesiapan-kri', $this->data, true);
        pdf_create($html, "Laporan Harian Kesiapan KRI");
    }

    public function pdflaporanhariankesiapanpesud() {
        $this->load->helper('dompdf');

        $this->data['aeroplane'] = $this->aeroplane_dao->table_fetch();

        $html = $this->load->view('admin/reporting/pdf-laporan-harian-kesiapan-pesud', $this->data, true);
        pdf_create($html, "Laporan Harian Kesiapan PESUD");
    }

    public function pdflaporanhariankesiapanranpurmarinir() {
        $this->load->helper('dompdf');

        $html = $this->load->view('admin/reporting/pdf-laporan-harian-kesiapan-ranpur-marinir', '', true);
        pdf_create($html, "Laporan Harian Kesiapan RANPUR MARINIR");
    }

    public function pdfperintahmalam() {
        $this->load->helper('dompdf');

        $html = $this->load->view('admin/reporting/pdf-perintah-malam', '', true);
        pdf_create($html, "Perintah Malam");
    }

    public function pdflaporansiaga() {
        $this->load->helper('dompdf');

        $html = $this->load->view('admin/reporting/pdf-laporan-siaga', '', true);
        pdf_create($html, "Laporan Siaga");
    }

    public function pdflampiranlaporansiaga() {
        $this->load->helper('dompdf');

        $html = $this->load->view('admin/reporting/pdf-lampiran-laporan-siaga', '', true);
        pdf_create($html, "Lampiran Laporan Siaga");
    }

    /*     * role and permission* */

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