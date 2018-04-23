<?php
	require_once('generic_dao.php');
	class aeroplane_condition_dao extends Generic_dao  {
		public function table_name(){
			return 'aeroplane_condition';
		}

		public function field_map() {
			return array ('aercond_id'=>'aercond_id','aercond_description'=>'aercond_description');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>