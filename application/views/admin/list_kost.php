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

		$('.delete-tab').click(function(){
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

		var rowTotalKmr = <?php if ($obj) 
									// echo sizeof($obj['kamar']);
									echo '0;';
								else echo '0;';
						?>

		$("#addKmr").click(function() {
			var namaKmr = $('#nama_kmr').val();
			var kmrFilled = $('#terisi_kmr').val();

			if ($('#editNumberKmr').val() != "") {
				var editNumberKmr = $('#editNumberKmr').val();
				$('#kmr_' + editNumberKmr + '').val(namaKmr);
				$('#kmr_td_' + editNumberKmr + '').text(namaKmr);
				$('#filledKmr_' + editNumberKmr + '').val(kmrFilled);
				$('#filledKmr_td_' + editNumberKmr + '').text(kmrFilled);
			} else {
				var rowCount = $('#tableKmr').find('tr').size();
				var tableClass = (rowCount % 2 == 0) ? 'row-two' : 'row-one';
				if (kmrFilled != '') {
					rowTotalKmr = rowTotalKmr + 1;
					$("#totalRowKmr").val(rowTotalKmr);

					var row1 = '<tr class=' + tableClass + '><td>' + rowCount + '</td>';
					var row2 = '<td id=kmr_td_' + rowTotalKmr + '>' + namaKmr + '</td>' + '<input type="hidden" name="kmr_' + rowTotalKmr + '" id="kmr_' + rowTotalKmr + '" value="' + namaKmr + '" />';
					var row3 = '<input type="hidden" name="kmr_' + rowTotalKmr + '" id="kmr_' + rowTotalKmr + '" value="' + namaKmr + '" />';
					var row4 = '<td id=filledKmr_td_' + rowTotalKmr + '>' + kmrFilled + '</td>' + '<input type="hidden" name="filledKmr_' + rowTotalKmr + '" id="filledKmr_' + rowTotalKmr + '" value="' + kmrFilled + '" />';
					var action = '<td class="action"><a href="javascript:void(0);" onClick="editKmr(\'' + rowTotalKmr + '\',\'' + namaKmr + '\',\'' + kmrFilled + '\')" id="editKmr" ><div class="tab-edit"></div></a> <a href="javascript:void(0);" id="deleteKmr"><div class="tab-delete"></div></a></td></tr>';

					$("#tableKmr").append(row1 + row2 + row3 + row4 + action);
					$('#nama_kmr').val('');
					$('#terisi_kmr').val('');
				}
			}
		});

		$("#tableKmr").on('click', '#deleteKmr', function() {
			$(this).parent().parent().remove();
			rowTotalKmr = rowTotalKmr - 1;
			$("#totalRowKmr").val(rowTotalKmr);
		});

		$("#cancelKmr").click(function() {
			$('#nama_kmr').val('');
			$('#terisi_kmr').val('');
			$("#addKmr").val('Tambah Kamar');
		});
	});

	function editKmr(noKmr, namaKmr, filledKmr) {
		$('#editNumberKmr').val(noKmr);
		$('#nama_kmr').val(namaKmr);
		$('#terisi_kmr').val(filledKmr);
		$("#addKmr").val('Ubah');
	}

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
		window.location = "<?php echo base_url() ?>admin/kost_ctrl";
	}

	function deletePenghuni(id_penghuni){
		window.location = "<?php echo base_url() ?>admin/kost_ctrl/delPenghuni/" + id_penghuni;
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
								<a href="<?php echo base_url();?>admin/kost_ctrl/edit/<?php echo $kosan->id_kosan ?>"><div class="tab-edit"></div></a>
								<a href="<?php echo base_url();?>admin/kost_ctrl/delete/<?php echo $kosan->id_kosan ?>" class="delete-tab"><div class="tab-delete"></div></a>
							</td>
						</tr>
			<?php 	}
				} ?>

		</tbody>
	</table>
	<br />  

	<p class="tit-form"><?php if ($obj) echo "Edit Kostan"; else echo "Tambah Kostan Baru"; ?></p>
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
				</ul>
			</div>
			<div class="kolom" id="fffooto">
				<ul class="form-admin">
					<li>
						<label>Foto1</label>
						<input name="fotokost1" id="fotokost1" type="file" class="text-medium" value="<?php if ($obj) echo $obj->foto ?>" >	
						<div class="clear"></div>
					</li>
					<li>
						<label>Foto2</label>
						<input name="fotokost2" id="fotokost2" type="file" class="text-medium" value="<?php if ($obj) echo $obj->foto ?>" >	
						<div class="clear"></div>
					</li>
					<li>
						<label>Foto3</label>
						<input name="fotokost3" id="fotokost3" type="file" class="text-medium" value="<?php if ($obj) echo $obj->foto ?>" >	
						<div class="clear"></div>
					</li>
					<li>
						<label>Lokasi</label>
						<div id=map></div>	
						<div class="clear"></div>
					</li>
				</ul>
			</div>
		</div>

		<p class="tit-form"></p>
		<label>&nbsp;</label>
		<input class="button-form" type="submit" value="<?php if ($obj) echo 'Ubah'; else echo 'Tambah'; ?>">
		<input class="button-form" type="reset" onclick="redirect()" value="Batal">
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
			<td><?php if ($kamar->terisi == 't') echo 'Ya'; else echo 'Tidak'; ?></td>
			<td class="action">
				<a href="<?php echo base_url();?>admin/kost_ctrl/edit/<?php echo $obj->id_kosan . '/' . $kamar->id_kamar ?>"><div class="tab-edit"></div></a>
				<a href="<?php echo base_url();?>admin/kost_ctrl/del_kmr/<?php echo $kamar->id_kamar ?>" class="delete-tab"><div class="tab-delete"></div></a>
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
	  	<p class="tit-form"><?php if ($objkamar) echo 'Ubah Kamar'; else echo 'Input Kamar Baru' ?></p>
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
					<label>Terisi</label>
					<select id="terisi_kmr" name="terisi_kmr" class="form-admin">
						<option value="" selected>-Pilih Kondisi Terisi-</option>
						<option value="t" <?php if ($objkamar && ($objkamar->terisi=='t')) echo 'selected' ?> >terisi</option>
						<option value="f" <?php if ($objkamar && ($objkamar->terisi=='f')) echo 'selected' ?> >kosong</option>
					</select>
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
					<input class="button-form red" type="reset" onclick="redirect()" value="Batal">
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
					<input class="button-form red" type="reset" onclick="<?php if ($penghuni) echo 'delPenghuni('.$penghuni->id_penghuni.')'; else echo 'redirect()'; ?>" value="<?php if ($penghuni) echo 'Ganti Penghuni'; else echo 'Batal'; ?>">
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