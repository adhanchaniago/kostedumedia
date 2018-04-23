<?php

class runningtext_ctrl extends CI_Controller {

	public $data;
	public $filter;
	public $limit = 16;
	public static $CURRENT_CONTEXT = '/admin/runningtext_ctrl';
	public static $TITLE = "Teks Berjalan";

	public function __construct() {
		parent::__construct();
		$this->data = array();
		$this->load->helper('string');
		$this->load->helper('url');
		$this->load->helper('acl');
		$this->load->library('dao/runningtext_dao');
		$this->load->library('dao/user_role_dao');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('tank_auth');
		$this->load->library('upload');
		$this->load->library('image_lib');

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

		$this->load_view('admin/running_text/list_runningtext', $this->data);
	}

	public function get_list($limit = 16, $offset = 0) {
		$obj = $this->filter_param();

		#generate pagination
		$this->data['offset'] = $offset;
		$config['base_url'] = site_url(self::$CURRENT_CONTEXT . 'index');
		$config['total_rows'] = $this->runningtext_dao->count_all();
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

	/*	 * role and permission* */
	private function fetch_data($limit, $offset) {
		$this->data['runningtexts'] = $this->runningtext_dao->fetch($limit, $offset, 'pk');
	}
	/**
	  getting filter parameter when user
	  doing searching.
	 */
	public function filter_param() {
		$filter = array();
		/* komen sementara by SKM17
		$par = $this->input->post('sample');
		if ($par != NULL || $par != '') {
			$filter['sample'] = $par;
		}
		*/
		// other input receive
		return $filter;
	}

    private function fetch_input(){

		$tglwkt = new DateTime($this->input->post('tanggalwaktu'));
		// echo 'werwefrwe';
		// die();
        $data = array(
			'day' => $this->input->post('hari'),
			'datetime' => $tglwkt->format('Y-m-d , H:i:s'),
			'status' => $this->input->post('status'),
			'status_desc' => $this->input->post('teks_berjalan')
		);

        return $data;
    }

	public function save() {
		$obj = $this->fetch_input();
        $infoSession = ''; 
        $saved; 

        $obj_id = array('pk' => '1');        
		$saved = $this->runningtext_dao->update($obj, $obj_id);

		if ($saved) 
			$infoSession .= "Pengaturan text berjalan berhasil diubah. ";			
		else
			$infoSession .= "Pengaturan text berjalan gagal diubah. ";

		$this->session->set_flashdata("info", $infoSession);
		$this->data['saving'] = true;
		redirect(self::$CURRENT_CONTEXT);		
        ////////////////////////////////
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
