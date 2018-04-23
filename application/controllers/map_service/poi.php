<?php

/**
 * @author Wira Sakti G
 * @added Mar 25, 2013
 */
class Poi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('dao/poi_dao');
        $this->load->library('session');
		$this->load->helper('url');
    }
    
    public function saveFormPOI(){
        //
        $name = $this->input->post('name');
        $description = $this->input->post('description');
        $category = $this->input->post('category');
        
        //lattitude
        $lat_degree = $this->input->post('lat_degree');
        $lat_minute = $this->input->post('lat_minute');
        $lat_second = $this->input->post('lat_second');
        $lat_point = $this->input->post('lat_point')=='U'?1:-1;
        $lattitude = $lat_degree + (float)($lat_minute/60) + (float)($lat_second/3600);
        $lattitude = $lat_point * $lattitude;
        //longitude
        $lon_degree = $this->input->post('lon_degree');
        $lon_minute = $this->input->post('lon_minute');
        $lon_second = $this->input->post('lon_second');
        $lon_point = $this->input->post('lon_point')=='T'?1:-1;
        $longitude = $lon_degree + (float)($lon_minute/60) + (float)($lon_second/3600);
        $longitude = $lon_point * $longitude;
        //saving poi
        $poi_count = $this->poi_dao->count_all() + 1;
        $data = array('poi_id' => $poi_count,
            'aptype_id' => $category,
            'poi_name' => $name,
//            'poi_icon' => $this->input->post('poi_icon'),
            'poi_description' => $description,
            'poi_lat' => (float) $lattitude,
            'poi_lon' => (float) $longitude);
        $status = $this->poi_dao->insert($data);
        // $this->refresh_session();
        if ($status) {
			$this->session->set_flashdata('info','Data Area Berhasil di simpan');
        } else {
			$this->session->set_flashdata('info','Data Area Gagal di simpan');
        }
		redirect('map');

    }
    
    public function savePOI() {
        $obj_poi = $this->fetch_input_poi();
        $status = $this->poi_dao->insert($obj_poi);
        if ($status) {
            echo $obj_poi['poi_id'];
//            echo 1;
        } else {
            echo 0;
        }
    }

    public function editPOI() {
        $obj_poi = $this->fetch_edit_poi();
        $obj_id = array('poi_id'=>$obj_poi['poi_id']);
        
        $status = $this->poi_dao->update($obj_poi, $obj_id);
        if ($status) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function deletePOI() {
        $poi_id = trim($this->input->post('poi_id'));
        $obj_id = array('poi_id' => $poi_id);

        $status = $this->poi_dao->delete($obj_id);
        if ($status) {
            echo 1;
        } else {
            echo 0;
        }
    }

    private function fetch_input_poi() {
        $poi_count = $this->poi_dao->count_all() + 1;
        $data = array('poi_id' => $poi_count,
            'aptype_id' => $this->input->post('aoipoi_type_id'),
            'poi_name' => $this->input->post('poi_name'),
//            'poi_icon' => $this->input->post('poi_icon'),
            'poi_description' => $this->input->post('poi_description'),
            'poi_lat' => (float) $this->input->post('poi_lat'),
            'poi_lon' => (float) $this->input->post('poi_lon'));

        return $data;
    }

    private function fetch_edit_poi() {
        $poi_id = $this->input->post('poi_id');
        $data = array('poi_id' => $poi_id,
            'aptype_id' => $this->input->post('aoipoi_type_id'),
            'poi_name' => $this->input->post('poi_name'),
//            'poi_icon' => $this->input->post('poi_icon'),
            'poi_description' => $this->input->post('poi_description'),
            'poi_lat' => (float) $this->input->post('poi_lat'),
            'poi_lon' => (float) $this->input->post('poi_lon'));

        return $data;
    }

	function refresh_session(){
		$sess = $this->session->userdata('user_login');
        if (!isset($sess) || $sess == false) {
            $this->session->set_userdata('user_login','operator');
        }
	}
}