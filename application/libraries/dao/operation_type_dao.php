<?php
	require_once('generic_dao.php');
	class operation_type_dao extends Generic_dao  {
		public function table_name(){
			return 'operation_type';
		}

		public function field_map() {
			return array ('optype_id'=>'optype_id','optype_name'=>'optype_name','optype_desc'=>'optype_desc');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>