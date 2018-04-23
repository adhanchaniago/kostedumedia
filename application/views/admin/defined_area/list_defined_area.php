<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.js"></script>

<!-- include js baru untuk dapat menampilkan koordinat titik kursor saat membuat area -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/util.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/geo.js"></script>

<script>
	$(document).ready(function(){
		<?php if ($this->session->flashdata('info')) { ?>
			$('.success').html("<strong> <?php echo $this->session->flashdata('info'); ?>");
			$('.success').attr('style','');
			$('.success').delay(10000).fadeOut('slow');
		<?php } ?>

		$('.delete-tab').click(function(){
			var page = $(this).attr("href");
			var $dialog = $('<div title="Hapus Area"></div>')
			.html('Semua terkait Area akan ikut dihapus! Hapus data area? <div class="clear"></div>').dialog({
				autoOpen: false,
				width: 280,
				show: "fade",
				hide: "fade",
				modal: true,
				resizable: false,
				buttons: {
					"Ok": function() {
						$(this).dialog("close");
						window.location = page;
					},
					"Cancel": function() {
						$(this).dialog("close");
					}
				}
			});
			$dialog.dialog('open');
			return false;
		});
	});

    function create_url() {
        var url = $('#form_search_filter').attr('action') + '/?filter=true&';
        var param = '';
        $('.filter_param').each(function() {
            param += $(this).attr('name') + '=' + $(this).val() + '&';
        });
        $('#form_search_filter').attr('action', url + param).submit();
    }

    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (!((charCode >= 48 && charCode <= 57) || (charCode == 46) || (charCode == 8) || (charCode == 9)))
            return false;

        return true;
    }

    function redirect(tail) {
        window.location = "<?php echo base_url() ?>admin/defined_area_ctrl/index"+ tail;
    } 

</script>
<script type="text/javascript"> 

function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 

document.onkeypress = stopRKey; 

</script> 
<style>
	#backlight{
		margin: -15px 0 0 0;
		position: absolute;
		cursor: pointer;
		width: 100%;
		background: rgba(0, 0, 0, 0.5);
	}

	#spotting-holder{
		width: 700px;
		left: 50%;
		margin: 20px 0 0 -355px;
		background: #eee;
		position: fixed;
		z-index: 999;
		padding: 5px;
	}
</style>
<div id="spotting-holder" style="display: none;"></div>
<div id="backlight" style="display: none;"></div>

<div id="main">
	<div class="clear " id="notif-holder"></div>
	<p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
	
	<p class="tit-form">Daftar Area <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
	<div class="filtering" style="display: none;">
		<form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
			<ul class="filter-form">
				<li>
					<label>Nama Area</label><br />
					<input type="text" placeholder="Nama Area" name="da_name" class='filter_param' value="<?php echo $this->input->get('da_name'); ?>" />
				</li>
			</ul>

			<div class="clear"></div>
			<div style="border-bottom: 1px dotted #DDD; margin: 15px 0 17px 0;"></div>

            <input type="button" value="Bersihkan Pencarian" onclick="document.location = '<?php echo base_url() . 'admin/defined_area_ctrl/index' ?>';" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
            <input type="button" value="Cari" name="search_filter" onclick="create_url();" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />

			<div class="clear"></div>
			<div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
		</form>
	</div>
	<table class="tab-admin">
		<thead>
			<tr class="tittab">
				<td class="header" style="width: 20px;">No</th>						
				<td class="header">Nama Area</td>
				<td class="header">Wilayah</td>
				<td class="header">Deskripsi</td>
				<td class="header delete" style="width: 80px;">Aksi</td>
			</tr>
		</thead>
		<tbody>
			<?php
				$count = 1;
				if(!empty($defined_area)){
					foreach($defined_area as $row) {?>
						<tr class="<?php echo alternator("row-two", "row-one"); ?>">
							<td><?php echo ($count++) + $offset;?></td>
							<td><?php echo $row->da_name;?></td>
							<td><?php echo $row->dac_description;?></td>
							<td><?php echo $row->da_description;?></td>
							<td class="action">
								<a href="<?php echo base_url(); ?>admin/defined_area_ctrl/view/<?php echo $row->da_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-view"></div></a> 
								<?php if (is_has_access('defined_area_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
									<a href="<?php echo base_url(); ?>admin/defined_area_ctrl/edit/<?php echo $row->da_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-edit"></div></a> 
								<?php } ?>
								<?php if (is_has_access('defined_area_ctrl-delete', $permission) || is_has_access('*', $permission)) { ?>
									<a href="<?php echo base_url(); ?>admin/defined_area_ctrl/delete/<?php echo $row->da_id . '?' . http_build_query($_GET) ?>" class="delete-tab"><div class="tab-delete"></div></a>
								<?php } ?>
							</td>
						</tr>
			<?php 		}
				}?>

		</tbody>
	</table>
	<br />
		<div class="pagination">
			<?php echo $pagination?>
		</div>
	<br />	
<?php if (is_has_access('defined_area_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
	<p id="form-pos" class="tit-form">Data Area</p>
	<form action="<?php echo base_url() ?>admin/defined_area_ctrl/save" method="post" id="definedArea">
		<?php if (!empty($obj)) { ?>
			<input type="hidden" name="da_id" value="<?php if (!empty($obj)) echo $obj->da_id; ?>" />
		<?php } ?>
		<ul class="form-admin">
			<li>
				<label>Nama Area *:</label>
				<input name="da_name" type="text" class="form-admin"
					   value="<?php if (!empty($obj)) echo $obj->da_name; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Wilayah *: </label>
				<select name="dac_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
					<option value="" selected>-Pilih Salah Satu-</option>
					<?php foreach($defined_area_categories as $defined_area_category){?>
						<option value="<?php echo $defined_area_category->dac_id ?>" <?php if(!empty($obj) && $obj->dac_id == $defined_area_category->dac_id) echo 'selected' ?>> <?php echo $defined_area_category->dac_description ?> </option>
					<?php } ?>
				</select>
				<div class="clear"></div>
			</li>
			<li>
				<label>Deskripsi Area:</label>
				<textarea rows="1" cols="1" name="da_description" class="form-admin"><?php if (!empty($obj)) echo $obj->da_description; ?></textarea>
				<div class="clear"></div>
			</li>
			<li>
				<label>Map:</label>
				<div id="map" style="width: 800px; height: 600px"></div>
			</li>
			<li>
				<div id="bounds_area_input">
					<?php 
						if(!empty($obj)){ 
							foreach($obj->point as $point){
								echo '<input type="hidden" value="'.$point->depoint_lat.'|'.$point->depoint_lon.'" name="area_point[]" />';
							}
						}
					?>
				</div>  
				<label>&nbsp;</label>
				<input type="button" value="Bersihkan Area Baru" onclick="clear_map()" class="button-form">
			</li>
			<li>
				<p class="tit-form"></p>
				<label>&nbsp;</label>
				<?php if (!isset($view)) { ?>
					<input class="button-form" type="submit" value="Simpan">
					<input class="button-form" type="reset" onclick="redirect('')" value="Batal">
				<?php } ?>
				<input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
			</li>
		</ul>
	</form>
</div>
<div class="clear"></div>

<script type="text/javascript">
	var all_area = <?php echo json_encode($defined_area_all);?>;
	var area_id = <?php echo (!(empty($obj)))?$obj->da_id:'false' ?>;
	var configMap = {
		latCenter : -2.108899,
		lonCenter : 117.509766,
		zoom :6,
		mapUrl : '<?php echo $this->config->item('map_url') ?>',
		mapStyleId : 22677
	};
	var minimal   = L.tileLayer(configMap.mapUrl, {styleId: configMap.mapStyleId,continuousWorld: 'false'});
	var southWest = new L.LatLng(85, -180);
	var northEast = new L.LatLng(-85, 180);
	var bounds = new L.LatLngBounds(southWest, northEast);
	var bounds_area_input = $("#bounds_area_input");

	//fixation for pan inside bounds
	L.Map.include({
		panInsideBounds: function(bounds) {
			bounds = L.latLngBounds(bounds);

			var viewBounds = this.getBounds(),
				viewSw = this.project(viewBounds.getSouthWest()),
				viewNe = this.project(viewBounds.getNorthEast()),
				sw = this.project(bounds.getSouthWest()),
				ne = this.project(bounds.getNorthEast()),
				dx = 0,
				dy = 0;

			if (viewNe.y < ne.y) { // north
				dy = ne.y - viewNe.y + Math.max(0, this.latLngToContainerPoint([85.05112878, 0]).y); // + extra vertical scroll
			}
			if (viewNe.x > ne.x) { // east
				dx = ne.x - viewNe.x;
			}
			if (viewSw.y > sw.y) { // south
				dy = sw.y - viewSw.y + Math.min(0, this.latLngToContainerPoint([-85.05112878, 0]).y - this.getSize().y); // + extra vertical scroll
			}
			if (viewSw.x < sw.x) { // west
				dx = sw.x - viewSw.x;
			}

			return this.panBy(new L.Point(dx, dy, true));
		}
	});

	//fixation for pan inside bounds
	var map = new L.map('map', {
		center: [configMap.latCenter, configMap.lonCenter],
		zoom: configMap.zoom,
		maxBounds : bounds,
		layers: [minimal],
		maxZoom : 15,
		minZoom : 3
	});

	var drawnItems = new L.FeatureGroup();
	map.addLayer(drawnItems);
	var drawControl = new L.Control.Draw({
		draw: {
			position: 'topleft',
			polygon: {
				title: 'Membuat Area Polygon',
				allowIntersection: false,
				drawError: {
					color: '#b00b00',
					timeout: 1000
				},
				shapeOptions: {
					color: '#bada55'
				}
			},
			circle: false,
			polyline : false,
			rectangle : false
		},
		edit:false
	});
	var draw_polygon = new L.Draw.Polygon(map, drawControl.options.polygon);
	if(area_id==false){
		draw_polygon.enable();
	}
	map.on('draw:created', function (e) {
		var type = e.layerType,layer = e.layer;
		switch(type){
			case 'polygon' : console.log(layer);
				$.each(layer._latlngs,function(i,item){
					bounds_area_input.append('<input type="hidden" name="area_point[]" value="'+item.lat+'|'+item.lng+'" />');
				});
				break;
			case 'circle' : console.log(layer);
				break;
			case 'marker' : console.log(layer);
				break;
		
		}
		drawnItems.addLayer(layer);
		// console.log(drawnItems);
	});
	
	var polygon_area = [];
	var temp_array_point = [];
	$.each(all_area,function(i,area){
		$.each(area.point,function(i,point){
			temp_array_point.push([parseFloat(point.depoint_lat),parseFloat(point.depoint_lon)]);
		});
		polygon_area[i] = new L.Polygon(temp_array_point,{color:area.color,weight:2,fillOpacity:0.5}).bindLabel(area.name);
		map.addLayer(polygon_area[i]);
		if(area_id!==false && i==area_id){
			polygon_area[i].editing.enable();
			polygon_area[i].on('edit',function(e){
				bounds_area_input.empty();
				$.each(e.target._latlngs,function(i,edit_point){
					
					bounds_area_input.append('<input type="hidden" name="area_point[]" value="'+edit_point.lat+'|'+edit_point.lng+'" />');
				});
			});
		}
		temp_array_point = [];
	});
	
	function clear_map(){
		$.each(drawnItems._layers,function(i,item){
			map.removeLayer(item);
		});
		bounds_area_input.empty();
		draw_polygon.enable();
	}

	// for displaying current mouse coordinate
	var attrib = new L.Control.Attribution;
	map.addControl(attrib); 
	attrib.setPrefix('Koordinat: ');

	/*mouse movement will affect coordinate view on right-bottom corner of map*/
	function onMouseMove(e) {
		attrib.setPrefix('Koordinat: '+viewableCoordinate(e.latlng.lat,'lat') + ", " + viewableCoordinate(e.latlng.lng,'lon')+'. Zoom:'+map.getZoom());
	}
	map.on('mousemove', onMouseMove);

	</script>
<?php } ?>