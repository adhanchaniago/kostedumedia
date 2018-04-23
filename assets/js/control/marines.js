function getMarines(fn)
{
	socket.emit('reqMarines', {});
	socket.once('resMarines', function (data) {
		fn(data);
	});
}

function showMarines(stat)
{
	if (stat) {
		if (markerAdditional['marine']!=undefined) {
			map.addLayer(markerAdditional['marine']);
		}
		else {
			getMarines(function(dataMarine){
				var tempMarine = [];
				
				if (dataMarine!=null && dataMarine.length > 0) {
					$.each(dataMarine,function(i,item){
						if (item.mardis_in_ops && item.mardis_lat!=undefined && item.mardis_lon!=undefined) {
							item.mardis_lat = parseFloat(item.mardis_lat);
							item.mardis_lon = parseFloat(item.mardis_lon);
							// added by SKM17
							var personnel = item.mardis_personnel;
							if (!personnel) personnel = '-';
						
							var matpur = item.mardis_matpur;
							if (!matpur) matpur = '-';
						
							var location = item.mardis_location;
							if (!location) location = '-';
						
							var mardisImage = '';
							if (item.mardis_image != null && item.mardis_image != '') {
								mardisImage = '<li> <img src="' + conf.url + 'assets/img/upload/main/marinir/' + item.mardis_image + '" height="125" width="215" alt=""> </li>';
							}
							
							var theIcon = IconMarine;
							if (item.maricon_file != null && item.maricon_file != '') {
								theIcon = new ShipIcon(
									{iconUrl: conf.url+'assets/img/icon-marine/'+item.maricon_file}
								);
							}
							
							// revised by SKM17
							tempMarine.push(
								L.marker(
									[item.mardis_lat,item.mardis_lon],
									{icon:theIcon}).bindLabel(
										'<p align="center">'+item.operation_name+'<br />'+viewableCoordinate(item.mardis_lat,'lat')+
										' , '+viewableCoordinate(item.mardis_lon,'lon')+'</p>'
									).on('contextmenu',function(e){
										onClickMeasuring(item.mardis_lat, item.mardis_lon);
									}).on('click',function(e){
									
										$('#side-satgas').hide();
										$("#ship-info-satgas").empty();
										$("#ship-info-satgas").html('<li>'+item.operation_name+'</li>'+
											mardisImage +
											'<li><label>Kodal :  </label><br />'+item.mardis_dpp+'</li>'+
											'<li><label>Posisi :  </label><br />'+viewableCoordinate(item.mardis_lat,'lat')+' , '+viewableCoordinate(item.mardis_lon,'lon')+'</li>'+
											'<li><label>Lokasi :  </label><br />'+location+'</li>'+
											'<li><label>Personil :  </label><br />'+personnel+'</li>'+
											'<li><label>Matpur :  </label><br />'+matpur+'</li>'
										  );
										$('#side-satgas').animate({width:'toggle'}, 150);
									})
								);
							}
						});
					markerAdditional['marine'] =  L.layerGroup(tempMarine);
					map.addLayer(markerAdditional['marine']);
					tempMarine = null;
				}
			});
		}
	}
	else {
		if(markerAdditional['marine']!=undefined){
			map.removeLayer(markerAdditional['marine']);
		}
	}
}
