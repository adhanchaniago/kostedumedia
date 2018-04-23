<?php
	require_once('generic_dao.php');
	class logistic_type_dao extends Generic_dao  {
		public function table_name(){
			return 'logistic_type';
		}

		public function field_map() {
			return array ('logtype_id'=>'logtype_id','logtype_name'=>'logtype_name');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>