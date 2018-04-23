<?php

require_once('generic_dao.php');

class personnel_type_dao extends Generic_dao {

    public function table_name() {
        return 'personnel_type';
    }

    public function field_map() {
        return array('psntype_id' => 'psntype_id', 'psntype_desc' => 'psntype_desc', 'psntype_metric' => 'psntype_metric');
    }

    public function __construct() {
        parent::__construct();
        $this->ci->load->library('dao/personnel_dao');
    }

    public function delete($keys) {
        $this->ci->personnel_dao->delete($keys);
        $keys_o = $this->to_sql_array($keys);
        return $this->ci->db->delete($this->table_name(), $keys_o);
    }

}

?>