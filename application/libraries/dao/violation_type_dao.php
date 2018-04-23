<?php
	require_once('generic_dao.php');
	class violation_type_dao extends Generic_dao  {
		public function table_name(){
			return 'violation_type';
		}

		public function field_map() {
			return array ('vt_id'=>'vt_id','vt_desc'=>'vt_desc','vt_active'=>'vt_active');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>