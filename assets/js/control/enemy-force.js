function getEnemyForce(fn){
	socket.emit('reqEnemyForce');
	socket.once('resEnemyForce', function (data){
		fn(data);
	});
}

function showEnemyForce(stat)
{

	if (stat) {
		if (markerAdditional['enemyForce']!=undefined) {
			map.addLayer(markerAdditional['enemyForce']);

		}
		else {
			getEnemyForce(function(enemyForceData) {

				var tempEnemyForce = [];

				if (enemyForceData != null && enemyForceData.length > 0 ) {

					$.each(enemyForceData, function(i, item) {

						item.enmap_lat = parseFloat(item.enmap_lat);
						item.enmap_lon = parseFloat(item.enmap_lon);

						var labelItem = '<p align="center">'+item.enmap_name+'</p>';
						var enmaImage = '';
							if (item.enmap_icon != null && item.enmap_icon != 0) {
								enmaImage += '<li> <img src="' + conf.url + 'assets/img/upload/main/lawan/' + item.enmap_icon + '" height="125" width="215" alt=""> </li>';
							}
						
						tempEnemyForce.push(
							new L.EnemyForceMarker(
								[item.enmap_lat, item.enmap_lon],
								{
									lat : item.enmap_lat,
									lng : item.enmap_lon,
									forceId: item.enmap_id,
									name : item.enmap_icon,
									desc : item.enmap_desc,
									icon : new ShipIcon({iconUrl: conf.url+'assets/img/icon-enemy-force/'+item.eforceflag_icon})
								}
							).bindLabel(labelItem)
							  .on('click', function(){
								// do something with the side right
								$('#side-lawan').hide();
								$("#ship-info-lawan").empty();
								$("#ship-info-lawan").html(
									'<li>'+item.enmap_name+'</li>' + enmaImage +
									'<li><label>Posisi :  </label>' + 
										'<br />'+viewableCoordinate(item.enmap_lat,'lat')+' , '+viewableCoordinate(item.enmap_lon,'lon') +
									'</li>'+
									'<li><label>Negara :  </label><br />' + item.eforceflag_name + '</li>'+
									'<li><label>Tipe Pangkalan :  </label><br />'+item.eforcetype_name+'</li>'+
									'<li><label>Deskripsi :</label>'+item.enmap_desc+' </li>');
							
	/* // yg ini nanti dulu dihapusnya
								socket.emit('reqEnForceComp', {'forceId' : item.enmap_id} );
								socket.on('resEnForceComp', function(result){
									var content = '<li>Komponen Kekuatan Lawan</li>';
									$.each(result, function(idx, item){
									
										content += '<li><label>'+item.fcomp_name+'</label>'+
													'<img src="'+conf.url+'assets/img/nato-icon/'+item.fcomp_icon+'" width="32"/> Kekuatan : '+item.fcomp_power+'</li>';
									});
						
									$('#ship-personnel').html(content);
								});
	*/
								$('#side-lawan').animate({width:'toggle'}, 150);
							})
						);
					});
				}
				markerAdditional['enemyForce'] = L.layerGroup(tempEnemyForce);
				map.addLayer(markerAdditional['enemyForce']);
				tempEnemyForce = null
			});
		}
	}
	else {
		if (markerAdditional['enemyForce']!=undefined) {
			map.removeLayer(markerAdditional['enemyForce']);
		}
	}
}
