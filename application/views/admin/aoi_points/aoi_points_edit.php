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
			window.location = '<?php echo base_url()?>admin/aoi_points_ctrl'
		});
	});
</script>



<div class="span12 block">			
	<div class="block_head">
		<div class="bheadl"></div>
		<div class="bheadr"></div>					
		<h2>aoi_points Data Editor</h2>
	</div>		<!-- .block_head ends -->		
	<?php if(strlen(validation_errors())>0){?>
		<div class="message errormsg" style="display: block; ">
			<p>There still error in form entry, please fix it</p>
		</div>
	<?php }?>
	<div class="block_content">
				<form action="<?php echo base_url()?>admin/aoi_points_ctrl/save" method="post">
					<p>
						<label>aoi_id * </label><br/>
						<input name="aoi_id" type="text"
						value="<?php if(!empty($obj)) echo $obj->aoi_id; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('aoi_id');?>					</p>
<p>
						<label>point_reg * </label><br/>
						<input name="point_reg" type="text"
						value="<?php if(!empty($obj)) echo $obj->point_reg; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('point_reg');?>					</p>
<p>
						<label>point_lat * </label><br/>
						<input name="point_lat" type="text"
						value="<?php if(!empty($obj)) echo $obj->point_lat; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('point_lat');?>					</p>
<p>
						<label>point_long * </label><br/>
						<input name="point_long" type="text"
						value="<?php if(!empty($obj)) echo $obj->point_long; ?>" <?php if(!empty($obj)) echo 'readonly'?>>
						<?php echo form_error('point_long');?>					</p>

					<p>
						<input id="saveBtn" type="submit" class="submit small" value="<?php if(empty($obj)) echo 'Save'; else echo 'Edit' ;?> ">
						<input id="cancelBtn" type="reset" class="submit small" value="Cancel">
					</p>

				</form>					
	</div>		<!-- .block_content ends -->				
	<div class="bendl"></div>
	<div class="bendr"></div>					
</div>