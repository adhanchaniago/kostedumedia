<?php

require_once('generic_dao.php');

class marine_logistics_dao extends Generic_dao {

    public function table_name() {
        return 'marines_logistics';
    }

    public function field_map() {
        return array('logitem_id' => 'logitem_id', 'mar_id' => 'mar_id', 'marinelog_value' => 'marinelog_value');
    }

    public function __construct() {
        parent::__construct();
    }

    public function table_fetch($mar_id,$limit = 1000, $offset = 0, $order_by = null, $asc = true) {
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        $this->ci->db->select('mar_log.*,log.logitem_desc,mar.mar_name');
        $this->ci->db->from('marines_logistics as mar_log, logistic_item as log, marines as mar');
        $this->ci->db->where("mar_log.logitem_id = log.logitem_id AND mar_log.mar_id = mar.mar_id AND mar_log.mar_id='".$mar_id."'");
        $this->ci->db->limit($limit, $offset);
        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }

}

?>