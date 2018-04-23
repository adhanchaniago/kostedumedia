<?php

require_once('generic_dao.php');

class aeroplane_logistics_dao extends Generic_dao {

    public function table_name() {
        return 'aeroplane_logistics';
    }

    public function field_map() {
        return array('logitem_id' => 'logitem_id', 'aer_id' => 'aer_id', 'aerlog_value' => 'aerlog_value');
    }

    public function __construct() {
        parent::__construct();
    }

    public function table_fetch($aer_id,$limit = 1000, $offset = 0, $order_by = null, $asc = true) {
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        $this->ci->db->select('aeroplane_logistics.*,logistic_item.logitem_desc,logistic_item.logitem_id,aeroplane.aer_name');
        $this->ci->db->from('aeroplane_logistics,logistic_item,aeroplane');
        $this->ci->db->where("aeroplane_logistics.logitem_id = logistic_item.logitem_id AND aeroplane_logistics.aer_id = aeroplane.aer_id AND aeroplane_logistics.aer_id='".$aer_id."'");
        $this->ci->db->limit($limit, $offset);
        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }

}

?>