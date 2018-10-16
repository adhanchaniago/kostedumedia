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
		
<?php if ($this->session->flashdata('success')) { ?>
		$('.success').html("<strong> <?php echo $this->session->flashdata('success'); ?>");
		$('.success').attr('style','');
		$('.success').delay(10000).fadeOut('slow');
<?php } else if ($this->session->flashdata('failed')) { ?>
		$('.error').html("<strong> <?php echo $this->session->flashdata('failed'); ?>");
		$('.error').attr('style','');
		$('.error').delay(10000).fadeOut('slow');
<?php } ?>

		$('.del-kosan').click(function(){
			var page = $(this).attr("href");
			var $dialog = $('<div title="Hapus Kosan"></div>')
			.html('Semua informasi kosan akan ikut dihapus! Hapus kosan? <div class="clear"></div>').dialog({
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

		$('.del-kamar').click(function(){
			var page = $(this).attr("href");
			var $dialog = $('<div title="Hapus Kamar"></div>')
			.html('Semua informasi kamar dan penghuninya akan ikut dihapus! Hapus Kamar? <div class="clear"></div>').dialog({
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

	function create_url(){
		var url = $('#form_search_filter').attr('action')+'/?filter=true&';
		var param = '';
		$('.filter_param').each(function(){
			param += $(this).attr('name')+'='+$(this).val()+'&';
		});
		
		$('#form_search_filter').attr('action',url+param).submit();
	}

	function redirect(tambahan = null){
		if (tambahan == null)
			window.location = "<?php echo base_url() ?>admin/kost_ctrl";
		else
			window.location = "<?php echo base_url() ?>admin/kost_ctrl/edit/" + tambahan + "#formkosan";
	}

	function delPenghuni(id_penghuni){
		var $dialog = $('<div title="Kosongkan Penghuni"></div>')
		.html('Semua informasi penghuni akan dipindahkan ke history penghuni dan tidak bisa di-undo! Kosongkan penghuni? <div class="clear"></div>').dialog({
			autoOpen: false,
			width: 280,
			show: "fade",
			hide: "fade",
			modal: true,
			resizable: false,
			buttons: {
				"Ok": function() {
					$(this).dialog("close");
					window.location = "<?php echo base_url() ?>admin/kost_ctrl/del_penghuni/" + id_penghuni;
				},
				"Cancel": function() {
					$(this).dialog("close");
				}
			}
		});
		$dialog.dialog('open');
		return false;
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
	<p class="notif success " style="display:none"></p>
	<p class="notif error " style="display:none"></p>
	
	<p class="tit-form">Daftar Kostan <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
	<div class="filtering" style="display: none;">
		<form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
			<ul class="filter-form">
				<li>
					<label>Filter POI</label><br />
					<input type="text" placeholder="Nama Area" name="poi_name" class='filter_param' value="<?php echo $this->input->get('poi_name'); ?>" onkeypress="search_enter_press(event);" />
				</li>
			</ul>

			<div class="clear"></div>
			<div style="border-bottom: 1px dotted #DDD; margin: 15px 0 17px 0;"></div>
			<input type="button" value="Bersihkan Pencarian" onclick="redirect()" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
			<input type="button" value="Cari" name="search_filter" onclick="create_url()" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
			<div class="clear"></div>
			<div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
		</form>
	</div>
	<table class="tab-admin">
		<thead>
			<tr class="tittab">
				<td class="header" style="width: 20px;">No</th>                     
				<td class="header">Nama Kostan</td>
				<td class="header">Alamat</td>
<!-- 				<td class="header">Lokasi</td>
				<td class="header">Detail</td> -->
				<td class="header delete" style="width: 52px;">Aksi</td>
			</tr>
		</thead>
		<tbody>
			<?php 
				$count=1;
				if(!empty($kosts)){
					foreach($kosts as $kosan) {
						// $deskripsi = $kosan['properties']; 
						?>
						<tr class="<?php echo alternator("row-two", "row-one"); ?>">
							<td><?php echo ($count++); ?></td>
							<td><?php echo $kosan->nama_kosan ?></td>
							<td><?php echo $kosan->alamat ?></td>
<!-- 							<td><?php echo $deskripsi['lokasi'] ?></td>
							<td><?php echo $deskripsi['desclok'] ?></td> -->
							<td class="action">
								<a href="<?php echo base_url();?>admin/kost_ctrl/edit/<?php echo $kosan->id_kosan  . '#formkosan' ?>"><div class="tab-edit"></div></a>
								<a href="<?php echo base_url();?>admin/kost_ctrl/delete/<?php echo $kosan->id_kosan ?>" class="del-kosan"><div class="tab-delete"></div></a>
							</td>
						</tr>
			<?php 	}
				} ?>

		</tbody>
	</table>
	<br />  

	<p id="formkosan" class="tit-form"><?php if ($obj) echo "Edit Kostan"; else echo "Tambah Kosan Baru"; ?></p>
	<form action="<?php if ($obj) echo base_url() . 'admin/kost_ctrl/edit_kosan'; else echo base_url() . 'admin/kost_ctrl/add_kosan'; ?>" method="post" >
		<div class="baris">
			<div class="kolom" id="ffform">
				<ul class="form-admin">
					<input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
					<?php if ($obj) { ?>
						<input type="hidden" name="id_kosan" value="<?php echo $obj->id_kosan ?>" >
					<?php } ?>
					<li>
						<label>Judul</label>
						<input class="form-admin" name="judul_kosan" id="judul_kosan" type="text" class="text-medium" value="<?php if ($obj) echo $obj->nama_kosan ?>" >
						<div class="clear"></div>
					</li>
					<li>
						<label>Alamat</label>
						<input class="form-admin" name="alamat_kosan" id="alamat_kosan" type="text" class="text-medium" value="<?php if ($obj) echo $obj->alamat ?>" >	
						<div class="clear"></div>
					</li>
					<li>
						<label>Deskripsi</label>
						<input class="form-admin" name="desk_kosan" id="desk_kosan" type="text" class="text-medium" value="<?php if ($obj) echo $obj->deskripsi ?>" >	
						<div class="clear"></div>
					</li>
					<li>
						<label>Fasilitas Umum</label>
						<input class="form-admin" name="fasum" id="fasum" type="text" class="text-medium" value="<?php if ($obj) echo $obj->fasum ?>" >	
						<div class="clear"></div>
					</li>
					<li>
						<label>Deskripsi Lokasi</label>
						<input class="form-admin" name="desk_lokasi" id="desk_lokasi" type="text" class="text-medium" value="<?php if ($obj) echo $obj->deskripsilokasi ?>" >	
						<div class="clear"></div>
					</li>
					<li>
						<label>Link Lokasi</label>
						<input class="form-admin" name="lokasi" id="lokasi" type="text" class="text-medium" value="<?php if ($obj) echo $obj->lokasi ?>" >	
						<div class="clear"></div>
					</li>
					<li>
						<label>Kamar Mandi</label>
						<input class="form-admin" name="kamarmandi" id="kamarmandi" type="text" class="text-medium" value="<?php if ($obj) echo $obj->kamarmandi ?>" >	
						<div class="clear"></div>
					</li>
					<li>
						<label>Kontak</label>
						<input class="form-admin" name="kontak" id="kontak" type="text" class="text-medium" value="<?php if ($obj) echo $obj->kontak ?>" >	
						<div class="clear"></div>
					</li>
					<li>
						<label>Foto</label>
						<input name="foto_kosan" id="foto_kosan" type="file" class="text-medium" value="<?php if ($obj) echo $obj->foto_kosan ?>" >	
						<div class="clear"></div>
					</li>
				</ul>
			</div>
			<div class="kolom" id="fffooto">
				<ul class="form-admin">
					<li>
						<label>Lintang</label>
						<input class="form-admin" name="lat" id="inputlat" type="text" class="text-medium" value="<?php if ($obj) echo $obj->lat ?>" >	
						<div class="clear"></div>
					</li>
					<li>
						<label>Bujur</label>
						<input class="form-admin" name="lon" id="inputlon" type="text" class="text-medium" value="<?php if ($obj) echo $obj->lon ?>" >	
						<div class="clear"></div>
					</li>
					<li>
						<label>Lokasi</label>
						<div id="map" style="width: 400px; height: 300px"></div>
						<div class="clear"></div>
					</li>
				</ul>
			</div>
		</div>

		<p class="tit-form"></p>
		<label>&nbsp;</label>
		<input class="button-form green" type="submit" value="<?php if ($obj) echo 'Ubah'; else echo 'Tambah'; ?>">
		<input class="button-form red" type="reset" onclick="redirect()" value="Batal">
		<div class="clear"></div>
		
	</form>
		
<?php if ($kamars) { ?>
	<br/>
	<p class="tit-form">Daftar Kamar</p>
	<table id="tableKmr" class="tab-admin">
		<tr class="tittab">
			<td>No</td>
			<td>Nama</td>
			<td>Luas (m<sup>2</sup>)</td>
			<td>Fasilitas</td>
			<td>Harga</td>
			<td>Terisi</td>
			<td style="width: 78px;">Aksi</td>
		</tr>
<?php $count_kamar = 1;
	foreach ($kamars as $kamar) {
?>
		<tr class="<?php echo alternator("row-one", "row-two"); ?>">
			<td><?php echo $count_kamar; ?></td>
			<td><?php echo $kamar->nama_kamar ?></td>
			<td><?php echo $kamar->luas ?></td>
			<td><?php echo $kamar->fasilitas ?></td>
			<td><?php echo $kamar->hargath ?></td>
			<td><?php if ($kamar->id_penghuni > 0) echo 'Ya'; else echo 'Tidak'; ?></td>
			<td class="action">
				<a href="<?php echo base_url();?>admin/kost_ctrl/edit/<?php echo $obj->id_kosan . '/' . $kamar->id_kamar . '#formkamar' ?>"><div class="tab-edit"></div></a>
				<a href="<?php echo base_url();?>admin/kost_ctrl/del_kmr/<?php echo $kamar->id_kamar ?>" class="del-kamar"><div class="tab-delete"></div></a>
			</td>
		</tr>
<?php
		$count_kamar++;
	} 
?>
	</table>
<?php } 

if ($obj) {
?>
	<br />
	<div class="baris">
		<div class="kolom" id="kolom1">
	  	<p id="formkamar" class="tit-form"><?php if ($objkamar) echo 'Ubah Kamar'; else echo 'Input Kamar Baru' ?></p>
		<form action="<?php if ($objkamar) echo base_url() . 'admin/kost_ctrl/edit_kamar'; else echo base_url() . 'admin/kost_ctrl/add_kamar'; ?>" method="post" >
			<input type="hidden" name="id_kosan" value="<?php echo $obj->id_kosan ?>" />
<?php if ($objkamar) { ?>
			<input type="hidden" name="id_kamar" value="<?php echo $objkamar->id_kamar ?>" />
<?php } ?>
			<ul class="form-admin">
				<li>
					<label>Nama</label>
					<input class="form-admin" id="nama_kmr" name="nama_kmr" type="text" class="text-medium" value="<?php if ($objkamar) echo $objkamar->nama_kamar ?>" >
					<div class="clear"></div>
				</li>
				<li>
					<label>Luas</label>
					<input class="form-admin" id="luas_kmr" name="luas_kmr" type="text" class="text-medium" value="<?php if ($objkamar) echo $objkamar->luas ?>" >
					<div class="clear"></div>
				</li>
				<li>
					<label>Fasilitas</label>
					<input class="form-admin" id="fasilitas_kmr" name="fasilitas_kmr" type="text" class="text-medium" value="<?php if ($objkamar) echo $objkamar->fasilitas ?>" >
					<div class="clear"></div>
				</li>
				<li>
					<label>Harga / Thn</label>
					<input class="form-admin" id="harga_kmr" name="harga_kmr" type="text" class="text-medium" value="<?php if ($objkamar) echo $objkamar->hargath ?>" >
					<div class="clear"></div>
				</li>
				<li>
					<label>Pembayaran</label>
					<input class="form-admin" id="pmby_kmr" name="pmby_kmr" type="text" class="text-medium">
					<div class="clear"></div>
				</li>
				<li>
					<label>Sisa Pembayaran</label>
					<input class="form-admin" id="sisapmby_kmr" name="sisapmby_kmr" type="text" class="text-medium">
					<div class="clear"></div>
				</li>
				<li>
					<label>Foto Kamar 1</label>
					<input name="alamat_kosan" id="fotokamar1" type="file" class="text-medium" value="" >	
					<div class="clear"></div>
				</li>
				<li>
					<label>Foto Kamar 2</label>
					<input name="alamat_kosan" id="fotokamar2" type="file" class="text-medium" value="" >	
					<div class="clear"></div>
				</li>
				<li>
					<label></label>
					<input class="button-form green" type="submit" value="<?php if ($objkamar) echo 'Ubah'; else echo 'Tambah'; ?>">
					<input class="button-form red" type="reset" onclick="<?php echo 'redirect('.$obj->id_kosan.')' ?>" value="Batal">
					<div class="clear"></div>
				</li>
			</ul>
		</form>
	</div>
<?php if ($objkamar) { ?>
	<div class="kolom" id="kolom2">
	  	<p class="tit-form">Data Penghuni</p>
		<form action="<?php if ($penghuni) echo base_url() . 'admin/kost_ctrl/edit_penghuni'; else echo base_url() . 'admin/kost_ctrl/add_penghuni'; ?>" method="post" >
			<input type="hidden" name="id_kamar" value="<?php echo $objkamar->id_kamar ?>" />
	<?php if ($penghuni) { ?>
			<input type="hidden" name="id_penghuni" value="<?php echo $penghuni->id_penghuni ?>" />
			<input type="hidden" name="hist_kamar" value="<?php echo $objkamar->nama_kamar ?>" />
			<input type="hidden" name="hist_kosan" value="<?php echo $obj->nama_kosan ?>" />
	<?php } ?>
			<ul class="form-admin">
				<li>
					<label>Nama Penghuni</label>
					<input class="form-admin" id="nama_penghuni" name="nama_penghuni" type="text" class="text-medium" value="<?php if ($penghuni) echo $penghuni->nama_penghuni ?>" >
					<div class="clear"></div>
				</li>
				<li>
					<label>TTL</label>
					<input class="form-admin" id="ttl" name="ttl" type="text" class="text-medium">
					</select>
					<div class="clear"></div>
				</li>
				<li>
					<label>Gender</label>
					<input class="form-admin" id="gender" name="gender" type="text" class="text-medium">
					<div class="clear"></div>
				</li>
				<li>
					<label>Agama</label>
					<input class="form-admin" id="agama" name="agama" type="text" class="text-medium">
					<div class="clear"></div>
				</li>
				<li>
					<label>No KTP</label>
					<input class="form-admin" id="noktp" name="noktp" type="text" class="text-medium" value="<?php if ($penghuni) echo $penghuni->no_ktp ?>" >
					<div class="clear"></div>
				</li>
				<li>
					<label>Alamat</label>
					<input class="form-admin" id="alamat" name="alamat" type="text" class="text-medium" value="<?php if ($penghuni) echo $penghuni->alamat ?>" >
					<div class="clear"></div>
				</li>
				<li>
					<label>No HP</label>
					<input class="form-admin" id="hp" name="hp" type="text" class="text-medium" value="<?php if ($penghuni) echo $penghuni->hp ?>" >
					<div class="clear"></div>
				</li>
				<li>
					<label>Aktivitas</label>
					<input class="form-admin" id="aktivitas" name="aktivitas" type="text" class="text-medium">
					<div class="clear"></div>
				</li>
				<li>
					<label>Tgl Masuk</label>
					<input class="form-admin" id="tglmasuk" name="tglmasuk" type="text" class="text-medium" value="<?php if ($penghuni) echo $penghuni->tglmasuk ?>" >
					<div class="clear"></div>
				</li>
				<li>
					<label>Tgl Keluar</label>
					<input class="form-admin" id="tglkeluar" name="tglkeluar" type="text" class="text-medium" value="<?php if ($penghuni) echo $penghuni->tglkeluar ?>" >
					<div class="clear"></div>
				</li>
				<li>
					<label>Ket Ayah</label>
					<input class="form-admin" id="ket_ayah" name="ket_ayah" type="text" class="text-medium">
					<div class="clear"></div>
				</li>
				<li>
					<label>Ket Ibu</label>
					<input class="form-admin" id="ket_ibu" name="ket_ibu" type="text" class="text-medium">
					<div class="clear"></div>
				</li>
				<li>
					<label>Kontak Darurat</label>
					<input class="form-admin" id="kontakdarurat" name="kontakdarurat" type="text" class="text-medium" value="<?php if ($penghuni) echo $penghuni->hpdarurat ?>" >
					<div class="clear"></div>
				</li>
				<li>
					<label>No HP darurat</label>
					<input class="form-admin" id="hpdarurat" name="hpdarurat" type="text" class="text-medium" value="<?php if ($penghuni) echo $penghuni->hpdarurat ?>" >
					<div class="clear"></div>
				</li>
				<li>
					<label>Email</label>
					<input class="form-admin" id="email" name="email" type="text" class="text-medium">
					<div class="clear"></div>
				</li>
				<li>
					<label>FB</label>
					<input class="form-admin" id="fb" name="fb" type="text" class="text-medium">
					<div class="clear"></div>
				</li>
				<li>
					<label>Instagram</label>
					<input class="form-admin" id="ig" name="ig" type="text" class="text-medium">
					<div class="clear"></div>
				</li>
				<li>
					<label>Twitter</label>
					<input class="form-admin" id="twitter" name="twitter" type="text" class="text-medium">
					<div class="clear"></div>
				</li>
				<li>
					<label>BBM</label>
					<input class="form-admin" id="bbm" name="bbm" type="text" class="text-medium">
					<div class="clear"></div>
				</li>
				<li>
					<label>Foto KTP</label>
					<input class="form-admin" id="fotoktp" name="fotoktp" type="text" class="text-medium">
					<div class="clear"></div>
				</li>
				<li>
					<label>Foto KTM</label>
					<input class="form-admin" id="fotoktm" name="fotoktm" type="text" class="text-medium">
					<div class="clear"></div>
				</li>
				<li>
					<label>Foto Diri</label>
					<input class="form-admin" id="fotodiri" name="fotodiri" type="text" class="text-medium">
					<div class="clear"></div>
				</li>
				<li>
					<label></label>
					<input class="button-form green" type="submit" value="<?php if ($penghuni) echo 'Ubah Data Penghuni'; else echo 'Set Penghuni'; ?>">
			<?php if ($penghuni) {
					echo '<input class="button-form red del-penghuni" type="reset" onclick="delPenghuni('.$penghuni->id_penghuni.')" value="Kosongkan Penghuni" >';
				} ?>
					<div class="clear"></div>
				</li>
			</ul>
		</form>
	</div> <!-- kolom -->

<?php 
	}
} ?>
</div> <!-- div main -->
<div class="clear"></div>

<script type="text/javascript">
	// var configMap = {
	// 	latCenter : -6.862386170,
	// 	lonCenter : 107.588816285,
	// 	zoom :17,
	// 	mapUrl : '<?php echo $this->config->item('map_url') ?>',
	// 	mapStyleId : 22677
	// };
			var configMap = {
						//gerlong
						latCenter : -6.862386170,
						lonCenter : 107.588816285,
						zoom :17,

						mapUrl : 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
						mapStyleId : 22677
		};
	var minimal   = L.tileLayer(configMap.mapUrl, {styleId: configMap.mapStyleId});
	var southWest = new L.LatLng(85, -180);
	var northEast = new L.LatLng(-85, 180);
	var bounds = new L.LatLngBounds(southWest, northEast);
	var bounds_area_input = $("#bounds_area_input");

	//fixation for pan inside bounds

	L.Map.include({panInsideBounds: function(bounds) {
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
	}});

	//fixation for pan inside bounds
	var map = new L.map('map', {
		center: [configMap.latCenter, configMap.lonCenter],
		zoom: configMap.zoom,
		layers: [minimal],
		maxZoom : 19,
		minZoom : 3
	});

	var drawnItems = new L.FeatureGroup();
	map.addLayer(drawnItems);

	//View for Longitude and Latitude topright in the map
	var attrib = new L.Control.Attribution();
	map.addControl(attrib);
	attrib.setPrefix('Koordinat : ');
	map.on('mousemove', function(e) {
		var latlng = e.latlng;
		attrib.setPrefix('Koordinat : '+viewableCoordinate(latlng.lat,'lat') + ", " + viewableCoordinate(latlng.lng,'lng'));
	});

	map.on('click', function(e) {
		document.getElementById("inputlat").value = e.latlng.lat;
		document.getElementById("inputlon").value = e.latlng.lng; 
	});

</script>