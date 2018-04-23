<?php

require_once('generic_dao.php');

class fight_vehicle_logistic_dao extends Generic_dao {

    public function table_name() {
        return 'fight_vehicle_logistic';
    }

    public function field_map() {
        return array('logitem_id' => 'logitem_id', 'fv_id' => 'fv_id', 'fvehicle_value' => 'fvehicle_value');
    }

    public function __construct() {
        parent::__construct();
    }
    
    public function table_fetch($fv_id, $limit = 1000, $offset = 0, $order_by = null, $asc = true) {
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        $this->ci->db->select('fight_vehicle_logistic.*,fighting_vehicle.fv_name,fighting_vehicle.fv_id,logistic_item.logitem_desc,logistic_item.logitem_id');
        $this->ci->db->from('fight_vehicle_logistic,fighting_vehicle,logistic_item');
        $this->ci->db->where('fighting_vehicle.fv_id = fight_vehicle_logistic.fv_id AND
				fight_vehicle_logistic.logitem_id = logistic_item.logitem_id AND fight_vehicle_logistic.fv_id=\''.$fv_id.'\'');
        $this->ci->db->limit($limit, $offset);
        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }
}

?>