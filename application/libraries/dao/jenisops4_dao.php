<?php
	require_once('generic_dao.php');
	class jenisops4_dao extends Generic_dao  {
		public function table_name(){
			return 'jenisops4';
		}

		public function field_map() {
			return array ('level4_id'=>'level4_id','level3_id'=>'level3_id','level4'=>'level4');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>