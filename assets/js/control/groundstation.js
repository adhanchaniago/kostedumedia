function getGroundStation(fn){
	socket.emit('reqGroundStation');
	socket.once('resGroundStation', function (data)
	{
		gsData = data;
		// console.log(data);

		fn();
	});
}

function showGroundStation(stat){

	getGroundStation(function(){

		tempGS = [];
		if (stat) {
			if(markerAdditional['groundStation']!=undefined){
				removeAdditional(markerAdditional['groundStation']);
			}

			if (gsData != null && gsData.length > 0 ) 
			{
				// data from mongo
				/*
				$.each(gsData, function(i, item){
					item.lat = parseFloat(item.lat);
					item.lon = parseFloat(item.lon);
					var stateInt = parseInt(item.state);
					var state;
					var warna;
					switch (stateInt) {
						case 0:
							state = 'Mati';
							warna = 'black';
							break;
						case 1:
							state = 'Nyala';
							warna = 'red';
							break;
						case 2:
							state = "Sibuk";
							break;
					}

					var labelItem = '<p align="center">GS '+item.location+
									'<br/> Lintang : '+viewableCoordinate(item.lat, 'lat')+
									'<br/> Bujur : '+viewableCoordinate(item.lon, 'lon')+
									'<br/> Status: ' + state +'</p>';
					  
					tempGS.push(
						new L.circle([item.lat, item.lon], 100,
						{
							color : warna,
							opacity : 0.5,
							fillColor : warna,
							fillOpacity: 0.5
						})
					);
				}); */

				// data from pg
				$.each(gsData, function(i, item){
					var lat = parseFloat(item.gs_lat);
					var lon = parseFloat(item.gs_lon);
					var conn_state = item.connection_status;
					var state;
					var warna;

					if (conn_state == true) {
						state = 'Nyala';
						warna = 'red';
					} else if (conn_state == false) {
						state = 'Mati';
						warna = 'black';
					}

					var labelItem = '<p align="center">GS ' + item.gs_place +
									// '<br/> Lintang : '+viewableCoordinate(item.gs_lat, 'lat')+
									// '<br/> Bujur : '+viewableCoordinate(item.gs_lon, 'lon')+
									'<br/> Status: ' + state +'</p>';
					  
					tempGS.push(
						new L.circle([item.gs_lat, item.gs_lon], 100,
						{
							color : warna,
							opacity : 0.5,
							fillColor : warna,
							fillOpacity: 0.5
						})
						.bindLabel(labelItem)
					);
				});

				labelItem = null;
				markerAdditional['groundStation'] = L.layerGroup(tempGS);
				map.addLayer(markerAdditional['groundStation']);
				tempGS = null
			}

			stat_view.groundStation = true;
		}
		else {
			stat_view.groundStation = false;
			if (markerAdditional['groundStation']!=undefined) {
				removeAdditional(markerAdditional['groundStation']);
			}
		}
	});
}
