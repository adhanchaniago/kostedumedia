<!-- Bootstrap Core CSS datatable-->
<link href="<?php echo base_url() ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url() ?>vendor/datatables/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url() ?>vendor/datatables/css/dataTables.responsive.css" rel="stylesheet">
	
<!-- DataTables JavaScript -->
<script type="text/javascript" src="<?php echo base_url() ?>vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>vendor/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>vendor/datatables/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>vendor/datatables/js/dataTables.responsive.js"></script>

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

	<div class="col-lg-12">
	<table class="table table-striped table-bordered table-hover" id="dataTables-histori">
		<thead>
			<tr >
				<td style="width: 20px;">No</td>
				<td>Alias</td>
				<td>Kamar</td>
				<td>Tgl Masuk</td>
				<td>Tgl Keluar</td>
				<td>Nama</td>
				<td>No HP</td>
				<td>LB</td>
				<td>Aksi</td>
			</tr>
		</thead>
		<tbody>
			<?php
				$count=1;
				if(!empty($hists)){
					foreach($hists as $data) {
						?>
						<tr class="<?php echo alternator("row-two", "row-one"); ?>">
							<td><?php echo ($count++); ?></td>
							<td><?php echo $data->alias_kosan ?></td>
							<td><?php echo $data->hist_kamar ?></td>
							<td><?php echo $data->tglmasuk ?></td>
							<td><?php echo $data->tglkeluar ?></td>
							<td><?php echo $data->nama_penghuni ?></td>
							<td><?php echo $data->hp ?></td>
							<td><?php echo $data->lb ?></td>
							<td class="action"> 
								<a href="<?php echo base_url(); ?>admin/history_ctrl/view/<?php echo $data->id_history . '?' . http_build_query($_GET) . '#form-pos' ?>"><div class="tab-view"></div></a> 
							</td>
						</tr>
			<?php 	}
				} ?>

		</tbody>
	</table>
	</div>

	<p class="tit-form">Detail History Penghuni</p>
	<ul class="form-admin">
		<li>
			<label>Nama Penghuni</label>
			<input class="form-admin" name="nama_penghuni" type="text" class="text-medium" value="<?php if ($hist) echo $hist->nama_penghuni ?>" >
			<div class="clear"></div>
		</li>
		<li>
			<label>Histori Kosan</label>
			<input class="form-admin" name="hist_kosan" type="text" class="text-medium" value="<?php if ($hist) echo $hist->hist_kosan ?>" >
			<div class="clear"></div>
		</li>
		<li>
			<label>Histori Kamar</label>
			<input class="form-admin" name="hist_kamar" type="text" class="text-medium" value="<?php if ($hist) echo $hist->hist_kamar ?>" >
			<div class="clear"></div>
		</li>
		<li>
			<label>TTL</label>
			<input class="form-admin" name="ttl" type="text" class="text-medium" value="<?php if ($hist) echo $hist->ttl ?>" >
			</select>
			<div class="clear"></div>
		</li>
		<li>
			<label>Gender</label>
			<div class="form-admin-radio">
				<input type="radio" name="gender" value="P" checked > P
				<input type="radio" name="gender" value="L" <?php if ($hist && $hist->gender == 'L') echo 'checked'; ?> > L
			</div>
			<div class="clear"></div>
		</li>
		<li>
			<label>Agama</label>
			<input class="form-admin" name="agama" type="text" class="text-medium" value="<?php if ($hist) echo $hist->agama_penghuni ?>" >
			</select>
			<div class="clear"></div>
		</li>
		<li>
			<label>No KTP</label>
			<input class="form-admin" name="noktp" type="text" class="text-medium" value="<?php if ($hist) echo $hist->no_ktp ?>" >
			<div class="clear"></div>
		</li>
		<li>
			<label>Alamat</label>
			<input class="form-admin" name="alamat_penghuni" type="text" class="text-medium" value="<?php if ($hist) echo $hist->alamat_penghuni ?>" >
			<div class="clear"></div>
		</li>
		<li>
			<label>No HP</label>
			<input class="form-admin" name="hp" type="text" class="text-medium" value="<?php if ($hist) echo $hist->hp ?>" >
			<div class="clear"></div>
		</li>
		<li>
			<label>No HP2</label>
			<input class="form-admin" name="hp2" type="text" class="text-medium" value="<?php if ($hist) echo $hist->hp2 ?>" >
			<div class="clear"></div>
		</li>
		<li>
			<label>Jurusan</label>
			<input class="form-admin" name="jurusan" type="text" class="text-medium" value="<?php if ($hist) echo $hist->jurusan ?>">
			<div class="clear"></div>
		</li>
		<li>
			<label>Fakultas</label>
			<input class="form-admin" name="fakultas" type="text" class="text-medium" value="<?php if ($hist) echo $hist->fakultas ?>">
			<div class="clear"></div>
		</li>
		<li>
			<label>NIM</label>
			<input class="form-admin" name="nim" type="text" class="text-medium" value="<?php if ($hist) echo $hist->nim ?>">
			<div class="clear"></div>
		</li>
		<li>
			<label>Tgl Masuk</label>
			<input class="form-admin" id="tglmasuk" name="tglmasuk" type="text" class="text-medium" value="<?php if ($hist) echo $hist->tglmasuk; else echo date('Y-m-d') ?>" >
			<div class="clear"></div>
		</li>
		<li>
			<label>Tgl Keluar</label>
			<input class="form-admin" id="tglkeluar" name="tglkeluar" type="text" class="text-medium" value="<?php echo $hist->tglkeluar ?>" >
			<div class="clear"></div>
		</li>
		<li>
			<label>Ket Ayah</label>
			<input class="form-admin" name="ket_ayah" type="text" class="text-medium" value="<?php if ($hist) echo $hist->ket_ayah ?>">
			<div class="clear"></div>
		</li>
		<li>
			<label>Ket Ibu</label>
			<input class="form-admin" name="ket_ibu" type="text" class="text-medium" value="<?php if ($hist) echo $hist->ket_ibu ?>">
			<div class="clear"></div>
		</li>
		<li>
			<label>Kontak Darurat</label>
			<input class="form-admin" name="kontakdarurat" type="text" class="text-medium" value="<?php if ($hist) echo $hist->hpdarurat ?>" >
			<div class="clear"></div>
		</li>
		<li>
			<label>No HP darurat</label>
			<input class="form-admin" name="hpdarurat" type="text" class="text-medium" value="<?php if ($hist) echo $hist->hpdarurat ?>" >
			<div class="clear"></div>
		</li>
		<li>
			<label>Sisa Pelunasan</label>
			<input class="form-admin" name="sisa_pelunasan" type="text" class="text-medium" value="<?php if ($hist) echo $hist->sisa_pelunasan; else echo '-1' ?>" >
			<div class="clear"></div>
		</li>
		<li>
			<label>Email</label>
			<input class="form-admin" name="email" type="text" class="text-medium" value="<?php if ($hist) echo $hist->email ?>" >
			<div class="clear"></div>
		</li>
		<li>
			<label>FB</label>
			<input class="form-admin" name="fb" type="text" class="text-medium" value="<?php if ($hist) echo $hist->fb ?>" >
			<div class="clear"></div>
		</li>
		<li>
			<label>Twitter</label>
			<input class="form-admin" name="twitter" type="text" class="text-medium" value="<?php if ($hist) echo $hist->twitter ?>" >
			<div class="clear"></div>
		</li>
		<li>
			<label>BBM</label>
			<input class="form-admin" name="bbm" type="text" class="text-medium" value="<?php if ($hist) echo $hist->bbm ?>" >
			<div class="clear"></div>
		</li>
		<li>
			<label>Instagram</label>
			<input class="form-admin" name="ig" type="text" class="text-medium" value="<?php if ($hist) echo $hist->ig ?>" >
			<div class="clear"></div>
		</li>
	</ul>		
</div> <!-- div main -->
<div class="clear"></div>


<script>
// DATA TABLE GOPAL
$(document).ready(function() {
	$('#dataTables-histori').DataTable({
		responsive: true,
		"paging":   false,
        "searching":   true,
        "ordering": true,
        "info":     false
		// "lengthMenu": [[25, 50, 100], [25, 50, 100]]
	});
});
// DATA TABLE GOPAL
</script>