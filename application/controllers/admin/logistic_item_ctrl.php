<?php

class logistic_item_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 16;
    public static $CURRENT_CONTEXT = '/admin/logistic_item_ctrl';
    public static $TITLE = "Kondisi Teknis Kapal";

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

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('acl');
        $this->load->library('dao/logistic_item_dao');
        $this->load->library('dao/logistic_item_category_dao', null, 'logistic_cat');
        $this->load->library('dao/logistic_item_context_dao', null, 'logistic_ctx');
        $this->load->library('dao/user_role_dao');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
        $this->load->library('pagination');
        $this->load->library('tank_auth');

        $this->logged_in();
        $this->role_user();
        $this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
        $this->data['idAccessMsg'] = $this->session->userdata(SESSION_USERMSGID);
    }

    private function validate() {
        $this->form_validation->set_rules('logitem_id', 'logitem_id', '');
        $this->form_validation->set_rules('logitem_desc', 'logitem_desc', 'required');
        $this->form_validation->set_rules('logitem_metric', 'logitem_metric', 'required');
        $this->form_validation->set_rules('logitemctx_id', 'logitemctx_id', 'required');
        
        return $this->form_validation->run();
    }

    private function fetch_relation() {
        $logctx_temp = $this->logistic_ctx->fetch(1000, 0, 'logitemctx_name');
        $logctx = array();
        $logctx[''] = '-Pilih Kelompok-';
        foreach ($logctx_temp as $lctx_item) {
            $logctx[$lctx_item->logitemctx_id] = $lctx_item->logitemctx_name;
        }
        $this->data['logctx'] = $logctx;

        $logcat_temp = $this->logistic_cat->fetch(1000, 0, 'logitemcat_name');
        $logcat = array();
        $logcat[''] = '-Pilih Kategori-';
        foreach ($logcat_temp as $lcat_item) {
            $logcat[$lcat_item->logitemcat_id] = $lcat_item->logitemcat_name;
        }
        $this->data['logcat'] = $logcat;
    }

    /**
      prepare data for view
     */
    public function index($offset = 0) {
        $this->preload();
        $this->get_list($this->limit, $offset);
        $this->fetch_relation();
        $this->load_view('admin/logistic_item/list_logistic_item', $this->data);
    }

    /**
      getting filter parameter when user
      doing searching.
     */
    public function filter_param() {
        $filter = array();
        if (isset($_GET['filter'])) {
            $filter['logitem_desc'] = $this->input->get('logitem_desc');
            $filter['logitemctx_id'] = $this->input->get('logitemctx_id');
            $filter['logitemcat_id'] = $this->input->get('logitemcat_id');
        }
        // other input receive
        return $filter;
    }

    public function get_list($limit = 16, $offset = 0) {
        $obj = $this->filter_param();
        $filter = (!empty($obj)) ? $obj : null;
        #generate pagination
        $config['base_url'] = site_url(self::$CURRENT_CONTEXT . '/index');
        $config['total_rows'] = $this->logistic_item_dao->count_table_fetch(null, $filter);
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;
        $config['filter_param'] = $_SERVER['QUERY_STRING'];
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        
        $this->data['offset'] = $offset;
        $this->fetch_data($limit, $offset, $filter);
    }

    private function fetch_data($limit, $offset, $filter = null) {
        $this->data['logistic_item'] = $this->logistic_item_dao->fetch(null, $limit, $offset, $filter, 'logitem_desc');
    }

    public function fetch_record($keys) {
        $this->data['logistic_item'] = $this->logistic_item_dao->by_id($keys);
    }

    private function fetch_input() {
        $data = array(//'logitem_id' => $this->input->post('logitem_id'),
            'logitem_desc' => $this->input->post('logitem_desc'),
            'logitem_metric' => $this->input->post('logitem_metric'),
            'logitemctx_id' => $this->input->post('logitemctx_id'),
            'logitemcat_id' => ($this->input->post('logitemcat_id') == '') ? null : $this->input->post('logitemcat_id')
        );
        if ($this->input->post('logitem_id')) {
            $data['logitem_id'] = $this->input->post('logitem_id');
        }

        return $data;
    }

    public function save() {
        $obj = $this->fetch_input(); // print_r($obj); die();
        $infoSession = ''; // added by SKM17

        if ($this->validate() != false) {
            $obj_id = array('logitem_id' => $obj['logitem_id']);

            if (isset($obj['logitem_id']) && $this->logistic_item_dao->by_id($obj_id) != null) {
                $this->logistic_item_dao->update($obj, $obj_id);
				$infoSession .= "Data Kondisi Teknis berhasil diubah. ";
            } else {
                $this->logistic_item_dao->insert($obj);
				$infoSession .= "Data Kondisi Teknis berhasil ditambah. ";
            }
            
            $this->session->set_flashdata("info", $infoSession);
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        } else {
            /* invalid input will be redirected to edit view with error message included */
            $this->preload();
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/logistic_item/list_logistic_item', $this->data);
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
    public function edit($logitem_id = null) {
        $this->preload();
        if ($logitem_id == null) {
            $this->load_view('admin/logistic_item/list_logistic_item');
        } else {
            $this->fetch_relation();
            $param = $this->get_list($this->limit);
            $obj_id = array('logitem_id' => $logitem_id);

            $to_edit = $this->logistic_item_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            $this->load_view('admin/logistic_item/list_logistic_item', $this->data);
        }
    }

    /**

      @description
      viewing record. repopulation for every data needed for view.
     */
    public function view($logitem_id = null) {
        $obj_id = array('logitem_id' => $logitem_id);

        $this->preload();
        $this->fetch_record($obj_id);
        #prepare link for back to view list
        $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
        $this->load_view('admin/logistic_item/view_logistic_item', $this->data);
    }

    public function delete($logitem_id = null) {
        $obj_id = array('logitem_id' => $logitem_id);

        $status_del = $this->logistic_item_dao->delete($obj_id);
        if ($status_del == false) {
            $this->session->set_flashdata("info", "Hapus data kondisi teknis gagal!");
        } else {
            $this->session->set_flashdata("info", "Hapus data kondisi teknis berhasil!");
        }
        redirect(self::$CURRENT_CONTEXT);
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
