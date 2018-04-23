<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.js"></script>
<!-- <script type="text/javascript" src="<?php echo $this->config->item('socket_ip') ?>/socket.io/socket.io.js"></script> -->
<?php if ($this->session->flashdata('info')) { ?>
	<script>
		// var socket = io.connect('<?php echo $this->config->item('socket_ip') ?>'); // commented by SKM17
		// socket.emit('reqAeroplaneUpdate');

		$(document).ready(function() {
			$('.success').html("<strong> <?php echo $this->session->flashdata('info'); ?>");
			$('.success').attr('style', '');
			$('.success').delay(10000).fadeOut('slow');
		});
	</script>
<?php } ?>
<script>
	$(document).ready(function() {
		$('.pilih-status').change(function() {
			if ($(this).val() == 'sandar') {
				$('.tempat-sandar').slideDown('fast');
			} else {
				$('.tempat-sandar').slideUp('fast');
			}
		});
		$("#addAeroPosition").validate({
			rules: {
				aer_id: "required"
			},
			messages: {
				aer_id: "required"
			}
		});
		$("#aer_timestamp_date").datepicker({dateFormat: 'yy-mm-dd', maxDate: '0'});
		//        $('#ship_machinehour').timepicker({ 'timeFormat': 'H:i:s' });
		//        $('#ship_currenthour').timepicker({ 'timeFormat': 'H:i:s' });
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
	function redirect() {
		window.location = "<?php echo base_url() ?>admin/aeroplane_ctrl/position";
	}
</script>

<div id="main">

	<div class="clear " id="notif-holder"></div>
	<p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data Pesud berhasil disimpan.</p>

	<?php 
	
	if (empty($aeroplane)) { ?>
		<p class="notif attention">
			<strong>Data Pesud tidak ditemukan</strong>
			Sistem tidak menemukan data Pesud pada SSAT. Silahkan terlebih dahulu melengkapi data Pesud untuk mengatur posisi Pesud.
			Mohon maaf atas ketidaknyamanan ini
		</p>
	<?php } ?>

	<p class="tit-form">Posisi Pesawat Udara<a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
	<div class="filtering" style="display: none;">
		<form action="<?php echo base_url() . 'admin/aeroplane_ctrl/position' ?>" method="post" id="form_search_filter">
			<ul class="filter-form">
				<li>
					<label>Nama Pesawat</label><br />
					<input type="text" placeholder="Nama Pesawat" name="aer_name" class='filter_param' value="<?php echo $this->input->get('aer_name'); ?>" onkeypress="search_enter_press(event);" />
				</li>
				<!--<li>
					<label>Skuadron</label><br />
					<select name="station_id" class='filter_param'>
						<option value="">Skuadron</option>
				<?php foreach ($skuadron as $row) { ?>
					<?php if (($this->input->get('station_id')) && $this->input->get('station_id') == $row->station_id) { ?>
																						<option value="<?php echo $row->station_id ?>" selected><?php echo $row->station_name ?></option>
					<?php } else { ?>
																						<option value="<?php echo $row->station_id ?>"><?php echo $row->station_name ?></option>
					<?php } ?>
				<?php } ?>
					</select>
				</li>-->
				<li>
					<label>Tipe Pesawat</label><br />
					<select name="aertype_id" class='filter_param'>
						<option value="">-Pilih Tipe Pesawat-</option>
						<?php foreach ($aeroplane_type as $row) { ?>
							<?php if (($this->input->get('aertype_id')) && $this->input->get('aertype_id') == $row->aertype_id) { ?>
								<option value="<?php echo $row->aertype_id ?>" selected><?php echo $row->aertype_name ?></option>
							<?php } else { ?>
								<option value="<?php echo $row->aertype_id ?>"><?php echo $row->aertype_name ?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</li>
				<li>
					<label>Pembina</label><br />
					<select name="corps_id" class='filter_param'>
						<option value="">-Pilih Pembina-</option>
						<?php foreach ($corps as $row) { ?>
							<?php if (($this->input->get('corps_id')) && $this->input->get('corps_id') == $row->corps_id) { ?>
								<option value="<?php echo $row->corps_id ?>" selected><?php echo $row->corps_name ?></option>
							<?php } else { ?>
								<option value="<?php echo $row->corps_id ?>"><?php echo $row->corps_name ?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</li>
				<li> <!-- added by SKM17 -->
					<label>Kodal</label><br />
					<select name="kodal_id" class='filter_param'>
						<option value="">-Pilih Kodal-</option>
						<?php foreach ($kodals as $row) { ?>
							<?php if (($this->input->get('kodal_id')) && $this->input->get('kodal_id') == $row->corps_id) { ?>
								<option value="<?php echo $row->corps_id ?>" selected><?php echo $row->corps_name ?></option>
							<?php } else { ?>
								<option value="<?php echo $row->corps_id ?>"><?php echo $row->corps_name ?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</li>
				<div class="clear"></div>
				<li>
					<label>Tanggal Dislokasi Unsur Pesud</label><br/>
					<input type="text" class="filter_param" name="aer_timestamp_date" id='aer_timestamp_date' readonly value="<?php echo $this->input->get('aer_timestamp_date') ?>"/>
				</li>
				 <li>
					<!-- Added by KP D3 -->
					<label>Nama Operasi</label><br />
					<select name="operation_id" class='filter_param'>
						<option value="">-Pilih Nama Operasi-</option>
						<?php foreach ($operation as $row) { ?>
							<?php if (($this->input->get('operation_id')) && $this->input->get('operation_id') == $row->operation_id) { ?>
								<option value="<?php echo $row->operation_id ?>" selected><?php echo $row->operation_name ?></option>
							<?php } else { ?>
								<option value="<?php echo $row->operation_id ?>"><?php echo $row->operation_name ?></option>
							<?php } ?>
						<?php } ?>

					</select>
					<!-- End Added -->
				</li>
				<li>
					<label>Waktu Dislokasi Unsur Pesud</label><br/>
					<select name="aer_timestamp_time" class="filter_param">
						<option value="">-Pilih Waktu-</option>
						<option value="06:00" <?php if ($this->input->get('aer_timestamp_time') == '06:00') echo 'selected' ?>>06:00</option>
						<option value="18:00" <?php if ($this->input->get('aer_timestamp_time') == '18:00') echo 'selected' ?>>18:00</option>
					</select>
				</li>
			</ul>

			<div class="clear"></div>
			<div style="border-bottom: 1px dotted #DDD; margin: 15px 0 17px 0;"></div>

			<input type="button" value="Bersihkan Pencarian" onclick="document.location = '<?php echo base_url() . 'admin/aeroplane_ctrl/position' ?>';" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
			<input type="button" value="Cari" name="search_filter" onclick="create_url();" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />

			<div class="clear"></div>
			<div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
		</form>
	</div>
	<table class="tab-admin">
		<thead>
			<tr class="tittab">
				<td class="header" rowspan="2" style="width: 5px;">No</td>						
				<td class="header" rowspan="2" style="width: 10px;">Nama Pesawat</td>
				<td class="header" rowspan="2">Nama Operasi</td>
				<td class="header" rowspan="2">Pembina</td>
				<td class="header" rowspan="2">Kodal</td>
				<td class="header" rowspan="2">Pilot</td>
				<td class="header" colspan="3" style="width: 60px;">Posisi</td>
				<td class="header" rowspan="2" style="width:10px;">Status</td>
				<?php if (isset($isSearchTime)) { ?>
					<td class="header" rowspan="2" style="width: 15px;">Waktu</td>
				<?php }
				
				if (!empty($aeroplane) && isset($aeroplane[0]->aerdis_lat)) { ?>
				<?php } else { ?>
				<td class="header delete" rowspan="2" style="width: 52px;">Aksi</td>
				<?php } ?>
			</tr>
			<tr class="tittab">
				<td class="header">Lintang</td>
				<td class="header">Bujur</td>
				<td class="header">Lokasi</td>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 1;
			if (!empty($aeroplane)) {
				foreach ($aeroplane as $row) {
					?>
					<tr class="<?php echo alternator("row-one", "row-two"); ?>">
						<td><?php echo ($i++) + $offset; ?></td>
						<td><?php echo $row->aer_name ?></td>
						<td><?php echo $row->operation_name ?></td>
						<!--<td><?php echo $row->aertype_name ?></td>-->
						<td><?php echo $row->corps_name ?></td>
						<td><?php echo $row->kodal_name ?></td>
						<td><?php echo $row->pilot_name ?></td>
						<td><?php echo geoComponent($row->aer_lat, 'a', 'lat'); ?></td>
						<td><?php echo geoComponent($row->aer_lon, 'a', 'lon'); ?></td>
						<td><?php echo $row->aer_location ?></td>
						<td><?php echo $row->aercond_description ?></td>
						<?php if (isset($isSearchTime)) { ?>
							<td><?php echo $row->aerdis_date . ' ' . $row->aerdis_time ?></td>
						<?php }
						
						if(isset($row->aerdis_lat)){ ?>
						<?php }else{?>
						<td class="action" style="width: 52px;">
							<a href="<?php echo base_url(); ?>admin/aeroplane_ctrl/view_position/<?php echo $row->aer_id . '?' . http_build_query($_GET) . '#form-pos' ?>" ><div class="tab-view"></div></a> 
							<a href="<?php echo base_url(); ?>admin/aeroplane_ctrl/edit_position/<?php echo $row->aer_id . '?' . http_build_query($_GET) . '#form-pos' ?>" class="edit-tab"><div class="tab-edit"></div></a> 
						</td>
						<?php }?>
					</tr>
					<?php
				}
			}
			?>
		</tbody>
	</table>
	<br />
	<div class="pagination">
		<?php echo $pagination ?>
	</div>
	<br />

	<?php
	#this part should be hidden if 
	if (!empty($obj)) {// print_r($obj); die();
		?>
		<p id="form-pos" class="tit-form">Tambah Posisi Pesawat Udara</p>
		<form action="<?php echo base_url() ?>admin/aeroplane_ctrl/save_position<?php echo '?' . http_build_query($_GET) ?>" method="post" id="addAeroPosition">
			<ul class="form-admin">
				<?php if (!empty($obj)) { ?>
					<input type="hidden" name="aer_id" value="<?php echo $obj->aer_id; ?>" />
				<?php } ?>
				<li>
					<label>Nama Pesawat * </label>
					<input class="form-admin" type="text" class="text-medium" 
						   value="<?php if (!empty($obj)) echo $obj->aer_name; ?>" <?php if (!empty($obj)) echo 'disabled'; ?> >
						   <?php echo form_error('aer_name'); ?>					
					<div class="clear"></div>
				</li>
				<input type="hidden" name="aer_name" id="aer_name" value="<?php if (!empty($obj)) echo $obj->aer_name; ?>" />
				<li> <!-- added by SKM17 -->
					<label>Kodal</label>
					<select name="kodal_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
						<option value="" selected>-Pilih Kodal-</option>
						<?php foreach ($kodals as $row) { ?>
							<?php if ((!empty($obj)) && $obj->kodal_id == $row->corps_id) { ?>
								<option value="<?php echo $row->corps_id ?>" selected><?php echo $row->corps_name ?></option>
							<?php } else { ?>
								<option value="<?php echo $row->corps_id ?>"><?php echo $row->corps_name ?></option>
							<?php } ?>
						<?php } ?>
					</select>

					<div class="clear"></div>
				</li>
				<li> <!-- added by SKM17 -->
					<label>Pilot</label>
					<input class="form-admin" name="pilot_name" type="text" class="text-medium" value="<?php if (!empty($obj)) echo $obj->pilot_name; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>>
					<?php echo form_error('pilot_name'); ?>					
					<div class="clear"></div>
				</li>
<?php if (!isset($view)) { ?>
				<li>
					<label>Pilih Lokasi</label>
					<select id="locations" class="form-admin" onchange="ChooseLocation(this)" >
						<option value="" selected>-Pilih Salah Satu-</option>
						<?php foreach ($ports as $row) { 
							$theValue = '{ name: \'' . $row->port_name . 
								'\', dlat: ' . geoComponent($row->port_lat, 'd') .
								', mlat: ' . geoComponent($row->port_lat, 'm') .
								', slat: ' . geoComponent($row->port_lat, 's') .
								', rlat: ' . geoComponent($row->port_lat, 'r') .
								', dlon: ' . geoComponent($row->port_lon, 'd') .
								', mlon: ' . geoComponent($row->port_lon, 'm') .
								', slon: ' . geoComponent($row->port_lon, 's') .
								', rlon: ' . geoComponent($row->port_lon, 'r') .
								' }';
							?>
							<option value="<?php echo $theValue ?>" ><?php echo $row->port_name ?></option>
						<?php } ?>
						<?php foreach ($onboards as $row) { 
							$theValue = '{ name: \'O.B KRI ' . $row->ship_abbr . 
								'\', dlat: ' . geoComponent($row->ship_lat, 'd') .
								', mlat: ' . geoComponent($row->ship_lat, 'm') .
								', slat: ' . geoComponent($row->ship_lat, 's') .
								', rlat: ' . geoComponent($row->ship_lat, 'r') .
								', dlon: ' . geoComponent($row->ship_lon, 'd') .
								', mlon: ' . geoComponent($row->ship_lon, 'm') .
								', slon: ' . geoComponent($row->ship_lon, 's') .
								', rlon: ' . geoComponent($row->ship_lon, 'r') .
								' }';
							?>
							<option value="<?php echo $theValue ?>" ><?php echo 'O.B KRI ' . $row->ship_abbr ?></option>
						<?php } ?>
					</select>

					<div class="clear"></div>
				</li>
<?php } ?>
				<li>
					<label>Lokasi </label>
					<input class="form-admin" name="aer_location" id="aer_location" type="text" class="text-medium" value="<?php if (!empty($obj)) echo $obj->aer_location; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>>
					<?php echo form_error('aer_location'); ?>                   
					<div class="clear"></div>
				</li>
				<?php if (!empty($obj) && $obj->aer_isrealtime == 't') { ?>
					<input type="hidden" name="aer_dlat" id="aer_dlat" value="<?php echo geoComponent($obj->aer_lat, 'd'); ?>" />
					<input type="hidden" name="aer_mlat" id="aer_mlat" value="<?php echo geoComponent($obj->aer_lat, 'm'); ?>" />
					<input type="hidden" name="aer_slat" id="aer_slat" value="<?php echo geoComponent($obj->aer_lat, 's'); ?>" />
					<input type="hidden" name="aer_rlat" id="aer_rlat" value="<?php echo geoComponent($obj->aer_lat, 'r'); ?>" />

					<input type="hidden" name="aer_dlon" id="aer_dlon" value="<?php echo geoComponent($obj->aer_lon, 'd'); ?>" />
					<input type="hidden" name="aer_mlon" id="aer_mlon" value="<?php echo geoComponent($obj->aer_lon, 'm'); ?>" />
					<input type="hidden" name="aer_slon" id="aer_slon" value="<?php echo geoComponent($obj->aer_lon, 's'); ?>" />
					<input type="hidden" name="aer_rlon" id="aer_rlon" value="<?php echo geoComponent($obj->aer_lon, 'r'); ?>" />
				<?php } ?>

				<li>
					<label>Lintang </label>
					<input class="form-admin two-digit" name="aer_dlat" id="aer_dlat" maxlength="3"  maxlength="3" type="text" class="text-medium" <?php if (!empty($obj) && $obj->aer_isrealtime == 't') echo "readonly" ?>
					   value="<?php if (!empty($obj)) echo geoComponent($obj->aer_lat, 'd'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
					<input class="form-admin two-digit" name="aer_mlat" id="aer_mlat" maxlength="2"  type="text" class="text-medium" <?php if (!empty($obj) && $obj->aer_isrealtime == 't') echo "readonly" ?>
					   value="<?php if (!empty($obj)) echo geoComponent($obj->aer_lat, 'm'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
					<input class="form-admin two-digit" name="aer_slat" id="aer_slat" maxlength="2"  type="text" class="text-medium" <?php if (!empty($obj) && $obj->aer_isrealtime == 't') echo "readonly" ?>
					   value="<?php if (!empty($obj)) echo geoComponent($obj->aer_lat, 's'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

					<?php
					$stat = 'class="form-admin" style="width: 47px;"';
					if (!empty($obj) && $obj->aer_isrealtime == 't' || isset($view))
						$stat = 'disabled="disabled"';

					if (!empty($obj))
						echo form_dropdown('aer_rlat', array(1 => 'U', -1 => 'S'), geoComponent($obj->aer_lat, 'r'), $stat);
					else
						echo form_dropdown('aer_rlat', array(1 => 'U', -1 => 'S'), '', $stat);
					?>

					<?php echo form_error('aer_lat'); ?>
					<div class="clear"></div>
				</li>
				<li>
					<label>Bujur </label>
					<input class="form-admin two-digit" name="aer_dlon" id="aer_dlon" maxlength="3" type="text" class="text-medium" <?php if (!empty($obj) && $obj->aer_isrealtime == 't') echo "readonly" ?>
					   value="<?php if (!empty($obj)) echo geoComponent($obj->aer_lon, 'd'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
					<input class="form-admin two-digit" name="aer_mlon" id="aer_mlon" maxlength="2" type="text" class="text-medium" <?php if (!empty($obj) && $obj->aer_isrealtime == 't') echo "readonly" ?>
					   value="<?php if (!empty($obj)) echo geoComponent($obj->aer_lon, 'm'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
					<input class="form-admin two-digit" name="aer_slon" id="aer_slon" maxlength="2" type="text" class="text-medium" <?php if (!empty($obj) && $obj->aer_isrealtime == 't') echo "readonly" ?>
					   value="<?php if (!empty($obj)) echo geoComponent($obj->aer_lon, 's'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

					<?php
					$stat = 'class="form-admin" style="width: 47px;"';
					if (!empty($obj) && $obj->aer_isrealtime == 't' || isset($view))
						$stat = 'disabled="disabled"';

					if (!empty($obj))
						echo form_dropdown('aer_rlon', array(1 => 'T', -1 => 'B'), geoComponent($obj->aer_lon, 'r'), $stat);
					else
						echo form_dropdown('aer_rlon', array(1 => 'T', -1 => 'B'), '', $stat);
					?>

					<?php echo form_error('aer_lon'); ?>
					<div class="clear"></div>
				</li>
				<!-- added by D3 KP -->
				<li>
					<label>Map</label>
					<div id="map" style="width: 400px; height: 200px;margin-left:20%;"></div>
					<script type="text/javascript">
	
						var osmUrl='<?php echo $this->config->item('map_url') ?>';
						var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
						var osm = new L.TileLayer(osmUrl, {minZoom: 1, maxZoom: 18, attribution: osmAttrib});

						map = L.map('map', {
							zoomControl: true,
							layers: [osm]
						}).setView(new L.LatLng(<?php echo $obj->aer_lat; ?>, <?php echo $obj->aer_lon; ?>),7);

					</script>


				<?php
					$icon_name;
					foreach ($aeroplane as $row)
					{
							foreach ($aeroplane_icon as $key) {
							   if($row->aericon_id == $key->aericon_id){
								  $icon_name = $key->aericon_file;
								}
						 }

				?>

				<script>
					var aer = new Array();
					var myIcon = L.icon({
					iconUrl: "<?php echo base_url().'assets/img/icon-aeroplane/'.$icon_name;?>",
					iconSize: [30, 30],
					iconAnchor: [9, 21],
					popupAnchor: [0, -14]
				});
				   aer[<?php echo $row->aer_id; ?>] = L.marker([<?php echo $row->aer_lat; ?>,<?php echo $row->aer_lon; ?>], {icon: myIcon} )
				   .bindPopup( "<?=$row->aer_name.' - '.$row->aer_id; ?>" )
				   .addTo(map);
					
				</script>
				 <?php 
				} ?>
				
				<li>
					<label>Kecepatan </label>
					<input class="form-admin" name="aer_speed" maxlength="4" type="text" class="text-medium"
						   value="<?php if (!empty($obj)) echo $obj->aer_speed; ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
					<?php echo form_error('aer_speed'); ?>									<div class="clear"></div>
				</li>
				<li>
					<label>Jangkauan </label>
					<input class="form-admin" name="aer_endurance" maxlength="5" type="text" class="text-medium"
						   value="<?php if (!empty($obj)) echo $obj->aer_endurance; ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
						   <?php echo form_error('aer_endurance'); ?>					
					<div class="clear"></div>
				</li>
				<input type="hidden" name="operation_id" value="<?php echo $obj->operation_id ?>" />
				<!--<li>
					<label>Keterangan</label>
					<textarea class="form-admin" name="aer_desc" <?php if (isset($view)) echo 'disabled'; ?>><?php if (!empty($obj)) echo $obj->aer_desc ?></textarea>
					<div class="clear"></div>
				</li>-->
				
				<!-- added by SKM17 -->
				<li>
					<label>Nama Operasi</label>
					<select name="operation_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
						<option value="" selected>-Pilih Operasi-</option>
						<?php foreach ($operation as $row) { ?>
							<?php if ((!empty($obj)) && $obj->operation_id == $row->operation_id) { ?>
								<option value="<?php echo $row->operation_id ?>" selected><?php echo $row->operation_name ?></option>
							<?php } else { ?>
								<option value="<?php echo $row->operation_id ?>"><?php echo $row->operation_name ?></option>
							<?php } ?>
						<?php } ?>
					</select>
					<div class="clear"></div>
				</li>
				<!-- end ADDED -->
				
				<li>
					<label>Realtime </label>

					<div class="form-admin-radio">
						<label><input type="radio" name="aer_isrealtime" value="TRUE" <?php if (!empty($obj) && $obj->aer_isrealtime == 't') echo "checked" ?> <?php if (empty($obj)) echo "checked" ?> <?php if (isset($view)) echo 'disabled'; ?>> Yes</label>
						<div class="clear"></div>
						<label><input type="radio" name="aer_isrealtime" value="FALSE" <?php if (!empty($obj) && $obj->aer_isrealtime == 'f')
					echo "checked";
				else
					echo "checked";
				?> <?php if (isset($view)) echo 'disabled'; ?>> No</label>
					</div>

					<div class="clear"></div>
				</li>
				<li>
					<label>Waktu Dislokasi Unsur Pesud</label>
					<select name="aer_timestamp_location" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
						<option value="06:00" <?php if (date("H:i", strtotime($obj->aer_timestamp_location)) == '06:00') echo 'selected' ?>>06:00</option>
						<option value="18:00" <?php if (date("H:i", strtotime($obj->aer_timestamp_location)) == '18:00') echo 'selected' ?>>18:00</option>
					</select>
					<div class="clear"></div>
				</li>
				<script type="text/javascript">
	var rowTotal = <?php
				if (!empty($aeroplane_logistics)) {
					echo count($aeroplane_logistics);
				} else {
					echo 0;
				}
				?>;

	$(document).ready(function() {
		$("#addLog").click(function() {
			if ($('#logitem_id').attr("disabled") == "disabled") {
				var editNumber = $('#editNumber').val();
				var logValue = $('#aerlog_value').val();
				$('#aeroValue_' + editNumber + '').val(logValue);
				$('#aeroValue_td_' + editNumber + '').text(logValue);
			} else {
				var rowCount = $('#addAeroLogistic').find('tr').size();
				var tableClass = (rowCount % 2 == 0) ? 'row-two' : 'row-one';
				var logId = $('#logitem_id option:selected').val();
				var logText = $('#logitem_id option:selected').text();
				var logValue = $('#aerlog_value').val();
				var aeroPlane = $('#aer_name').val();
				if (logId != '') {
					if (isExist(logText)) {
						alert('Kondisi teknis sudah ditambahkan, silahkan edit untuk mengubah nilai')
					} else {
						rowTotal = rowTotal + 1;
						$("#totalRow").val(rowTotal);

						var row1 = '<tr class=' + tableClass + ' id="logitem_' + logText + '"><td>' + rowCount + '</td>';
						var row2 = '<td>' + logText + '</td>' + '<input type="hidden" name="aeroLog_' + rowTotal + '" id="aeroLog_' + rowTotal + '" value="' + logId + '" />';
						var row3 = '<td>' + aeroPlane + '</td>';
						var row4 = '<td id=aeroValue_td_' + rowTotal + '>' + logValue + '</td>' + '<input type="hidden" name="aeroValue_' + rowTotal + '" id="aeroValue_' + rowTotal + '" value="' + logValue + '" />';
						var action = '<td class="action"><a href="javascript:void(0);" onClick="editLog(\'' + logId + '\',\'' + logValue + '\',\'' + rowTotal + '\')" id="editLog" class="tab-edit">Edit</a><a href="javascript:void(0);" id="deleteLog" class="tab-delete">Delete</a></td></tr>';

						$("#addAeroLogistic").append(row1 + row2 + row3 + row4 + action);
						$('#aerlog_value').val('');
						$('#logitem_id').val('');
					}
				}
			}
		});

		$("#addAeroLogistic").on('click', '#deleteLog', function() {
			$(this).parent().parent().remove();
			rowTotal = rowTotal - 1;
			$("#totalRow").val(rowTotal);
		});

		$("#cancelLog").click(function() {
			$('#aerlog_value').val('');
			$('#logitem_id').val('');
			$("#logitem_id").attr('disabled', false);
			$("#addLog").val('Tambah Kondisi Teknis');
		});

	});

	function editLog(logId, logValue, editNumber) {
		$('#aerlog_value').val(logValue);
		$('#logitem_id').val(logId);
		$('#editNumber').val(editNumber);
		$("#logitem_id").attr('disabled', true);
		$("#addLog").val('Ubah');
	}
	function isExist(strd) {
		console.log($('tr[id*=logitem]').length)
		testme = false;
		$('tr[id*=logitem]').each(function() {
			console.log($('td:nth(1)', $(this)).html());
			console.log($('td:nth(2)', $(this)).html());
			if ($('td:nth(1)', $(this)).html() === strd) {
				testme = true;
			}
		})
		return testme;
	}

	function ChooseLocation(obj) {
		// console.log("ChoosePort " + obj.selectedIndex + " " + $('#ports').val());

		var locInfo = eval("(" + $('#locations').val() + ")");
		$('#aer_location').val(locInfo.name);
		$('#aer_dlat').val(locInfo.dlat);
		$('#aer_mlat').val(locInfo.mlat);
		$('#aer_slat').val(locInfo.slat);
		$('#aer_rlat').val(locInfo.rlat);
		$('select[name="aer_rlat"]').val(locInfo.rlat);
		$('#aer_dlon').val(locInfo.dlon);
		$('#aer_mlon').val(locInfo.mlon);
		$('#aer_slon').val(locInfo.slon);
		$('#aer_rlon').val(locInfo.rlon);
		$('select[name="aer_rlon"]').val(locInfo.rlon);
	}
</script>
				<br />
				<p class="tit-form">Daftar Kondisi Teknis Pesawat</p>
				<table class="tab-admin" id="addAeroLogistic">

					<tr class="tittab">
						<td>No</th>						
						<td>Item Kondisi Teknis</td>
						<td>Pesawat</td>
						<td>Kondisi</td>
						<td style="width: 52px;">Aksi</td>
					</tr>
					<?php if (!empty($aeroplane_logistics)) { ?>
						<?php
						$count = 1;
						if (!empty($aeroplane_logistics)) {
							foreach ($aeroplane_logistics as $row) {
								?>
								<tr class="<?php echo alternator("row-one", "row-two"); ?>" id="logitem_<?php echo $row->logitem_desc ?>">
									<td><?php echo $count; ?></td>
									<td><?php echo $row->logitem_desc; ?></td>
								<input type="hidden" name="aeroLog_<?php echo $count ?>" id="aeroLog_<?php echo $count ?>" value="<?php echo $row->logitem_id ?>" />
								<td><?php echo $row->aer_name; ?></td>
								<td id=aeroValue_td_<?php echo $count ?>><?php echo $row->aerlog_value; ?></td>
								<input type="hidden" name="aeroValue_<?php echo $count ?>" id="aeroValue_<?php echo $count ?>" value="<?php echo $row->aerlog_value ?>" />
				<?php if (!isset($view)) { ?>
									<td class="action"> 
										<a href="javascript:void(0);" onClick="editLog('<?php echo $row->logitem_id ?>', '<?php echo $row->aerlog_value ?>', '<?php echo $count ?>')" id="editLog"><div class="tab-edit"></div></a> 
										<a href="javascript:void(0);" id="deleteLog"><div class="tab-delete"></div></a>
									</td>
								<?php } ?>
								</tr>
								<?php
								$count++;
							}
						}
						?>

				<?php } ?>
				</table>
				<br />
	<?php if (!isset($view)) { ?>
					<p class="tit-form">Entri Data Kondisi Teknis Pesawat</p>
					<ul class="form-admin">
						<li>
							<label>Item Kondisi Teknis * </label>
							<select id="logitem_id" name="logitem_id" <?php if (!empty($obj_logistic)) echo "disabled"; ?> class="form-admin">
								<option value="" selected>-Pilih Kondisi Teknis-</option>
								<?php foreach ($logistic_item as $row) { ?>
									<?php if ((!empty($obj_logistic)) && $obj_logistic->logitem_id == $row->logitem_id) { ?>
										<option value="<?php echo $row->logitem_id ?>" selected><?php echo $row->logitem_desc ?></option>
									<?php } else { ?>
										<option value="<?php echo $row->logitem_id ?>"><?php echo $row->logitem_desc ?></option>
								<?php } ?>
							<?php } ?>
							</select>

		<?php if (!empty($obj_logistic)) { ?>
								<input class="form-admin" type="hidden" name="logitem_id" value="<?php echo $obj_logistic->logitem_id; ?>" />
		<?php } ?>
							<div class="clear"></div>
						</li>
						<li>
							<label>Kondisi * </label>
							<input class="form-admin" name="aerlog_value" type="text" class="text-medium" id="aerlog_value"
								   value="<?php if (!empty($obj_logistic)) echo $obj_logistic->aerlog_value; ?>" >
		<?php echo form_error('aerlog_value'); ?>					
							<div class="clear"></div>
						</li>
						<input type="hidden" value="" id="editNumber"/>
						<input type="hidden" value="<?php if (!empty($aeroplane_logistics)) echo count($aeroplane_logistics) ?>" id="totalRow" name="totalRow"/>
						<li>
							<label></label>
							<input class="button-form green" id="addLog" type="button" value="Simpan" >
							<input class="button-form red" id="cancelLog" type="button" value="Batal">
							<div class="clear"></div>
						</li>
					</ul>
	<?php } ?>
				<?php if (!isset($view)) { ?>
					<li>
						<p class="tit-form"></p>
						<label>&nbsp;</label>
						<input class="button-form" type="submit" value="Simpan">
						<input class="button-form" type="reset" onclick="redirect()" value="Batal">
						<div class="clear"></div>
					</li>
				<?php } ?>
			</ul>
		</form>

		<?php
		#end of hidden part
	}else{
	?>
	<p class="tit-form">Map: </p>
		<div id="map" style="width: 1080px; height: 590px; margin-left:1%;"></div>    

<?php    
	$lat = -1.1750;
	$lng = 119.8283;
	$zoom = 5;
?>


<!-- added by D3-->
<script type="text/javascript">
	
	var osmUrl='<?php echo $this->config->item('map_url') ?>';
	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 1, maxZoom: 18, attribution: osmAttrib});

	map = L.map('map', {
		zoomControl: true,
		layers: [osm]
	}).setView(new L.LatLng(<?php echo $lat; ?>, <?php echo $lng; ?>),<?php echo $zoom; ?>);

</script>


<?php
	$icon_name;
	foreach ($aeroplane as $row)
	{
		foreach ($aeroplane_icon as $key) {

			 if($row->aericon_id == $key->aericon_id){
				$icon_name = $key->aericon_file;
			  }
		}

?>

<script >
	

</script>

<script>
	var aer = new Array();
	var myIcon = L.icon({
	iconUrl: "<?php echo base_url().'assets/img/icon-aeroplane/'.$icon_name;?>",
	iconSize: [30, 30],
	iconAnchor: [9, 21],
	popupAnchor: [0, -14]
});
   aer[<?php echo $row->aer_id; ?>] = L.marker([<?php echo $row->aer_lat; ?>,<?php echo $row->aer_lon; ?>], {icon: myIcon} )
   .bindPopup( "<?=$row->aer_name.' - '.$row->aer_id; ?>" )
   .addTo(map);
	
</script>

<?php 
} ?>

<?php
	}
?>
