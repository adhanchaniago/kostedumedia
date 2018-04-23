<?php
	class track_mapsys{
		
		private $db;
		private $track;
		private $ci; // added by SKM17

		public function __construct(){
			$this->ci = & get_instance();
			$this->db = new MongoClient($this->ci->config->item('ip_mongo'))->puskodal;
			$this->position = $this->db->positions;
			
		}
		


	}
?>
