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
			window.location = '<?php echo base_url()?>admin/aoi_ctrl'
		});
	});
</script>



<div class="span12 block">			
	<div class="block_head">
		<div class="bheadl"></div>
		<div class="bheadr"></div>					
		<h2>aoi Data Editor</h2>
	</div>		<!-- .block_head ends -->		
	<?php if(strlen(validation_errors())>0){?>
		<div class="message errormsg" style="display: block; ">
			<p>There still error in form entry, please fix it</p>
		</div>
	<?php }?>
	<div class="block_content">
				<form action="<?php echo base_url()?>admin/aoi_ctrl/save" method="post">
					<p>
						<label>aoi_id * </label><br/>
						<input name="aoi_id" type="text"
						value="<?php if(!empty($obj)) echo $obj->aoi_id; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('aoi_id');?>					</p>
<p>
						<label>operation_id * </label><br/>
						<input name="operation_id" type="text"
						value="<?php if(!empty($obj)) echo $obj->operation_id; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('operation_id');?>					</p>
<p>
						<label>aoi_name * </label><br/>
						<input name="aoi_name" type="text"
						value="<?php if(!empty($obj)) echo $obj->aoi_name; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('aoi_name');?>					</p>
<p>
						<label>aoi_icon * </label><br/>
						<input name="aoi_icon" type="text"
						value="<?php if(!empty($obj)) echo $obj->aoi_icon; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('aoi_icon');?>					</p>
<p>
						<label>aoi_description * </label><br/>
						<input name="aoi_description" type="text"
						value="<?php if(!empty($obj)) echo $obj->aoi_description; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('aoi_description');?>					</p>

					<p>
						<input id="saveBtn" type="submit" class="submit small" value="<?php if(empty($obj)) echo 'Save'; else echo 'Edit' ;?> ">
						<input id="cancelBtn" type="reset" class="submit small" value="Cancel">
					</p>

				</form>					
	</div>		<!-- .block_content ends -->				
	<div class="bendl"></div>
	<div class="bendr"></div>					
</div>