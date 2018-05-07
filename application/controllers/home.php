<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('security');
        $this->load->library('session');
        $this->load->library('tank_auth');
        // $this->load->library('dao/user_role_dao');
        $this->load->model('Kosts','',TRUE);
        $this->lang->load('tank_auth');
    }

    public function index() {
        $this->is_logged_in();

        $this->load->view('home/home');
    }

//    public function login() {
//        if ($this->session->userdata('user_login')) {
//            redirect('');
//        }
//        $this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
//        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
//        if ($this->form_validation->run() === TRUE) {
//            if (strtolower($this->input->post('login')) == 'operator' && strtolower($this->input->post('password')) == 'operator') {
//                $this->session->set_userdata('user_login', 'operator');
//                redirect('');
//            } else if (strtolower($this->input->post('login')) == 'viewer' && strtolower($this->input->post('password')) == 'viewer') {
//                $this->session->set_userdata('user_login', 'viewer');
//                redirect('');
//            }
//        }
//        $this->load->view('home/login');
//    }

    /**
     * Login user on the site
     *
     * @return void
     */
    function login() {

        if ($this->tank_auth->is_logged_in()) {         // logged in
            $this->roleUserRedirect();
//            redirect('admin/corps_ctrl');
        } else {
            $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
                    $this->config->item('use_username', 'tank_auth'));
            $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');
            //rules : trim|required|xss_clean
            $this->form_validation->set_rules('login', 'Login', '');
            $this->form_validation->set_rules('password', 'Password', '');

            // Get login for counting attempts to login
            if ($this->config->item('login_count_attempts', 'tank_auth') AND
                    ($login = $this->input->post('login'))) {
                $login = $this->security->xss_clean($login);
            } else {
                $login = '';
            }

            //captcha
			$data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
			if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
				if ($data['use_recaptcha'])
					$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				else
					$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
			}
            //captcha
            $data['errors'] = array();

            if ($this->form_validation->run()) {        // validation ok
                if ($this->tank_auth->login(
                                $this->form_validation->set_value('login'), $this->form_validation->set_value('password'), $this->form_validation->set_value('remember'), $data['login_by_username'], $data['login_by_email'])) {        // success
                    $this->roleUserRedirect();
//                    redirect('admin/corps_ctrl');
                } else {
                    $errors = $this->tank_auth->get_error_message();
                    if (isset($errors['banned'])) {        // banned user
                        $this->_show_message($this->lang->line('auth_message_banned') . ' ' . $errors['banned']);
                    } elseif (isset($errors['not_activated'])) {    // not activated user
                        redirect('/admin/auth/send_again/');
                    } else {             // fail
                        foreach ($errors as $k => $v)
                            $data['errors'][$k] = $this->lang->line($v);
                    }
                }
            }else{

                
            }
            // ALWAYS USE CAPTCHA
            $data['show_captcha'] = TRUE;
            $data['captcha_html'] = $this->_create_captcha();


   //          $data['show_captcha'] = FALSE;
			// if ($this->tank_auth->is_max_login_attempts_exceeded($login)) 
   //          {
			// 	$data['show_captcha'] = TRUE;
			// 	if ($data['use_recaptcha']) {
			// 		$data['recaptcha_html'] = $this->_create_recaptcha();
			// 	} else {
			// 		$data['captcha_html'] = $this->_create_captcha();
			// 	}
			// }
//            $this->load->view('admin/auth/login_form', $data);
            $this->load->view('home/login', $data);
        }
    }

//     public function roleUserRedirect() {
//         $user_id = $this->tank_auth->get_user_id();
//         $user = $this->user_role_dao->fetch_record($user_id);
        
//         //print_r($user);
//         if($user == null){
//             $this->logout();
// //            redirect('home/login');//prepare for undifine role page
//         }
        
//         // if($user->corps_id != 3){ // commented by SKM17
//             $this->session->set_userdata(SESSION_USERGROUP, $user->corps_id);
//             $this->session->set_userdata(SESSION_USERMSGID, $user->msg_acc_id);
//         // }
        

//         if(trim($user->role_name) == 'admin'){
//             //redirect('admin/dashboard_ctrl');
// 			redirect('html/map_clean');
//         }else{
//             redirect('html/map_clean');
//         }
//     }

    public function roleUserRedirect() {
        $user_id = $this->tank_auth->get_user_id();
        // $user = $this->user_role_dao->fetch_record($user_id);
        $user = $this->Kosts->getUserById($user_id);
        
        //print_r($user);
        if($user == null){
            $this->logout();
//            redirect('home/login');//prepare for undifine role page
        }
        
        // if($user->corps_id != 3){ // commented by SKM17
            // $this->session->set_userdata(SESSION_USERGROUP, $user->corps_id);
            // $this->session->set_userdata(SESSION_USERMSGID, $user->msg_acc_id);
        // }
        

        if(trim($user->role_name) == 'admin'){
            //redirect('admin/dashboard_ctrl');
            redirect('html/map_clean');
        }else{
            redirect('html/map_clean');
        }
    }

//    public function logout() {
//        $this->session->unset_userdata('user_login');
//        redirect('');
//    }
    /**
     * Logout user
     *
     * @return void
     */
    function logout() {
        $this->tank_auth->logout();
        redirect('');
//        $this->_show_message($this->lang->line('auth_message_logged_out'));
    }

    private function is_logged_in() {
        $sess = $this->session->userdata('user_login');
        if (!isset($sess) || $sess == false) {
            redirect('html/map_clean');
        }
    }

	/**
	 * Create CAPTCHA image to verify user as a human
	 *
	 * @return	string
	 */
	public function _create_captcha()
	{
		$this->load->helper('captcha');

		$cap = create_captcha(array(
			'img_path'		=> './'.$this->config->item('captcha_path', 'tank_auth'),
			'img_url'		=> base_url().$this->config->item('captcha_path', 'tank_auth'),
			'font_path'		=> './'.$this->config->item('captcha_fonts_path', 'tank_auth'),
			// 'font_size'		=> $this->config->item('captcha_font_size', 'tank_auth'),
         // 'word_length'   => 4, // to change this, go to system/helpers/captcha_helper.php
			'img_width'		=> $this->config->item('captcha_width', 'tank_auth'),
			'img_height'	=> $this->config->item('captcha_height', 'tank_auth'),
			'show_grid'		=> $this->config->item('captcha_grid', 'tank_auth'),
			'expiration'	=> $this->config->item('captcha_expire', 'tank_auth'),
		));

		// Save captcha params in session
		$this->session->set_flashdata(array(
				'captcha_word' => $cap['word'],
				'captcha_time' => $cap['time'],
		));

		return $cap['image'];
	}

	/**
	 * Callback function. Check if CAPTCHA test is passed.
	 *
	 * @param	string
	 * @return	bool
	 */
	public function _check_captcha($code)
	{
		$time = $this->session->flashdata('captcha_time');
		$word = $this->session->flashdata('captcha_word');

		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);

		if ($now - $time > $this->config->item('captcha_expire', 'tank_auth')) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
			return FALSE;

		} elseif (($this->config->item('captcha_case_sensitive', 'tank_auth') AND
				$code != $word) OR
				strtolower($code) != strtolower($word)) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
