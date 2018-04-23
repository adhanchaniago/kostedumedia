
function getRanpur(){

	socket.emit('reqRanpur', {});
	socket.once('resRanpur', function (data) {
		dataRanpur = data;
	});
}

function showCombatVehicle(stat){

	getRanpur();

	tempRanpur = [];
	if(stat){
		stat_view.ranpur = true;
		if(markerAdditional['ranpur']!=undefined){
			removeAdditional(markerAdditional['ranpur']);
		}
		if (dataRanpur!=null && dataRanpur.length > 0) {
			$.each(dataRanpur,function(i,item) {
				item.mar_lat = parseFloat(item.mar_lat);
				item.mar_lon = parseFloat(item.mar_lon);
				tempRanpur.push(
					L.marker(
						[item.mar_lat,item.mar_lon],
						{icon:IconRanpur}).bindLabel(
							'<p align="center">'+item.mar_name+'<br />'+viewableCoordinate(item.mar_lat,'lat')+
							' , '+viewableCoordinate(item.mar_lon,'lon')+'</p>'
						).on('contextmenu',function(e){
							onClickMeasuring(item.mar_lat,item.mar_lon);
						}).on('click',function(e){
							cleanInfoPanel();
							$('#side-right').hide();
							cleanInfoPanel();
							$("#ship-info").append('<li>'+item.mar_name+'</li>'+
								'<li><label>Posisi :  </label><br />'+viewableCoordinate(item.mar_lat,'lat')+' , '+viewableCoordinate(item.mar_lon,'lon')+'</li>'+
								'<li><label>Deskripsi :  </label><br />'+item.mar_description+'</li>'+
								'<li><label>Jumlah Personel :  </label><br />'+item.mar_personel_count+' Orang</li>'
								// '<li><label>Nama Korps :  </label><br />'+item.corps_name+' Knott</li>'+
								// '<li><label>Deskripsis Korps :</label><br />  '+item.corps_description+' </li>'
							);
							$('#side-right').animate({width:'toggle'}, 150);
				
						})
					);
				});
			markerAdditional['ranpur'] =  L.layerGroup(tempRanpur);
			map.addLayer(markerAdditional['ranpur']);
			tempRanpur = null;
		}
	}else{
		stat_view.ranpur = false;
		if(markerAdditional['ranpur']!=undefined){
			removeAdditional(markerAdditional['ranpur']);
		}
	}
}
