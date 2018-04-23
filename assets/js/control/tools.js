/**
	available tools on puskodal maps app.
	- 
*/

/*
	definition of : distance measure tools
*/
function popup_distance(distance, coord,start_pos,stop_pos) {
	start_pos = start_pos || "";
	stop_pos = stop_pos || "";
	var baringan, totjar = ""; 
	if (!distancePopup) {
		distancePopup = new L.Popup(this.options, this);
	}
	var miles = parseFloat((distance/1000) * 0.539957);
	if(start_pos!="" && stop_pos!=""){
		baringan = "<b>Baringan: </b><br />"+calculate_bearing(start_pos,stop_pos)+"<br />";
	}
	


	if(!isMeasuring){
		// distancePopup.setContent("<b>Jarak: </b></br>"+miles.toFixed(2)+"nmi<br />"+baringan+"<input type='button' onclick='hapus_jarak();' value='Hapus Jarak' />");
		totalJarak = totalJarak+miles;
		totjar = "<b>Total Jarak Semua Garis: </b><br />"+totalJarak.toFixed(2)+"nmi<br />";
		distancePopup.setContent("<b>Jarak: </b></br>"+miles.toFixed(2)+"nmi<br />"+totjar+baringan);	
	}
	else if(isMeasuring ){
		distancePopup.setContent("<b>Jarak: </b></br>"+miles.toFixed(2)+"nmi<br />"+baringan);
	}

	distancePopup.setLatLng(coord);
	baringan = null;
	miles = null;
}

// function putMeasureBend(lat, lng){
// 	console.log('you click me..');
// 	console.log('measuring : '+isMeasuring);
// 	if(stat_ukur_jarak && isMeasuring){
// 		var bend = new L.Marker([lat, lng]);
// 		measureBends.push(bend);

// 		map.addLayer(bend);

// 		console.log(start_lat);

// 		var line = new L.Polyline([start_lat, new L.LatLng(lat, lng)],
// 					{color:'red', weight:1});
		
// 		line.setLatLngs([start_lat,new L.LatLng(lat,lng)]);
// 		measureLines.push(line);

// 		map.addLayer(line);
// 		start_lat.lat =  lat;
// 		start_lat.lng = lng;	   
// 	}		
// }

var totalJarak = 0;
var allPolylines = [];
isMeasuring = false;

function onClickMeasuring(lat,lon){
	lat = parseFloat(lat);
	lon = parseFloat(lon);
	// console.log('tools status ukur jarak : '+stat_ukur_jarak);
	// console.log('tools measuring status : '+isMeasuring);
	if(stat_ukur_jarak){
		if(!isMeasuring){
			// console.log('if pertama');
			isMeasuring = true;
			measuring_line = new L.Polyline(
								[new L.LatLng(lat,lon),new L.LatLng(lat,lon)], 
								{color: 'red',weight:4}
								).addTo(map);
			// measuring_line.bindPopup("ini jarak gue");
			// measuring_line.bindLabel('history pesud: ');
			allPolylines.push(measuring_line);

			start_lat = new L.LatLng(lat,lon);
			// measureBends = new Array();
			// measureLines  = new Array();
		}
		else {
			/*do line measurement.*/
			// console.log('if kedua (else)');
			isMeasuring = false;
			
			measuring_line.setLatLngs([start_lat,new L.LatLng(lat,lon)]);
			var centerPos = new L.LatLng((start_lat.lat + lat)/2, 
			(start_lat.lng + lon)/2);

			var distance = start_lat.distanceTo(new L.LatLng(lat,lon));
			var miles = parseFloat((distance/1000) * 0.539957);

			popup_distance(distance, centerPos,start_lat,new L.LatLng(lat,lon));
			measuring_line.bindLabel('<b>jarak: </b>'+ miles.toFixed(2)+'nmi</br>'+
									 '<b>baringan: </b>'+ calculate_bearing(start_lat,new L.LatLng(lat,lon))
									 ,{noHide:true, direction: 'auto' });
			map.addLayer(distancePopup)
				.fire('popupopen', { popup: distancePopup })
				.on('popupclose',function(e){hapus_jarak()});

			distance = null;
			centerPos=null;
		}
	}

	// console.log('measuring status : '+isMeasuring);
}

function hapus_jarak(){
	isMeasuring = false;
	start_lat = null;
	start_lon = null;

	//gopalgopel
	totalJarak = 0;

	for (var i=0; i<allPolylines.length; i++){
		map.removeLayer(allPolylines[i]);
	}
	// if(measuring_line!=null){
		// map.removeLayer(measuring_line);
	// }

	measuring_line = null;
	if(distancePopup!=null){
		// map.removeLayer(distancePopup);
		distancePopup = null;
	}
	// distancePopup = null;

	// for(var idx in measureBends){
	// 	map.removeLayer(measureBends[idx]);	
	// }
	// for(var idx in measureLines){
	// 	map.removeLayer(measureLines[idx]);	
	// }

	// measureBends = null;
	// measureLines  = null;
	
}

/*
[end of] definition of : distance measure tools
*/
