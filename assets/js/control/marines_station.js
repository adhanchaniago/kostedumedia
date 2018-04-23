
function getMarinesStation(fn)
{
	socket.emit('reqMarinesStation', {});
	socket.once('resMarinesStation', function (data) {
		dataMarineStation = data;
		fn();
	});
}

function showMarinesStation(stat)
{
	getMarinesStation(function() {
		tempMarineStation = [];
		if (stat) {
			if (markerAdditional['marinestation'] != undefined) {
				removeAdditional(markerAdditional['marinestation']);
			}
			
			if (dataMarineStation != null && dataMarineStation.length > 0) {
				$.each(dataMarineStation,function(i,item) 
				{
					if (item.mar_in_ops && item.mar_lat!=undefined && item.mar_lon!=undefined) 
					{
						item.mar_lat = parseFloat(item.mar_lat);
						item.mar_lon = parseFloat(item.mar_lon);

						var labelItem = '<p align="center">' + item.unit_name + '<br />Lokasi: ' + item.mar_location + '</p>';
						
						// added by SKM17 {
						var marImage = '';
						if (item.mar_image != null && item.mar_image != '') {
							marImage = '<li> <img src="' + conf.url + 'assets/img/upload/main/marinir/' + item.mar_image + '" height="125" width="215" alt=""> </li>';
						} 
					
						var theIcon = IconMarine;
						if (item.maricon_file != null && item.maricon_file != '') {
							theIcon = new ShipIcon(
								{iconUrl: conf.url+'assets/img/icon-marine/'+item.maricon_file}
							);
						}
						// } end ADDED
					
						tempMarineStation.push(L.marker(
							[item.mar_lat, item.mar_lon], {icon:theIcon})
							.bindLabel(labelItem)
							.on('contextmenu',function(e){
								onClickMeasuring(item.mar_lat,item.mar_lon);
							}).on('click',function(e) {
								$('#side-marinir').hide();
								$("#ship-info-marinir").empty();
								// revised by SKM17
								$("#ship-info-marinir").append(
									'<li>' + item.unit_name + '</li>' + 
									marImage +
									'<li><label>Kedudukan :  </label><br />' + item.corps_name + '</li>' +
									'<li><label>Lokasi :  </label><br />' + item.mar_location + '</li>' +
									'<li><label>Personil :  </label><br />' + item.mar_personel_desc + '</li>' +
									'<li><label>Matpur :  </label><br />' + item.mar_matpur_desc + '</li>'
								);
								$('#side-marinir').animate({width:'toggle'}, 150);
							})
						);
						 
						labelItem = null;
					}
				});
				markerAdditional['marinestation'] =  L.layerGroup(tempMarineStation);
				map.addLayer(markerAdditional['marinestation']);
				tempMarineStation = null;
			}
			
			stat_view.marinestation = true;
		}
		else {
			stat_view.marinestation = false;
			if(markerAdditional['marinestation'] != undefined){
				removeAdditional(markerAdditional['marinestation']);
			}
		}	
	});
}

