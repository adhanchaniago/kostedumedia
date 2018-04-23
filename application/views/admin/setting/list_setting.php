<?php if ($this->session->flashdata('info')) { ?>
	<script>
		$(document).ready(function(){
			$('.success').html("<strong><?php echo $this->session->flashdata('info'); ?>");
			$('.success').attr('style','');
			$('.success').delay(10000).fadeOut('slow');
		});
	</script>
<?php } ?>
<script>
	$(document).ready(function(){
		$("#editSetting").validate({
			rules:{
				apel_siaga: "required"
			},
			messages:{
				apel_siaga: "required"
			}
		});
	});
</script>

<div id="main">
	<div class="clear " id="notif-holder"></div>
	<p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
	<br />

<?php if (is_has_access('setting-edit', $permission) || is_has_access('*', $permission)) { ?>
	<p id="form-pos" class="tit-form">Entri Pengaturan</p>
	<form action="<?php echo base_url() ?>admin/setting_ctrl/save" method="post" id="editSetting" enctype="multipart/form-data">
		<ul class="form-admin">
<?php
	if (!empty($settings)) {
		// arranging apel_siaga setting
		$row = $settings[0];
		$apel_descs = json_decode($row->description);
?>
			<li>
				<label><?php echo $row->parameter; ?></label>
				<div class="form-admin-radio">

<?php	foreach ($apel_descs as $desc) { ?>
					<label>
						<input type="radio" name="apel_siaga" value="<?php echo $desc; ?>" <?php if ($desc == $row->value) echo "checked"; ?> > <?php echo $desc; ?>
					</label><br />
<?php	} ?>
				</div>
				<div class="clear"></div>
			</li>
<?php 
		// arranging kri_number_display setting
		$row = $settings[1];
		$hull_display = json_decode($row->description);
?>
			<li>
				<label><?php echo $row->parameter; ?></label>
				<div class="form-admin-radio">

<?php	foreach ($hull_display as $desc) { ?>
					<label>
						<input type="radio" name="kri_number_display" value="<?php echo $desc; ?>" <?php if ($desc == $row->value) echo "checked"; ?> > <?php echo $desc; ?>
					</label><br />
<?php	} ?>
				</div>
				<div class="clear"></div>
			</li>
<?php
		// arranging pesud_number_display setting
		$row = $settings[2];
		$pesud_display = json_decode($row->description);
?>
			<li>
				<label><?php echo $row->parameter; ?></label>
				<div class="form-admin-radio">

<?php	foreach ($pesud_display as $desc) { ?>
					<label>
						<input type="radio" name="pesud_number_display" value="<?php echo $desc; ?>" <?php if ($desc == $row->value) echo "checked"; ?> > <?php echo $desc; ?>
					</label><br />
<?php	} ?>
				</div>
				<div class="clear"></div>
			</li>
<?php
		// arranging myfleet_display setting
		$row = $settings[3];
		$pesud_display = json_decode($row->description);
?>
			<li>
				<label><?php echo $row->parameter; ?></label>
				<div class="form-admin-radio">

<?php	foreach ($pesud_display as $desc) { ?>
					<label>
						<input type="radio" name="myfleet_display" value="<?php echo $desc; ?>" <?php if ($desc == $row->value) echo "checked"; ?> > <?php echo $desc; ?>
					</label><br />
<?php	} ?>
				</div>
				<div class="clear"></div>
			</li>
<?php
	} ?>
			<li>
				<p class="tit-form"></p>
				<label>&nbsp;</label>
				<input class="button-form" type="submit" value="Simpan">
			</li>
		</ul>

	</form>

<?php }?>


</div>
<div class="clear"></div>
