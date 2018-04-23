<?php

require_once('generic_dao.php');

class feature_access_dao extends Generic_dao {

    public function table_name() {
        return 'feature_access';
    }

    public function field_map() {
        return array('feat_id' => 'feat_id', 'role_id' => 'role_id', 'featacc_access' => 'featacc_access');
    }

    public function __construct() {
        parent::__construct();
    }

    public function table_fetch($role_id, $limit = 1000, $offset = 0, $order_by = null, $asc = true) {
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        $this->ci->db->select('feature_access.*,features.feat_name');
        $this->ci->db->from('feature_access,features');
        $this->ci->db->where("feature_access.feat_id = features.feat_id and role_id = '$role_id'");
        $this->ci->db->limit($limit, $offset);
        if ($order_by != NULL && !is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }

}

?>
