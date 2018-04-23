<?php
    include('generic_dao.php');
    class generic_marker_category_dao extends Generic_dao  {
        public function table_name(){
            return 'generic_marker_category';
        }

        public function field_map() {
            return array ('gmarkcat_id'=>'gmarkcat_id','gmarkcat_name'=>'gmarkcat_name','gmarkcat_icon'=>'gmarkcat_icon');
        }

        public function __construct() {
            parent::__construct();
        }
    }
?>