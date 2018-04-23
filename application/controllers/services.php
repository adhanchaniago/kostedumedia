<?php

/**
 * @author Wira Sakti G
 * @added Mar 22, 2013
 */
class Services extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('dao/aoi_dao');
        $this->load->library('dao/aoi_points_dao');
        $this->load->library('dao/poi_dao');
    }

    public function savePOI() {
        $obj_poi = $this->fetch_input_poi();
        $status = $this->poi_dao->insert($obj_poi);
        if($status){
            echo 1;
        }else{
            echo 0;
        }
        
    }

    public function saveAOI() {
        $aoi_count = $this->aoi_dao->count_all() + 1;
        $obj_aoi = $this->fetch_input_aoi($aoi_count);
        $this->aoi_dao->insert($obj_aoi);

        $aoi_points = $this->input->post('aoi_points');
//        echo"<pre>";print_r($aoi_points);echo"</pre>";exit();   
        foreach ($aoi_points as $key => $point) {
            $obj_aoi_points = $this->fetch_input_aoi_points($aoi_count, $point['lat'], $point['lng']);
            $this->aoi_points_dao->insert($obj_aoi_points);
        }
    }

    private function fetch_input_aoi($aoi_id) {
        $data = array('aoi_id' => 'aoi' . $aoi_id,
            'operation_id' => $this->input->post('operation_id'),
            'aoi_name' => $this->input->post('aoi_name'),
//            'aoi_icon' => $this->input->post('aoi_icon'),
            'aoi_description' => $this->input->post('aoi_description'));

        return $data;
    }

    private function fetch_input_aoi_points($aoi_id, $lat, $long) {
        $data = array('aoi_id' => 'aoi' . $aoi_id,
//            'point_reg' => $this->input->post('point_reg'),
            'point_lat' => $lat,
            'point_long' => $long);

        return $data;
    }

    private function fetch_input_poi() {
        $poi_count = $this->poi_dao->count_all() + 1;
        $data = array('poi_id' => 'poi'.$poi_count,
            'operation_id' => $this->input->post('operation_id'),
            'poi_name' => $this->input->post('poi_name'),
            'poi_icon' => $this->input->post('poi_icon'),
            'poi_description' => $this->input->post('poi_description'),
            'poi_lat' => (float) $this->input->post('poi_lat'),
            'poi_lon' => (float) $this->input->post('poi_lon'));

        return $data;
    }

}

?>
