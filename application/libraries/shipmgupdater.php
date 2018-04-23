<?php
/**
	--ship updater
	doing update to marker cache @ mongodb and sending change to neptunus.
*/
include("neptunusclient.php");
class ShipMgUpdater{

	private $kri;
	private $neptunus_cli;
	private $ci;

	function __construct(){
		$this->ci = & get_instance();
		$client = new MongoClient($this->ci->config->item('ip_mongo'));
		$this->kri = $client->puskodal->kri;
		//TODO: take host and port from configuration
		$this->neptunus_cli = new NeptunusClient(
			$this->ci->config->item('neptunus_host'),
			$this->ci->config->item('neptunus_port')
		);
	}

	private function checkObject($ship){
		return (array_key_exists("shipId", $ship)
			&& array_key_exists("lat", $ship)
			&& array_key_exists("lon", $ship)
			&& array_key_exists("direction", $ship)
			&& array_key_exists("speed", $ship)
			&& array_key_exists("postTime", $ship)
			);
	}

	public function update($ship){
		if($this->checkObject($ship)){
			$this->kri->update(
				array("shipId"=>$ship["shipId"]),
				array('$set' => $ship)
			);

			$this->neptunus_cli->sendShipUpdate($ship['shipId']);
		}else{

		}
	}
}
?>
