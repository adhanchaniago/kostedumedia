<?php
	require_once('generic_dao.php');
	class jenisops1dan2_dao extends Generic_dao  {
		public function table_name(){
			return 'jenisops1dan2';
		}

		public function field_map() {
			return array ('level1dan2_id'=>'level1dan2_id','level1'=>'level1','level2'=>'level2');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>