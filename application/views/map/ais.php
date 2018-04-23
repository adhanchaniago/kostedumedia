<html>
	<head>
	<title>Map</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/js/leaflet/leaflet.css" />
	<link rel="stylesheet" href="<?php echo base_url()?>assets/js/leaflet/leaflet.draw.css" />
	<link rel="stylesheet" href="<?php echo base_url()?>assets/js/leaflet/leaflet-search.css" />
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/redmond/jquery-ui-1.10.2.custom.min.css" />
	<!--[if lte IE 8]><link rel="stylesheet" href="<?php echo base_url()?>assets/js/leaflet/leaflet.ie.css" /><![endif]-->
	<!--[if lte IE 8]><link rel="stylesheet" href="<?php echo base_url()?>assets/js/leaflet/leaflet.draw.ie.css" /><![endif]-->
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery.jgrowl.css" />
	<style>
		body {
			font-family: "Trebuchet MS", "Helvetica", "Arial",  "Verdana", "sans-serif";
			font-size: 62.5%;
		}
		label, input { display:block; }
		input.text { margin-bottom:12px; width:95%; padding: .4em; }
		fieldset { padding:0; border:0; margin-top:25px; }
		h1 { font-size: 1.2em; margin: .6em 0; }
		.ui-dialog .ui-state-error { padding: .3em; }
		.validateTips { border: 1px solid transparent; padding: 0.3em; }
		div.jGrowl div.warning {
			background: 		#5c9ccc;
			color: 					white;
			border : black;
		}
		.leaflet-popup-content-wrapper {
			border: 1px solid #a6c9e2;
			background: #dfeffc url(<?php echo base_url()?>assets/css/redmond/images/ui-bg_glass_85_dfeffc_1x400.png) 50% 50% repeat-x;
		}

		.leaflet-popup-content-wrapper .leaflet-popup-content {
			background: #dfeffc url(<?php echo base_url()?>assets/css/redmond/images/ui-bg_glass_85_dfeffc_1x400.png) 50% 50% repeat-x;
			color: #1d5987;
		}


	</style>
	<script src="<?php echo base_url()?>assets/js/jquery-1.7.2.min.js"></script>
	<script src="<?php echo base_url()?>assets/js/jquery-ui-1.10.2.custom.min.js"></script>
	<script type="text/javascript" src="http://192.168.1.88:8082/socket.io/socket.io.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/leaflet/leaflet.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/leaflet/leaflet.draw.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/leaflet/leaflet-search.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.jgrowl.js"></script>
	
	<script type="text/javascript">
		var configMap = {
			latCenter : 0,
			lonCenter : 0,
			zoom :9,
			mapUrl : 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',//'http://tile.puskodal.gov/osm/{z}/{x}/{y}.png',//'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
			mapStyleId : 22677
		};
		var conf = {
			url : '<?php echo base_url()?>'
		};
        var map,marker = new Array();
		var markersLayer = null;
		var markerGroup = new Array();
		var socket = io.connect('http://192.168.1.88:8082/');
		var ShipMarker = L.Icon.extend({
					options: {
						iconSize:     [20, 20]
					}
				});
		var IconKI = new ShipMarker({iconUrl:conf.url+'assets/img/icon-ship/blue/1.-icon-KI.png'}),
		IconUnk = new ShipMarker({iconUrl: conf.url+'assets/img/icon-ship/blue/20.-icon--.png'});
		$(document).ready(function(){
			init();
			getPushdata();
			hapus_ais();
		});
	
		//Inisialisasi Map
		function init(){
			var minimal   = L.tileLayer(configMap.mapUrl, {styleId: configMap.mapStyleId});
			map = new L.map('map', {
				center: [configMap.latCenter, configMap.lonCenter],
				zoom: configMap.zoom,
				layers: [minimal],
				maxZoom : 19
			});
			var baseLayers = {
				"Default": minimal
			};
			L.control.layers(baseLayers).addTo(map);		
			
			
		}
		
		function getPushdata(){
			socket.emit('reqChangeMode', { mode: 'surround' });
			socket.once('statupdate', function (data) {
				console.log(data);
				// console.log('statupdate');
				data = eval('('+data+')');
				$.each(data.ships,function(i,item){
					if(item.protocol!="pos"){
						if(markerGroup.lenght>0){
							removeLayer();
						}
						markerGroup = [];
						$.each(data.ships,function(i,item){
							if(item.protocol!='pos'){
								markerGroup.push(new L.marker([item.lat, item.lon],{icon:IconUnk,title:item.shipId}).bindPopup("<p align='center' >"+item.shipId+"<br />L : "+item.lat+" , B "+item.lon+"</p>"));
							}
						});
						map.panTo(new L.LatLng(data.lat, data.lon));
						markerGroup.push(new L.marker([data.lat, data.lon],{icon:IconKI,title:data.name}).bindPopup("<p align='center' >"+data.name+"<br />L : "+data.lat+" , B "+data.lon+"</p>"));
					}
				});
				markersLayer = L.layerGroup(markerGroup);
				map.addLayer(markersLayer);
			});
		}
		
		function hapus_ais(){
			socket.once('AISstat', function (data) {
				console.log(data);
				removeLayer();
			});
		}
		
		function removeLayer() {
			if(markersLayer!=null){
				map.removeLayer(markersLayer);	
				console.log(markersLayer);
				markersLayer = null;
			}
		}

	</script>
	</head>
	<body>
		<div style="width:100%; height:100%" id="map"></div>
	</body>
</html>
