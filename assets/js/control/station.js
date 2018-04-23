
function getStation(fn)
{
	socket.emit('reqStation', {});
	socket.once('resStation', function (data) {
		fn(data);
	});
}

function getStationLogistic(id, fn){
	$("#ship-info-pangkalan").empty();
	$("#ship-ado").empty();
	$("#ship-personnel").empty();
	$("#ship-logistic").empty();
	socket.emit('reqStationLogistic', { stationId: id });
	socket.once('resStationLogistic', function (data) {
		fn(data);
	});
}

function showLandStation(stat)
{
	if(stat){
		if(markerAdditional['station']!=undefined){
			map.addLayer(markerAdditional['station']);
		} 
		else {
			getStation(function(dataStation){

				var tempStation = [];
				if(dataStation!=null && dataStation.length > 0){
					$.each(dataStation,function(i,item)
					{
						console.log("ini station:", item)
						item.station_lat = parseFloat(item.station_lat);
						item.station_lon = parseFloat(item.station_lon);

						var stationLocation = '-'; // added by SKM17
						if (item.station_location != null && item.station_location != '')
							stationLocation = item.station_location;
						var labelItem = '<p align="center">'+item.station_name+'<br />Lokasi: ' + stationLocation + '</p>';
							
						// added by SKM17 {
						var stationImage = ''; // added by SKM17
						if (item.station_image != null && item.station_image != '') {
							stationImage = '<li> <img src="' + conf.url + 'assets/img/upload/main/pangkalan/' + item.station_image + '" height="125" width="215" alt=""> </li>';
						}
						var sandarImage = ''; // added by SKM17
						if (item.station_fac_sandar_image != null && item.station_fac_sandar_image != '') {
							sandarImage = '<li> <img src="' + conf.url + 'assets/img/upload/main/pangkalan/fac_sandar/' + item.station_fac_sandar_image + '" height="125" width="215" alt=""> </li>';
						}
						var bekalImage = ''; // added by SKM17
						if (item.station_fac_perbekalan_image != null && item.station_fac_perbekalan_image != '') {
							bekalImage = '<li> <img src="' + conf.url + 'assets/img/upload/main/pangkalan/fac_perbekalan/' + item.station_fac_perbekalan_image + '" height="125" width="215" alt=""> </li>';
						}
						// } end ADDED
						
						tempStation.push(L.marker(
							[item.station_lat,item.station_lon],{icon:new ShipIcon(
								{iconUrl: conf.url+'assets/img/icon-station/'+item.stype_icon}
							)})
						.bindLabel(labelItem)
						.on('contextmenu',function(e){
							onClickMeasuring(item.station_lat,item.station_lon);
						}).on('click',function(e){
							console.log('logistik-'+item.station_id);
							getStationLogistic(item.station_id,function(result){
								
								$('#side-pangkalan').hide();
								 cleanInfoPanel();
								// revised by SKM17
								$("#ship-info-pangkalan").append(
									'<div class="container-wrapper">' +
									'<div class="tab-container">' +

									'<input type="radio" name="tab-menu" class="tab-menu-radio" id="tab-menu1" checked />' +
								    '<label for="tab-menu1" class="tab-menu">Info</label>' +

								    '<input type="radio" name="tab-menu" class="tab-menu-radio" id="tab-menu2"/>' +
								    '<label for="tab-menu2" class="tab-menu">Pesonel</label>' +


								    '<input type="radio" name="tab-menu" class="tab-menu-radio" id="tab-menu3"/>'+
								    '<label for="tab-menu3" class="tab-menu">logistik</label>'+

								    '<div class="tab-content">' +
								    '<div class="tab tab-1">' +

									'<li>' + item.station_name + '</li>' + stationImage +
									'<li><label>Nama Komandan : </label><br />' + item.station_commander + '</li>' +
									'<li><label>Lokasi :  </label><br />' + stationLocation + '</li>'+
									'<li><label>Tipe Pangkalan :  </label><br />' + item.sclass_name + '</li>' +
									
									'<li><label>Fasilitas Perbekalan</label></li>'+
									bekalImage +
									'<li>'+item.station_fac_perbekalan+' </li>' +


									'</div>' + 
								


									'<div class="tab tab-2">' +
									'<li><label>Fasilitas Sandar</label></li>'+
									sandarImage +
									'<li>'+item.station_fac_sandar+' </li>' +
									'<li><label>FASHARKAN</label></li>'+
									'<li>'+item.station_fasharkan+' </li>' +
									'</div>' + 

									'<div class="tab tab-3">' +
										'<li><label>Fasilitas Power</label></li>'+
									'<li>'+item.station_fac_power+' </li>' +
									'</div>' + 

									'</div>' +
									'</div>' +
									'</div>' 
									);

								$('#side-pangkalan').animate({width:'toggle'}, 150);
								console.log('buka');
							});
						}));
						labelItem = null;
					});
					markerAdditional['station'] =  L.layerGroup(tempStation);
					map.addLayer(markerAdditional['station']);
					tempStation = null;
				}
			});
		}
	}
	else {
		if (markerAdditional['station']!=undefined) {
			map.removeLayer(markerAdditional['station']);
		}
	}
}