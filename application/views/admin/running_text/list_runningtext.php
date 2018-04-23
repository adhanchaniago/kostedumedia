<?php if ($this->session->flashdata('info')) { ?>
	<script>
		$(document).ready(function(){
			$('.success').html("<strong><?php echo $this->session->flashdata('info'); ?>");
			$('.success').attr('style','');
			$('.success').delay(10000).fadeOut('slow');
		});
	</script>
<?php } ?>

<div id="main">
	<div class="clear " id="notif-holder"></div>
	<p class="notif success " style="display:none"></p>
	<br />

<!--
<?php if (is_has_access('setting-edit', $permission) || is_has_access('*', $permission)) { ?>
 -->

	<p id="form-pos" class="tit-form">Entri Teks Berjalan</p>
	<form action="<?php echo base_url() ?>admin/runningtext_ctrl/save" method="post" id="addRunningText">
		<ul class="form-admin">
			
			<?php
				$dayNames = array(					    
				    0=>'Senin', 
				    1=>'Selasa', 
				    2=>'Rabu', 
				    3=>'Kamis', 
				    4=>'Jumat', 
				    5=>'Sabtu', 
				    6=>'Minggu'
				 );

				$day_of_week = date('N', strtotime(date("l")));
			?>

			<!-- date time -->
			<li>
				<label>Hari, tanggal dan jam</label>				
				<input type="text" name="hari" value=" <?php echo $dayNames[$day_of_week-1]; ?>">				
				<input type="datetime" name="tanggalwaktu" value="<?php echo date('d-m-Y H:i:s'); ?>"/>				
				<div class="clear"></div>
			</li>

			<!-- status text berjalan -->
			<li>
				<label>Status teks berjalan</label>
				<div class="form-admin-radio">
					<label>
						<input type="radio" name="status" value="on" checked> Nyala
					</label><br />
					<label>  					
  						<input type="radio" name="status" value="off"> Mati			
					</label><br />
				</div>
				<div class="clear"></div>
			</li>


            <!-- isi teks_berjalan -->
            <li>
                <label>Isi teks berjalan</label>
                <input class="form-admin" name="teks_berjalan" type="text" class="text-medium"
                      maxlength="250" value="<?php echo $runningtexts[0]->status_desc; ?>">
					
                <div class="clear"></div>
            </li>
			<li>
				<p class="tit-form"></p>
				<label>&nbsp;</label>
				<input class="button-form" type="submit" value="Simpan">
			</li>
		</ul>

 	</form>
<!--
<?php }?>
 -->

</div>
<div class="clear"></div>
