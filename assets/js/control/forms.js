/**
	AOI / POI control from front end.
*/

function setPolygonArea(layer){
	// layer.on('click',function(el){
	postArea(layer._latlngs,layer);
	// });
	// console.log();
}

function setCircleArea(layer){
	// layer.on('click',function(el){
	postCircle(layer);
	// });
	
}

function setMarkerArea(layer){
	var myIcon = L.icon({
		iconUrl: conf.url+'assets/img/x-red.png',
		iconSize: [25, 25]
	});
	layer.setIcon(myIcon);
	myIcon = null;
	postMarker(layer);
}

function drawMarker(item){
	var icon = L.icon({
		iconUrl: conf.url+'assets/img/x-green.jpg',
		iconSize: [25, 25]
	});
	var text = "<p><span style='font-weight:bold;'>Nama Marker:</span><br />"+item.name+"</p>"+
		"<p><span style='font-weight:bold;'>Deskripsi</span><br />"+item.desc+"</p>"+
		"<p><span style='font-weight:bold;'>Tipe</span><br />Intelegent Info</p>"+
		"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Edit' onclick='editMarker("+count_marker+")' /></p>"+
		"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Hapus' onclick='deleteMarker("+count_marker+")' /></p>";
	markerPoi[count_marker] = new L.marker([parseFloat(item.lat), parseFloat(item.lon)],{icon:icon,opacity:0}).bindPopup(text);
	dataMarkerPoi[count_marker] = {poi_name:item.name,poi_description:item.desc,poi_lat:item.lat,poi_lon:item.lon,aoipoi_type_id:0,poi_id:item.id}; 
	count_marker++;
	groupMarkerPoi = L.layerGroup(markerPoi);
	map.addLayer(groupMarkerPoi);
	icon = null;text = null;
}

function drawCircle(item){
	var text = "<p><span style='font-weight:bold;'>Nama Area:</span><br />"+item.name+"</p>"+
		"<p><span style='font-weight:bold;'>Deskripsi</span><br />"+item.desc+"</p>"+
		"<p><span style='font-weight:bold;'>Tipe</span><br />Intelegent Info</p>"+
		"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Edit' onclick='editCircle("+count_area_circle+")' /></p>"+
		"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Hapus' onclick='deleteCircle("+count_area_circle+")' /></p>";
	circle_area[count_area_circle] = new L.circle([parseFloat(item.lat), parseFloat(item.lon)], parseFloat(item.rad),{color:"red",weight:0,fillOpacity:0}).bindPopup(text);
	map.addLayer(circle_area[count_area_circle]);
	data_area_circle[count_area_circle] = {'aoi_name':item.name,'aoi_description':item.desc,'aoipoi_type_id':0,'aoi_id':item.id,'aoi_circle_lon':item.lon,'aoi_circle_lat':item.lat,'aoi_circle_rad':item.rad};
	count_area_circle++;
}

function drawArea(item){
	temp_path = [];
	var path_bound = new Array();
	$.each(item.points,function(j,path){
		temp_path.push([parseFloat(path.lat),parseFloat(path.lon)]);
		path_bound.push({lat:parseFloat(path.lat),lng:parseFloat(path.lon)});
	});
	var text = "<p><span style='font-weight:bold;'>Nama Area:</span><br />"+item.name+"</p>"+
		"<p><span style='font-weight:bold;'>Deskripsi</span><br />"+item.desc+"</p>"+
		"<p><span style='font-weight:bold;'>Tipe</span><br />Intelegent Info</p>"+
		"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Edit' onclick='editArea("+count_area+")' /></p>"+
		"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Hapus' onclick='deleteArea("+count_area+")' /></p>";
	polygon_area[count_area] = new L.Polygon(temp_path,{color:"red",weight:0,fillOpacity:0}).bindPopup(text);
	map.addLayer(polygon_area[count_area]);
	data_area[count_area] = {'aoi_name':item.name,'aoi_description':item.desc,'aoipoi_type_id':0,'path':path_bound,'aoi_id':item.id};

	count_area++;
}

function postArea(data_array,layer_polygon){
	$("#form_add_area_polygon").each(function(){ this.reset(); });
	var path_bound = new Array();
	temp_path = [];
	$.each(data_array,function(i,item){
		path_bound.push({lat:item.lat,lng:item.lng});
		temp_path.push([item.lat,item.lng]);
	});
	$( "#dialog-post-area" ).dialog({buttons: {
			"Simpan Area": function() {
				var type_id = $("#tipe_area_polygon option:selected").val();
				var name_type = $("#tipe_area_polygon option:selected").text();
				$.ajax({
					url:conf.url+'map_service/aoi/saveAOI',
					dataType : 'html',
					type : 'POST',
					data : {aoipoi_type_id:type_id,aoi_name:$("#name_area_polygon").val(),aoi_description:$("#description_area_polygon").val(),aoi_points:path_bound},
					success : function(data){
						var text = "<p><span style='font-weight:bold;'>Nama Area:</span><br />"+$("#name_area_polygon").val()+"</p>"+
							"<p><span style='font-weight:bold;'>Deskripsi</span><br />"+$("#description_area_polygon").val()+"</p>"+
							"<p><span style='font-weight:bold;'>Tipe</span><br />"+name_type+"</p>"+
							"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Edit' onclick='editArea("+count_area+")' /></p>"+
							"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Hapus' onclick='deleteArea("+count_area+")' /></p>";
						layer_polygon.off('click');
						map.removeLayer(layer_polygon);
						polygon_area[count_area] = new L.Polygon(temp_path,{color:"red",weight:0,fillOpacity:0}).bindPopup(text);
						map.addLayer(polygon_area[count_area]);
						data_area[count_area] = {'aoi_name':$("#name_area_polygon").val(),'aoi_description':$("#description_area_polygon").val(),'aoipoi_type_id':type_id,'path':path_bound,'aoi_id':data};
						// for(var i in markerKRI){
						// checkContainLatlngPolygonArea(markerKRI[i],count_area);
						// }
						count_area++;
						
					}
				});
				set_drawing_area();
				$( this ).dialog( "close" );
			},
			Cancel: function() {
				map.removeLayer(layer_polygon);
				set_drawing_area();
				$( this ).dialog( "close" );
			}
		}});
	$( "#dialog-post-area" ).dialog( "open" );
}

function postMarker(layer){
	$("#form_add_marker").each(function(){ this.reset(); });
	$( "#dialog-post-marker" ).dialog({buttons: {
			"Simpan Marker": function() {
				var type_id = $("#tipe_marker option:selected").val();
				var name_type = $("#tipe_marker option:selected").text();
				$.ajax({
					url:conf.url+'map_service/poi/savePOI',
					dataType : 'html',
					type : 'POST',
					data : {aoipoi_type_id:type_id,poi_name:$("#name_marker").val(),poi_description:$("#description_marker").val(),poi_lat:layer.getLatLng().lat,poi_lon:layer.getLatLng().lng},
					success : function(data){
						//map.removeLayer(marker)
						layer.off('click');
						var icon = L.icon({
							iconUrl: conf.url+'assets/img/x-green.jpg',
							iconSize: [25, 25]
						});
						var text = "<p><span style='font-weight:bold;'>Nama Marker:</span><br />"+$("#name_marker").val()+"</p>"+
							"<p><span style='font-weight:bold;'>Deskripsi</span><br />"+$("#description_marker").val()+"</p>"+
							"<p><span style='font-weight:bold;'>Tipe</span><br />"+name_type+"</p>"+
							"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Edit' onclick='editMarker("+count_marker+")' /></p>"+
							"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Hapus' onclick='deleteMarker("+count_marker+")' /></p>";
						dataMarkerPoi[count_marker] = {poi_name:$("#name_marker").val(),poi_description:$("#description_marker").val(),poi_lat:layer.getLatLng().lat,poi_lon:layer.getLatLng().lng,aoipoi_type_id:type_id,poi_id:data}; 
						map.removeLayer(layer);
						markerPoi[count_marker] = new L.marker([parseFloat(dataMarkerPoi[count_marker].poi_lat), parseFloat(dataMarkerPoi[count_marker].poi_lon)],{icon:icon,opacity:0}).bindPopup(text);
						map.addLayer(markerPoi[count_marker]);
						count_marker++;
						
					}
				});
				set_drawing_area();
				$( this ).dialog( "close" );
			},
			Cancel: function() {	
				map.removeLayer(layer);
				set_drawing_area();
				$( this ).dialog( "close" );
			}
		}});
	$( "#dialog-post-marker" ).dialog( "open" );
}

function postCircle(layer){
	$("#form_add_circle").each(function(){ this.reset(); });
	$( "#dialog-post-circle" ).dialog({buttons: {
			"Simpan Area": function() {
				var type_id = $("#tipe_area_circle option:selected").val();
				var name_type = $("#tipe_area_circle option:selected").text();
				$.ajax({
					url:conf.url+'map_service/aoi_circle/saveCircle',
					dataType : 'html',
					type : 'POST',
					data : {aoipoi_type_id:type_id,aoi_name:$("#name_area_circle").val(),aoi_description:$("#description_area_circle").val(),aoi_circle_lat:layer.getLatLng().lat,aoi_circle_lon:layer.getLatLng().lng,aoi_circle_rad:layer.getRadius()},
					success : function(data){
						layer.off('click');
						data_area_circle[count_area_circle] = {'aoi_name':$("#name_area_circle").val(),'aoi_description':$("#description_area_circle").val(),'aoipoi_type_id':type_id,'aoi_id':data,'aoi_circle_lon':layer.getLatLng().lng,'aoi_circle_lat':layer.getLatLng().lat,'aoi_circle_rad':layer.getRadius()};
						map.removeLayer(layer);
						var text = "<p><span style='font-weight:bold;'>Nama Area:</span><br />"+$("#name_area_circle").val()+"</p>"+
							"<p><span style='font-weight:bold;'>Deskripsi</span><br />"+$("#description_area_circle").val()+"</p>"+
							"<p><span style='font-weight:bold;'>Tipe</span><br />"+name_type+"</p>"+
							"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Edit' onclick='editCircle("+count_area_circle+")' /></p>"+
							"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Hapus' onclick='deleteCircle("+count_area_circle+")' /></p>";
						circle_area[count_area_circle] = new L.circle([parseFloat(data_area_circle[count_area_circle].aoi_circle_lat), parseFloat(data_area_circle[count_area_circle].aoi_circle_lon)], parseFloat(data_area_circle[count_area_circle].aoi_circle_rad),{color:"red",weight:0,fillOpacity:0}).bindPopup(text);
						map.addLayer(circle_area[count_area_circle]);
						// for(var i in markerKRI){
						// checkContainLatlngCircleArea(markerKRI[i],count_area_circle);
						// }
						count_area_circle++;
						
					}
				});
				set_drawing_area();
				$( this ).dialog( "close" );
			},
			Cancel: function() {
				set_drawing_area();
				map.removeLayer(layer);
				$( this ).dialog( "close" );
			}
		}});
	$( "#dialog-post-circle" ).dialog( "open" );
}

function editArea(id){
	polygon_area[id].closePopup();
	$("#form_add_area_polygon").each(function(){ this.reset(); });
	$("#name_area_polygon").val(data_area[id].aoi_name);
	$("#description_area_polygon").val(data_area[id].aoi_description);
	$("#tipe_area_polygon").val(data_area[id].aoipoi_type_id);
	$('#dialog-post-area').dialog({buttons: {
			"Simpan Area": function() {
				var type_id = $("#tipe_area_polygon option:selected").val();
				var name_type = $("#tipe_area_polygon option:selected").text();
				$.ajax({
					url:conf.url+'map_service/aoi/editAOI',
					dataType : 'html',
					type : 'POST',
					data : {aoipoi_type_id:type_id,aoi_name:$("#name_area_polygon").val(),aoi_description:$("#description_area_polygon").val(),aoi_points:data_area[id].path,aoi_id:data_area[id].aoi_id},
					success : function(data){
						//console.log(data);
						data_area[id] = {'aoi_name':$("#name_area_polygon").val(),'aoi_description':$("#description_area_polygon").val(),'aoipoi_type_id':type_id,'path':data_area[id].path,'aoi_id':data_area[id].aoi_id};
						var text = "<p><span style='font-weight:bold;'>Nama Area:</span><br />"+$("#name_area_polygon").val()+"</p>"+
							"<p><span style='font-weight:bold;'>Deskripsi</span><br />"+$("#description_area_polygon").val()+"</p>"+
							"<p><span style='font-weight:bold;'>Tipe</span><br />"+name_type+"</p>"+
							"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Edit' onclick='editArea("+id+")' /></p>"+
							"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Hapus' onclick='deleteArea("+id+")' /></p>";
						polygon_area[id].unbindPopup();
						polygon_area[id].bindPopup(text);
					}
				});
				$( this ).dialog( "close" );
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}}).dialog( "open" );
}

function editCircle(id){
	circle_area[id].closePopup();
	$("#form_add_circle").each(function(){ this.reset(); });
	$("#name_area_circle").val(data_area_circle[id].aoi_name);
	$("#description_area_circle").val(data_area_circle[id].aoi_description);
	$("#tipe_area_circle").val(data_area_circle[id].aoipoi_type_id);
	$("#dialog-post-circle").dialog({buttons: {
			"Simpan Area": function() {
				var type_id = $("#tipe_area_circle option:selected").val();
				var name_type = $("#tipe_area_circle option:selected").text();
				$.ajax({
					url:conf.url+'map_service/aoi_circle/editCircle',
					dataType : 'html',
					type : 'POST',
					data : {aoipoi_type_id:type_id,aoi_name:$("#name_area_circle").val(),aoi_description:$("#description_area_circle").val(),aoi_circle_lat:data_area_circle[id].aoi_circle_lat,aoi_circle_lon:data_area_circle[id].aoi_circle_lon,aoi_circle_rad:data_area_circle[id].aoi_circle_rad,aoi_id:data_area_circle[id].aoi_id},
					success : function(data){
						data_area_circle[id] = {'aoi_name':$("#name_area_circle").val(),'aoi_description':$("#description_area_circle").val(),'aoipoi_type_id':type_id,'aoi_id':data_area_circle[id].aoi_id,'aoi_circle_lon':data_area_circle[id].aoi_circle_lon,'aoi_circle_lat':data_area_circle[id].aoi_circle_lat,'aoi_circle_rad':data_area_circle[id].aoi_circle_rad};
						var text = "<p><span style='font-weight:bold;'>Nama Area:</span><br />"+$("#name_area_circle").val()+"</p>"+
							"<p><span style='font-weight:bold;'>Deskripsi</span><br />"+$("#description_area_circle").val()+"</p>"+
							"<p><span style='font-weight:bold;'>Tipe</span><br />"+name_type+"</p>"+
							"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Edit' onclick='editCircle("+id+")' /></p>"+
							"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Hapus' onclick='deleteCircle("+id+")' /></p>";
						circle_area[id].unbindPopup();
						circle_area[id].bindPopup(text);
					}
				});
				$( this ).dialog( "close" );
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}}).dialog( "open" );
}

function editMarker(id){
	markerPoi[id].closePopup();
	$("#form_add_marker").each(function(){ this.reset(); });
	$("#name_marker").val(dataMarkerPoi[id].poi_name);
	$("#description_marker").val(dataMarkerPoi[id].poi_description);
	$("#tipe_marker").val(dataMarkerPoi[id].aoipoi_type_id);
	$("#dialog-post-marker").dialog({buttons: {
			"Save": function() {
				var type_id = $("#tipe_marker option:selected").val();
				var name_type = $("#tipe_marker option:selected").text();
				$.ajax({
					url:conf.url+'map_service/poi/editPOI',
					dataType : 'html',
					type : 'POST',
					data : {aoipoi_type_id:type_id,poi_id:dataMarkerPoi[id].poi_id,poi_name:$("#name_marker").val(),poi_description:$("#description_marker").val(),poi_lat:dataMarkerPoi[id].poi_lat,poi_lon:dataMarkerPoi[id].poi_lon},
					success : function(data){
						var name_marker = $("#name_marker").val();
						var desc_marker = $("#description_marker").val();
						var text = "<p><span style='font-weight:bold;'>Nama Marker:</span><br />"+name_marker+"</p>"+
							"<p><span style='font-weight:bold;'>Deskripsi</span><br />"+desc_marker+"</p>"+
							"<p><span style='font-weight:bold;'>Tipe</span><br />"+name_type+"</p>"+
							"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Edit' onclick='editMarker("+id+")' /></p>"+
							"<p><input type='button' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' value='Hapus' onclick='deleteMarker("+id+")' /></p>";
						markerPoi[id].unbindPopup();
						markerPoi[id].bindPopup(text);
						dataMarkerPoi[id] = {poi_name:name_marker,poi_description:desc_marker,poi_lat:dataMarkerPoi[id].poi_lat,poi_lon:dataMarkerPoi[id].poi_lon,aoipoi_type_id:type_id,poi_id:dataMarkerPoi[id].poi_id};  
					}
				});
				$( this ).dialog( "close" );
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}}).dialog( "open" );
}

function deleteMarker(i){
	if(confirm('Apakah anda akan menghapus area titik ini?')){
		$.ajax({
			url:conf.url+'map_service/poi/deletePOI',
			dataType : 'html',
			type : 'POST',
			data : {poi_id:dataMarkerPoi[i].poi_id},
			success : function(data){
				// console.log(data);
				if(data==1){
					map.removeLayer(markerPoi[i]);
					dataMarkerPoi[i] = [];
					markerPoi[i] = [];
				}else{
					alert('area gagal di hapus');
				}
			}
		});
	}
}

function deleteArea(i){
	if(confirm('Apakah anda akan menghapus area poligon ini?')){
		$.ajax({
			url:conf.url+'map_service/aoi/deleteAOI',
			dataType : 'html',
			type : 'POST',
			data : {aoi_id:data_area[i].aoi_id},
			success : function(data){
				if(data==1){
					map.removeLayer(polygon_area[i]);
					data_area[i] = [];
					polygon_area[i] = [];
				}else{
					alert('area gagal di hapus');
				}
			}
		});
	}
}

function deleteCircle(i){
	if(confirm('Apakah anda akan menghapus area lingkaran ini?')){
		$.ajax({
			url:conf.url+'map_service/aoi_circle/deleteCircle',
			dataType : 'html',
			type : 'POST',
			data : {aoi_id:data_area_circle[i].aoi_id},
			success : function(data){
				if(data==1){
					map.removeLayer(circle_area[i]);
					data_area_circle[i] = [];
					circle_area[i] = [];
				}else{
					alert('area gagal di hapus');
				}
			}
		});
	} 
}

 var count_line=2;
	function add_more_line(){
		var line = document.createElement('div');
		line.setAttribute('id', 'line'+ count_line);
		line.innerHTML =
			'<p style="border-bottom: 1px solid #CCC; padding-bottom: 5px; margin-bottom: 5px;">Titik' + count_line + '</p>'+
			'<label for="lattitude">Lattitude :</label>'+
			'<div style="width: 104px; float: left; margin: 0 20px 0 0;">'+
			'<input type="text" name="pol_lat_degree'+count_line+'" size="5" class="text ui-widget-content ui-corner-all pol_lat_degree'+count_line+'" style="float: left; margin-right: 3px;" onkeypress="return validDegree(event,\'pol_lat_degree'+count_line+'\')" /> <span class="symbol">&#176;</div>'+
			'</div>'+
			'<div style="width: 104px; float: left; margin: 0 20px 0 0;">'+
			'<input type="text" name="pol_lat_minute'+count_line+'" size="5" class="text ui-widget-content ui-corner-all pol_lat_minute'+count_line+'" style="float: left; margin-right: 3px;" onkeypress="return validMinuteSecond(event,\'pol_lat_minute'+count_line+'\')"/> <span class="symbol">&#39;</div>'+
			'</div>'+
			'<div style="width: 104px; float: left; margin: 0 20px 0 0;">'+
			'<input type="text" name="pol_lat_second'+count_line+'" size="5" class="text ui-widget-content ui-corner-all pol_lat_second'+count_line+'" style="float: left; margin-right: 3px;" onkeypress="return validMinuteSecond(event,\'pol_lat_second'+count_line+'\')"/> <span class="symbol">&#34;</div>'+
			'</div>'+
			'<select name="pol_lat_point'+count_line+'" class="selecting" style="width: 91px;">'+
			'<option value="U">U</option>'+
			'<option value="S">S</option>'+
			'</select>'+
			'<label for="lattitude">Longitude :</label>'+
			'<div style="width: 104px; float: left; margin: 0 20px 0 0;">'+
			'<input type="text" name="pol_lon_degree'+count_line+'" size="5" class="text ui-widget-content ui-corner-all pol_lon_degree'+count_line+'" style="float: left; margin-right: 3px;" onkeypress="return validDegree(event,\'pol_lon_degree'+count_line+'\')" /> <span class="symbol">&#176;</div>'+
			'</div>'+
			'<div style="width: 104px; float: left; margin: 0 20px 0 0;">'+
			'<input type="text" name="pol_lon_minute'+count_line+'" size="5" class="text ui-widget-content ui-corner-all pol_lon_minute'+count_line+'" style="float: left; margin-right: 3px;" onkeypress="return validMinuteSecond(event,\'pol_lon_minute'+count_line+'\')"/> <span class="symbol">&#39;</div>'+
			'</div>'+
			'<div style="width: 104px; float: left; margin: 0 20px 0 0;">'+
			'<input type="text" name="pol_lon_second'+count_line+'" size="5" class="text ui-widget-content ui-corner-all pol_lon_second'+count_line+'" style="float: left; margin-right: 3px;" onkeypress="return validMinuteSecond(event,\'pol_lon_second'+count_line+'\')"/> <span class="symbol">&#34;</div>'+
			'</div>'+
			'<select name="pol_lon_point'+count_line+'" class="selecting" style="width: 91px;">'+
			'<option value="T">T</option>'+
			'<option value="B">B</option>'+
			'</select>';
		$("#add_more_line").append(line);
		$("#total_line_polygon").val(count_line);
		count_line++;
	}
	
	function set_drawing_area(){
		if(!stat_draw_area){
			switch(type_draw_area){
				case 'polygon':
					draw_circle.disable();
					draw_polygon.enable();
					draw_point.disable();
					console.log('polygon');
					break;
				case 'circle':
					draw_circle.enable();
					draw_polygon.disable();
					draw_point.disable();
					break;
				case 'point':
					draw_circle.disable();
					draw_polygon.disable();
					draw_point.enable();
					break;
			}
			stat_draw_area = true;
			$('.cancel_draw').show();
		}else{
			draw_circle.disable();
			draw_polygon.disable();
			draw_point.disable();
			stat_draw_area = false;
			$('.cancel_draw').hide();
		}
	}
