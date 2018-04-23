var connState;
var clusMarks = L.markerClusterGroup(); //---nambah clustered marker---gopal

function removeAIS(){		
	for (var mmsi in markerAIS) {
		clusMarks.removeLayer(markerAIS[mmsi]);
	}
}

function showAIS(stat){
	map.addLayer(clusMarks); //---nambah clustered marker---gopal

	if(stat){
		stat_view.ais = true;		

		connectAIS(function(){
			processAISData();	
		});
				
	}else{
		stat_view.ais = false;
		disconnectAIS();
		removeAIS();		
	}
}

function isEmptyObject(obj) {
	for (var key in obj) {
		if (Object.prototype.hasOwnProperty.call(obj, key)) {
		  return false;
		}
	}
	return true;
}		

/*  
	kondisi berhenti pakai wajik .
		icon :  kuning : not complete 
				ijo : complete

	moveend : 
		1. cek , iterasi array. 
		jika masuk bound, masukin ke layer.
		

	kondisi berhenti (wajik) : 
		status : 1,5,6
		sog : 0 atau 102.3

*/

/**isStopping
	@brief check if AIS vessel stopping.
	@param Boolean status navigation status
	@param Float sog Speed Over Ground

	@return boolean true if stopping. false otherwise;
*/
function isStopping(status, sog){

	if(status == '1' || status == '5' 
		|| status == '6' || sog <= 0 || sog >= 102.3){

		return true;
	}

	return false;
}

function navStatus (status) {
	var nav_status = "";
	if (status == "0")
		nav_status = "Under way using engine";
	else if (status == "1")
		nav_status = "At anchor";
	else if (status == "2")
		nav_status = "Not under command";
	else if (status == "3")
		nav_status = "Restricted manoeuverability";
	else if (status == "4")
		nav_status = "Constrained by her draught";
	else if (status == "5")
		nav_status = "Moored";
	else if (status == "6")
		nav_status = "Aground";
	else if (status == "7")
		nav_status = "Engaged in Fishing";
	else if (status == "8")
		nav_status = "Under way sailing";
	
	return nav_status;
}

function disconnectAIS(){
	
	if(aisSocket != null){		 
		aisSocket.disconnect(); 
		console.log("Disconnecting AIS");
		
		clearInterval(connState);
		// aisSocket = null;
		AISDisconnected();
	}
}

function connectAIS(fn){

	if(aisSocket == null){
		aisSocket = io.connect(conf.aisSocket);

		AISConnecting();

		// if(aisSocket == null){ // added by SKM17
		// 	console.log("reconnecting AIS");
																																																																																																																																									// 	reconnectAIS();												
		// }else {
		// 	console.log("AIS connected!");
		// 	fn();
		// }																																					
		fn();
																																																																																																																																																																																																																									} else {					
		aisSocket.socket.reconnect();
	}

}

function AISDisconnected(){																																																																																																																																																																	
	var n = noty({
		layout:'topCenter',
		text: "Koneksi dengan data AIS ditutup", 
		type : "alert",
		timeout:3000
	});
}

function AISConnecting(){
	console.log("AIS Connecting");

	var n = noty({
		layout:'topCenter',
		text: "Mencoba membangun koneksi dengan data AIS", 
		type : "alert",
		timeout:5000
	});
}

function AISConnected(){
	var n = noty({
		timeout:2000,
		layout:'topCenter',
		text: "Koneksi ke data AIS sukses dibangun", 
		type : 'success',
		maxVisible : 1
	});
	clearInterval(connState);
}

function reconnectAIS(){
	if(!aisSocket.socket.connected){
		connState = setInterval(function(){
			var n = noty({
				timeout : 2000,
				layout:'topCenter',
				text: "Kembali mencoba membangun koneksi dengan data AIS", 
				type : 'alert',
				maxVisible : 1
			});
			// if(aisSocket!=null){ // commented by SKM17
			if(aisSocket==null){ // added by SKM17
				aisSocket.socket.reconnect();
			}else{
				clearInterval(connState);
			}
		}, 5000);
	}
}

var iconGue;

function pilihIcon(data){
	// console.log(data.jenis);
	if (data.nav_status == 1 || data.nav_status == 5 || data.nav_status == 6){ //sandar
		if (data.jenis == 52)																											{ iconGue = tug_sandar;} 
		else if (data.jenis == 40 || data.jenis == 41 || data.jenis == 42 || data.jenis == 43 || data.jenis == 44)						{ iconGue = highspeed_sandar;} 
		else if (data.jenis == 60 || data.jenis == 61 || data.jenis == 62 || data.jenis == 63 || data.jenis == 64 || data.jenis == 69)	{ iconGue = passenger_sandar;} 
		else if (data.jenis == 70 || data.jenis == 71 || data.jenis == 72 || data.jenis == 73 || data.jenis == 74)						{ iconGue = cargo_sandar;} 
		else if (data.jenis == 80 || data.jenis == 81 || data.jenis == 82 || data.jenis == 83 || data.jenis == 84)						{ iconGue = tanker_sandar;} 
		else if (data.jenis == 35 || data.jenis == 36)																					{ iconGue = fishing_sandar;} 
		else if (data.jenis == 37)																										{ iconGue = yacht_sandar;} 
		else 																															{ iconGue = other_sandar; }
	} else { //layar
		if (data.jenis == 52)																											{ iconGue = tug_layar;	} 
		else if (data.jenis == 40 || data.jenis == 41 || data.jenis == 42 || data.jenis == 43 || data.jenis == 44)						{ iconGue = highspeed_layar;} 
		else if (data.jenis == 60 || data.jenis == 61 || data.jenis == 62 || data.jenis == 63 || data.jenis == 64 || data.jenis == 69)	{ iconGue = passenger_layar;} 
		else if (data.jenis == 70 || data.jenis == 71 || data.jenis == 72 || data.jenis == 73 || data.jenis == 74)						{ iconGue = cargo_layar;} 
		else if (data.jenis == 80 || data.jenis == 81 || data.jenis == 82 || data.jenis == 83 || data.jenis == 84)						{ iconGue = tanker_layar;} 
		else if (data.jenis == 35 || data.jenis == 36)																					{ iconGue = fishing_layar;} 
		else if (data.jenis == 37)																										{ iconGue = yacht_layar;} 
		else 																															{ iconGue = other_layar; }
	}
}

function gantilabel(data){
	if (data.namakapal == '' || data.namakapal == null || data.namakapal == undefined){
		return data.mmsi;
	} else {
		return data.namakapal;
	}
}	

function processAISData(){	
	console.log("process AIS data called... ");

	aisSocket.on('replyInfo', function (data) {
		// console.log("data:", data);
	
		$('#side-ais').hide();
		$("#ship-info-ais").empty();

		var aisInfoBox = "";
		if (data.namakapal) {						
			// if(data.photo != null && data.photo != ''){
			// 	aisInfoBox += '<li> <label><img src="images/' + data.photo + '" width="215"></li>';	
			// }				
			aisInfoBox += '<li> ' + data.namakapal+' </li>';
			aisInfoBox += '<li> <label>MMSI: </label> ' + data.mmsi+'</li>';
			aisInfoBox += '<li> <label>NO IMO: </label> ' + data.noimo+'</li>';
			aisInfoBox += '<li> <label>Jenis Kapal: </label> ' + data.jeniskapal+'</li>';
			aisInfoBox += '<li> <label>Posisi: </label><br>Lintang: ' + getDegMinSec(data.lat) + '<br>Bujur: </label> ' + getDegMinSec(data.long)+'</li>';
			aisInfoBox += '<li> <label>Status: </label> ' + navStatus(data.nav_status)+'</li>';
			aisInfoBox += '<li> <label>Cepat: </label> ' + data.sog + ' knots</li>';
			aisInfoBox += '<li> <label>Heading: </label> ' + data.hdg + '°</li>';
			aisInfoBox += '<li> <label>Course: </label> ' + data.cog + '°</li>';
			aisInfoBox += '<li> <label>Jam: </label> ' + data.timestamp+'</li>';
		} else {
			// aisInfoBox += '<li> Nama Kapal: &nbsp;&nbsp; - &nbsp;&nbsp; </li>';
			aisInfoBox += '<li> ' + data.mmsi+' </li>';
			aisInfoBox += '<li> <label>Posisi: </label> Lintang: ' + getDegMinSec(data.lat) + ' Bujur: ' + getDegMinSec(data.long)+'</li>';
			aisInfoBox += '<li> <label>Status: </label> ' + navStatus(data.nav_status) + '</li>';
			aisInfoBox += '<li> <label>Kecepatan: </label>' + data.sog + ' knots</li>';
			aisInfoBox += '<li> <label>Heading: </label> ' + data.hdg + '°</li>';
			aisInfoBox += '<li> <label>Course: </label> ' + data.cog + '°</li>';
			aisInfoBox += '<li> <label>Jam: </label> ' + data.timestamp+'</li>';
		}

		$("#ship-info-ais").html(aisInfoBox);
		$('#side-ais').animate({width:'toggle'}, 150); 
		aisInfoBox = null;
	}); 

	aisSocket.on('dataAIS', function (data) {
		// console.log("on dataAIS ", data);		

		//miih icon berdasarkan sandar/layar dan jenis ship
		pilihIcon(data);

		// ngehandle data masuk, cek valid ga lat lon-nya sblm jadi marker
		if(data.lat != undefined && data.lat != null  && data.long != undefined && data.long != null) 
		{
			// cek kalo data baru / lama
			if (markerAIS[data.mmsi]) { //ini data lama, update posisi				
				clusMarks.removeLayer(markerAIS[data.mmsi]); // remove yg lama				
			}

			var sudut = parseFloat(data.hdg);
			if (data.hdg == undefined || data.hdg == 'NULL' || data.hdg == 'null' || data.hdg == null || data.hdg == '')
				sudut = parseFloat(data.cog);

			// masukin yg baru, 				
			newMarker = new L.marker ([data.lat, data.long], {				
				title: data.mmsi,
				mmsi: data.mmsi,
				nav_status: data.nav_status,
				rot: data.rot,
				sog: data.sog,
				pos_acc: data.pos_acc,
				lat: data.lat,
				long: data.long,
				cog: data.cog,
				hdg: data.hdg,
				raim: data.raim,
				timestamp: new Date(),
				icon: iconGue,
				iconAngle: sudut
			})
			.update()
			.bindLabel(gantilabel(data), { noHide: true })
			.addTo(clusMarks)
			.on('click', function(){
				onAISClick(this);
			});				
			newMarker.setIconAngle(sudut);
			markerAIS[data.mmsi] = newMarker;
		}
	}); // tutup aisSocket.on

	aisSocket.on('dataARPA', function (data) {
		// cek kalo data baru / lama
		if (markerARPA[data.id]) { //ini data lama, update posisi				
			clusMarks.removeLayer(markerARPA[data.id]); // remove yg lama				
		}

		var labelARPA;
		if (data.name == "-")
			labelARPA = data.id;
		else
			labelARPA = data.name;

		// masukin yg baru, 				
		var newMarker = L.marker([data.lat,data.long],{
			icon: data_arpa,
			id: data.id,
			radar_loc: data.radar_loc,
			lat: data.lat,
			long: data.long,
			sog: data.sog,
			cog: data.cog,
			name: data.name,
			iconAngle: data.cog
		})     
		.update()
		.bindLabel(labelARPA, { noHide: true })
		.addTo(clusMarks)
		.on('click', function(e){ 				
			$('#side-arpa').hide();	
			$("#ship-info-arpa").empty();	

			$("#ship-info-arpa").html(
				'<li>ID : '+ data.id +'</li>' +										
				'<li><label>Name :</label><br />'+ data.name+'</li>' +
				'<li><label>Lat : </label><br />' + data.lat + '</li>' +
				'<li><label>Lon :</label><br />'+ data.long+'</li>' +										
				'<li><label>Radar position : </label><br />' + data.radar_loc + '</li>' +
				'<li><label>Speed : </label><br />' + data.sog + ' knots</li>' +
				'<li><label>Course : </label><br />' + data.cog + '°</li>' 
			);
			$('#side-arpa').animate({width:'toggle'}, 150);
		});				
		markerARPA[data.id] = newMarker;
	});
}

// menampilkan informasi kapal jika marker tertentu di-click
function onAISClick(thisObj) { 
	// console.log("thisObj: ", thisObj);
	
	if (aisSocket) {
		aisSocket.emit('askInfo', {mmsi: thisObj.options.mmsi });

	} else{
		alert('Info AIS tidak dapat ditampilkan karena tidak terhubung ke data AIS');
	}
}

function getNewLat (lat, distance, brn) {
	var d = distance; //in kilometers

	brn *= TO_RAD;

	var lat1 = lat * TO_RAD; //latitude in degrees
	var lat2 = Math.asin (Math.sin (lat1) * Math.cos (d / EARTH_RADIUS_DM) +
					Math.cos (lat1) * Math.sin (d / EARTH_RADIUS_DM) * Math.cos (brn));

	lat2 /= TO_RAD;
	return lat2;
}

function getNewLon (lon, lat1, distance, brn) {
	var d = distance; // in DM

	brn *= TO_RAD;
	lat1 *= TO_RAD;
	var lat2 = Math.asin (Math.sin (lat1) * Math.cos (d / EARTH_RADIUS_DM) +
					Math.cos (lat1) * Math.sin (d / EARTH_RADIUS_DM) * Math.cos(brn));
	var lon1 = lon * TO_RAD; //longitude in degrees
	var lon2 = lon1 + Math.atan2 (Math.sin(brn) * Math.sin (d / EARTH_RADIUS_DM) * Math.cos (lat1),
								Math.cos (d / EARTH_RADIUS_DM) - Math.sin(lat1) * Math.sin(lat2));
	lon2 /= TO_RAD;
	return lon2;
}

function getDegMinSec (decimal) {
	var minus = false;
	if (decimal < 0) {
		minus = true;
		decimal *= -1;
	}
	var deg = Math.floor(decimal);
	var temp = (decimal - deg) * 60;
	var minute = Math.floor(temp);
	var sec = Math.round((temp - minute) * 60);
	
	var degMinSec = '';
	if (minus) degMinSec = '-';
	degMinSec += deg + "° " + minute + "\' " + sec + "\"";
	
	return degMinSec;
}
