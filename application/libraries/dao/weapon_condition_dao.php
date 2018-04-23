<?php
	require_once('generic_dao.php');
	class weapon_condition_dao extends Generic_dao  {
		public function table_name(){
			return 'weapon_condition';
		}

		public function field_map() {
			return array ('ship_id'=>'ship_id','weap_id'=>'weap_id','wstat_id'=>'wstat_id','ammo_count'=>'ammo_count');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>