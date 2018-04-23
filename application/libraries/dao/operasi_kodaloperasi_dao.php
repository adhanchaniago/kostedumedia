<?php

require_once('generic_dao.php');

class operasi_kodaloperasi_dao extends Generic_dao {

    public function table_name() {
        return 'operasi_kodaloperasi';
    }

    public function field_map() {
        return array('kodaloperasi_id' => 'kodaloperasi_id', 'operation_id' => 'operation_id');
    }

    public function __construct() {
        parent::__construct();
    }

    public function table_fetch($obj) {
        $this->ci->db->select('operasi_kodaloperasi.*,kodaloperasi.kodaloperasi_desc');
        $this->ci->db->from('operasi_kodaloperasi,kodaloperasi');
        $this->ci->db->where('operasi_kodaloperasi.kodaloperasi_id = kodaloperasi.kodaloperasi_id AND operasi_kodaloperasi.operation_id = \''.$obj['operation_id'].'\' ');

        $q = $this->ci->db->get();
        return $q->result();
    }

}

?>