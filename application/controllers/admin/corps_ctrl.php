<?php

class corps_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 16;
    public static $CURRENT_CONTEXT = '/admin/corps_ctrl';
    public static $TITLE = "Komando";

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('geodesics');
        $this->load->helper('acl');
        $this->load->library('dao/corps_dao');
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

    private function validate() {
        $this->form_validation->set_rules('corps_id', 'corps_id', '');
        $this->form_validation->set_rules('corps_name', 'corps_name', 'required');
//        $this->form_validation->set_rules('corps_description', 'corps_description', 'required');

        return $this->form_validation->run();
    }

    /**
      prepare data for view
     */
    public function index($offset = 0) {
        $this->preload();
        $this->get_list($this->limit, $offset);
        $this->load_view('admin/corps/list_corps', $this->data);
    }

    /**
      getting filter parameter when user
      doing searching.
     */
    public function filter_param() {
        $filter = array();
        if (isset($_GET['filter'])) {
            $filter['corps_name'] = $this->input->get('corps_name');
            $filter['corps_type_id'] = $this->input->get('corps_type_id');
        }
        // other input receive
        return $filter;
    }

    public function get_list($limit = 16, $offset = 0) {
        $obj = $this->filter_param();
        
        #generate pagination
        $filter = (!empty($obj)) ? $obj : null;
        $config['base_url'] = site_url(self::$CURRENT_CONTEXT . '/index');
        $config['total_rows'] = $this->corps_dao->count_table_fetch($filter);
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;
        $config['filter_param'] = $_SERVER['QUERY_STRING'];
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        
        $this->data['offset'] = $offset;
        $this->fetch_data($limit, $offset, $filter);
    }

    private function fetch_data($limit, $offset, $filter = null) {
        $this->data['corps'] = $this->corps_dao->table_fetch($limit, $offset, $filter, 'corps_name');
    }

    public function fetch_record($keys) {
        $this->data['corps'] = $this->corps_dao->by_id($keys);
    }

    private function getValue($inputid) {
        return $this->input->post($inputid) == '' ? 0 : (float) $this->input->post($inputid);
    }

    private function fetch_input() {
        $data = array(
        	'corps_name' => $this->input->post('corps_name'),
            'corps_type_id' => $this->input->post('corps_type_id'),
            'corps_description' => $this->input->post('corps_description'),
            'corps_lat' => toGeoDec($this->getValue('corps_dlat'), $this->getValue('corps_mlat'), $this->getValue('corps_slat'), $this->getValue('corps_rlat')),
            'corps_lon' => toGeoDec($this->getValue('corps_dlon'), $this->getValue('corps_mlon'), $this->getValue('corps_slon'), $this->getValue('corps_rlon'))
        );
        if ($this->input->post('corps_id')) {
            $data['corps_id'] = $this->input->post('corps_id');
        }
        return $data;
    }

    public function save() {
        $obj = $this->fetch_input();
        $infoSession = ''; // added by SKM17

        if ($this->validate() != false) {
//            $obj_id = array('corps_id' => $obj['corps_id']);

			$saved; // added by SKM17
            if (isset($obj['corps_id']) && $this->corps_dao->by_id(array('corps_id' => $obj['corps_id'])) != null) {
                $obj_id = array('corps_id' => $obj['corps_id']);
                $saved = $this->corps_dao->update($obj, $obj_id);
                $saving_corps_id = $obj['corps_id'];
				$infoSession .= "Data Pembina berhasil diubah. ";
            } else {
                $saved = $this->corps_dao->insert($obj);
                $saving_corps_id = $this->corps_dao->insert_id();
				$infoSession .= "Data Pembina berhasil ditambah. ";
            }
            
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
            $this->load_view('admin/corps/list_corps', $this->data);
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
    public function edit($corps_id = null) {
        $this->preload();
        if ($corps_id == null) {
            $this->load_view('admin/corps/list_corps');
        } else {
            $param = $this->get_list($this->limit);
            $obj_id = array('corps_id' => $corps_id);

            $to_edit = $this->corps_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            $this->load_view('admin/corps/list_corps', $this->data);
        }
    }

    /**

      @description
      viewing record. repopulation for every data needed for view.
     */
    public function view($corps_id = null) {
        $obj_id = array('corps_id' => $corps_id);

        $this->preload();
        $this->fetch_record($obj_id);
        #prepare link for back to view list
        $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
        $this->load_view('admin/corps/view_corps', $this->data);
    }

    public function delete($corps_id = null) {
        $obj_id = array('corps_id' => $corps_id);

        $status_del = $this->corps_dao->delete($obj_id);
        if ($status_del == false) {
            $this->session->set_flashdata("info", "Hapus Pembina gagal!");
        } else {
            $this->session->set_flashdata("info", "Hapus Pembina berhasil!");
        }
        redirect(self::$CURRENT_CONTEXT);
    }

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
