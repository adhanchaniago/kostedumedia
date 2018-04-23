<?php

require_once('generic_dao.php');

class fighting_vehicle_dao extends Generic_dao {

    public function table_name() {
        return 'fighting_vehicle';
    }

    public function field_map() {
        return array('fv_id' => 'fv_id', 'fv_name' => 'fv_name', 'fv_desc' => 'fv_desc', 'fv_speed' => 'fv_speed', 'fv_passanger_capacity' => 'fv_passanger_capacity', 'fv_lat' => 'fv_lat', 'fv_lon' => 'fv_lon', 'fv_isrealtime' => 'fv_isrealtime', 'fv_establish_date' => 'fv_establish_date', 'fv_lifespan' => 'fv_lifespan');
    }

    public function __construct() {
        parent::__construct();
    }

}

?>