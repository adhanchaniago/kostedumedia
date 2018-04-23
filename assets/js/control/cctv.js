


function getCctv(fn){
	socket.emit('reqCCTVLocation', {});
	socket.once('resCCTVLocation', function (data) {
		dataCCTV = data;
		fn();
	});
}

function showCCTV(stat){

	getCctv(function(){
		tempCCTV = [];
		if (stat) {
			stat_view.cctv = true;
			if(markerAdditional['cctv']!=undefined){
				removeAdditional(markerAdditional['cctv']);
			}

			if(dataCCTV!=null && dataCCTV.length > 0){
				$.each(dataCCTV, function(i, item){
					item.cctv_lat = parseFloat(item.cctv_lat);
					item.cctv_lat = parseFloat(item.cctv_lat);

					tempCCTV.push(
						new L.Marker([item.cctvloc_lat,item.cctvloc_lon])
							.bindLabel('<p align="center">CCTV '+item.cctvloc_name+'</p>')
							.on('click',function(){
								$("#frame-video").attr('src',conf.url+'map/video/'+item.cctvloc_id);
								$('#video-streaming').fadeIn('fast');
							
						})
					);
				});

				markerAdditional['cctv'] = L.layerGroup(tempCCTV);
				map.addLayer(markerAdditional['cctv']);
				tempCCTV = null;
			}
		}
		else {
			stat_view.cctv = false;
			if(markerAdditional['cctv']!=undefined){
				removeAdditional(markerAdditional['cctv']);
			}
		}		
	});
}
