<?php
    require_once('generic_dao.php');
    class marines_kolak_dao extends Generic_dao  {
        public function table_name(){
            return 'marines_kolak';
        }

        public function field_map() {
            return array ('corps_id'=>'corps_id','kolak_id'=>'kolak_id','kolak_description'=>'kolak_description');
        }
		
		public function table_fetch($limit=16,$offset=0){
			return $this->ci->db->query("select k.*,c.corps_name from marines_kolak k left join corps c on(k.corps_id=c.corps_id) order by k.kolak_id ASC LIMIT $limit OFFSET $offset")->result();
		}

        public function __construct() {
            parent::__construct();
        }
    }
?>