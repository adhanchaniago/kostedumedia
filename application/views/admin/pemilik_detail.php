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
						required: true,
						minlength: 5
					},
					confirm_password: {
						required: true,
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
						required: "required",
						minlength: "Your password must be at least 5 characters long"
					},
					confirm_password: {
						required: "required",
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
	<form action="<?php echo base_url() ?>admin/pemilik_ctrl/save" method="post" class="" id="editPengguna">
		<ul class="form-admin">
			<?php if (!empty($obj)) { ?>
				<input type="hidden" value="<?php echo $obj->id_pengguna ?>" name="user_id"/>
			<?php } ?>
			<li>
				<label>Username</label>
				<input class="form-admin" name="username" type="text" class="text-medium"
					value="<?php if (!empty($obj)) echo $obj->username ?>" >
					<?php echo form_error('username'); ?>

				<div class="clear"></div>
			</li>
			<li>
				<label>Nama Lengkap</label>
				<input class="form-admin" name="userfullname" type="text" class="text-medium"
					value="<?php if (!empty($obj)) echo $obj->nama_lengkap ?>" >
					<?php echo form_error('username'); ?>

				<div class="clear"></div>
			</li>
			<li>
				<label>Nomor HP</label>
				<input class="form-admin" name="userhp" type="text" class="text-medium"
					value="<?php if (!empty($obj)) echo $obj->hp ?>" >
					<?php echo form_error('userhp'); ?>

				<div class="clear"></div>
			</li>
			<li>
				<label>Alamat</label>
				<input class="form-admin" name="useralamat" type="text" class="text-medium"
					value="<?php if (!empty($obj)) echo $obj->alamat ?>" >
					<?php echo form_error('useralamat'); ?>

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
			<?php if (!empty($obj)) { ?>
				<li><label></label>*Kosongkan kolom kata sandi jika anda tidak ingin merubah kata sandi.</li>
			<?php } ?>
		</ul>
		<p class="tit-form"></p>
		<ul class="form-admin">
			<li>
				<label>&nbsp;</label>
				<input class="button-form" type="submit" value="Ubah">
<!-- 				<input class="button-form" type="reset" onclick="redirect('')" value="Batal">
				<input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/> -->
			</li>
		</ul>
	</form>
<div class="clear"></div>
</div>

