<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Map extends CI_Controller {

    public $data;

    function __construct() {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->library('session');
        $this->load->library('dao/cctv_location_dao');
        $this->load->library('dao/operation_dao');
        $this->load->library('dao/aoipoi_type_dao');
        $this->load->library('dao/aoi_dao');
        $this->load->library('dao/aoi_points_dao');
        $this->load->library('dao/poi_dao');
        $this->load->library('dao/user_role_dao');
        $this->load->library('dao/violation_type_dao');
        $this->load->library('dao/report_type_dao');
    }

    public function index() {
        $this->is_logged_in();
        $this->getSession();
        $user = $this->user_role_dao->fetch_record($this->session->userdata('user_id'));
        
        if (trim($user->role_name) == 'operator') {
            $this->load->view('map/map', $this->data);
        } else if (trim($user->role_name) == 'viewer') {
            $this->load->view('map/map_viewer', $this->data);
        } else {
            redirect('');
        }
    }
    
    function ais() {
        $this->load->view('map/ais');
    }

    public function request() {
        $i = $_POST['counter'];
        $data = array();
        $data[0]['lat'] = -4.258768;
        $data[0]['lon'] = 117.421875;

        $data[1]['lat'] = -5.222247;
        $data[1]['lon'] = 115.620117;

        $data[2]['lat'] = -5.178482;
        $data[2]['lon'] = 113.203125;

        $data[3]['lat'] = -5.528511;
        $data[3]['lon'] = 111.708984;

        $data[4]['lat'] = -4.65308;
        $data[4]['lon'] = 108.149414;
        if ($i > 4) {
            echo json_encode(500);
        } else {
            echo json_encode($data[$i]);
        }
    }

    public function aoipoi() {
        $data['aoipoi_type'] = $this->aoipoi_type_dao->fetch();
        $this->load->view('map/aoipoi', $data);
    }

    public function saveAoipoi() {
        
    }
    
    private function getSession(){
        $this->data['operation'] = $this->operation_dao->fetch();
        $this->data['type'] = $this->aoipoi_type_dao->fetch();
        $this->data['violation_type'] = $this->violation_type_dao->fetch();
        $this->data['report_type'] = $this->report_type_dao->fetch();
    }
	
	public function video($cctv_id){
		$cctv = $this->cctv_location_dao->by_id(array('cctvloc_id'=>$cctv_id));
		$obj = array();
		$obj['cctv_location'] = $cctv->cctvloc_url;
		$obj['cctv_username'] = $cctv->cctvloc_username;
		$obj['cctv_password'] = $cctv->cctvloc_password;
		
		$this->load->view('map/video',$obj);
	}

    public function kri_video($ip, $uname , $pwd){
        $obj = array();
        $obj['cctv_location'] = $ip;
        $obj['cctv_username'] = $uname;
        $obj['cctv_password'] = $pwd;
        
        $this->load->view('map/video',$obj);
    }
            
    private function is_logged_in() {
        $sess = $this->session->userdata('user_id');
        if (!isset($sess) || $sess == false) {
            redirect('home/login');
        }
    }
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */