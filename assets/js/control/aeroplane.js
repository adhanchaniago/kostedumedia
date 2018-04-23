
function getAeroplane(fn)
{
	socket.emit('reqAeroplane', {});
	socket.once('resAeroplane', function (data) {
		fn(data);
	});
}

function showAeroplane(stat)
{
	if (stat) {
		if (markerAdditional['aeroplane']!=undefined) {
			map.addLayer(markerAdditional['aeroplane']);
		}
		else {
			getAeroplane(function(dataAeroplane){
				var tempAeroplane = [];
				if(dataAeroplane!=null && dataAeroplane.length > 0){
					$.each(dataAeroplane,function(i,item){
						// console.log("ini isi item");
						// console.log(item);
						if (item.aer_lat!=undefined && item.aer_lon!=undefined) {
							item.aer_lat = parseFloat(item.aer_lat);
							item.aer_lon = parseFloat(item.aer_lon);
							
							// added by SKM17 {
							var sisa = parseInt(item.aer_pjl_ops) - parseInt(item.aer_realitation);
							var aerImage = '';
							if (item.aer_image != null && item.aer_image != '') {
								aerImage += '<li> <img src="' + conf.url + 'assets/img/upload/main/pesud/' + item.aer_image + '" height="125" width="215" alt=""> </li>';
							}
							
							var theIcon = IconAeroplane;
							if (item.aericon_file != null && item.aericon_file != '') {
								theIcon = new ShipIcon(
									{iconUrl: conf.url+'assets/img/icon-aeroplane/'+item.aericon_file}
								);
							}
							
							var pembina, kodal, pilot;
							if (item.corps_name) pembina = item.corps_name;
							else pembina = '-';
							if (item.kodal_name) kodal = item.kodal_name;
							else kodal = '-';
							if (item.pilot_name) pilot = item.pilot_name;
							else pilot = '-';
							// } end ADDED
							
							tempAeroplane.push(
								L.marker(
								[item.aer_lat,item.aer_lon],
								{icon:theIcon}).bindLabel(
									'<p align="center">'+item.aer_name+'</p>', 
									{ noHide: pesudNumberDisplayStat, direction: 'auto' }
								).on('contextmenu',function(e){
									onClickMeasuring(item.aer_lat,item.aer_lon);
								}).on('click',function(e){
									//history
									if (secondpolyline != null){
										showHistoryPesud(false); //nambah pas awal klik info biar ganti history	
									}																
									showPesudDislocation(item.aer_name, item.aer_id, item.aer_lat, item.aer_lon);// nambah buat show history dislokasi //gopalgopel
									//history
									
									$('#side-pesud').hide();
									$("#ship-info-pesud").empty();							
									// revised by SKM17
									$("#ship-info-pesud").html(
										'<li>' + item.aer_name+'</li>' + 
										aerImage + 
										'<li><label>Tipe Pesawat : </label><br />' + item.aertype_name + '</li>' +
										// '<li><label>Posisi :  </label><br />'+viewableCoordinate(item.aer_lat,'lat')+' , '+viewableCoordinate(item.aer_lon,'lon')+'</li>'+
										'<li><label>Lokasi : </label><br />' + item.aer_location + '</li>' +
										'<li><label>PJT OPS : </label><br />' + item.aer_pjl_ops + ' Jam</li>' +
										'<li><label>Realisasi : </label><br />' + item.aer_realitation + ' Jam</li>' +
										'<li><label>Sisa : </label><br />' + sisa + ' Jam</li>' + 
										'<li><label>Pembina : </label><br />' + pembina + '</li>' + 
										'<li><label>Nama Operasi : </label><br />' + item.operation_name + '</li>' + 
										'<li><label>Kodal : </label><br />' + kodal + '</li>' + 
										'<li><label>Pilot : </label><br />' + pilot + '</li>'/*
										'<li><label>Ketahanan :  </label><br />'+item.aer_endurance+' mile</li>'+
										'<li><label>Cpt :  </label><br />'+item.aer_speed+'</li>'*/
									);
									$('#side-pesud').animate({width:'toggle'}, 150);
							
								})
							);
						}
					});
					if (tempAeroplane.length>0) {
						markerAdditional['aeroplane'] =  L.layerGroup(tempAeroplane);
						map.addLayer(markerAdditional['aeroplane']);
						tempAeroplane = null;
					}
				}
			});
		}
	}
	else {
		if (markerAdditional['aeroplane']!=undefined) {
			map.removeLayer(markerAdditional['aeroplane']);
		}
	}
}
