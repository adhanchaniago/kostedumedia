<!-- added by D3-->

	<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.css" />
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.js"></script>

	<!-- rotate added by D3-->
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/leaflet/Marker.Rotate.js"></script>
	<!-- end added -->
	 
<script type="text/javascript" src="<?php echo $this->config->item('socket_ip') ?>/socket.io/socket.io.js"></script>

<?php if ($this->session->flashdata('info')) { ?>
	<script>
		$(document).ready(function() {
	<?php if ($this->session->flashdata('trigger_io')) { ?>
				var socket = io.connect('<?php echo $this->config->item('socket_ip') ?>');
				// socket.join('kri');
				socket.emit('reqShipUpdate');
	<?php } ?>
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
		$("#addShipPosition").validate({
			rules: {
				ship_id: "required"
			},
			messages: {
				ship_id: "required"
			}
		});
		$("#ship_lasttrans").datepicker({dateFormat: 'yy-mm-dd', maxDate: '0'});
		$("#ship_timestamp_date").datepicker({dateFormat: 'yy-mm-dd', maxDate: '0'});
		//        $('#ship_machinehour').timepicker({ 'timeFormat': 'H:i:s' });
		//        $('#ship_currenthour').timepicker({ 'timeFormat': 'H:i:s' });

		$('.filter_param').keypress(function(event) {
			if (event.keyCode == '13') { //jquery normalizes the keycode 
				event.preventDefault(); //avoids default action
				$(this).parent().find('input[type=submit]').trigger('click');
				// or $(this).closest('form').submit();
			}
		});

	});
	function create_url() {
		var url = $('#form_search_filter').attr('action') + '/?filter=true&';
		var param = '';
		$('.filter_param').each(function() {
			param += $(this).attr('name') + '=' + $(this).val() + '&';
		});
		//param = param.substr(0,-1);
		$('#form_search_filter').attr('action', url + param).submit();
		//alert(url+param);
	}
	function isNumberKey(evt)
	{
		var charCode = (evt.which) ? evt.which : evt.keyCode;
console.log(charCode);/*
		if (!((charCode >= 48 && charCode <= 57) || (charCode == 46) || (charCode == 8) || (charCode == 9)))
			return false;

		return true;*/
	}
	function redirect() {
		window.location = "<?php echo base_url() ?>admin/ship_ctrl/position";
	}
</script>
<div id="main">

	<div class="clear " id="notif-holder"></div>
	<p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>

	<?php if (empty($ship)) { ?>
		<p class="notif attention">
			<strong>Data KRI tidak ditemukan</strong>
			Sistem tidak menemukan data KRI pada SSAT. Silahkan terlebih dahulu melengkapi data KRI untuk mengatur posisi KRI.
			Mohon maaf atas ketidaknyamanan ini
		</p>
	<?php } ?>

	<p class="tit-form">Posisi KRI
		<a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" />
		</a>
	</p>
	<div class="filtering" style="display: none;">
		<form action="<?php echo base_url() . 'admin/ship_ctrl/position' ?>" method="post" id="form_search_filter" >
			<ul class="filter-form">
				<li>
					<label>Nomor Lambung Kapal</label><br />
					<input type="text" placeholder="Nomor Lambung Kapal" name="ship_id" class='filter_param' value="<?php echo $this->input->get('ship_id'); ?>" />
				</li>
				<li>
					<label>Singkatan Kapal</label><br />
					<input type="text" placeholder="Singkatan Kapal" name="ship_abbr" class='filter_param' value="<?php echo $this->input->get('ship_abbr'); ?>" />
				</li>
				<li>
					<label>Nama Kapal</label><br />
					<input type="text" placeholder="Nama Kapal" name="ship_name" class='filter_param' value="<?php echo $this->input->get('ship_name'); ?>" />
				</li>
				<li>
					<label>Kondisi Kapal</label><br />
					<?php
					$conds = array('' => '-- Pilih Kondisi Kapal --', 1 => 'SIAP', 2 => 'SIAP PANGKALAN', 3 => 'TIDAK SIAP (REPOWERING)', 4 => 'TIDAK SIAP (HARDEPO)', 5 => 'TIDAK SIAP (HARMEN)', 6 => 'TIDAK SIAP (DOCKING)', 7 => 'TIDAK SIAP (TAPKONIS/HARKAN)', 8 => 'TIDAK SIAP (HARWAT)', 9 => 'TIDAK SIAP (LAIN-LAIN)');
					?>
					<select name="shipcond_id" class="filter_param">
						<?php foreach ($conds as $key => $val) { ?>
							<?php if (($this->input->get('shipcond_id')) && $key == $this->input->get('shipcond_id')) { ?>
								<option value="<?php echo $key ?>" selected ><?php echo $val ?></option>
							<?php } else { ?>
								<option value="<?php echo $key ?>"><?php echo $val ?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</li>

				<!--<li>
					<label>Status Operasional</label><br />
					<select name="ship_stat_id" class='filter_param'>
						<option value="">Status Operasional</option>
				<?php foreach ($ship_status as $row) { ?>
					<?php if (($this->input->get('shiptype_id')) && $this->input->get('shiptype_id') == $row->ship_stat_id) { ?>
																																												<option value="<?php echo $row->ship_stat_id ?>" selected><?php echo $row->ship_stat_desc ?></option>
					<?php } else { ?>
																																												<option value="<?php echo $row->ship_stat_id ?>"><?php echo $row->ship_stat_desc ?></option>
					<?php } ?>
				<?php } ?>
					</select>
				</li>-->
				<li>
					<label>Tipe Kapal</label><br />
					<select name="shiptype_id" class='filter_param'>
						<option value="">-Tipe Kapal-</option>
						<?php foreach ($ship_type as $row) { ?>
							<?php if (($this->input->get('shiptype_id')) && $this->input->get('shiptype_id') == $row->shiptype_id) { ?>
								<option value="<?php echo $row->shiptype_id ?>" selected><?php echo $row->shiptype_desc ?></option>
							<?php } else { ?>
								<option value="<?php echo $row->shiptype_id ?>"><?php echo $row->shiptype_desc ?></option>
							<?php } ?>
						<?php } ?>
					</select>
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

						<!-- 
						<?php foreach ($operation as $row) { ?>
							<?php if (($this->input->get('operation_id')) && $this->input->get('operation_id') == $row->operation_id) { ?>
								<option value="<?php echo $row->operation_id ?>" selected><?php echo $row->operation_name ?></option>
							<?php } else { ?>
								<option value="<?php echo $row->operation_id ?>"><?php echo $row->operation_name ?></option>
							<?php } ?>
						<?php } ?> -->
					</select>
					<!-- End Added -->
				</li>
				<li>
					<label>Pembina</label><br />
					<select name="corps_id" class='filter_param'>
						<option value="">-Pilih Pembina-</option>
						<?php 

						foreach ($corps as $row) { ?>
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
						<?php foreach ($corps as $row) { ?>
							<?php if (($this->input->get('corps_id')) && $this->input->get('kodal_id') == $row->corps_id) { ?>
								<option value="<?php echo $row->corps_id ?>" selected><?php echo $row->corps_name ?></option>
							<?php } else { ?>
								<option value="<?php echo $row->corps_id ?>"><?php echo $row->corps_name ?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</li>
				<div class="clear"></div>
				<li>
					<label>Tanggal Dislokasi Unsur KRI</label><br/>
					<input type="text" class="filter_param" name="ship_timestamp_date" id='ship_timestamp_date' readonly value="<?php echo $this->input->get('ship_timestamp_date') ?>"/>
				</li>
				<li>
					<label>Waktu Dislokasi Unsur KRI</label><br/>
					<select name="ship_timestamp_time" class="filter_param">
						<option value="">-Pilih Waktu-</option>
						<option value="06:00" <?php if ($this->input->get('ship_timestamp_time') == '06:00') echo 'selected' ?>>06:00</option>
						<option value="18:00" <?php if ($this->input->get('ship_timestamp_time') == '18:00') echo 'selected' ?>>18:00</option>
					</select>
				</li>
			</ul>

			<div class="clear"></div>
			<div style="border-bottom: 1px dotted #DDD; margin: 15px 0 17px 0;"></div>

			<input type="button" value="Bersihkan Pencarian" onclick="document.location = '<?php echo base_url() . 'admin/ship_ctrl/position' ?>';" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
			<input type="submit" value="Cari" name="search_filter" onclick="create_url();" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />

			<div class="clear"></div>
			<div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
		</form>
	</div>
	<table class="tab-admin">
		<thead>
			<tr class="tittab">
				<td class="header" style="width: 5px;" rowspan="2">No</td>						
				<td class="header" rowspan="2" style="width: 10px;" >No Lambung</td>
				<td class="header" rowspan="2">Nama</td>
				<td class="header" rowspan="2">Nama Operasi</td>
				<td class="header" rowspan="2">Pembina</td>
				<td class="header" rowspan="2">Kodal</td>
				<td class="header" colspan="3" style="width: 60px;">Posisi</td>
				<td class="header" rowspan="2" style="width: 15px;">Status Operasional</td>
				<td class="header" rowspan="2" style="width: 5px;">Arah</td>
				<td class="header" rowspan="2" style="width: 5px;">Kecepatan</td>
				<!--<td class="header" rowspan="1" style="width: 50px;">Ket</td>-->
				<?php if (isset($isSearchTime)) { ?>
					<td class="header" rowspan="2" style="width: 15px;">Waktu</td>
				<?php }
				if (!empty($ship) && isset($ship[0]->history)) {
				} else { ?>
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
			if (!empty($ship)) {
				foreach ($ship as $row) {
					?>
					<tr class="<?php echo alternator("row-one", "row-two"); ?>">
						<td><?php echo ($i++) + $offset; ?></td>
						<td><?php echo $row->ship_id ?></td>
						<td><?php echo $row->ship_name ?></td>
						<td><?php echo $row->operation_name ?></td>
						<td><?php echo $row->corps_name ?></td>
						<td><?php echo $row->kodal_name ?></td>
						<td><?php echo geoComponent($row->ship_lat, 'a', 'lat'); ?></td>
						<td><?php echo geoComponent($row->ship_lon, 'a', 'lon'); ?></td>
						<td><?php echo $row->ship_water_location ?></td>
						<td><?php echo $row->ship_stat_desc ?></td>
						<td><?php echo $row->ship_direction ?></td>
						<td><?php echo $row->ship_speed ?></td>
						<?php if (isset($isSearchTime)) { ?>
						<td><?php echo $row->shipdis_date . ' ' . $row->shipdis_time ?></td>
						<?php }
						
						if (isset($row->history)) { ?>
						<?php } else { ?>
							<td class="action" style="width: 52px;">
								<a href="<?php echo base_url(); ?>admin/ship_ctrl/view_position/<?php echo $row->ship_id . '?' . http_build_query($_GET) . '#form-pos' ?>"><div class="tab-view"></div></a> 
								<a href="<?php echo base_url(); ?>admin/ship_ctrl/edit_position/<?php echo $row->ship_id . '?' . http_build_query($_GET) . '#form-pos' ?>" class="edit-tab"><div class="tab-edit"></div></a> 
							</td>
						<?php } ?>
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
	#this part should be hidden if there's no position to edit
	if (!empty($obj)) {
		?>

		<p id="form-pos" class="tit-form">Perbaharui Posisi KRI</p>
		<form action="<?php echo base_url() ?>admin/ship_ctrl/save_position<?php echo '?' . http_build_query($_GET) ?>" method="post" id="addShipPosition">
			<ul class="form-admin">
				<?php if (!empty($obj)) { ?>
					<input type="hidden" name="ship_id" value="<?php echo $obj->ship_id; ?>" />
				<?php } ?>
				<li>
					<label>Nomor Lambung * </label>
					<input class="form-admin" name="ship_id" type="text" class="text-medium" id="ship_id"
						   value="<?php if (!empty($obj)) echo $obj->ship_id; ?>" <?php if (!empty($obj)) echo 'disabled'; ?> >
						   <?php echo form_error('ship_id'); ?>					
					<div class="clear"></div>
				</li>
				<input type="hidden" name="ship_name" id="ship_name" value="<?php if (!empty($obj)) echo $obj->ship_name; ?>" />
				<!-- added by SKM17 -->
				<li>
					<label>Kodal</label>
					<select name="kodal_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
						<option value="" selected>-Pilih Kodal-</option>
						<?php foreach ($corps as $row) { ?>
							<?php if ((!empty($obj)) && $obj->kodal_id == $row->corps_id) { ?>
								<option value="<?php echo $row->corps_id ?>" selected><?php echo $row->corps_name ?></option>
							<?php } else { ?>
								<option value="<?php echo $row->corps_id ?>"><?php echo $row->corps_name ?></option>
							<?php } ?>
						<?php } ?>
					</select>

					<div class="clear"></div>
				</li>
				<!-- end ADDED -->
<?php if (!isset($view)) { ?>
				<li>
					<label>Pilih Lokasi/Perairan</label>
					<select id="ports" class="form-admin" onchange="ChoosePort(this)" >
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
					</select>

					<div class="clear"></div>
				</li>
<?php } ?>
				<li>
					<label>Lokasi/Perairan</label>
					<input class="form-admin" name="ship_water_location" id="ship_water_location" type="text" class="text-medium" value="<?php if (!empty($obj)) echo $obj->ship_water_location; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>>
					<?php echo form_error('ship_water_location'); ?>                    
					<div class="clear"></div>
				</li>
				<!--<li>
					<label>Nomor Lambung</label>
					<select name="ship_id" class="form-admin pilih-status">
						<option value="" selected="selected">- Pilih Nomor Lambung -</option>
				<?php foreach ($ship as $row) { ?>
					<?php if ((!empty($obj)) && $obj->ship_id == $row->ship_id) { ?>
																										<option value="<?php echo $row->ship_id ?>" selected><?php echo $row->ship_id ?></option>
					<?php } else { ?>
																										<option value="<?php echo $row->ship_id ?>"><?php echo $row->ship_id ?></option>
					<?php } ?>
				<?php } ?>
					</select>				
					<div class="clear"></div>
				</li>-->
				<!--<li>
							<label>Icon Kapal</label>
							<input class="form-admin" name="ship_icon" type="text" class="text-medium"
								   value="<?php if (!empty($obj)) echo $obj->ship_icon; ?>" >
				<?php echo form_error('ship_icon'); ?>					
							<div class="clear"></div>
						</li>-->
				<?php if (!empty($obj) && $obj->ship_isrealtime == 't') { ?>
					<input type="hidden" name="ship_dlat" id="ship_dlat" value="<?php echo geoComponent($obj->ship_lat, 'd'); ?>" />
					<input type="hidden" name="ship_mlat" id="ship_mlat" value="<?php echo geoComponent($obj->ship_lat, 'm'); ?>" />
					<input type="hidden" name="ship_slat" id="ship_slat" value="<?php echo geoComponent($obj->ship_lat, 's'); ?>" />
					<input type="hidden" name="ship_rlat" id="ship_rlat" value="<?php echo geoComponent($obj->ship_lat, 'r'); ?>" />

					<input type="hidden" name="ship_dlon" id="ship_dlon" value="<?php echo geoComponent($obj->ship_lon, 'd'); ?>" />
					<input type="hidden" name="ship_mlon" id="ship_mlon" value="<?php echo geoComponent($obj->ship_lon, 'm'); ?>" />
					<input type="hidden" name="ship_slon" id="ship_slon" value="<?php echo geoComponent($obj->ship_lon, 's'); ?>" />
					<input type="hidden" name="ship_rlon" id="ship_rlon" value="<?php echo geoComponent($obj->ship_lon, 'r'); ?>" />
				<?php } ?>
				<li>
					<label>Lintang</label>
					<input class="form-admin two-digit" name="ship_dlat" id="ship_dlat" maxlength="3"  type="text" class="text-medium" <?php if (!empty($obj)) iff($obj->ship_isrealtime == 't', 'readonly', ''); ?>
					   value="<?php if (!empty($obj)) echo geoComponent($obj->ship_lat, 'd'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?> >
					<input class="form-admin two-digit" name="ship_mlat" id="ship_mlat" maxlength="2"  type="text" class="text-medium" <?php if (!empty($obj)) iff($obj->ship_isrealtime == 't', 'readonly', ''); ?>
					   value="<?php if (!empty($obj)) echo geoComponent($obj->ship_lat, 'm'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?> >
					<input class="form-admin two-digit" name="ship_slat" id="ship_slat" maxlength="2"  type="text" class="text-medium" <?php if (!empty($obj)) iff($obj->ship_isrealtime == 't', 'readonly', ''); ?>
					   value="<?php if (!empty($obj)) echo geoComponent($obj->ship_lat, 's'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?> >
					   <?php
						   $stat = 'class="form-admin" style="width: 47px;"';

						   if (!empty($obj) && $obj->ship_isrealtime == 't' || isset($view))
							   $stat .= 'disabled';

						   if (!empty($obj))
							   echo form_dropdown('ship_rlat', array(1 => 'U', -1 => 'S'), geoComponent($obj->ship_lat, 'r'), $stat);
						   else
							   echo form_dropdown('ship_rlat', array(1 => 'U', -1 => 'S'), '', $stat);
					   ?>

					<?php echo form_error('ship_lat'); ?>					

					<div class="clear"></div>
				</li>
				<li>
					<label>Bujur</label>
					<input class="form-admin two-digit" name="ship_dlon" id="ship_dlon" maxlength="3"  type="text" class="text-medium" <?php if (!empty($obj)) iff($obj->ship_isrealtime == 't', 'readonly', ''); ?>
					   value="<?php if (!empty($obj)) echo geoComponent($obj->ship_lon, 'd'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
					<input class="form-admin two-digit" name="ship_mlon" id="ship_mlon" maxlength="2"  type="text" class="text-medium" <?php if (!empty($obj)) iff($obj->ship_isrealtime == 't', 'readonly', ''); ?>
					   value="<?php if (!empty($obj)) echo geoComponent($obj->ship_lon, 'm'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
					<input class="form-admin two-digit" name="ship_slon" id="ship_slon" maxlength="2"  type="text" class="text-medium" <?php if (!empty($obj)) iff($obj->ship_isrealtime == 't', 'readonly', ''); ?>
					   value="<?php if (!empty($obj)) echo geoComponent($obj->ship_lon, 's'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

					<?php
						$stat = 'class="form-admin" style="width: 47px;"';
						if (!empty($obj) && $obj->ship_isrealtime == 't' || isset($view))
							$stat = 'class="form-admin" style="width: 47px;" disabled';

						if (!empty($obj))
							echo form_dropdown('ship_rlon', array(1 => 'T', -1 => 'B'), geoComponent($obj->ship_lon, 'r'), $stat);
						else
							echo form_dropdown('ship_rlon', array(1 => 'T', -1 => 'B'), '', $stat);
					?>

					<?php echo form_error('ship_lon'); ?>					
					<div class="clear"></div>
				</li>
				<li>
					<label>Map</label>
						<div id="map" style="width: 400px; height: 200px;margin-left:20%;"></div>


						<!-- added by D3-->
						<script type="text/javascript">
							
							var osmUrl='<?php echo $this->config->item('map_url') ?>';
							var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
							var osm = new L.TileLayer(osmUrl, {minZoom: 1, maxZoom: 18, attribution: osmAttrib});

							map = L.map('map', {
								zoomControl: true,
								layers: [osm]
							}).setView(new L.LatLng(<?php echo $obj->ship_lat; ?>, <?php echo $obj->ship_lon; ?>),7);

						</script>


						<?php
							//properti icon kapal untuk jenis kapal dan pembina
							$nonRealtime = base_url()."assets/img/icon-ship/not-realtime/";
							$realtime = base_url()."assets/img/icon-ship/realtime/";
							$defaultIcon = "KI.png";
							foreach ($ship as $row){
							$nama_icon ="";
							$folder_icon="";
							$appliedIcon = "";
							$id_type = $row->shiptype_id;

										if($row->corps_id == 1){
											foreach ($type as $key) {
												$id_type_db = $key->shiptype_id;
												$ship_icon = $key->shiptype_icon;
												//cek id icon
												if(!(strcmp($id_type,$id_type_db))){
													if($ship_icon == NULL){    
														 $nama_icon ="hijau-".$defaultIcon;
														 break;
													}else{
														$nama_icon ="hijau-".$key->shiptype_icon;
														break; 
													}                             
												}else{
													$nama_icon ="hijau-".$defaultIcon;
												}
											}
											//cek status kapal
											if($row->ship_stat_id ==2){$folder_icon="lego/";} 
											if($row->ship_stat_id ==3){$folder_icon="sandar/";}     
											$appliedIcon =$nonRealtime."hijau/".$folder_icon.$nama_icon;

										}else
										if($row->corps_id == 2){
											foreach ($type as $key) {
												$id_type_db = $key->shiptype_id;
												$ship_icon = $key->shiptype_icon;
												//cek id icon
												if(!(strcmp($id_type,$id_type_db))){
													 if($ship_icon == NULL){    
														 $nama_icon ="grey-".$defaultIcon;
														 break;
													 }else{
														 $nama_icon ="grey-".$key->shiptype_icon;
														break;
													 }
													
												}else{
													$nama_icon ="grey-".$defaultIcon;
												}
											}
											//cek status kapal
											if($row->ship_stat_id ==2){$folder_icon="lego/";} 
											if($row->ship_stat_id ==3){$folder_icon="sandar/";}          
											$appliedIcon =$nonRealtime."hitam/".$folder_icon.$nama_icon;        

										}else
										if($row->corps_id == 40){
											foreach ($type as $key) {
												$id_type_db = $key->shiptype_id;
												$ship_icon = $key->shiptype_icon;
												//cek id icon
												if(!(strcmp($id_type,$id_type_db))){
													if($ship_icon == NULL){    
														 $nama_icon ="orange-".$defaultIcon;
														 break;
													 }else{
														$nama_icon ="orange-".$key->shiptype_icon;
														break;
													 }
												}else{
													$nama_icon ="orange-".$defaultIcon;
												}
											}
											//cek status kapal
											if($row->ship_stat_id ==2){$folder_icon="lego/";} 
											if($row->ship_stat_id ==3){$folder_icon="sandar/";} 
													
											$appliedIcon =$nonRealtime."orange/".$folder_icon.$nama_icon;        
											
										}else{
											foreach ($type as $key) {
												$id_type_db = $key->shiptype_id;
												$ship_icon = $key->shiptype_icon;
												if(!(strcmp($id_type,$id_type_db))){
													if($ship_icon == NULL){
														$nama_icon =$defaultIcon;
														break;
													}else{
														$nama_icon ="blue-".$key->shiptype_icon;
														break;
													}        
												}else{
													$nama_icon =$defaultIcon;
												}
											}
											//cek status kapal
											if($row->ship_stat_id ==2){$folder_icon="lego/";} 
											if($row->ship_stat_id ==3){$folder_icon="sandar/";} 
											$appliedIcon =$nonRealtime."blue/".$folder_icon.$nama_icon;
										}
						?>

						<script >
							var ship = new Array();
							var myIcon = L.icon({
							iconUrl: "<?php echo $appliedIcon;?>",
							iconSize: [30, 30],
							iconAnchor: [9, 21],
							popupAnchor: [0, -14]
						});
						  </script>

						<script>

						   ship[<?php echo $row->ship_id; ?>] = L.marker([<?php echo $row->ship_lat; ?>,<?php echo $row->ship_lon; ?>], {icon: myIcon, iconAngle:<?php echo $row->ship_direction; ?>} )
						   .bindPopup( "<?=$row->ship_name.' - '.$row->ship_id; ?>" )
						   .addTo(map);
							
						</script>

						<?php 
							}
						?>

				</li>
				<li>
					<label>Arah</label>
					<input class="form-admin" name="ship_direction" type="text" class="text-medium" <?php if (!empty($obj)) iff($obj->ship_isrealtime == 't', 'readonly', ''); ?>
						   value="<?php if (!empty($obj)) echo $obj->ship_direction; ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
						   <?php echo form_error('ship_direction'); ?>					
					<div class="clear"></div></li>
				<li>
					<label>Kecepatan</label>
					<input class="form-admin" name="ship_speed" id="ship_speed" type="text" class="text-medium" <?php if (!empty($obj)) iff($obj->ship_isrealtime == 't', 'readonly', ''); ?>
						   value="<?php if (!empty($obj)) echo $obj->ship_speed; ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
						   <?php echo form_error('ship_speed'); ?>					
					<div class="clear"></div>
				</li>
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
					<label>Status Operasional KRI</label>
					<select name="ship_stat_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
						<option value="" selected>-Pilih Status-</option>
						<?php foreach ($ship_status as $row) { ?>
							<?php if ((!empty($obj)) && $obj->ship_stat_id == $row->ship_stat_id) { ?>
								<option value="<?php echo $row->ship_stat_id ?>" selected><?php echo $row->ship_stat_desc ?></option>
							<?php } else { ?>
								<option value="<?php echo $row->ship_stat_id ?>"><?php echo $row->ship_stat_desc ?></option>
							<?php } ?>
						<?php } ?>
					</select>
					<div class="clear"></div>
				</li>

				<script type="text/javascript">
					$(this).ready(function(){
						
						$('select[name="ship_stat_id"]').change(function(){
							if(this.value == 3){
								$('#harbour-city').attr('style','');
							}else{
								$('#harbour-city').attr('style','display:none;');
							}
						});
					});
				</script>
					
				<li id="harbour-city" <?php if(!empty($obj) && $obj->ship_stat_id  != 3) echo 'style="display : none;"'; ?>>
					<label>Dermaga</label>
					<input class="form-admin" name="ship_dock" id="ship_dock" type="text" class="text-medium" value="<?php if (!empty($obj)) echo $obj->ship_dock; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>>
					<?php echo form_error('ship_dock'); ?>					
					<div class="clear"></div>
				</li>
				<!--<li>
					<label>Keterangan</label>
					<textarea class="form-admin" name="ship_desc" <?php if (isset($view)) echo 'disabled'; ?>><?php if (!empty($obj)) echo $obj->ship_desc ?></textarea>
				</li>-->
				<li>
					<?php echo form_error('ship_lon'); ?>					
					<div class="clear"></div>
				</li>
				<!--<li>
					<label>Gambar</label>
					<input class="form-admin" name="ship_image" type="text" class="text-medium"
						   value="<?php if (!empty($obj)) echo $obj->ship_image; ?>" >
				<?php echo form_error('ship_image'); ?>					
					<div class="clear"></div></li>
					<input type="hidden" name="ship_image" value="<?php if (!empty($obj)) echo $obj->ship_image; ?>"> -->
				<!--<li>
					<label>Machine Hours</label>
					<input class="form-admin" name="ship_machinehour" id="ship_machinehour" type="text" class="text-medium"
						   value="<?php if (!empty($obj)) echo $obj->ship_machinehour; ?>" onkeypress="return isNumberKey(event)">
				<?php echo form_error('ship_machinehour'); ?>					
					<div class="clear"></div></li>
				<li>
					<label>Current Hour</label>
					<input class="form-admin" name="ship_currenthour" id="ship_currenthour" type="text" class="text-medium"
						   value="<?php if (!empty($obj)) echo $obj->ship_currenthour; ?>" onkeypress="return isNumberKey(event)">
				<?php echo form_error('ship_currenthour'); ?>					
					<div class="clear"></div>
				</li>-->
				<li>
					<label>Tanggal Penugasan Terakhir</label>
					<input class="form-admin" name="ship_lasttrans" id="ship_lasttrans" type="text" class="text-medium"
						   value="<?php if (!empty($obj)) echo substr($obj->ship_timestamp_location, 0, 10); ?>" <?php if (isset($view)) echo 'disabled'; ?>>
						   <?php echo form_error('ship_lasttrans'); ?>					
					<div class="clear"></div>
				</li>
				<li>
					<label>KRI</label>
					<div class="form-admin-radio">
						<label>
							<input type="radio" name="ship_iskri" value="true" <?php if (!empty($obj) && $obj->ship_iskri == 't') echo "checked" ?> <?php if (empty($obj)) echo "checked" ?> <?php if (isset($view)) echo 'disabled'; ?>>Ya
						</label><br />
						<label>
							<input type="radio" name="ship_iskri" value="false" <?php if (!empty($obj) && $obj->ship_iskri == 'f') echo "checked" ?> <?php if (isset($view)) echo 'disabled'; ?>>Tidak
						</label>
					</div>
					<div class="clear"></div>
				</li>
				<li>
					<label>Realtime</label>

					<div class="form-admin-radio">
						<label>
							<input type="radio" name="ship_isrealtime" value="true" <?php if (!empty($obj) && $obj->ship_isrealtime == 't') echo "checked" ?> <?php if (empty($obj)) echo "checked" ?> <?php if (isset($view)) echo 'disabled'; ?>>Ya
						</label><br />
						<label>
							<input type="radio" name="ship_isrealtime" value="false" <?php if (!empty($obj) && $obj->ship_isrealtime == 'f') echo "checked" ?> <?php if (isset($view)) echo 'disabled'; ?>>Tidak
						</label>
					</div>


					<div class="clear"></div>
				</li>
				<li>
					<label>Waktu Dislokasi Unsur KRI</label>
					<select name="ship_timestamp_location" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
						<option value="06:00" <?php if (date("H:i", strtotime($obj->ship_timestamp_location)) == '06:00') echo 'selected' ?>>06:00</option>
						<option value="18:00" <?php if (date("H:i", strtotime($obj->ship_timestamp_location)) == '18:00') echo 'selected' ?>>18:00</option>
					</select>
					<div class="clear"></div>
				</li>
				<!-- <input type="hidden" name="operation_id" value="<?php echo $obj->operation_id ?>" /> commented by SKM17 -->
				<script type="text/javascript">
		var rowTotal = <?php
					   if (!empty($ship_logistics)) {
						   echo count($ship_logistics);
					   } else {
						   echo 0;
					   }
					   ?>;
		/*var rowTotalPersonel = <?php
					   if (!empty($ship_personel)) {
						   echo count($ship_personel);
					   } else {
						   echo 0;
					   }
					   ?>;*/
		var rowTotalAdo = <?php
					   if (!empty($ship_ado)) {
						   echo count($ship_ado);
					   } else {
						   echo 0;
					   }
					   ?>

		$(document).ready(function() {
			$("#addLog").click(function() {
				if ($('#logitem_id').attr("disabled") == "disabled") {
					var editNumber = $('#editNumber').val();
					var logValue = $('#shiplog_value').val();
					$('#shipValue_' + editNumber + '').val(logValue);
					$('#shipValue_td_' + editNumber + '').text(logValue);
				} else {
					var rowCount = $('#addStationLogistic').find('tr').size();
					var tableClass = (rowCount % 2 == 0) ? 'row-two' : 'row-one';
					var logId = $('#logitem_id option:selected').val();
					var logText = $('#logitem_id option:selected').text();
					var logValue = $('#shiplog_value').val();
					var aeroPlane = $('#ship_name').val();
					if (logId != '') {
						if (isExist(logText, 'logitem')) {
							alert('Kondisi teknis sudah ditambahkan, silahkan edit untuk mengubah nilai')
						} else {
							rowTotal = rowTotal + 1;
							$("#totalRow").val(rowTotal);

							var row1 = '<tr class=' + tableClass + ' id="logitem_' + logText + '"><td>' + rowCount + '</td>';
							var row2 = '<td>' + logText + '</td>' + '<input type="hidden" name="shipLog_' + rowTotal + '" id="shipLog_' + rowTotal + '" value="' + logId + '" />';
							var row3 = '<td>' + aeroPlane + '</td>';
							var row4 = '<td id=shipValue_td_' + rowTotal + '>' + logValue + '</td>' + '<input type="hidden" name="shipValue_' + rowTotal + '" id="shipValue_' + rowTotal + '" value="' + logValue + '" />';
							var action = '<td class="action"><a href="javascript:void(0);" onClick="editLog(\'' + logId + '\',\'' + logValue + '\',\'' + rowTotal + '\')" id="editLog"><div class="tab-edit"></div></a><a href="javascript:void(0);" id="deleteLog"><div class="tab-delete"></div></a></td></tr>';

							$("#addStationLogistic").append(row1 + row2 + row3 + row4 + action);
							$('#shiplog_value').val('');
							$('#logitem_id').val('');
						}
					}
				}
			});

			$("#addStationLogistic").on('click', '#deleteLog', function() {
				$(this).parent().parent().remove();
				rowTotal = rowTotal - 1;
				$("#totalRow").val(rowTotal);
			});

			$("#cancelLog").click(function() {
				$('#shiplog_value').val('');
				$('#logitem_id').val('');
				$("#logitem_id").attr('disabled', false);
				$("#addLog").val('Tambah Kondisi Teknis');
			});

			$("#addPersonel").click(function() {
				if ($('#psnreff_nrp').attr("disabled") == "disabled") {
					var editNumberPersonel = $('#editNumberPersonel').val();
					var logValue = $('#psn_value').val();
					$('#personelValue_' + editNumberPersonel + '').val(logValue);
					$('#personelValue_td_' + editNumberPersonel + '').text(logValue);
				} else {
					var rowCount = $('#addShipPersonel').find('tr').size();
					var tableClass = (rowCount % 2 == 0) ? 'row-two' : 'row-one';
					var logId = $('#psnreff_nrp option:selected').val();
					var logText = $('#psnreff_nrp option:selected').text();
					var logValue = $('#psn_value').val();
					var aeroPlane = $('#ship_name').val();
					if (logId != '') {
						if (isExist(logText, 'pref')) {
							alert('personel sudah ditambahkan, silahkan edit untuk mengubah nilai')
						} else {
							rowTotalPersonel = rowTotalPersonel + 1;
							$("#totalRowPersonel").val(rowTotalPersonel);

							var row1 = '<tr class=' + tableClass + ' id="pref_' + logText + '"><td>' + rowCount + '</td>';
							var row2 = '<td>' + logText + '</td>' + '<input type="hidden" name="personel_' + rowTotalPersonel + '" id="personel_' + rowTotalPersonel + '" value="' + logId + '" />';
							var row3 = '<td>' + aeroPlane + '</td>';
							var row4 = '<td id=personelValue_td_' + rowTotalPersonel + '>' + logValue + '</td>' + '<input type="hidden" name="personelValue_' + rowTotalPersonel + '" id="personelValue_' + rowTotalPersonel + '" value="' + logValue + '" />';
							var action = '<td class="action"><a href="javascript:void(0);" onClick="editPersonel(\'' + logId + '\',\'' + logValue + '\',\'' + rowTotalPersonel + '\')" id="editPersonel"><div class="tab-edit"></div></a><a href="javascript:void(0);" id="deletePersonel"><div class="tab-delete"></div></a></td></tr>';

							$("#addShipPersonel").append(row1 + row2 + row3 + row4 + action);
							$('#psn_value').val('');
							$('#psnreff_nrp').val('');
						}
					}
				}
			});

			$("#addShipPersonel").on('click', '#deletePersonel', function() {
				$(this).parent().parent().remove();
				rowTotalPersonel = rowTotalPersonel - 1;
				$("#totalRowPersonel").val(rowTotalPersonel);
			});

			$("#cancelPersonel").click(function() {
				$('#psn_value').val('');
				$('#psnreff_nrp').val('');
				$("#psnreff_nrp").attr('disabled', false);
				$("#addPersonel").val('Tambah Personel');
			});

			//FOR ADO
			$("#addAdo").click(function() {
				if ($('#editNumberAdo').val() != "") {
					var editNumberAdo = $('#editNumberAdo').val();
					var adoTime = $('#ado_time').val();
					var adoReport = $('#ado_report').val();
					$('#adoDate_' + editNumberAdo + '').val(adoTime);
					$('#adoDate_td_' + editNumberAdo + '').text(adoTime);
					$('#ado_' + editNumberAdo + '').val(adoReport);
					$('#ado_td_' + editNumberAdo + '').text(adoReport);
				} else {
					var rowCount = $('#addShipAdo').find('tr').size();
					var tableClass = (rowCount % 2 == 0) ? 'row-two' : 'row-one';
					var adoReport = $('#ado_report').val();
					var adoTime = $('#ado_time').val();
					if (adoReport != '') {
						rowTotalAdo = rowTotalAdo + 1;
						$("#totalRowAdo").val(rowTotalAdo);

						var row1 = '<tr class=' + tableClass + '><td>' + rowCount + '</td>';
						var row2 = '<td id=ado_td_' + rowTotalAdo + '>' + adoReport + '</td>' + '<input type="hidden" name="ado_' + rowTotalAdo + '" id="ado_' + rowTotalAdo + '" value="' + adoReport + '" />';
						var row3 = '<input type="hidden" name="ado_' + rowTotalAdo + '" id="ado_' + rowTotalAdo + '" value="' + adoReport + '" />';
						var row4 = '<td id=adoDate_td_' + rowTotalAdo + '>' + adoTime + '</td>' + '<input type="hidden" name="adoDate_' + rowTotalAdo + '" id="adoDate_' + rowTotalAdo + '" value="' + adoTime + '" />';
						var action = '<td class="action"><a href="javascript:void(0);" onClick="editAdo(\'' + rowTotalAdo + '\',\'' + adoReport + '\',\'' + adoTime + '\')" id="editAdo" ><div class="tab-edit"></div></a> <a href="javascript:void(0);" id="deleteAdo"><div class="tab-delete"></div></a></td></tr>';

						$("#addShipAdo").append(row1 + row2 + row3 + row4 + action);
						$('#ado_report').val('');
						$('#ado_time').val('');
					}
				}
			});
			$("#ado_time").datepicker({dateFormat: "yy-mm-dd"});
			$("#addShipAdo").on('click', '#deleteAdo', function() {
				$(this).parent().parent().remove();
				rowTotalAdo = rowTotalAdo - 1;
				$("#totalRowAdo").val(rowTotalAdo);
			});

			$("#cancelAdo").click(function() {
				$('#ado_report').val('');
				$('#ado_time').val('');
				$("#addAdo").val('Tambah Data Operasi');
			});

		});

		function editLog(logId, logValue, editNumber) {
			$('#shiplog_value').val(logValue);
			$('#logitem_id').val(logId);
			$('#editNumber').val(editNumber);
			$("#logitem_id").attr('disabled', true);
			$("#addLog").val('Ubah');
		}
		function editPersonel(logId, logValue, editNumberPersonel) {
			$('#psn_value').val(logValue);
			$('#psnreff_nrp').val(logId);
			$('#editNumberPersonel').val(editNumberPersonel);
			$("#psnreff_nrp").attr('disabled', true);
			$("#addPersonel").val('Ubah');
		}
		function editAdo(logId, logValue, editNumber) {
			$('#editNumberAdo').val(logId);
			$('#ado_report').val(logValue);
			$('#ado_time').val(editNumber);
			$("#addAdo").val('Ubah');
		}
		function isExist(strd, row_id) {
			console.log($('tr[id*=' + row_id + ']').length)
			testme = false;
			$('tr[id*=' + row_id + ']').each(function() {
				console.log($('td:nth(1)', $(this)).html());
				console.log($('td:nth(2)', $(this)).html());
				if ($('td:nth(1)', $(this)).html() === strd) {
					testme = true;
				}
			})
			return testme;
		}

		function ChoosePort(obj) {
			// console.log("ChoosePort " + obj.selectedIndex + " " + $('#ports').val());

			var portInfo = eval("(" + $('#ports').val() + ")");
			$('#ship_water_location').val(portInfo.name);
			$('#ship_dlat').val(portInfo.dlat);
			$('#ship_mlat').val(portInfo.mlat);
			$('#ship_slat').val(portInfo.slat);
			$('#ship_rlat').val(portInfo.rlat);
			$('select[name="ship_rlat"]').val(portInfo.rlat);
			$('#ship_dlon').val(portInfo.dlon);
			$('#ship_mlon').val(portInfo.mlon);
			$('#ship_slon').val(portInfo.slon);
			$('#ship_rlon').val(portInfo.rlon);
			$('select[name="ship_rlon"]').val(portInfo.rlon);
		}

	</script>
				<!--used to store logistic data-->

				<br />

				<p class="tit-form">Daftar Kondisi Teknis Kapal</p>
				<table id="addStationLogistic" class="tab-admin">
					<tr class="tittab">
						<td>No</td>
						<td>Logistic Item</td>
						<td>Kapal</td>
						<td>Kondisi</td>
						<td style="width: 52px;">Action</td>
					</tr>
					<?php if (!empty($ship_logistics)) { ?>
						<?php
						$count = 1;
						if (!empty($ship_logistics)) {
							foreach ($ship_logistics as $row) {
								?>
								<tr class="<?php echo alternator("row-one", "row-two"); ?>" id="logitem_<?php echo $row->logitem_desc ?>">
									<td><?php echo $count; ?></td>
									<td><?php echo $row->logitem_desc; ?></td>
								<input type="hidden" name="shipLog_<?php echo $count ?>" id="shipLog_<?php echo $count ?>" value="<?php echo $row->logitem_id ?>" />
								<td><?php echo $row->ship_name; ?></td>
								<td id=shipValue_td_<?php echo $count ?>><?php echo $row->shiplog_value; ?></td>
								<input type="hidden" name="shipValue_<?php echo $count ?>" id="shipValue_<?php echo $count ?>" value="<?php echo $row->shiplog_value ?>" />
								<?php if (!isset($view)) { ?>
									<td class="action"> 
										<a href="javascript:void(0);" onClick="editLog('<?php echo $row->logitem_id ?>', '<?php echo $row->shiplog_value ?>', '<?php echo $count ?>')" id="editLog" ><div class="tab-edit"></div></a> 
										<a href="javascript:void(0);" id="deleteLog" ><div class="tab-delete"></div></a>
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
					<p class="tit-form">Data Kondisi Teknis Kapal</p>
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
							<div class="clear"></div>
						</li>
						<li>
							<label>Kondisi * </label>
							<input class="form-admin" name="shiplog_value" type="text" class="text-medium" id="shiplog_value" value="" >
							<div class="clear"></div>
						</li>
						<input type="hidden" value="" id="editNumber"/>
						<input type="hidden" value="<?php if (!empty($ship_logistics)) echo count($ship_logistics) ?>" id="totalRow" name="totalRow"/>
						<li>
							<label></label>
							<input class="button-form green" id="addLog" type="button" value="<?php
							if (empty($obj))
								echo 'Simpan';
							else
								echo 'Tambah Kondisi Teknis';
							?>" >
							<input class="button-form red" id="cancelLog" type="button" value="Batal">
							<div class="clear"></div>
						</li>
					</ul>
				<?php } ?>
				<!--Data Personil--> <!--

				<br />

				<p class="tit-form">Daftar Personel Kapal</p>


				<table id="addShipPersonel" class="tab-admin">
					<tr class="tittab">
						<td>No</td>
						<td>Personel</td>
						<td>Kapal</td>
						<td>Kondisi</td>
						<td style="width: 52px;">Action</td>
					</tr>
					<?php if (!empty($ship_personel)) { ?>
						<?php
						$count_personel = 1;
						if (!empty($ship_personel)) {
							foreach ($ship_personel as $row) {
								?>
								<tr class="<?php echo alternator("row-one", "row-two"); ?>" id="pref_<?php echo $row->psnreff_name ?>">
									<td><?php echo $count_personel; ?></td>
									<td><?php echo $row->psnreff_name; ?></td>
								<input type="hidden" name="personel_<?php echo $count_personel ?>" id="personel_<?php echo $count_personel ?>" value="<?php echo $row->psnreff_nrp ?>" />
								<td><?php echo $row->psnreff_name; ?></td>
								<td id=personelValue_td_<?php echo $count_personel ?>><?php echo $row->psn_value; ?></td>
								<input type="hidden" name="personelValue_<?php echo $count_personel ?>" id="personelValue_<?php echo $count_personel ?>" value="<?php echo $row->psn_value ?>" />
								<?php if (!isset($view)) { ?>
									<td class="action"> 
										<a href="javascript:void(0);" onClick="editPersonel('<?php echo $row->psnreff_nrp ?>', '<?php echo $row->psn_value ?>', '<?php echo $count_personel ?>')" id="editPersonel" ><div class="tab-edit"></div></a> 
										<a href="javascript:void(0);" id="deletePersonel" ><div class="tab-delete"></div></a>
									</td>
								<?php } ?>
								</tr>
								<?php
								$count_personel++;
							}
						}
						?>

					<?php } ?>
				</table>

				<br />

				<?php if (!isset($view)) { ?>
					<p class="tit-form">Data Personel Kapal</p>
					<ul class="form-admin">
						<li>
							<label>Personel * </label>
							<select id="psnreff_nrp" name="psnreff_nrp" class="form-admin">
								<option value="" selected>-Select Personel-</option>
								<?php foreach ($personel as $row) { ?>
									<option value="<?php echo $row->psnreff_nrp ?>"><?php echo $row->psnreff_name ?></option>
								<?php } ?>
							</select>
							<div class="clear"></div>
						</li>
						<li>
							<label>Kondisi * </label>
							<input class="form-admin" name="psn_value" type="text" class="text-medium" id="psn_value" value="" >
							<div class="clear"></div>
						</li>
						<input type="hidden" value="" id="editNumberPersonel"/>
						<input type="hidden" value="<?php if (!empty($ship_personel)) echo count($ship_personel) ?>" id="totalRowPersonel" name="totalRowPersonel"/>
						<li>
							<label></label>
							<input class="button-form green" id="addPersonel" type="button" value="<?php
							if (empty($obj))
								echo 'Simpan';
							else
								echo 'Tambah Personel';
							?>" >
							<input class="button-form red" id="cancelPersonel" type="button" value="Batal">
							<div class="clear"></div>
						</li>
					</ul>
				<?php } ?>
				-->
				<!--Data ADO-->

				<br />

				<p class="tit-form">Daftar Analisis Data Operasi</p>
				<table id="addShipAdo" class="tab-admin">
					<tr class="tittab">
						<td>No</td>
						<td>Laporan</td>
						<td>Tanggal</td>
						<td style="width: 52px;">Action</td>
					</tr>
					<?php if (!empty($ship_ado)) { 
						$count_ado = 1;
						if (!empty($ship_ado)) {
							foreach ($ship_ado as $row) {
								?>
								<tr class="<?php echo alternator("row-one", "row-two"); ?>">
									<td><?php echo $count_ado; ?></td>
									<td id=ado_td_<?php echo $count_ado ?>><?php echo $row->ado_report; ?></td>
									<input type="hidden" name="ado_<?php echo $count_ado ?>" id="ado_<?php echo $count_ado ?>" value="<?php echo $row->ado_report ?>" />
									<td id=adoDate_td_<?php echo $count_ado ?>><?php echo $row->ado_time; ?></td>
									<input type="hidden" name="adoDate_<?php echo $count_ado ?>" id="adoDate_<?php echo $count_ado ?>" value="<?php echo $row->ado_time ?>" />
									<?php if (!isset($view)) { ?>
										<td class="action"> 
											<a href="javascript:void(0);" onClick="editAdo('<?php echo $count_ado ?>', '<?php echo $row->ado_report ?>', '<?php echo $row->ado_time ?>')" id="editAdo" ><div class="tab-edit"></div></a> 
											<a href="javascript:void(0);" id="deleteAdo" ><div class="tab-delete"></div></a>
										</td>
									<?php } ?>
								</tr>
								<?php
								$count_ado++;
							}
						}
					} ?>
				</table>

				<br />
				<?php if (!isset($view)) { ?>
					<p class="tit-form">Analisis Data Operasi</p>
					<ul class="form-admin">
						<li>
							<label>Laporan * </label>
							<textarea id="ado_report" name="ado_report" class="form-admin"></textarea>
							<div class="clear"></div>
						</li>
						<li>
							<label>Waktu * </label>
							<input class="form-admin" name="ado_time" type="text" class="text-medium" id="ado_time" value="" >
							<div class="clear"></div>
						</li>
						<input type="hidden" value="" id="editNumberAdo"/>
						<input type="hidden" value="<?php if (!empty($ship_ado)) echo count($ship_ado) ?>" id="totalRowAdo" name="totalRowAdo"/>
						<li>
							<label></label>
							<input class="button-form green" id="addAdo" type="button" value="<?php
							if (empty($obj))
								echo 'Simpan';
							else
								echo 'Tambah Data Operasi';
							?>" >
							<input class="button-form red" id="cancelAdo" type="button" value="Batal">
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

</div>

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
	//properti icon kapal untuk jenis kapal dan pembina
	$nonRealtime = base_url()."assets/img/icon-ship/not-realtime/";
	$realtime = base_url()."assets/img/icon-ship/realtime/";
	$defaultIcon = "KI.png";
	foreach ($ship as $row){
	$nama_icon ="";
	$folder_icon="";
	$appliedIcon = "";
	$id_type = $row->shiptype_id;

				if($row->corps_id == 1){
					foreach ($type as $key) {
						$id_type_db = $key->shiptype_id;
						$ship_icon = $key->shiptype_icon;
						//cek id icon
						if(!(strcmp($id_type,$id_type_db))){
							if($ship_icon == NULL){    
								 $nama_icon ="hijau-".$defaultIcon;
								 break;
							}else{
								$nama_icon ="hijau-".$key->shiptype_icon;
								break; 
							}                             
						}else{
							$nama_icon ="hijau-".$defaultIcon;
						}
					}
					//cek status kapal
					if($row->ship_stat_id ==2){$folder_icon="lego/";} 
					if($row->ship_stat_id ==3){$folder_icon="sandar/";}     
					$appliedIcon =$nonRealtime."hijau/".$folder_icon.$nama_icon;

				}else
				if($row->corps_id == 2){
					foreach ($type as $key) {
						$id_type_db = $key->shiptype_id;
						$ship_icon = $key->shiptype_icon;
						//cek id icon
						if(!(strcmp($id_type,$id_type_db))){
							 if($ship_icon == NULL){    
								 $nama_icon ="grey-".$defaultIcon;
								 break;
							 }else{
								 $nama_icon ="grey-".$key->shiptype_icon;
								break;
							 }
							
						}else{
							$nama_icon ="grey-".$defaultIcon;
						}
					}
					//cek status kapal
					if($row->ship_stat_id ==2){$folder_icon="lego/";} 
					if($row->ship_stat_id ==3){$folder_icon="sandar/";}          
					$appliedIcon =$nonRealtime."hitam/".$folder_icon.$nama_icon;        

				}else
				if($row->corps_id == 40){
					foreach ($type as $key) {
						$id_type_db = $key->shiptype_id;
						$ship_icon = $key->shiptype_icon;
						//cek id icon
						if(!(strcmp($id_type,$id_type_db))){
							if($ship_icon == NULL){    
								 $nama_icon ="orange-".$defaultIcon;
								 break;
							 }else{
								$nama_icon ="orange-".$key->shiptype_icon;
								break;
							 }
						}else{
							$nama_icon ="orange-".$defaultIcon;
						}
					}
					//cek status kapal
					if($row->ship_stat_id ==2){$folder_icon="lego/";} 
					if($row->ship_stat_id ==3){$folder_icon="sandar/";} 
							
					$appliedIcon =$nonRealtime."orange/".$folder_icon.$nama_icon;        
					
				}else{
					foreach ($type as $key) {
						$id_type_db = $key->shiptype_id;
						$ship_icon = $key->shiptype_icon;
						if(!(strcmp($id_type,$id_type_db))){
							if($ship_icon == NULL){
								$nama_icon =$defaultIcon;
								break;
							}else{
								$nama_icon ="blue-".$key->shiptype_icon;
								break;
							}        
						}else{
							$nama_icon =$defaultIcon;
						}
					}
					//cek status kapal
					if($row->ship_stat_id ==2){$folder_icon="lego/";} 
					if($row->ship_stat_id ==3){$folder_icon="sandar/";} 
					$appliedIcon =$nonRealtime."blue/".$folder_icon.$nama_icon;
				}
?>

<script >
	var ship = new Array();
	var myIcon = L.icon({
	iconUrl: "<?php echo $appliedIcon;?>",
	iconSize: [30, 30],
	iconAnchor: [9, 21],
	popupAnchor: [0, -14]
});
  </script>






<script>

   ship[<?php echo $row->ship_id; ?>] = L.marker([<?php echo $row->ship_lat; ?>,<?php echo $row->ship_lon; ?>], {icon: myIcon, iconAngle:<?php echo $row->ship_direction; ?>} )
   .bindPopup( "<?=$row->ship_name.' - '.$row->ship_id; ?>" )
   .addTo(map);
	
</script>

<?php 


}
}
?>
		
