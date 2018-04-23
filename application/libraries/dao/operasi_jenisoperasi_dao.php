<?php
	require_once('generic_dao.php');
	class operasi_jenisoperasi_dao extends Generic_dao  {
		public function table_name(){
			return 'operasi_jenisoperasi';
		}

		public function field_map() {
			return array ('level4_id'=>'level4_id','operation_id'=>'operation_id');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>