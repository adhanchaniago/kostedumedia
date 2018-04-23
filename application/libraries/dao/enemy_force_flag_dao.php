<?php
	require_once('generic_dao.php');
	class enemy_force_flag_dao extends Generic_dao  {
		public function table_name(){
			return 'enemy_force_flag';
		}

		public function field_map() {
			return array (	'eforceflag_id' => 'eforceflag_id',
							'eforceflag_name'=>'eforceflag_name',
							'eforceflag_icon'=>'eforceflag_icon'
			);
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>
