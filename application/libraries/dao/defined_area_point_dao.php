<?php
	require_once('generic_dao.php');
	class defined_area_point_dao extends Generic_dao  {
		public function table_name(){
			return 'defined_area_point';
		}

		public function field_map() {
			return array ('da_id'=>'da_id','depoint_inc'=>'depoint_inc','depoint_lat'=>'depoint_lat','depoint_lon'=>'depoint_lon');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>