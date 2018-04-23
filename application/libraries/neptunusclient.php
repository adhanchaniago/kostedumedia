<?php

class NeptunusClient {

	private $host;
	private $port;

	function __construct($host , $port){
		$this->host = $host;
		$this->port = $port;
	}

	public function sendShipUpdate($puskodalid){		
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if($socket === false)
			echo "socket error:".socket_strerror(socket_last_error());

		$result = socket_connect($socket, $this->host, $this->port);
		$protocol =  "KU,$puskodalid*!$puskodalid\n";
		socket_write($socket, $protocol, strlen($protocol));
		
	}

	public function sendShipDelete($puskodalid){
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if($socket === false)
			echo "socket error:".socket_strerror(socket_last_error());

		$result = socket_connect($socket, $this->host, $this->port);
		$protocol =  "DL,$puskodalid*!$puskodalid\n";
		socket_write($socket, $protocol, strlen($protocol));
	}

	public function sendSyncNewKRI($shipId){
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if($socket === false)
			echo "socket error:".socket_strerror(socket_last_error());

		$result = socket_connect($socket, $this->host, $this->port);
		$protocol =  "SK,$shipId*!$shipId\n";
		socket_write($socket, $protocol, strlen($protocol));	
		
	}
}

?>