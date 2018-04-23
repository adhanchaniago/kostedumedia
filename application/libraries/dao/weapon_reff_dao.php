<?php
	require_once('generic_dao.php');
	class weapon_reff_dao extends Generic_dao  {
		public function table_name(){
			return 'weapon_reff';
		}

		public function field_map() {
			return array ('weap_id'=>'weap_id','weap_name'=>'weap_name','weap_desc'=>'weap_desc','weap_shoot_range'=>'weap_shoot_range');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>