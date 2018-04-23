<?php
	require_once('generic_dao.php');
	class aeroplane_type_dao extends Generic_dao  {
		public function table_name(){
			return 'aeroplane_type';
		}

		public function field_map() {
			return array ('aertype_id'=>'aertype_id','aertype_name'=>'aertype_name','aertype_icon'=>'aertype_icon');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>