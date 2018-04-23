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
			window.location = '<?php echo base_url()?>admin/poi_ctrl'
		});
	});
</script>



<div class="span12 block">			
	<div class="block_head">
		<div class="bheadl"></div>
		<div class="bheadr"></div>					
		<h2>poi Data Editor</h2>
	</div>		<!-- .block_head ends -->		
	<?php if(strlen(validation_errors())>0){?>
		<div class="message errormsg" style="display: block; ">
			<p>There still error in form entry, please fix it</p>
		</div>
	<?php }?>
	<div class="block_content">
				<form action="<?php echo base_url()?>admin/poi_ctrl/save" method="post">
					<p>
						<label>poi_id * </label><br/>
						<input name="poi_id" type="text"
						value="<?php if(!empty($obj)) echo $obj->poi_id; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('poi_id');?>					</p>
<p>
						<label>operation_id * </label><br/>
						<input name="operation_id" type="text"
						value="<?php if(!empty($obj)) echo $obj->operation_id; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('operation_id');?>					</p>
<p>
						<label>poi_name * </label><br/>
						<input name="poi_name" type="text"
						value="<?php if(!empty($obj)) echo $obj->poi_name; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('poi_name');?>					</p>
<p>
						<label>poi_icon * </label><br/>
						<input name="poi_icon" type="text"
						value="<?php if(!empty($obj)) echo $obj->poi_icon; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('poi_icon');?>					</p>
<p>
						<label>poi_description * </label><br/>
						<input name="poi_description" type="text"
						value="<?php if(!empty($obj)) echo $obj->poi_description; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('poi_description');?>					</p>
<p>
						<label>poi_lat * </label><br/>
						<input name="poi_lat" type="text"
						value="<?php if(!empty($obj)) echo $obj->poi_lat; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('poi_lat');?>					</p>
<p>
						<label>poi_lon * </label><br/>
						<input name="poi_lon" type="text"
						value="<?php if(!empty($obj)) echo $obj->poi_lon; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('poi_lon');?>					</p>

					<p>
						<input id="saveBtn" type="submit" class="submit small" value="<?php if(empty($obj)) echo 'Save'; else echo 'Edit' ;?> ">
						<input id="cancelBtn" type="reset" class="submit small" value="Cancel">
					</p>

				</form>					
	</div>		<!-- .block_content ends -->				
	<div class="bendl"></div>
	<div class="bendr"></div>					
</div>