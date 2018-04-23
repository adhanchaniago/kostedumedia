<?php
class defined_area_ctrl extends CI_Controller{

	public $data;
	public $filter;
	public $limit = 16;
	public static $CURRENT_CONTEXT = '/admin/defined_area_ctrl';
	public static $TITLE = "Area";

	public function __construct(){
		parent::__construct();
		$this->data = array();
		$this->load->helper('string');
		$this->load->helper('url');
		$this->load->helper('stringify');
		$this->load->helper('acl');
		$this->load->helper('sanitizer');
        $this->load->library('session');
		$this->load->library('dao/defined_area_dao');
		$this->load->library('dao/defined_area_category_dao');
		$this->load->library('dao/user_role_dao');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
		$this->load->library('pagination');
		$this->load->library('tank_auth');

		$this->logged_in();
		$this->role_user();
		$this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
		$this->data['idAccessMsg'] = $this->session->userdata(SESSION_USERMSGID);
	}

	private function validate(){
		$this->form_validation->set_rules('area_point','da_id','required');
		$this->form_validation->set_rules('da_name','da_name','required');
		$this->form_validation->set_rules('da_description','da_description','required');
			
		return $this->form_validation->run();
	}
	/**
		prepare data for view 
	*/
	public function preload(){
		$this->data['current_context'] = self::$CURRENT_CONTEXT;
		$this->data['title'] = self::$TITLE;
	}

	public function load_view($page, $data = null){
		$this->load->view('template/template_header',$data);
		$this->load->view('template/template_menu',$this->data);
		$this->load->view($page, $data);
		$this->load->view('template/template_footer');
	}

	public function index($offset=0){
		$this->preload();
        $this->get_list($this->limit, $offset);
		$this->load_view('admin/defined_area/list_defined_area', $this->data);
	}

	public function get_list($limit = 16, $offset = 0){
		 	$this->preload('');
			$obj = $this->filter_param();
			 $filter = (!empty($obj)) ? $obj : null;
			 if ($this->uri->segment(4) == "") {
	            $offset = 0;
	        } else {
	            $offset = $this->uri->segment(4);
	        }
			$this->fetch_data($this->limit, $offset, $filter);

			#generate pagination
			$config['base_url']		=  base_url().self::$CURRENT_CONTEXT."/index";
			$config['total_rows']	= $this->defined_area_dao->count_table_fetch($filter);
			$config['per_page']		= $this->limit;
			$config['uri_segment']	= 4;
			$config['filter_param'] = $_SERVER['QUERY_STRING'];  //added by D3
			$this->pagination->initialize($config);
			$this->data['pagination']= $this->pagination->create_links();
			$this->data['offset'] 	 = $offset;
	}
	

	public function fetch_record($keys){
		$this->data['defined_area']=$this->defined_area_dao->by_id($keys);

	}

	private function fetch_data($limit,$offset, $filter = null){
		$this->data['defined_area'] = $this->defined_area_dao->table_fetch2($filter,'','',$limit,$offset);
		$defined_area_all = $this->defined_area_dao->fetch_all();

		$this->data['defined_area_all'] = array();
		$this->data['defined_area_categories'] = $this->defined_area_category_dao->fetch(1000, $offset, 'dac_description'); // added by SKM17 
		
		$defined_area_all = $this->defined_area_dao->table_fetch2();
		foreach($defined_area_all as $area){
			$coordinate = null;
			$this->data['defined_area_all'][$area->da_id]['name'] = $area->da_name;
			$this->data['defined_area_all'][$area->da_id]['color'] = $area->dac_color;
			$coordinate = $this->defined_area_dao->fetch_area_point($area->da_id);
			$this->data['defined_area_all'][$area->da_id]['point'] = $coordinate;
			// $color = $this->defined_area_dao->fetch_area_color($area->dac_id);
			// $this->data['defined_area_all'][$area->da_id]['color'] = $color;
		}
		
	}

	private function fetch_input(){
		$data = array(
			'area_point' => $this->input->post('area_point'),
			'da_name' => $this->input->post('da_name'),
			'dac_id' => $this->input->post('dac_id'),
			'da_description' => $this->input->post('da_description')
		);

		return $data;
	}

	public function save(){
		
		$obj = $this->fetch_input();
		
		if($this->validate() != false){
			if($this->input->post('da_id')){
				$obj_id = array('da_id'=>$this->input->post('da_id'));
				if($this->defined_area_dao->by_id($obj_id)!=null){
					$this->defined_area_dao->update_defined_area($obj, $obj_id);
				}else{
					$this->defined_area_dao->insert($obj);
				}
				$infoSession .= "Data Area berhasil diubah. ";
			}else{
				$this->defined_area_dao->insert_defined_area($obj);
				$infoSession .= "Data Area berhasil ditambah. ";
			}
			$this->session->set_flashdata("info", $infoSession);
			redirect(self::$CURRENT_CONTEXT);

		}else{
			$infoSession .= "Data Area gagal dimasukan. ";
			$this->session->set_flashdata("info", $infoSession);
			redirect(self::$CURRENT_CONTEXT.'/index/');
			/* invalid input will be redirected to edit view with error message included*/
			// $this->preload();
			// $this->data['edit'] = false;
			#prepare link for back to view list
			// $this->data['link_back']=  anchor(self::$CURRENT_CONTEXT.'index/',
							// 'Back',array('class'=>'back'));
			// $this->load_view('admin/defined_area/defined_area_edit', $this->data);
		}
	}

	/**
	repopulation for reference data done here.
		add different reference data to different array.
		and pass it to views using $this->data[] parameter.
	*/
	public function repopulate(){

	}
	/**

		@description
			viewing editing form. repopulation for every data needed in form done here.
	*/
	public function edit($da_id = null){
		if( $da_id == null){
			$this->load_view('admin/defined_area/defined_area_edit');
		}else{
			//added by D3 POLBAN
			$obj = $this->filter_param();
			 $filter = (!empty($obj)) ? $obj : null;
			 if ($this->uri->segment(5) == "") {
	            $offset = 0;
	        } else {
	            $offset = $this->uri->segment(5);
	        }
        	//$this->get_list($this->limit, $offset);
			$this->fetch_data($this->limit, $offset, $filter);

			#generate pagination
			$config['base_url']		=  base_url().self::$CURRENT_CONTEXT.'/edit/'.$da_id;
			$config['total_rows']	= $this->defined_area_dao->count_table_fetch($filter);
			$config['per_page']		= $this->limit;
			$config['uri_segment']	= 5;
			$config['filter_param'] = $_SERVER['QUERY_STRING'];  
			$this->pagination->initialize($config);
			$this->data['pagination']= $this->pagination->create_links();
			$this->data['offset'] 	 = $offset;
			//end added

			$obj_id = array('da_id'=>$da_id);

			$to_edit = $this->defined_area_dao->by_id($obj_id);
			$this->data['obj'] = $to_edit;
			$this->data['obj']->point = $this->defined_area_dao->fetch_area_point($da_id);
			//$this->preload();
			//$this->get_list($this->limit);
			$this->load_view('admin/defined_area/list_defined_area', $this->data);
		}
	}
	/**

		@description
			viewing record. repopulation for every data needed for view.
	*/

	public function view($da_id = null){
		$this->preload();
		if ($da_id == null) {
			$this->load_view('admin/defined_area/list_defined_area');
		} else {
			//$this->get_list($this->limit);
			//added by D3 POLBAN
			$obj = $this->filter_param();
			 $filter = (!empty($obj)) ? $obj : null;
			 if ($this->uri->segment(5) == "") {
	            $offset = 0;
	        } else {
	            $offset = $this->uri->segment(5);
	        }

			#generate pagination
			$config['base_url']		=  base_url().self::$CURRENT_CONTEXT.'/view/'.$da_id;
			$config['total_rows']	= $this->defined_area_dao->count_table_fetch($filter);
			$config['per_page']		= $this->limit;
			$config['uri_segment']	= 5;
			$config['filter_param'] = $_SERVER['QUERY_STRING'];  
			$this->pagination->initialize($config);
			$this->data['pagination']= $this->pagination->create_links();
			$this->data['offset'] 	 = $offset;
			$this->fetch_data($this->limit, $offset, $filter);
			//end added
			$obj_id = array('da_id' => $da_id);

			$to_edit = $this->defined_area_dao->by_id($obj_id);
			$this->data['obj'] = $to_edit;
			$this->data['obj']->point = $this->defined_area_dao->fetch_area_point($da_id);
			$this->data['view'] = true;
			$this->load_view('admin/defined_area/list_defined_area', $this->data);
		}
		
	}

	public function delete($da_id = null){
		$obj_id =  array('da_id' => $da_id);

		$status_del = $this->defined_area_dao->delete_defined_area($obj_id);
		if ($status_del == false) {
			$this->session->set_flashdata("info", "Hapus Data Area gagal!");
		} else {
			$this->session->set_flashdata("info", "Hapus Data Area berhasil!");
		}
		redirect(self::$CURRENT_CONTEXT);
	}

	/**
		getting filter parameter when user
		doing searching.
	*/
	public function filter_param(){
			$filter = array();
		if (isset($_GET['filter'])) {
			$filter['da_name'] = $this->input->get('da_name');
		}
			return $filter;
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