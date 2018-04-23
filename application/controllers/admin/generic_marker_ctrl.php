<?php
class generic_marker_ctrl extends CI_Controller{

    public $data;
    public $filter;
    public $limit = 1000;
	public static $CURRENT_CONTEXT = '/admin/generic_marker_ctrl';
    public function __construct(){
        parent::__construct();
        define('CURRENT_CONTEXT', 'admin/generic_marker_ctrl/');
        $this->data = array();
		$this->load->helper('string');
		$this->load->helper('url');
		$this->load->helper('stringify');
        $this->load->helper('acl');
        $this->load->library('dao/generic_marker_dao');
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
        // $this->form_validation->set_rules('gmark_id','gmark_id','required');
			$this->form_validation->set_rules('gmark_name','gmark_name','required');
			$this->form_validation->set_rules('gmark_lat','gmark_lat','trim');
			$this->form_validation->set_rules('gmark_lon','gmark_lon','trim');
			$this->form_validation->set_rules('gmarkcat_id','gmarkcat_id','required');
			// $this->form_validation->set_rules('gmark_icon','gmark_icon','required');
			$this->form_validation->set_rules('gmark_desc','gmark_desc','required');
			$this->form_validation->set_rules('gmarktype_id','gmarktype_id','required');
			$this->form_validation->set_rules('gmark_radius','gmark_radius','trim');
			
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
        $this->load_view('admin/generic_marker/list_generic_marker', $this->data);
    }

    public function fetch_record($keys){
        $this->data['generic_marker']=$this->generic_marker_dao->by_id($keys);
    }

    private function fetch_data($limit,$offset){
        $this->data['generic_marker'] = $this->generic_marker_dao->fetch_data(null,$limit,$offset);
        $this->data['generic_marker_category'] = $this->generic_marker_dao->fetch_generic_marker_category();
        $this->data['generic_marker_type'] = $this->generic_marker_dao->fetch_generic_marker_type();
    }

    private function fetch_input(){
        $data = array('gmark_id' => $this->input->post('gmark_id'),
				'gmark_name' => $this->input->post('gmark_name'),
				'gmark_lat' => $this->input->post('gmark_lat'),
				'gmark_lon' => $this->input->post('gmark_lon'),
				'gmarkcat_id' => $this->input->post('gmarkcat_id'),
				// 'gmark_icon' => $this->input->post('gmark_icon'),
				'gmark_desc' => $this->input->post('gmark_desc'),
				'gmarktype_id' => $this->input->post('gmarktype_id'),
				'gmark_radius' => $this->input->post('gmark_radius'));

        return $data;
    }

    public function save(){
        $obj = $this->fetch_input();
        if($this->validate() != false){
			if($obj['gmarktype_id']==2){
				$obj['area_point'] = $this->input->post('area_point');
			}
			if(!$this->input->post('gmark_id')){
				$this->session->set_flashdata('info','Data berhasil disimpan');
				$this->generic_marker_dao->insert_generic_marker($obj);
			}else{
				$this->session->set_flashdata('info','Data berhasil diedit');
				$obj_id = array('gmark_id'=>$this->input->post('gmark_id'));
				$this->generic_marker_dao->update_generic_marker($obj,$obj_id);
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
    public function edit($gmark_id=null){
            if( $gmark_id == null){
				redirect(CURRENT_CONTEXT.'/index/');
			}else{
				
				$obj_id = array('gmark_id'=>$gmark_id);

				$to_edit = $this->generic_marker_dao->by_id($obj_id);
				$this->data['obj'] = $to_edit;
				$this->data['obj']->point = $this->generic_marker_dao->fetch_area_point($gmark_id);
				$this->preload();
				$this->get_list($this->limit,0);
				$this->load_view('admin/generic_marker/list_generic_marker', $this->data);
			}
    }
    /**
        @description
            viewing record. repopulation for every data needed for view.
    */

    public function detail($gmark_id){
            $obj_id =  array('gmark_id' => $gmark_id);

            $this->preload();
            $this->fetch_record($obj_id);
            #prepare link for back to view list
            $this->data['link_back']=  anchor(CURRENT_CONTEXT.'index/',
                                'Back',array('class'=>'back'));
            $this->load_view('admin/generic_marker/generic_marker_detail', $this->data);
        
    }

    public function delete($gmark_id){
            $obj_id =  array('gmark_id' => $gmark_id);

            $this->generic_marker_dao->delete_generic_marker($obj_id);
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
            $config['total_rows']=$this->generic_marker_dao->count_all();
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