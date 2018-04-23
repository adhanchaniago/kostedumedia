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
			window.location = '<?php echo base_url()?>admin/permission_ctrl'
		});
	});
</script>



<div class="span12 block">			
	<div class="block_head">
		<div class="bheadl"></div>
		<div class="bheadr"></div>					
		<h2>permission Data Editor</h2>
	</div>		<!-- .block_head ends -->		
	<?php if(strlen(validation_errors())>0){?>
		<div class="message errormsg" style="display: block; ">
			<p>There still error in form entry, please fix it</p>
		</div>
	<?php }?>
	<div class="block_content">
				<form action="<?php echo base_url()?>admin/permission_ctrl/save" method="post">
					<p>
						<label>feature_id * </label><br/>
						<input name="feature_id" type="text"
						value="<?php if(!empty($obj)) echo $obj->feature_id; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('feature_id');?>					</p>
<p>
						<label>role_id * </label><br/>
						<input name="role_id" type="text"
						value="<?php if(!empty($obj)) echo $obj->role_id; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('role_id');?>					</p>
<p>
						<label>access * </label><br/>
						<input name="access" type="text"
						value="<?php if(!empty($obj)) echo $obj->access; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('access');?>					</p>
<p>
						<label>update * </label><br/>
						<input name="update" type="text"
						value="<?php if(!empty($obj)) echo $obj->update; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('update');?>					</p>
<p>
						<label>delete * </label><br/>
						<input name="delete" type="text"
						value="<?php if(!empty($obj)) echo $obj->delete; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('delete');?>					</p>

					<p>
						<input id="saveBtn" type="submit" class="submit small" value="<?php if(empty($obj)) echo 'Save'; else echo 'Edit' ;?> ">
						<input id="cancelBtn" type="reset" class="submit small" value="Cancel">
					</p>

				</form>					
	</div>		<!-- .block_content ends -->				
	<div class="bendl"></div>
	<div class="bendr"></div>					
</div>