<?php
/**
 * @author Wira Sakti G
 * @added Mar 20, 2013
 */
?>
<script type="text/javascript" src="<?php echo $this->config->item('socket_ip') ?>/socket.io/socket.io.js"></script>
<script>
	// alert("hello");
	$(document).ready(function() {
		socket = io.connect('<?php echo $this->config->item('socket_ip') ?>');
		
		socket.on('updatePesan', function(param){
			console.log('updatePesan ' + param);
			// alert(param);
			$("#tes").html("<img src='<?php echo base_url() ?>assets/html/img/icon-menu/roles.png'> Pesan (" + nPes + ")");
		});
		
		socket.on('updateOutboxCount', function(mm){
			console.log("updateOutboxCount " + mm);
			
			var n = (JSON.parse(mm))[0].count;
			if (n == 0) 
				$("#pesanKeluar").html("<img src='<?php echo base_url() ?>assets/html/img/icon-menu/roles.png'> Pesan Keluar");
			else
				$("#pesanKeluar").html("<img src='<?php echo base_url() ?>assets/html/img/icon-menu/roles.png'> <b> Pesan Keluar (" + n + ") </b>");
		});
		
		socket.on('outboxNotif', function() {
			$('.success').html("<strong>Pesan terkirim");
			$('.success').attr('style','');
			$('.success').click(function() {
				$('.success').fadeOut('slow');
				window.location.assign("message_ctrl/outbox")
			});
		});
		
		socket.on('updateUnreadInbox', function(mm){
			console.log("updateUnreadInbox " + mm);
			
			var n = (JSON.parse(mm))[0].count;
			if (n == 0) 
				$("#pesanMasuk").html("<img src='<?php echo base_url() ?>assets/html/img/icon-menu/roles.png'> Pesan Masuk");
			else
				$("#pesanMasuk").html("<img src='<?php echo base_url() ?>assets/html/img/icon-menu/roles.png'> <b> Pesan Masuk (" + n + ") </b>");
		});
		
		socket.on('inboxNotif', function() {
			$('.success').html("<strong>Pesan diterima");
			$('.success').attr('style','');
			$('.success').click(function() {
				$('.success').fadeOut('slow');
				window.location.assign("message_ctrl/inbox")
			});
		});
		
		socket.on('updateDraftCount', function(mm){
			console.log('updateDraftCount ' + mm);
			
			// if (mm) {
				var n = (JSON.parse(mm))[0].count;
				if (n == 0) 
					$("#tulisPesan").html("<img src='<?php echo base_url() ?>assets/html/img/icon-menu/roles.png'> Tulis Pesan");
				else
					$("#tulisPesan").html("<img src='<?php echo base_url() ?>assets/html/img/icon-menu/roles.png'> Tulis Pesan (" + n + ")");
			// }
		});
	});
	// */
</script>
<body>
	<div id="container">
		<ul id="side-menu">
			<li id="logo"><img src="<?php echo base_url() ?>assets/html/img/logo-new-liting.png" /></li>
			<li class="category">Data Pokok</li>
			<li class="sub-category">
				<a href="#"><span>Dislokasi Unsur Operasi</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a>
			</li>
			<li>
				<a href="<?php echo base_url() . 'admin/ship_ctrl/position' ?>" <?php if (isset($current_context) && $current_context == '/admin/ship_ctrl/position') echo 'class="current"' ?>>
					<img src="<?php echo base_url() ?>assets/html/img/icon-menu/kapal.png">
					KRI
				</a>
			</li>
			<li>
				<a href="<?php echo base_url() . 'admin/aeroplane_ctrl/position' ?>" <?php if (isset($current_context) && $current_context == '/admin/aeroplane_ctrl/position') echo 'class="current"' ?>>
					<img src="<?php echo base_url() ?>assets/html/img/icon-menu/pesawat-udara.png">
					Pesawat Udara
				</a>
			</li>
			<li>
				<a href="<?php echo base_url() . 'admin/marines_ctrl/position' ?>" <?php if (isset($current_context) && $current_context == '/admin/marines_ctrl/position') echo 'class="current"' ?>>
					<img src="<?php echo base_url() ?>assets/html/img/icon-menu/marinir.png">
					Satgas
				</a>
			</li>
			<li class="sub-category" style="display: none;">
				<a href="#" style="display: none;"><span>Operasional</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a>
			</li>
			<!-- commented by SKM17
			<li>
				<a href="<?php echo base_url() . 'admin/operation_ctrl/operation_list' ?>" <?php if (isset($current_context) && $current_context == '/admin/operation_ctrl/operation_list') echo 'class="current"' ?>>
					<img src="<?php echo base_url() ?>assets/html/img/icon-menu/info.png">
					Daftar Operasi
				</a>
			</li>
			-->
			<?php if (is_has_access('ssat', $permission) || is_has_access('*', $permission)) { ?>
				<li class="sub-category">
					<a href="#"><span>SSAT</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a>
				</li>
				<?php if (is_has_access('ship_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/ship_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/ship_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/kapal.png">
							KRI
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('aeroplane_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/aeroplane_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/aeroplane_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/pesawat-udara.png">
							Pesawat Udara
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('marines_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/marines_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/marines_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/satuan_marinir.png">
							Satuan Marinir
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('station_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/station_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/station_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/pos.png">
							Pangkalan
						</a>
					</li>
				<?php } ?>
			<?php } ?>
			<!-- commented by SKM17
			<?php if (is_has_access('report', $permission) || is_has_access('*', $permission)) { ?>
				<li class="sub-category">
					<a href="#"><span>Laporan</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a>
				</li>
				<?php if (is_has_access('areal_report', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/areal_report_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/areal_report_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/info.png">
							Laporan Unsur
						</a>
					</li>
				<?php } ?>
				<li>
					<a href="<?php echo base_url() . 'admin/reporting_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/reporting_ctrl') echo 'class="current"' ?>>
						<img src="<?php echo base_url() ?>assets/html/img/icon-menu/info.png">
						Cetak Laporan
					</a>
				</li>
			<?php } ?>
			-->
			<!--
			<?php if (is_has_access('personnel_ref', $permission) || is_has_access('*', $permission)) { ?>
				<li>
					<a href="<?php echo base_url() . 'admin/personnel_reff_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/personnel_reff_ctrl') echo 'class="current"' ?>>
						<img src="<?php echo base_url() ?>assets/html/img/icon-menu/personel.png">
						Personel
					</a>
				</li>
			<?php } ?>
			-->
			<?php if (is_has_access('intelligent', $permission) || is_has_access('*', $permission)) { ?>
				<li class="sub-category">
					<a href="#"><span>Intelijen</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a>
				</li>
				<?php if (is_has_access('enemy_force_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/enemy_force_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/enemy_force_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/radar.png">
							Kekuatan Lawan
						</a>
					</li>
				<?php } ?>
			<?php } ?>
			<?php if (is_has_access('support', $permission) || is_has_access('*', $permission)) { ?>
				<li class="sub-category">
					<a href="#"><span>Pendukung</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a>
				</li>
				<?php if (is_has_access('defined_area_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/defined_area_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/defined_area_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/area.png">
							Area
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('poi_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/poi_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/poi_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/poibe.png">
							POI
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('gs_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/gs_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/gs_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/groundstation.png">
							Groundstation
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('myfleet_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/myfleet_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/myfleet_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/fleet.png">
							MyFleet
						</a>
					</li>
				<?php } ?>
			<?php } ?>
			<!-- commented by SKM17
			<li class="category">Pengaturan</li>
			<?php if (is_has_access('status', $permission) || is_has_access('*', $permission)) { ?>
				<li class="sub-category">
					<a href="#"><span>Status</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a>
				</li>
				<?php if (is_has_access('ops_status', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/ops_status_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/ops_status_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/operasi.png">
							Operasi
						</a>
					</li>
				<?php } ?>
			<?php } ?>
			-->
			<li class="category">Data Pendukung</li>
			<?php if (is_has_access('types', $permission) || is_has_access('*', $permission)) { ?>
				<li class="sub-category">
					<a href="#"><span>Daftar / Jenis</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a>
				</li>
				<?php if (is_has_access('operation', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/operation_ctrl2' ?>" <?php if (isset($current_context) && $current_context == '/admin/operation_ctrl2') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/info.png">
							Daftar Operasi
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('unit_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/unit_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/unit_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/pos.png">
							Daftar Kesatuan
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('logistic_item', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/logistic_item_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/logistic_item_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/barang-logistik.png">
							Kondisi Teknis
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('corps_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/corps_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/corps_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/komando.png">
							Daftar Pembina
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('ship_status', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/ship_status_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/ship_status_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/kapal.png">
							Daftar Status Kapal
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('port_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/port_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/port_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/plbn.png">
							Daftar Pelabuhan
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('personnel_type', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/personnel_type_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/personnel_type_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/personel.png">
							Tipe Personil
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('aeroplane_type', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/aeroplane_type_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/aeroplane_type_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/pesawat-udara.png">
							Tipe Pesawat
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('aoipoi_type_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/aoipoi_type_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/aoipoi_type_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/poitype.png">
							Tipe POI
						</a>
					</li>
				<?php } ?>
			<?php } ?>
			<?php if (is_has_access('icon', $permission) || is_has_access('*', $permission)) { ?>
				<li class="sub-category">
					<a href="#"><span>Atur Ikon</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a>
				</li>
				<?php if (is_has_access('ship_type', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/ship_type_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/ship_type_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/kapal.png">
							Ikon Kapal
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('aeroplane_icon_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/aeroplane_icon_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/aeroplane_icon_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/pesawat-udara.png">
							Ikon Pesawat
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('marine_icon_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/marine_icon_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/marine_icon_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/marinir.png">
							Ikon Marinir
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('station_type', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/station_type_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/station_type_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/pos.png">
							Ikon Pangkalan
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('enemy_force_flag', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/enemy_force_flag_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/enemy_force_flag_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/musuh.png">
							Bendera Lawan
						</a>
					</li>
				<?php } ?>
			<?php } ?>
			
				<!-- commented by SKM17
				<?php if (is_has_access('violation_type', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/violation_type_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/violation_type_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/pelanggaran.png">
							Pelanggaran
						</a>
					</li>
				<?php } ?>
				-->
				
				<!-- Pembina, Daftar Operasi, esatuan moved by SKM17 from Lain-Lain -->
				
				<!-- commented by SKM17
				<?php if (is_has_access('generic_marker_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/generic_marker_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/generic_marker_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/info.png">
							Peta-peta
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('cctv_location_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/cctv_location_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/cctv_location_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/video.png">
							Lokasi CCTV
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('force_component_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/force_component_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/force_component_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/pos.png">
							Komponen Kekuatan Musuh
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('marines_kolak_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/marines_kolak_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/marines_kolak_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/komando.png">
							Komando Pelaksana
						</a>
					</li>
				<?php } ?>
				-->
			<?php if (is_has_access('user', $permission) || is_has_access('*', $permission)) { ?>
				<li class="sub-category">
					<a href="#">
						<span>Administrasi</span>
						<img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" />
					</a>
				</li>
				<?php if (is_has_access('users_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/users_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/users_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/user.png">
							Pengguna
						</a>
					</li>
				<?php } ?>
				<?php if (is_has_access('role_ctrl', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/role_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/role_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/roles.png">
							Role
						</a>
					</li>
				<?php } ?>

				<?php if (is_has_access('setting', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/setting_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/setting_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/sett.png">
							Pengaturan
						</a>
					</li>
				<?php } ?>
				<!-- //runningtext -->
				<?php if (is_has_access('setting', $permission) || is_has_access('*', $permission)) { ?>
					<li>
						<a href="<?php echo base_url() . 'admin/runningtext_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/runningtext_ctrl') echo 'class="current"' ?>>
							<img src="<?php echo base_url() ?>assets/html/img/icon-menu/text.png">
							Teks Berjalan
						</a>
					</li>
				<?php } ?>
			<?php } ?>

<!-- 			
			<?php if (is_has_access('*', $permission) || $idAccessMsg != '') { ?>
				<li class="sub-category">
					<a href="#"><span>Pesan</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a>
				</li>
				<li>
					<a id="tulisPesan" href="<?php echo base_url() . 'admin/message_ctrl' ?>" <?php if (isset($current_context) && $current_context == '/admin/message_ctrl') echo 'class="current"' ?>>
						<img src="<?php echo base_url() ?>assets/html/img/icon-menu/roles.png">
						Tulis Pesan	</a>
				</li>
				<li>
					<a id="pesan" href="<?php echo base_url() . 'admin/message_ctrl2' ?>" <?php if (isset($current_context) && $current_context == '/admin/message_ctrl2') echo 'class="current"' ?>>
						<img src="<?php echo base_url() ?>assets/html/img/icon-menu/roles.png">
						Pesan    </a>
				</li>
				<li>
					<a id="pesanMasuk" href="<?php echo base_url() . 'admin/message_ctrl/inbox' ?>" <?php if (isset($current_context) && $current_context == '/admin/message_ctrl/inbox') echo 'class="current"' ?>>
						<img src="<?php echo base_url() ?>assets/html/img/icon-menu/roles.png">
						Pesan Masuk
					</a>
				</li>
				<li>
					<a id="pesanKeluar" href="<?php echo base_url() . 'admin/message_ctrl/outbox' ?>" <?php if (isset($current_context) && $current_context == '/admin/message_ctrl/outbox') echo 'class="current"' ?>>
						<img src="<?php echo base_url() ?>assets/html/img/icon-menu/roles.png">
						Pesan Keluar
					</a>
				</li>
			<?php } ?>
			 -->
			<!-- commented by SKM17
			<?php if (is_has_access('misc', $permission) || is_has_access('*', $permission)) { ?>
				<li class="sub-category">
					<a href="#"><span>Lain-lain</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a>
				</li>
			<?php } ?>
			-->
		</ul>

		<div id="content">
			<div id="title-up">
				<?php if (isset($title)) echo $title ?> <a href="<?php echo base_url() . 'home/logout' ?>" class="red">Keluar</a> <a class="blue" href="<?php echo base_url() ?>html/map_clean">Peta</a>
			</div>

			<div class="clear"></div>
			<br />
