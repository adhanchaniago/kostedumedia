<?php

/**
 * @author Wira Sakti G
 * @added Mar 25, 2013
 */
class Aoi_circle extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('dao/aoi_dao');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function saveFormCircle() {
        $name = $this->input->post('name');
        $description = $this->input->post('description');
        $category = $this->input->post('category');

        //lattitude
        $lat_degree = $this->input->post('lat_degree');
        $lat_minute = $this->input->post('lat_minute');
        $lat_second = $this->input->post('lat_second');
        $lat_point = $this->input->post('lat_point') == 'U' ? 1 : -1;
        $lattitude = $lat_degree + (float) ($lat_minute / 60) + (float) ($lat_second / 3600);
        $lattitude = $lat_point * $lattitude;
        //longitude
        $lon_degree = $this->input->post('lon_degree');
        $lon_minute = $this->input->post('lon_minute');
        $lon_second = $this->input->post('lon_second');
        $lon_point = $this->input->post('lon_point') == 'T' ? 1 : -1;
        $longitude = $lon_degree + (float) ($lon_minute / 60) + (float) ($lon_second / 3600);
        $longitude = $lon_point * $longitude;
        //radius
        $radius = (float)$this->input->post('radius');
        //saving circle
        $aoi_id = $this->aoi_dao->count_all() + 1;
        $data = array('aoi_id' => $aoi_id,
            'aptype_id' => $category,
            'aoi_name' => $name,
//            'aoi_icon' => $this->input->post('aoi_icon'),
            'aoi_iscircle' => 'true',
            'aoi_description' => $description,
            'aoi_circle_lat' => $lattitude,
            'aoi_circle_lon' => $longitude,
            'aoi_circle_rad' => $radius);
        
        $status = $this->aoi_dao->insert($data);
		// $this->refresh_session();
        if ($status) {
			$this->session->set_flashdata('info','Data Area Berhasil di simpan');
        } else {
			$this->session->set_flashdata('info','Data Area Gagal di simpan');
        }
		redirect('map');
    }

    public function saveCircle() {
        $aoi_count = $this->aoi_dao->count_all() + 1;
        $obj_aoi = $this->fetch_input_circle($aoi_count);
        $status = $this->aoi_dao->insert($obj_aoi);
        if ($status) {
            echo $obj_aoi['aoi_id'];
        } else {
            echo 0;
        }
    }

    public function editCircle() {
        $obj_circle = $this->fetch_edit_circle();
        $obj_id = array('aoi_id' => $obj_circle['aoi_id']);
        $status = $this->aoi_dao->update($obj_circle, $obj_id);
        if ($status) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function deleteCircle() {
        $obj_id = array('aoi_id' => $this->input->post('aoi_id'));
        $status = $this->aoi_dao->delete($obj_id);
        if ($status) {
            echo 1;
        } else {
            echo 0;
        }
    }

    private function fetch_edit_circle() {
        $aoi_id = $this->input->post('aoi_id');
        $data = array('aoi_id' => $aoi_id,
            'aptype_id' => $this->input->post('aoipoi_type_id'),
            'aoi_name' => $this->input->post('aoi_name'),
//            'aoi_icon' => $this->input->post('aoi_icon'),
            'aoi_iscircle' => 'true',
            'aoi_description' => $this->input->post('aoi_description'),
            'aoi_circle_lat' => $this->input->post('aoi_circle_lat'),
            'aoi_circle_lon' => $this->input->post('aoi_circle_lon'),
            'aoi_circle_rad' => $this->input->post('aoi_circle_rad'));

        return $data;
    }

    private function fetch_input_circle($aoi_id) {
        $data = array('aoi_id' => $aoi_id,
            'aptype_id' => $this->input->post('aoipoi_type_id'),
            'aoi_name' => $this->input->post('aoi_name'),
//            'aoi_icon' => $this->input->post('aoi_icon'),
            'aoi_iscircle' => 'true',
            'aoi_description' => $this->input->post('aoi_description'),
            'aoi_circle_lat' => $this->input->post('aoi_circle_lat'),
            'aoi_circle_lon' => $this->input->post('aoi_circle_lon'),
            'aoi_circle_rad' => $this->input->post('aoi_circle_rad'));

        return $data;
    }
	
	function refresh_session(){
		$sess = $this->session->userdata('user_login');
        if (!isset($sess) || $sess == false) {
            $this->session->set_userdata('user_login','operator');
        }
	}

}