<?php

require_once('generic_dao.php');

class pilot_grade_dao extends Generic_dao {

    public function table_name() {
        return 'pilot_grade';
    }

    public function field_map() {
        return array('plev_id' => 'plev_id', 'plev_name' => 'plev_name');
    }

    public function __construct() {
        parent::__construct();
    }

}

?>