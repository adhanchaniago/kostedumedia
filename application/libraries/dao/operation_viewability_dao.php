<?php

require_once('generic_dao.php');

class operation_viewability_dao extends Generic_dao {

    public function table_name() {
        return 'operation_viewability';
    }

    public function field_map() {
        return array('operation_id' => 'operation_id', 'corps_id' => 'corps_id', 'viewability' => 'viewability');
    }

    public function __construct() {
        parent::__construct();
    }

    public function table_fetch($limit = 1000, $offset = 0, $order_by = null, $asc = true) {
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        $this->ci->db->select('v.operation_id,v.corps_id,v.viewability,op.operation_name, corp.corps_name');
        $this->ci->db->from('operation_viewability as v,operation as op, corps as corp');
        $this->ci->db->where('v.operation_id = op.operation_id');
        $this->ci->db->where('corp.corps_id = v.corps_id');
        $this->ci->db->limit($limit, $offset);
        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }

}

?>