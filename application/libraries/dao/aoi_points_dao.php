<?php
	require_once('generic_dao.php');
	class aoi_points_dao extends Generic_dao  {
		public function table_name(){
			return 'aoi_points';
		}

		public function field_map() {
			return array ('aoi_id'=>'aoi_id','point_lat'=>'point_lat','point_lon'=>'point_lon');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>