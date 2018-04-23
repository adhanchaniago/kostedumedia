/*
	File ini diload oleh:
	- views/html/justmaps.php
	- views/html/map_clean.php
*/

$(document).ready(function(){ 
	init();
	// initkota();
	initWeather();
	getPushdata(); 	// first loading of kri & target
	next_move(); 	// assigning socket for receiving regular ship & target update
	
	// initChatEngine();
	initFeatures();
	// showPoi(true); // display poi in the beginning of loading page
	if (myFleetDisplayStat) showMyFleet(true);
	// searchpredict();

	/*  attribution shown in bottom right of the screen. 
		it shows information about lattitude and longitude*/
	var attrib = new L.Control.Attribution;
	map.addControl(attrib); 
	attrib.setPrefix('Koordinat : ');

	/*mouse movement will affect coordinate view on right-bottom corner of map*/
	function onMouseMove(e) {
		attrib.setPrefix('Koordinat : '+viewableCoordinate(e.latlng.lat,'lat') + ", " + viewableCoordinate(e.latlng.lng,'lon')+'. Zoom:'+map.getZoom());
		//attrib.setPrefix('Koordinat : '+e.latlng.lat + ", "+ e.latlng.lng +'. Zoom:'+map.getZoom());
		// console.log('maps ukur jarak: '+stat_ukur_jarak);
		// console.log('maps is measuring: '+isMeasuring);
		
		if(stat_ukur_jarak && isMeasuring){
			//add if by kikifirmansyah
			//if(!!measuring_line){
				// console.log('masuk maps js nih');
				measuring_line.setLatLngs([start_lat,new L.LatLng(e.latlng.lat,e.latlng.lng)]);
			//}
			//if(!!start_lat){
				var centerPos = new L.LatLng((start_lat.lat + e.latlng.lat)/2, 
				(start_lat.lng + e.latlng.lng)/2);
				var distance = start_lat.distanceTo(e.latlng);
			//}	
	
			popup_distance(distance, new L.LatLng(e.latlng.lat,e.latlng.lng),start_lat,new L.LatLng(e.latlng.lat,e.latlng.lng));
			map.addLayer(distancePopup)
			.fire('popupopen', { popup: distancePopup });
		}
	}

	map.doubleClickZoom.disable();

	map.on('mousemove', onMouseMove);
	/*handling right click for drawing*/
	map.on('contextmenu',function(e){
		onClickMeasuring(e.latlng.lat,e.latlng.lng);
	});

	emitBounds();//bounds initialization.
	
	map.on("moveend", function(e){
		//removeAllKRI();
		emitBounds();//reapply bounds every changing viewport
	});

   
            
            


	// map.on('click', function(e){
	//	 putMeasureBend(e.latlng.lat, e.latlng.lng);
	// });
	
	$("ul#demo_menu2").sidebar({
		position:"left"
	});
});

// GLOBAL VARIABLE CUACA
var JSONWIND = [];
var JSONWAVES = [];
// var JSONBATASLINE = [];
// var JSONBATASPOINT = [];


function emitBounds(){
	var bounds = map.getBounds();
		socket.emit("updateBounds", {
			lat1 : bounds._southWest.lat , lat2 : bounds._northEast.lat, 
			lon1 : bounds._southWest.lng  , lon2 : bounds._northEast.lng
		});
}

function init(){

	var minimal   = L.tileLayer(
		configMap.mapUrl, 
		{
			styleId: configMap.mapStyleId,
			// continuousWorld: "true"			
			
		}
	);
	var southWest = new L.LatLng(85, -180);
	var northEast = new L.LatLng(-85, 180);
	var bounds = new L.LatLngBounds(southWest, northEast);

	//fixation for pan inside bounds

	L.Map.include({
		panInsideBounds: function(bounds) {
			bounds = L.latLngBounds(bounds);

			var viewBounds = this.getBounds(),
				viewSw = this.project(viewBounds.getSouthWest()),
				viewNe = this.project(viewBounds.getNorthEast()),
				sw = this.project(bounds.getSouthWest()),
				ne = this.project(bounds.getNorthEast()),
				dx = 0,
				dy = 0;

			if (viewNe.y < ne.y) { // north
				dy = ne.y - viewNe.y + Math.max(0, this.latLngToContainerPoint([85.05112878, 0]).y); // + extra vertical scroll
			}
			if (viewNe.x > ne.x) { // east
				dx = ne.x - viewNe.x;
			}
			if (viewSw.y > sw.y) { // south
				dy = sw.y - viewSw.y + Math.min(0, this.latLngToContainerPoint([-85.05112878, 0]).y - this.getSize().y); // + extra vertical scroll
			}
			if (viewSw.x < sw.x) { // west
				dx = sw.x - viewSw.x;
			}

			return this.panBy(new L.Point(dx, dy, true));
		}
	});



	//repair for pan inside bounds

	$("#map").css('height',$('ul#side-menu').height());
	$(window).resize(function() {
		$("#map").css('height',$('ul#side-menu').height());
	});

	map = new L.map('map', {
		center: [configMap.latCenter, configMap.lonCenter],
		zoom: configMap.zoom,
		// maxBounds : bounds,
		layers: [minimal],
		maxZoom : 18,
		minZoom : 3,
		// worldCopyJump : true
	});

	var baseLayers = {
		"Default": minimal,
	};
	
	// map.addLayer(markersSearch); // commented by SKM17
	initDrawControl();
	initCuaca();
	initBatas();
	initBMKG();
	// initRadar();
	// initRadarJs();
}

//Ngukur jarak untuk RADAR RADAR RADAR RADAR
//GOPALGOPALGOPALOGPALOGPALOGPLAOPGLAOPGLAOPGLA
function toRad(a) { return a * Math.PI / 180; }
function toDeg(a) { return a * 180 / Math.PI; }

function getKoordinatRadar(lat,lon,brng,radiusRadar) {
   radiusRadar = radiusRadar * Math.sqrt(2) / 6371;  // radius X dikali akar 2 karena biar dapet ujung kotak png-nya dgn radius X
   brng = toRad(brng);  

   var lat1 = toRad(lat);
   var lon1 = toRad(lon);

   var lat2 = Math.asin(Math.sin(lat1) * Math.cos(radiusRadar) + Math.cos(lat1) * Math.sin(radiusRadar) * Math.cos(brng));
   var lon2 = lon1 + Math.atan2(Math.sin(brng) * Math.sin(radiusRadar) * Math.cos(lat1), Math.cos(radiusRadar) - Math.sin(lat1) * Math.sin(lat2));

   if (isNaN(lat2) || isNaN(lon2)) return null;
   
   return [lat2.toDeg(), lon2.toDeg()];
}
//Ngukur jarak untuk RADAR RADAR RADAR RADAR
//GOPALGOPALGOPALOGPALOGPALOGPLAOPGLAOPGLAOPGLA

function initRadar(){	
	var i = 1;
	var ii = 0;
	// var rdUrl = '../assets/img/radar/download'+i+'.png';

	// -6.976374, 106.529090 //pelabuhan ratu
	// -6.863452, 107.584045 //kpad
	var rdUrl = 'http://192.168.1.118/radar/radar'+i+'.png';
	var bs = [getKoordinatRadar(-6.863452, 107.584045,315,10), getKoordinatRadar(-6.863452, 107.584045,135,10)];

	var x = L.imageOverlay(rdUrl, bs); 
	x.addTo(map);
	i++;
	// ii++;
	var intervl = 0;
	intervl = setInterval(function() {					
		map.removeLayer(x);
		// rdUrl = '../assets/img/radar/download'+i+'.png';
		// rdUrl = 'http://192.168.1.124/radar/download'+i+'.png';
		rdUrl = 'http://192.168.1.118/radar/radar'+i+'.png?n='+ii;
		x = L.imageOverlay(rdUrl, bs); 		
		x.addTo(map);
		if (i == 8) {
			i = 1;
			ii++;	
		} else i++;
	}, 500); //milisecond	

	// klo udh beres, tinggal: 
	// clearInterval(intervl);
}


var listGempa = [];
var gempastat = false;

function initBMKG(){	
	var bas = "http://192.168.1.124/getcuaca/bin/hasil/";	
	bmkg = bas+"gempaterkini.xml";	
	// bmkg = bas+"gempaauto.xml";
	var tgl,jam,lat,lon,mag,ked,wil,pot,cek2hr;
	var koor = [];
	var gmpaIcon = L.icon({
	    iconUrl: '../assets/img/epic.png',	    
	    iconSize:     [70, 70], 
	    iconAnchor:   [35, 35], 
	});

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
                		if (d - new Date(tgl) <= 0){
                			cek2hr = true;
                		} else cek2hr = false;

                	});
                	$(this).find("Jam").each(function(){
                		jam = $(this).text();                    
                	});
                	$(this).find("point").each(function(){
                		$(this).find("coordinates").each(function(){
                			koor = $(this).text().split(",");
                		});	
                	});
                	$(this).find("Lintang").each(function(){
                		lat = $(this).text();                    
                	});
                	$(this).find("Bujur").each(function(){
                		lon = $(this).text();                    
                	});
                	$(this).find("Magnitude").each(function(){
                		mag = $(this).text();                    
                	});
                	$(this).find("Kedalaman").each(function(){
                		ked = $(this).text();                    
                	});
                	$(this).find("Wilayah1").each(function(){
                		wil = $(this).text();                    
                	}); 
                	$(this).find("Potensi").each(function(){
                		pot = $(this).text();                    
                	}); 

                	// cek ini 2hr lalu ga?
                	if (cek2hr){
                	   	// bikin icon
	                	var gmpa = L.marker([koor[1],koor[0]], {icon: gmpaIcon})
	                		// .addTo(map)	
	                		.bindPopup( "<b><table><tr>"+
	                						"<td>Tanggal </td>"+
	                						"<td>: "+tgl+"</td>"+
	                					"</tr><tr>"+
	                						"<td>Jam </td>"+
	                						"<td>: "+jam+"</td>"+
	                					"</tr><tr>"+
	                						"<td>Lintang </td>"+
	                						"<td>: "+lat+"</td>"+
	                					"</tr><tr>"+
	                						"<td>Bujur </td>"+
	                						"<td>: "+lon+"</td>"+
	                					"</tr><tr>"+
	                						"<td>Magnitude </td>"+
	                						"<td>: "+mag+"</td>"+
	                					"</tr><tr>"+
	                						"<td>Kedalaman </td>"+
	                						"<td>: "+ked+"</td>"+
	                					"</tr><tr>"+
	                						"<td>Wilayah </td>"+
	                						"<td>: "+wil+"</td>"+
	                					"</tr><tr>"+
	                						"<td>Potensi </td>"+
	                						"<td>: "+pot+"</td>"+
	                					"</tr></table></b>"
									  );
	                	listGempa.push(gmpa);	                	
                	}// end of cek (if)

                });
            });
        }
	});	
}





var tik, terline1,terline2,terline3,terline4, pklline1,pklline2,pklline3, tmbline1,tmbline2,tmbline3,tmbline4,tmbline5, zeeline1,zeeline2,zeeline3,zeeline4,zeeline5,zeeline6, konline, stline;
var btsTer, btsPkl, btsTmb, btsZee, btsKon, btsSt = false; // if true then show batas line

function showBatasTer(s){ if (s) {btsTer = true; map.addLayer(terline1);map.addLayer(terline2);map.addLayer(terline3);map.addLayer(terline4);} else {btsTer = false; map.removeLayer(terline1); map.removeLayer(terline2); map.removeLayer(terline3); map.removeLayer(terline4);	}}
function showBatasPkl(s){ if (s) {btsPkl = true; map.addLayer(pklline1);map.addLayer(pklline2);map.addLayer(pklline3);} else {btsPkl = false; map.removeLayer(pklline1); map.removeLayer(pklline2); map.removeLayer(pklline3);  }}
function showBatasTmb(s){ if (s) {btsTmb = true; map.addLayer(tmbline1);map.addLayer(tmbline2);map.addLayer(tmbline3);map.addLayer(tmbline4);map.addLayer(tmbline5);} else {btsTmb = false; map.removeLayer(tmbline1); map.removeLayer(tmbline2); map.removeLayer(tmbline3); map.removeLayer(tmbline4); map.removeLayer(tmbline5);  }}
function showBatasZee(s){ if (s) {btsZee = true; map.addLayer(zeeline1);map.addLayer(zeeline2);map.addLayer(zeeline3);map.addLayer(zeeline4);map.addLayer(zeeline5);map.addLayer(zeeline6);} else {btsZee = false; map.removeLayer(zeeline1); map.removeLayer(zeeline2); map.removeLayer(zeeline3); map.removeLayer(zeeline4); map.removeLayer(zeeline5); map.removeLayer(zeeline6);  }}
function showBatasKon(s){ if (s) {btsKon = true; map.addLayer(konline);} else {btsKon = false; map.removeLayer(konline);	}}
function showBatasSt(s){ if (s) {btsSt = true; map.addLayer(stline);} else {btsSt = false; map.removeLayer(stline);	}}

function initBatas(){	
	var urlbatasL = '../assets/js/batas/batasline.json';
	
	//ngambil data batas line
	$.ajax({
        type: 'GET',        
        url: urlbatasL,        
        success:function(response){

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
			
			terline1 = new L.polyline(teritorialList1, {color: "#7700ff", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('batas teritorial', { noHide: true }); //.addTo(map);
			terline2 = new L.polyline(teritorialList2, {color: "#7700ff", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('batas teritorial', { noHide: true }); //.addTo(map);
			terline3 = new L.polyline(teritorialList3, {color: "#7700ff", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('batas teritorial', { noHide: true }); //.addTo(map);
			terline4 = new L.polyline(teritorialList4, {color: "#7700ff", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('batas teritorial', { noHide: true }); //.addTo(map);

			pklline1 = new L.polyline(pangkalList1, {color: 'red', weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('garis pangkal', { noHide: true }); //.addTo(map);
			pklline2 = new L.polyline(pangkalList2, {color: 'red', weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('garis pangkal', { noHide: true }); //.addTo(map);
			pklline3 = new L.polyline(pangkalList3, {color: 'red', weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('garis pangkal', { noHide: true }); //.addTo(map);

			tmbline1 = new L.polyline(tambahanList1, {color: "#0901ff", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('zona tambahan', { noHide: true }); //.addTo(map);
			tmbline2 = new L.polyline(tambahanList2, {color: "#0901ff", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('zona tambahan', { noHide: true }); //.addTo(map);
			tmbline3 = new L.polyline(tambahanList3, {color: "#0901ff", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('zona tambahan', { noHide: true }); //.addTo(map);
			tmbline4 = new L.polyline(tambahanList4, {color: "#0901ff", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('zona tambahan', { noHide: true }); //.addTo(map);
			tmbline5 = new L.polyline(tambahanList5, {color: "#0901ff", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('zona tambahan', { noHide: true }); //.addTo(map);

			zeeline1 = new L.polyline(zeeList1, {color: "#088A08", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('ZEE', { noHide: true }); //.addTo(map);
			zeeline2 = new L.polyline(zeeList2, {color: "#088A08", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('ZEE', { noHide: true }); //.addTo(map);
			zeeline3 = new L.polyline(zeeList3, {color: "#088A08", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('ZEE', { noHide: true }); //.addTo(map);
			zeeline4 = new L.polyline(zeeList4, {color: "#088A08", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('ZEE', { noHide: true }); //.addTo(map);
			zeeline5 = new L.polyline(zeeList5, {color: "#088A08", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('ZEE', { noHide: true }); //.addTo(map);
			zeeline6 = new L.polyline(zeeList6, {color: "#088A08", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('ZEE', { noHide: true }); //.addTo(map);

			konline = new L.polyline(kontinenList, {color: "#2E9AFE", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('landas kontinent', { noHide: true }); //.addTo(map);
			stline = new L.polyline(stList, {color: "#DBA901", weight: 2, opacity: 1, smoothFactor: 1, dashArray: '5, 8'}).bindLabel('perjanjian 1997', { noHide: true }); //.addTo(map);

        },
        error: function() {
        	console.log("Error json request"); 
        	window.confirm("Data batas gagal diload");

    	}	
	});	
}

// DISLOKASI HISTORY DISLOKASI HISTORY DISLOKASI HISTORY DISLOKASI HISTORY DISLOKASI HISTORY
// DISLOKASI HISTORY DISLOKASI HISTORY DISLOKASI HISTORY DISLOKASI HISTORY DISLOKASI HISTORY

var firstpolyline, secondpolyline = null; // init polyline buat show history
var marker, markeraes = []; // init polyline buat show history
var transarrow = L.icon({		//custom icon
    iconUrl: '../assets/img/upsolidgreen.png',
    iconSize:     [20, 20], // size of the icon    
    iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
});

function showPesudDislocation(name, id, lat, lon) {
	getDataDislokasiHistoriPesud(id, function(data){
		console.log(data);
		//rekursif ngisi point2 dari hasil data socket.io
		var pointList = [];
		var point = null;
		markeraes = [];

		for (i = 0; i < data.length; i++) { 			
			point = new L.LatLng(data[i].aerdis_lat, data[i].aerdis_lon);
			pointList.push(point);

			//marker 
			mark = new L.marker([data[i].aerdis_lat, data[i].aerdis_lon], {icon: transarrow}, {direction : 120})
				.bindLabel('date: '+data[i].aerdis_date+
						  '</br> time: '+data[i].aerdis_time+
						  '</br> direction: '+data[i].aerdis_direction+
						  '</br> speed: '+data[i].aerdis_speed+
						  '</br> location: '+data[i].aerdis_location+
						  '</br> lat: '+viewableCoordinate(data[i].aerdis_lat)+
						  '</br> lon: '+viewableCoordinate(data[i].aerdis_lon)+
						  '</br> operation id: '+data[i].operation_id+
						  '</br> endurance: '+data[i].aerdis_endurance
						  );				
			mark.setIconAngle(data[i].aerdis_direction);
			markeraes.push(mark);
		}
		//nambahin current location	
		point = new L.LatLng(lat, lon);
		pointList.push(point);
		
		secondpolyline = new L.polyline(pointList, {
		color: 'green',
		weight: 3,
		opacity: 1,
		smoothFactor: 1,
		dashArray: '5, 8'
		}); 

		secondpolyline.bindLabel('history pesud: '+name, { noHide: true });
	});
}

var historystatpesud = false;
function showHistoryPesud(stat){	
	if (stat) {
		historystatpesud = true;
		// console.log(historystatpesud);
		console.log("history ON");		
		map.addLayer(secondpolyline);				
		//nampilin marker
		for (i = 0; i < markeraes.length; i++) {
			map.addLayer(markeraes[i]);
		}

	} else {
		historystatpesud = false;
		// console.log(historystatpesud);
		console.log("history OFF");
    	map.removeLayer(secondpolyline);
    	// hilangin marker
		for (i = 0; i < markeraes.length; i++) {			
			map.removeLayer(markeraes[i]);
		}
		// markeraes = []; // clear marker

	}
}

// DISLOKASI HISTORY DISLOKASI HISTORY DISLOKASI HISTORY DISLOKASI HISTORY DISLOKASI HISTORY
function showShipDislocation(name, id, lat, lon) {

	//@ship-dislokasi history //gopalgopel
	// lihat ke line 1244

	getDataDislokasiHistori(id, function(data){
		console.log(data);
		//rekursif ngisi point2 dari hasil data socket.io
		var pointList = [];
		var point = null;
		marker = [];		

		for (i = 0; i < data.length; i++) { 			
			point = new L.LatLng(data[i].shipdis_lat, data[i].shipdis_lon);
			pointList.push(point);

			//marker 
			mark = new L.marker([data[i].shipdis_lat, data[i].shipdis_lon], {icon: transarrow}, {direction : 120})
				.bindLabel('date: '+data[i].shipdis_date+
						  '</br> time: '+data[i].shipdis_time+
						  '</br> direction: '+data[i].shipdis_direction+
						  '</br> speed: '+data[i].shipdis_speed+
						  '</br> location: '+data[i].shipdis_water_location+						 
						  '</br> lat: '+viewableCoordinate(data[i].shipdis_lat)+
						  '</br> lon: '+viewableCoordinate(data[i].shipdis_lon)+
						  '</br> operation id: '+data[i].operation_id
						  );				
			mark.setIconAngle(data[i].shipdis_direction);
			marker.push(mark);
		}
		//nambahin current location	
		point = new L.LatLng(lat, lon);
		pointList.push(point);
		
		firstpolyline = new L.polyline(pointList, {
		color: 'green',
		weight: 3,
		opacity: 1,
		smoothFactor: 1,
		dashArray: '5, 8'
		}); 

		firstpolyline.bindLabel('history kapal: '+name, { noHide: true });		
	});
}

var historystat = false;
function showHistory(stat){	
	if (stat) {
		historystat = true;
		// console.log(historystat);
		console.log("history ON");		
		map.addLayer(firstpolyline);				
		//nampilin marker
		for (i = 0; i < marker.length; i++) {
			map.addLayer(marker[i]);
		}

	} else {
		historystat = false;
		// console.log(historystat);
		console.log("history OFF");
    	map.removeLayer(firstpolyline);
    	// hilangin marker
		for (i = 0; i < marker.length; i++) {			
			map.removeLayer(marker[i]);
		}
		// marker = []; // clear marker

	}
}
// DISLOKASI HISTORY DISLOKASI HISTORY DISLOKASI HISTORY DISLOKASI HISTORY DISLOKASI HISTORY
// DISLOKASI HISTORY DISLOKASI HISTORY DISLOKASI HISTORY DISLOKASI HISTORY DISLOKASI HISTORY



// CUACA CUACA CUACA CUACA CUACA CUACA CUACA

// var urlcuaca, urlwind, urlwaves, urltemp, urlpresr, tekananUrl, suhuUrl, hujanUrl, awanUrl;
var urlcuaca, tekananUrl, suhuUrl, hujanUrl, awanUrl;
var urlSadewa = 'http://sadewa.sains.lapan.go.id';

function initDate() {	
	var dt = new Date();
	var ss = dt.getHours();
	var k;	// j for windyty data,, k for sadewa data

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
	
	var baseurl = "http://192.168.1.124/getcuaca/bin/hasil/";
	urlcuaca = baseurl+"cuaca.json";	

	// sadewa
	tekananUrl = baseurl+'psf'+k+'.png';
	suhuUrl = baseurl+'sst'+k+'.png';
	hujanUrl = baseurl+'frain'+k+'.png';
	awanUrl = baseurl+'cloud'+k+'.png';
	
}

// init SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA
// SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA

var awan, tekanan, suhu, hujan = null;
var awanstat, tekananstat, suhustat, hujanstat = false;

//tambah legend suhu
var suhuLegend = L.control({position: 'bottomright'});
suhuLegend.onAdd = function (map) {
	var div = L.DomUtil.create('div', 'info legend');
	    div.innerHTML +=	    
	    '<img src="../assets/js/wind/legendsuhu.png" alt="legend" width="30" height="300">';
	    // console.log(div.innerHTML);
	return div;
};

//tambah legend tekanan
var tekananLegend = L.control({position: 'bottomright'});
tekananLegend.onAdd = function (map) {
	var div = L.DomUtil.create('div', 'info legend');
	    div.innerHTML +=	    
	    '<img src="../assets/js/wind/legendtekanan.png" alt="legend" width="30" height="300">';
	    // console.log(div.innerHTML);
	return div;
};
// SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA
// SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA SADEWA


// CUACA CUACA CUACA CUACA CUACA CUACA CUACA
// ANGIN ANGIN ANGIN ANGIN ANGIN ANGIN ANGIN
var anginstat = false;
function showAngin(stat){
	// console.log(stat);
	if (stat) {
		anginstat = true;
		console.log("angin ON");		
		// redrawWind();
		drawWind();

	} else {
		anginstat = false;
		console.log("angin OFF");
    	clearWind();
	}
}

//tambah legend
var anginLegend = L.control({position: 'bottomright'});
anginLegend.onAdd = function (map) {
	var div = L.DomUtil.create('div', 'info legend');
	    div.innerHTML +=	    
	    '<img src="../assets/js/wind/anginlegendkh.png" alt="legend" width="30" height="300">';
	    // console.log(div.innerHTML);
	return div;
};

//start drawing wind map
//nambahin timer, gopalgopel2015
function drawWind() {
    //Add CanvasLayer to the map
    canvasOverlayWind = L.canvasOverlay()			   
        .drawing(redrawWind(null))
        .addTo(map);

    //windy object  
    windy = new Windy({canvas: canvasOverlayWind.canvas(), data: JSONWIND});

    //prepare context global var
    contextWind = canvasOverlayWind.canvas().getContext('2d');				

    	// console.log("anginstat init= "+anginstat);
		map.on('dragstart', function() { 
	    	if(anginstat){
	    		reclearWind(); 
	    		redrawWind();
	    	}
	    });
	    map.on('zoomstart', function() { 
	    	if(anginstat){
	    		reclearWind(); 
	    		redrawWind();
	    	}
	    });
	    map.on('resize', function() { 
	    	if(anginstat){
	    		reclearWind(); 
	    		drawWind();
	    	}
	    });
}

// redrawwind
function redrawWind(overlay, params, timer) {
	
	if (anginstat){	
		console.log("redrawwind");
		//add legend to map
		anginLegend.addTo(map);

	    if( timer ) 
	        window.clearTimeout( timer ); 

	    timer = setTimeout(function() { //showing wind is delayed
	        var bounds = map.getBounds();
	        var size = map.getSize();
	        windy.start( [[0,0],[size.x, size.y]], size.x, size.y, 
	            [[bounds._southWest.lng, bounds._southWest.lat ],[bounds._northEast.lng, bounds._northEast.lat]] );
	    },750)
	}
}

// hilangin layer canvas dan stop animasi
function clearWind() {	
	anginLegend.removeFrom(map);
	console.log("clearwind");
    windy.stop();
    contextWind.clearRect(0,0,3000, 3000);
    contextWind = null;
    map.removeLayer(canvasOverlayWind);
    // windy = null;
}

//kpake kalu cuma mau drag/zoom.klik.. ga ampe remove layer, cm bersihin canvas
function reclearWind() {	
	anginLegend.removeFrom(map);
	console.log("reclearwind");
    windy.stop();
    contextWind.clearRect(0,0,3000, 3000);
}

// CUACA CUACA CUACA CUACA CUACA CUACA CUACA
// WAVES WAVES WAVES WAVES WAVES WAVES WAVES 
var wavesstat = false;
function showWaves(stat){
	// console.log(stat);
	if (stat) {
		wavesstat = true;
		console.log("waves ON");		
		// redrawWaves();
		drawWaves();

	} else {
		wavesstat = false;
		console.log("waves OFF");
    	clearWaves();
	}
}

//tambah legend
var wavesLegend = L.control({position: 'bottomright'});
wavesLegend.onAdd = function (map) {
	var div = L.DomUtil.create('div', 'info legend');
	    div.innerHTML +=	    
	    '<img src="../assets/js/wind/waveslegend.png" alt="legend" width="30" height="300">';	    
	return div;
};

//start drawing wind map
//nambahin timer, gopalgopel2015
function drawWaves() {

    //Add CanvasLayer to the map
    canvasOverlayWaves = L.canvasOverlay()			   
        .drawing(redrawWaves(null))
        .addTo(map);

    //waves object  
    waves = new Waves({canvas: canvasOverlayWaves.canvas(), data: JSONWAVES});

    //prepare context global var
    contextWaves = canvasOverlayWaves.canvas().getContext('2d');				

    	// console.log("anginstat init= "+anginstat);
		map.on('dragstart', function() { 
	    	if(wavesstat){
	    		reclearWaves(); 
	    		redrawWaves();
	    	}
	    });
	    map.on('zoomstart', function() { 
	    	if(wavesstat){
	    		reclearWaves(); 
	    		redrawWaves();
	    	}
	    });
	    map.on('resize', function() { 
	    	if(wavesstat){	    		
	    		reclearWaves(); 
	    		redrawWaves();
	    	}
	    });	
	// redrawWaves();
}

// redrawwaves
function redrawWaves(overlay, params, timer) {
	
	if (wavesstat){	
		console.log("redrawwaves");
		//add legend to map
		wavesLegend.addTo(map);

	    if( timer ) 
	        window.clearTimeout( timer ); 

	    timer = setTimeout(function() { //showing wind is delayed
	        var bounds = map.getBounds();
	        var size = map.getSize();
	        waves.start( [[0,0],[size.x, size.y]], size.x, size.y, 
	            [[bounds._southWest.lng, bounds._southWest.lat ],[bounds._northEast.lng, bounds._northEast.lat]] );
	    },750)
	}
}

// hilangin layer dan stop animasi
function clearWaves() {	
	wavesLegend.removeFrom(map);
	console.log("clearwaves");
    waves.stop();
    contextWaves.clearRect(0,0,3000, 3000);
    contextWaves = null;
    map.removeLayer(canvasOverlayWaves);
    // waves = null;    
}

// cuma bersihin canvas, ga ampe ngilangin layer canvas
function reclearWaves() {	
	wavesLegend.removeFrom(map);
	console.log("reclearwaves");
    waves.stop();
    contextWaves.clearRect(0,0,3000, 3000); 
}

// CUACA CUACA CUACA CUACA CUACA CUACA CUACA
// INIT INIT INIT INIT INIT INIT INIT INIT

function initCuaca(){
	$("#map .leaflet-control-container")
		.append('<div class="leaflet-control-search leaflet-control" style="margin-top:75px;"><input class="search-input" type="text" size="17"  placeholder="Cari Nama Kapal.." style="display: none; max-width: 100%;"><div class="search-tooltip" style="display: none;"></div><a class="search-cancel" href="#" title="Cancel" style="display: none;"><span>⊗</span></a><a class="search-button" href="#" title="Cari Nama Kapal.."></a><div class="search-alert" style="display: none;"></div></div>');
	minimal = null;
	southWest = null;
	northEast = null;
	bounds = null;
	
	//gopalgopel, begin https request	
	initDate();

	//init data sadewa
	var smBounds = [[-10.0, 95.0], [10.0, 145.0]];
	var lgBounds = [[70.0, 70.0], [-70.0, 210.0]];

	awan = L.imageOverlay(awanUrl, smBounds);
	tekanan = L.imageOverlay(tekananUrl, smBounds);
	suhu = L.imageOverlay(suhuUrl, smBounds);
	hujan = L.imageOverlay(hujanUrl, smBounds);



	//ngambil data gelombang
	$.ajax({
        type: 'GET',        
        url: urlcuaca,        
        success:function(response){
            console.log("request "+urlcuaca);
			console.log("result: "+response);					    

			JSONWIND = JSONWAVES = response;
        },
        error: function() {
        	console.log("Error json request"); 
        	window.confirm("Data gelombang dan angin tidak bisa ditampilkan dikarenakan gagal diunduh.");

    	}	
	});	

	//ngambil data temperature
	// $.ajax({
 //        type: 'GET',
 //        url: urltemp,
 //        success:function(response){
 //            console.log("request "+urltemp);
	// 		console.log("result: "+response);

	// 		JSONTEMP = response;			
 //        }
	// });

	//ngambil data pressure
	// $.ajax({
 //        type: 'GET',
 //        url: urlpresr,
 //        success:function(response){
 //            console.log("request "+urlpresr);
	// 		console.log("result: "+response);
			
	// 		JSONPRES = response;
 //        }
	// });	

	//ngambil data angin
	// $.ajax({
 //        type: 'GET',
 //        url: urlwind,	       
 //        success:function(result){            
	// 		console.log("request "+urlwind);
	// 		console.log("result: "+result);

	// 		JSONWIND = result;
 //        },
 //        error: function() {
 //        	console.log("Error json request"); 
 //        	window.confirm("Data angin tidak bisa ditampilkan dikarenakan gagal diunduh.");
 //    	}
	// });
	//end of httprequest
}

// END OF CUACA // END OF CUACA // END OF CUACA // END OF CUACA // END OF CUACA 


function initDrawControl(){
	var drawnItems = new L.FeatureGroup();
	map.addLayer(drawnItems);
	var drawControl = new L.Control.Draw({
		draw: {
			position: 'topleft',
			polygon: {
				title: 'Membuat Area Polygon',
				allowIntersection: true,
				drawError: {
					color: '#b00b00',
					timeout: 1000
				},
				shapeOptions: {
					color: '#bada55'
				}
			},
			circle: {
				title: 'Membuat Area Lingkaran',
				shapeOptions: {
					color: '#662d91'
				}
			},
			polyline : false,
			rectangle : false
		},
		edit:false
	});
	// map.addControl(drawControl);
	draw_circle = new L.Draw.Circle(map, drawControl.options.circle);
	draw_polygon = new L.Draw.Polygon(map, drawControl.options.polygon);
	draw_point = new L.Draw.Marker(map, drawControl.options.marker);
	drawControl = null;
	
	map.on('draw:created', function (e) {
		var type = e.layerType,layer = e.layer;
		switch(type){
			case 'polygon' : setPolygonArea(layer);
				break;
			case 'circle' : setCircleArea(layer);
				break;
			case 'marker' : setMarkerArea(layer);
				break;
		
		}
		drawnItems.addLayer(layer);
	});
}

/**
	initialization features.
		feature activation bounded on left-side menu

	activate feature function definition can be found
	on util.js
*/
var searchKRI = true;
var searchPESUD = null;
var searchMARINIR = null;
var searchPANGKALAN = null;
var searchSATGAS = null;


function initFeatures(){
// var btsTer, btsPkl, btsTmb, btsZee, btsKon, btsSt = false; // if true then show batas line
	//batasLine
    activateFeature('#showbtster', function(s){if(btsTer)showBatasTer(false); else showBatasTer(true);});
    activateFeature('#showbtspkl', function(s){if(btsPkl)showBatasPkl(false); else showBatasPkl(true);});
    activateFeature('#showbtstmb', function(s){if(btsTmb)showBatasTmb(false); else showBatasTmb(true);});
    activateFeature('#showbtszee', function(s){if(btsZee)showBatasZee(false); else showBatasZee(true);});
    activateFeature('#showbtskon', function(s){if(btsKon)showBatasKon(false); else showBatasKon(true);});
    activateFeature('#showbtsst',  function(s){if(btsSt) showBatasSt(false);  else showBatasSt(true);});

	// poi
    activateFeature('#show-poi', function(status){
		showPoi(status);
		// console.log(status);
	});

	// dislokasi kapal
	activateFeature('#show-hist', function(status){
		showHistory(status);		
	});

	activateFeature('#show-hist-aer', function(status){		
		showHistoryPesud(status);		
	});	

	activateFeature('#show-cuaca', function(status){		
		if(!status){
			if(anginstat){			
				clearWind();
				anginstat = false;
			} 
			if (wavesstat) {
				clearWaves();
				wavesstat = false;
			}

		}
		$('input[name=cuaca]').removeAttr("checked"); 
		
	});	

	// cuaca, angin
	activateFeature('#hapus-canvas', function(status){
		// console.log("hapusin cuy");
		// console.log(status);
		// if(!status){
			if(anginstat){			
				clearWind();
				anginstat = false;
			} 
			if (wavesstat) {
				clearWaves();
				wavesstat = false;
			}
		// }
	});


	// cuaca, angin
	activateFeature('#show-angin', function(status){
		console.log(status);
		if(anginstat){			
			// clearWind();
		} else {
			if (wavesstat) {
				clearWaves();
				wavesstat = false;
			}

			showAngin(status);					
		}
	});

	// cuaca, waves
	activateFeature('#show-waves', function(status){
		console.log(status);
		if(wavesstat){			
			// clearWaves();
		} else {
			if (anginstat) {
				clearWind();
				anginstat = false;
			}

			showWaves(status);					
		}
	});

	// cuaca, awan hujan
	activateFeature('#show-awan', function(status){	
		awanstat = !awanstat;
		if(awanstat){
			awan.addTo(map);		
		} else {			
			map.removeLayer(awan);
		}
	});

	// cuaca, tekanan
	activateFeature('#show-tekanan', function(status){	
		tekananstat = !tekananstat;
		if(tekananstat){
			tekanan.addTo(map);		
			tekananLegend.addTo(map);
		} else {			
			map.removeLayer(tekanan);
			tekananLegend.removeFrom(map);
		}
	});

	// cuaca, suhu
	activateFeature('#show-suhu', function(status){	
		suhustat = !suhustat;
		if(suhustat){
			suhu.addTo(map);		
			suhuLegend.addTo(map);
		} else {			
			map.removeLayer(suhu);
			suhuLegend.removeFrom(map);
		}
	});		

	// cuaca, hujan
	activateFeature('#show-hujan', function(status){	
		hujanstat = !hujanstat;
		if(hujanstat){
			hujan.addTo(map);					
		} else {			
			map.removeLayer(hujan);			
		}
	});
	
	// cuaca, gempa
	activateFeature('#show-gempa', function(status){
		console.log("masuk gempa?");
		console.log(listGempa);		
		gempastat = !gempastat;
		if(gempastat){
			console.log(listGempa.length);
			for (i=0; i<listGempa.length; i++){
				listGempa[i].addTo(map);
			}
		} else {			
			for (i=0; i<listGempa.length; i++){				
				map.removeLayer(listGempa[i]);				
			}						
		}
	});		

	activateFeature('#show-kri', function(status){
		searchKRI = status;
		searchpredict();		
		showKRIShip(status);
	});

	activateFeature('#show-ais', function(status){ // added by SKM17
		showAIS(status);
	});
	
    activateFeature('#show-tulis', function(status){
        showtulis(status);
        //showMessage(status);
    });

   activateFeature('#show-inbox', function(status){
        showinbox(status);
        //showMessage(status);
    });
    activateFeature('#show-outbox', function(status){
        showoutbox(status);
        //showMessage(status);
    });
	activateFeature('#show-gs', function(status){ // added by SKM17
		showGroundStation(status);
	});

	activateFeature('#show-message', function(status){ // added by SKM17
		showPesan(status);
		//showMessage(status);
	});
	
	activateFeature('#show-enemy-force', function(status){
		showEnemyForce(status);
	});

	activateFeature('#show-target', function(status){
		showTargetShip(status);
	});

	activateFeature('#show-marines', function(status){
		searchSATGAS = status;
		searchpredict();		
		showMarines(status);
	});

	activateFeature('#show-land-station', function(status){
		console.log("Ini Masuk Pangkalan (LS)");
		searchPANGKALAN = status;
		searchpredict();
		showLandStation(status);
	});

	activateFeature('#show-marines-station', function(status){ // added by SKM17
		console.log("Ini Masuk Marines");
		searchMARINIR = status;
		searchpredict();
		showMarinesStation(status);
	});

	activateFeature('#show-submarine', function(status){
		showSubmarine(status);
	});

	activateFeature('#show-aeroplane', function(status){
		searchPESUD = status;
		console.log("statsu pesud : "+status)
		searchpredict();
		showAeroplane(status);
	});

	activateFeature('#show-combat-vehicle', function(status){
		showCombatVehicle(status);
	});

	activateFeature('#show-form-lapsithar', function(status){
		showLapsitharForm(status);
	});

	activateFeature('#show-form-intel-info', function(status){
		showIntelligentInfo(status);
	});

	activateFeature('#show-measure-tool', function(status){
		// showMeasureTool(status);
		if (status){
			stat_ukur_jarak = status;
		} else {
			stat_ukur_jarak = status;
			hapus_jarak();
		}
	});
	
	activateFeature('#get-camera', function(status){
		showCCTV(status);
	});

	activateFeature('#show-chat', function(status){
		showChat(status);
	});

	activateFeature('#goto-backend', function(status){
		// window.location = '';
	   popup('popUpDiv');
		 window.location = conf.url + 'admin/dashboard_ctrl';
	});

	activateFeature('#logout', function(status){
	   window.location = conf.url +'home/logout';
	});

	activateFeature('#ship-cctv', function(status){
		$("#frame-video").attr('src',conf.url+'map/kri_video/'+$('#cctv-ip').val()+'/'+$('#cctv-uname').val()+'/'+$('#cctv-pwd').val());
		$('#video-streaming').fadeIn('fast');
	});

	// activateFeature('#show-kri', function(status){
	// 	showKRIShip(status);
	// });

	activateFeature('#show-area', function(status){ // added by SKM17
		showDefinedArea(status);
	});
}



//POIPOIPOIPOIPOI
var bufferPOI = [];	
var lolo;
function showPoi(status){

	if (status == true){
		getDatapoi(function(data){
			

			var transarrow, as;

        	for (var i=0; i<data.length; i++){
        		lolo = data;
            	as = data[i].poi_icon;
            	// console.log(as);
            	transarrow = L.icon({  
                	iconUrl: '../assets/img/upload/icon/IconPoi/'+as, 
                	iconSize: [30, 30],
                	iconAnchor: [15, 15]
          	 	});
            	// console.log(data[i]);
            	mark = new L.marker([data[i].poi_lat, data[i].poi_lon,], {icon: transarrow}, {name: data[i].poi_name}, {des: data[i].poi_description})
                	.bindLabel('Nama Poi: '+data[i].poi_name+
                          	   '</br> <p style=display:none;> Deskripsi: '+data[i].poi_description,
                           	 // '</br> Latitude: '+viewableCoordinate(data[i].poi_lat,'lat')+
                           	//  '</br> Longitude: '+viewableCoordinate(data[i].poi_lon,'lng'), 
                           	{noHide: true}
					)
					.on('click', function(lolo) { 
                	 	console.log('data POI');
                	 	// console.log(e);	 
                	 	console.log(lolo);	
                	 	// $.each(mark,function(){

						$('#side-POI').hide();	
						$("#ship-info-POI").empty();	
						
						$("#ship-info-POI").html(
						// '<li><img src='+conf.url+'assets/img/upload/icon/IconPoi/'+ this.dragging._marker +'></img></li>'+
						'<li><label></label> <br />'+ this.label._content +'</li>' +
						'<li><label>Latitude </label> <br />'+viewableCoordinate(this.getLatLng().lat,'lat')+'</li>' + 
						'<li><label>Longitude </label> <br />'+viewableCoordinate(this.getLatLng().lng,'lng')+'</li>' 
							
						// '<li><label>Latitude </label> <br />'+viewableCoordinate(lala.poi_lat,'lat')+'</li>' +
						// '<li><label>Longitude </label> <br />'+viewableCoordinate(lala.poi_lon,'lng')+'</li>' +
						// 	'<li><label>Deskripsi </label> <br />'+ lala.poi_description +'</li>' 
						);
						// });

						$('#side-POI').animate({width:'toggle'}, 150);
					});



 // click untuk side info fletmoon

// .on('click', function(lolo) { 
//                 	 	console.log('data POI');
//                 	 	// console.log(e);	 
//                 	 	console.log(lolo);	
//                 	 	// $.each(mark,function(){

// 						$('#side-Fletmoon').hide();	
// 						$("#ship-info-Fletmoon").empty();	
						
// 						$("#ship-info-Fletmoon").html(
// 						// '<li><img src='+conf.url+'assets/img/upload/icon/IconPoi/'+ this.dragging._marker +'></img></li>'+
// 						'<li><label></label> <br />'+ this.label._content +'</li>' +
// 						'<li><label>Latitude </label> <br />'+viewableCoordinate(this.getLatLng().lat,'lat')+'</li>' + 
// 						'<li><label>Longitude </label> <br />'+viewableCoordinate(this.getLatLng().lng,'lng')+'</li>' 
							
// 						// '<li><label>Latitude </label> <br />'+viewableCoordinate(lala.poi_lat,'lat')+'</li>' +
// 						// '<li><label>Longitude </label> <br />'+viewableCoordinate(lala.poi_lon,'lng')+'</li>' +
// 						// 	'<li><label>Deskripsi </label> <br />'+ lala.poi_description +'</li>' 
// 						);
// 						// });

// 						$('#side-Fletmoon').animate({width:'toggle'}, 150);
// 					});










            	map.addLayer(mark);
            	bufferPOI.push(mark);

           		// console.log('Data Ke:'+i);
       	 	}    

		});

	} else {
		// console.log(bufferPOI.length);
		for (var x=0; x<bufferPOI.length; x++){
			map.removeLayer(bufferPOI[x]);			
		}
		bufferPOI = [];
	}
	
}
//POIPOIPOIPOIPOI


// function removeAllKRI(){

// 	for(var shipId in markerKRI){
// 		map.removeLayer(markerKRI[shipId]);
// 	}
// }

function GetAppliedKRIIcon (shipType, mapZoom, isRealtime, isObsolete, shipStatus, shipCorpsId) {
	var icon = null;

	if (mapZoom <= 15) {
		if (isRealtime && isObsolete) {
			icon = iconObsolete[shipType];
		} else if (isRealtime) {
			icon = iconRealtime[shipType];
		} else {
			// pembina armabar zoom <= 15
			if (shipCorpsId == 1) {
				if (shipStatus == 1) {
					icon = iconNoRealtimemabar[shipType];
				} else if (shipStatus == 2) {
					icon = iconNoRealtimemabarlego[shipType];
				} else { // if (shipStatus == 3) {
					icon = iconNoRealtimemabarsandar[shipType];
				}
			}
			// pembina armatim zoom <= 15
			else if (shipCorpsId == 2) { 	
				if (shipStatus == 1) {
					icon = iconNoRealtimematim[shipType];
				} else if (shipStatus == 2) {
					icon = iconNoRealtimematimlego[shipType];
				} else { // if (shipStatus == 3) {
					icon = iconNoRealtimematimsandar[shipType];
				}
			}
			// pembina kolinlamil zoom <= 15
			else if (shipCorpsId == 40) { //lamil
				if (shipStatus == 1) {
					icon = iconNoRealtimelamil[shipType];
				} else if (shipStatus == 2) {
					icon = iconNoRealtimelamillego[shipType];
				} else { // if (shipStatus == 3) {
					icon = iconNoRealtimelamilsandar[shipType];
				}
			}
			// pembina selain armabar, armatim, kolinlamil zoom <= 15
			else { 
				if (shipStatus == 1) { //layar
					icon = iconNoRealtime[shipType];				
				} else if (shipStatus == 2) { //lego
					icon = iconNoRealtimeLego[shipType];
				} else { // if (shipStatus == 3) { //sandar
					icon = iconNoRealtimeSandar[shipType];
				}
			}
		}
	} 
	else if (mapZoom == 16) {
		if (isRealtime && isObsolete) {
			icon = iconObsolete16[shipType];
		} else if (isRealtime) {
			icon = iconRealtime16[shipType];
		} else {
			// pembina armabar zoom 16
			if (shipCorpsId == 1) {
				if (shipStatus == 1) {
					icon = iconNoRealtimemabar16[shipType];
				} else if (shipStatus == 2) {
					icon = iconNoRealtimemabarlego16[shipType];
				} else { // if (shipStatus == 3) {
					icon = iconNoRealtimemabarsandar16[shipType];
				}
			}
			// pembina armatim zoom 16
			else if (shipCorpsId == 2) { 	
				if (shipStatus == 1) {
					icon = iconNoRealtimematim16[shipType];
				} else if (shipStatus == 2) {
					icon = iconNoRealtimematimlego16[shipType];
				} else { // if (shipStatus == 3) {
					icon = iconNoRealtimematimsandar16[shipType];
				}
			}
			// pembina kolinlamil zoom 16
			else if (shipCorpsId == 40) { //lamil
				if (shipStatus == 1) {
					icon = iconNoRealtimelamil16[shipType];
				} else if (shipStatus == 2) {
					icon = iconNoRealtimelamillego16[shipType];
				} else { // if (shipStatus == 3) {
					icon = iconNoRealtimelamilsandar16[shipType];
				}
			}
			// pembina selain armabar, armatim, kolinlamil zoom 16
			else { 
				if (shipStatus == 1) { //layar
					icon = iconNoRealtime16[shipType];				
				} else if (shipStatus == 2) { //lego
					icon = iconNoRealtimeLego16[shipType];
				} else { // if (shipStatus == 3) { //sandar
					icon = iconNoRealtimeSandar16[shipType];
				}
			}
		}
	} 
	else if (mapZoom == 17) {
		if (isRealtime && isObsolete) {
			icon = iconObsolete17[shipType];
		} else if (isRealtime) {
			icon = iconRealtime17[shipType];
		} else {
			// pembina armabar zoom 17
			if (shipCorpsId == 1) {
				if (shipStatus == 1) {
					icon = iconNoRealtimemabar17[shipType];
				} else if (shipStatus == 2) {
					icon = iconNoRealtimemabarlego17[shipType];
				} else { // if (shipStatus == 3) {
					icon = iconNoRealtimemabarsandar17[shipType];
				}
			}
			// pembina armatim zoom 17
			else if (shipCorpsId == 2) { 	
				if (shipStatus == 1) {
					icon = iconNoRealtimematim17[shipType];
				} else if (shipStatus == 2) {
					icon = iconNoRealtimematimlego17[shipType];
				} else { // if (shipStatus == 3) {
					icon = iconNoRealtimematimsandar17[shipType];
				}
			}
			// pembina kolinlamil zoom 17
			else if (shipCorpsId == 40) { //lamil
				if (shipStatus == 1) {
					icon = iconNoRealtimelamil17[shipType];
				} else if (shipStatus == 2) {
					icon = iconNoRealtimelamillego17[shipType];
				} else { //} if (shipStatus == 3) {
					icon = iconNoRealtimelamilsandar17[shipType];
				}
			}
			// pembina selain armabar, armatim, kolinlamil zoom 17
			else { 
				if (shipStatus == 1) { //layar
					icon = iconNoRealtime17[shipType];				
				} else if (shipStatus == 2) { //lego
					icon = iconNoRealtimeLego17[shipType];
				} else { //} if (shipStatus == 3) { //sandar
					icon = iconNoRealtimeSandar17[shipType];
				}
			}
		}
	} 
	else if (mapZoom == 18) {
		if (isRealtime && isObsolete) {
			icon = iconObsolete18[shipType];
		} else if (isRealtime) {
			icon = iconRealtime18[shipType];
		} else {
			// pembina armabar zoom 18
			if (shipCorpsId == 1) {
				if (shipStatus == 1) {
					icon = iconNoRealtimemabar18[shipType];
				} else if (shipStatus == 2) {
					icon = iconNoRealtimemabarlego18[shipType];
				} else { //if (shipStatus == 3) {
					icon = iconNoRealtimemabarsandar18[shipType];
				}
			}
			// pembina armatim zoom 18
			else if (shipCorpsId == 2) { 	
				if (shipStatus == 1) {
					icon = iconNoRealtimematim18[shipType];
				} else if (shipStatus == 2) {
					icon = iconNoRealtimematimlego18[shipType];
				} else { //if (shipStatus == 3) {
					icon = iconNoRealtimematimsandar18[shipType];
				}
			}
			// pembina kolinlamil zoom 18
			else if (shipCorpsId == 40) { //lamil
				if (shipStatus == 1) {
					icon = iconNoRealtimelamil18[shipType];
				} else if (shipStatus == 2) {
					icon = iconNoRealtimelamillego18[shipType];
				} else { //if (shipStatus == 3) {
					icon = iconNoRealtimelamilsandar18[shipType];
				}
			}
			// pembina selain armabar, armatim, kolinlamil zoom 18
			else { 
				if (shipStatus == 1) { //layar
					icon = iconNoRealtime18[shipType];				
				} else if (shipStatus == 2) { //lego
					icon = iconNoRealtimeLego18[shipType];
				} else { //if (shipStatus == 3) { //sandar
					icon = iconNoRealtimeSandar18[shipType];
				}
			}
		}
	}

	return icon;
}

function CountMarkerKRI() {
	var n = 0;

	for (var i in markerKRI) {
		if (markerKRI[i]!=undefined || markerKRI[i]!=null)
			n++;
	}

	return n;
}

function processKRIData(kris){
	var len = kris.length;
	var i = 0; 

	// console.log(kris);// + JSON.stringify(kris));
	
	/* delete all KRI 
		viewport bounding makes problem if KRI marker don't remove before
		new data processed.
	*/

	// console.log("nKRI from node JS: " + len);
	// console.log("nKRI in array markerKRI: " + CountMarkerKRI());
	// console.log("markerKRI.length: " + markerKRI.length);

	for (i; i< len ; i++) {
		var item = kris[i];

	    if (item.is_in_operation && (!user_group || item.corps == corps_id)) {
	    	var appliedKRIIcon = GetAppliedKRIIcon(item.shipType, map.getZoom(), item.isRealtime, item.isObsolete, 
	    		item.shipStatus, item.corps);

	    	if (!markerKRI[item.shipId]) { // marker kri baru
	    		markerKRI[item.shipId] = new L.KRIMarker(
					[item.lat,item.lon], 
					{   
						icon:appliedKRIIcon, 
						iconAngle: parseInt(item.direction), 
						zIndexOffset:1000,
						shipId:item.shipId, 
						lat:item.lat, lon:item.lon, 
						abbr: item.abbr,view:true, 
						name:item.name,
						direction:parseInt(item.direction),
						speed:Math.abs(item.speed),
						tw : item.TW
					}
				)
    			.bindLabel('<p align="center">'+item.abbr+'-'+item.shipId+'</p>', 
					{ noHide: kriNumberDisplayStat, direction: 'auto' }
				)
				.on('click', function() { 
					if (stat_view.kri) {
						$('#side-KRI').hide();							
						$("#ship-info-KRI").empty();
						if (firstpolyline != null){
							showHistory(false); //nambah pas awal klik info biar ganti history	
						}														
						showShipInfo(this.options.shipId);							
						showShipDislocation(this.options.name, this.options.shipId, this.options.lat, this.options.lon);// nambah buat show history dislokasi //gopalgopel
						$('#side-KRI').animate({width:'toggle'}, 150);
					}
				});

				if (kriNumberDisplayStat)
					markerKRI[item.shipId].showLabel();

				markerKRI[item.shipId].on('contextmenu',function(e) {
					onClickMeasuring(markerKRI[item.shipId].lat,markerKRI[item.shipId].lon);
				});
				map.addLayer(markerKRI[item.shipId]);

				markersSearch.addLayer(markerKRI[item.shipId]);
				append_search_list(item.name,item.lat,item.lon,'kri');
	    	}
	    	else { // update info KRI
				markerKRI[item.shipId].setIcon(appliedKRIIcon);						

				markerKRI[item.shipId].setIconAngle(parseInt(item.direction));
				markerKRI[item.shipId].unbindLabel();
				
				markerKRI[item.shipId].bindLabel(
					'<p align="center">'+item.abbr+'-'+item.shipId+'</p>', 
					{ noHide: kriNumberDisplayStat, direction: 'auto' });

				if (kriNumberDisplayStat)
					markerKRI[item.shipId].showLabel();

				markerKRI[item.shipId].setOpacity(1);				

				markerKRI[item.shipId].update();
	    	}
	    }
	}//end for
}

function processTargetData(targets){
	tempTrack = [];
	if(targets != null){
		var len = targets.length;
		var i = 0;
		for(i ; i < len ; i++){
			var item = targets[i];
			
			// added by SKM17 for filtering the time
			var selisihWaktu = (new Date()).getTime() - (new Date(item.TW)).getTime();
			var patokan = 10 * 60 * 1000;
			
			if(item.lat != null && item.lon != null && (selisihWaktu < patokan)) { // modified by SKM17
				if(markerTrack!=null){
					removeTrack();
				}

/*
				var itemLabel = '<p align="center">'+item.targetId+'<br />'+viewableCoordinate(item.lat,'lat')+
						' , '+viewableCoordinate(item.lon,'lon')+'<br />Sumber: '+item.shipName+ '<br />' + Date.getTW(item.TW) + '</p>';
				*/
				var itemLabel = '<p align="center">' + item.targetId + '</p>';

				var target = new L.TargetMarker(
					[item.lat,item.lon],
					{
						icon:new ShipIcon({iconUrl: conf.url+'assets/img/target-icon/'+item.icon}),
						direction : item.direction,
						speed: Math.abs(item.speed),
						iconAngle: parseInt(item.heading),
						tw : item.TW
					}
				).bindLabel(itemLabel).on('contextmenu',function(e){
						onClickMeasuring(item.lat,item.lon);
				});
				target.setIconAngle(parseFloat(item.heading));
				
				tempTrack.push(target);
				itemLabel = null;
			}
		}

		if (tempTrack!= null) {
			if (stat_view.track &&  tempTrack != null && tempTrack.length>0) {
				markerTrack =  L.layerGroup(tempTrack);
				map.addLayer(markerTrack);
			}else{
				removeTrack();
			} 
		}
	}
	else{
		console.log('no targets found');
	}
}

function getPushdata() {
	if (socket!= null) 
	{
		socket.emit('reqInitKRI',{});
		socket.emit('reqInitTarget',{});
	}
}


function next_move() {
	if (socket!=null)
	{
		socket.on('updateKRI', function(param) {
			var payload = JSON.parse(param);
			processKRIData(payload);
		});

		socket.on('updateTarget', function(param) {
			var payload = JSON.parse(param);
			processTargetData(payload);
		});
	}
}

/* @ship-data-support! 
	ship data support formatting :

	Math.abs

*/
function showShipInfo(id) {	
	getDataShip(id,"ship", function(data){
		$("#ship-info-KRI").empty();
		
		$.each(data,function(i,item) {
			console.log("kaulah1111111");
		console.log(item);
			var result = '';

			// if else added by SKM17
			if (item.ship_abbr)
				result += '<li>'+item.ship_abbr+' '+item.ship_id+' - '+item.ship_name+'</li>';
			else
				result += '<li>' +item.ship_id+' - '+item.ship_name+'</li>';

			if(item.ship_image != null && item.ship_image != 0){
				result += '<li> <img src="'+conf.url+'assets/img/upload/main/'+item.ship_image+'" height="125" width="215" alt=""> </li>'
			}

			// revised by SKM17
			var opName, kodal;
			if (item.operation_name) opName = item.operation_name;
			else opName = '-';
			
			if (item.kodal_name) kodal = item.kodal_name;
			else kodal = '-';
			// END REVISED
			
			

			result += 
				
				'<li><label>Komandan	:</label><br/> '+item.ship_commander+'</li>'+
				'<li><label>Jenis Kapal :</label><br/> '+item.shiptype_desc+'</li>'+
				'<li><label>Posisi :  </label><br />'+viewableCoordinate(item.ship_lat,'lat')+' , '+viewableCoordinate(item.ship_lon,'lon')+'</li>'+
				'<li><label>Halu :  </label><br />'+item.ship_direction+'</li>'+
				'<li><label>Cepat :  </label><br />'+Math.abs(item.ship_speed)+' Knot</li>'+
				 // '<li><label>Timestamp :  </label><br />'+item.ship_timestamp_location+'</li>'+
				  '<li><label>Timestamp :  </label><br />-</li>'+
				
				'<li><label>Pembina :</label><br />  '+item.corps_name+' </li>'+
				'<li><label>Nama Operasi : </label><br />  '+ opName +' </li>'+ // added opName by SKM17
				'<li><label>Kodal :  </label><br />'+ kodal +' </li>'+
				'<li><label>Status : </label><br />'+item.ship_stat_desc+'<li>'; // added by SKM17

			$("#ship-info-KRI").append(result);

			var cctv_info =  '<input id="cctv-ip" type="hidden" value="'+item.ship_cctv_ip+'" />';
				cctv_info +=  '<input id="cctv-uname" type="hidden" value="'+item.ship_cctv_uname+'" />';
				cctv_info +=  '<input id="cctv-pwd" type="hidden" value="'+item.ship_cctv_pwd+'" />';

			if (item.ship_cctv_ip != null) {
				$('#ship-cctv').attr("style","");
			}

			$('#cctv-info').html(cctv_info);
			result = null;
			console.log("append ship-info");
		});	
	});

	//@ship-ado
	getDataAdo(id,"ado", function(data){
	   $("#ship-ado-KRI").empty();
		var result = '<li>ANALISIS DAERAH OPERASI (ADO)</li>';
		$.each(data,function(i,item){
			var time = (item.ado_time)?item.ado_time:'';
			result += '<p style="border-top: 1px solid #2E6E9E; padding: 5px 0; line-height: 12px;">'
				+ '<span style="font-size: 10px; font-weight: bold; color: #999;">'+Date.getTW(time)+
				'</span> <br /><span style="font-size:12px; line-height: 13px;">' + item.ado_report + '</span></p>'; 
	
		});
		$("#ship-ado-KRI").append(result);
		result = null;
	});

	//@ship-personnel
	getDataPersonnel(id,"personnel", function(data){
		$("#ship-personnel-KRI").empty();
		var result = '<li>PERSONIL</li>';
		 $.each(data,function(i,item){
			if(item.psn_code==10){
				result += '<li> <label>'+item.psn_desc+' :</label><br />'+item.psn_name+'</li>';
			}else{
				result += '<li><label>Jumlah '+item.psn_desc+': </label> '+item.psn_value+' '+item.psn_metric+'</li>';
			}
		});
		$("#ship-personnel-KRI").append(result);
		result = null;
	});

	//@ship-logistic
	getDataLogistic(id,"logistic", function(data){
		$("#ship-logistic-KRI").empty();
		var result = '<li>KONDISI TEKNIS</li>';
		$.each(data,function(i,item){
			 result += '<li> <label>'+item.log_desc+' :</label>  '+item.log_value+' '+item.log_metric+'</li>';
		});
		$("#ship-logistic-KRI").append(result);
		result = null;
	}); 
}

function append_search_list(name,lat,lon,type){ 
// var keyword = '';

// pattern : ([\s^\w]*)?keyword([\s$\w]+)?
	var found = false;
	var index = 0;
	$.each(array_search,function(i,item){
		if(item.name==name){
			found = true;
			index = i;
			// //console.log(item.name);
			// //console.log(name);
		}
	});
	if (!found) {
		array_search.push(
			{
				name : name,
				lat:lat,
				lon:lon,
				type:type
			}
		);
	} else {
		array_search[index] = {
				name : name,
				lat:lat,
				lon:lon,
				type:type
		};
	}
}

function changeMode(currMode){
	if(socket!=null){
		socket.emit('reqChangeMode', {'mode': currMode});
	}
}

/*block of @data-support*/

/* @ship-data-support @ship-logistic!*/
function getDataLogistic(id,type, fn){
	if(socket != null){
		socket.emit('reqLogistics', { shipId: id });
		socket.once('resLogistics', function (data) {
			fn(data); 
		});
	}
}

/* @ship-data-support @ship-info! */
function getDataShip(id,type, fn){
	if(socket!=null){
		socket.emit('reqShip', { shipId: id });
		socket.once('resShip', function (data) {
			$("#ship").html("");
			fn(data);
		});
	}
}

function getDatapoi(fn){
	if(socket!=null){
		socket.emit('reqPoi', {});
		socket.once('resPoi', function (data) {
			$("#poi").html("");
			fn(data);
		});
	}
}

/* @ship-data-support @ship-ado*/
function getDataAdo(id,type, fn){

	if(socket != null){
		socket.emit('reqADO', { shipId: id });
		socket.once('resADO', function (data) {
			////console.log(data);
			$("#ado").html("");
			var content = '<p style="font-weight: bold;" align="center">ADO</p><p>Laporan : </p>';
			$("#ado").append(content);
			content = null;
			fn(data);
		});
	}
}

/* @ship-data-support @ship-personnel*/
function getDataPersonnel(id,type, fn){
	if(socket != null){
		socket.emit('reqPersonnel', { shipId: id });
		socket.once('resPersonnel', function (data) {
			$("#personnel").html("");
			var content = '<p style="font-weight:bold;" align="center">Informasi Personil</p>';
			$("#personnel").append(content);
			content = null;
			fn(data);
		});
	}
}

/* @ship-history dislokasi*/
function getDataDislokasiHistori(id, fn){
	if(socket != null){
		socket.emit('reqShipHist', { shipId: id });
		socket.once('resShipHist', function (data) {
			// console.log("hasil request hist ship");
			// console.log(data);
			// belom dikerjain gopalgopel
			// $("#personnel").html("");
			// var content = '<p style="font-weight:bold;" align="center">Informasi Personil</p>';
			// $("#personnel").append(content);
			// content = null;
			fn(data);
		});
	}
}

/* @ship-history dislokasi*/
function getDataDislokasiHistoriPesud(id, fn){
	if(socket != null){
		console.log("request hist pesud id: "+id);
		socket.emit('reqPesudHist', { aerId: id });
		socket.once('resPesudHist', function (data) {
			// console.log("hasil request hist pesud:");
			// console.log(data);
			// belom dikerjain gopalgopel
			// $("#personnel").html("");
			// var content = '<p style="font-weight:bold;" align="center">Informasi Personil</p>';
			// $("#personnel").append(content);
			// content = null;
			fn(data);
		});
	}
}

function getIntelegentInfo(){
	if(socket != null){
		socket.emit('reqIntelligence', {});
		socket.once('resIntelligence', function (data) {
		   // //console.log('intelegent');
		   // //console.log(data);
			if(data.length>0){
				for(var i in data){
					dataIntelegent = data[i].find_intelligence_info;
				}
				dataIntelegent = eval('('+dataIntelegent+')');
				$.each(dataIntelegent,function(i,item){
					if(item.type=="circle"){
						drawCircle(item);
					}else if(item.type=="polygon"){
						drawArea(item);
					}else if(item.type=="point"){
						drawMarker(item);
					}
				});
			}
		});
	}
}

/*end of @data-support*/

 
//openweathermap added by kikifirmansyah
function getI18n(key, lang) {
	var i18n = {
		en: {
			  maps: 'Maps'
			// , layers: 'TileLayer'
			// , current: 'Current Weather'
			// ,windity :'windityee'

			, gopal: 'GopalGopel'
			, clouds: 'Clouds'
			, cloudscls: 'Clouds (classic)'
			, precipitation: 'Precipitation'
			, precipitationcls: 'Precipitation (classic)'
			, rain: 'Rain'
			, raincls: 'Rain (classic)'
			, snow: 'Snow'
			, temp: 'Temperature'
			, windspeed: 'Wind Speed'
			, pressure: 'Pressure'
			, presscont: 'Pressure Contour'

			, city: 'Cities'
			, station: 'Stations'
			, windrose: 'Wind Rose'

			
		}
		, de: {
			  maps: 'Karten'
			// , layers: 'Ebenen'
			// , current: 'Aktuelles Wetter'

			, clouds: 'Wolken'
			, cloudscls: 'Wolken (classic)'
			, precipitation: 'Niederschläge'
			, precipitationcls: 'Niederschläge (classic)'
			, rain: 'Regen'
			, raincls: 'Regen (classic)'
			, snow: 'Schnee'
			, temp: 'Temperatur'
			, windspeed: 'Windgeschwindigkeit'
			, pressure: 'Luftdruck'
			, presscont: 'Isobaren'

			, city: 'Städte'
			, station: 'Stationen'
			, windrose: 'Windrose'


		}
		, fr: {
			  maps: 'Carte'
			// , layers: 'Couches'
			// , current: 'Temps actuel'

			, clouds: 'Nuage'
			, cloudscls: 'Nuage (classique)'
			, precipitation: 'Précipitations'
			, precipitationcls: 'Précipitations (classique)'
			, rain: 'Pluie'
			, raincls: 'Pluie (classique)'
			, snow: 'Neiges'
			, temp: 'Température'
			, windspeed: 'Vitesse du vent'
			, pressure: 'Pression de l\'air'
			, presscont: 'Isobare'

			, city: 'Villes'
			, station: 'Stations'
			, windrose: 'Boussole'
		}
		, ru: {
			  maps: 'карта'
			// , layers: 'слой'
			// , current: 'текущая погода'

			, clouds: 'о́блачность'
			, cloudscls: 'о́блачность (класси́ческий)'
			, precipitation: 'оса́дки'
			, precipitationcls: 'оса́дки (класси́ческий)'
			, rain: 'дождь'
			, raincls: 'дождь (класси́ческий)'
			, snow: 'снег'
			, temp: 'температу́ра'
			, windspeed: 'ско́рость ве́тра'
			, pressure: 'давле́ние'
			, presscont: 'изоба́ра'

			, city: 'города'
			, station: 'станции'
			, windrose: 'направление ветра'
		}
		, nl: {
			  maps: 'Kaarten'
			// , layers: 'Lagen'
			// , current: 'Actuele Weer'

			, clouds: 'Wolken'
			, cloudscls: 'Wolken (classic)'
			, precipitation: 'Neerslag'
			, precipitationcls: 'Neerslag (classic)'
			, rain: 'Regen'
			, raincls: 'Regen (classic)'
			, snow: 'Sneeuw'
			, temp: 'Temparatuur'
			, windspeed: 'Windsnelheid'
			, pressure: 'Luchtdruk'
			, presscont: 'Isobare'

			, city: 'Steden'
			, station: 'Stations'
			, windrose: 'Wind roos'
		}
	};

	if (typeof i18n[lang] != 'undefined'
			&& typeof i18n[lang][key] != 'undefined') {
		return  i18n[lang][key];
	}
	return key;
}

/**
 * Try to find a language we shoud use. Look for URL parameter or system settings.
 * Restricts to supported languages ('en', 'fr', 'ru', 'de').
 * @return String language code like 'en', 'fr', 'ru' or 'de'
 */
function getLocalLanguage() {
	var lang = null;

	// 1. try to read URL parameter 'lang'
	var qs = window.location.search;
	if (qs) {
		if (qs.substring(0, 1) == '?') {
			qs = qs.substring(1)
		}
		var params = qs.split('&')
		for(var i = 0; i < params.length; i++) {
			var keyvalue = params[i].split('=');
			if (keyvalue[0] == 'lang') {
				lang = keyvalue[1];
				break;
			}
		}
	}

	// 2. try to get browser or system language
	if (!lang) {
		var tmp = window.navigator.userLanguage || window.navigator.language;
		lang = tmp.split('-')[0];
	}

	// Use only supported languages, defaults to 'en'
	if (lang != 'en' && lang != 'de' && lang != 'fr' && lang != 'ru' && lang != 'nl') {
		lang = 'en';
	}
	return lang;
}

/**
 * Add or replace a parameter (with value) in the given URL.
 * By Adil Malik, http://stackoverflow.com/questions/1090948/change-url-parameters/10997390#10997390
 * @param String url the URL
 * @param String param the parameter
 * @param String paramVal the value of the parameter
 * @return String the changed URL
 */
function updateURLParameter(url, param, paramVal) {
	var theAnchor = null;
	var newAdditionalURL = "";
	var tempArray = url.split("?");
	var baseURL = tempArray[0];
	var additionalURL = tempArray[1];
	var temp = "";

	if (additionalURL) {
		var tmpAnchor = additionalURL.split("#");
		var theParams = tmpAnchor[0];
		theAnchor = tmpAnchor[1];
		if(theAnchor) {
			additionalURL = theParams;
		}

		tempArray = additionalURL.split("&");

		for (i=0; i<tempArray.length; i++) {
			if(tempArray[i].split('=')[0] != param) {
				newAdditionalURL += temp + tempArray[i];
				temp = "&";
			}
		}        
	} else {
		var tmpAnchor = baseURL.split("#");
		var theParams = tmpAnchor[0];
		theAnchor  = tmpAnchor[1];

		if(theParams) {
			baseURL = theParams;
		}
	}

	if(theAnchor) {
		paramVal += "#" + theAnchor;
	}

	var rows_txt = temp + "" + param + "=" + paramVal;
	return baseURL + "?" + newAdditionalURL + rows_txt;
}

/**
 * Add or replace the language parameter of the URL and reload the page.
 * @param String id of the language
 */
function changeLanguage(pLang) {
	window.location.href = updateURLParameter(window.location.href, 'lang', pLang);
}

/**
 * Get all parameters out of the URL.
 * @return Array List of URL parameters key-value indexed
 */
function getUrlParameters() {
	var vars = [], hash;
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	for(var i=0; i<hashes.length; i++) {
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}
	return vars;
}

/**
 * Callback for successful geolocation.
 * @var position Geolocated position
 */
function foundLocation(position) {
	if (typeof map != "undefined") {
		var lat = position.coords.latitude;
		var lon = position.coords.longitude;
		map.setView(new L.LatLng(lat, lon), 11);
	}
}

/**
 * Example function to replace leaflet-openweathermap's builtin marker by a wind rose symbol.
 * Some helper functions and an event listener are needed, too. See below.
 */
function myWindroseMarker(data) {
	var content = '<canvas id="id_' + data.id + '" width="50" height="50"></canvas>';
	var icon = L.divIcon({html: content, iconSize: [50,50], className: 'owm-div-windrose'});
	return L.marker([data.coord.lat, data.coord.lon], {icon: icon, clickable: false});
}

/**
 * Helper function for replacing leaflet-openweathermap's builtin marker by a wind rose symbol.
 * This function draws the canvas of one marker symbol once it is available in the DOM.
 */
function myWindroseDrawCanvas(data, owm) {

	var canvas = document.getElementById('id_' + data.id);
	canvas.title = data.name;
	var angle = 0;
	var speed = 0;
	var gust = 0;
	if (typeof data.wind != 'undefined') {
		if (typeof data.wind.speed != 'undefined') {
			canvas.title += ', ' + data.wind.speed + ' m/s';
			canvas.title += ', ' + owm._windMsToBft(data.wind.speed) + ' BFT';
			speed = data.wind.speed;
		}
		if (typeof data.wind.deg != 'undefined') {
			//canvas.title += ', ' + data.wind.deg + '°';
			canvas.title += ', ' + owm._directions[(data.wind.deg/22.5).toFixed(0)];
			angle = data.wind.deg;
		}
		if (typeof data.wind.gust != 'undefined') {
			gust = data.wind.gust;
		}
	}
	if (canvas.getContext && speed > 0) {
		var red = 0;
		var green = 0;
		if (speed <= 10) {
			green = 10*speed+155;
			red = 255*speed/10.0;
		} else {
			red = 255;
			green = 255-(255*(Math.min(speed, 21)-10)/11.0);
		}
		var ctx = canvas.getContext('2d');
		ctx.translate(25, 25);
		ctx.rotate(angle*Math.PI/180);
		ctx.fillStyle = 'rgb(' + Math.floor(red) + ',' + Math.floor(green) + ',' + 0 + ')';
		ctx.beginPath();
		ctx.moveTo(-15, -25);
		ctx.lineTo(0, -10);
		ctx.lineTo(15, -25);
		ctx.lineTo(0, 25);
		ctx.fill();

		// draw inner arrow for gust
		if (gust > 0 && gust != speed) {
			if (gust <= 10) {
				green = 10*gust+155;
				red = 255*gust/10.0;
			} else {
				red = 255;
				green = 255-(255*(Math.min(gust, 21)-10)/11.0);
			}
			canvas.title += ', gust ' + data.wind.gust + ' m/s';
			canvas.title += ', ' + owm._windMsToBft(data.wind.gust) + ' BFT';
			ctx.fillStyle = 'rgb(' + Math.floor(red) + ',' + Math.floor(green) + ',' + 0 + ')';
			ctx.beginPath();
			ctx.moveTo(-15, -25);
			ctx.lineTo(0, -10);
			//ctx.lineTo(15, -25);
			ctx.lineTo(0, 25);
			ctx.fill();
		}
	} else {
		canvas.innerHTML = '<div>'
				+ (typeof data.wind != 'undefined' && typeof data.wind.deg != 'undefined' ? data.wind.deg + '°' : '')
				+ '</div>';
	}
}

/**
 * Helper function for replacing leaflet-openweathermap's builtin marker by a wind rose symbol.
 * This function is called event-driven when the layer and its markers are added. Now we can draw all marker symbols.
 * The this-context has to be the windrose layer.
 */
function windroseAdded(e) {
	for (var i in this._markers) {
		var m = this._markers[i];
		var cv = document.getElementById('id_' + m.options.owmId);
		for (var j in this._cache._cachedData.list) {
			var station = this._cache._cachedData.list[j];
			if (station.id == m.options.owmId) {
				myWindroseDrawCanvas(station, this);
			}
		}
	}
}

/**
 * Example function to replace leaflet-openweathermap's builtin marker.
 */
function myOwmMarker(data) {
	// just a Leaflet default marker
	return L.marker([data.coord.lat, data.coord.lon]);
}

/**
 * Example function to replace leaflet-openweathermap's builtin popup.
 */
function myOwmPopup(data) {
	// just a Leaflet default popup
	return L.popup().setContent(typeof data.name != 'undefined' ? data.name : data.id);
}


/**
 * Initialize the map. openweathermap
 */
function initWeather() {
/* Basemap Layers */

// var mapquestOSM = L.tileLayer("https://{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png", {
//   maxZoom: 19,
//   subdomains: ["otile1-s", "otile2-s", "otile3-s", "otile4-s"],
//   attribution: 'Tiles courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="https://developer.mapquest.com/content/osm/mq_logo.png">. Map data (c) <a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> contributors, CC-BY-SA.'
// });
// var mapquestOAM = L.tileLayer("https://{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg", {
//   maxZoom: 18,
//   subdomains: ["otile1-s", "otile2-s", "otile3-s", "otile4-s"],
//   attribution: 'Tiles courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a>. Portions Courtesy NASA/JPL-Caltech and U.S. Depart. of Agriculture, Farm Service Agency'
// });
// var mapquestHYB = L.layerGroup([L.tileLayer("https://{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg", {
//   maxZoom: 18,
//   subdomains: ["otile1-s", "otile2-s", "otile3-s", "otile4-s"]
// }), L.tileLayer("https://{s}.mqcdn.com/tiles/1.0.0/hyb/{z}/{x}/{y}.png", {
//   maxZoom: 19,
//   subdomains: ["otile1-s", "otile2-s", "otile3-s", "otile4-s"],
//   attribution: 'Labels courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="https://developer.mapquest.com/content/osm/mq_logo.png">. Map data (c) <a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> contributors, CC-BY-SA. Portions Courtesy NASA/JPL-Caltech and U.S. Depart. of Agriculture, Farm Service Agency'
// })]);
var Esri_OceanBasemap = L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/Ocean_Basemap/MapServer/tile/{z}/{y}/{x}', {
  // attribution: 'Tiles &copy; Esri &mdash; Sources: GEBCO, NOAA, CHS, OSU, UNH, CSUMB, National Geographic, DeLorme, NAVTEQ, and Esri',
  maxZoom: 13
});

var CartoDB_DarkMatter = L.tileLayer('http://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png', {
  // attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="http://cartodb.com/attributions">CartoDB</a>',
  // subdomains: 'abcd',
  maxZoom: 19
});

//lalalalalla
	var mapquestUrl = "http://{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png",
		mapquestSubDomains = ["otile1","otile2","otile3","otile4"],
		mapquest = new L.TileLayer(mapquestUrl, {maxZoom: 18, subdomains: mapquestSubDomains});
	var aermapUrl = "http://{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.png";
	var aermap = new L.TileLayer(aermapUrl, {maxZoom: 18, subdomains: mapquestSubDomains});
	var mapquestHYB = L.layerGroup([L.tileLayer("https://{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg", {maxZoom: 18,subdomains: ["otile1-s", "otile2-s", "otile3-s", "otile4-s"]}), L.tileLayer("https://{s}.mqcdn.com/tiles/1.0.0/hyb/{z}/{x}/{y}.png", { maxZoom: 19, subdomains: ["otile1-s", "otile2-s", "otile3-s", "otile4-s"]	})]);
	var standard = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 18,});
	var esri = L.tileLayer("http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}.jpg", { maxZoom: 18	});

	// var primar = L.tileLayer.wms("http://primar.ecc.no/primar/wms_session", {    layers: 'cells',    format: 'image/png',    noWrap: true,    transparent: true    });

	// change here, convert json from DB, to list of array
	var clouds = L.OWM.clouds({opacity: 0.8, legendImagePath: 'http://map.comlu.com/openweathermap/files/NT2.png'});
	var cloudscls = L.OWM.cloudsClassic({opacity: 0.5});
	var precipitation = L.OWM.precipitation( {opacity: 0.5} );
	var precipitationcls = L.OWM.precipitationClassic({opacity: 0.5});
	var rain = L.OWM.rain({opacity: 0.5});
	var raincls = L.OWM.rainClassic({opacity: 0.5});
	var snow = L.OWM.snow({opacity: 0.5});
	var pressure = L.OWM.pressure({opacity: 0.4});
	var pressurecntr = L.OWM.pressureContour({opacity: 0.5});
	var temp = L.OWM.temperature({opacity: 0.5});
	var wind = L.OWM.wind({opacity: 0.5});

	var localLang = getLocalLanguage();

	// Get your own free OWM API key at http://www.openweathermap.org/appid - please do not re-use mine!
	// You don't need an API key for this to work at the moment, but this will change eventually.
	var OWM_API_KEY = '84f16e9a6d5aa76227fb107e44bfdf16';
	// var city = L.OWM.current({intervall: 15, imageLoadingUrl: 'http://sampleproject.url.ph/cuaca/owmloading.gif', lang: localLang, minZoom: 5,
	var city = L.OWM.current({intervall: 15, imageLoadingUrl: '/puskodal/assets/img/owmloading.gif', lang: localLang, minZoom: 5,		
			appId: OWM_API_KEY});
	// var station = L.OWM.current({type: 'station', intervall: 15, imageLoadingUrl: 'http://sampleproject.url.ph/cuaca/owmloading.gif', lang: localLang,
	var station = L.OWM.current({type: 'station', intervall: 15, imageLoadingUrl: '/puskodal/assets/img/owmloading.gif', lang: localLang,
			appId: OWM_API_KEY /* , markerFunction: myOwmMarker, popupFunction: myOwmPopup */ });
	// var windrose = L.OWM.current({intervall: 15, imageLoadingUrl: 'http://sampleproject.url.ph/cuaca/owmloading.gif', lang: localLang, minZoom: 4,
	var windrose = L.OWM.current({intervall: 15, imageLoadingUrl: '/puskodal/assets/img/owmloading.gif', lang: localLang, minZoom: 4,
			appId: OWM_API_KEY, markerFunction: myWindroseMarker, popup: false, clusterSize: 50,
   			imageLoadingBgUrl: 'http://openweathermap.org/img/w0/iwind.png' });
	windrose.on('owmlayeradd', windroseAdded, windrose); // Add an event listener to get informed when windrose layer is ready

	//testing
	// console.log("data city hahaha:");
	// console.log(city);


	var useGeolocation = false;
	var zoom = 5;
	var lat = -2.108899;
	var lon = 122.509766;
	var urlParams = getUrlParameters();
	if (typeof urlParams.zoom != "undefined" && typeof urlParams.lat != "undefined" && typeof urlParams.lon != "undefined") {
		zoom = urlParams.zoom;
		lat = urlParams.lat;
		lon = urlParams.lon;
		useGeolocation = false;
	}

	var baseMaps = {
		"<img src='../assets/img/3BS.png' width='50' height='47'></br>Ocean": Esri_OceanBasemap,
		"<img src='../assets/img/2BS.png' width='50' height='47'></br>Black": CartoDB_DarkMatter,
		"<img src='../assets/img/6BS.png' width='50' height='47'></br>Aerial View": aermap,
		"<img src='../assets/img/4BS.png' width='50' height='47'></br>OSM Standard": standard,
		"<img src='../assets/img/1BS.png' width='50' height='47' ></br>Mapquest Open": mapquest,
		// "<img src='../assets/img/7BS.png' width='50' height='47' ></br>ENC": primar,
		"<img src='../assets/img/5BS.png' width='50' height='47'></br>Aerial with Streets": mapquestHYB
	//	, "ESRI Aerial": esri
	};

	var overlayMaps = {};
	overlayMaps[getI18n('gopal', localLang)] = snow;
	overlayMaps[getI18n('clouds', localLang)] = clouds;
	overlayMaps[getI18n('cloudscls', localLang)] = cloudscls;
	overlayMaps[getI18n('precipitation', localLang)] = precipitation;
	overlayMaps[getI18n('precipitationcls', localLang)] = precipitationcls;
	overlayMaps[getI18n('rain', localLang)] = rain;
	overlayMaps[getI18n('raincls', localLang)] = raincls;
	overlayMaps[getI18n('snow', localLang)] = snow;
	
	overlayMaps[getI18n('temp', localLang)] = temp;
	overlayMaps[getI18n('windspeed', localLang)] = wind;
	overlayMaps[getI18n('pressure', localLang)] = pressure;
	overlayMaps[getI18n('presscont', localLang)] = pressurecntr;
	overlayMaps[getI18n('city', localLang) + " (min Zoom 5)"] = city;
	overlayMaps[getI18n('station', localLang) + " (min Zoom 7)"] = station;
	overlayMaps[getI18n('windrose', localLang)] = windrose;



	

	// var layerControl = L.control.layers(baseMaps, overlayMaps, {collapsed: true}).addTo(map);
	var layerControl = L.control.layers(baseMaps).addTo(map);

	// patch layerControl to add some titles
	
	// trakhir
	var patch = L.DomUtil.create('div', 'owm-layercontrol-header');
	patch.innerHTML = getI18n('maps', localLang); // 'Maps';	
	layerControl._form.children[0].parentNode.insertBefore(patch, layerControl._form.children[0]);
	// patch = L.DomUtil.create('div', 'leaflet-control-layers-separator');

	// patch.innerHTML = getI18n('windity', localLang); // 'windity';
	// layerControl._form.children[2].parentNode.insertBefore(patch, layerControl._form.children[5]); 
	// patch = L.DomUtil.create('div', 'owm-layercontrol-header');
	// patch.innerHTML = getI18n('layers', localLang); // 'TileLayers';
	// layerControl._form.children[2].parentNode.insertBefore(patch, layerControl._form.children[1]);
	// patch = L.DomUtil.create('div', 'leaflet-control-layers-separator');
	// layerControl._form.children[3].children[0].parentNode.insertBefore(patch, layerControl._form.children[3].children[layerControl._form.children[3].children.length-3]);
	// patch = L.DomUtil.create('div', 'owm-layercontrol-header');
	// patch.innerHTML = getI18n('current', localLang); // 'Current Weather';
	// layerControl._form.children[3].children[0].parentNode.insertBefore(patch, layerControl._form.children[3].children[layerControl._form.children[3].children.length-3]);
	// patch = L.DomUtil.create('div', 'owm-layercontrol-header');


	if (useGeolocation && typeof navigator.geolocation != "undefined") {
		navigator.geolocation.getCurrentPosition(foundLocation);
	}
}
