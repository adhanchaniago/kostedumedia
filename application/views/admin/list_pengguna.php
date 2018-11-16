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

		$("#editPengguna").validate({
			rules:{
				id_pengguna: "required",
				password: {
					minlength: 5
				},
				confirm_password: {
					minlength: 5,
					equalTo: "#password"
				},
				username: "required",
				nama_lengkap: "required",
				hp: "required",
				alamat: "required"
			},
			messages:{
				id_pengguna: "required",
				password: {
					minlength: "Your password must be at least 5 characters long"
				},
				confirm_password: {
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
				username: "required",
				nama_lengkap: "required",
				hp: "required",
				alamat: "required"
			}
		});

		$('.delete-tab').click(function(){
			var page = $(this).attr("href");
			var $dialog = $('<div title="Hapus Pengguna"></div>')
			.html('Semua informasi pengguna akan ikut dihapus! Hapus pengguna? <div class="clear"></div>').dialog({
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
			<tr>
				<td class="header" style="width: 30px;">No</td>
				<td class="header" style="cursor: pointer ;">Username</td>
				<td class="header" style="cursor: pointer ;">Nama Lengkap</td>
				<td class="header" style="cursor: pointer ;">HP</td>
				<td class="header" style="cursor: pointer ;">Alamat</td>
				<td class="header delete" style="width: 52px;">Aksi</td>
			</tr>
		</thead>
		<tbody>
<?php
	$count = 1;
	if (!empty($penggunas)) {
		foreach ($penggunas as $row) {
?>
			<tr class="<?php echo alternator("row-two", "row-one"); ?>">
				<td><?php echo ($count++) ?></td>
				<td><?php echo $row->username ?></td>
				<td><?php echo $row->nama_lengkap ?></td>
				<td><?php echo $row->hp ?></td>
				<td><?php echo $row->alamat ?></td>
				<td class="action"> 
					<a href="<?php echo base_url();?>admin/pengguna_ctrl/edit/<?php echo $row->id_pengguna  . '#formedit' ?>"><div class="tab-edit"></div></a>
					<a href="<?php echo base_url();?>admin/pengguna_ctrl/delete/<?php echo $row->id_pengguna ?>" class="delete-tab"><div class="tab-delete"></div></a>
				</td>
			</tr>
<?php
		}
	}
?>

		</tbody>
	</table>
	<br><br>
	</div>

	<p class="tit-form"><?php if ($obj) echo "Edit Pengguna"; else echo "Tambah Pengguna Baru"; ?></p>
	<form action="<?php if ($obj) echo base_url() . 'admin/pengguna_ctrl/edit_pengguna'; else echo base_url() . 'admin/pengguna_ctrl/add_pengguna'; ?>" method="post" id="editPengguna" >
		<ul class="form-admin">
			<?php if ($obj) { /* print_r($obj); die();*/ ?>
				<input type="hidden" name="id_pengguna" value="<?php echo $obj->id_pengguna ?>" >
			<?php } ?>
			<li>
				<label>Username</label>
				<input class="form-admin" name="username" type="text" class="text-medium" value="<?php if ($obj) echo $obj->username ?>" >
				<div class="clear"></div>
			</li>
			<li>
				<label>Nama Lengkap</label>
				<input class="form-admin" name="nama_lengkap" type="text" class="text-medium" value="<?php if ($obj) echo $obj->nama_lengkap ?>" >	
				<div class="clear"></div>
			</li>
			<li>
				<label>HP</label>
				<input class="form-admin" name="hp" type="text" class="text-medium" value="<?php if ($obj) echo $obj->hp ?>" >	
				<div class="clear"></div>
			</li>
			<li>
				<label>Alamat</label>
				<textarea class="form-admin" name="alamat" style="width: 30%"><?php if ($obj) echo $obj->alamat ?></textarea>
				<div class="clear"></div>
			</li>
			<li>
				<label>Kata Sandi</label>
				<input class="form-admin" name="password" id="password" type="password" class="text-medium" value="" />
					   <?php echo form_error('password'); ?>					

				<div class="clear"></div>
			</li>
			<li>
				<label>Konfirmasi kata sandi</label>
				<input class="form-admin" name="confirm_password" id="confirm_password" type="password" class="text-medium" />

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
