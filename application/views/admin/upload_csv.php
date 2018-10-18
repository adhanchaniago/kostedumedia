<script>
	$(document).ready(function(){
<?php if ($this->session->flashdata('info')) { ?>
		$('.success').html('<strong> <?php echo $this->session->flashdata('info'); ?>');
		$('.success').attr('style','');
		$('.success').delay(10000).fadeOut('slow');
<?php } ?>

			$("#editPengguna").validate({
				rules:{
					user_id: "required",
					password: {
						minlength: 5
					},
					confirm_password: {
						minlength: 5,
						equalTo: "#password"
					},
					username: "required",
					userfullname: "required",
					userhp: "required",
					useralamat: "required"
				},
				messages:{
					user_id: "required",
					password: {
						minlength: "Your password must be at least 5 characters long"
					},
					confirm_password: {
						minlength: "Your password must be at least 5 characters long",
						equalTo: "Please enter the same password as above"
					},
					username: "required",
					userfullname: "required",
					userhp: "required",
					useralamat: "required"
				}
			});

	});

	function redirect(tail){
		window.location = "<?php echo base_url() ?>admin/pemilik_ctrl" + tail;
	}
</script>

<div class="clear " id="notif-holder"></div>
	<p class="notif success " style="display:none"><strong>Edit Sukses</strong>. Data Pemilik berhasil diubah.</p>
	<p id="form-pos" class="tit-form">Informasi Pemilik</p>
	
	<form action="<?php echo base_url() ?>admin/csv_ctrl/upload" method="post" enctype="multipart/form-data">
		<ul class="form-admin">
			<li>
				<label>Ikon </label>
				<input type="file" name="csvfile" />
				<div class="clear"></div>
			</li>

			<li>
				<label>&nbsp;</label>
				<input class="button-form" type="submit" value="Simpan">
				<input class="button-form" type="reset" value="Batal" onclick="redirect('')" >
				<input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
			</li>
		</ul>
	</form>
<div class="clear"></div>
</div>

