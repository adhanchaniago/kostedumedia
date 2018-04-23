<?php
class poi_ctrl extends CI_Controller{

	public $data;
	public $filter;
	public $limit = 16;
	public static $CURRENT_CONTEXT = '/admin/poi_ctrl';
    public static $TITLE = "POI";

	public function __construct(){
		parent::__construct();
		$this->data = array();
		$this->load->helper('string');
		$this->load->helper('url');
		$this->load->helper('file');
		$this->load->helper('stringify');
        $this->load->helper('acl');
        $this->load->library('session');
		$this->load->library('dao/poi_dao');
		$this->load->library('dao/operation_dao');
		$this->load->library('dao/aoipoi_type_dao');
		$this->load->library('dao/user_role_dao');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
		$this->load->library('pagination');
		$this->load->library('tank_auth');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->helper('geodesics');


        $this->logged_in();
        $this->role_user();
        $this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
		$this->data['idAccessMsg'] = $this->session->userdata(SESSION_USERMSGID);
	}

	private function validate(){
		
		// $this->form_validation->set_rules('operation_id','operation_id','required');	
		// $this->form_validation->set_rules('aptype_id','aptype_id','required');
		
		$this->form_validation->set_rules('poi_lat', 'poi_lat', '');
		$this->form_validation->set_rules('poi_lon', 'poi_lon', '');	
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

	public function index($offset=0 ,$limit=16){
		$this->preload();
		$this->get_list($this->limit,$offset);
		$this->load_view('admin/poi/list_poi', $this->data);
	}

	public function fetch_record($keys){
		$this->data['pois']=$this->poi_dao->by_id($keys);

	}

	private function fetch_data($limit,$offset,$filter=null){
		$this->data['pois'] = $this->poi_dao->table_fetch($limit,$offset,$filter);
		$this->data['poi_icon'] = array();
		$this->data['poi_icon']=$this->poi_dao->fetch($limit , $offset, 'poi_id');

		$operations = $this->operation_dao->fetch_All();
		// $operation_pv = 322;
        $operation_pv = array();
        // $operation_pv = '451';
        // $operation_pv['1'] = '-';

        foreach ($operations as $u) {
            if ($u->operation_id >= 1 ) {
                $operation_pv[$u->operation_id] = $u->operation_name;

            }

        // if 	( $operation === '' )
        // {
        // 	$infoSession .= "ga ada nilai ";
        // }

        }

        $this->data['operation'] = $operation_pv;

        // $aptypes = $this->aoipoi_type_dao->fetch_All();
        $aptypes = $this->aoipoi_type_dao->fetch(1000, 0, 'aptype_name');
        $aptype_vp = array();
        // $aptype_vp['3'] = '-';
        foreach ($aptypes as $u) {
            if ($u->aptype_id >= 1) {
                $aptype_vp[$u->aptype_id] = $u->aptype_name;
            }
        }
        $this->data['aptype'] = $aptype_vp;

        $this->data['poi_ctrl'] = $this->poi_dao->fetch($limit, $offset, 'poi_icon');
	}
	

	private function fetch_input(){
		$data = array(
			'operation_id' => $this->input->post('operation_id'),
			'aptype_id' => $this->input->post('aptype_id'),
			'poi_name' => $this->input->post('poi_name'),
			// 'poi_icon' => $this->input->post('poi_icon'),
			'poi_description' => $this->input->post('poi_description'),
			'poi_lat' => toGeoDec($this->input->post('poi_dlat'),$this->input->post('poi_mlat'),$this->input->post('poi_slat'),$this->input->post('poi_rlat')),
			'poi_lon' => toGeoDec($this->input->post('poi_dlon'),$this->input->post('poi_mlon'),$this->input->post('poi_slon'),$this->input->post('poi_rlon'))
	//$data['poi_lat'] = toGeoDec($this->getValue('poi_dlat'), $this->getValue('poi_mlat'), $this->getValue('poi_slat'), $this->getValue('poi_rlat'));
	//$data['poi_lon'] = toGeoDec($this->getValue('poi_dlon'), $this->getValue('poi_mlon'), $this->getValue('poi_slon'), $this->getValue('poi_rlon'));
	
		);
		return $data;
	}

	public function save() {
        $obj = $this->fetch_input();
        // print_r($obj);
        // die();
        $id = $this->input->post('poi_id');
		$infoSession = ''; // added by SKM17

		if ($this->validate() != false) {

			// added by SKM17 {
			$config_poi['upload_path'] = './assets/img/upload/icon/IconPoi';
			$config_poi['allowed_types'] = 'gif|jpeg|png|jpg';
			$config_poi['max_width'] = 700;
			$config_poi['max_height'] = 700;
			$config_poi['max_size'] = 1000;
			$config_poi['encrypt_name'] = TRUE;

			$this->upload->initialize($config_poi);


			$info = '';        
            if ($_FILES['poi_icon']['name']!=''){
                if ($this->upload->do_upload('poi_icon')) {
                    $info = $this->upload->data();
                    $obj['poi_icon'] = $info['file_name'];
                    $infoSession .= "Gambar POI Icon berhasil diunggah. ";
                    
                } else {
                    $this->data['error_main_image'] = TRUE;
                    $this->data['msg_error_main_image'] = strip_tags($this->upload->display_errors());
                    $infoSession .= "<font color='red'>Gambar POI Icon GAGAL diunggah. Silakan masukan gambar dibawah 1MB dan Ukuran pixel dibawah 100 x 100 .</font>";
                    $this->session->set_flashdata("info", $infoSession);
                    redirect(self::$CURRENT_CONTEXT);
                }                
            } else {
                // $infoSession .= "<font color='red'>Gambar tidak diubah. </font>";
            }


			// } END ADDED
			
			$saved; // added by SKM17
			if ($id != null) {
                $obj_id = array('poi_id'=>$this->input->post('poi_id'));
                $saved = $this->poi_dao->update($obj, $obj_id);
				$infoSession .= "Data POI Lawan berhasil diubah. ";
            } else {
				$saved = $this->poi_dao->insert($obj);
				$infoSession .= "Data POI Lawan berhasil ditambah. ";
            }
        	
        	$this->session->set_flashdata("info", $infoSession);
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
		} 

		else {
			/* invalid input will be redirected to edit view with error message included */
			$this->preload();
			$this->data['edit'] = false;
			#prepare link for back to view list
			$this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
			$this->load_view('admin/poi/list_poi', $this->data);
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
	public function edit($poi_id = null){
			// $this->preload();
        if ($poi_id == null) {
            $this->load_view('admin/poi/list_poi');
        } else {
            // $param = $this->get_list($this->limit);
            $obj_id = array('poi_id' => $poi_id);

            $to_edit = $this->poi_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;
            $this->data['obj']->point = $this->poi_dao->fetch_area_point($poi_id);
            $this->preload();
            $this->get_list($this->limit,0);
            $this->load_view('admin/poi/list_poi', $this->data);
        }
	}
	/**

		@description
			viewing record. repopulation for every data needed for view.
	*/


	public function delete($poi_id = null){
		$obj_id =  array('poi_id' => $poi_id);
		//$file = $this->poi_dao->delete_icon($poi_id);

		//menghapus gambar di folder added d3 POLBAN
        $image=$this->poi_dao->by_id($obj_id);
        unlink($this->config->item('root_path')."assets/img/upload/icon/IconPoi/".$image->poi_icon);


		$status_del = $this->poi_dao->delete($obj_id);
		if ($status_del == false) {
			$this->session->set_flashdata("info", "Hapus Data Area POI gagal!");
		} else {
			// foreach ($file as $row) {
			// 	unlink('./assets/img/upload/icon/IconPoi'.$row->poi_icon);
			// }
			// die();
			$this->session->set_flashdata("info", "Hapus Data Area POI berhasil!");
		}
		redirect(self::$CURRENT_CONTEXT);
	}

	/**
		getting filter parameter when user
		doing searching.
	*/
	public function filter_param(){
		$filter = array();
		$par = $this->input->post('poi_name');
		if($par != NULL || $par != ''){
			$filter['poi_name'] = $par;
		}
		// other input receive
		return $filter;
	}

	public function get_list($limit = 16, $offset = 0){
		$obj = $this->filter_param();

		#generate pagination
		$filter = (!empty($obj)) ? $obj : null;
		$config['base_url']=  site_url(self::$CURRENT_CONTEXT.'/index');
		$config['total_rows']=$this->poi_dao->count_table_fetch($filter);
		$config['per_page']=$limit;
		$config['uri_segment']= 4;
		$this->pagination->initialize($config);
		$this->data['pagination']=$this->pagination->create_links();
		$this->data['offset'] = $offset;

		$this->fetch_data($limit, $offset,$filter);
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