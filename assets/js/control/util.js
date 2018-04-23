/*small utilities functions*/
function activateFeature(featureId, fn){
	
	$(featureId).click(function(){
		fn(!$(featureId).hasClass('nyala'));
	});
}

function removeLayer(id) {
console.log("removeLayer " + id);
	map.removeLayer(markersLayer[id]);			  
}

function removeTrack() {
	map.removeLayer(markerTrack);			   
}

function cleanInfoPanel(){
	$('#ship-info').empty();
	$('#ship-personnel').empty();
	$('#ship-logistic').empty();
	$('#ship-ado').empty();
}

function removeAdditional(name){
	map.removeLayer(name);
}

function calculate_bearing(start_pos,stop_pos){
	var lat1 = Geo.parseDMS(start_pos.lat);
	var lon1 = Geo.parseDMS(start_pos.lng);
	var lat2 = Geo.parseDMS(stop_pos.lat);
	var lon2 = Geo.parseDMS(stop_pos.lng);
	var p1 = new LatLon(lat1, lon1);
	var p2 = new LatLon(lat2, lon2);
	lat1=null;lat2=null;lon1=null;lon2=null;
	return Geo.toBrng(p1.bearingTo(p2),'dm');
	p1=null;p2=null;
}

function viewableCoordinate(deg,type){
	var sign = '';
	if(type=='lat'){
		var result = Geo.toLat(deg,'dms',0);
	}else{
		var result = Geo.toLon(deg,'dms',0);
	}

	return sign+result;
	sign=null;result=null;
}

function checkContainLatlngCircleArea(marker,i){
	if (i=='') {
		for (var i in circle_area) {
			var text = '';

			var param = {
				circleLat : circle_area[i]._latlng.lat,
				circleLon : circle_area[i]._latlng.lng,
				circleRad : (circle_area[i].getRadius()/1000),
				lat : marker._latlng.lat,
				lon : marker._latlng.lng
			};
		
			if(isPointInCircle(param.circleLat,param.circleLon,param.circleRad,param.lat,param.lon)){
				text += marker.options.title+', ';
			}
		
	
			if(text!=""){
				text.substr(-2);
				text +=' berada di wilayah '+data_area_circle[i].aoi_name+'';
				messageWarning(text);
			}
			text = null;
			param = null;
		}
	}
	else {
		var text = '';

		var param = {
			circleLat : circle_area[i]._latlng.lat,
			circleLon : circle_area[i]._latlng.lng,
			circleRad : (circle_area[i].getRadius()/1000),
			lat : marker._latlng.lat,
			lon : marker._latlng.lng
		};
		
		if(isPointInCircle(param.circleLat,param.circleLon,param.circleRad,param.lat,param.lon)){
			text += marker.options.title+', ';
		}
	

		if(text!=""){
			text.substr(-2);
			text +=' berada di wilayah '+data_area_circle[i].aoi_name+'';
			messageWarning(text);
		}
		text = null;
		param = null;
	}
}

function checkContainLatlngPolygonArea(marker,i){
	if(i==''){
		for(var i in polygon_area){
			var text = '';
		
			if(polygon_area[i].getBounds().contains(marker._latlng)){
				text += marker.options.title+', ';
			}
	
			if(text!=''){
				text.substr(-2);
				text +=' berada di wilayah '+data_area[i].aoi_name+'';
				messageWarning(text);
			}
			text = null;
		}
	}
	else {
		var text = '';
	
		if(polygon_area[i].getBounds().contains(marker._latlng)){
			text += marker.options.title+', ';
		}

		if(text!=''){
			text.substr(-2);
			text +=' berada di wilayah '+data_area[i].aoi_name+'';
			messageWarning(text);
		}
		text = null;
	}
}

function messageWarning(text){
	if(text!=''){
		$.jGrowl(text, { 
			header: 'Peringatan !!',
			theme: 'warning',
			speed: 'slow',
			animateOpen: { 
				height: "show"
			},
			animateClose: { 
				height: "hide"
			}
		});
	}
}

function isPointInCircle(centerX,centerY,radius,x,y)
{
	var R = 6371; // Radius of the Earth in km
	var dLat = (x - centerX) * Math.PI / 180;
	var dLon = (y - centerY) * Math.PI / 180;
	var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
		Math.cos(centerX * Math.PI / 180) * Math.cos(x * Math.PI / 180) *
		Math.sin(dLon / 2) * Math.sin(dLon / 2);
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
	var d = R * c;
	R = null;dLat=null;dLon=null;a=null;c=null;
	if( d < radius ){
		d = null;
		radius = null;
		return true;
	}
	d = null;
	radius = null;
	return false;
}


var regEx = new RegExp(/^[0-9]{1,45}$/);
function validDegree(event,name){
	var charr = String.fromCharCode( event.keyCode );
	var string = $( "."+name+"" ).val() + charr;
	if(string.match( regEx ) && parseInt(string) <= 360) {
		return true;
	}else{
		return false;
	}
}
function validMinuteSecond(event,name){
	var charr = String.fromCharCode( event.keyCode );
	var string = $( "."+name+"" ).val() + charr;
	if(string.match( regEx ) && parseInt(string) <= 59) {
		return true;
	}else{
		return false;
	}
}

function find(arr) {
	var result = [];

	for (var i in arr) {
		if (arr[i].match(/oo/)) {
			result.push(arr[i]);
		}
	}

	return result;
	result = null;
}
