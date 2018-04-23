<?php

require_once('generic_dao.php');

class features_dao extends Generic_dao {

    public function table_name() {
        return 'features';
    }

    public function field_map() {
        return array('feat_id' => 'feat_id', 'feat_name' => 'feat_name', 'feat_uri' => 'feat_uri', 'feat_itemdata' => 'feat_itemdata');
    }

    public function __construct() {
        parent::__construct();
    }

}

?>