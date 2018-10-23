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
	<table class="table table-striped table-bordered table-hover" id="dataTables-penghuni">
		<thead>
			<tr class="tittab">
				<td class="header" style="width: 20px;">No</td>
				<td class="header">Kost</td>
				<td class="header">Kamar</td>
				<td class="header">Nama</td>
				<td class="header">No HP</td>
				<td class="header">Jurusan</td>
				<td class="header">Tgl Masuk</td>
			</tr>
		</thead>
		<tbody>
			<?php
				$count=1;
				if(!empty($penghunis)){
					foreach($penghunis as $data) {
						// $deskripsi = $data['properties']; 
						?>
						<tr class="<?php echo alternator("row-two", "row-one"); ?>">
							<td><?php echo ($count++); ?></td>
							<td><?php echo $data->nama_kosan ?></td>
							<td><?php echo $data->nama_kamar ?></td>
							<td><?php echo $data->nama_penghuni ?></td>
							<td><?php echo $data->hp ?></td>
							<td><?php echo $data->jurusan ?></td>
							<td><?php echo $data->tglmasuk ?></td>
						</tr>
			<?php 	}
				} ?>

		</tbody>
	</table>
	</div>

</div> <!-- div main -->
<div class="clear"></div>

<script>
// DATA TABLE GOPAL
$(document).ready(function() {
	$('#dataTables-penghuni').DataTable({
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