<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/util.js"> </script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/geo.js"></script>

<script>
	$(document).ready(function(){
		<?php if ($this->session->flashdata('info')) { ?>
			$('.success').html("<strong> <?php echo $this->session->flashdata('info'); ?>");
			$('.success').attr('style','');
			$('.success').delay(10000).fadeOut('slow');
		<?php } ?>

		$("#definedArea").validate({
			rules:{
				poi_id: "required",
				// aptype_id : "required",
				// operation_id : "required",
				poi_name: "required",
				poi_description: "required",
				// poi_icon: "required",
				poi_lat: "required",
				poi_lon: "required"
			},
			messages:{
				poi_id:"required",
				// aptype_id : "Harus diisi!",
				// operation_id : "Harus diisi!",
				poi_name: "Harus diisi!",
				poi_description: "Harus diisi!",
				// poi_icon: "harus diisi!",
				poi_lat: "Harus diisi!",
				poi_lon: "Harus diisi!"
			}
		});

		$('.delete-tab').click(function(){
			var page = $(this).attr("href");
			var $dialog = $('<div title="Hapus Area POI"></div>')
			.html('Semua terkait Area POI akan ikut dihapus! Hapus data area POI? <div class="clear"></div>').dialog({
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
	

	function isNumberKey(evt)
	{
		var charCode = (evt.which) ? evt.which : evt.keyCode
		if (!((charCode >= 48 && charCode <= 57) || (charCode == 46) || (charCode == 8) || (charCode == 9)))
			return false;

		return true;
	}
	function create_url(){
		var url = $('#form_search_filter').attr('action')+'/?filter=true&';
		var param = '';
		$('.filter_param').each(function(){
			param += $(this).attr('name')+'='+$(this).val()+'&';
		});
		
		$('#form_search_filter').attr('action',url+param).submit();
	}

	
	function redirect(){
		window.location = "<?php echo base_url() ?>admin/poi_ctrl";
	}



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
<!-- Added by D3 - Disable enter -->
<script type="text/javascript"> 
function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = stopRKey; 
</script> 
<div id="spotting-holder" style="display: none;"></div>
<div id="backlight" style="display: none;"></div>

<div id="main">
	<div class="clear " id="notif-holder"></div>
	<p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data POI berhasil disimpan.</p>
	
	<p class="tit-form">Daftar POI <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
	<div class="filtering" style="display: none;">
		<form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
			<ul class="filter-form">
				<li>
					<label>Nama POI</label><br />
					<input type="text" placeholder="Nama Area" name="poi_name" class='filter_param' value="<?php echo $this->input->get('poi_name'); ?>" onkeypress="search_enter_press(event);" />
				</li>
			</ul>

			<div class="clear"></div>
			<div style="border-bottom: 1px dotted #DDD; margin: 15px 0 17px 0;"></div>
			<input type="button" value="Bersihkan Pencarian" onclick="redirect('')" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
			<input type="button" value="Cari" name="search_filter" onclick="create_url()" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
			<div class="clear"></div>
			<div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
		</form>
	</div>
	<table class="tab-admin">
		<thead>
			<tr class="tittab">
				<td class="header" style="width: 20px;">No</th>                     
				<td class="header">Nama POI</td>
				<td class="header">POI Icon</td>
				<td class="header">Deskripsi</td>
				<td class="header">Lintang</td>
				<td class="header">Bujur</td>
				<td class="header delete" style="width: 60px;">Aksi</td>
			</tr>
		</thead>
		<tbody>
			<?php
				$count=1;
				if(!empty($pois)){
					foreach($pois as $row) {?>
						<tr class="<?php echo alternator("row-two", "row-one"); ?>">
							<td><?php echo ($count++) + $offset;?></td>
							<td><?php echo $row->poi_name;?></td>
							<td>
								<?php if ($row->poi_icon != null || $row->poi_icon != '') { ?>
									<img src="<?php echo base_url() ?>assets/img/upload/icon/IconPoi/<?php echo $row->poi_icon ?>"/>
								<?php } else { ?>
									<span style="font-weight:bold;">Ikon tidak ada</span>
								<?php } ?>
							</td>
							<td><?php echo $row->poi_description;?></td>
							<td><?php echo geoComponent($row->poi_lat, 'a', 'lat'); ?></td>
							<td><?php echo geoComponent($row->poi_lon, 'a', 'lon'); ?></td>
							<td class="action">
								<?php if (is_has_access('poi_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
								<a href="<?php echo base_url();?>admin/poi_ctrl/edit/<?php echo $row->poi_id?>"><div class="tab-edit"></div></a> 
								<?php }?>
								<?php if (is_has_access('poi_ctrl-delete', $permission) || is_has_access('*', $permission)) { ?>
								<a href="<?php echo base_url();?>admin/poi_ctrl/delete/<?php echo $row->poi_id?>" class="delete-tab"><div class="tab-delete"></div></a>
								<?php }?>
							</td>
						</tr>
			<?php       }
				}?>

		</tbody>
	</table>
	<br />
		<div class="pagination">
			<?php echo $pagination?>
		</div>
	<br />  


<?php if (is_has_access('poi_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
	<p class="tit-form">Entri Data POI</p>
	<form action="<?php echo base_url() ?>admin/poi_ctrl/save" method="post" id="definedArea" enctype="multipart/form-data">
		<?php if (!empty($obj)) { ?>
			<input type="hidden" name="poi_id" value="<?php if (!empty($obj)) echo $obj->poi_id; ?>" />
		<?php } ?>
		<ul class="form-admin">
			 <li>
					<label>Operation Name *</label>
					<?php
					if (!empty($obj))
						if (isset($view)) {
							echo form_dropdown('operation_id', $operation, $obj->operation_id, 'class="form-admin" disabled');
						} else {
							echo form_dropdown('operation_id', $operation, $obj->operation_id, 'class="form-admin"');
						}
					else
						echo form_dropdown('operation_id', $operation, '', 'class="form-admin"');
					?>

					<div class="clear"></div>
			</li>

			 <li>
					<label>POI Type *</label>
					<?php
					if (!empty($obj))
						if (isset($view)) {
							echo form_dropdown('aptype_id', $aptype, $obj->aptype_id, 'class="form-admin" disabled');
						} else {
							echo form_dropdown('aptype_id', $aptype, $obj->aptype_id, 'class="form-admin"');
						}
					else
						echo form_dropdown('aptype_id', $aptype, '', 'class="form-admin"');
					?>

					<div class="clear"></div>
			</li>

			<li>
				<label>Nama POI:</label>
				<input name="poi_name" type="text" class="form-admin"
					   value="<?php if (!empty($obj)) echo $obj->poi_name; ?>" >
				<div class="clear"></div>
			</li>
			<li>
			<?php if (!empty($obj)) { ?>
					<label style="margin-left:110px;" >
						<?php if ($obj->poi_icon != null || $obj->poi_icon != '') { ?>
							<img src="<?php echo base_url() ?>assets/img/upload/icon/IconPoi/<?php echo $obj->poi_icon ?>"/>
						<?php } else { ?>
							<span style="font-weight:bold;">Ikon tidak ada</span>
						<?php } ?>
					</label>
					<div class="clear"></div>
				<?php } ?>
				<label>Ikon </label>
				<input type="file" name="poi_icon" />
				
				<?php if (!empty($obj) && ($obj->poi_icon != null || $obj->poi_icon != '')) { ?>
					<p style="margin-left:210px;color:red;">*Abaikan apabila Ikon tidak akan diubah</p>
				<?php } ?>
				<p style="margin-left:210px;color:red;">*Tipe File Ikon yang diperbolehkan : .gif atau. png atau .jpg atau .jpeg</p>
				<p style="margin-left:210px;color:red;">*Maksimum File Ikon adalah 1 MB (Megabtye) 700x700 px </p>
				<div class="clear"></div>
			</li>
			<li>
				<label>Deskripsi POI:</label>
				<textarea rows="1" cols="1" name="poi_description" class="form-admin"><?php if (!empty($obj)) echo $obj->poi_description; ?></textarea>
				<div class="clear"></div>
			</li>
			<li>
				<label>Lintang </label>
				<input class="form-admin two-digit" name="poi_dlat" maxlength="3"  maxlength="3" type="text" class="text-medium" 
						value="<?php if (!empty($obj)) echo geoComponent($obj->poi_lat, 'd'); ?>"onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
				<input class="form-admin two-digit" name="poi_mlat" maxlength="2"  type="text" class="text-medium" 
						value="<?php if (!empty($obj)) echo geoComponent($obj->poi_lat, 'm'); ?>"onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
				<input class="form-admin two-digit" name="poi_slat" maxlength="2"  type="text" class="text-medium" 
					   value="<?php if (!empty($obj)) echo geoComponent($obj->poi_lat, 's'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

				<?php
				$stat = 'class="form-admin" style="width: 47px;"';
				

				if (!empty($obj))
					echo form_dropdown('poi_rlat', array(1 => 'U', -1 => 'S'), geoComponent($obj->poi_lat, 'r'), $stat);
				else
					echo form_dropdown('poi_rlat', array(1 => 'U', -1 => 'S'), '', $stat);
				?>

				<?php echo form_error('poi_lat'); ?>
				<div class="clear"></div>
			</li>
			<li>
				<label>Bujur </label>
				<input class="form-admin two-digit" name="poi_dlon" maxlength="3" type="text" class="text-medium" 
						value="<?php if (!empty($obj)) echo geoComponent($obj->poi_lon, 'd'); ?>"onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
				<input class="form-admin two-digit" name="poi_mlon" maxlength="2" type="text" class="text-medium" 
					   value="<?php if (!empty($obj)) echo geoComponent($obj->poi_lon, 'm'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
				<input class="form-admin two-digit" name="poi_slon" maxlength="2" type="text" class="text-medium" 
						value="<?php if (!empty($obj)) echo geoComponent($obj->poi_lon, 'r'); ?>"onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

				<?php
				$stat = 'class="form-admin" style="width: 47px;"';
				
				if (!empty($obj))
					echo form_dropdown('poi_rlon', array(1 => 'T', -1 => 'B'), geoComponent($obj->poi_lon, 'r'), $stat);
				else
					echo form_dropdown('poi_rlon', array(1 => 'T', -1 => 'B'), '', $stat);
				?>

				<?php echo form_error('poi_lon'); ?>
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
								echo '<input type="hidden" value="'.$point->poi_lat.'|'.$point->poi_lon.'" name="area_poi[]" />';
							}
						}
					?>
				</div>
				<br />

				<p class="tit-form"></p>

				<label>&nbsp;</label>
				<input type="reset" value="Reset" class="button-form">
				<!-- <input class="button-form" type="submit" value="Simpan"> -->
				<input type="submit" value="<?php if (empty($obj)) echo 'Simpan'; else echo 'Ubah'; ?> " class="button-form">
				<!-- <input type="reset" value="Batalkan" class="button-form"> -->
			</li>
		</ul>
	</form>
</div>
<div class="clear"></div>

<script type="text/javascript">
	var all_area = <?php echo json_encode($poi_icon);?>;
	// console.log(all_area);
	var poi_id = <?php echo (!(empty($obj)))?$obj->poi_id:'false' ?>;
	var configMap = {
		latCenter : -2,
		lonCenter : 112,
		zoom :6,
		mapUrl : '<?php echo $this->config->item('map_url') ?>',
		mapStyleId : 22677
	};
	var minimal   = L.tileLayer(configMap.mapUrl, {styleId: configMap.mapStyleId});
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
		// maxBounds : bounds,
		layers: [minimal],
		maxZoom : 15,
		minZoom : 3
	});

	//view Data Icon in Map
	setMarkers(map,all_area);

	function setMarkers(map,data) {
		
		// console.log(data);
		// console.log(data[2].poi_lat);
		// console.log(data[2].poi_lon);
		var transarrow, as;

		for (var i=0; i<data.length; i++){
			as = data[i].poi_icon;
			// console.log(as);    
			transarrow = L.icon({  
				iconUrl: '../assets/img/upload/icon/IconPoi/'+as, 
				iconSize: [30, 30],
				iconAnchor: [15, 15]
			});

			mark = new L.marker([data[i].poi_lat, data[i].poi_lon,], {icon: transarrow})
				.bindLabel('Nama Poi: '+data[i].poi_name+
						   '</br> Deskripsi: '+data[i].poi_description+
						   '</br> Latitude: '+viewableCoordinate(data[i].poi_lat,'lat')+
						   '</br> Longitude: '+viewableCoordinate(data[i].poi_lon,'lng'), 
						   {noHide: true}
						 );
			map.addLayer(mark);
			// console.log('Data Ke:'+i);
		}        
		// console.log('tes');
	}



	var drawnItems = new L.FeatureGroup();
	map.addLayer(drawnItems);

	//View for Longitude and Latitude topright in the map
	var attrib = new L.Control.Attribution({position: 'topright'});
	map.addControl(attrib);
	attrib.setPrefix('Koordinat : ');
	
	function onMouseMove(e) {
		// console.log(e);
		var latlng = e.latlng;

		// attrib.setPrefix('Koordinat : latitude :'+latlng.lat + ', longitude :' + latlng.lng);        
		attrib.setPrefix('Koordinat : '+viewableCoordinate(latlng.lat,'lat') + ", " + viewableCoordinate(latlng.lng,'lng'));
		
		// console.log(latlng)
		// console.log(latlng.lat)
		// console.log(e)
	}

	map.on('mousemove', onMouseMove);
	
	function clear_map(){
		$.each(drawnItems._layers,function(i,item){
			map.removeLayer(item);
		});
		bounds_area_input.empty();
		draw_polygon.false();
	}

	</script>
	
<?php } ?>