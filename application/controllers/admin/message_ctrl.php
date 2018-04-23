<?php

class message_ctrl extends CI_Controller{

    public $data;
    public $filter;
    public $limit = 16;
    public static $CURRENT_CONTEXT = '/admin/message_ctrl';
    public static $TITLE = "Pesan";
    
    public function __construct(){
        parent::__construct();
        $this->data = array();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('stringify');
        $this->load->helper('acl');
        $this->load->library('dao/message_dao');
        $this->load->library('dao/ship_dao');
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

    private function validate() {
        $this->form_validation->set_rules('id_pesan', 'id_pesan', '');

        return $this->form_validation->run();
    }

    public function preload($url = '') {
        $this->data['current_context'] = self::$CURRENT_CONTEXT . '/' . $url;
        $this->data['title'] = self::$TITLE;
    }

    public function load_message_count() {
        $this->data['n_new_inbox'] = $this->message_dao->count('state', '6');
       $this->data['n_new_draf'] = $this->message_dao->count('state', '0');
        $this->data['n_new_status'] = $this->message_dao->count('state', '5');
    }
    
    public function load_view($page, $data = null) {
        $this->load_message_count();
        $this->load->view('template/template_header', $data);
        $this->load->view('template/template_menu', $this->data);
        $this->load->view($page);
        $this->load->view('template/template_footer');
    }

    public function index($offset = 0) {
        $this->preload();
        $this->get_list($this->limit, $offset);
        $this->load_view('admin/message/draft', $this->data);
    }

    private function fetch_draft($limit, $offset, $filter = null) {
        //$this->data['messages'] = $this->message_dao->fetch($limit, $offset, 'created_time', 'state = 0', false);
        $this->data['messages'] = $this->message_dao->table_fetch($limit, $offset, $filter, 'created_time');
        $this->data['ships'] = $this->ship_dao->fetch_for_msg();
    }

     public function filter_param() {
        $filter = array();
        if (isset($_GET['filter'])) {
            $filter['id_from'] = $this->input->get('id_from');
            $filter['id_to'] = $this->input->get('id_to');
            //$filter['msg'] = $this->input->get('msg');
        }

        return $filter;
    }



    public function get_list($limit = 16, $offset = 0) {
        $obj = $this->filter_param();
        $filter = (!empty($obj)) ? $obj : null;
        #generate pagination
        if ($this->uri->segment(3)=='edit'){
            $base_url = self::$CURRENT_CONTEXT . '/edit/'.$this->uri->segment(4);
            $uri = 5;
        } else {
            $base_url = self::$CURRENT_CONTEXT . '/index/';
            $uri = 4;
        }
        $config['base_url'] = site_url($base_url);
        $config['total_rows'] = $this->message_dao->count_table_draft($filter);
        //$config['total_rows'] = $this->message_dao->count_all();
        $config['per_page'] = $limit;
        $config['uri_segment'] = $uri;
        $config['filter_param'] = $_SERVER['QUERY_STRING'];
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->fetch_draft($limit, $offset, $filter);  
        $this->data['offset'] = $offset;
    }
    
    private function fetch_inbox($limit, $offset, $filter=null) {
        //$this->data['messages'] = $this->message_dao->fetch($limit, $offset, 'created_time', 'state = 6 OR state = 7', false);
        $this->data['messages'] = $this->message_dao->table_fetch_inbox($limit, $offset, $filter, 'created_time', false);
        $this->data['ships'] = $this->ship_dao->fetch_for_msg();
    }

    public function get_inbox_list($limit = 16, $offset = 0) {
        $obj = $this->filter_param();
        $filter = (!empty($obj)) ? $obj : null;
        #generate pagination
        if ($this->uri->segment(3)=='edit'){
            $base_url = self::$CURRENT_CONTEXT . '/edit/'.$this->uri->segment(4);
            $uri = 5;
        } else {
            $base_url = self::$CURRENT_CONTEXT . '/inbox/';
            $uri = 4;
        }
        $config['base_url'] = site_url($base_url);
        $config['total_rows'] = $this->message_dao->count_table_inbox($filter);
        //$array_where = array('id_to' => '1', 'state' => '6', 'state' => '7');
        //$config['total_rows'] = $this->message_dao->count_where($array_where);
        $config['per_page'] = $limit;
        $config['uri_segment'] = $uri;
        $config['filter_param'] = $_SERVER['QUERY_STRING'];
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->fetch_inbox($limit, $offset, $filter);  
        //$config['total_rows'] = count($this->data['messages']);   
        $this->data['offset'] = $offset;
        
    }

    public function inbox($offset = 0) {
        $this->preload('inbox');
        $this->get_inbox_list($this->limit, $offset);
        $this->load_view('admin/message/inbox', $this->data);
    }
    
    public function view_inbox($msg_id = null) {
        $data = array(
               'state' => '7'               
        );

        $this->db->where('msg_id', $msg_id);
        $this->db->update('message', $data);    

        $this->preload('inbox');
        if ($msg_id == null) {
            $this->load_view('admin/message/inbox');
        } 
        else {
            $this->get_inbox_list($this->limit);
            $obj_id = array('msg_id' => $msg_id);

            $to_edit = $this->message_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;

            $this->load_view('admin/message/inbox', $this->data);
        }
    }

    public function delete_inbox($msg_id = null) {
        $obj_id = array('msg_id' => $msg_id);

        $status_del = $this->message_dao->delete($obj_id);
        if ($status_del == false) {
            $this->session->set_flashdata("info", "Hapus pesan masuk gagal!");
        } else {
            $this->session->set_flashdata("info", "Hapus pesan masuk berhasil!");
        }
        redirect(self::$CURRENT_CONTEXT . '/inbox/');
    }

    private function fetch_outbox($limit, $offset, $filter) {
        //$this->data['messages'] = $this->message_dao->fetch($limit, $offset, 'created_time', 'state > 0 AND state < 6', false);
        $this->data['messages'] = $this->message_dao->table_fetch_outbox($limit, $offset, $filter, 'created_time', false);
        $this->data['ships'] = $this->ship_dao->fetch_for_msg();
    }

    public function get_outbox_list($limit = 16, $offset = 0) {
        $obj = $this->filter_param();
        $filter = (!empty($obj)) ? $obj : null;
        #generate pagination
        if ($this->uri->segment(3)=='edit'){
            $base_url = self::$CURRENT_CONTEXT . '/edit/'.$this->uri->segment(4);
            $uri = 5;
        } else {
            $base_url = self::$CURRENT_CONTEXT . '/outbox/';
            $uri = 4;
        }
        $config['base_url'] = site_url($base_url);
        $config['total_rows'] = $this->message_dao->count_table_outbox($filter);
        //$config['total_rows'] = $this->message_dao->count_all();
        $config['per_page'] = $limit;
        $config['uri_segment'] = $uri;
        $config['filter_param'] = $_SERVER['QUERY_STRING'];
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->fetch_outbox($limit, $offset, $filter);  
        //$config['total_rows'] = count($this->data['messages']);
        $this->data['offset'] = $offset;
        
    }

    public function outbox($offset = 0) {
        $this->preload('outbox');
        $this->get_outbox_list($this->limit, $offset);
        $this->load_view('admin/message/outbox', $this->data);
    }
    
    public function view_outbox($msg_id = null) {
        $data = array(
               'state' => '1'               
        );

        $this->db->where('msg_id', $msg_id);
        $this->db->update('message', $data);

        $this->preload('outbox');
        if ($msg_id == null) {
            $this->load_view('admin/message/outbox');
        } 
        else {
            $this->get_outbox_list($this->limit);
            $obj_id = array('msg_id' => $msg_id);

            $to_edit = $this->message_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;

            $this->load_view('admin/message/outbox', $this->data);
        }
    }

    public function delete_outbox($msg_id = null) {
        $obj_id = array('msg_id' => $msg_id);

        $status_del = $this->message_dao->delete($obj_id);
        if ($status_del == false) {
            $this->session->set_flashdata("info", "Hapus pesan keluar gagal!");
        } else {
            $this->session->set_flashdata("info", "Hapus pesan keluar berhasil!");
        }
        redirect(self::$CURRENT_CONTEXT . '/outbox/');
    }

    private function fetch_input() {
        $data=array (
            'created_time' => ($this->input->post('created_time')),
            //'sender_name' => ($this->input->post('sender_name')),
            //'rcvr_name' => ($this->input->post('rcvr_name')),
            'id_to' => ($this->input->post('id_to')), 
            'msg' =>($this->input->post('msg'))            
        );
        
        return $data;
    }

    public function save() {
        $obj = $this->fetch_input();
        $id = $this->input->post('msg_id');
        $infoSession = ''; 
        
        if ($this->validate()) {
            $saved;
            if ($id != null) {
                $obj_id = array('msg_id' => $id);
                $saved = $this->message_dao->update($obj, $obj_id);
                $infoSession .= "Konsep Pesan berhasil diubah. ";
            } else {
                $obj['created_time'] = date('Y-m-d H:i:s');
                $obj['id_from'] = '1';
                $obj['state'] = '0';
                $saved = $this->message_dao->insert($obj);
                $infoSession .= "Konsep Pesan baru berhasil disimpan. ";
            }
            
            if (!$saved)
                $infoSession .= "Konsep Pesan gagal ditambah/diubah. ";
            
            $this->session->set_flashdata("info", $infoSession);
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        } 
        else {
            $this->preload();
            $this->get_list($this->limit, $this->offset);
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/message/draft', $this->data);
        }
    }

    public function send() {
        $obj=$this->fetch_input();
        $id = $this->input->post('msg_id');
        $obj['state'] = '3';
        $infoSession = ''; 
        
        if ($this->validate()) {
            $saved;
            if ($id != null) {
                $obj_id = array('msg_id' => $id);                
                $saved = $this->message_dao->update($obj, $obj_id);
            } else {
                $obj['created_time'] = date('Y-m-d H:i:s');
                $obj['id_from'] = $this->data['idAccessMsg'];
                $saved = $this->message_dao->insert($obj);
                $id = $this->message_dao->fetch_id($obj['created_time']);
            }
            
            if ($saved) 
                $infoSession .= "Pesan dalam proses pengiriman. ";
            else
                $infoSession .= "Konsep Pesan gagal dikirimkan. ";  
            
            $this->session->set_flashdata("info", $infoSession);
            
            // for updating mongo
            $updateMongo = '[{' .
                'no : "' . $id . 
                '", timestamp : "' . $obj['created_time'] . 
                '", idFrom : "' . $this->session->userdata(SESSION_USERMSGID) . 
                '", idTo : "' . $obj['id_to'] .
               // '", senderName : "' . $obj['sender_name'] .
                //'", rcvrName : "' . $obj['rcvr_name'] .
                '", msg : "' . $obj['msg'] .
            '"}]';
            $this->session->set_flashdata("update_mongo", $updateMongo); // added by SKM17 for synchronizing ship in mongo
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        } 
        else {
            $this->preload();
            $this->get_list($this->limit, $this->offset);
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/message/draft', $this->data);
        }
    }

    public function sendAll() {
        $obj=$this->fetch_input();
        $arrOfRecipient = $this->ship_dao->fetch_for_msg();
        $id = $this->input->post('msg_id');
        $obj['state'] = '3';
        $infoSession = ''; 
        
        if ($this->validate()) {
            $updateMongo = '[';
            $saved = true;
            $first = true;
            
            foreach ($arrOfRecipient as $row) {
                if (!$first) {
                    $updateMongo .= ', ';
                }
                
                $obj['id_to'] = $row->ship_id;
                if ($id != null) {
                    $obj_id = array('msg_id' => $id);
                    $saved = $this->message_dao->update($obj, $obj_id);
                } else {
                    $obj['created_time'] = date('Y-m-d H:i:s');
                    $obj['id_from'] = $this->session->userdata(SESSION_USERMSGID);
                    $saved = $saved && $this->message_dao->insert($obj);
                    $id = $this->message_dao->fetch_id($obj['created_time'], $obj['id_to']);
                }
            
            
                // for updating mongo
                $updateMongo .= '{' .
                    'no : "' . $id . 
                    '", timestamp : "' . $obj['created_time'] . 
                    '", idFrom : "' . $this->session->userdata(SESSION_USERMSGID) .
                    '", idTo : "' . $obj['id_to'] .
                    // '", senderName : "' . $obj['sender_name'] .
                    // '", rcvrName : "' . $obj['rcvr_name'] .
                    '", msg : "' . $obj['msg'] .
                '"}';
            
                if ($first) $first = false;
                $id = null;
            }
            
            $updateMongo .= ']';
            
            if ($saved) 
                $infoSession .= "Semua pesan dalam proses pengiriman. ";
            else
                $infoSession .= "Konsep Pesan gagal ditambah/diubah. "; 
            
            $this->session->set_flashdata("info", $infoSession);
            
            // for updating mongo
            $this->session->set_flashdata("update_mongo", $updateMongo); // added by SKM17 for synchronizing ship in mongo
            $this->data['saving'] = true;
            redirect(self::$CURRENT_CONTEXT);
        } 
        else {
            $this->preload();
            $this->get_list($this->limit, $this->offset);
            $this->data['edit'] = false;
            #prepare link for back to view list
            $this->data['link_back'] = anchor(self::$CURRENT_CONTEXT . 'index/', 'Back', array('class' => 'back'));
            $this->load_view('admin/message/draft', $this->data);
        }
    }


    public function edit($msg_id = null) {
        $this->preload();
        if ($msg_id == null) {
            $this->load_view('admin/message/draft');
        } 
        else {
            $this->get_list($this->limit);
            $obj_id = array('msg_id' => $msg_id);

            $to_edit = $this->message_dao->by_id($obj_id);
            $this->data['obj'] = $to_edit;

            $this->load_view('admin/message/draft', $this->data);
        }
    }

    public function delete($msg_id = null) {
        $obj_id = array('msg_id' => $msg_id);

        $status_del = $this->message_dao->delete($obj_id);
        if ($status_del == false) {
            $this->session->set_flashdata("info", "Hapus konsep pesan gagal!");
        } else {
            $this->session->set_flashdata("info", "Hapus konsep pesan berhasil!");
        }
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
