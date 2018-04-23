<?php
include("neptunusclient.php");
class ShipUpdater{

	private $kri;
	private $neptunus_cli;
	private $ci; // added by SKM17

	function __construct(){
		$this->ci = & get_instance();
		$client = new MongoClient($this->ci->config->item('ip_mongo'));
		$this->kri = $client->puskodal->kri;
		$this->neptunus_cli = new NeptunusClient("127.0.0.1", 6969);
	}

	private function checkObject($ship){
		return (array_key_exists("shipId", $ship)
			&& array_key_exists("lat", $ship)
			&& array_key_exists("lon", $ship)
			&& array_key_exists("direction", $ship)
			&& array_key_exists("speed", $ship)
			&& array_key_exists("isRealtime", $ship)
			&& array_key_exists("postTime", $ship)
			);
	}

	public function update($ship){
		if($this->checkObject($ship)){
			$this->kri->update(
				array("shipId"=>ship["shipId"]),
				array("$set" => $ship)
			);

			$this->neptunus_cli->sendShipUpdate($ship['shipId']);
		}else{

		}
	}
}
?>
