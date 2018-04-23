<?php
	require_once('generic_dao.php');
	class station_type_dao extends Generic_dao  {
		public function table_name(){
			return 'station_type';
		}

		public function field_map() {
			return array ('stype_id'=>'stype_id','stype_name'=>'stype_name','stype_icon'=>'stype_icon');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>