<?php

class fighting_vehicle_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 16;
    public static $CURRENT_CONTEXT = '/admin/fighting_vehicle_ctrl';

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('geodesics');
        $this->load->library('dao/logistic_item_dao');
        $this->load->library('dao/fighting_vehicle_dao');
        $this->load->library('dao/fight_vehicle_logistic_dao');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
        $this->load->library('pagination');
    }

    private function validate() {
//        $this->form_validation->set_rules('fv_id', 'fv_id', 'required');
        $this->form_validation->set_rules('fv_name', 'fv_name', '');
        $this->form_validation->set_rules('fv_desc', 'fv_desc', '');
        $this->form_validation->set_rules('fv_speed', 'fv_speed', '');
        $this->form_validation->set_rules('fv_passanger_capacity', 'fv_passanger_capacity', '');
        $this->form_validation->set_rules('fv_lat', 'fv_lat', '');
        $this->form_validation->set_rules('fv_lon', 'fv_lon', '');
        $this->form_validation->set_rules('fv_isrealtime', 'fv_isrealtime', '');
        $this->form_validation->set_rules('fv_establish_date', 'fv_establish_date', '');
        $this->form_validation->set_rules('fv_lifespan', 'fv_lifespan', '');

        return $this->form_validation->run();
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
        $this->load_view('admin/fighting_vehicle/list_fighting_vehicle', $this->data);
    }

    public function fetch_record($keys) {
        $this->data['fighting_vehicle'] = $this->fighting_vehicle_dao->by_id($keys);
    }

    private function fetch_data($limit, $offset) {
        $this->data['fighting_vehicle'] = $this->fighting_vehicle_dao->fetch($limit, $offset);
        //ship logistic
        $this->data['logistic_item'] = $this->logistic_item_dao->fetch('6',$limit, $offset);
        $this->data['fvehicle_logistics'] = null; //$this->ship_logistics_dao->table_fetch($limit, $offset);
    }

    private function getValue($inputid) {
        return $this->input->post($inputid) == '' ? 0 : $this->input->post($inputid);
    }

    private function fetch_input() {
        if($this->input->post('fv_id')){
            $data['fv_id'] = $this->input->post('fv_id');
        }
            $data['fv_name'] = $this->input->post('fv_name');
            $data['fv_desc'] = $this->input->post('fv_desc');
            $data['fv_speed'] = $this->input->post('fv_speed');
            $data['fv_passanger_capacity'] = $this->input->post('fv_passanger_capacity');
            $data['fv_lat'] = toGeoDec($this->getValue('fv_dlat'),$this->getValue('fv_mlat'),$this->getValue('fv_slat'),$this->getValue('fv_rlat'));
            $data['fv_lon'] = toGeoDec($this->getValue('fv_dlon'),$this->getValue('fv_mlon'),$this->getValue('fv_slon'),$this->getValue('fv_rlon'));
            $data['fv_isrealtime'] = $this->input->post('fv_isrealtime');
            $data['fv_establish_date'] = $this->input->post('fv_establish_date');
            $data['fv_lifespan'] = $this->input->post('fv_lifespan');
        return $data;
    }

    public function save() {
        $obj = $this->fetch_input();

        if ($this->validate() != false) {
//            $obj_id = array('fv_id' => $obj['fv_id']);
            if (isset($obj['fv_id']) && $this->fighting_vehicle_dao->by_id(array('fv_id'=>$obj['fv_id'])) != null) {
                $obj_id = array('fv_id' => $obj['fv_id']);
                $this->fighting_vehicle_dao->update($obj, $obj_id);
                $saving_fv_id = $obj['fv_id'];
            } else {
                $this->fighting_vehicle_dao->insert($obj);
                $saving_fv_id = $this->fighting_vehicle_dao->insert_id();
            }
            $this->save_logistic($saving_fv_id);
            
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        } else {
            /* invalid input will be redirected to edit view with error message included */
            $this->preload();
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/fighting_vehicle/list_fighting_vehicle', $this->data);
        }
    }
    
    public function save_logistic($fv_id) {
        $status_insert = true;

        $fvlog = array();
        $fvvalue = array();

        $totalRow = $this->input->post('totalRow');
        //delete logistik in ship first
        $this->fight_vehicle_logistic_dao->delete(array('fv_id' => $fv_id));
        //insert new logistik
        for ($i = 1; $i <= $totalRow; $i++) {
            $fvlog = $this->input->post('fvLog_' . $i);
            $fvvalue = $this->input->post('fvValue_' . $i);

            $new_logistics = array('logitem_id' => $fvlog, 'fv_id' => $fv_id, 'fvehicle_value' => $fvvalue);
            $this->fight_vehicle_logistic_dao->insert($new_logistics);
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
    public function edit($fv_id = null) {
        if ($fv_id == null
        ) {
            $this->load_view('admin/fighting_vehicle/list_fighting_vehicle');
        } else {
            $this->get_list($this->limit);
            $this->get_list_logistic($this->limit);
            $this->data['fvehicle_logistics'] = $this->fight_vehicle_logistic_dao->table_fetch($fv_id, $this->limit);
            
            $obj_id = array('fv_id' => $fv_id);

            $to_edit = $this->fighting_vehicle_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            $this->load_view('admin/fighting_vehicle/list_fighting_vehicle', $this->data);
        }
    }

    /**

      @description
      viewing record. repopulation for every data needed for view.
     */
    public function view($fv_id = null) {
        $obj_id = array('fv_id' => $fv_id);

        $this->preload();
        $this->fetch_record($obj_id);
        #prepare link for back to view list
        $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
        $this->load_view('admin/fighting_vehicle/view_fighting_vehicle', $this->data);
    }

    public function delete($fv_id = null) {
        $obj_id = array('fv_id' => $fv_id);
        $this->fight_vehicle_logistic_dao->delete($obj_id);
        $this->fighting_vehicle_dao->delete($obj_id);
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
        $config['total_rows'] = $this->fighting_vehicle_dao->count_all();
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
        $config['total_rows'] = $this->fight_vehicle_logistic_dao->count_all();
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