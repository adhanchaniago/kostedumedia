<?php
	class position_mapsys{
		
		private $db;
		private $kri;
		private $ci; // added by SKM17

		public function __construct(){
			$this->ci = & get_instance();
			$client = new MongoClient($this->ci->config->item('ip_mongo'));
			$this->db = $client->puskodal;
			$this->kri = $this->db->kri;

		}

		public function delete($ship_id){
			return $this->kri->update(
				array('shipId'=>$ship_id),
				array('$set'=> array(
					'deleted' => true, 
					'castCounter' => -1
				))
			);
		}


		public function update($ship){
			$o = null;

			if(is_object($ship)){
				$o = $ship;
			}else{
				$o = (object) $ship;
			}

			$this->kri->update(
				array("shipId"=>$o->ship_id),
				array('$set' => array(
					"name"=> $o->ship_name, 
					"isRealTime"=> $o->ship_isrealtime, 
					"lat"=> $o->ship_lat, 
					"lon"=> $o->ship_lon,
					"speed"=> $o->ship_speed,
					"direction"=> $o->ship_direction
					)
				),
				array("upsert"=>true)
			);
		}
		/*
			id is TIC node id
		*/
		public function update_position($id, $lat, $lon){
			$this->kri->update(
				array("shipId" => $id),
				array("$set" =>	array(
					"lat" => $lat , "lon"=>$lon
					)
				),
				array("upsert"=>true, "multiple"=>true)
			);
		}

		public function update_status($id, $status){
			$this->kri->update(
				array("shipId"=>$id),
				array("$set"=>array("status"=>$status)),
				array("upsert"=>true, "multiple"=>true)
			);
		}


	}
?>
