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

		$("#startkomplain").datepicker({dateFormat: 'yy-mm-dd'});
		$("#endkomplain").datepicker({dateFormat: 'yy-mm-dd'});

		$('.delete-tab').click(function(){
			var page = $(this).attr("href");
			var $dialog = $('<div title="Hapus Komplain"></div>')
			.html('Semua informasi komplain akan ikut dihapus! Hapus komplain? <div class="clear"></div>').dialog({
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
		window.location = "<?php echo base_url() ?>admin/komplain_ctrl";
	}

	function deletePenghuni(id_penghuni){
		window.location = "<?php echo base_url() ?>admin/kost_ctrl/delPenghuni/" + id_penghuni;
	}

	function beresSelected() {
		var noww = new Date();
		document.getElementById("endkomplain").disabled = false;
		document.getElementById("endkomplain").value = noww.getFullYear() + '-' + (noww.getMonth()+1) + '-' + noww.getDate();
	}

	function belumBeresSelected() {
		document.getElementById("endkomplain").disabled = true;
		document.getElementById("endkomplain").value = '';
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
	
	<p class="tit-form">Daftar Keluarga <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
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
				<td class="header" style="width: 30px;">No</td>
				<td class="header" style="cursor: pointer ;">Lokasi</td>
				<td class="header" style="cursor: pointer ;">Orang - Kamar</td>
				<td class="header" style="cursor: pointer ;">Masalah</td>
				<td class="header" style="cursor: pointer ;">Mulai Komplain</td>
				<td class="header" style="cursor: pointer ;">Selesai Komplain</td>
				<td class="header" style="cursor: pointer ;">Status Beres</td>
				<td class="header delete" style="width: 52px;">Aksi</td>
			</tr>
		</thead>
		<tbody>
<?php
	$count = 1;
	if (!empty($komplains)) {
		foreach ($komplains as $row) {
?>
			<tr class="<?php echo alternator("row-two", "row-one"); ?>">
				<td><?php echo ($count++) ?></td>
				<td><?php echo $row->lokasi ?></td>
				<td><?php echo $row->orang_kamar ?></td>
				<td><?php echo $row->masalah ?></td>
				<td><?php echo $row->start_komplain ?></td>
				<td><?php echo $row->end_komplain ?></td>
				<td><?php echo ($row->status_beres == 't') ? 'Sudah' : 'Belum' ?></td>
				<td class="action"> 
					<a href="<?php echo base_url();?>admin/komplain_ctrl/edit/<?php echo $row->id_komplain  . '#formedit' ?>"><div class="tab-edit"></div></a>
					<a href="<?php echo base_url();?>admin/komplain_ctrl/delete/<?php echo $row->id_komplain ?>" class="delete-tab"><div class="tab-delete"></div></a>
				</td>
			</tr>
<?php
		}
	}
?>

		</tbody>
	</table>
	<br />
	<br />

	<p class="tit-form"><?php if ($obj) echo "Edit Komplain"; else echo "Tambah Komplain Baru"; ?></p>
	<form action="<?php if ($obj) echo base_url() . 'admin/komplain_ctrl/edit_komplain'; else echo base_url() . 'admin/komplain_ctrl/add_komplain'; ?>" method="post" >
		<ul class="form-admin">
			<?php if ($obj) { ?>
				<input type="hidden" name="id_komplain" value="<?php echo $obj->id_komplain ?>" >
			<?php } ?>
			<li>
				<label>Lokasi</label>
				<input class="form-admin" name="lokasi" type="text" class="text-medium" value="<?php if ($obj) echo $obj->lokasi ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Orang - Kamar</label>
				<input class="form-admin" name="orang_kamar" type="text" class="text-medium" value="<?php if ($obj) echo $obj->orang_kamar ?>" >	
				<div class="clear"></div>
			</li>
			<li>
				<label>Masalah</label>
				<textarea class="form-admin" name="masalah" type="text" class="text-medium" value="<?php if ($obj) echo $obj->masalah ?>" ></textarea>
				<div class="clear"></div>
			</li>
			<li>
				<label>Mulai Komplain</label>
				<input class="form-admin" name="start_komplain" id="startkomplain" type="text" class="text-medium" value="<?php if ($obj) echo $obj->start_komplain; else echo date('Y-m-d') ?>" >	
				<div class="clear"></div>
			</li>
			<li>
				<label>Status Beres</label>
				<div class="form-admin-radio">
					<input type="radio" name="status_beres" onchange="belumBeresSelected()" value="F" checked > Belum Selesai
					<input type="radio" name="status_beres" onchange="beresSelected()" value="T" <?php if ($obj && $obj->status_beres == 't') echo 'checked'; ?> > Sudah Selesai
				</div>
				<div class="clear"></div>
			</li>
			<li>
				<label>Selesai Komplain</label>
				<input class="form-admin" name="end_komplain" id="endkomplain" type="text" class="text-medium" value="<?php if ($obj) echo $obj->end_komplain ?>" <?php if ($obj && $obj->status_beres == 'f') echo 'disabled' ?> >	
				<div class="clear"></div>
			</li>
		</ul>
		<p class="tit-form"></p>
		<label>&nbsp;</label>
		<input class="button-form" type="submit" value="<?php if ($obj) echo 'Ubah'; else echo 'Tambah'; ?>">
		<input class="button-form" type="reset" onclick="redirect()" value="Batal">
		<div class="clear"></div>
		
	</form>
</div> <!-- div main -->
<div class="clear"></div>
