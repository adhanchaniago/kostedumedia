
/** marker switch */
function showKRIShip(stat){
	if (stat) {
		stat_view.kri = true; 
	} else {
		stat_view.kri = false; 
	}

	refreshShipView();
}

function showTargetShip(stat) {
	if (stat) {
		stat_view.track = true;
	} else {
		stat_view.track = false;
		if (markerTrack!=null) {
			removeTrack();
		}
		markerTrack=null;
	}

	refreshShipView();
}


function showIntelligentInfo(stat){

	getIntelegentInfo();

	tempIntelegent = [];

	if(stat){
		stat_view.intelegent = true;
		if(markerPoi.length>0){
			for(var i in markerPoi){
				markerPoi[i].setOpacity(1);
			}
		}
		if(circle_area.length>0){
			for(var i in circle_area){
				circle_area[i].setStyle({'fillOpacity':0.5});
			}
		}   
		if(polygon_area.length>0){
			for(var i in polygon_area){
				polygon_area[i].setStyle({'fillOpacity':0.5});
			}
		}
	}else{
		stat_view.intelegent = false;
		if(markerPoi.length>0){
			for(var i in markerPoi){
				markerPoi[i].setOpacity(0);
			}
		}
		if(circle_area.length>0){
			for(var i in circle_area){
				circle_area[i].setStyle({'fillOpacity':0});
			}
		}
		if(polygon_area.length>0){
			for(var i in polygon_area){
				polygon_area[i].setStyle({'fillOpacity':0});
			}
		}
	}
	tempIntelegent = null;
}

function showChat(stat){
	if(stat){

	}else{

	}
}



function showLapsitharForm(stat){
	if(stat){

	}else{

	}
}

function showGenericMarker(category_id){

	if(generic_marker_data!=null){
		map.removeLayer(generic_marker_data);
		generic_marker_data = null;
	}
	socket.emit('reqGenericMarker', {'markerCategory':category_id});
	socket.on('resGenericMarker', function (data) {
		console.log('generic marker');
		if(data.length>0){
			if(generic_marker_data!=null){
				map.removeLayer(generic_marker_data);
				generic_marker_data = null;
			}
			generic_marker_data = new L.LayerGroup();
			var dataGenericMarker = null;
			for(var i in data){
				dataGenericMarker = data[i].fetch_generic_marker;
			}
			dataGenericMarker = eval('('+dataGenericMarker+')');
			$.each(dataGenericMarker,function(i,item){
				console.log(item);
				if(item.type=="circle"){
					new L.circle([parseFloat(item.lat), parseFloat(item.lon)], parseFloat(item.rad),{color:"red",weight:1,fillOpacity:0.5}).bindPopup(item.name).addTo(generic_marker_data);
				}
				else if(item.type=="polygon"){
					temp_path = [];
					var path_bound = new Array();
					$.each(item.points,function(j,path){
						temp_path.push([parseFloat(path.lat),parseFloat(path.lon)]);
						path_bound.push({lat:parseFloat(path.lat),lng:parseFloat(path.lon)});
					});
					new L.Polygon(temp_path,{color:"red",weight:1,fillOpacity:0.5}).bindPopup(item.name).addTo(generic_marker_data);
					temp_path = [];
				}else if(item.type=="point"){
					new L.marker([parseFloat(item.lat), parseFloat(item.lon)]).bindPopup(item.name).addTo(generic_marker_data);
				}
			});
			map.addLayer(generic_marker_data);
			dataGenericMarker = null;
		}
	});
}

function cleanGenericMarker(){
	if(generic_marker_data!=null){
		map.removeLayer(generic_marker_data);
		generic_marker_data = null;
		console.log(generic_marker_data);
		console.log("generic_marker_data ga NULL");
	} else console.log("generic_marker_data NULL");
}


function refreshShipView(){
	if (stat_view.kri) {
		socket.emit('reqSubscribe',{mode:'kri'});
	} else {
		socket.emit('reqUnsubscribe',{mode:'kri'});
	}

	if (stat_view.track) {
		socket.emit('reqSubscribe',{mode:'track'});
	} else {
		socket.emit('reqUnsubscribe',{mode:'track'});
	}
		// else if(stat_view.kri==false && stat_view.track==true){
		//	 socket.emit('reqUnsubscribe',{mode:'kri'});
		//	 // socket.emit('reqUnsubscribe',{mode:'all'});
		//	 socket.emit('reqSubscribe',{mode:'track'});
			
		//	 console.log('track');
		// }
	// commented temporary by SKM17 jejak
	/* dikomen dulu nyobain lojik lain
	 for(var i in markerKRI){
		 if(stat_view.kri==true && (markerKRI[i]!=undefined || markerKRI[i]!=null )){
			 markerKRI[i].setOpacity(1);
			 
		 }else if(stat_view.kri==false && (markerKRI[i]!=undefined || markerKRI[i]!=null )){
			 markerKRI[i].setOpacity(0);
			 
			 markerKRI[i].unbindLabel();
			 console.log('set opac 0');
		 }
	 }
	 */
	if (stat_view.kri) {
		for (var i in markerKRI) {
			if (markerKRI[i]!=undefined || markerKRI[i]!=null)
				map.addLayer(markerKRI[i]);
		}
	} else {
		for (var i in markerKRI) {
			map.removeLayer(markerKRI[i]);
		}
	}
}

function refreshAISView(){

	for(var i in markerAIS){
		if(stat_view.ais == true && (markerAIS[i]!=undefined || markerAIS[i]!=null )){
			markerAIS[i].setOpacity(1);
			markerAISdata[i].view=true;
		}else if(stat_view.ais == false && (markerAIS[i]!=undefined || markerAIS[i]!=null )){
			markerAIS[i].setOpacity(0);
			markerAISdata[i].view=false;
			markerAIS[i].unbindLabel();
		}
	}
}

function goToBackend(){
   
}
