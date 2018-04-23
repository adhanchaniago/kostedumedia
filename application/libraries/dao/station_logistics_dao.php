<?php

require_once('generic_dao.php');

class station_logistics_dao extends Generic_dao {

    public function table_name() {
        return 'station_logistics';
    }

    public function field_map() {
        return array('logitem_id' => 'logitem_id', 'station_id' => 'station_id', 'stationlog_value' => 'stationlog_value');
    }

    public function __construct() {
        parent::__construct();
    }

    public function table_fetch($station_id,$limit = 1000, $offset = 0, $order_by = null, $asc = true) {
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        $this->ci->db->select('station_logistics.*,station.station_name,station.station_id,logistic_item.logitem_desc,logistic_item.logitem_id');
        $this->ci->db->from('station_logistics,logistic_item,station');
        $this->ci->db->where('station_logistics.station_id = station.station_id AND station_logistics.logitem_id = logistic_item.logitem_id AND station_logistics.station_id=\''.$station_id.'\'');
        $this->ci->db->limit($limit, $offset);
        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }

}

?>