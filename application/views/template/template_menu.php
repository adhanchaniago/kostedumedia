<body>
	<div id="container">
		<ul id="side-menu">
			<li id="logo"><img src="<?php echo base_url() ?>assets/html/img/logo-new-liting.png" /></li>
			<li class="category">Data Pokok</li>
			<li class="sub-category">
				<a href="#"><span>Data lagi</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a>
			</li>

<?php if ($permission) { ?>
			<li>
				<a href="<?php echo base_url() . 'admin/pemilik_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/pemilik_ctrl') echo 'class="current"' ?>>
					<img src="<?php echo base_url() ?>assets/html/img/icon-menu/poibe.png">
					Pemilik
				</a>
			</li>
<?php } ?>
<?php if ($permission) { ?>
			<li>
				<a href="<?php echo base_url() . 'admin/kost_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/kost_ctrl') echo 'class="current"' ?>>
					<img src="<?php echo base_url() ?>assets/html/img/icon-menu/poibe.png">
					KOSTan
				</a>
			</li>
<?php } ?>

		</ul>

		<div id="content">
			<div id="title-up">
				<?php if (isset($title)) echo $title ?> <a href="<?php echo base_url() . 'home/logout' ?>" class="red">Keluar</a> <a class="blue" href="<?php echo base_url() ?>html/map_clean">Peta</a>
			</div>

			<div class="clear"></div>
			<br />
