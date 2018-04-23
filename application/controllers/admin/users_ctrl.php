<?php

class users_ctrl extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 16;
    public static $CURRENT_CONTEXT = '/admin/users_ctrl';
    public static $TITLE = 'Pengguna';

    public function __construct() {
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('acl');
        $this->load->library('session');
        $this->load->library('dao/users_dao');
        $this->load->library('dao/corps_dao');
        $this->load->library('dao/role_dao');
        $this->load->library('dao/user_role_dao');
        $this->load->library('form_validation');
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
        $this->load->library('pagination');
        $this->load->library('tank_auth');

        $this->logged_in();
        $this->role_user();
        $this->data['permission'] = all_permission_string($this->session->userdata('user_id'));
        $this->data['idAccessMsg'] = $this->session->userdata(SESSION_USERMSGID);
    }

    private function validate() {
        $this->form_validation->set_rules('username', 'username', '');
        $this->form_validation->set_rules('password', 'password', '');
        $this->form_validation->set_rules('email', 'email', '');
        $this->form_validation->set_rules('corps_id', 'corps_id', '');

        return $this->form_validation->run();
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
        $this->load_view('admin/users/list_users', $this->data);
    }

    /**
      getting filter parameter when user
      doing searching.
     */
    public function filter_param() {
        $filter = array();
        $par = $this->input->post('sample');
        if ($par != NULL || $par != '') {
            $filter['sample'] = $par;
        }
        // other input receive
        return $filter;
    }

    public function get_list($limit = 16, $offset = 0) {
        $obj = $this->filter_param();

        #generate pagination
        $config['base_url'] = site_url(self::$CURRENT_CONTEXT . 'index');
        $config['total_rows'] = $this->users_dao->count_all();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['offset'] = $offset;

        if (empty($obj)) {
            // non conditional data fetching
            $this->fetch_data($limit, $offset);
        } else {
            // apply filter
        }
    }

    private function fetch_data($limit, $offset) {

        $criteria = null;
        $restriction = get_data_restriction($this->session->userdata(SESSION_USERGROUP)); 

        if (!is_null($restriction) && $restriction != '') {
            $criteria = array('corps_id' => $restriction); // edited by SKM17 from users.corps_id to corps_id
			
        }

        $this->data['users'] = $this->users_dao->fetch(1000, $offset, "username", $criteria);
        $this->data['corps'] = $this->corps_dao->fetch(1000, $offset, "corps_name", $criteria); // modified by SKM17 from $limit to 1000 and null to corps_name
        //role user
        $this->data['role'] = $this->role_dao->fetch($limit, $offset, "role_name");
        $this->data['user_role'] = null;
    }

    private function insert($obj) {
        $data['errors'] = array();

        $email_activation = $this->config->item('email_activation', 'tank_auth');

        if ($this->form_validation->run()) {        // validation ok
            if (!is_null($data = $this->tank_auth->create_user(
                            $obj['username'], $obj['email'], $obj['password'], $obj['corps_id'], $email_activation, $obj['users_isactive']))) {         // success // edited by SKM17, add 1 parameter
                $data['site_name'] = $this->config->item('website_name', 'tank_auth');

//                if ($email_activation) {         // send "activate" email
//                    $data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;
//
//                    $this->_send_email('activate', $data['email'], $data);
//
//                    unset($data['password']); // Clear password (just for any case)
//
//                    $this->_show_message($this->lang->line('auth_message_registration_completed_1'));
//                } else {
//                    if ($this->config->item('email_account_details', 'tank_auth')) { // send "welcome" email
//                        $this->_send_email('welcome', $data['email'], $data);
//                    }
//                    unset($data['password']); // Clear password (just for any case)
//
//                    $this->_show_message($this->lang->line('auth_message_registration_completed_2') . ' ' . anchor('/admin/auth/login/', 'Login'));
//                }
            } else {
                $errors = $this->tank_auth->get_error_message();
                foreach ($errors as $k => $v)
                    $data['errors'][$k] = $this->lang->line($v);
            }
        }
//        $data['use_username'] = $use_username;
//        $this->load->view('admin/auth/register_form', $data);
        return $data;
    }

    public function fetch_record($keys) {
        $this->data['users'] = $this->users_dao->by_id($keys);
    }

    private function fetch_input() {
//        $data = array('id' => $this->input->post('id'),
        if ($this->input->post('user_id')) {
            $data['user_id'] = $this->input->post('user_id');
        }
        $data['username'] = $this->input->post('username');
        $data['email'] = $this->input->post('email');
        $data['corps_id'] = $this->input->post('corps_id');
		//echo 'USER ACTIVE : '.$this->input->post('users_isactive'); exit;
		
		/* // commented by SKM17
		$user_active = $this->input->post('users_isactive'); 
		if(strtolower(trim($user_active)) == 'true'){
			$data['users_isactive'] = 't';
		}else{
			$data['users_isactive'] = 'f';
		}
		*/
		$data['users_isactive'] = $this->input->post('users_isactive'); // added by SKM17
		
        return $data;
    }

    public function save() {
        $obj = $this->fetch_input();
        $password = $this->input->post('password');
        $infoSession = ''; // added by SKM17
        
        if ($this->validate() != false) {
//            $obj_id = array('id' => $obj['id']);
			$saved = true; // added by SKM17
            if (isset($obj['user_id']) && $this->users_dao->by_id(array('user_id' => $obj['user_id'])) != null) {
                $obj_id = array('user_id' => $obj['user_id']);
                if ($password != "") {
                    $this->tank_auth->change_password($obj['user_id'], $password);
                }
                $saved = $this->users_dao->update($obj, $obj_id);
                $saving_user_id = $obj;
				$infoSession .= "Data Pengguna berhasil diubah. ";
            } else {
                $obj['password'] = $password;
                $saving_user_id = $this->insert($obj);
				$infoSession .= "Data Pengguna berhasil ditambah. ";
            }
            $this->save_role($saving_user_id['user_id']);
            
            if (!$saved)
            	$infoSession .= "Data Pengguna gagal diubah";
        	
        	$this->session->set_flashdata("info", $infoSession);
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        } else {
            /* invalid input will be redirected to edit view with error message included */
            $this->preload();
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/users/list_users', $this->data);
        }
    }

    public function save_role($user_id) {
    	/* commented by SKM17
        $status_insert = true;

        $rolevalue = array();

        $totalRow = $this->input->post('totalRow');
        //delete logistik in aeroplane first
        $this->user_role_dao->delete(array('user_id' => $user_id));
        //insert new logistik
        for ($i = 1; $i <= $totalRow; $i++) {
            $rolevalue = $this->input->post('roleValue_' . $i);

            $new_role = array('user_id' => $user_id, 'role_id' => $rolevalue);
            $this->user_role_dao->insert($new_role);
        }

        return $status_insert;
        */
        
        // added by SKM17
        $this->user_role_dao->delete(array('user_id' => $user_id));
        $new_role = array('user_id' => $user_id, 'role_id' => $this->input->post('role_id'));
		$this->user_role_dao->insert($new_role);
    }

    /**
      repopulation for reference data done here.
      add different reference data to different array.
      and pass it to views using $this->data[] parameter.
     */
    public function repopulate() {
        
    }

    /**

      @description
      viewing editing form. repopulation for every data needed in form done here.
     */
		public function edit($id = null) {
			$this->preload();
			if ($id == null) {
				$this->load_view('admin/users/list_users');
			} else {
				$this->get_list($this->limit);
				$obj_id = array('user_id' => $id);
				$this->data['user_role'] = $this->user_role_dao->table_fetch($id, $this->limit);

				$to_edit = $this->users_dao->by_id($obj_id);

				if ($to_edit->users_isactive == 't') {
					$to_edit->users_isactive = true;
				} else{
					$to_edit->users_isactive = false;
				}
		    $this->data['obj'] = $to_edit;
		    $this->load_view('admin/users/list_users', $this->data);
			}
		}

    /**

      @description
      viewing record. repopulation for every data needed for view.
     */
    public function view($id = null) {
        $obj_id = array('user_id' => $id);

        $this->preload();
        $this->fetch_record($obj_id);
        #prepare link for back to view list
        $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
        $this->load_view('admin/users/view_users', $this->data);
    }

    public function delete($id = null) {
        $obj_id = array('user_id' => $id);

        $status_del = $this->users_dao->delete($obj_id);
        if ($status_del == false) {
            $this->session->set_flashdata("info", "Hapus pengguna gagal!");
        } else {
            $this->session->set_flashdata("info", "Hapus pengguna berhasil!");
        }
        redirect(self::$CURRENT_CONTEXT);
    }

    /*     * role and permission* */

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
