<?php 
	function humanTiming ($time)
	{
		$time = time() - $time; // to get the time since that moment
		$time = ($time<1)? 1 : $time;
		$tokens = array (
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		);

		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
		}
	}
?>

<script>
	function redirect(tail){
		window.location = "<?php echo base_url() ?>admin/myfleet_ctrl" + tail;
	}
</script>

<div id="main">
	<div class="clear " id="notif-holder"></div>
	<p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data MyFleet berhasil disimpan.</p>
	
	<p class="tit-form">Daftar <?php echo $title; ?> <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
	<div class="filtering" style="display: none;">
		<form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
			<ul class="filter-form">
				<li>
					<label>MMSI</label><br />
					<input type="text" placeholder="MMSI" name="mf_mmsi" class='filter_param' value="<?php echo $this->input->get('mf_mmsi'); ?>" />
				</li>
				<li>
					<label>Nama Kapal</label><br />
					<input type="text" placeholder="Nama Kapal" name="mf_name" class='filter_param' value="<?php echo $this->input->get('mf_name'); ?>" />
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




	<table class="tab-admin" cellpadding="0" cellspacing="0">
		<thead>
			<tr class="tittab">
				<td class="header" style="width: 30px;">No</th>						
				<td class="header" style="cursor: pointer ;">MMSI</th>			
				<td class="header" style="cursor: pointer ;">Nama Kapal</th>
				<td class="header" style="cursor: pointer ;">Kejadian Terakhir</th>
				<td class="header" style="cursor: pointer ;">Tujuan</th>
				<td class="header" style="cursor: pointer ;">Kecepatan</th>
				<td class="header" style="cursor: pointer ;">Lokasi</th>
				<td class="header delete" style="width: 35px;">Aksi</th>
			</tr>
		</thead>
		<tbody>
<?php
	$count = 1;
	if (!empty($myfleets)) {
		foreach ($myfleets as $row) {
?>
			<tr class="<?php echo alternator("row-one", "row-two"); ?>">
				<td><?php echo ($count++) + $offset; ?></td>
				<td><?php echo $row->mf_mmsi; ?></td>
				<td><?php echo $row->mf_name; ?></td>
				<td>
					<?php if ($row->mf_lastevent_event) echo $row->mf_lastevent_event; else echo '---'; ?>
					<br />
					<?php if ($row->mf_lastevent_eventtime) echo humanTiming(strtotime($row->mf_lastevent_eventtime)) . ' ago'; else echo '---'; ?>
					<!-- <?php if ($row->mf_lastevent_eventtime) echo $row->mf_lastevent_eventtime; else echo '---'; ?> -->
				</td>
				<td>
					<?php if ($row->mf_destination) echo $row->mf_destination; else echo '---'; ?>
					<br />
					<?php if ($row->mf_etatime) echo $row->mf_etatime; else echo '---'; ?>
				</td>
				<td><?php if ($row->mf_speed) echo $row->mf_speed; else echo '---'; ?> knot</td>
				<td><?php if ($row->mf_location) echo $row->mf_location; else echo '---'; ?></td>
				<td class="action"> 
					<a href="<?php echo base_url(); ?>admin/myfleet_ctrl/view/<?php echo $row->mf_mmsi . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-view"></div></a> 
				</td>
			</tr>
<?php
		}
	}
?>

		</tbody>
	</table>
	<br />
		<div class="pagination">
			<?php echo $pagination?>
		</div>
	<br />  

<?php if (!empty($obj)) { ?>
	<p id="form-pos" class="tit-form">Detil <?php echo $title; ?></p>
	<form action="<?php echo base_url() ?>admin/personnel_type_ctrl/save" method="post" class="jNice" id="addPersonnelType">
		<ul class="form-admin">
			<li>
				<label>MMSI </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_mmsi; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Nama Kapal </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_name; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>No IMO </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_imo; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Callsign </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_callsign; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Bendera </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_flag; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Foto </label>
				<img src="<?php echo $obj->mf_photos; ?>" width="500" />
				<div class="clear"></div>
			</li>
			<li>
				<label>URL Detil kapal </label>
				<a href="<?php echo $obj->mf_publicurl; ?>"><?php echo $obj->mf_publicurl; ?></a> 
				<div class="clear"></div>
			</li>
			<li>
				<label>Tipe Kapal </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_type; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Lintang </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo geoComponent($obj->mf_lat, 'a', 'lat'); ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Bujur </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo geoComponent($obj->mf_lon, 'a', 'lon'); ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Heading </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_hdg; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Course </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_course; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Kecepatan </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_speed; ?> knot" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Draught </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_draught; ?> m" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Status Navigasi </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_nav_status; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Lokasi </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_location; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Tujuan </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_destination; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>ETA </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_etatime; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Waktu Posisi Diterima </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_positionreceived; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<br />
				<p class="sub-tit-form">Kejadian Terakhir</p>
			</li>
			<li>
				<label>Kejadian </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_lastevent_event; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Waktu </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_lastevent_eventtime; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<br />
				<p class="sub-tit-form">Pelabuhan Terakhir</p>
			</li>
			<li>
				<label>Nama Pelabuhan </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_lastport_name; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Kode Pelabuhan </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_lastport_locode; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Waktu Kedatangan </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_lastport_arrival; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Waktu Keberangkatan </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_lastport_departure; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<br />
				<p class="sub-tit-form">Pelabuhan Berikutnya</p>
			</li>
			<li>
				<label>Nama Pelabuhan </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_nextport_name; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Kode Pelabuhan </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_nextport_locode; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Negara </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_nextport_country; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Kode Negara </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_nextport_countryiso2; ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<br />
				<p class="sub-tit-form"></p>
			</li>
			<li>
				<label>Info Diperbaharui </label>
				<input class="form-admin" type="text" class="text-medium" maxlength="250" value="<?php echo $obj->mf_last_reload; ?>" >
				<div class="clear"></div>
			</li>
		</ul>
	</form>
<?php } ?>
</div>
<div class="clear"></div>
