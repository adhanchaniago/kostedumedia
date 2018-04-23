<?php
	require_once('generic_dao.php');
	class jenisops3_dao extends Generic_dao  {
		public function table_name(){
			return 'jenisops3';
		}

		public function field_map() {
			return array ('level3_id'=>'level3_id','level1dan2_id'=>'level1dan2_id','level3'=>'level3');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>