<?php
	require_once('generic_dao.php');
	class aoi_dao extends Generic_dao  {
		public function table_name(){
			return 'aoi';
		}

		public function field_map() {
			return array ('aoi_id'=>'aoi_id','operation_id'=>'operation_id','aptype_id'=>'aptype_id','aoi_name'=>'aoi_name','aoi_icon'=>'aoi_icon','aoi_description'=>'aoi_description','aoi_iscircle'=>'aoi_iscircle','aoi_circle_lon'=>'aoi_circle_lon','aoi_circle_lat'=>'aoi_circle_lat','aoi_circle_rad'=>'aoi_circle_rad');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>