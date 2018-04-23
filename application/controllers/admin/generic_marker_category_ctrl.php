<?php
class generic_marker_category_ctrl extends CI_Controller{

    public $data;
    public $filter;
    public $limit = 16;

    public function __construct(){
        parent::__construct();
        define('CURRENT_CONTEXT', 'admin/generic_marker_category_ctrl/');
        $this->data = array();
        $this->load->helper('url');
        $this->load->library('dao/generic_marker_category_dao');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    private function validate(){
        $this->form_validation->set_rules('gmarkcat_id','gmarkcat_id','required');
			$this->form_validation->set_rules('gmarkcat_name','gmarkcat_name','required');
			$this->form_validation->set_rules('gmarkcat_icon','gmarkcat_icon','required');
			
        return $this->form_validation->run();
    }
    /**
        prepare data for view 
    */
    public function preload(){
        $this->data['current_context'] = CURRENT_CONTEXT;
    }

    public function load_view($page, $data){
        //$this->load->view('template/template_header');
        //$this->load->view('template/template_menu');
        $this->load->view($page, $data);
        //$this->load->view('template/template_footer');
    }

    public function index($offset=0){
        $this->preload();
        $this->get_list($this->limit,$offset);
        $this->load_view('admin/generic_marker_category/generic_marker_category_list', $this->data);
    }

    public function fetch_record($keys){
        $this->data['generic_marker_category']=$this->generic_marker_category_dao->by_id($keys);
    }

    private function fetch_data($limit,$offset){
        $this->data['generic_marker_category'] = $this->generic_marker_category_dao->fetch($limit,$offset);
    }

    private function fetch_input(){
        $data = array('gmarkcat_id' => $this->input->post('gmarkcat_id'),
				'gmarkcat_name' => $this->input->post('gmarkcat_name'),
				'gmarkcat_icon' => $this->input->post('gmarkcat_icon'));

        return $data;
    }

    public function save(){
        $obj = $this->fetch_input();
        
        if($this->validate() != false){
            $this->generic_marker_category_dao->insert($obj);
            redirect(base_url().CURRENT_CONTEXT);
        }
        else{
            $this->preload();
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back']=  anchor(CURRENT_CONTEXT.'index/',
                            'Back',array('class'=>'back'));
            $this->load_view('admin/generic_marker_category/generic_marker_category_insert', $this->data);
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
    public function edit($gmarkcat_id){
            $obj = $this->fetch_input();
            
            $obj_id =  array('gmarkcat_id' => $gmarkcat_id);

            if($this->validate() != false){
                $this->generic_marker_category_dao->update($obj, $obj_id);
                redirect(base_url().CURRENT_CONTEXT);
            }
            else{
                $this->preload();
                $this->data['edit'] = true;
                $this->fetch_record($obj_id);
                #prepare link for back to view list
                $this->data['link_back']=  anchor(CURRENT_CONTEXT.'detail/'.$gmarkcat_id,
                                'Back',array('class'=>'back'));
                $this->load_view('admin/generic_marker_category/generic_marker_category_insert', $this->data);
                
            }
    }
    /**
        @description
            viewing record. repopulation for every data needed for view.
    */

    public function detail($gmarkcat_id){
            $obj_id =  array('gmarkcat_id' => $gmarkcat_id);

            $this->preload();
            $this->fetch_record($obj_id);
            #prepare link for back to view list
            $this->data['link_back']=  anchor(CURRENT_CONTEXT.'index/',
                                'Back',array('class'=>'back'));
            $this->load_view('admin/generic_marker_category/generic_marker_category_detail', $this->data);
        
    }

    public function delete($gmarkcat_id){
            $obj_id =  array('gmarkcat_id' => $gmarkcat_id);

            $this->generic_marker_category_dao->delete($obj_id);
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
            $config['total_rows']=$this->generic_marker_category_dao->count_all();
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
?>