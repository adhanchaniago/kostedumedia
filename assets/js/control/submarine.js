
function getSubmarine(){

	socket.emit('reqSubmarine', {});
	socket.once('resSubmarine', function (data) {
		dataSubmarine = data;
	});
}

function showSubmarine(stat){

	getSubmarine();

	tempSubmarine = [];
	if(stat){
		stat_view.submarine = true;
		if(markerAdditional['submarine']!=undefined){
			removeAdditional(markerAdditional['submarine']);
		}
		if(dataSubmarine!=null && dataSubmarine.length > 0){
			$.each(dataSubmarine,function(i,item){
				item.ship_lat = parseFloat(item.ship_lat);
				item.ship_lon = parseFloat(item.ship_lon);
				tempSubmarine.push(
					L.marker(
						[item.ship_lat,item.ship_lon],
						{icon:IconSubmarine}).bindLabel(
							'<p align="center">'+item.ship_name+'<br />'+viewableCoordinate(item.ship_lat,'lat')+
							' , '+viewableCoordinate(item.ship_lon,'lon')+'</p>'
						).on('contextmenu',function(e){
							onClickMeasuring(item.ship_lat,item.ship_lon);
						}).on('click',function(e){
						
							$('#side-right').hide();
							cleanInfoPanel();
							$("#ship-info").append('<li>'+item.ship_name+'-'+item.ship_id+'</li>'+
							'<li><label>Posisi :  </label><br />'+viewableCoordinate(item.ship_lat,'lat')+' , '+viewableCoordinate(item.ship_lon,'lon')+'</li>'+
							'<li><label>Halu :  </label><br />'+item.ship_direction+'</li>'+
							'<li><label>Cpt :  </label><br />'+item.ship_speed+' Knott</li>'
							);
							$('#side-right').animate({width:'toggle'}, 150);
						})
					);
				});
			markerAdditional['submarine'] =  L.layerGroup(tempSubmarine);
			map.addLayer(markerAdditional['submarine']);
			tempSubmarine = null;
		}
	}else{
		stat_view.submarine = false;
		if(markerAdditional['submarine']!=undefined){
			removeAdditional(markerAdditional['submarine']);
		}
	}
}
