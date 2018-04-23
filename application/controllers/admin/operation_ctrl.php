<?php

class operation_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 5000;
    public static $CURRENT_CONTEXT = '/admin/operation_ctrl';
    public static $TITLE = "Operasi";

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('stringify');
        $this->load->helper('acl');
        $this->load->helper('geodesics');
        $this->load->library('session');
        $this->load->library('dao/operation_dao');
        $this->load->library('dao/operation_type_dao');
        $this->load->library('dao/aeroplane_ops_dao');
        $this->load->library('dao/marines_ops_dao');
        $this->load->library('dao/ship_ops_dao');
        $this->load->library('dao/ship_dao');
        $this->load->library('dao/user_role_dao');
        $this->load->library('dao/jenisops1dan2_dao');
        $this->load->library('dao/jenisops3_dao');
        $this->load->library('dao/jenisops4_dao');
        $this->load->library('dao/kodaloperasi_dao');
        $this->load->library('dao/marines_dao');
        $this->load->library('dao/aeroplane_dao');
        $this->load->library('dao/ship_dao');
        $this->load->library('dao/operasi_kodaloperasi_dao');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
        $this->load->library('pagination');
        $this->load->library('tank_auth');

        $this->logged_in();
        $this->role_user();
        $this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
    }

    private function validate() {
        $this->form_validation->set_rules('operation_id', 'operation_id', '');
        $this->form_validation->set_rules('operation_name', 'operation_name', '');
//        $this->form_validation->set_rules('operation_description', 'operation_description', '');
        $this->form_validation->set_rules('operation_start', 'operation_start', '');
        $this->form_validation->set_rules('operation_end', 'operation_end', '');

        return $this->form_validation->run();
    }

    /**
      prepare data for view
     */
    public function preload($context = '') {
        $this->data['current_context'] = self::$CURRENT_CONTEXT . $context;
        $this->data['title'] = self::$TITLE;
    }

    public function load_view($page, $data = null) {
        $this->load->view('template/template_header', $data);
        $this->load->view('template/template_menu', $this->data);
        $this->load->view($page);
        $this->load->view('template/template_footer');
    }

    public function index($offset = 0) {
        $this->operation_plan();
//        $this->preload();
//        $param = $this->get_list($this->limit, $offset);
//        $this->get_form_reference();
//        $this->load_view('admin/operation/list_operation', $this->data);
    }

    public function operation_plan() {
        $this->preload('/operation_plan');
        $this->fetch_data_plan(5000, 0, null);
//        $this->check_existing_data_plan();
        $this->get_form_reference();
        $this->load_view('admin/operation/operation_plan', $this->data);
    }

    public function operation_occur() {
        $this->preload('/operation_occur');
        $this->fetch_data_occur(5000, 0, null);
//        $this->get_list($this->limit);
//        $this->get_form_reference();
        $this->load_view('admin/operation/operation_occur', $this->data);
    }

    public function operation_detail_occur($operation_id) {
        $obj_id = array('operation_id' => $operation_id);
        $detail = $this->operation_dao->by_id($obj_id);
        $data['operations'] = $detail;
        $data['aeroplanes'] = $this->aeroplane_ops_dao->aeroplane_ops($operation_id);
        $data['marines'] = $this->marines_ops_dao->marine_ops($operation_id);
        $data['ships'] = $this->ship_ops_dao->ship_ops($operation_id);

        $data['kodal'] = $this->operasi_kodaloperasi_dao->table_fetch($obj_id);

        $data['ops_type'] = $this->jenisops4_dao->arr_by_id(array('level4_id' => $detail->operation_type));
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
//        exit();
        $this->load->view('admin/operation/operation_detail_occur', $data);
    }

    public function get_form_reference() {
        $operation_type = array();
        $optypes = $this->operation_type_dao->fetch();
        foreach ($optypes as $optype) {
            $operation_type[$optype->optype_id] = $optype->optype_name;
        }
        $this->data['operation_type'] = $operation_type;
    }

    public function fetch_record($keys) {
        $this->data['operation'] = $this->operation_dao->by_id($keys);
    }

    private function fetch_data_plan($limit, $offset, $filter = null) {
        $constraint = null;
        $group = get_data_restriction($this->session->userdata(SESSION_USERGROUP));
        if (strlen($group) > 0) {
            //$constraint = array('corps_id' => $group);
        }

        $this->data['operation'] = $this->operation_dao->table_fetch('plan', $limit, $offset, $constraint, $filter);
        $this->data['jenis_ops_subonetwo'] = $this->jenisops1dan2_dao->fetch();
//        $this->data['jenis_ops_subthree'] = $this->jenisops3_dao->fetch();
//        $this->data['jenis_ops_subfour'] = $this->jenisops4_dao->fetch();
        $this->data['kodals'] = $this->kodaloperasi_dao->fetch();
        //data pokok
        $this->data['marines'] = $this->marines_dao->fetch();
        $this->data['ships'] = $this->ship_dao->table_fetch();
        $this->data['aeroplanes'] = $this->aeroplane_dao->fetch();
    }

    private function fetch_data_occur($limit, $offset, $filter = null) {
        $constraint = null;
        $group = get_data_restriction($this->session->userdata(SESSION_USERGROUP));
        if (strlen($group) > 0) {
            //$constraint = array('corps_id' => $group);
        }

        $this->data['operation'] = $this->operation_dao->table_fetch('occur', $limit, $offset, $constraint, $filter);
    }

    private function fetch_edit_plan($operation_id) {
        $obj_id = array('operation_id' => $operation_id);
        $to_edit = $this->operation_dao->by_id($obj_id);
        $this->data['obj'] = $to_edit;

        $aeroplanes_exist = $this->aeroplane_ops_dao->arr_by_id($obj_id);
        $marines_exist = $this->marines_ops_dao->arr_by_id($obj_id);
        $ships_exist = $this->ship_ops_dao->arr_by_id($obj_id);

        $this->data['aeroplanes_exist'] = array();
        foreach ($aeroplanes_exist as $ae) {
            $this->data['aeroplanes_exist'][] = $ae->aer_id;
        }

        $this->data['marines_exist'] = array();
        $this->data['marines_count_exist'] = array();
        foreach ($marines_exist as $me) {
            $this->data['marines_exist'][] = $me->mar_id;
            $this->data['marines_count_exist'][$me->mar_id] = $me->mar_count;
        }
        $this->data['ships_exist'] = array();
        foreach ($ships_exist as $se) {
            $this->data['ships_exist'][] = $se->ship_id;
        }

        $kodal_exist = $this->operasi_kodaloperasi_dao->arr_by_id($obj_id);
        $this->data['kodal_exist'] = array();
        foreach ($kodal_exist as $ke) {
            $this->data['kodal_exist'][] = $ke->kodaloperasi_id;
        }
        //get operation type
        $this->data['subfour_id'] = $this->jenisops4_dao->arr_by_id(array('level4_id' => $to_edit->operation_type));
        $this->data['subthree_id'] = $this->jenisops3_dao->arr_by_id(array('level3_id' => $this->data['subfour_id'][0]->level3_id));
        $this->data['subone_id'] = $this->jenisops1dan2_dao->arr_by_id(array('level1dan2_id' => $this->data['subthree_id'][0]->level1dan2_id));

        $this->data['jenis_ops_subthree_exist'] = $this->jenisops3_dao->arr_by_id(array('level1dan2_id' => $this->data['subthree_id'][0]->level1dan2_id));
        $this->data['jenis_ops_subfour_exist'] = $this->jenisops4_dao->arr_by_id(array('level3_id' => $this->data['subfour_id'][0]->level3_id));
    }

    public function check_existing_data_plan($operation_id) {
        $return['status'] = true;
        $return['desc'] = '';
        //get operation
        $operation = $this->operation_dao->by_id(array('operation_id' => $operation_id));
        $ship_used = $this->ship_ops_dao->ship_ops_used_plan($operation);
        $aer_used = $this->aeroplane_ops_dao->aeroplane_ops_used_plan($operation);
        $mar_used = $this->marines_ops_dao->marine_ops_used_plan($operation);
				
        $aeroplanes_exist = $this->aeroplane_ops_dao->arr_by_id(array('operation_id' => $operation->operation_id));
        $marines_exist = $this->marines_ops_dao->arr_by_id(array('operation_id' => $operation->operation_id));
        $ships_exist = $this->ship_ops_dao->arr_by_id(array('operation_id' => $operation->operation_id));
		
        //element on other operation
        $shipused = array();
        $aerused = array();
        $marused = array();
        $marcount = 0;
        
        if ($ship_used != null) {
            foreach ($ship_used as $su) {
                $shipused[] = $su->ship_id;
            }
        }
        if ($aer_used != null) {
            foreach ($aer_used as $au) {
                $aerused[] = $au->aer_id;
            }
        }

        if ($mar_used != null) {
            foreach ($mar_used as $mu) {
                $marused[] = $mu->mar_id;
                $marcount = $marcount + $mu->mar_count;
            }
        }
		
        //element on operation
        foreach ($aeroplanes_exist as $ae) {
            if (in_array($ae->aer_id, $aerused)) {
                $return['status'] = false;
            }
        }

        foreach ($marines_exist as $me) {
            $marines_count = $this->marines_dao->by_id(array('mar_id' => $me->mar_id));
            $mar_total = $marcount + $me->mar_count;
            if($mar_total>$marines_count->mar_personel_count){
                $return['status'] = false;
                $return['desc'] = 'marines_max';
            }
            if (in_array($me->mar_id, $marused)) {
                $return['status'] = false;
            }
        }

        foreach ($ships_exist as $se) {
            if (in_array($se->ship_id, $shipused)) {
                $return['status'] = false;
            }
        }
        return $return;
    }

    private function fetch_input() {
        if ($this->input->post('operation_id')) {
            $data['operation_id'] = $this->input->post('operation_id');
        }
        $data['operation_name'] = $this->input->post('operation_name');
        $data['operation_description'] = $this->input->post('operation_description');
        $data['operation_start'] = $this->input->post('operation_start');
        $data['operation_end'] = $this->input->post('operation_end');
//        $data['operation_annual'] = $this->input->post('operation_annual');
        $data['optype_id'] = $this->input->post('optype_id');
        $data['operation_year'] = $this->input->post('operation_year');
        $data['operation_is_active'] = $this->input->post('operation_is_active');
//        $data['operation_is_template'] = $this->input->post('operation_is_template');
//        $data['kodals'] = $this->input->post('kodals');
        $data['operation_type'] = $this->input->post('sub_four');

        return $data;
    }

    public function save() {
        $obj = $this->fetch_input();

        if ($this->validate() != false) {
//            $obj_id = array('operation_id' => $obj['operation_id']);

            if (isset($obj['operation_id']) && $this->operation_dao->by_id(array('operation_id' => $obj['operation_id'])) != null) {
                $obj_id = array('operation_id' => $obj['operation_id']);
                $this->operation_dao->update($obj, $obj_id);
            } else {
                $lastkey = $this->operation_dao->getLastKey();
                $obj['operation_id'] = (int) $lastkey[0]->operation_id + 1;
                $this->operation_dao->insert($obj);
            }

            $this->save_kodal_operasi($obj['operation_id']);
            $this->OpsElement($obj['operation_id']);

            $this->data['saving'] = true;
            $this->session->set_flashdata("info", "Data operasi berhasil disimpan.");
            redirect(self::$CURRENT_CONTEXT . '/operation_plan');
        } else {
            /* invalid input will be redirected to edit view with error message included */
            $this->preload();
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/operation/operation_edit', $this->data);
        }
    }

    public function save_kodal_operasi($ops_id) {
        $status_insert = true;

        $kodal = $this->input->post('kodals');
        //delete kodal first
        $this->operasi_kodaloperasi_dao->delete(array('operation_id' => $ops_id));
        foreach ($kodal as $kod) {
            $new_kodal = array('operation_id' => $ops_id, 'kodaloperasi_id' => $kod);
            $this->operasi_kodaloperasi_dao->insert($new_kodal);
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

    public function edit_plan($operation_id = null) {
        $this->preload('/operation_plan');
        if ($operation_id == null) {
            $this->load_view('admin/operation/operation_plan');
        }
        $this->fetch_data_plan(5000, 0);
//        $this->check_existing_data_plan();
        $this->get_form_reference();
        $this->fetch_edit_plan($operation_id);

        $this->load_view('admin/operation/operation_plan', $this->data);
    }

    public function delete_plan($operation_id = null) {
        $delete_stat = true;
        $this->preload('/operation_plan');
        if ($operation_id == null) {
            $this->load_view('admin/operation/operation_plan');
        }
        //delete all data related to operation
        $stat_kodal = $this->operasi_kodaloperasi_dao->delete(array('operation_id' => $operation_id));
        $stat_aero = $this->aeroplane_ops_dao->delete(array('operation_id' => $operation_id));
        $stat_mar = $this->marines_ops_dao->delete(array('operation_id' => $operation_id));
        $stat_ship = $this->ship_ops_dao->delete(array('operation_id' => $operation_id));
        //delete operation
        if ($stat_kodal == true && $stat_aero == true && $stat_mar == true && $stat_ship == true) {
            $stat_ops = $this->operation_dao->delete(array('operation_id' => $operation_id));
            if (!$stat_ops) {
                $delete_stat = false;
            }
        } else {
            $delete_stat = false;
        }
        if ($delete_stat != true) {
            $this->operasi_kodaloperasi_dao->__rollback();
            $this->aeroplane_ops_dao->__rollback();
            $this->marines_ops_dao->__rollback();
            $this->ship_ops_dao->__rollback();
            $this->operation_dao->__rollback();
            $this->session->set_flashdata("info", "Hapus data rencana operasi gagal.");
        } else {
            $this->operasi_kodaloperasi_dao->__commit();
            $this->aeroplane_ops_dao->__commit();
            $this->marines_ops_dao->__commit();
            $this->ship_ops_dao->__commit();
            $this->operation_dao->__commit();
            $this->session->set_flashdata("info", "Hapus data rencana operasi berhasil.");
        }
        redirect(self::$CURRENT_CONTEXT . '/operation_plan');
    }

    /**

      @description
      viewing editing form. repopulation for every data needed in form done here.
     */
    public function edit($operation_id = null) {
        $this->preload();
        if ($operation_id == null) {
            $this->load_view('admin/operation/list_operation');
        } else {

            $param = $this->get_list($this->limit);
            $this->get_form_reference();

            $obj_id = array('operation_id' => $operation_id);
            $to_edit = $this->operation_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;

            $this->data['aeroplane_total'] = $this->aeroplane_ops_dao->arr_by_id($obj_id);

            $obj_id = array('operation_id' => $operation_id, 'mo_martype_id' => MARINES_SATPURMAR_CODE);
            $this->data['satpurmar_total'] = $this->marines_ops_dao->arr_by_id($obj_id);

            $obj_id = array('operation_id' => $operation_id, 'mo_martype_id' => MARINES_RANPURMAR_CODE);
            $this->data['ranpurmar_total'] = $this->marines_ops_dao->arr_by_id($obj_id);

            $obj_id = array('operation_id' => $operation_id, 'shipops_shiptype_id' => SHIP_SURFACE_CODE);
            $this->data['ship_surface_total'] = $this->ship_ops_dao->arr_by_id($obj_id);

            $obj_id = array('operation_id' => $operation_id, 'shipops_shiptype_id' => SHIP_SUBMARINE_CODE);
            $this->data['ship_submarine_total'] = $this->ship_ops_dao->arr_by_id($obj_id);

            $this->load_view('admin/operation/list_operation', $this->data);
        }
    }

    /**

      @description
      viewing record. repopulation for every data needed for view.
     */
    public function view($operation_id = null) {
        $obj_id = array('operation_id' => $operation_id);

        $this->preload();
        $this->fetch_record($obj_id);
        #prepare link for back to view list
        $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
        $this->load_view('admin/operation/view_operation', $this->data);
    }

    public function delete($operation_id = null) {
        $obj_id = array('operation_id' => $operation_id);

        $this->operation_dao->delete($obj_id);
        redirect(self::$CURRENT_CONTEXT);
    }

    /**
      getting filter parameter when user
      doing searching.
     */
    public function filter_param() {
        $filter = array();
        if (isset($_GET['filter'])) {
            $filter['operation_name'] = $this->input->get('operation_name');
            $filter['optype_id'] = $this->input->get('optype_id');
        }
        // other input receive
        return $filter;
    }

    public function get_list($limit = 16, $offset = 0) {
        $obj = $this->filter_param();
        $filter = (!empty($obj)) ? $obj : null;
        #generate pagination
        $config['base_url'] = site_url(self::$CURRENT_CONTEXT . '/index');
        $config['total_rows'] = $this->operation_dao->count_table_fetch(null, $filter);
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;
        $config['filter_param'] = $_SERVER['QUERY_STRING'];
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->fetch_data($limit, $offset, $filter);
    }

    public function get_sub_three() {
        if (isset($_POST['parent_id'])) {
            $response = $this->jenisops3_dao->fetch(1000, 0, null, array('level1dan2_id' => $_POST['parent_id']));
            die(json_encode($response)); // convert variable respon menjadi JSON, lalu tampilkan
        }
    }

    public function get_sub_four() {
        if (isset($_POST['parent_id'])) {
            $response = $this->jenisops4_dao->fetch(1000, 0, null, array('level3_id' => $_POST['parent_id']));
            die(json_encode($response)); // convert variable respon menjadi JSON, lalu tampilkan
        }
    }

    public function operationData($element, $operation_id) {
        $element_list = array();
        $element_ops = array();

        switch ($element) {
            case 'ship':
                $element_list = $this->ship_ops_dao->ship_ops($operation_id);
                $element_ops = $this->ship_ops_dao->ops_by_id($operation_id);
                $element_name[0] = 'ship';
                $element_name[1] = 'Kapal';
                break;
            case 'marines':
                $element_list = $this->marines_ops_dao->marine_ops($operation_id);
                $element_ops = $this->marines_ops_dao->ops_by_id($operation_id);
                $element_name[0] = 'marines';
                $element_name[1] = 'Marinir';
                break;
            case 'aeroplane':
                $element_list = $this->aeroplane_ops_dao->aeroplane_ops($operation_id);
                $element_ops = $this->aeroplane_ops_dao->ops_by_id($operation_id);
                $element_name[0] = 'aeroplane';
                $element_name[1] = 'Pesawat Udara';
                break;
            case 'fvehicle':
                $element_list = $this->marines_ops_dao->marine_ops($operation_id, MARINES_RANPURMAR_CODE);
                $element_ops = $this->marines_ops_dao->ops_by_id($operation_id, MARINES_RANPURMAR_CODE);
                $element_name[0] = 'fvehicle';
                $element_name[1] = 'Kendaraan Tempur';
                break;
            case 'submarine':
                $element_list = $this->ship_ops_dao->ship_ops($operation_id, SHIP_SUBMARINE_CODE);
                $element_ops = $this->ship_ops_dao->ops_by_id($operation_id, SHIP_SUBMARINE_CODE);
                $element_name[0] = 'submarine';
                $element_name[1] = 'Kapal Selam';
                break;
        }
        $this->data['element'] = $element_name;
        $this->data['element_list'] = $element_list;
        $this->data['element_ops'] = $element_ops;
        $this->data['obj'] = $this->operation_dao->by_id(array('operation_id' => $operation_id));

        $this->load->view('admin/operation/operationData', $this->data);
    }

    public function OpsElement($operationId) {
        $ship_list = $this->input->post('ship_list');
        $aer_list = $this->input->post('aer_list');
        $mar_list = $this->input->post('mar_list');
        $mar_personel_count = $this->input->post('mar_list_count');
        
        $obj_id = array('operation_id' => $operationId);

        //delete data ship first
        $this->ship_ops_dao->delete($obj_id);
        if ($ship_list != null) {
            foreach ($ship_list as $el) {
                $obj_insert = array('operation_id' => $operationId, 'ship_id' => $el, 'sh_add_timestamp' => date("Y-m-d"));
                $this->ship_ops_dao->insert($obj_insert);
            }
        }
        //delete data marines first
        $this->aeroplane_ops_dao->delete($obj_id);
        if ($aer_list != null) {
            foreach ($aer_list as $el) {
                $obj_insert = array('operation_id' => $operationId, 'aer_id' => $el, 'ao_add_timestamp' => date("Y-m-d"));
                $this->aeroplane_ops_dao->insert($obj_insert);
            }
        }
        $this->marines_ops_dao->delete($obj_id);
        if ($mar_list != null) {
            //delete data aeroplane first
            foreach ($mar_list as $key=>$val) {
                $per_count = $mar_personel_count[$key] == '' ? 0 : $mar_personel_count[$key];
                $obj_insert = array('operation_id' => $operationId, 'mar_id' => $val, 'mo_add_timestamp' => date("Y-m-d"),'mar_count'=>$per_count);
                $this->marines_ops_dao->insert($obj_insert);
            }
        }
    }

    public function setActivatedPlan() {
        $return = 'failed';
        if (isset($_POST['id'])) {
            //get element existing
            $status = $this->check_existing_data_plan($_POST['id']);
            if ($status['status'] == true) {
                $obj['operation_is_active'] = 't';
                $this->operation_dao->update($obj, array('operation_id' => $_POST['id']));
                $return = 'success';
            }else{
                if($status['desc'] == 'marines_max'){
                    $return = 'marine_max';
                }
            }
        }
        echo $return;
    }

    public function setOperationStatus($id,$status){
        $update = $this->operation_dao->update(array('opstatus_id'=>$status), array('operation_id' => $id));
        if($update){
            redirect(self::$CURRENT_CONTEXT.'/operation_occur');
        }
    }
    
    /*----OPERATION ENDED----*/
    
    public function operation_ended() {
        $this->preload('/operation_ended');
        $this->fetch_data_occur(5000, 0, null);
        $this->data['operation'] = $this->operation_dao->table_fetch('ended', 5000, 0);
        $this->load_view('admin/operation/operation_ended', $this->data);
    }

    /*----END OF OPERATION ENDED*/


//    public function OpsElement() {
//        $newElement = $this->input->post('newElement');
//        $elementName = $this->input->post('elementName');
//        $operationId = $this->input->post('operationId');
//
//        switch ($elementName) {
//            case 'ship':
//                //delete data first
//                $obj_id = array('operation_id' => $operationId, 'shipops_shiptype_id' => SHIP_SURFACE_CODE);
//                $this->ship_ops_dao->delete($obj_id);
//                foreach ($newElement as $el) {
//                    $obj_insert = array('operation_id' => $operationId, 'ship_id' => $el, 'sh_add_timestamp' => date("Y-m-d"), 'shipops_shiptype_id' => SHIP_SURFACE_CODE);
//                    $this->ship_ops_dao->insert($obj_insert);
//                }
//                break;
//            case 'marines':
//                //delete data first
//                $obj_id = array('operation_id' => $operationId, 'mo_martype_id' => MARINES_SATPURMAR_CODE);
//                $this->marines_ops_dao->delete($obj_id);
//                foreach ($newElement as $el) {
//                    $obj_insert = array('operation_id' => $operationId, 'mar_id' => $el, 'mo_add_timestamp' => date("Y-m-d"), 'mo_martype_id' => MARINES_SATPURMAR_CODE);
//                    $this->marines_ops_dao->insert($obj_insert);
//                }
//                break;
//            case 'aeroplane':
//                //delete data first
//                $obj_id = array('operation_id' => $operationId);
//                $this->aeroplane_ops_dao->delete($obj_id);
//                foreach ($newElement as $el) {
//                    $obj_insert = array('operation_id' => $operationId, 'aer_id' => $el, 'ao_add_timestamp' => date("Y-m-d"));
//                    $this->aeroplane_ops_dao->insert($obj_insert);
//                }
//                break;
//            case 'fvehicle':
//                //delete data first
//                $obj_id = array('operation_id' => $operationId, 'mo_martype_id' => MARINES_RANPURMAR_CODE);
//                $this->marines_ops_dao->delete($obj_id);
//                foreach ($newElement as $el) {
//                    $obj_insert = array('operation_id' => $operationId, 'mar_id' => $el, 'mo_add_timestamp' => date("Y-m-d"), 'mo_martype_id' => MARINES_RANPURMAR_CODE);
//                    $this->marines_ops_dao->insert($obj_insert);
//                }
//                break;
//            case 'submarine':
//                //delete data first
//                $obj_id = array('operation_id' => $operationId, 'shipops_shiptype_id' => SHIP_SUBMARINE_CODE);
//                $this->ship_ops_dao->delete($obj_id);
//                foreach ($newElement as $el) {
//                    $obj_insert = array('operation_id' => $operationId, 'ship_id' => $el, 'sh_add_timestamp' => date("Y-m-d"), 'shipops_shiptype_id' => SHIP_SUBMARINE_CODE);
//                    $this->ship_ops_dao->insert($obj_insert);
//                }
//                break;
//        }
//    }

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

    /**
     * Template
     */
    public function new_design() {
        $this->load->view('template/template_header');
        $this->load->view('template/template_menu', $this->data);
        $this->load->view('admin/operation/new_design');
        $this->load->view('template/template_footer');
    }

    public function new_design2() {
        $this->load->view('template/template_header');
        $this->load->view('template/template_menu', $this->data);
        $this->load->view('admin/operation/new_design2');
        $this->load->view('template/template_footer');
    }

    public function new_rencana() {
        $this->load->view('template/template_header');
        $this->load->view('template/template_menu', $this->data);
        $this->load->view('admin/operation/new_rencana');
        $this->load->view('template/template_footer');
    }

    public function new_berlangsung() {
        $this->load->view('template/template_header');
        $this->load->view('template/template_menu', $this->data);
        $this->load->view('admin/operation/new_berlangsung');
        $this->load->view('template/template_footer');
    }

}
