<!DOCTYPE html>
<html>
	<head>
		<title>Peta Puskodal</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

		<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet-openweathermap.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet-search.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/redmond/jquery-ui-1.10.2.custom.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/ui.panel.css" />
		<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/html/css/style-new.css" />
		<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/html/css/tab-info.css" />

		<!-- //add wind-js -->
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/wind/gopaLesri.css" />                
		<link rel="shortcut icon" href="<?php echo base_url() ?>favicon.ico" type="image/x-icon">
	
		<style>
			/*label, input { display:block; }*/
			input.text { margin-bottom:12px; width:95%; padding: .4em; }
			fieldset { padding:0; border:0; margin-top:25px; }
			.ui-dialog .ui-state-error { padding: .3em; }
			.ui-corner-all, .ui-corner-top, .ui-corner-right, .ui-corner-tr {
				border-top-right-radius: 0px;
			}
			.ui-corner-all, .ui-corner-bottom, .ui-corner-left, .ui-corner-bl {
				border-bottom-left-radius: 0px;
			}
			.ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br {
				border-bottom-right-radius: 0px;
			}
			.ui-corner-all, .ui-corner-top, .ui-corner-left, .ui-corner-tl {
				border-top-left-radius: 0px;
			}
			.ui-widget-header,
			.ui-widget-content{
				border: none;
			}

			.ui-widget-header{
				background: rgba(46, 110, 158, 0.9);
				border-radius: 10px 0 0 0;
				box-shadow: inset 0 0 10px #5F8FBF;
			}

			.ui-widget-content{
				border-radius: 5px;
			}
			.ui-widget-content[aria-describedby="dialog-chat"],
			.ui-widget-content[aria-describedby="dialog-post-area"],
			.ui-widget-content[aria-describedby="dialog-post-marker"],
			.ui-widget-content[aria-describedby="dialog-post-circle"],
			.ui-widget-content[aria-describedby="dialog-postarea-manual"]{
				background: transparent;
			}

			.ui-widget-content[aria-describedby="dialog-chat"] .ui-widget-header,
			.ui-widget-content[aria-describedby="dialog-post-area"] .ui-widget-header,
			.ui-widget-content[aria-describedby="dialog-post-marker"] .ui-widget-header,
			.ui-widget-content[aria-describedby="dialog-post-circle"] .ui-widget-header,
			.ui-widget-content[aria-describedby="dialog-postarea-manual"] .ui-widget-header{
				background: rgba(46, 110, 158, 0.9);
				border-radius: 10px 10px 0 0;
				box-shadow: inset 0 0 10px #5F8FBF;
			}

			.ui-widget-content[aria-describedby="dialog-chat"] .ui-widget-header span.ui-dialog-title,
			.ui-widget-content[aria-describedby="dialog-post-area"] .ui-widget-header span.ui-dialog-title,
			.ui-widget-content[aria-describedby="dialog-post-marker"] .ui-widget-header span.ui-dialog-title,
			.ui-widget-content[aria-describedby="dialog-post-circle"] .ui-widget-header span.ui-dialog-title,
			.ui-widget-content[aria-describedby="dialog-postarea-manual"] .ui-widget-header span.ui-dialog-title{
				padding: 3px 0;
			}

			.ui-widget-content[aria-describedby="dialog-chat"] .ui-widget-header .ui-dialog-titlebar-close,
			.ui-widget-content[aria-describedby="dialog-post-area"] .ui-widget-header .ui-dialog-titlebar-close,
			.ui-widget-content[aria-describedby="dialog-post-marker"] .ui-widget-header .ui-dialog-titlebar-close,
			.ui-widget-content[aria-describedby="dialog-post-circle"] .ui-widget-header .ui-dialog-titlebar-close,
			.ui-widget-content[aria-describedby="dialog-postarea-manual"] .ui-widget-header .ui-dialog-titlebar-close{
				border-radius: 7px;
				margin-right: 1px;
			}

			.ui-widget-content[aria-describedby="dialog-chat"] #dialog-chat,
			.ui-widget-content[aria-describedby="dialog-post-area"] #dialog-post-area,
			.ui-widget-content[aria-describedby="dialog-post-marker"] #dialog-post-marker,
			.ui-widget-content[aria-describedby="dialog-post-circle"] #dialog-post-circle,
			.ui-widget-content[aria-describedby="dialog-postarea-manual"] #dialog-postarea-manual{
				background: #FFF;
				border-radius: 0;
				margin-top: 1px;
				padding-top: 8px;
			}

			.ui-widget-content[aria-describedby="dialog-postarea-manual"] #dialog-postarea-manual{
				border-radius: 0 0 10px 10px;
				padding-bottom: 10px;

			}

			.ui-widget-content[aria-describedby="dialog-chat"] #dialog-chat{
				border-radius: 0 0 10px 10px;
				overflow: hidden;
				padding-bottom: 0;
			}

			.ui-widget-content[aria-describedby="dialog-chat"] #dialog-chat fieldset,
			.ui-widget-content[aria-describedby="dialog-post-area"] #dialog-post-area fieldset,
			.ui-widget-content[aria-describedby="dialog-post-marker"] #dialog-post-marker fieldset,
			.ui-widget-content[aria-describedby="dialog-post-circle"] #dialog-post-circle fieldset,
			.ui-widget-content[aria-describedby="dialog-postarea-manual"] #dialog-postarea-manual fieldset{
				margin: 0;
			}

			.ui-widget-content[aria-describedby="dialog-chat"] .ui-dialog-buttonpane,
			.ui-widget-content[aria-describedby="dialog-post-area"] .ui-dialog-buttonpane,
			.ui-widget-content[aria-describedby="dialog-post-marker"] .ui-dialog-buttonpane,
			.ui-widget-content[aria-describedby="dialog-post-circle"] .ui-dialog-buttonpane,
			.ui-widget-content[aria-describedby="dialog-postarea-manual"] .ui-dialog-buttonpane{
				margin-top: 0;
				padding: 5px;
				border-top: 1px solid rgba(46, 110, 158, 0.9);
				border-radius: 0 0 10px 10px;
			}


			#blanket {
				background-color:#111;
				opacity: 0.65;
				*background:none;
				position:absolute;
				z-index: 9001;
				top:0px;
				left:0px;
				width:100%;
			}

			#popUpDiv {
				position:absolute;
				background:#2E6E9E;
				width:200px;
				height:200px;
				border:5px solid #000;
				z-index: 9002;
			}

			#popUpDiv a {position:relative; top:20px; left:20px}

		</style>

		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.9.1.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/jquery-ui-1.10.2.js"></script>
		
		
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui-1.10.2.js"> </script>
		
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/base.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet-search.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/Marker.Rotate.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.jgrowl.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.sidebar.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/geo.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/latlon.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/css-pop.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/noty/packaged/jquery.noty.packaged.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->config->item('socket_ip') ?>/socket.io/socket.io.js"></script>

		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet-openweathermap.js"></script>
		
		<!-- marker cluster -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/MarkerCluster.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/MarkerCluster.Default.css" />        
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet.markercluster-src.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/init_marker.js"></script>
		<!-- marker cluster -->



		<!-- //add wind-js library-->
		<script>
		var dojoConfig = { 
			paths: {
			  //aslinya ini
			  // plugins: location.pathname.replace(/\/[^/]+$/, "") + "/plugins"
			  plugins: "http://192.168.1.124/puskodal/assets/js/wind/plugins"
			}
			
		};        
		</script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/wind/windy.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/wind/waves.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/wind/gopaLcanvasOverlay.js"></script>
		<!-- //end of add wind-js library-->



		<script type="text/javascript">

			/*
				notification config.
			*/
			$.noty.defaults = {
				layout: 'top',
				theme: 'defaultTheme',
				type: 'error',
				text: '', // can be html or string
				dismissQueue: true, // If you want to use queue feature set this true
				template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>',
				animation: {
					open: {height: 'toggle'},
					close: {height: 'toggle'},
					easing: 'swing',
					speed: 500 // opening & closing animation speed
				},
				timeout: 5000, // delay for closing event. Set false for sticky notifications
				force: false, // adds notification to the beginning of queue when set to true
				modal: false,
				maxVisible: 1, // you can set max visible notification for dismissQueue true option,
				killer: false, // for close all notifications before show
				closeWith: ['button'], // ['click', 'button', 'hover']
				callback: {
					onShow: function() {},
					afterShow: function() {},
					onClose: function() {},
					afterClose: function() {}
				},
				buttons: false // an array of buttons
			};

			/*
				custom prototype function
			*/

			var NumberFormat = function(){

			};

			NumberFormat.pad = function (num, size) {
				var s = num+"";
				while (s.length < size) s = "0" + s;
				return s;
			}

			Date.getTW = function(param){
				var date = new Date(param);
// console.log("getTW " + param + " " + date.getHours()); // debug by SKM17


				return  'TW. '+NumberFormat.pad(date.getMonth()+1, 2)+
							NumberFormat.pad(date.getDate(), 2)+'.'+
							NumberFormat.pad(date.getHours(),2)+ // -1 deleted by SKM17
							NumberFormat.pad(date.getMinutes(),2);
			}
			/**
				application wide configuration
				left here to simplify complications because js-php mixing required. :D
			 */

			var month=new Array(12);
			month[0]="Januari";
			month[1]="Februari";
			month[2]="Maret";
			month[3]="April";
			month[4]="Mei";
			month[5]="Juni";
			month[6]="Juli";
			month[7]="Agustus";
			month[8]="September";
			month[9]="Oktober";
			month[10]="November";
			month[11]="Desember";

			var tempMarineStation,tempIntelegent,tempRanpur,tempSubmarine = [];

			/*arpa hacks...*/

			var realtimeARPA = new Array();
			var myLayer = new L.LayerGroup();
			/*end of arpa hacks..*/

			var measuring_line = null;
			var stat_ukur_jarak = false;
			var isMeasuring = true;
			var measureBends = new Array();
			var measureLines = new Array();

			var start_lat = null;
			var start_lon = null;
			var distancePopup = false;
			var stat_draw_area = false;
			var type_draw_area = 'polygon';
			var draw_circle,draw_point,draw_polygon = null;

			var configMap = {

				latCenter : 6-(6-(-11))/2,
				lonCenter : 95+(141-95)/2,

				zoom :5,
				mapUrl : '<?php echo $map_url ?>',
				baseUrl : '<?php echo base_url(); ?>',
				mapStyleId : 22677
			};

			var conf = {
				url : '<?php echo base_url() ?>',
				aisSocket : "<?php echo $this->config->item('ais_socket')?>"
			};

			var icons = <?php echo $ship_types ?>;

			var map,marker = new Array(),
				groupMarkerPoi,
				markerPoi = new Array(),
				dataMarkerPoi = new Array(),
				temp_path = new Array(),
				polygon_area = new Array(),
				data_area = new Array(),
				circle_area = new Array(),
				data_area_circle = new Array(),
				socket = null;

			var count_area = 0,count_area_circle=0,count_marker=0;

			if(typeof io === 'undefined'){
				var n = noty({text: 'Koneksi ke web socket tidak aktif, silahkan refresh dengan menekan tombol refresh atau menekan F5 pada keyboard'});

				// document.write("");
			   console.log("Koneksi ke web socket tidak aktif, silahkan refresh dengan menekan tombol refresh atau menekan F5 pada keyboard");
			}else{
				socket = io.connect('<?php echo $this->config->item('socket_ip') ?>');

			}

			socket.on('test_id', function(data){
				console.log('testing socket id ' + data);
			});

			// added by SKM17
			socket.on('reqCorpsId', function(){
				//var corps_id = '<?php echo $user->corps_id ?>';
				socket.emit('resCorpsId', corps_id);
			});
		
			socket.on('outboxNotif', function() {
				var n = noty({
					layout:'topCenter',
					text: "Pesan terkirim", 
					type : "alert",
					timeout : false
				});
			});
			
			socket.on('inboxNotif', function() {
				var n = noty({
					layout:'topCenter',
					text: "Pesan diterima", 
					type : "alert",
					timeout : false
				});
			});
			
			var markersLayer = new Array();
			var markerKRI = new Array(),  markerKRIdata = new Array();
				var corps_id = '<?php echo $user->corps_id ?>';
				var user_group = '<?php echo $user->user_group ?>';

			var stat_view = {
				kri:true, track:false, 
				intelegent:false,
				ranpur:false, submarine:false, 
				ais : false,
				marinestation: false // added by SKM17
			};

			var dataMarineStation,dataIntelegent,
				dataRanpur,dataSubmarine, gsData;
			var markerAdditional = new Array();
			var markerTrack = null;
			var markersSearch = new L.LayerGroup();

			var I16 = 18*15/8; //18 = pixel dr rata2 ukuran kapal 75m pd scale 1:15000     //15/8 adalah pembandingan skala zoom15:zoom16
			var I17 = I16*2; //*2 = perbandingan zoom 16 : 17
			var I18 = I17*2; //*2 = perbandingan zoom 17 : 18

			var ShipIcon = L.Icon.extend(
			{options: {
					iconSize:     [30, 30],
					iconAnchor: [(8/27*30), (20/27*30)],                 
				}
			});

			var ShipIcon16 = L.Icon.extend(
			{options: {
					iconSize:     [I16,I16 ],
					iconAnchor: [(8/27*I16), (20/27*I16)],                 
				}
			});

			 var ShipIcon17 = L.Icon.extend(
			{options: {
					iconSize:     [I17, I17],
					iconAnchor: [(8/27*I17), (20/27*I17)],                 
				}
			});
			  var ShipIcon18 = L.Icon.extend(
			{options: {
					iconSize:     [I18, I18],
					iconAnchor: [(8/27*I18), (20/27*I18)],                 
				}
			});
			

			/*AIS definition*/

					// mendefinisikan kelas marker untuk kapal ais
			var AISMarker = L.Marker.extend({
				options: {
						mmsi: '',
						nama: '',
						nav_status: '',
						rot: '',
						sog: '',
						pos_acc: '',
						lat: '',
						long: '',
						cog: '',
						hdg: '',
						raim: '',
						timestamp: ''
					}
			});

			L.ARPAMarker = L.Marker.extend({
			options: {
				angle: 0,
				id: '',
				lat: '',
				long: '',
				sog: '',
				cog: '',
				name: '',
				timestamp: ''
			},
			statics: {
				// determine the best and only CSS transform rule to use for this browser
				bestTransform: L.DomUtil.testProp([
					'transform',
					'WebkitTransform',
					'msTransform',
					'MozTransform',
					'OTransform'
				])
			},
			_setPos: function (pos) {
				L.Marker.prototype._setPos.call(this, pos);

				var rotate = ' rotate(' + this.options.angle + 'deg)';

				if (L.RotatedMarker.bestTransform) {
					// use the CSS transform rule if available
					this._icon.style[L.RotatedMarker.bestTransform] += rotate;
				} else if(L.Browser.ie) {
					// fallback for IE6, IE7, IE8
					var rad = this.options.angle * L.LatLng.DEG_TO_RAD,
						costheta = Math.cos(rad),
						sintheta = Math.sin(rad);
					this._icon.style.filter += ' progid:DXImageTransform.Microsoft.Matrix(sizingMethod=\'auto expand\', M11=' + 
						costheta + ', M12=' + (-sintheta) + ', M21=' + sintheta + ', M22=' + costheta + ')';                
				}
			}
		});


			L.KRIMarker = L.Marker.extend({
				options : {
					shipId : '',
					name : '',
					abbr : '',                    
					lat : 0.0,
					lon : 0.0,
					direction : 0.0,
					speed : 0.0,
					tw:'N/A'

				}
			});

			L.TargetMarker = L.Marker.extend({
				options : {
					targetId : '',
					lat : 0.0,
					lon : 0.0,
					direction : 0.0,
					speed : 0.0,
					tw:'N/A',
				}
			});

			/*custom enemy force marker*/
			L.EnemyForceMarker = L.Marker.extend({
				options : {
					forceId : '',
					name : '',
					desc : '',
					lat  : 0.0,
					lng  : 0.0
				}
			});
			
			L.GroundStationMarker = L.Marker.extend({
				options : {
					gsId : '',
					location : '',
					state : '',
					lat  : 0.0,
					lon  : 0.0
				}
			});
		
			L.RotatedMarker = L.Marker.extend({
				options: {
					angle: 0,
					mmsi: '',
					nama: '',
					nav_status: '',
					rot: '',
					sog: '',
					pos_acc: '',
					lat: '',
					long: '',
					cog: '',
					hdg: '',
					raim: '',
					timestamp: ''
				},
				statics: {
					// determine the best and only CSS transform rule to use for this browser
					bestTransform: L.DomUtil.testProp([
						'transform',
						'WebkitTransform',
						'msTransform',
						'MozTransform',
						'OTransform'
					])
				},
				_setPos: function (pos) {
					L.Marker.prototype._setPos.call(this, pos);
					
					var rotate = ' rotate(' + this.options.angle + 'deg)';
					if (L.RotatedMarker.bestTransform) {
						// use the CSS transform rule if available
						this._icon.style[L.RotatedMarker.bestTransform] += rotate;
					} else if(L.Browser.ie) {
						// fallback for IE6, IE7, IE8
						var rad = this.options.angle * L.LatLng.DEG_TO_RAD,
							costheta = Math.cos(rad),
							sintheta = Math.sin(rad);
						this._icon.style.filter += ' progid:DXImageTransform.Microsoft.Matrix(sizingMethod=\'auto expand\', M11=' + 
							costheta + ', M12=' + (-sintheta) + ', M21=' + sintheta + ', M22=' + costheta + ')';                
					}
				}
			});


			var aisSocket = null;
			var markerAIS = [];
			var markerARPA = [];
			var pioPath = '<?php echo $this->config->item('piopath') ?>';
			
			// untuk keperluan parsing ARPA
			var EARTH_RADIUS_DM  = 3485.23; //disamakan dengan puskodal
			var TO_RAD = Math.PI/180.0;
			var latRel = -6.23886;
			var lonRel = 114.78516;

			/*icon initialization*/
			var iconNoRealtimeLego = {},
				iconNoRealtimeSandar = {},//
				iconNoRealtime = {},
				iconObsolete = {},
				iconRealtime = {},
				iconNoRealtimemabar={},
				iconNoRealtimemabarlego={},
				iconNoRealtimemabarsandar={},
				iconNoRealtimematim={},
				iconNoRealtimematimlego={},
				iconNoRealtimematimsandar={},
				iconNoRealtimelamil={},
				iconNoRealtimelamillego={},
				iconNoRealtimelamilsandar={};
				//zoom16
			var iconNoRealtimeLego16 = {},
				iconNoRealtimeSandar16 = {},
				iconNoRealtime16 = {},
				iconObsolete16 = {},
				iconRealtime16 = {},
				iconNoRealtimemabar16={},
				iconNoRealtimemabarlego16={},
				iconNoRealtimemabarsandar16={},
				iconNoRealtimematim16={},
				iconNoRealtimematimlego16={},
				iconNoRealtimematimsandar16={},
				iconNoRealtimelamil16={},
				iconNoRealtimelamillego16={},
				iconNoRealtimelamilsandar16={};
				//zoom17
			var iconNoRealtimeLego17 = {},
				iconNoRealtimeSandar17 = {},
				iconNoRealtime17 = {},
				iconObsolete17 = {},
				iconRealtime17= {},
				iconNoRealtimemabar17={},
				iconNoRealtimemabarlego17={},
				iconNoRealtimemabarsandar17={},
				iconNoRealtimematim17={},
				iconNoRealtimematimlego17={},
				iconNoRealtimematimsandar17={},
				iconNoRealtimelamil17={},
				iconNoRealtimelamillego17={},
				iconNoRealtimelamilsandar17={};

			 var iconNoRealtimeLego18 = {},
				iconNoRealtimeSandar18 = {},
				iconNoRealtime18 = {},
				iconObsolete18 = {},
				iconRealtime18= {},
				iconNoRealtimemabar18={},
				iconNoRealtimemabarlego18={},
				iconNoRealtimemabarsandar18={},
				iconNoRealtimematim18={},
				iconNoRealtimematimlego18={},
				iconNoRealtimematimsandar18={},
				iconNoRealtimelamil18={},
				iconNoRealtimelamillego18={},
				iconNoRealtimelamilsandar18={};
				
			var defaultIcon = 'KI.png';
			var icon = null;

			for (var idx in icons) {

				icon = icons[idx];
		   
				////console.log('FOUND ICON : ' + JSON.stringify(icon));
				
				if(icon.file == null || icon.file == ''){
					icon.file = defaultIcon;
				}
				
				// zoom 5-15
				iconNoRealtime[icon.id ] = new ShipIcon({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/blue/blue-'+icon.file});            
				iconNoRealtimeSandar[icon.id ] = new ShipIcon({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/blue/sandar/blue-'+icon.file});            
				iconNoRealtimeLego[icon.id ] = new ShipIcon({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/blue/lego/blue-'+icon.file});            
				
				iconRealtime[icon.id] = new ShipIcon({iconUrl:conf.url+'assets/img/icon-ship/realtime/green-'+icon.file});
				iconObsolete[icon.id] = new ShipIcon({iconUrl:conf.url+'assets/img/icon-ship/realtime/yellow-'+icon.file});
				
				iconNoRealtimemabar[icon.id ] = new ShipIcon({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hijau/hijau-'+icon.file});           
				iconNoRealtimemabarlego[icon.id ] = new ShipIcon({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hijau/lego/hijau-'+icon.file});            
				iconNoRealtimemabarsandar[icon.id ] = new ShipIcon({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hijau/sandar/hijau-'+icon.file});            
				
				iconNoRealtimelamil[icon.id ] = new ShipIcon({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hitam/grey-'+icon.file});
				iconNoRealtimelamillego[icon.id ] = new ShipIcon({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hitam/lego/grey-'+icon.file});
				iconNoRealtimelamilsandar[icon.id ] = new ShipIcon({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hitam/sandar/grey-'+icon.file});
				
				iconNoRealtimematim[icon.id ] = new ShipIcon({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/orange/orange-'+icon.file});
				iconNoRealtimematimlego[icon.id ] = new ShipIcon({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/orange/lego/orange-'+icon.file});
				iconNoRealtimematimsandar[icon.id ] = new ShipIcon({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/orange/sandar/orange-'+icon.file}); 

				//kalo zoom16
				iconNoRealtime16[icon.id ] = new ShipIcon16({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/blue/blue-'+icon.file});            
				iconNoRealtimeSandar16[icon.id ] = new ShipIcon16({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/blue/sandar/blue-'+icon.file});            
				iconNoRealtimeLego16[icon.id ] = new ShipIcon16({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/blue/lego/blue-'+icon.file});            
				
				iconRealtime16[icon.id] = new ShipIcon16({iconUrl:conf.url+'assets/img/icon-ship/realtime/green-'+icon.file});
				iconObsolete16[icon.id] = new ShipIcon16({iconUrl:conf.url+'assets/img/icon-ship/realtime/yellow-'+icon.file});
				
				iconNoRealtimemabar16[icon.id ] = new ShipIcon16({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hijau/hijau-'+icon.file});           
				iconNoRealtimemabarlego16[icon.id ] = new ShipIcon16({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hijau/lego/hijau-'+icon.file});            
				iconNoRealtimemabarsandar16[icon.id ] = new ShipIcon16({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hijau/sandar/hijau-'+icon.file});            
				
				iconNoRealtimelamil16[icon.id ] = new ShipIcon16({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hitam/grey-'+icon.file});            
				iconNoRealtimelamillego16[icon.id ] = new ShipIcon16({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hitam/lego/grey-'+icon.file});
				iconNoRealtimelamilsandar16[icon.id ] = new ShipIcon16({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hitam/sandar/grey-'+icon.file});
				
				iconNoRealtimematim16[icon.id ] = new ShipIcon16({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/orange/orange-'+icon.file});
				iconNoRealtimematimlego16[icon.id ] = new ShipIcon16({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/orange/lego/orange-'+icon.file});
				iconNoRealtimematimsandar16[icon.id ] = new ShipIcon16({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/orange/sandar/orange-'+icon.file}); 
	   
				//kalo zoom17
				iconNoRealtime17[icon.id ] = new ShipIcon17({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/blue/blue-'+icon.file});            
				iconNoRealtimeSandar17[icon.id ] = new ShipIcon17({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/blue/sandar/blue-'+icon.file});            
				iconNoRealtimeLego17[icon.id ] = new ShipIcon17({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/blue/lego/blue-'+icon.file});            
				
				iconRealtime17[icon.id] = new ShipIcon17({iconUrl:conf.url+'assets/img/icon-ship/realtime/green-'+icon.file});
				iconObsolete17[icon.id] = new ShipIcon17({iconUrl:conf.url+'assets/img/icon-ship/realtime/yellow-'+icon.file});
				
				iconNoRealtimemabar17[icon.id ] = new ShipIcon17({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hijau/hijau-'+icon.file});           
				iconNoRealtimemabarlego17[icon.id ] = new ShipIcon17({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hijau/lego/hijau-'+icon.file});            
				iconNoRealtimemabarsandar17[icon.id ] = new ShipIcon17({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hijau/sandar/hijau-'+icon.file});            
				
				iconNoRealtimelamil17[icon.id ] = new ShipIcon17({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hitam/grey-'+icon.file});            
				iconNoRealtimelamillego17[icon.id ] = new ShipIcon17({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hitam/lego/grey-'+icon.file});
				iconNoRealtimelamilsandar17[icon.id ] = new ShipIcon17({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hitam/sandar/grey-'+icon.file});
				
				iconNoRealtimematim17[icon.id ] = new ShipIcon17({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/orange/orange-'+icon.file});
				iconNoRealtimematimlego17[icon.id ] = new ShipIcon17({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/orange/lego/orange-'+icon.file});
				iconNoRealtimematimsandar17[icon.id ] = new ShipIcon17({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/orange/sandar/orange-'+icon.file});

				//kalo zoom18
				iconNoRealtime18[icon.id ] = new ShipIcon18({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/blue/blue-'+icon.file});            
				iconNoRealtimeSandar18[icon.id ] = new ShipIcon18({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/blue/sandar/blue-'+icon.file});            
				iconNoRealtimeLego18[icon.id ] = new ShipIcon18({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/blue/lego/blue-'+icon.file});            
				
				iconRealtime18[icon.id] = new ShipIcon18({iconUrl:conf.url+'assets/img/icon-ship/realtime/green-'+icon.file});
				iconObsolete18[icon.id] = new ShipIcon18({iconUrl:conf.url+'assets/img/icon-ship/realtime/yellow-'+icon.file});
				
				iconNoRealtimemabar18[icon.id ] = new ShipIcon18({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hijau/hijau-'+icon.file});           
				iconNoRealtimemabarlego18[icon.id ] = new ShipIcon18({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hijau/lego/hijau-'+icon.file});            
				iconNoRealtimemabarsandar18[icon.id ] = new ShipIcon18({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hijau/sandar/hijau-'+icon.file});            
				
				iconNoRealtimelamil18[icon.id ] = new ShipIcon18({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hitam/grey-'+icon.file});            
				iconNoRealtimelamillego18[icon.id ] = new ShipIcon18({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hitam/lego/grey-'+icon.file});
				iconNoRealtimelamilsandar18[icon.id ] = new ShipIcon18({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/hitam/sandar/grey-'+icon.file});
				
				iconNoRealtimematim18[icon.id ] = new ShipIcon18({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/orange/orange-'+icon.file});
				iconNoRealtimematimlego18[icon.id ] = new ShipIcon18({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/orange/lego/orange-'+icon.file});
				iconNoRealtimematimsandar18[icon.id ] = new ShipIcon18({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/orange/sandar/orange-'+icon.file});

			}

			var IconKIRealtime = new ShipIcon({iconUrl:conf.url+'assets/img/icon-ship/realtime/KI.png'}),//MEMASUKAN GAMBAR IKON 
			IconKI = new ShipIcon({iconUrl:conf.url+'assets/img/icon-ship/not-realtime/KI.png'}),
			IconUnk = new ShipIcon({iconUrl: conf.url+'assets/img/icon-ship/non-kri/1.-Non-NKRI-(Red).png'}),
			IconMarine = new ShipIcon({iconUrl: conf.url+'assets/img/icon-marine/marine.png'}),
			IconIntelegent = new ShipIcon({iconUrl: conf.url+'assets/img/icon-ship/non-kri/1.-Non-NKRI-(Green).png'}),
			IconAeroplane = new ShipIcon({iconUrl: conf.url+'assets/img/icon-aeroplane/aeroplane.png'}),
			IconRanpur = new ShipIcon({iconUrl: conf.url+'assets/img/icon-ship/blue2/5.-KCR.png'}),
			IconSubmarine = new ShipIcon({iconUrl: conf.url+'assets/img/icon-ship/blue2/9.-SS.png'}),
			IconStation = new ShipIcon({iconUrl: conf.url+'assets/img/icon-ship/non-kri/1.-Non-NKRI-(Yellow).png'});


			var tempTrack = null;
			var array_search = new Array();
			var cctv_data = null;
			var generic_marker_data = null;
			var array_additional = new Array();
			var circleAnimation = null;

			// for displaying kri number
			var kriNumberDisplayStat = '<?php echo $display_kri_number ?>';
			if (kriNumberDisplayStat == "Ya") kriNumberDisplayStat = true;
			else if (kriNumberDisplayStat == "Tidak") kriNumberDisplayStat = false;

			// for displaying pesud number
			var pesudNumberDisplayStat = '<?php echo $display_pesud_number ?>';
			if (pesudNumberDisplayStat == "Ya") pesudNumberDisplayStat = true;
			else if (pesudNumberDisplayStat == "Tidak") pesudNumberDisplayStat = false;

			// for displaying myfleet
			var myFleetDisplayStat = '<?php echo $display_myfleet ?>';
			if (myFleetDisplayStat == "Ya") myFleetDisplayStat = true;
			else if (myFleetDisplayStat == "Tidak") myFleetDisplayStat = false;
			
		</script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/forms.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/tools.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/util.js"> </script>
		
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/maps.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/ais.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/chat.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/cctv.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/aeroplane.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/submarine.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/station.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/marines.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/ranpur.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/enemy-force.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/pesan.js"> </script>

   
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/feature.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/marines_station.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/groundstation.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/message.js"> </script> 
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/defined-area.js"> </script> 
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/myfleet.js"> </script> 
		
	  <!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/crypt/maps.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/crypt/ais.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/crypt/chat.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/crypt/forms.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/crypt/tools.js"> </script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/crypt/util.js"> </script>
		-->
	
		<!-- Memanggil file .js untuk proses autocomplete -->
		<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.autocomplete.js'></script>

		<!-- Memanggil file .css untuk style saat data dicari dalam filed -->
		<link href='<?php echo base_url();?>assets/css/jquery.autocomplete.css' rel='stylesheet' />

		<!-- Memanggil file .css autocomplete_ci/assets/css/default.css -->
		<link href='<?php echo base_url();?>assets/css/default.css' rel='stylesheet' />

		<script>            
				$(function(){
					console.log("searchKRI default");
					$('.autocomplete').autocomplete({
					   
						serviceUrl : site + 'autocomplete/searchKRI',                         
						onSelect: function (suggestion) {
						   map.setView(new L.LatLng(suggestion.lat, suggestion.lon),12);
						}
					});

				});            
		</script>
	   

		<script type='text/javascript' src='<?php echo base_url();?>assets/js/control/search.js'></script>        
	   
	</head>

<body >
	<div id="container">
		<div id="header">            
			<marquee direction="left" scrollamount="5" width="100%" style="position:absolute; color:#fff; margin-top:53px; font-size:13px;">                
				<?php echo $running_text ?>   
			</marquee>    
			<div>
				<div style=" float:left;"> 
					<img src="<?php echo base_url() ?>assets/html/img/logo.png" height="60px" width="180px"> 
				 	<img src="<?php echo base_url() ?>assets/html/img/ak.png" height="60px" width="180px"> <br>
				</div>
				<div id="txt" style="color:#fff; float:right; "></div>
				
				
			</div>
			
  			<div id="line"></div>
		
		</div>  

	<div id="srch"> 
		<form class="search" action="#" >
			 <input type="text" placeholder="Search, case sensitive.." class='autocomplete' id="autocomplete1"/>
		</form>
	</div>

	<div id="base" style="color:#fff; ">
	 				<input id="showbtspkl" type="checkbox"><font>Garis Pangkal &nbsp; </font>
					<input id="showbtster" type="checkbox"><font>Batas Teritorial &nbsp;</font>
					<input id="showbtstmb" type="checkbox"><font>Zona Tambahan &nbsp;</font>
					<input id="showbtszee" type="checkbox"><font>Zee &nbsp;</font>
					<input id="showbtskon" type="checkbox"><font>Landas Kontinent &nbsp; </font> 
					<input id="showbtsst" type="checkbox"><font>Perjanjian 1997</font> 
	</div>
	<div id="baseline" style="color:#fff; font-weight: bold; cursor:pointer" > <font> &nbsp;Line</font>
	</div>

	
			<a id="btn1" class="open" href="#" style="margin-top:74px;"> <img src="<?php echo base_url() ?>assets/html/img/cls.png" style="border:none; float:left; margin-top:180px; margin-right:2px;" width="20px" height="18px" alt=""></a>
		<!-- left menu, feature indicators -->
		<ul id="side-menu" style="z-index:10000000">

		<div id="menu" style="margin-top:74px" >
	<a style=" margin-left:250px; " id="btn1"  href="#" ><img src="<?php echo base_url() ?>assets/html/img/opn.png" width="20px" height="18px" style="margin-top:180px; margin-right:2px; "></a>
   
   <div>
	 
	 <table id="tbl-menu"  style="border-collapse:collapse;" >
			<tr>
				
					<td colspan="4" class="lbmenu"> <center>
					<a href="#" class="wr">SSAT</a>
					</td>
				</tr>
				<tr>
				<td class="line_emas" colspan="4" height="5px;"></td></tr>
	
	<tr>
		<td  width="50px;">
		<li class="lvl-1" style="list-style:none" >
			   <a id="show-kri" href="#" class="lightning nyala" >
					<div  class="default" style="float:left;  "><img src="<?php echo base_url() ?>assets/html/img/icon-menu/KRI.png" style="border:none; " width="32px" height="32px" alt="KRI" /></div>
					<div style="color: #8B4513;   float:left; padding-left:10px; margin-top:5px "><font size="4"><sub>KRI</sub></font></div>
				</a>
			</li>
		</td>
			 
			 
	

	<td  width="60px;">
		<li class="lvl-1" style="list-style:none">
		  <a id="show-aeroplane" href="#" class="lightning" >
				
				<div  class="default" style="float:left;  "><img src="<?php echo base_url() ?>assets/html/img/icon-menu/pesawat_udara_br.png" width="34px" height="34px"/></div>
				<div style="color: #0d7e67;   float:left; margin-left:10px; margin-top:5px"><font size="4"><sub>Pesud</sub></font></div>
				
		  </a>
		  </li>
		  </td>

	</tr>


	<tr>
		<td width="70px;">
		<li class="lvl-1" style="list-style:none" >
			 <a  id="show-marines-station" href="#" class="lightning" >
		  <div  class="default" style="float:left;  "> <img src="<?php echo base_url() ?>assets/html/img/icon-menu/marinirbr.png" width="34px" height="34px"/></div>
		<div style="color: #336699;   float:left; margin-left:10px; margin-top:5px"><font size="4"><sub>Marinir</sub></font></div>  
		</a>
		</li>
		</td>
							
		
		<td width="50px;">
		 <li class="lvl-1" style="list-style:none" >
	   <a id="show-land-station" href="#" class="lightning" >
	   <div  class="default" style="float:left;  "> <img src="<?php echo base_url() ?>assets/html/img/icon-menu/marinir_br.png" width="32px" height="32px"/></div>
	   <div style="color: #CD853F;   float:left; margin-left:10px; margin-top:5px"><font size="4"><sub>Pangkalan</sub></font></div>  
		 </a>
			</li>
		</td>
	</tr>

<tr>
				
					<td colspan="4" class="lbmenu"> <center>
					<a href="#" class="wr">Intelejen</a>
					</td>
				</tr>
				<tr>
				<td class="line_emas" colspan="4" height="5px;"></td></tr>
	
	<tr>
   <tr>
		<td width="0px;" colspan="4" >
		<li class="lvl-1" style="list-style:none" >
		<a id="show-enemy-force" href="#" class="lightning" >
		<div  class="default" style="float:left;  "> <img src="<?php echo base_url() ?>assets/html/img/icon-menu/pelanggaran_br.png" width="30px" height="32px"/> </div> 
	   <div style="color: gray;   float:left; margin-left:10px; margin-top:5px"><font size="4"><sub>Kekuatan Lawan</sub></font></div>
		</a>
		</li>
			
		</td>
	</tr>
<tr>
				
					<td colspan="4" class="lbmenu"> <center>
					<a href="#" class="wr">Jenis</a>
					</td>
				</tr>
				<tr>
				<td class="line_emas" colspan="4" height="5px;"></td></tr>
	
	<tr>
	<tr>
		<td width="50px;">
		<li class="lvl-1" style="list-style:none" >
		<a  id="show-marines" href="#" class="lightning"  >
		<div  class="default" style="float:left;  "> <img src="<?php echo base_url() ?>assets/html/img/icon-menu/satgasnew.png" width="34px" height="34px"/></div>
		 <div style="color: #5e6969;   float:left; margin-left:10px; margin-top:5px"><font size="4"><sub>Satgas</sub></font></div>
		</a>
		</li>
		  </td>
		</td>
	
	<td width="50px;">
	<li class="lvl-1" style="list-style:none" >
		<a  id="show-target" href="#" class="lightning" >
		  <div  class="default" style="float:left;  "> <img src="<?php echo base_url() ?>assets/html/img/icon-menu/target_br.png" width="32px" height="32px"/></div>
		  <div style="color: #f90a20;   float:left; margin-left:10px; margin-top:5px"><font size="4"><sub>Target</sub></font></div>
		  </a>
		  </li>
	</td>
	</tr>
   
	<tr>
		<td width="50px;">
			<li class="lvl-1" style="list-style:none" >
				<a id="show-gs" href="#" class="lightning" >
					<div  class="default" style="float:left">  <img src="<?php echo base_url() ?>assets/html/img/icon-menu/GS_br.png" width="32px" height="32px"/></div>
					<div style="color: #4682B4; float:left; margin-left:10px; margin-top:5px "><font size="4"><sub>GS</sub></font></div>
				</a>
			</li>
		</td>
		<td width="50px;">
		<li class="lvl-1" style="list-style:none" >
		<a  id="show-ais" href="#"  class="lightning" >
		<div  class="default" style="float:left;  "> <img src="<?php echo base_url() ?>assets/html/img/icon-menu/ico3_br.png" width="30px" height="32px"/></div>
		<div style="color: #4f1025;   float:left; margin-left:10px; margin-top:5px; "><font size="4"><sub>AIS</sub></font></div>
		</a>
		</li>
		</td>
	</tr>

	<tr> 
		<td width="50px;">
		<li class="lvl-1" style="list-style:none" >
			<!-- <a id="show-measure-tools"  href="#"  class="lightning"> -->
			<a id="show-measure-tool"  href="#"  class="lightning">
					<div  class="default" style="float:left;  "><img src="<?php echo base_url() ?>assets/html/img/icon-menu/ukur-jarak_br.png" width="30px" height="32px"/></div>
					<div style="color: #876e6e; float:left; margin-left:10px; margin-top:5px;"><font size="4"><sub>Jarak</sub></font></div>
				</a>
			</li>
		</td>
		<td width="50px;">
		<li class="lvl-1" style="list-style:none" >
			<a id="show-tulis" href="#"  class="lightning">
			<div  class="default" style="float:left"> <img src="<?php echo base_url() ?>assets/html/img/icon-menu/pesan.png" width="30px" height="32px"/></div>
			  <div style="color: #332900;   float:left; margin-left:10px; margin-top:5px"><font size="4"><sub>Pesan</sub></font></div>
			</a>
		</li>
		</td>  
	</tr>

	<tr>        
	<td width="50px;">
		 <li class="lvl-1" style="list-style:none" >
			<!-- <a id="show-poi" href="#"  class="lightning nyala"> -->
			<a id="show-poi" href="#"  class="lightning">
			<div  class="default" style="float:left"> <img src="<?php echo base_url() ?>assets/html/img/icon-menu/POIbr.png" width="30px" height="32px"/></div>
			  <div style="color: #0099FF;   float:left; margin-left:10px; margin-top:5px"><font size="4"><sub>POI</sub></font></div>
			</a>
		</li>
		 
	</td>
   
		 <td width="50px;">
		 <li class="lvl-1" style="list-style:none" >
				<a id="show-area" href="#"  class="lightning">
					<div  class="default" style="float:left"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/areadpn.png" width="30px" height="32px"/></div>
					<div style="color: #5e0909; float:left; margin-left:10px; margin-top:5px "><font size="4"><sub>Area</sub></font></div>
				</a>
			</li>
		</td>  
	</tr>


	<tr>        
		<td  width="50px;">
		  <li class="lvl-1" style="list-style:none" >
			<a id="show-cuaca" href="#"  class="lightning" style="decoration:none; ">
				<div class="default" style="float:left" ><img src="<?php echo base_url() ?>assets/html/img/icon-menu/cuaca.png" width="30" height="32"/>  </div>
				<div style="float:left; margin-left:10px; margin-top:5px;"><font size="4"  style="color:#005299; "><sub>Cuaca</sub></font></div>
			</a>
		</li>  
		</td>
		<td width="50px;">
			<li class="lvl-1" style="list-style:none" >
				<a id="goto-backend" href="#"  class="lightning">
					<div  class="default" style="float:left"> <img src="<?php echo base_url() ?>assets/html/img/icon-menu/back end_br.png" width="30px" height="31px"/></div>
					<div style="color: #332900; float:left; margin-left:10px;margin-top:5px"><font size="4"><sub>Back End</sub></font></div>
				</a>
			</li>
		</td>
	</tr>

	
 <tr>
				
					<td colspan="4" class="lbmenu"> <center>
					<a href="#" class="wrr">.</a>
					</td>
				</tr>
				<tr>
				<td class="line_emas" colspan="4" height="5px;"></td></tr>
	
	<tr>
	<tr>        
	<td colspan="4">
	   <li class="lvl-1" style="list-style:none" >
			<a id="logout" href="#"  class="lightning">
		   <div  class="default" style="float:left"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/logout_br.png" width="30px" height="31px"/></div>
			  <div style="color: #FF5050;   float:left; margin-left:10px; margin-top:5px"><font size="4"><sub>Logout</sub></font></div>
			</a>
		</li>
		 
	</td>

	</tr>
	</table>    
		</div> 
		</div>    
		</ul>
<!-- side info -->
	  <div id="side-lawan" class="icandrag" style="display:none" >
		<table>
		<td>
			<div style="float:left"><img src="<?php echo base_url() ?>assets/html/img/Pskdl.png"/ width="50" height="48"></div>
		   <div style="color:#fff"><center><h4>KEKUATAN LAWAN</h4></center></div>
		</td>
		<tr><td  class="line_emas" colspan="2" >
		</tr>
			</table>
			<ul class="info" id="ship-info-lawan"></ul>
		   <a href="#" id="close-lawan">
				<img src="<?php echo base_url() ?>assets/html/img/arrow-right.png" />
			</a>
		</div>
	  
		

<div id="side-pesud" class="icandrag" style="display:none" >
		<table>
		<td>
			<div style="float:left"><img src="<?php echo base_url() ?>assets/html/img/Pskdl.png"/ width="50" height="48"></div>
		   <div style="color:#fff"><center><h3>PESAWAT UDARA</h3></center></div>
		</td>
		<tr><td  class="line_emas" colspan="2" >
		</tr>
			</table>
			<ul class="info" id="ship-info-pesud"></ul>
			<a href="#" id="show-hist-aer" class="showHist">
			<label style="margin-left:25px;">Histori Dislokasi Pesud</label>
			</a>
			<a href="#" id="close-pesud">
				<img src="<?php echo base_url() ?>assets/html/img/arrow-right.png" />
			</a>
		</div>

<div id="side-KRI" class="icandrag" style="display:none" >
		<table>
		<td>
		   <div style="float:left"><img src="<?php echo base_url() ?>assets/html/img/Pskdl.png"/ width="50" height="48"></div>
		   <div style="color:#fff"><center><h3>KAPAL KRI</h3></center></div>
		</td>
		<tr><td  class="line_emas" colspan="2" >
		</tr>
			</table>
			
		<div class="container-wrapper-kri">
		   <div class="tab-container-kri">
				<input type="radio" name="tab-menu-kri" class="tab-menu-kri-radio" id="tab-menu1-kri" checked />
					<label for="tab-menu1-kri" class="tab-menu-kri">Info</label>
				<input type="radio" name="tab-menu-kri" class="tab-menu-kri-radio" id="tab-menu2-kri"/>
					<label for="tab-menu2-kri" class="tab-menu-kri">Ado</label>
				<input type="radio" name="tab-menu-kri" class="tab-menu-kri-radio" id="tab-menu3-kri"/>
					<label for="tab-menu3-kri" class="tab-menu-kri">Logistik</label>

			<div class="tab-content-kri">
				<div class="tab-kri tab-1-kri">
					<div class="info" id="ship-info-KRI"></div>
				</div>
				<div class="tab-kri tab-2-kri">
					<div class="info" id="ship-ado-KRI"></div>
				</div>
				 <div class="tab-kri tab-3-kri">
					 <div class="info" id="ship-logistic-KRI"></div>
				</div>
			</div>

			</div>
		</div>
			<a href="#" id="show-hist" class="showHist">
			<label style="margin-left:25px;">Histori Dislokasi Kapal</label>
			</a>
			<a href="#" id="close-KRI">
				<img src="<?php echo base_url() ?>assets/html/img/arrow-right.png" />
			</a>
		</div>


	<div id="side-POI" class="icandrag" style="display:none" >
		<table>
		<td>
		   <div style="float:left"><img src="<?php echo base_url() ?>assets/html/img/Pskdl.png"/ width="50" height="48"></div>
		   <div style="color:#fff"><center><h3>INFO POI</h3></center></div>
		</td>
		<tr><td  class="line_emas" colspan="2" >
		</tr>
			</table>
				 <ul class="info" id="ship-info-POI"></ul>
			<a href="#" id="close-POI">
				<img src="<?php echo base_url() ?>assets/html/img/arrow-right.png" />
			</a>
		</div>

		<div id="side-Fletmoon" class="icandrag" style="display:none" >
		<table>
		<td>
		   <div style="float:left"><img src="<?php echo base_url() ?>assets/html/img/Pskdl.png"/ width="50" height="48"></div>
		   <div style="color:#fff"><center><h3>INFO Fleetmoon</h3></center></div>
		</td>
		<tr><td  class="line_emas" colspan="2" >
		</tr>
			</table>
				 <ul class="info" id="ship-info-Fletmoon"></ul>
			<a href="#" id="close-Fletmoon">
				<img src="<?php echo base_url() ?>assets/html/img/arrow-right.png" />
			</a>
		</div>

<div id="side-satgas" class="icandrag" style="display:none" >
		<table>
		<td>
			 <div style="float:left"><img src="<?php echo base_url() ?>assets/html/img/Pskdl.png"/ width="50" height="48"></div>
		   <div style="color:#fff"><center><h3>SATGAS</h3></center></div>
		</td>
		<tr><td  class="line_emas" colspan="2" >
		</tr>
			</table>
			<ul class="info" id="ship-info-satgas"></ul>
		  
		   <a href="#" id="close-satgas">
				<img src="<?php echo base_url() ?>assets/html/img/arrow-right.png" />
			</a>
		</div>

<div id="side-marinir" class="icandrag" style="display:none" >
		<table>
		<td>
			 <div style="float:left"><img src="<?php echo base_url() ?>assets/html/img/Pskdl.png"/ width="50" height="48"></div>
		   <div style="color:#fff"><center><h3>MARINIR</h3></center></div>
		</td>
		<tr><td  class="line_emas" colspan="2" >
		</tr>
			</table>
			<ul class="info" id="ship-info-marinir"></ul>
		  
		   <a href="#" id="close-marinir">
				<img src="<?php echo base_url() ?>assets/html/img/arrow-right.png" />
			</a>
		</div>

<div id="side-pangkalan" class="icandrag" style="display:none" >
		<table>
		<td>
			<div style="float:left"><img src="<?php echo base_url() ?>assets/html/img/Pskdl.png"/ width="50" height="48"></div>
		   <div style="color:#fff"><center><h3>PANGKALAN</h3></center></div>
		</td>
		<tr><td  class="line_emas" colspan="2" >
		</tr>
			</table>
			<div class="info" id="ship-info-pangkalan"></div>
		   <a href="#" id="close-pangkalan">
				<img src="<?php echo base_url() ?>assets/html/img/arrow-right.png" />
			</a>
		</div>

<div id="side-ais" class="icandrag" style="display:none" >
		<table>
		<td>
			<div style="float:left"><img src="<?php echo base_url() ?>assets/html/img/Pskdl.png"/ width="50" height="48"></div>
		   <div style="color:#fff"><center><h3>AIS</h3></center></div>
		</td>
		<tr><td  class="line_emas" colspan="2" >
		</tr>
			</table>
			<div class="info" id="ship-info-ais"></div>
		   <a href="#" id="close-ais">
				<img src="<?php echo base_url() ?>assets/html/img/arrow-right.png" />
			</a>
		</div>

<!-- side arpa -->
	<div id="side-arpa" class="icandrag" style="display:none" >
		<table>
		<td>
			<div style="float:left"><img src="<?php echo base_url() ?>assets/html/img/Pskdl.png"/ width="50" height="48"></div>
		   <div style="color:#fff"><center><h3>ARPA</h3></center></div>
		</td>
		<tr><td  class="line_emas" colspan="2" >
		</tr>
			</table>
			<div class="info" id="ship-info-arpa"></div>
		   <a href="#" id="close-arpa">
				<img src="<?php echo base_url() ?>assets/html/img/arrow-right.png" />
			</a>
		</div>
<!-- end side arpa -->


<div id="cuaca" >
	<div > 
		<h2> <center>Cuaca</center></h2>
		<form action="">			
			<input id="show-angin" type="radio" name="cuaca"><font>Angin</font><br>
			<input id="show-waves" type="radio" name="cuaca"><font>Gelombang</font></br>
			<input id="hapus-canvas" type="radio" name="cuaca" checked><font>Bersih</font><br>
			<input id="show-awan" type="checkbox"><font>Awan</font></br>
			<input id="show-hujan" type="checkbox"><font>Hujan</font></br>
			<input id="show-tekanan" type="checkbox"><font>Tekanan</font></br>
			<input id="show-suhu" type="checkbox"><font>Suhu</font> <br>    
			<input id="show-gempa" type="checkbox"><font>Gempa +7d</font>     
		</form>
	</div>
		<div class="titik">
		</div>
 </div>

<!-- </div>  -->
 <div id="lgn-kri">
	 <div>
		 <img src="<?php echo base_url() ?>assets/img/legenKRI.png">
	 </div>
	 <div class="titiklg">   
	 </div>
</div>

 <div style="width:100%, height:100%" id="map" ></div>
		 
		<div id="backlight" style="display: none;"></div>
		<div id="blanket" style="display:none;"><img src="<?php echo base_url() ?>assets/html/img/loading.gif" /></div>
		<div id="popUpDiv" style="display:none;"><img src="<?php echo base_url() ?>assets/html/img/loading.gif" /></div>
<!--     </div> 
</div>  -->


<div id="scan" class="chat" style="display:none" >
<p class="titlelan" style="padding-bottom:10px;">Pesan <a href="#" class="closing"><img src="<?php echo base_url() ?>assets/html/img/close.png" /></a></p> 

<div onclick="printContent()" style="float:left;  color:white;"><img src="<?php echo base_url() ?>assets/html/img/save.png" width="23" height="23" />&nbsp&nbspSimpan </div>
		<div id="filter" style="margin-left:370px;  padding-bottom:20px; color:white">  
		</div>

<!-- <br> -->
<hr> 

	 
		 <div id="scan"> 
		 <div id="ship-ado2" style=" "> </div>
		 <div id="ship-id2" class="scrl"></div> 
				 
</div> 

  </div>  

</div> 
</body>
<script type="text/javascript">
  
$(document).ready(function() {
  $('.icandrag').draggable({
		cursor:'move',
		containment: '#container'
		});
}); 

$(document).ready(function() {
  $('.icandrag2').draggable({
		cursor:'move',
		containment: '#container'
		});
}); 
</script>
<script type="text/javascript">


	
	function printContent(back){
	// var restorepage = document.body.innerHTML;
	// var printcontent = document.getElementById(back).innerHTML;
	// document.body.innerHTML = printcontent;
	window.print();
	// document.body.innerHTML = restorepage;

   

	}
	
	   
</script>

 <script>

$(document).ready(function() {
  $('.chat').draggable({
		cursor:'move',
		containment: '#container'
		});
}); 

$(document).ready(function(){
	$("#show-cuaca").click(function(){
		$("#cuaca").slideToggle();
	});
	
});

$(document).ready(function(){
	$("#show-kri").click(function(){
		$("#lgn-kri").slideToggle();
	});
	
});
$('.open').click(function(e){
		e.preventDefault();
		
		$('#menu').animate({width:'toggle'}, 300);
	});
	$('ul#side-menu div a#btn1').click(function(e){
		e.preventDefault();
		
		$('#menu').animate({width:'toggle'}, 300);
	});


  $("#baseline").click(function(){
    $("#base").animate({width:'toggle'}, 900);
      
  });

 </script>

<script>
function checkTime(i) {
	if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
	return i;
}

function startTime() {
	var today=new Date();
	var h=today.getHours();
	var m=today.getMinutes();
	var s=today.getSeconds();
	m = checkTime(m);
	s = checkTime(s);
	var str = today.toDateString();
	document.getElementById('txt').innerHTML = str+" - "+h+":"+m+":"+s;
	var t = setTimeout(function(){startTime()},500);
}
startTime();              
</script>
</html>
