<?php

class areal_report_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 16;
    public static $CURRENT_CONTEXT = '/admin/areal_report_ctrl';
    public static $TITLE = "Laporan Situasi";

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('geodesics');
        $this->load->helper('acl');
        $this->load->library('dao/areal_report_dao');
        $this->load->library('dao/violation_type_dao');
        $this->load->library('dao/report_type_dao');
        $this->load->library('dao/user_role_dao');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
        $this->load->library('pagination');
        $this->load->library('tank_auth');

        $this->logged_in();
        $this->role_user();
        $this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
    }

    private function validate() {
//        $this->form_validation->set_rules('ar_id', 'ar_id', 'required');
        $this->form_validation->set_rules('user_id', 'user_id', '');
        $this->form_validation->set_rules('vt_id', 'vt_id', 'required');
        $this->form_validation->set_rules('rt_id', 'rt_id', 'required');
        $this->form_validation->set_rules('ar_date', 'ar_date', '');
        $this->form_validation->set_rules('ar_time', 'ar_time', '');
        $this->form_validation->set_rules('ar_title', 'ar_title', '');
        $this->form_validation->set_rules('ar_content', '', '');
        $this->form_validation->set_rules('ar_lat', 'ar_lat', '');
        $this->form_validation->set_rules('ar_lon', 'ar_lon', '');
        $this->form_validation->set_rules('ar_posting_timestamp', '', '');

        return $this->form_validation->run();
    }

    /**
      prepare data for view
     */
    public function preload() {
        $this->data['current_context'] = self::$CURRENT_CONTEXT;
        $this->data['title'] = self::$TITLE;
    }

    public function load_view($page, $data = null) {
        $this->load->view('template/template_header', $data);
        $this->load->view('template/template_menu', $this->data);
        $this->load->view($page);
        $this->load->view('template/template_footer');
    }

    public function index($offset = 0) {
        $this->preload();
        $this->get_list($this->limit, $offset);
        $this->load_view('admin/areal_report/list_areal_report', $this->data);
    }

    public function fetch_record($keys) {
        $this->data['areal_report'] = $this->areal_report_dao->by_id($keys);
    }

    private function fetch_data($limit, $offset, $filter = null) {
        $this->data['violation_type'] = $this->violation_type_dao->fetch($limit, $offset, 'vt_id', null, 'ASC');
        $this->data['report_type'] = $this->report_type_dao->fetch($limit, $offset, 'rt_id', null, 'ASC');
        $this->data['violation_type'] = $this->violation_type_dao->fetch($limit, $offset, 'vt_id', null, 'ASC');
        $this->data['report_type'] = $this->report_type_dao->fetch($limit, $offset, 'rt_id', null, 'ASC');
        $this->data['areal_report'] = $this->areal_report_dao->table_fetch($limit, $offset, $filter);
    }

    private function getValue($inputid) {
        return $this->input->post($inputid) == '' ? 0 : (float) $this->input->post($inputid);
    }

    private function fetch_input() {
        if ($this->input->post('ar_id')) {
            $data['ar_id'] = $this->input->post('ar_id');
        }

        $data['user_id'] = $this->session->userdata('user_id');
        $data['vt_id'] = $this->input->post('vt_id');
        $data['rt_id'] = $this->input->post('rt_id');
        $data['ar_title'] = $this->input->post('ar_title');
        $data['ar_content'] = $this->input->post('ar_content');
        $data['ar_lat'] = toGeoDec($this->getValue('ar_dlat'), $this->getValue('ar_mlat'), $this->getValue('ar_slat'), $this->getValue('ar_rlat'));
        $data['ar_lon'] = toGeoDec($this->getValue('ar_dlon'), $this->getValue('ar_mlon'), $this->getValue('ar_slon'), $this->getValue('ar_rlon'));
        $data['ar_posting_timestamp'] = date('Y-m-d H:i:s');
        $data['ar_reporter'] = $this->input->post('ar_reporter');

        $date = $this->input->post('ar_date');
        if (strlen($date) > 0)
            $data['ar_date'] = $date;

        $time = $this->input->post('ar_time');
        if (strlen($time) > 0)
            $data['ar_time'] = $time;

        return $data;
    }

    public function save() {
        $obj = $this->fetch_input();

        if ($this->validate() != false) {

            if (isset($obj['ar_id']) && $this->areal_report_dao->by_id(array('ar_id' => $obj['ar_id'])) != null) {
                $obj_id = array('ar_id' => $obj['ar_id']);
                $this->areal_report_dao->update($obj, $obj_id);
            } else {
                $this->areal_report_dao->insert($obj);
            }
            $this->data['saving'] = true;
            if ($this->input->post('frontend_input')) {
                redirect('map');
            } else {
                redirect(self::$CURRENT_CONTEXT);
            }
        } else {
            /* invalid input will be redirected to edit view with error message included */
            $this->preload();
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/areal_report/list_areal_report', $this->data);
        }
    }

    /**
      repopulation for reference data done here.
      add different reference data to different array.
      and pass it to views using $this->data[] parameter.
     */
    public function repopulate() {
        
    }

    /**

      @description
      viewing editing form. repopulation for every data needed in form done here.
     */
    public function edit($ar_id = null) {
        $this->preload();
        if ($ar_id == null) {
            $this->load_view('admin/areal_report/list_areal_report');
        } else {

            $this->get_list($this->limit);
            $obj_id = array('ar_id' => $ar_id);

            $to_edit = $this->areal_report_dao->by_id($obj_id);


            $this->data['obj'] = $to_edit;
            $this->load_view('admin/areal_report/list_areal_report', $this->data);
        }
    }

    /**

      @description
      viewing record. repopulation for every data needed for view.
     */
    public function view($ar_id = null) {
        $obj_id = array('ar_id' => $ar_id);

        $this->preload();
        $this->fetch_record($obj_id);
        #prepare link for back to view list
        $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
        $this->load_view('admin/areal_report/view_areal_report', $this->data);
    }

    public function delete($ar_id = null) {
        $obj_id = array('ar_id' => $ar_id);

        $status_del = $this->areal_report_dao->delete($obj_id);
        if ($status_del == false) {
            $this->session->set_flashdata("info", "Delete failed!");
        } else {
            $this->session->set_flashdata("info", "Delete succeed !");
        }
        redirect(self::$CURRENT_CONTEXT);
    }

    /**
      getting filter parameter when user
      doing searching.
     */
    public function filter_param() {
        $filter = array();
        if (isset($_GET['filter'])) {
            $filter['ar_date_start'] = $this->input->get('ar_date_start');
            $filter['ar_date_end'] = $this->input->get('ar_date_end');
            $filter['vt_id'] = $this->input->get('vt_id');
            $filter['rt_id'] = $this->input->get('rt_id');
        }
        // other input receive
        return $filter;
    }

    public function get_list($limit = 16, $offset = 0) {
        $obj = $this->filter_param();
        $filter = (!empty($obj)) ? $obj : null;
        #generate pagination
        $config['base_url'] = site_url(self::$CURRENT_CONTEXT . '/index');
        $config['total_rows'] = $this->areal_report_dao->count_table_fetch($filter);
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;
        $config['filter_param'] = $_SERVER['QUERY_STRING'];
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->fetch_data($limit, $offset, $filter);
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