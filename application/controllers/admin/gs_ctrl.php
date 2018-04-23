<?php

class gs_ctrl extends CI_Controller {

	public $data;
	public $filter;
	public $limit = 16;
	public static $CURRENT_CONTEXT = '/admin/gs_ctrl';
	public static $TITLE = "Groundstation";

	public function __construct() {
		parent::__construct();
		$this->data = array();
		$this->load->helper('string');
		$this->load->helper('url');
		$this->load->helper('acl');
		$this->load->helper('file');
		$this->load->helper('stringify');
		$this->load->library('dao/groundstation_dao');
		$this->load->library('dao/user_role_dao');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('tank_auth');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->helper('geodesics');
		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
		$this->logged_in();
		$this->role_user();
		$this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
		$this->data['idAccessMsg'] = $this->session->userdata(SESSION_USERMSGID);
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
		$this->load_view('admin/gs/list_gs', $this->data);
	}

	public function get_list($limit = 16, $offset = 0) {
        $obj = $this->filter_param();
        $filter = (!empty($obj)) ? $obj : null;
        #generate pagination
        if ($this->uri->segment(3) == 'edit') {
            $base_url = self::$CURRENT_CONTEXT . '/edit/' . $this->uri->segment(4);
            $uri = 5;
        } else {
            $base_url = self::$CURRENT_CONTEXT . '/index/';
            $uri = 4;
        }
        $config['base_url'] = site_url($base_url);

        $config['total_rows'] = $this->groundstation_dao->count_table_fetch($filter);
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri;
        $config['filter_param'] = $_SERVER['QUERY_STRING'];

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['offset'] = $offset;
        $this->fetch_data(16, $offset, $filter);
	}

	public function fetch_record($keys){
		$this->data['plbhn_tabel']=$this->groundstation_dao->by_id($keys);

	}

	/*	 * role and permission* */
	private function fetch_data($limit, $offset, $filter=null) {
		$this->data['gs'] = $this->groundstation_dao->table_fetch($limit,$offset,$filter);
	}
	/**
	  getting filter parameter when user
	  doing searching.
	 */
	public function filter_param(){
		$filter = array();
		 if (isset($_GET['filter'])) {

			$portname = $this->input->get('gs_place');
			if(isset($portname) && $portname != '' ){
				$filter['gs_place'] = $portname;
			}
		 }

		return $filter;
	}

	private function fetch_input(){
		$data = array(
			'gs_place' => $this->input->post('gs_place'),
			'gs_desc' => $this->input->post('gs_desc'),
			'gs_ip' => $this->input->post('gs_ip'),
			'connection_status' => 'f',
			'gs_lat' => toGeoDec($this->input->post('gs_dlat'),$this->input->post('gs_mlat'),$this->input->post('gs_slat'),$this->input->post('gs_rlat')),
			'gs_lon' => toGeoDec($this->input->post('gs_dlon'),$this->input->post('gs_mlon'),$this->input->post('gs_slon'),$this->input->post('gs_rlon')),
			'gs_frec' => ($this->input->post('gs_frec') == '') ? 0 : $this->input->post('gs_frec')
		);

		return $data;
	}

	public function save() {
		$obj = $this->fetch_input();
		$id = $this->input->post('gs_id');
		$infoSession = ''; 
		$saved;

		if ($id != null) {
			$obj_id = array('gs_id'=>$this->input->post('gs_id'));
			$saved = $this->groundstation_dao->update($obj, $obj_id);
			$infoSession .= "Data GS berhasil diubah. ";
		} else {
			$saved = $this->groundstation_dao->insert($obj);
			$infoSession .= "Data GS berhasil ditambah. ";
		}

		$this->session->set_flashdata("info", $infoSession);
		$this->data['saving'] = true;
		redirect(self::$CURRENT_CONTEXT);		
	}

//editttttt

	public function edit($gs_id = null){
			// $this->preload();
		if ($gs_id == null) {
			$this->load_view('admin/gs/list_gs');
		} else {
			// $param = $this->get_list($this->limit);
			$obj_id = array('gs_id' => $gs_id);

			$to_edit = $this->groundstation_dao->by_id($obj_id);
			$this->data['obj'] = $to_edit;
			$this->data['obj']->point = $this->groundstation_dao->fetch_gs($gs_id);
			$this->preload();
			$this->get_list($this->limit,0);
			$this->load_view('admin/gs/list_gs', $this->data);
		}
	}
	/**

		@description
			viewing record. repopulation for every data needed for view.
	*/


	public function delete($gs_id = null){
		$obj_id =  array('gs_id' => $gs_id);
		//$file = $this->groundstation_dao->delete_icon($gs_id);

		$status_del = $this->groundstation_dao->delete($obj_id);
		if ($status_del == false) {
			$this->session->set_flashdata("info", "Hapus Data GS gagal dilakukan!");
		} else {
			$this->session->set_flashdata("info", "Hapus Data GS berhasil dilakukan!");
		}
		redirect(self::$CURRENT_CONTEXT);
	}
//end editt deleteeeeeeeeeeeee

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
