<?php

class role_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 100;
    public static $CURRENT_CONTEXT = '/admin/role_ctrl';
    public static $TITLE = 'Role';

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('acl');
        $this->load->library('dao/role_dao');
        $this->load->library('dao/features_dao');
        $this->load->library('dao/feature_access_dao');
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
        $this->form_validation->set_rules('role_id', 'role_id', '');
        $this->form_validation->set_rules('role_name', 'role_name', 'required');

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
        $this->load_view('admin/role/list_role', $this->data);
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

    public function get_list($limit = 16, $offset = 0) {
        $obj = $this->filter_param();

        #generate pagination
        $config['base_url'] = site_url(self::$CURRENT_CONTEXT . 'index');
        $config['total_rows'] = $this->role_dao->count_all();
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

    public function fetch_record($keys) {
        $this->data['role'] = $this->role_dao->by_id($keys);
    }

    private function fetch_input() {
        $data = array(
            'role_name' => $this->input->post('role_name'),
            'role_mapurl'=>$this->input->post('role_mapurl')
        );
            
        if ($this->input->post('role_id')) {
            $data['role_id'] = $this->input->post('role_id');
        }

        return $data;
    }

    public function save() {
        $obj = $this->fetch_input();
        $infoSession = ''; // added by SKM17

        if ($this->validate() != false) {
            $obj_id = array('role_id' => $obj['role_id']);

			$saved = false; // added by SKM17
            if ($this->role_dao->by_id($obj_id) != null) {
                $saved = $this->role_dao->update($obj, $obj_id);
                $infoSession .= "Data Role berhasil diubah. ";
            } else {
                $saved = $this->role_dao->insert($obj);
                $infoSession .= "Data Role berhasil ditambah. ";
            }
            if ($this->save_fitur())
                $infoSession .= "Daftar Fitur Role berhasil disimpan. ";
            
            if (!$saved)
            	$infoSession .= "Data Pembina gagal ditambah/diubah. ";

            $this->session->set_flashdata("info", $infoSession);
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        } else {
            /* invalid input will be redirected to edit view with error message included */
            $this->preload();
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/role/list_role', $this->data);
        }
    }

    public function save_fitur() {
        $status_insert = true;

        $aerolog = array();
        $aerovalue = array();

        $role_id = $this->input->post('role_id');
        $totalRow = $this->input->post('totalRow');
        //delete logistik in aeroplane first
        $this->feature_access_dao->delete(array('role_id' => $role_id));
        //insert new logistik
        for ($i = 1; $i <= $totalRow; $i++) {
            $fiturVal = $this->input->post('fiturVal_' . $i);
            $fiturAkses = $this->input->post('fiturAkses_' . $i);

            ($fiturAkses == "") ? 0 : $fiturAkses;
            if ($fiturVal != null) {
                $new_fitur = array('role_id' => $role_id, 'feat_id' => $fiturVal, 'featacc_access' => $fiturAkses);
                $this->feature_access_dao->insert($new_fitur);
            }
        }

        return $status_insert;
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
    public function edit($role_id = null) {
        $this->preload();
        if ($role_id == null) {
            $this->load_view('admin/role/role_edit');
        } else {
            $this->get_list($this->limit);
            //get feature access
            $this->data['feature_access'] = $this->feature_access_dao->table_fetch($role_id, $this->limit, 0, "feat_name");
            ;

            $obj_id = array('role_id' => $role_id);

            $to_edit = $this->role_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            $this->load_view('admin/role/list_role', $this->data);
        }
    }

    /**

      @description
      viewing record. repopulation for every data needed for view.
     */
    public function view($role_id = null) {
        $obj_id = array('role_id' => $role_id);

        $this->preload();
        $this->fetch_record($obj_id);
        #prepare link for back to view list
        $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
        $this->load_view('admin/role/view_role', $this->data);
    }

    public function delete($role_id = null) {
        $obj_id = array('role_id' => $role_id);

		$this->feature_access_dao->delete($obj_id);
        $status_del = $this->role_dao->delete($obj_id);
        if ($status_del == false) {
            $this->session->set_flashdata("info", "Hapus role gagal!");
        } else {
            $this->session->set_flashdata("info", "Hapus role berhasil!");
        }
        redirect(self::$CURRENT_CONTEXT);
    }

    private function fetch_data($limit, $offset) {
        $this->data['role'] = $this->role_dao->fetch($limit, $offset, "role_name");
        //feature
        $this->data['features'] = $this->features_dao->fetch(1000, 0, "feat_name"); // edited by SKM17
        $this->data['feature_access'] = null;
        $this->data['total_rows'] = $this->role_dao->count_all();
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
