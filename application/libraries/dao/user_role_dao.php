<?php

require_once('generic_dao.php');

class user_role_dao extends Generic_dao {

    public function table_name() {
        return 'user_role';
    }

    public function field_map() {
        return array('user_id' => 'user_id', 'role_id' => 'role_id', 'revoked' => 'revoked');
    }

    public function __construct() {
        parent::__construct();
    }

    public function table_fetch($user_id,$limit = 1000, $offset = 0, $order_by = null, $asc = true) {
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        
        $this->ci->db->select('user_role.*,users.username,role.role_name,users.corps_id');
        $this->ci->db->from('user_role,users,role');
        $this->ci->db->where('user_role.user_id = users.user_id and user_role.role_id = role.role_id and users.user_id=\''.$user_id.'\'');
        $this->ci->db->limit($limit, $offset);
        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }
    
    public function fetch_record($user_id){
        $this->ci->db->select('user_role.*,users.username,role.role_name,users.corps_id, users.msg_acc_id');
        $this->ci->db->from('user_role,users,role');
        $this->ci->db->where('user_role.user_id = users.user_id and user_role.role_id = role.role_id and users.user_id = '.$user_id.'');
        $q = $this->ci->db->get();
        return $q->row();
    }
}

?>
