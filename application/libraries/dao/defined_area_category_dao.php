<?php
	require_once('generic_dao.php');
	
	class defined_area_category_dao extends Generic_dao  {
		public function table_name(){
			return 'defined_area_category';
		}

		public function field_map() {
			return array (	
				'dac_id' => 'dac_id',
				'dac_description'=>'dac_description',
				'dac_color'=>'dac_color'
			);
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>
