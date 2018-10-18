// THE ULTIMATE MAPS OF RESILIENT
// Author / creator   : GOPAL (Naufal El Farisi M) 
// Contact            : naufalelfarisim@gmail.com 
// Email              : 085659360489 
// Lama Pengerjaan    : 2017-2018

// init include html syntax from index.html
includeHTML();

// GLOBAL VARIABLE
var map; 
var dishidros,ais,kkp,rapingla,migas,pasut;
var overlays, baseMaps, bsm, layerControl1, layerControl2, layerControl3, layerControl4;
var tik, terline1,terline2,terline3,terline4, pklline1,pklline2,pklline3, tmbline1,tmbline2,tmbline3,tmbline4,tmbline5, zeeline1,zeeline2,zeeline3,zeeline4,zeeline5,zeeline6;
var teri, zee, tmbline, pklline, konline, stline, tk1, tk2;
var gempa,tekanan,awan,suhu,hujan;
var ikanpari,ikanbiru,ikanmerah,ikanoren,ikanpink,ikanhiu,ikanpaus,kepitingicon,udangicon,cumiicon,lobstericon,gmpaIcon,aiscon,buletabu,buletdefault,bulethijau,bulethitam,buletkuning,buletmerah,buletputih,bulettransp,buletungu;
var LOCATIONSTAT = false;
var EDITSTAT, DRAWSTAT;
var BUFFERFORM = {}; 
var BUFFERORGorg = {};
var BUFFERORG = [];

//CONFIG IP AJAX
var URLAPI        = 'http://192.168.1.241:9099/api/';
var URLINTELBOT   = URLAPI+'rawpesans';
var URLTK1        = 'json/tk1ori.json';
var URLTK2        = 'json/tk2ori.json';
var URLCUACABASE  = "../getcuaca/bin/hasil/"; 
var URLBATASLINE  = 'json/batasline.json';
var URLIKAN       = 'json/ikan.json';
var URLWINDBASE   = 'http://192.168.1.124:7000/';


// FUNCTION FUNCTION FUNCTION FUNCTION FUNCTION FUNCTION FUNCTION FUNCTION
// FUNCTION FUNCTION FUNCTION FUNCTION FUNCTION FUNCTION FUNCTION FUNCTION
// FUNCTION FUNCTION FUNCTION FUNCTION FUNCTION FUNCTION FUNCTION FUNCTION
function INITMAP(){
		// MAP SOURCE MAP SOURCE MAP SOURCE MAP SOURCE MAP SOURCE
		var CartoDB_DarkMatter = L.tileLayer('http://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png', {maxZoom: 19});
		var CartoDB_GreyMatter = L.tileLayer('https://b.basemaps.cartocdn.com/rastertiles/light_all/{z}/{x}/{y}.png', {maxZoom: 19});
		var standard = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 19,});
		var primar = L.tileLayer.wms("http://primar.ecc.no/primar/wms_session", {    layers: 'cells',    format: 'image/png',    noWrap: true,    transparent: true    });
		var navtoniv = L.tileLayer('https://backend.navionics.io/tile/{z}/{x}/{y}?LAYERS=config_1_20.00_1&TRANSPARENT=FALSE&UGC=TRUE&navtoken=eyJrZXkiOiJOYXZpb25pY3NfaW50ZXJuYWxwdXJwb3NlXzAwMDAxIiwia2V5RG9tYWluIjoid2ViYXBwLm5hdmlvbmljcy5jb20iLCJyZWZlcmVyIjoid2ViYXBwLm5hdmlvbmljcy5jb20iLCJyYW5kb20iOjM2Mjc4fQ');
		var gray = L.esri.basemapLayer('Gray');//.addTo(map);
		var streets = L.esri.basemapLayer('Streets');//.addTo(map);
		var topo = L.esri.basemapLayer('Topographic');//.addTo(map);
		var nationalgeo = L.esri.basemapLayer('NationalGeographic');//.addTo(map);
		var ocean = L.esri.basemapLayer('Oceans');//.addTo(map);
		var darkgray = L.esri.basemapLayer('DarkGray');//.addTo(map);
		var image = L.esri.basemapLayer('Imagery');//.addTo(map);
		var imagel = L.esri.basemapLayer('ImageryLabels');//.addTo(map);
		var imaget = L.esri.basemapLayer('ImageryTransportation');//.addTo(map);
		var shade = L.esri.basemapLayer('ShadedRelief');//.addTo(map);
		var terain = L.esri.basemapLayer('Terrain');//.addTo(map);
		var usa = L.esri.basemapLayer('USATopo');//.addTo(map);
		var lightgray = L.tileLayer('http://services.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}', {maxZoom: 19});
		var satlabel = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}', {maxZoom: 21});    

		// var Esri_OceanBasemap = L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/Ocean_Basemap/MapServer/tile/{z}/{y}/{x}', {maxZoom: 13});
		// var mid = L.esri.Vector.basemap('MidCentury');//.addTo(map);
		// var news = L.esri.Vector.basemap('Newspaper');//.addTo(map);
		// var spring = L.esri.Vector.basemap('Spring');//.addTo(map);
		// var dishidros = L.esri.dynamicMapLayer({url: 'http://hdc.pushidrosal.id/arcgis/rest/services/enc_indonesia/MapServer/exts/MaritimeChartService/MapServer', opacity: 0.6, f:'image'});
		// var dishidros = L.esri.dynamicMapLayer({url: 'http://hdc.pushidrosal.id/arcgis/rest/services/SampleWorldCities/MapServer/exts/MaritimeChartService/MapServer', opacity: 0.6, f:'image'});
		dishidros = L.esri.dynamicMapLayer({url: 'http://hdc.pushidrosal.id/arcgis/rest/services/SampleWorldCities/MapServer/exts/MaritimeChartService/MapServer', opacity: 0.6, f:'image', layers: [0,2,3,4,5,6,7,8,9,10]});
		//layer.show:
		// 0 = kotak batas
		// 1 = land & rambu2 pulau kecil
		// 2 = angka2 kedalaman laut
		// 3 = garis ungu jalur pelayaran
		// 4 = rambu2 bundar ungu
		// 5 = rambu2 ungu lainnnya
		// 6 = mercusuar dan lingkaranya
		// 7 = garis ungu batas pulau
		// 8 = garis2 ungu
		// 9 = 
		// var topoindo = L.esri.dynamicMapLayer({url: 'http://hdc.dishidros.go.id/arcgis/rest/services/enc_indonesia/MapServer/exts/Maritime%20Chart%20Service/MapServer', opacity: 0.6, f:'image'});
		var topoindo = L.tileLayer('https://a.tile.thunderforest.com/landscape/{z}/{x}/{y}.png?apikey=a5dd6a2f1c934394bce6b0fb077203eb', {maxZoom: 19});
		// list of topologi map from opencycle free
		// https://a.tile.thunderforest.com/cycle/{z}/{x}/{y}.png
		// https://a.tile.thunderforest.com/outdoors/{z}/{x}/{y}.png
		// https://a.tile.thunderforest.com/transport-dark/{z}/{x}/{y}.png
		// https://a.tile.thunderforest.com/landscape/{z}/{x}/{y}.png
		// https://a.tile.thunderforest.com/cycle/{z}/{x}/{y}.png
		// https://a.tile.thunderforest.com/cycle/{z}/{x}/{y}.png
		var udaraindo= L.esri.dynamicMapLayer({url: 'http://hdc.dishidros.go.id/arcgis/rest/services/enc_indonesia/MapServer/exts/Maritime%20Chart%20Service/MapServer', opacity: 0.6, f:'image'});
		migas = L.esri.dynamicMapLayer({url: 'http://webgis.den.go.id/arcgis/rest/services/Pipa_Hulu_Migas/MapServer', opacity: 0.9, f:'image'});
		rapingla = L.esri.dynamicMapLayer({url: 'http://hdc.dishidros.tnial.mil.id/arcgis/rest/services/raplingla/MapServer', opacity: 0.7, f:'image'});
		pasut = L.esri.dynamicMapLayer({url: 'http://hdc.dishidros.tnial.mil.id/arcgis/rest/services/Pasut/MapServer', opacity: 0.7, f:'image'});
		kkp = L.esri.dynamicMapLayer({url: 'http://www.ppk-kp3k.kkp.go.id/ArcGIS/rest/services/kkp/Kawasan/MapServer', opacity: 1,useCors : false,f:'image'});
		ais = L.esri.Cluster.featureLayer({url: 'http://geoeventsample1.esri.com:6080/arcgis/rest/services/Hosted/exactEarthCurrent/FeatureServer/0',opacity:1,pointToLayer: 
		// ais = L.esri.Cluster.featureLayer({url: 'json/gempa.json',opacity:1,pointToLayer: 
			function (geojson, latlng){   
				console.log(geojson);
				return L.marker(latlng, {rotationAngle: geojson.properties.cog, icon: aiscon})
					 .bindPopup("<table width=100% style='font-size:11px'><tr>"+
											"<td>Nama kapal </td><td>: "+geojson.properties.vessel_name+"</td>"+
											"</tr><tr>"+
											"<td>Type kapal </td><td>: "+geojson.properties.vessel_type+"</td>"+
											"</tr><tr>"+
											"<td>Kelas Kapal </td><td>: "+geojson.properties.vessel_class+"</td>"+
											"</tr><tr>"+
											"<td>Callsign </td><td>: "+geojson.properties.callsign+"</td>"+
											"</tr><tr>"+
											"<td>Status </td><td>: "+geojson.properties.nav_status+"</td>"+
											"</tr><tr>"+
											"<td>Latitude </td><td>: "+geojson.properties.latitude+"</td>"+
											"</tr><tr>"+
											"<td>longitude </td><td>: "+geojson.properties.longitude+"</td>"+
											"</tr><tr>"+
											"<td>MMSI </td><td>: "+geojson.properties.mmsi+"</td>"+
											"</tr><tr>"+
											"<td>COG </td><td>: "+geojson.properties.cog+"</td>"+
											"</tr><tr>"+
											"<td>SOG </td><td>: "+geojson.properties.sog+"</td>"+
											"</tr><tr>"+
											"<td>Flag </td><td>: "+geojson.properties.flag+"</td>"+
											"</tr><tr>"+
											"<td>Destination </td><td>: "+geojson.properties.destination+"</td>"+
											"</tr><tr>"+
											"<td>Draught </td><td>: "+geojson.properties.draught+" m</td>"+
											"</tr><tr>"+
											"<td>Panjang </td><td>: "+geojson.properties.length+" m</td>"+
											"</tr><tr>"+
											"<td> Lebar </td><td>: "+geojson.properties.width+" m</td>"+
											"</tr></table>"
						);
			}
		});

		// LAYERCONTROL
		baseMaps = {
			// "Navtonic": navtoniv,
			"Black": CartoDB_DarkMatter,
			"Grey": CartoDB_GreyMatter,
			"Open Street": standard,
			// "Gray": gray, 
			// "Streets": streets,
			// "Topo": topo,
			// "NatGeo": nationalgeo,
			// "Ocean": ocean,
			// "DarkGry": darkgray,
			// "LightGry":lightgray,
			"Satelite": image,
			// "Sat Label": imagel,
			// "Sat Transport": imaget,
			// "Shade": shade,
			// "Terain": terain,
			// "USA topo": usa,
			"Topografi":topoindo
			// "Mid": mid,
			// "Spring" : spring,
			// "News": news
		};

		// bsm = {
			// "Open Street": standard,
			// "Streets": streets,
			// "Topo": topo,
			// "NatGeo": nationalgeo,
			// "Ocean": ocean,
			// "Imagy": image,
			// "Shade": shade,
			// "Gray": gray, 
			// "DarkGry": darkgray,
			// "Black": CartoDB_DarkMatter,
			// "Terain": terain
			// "USA topo": usa
			// "Mid": mid,
			// "Spring" : spring,
			// "News": news
		// };

		var configMap = {
						//gerlong
						latCenter : -6.862386170,
						lonCenter : 107.588816285,
						zoom :17,

						mapUrl : 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
						mapStyleId : 22677
		};

		map = new L.map('map', {
			// drawControl: true,
			center: [configMap.latCenter, configMap.lonCenter],
			zoom: configMap.zoom,
			layers: [standard],
			maxZoom : 19,
			minZoom : 3
			// worldCopyJump : true
		});
}


function INITICON(){
		// ikanpari = L.icon({iconUrl: 'aset/img/paripari.png', iconSize: [40,40], iconAnchor:[20,20]});
		// ikanbiru = L.icon({iconUrl: 'aset/img/ikanbiru.png', iconSize: [40,40], iconAnchor:[20,20]});
		// ikanmerah = L.icon({iconUrl: 'aset/img/ikanmerah.png', iconSize: [40,40], iconAnchor:[20,20]});
		// ikanoren = L.icon({iconUrl: 'aset/img/ikanoren.png', iconSize: [40,40], iconAnchor:[20,20]});
		// ikanpink = L.icon({iconUrl: 'aset/img/ikanpink.png', iconSize: [40,40], iconAnchor:[20,20]});
		// ikanhiu = L.icon({iconUrl: 'aset/img/hiuhiu.png', iconSize: [40,40], iconAnchor:[20,20]});
		// ikanpaus = L.icon({iconUrl: 'aset/img/pauspaus.png', iconSize: [40,40], iconAnchor:[20,20]});
		// kepitingicon = L.icon({iconUrl: 'aset/img/kepiting.png', iconSize: [40,40], iconAnchor:[20,20]});
		// udangicon = L.icon({iconUrl: 'aset/img/udangudang.png', iconSize: [40,40], iconAnchor:[20,20]});
		// cumiicon = L.icon({iconUrl: 'aset/img/cumicumi.png', iconSize: [40,40], iconAnchor:[20,20]});
		// lobstericon = L.icon({iconUrl: 'aset/img/lobterlobster.png', iconSize: [40,40], iconAnchor:[20,20]});
		gmpaIcon = L.icon({iconUrl: '../aset/img/epic.gif', iconSize: [50,50], iconAnchor:[25,25]});
		aiscon = L.icon({iconUrl: '../aset/img/v.png', iconSize: [24,24], iconAnchor:[12,12]});
		buletabu = L.icon({iconUrl: '../aset/img/iconabu.png', iconSize: [12,12], iconAnchor:[6,6]});
		buletdefault = L.icon({iconUrl: '../aset/img/icondefault.png', iconSize: [12,12], iconAnchor:[6,6]});
		bulethijau = L.icon({iconUrl: '../aset/img/iconhijau.png', iconSize: [12,12], iconAnchor:[6,6]});
		bulethitam = L.icon({iconUrl: '../aset/img/iconhitam.png', iconSize: [12,12], iconAnchor:[6,6]});
		buletkuning = L.icon({iconUrl: '../aset/img/iconkuning.png', iconSize: [12,12], iconAnchor:[6,6]});
		buletmerah = L.icon({iconUrl: '../aset/img/iconmerah.png', iconSize: [12,12], iconAnchor:[6,6]});
		buletputih = L.icon({iconUrl: '../aset/img/iconputih.png', iconSize: [12,12], iconAnchor:[6,6]});
		bulettransp = L.icon({iconUrl: '../aset/img/icontransp.png', iconSize: [12,12], iconAnchor:[6,6]});
		buletungu = L.icon({iconUrl: '../aset/img/iconungu.png', iconSize: [12,12], iconAnchor:[6,6]});
}


function INITPLUGIN(){
		// LEAFLET search
		map.addControl( new L.Control.Search({
				url: 'http://nominatim.openstreetmap.org/search?format=json&q={s}',
				jsonpParam: 'json_callback',
				propertyName: 'display_name',
				propertyLoc: ['lat','lon'],
				marker: L.circleMarker([0,0],{radius:20}),
				// autoCollapse: true,
				autoType: false,
				position: 'topright',
				collapsed: false,
				// autoCollapse: false,
				// hideMarkerOnCollapse: true,
				minLength: 2
			}) );

		//LEAFLET attribution
		var attrib = new L.Control.Attribution;
		map.addControl(attrib); 
		attrib.setPrefix('<a href="https://www.youtube.com/c/resilientonamission/about" target="_blank"><strong>Gopal & Sesdika, 2018</strong></a>');
		map.on('mousemove', function(e) {
			attrib.setPrefix('Koordinat : '+e.latlng.lat+", "+e.latlng.lng+'. Zoom:'+map.getZoom()+'. <a target="_blank" href="https://www.youtube.com/c/resilientonamission/about"><strong>Gopal & Sesdika, 2018</strong></a>');
		});

		//LEAFLET scale nautica
		map.addControl(new L.Control.ScaleNautic({
				// position: 'bottomleft',
				metric: true,
				imperial: true,
				nautic: true
		}));
}


function INITANGIN(){
		// var layerControl = L.control.layers(bsm).addTo(map);
		var layerControl = L.control.layers().addTo(map);
		var handleError = function(err){
				console.log('handleError...');
				console.log(err);
		};
		WindJSLeaflet.init({ 
				localMode: true,                                 // use a local data file to test before hitting a real wind-js-server
				map: map,                                       // ref to your leaflet Map
				layerControl: layerControl,                    // ref to your leaflet layer control
				useNearest: false,                              // get nearest data to your ISO time string
				timeISO: null,                                  // your ISO time string, falls back to current time (can also use WindJsLeaflet.setTime(time))
				nearestDaysLimit: 7,                            // the maximum range (±) to look for data 
				displayValues: true,                              // whether or not to add a mouseover control to display values
				displayOptions: {
					 position: 'bottomright',               // leaflet control position
					 displayEmptyString: 'No wind data'           // what to display in mouseover control when no data
				},
				overlayName: 'wind',                            // string to display for the overlay in your layer control
				pingUrl: URLWINDBASE+'alive',        // url to check service availability
				latestUrl: URLWINDBASE+'latest',     // url to get latest data with no required params   
				nearestUrl: URLWINDBASE+'nearest',   // url to get data nearest a specified time ISO 
				errorCallback: handleError
		});  
}


function INITCUACAGEMPA(){
		var listGempa = [];
		gempa = L.layerGroup(listGempa);
		var bmkg, tekananUrl, suhuUrl, hujanUrl, awanUrl;

		var dt = new Date();
		var ss = dt.getHours();
		var k;  // j for windyty data,, k for sadewa data

			// // windyty update data tiap 3 jam sekali sesuai jam windyty (rusia).. sadewa update data 1 jam sekali
			switch(ss) {
					case 0:k = "17";break;
					case 1:k = "18";break;
					case 2:k = "19";break;
					case 3:k = "20";break;
					case 4:k = "21";break;
					case 5:k = "22";break;
					case 6:k = "23";break;
					case 7:k = "00";break;
					case 8:k = "01";break;
					case 9:k = "02";break;
					case 10:k = "03";break;
					case 11:k = "04";break;
					case 12:k = "05";break;
					case 13:k = "06";break;     
					case 14:k = "07";break;
					case 15:k = "08";break;
					case 16:k = "09";break;
					case 17:k = "10";break;
					case 18:k = "11";break;
					case 19:k = "12";break;
					case 20:k = "13";break;
					case 21:k = "14";break;
					case 22:k = "15";break;
					case 23:k = "16";break;
			}

		tekananUrl = URLCUACABASE+'psf_'+k+'.png';
		suhuUrl = URLCUACABASE+'sst_'+k+'.png';
		hujanUrl = URLCUACABASE+'rain_'+k+'.png';
		awanUrl = URLCUACABASE+'cloud_'+k+'.png';
		bmkg = URLCUACABASE+"gempaterkini.xml"; 
		// var bmkg = bas+"gempaauto.xml";

			//init data sadewa
			var smBounds = [[-10.0, 95.0], [10.0, 145.0]];
			var lgBounds = [[70.0, 70.0], [-70.0, 210.0]];

			awan =L.imageOverlay(awanUrl, smBounds);
			tekanan =L.imageOverlay(tekananUrl, smBounds);
			suhu =L.imageOverlay(suhuUrl, smBounds);
			hujan =L.imageOverlay(hujanUrl, smBounds);


		var tgl,jam,lat,lon,mag,ked,wil,pot,cek7hr;
		var koor = [];

		$.ajax({
			type: 'GET',        
			url: bmkg,
			dataType: "xml",
			success:function(xml){
				$(xml).find('Infogempa').each(function(){
					$(this).find("gempa").each(function(){

						info = $(this).text(); 
						$(this).find("Tanggal").each(function(){
							tgl = $(this).text();                   
							var d = new Date();
							d.setDate(d.getDate() - 7); // disini diset brp hari yg lalu, misal 7 hari yg lalu jadinya - 7
							if (d - new Date(tgl) <= 0){cek7hr = true} else cek7hr = false;
						});
						$(this).find("Jam").each(function(){jam = $(this).text()});
						$(this).find("point").each(function(){
							$(this).find("coordinates").each(function(){koor = $(this).text().split(",")}); 
						});
						$(this).find("Lintang").each(function(){lat = $(this).text()});
						$(this).find("Bujur").each(function(){lon = $(this).text()});
						$(this).find("Magnitude").each(function(){mag = $(this).text()});
						$(this).find("Kedalaman").each(function(){ked = $(this).text()});
						$(this).find("Wilayah").each(function(){wil = $(this).text()}); 
						
						// cek ini 2hr lalu ga?
						if (cek7hr){
							// bikin icon
							var gmpa = L.marker([koor[1],koor[0]], {icon: gmpaIcon})
								.bindTooltip("<table  style='font-size:10px'><tr>"+
															"<td>Tanggal </td><td>: "+tgl+"</td>"+
														"</tr><tr>"+
															"<td>Jam </td><td>: "+jam+"</td>"+
														"</tr><tr>"+
															"<td>Lintang </td><td>: "+lat+"</td>"+
														"</tr><tr>"+
															"<td>Bujur </td><td>: "+lon+"</td>"+
														"</tr><tr>"+
															"<td>Magnitude </td><td>: "+mag+"</td>"+
														"</tr><tr>"+
															"<td>Kedalaman </td><td>: "+ked+"</td>"+
														"</tr><tr>"+
															"<td>Wilayah </td><td>: "+wil+"</td>"+
														"</tr></table>",
										{opacity:0.8, sticky:true});
							listGempa.push(gmpa);                   
						}// end of cek (if)

					});
				});
				gempa = L.layerGroup(listGempa);
			}
		}); 
}


function INITBATAS(){
		teri = L.layerGroup();
		zee = L.layerGroup();
		tmbline = L.layerGroup();
		pklline = L.layerGroup();
		tk1 = L.layerGroup();
		tk2 = L.layerGroup();

		// batas Wilayah Daerah Tingkat 2 (kotamadya/kabupaten)
		$.ajax({
			type: 'GET',        
			url: URLTK2,        
			success:function(response){
					// console.log(response);
					var linetk2;
					for(var i=0; i<response.data.length; i++){
							// var titiktkdua=[];
							// console.log(response.data[i].geometry);
							if(response.data[i].geometry.type == "MultiPolygon"){ //multipolygon
									var titiktkduaMP=[];
									// console.log("multipolygon");
									for(var ii=0; ii<response.data[i].geometry.coordinates.length; ii++){
											// console.log(response.data[i].geometry.coordinates[ii].length);
											var buff=[];
											for(var iii=0; iii<response.data[i].geometry.coordinates[ii][0].length; iii++){
													tik = new L.LatLng(response.data[i].geometry.coordinates[ii][0][iii][1], response.data[i].geometry.coordinates[ii][0][iii][0]); 
													buff.push(tik);
											}
											titiktkduaMP.push(buff);
											// disini gakuat, ramnya ga cukup terus
											// linetk2 = new L.polygon(titiktkdua, {color: "#7700ff", weight: 1, opacity: 1, smoothFactor: 1}).bindTooltip('batas teritorial').addTo(map);
									}
									// disini banyak nyilang
									linetk2 = new L.polygon(titiktkduaMP, {color: "green", weight: 1.5, opacity: 1, smoothFactor: 1})
									// .bindTooltip('batas teritorial').addTo(map);
									.bindTooltip("<table  style='font-size:11px'><tr>"+
															"<td>Nama </td><td>: "+response.data[i].properties.NAME_2+"</td>"+
														"</tr><tr>"+
															"<td>Tipe </td><td>: "+response.data[i].properties.TYPE_2+"</td>"+
														"</tr><tr>"+
															"<td>Kode </td><td>: "+response.data[i].properties.HASC_2+"</td>"+
														"</tr><tr>"+
															"<td>Provinsi </td><td>: "+response.data[i].properties.NAME_1+"</td>"+
														"</tr></table>",
										{opacity:0.8, sticky:true});//.addTo(map);
							} else if(response.data[i].geometry.type == "Polygon"){ //polygon
									var titiktkduaP=[];
									// console.log("polygon")
									for(var ii=0; ii<response.data[i].geometry.coordinates[0].length; ii++){
											tik = new L.LatLng(response.data[i].geometry.coordinates[0][ii][1], response.data[i].geometry.coordinates[0][ii][0]); 
											titiktkduaP.push(tik);
									}
									linetk2 = new L.polygon(titiktkduaP, {color: "green", weight: 1.5, opacity: 1, smoothFactor: 1})
									// .bindTooltip("<table  style='font-size:10px'><tr>"+
									.bindTooltip("<table  style='font-size:11px'><tr>"+
															"<td>Nama </td><td>: "+response.data[i].properties.NAME_2+"</td>"+
														"</tr><tr>"+
															"<td>Tipe </td><td>: "+response.data[i].properties.TYPE_2+"</td>"+
														"</tr><tr>"+
															"<td>Kode </td><td>: "+response.data[i].properties.HASC_2+"</td>"+
														"</tr><tr>"+
															"<td>Provinsi </td><td>: "+response.data[i].properties.NAME_1+"</td>"+
														"</tr></table>",
										{opacity:0.8, sticky:true});//.addTo(map);
							}
							tk2.addLayer(linetk2);

							// simple dan gampang kalau datanya udh bener
							// linetk2 = new L.polygon(response.data[i].geometry.coordinates, {color: "#7700ff", weight: 1, opacity: 1, smoothFactor: 1}).bindTooltip('batas teritorial').addTo(map);
							// tk2.addLayer(linetk2);
					}
					console.log("beres iterasi tk2");
					// console.log(tk2);
					
			}
		}) // end of ajax


		// batas Wilayah Daerah Tingkat 1 (provinsi)
		$.ajax({
			type: 'GET',
			url: URLTK1,
			success:function(response){
					// console.log(response);
					var linetk1;
					for(var i=0; i<response.data.length; i++){
							// console.log(response.data[i].properties);
							var titiktksatuMP=[];
							for(var ii=0; ii<response.data[i].geometry.coordinates.length; ii++){
									var buff=[];
									for(var iii=0; iii<response.data[i].geometry.coordinates[ii][0].length; iii++){
											tik = new L.LatLng(response.data[i].geometry.coordinates[ii][0][iii][1], response.data[i].geometry.coordinates[ii][0][iii][0]); 
											buff.push(tik);
									}
									titiktksatuMP.push(buff);
							}
							linetk1 = new L.polygon(titiktksatuMP, {color: "blue", weight: 3, opacity: 1, smoothFactor: 1})
							// .bindTooltip('batas teritorial').addTo(map);
								.bindTooltip("<table  style='font-size:11px'><tr>"+
													"<td>Nama </td><td>: "+response.data[i].properties.VARNAME_1+"</td>"+
												"</tr><tr>"+
													"<td>Tipe </td><td>: "+response.data[i].properties.ENGTYPE_1+" / "+response.data[i].properties.TYPE_1+"</td>"+
												"</tr><tr>"+
													"<td>Kode </td><td>: "+response.data[i].properties.HASC_1+"</td>"+
												"</tr><tr>"+
													"<td>Nama Provinsi </td><td>: "+response.data[i].properties.NAME_1+"</td>"+
												"</tr></table>",
								{opacity:0.8, sticky:true});//.addTo(map);
							tk1.addLayer(linetk1);
					}
					console.log("beres iterasi tk1");
					// console.log(tk1);
					
			}
		}) // end of ajax


		// batas Negara / Teritorial
		$.ajax({
			type: 'GET',        
			url: URLBATASLINE,        
			success:function(response){
				// console.log('batas',response);
				var teritorialList1 =[]; var teritorialList2 =[]; var teritorialList3 =[]; var teritorialList4 =[];
				var pangkalList1 = []; var pangkalList2 = []; var pangkalList3 = [];
				var tambahanList1 = []; var tambahanList2 = []; var tambahanList3 = []; var tambahanList4 = []; var tambahanList5 = [];
				var zeeList1 = []; var zeeList2 = []; var zeeList3 = []; var zeeList4 = []; var zeeList5 = []; var zeeList6 = [];
				var kontinenList = []; var stList = [];         

				for (i = 0; i < response.features.length; i++) { 
					for (ii = 0; ii < response.features[i].latlon.length; ii++) { 
						if (response.features[i].tag == "ter1"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); teritorialList1.push(tik); }
						if (response.features[i].tag == "ter2"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); teritorialList2.push(tik); }
						if (response.features[i].tag == "ter3"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); teritorialList3.push(tik); }
						if (response.features[i].tag == "ter4"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); teritorialList4.push(tik); }

						if (response.features[i].tag == "pkl1"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); pangkalList1.push(tik); }
						if (response.features[i].tag == "pkl2"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); pangkalList2.push(tik); }
						if (response.features[i].tag == "pkl3"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); pangkalList3.push(tik); }

						if (response.features[i].tag == "tmb1"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); tambahanList1.push(tik); }
						if (response.features[i].tag == "tmb2"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); tambahanList2.push(tik); }
						if (response.features[i].tag == "tmb3"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); tambahanList3.push(tik); }
						if (response.features[i].tag == "tmb4"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); tambahanList4.push(tik); }
						if (response.features[i].tag == "tmb5"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); tambahanList5.push(tik); }

						if (response.features[i].tag == "zee1"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); zeeList1.push(tik); }
						if (response.features[i].tag == "zee2"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); zeeList2.push(tik); }
						if (response.features[i].tag == "zee3"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); zeeList3.push(tik); }
						if (response.features[i].tag == "zee4"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); zeeList4.push(tik); }
						if (response.features[i].tag == "zee5"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); zeeList5.push(tik); }
						if (response.features[i].tag == "zee6"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); zeeList6.push(tik); }

						if (response.features[i].tag == "kon"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); kontinenList.push(tik); }
						if (response.features[i].tag == "197"){ tik = new L.LatLng(response.features[i].latlon[ii][1], response.features[i].latlon[ii][0]); stList.push(tik); }         
					}
				}
				
				terline1 = new L.polyline(teritorialList1, {color: "#7700ff", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('batas teritorial', { noHide: true }); //.addTo(map);
				terline2 = new L.polyline(teritorialList2, {color: "#7700ff", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('batas teritorial', { noHide: true }); //.addTo(map);
				terline3 = new L.polyline(teritorialList3, {color: "#7700ff", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('batas teritorial', { noHide: true }); //.addTo(map);
				terline4 = new L.polyline(teritorialList4, {color: "#7700ff", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('batas teritorial', { noHide: true }); //.addTo(map);

				pklline1 = new L.polyline(pangkalList1, {color: 'red', weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('garis pangkal', { noHide: true }); //.addTo(map);
				pklline2 = new L.polyline(pangkalList2, {color: 'red', weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('garis pangkal', { noHide: true }); //.addTo(map);
				pklline3 = new L.polyline(pangkalList3, {color: 'red', weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('garis pangkal', { noHide: true }); //.addTo(map);

				tmbline1 = new L.polyline(tambahanList1, {color: "#DBA901", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('zona tambahan', { noHide: true }); //.addTo(map);
				tmbline2 = new L.polyline(tambahanList2, {color: "#DBA901", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('zona tambahan', { noHide: true }); //.addTo(map);
				tmbline3 = new L.polyline(tambahanList3, {color: "#DBA901", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('zona tambahan', { noHide: true }); //.addTo(map);
				tmbline4 = new L.polyline(tambahanList4, {color: "#DBA901", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('zona tambahan', { noHide: true }); //.addTo(map);
				tmbline5 = new L.polyline(tambahanList5, {color: "#DBA901", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('zona tambahan', { noHide: true }); //.addTo(map);

				zeeline1 = new L.polyline(zeeList1, {color: "#088A08", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('ZEE', { noHide: true }); //.addTo(map);
				zeeline2 = new L.polyline(zeeList2, {color: "#088A08", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('ZEE', { noHide: true }); //.addTo(map);
				zeeline3 = new L.polyline(zeeList3, {color: "#088A08", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('ZEE', { noHide: true }); //.addTo(map);
				zeeline4 = new L.polyline(zeeList4, {color: "#088A08", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('ZEE', { noHide: true }); //.addTo(map);
				zeeline5 = new L.polyline(zeeList5, {color: "#088A08", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('ZEE', { noHide: true }); //.addTo(map);
				zeeline6 = new L.polyline(zeeList6, {color: "#088A08", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('ZEE', { noHide: true }); //.addTo(map);

				konline = new L.polyline(kontinenList, {color: "#2E9AFE", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('landas kontinent', { noHide: true }); //.addTo(map);
				stline = new L.polyline(stList, {color: "#0901ff", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '3, 4'}).bindTooltip('perjanjian 1997', { noHide: true }); //.addTo(map);

				teri = L.layerGroup([terline1, terline2, terline3, terline4]);
				zee = L.layerGroup([zeeline1, zeeline2, zeeline3, zeeline4, zeeline5, zeeline6]);
				tmbline = L.layerGroup([tmbline1, tmbline2, tmbline3, tmbline4, tmbline5]);
				pklline = L.layerGroup([pklline1, pklline2, pklline3]);
				// tk1 = L.layerGroup([]);
				// tk2 = L.layerGroup([]);
				
		
				//masukin semua overlays disini
				overlays = {
						// "Batas Wilayah":{
							// "<font color='#2E9AFE'>Landas Kontinent</font>": konline, 
							// "<font color='#0901ff'>Perjanjian 1997</font>": stline, 
							"<font color='red'>Garis Batas</font>": pklline,
							"<font color='#7700ff'>Teritorial</font>": teri,
							"<font color='#DBA901'>Zona Plus</font>": tmbline, 
							"<font color='#088A08'>ZEE</font>": zee,
							"<font color='blue'>Tingkat 1</font>": tk1,
							"<font color='green'>Tingkat 2</font><br><br><b>Peta Tambahan :</b>": tk2,
						// },
						// "Peta Tambahan":{
							"Dishidros" : dishidros,
							// "DishidrosT" : dishidrost,
							"AIS": ais,
							"KKP wilayah" : kkp,
							"Hulu Migas" : migas,
							"Rapingla" : rapingla,
							"Pasut <br><br><b>Cuaca & Gempa:</b>" : pasut,
						// },
						// "Cuaca & Gempa":{
							"Gempa 7hr": gempa,
							"Tekanan": tekanan,
							"Awan": awan,
							"Suhu": suhu,
							"Hujan": hujan
						// }
				};

				layerControl1 = L.control.layers(baseMaps, overlays).addTo(map);
				//layerControl3 = L.control.groupedLayers(null,ikan, {position:'topright'}).addTo(map);
			},
			error: function() {
				console.log("Error json request"); 
				window.confirm("Data batas gagal diload");
			}
		}); 
}


function INITLAPORANPERSONEL(){
		//laporan
		var lapor3= L.layerGroup([]),lapor7= L.layerGroup([]),lapor30= L.layerGroup([]),lapor365= L.layerGroup([]);
		$.ajax({
			type: 'GET',        
			url: URLINTELBOT+'/filter/last3day',        
			success:function(lapor){
				console.log(lapor);
				for(var i=0; i<lapor.data.length; i++){
					var mark = L.marker([lapor.data[i].lokasi.latitude, lapor.data[i].lokasi.longitude], {icon:buletmerah})
							.bindTooltip("<table width=100% style='font-size:11px'><tr>"+
														"<td>Date </td><td>: "+lapor.data[i].date+"</td>"+
														"</tr><tr>"+
														"<td>Kategori </td><td>: "+lapor.data[i].category+"</td>"+
														"</tr><tr>"+
														"<td>Pengirim </td><td>: "+lapor.data[i].dari+"</td>"+
														"</tr><tr>"+
														"<td>Lokasi </td><td>: "+lapor.data[i].lokasi.latitude+", "+lapor.data[i].lokasi.longitude+"</td>"+
														"</tr><tr>"+
														"<td>Laporan </td><td>: "+lapor.data[i].laporan+"</td>"+
														"</tr></table>"                        
														,{opacity:0.8, sticky:true});
							lapor3.addLayer(mark);
				}
			}
		});
		$.ajax({
			type: 'GET',        
			url: URLINTELBOT+'/filter/lastweek',        
			success:function(lapor){
				console.log(lapor);
				for(var i=0; i<lapor.data.length; i++){
					var mark = L.marker([lapor.data[i].lokasi.latitude, lapor.data[i].lokasi.longitude], {icon:buletmerah})
							.bindTooltip("<table width=100% style='font-size:11px'><tr>"+
														"<td>Date </td><td>: "+lapor.data[i].date+"</td>"+
														"</tr><tr>"+
														"<td>Kategori </td><td>: "+lapor.data[i].category+"</td>"+
														"</tr><tr>"+
														"<td>Pengirim </td><td>: "+lapor.data[i].dari+"</td>"+
														"</tr><tr>"+
														"<td>Lokasi </td><td>: "+lapor.data[i].lokasi.latitude+", "+lapor.data[i].lokasi.longitude+"</td>"+
														"</tr><tr>"+
														"<td>Laporan </td><td>: "+lapor.data[i].laporan+"</td>"+
														"</tr></table>"                        
														,{opacity:0.8, sticky:true});                        
							lapor7.addLayer(mark);
				}
			}
		});
		$.ajax({
			type: 'GET',        
			url: URLINTELBOT+'/filter/lastmonth',        
			success:function(lapor){
				console.log(lapor);
				for(var i=0; i<lapor.data.length; i++){
					var mark = L.marker([lapor.data[i].lokasi.latitude, lapor.data[i].lokasi.longitude], {icon:buletmerah})
							.bindTooltip("<table width=100% style='font-size:11px'><tr>"+
														"<td>Date </td><td>: "+lapor.data[i].date+"</td>"+
														"</tr><tr>"+
														"<td>Kategori </td><td>: "+lapor.data[i].category+"</td>"+
														"</tr><tr>"+
														"<td>Pengirim </td><td>: "+lapor.data[i].dari+"</td>"+
														"</tr><tr>"+
														"<td>Lokasi </td><td>: "+lapor.data[i].lokasi.latitude+", "+lapor.data[i].lokasi.longitude+"</td>"+
														"</tr><tr>"+
														"<td>Laporan </td><td>: "+lapor.data[i].laporan+"</td>"+
														"</tr></table>"                        
														,{opacity:0.8, sticky:true});
							lapor30.addLayer(mark);
				}
			}
		});
		$.ajax({
			type: 'GET',        
			url: URLINTELBOT+'/filter/lastyear',        
			success:function(lapor){
				console.log(lapor);
				for(var i=0; i<lapor.data.length; i++){
					var mark = L.marker([lapor.data[i].lokasi.latitude, lapor.data[i].lokasi.longitude], {icon:buletmerah})
							.bindTooltip("<table width=100% style='font-size:11px'><tr>"+
														"<td>Date </td><td>: "+lapor.data[i].date+"</td>"+
														"</tr><tr>"+
														"<td>Kategori </td><td>: "+lapor.data[i].category+"</td>"+
														"</tr><tr>"+
														"<td>Pengirim </td><td>: "+lapor.data[i].dari+"</td>"+
														"</tr><tr>"+
														"<td>Lokasi </td><td>: "+lapor.data[i].lokasi.latitude+", "+lapor.data[i].lokasi.longitude+"</td>"+
														"</tr><tr>"+
														"<td>Laporan </td><td>: "+lapor.data[i].laporan+"</td>"+
														"</tr></table>"                        
														,{opacity:0.8, sticky:true});
							lapor365.addLayer(mark);
				}
			}
		});

		var resilient = {
			"Laporan Keamanan":{
				"3 days" : lapor3,
				"1 week" : lapor7,
				"1 month" : lapor30,
				"1 year" : lapor365
			// },
			// "Personel":{
			//   "<font color='#FFC100'> AS <i class='fa fa-star'></i></font> ": as,
			//   "<font color='#FBFF00'> AD <i class='fa fa-star-half-o'></i></font>" : ad,
			//   "<font color='#61FF00'> ME <i class='fa fa-star-o'></i></font>" : me,
			//   "<font color='red'> Out <i class='fa fa-frown-o'></i></font>" : out,
			}
		};

		layerControl4 = L.control.groupedLayers(null,resilient, {position:'topright'}).addTo(map);
}

INITICON();
// INITCUACAGEMPA();
// INITBATAS();
INITMAP();
INITPLUGIN();
layerControl1 = L.control.layers(baseMaps).addTo(map);
// INITANGIN();
// INITLAPORANPERSONEL();
/////////////////////


// INIT IKAN INIT IKAN INIT IKAN INIT IKAN INIT IKAN 
// INIT IKAN INIT IKAN INIT IKAN INIT IKAN INIT IKAN 
// var tuna= L.layerGroup([]), pari= L.layerGroup([]), hiu= L.layerGroup([]), cakalang= L.layerGroup([]), tongkol= L.layerGroup([]), makarel= L.layerGroup([]), paus= L.layerGroup([]), cumi= L.layerGroup([]), udang= L.layerGroup([]), lobster= L.layerGroup([]), kepiting= L.layerGroup([]); 

// $.ajax({
//   type: 'GET',        
//   url: URLIKAN,        
//   success:function(ikan){
//   	// console.log(ikan);
//   	for(var i=0; i<ikan.length; i++){
//   		if(ikan[i].ikan === "tuna"){
//   			var mark = L.marker([ikan[i].koor.lat, ikan[i].koor.lon], {icon:ikanmerah})
//   			.bindPopup("<table width=100% style='font-size:11px'><tr>"+
//                       "<td>Ikan </td><td>: "+ikan[i].ikan+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Keterangan </td><td>: "+ikan[i].desc+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Prediksi muncul </td><td>: "+ikan[i].tgl+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Jam muncul </td><td>: "+ikan[i].jam+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Lokasi </td><td>: "+ikan[i].koor.lat+", "+ikan[i].koor.lon+"</td>"+
//                       "</tr></table>"
//                       );
//   			tuna.addLayer(mark);
//   		}
//   		if(ikan[i].ikan === "pari"){
//   			var mark = L.marker([ikan[i].koor.lat, ikan[i].koor.lon], {icon:ikanpari})
//   			.bindPopup("<table width=100% style='font-size:11px'><tr>"+
//                       "<td>Ikan </td><td>: "+ikan[i].ikan+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Keterangan </td><td>: "+ikan[i].desc+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Prediksi muncul </td><td>: "+ikan[i].tgl+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Jam muncul </td><td>: "+ikan[i].jam+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Lokasi </td><td>: "+ikan[i].koor.lat+", "+ikan[i].koor.lon+"</td>"+
//                       "</tr></table>"
//                       );
//   			pari.addLayer(mark);
//   		}
//   		if(ikan[i].ikan === "hiu"){
//   			var mark = L.marker([ikan[i].koor.lat, ikan[i].koor.lon], {icon:ikanhiu})
//   			.bindPopup("<table width=100% style='font-size:11px'><tr>"+
//                       "<td>Ikan </td><td>: "+ikan[i].ikan+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Keterangan </td><td>: "+ikan[i].desc+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Prediksi muncul </td><td>: "+ikan[i].tgl+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Jam muncul </td><td>: "+ikan[i].jam+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Lokasi </td><td>: "+ikan[i].koor.lat+", "+ikan[i].koor.lon+"</td>"+
//                       "</tr></table>"
//                       );
//   			hiu.addLayer(mark);
//   		}
//   		if(ikan[i].ikan === "paus"){
//   			var mark = L.marker([ikan[i].koor.lat, ikan[i].koor.lon], {icon:ikanpaus})
//   			.bindPopup("<table width=100% style='font-size:11px'><tr>"+
//                       "<td>Ikan </td><td>: "+ikan[i].ikan+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Keterangan </td><td>: "+ikan[i].desc+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Prediksi muncul </td><td>: "+ikan[i].tgl+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Jam muncul </td><td>: "+ikan[i].jam+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Lokasi </td><td>: "+ikan[i].koor.lat+", "+ikan[i].koor.lon+"</td>"+
//                       "</tr></table>"
//                       );
//   			paus.addLayer(mark);
//   		}
//   		if(ikan[i].ikan === "cakalang"){
//   			var mark = L.marker([ikan[i].koor.lat, ikan[i].koor.lon], {icon:ikanbiru})
//   			.bindPopup("<table width=100% style='font-size:11px'><tr>"+
//                       "<td>Ikan </td><td>: "+ikan[i].ikan+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Keterangan </td><td>: "+ikan[i].desc+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Prediksi muncul </td><td>: "+ikan[i].tgl+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Jam muncul </td><td>: "+ikan[i].jam+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Lokasi </td><td>: "+ikan[i].koor.lat+", "+ikan[i].koor.lon+"</td>"+
//                       "</tr></table>"
//                       );
//   			cakalang.addLayer(mark);
//   		}
//   		if(ikan[i].ikan === "tongkol"){
//   			var mark = L.marker([ikan[i].koor.lat, ikan[i].koor.lon], {icon:ikanoren})
//   			.bindPopup("<table width=100% style='font-size:11px'><tr>"+
//                       "<td>Ikan </td><td>: "+ikan[i].ikan+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Keterangan </td><td>: "+ikan[i].desc+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Prediksi muncul </td><td>: "+ikan[i].tgl+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Jam muncul </td><td>: "+ikan[i].jam+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Lokasi </td><td>: "+ikan[i].koor.lat+", "+ikan[i].koor.lon+"</td>"+
//                       "</tr></table>"
//                       );
//   			tongkol.addLayer(mark);
//   		}
//   		if(ikan[i].ikan === "makarel"){
//   			var mark = L.marker([ikan[i].koor.lat, ikan[i].koor.lon], {icon:ikanpink})
//   			.bindPopup("<table width=100% style='font-size:11px'><tr>"+
//                       "<td>Ikan </td><td>: "+ikan[i].ikan+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Keterangan </td><td>: "+ikan[i].desc+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Prediksi muncul </td><td>: "+ikan[i].tgl+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Jam muncul </td><td>: "+ikan[i].jam+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Lokasi </td><td>: "+ikan[i].koor.lat+", "+ikan[i].koor.lon+"</td>"+
//                       "</tr></table>"
//                       );
//   			makarel.addLayer(mark);
//   		}
//   		if(ikan[i].ikan === "cumi"){
//   			var mark = L.marker([ikan[i].koor.lat, ikan[i].koor.lon], {icon:cumiicon})
//   			.bindPopup("<table width=100% style='font-size:11px'><tr>"+
//                       "<td>Ikan </td><td>: "+ikan[i].ikan+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Keterangan </td><td>: "+ikan[i].desc+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Prediksi muncul </td><td>: "+ikan[i].tgl+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Jam muncul </td><td>: "+ikan[i].jam+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Lokasi </td><td>: "+ikan[i].koor.lat+", "+ikan[i].koor.lon+"</td>"+
//                       "</tr></table>"
//                       );
//   			cumi.addLayer(mark);
//   		}
//   		if(ikan[i].ikan === "udang"){
//   			var mark = L.marker([ikan[i].koor.lat, ikan[i].koor.lon], {icon:udangicon})
//   			.bindPopup("<table width=100% style='font-size:11px'><tr>"+
//                       "<td>Ikan </td><td>: "+ikan[i].ikan+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Keterangan </td><td>: "+ikan[i].desc+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Prediksi muncul </td><td>: "+ikan[i].tgl+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Jam muncul </td><td>: "+ikan[i].jam+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Lokasi </td><td>: "+ikan[i].koor.lat+", "+ikan[i].koor.lon+"</td>"+
//                       "</tr></table>"
//                       );
//   			udang.addLayer(mark);
//   		}
//   		if(ikan[i].ikan === "kepiting"){
//   			var mark = L.marker([ikan[i].koor.lat, ikan[i].koor.lon], {icon:kepitingicon})
//   			.bindPopup("<table width=100% style='font-size:11px'><tr>"+
//                       "<td>Ikan </td><td>: "+ikan[i].ikan+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Keterangan </td><td>: "+ikan[i].desc+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Prediksi muncul </td><td>: "+ikan[i].tgl+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Jam muncul </td><td>: "+ikan[i].jam+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Lokasi </td><td>: "+ikan[i].koor.lat+", "+ikan[i].koor.lon+"</td>"+
//                       "</tr></table>"
//                       );
//   			kepiting.addLayer(mark);
//   		}
//   		if(ikan[i].ikan === "lobster"){
//   			var mark = L.marker([ikan[i].koor.lat, ikan[i].koor.lon], {icon:lobstericon})
//   			.bindPopup("<table width=100% style='font-size:11px'><tr>"+
//                       "<td>Ikan </td><td>: "+ikan[i].ikan+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Keterangan </td><td>: "+ikan[i].desc+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Prediksi muncul </td><td>: "+ikan[i].tgl+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Jam muncul </td><td>: "+ikan[i].jam+"</td>"+
//                       "</tr><tr>"+
//                       "<td>Lokasi </td><td>: "+ikan[i].koor.lat+", "+ikan[i].koor.lon+"</td>"+
//                       "</tr></table>"
//                       );
//   			lobster.addLayer(mark);
//   		}
//   	}

//   }, error:function(e){
//   	console.log(e);
//   }
// });

// var ikan = {
// 	"Prediksi Ikan <br>3 hari kedepan ":{
// 		"<font color='red'>Tuna</font>" : tuna,
//         "<font color='#009999'>Pari " : pari,
//         "<font color='#006600'>Hiu " : hiu,
//         "<font color='#0066ff'>Cakalang " : cakalang,
//         "<font color='#ff6600'>Tongkol " : tongkol,
//         "<font color='#cc0099'>Makarel " : makarel,
//         "<font color='#0099ff'>Paus " : paus
// 	},
// 	"Lainnya":{
// 		"Cumi": cumi,
//         "<font color='#ff6600'>Udang" : udang,
//         "<font color='#6600ff'>Lobster " : lobster,
//         "<font color='#339966'>Kepiting " : kepiting
// 	}
// };


//INIT DRAW AND EDIT CONTROL
//INIT DRAW AND EDIT CONTROL
//INIT DRAW AND EDIT CONTROL    
var drawnGeojson = L.featureGroup().addTo(map);
var drawnPolygon = L.featureGroup().addTo(map);
var drawnPolyline = L.featureGroup().addTo(map);
var drawnRectangle = L.featureGroup().addTo(map);
var drawnCircle = L.featureGroup().addTo(map);
var drawnMarker = L.featureGroup().addTo(map);
var drawnMarkerBulat = L.featureGroup().addTo(map);
var drawnItems = L.featureGroup().addTo(map);

var KOSANS = new Array();
INITGAMBARDB();

function modalgalery(i){ 
	// console.log(KOSANS);
	var urldasar = "../aset/img/"+KOSANS[i].properties.foto+"/";
	console.log(urldasar);
	var pictureIndex = 0;
	var pictures = [];
	function getFiles() {
		$.ajax({
			type: 'GET',        
			url: urldasar,        
			success:function(data){
		// $.ajax(urldasar).success(function(data) {
			pictures = [];
			$(data).find("a[href]").each(function() {
				var href = $(this).attr('href');
				if (href.indexOf('.JPG') > 0 || href.indexOf('.jpg') > 0 || href.indexOf('.png') > 0 || href.indexOf('.jpeg') > 0) {
					pictures.push(href);
				}
			});
			// console.log(pictures.length + " pictures loaded!");
			changePicture(0);
		// });
		}});
	}
	function changePicture(indexOffset) {
		pictureIndex += indexOffset;
		if (pictureIndex >= pictures.length) {
			pictureIndex = 0;
		} else if (pictureIndex < 0) {
			pictureIndex = pictures.length - 1;
		}
		$('#modalgaleryviewer').attr('src', urldasar + pictures[pictureIndex]);
		$('#modalgaleryinfo').text((pictureIndex + 1) + "/" + pictures.length);
	}
	getFiles();
	// setInterval(function(){ changePicture(1); }, 2000);
	$('#goright').on('click', function(){changePicture(1); return false;});
	$('#goleft').on('click', function(){changePicture(-1); return false;});
	$(document).keydown(function(e){
		var left = -1, right = 1;
			if (e.keyCode == 37) {
				 changePicture(left); return false;
			} else if (e.keyCode == 39) {
				changePicture(right); return false;
			}
	});
}

function gambarkamar(i,ii){ 
	// console.log(i,ii);
	var urldasar = "../aset/img/"+KOSANS[i].properties.foto+"/"+(ii+1)+"/";
	// console.log(urldasar);
	var pictureIndex = 0;
	var pictures = [];
	function getFiles() {
		$.ajax({
			type: 'GET',        
			url: urldasar,        
			success:function(data){
		// $.ajax(urldasar).success(function(data) {
			pictures = [];
			$(data).find("a[href]").each(function() {
				var href = $(this).attr('href');
				if (href.indexOf('.JPG') > 0 || href.indexOf('.jpg') > 0 || href.indexOf('.png') > 0 || href.indexOf('.jpeg') > 0) {
					pictures.push(href);
				}
			});
			// console.log(pictures.length + " pictures loaded!");
			changePicture(0);
		// });
		}});
	}
	function changePicture(indexOffset) {
		pictureIndex += indexOffset;
		if (pictureIndex >= pictures.length) {
			pictureIndex = 0;
		} else if (pictureIndex < 0) {
			pictureIndex = pictures.length - 1;
		}
		$('#modalkamarviewer').attr('src', urldasar + pictures[pictureIndex]);
		$('#modalkamarinfo').text((pictureIndex + 1) + "/" + pictures.length);
	}
	getFiles();
	// setInterval(function(){ changePicture(1); }, 2000);
	$('#giright').on('click', function(){changePicture(1); return false;});
	$('#gileft').on('click', function(){changePicture(-1); return false;});
	$(document).keydown(function(e){
		var left = -1, right = 1;
			if (e.keyCode == 37) {
				 changePicture(left); return false;
			} else if (e.keyCode == 39) {
				changePicture(right); return false;
			}
	});
}

function INITGAMBARDB(){
	// $.get("../json/edumedia.json", function(data, status){
				var data = dataKosan;
				console.log(data.features);
				for(var i=0; i<data.features.length; i++){
						KOSANS.push(data.features[i]);
						var fasum,foto,kontak,lokasi,desclok,kamarmandi;
						var desc="";
						for (var ii=0; ii<data.features[i].properties.kamar.length; ii++){
								desc = desc+"<tr><td><i style='font-size:11px' class='fa fa-bed'>&nbsp;<a onclick=\'modalkamar("+i+","+ii+")\' data-toggle='modal' href='#modalcoba'>"+data.features[i].properties.kamar[ii].nama+"&nbsp;&nbsp;</td><td>&nbsp;&nbsp;"+data.features[i].properties.kamar[ii].luas+"&nbsp;&nbsp;</td><td>&nbsp;&nbsp;"+data.features[i].properties.kamar[ii].hargath+"&nbsp;&nbsp;</td><td>&nbsp;&nbsp;"+data.features[i].properties.kamar[ii].terisi+"&nbsp;&nbsp;</a></i></td></tr>"
						}
						fasum = data.features[i].properties.fasum;
						foto = data.features[i].properties.foto;
						kontak = data.features[i].properties.kontak;
						lokasi = data.features[i].properties.lokasi;
						desclok = data.features[i].properties.desclok;  
						kamarmandi = data.features[i].properties.kamarmandi;
						
						var binpop =  "<b> "+data.features[i].properties.judul+"</b></br>"+
													"<i>"+data.features[i].properties.desc+"</i><hr style='margin-top: 0.3em; margin-bottom: 0.3em;'><i>"+desclok+"</i><hr style='margin-top: 0.3em; margin-bottom: 0.3em;'>"+
													"<i>Jumlah Kamar :&nbsp;"+data.features[i].properties.kamar.length+"</i></br>"+
													"<table border=\"1\" class=\"table-striped\" style='font-size:11px'>"+desc+"</table>"+
													"<table style='font-size:11px'>"+
														"<tr><td>&nbsp;</td><td>&nbsp;</td></tr>"+
														"<tr><td>foto kostan</td><td>:&nbsp;<a onclick=\"modalgalery("+i+")\" data-toggle='modal' href='#modalgalery'>Galery</a></td></tr>"+ 
														"<tr><td>fasilitas umum</td><td>:&nbsp;Internet WiFi, kamar mandi luar, "+fasum+"</td></tr>"+
														"<tr><td>jml kmr mandi</td><td>:&nbsp;"+kamarmandi+"</td></tr>"+
														"<tr><td>&nbsp;</td><td>&nbsp;</td></tr>"+
														'<tr><td>link lokasi (direction)</td><td>:&nbsp;<a target="_blank" href="'+lokasi+'">Google Maps</a></td></tr>'+
														"<tr><td>kontak</td><td>:&nbsp;"+kontak+"</td></tr>"+
													"</table>";
						// BINpop.push(binpop);
						var gelo = L.geoJSON(data.features[i]).bindPopup(binpop,{minWidth : 300}).addTo(map);
						gelo.properties = data.features[i].properties;
						drawnGeojson.addLayer(gelo);
						// desc ="";
						// if(data.features[i].geometry.type == 'circle'){layer.jenis="circle"; drawnCircle.addLayer(layer)}; 
				}
				// opsipenyakit(data.features, BINpop);
				drawnGeojson.on("add",function(){STgeo = true;syncSidebar();});
				drawnGeojson.on("remove",function(){STgeo = false;syncSidebar();});
			
				// BINpop = [];
				// KOSANS.push(data.features);
				// console.log(drawnGeojson);
				// console.log(KOSANS);
				syncSidebar();
		// }); //ajax
} //INITGAMBARDB


		
var ldraw = new L.Control.Draw({
		edit: {
				featureGroup: drawnItems,
				// featureGroup: [drawnPolygon, drawnPolyline, drawnRectangle, drawnCircle, drawnMarker, drawnMarkerBulat],
				poly: {
						allowIntersection: false  
				}
		},
		draw: {
				polygon: {
						allowIntersection: false,
						shapeOptions:{showMeasurements: true},
						showArea: true
				},
				polyline: {
						shapeOptions:{
							showMeasurements: true
						}
				},
				rectangle: {
						showRadius: true,
						shapeOptions:{showMeasurements: true}
				},
				circle: {
						shapeOptions:{showMeasurements: true}
				}
		}	
});
ldraw.addTo(map);

map.on(L.Draw.Event.CREATED, function (event) {
	var layer = event.layer;
	myBindPopUp(layer);
	drawnItems.addLayer(layer);
	if(event.layerType == 'polygon'){layer.jenis ="polygon"; drawnPolygon.addLayer(layer)}; 
	if(event.layerType == 'rectangle'){layer.jenis ="rectangle"; drawnRectangle.addLayer(layer)}; 
	if(event.layerType == 'polyline'){layer.jenis = "polyline"; drawnPolyline.addLayer(layer)}; 
	if(event.layerType == 'circle'){layer.jenis="circle"; drawnCircle.addLayer(layer)}; 
	if(event.layerType == 'marker'){layer.jenis="marker"; drawnMarker.addLayer(layer)}; 
	if(event.layerType == 'markerbulat'){layer.jenis="markerbulat"; drawnMarkerBulat.addLayer(layer)}; 
	syncSidebar();
});

map.on('draw:drawvertex', function (event) {
	// var layer = event;
	console.log(event.layer);
	// L.Draw.Tooltip().updateContent(e.latlng.lat);	 //e.latlng.lat+", "+e.latlng.lng;
	// console.log("SRAWSTART");

	//kalo lingkaran
	// if (event.layer && event.layer.getRadius()) {
		// $('.leaflet-draw-tooltip-subtext').html('Buffer (m): '+Math.floor(event.layer.getRadius()));
	// }		
});

// window prompt, asking bindpopup!    
function myBindPopUp(objek) {
		var pop1 = prompt("Masukan JUDUL dari gambar / marker", "");
		var pop2 = prompt("Masukan DESKRIPSI dari gambar / marker", "");
		if ((pop1 != null)&&(pop2!= null)) {
				objek.bindPopup(
											"<table style='font-size:14px'>"+
												"<tr><td><b>"+pop1+"</b></td></tr>"+
											"</table></br>"+
												"<i>"+pop2+"</i></br>"
											);
				objek.judul = pop1;
				objek.desc = pop2;
		}
}
//window prompt, asking bindpopup!
function flyto(nelat,nelng,swlat,swlng,id) {
	console.log("flyto");
	map.flyToBounds(L.latLngBounds(L.latLng(nelat,nelng),L.latLng(swlat,swlng)));
	  drawnGeojson.eachLayer(function (layer) {
	  	if(layer._leaflet_id == id){
	  		layer.openPopup();	
	  	}
	  });
}
function panto(lat,lng,id) {
	// console.log("panto");
	// console.log("id =", id);
	map.flyTo(L.latLng(lat,lng),18);
	  drawnGeojson.eachLayer(function (layer) {
	  	// console.log(layer._leaflet_id);
	  	if(layer._leaflet_id == id){
	  		layer.openPopup();	
	  	}
	  });
	  drawnMarker.eachLayer(function (layer) {
	  	// console.log(layer._leaflet_id);
	  	if(layer._leaflet_id == id){
	  		layer.openPopup();	
	  	}
	  });
	  drawnMarkerBulat.eachLayer(function (layer) {
	  	// console.log(layer._leaflet_id);
	  	if(layer._leaflet_id == id){
	  		layer.openPopup();	
	  	}
	  });
}

function syncSidebar() {
	/* Empty sidebar features */
	$("#feature-list tbody").empty();
	// $("#feature-lost tbody").empty();

	/* GEOJSON */
	drawnGeojson.eachLayer(function (layer) {
		// console.log(layer.properties);
		if (map.getBounds().contains(layer._layers[(layer._leaflet_id-1)].getLatLng())) {
			$("#feature-list tbody").append('<tr onclick="panto('+layer._layers[(layer._leaflet_id-1)]._latlng.lat+','+layer._layers[(layer._leaflet_id-1)]._latlng.lng+','+layer._leaflet_id+')" class="feature-row" id="' + L.stamp(layer) + '"><td style="text-align: center; vertical-align: middle;"><img src="../aset/img/marker-icon.png" width="13" height="20""></td><td style="vertical-align: middle;" class="feature-name">' + layer.properties.judul + '</td><td class="feature-name">' + layer.properties.desc + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
		}
	});
	
	
	/* POLYLINE */ 
	drawnPolyline.eachLayer(function (layer) {
		// if (map.hasLayer(drawnPolyline)) {
			// console.log(layer._bounds);
			if (map.getBounds().contains(layer.getBounds())) {
				$("#feature-list tbody").append('<tr onclick="flyto('+layer._bounds._northEast.lat+','+layer._bounds._northEast.lng+','+layer._bounds._southWest.lat+','+layer._bounds._southWest.lng+','+layer._leaflet_id+')" class="feature-row" id="' + L.stamp(layer) + '"><td style="text-align: center; vertical-align: middle;"><img src="../aset/img/polyline.png" width="20" height="20""></td><td style="vertical-align: middle;" class="feature-name">' + "<font color="+layer.options.color+">"+layer.judul+"</font>"+'</td><td class="feature-name">' + "<font color="+layer.options.color+">"+layer.desc+"</font>"+'</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
			}
		// }
	});
	/* POLYGON */
	drawnPolygon.eachLayer(function (layer) {
		// if (map.hasLayer(drawnPolygon)) {
			// console.log(layer);
			if (map.getBounds().contains(layer.getBounds())) {
				$("#feature-list tbody").append('<tr onclick="flyto('+layer._bounds._northEast.lat+','+layer._bounds._northEast.lng+','+layer._bounds._southWest.lat+','+layer._bounds._southWest.lng+','+layer._leaflet_id+')" class="feature-row" id="' + L.stamp(layer) + '"><td style="text-align: center; vertical-align: middle;"><img src="../aset/img/polygon.png" width="20" height="20""></td><td style="vertical-align: middle;" class="feature-name">' + "<font color="+layer.options.color+">"+layer.judul+"</font>" + '</td><td class="feature-name">' + "<font color="+layer.options.color+">"+layer.desc+"</font>"+'</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
			}
		// }
	});
	/* RECTANGLE */
	drawnRectangle.eachLayer(function (layer) {
		// if (map.hasLayer(drawnRectangle)) {
			// console.log(layer);
			if (map.getBounds().contains(layer.getBounds())) {
				$("#feature-list tbody").append('<tr onclick="flyto('+layer._bounds._northEast.lat+','+layer._bounds._northEast.lng+','+layer._bounds._southWest.lat+','+layer._bounds._southWest.lng+','+layer._leaflet_id+')" class="feature-row" id="' + L.stamp(layer) + '"><td style="text-align: center; vertical-align: middle;"><img src="../aset/img/kotak.png" width="20" height="20""></td><td style="vertical-align: middle;" class="feature-name">' + "<font color="+layer.options.color+">"+layer.judul+"</font>" + '</td><td class="feature-name">' + "<font color="+layer.options.color+">"+layer.desc+"</font>"+'</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
			}
		// }
	});
	/* CIRCLE */
	drawnCircle.eachLayer(function (layer) {
		// if (map.hasLayer(drawnCircle)) {
			// console.log(layer);
			if (map.getBounds().contains(layer.getBounds())) {
				$("#feature-list tbody").append('<tr onclick="panto('+layer._latlng.lat+','+layer._latlng.lng+','+layer._leaflet_id+')" class="feature-row" id="' + L.stamp(layer) + '"><td style="text-align: center; vertical-align: middle;"><img src="../aset/img/lingkaran.png" width="20" height="20""></td><td style="vertical-align: middle;" class="feature-name">' + "<font color="+layer.options.color+">"+layer.judul+"</font>" + '</td><td class="feature-name">' + "<font color="+layer.options.color+">"+layer.desc+"</font>"+'</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
			}
		// }
	});
	/* MARKER */
	drawnMarker.eachLayer(function (layer) {
		// if (map.hasLayer(drawnMarker)) {
			// console.log(layer);
			if (map.getBounds().contains(layer.getLatLng())) {
				$("#feature-list tbody").append('<tr onclick="panto('+layer._latlng.lat+','+layer._latlng.lng+','+layer._leaflet_id+')" class="feature-row" id="' + L.stamp(layer) + '"><td style="text-align: center; vertical-align: middle;"><img src='+layer.options.icon.options.iconUrl+' width="13" height="20""></td><td style="vertical-align: middle;" class="feature-name">' + layer.judul + '</td><td class="feature-name">' + layer.desc + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
			}
		// }
	});
	/* MARKERBULAT */
	drawnMarkerBulat.eachLayer(function (layer) {
		// if (map.hasLayer(drawnMarkerBulat)) {
			// console.log(layer);
			if (map.getBounds().contains(layer.getLatLng())) {
				$("#feature-list tbody").append('<tr onclick="panto('+layer._latlng.lat+','+layer._latlng.lng+','+layer._leaflet_id+')" class="feature-row" id="' + L.stamp(layer) + '"><td style="text-align: center; vertical-align: middle;"><img src='+layer.options.icon.options.iconUrl+' width="20" height="20""></td><td style="vertical-align: middle;" class="feature-name">' + layer.judul + '</td><td class="feature-name">' + layer.desc + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
			}
		// }
	});
}

// SAVE FILE GEOJSON LOKAL SAVE FILE GEOJSON LOKAL
// SAVE FILE GEOJSON LOKAL SAVE FILE GEOJSON LOKAL
function download(strData, strFileName, strMimeType) {
		var D = document,
				A = arguments,
				a = D.createElement("a"),
				d = A[0],
				n = A[1],
				t = A[2] || "text/plain";

		//build download link:
		a.href = "data:" + strMimeType + "charset=utf-8," + escape(strData);
		if (window.MSBlobBuilder) { // IE10
				var bb = new MSBlobBuilder();
				bb.append(strData);
				return navigator.msSaveBlob(bb, strFileName);
		} /* end if(window.MSBlobBuilder) */
		if ('download' in a) { //FF20, CH19
				a.setAttribute("download", n);
				a.innerHTML = "downloading...";
				D.body.appendChild(a);
				setTimeout(function() {
						var e = D.createEvent("MouseEvents");
						e.initMouseEvent("click", true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
						a.dispatchEvent(e);
						D.body.removeChild(a);
				}, 66);
				return true;
		}; /* end if('download' in a) */
		//do iframe dataURL download: (older W3)
		var f = D.createElement("iframe");
		D.body.appendChild(f);
		f.src = "data:" + (A[2] ? A[2] : "application/octet-stream") + (window.btoa ? ";base64" : "") + "," + (window.btoa ? window.btoa : escape)(strData);
		setTimeout(function() {
				D.body.removeChild(f);
		}, 333);
		return true;
}


map.on("moveend", function (e) {
	syncSidebar();
});







map.on('draw:editstart', function(e) {
	EDITSTAT = true;       
});
map.on('draw:editstop', function() {
	EDITSTAT = false;
	syncSidebar();
});
map.on('draw:drawstart', function(e) {
	var type = e.layerType;
	if (type === 'polyline' || type === 'polygon')
			 DRAWSTAT = true;
});
map.on('draw:drawstop', function() {
	DRAWSTAT = false;
});
map.on('draw:edited', function(e) {
	console.log("edited");
	var layers = e.layers;
	layers.eachLayer(function (layer) {
		 //do whatever you want; most likely save back to db
			console.log(layer);
	});
	syncSidebar();
});
map.on('draw:deleted', function(e) {
	console.log("deleted");
	var layers = e.layers;
	layers.eachLayer(function (layer) {
		 //do whatever you want; most likely save back to db
			console.log(layer);
			drawnItems.removeLayer(layer);
			if(layer.jenis == 'polygon'){drawnPolygon.removeLayer(layer)}; 
			if(layer.jenis == 'rectangle'){drawnRectangle.removeLayer(layer)}; 
			if(layer.jenis == 'polyline'){drawnPolyline.removeLayer(layer)}; 
			if(layer.jenis == 'circle'){drawnCircle.removeLayer(layer)}; 
			if(layer.jenis == 'marker'){drawnMarker.removeLayer(layer)}; 
			if(layer.jenis == 'markerbulat'){drawnMarkerBulat.removeLayer(layer)};   
	});
	syncSidebar();
});


// RIGHTBAR
$("#formselectloc").click(function(e) {
	LOCATIONSTAT = !LOCATIONSTAT;
	return false;
});

map.on('click', function(e) {
	if(LOCATIONSTAT){
		// alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng);
		var lat = document.getElementById("formlat");
		var lon = document.getElementById("formlon"); 
		lat.value = e.latlng.lat;
		lon.value = e.latlng.lng;
		LOCATIONSTAT = false;
	}
});

$("#formkirim").click(function() {
	BUFFERFORM.judul = document.getElementById("formjudul").value;
	BUFFERFORM.kategori = document.getElementById("formkategori").value;
	BUFFERFORM.tingkat = document.getElementById("formtingkat").value;
	BUFFERFORM.tanggal = document.getElementById("formtanggal").value;
	BUFFERFORM.lat = document.getElementById("formlat").value;
	BUFFERFORM.lon = document.getElementById("formlon").value;
	BUFFERFORM.lokasi = document.getElementById("formlokasi").value;
	BUFFERFORM.isi = document.getElementById("formisi").value;
	BUFFERFORM.foto1 = document.getElementById("formfotokjadian1").value.slice(12);
	BUFFERFORM.foto2 = document.getElementById("formfotokjadian2").value.slice(12);
	BUFFERFORM.orang = BUFFERORG;
	
	// kirim k API & upload foto 
	console.log(BUFFERFORM);
	$.post(URLAPI+"laporan", BUFFERFORM, function(result){
				// console.log(result);
				alert(result.message);
	});
	
	bebersihform();
	return false;
});
$("#formbersih").click(function() {
	bebersihform();
	return false;
});
$("#formorgkirim").click(function() {
	BUFFERORGorg.nama = document.getElementById("formorgnama").value; 
	BUFFERORGorg.umur = document.getElementById("formorgumur").value;
	BUFFERORGorg.sebagai = document.getElementById("formorgsebagai").value;
	BUFFERORGorg.suku = document.getElementById("formorgsuku").value;
	BUFFERORGorg.agama = document.getElementById("formorgagama").value;
	BUFFERORGorg.alamat = document.getElementById("formorgalamat").value;
	BUFFERORGorg.fotoorg1 = document.getElementById("formorgfoto1").value.slice(12);
	BUFFERORGorg.fotoorg2 = document.getElementById("formorgfoto2").value.slice(12);
	BUFFERORGorg.fotoorg3 = document.getElementById("formorgfoto3").value.slice(12);
	
	BUFFERORG.push(BUFFERORGorg);

	// upload foto 
	console.log(BUFFERORG);
	console.log(BUFFERORGorg);

	$("#formtabelorg tbody").append(
		'<tr>'+
			'<td>'+document.getElementById("formorgnama").value+'</td>'+
			'<td>'+document.getElementById("formorgumur").value+'</td>'+
			'<td>'+document.getElementById("formorgsebagai").value+'</td>'+
			'<td>'+document.getElementById("formorgsuku").value+'</td>'+
			'<td>'+document.getElementById("formorgagama").value+'</td>'+
			'<td>'+document.getElementById("formorgalamat").value+'</td>'+
			'<td><a href><i class="fa fa-file"></i></a></td>'+
		'</tr>');
	bebersihorg();

	BUFFERORGorg = {};
	return false;
});
$("#formorgbersih").click(function() {
	bebersihorg();
	return false;
});

function bebersihorg(){
	document.getElementById("formorgnama").value = "";
	document.getElementById("formorgumur").value = "";
	document.getElementById("formorgsebagai").value = "";
	document.getElementById("formorgsuku").value = "";
	document.getElementById("formorgagama").value = "";
	document.getElementById("formorgalamat").value = "";
	document.getElementById("formorgfoto1").value = "";
	document.getElementById("formorgfoto2").value = "";
	document.getElementById("formorgfoto3").value = "";
}
function bebersihform(){
	document.getElementById("formjudul").value = "";
	document.getElementById("formkategori").value = "";
	document.getElementById("formtingkat").value = "";
	document.getElementById("formtanggal").value = "";
	document.getElementById("formlat").value = "";
	document.getElementById("formlon").value = "";
	document.getElementById("formlokasi").value = "";
	document.getElementById("formisi").value = "";
	document.getElementById("formfotokjadian1").value = "";
	document.getElementById("formfotokjadian2").value = "";
	BUFFERORG = [];
	$("#formtabelorg tbody").empty();
}

// INITTABELLAPORAN();
function INITTABELLAPORAN(){
	$.get(URLAPI+"laporan", function(data, status){
				console.log(data);
				// alert("Data: " + data + "\nStatus: " + status);
				for(var i=0; i<data.data.length; i++){
						$("#tabellap tbody").append(
						'<tr>'+
							'<td>'+data.data[i].judul +'</td>'+
							'<td>'+data.data[i].kategori +'</td>'+
							'<td>'+data.data[i].tanggal +'</td>'+
							'<td>'+data.data[i].lokasi +'</td>'+
							'<td>'+data.data[i].isi +'</td>'+
							'<td><a href><i class="fa fa-user"></i></a></td><td><a href><i class="fa fa-photo"></i></a></td>'+
						'</tr>');
				}
		});
}
	

// LEFTBAR
$("#download-btn").click(function() {
	// console.log(drawnItems);
	var namafile = "gambar.json";
	var buff = drawnItems.toGeoJSON();
	console.log(buff);
	var i=0;
	drawnItems.eachLayer(function (layer) {
		console.log(layer);
		buff.features[i].properties.judul = layer.judul;
		buff.features[i].properties.jenis = layer.jenis;
		buff.features[i].properties.desc = layer.desc;
		buff.features[i].properties.color = layer.options.color;
		buff.features[i].properties.radius = layer._mRadius;
		i++;
	});
	var print = JSON.stringify(buff);
	var popup = prompt("Tulis nama filenya. extension jangan diubah", ".json");  
		if (popup != null) {
				namafile = popup;
		}
	download(print, namafile, 'text/plain');
	return false;
});
$("#sidebar-legend-btn").click(function() {
	animateSidebar();
	// animateRightbar();
	return false;
});

$("#sidebar-form-btn").click(function() {
	// animateSidebar();
	animateRightbar();
	return false;
});

$("#tutupR").click(function() {
	animateRightbar();
	return false;
});
$("#tutupS").click(function() {
	animateSidebar();
	return false;
});

$("#login").click(function() {
	window.location.href = "../home/login";
});
$("#logout").click(function() {
	window.location.href = "../home/logout";
});
$("#backend").click(function() {
	window.location.href = "../admin/pemilik_ctrl";
});
$("#tabel").click(function() {
	window.location.href = "../html/tabelkost";
});
$("#about").click(function() {
	window.location.href = "../html/about";
});

function animateSidebar() {
	$("#sidebar").animate({
		width: "toggle"
	}, 350, function() {
		map.invalidateSize();
	});
}

function animateRightbar(){
	$("#rightbar").animate({
		width: "toggle"
	}, 350, function() {
		map.invalidateSize();
	});
}

function IsJsonString(str) {try {JSON.parse(str)}catch (e) {return false}return true}


// animateSidebar();
animateRightbar();


// INIT GRAFIK INIT GRAFIK INIT GRAFIK INIT GRAFIK INIT GRAFIK
// INIT GRAFIK INIT GRAFIK INIT GRAFIK INIT GRAFIK INIT GRAFIK
// INIT GRAFIK INIT GRAFIK INIT GRAFIK INIT GRAFIK INIT GRAFIK
INITGRAFIKKOSAN();
function INITGRAFIKKOSAN() {
	var namaKosanGrafik = [];
	var terisiKosanGrafik = []; 
	var kosongKosanGrafik = [];

	for (var i=0; i<dataKosan.features.length; i++){
		var buffisi = 0; var buffksg = 0;
		for(var z=0; z<dataKosan.features[i].properties.kamar.length; z++){
			if (dataKosan.features[i].properties.kamar[z].terisi === "terisi"){buffisi++;};	
			if (dataKosan.features[i].properties.kamar[z].terisi === "kosong"){buffksg++;};		
		}
		namaKosanGrafik.push(dataKosan.features[i].properties.judul);
		terisiKosanGrafik.push(buffisi);
		kosongKosanGrafik.push(buffksg);
	}

	var barChartData = {
		//labels: ['G.asih', 'G.arum', 'G.bhakti', 'G.kiara', 'G.sari'],
		labels: namaKosanGrafik,
		datasets: [{
			label: 'terisi',
			backgroundColor: '#36a2eb',
			//data: [12, 6, 6, 4, 13]
			data: terisiKosanGrafik
		}, {
			label: 'kosong',
			backgroundColor: '#ff6384',
			//data: [3, 2, 2, 2, 1]
			data: kosongKosanGrafik
		}]

	};

	var ctx = document.getElementById('myChart').getContext('2d');
	window.myBar = new Chart(ctx, {
		type: 'bar',
		data: barChartData,
		options: {
			title: {
				display: true,
				text: 'Kost Edumedia Availability'
			},
			tooltips: {
				mode: 'index',
				intersect: false
			},
			responsive: true,
			scales: {
				xAxes: [{
					stacked: true,
				}],
				yAxes: [{
					stacked: true
				}]
			}
		}
	});
};
// INIT GRAFIK INIT GRAFIK INIT GRAFIK INIT GRAFIK INIT GRAFIK
// INIT GRAFIK INIT GRAFIK INIT GRAFIK INIT GRAFIK INIT GRAFIK
// INIT GRAFIK INIT GRAFIK INIT GRAFIK INIT GRAFIK INIT GRAFIK






// var ctx = document.getElementById("myChart").getContext('2d');
// var myChart = new Chart(ctx, {
//     type: 'bar',
//     data: {
//         labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
//         datasets: [{
//             label: '# of Votes',
//             data: [12, 19, 3, 5, 2, 3],
//             backgroundColor: [
//                 'rgba(255, 99, 132, 0.2)',
//                 'rgba(54, 162, 235, 0.2)',
//                 'rgba(255, 206, 86, 0.2)',
//                 'rgba(75, 192, 192, 0.2)',
//                 'rgba(153, 102, 255, 0.2)',
//                 'rgba(255, 159, 64, 0.2)'
//             ],
//             borderColor: [
//                 'rgba(255,99,132,1)',
//                 'rgba(54, 162, 235, 1)',
//                 'rgba(255, 206, 86, 1)',
//                 'rgba(75, 192, 192, 1)',
//                 'rgba(153, 102, 255, 1)',
//                 'rgba(255, 159, 64, 1)'
//             ],
//             borderWidth: 1
//         }]
//     },
//     options: {
//         scales: {
//             yAxes: [{
//                 ticks: {
//                     beginAtZero:true
//                 }
//             }]
//         }
//     }
// });



// PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR
// PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR
// PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR PR
// .ngesave gambar ke DB

// .nambahin properties gambar2 pas mau ngesave ke file/db:
// ..warna garis
// ..ketebalan garis
// ..popup data
// ..luas wilayah
// ..iconUrl
// ..showMeasurements
// ..
// ..

// .
// .gambar yg marker ama marker bulet warnanya ubah2 sendiri terus
// .dr list tabel di kiri blm bisa filter, pke search dr bootsrap tabel
// .dr list tabel di kiri pas diklik datanya harusnya menuju ke objek
// .
// .layer control di kanan terlalu rame,, banyak yg harusnya disatuin
// .init ikan blm dibikin
// .init gambar jg blm dibikin, masih on floor
// .
// .
// .backend (halaman admin) masih blm disentuh
// .autentikasi / login belum ada
// .
// .
// .
// .
// .
// .
