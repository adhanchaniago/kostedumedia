<?php
	require_once('generic_dao.php');
	class report_type_dao extends Generic_dao  {
		public function table_name(){
			return 'report_type';
		}

		public function field_map() {
			return array ('rt_id'=>'rt_id','rt_desc'=>'rt_desc','rt_active'=>'rt_active');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>