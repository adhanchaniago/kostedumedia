<?php

/**
 * @author Wira Sakti G
 * @added Mar 25, 2013
 */
class Aoi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('dao/aoi_dao');
        $this->load->library('dao/aoi_points_dao');
        $this->load->library('session');
		$this->load->helper('url');
    }

    public function saveFormAOI() {
        $name = $this->input->post('name');
        $description = $this->input->post('description');
        $category = $this->input->post('category');

        $aoi_id = $this->aoi_dao->count_all() + 1;
        $aoi_obj = array('aoi_id' => $aoi_id,
            'aptype_id' => $category,
            'aoi_name' => $name,
//            'aoi_icon' => $this->input->post('aoi_icon'),
            'aoi_iscircle' => 'false',
            'aoi_description' => $description);
        $status = $this->aoi_dao->insert($aoi_obj);

        $count_line = $this->input->post('total_line_polygon');
        for ($i = 1; $i <= $count_line; $i++) {
            //lattitude
            $lat_degree = $this->input->post('pol_lat_degree' . $i);
            $lat_minute = $this->input->post('pol_lat_minute' . $i);
            $lat_second = $this->input->post('pol_lat_second' . $i);
            $lat_point = $this->input->post('pol_lat_point' . $i) == 'U' ? 1 : -1;
            $lattitude = $lat_degree + (float) ($lat_minute / 60) + (float) ($lat_second / 3600);
            $lattitude = $lat_point * $lattitude;
            //longitude
            $lon_degree = $this->input->post('pol_lon_degree' . $i);
            $lon_minute = $this->input->post('pol_lon_minute' . $i);
            $lon_second = $this->input->post('pol_lon_second' . $i);
            $lon_point = $this->input->post('pol_lon_point' . $i) == 'T' ? 1 : -1;
            $longitude = $lon_degree + (float) ($lon_minute / 60) + (float) ($lon_second / 3600);
            $longitude = $lon_point * $longitude;
            $point_obj = array('aoi_id' => $aoi_id,
//            'point_reg' => $this->input->post('point_reg'),
                'point_lat' => $lattitude,
                'point_lon' => $longitude);
            $this->aoi_points_dao->insert($point_obj);
        }
        //saving aoi point
        // $this->refresh_session();
        if ($status) {
			$this->session->set_flashdata('info','Data Area Berhasil di simpan');
        } else {
			$this->session->set_flashdata('info','Data Area Gagal di simpan');
        }
		redirect('map');
    }

    public function saveAOI() {
        $aoi_count = $this->aoi_dao->count_all() + 1;
        $aoi_id = $aoi_count;

        $obj_aoi = $this->fetch_input_aoi($aoi_id);
        $this->aoi_dao->insert($obj_aoi);

        $aoi_points = $this->input->post('aoi_points');
//        echo"<pre>";print_r($aoi_points);echo"</pre>";exit();   
        foreach ($aoi_points as $key => $point) {
            $obj_aoi_points = $this->fetch_input_aoi_points($aoi_id, $point['lat'], $point['lng']);
            $this->aoi_points_dao->insert($obj_aoi_points);
        }
        echo $obj_aoi['aoi_id'];
    }

    public function editAOI() {
        $obj_aoi = $this->fetch_edit_aoi();
        $obj_id = array('aoi_id' => $obj_aoi['aoi_id']);

        $status = $this->aoi_dao->update($obj_aoi, $obj_id);
        if ($status) {
            $aoi_points = $this->input->post('aoi_points');
            $stat_delete = $this->delete_aoi_points();
            if ($stat_delete) {
                foreach ($aoi_points as $key => $point) {
                    $obj_aoi_points = $this->fetch_input_aoi_points($obj_aoi['aoi_id'], $point['lat'], $point['lng']);
                    $this->aoi_points_dao->insert($obj_aoi_points);
                }
                $this->aoi_dao->__commit();
                echo 1;
            } else {
                $this->aoi_dao->__rollback();
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    public function deleteAOI() {
        $aoi_id = $this->input->post('aoi_id');
        $obj_id = array('aoi_id' => $aoi_id);

        //delete aoi points
        $del_points = $this->delete_aoi_points();
        if ($del_points) {
            $del_aoi = $this->aoi_dao->delete($obj_id);
            if ($del_aoi) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    private function fetch_input_aoi($aoi_id) {
        $data = array('aoi_id' => $aoi_id,
            'aptype_id' => $this->input->post('aoipoi_type_id'),
            'aoi_name' => $this->input->post('aoi_name'),
//            'aoi_icon' => $this->input->post('aoi_icon'),
            'aoi_iscircle' => 'false',
            'aoi_description' => $this->input->post('aoi_description'));

        return $data;
    }

    private function fetch_input_aoi_points($aoi_id, $lat, $long) {
        $data = array('aoi_id' => $aoi_id,
//            'point_reg' => $this->input->post('point_reg'),
            'point_lat' => $lat,
            'point_lon' => $long);

        return $data;
    }

    private function fetch_edit_aoi() {
        $aoi_id = $this->input->post('aoi_id');
        $data = array('aoi_id' => $aoi_id,
            'aptype_id' => $this->input->post('aoipoi_type_id'),
            'aoi_name' => $this->input->post('aoi_name'),
            'aoi_iscircle' => 'false',
            'aoi_description' => $this->input->post('aoi_description')
        );
        return $data;
    }

    private function delete_aoi_points() {
        $aoi_id = $this->input->post('aoi_id');
        $obj_id = array('aoi_id' => $aoi_id);

        return $this->aoi_points_dao->delete($obj_id);
    }
	
	function refresh_session(){
		$sess = $this->session->userdata('user_login');
        if (!isset($sess) || $sess == false) {
            $this->session->set_userdata('user_login','operator');
        }
	}

}