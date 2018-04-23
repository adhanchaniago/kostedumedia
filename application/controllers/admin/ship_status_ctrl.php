<?php

class ship_status_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 16;
    public static $CURRENT_CONTEXT = '/admin/ship_status_ctrl';
    public static $TITLE = "Status Kapal";

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('acl');
        $this->load->library('dao/ship_status_dao');
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
        $this->form_validation->set_rules('ship_stat_id', 'ship_stat_id', '');
        $this->form_validation->set_rules('ship_stat_desc', 'ship_stat_desc', 'required'); // uncommented by SKM17

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
        $this->load_view('admin/ship_status/list_ship_status', $this->data);
    }

    public function get_list($limit = 16, $offset = 0) {
        $obj = $this->filter_param();

        #generate pagination
        $config['base_url'] = site_url(self::$CURRENT_CONTEXT . 'index');
        $config['total_rows'] = $this->ship_status_dao->count_all();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        if (empty($obj)) {
            // non conditional data fetching
            $this->fetch_data($limit, $offset);
        } else {
            // apply filter
        }
    }

    /**
      getting filter parameter when user
      doing searching.
     */
    public function filter_param() {
        $filter = array();
        $par = $this->input->post('sample');
        if ($par != NULL || $par != '') {
            $filter['sample'] = $par;
        }
        // other input receive
        return $filter;
    }

    private function fetch_data($limit, $offset) {
        $this->data['ship_status'] = $this->ship_status_dao->fetch($limit, $offset, 'ship_stat_desc');
    }

    public function fetch_record($keys) {
        $this->data['ship_status'] = $this->ship_status_dao->by_id($keys);
    }

    private function fetch_input() {
        $data = array(//'ship_stat_id' => $this->input->post('ship_stat_id'), // commented by SKM17
            'ship_stat_desc' => $this->input->post('ship_stat_desc'));
            
        if ($this->input->post('ship_stat_id')) {
            $data['ship_stat_id'] = $this->input->post('ship_stat_id');
        }

        return $data;
    }

    public function save() {
        $obj = $this->fetch_input();
        $infoSession = ''; // added by SKM17

        if ($this->validate() != false) {
            $obj_id = array('ship_stat_id' => $obj['ship_stat_id']);

			$status; // added by SKM17
            if ($this->ship_status_dao->by_id($obj_id) != null) {
                $status = $this->ship_status_dao->update($obj, $obj_id);
				$infoSession .= "Data Status Kapal berhasil diubah. ";
            } else {
                $status = $this->ship_status_dao->insert($obj);
				$infoSession .= "Data Status Kapal berhasil ditambah. ";
            }
            
			if ($status == FALSE) {
				$infoSession .= "Data Status Kapal gagal ditambah/disimpan. ";
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
            $this->load_view('admin/ship_status/ship_status_edit', $this->data);
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
    public function edit($ship_stat_id = null) {
        $this->preload();
        if ($ship_stat_id == null) {
            $this->load_view('admin/ship_status/list_ship_status');
        } else {
            $param = $this->get_list($this->limit);
            $obj_id = array('ship_stat_id' => $ship_stat_id);

            $to_edit = $this->ship_status_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            $this->load_view('admin/ship_status/list_ship_status', $this->data);
        }
    }

    /**

      @description
      viewing record. repopulation for every data needed for view.
     */
    public function view($ship_stat_id = null) {
        $obj_id = array('ship_stat_id' => $ship_stat_id);

        $this->preload();
        $this->fetch_record($obj_id);
        #prepare link for back to view list
        $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
        $this->load_view('admin/ship_status/view_ship_status', $this->data);
    }

    public function delete($ship_stat_id = null) {
        $obj_id = array('ship_stat_id' => $ship_stat_id);

        $status_del = $this->ship_status_dao->delete($obj_id);
        if ($status_del == false) {
            $this->session->set_flashdata("info", "Hapus Status Kapal gagal!");
        } else {
            $this->session->set_flashdata("info", "Hapus Status Kapal berhasil!");
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
