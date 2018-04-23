<?php
class fvehicle_ops_ctrl extends CI_Controller{

	public $data;
	public $filter;
	public $limit = 16;
	public static $CURRENT_CONTEXT = '/admin/fvehicle_ops_ctrl';

	public function __construct(){
		parent::__construct();
		$this->data = array();
		$this->load->helper('string');
		$this->load->helper('url');
		$this->load->library('dao/fvehicle_ops_dao');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
		$this->load->library('pagination');
	}

	private function validate(){
		$this->form_validation->set_rules('operation_id','operation_id','required');
			$this->form_validation->set_rules('fv_id','fv_id','required');
			$this->form_validation->set_rules('fvo_add_timestamp','fvo_add_timestamp','required');
			
		return $this->form_validation->run();
	}
	/**
		prepare data for view 
	*/
	public function preload(){
		$this->data['current_context'] = self::$CURRENT_CONTEXT;
	}

	public function load_view($page, $data = null){
		$this->load->view('template/template_header');
		$this->load->view('template/template_menu');
		$this->load->view($page, $data);
		$this->load->view('template/template_footer');
	}

	public function index($offset=0){
		$this->preload();
		$this->get_list($this->limit,$offset);
		$this->load_view('admin/fvehicle_ops/list_fvehicle_ops', $this->data);
	}

	public function fetch_record($keys){
		$this->data['fvehicle_ops']=$this->fvehicle_ops_dao->by_id($keys);

	}

	private function fetch_data($limit,$offset){
		$this->data['fvehicle_ops'] = $this->fvehicle_ops_dao->fetch($limit,$offset);
	}

	private function fetch_input(){
		$data = array('operation_id' => $this->input->post('operation_id'),
				'fv_id' => $this->input->post('fv_id'),
				'fvo_add_timestamp' => $this->input->post('fvo_add_timestamp'));

		return $data;
	}

	public function save(){
		$obj = $this->fetch_input();
		
		if($this->validate() != false){
			$obj_id = array('operation_id'=>$obj['operation_id'],'fv_id'=>$obj['fv_id']);

			if($this->fvehicle_ops_dao->by_id($obj_id)!=null){
				$this->fvehicle_ops_dao->update($obj, $obj_id);
			}else{
				$this->fvehicle_ops_dao->insert($obj);
			}
			$this->data['saving'] = true;
			redirect(self::$CURRENT_CONTEXT);

		}else{
			/* invalid input will be redirected to edit view with error message included*/
			$this->preload();
			$this->data['edit'] = false;
			#prepare link for back to view list
			$this->data['link_back']=  anchor(self::$CURRENT_CONTEXT.'index/',
							'Back',array('class'=>'back'));
			$this->load_view('admin/fvehicle_ops/fvehicle_ops_edit', $this->data);
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
	public function edit($operation_id = null, $fv_id = null){
			if( $operation_id == null || $fv_id == null 
){
				$this->load_view('admin/fvehicle_ops/fvehicle_ops_edit');
			}else{
				$obj_id = array('operation_id'=>$operation_id,'fv_id'=>$fv_id);

				$to_edit = $this->fvehicle_ops_dao->by_id($obj_id);
				$this->data['obj'] = $to_edit;
				$this->load_view('admin/fvehicle_ops/fvehicle_ops_edit', $this->data);
			}
	}
	/**

		@description
			viewing record. repopulation for every data needed for view.
	*/

	public function view($operation_id = null, $fv_id = null){
			$obj_id =  array('operation_id' => $operation_id,
							'fv_id' => $fv_id);

			$this->preload();
			$this->fetch_record($obj_id);
			#prepare link for back to view list
			$this->data['link_back']=  anchor(self::$CURRENT_CONTEXT.'index/',
								'Back',array('class'=>'back'));
			$this->load_view('admin/fvehicle_ops/view_fvehicle_ops', $this->data);
		
	}

	public function delete($operation_id = null, $fv_id = null){
			$obj_id =  array('operation_id' => $operation_id,
							'fv_id' => $fv_id);

			$this->fvehicle_ops_dao->delete($obj_id);
			redirect(self::$CURRENT_CONTEXT);
	}

	/**
		getting filter parameter when user
		doing searching.
	*/
	public function filter_param(){
			$filter = array();
			$par = $this->input->post('sample');
			if($par != NULL || $par != ''){
				$filter['sample'] = $par;
			}
			// other input receive
			return $filter;
	}

	public function get_list($limit = 16, $offset = 0){
			$obj = $this->filter_param();

			#generate pagination
			$config['base_url']=  site_url(self::$CURRENT_CONTEXT.'index');
			$config['total_rows']=$this->fvehicle_ops_dao->count_all();
			$config['per_page']=$limit;
			$config['uri_segment']= 3;
			$this->pagination->initialize($config);
			$this->data['pagination']=$this->pagination->create_links();
			
			if (empty($obj)){
				// non conditional data fetching
				$this->fetch_data($limit, $offset);
			}else{
				// apply filter
			} 
	}
}