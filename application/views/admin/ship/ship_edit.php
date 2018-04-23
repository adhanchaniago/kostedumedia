<script type="text/javascript">
	$(document).ready(function(){
		$('#saveBtn').click(function (){
			var edit = $.trim($(this).prop('value')).toLowerCase();

			if( edit==='edit'){
				$(this).prop('value', 'Save');
				$('input[type=text]').prop('readonly',false);
				return false;
			}else{
				var form = $('input[type=submit]').closest("form");
				form.submit();
			}
		});

		$('#cancelBtn').click(function(){
			window.location = '<?php echo base_url()?>admin/ship_ctrl'
		});
	});
</script>



<div class="span12 block">			
	<div class="block_head">
		<div class="bheadl"></div>
		<div class="bheadr"></div>					
		<h2>ship Data Editor</h2>
	</div>		<!-- .block_head ends -->		
	<?php if(strlen(validation_errors())>0){?>
		<div class="message errormsg" style="display: block; ">
			<p>There still error in form entry, please fix it</p>
		</div>
	<?php }?>
	<div class="block_content">
				<form action="<?php echo base_url()?>admin/ship_ctrl/save" method="post">
					<p>
						<label>ship_stat_id * </label><br/>
						<input name="ship_stat_id" type="text"
						value="<?php if(!empty($obj)) echo $obj->ship_stat_id; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('ship_stat_id');?>					</p>
<p>
						<label>imo * </label><br/>
						<input name="imo" type="text"
						value="<?php if(!empty($obj)) echo $obj->imo; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('imo');?>					</p>
<p>
						<label>Nomor Lambung * </label><br/>
						<input name="hull_number" type="text"
						value="<?php if(!empty($obj)) echo $obj->hull_number; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('hull_number');?>					</p>
<p>
						<label>Nama Kapal * </label><br/>
						<input name="ship_name" type="text"
						value="<?php if(!empty($obj)) echo $obj->ship_name; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('ship_name');?>					</p>
<p>
						<label>Icon Kapal * </label><br/>
						<input name="ship_icon" type="text"
						value="<?php if(!empty($obj)) echo $obj->ship_icon; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('ship_icon');?>					</p>
<p>
						<label>Lintang * </label><br/>
						<input name="current_lat" type="text"
						value="<?php if(!empty($obj)) echo $obj->current_lat; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('current_lat');?>					</p>
<p>
						<label>Bujur * </label><br/>
						<input name="current_lon" type="text"
						value="<?php if(!empty($obj)) echo $obj->current_lon; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('current_lon');?>					</p>
<p>
						<label>Gambar Kapal * </label><br/>
						<input name="ship_image" type="text"
						value="<?php if(!empty($obj)) echo $obj->ship_image; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('ship_image');?>					</p>
<p>
						<label>Adalah KRI * </label><br/>
						<input name="is_kri" type="text"
						value="<?php if(!empty($obj)) echo $obj->is_kri; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('is_kri');?>					</p>
<p>
						<label>Kesatuan * </label><br/>
						<input name="corps_id" type="text"
						value="<?php if(!empty($obj)) echo $obj->corps_id; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('corps_id');?>					</p>
<p>
						<label>Tipe Kapal * </label><br/>
						<input name="id_ship_type" type="text"
						value="<?php if(!empty($obj)) echo $obj->id_ship_type; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('id_ship_type');?>					</p>
<p>
						<label>Rencana Jam Putar * </label><br/>
						<input name="prog_machine_hour" type="text"
						value="<?php if(!empty($obj)) echo $obj->prog_machine_hour; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('prog_machine_hour');?>					</p>
<p>
						<label>Jam putar saat ini * </label><br/>
						<input name="current_machine_hour" type="text"
						value="<?php if(!empty($obj)) echo $obj->current_machine_hour; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('current_machine_hour');?>					</p>
<p>
						<label>Transmisi terakhir * </label><br/>
						<input name="last_transmission" type="text"
						value="<?php if(!empty($obj)) echo $obj->last_transmission; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('last_transmission');?>					</p>

					<p>
						<input id="saveBtn" type="submit" class="submit small" value="<?php if(empty($obj)) echo 'Simpan'; else echo 'Perbaharui' ;?> ">
						<input id="cancelBtn" type="reset" class="submit small" value="Batalkan">
					</p>

				</form>					
	</div>		<!-- .block_content ends -->				
	<div class="bendl"></div>
	<div class="bendr"></div>					
</div>