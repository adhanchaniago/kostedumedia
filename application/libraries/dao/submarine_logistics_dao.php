<?php

require_once('generic_dao.php');

class submarine_logistics_dao extends Generic_dao {

    public function table_name() {
        return 'submarine_logistics';
    }

    public function field_map() {
        return array('logitem_id' => 'logitem_id', 'sbm_id' => 'sbm_id', 'sbmlog_value' => 'sbmlog_value');
    }

    public function __construct() {
        parent::__construct();
    }

    public function table_fetch($sbm_id, $limit = 1000, $offset = 0, $order_by = null, $asc = true) {
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        $this->ci->db->select('submarine_logistics.*,logistic_item.logitem_desc,logistic_item.logitem_id,submarine.sbm_name');
        $this->ci->db->from('submarine_logistics,logistic_item,submarine');
        $this->ci->db->where("submarine_logistics.logitem_id = logistic_item.logitem_id AND submarine_logistics.sbm_id = submarine.sbm_id AND submarine_logistics.sbm_id='" . $sbm_id . "'");
        $this->ci->db->limit($limit, $offset);
        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }

}

?>