
function getMyFleet(fn)
{
	socket.emit('reqMyFleet', {});
	socket.once('resMyFleet', function (data) {
		fn(data);
	});
}

function showMyFleet(stat)
{
	if (stat) {
		if (markerAdditional['myfleet'] != undefined) {
			map.addLayer(markerAdditional['myfleet']);
		}
		else {
			getMyFleet(function(dataMyFleet){
				var tempMyFleet = [];
				if(dataMyFleet != null && dataMyFleet.length > 0){
					$.each(dataMyFleet, function(i,item) {
						if (item.mf_lat!=undefined && item.mf_lon != undefined) {
							item.mf_lat = parseFloat(item.mf_lat);
							item.mf_lon = parseFloat(item.mf_lon);
							
							var theIcon = new ShipIcon(

								{iconUrl: conf.url+'assets/img/fleet2.png',
								iconSize:     [15, 30],
								iconAnchor: [7, 15]}

							);
							
							
							var mark = new L.marker(
								[item.mf_lat, item.mf_lon],
								{icon: theIcon}).bindLabel(
									'<p align="center">' + item.mf_name + '</p>', 
									{ direction: 'auto' }
								)								
								.on('contextmenu',function(e){
									onClickMeasuring(item.mf_lat, item.mf_lon);
								}).on('click',function(e){
									console.log('data fleet');
									console.log(item);	
									$('#side-Fletmoon').hide();	
									$("#ship-info-Fletmoon").empty();	
						
									$("#ship-info-Fletmoon").html(
										//imo ,mmsi, callsign, lxWxmax Draught
										//type, location, last port, Destination, ETA(UTC), SOG COG HDG
										//nav status, CPA TCPA
										'<li> <img src="'+item.mf_photos+'" height="125" width="215" alt=""> </li>' + 
										'<li><label>Name :</label><br />'+ item.mf_name +'</li>' +										
										'<li><label>IMO :</label><br />'+ item.mf_imo+'</li>' +
										'<li><label>MMSI : </label><br />' + item.mf_mmsi + '</li>' +
										'<li><label>Origin :</label><br />'+ item.mf_flag+'</li>' +										
										'<li><label>Callsign : </label><br />' + item.mf_callsign + '</li>' +
										'<li><label>Type : </label><br />' + item.mf_type + '</li>' +
										'<li><label>Location : </label><br />' + item.mf_location + '</li>' +
										'<li><label>Last Port : </label><br />' + item.mf_lastport_name+ '</li>' + 
										'<li><label>Destination : </label><br />' + item.mf_destination + '</li>' + 
										'<li><label>ETA: </label><br />' + item.mf_etatime + '</li>' + 
										'<li><label>Speed : </label><br />' + item.mf_speed + ' knot</li>' + 
										'<li><label>Course : </label><br />' + item.mf_course + '°</li>'+
										'<li><label>Heading : </label><br />' + item.mf_hdg + '°</li>' + 
										'<li><label>Navigation Status : </label><br />' +item.mf_nav_status+ '</li>' + 
										'<li><label>Last Updated : </label><br />' +item.mf_last_reload+ '</li>'  
									);
									$('#side-Fletmoon').animate({width:'toggle'}, 150);

								})
							mark.setIconAngle(item.mf_hdg);
							tempMyFleet.push(mark);
						}
					});
					if (tempMyFleet.length>0) {
						markerAdditional['myfleet'] =  L.layerGroup(tempMyFleet);
						map.addLayer(markerAdditional['myfleet']);
						tempMyFleet = null;
					}
				}
			});
		}
	}
	else {
		if (markerAdditional['myfleet']!=undefined) {
			map.removeLayer(markerAdditional['myfleet']);
		}
	}
}
