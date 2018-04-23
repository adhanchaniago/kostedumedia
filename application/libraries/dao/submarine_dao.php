<?php
	require_once('generic_dao.php');
	class submarine_dao extends Generic_dao  {
		public function table_name(){
			return 'submarine';
		}

		public function field_map() {
			return array ('sbm_id'=>'sbm_id','sbm_hull_number'=>'sbm_hull_number','sbm_name'=>'sbm_name','sbm_description'=>'sbm_description','sbm_lat'=>'sbm_lat','sbm_lon'=>'sbm_lon','sbm_isrealtime'=>'sbm_isrealtime','sbm_cruising_range'=>'sbm_cruising_range');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>