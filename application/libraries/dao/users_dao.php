<?php

require_once('generic_dao.php');

class users_dao extends Generic_dao  {
	public function table_name(){
		return 'users';
	}

	public function field_map() {
		return array (
			'user_id'=>'user_id','username'=>'username',
			'password'=>'password','email'=>'email',
			'activated'=>'activated','banned'=>'banned',
			'ban_reason'=>'ban_reason','new_password_key'=>'new_password_key',
			'new_password_requested'=>'new_password_requested',
			'new_email'=>'new_email','new_email_key'=>'new_email_key',
			'last_ip'=>'last_ip','last_login'=>'last_login',
			'created'=>'created','modified'=>'modified',
			'corps_id'=>'corps_id', 'users_isactive'=>'users_isactive');
	}

	public function __construct() {
		parent::__construct();
	}
    
	public function fetch($limit = 1000, $offset = 0, $order_by = null,  $where = null,  $asc = true) {
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        $this->ci->db->select('users.*, corps.corps_name, role.*');
        $this->ci->db->limit($limit, $offset);
        $this->ci->db->from('users LEFT JOIN corps ON (users.corps_id = corps.corps_id) 
        	LEFT JOIN user_role ON (users.user_id = user_role.user_id)
        	LEFT JOIN role ON (user_role.role_id = role.role_id)'
    	);

        if(!is_null($where)){
			$this->ci->db->where($where);
        }
		
        if ($order_by != NULL)
            $this->ci->db->order_by($order_by, $name_asc);
            
        $q = $this->ci->db->get();
		return $q->result();
	}
	
	public function count_table_fetch($context = null,$array_search=null) {
        $this->ci->db->select('users.*, corps.corps_name');
        $this->ci->db->limit($limit, $offset);
        $this->ci->db->from('users LEFT JOIN corps ON (users.corps_id = corps.corps_id)');

        if(!is_null($where)){
			$this->ci->db->where($where);
        }
        
		$q = $this->ci->db->count_all_results();
		return $q;
	}
	
}

?>
