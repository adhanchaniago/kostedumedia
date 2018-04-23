<?php

class submarine_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 16;
    public static $CURRENT_CONTEXT = '/admin/submarine_ctrl';

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('geodesics');
        $this->load->library('dao/logistic_item_dao');
        $this->load->library('dao/submarine_dao');
        $this->load->library('dao/submarine_logistics_dao');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
        $this->load->library('pagination');
    }

    private function validate() {
        $this->form_validation->set_rules('sbm_id', 'sbm_id', 'required');
        $this->form_validation->set_rules('sbm_hull_number', 'sbm_hull_number', 'required');
        $this->form_validation->set_rules('sbm_name', 'sbm_name', 'required');
        $this->form_validation->set_rules('sbm_description', 'sbm_description', 'required');
        $this->form_validation->set_rules('sbm_lat', 'sbm_lat', 'required');
        $this->form_validation->set_rules('sbm_lon', 'sbm_lon', 'required');
        $this->form_validation->set_rules('sbm_isrealtime', 'sbm_isrealtime', 'required');
        $this->form_validation->set_rules('sbm_cruising_range', 'sbm_cruising_range', 'required');

        // return $this->form_validation->run();
        return true;
    }

    /**
      prepare data for view
     */
    public function preload() {
        $this->data['current_context'] = self::$CURRENT_CONTEXT;
    }

    public function load_view($page, $data = null) {
        $this->load->view('template/template_header');
        $this->load->view('template/template_menu');
        $this->load->view($page, $data);
        $this->load->view('template/template_footer');
    }

    public function index($offset = 0) {
        $this->preload();
        $this->get_list($this->limit, $offset);
        $this->get_list_logistic($this->limit, $offset);
        $this->load_view('admin/submarine/list_submarine', $this->data);
    }

    public function fetch_record($keys) {
        $this->data['submarine'] = $this->submarine_dao->by_id($keys);
    }

    private function fetch_data($limit, $offset) {
        $this->data['submarine'] = $this->submarine_dao->fetch($limit, $offset);
        //submarine logistic
        $this->data['logistic_item'] = $this->logistic_item_dao->fetch('3',$limit, $offset);
        $this->data['submarine_logistics'] = null; //$this->aeroplane_logistics_dao->table_fetch($limit, $offset);
    }

    private function getValue($inputid) {
        return $this->input->post($inputid) == '' ? 0 : $this->input->post($inputid);
    }

    private function fetch_input() {
        if ($this->input->post('sbm_id')) {
            $data['sbm_id'] = $this->input->post('sbm_id');
        }
        $data['sbm_hull_number'] = $this->input->post('sbm_hull_number');
        $data['sbm_name'] = $this->input->post('sbm_name');
        $data['sbm_description'] = $this->input->post('sbm_description');
        $data['sbm_lat'] = toGeoDec($this->getValue('sbm_dlat'), $this->getValue('sbm_mlat'), $this->getValue('sbm_slat'), $this->getValue('sbm_rlat'));
        $data['sbm_lon'] = toGeoDec($this->getValue('sbm_dlon'), $this->getValue('sbm_mlon'), $this->getValue('sbm_slon'), $this->getValue('sbm_rlon'));
        $data['sbm_isrealtime'] = $this->input->post('sbm_isrealtime') == '' ? 't' : $this->input->post('sbm_isrealtime');
        $data['sbm_cruising_range'] = $this->input->post('sbm_cruising_range');

        return $data;
    }

    public function save() {

        $obj = $this->fetch_input();
//        $this->get_list($this->limit, 0);

        if ($this->validate() != false) {
//            $obj_id = array('sbm_id' => $obj['sbm_id']);

            if (isset($obj['sbm_id']) && $this->submarine_dao->by_id(array('sbm_id' => $obj['sbm_id'])) != null) {
                $obj_id = array('sbm_id' => $obj['sbm_id']);
                $this->submarine_dao->update($obj, $obj_id);
                $saving_sbm_id = $obj['sbm_id'];
            } else {
                $this->submarine_dao->insert($obj);
                $saving_sbm_id = $this->submarine_dao->insert_id();
            }
            $this->save_logistic($saving_sbm_id);

            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        } else {
            /* invalid input will be redirected to edit view with error message included */
            $this->preload();
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/submarine/list_submarine', $this->data);
        }
    }

    public function save_logistic($sbm_id) {
        $status_insert = true;

        $sublog = array();
        $subvalue = array();

        $totalRow = $this->input->post('totalRow');
        //delete logistik in submarine first
        $this->submarine_logistics_dao->delete(array('sbm_id' => $sbm_id));
        //insert new logistik
        for ($i = 1; $i <= $totalRow; $i++) {
            $sublog = $this->input->post('submarineLog_' . $i);
            $subvalue = $this->input->post('submarineValue_' . $i);

            $new_logistics = array('logitem_id' => $sublog, 'sbm_id' => $sbm_id, 'sbmlog_value' => $subvalue);
            $this->submarine_logistics_dao->insert($new_logistics);
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
    public function edit($sbm_id = null) {
        if ($sbm_id == null
        ) {
            $this->load_view('admin/submarine/submarine_edit');
        } else {
            $this->get_list($this->limit);
            $this->get_list_logistic($this->limit);
            $this->data['submarine_logistics'] = $this->submarine_logistics_dao->table_fetch($sbm_id, $this->limit);

            $obj_id = array('sbm_id' => $sbm_id);

            $to_edit = $this->submarine_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            $this->load_view('admin/submarine/list_submarine', $this->data);
        }
    }

    /**

      @description
      viewing record. repopulation for every data needed for view.
     */
    public function view($sbm_id = null) {
        $obj_id = array('sbm_id' => $sbm_id);

        $this->preload();
        $this->fetch_record($obj_id);
        #prepare link for back to view list
        $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
        $this->load_view('admin/submarine/view_submarine', $this->data);
    }

    public function delete($sbm_id = null) {
        $obj_id = array('sbm_id' => $sbm_id);
        $this->submarine_logistics_dao->delete($obj_id);
        $this->submarine_dao->delete($obj_id);
        redirect(self::$CURRENT_CONTEXT);
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
        $config['total_rows'] = $this->submarine_dao->count_all();
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

    public function get_list_logistic($limit = 16, $offset = 0) {
        $obj = $this->filter_param();

        #generate pagination
        $config['base_url'] = site_url(self::$CURRENT_CONTEXT . 'index');
        $config['total_rows'] = $this->submarine_logistics_dao->count_all();
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
    
}