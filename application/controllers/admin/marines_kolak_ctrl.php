<?php
class marines_kolak_ctrl extends CI_Controller{

    public $data;
    public $filter;
    public $limit = 16;
    public static $CURRENT_CONTEXT = '/admin/marines_kolak_ctrl';
    public static $TITLE = "Komando Pelaksana";

    public function __construct(){
        parent::__construct();
        define('CURRENT_CONTEXT', 'admin/marines_kolak_ctrl/');
        $this->data = array();
        $this->load->helper('url');
		$this->load->helper('string');
		$this->load->library('session');
        $this->load->helper('acl');
        $this->load->library('dao/marines_kolak_dao');
        $this->load->library('dao/corps_dao');
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
        $this->form_validation->set_rules('corps_id','corps_id','required');
			// $this->form_validation->set_rules('kolak_id','kolak_id','required');
			$this->form_validation->set_rules('kolak_description','kolak_description','required');
			
        return $this->form_validation->run();
    }
    /**
        prepare data for view 
    */
    public function preload(){
        $this->data['current_context'] = self::$CURRENT_CONTEXT;
        $this->data['title'] = self::$TITLE;
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
		$this->data['corps'] = $this->corps_dao->fetch();
        $this->load_view('admin/marines_kolak/marines_kolak_list', $this->data);
    }

    public function fetch_record($keys){
        $this->data['marines_kolak']=$this->marines_kolak_dao->by_id($keys);
    }

    private function fetch_data($limit,$offset){
        $this->data['marines_kolak'] = $this->marines_kolak_dao->table_fetch($limit,$offset);
    }

    private function fetch_input(){
        $data = array('corps_id' => $this->input->post('corps_id'),
				// 'kolak_id' => $this->input->post('kolak_id'),
				'kolak_description' => $this->input->post('kolak_description'));

        return $data;
    }

    public function save(){
        $obj = $this->fetch_input();
        
        if($this->validate() != false){
            if(!$this->input->post('kolak_id')){
				$this->session->set_flashdata('info','Data berhasil dimasukan');
				$this->marines_kolak_dao->insert($obj);
			}else{
				$this->session->set_flashdata('info','Data berhasil diedit');
				$obj_id['kolak_id'] = $this->input->post('kolak_id');
				$this->marines_kolak_dao->update($obj,$obj_id);
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
    public function edit($kolak_id){
		if( $kolak_id == null){
			redirect(CURRENT_CONTEXT.'/index/');
		}else{
			$this->preload();
			if($this->uri->segment(5)==""){
				$offset = 0;
			}else{
				$offset = $this->uri->segment(5);
			}
			$this->get_list($this->limit,$offset);
			$obj_id = array('kolak_id'=>$kolak_id);
			$this->data['corps'] = $this->corps_dao->fetch();
			$to_edit = $this->marines_kolak_dao->by_id($obj_id);
			$this->data['obj'] = $to_edit;
			$this->load_view('admin/marines_kolak/marines_kolak_list', $this->data);
			
		}
    }
    /**
        @description
            viewing record. repopulation for every data needed for view.
    */

    public function detail($kolak_id){
            $obj_id =  array('kolak_id' => $kolak_id);

            $this->preload();
            $this->fetch_record($obj_id);
            #prepare link for back to view list
            $this->data['link_back']=  anchor(CURRENT_CONTEXT.'index/',
                                'Back',array('class'=>'back'));
            $this->load_view('admin/marines_kolak/marines_kolak_detail', $this->data);
        
    }

    public function delete($kolak_id){
            $obj_id =  array('kolak_id' => $kolak_id);

            $this->marines_kolak_dao->delete($obj_id);
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
		if($this->uri->segment(3)=='edit'){
			$base_url = self::$CURRENT_CONTEXT . '/edit/'.$this->uri->segment(4);
			$uri = 5;
		}else{
			$base_url = self::$CURRENT_CONTEXT . '/index/';
			$uri = 4;
		}
		$config['base_url']=  site_url($base_url);
		$config['total_rows'] = $this->marines_kolak_dao->count_all();
		$config['per_page'] = $limit;
		$config['uri_segment']= $uri;
		$this->pagination->initialize($config);
		$this->data['pagination']=$this->pagination->create_links();
		$this->data['offset'] = $offset;
		$this->fetch_data($limit, $offset);
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