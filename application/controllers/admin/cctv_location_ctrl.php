<?php
class cctv_location_ctrl extends CI_Controller{

    public $data;
    public $filter;
    public $limit = 1000;
	public static $CURRENT_CONTEXT = '/admin/cctv_location_ctrl';
    public function __construct(){
        parent::__construct();
        define('CURRENT_CONTEXT', 'admin/cctv_location_ctrl/');
        $this->data = array();
        $this->load->helper('string');
		$this->load->helper('url');
		$this->load->helper('stringify');
        $this->load->helper('acl');
		$this->load->library('dao/cctv_location_dao');
		$this->load->library('dao/user_role_dao');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
		$this->load->library('pagination');
		$this->load->library('tank_auth');
		$this->logged_in();
        $this->role_user();
        $this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
    }

    private function validate(){
        // $this->form_validation->set_rules('cctvloc_id','cctvloc_id','required');
			$this->form_validation->set_rules('cctvloc_name','cctvloc_name','required');
			$this->form_validation->set_rules('cctvloc_lat','cctvloc_lat','required');
			$this->form_validation->set_rules('cctvloc_lon','cctvloc_lon','required');
			$this->form_validation->set_rules('cctvloc_url','cctvloc_url','required');
			$this->form_validation->set_rules('cctvloc_desc','cctvloc_desc','required');
			
        return $this->form_validation->run();
    }
    /**
        prepare data for view 
    */
    public function preload(){
		$this->data['current_context'] = self::$CURRENT_CONTEXT;
        // $this->data['current_context'] = CURRENT_CONTEXT;
    }

    public function load_view($page, $data){
        $this->load->view('template/template_header',$data);
		$this->load->view('template/template_menu',$this->data);
		$this->load->view($page, $data);
		$this->load->view('template/template_footer');
    }

    public function index($offset=0){
        $this->preload();
        $this->get_list($this->limit,$offset);
        $this->load_view('admin/cctv_location/list_cctv_location', $this->data);
    }

    public function fetch_record($keys){
        $this->data['cctv_location']=$this->cctv_location_dao->by_id($keys);
    }

    private function fetch_data($limit,$offset){
        $this->data['cctv_location'] = $this->cctv_location_dao->fetch($limit,$offset);
    }

    private function fetch_input(){
        $data = array(
				'cctvloc_name' => $this->input->post('cctvloc_name'),
				'cctvloc_lat' => $this->input->post('cctvloc_lat'),
				'cctvloc_lon' => $this->input->post('cctvloc_lon'),
				'cctvloc_url' => $this->input->post('cctvloc_url'),
				'cctvloc_desc' => $this->input->post('cctvloc_desc'),
				'cctvloc_username' => $this->input->post('cctvloc_username'),
				'cctvloc_password' => $this->input->post('cctvloc_password')
		);

        return $data;
    }

    public function save(){
        $obj = $this->fetch_input();
        if($this->validate() != false){
			if(!$this->input->post('cctvloc_id')){
				$this->session->set_flashdata('info','Data berhasil dimasukan');
				$this->cctv_location_dao->insert($obj);
			}else{
				$this->session->set_flashdata('info','Data berhasil diedit');
				$obj_id['cctvloc_id'] = $this->input->post('cctvloc_id');
				$this->cctv_location_dao->update($obj,$obj_id);
			}
            redirect(base_url().CURRENT_CONTEXT);
        }
        else{
            $this->session->set_flashdata('info','Data Gagal dimasukan');
			redirect(CURRENT_CONTEXT.'/index/');
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
    public function edit($cctvloc_id=null){
            if( $cctvloc_id == null){
				redirect(CURRENT_CONTEXT.'/index/');
			}else{
				
				$obj_id = array('cctvloc_id'=>$cctvloc_id);

				$to_edit = $this->cctv_location_dao->by_id($obj_id);
				$this->data['obj'] = $to_edit;
				$this->preload();
				$this->get_list($this->limit,0);
				$this->load_view('admin/cctv_location/list_cctv_location', $this->data);
			}
    }
    /**
        @description
            viewing record. repopulation for every data needed for view.
    */

    public function detail($cctvloc_id){
            $obj_id =  array('cctvloc_id' => $cctvloc_id);

            $this->preload();
            $this->fetch_record($obj_id);
            #prepare link for back to view list
            $this->data['link_back']=  anchor(CURRENT_CONTEXT.'index/',
                                'Back',array('class'=>'back'));
            $this->load_view('admin/cctv_location/cctv_location_detail', $this->data);
        
    }

    public function delete($cctvloc_id){
            $obj_id =  array('cctvloc_id' => $cctvloc_id);

            $this->cctv_location_dao->delete($obj_id);
            redirect(base_url().CURRENT_CONTEXT);
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
            $config['base_url']=  site_url(CURRENT_CONTEXT.'index');
            $config['total_rows']=$this->cctv_location_dao->count_all();
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
?>