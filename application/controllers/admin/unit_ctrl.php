<?php

class unit_ctrl extends CI_Controller{

    public $data;
    public $filter;
    public $limit = 16;
	public static $CURRENT_CONTEXT = '/admin/unit_ctrl';
    public static $TITLE = "Kesatuan";
    
    public function __construct(){
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
		$this->load->helper('url');
		$this->load->helper('stringify');
        $this->load->helper('acl');
        $this->load->library('dao/unit_dao');
        $this->load->library('dao/user_role_dao');
		$this->load->library('form_validation');
        $this->load->library('session');
		$this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
		$this->load->library('pagination');
		$this->load->library('tank_auth');

        $this->logged_in();
        $this->role_user();
        $this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
        $this->data['idAccessMsg'] = $this->session->userdata(SESSION_USERMSGID);
    }
    
    public function preload(){
		$this->data['current_context'] = self::$CURRENT_CONTEXT;
        $this->data['title'] = self::$TITLE;
    }

    public function load_view($page, $data = null){
        $this->load->view('template/template_header', $data);
        $this->load->view('template/template_menu', $this->data);
        $this->load->view($page);
        $this->load->view('template/template_footer');
    }

    private function validate(){
		$this->form_validation->set_rules('unit_id','unit_id','');
		$this->form_validation->set_rules('unit_name','unit_name','required');
		$this->form_validation->set_rules('unitcat_id','unitcat_id','required');
			
        return $this->form_validation->run();
    }

    public function index($offset=0){
        $this->preload();
        $this->get_list($this->limit,$offset);
        $this->load_view('admin/unit/list_unit', $this->data);
    }

    /**
        getting filter parameter when user
        doing searching.
    */
    public function filter_param(){
        $filter = array();
        if (isset($_GET['filter'])) {
            $filter['unit_name'] = $this->input->get('unit_name');
            $filter['unitcat_id'] = $this->input->get('unitcat_id');
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
        $config['base_url'] = site_url($base_url);
        $config['total_rows'] = $this->unit_dao->count_table_fetch($obj);
        $config['per_page'] = $limit;
        $config['uri_segment'] = $uri;
        $config['filter_param'] = $_SERVER['QUERY_STRING'];
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        
        $this->data['offset'] = $offset;
        $this->fetch_data($limit, $offset, $obj);
    }

    private function fetch_data($limit, $offset, $filter){
        $this->data['unit'] = $this->unit_dao->fetch_data($filter, $limit, $offset, 'unit_name');
        $this->data['unit_category'] = $this->unit_dao->fetch_unit_category();
    }

    public function fetch_record($keys){
        $this->data['unit']=$this->unit_dao->by_id($keys);
    }

    private function fetch_input(){
        $data = array(
			'unit_name' => $this->input->post('unit_name'),
			'unitcat_id' => $this->input->post('unitcat_id')
		);
        if ($this->input->post('unit_id')) {
            $data['unit_id'] = $this->input->post('unit_id');
        }

        return $data;
    }

    public function save(){
        $obj = $this->fetch_input();
        $infoSession = ''; // added by SKM17
        
		$saved; // added by SKM17
        if($this->validate() != false){
			if (!isset($obj['unit_id'])) {
				$saved = $this->unit_dao->insert($obj);
				$infoSession .= "Data Kesatuan berhasil ditambah. ";
			} else {
				$obj_id = array('unit_id' => $obj['unit_id']);
				$saved = $this->unit_dao->update($obj, $obj_id);
				$infoSession .= "Data Kesatuan berhasil diubah. ";
			}
            
            if (!$saved)
            	$infoSession .= "Data Kesatuan gagal ditambah/diubah. ";
            	
            $this->session->set_flashdata("info", $infoSession);
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        }
        else{
			$this->session->set_flashdata('info','Data Kesatuan gagal disimpan.');
            redirect(self::$CURRENT_CONTEXT);
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
    public function edit ($unit_id = null) {
        $this->preload();
        if ($unit_id == null) {
            $this->load_view('admin/unit/list_unit');
        } else {
            $obj_id = array('unit_id' => $unit_id);

            $to_edit = $this->unit_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            $this->get_list($this->limit);
            $this->load_view('admin/unit/list_unit', $this->data);
        }
    }
    
    /**
        @description
            viewing record. repopulation for every data needed for view.
    */

	public function detail($unit_id){
        $obj_id =  array('unit_id' => $unit_id);

        $this->preload();
        $this->fetch_record($obj_id);
        #prepare link for back to view list
        $this->data['link_back']=  anchor(CURRENT_CONTEXT.'index/',
                            'Back',array('class'=>'back'));
        $this->load_view('admin/unit/unit_detail', $this->data);
        
    }

    public function delete($unit_id){
        $obj_id =  array('unit_id' => $unit_id);

        if ($this->unit_dao->delete($obj_id))
        	$this->session->set_flashdata("info", "Hapus Kesatuan berhasil!");
        else
        	$this->session->set_flashdata("info", "Hapus Kesatuan gagal!");
        
        redirect(self::$CURRENT_CONTEXT);
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
