
function getDefinedArea(fn)
{
	socket.emit('reqDefinedArea', {});
	socket.once('resDefinedArea', function (data) {
		fn(data);
	});
}

function showDefinedArea(stat)
{
	if (stat) {
		if (markerAdditional['def_area']!=undefined) {
			map.addControl(markerAdditional['def_area']);
		}
		else {
			getDefinedArea(function(dataDefArea){
				if(dataDefArea!=null && dataDefArea.length > 0){
					var areaPolygon;
					var listAreaPoint = [];
					var firstList = true;
					var lastAreaName;
					var lastAreaDesc;
					var lastAreaColor;
					var overlayMaps = {};
					$.each(dataDefArea,function(i,item){
						if (item.depoint_lat!=undefined && item.depoint_lon!=undefined) {
							if (item.da_name != lastAreaName) {
								if (!firstList) {
									// create new polygon
									areaPolygon = L.polygon(listAreaPoint,{color:lastAreaColor}).bindPopup(lastAreaDesc);
									overlayMaps[lastAreaName] = areaPolygon;
									listAreaPoint = [];
								} else
									firstList = false;
							}
							listAreaPoint.push([parseFloat(item.depoint_lat), parseFloat(item.depoint_lon)]);
							lastAreaName = item.da_name;
							lastAreaDesc = item.da_description;
							lastAreaColor = item.dac_color;

						}
					});
					// create last polygon
					areaPolygon = L.polygon(listAreaPoint,{color:lastAreaColor}).bindPopup(lastAreaDesc);
					overlayMaps[lastAreaName] = areaPolygon;
					listAreaPoint = null;

					var layerPoly = L.control.layers(null, overlayMaps, {collapsed: true});
					markerAdditional['def_area'] =  layerPoly;
					map.addControl(markerAdditional['def_area']);

					// patch layerPoly to add some titles
					var patch = L.DomUtil.create('div', 'owm-layercontrol-header');
					patch.innerHTML = 'Area';
					layerPoly._form.children[0].parentNode.insertBefore(patch, layerPoly._form.children[0]);
				}
			});
		}
	}
	else {
		if (markerAdditional['def_area']!=undefined) {
			map.removeControl(markerAdditional['def_area']);
		}
	}
}
