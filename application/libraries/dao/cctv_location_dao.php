<?php
    require_once('generic_dao.php');
    class cctv_location_dao extends Generic_dao  {
        public function table_name(){
            return 'cctv_location';
        }

        public function field_map() {
            return array (
				'cctvloc_id'=>'cctvloc_id',
				'cctvloc_name'=>'cctvloc_name',
				'cctvloc_lat'=>'cctvloc_lat',
				'cctvloc_lon'=>'cctvloc_lon',
				'cctvloc_url'=>'cctvloc_url',
				'cctvloc_desc'=>'cctvloc_desc',
				'cctvloc_username'=>'cctvloc_username',
				'cctvloc_password'=>'cctvloc_password',
				);
        }

        public function __construct() {
            parent::__construct();
        }
    }
?>