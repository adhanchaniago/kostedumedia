<?php

require_once('generic_dao.php');

class ship_logistics_dao extends Generic_dao {

    public function table_name() {
        return 'ship_logistics';
    }

    public function field_map() {
        return array('ship_id' => 'ship_id', 'logitem_id' => 'logitem_id', 'shiplog_value' => 'shiplog_value');
    }

    public function __construct() {
        parent::__construct();
    }

    public function table_fetch($ship_id,$limit = 1000, $offset = 0, $order_by = null, $asc = true) {
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        $this->ci->db->select('ship_logistics.*,ship.ship_name,logistic_item.logitem_desc');
        $this->ci->db->from('ship_logistics,ship,logistic_item');
        $this->ci->db->where('ship_logistics.ship_id = ship.ship_id AND
				ship_logistics.logitem_id = logistic_item.logitem_id AND ship_logistics.ship_id=\''.$ship_id.'\'');
        $this->ci->db->limit($limit, $offset);
        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }

}

?>