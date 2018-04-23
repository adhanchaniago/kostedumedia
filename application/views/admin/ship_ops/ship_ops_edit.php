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
			window.location = '<?php echo base_url()?>admin/ship_ops_ctrl'
		});
	});
</script>



<div class="span12 block">			
	<div class="block_head">
		<div class="bheadl"></div>
		<div class="bheadr"></div>					
		<h2>ship_ops Data Editor</h2>
	</div>		<!-- .block_head ends -->		
	<?php if(strlen(validation_errors())>0){?>
		<div class="message errormsg" style="display: block; ">
			<p>There still error in form entry, please fix it</p>
		</div>
	<?php }?>
	<div class="block_content">
				<form action="<?php echo base_url()?>admin/ship_ops_ctrl/save" method="post">
					<p>
						<label>operation_id * </label><br/>
						<input name="operation_id" type="text"
						value="<?php if(!empty($obj)) echo $obj->operation_id; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('operation_id');?>					</p>
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
						<label>hull_number * </label><br/>
						<input name="hull_number" type="text"
						value="<?php if(!empty($obj)) echo $obj->hull_number; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('hull_number');?>					</p>
<p>
						<label>ops_stat_id * </label><br/>
						<input name="ops_stat_id" type="text"
						value="<?php if(!empty($obj)) echo $obj->ops_stat_id; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('ops_stat_id');?>					</p>
<p>
						<label>program_turn_hour * </label><br/>
						<input name="program_turn_hour" type="text"
						value="<?php if(!empty($obj)) echo $obj->program_turn_hour; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('program_turn_hour');?>					</p>
<p>
						<label>current_turn_hour * </label><br/>
						<input name="current_turn_hour" type="text"
						value="<?php if(!empty($obj)) echo $obj->current_turn_hour; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('current_turn_hour');?>					</p>

					<p>
						<input id="saveBtn" type="submit" class="submit small" value="<?php if(empty($obj)) echo 'Save'; else echo 'Edit' ;?> ">
						<input id="cancelBtn" type="reset" class="submit small" value="Cancel">
					</p>

				</form>					
	</div>		<!-- .block_content ends -->				
	<div class="bendl"></div>
	<div class="bendr"></div>					
</div>