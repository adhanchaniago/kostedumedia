<?php if(!empty($saving)){?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.success').fadeOut(5000,function(){
			$(this).remove();
		});
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
			window.location = '<?php echo base_url()?>admin/defined_area_point_ctrl'
		});
	});
</script>
<?php }?>
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">defined_area_point</a></h2>

<div id="main">
    <h3>List defined_area_point</h3>
	<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
													<th class="header">No</th>						<th class="header" style="cursor: pointer ;">da_id</th>
						<th class="header" style="cursor: pointer ;">depoint_inc</th>
						<th class="header" style="cursor: pointer ;">depoint_lat</th>
						<th class="header" style="cursor: pointer ;">depoint_lon</th>
							<th class="header delete">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count = 1;
						if(!empty($defined_area_point)){
							foreach($defined_area_point as $row) {?>
								<tr class="<?php echo alternator("","odd"); ?>">
									<td><?php echo $count++;?></td>
																<td><?php echo $row->da_id;?></td>
							<td><?php echo $row->depoint_inc;?></td>
							<td><?php echo $row->depoint_lat;?></td>
							<td><?php echo $row->depoint_lon;?></td>
							<td class="action"> <a href="<?php echo base_url();?>admin/defined_area_point_ctrl/edit/<?php echo $row->da_id?>/<?php echo $row->depoint_inc?>" class="edit">Edit</a> 
					<a href="<?php echo base_url();?>admin/defined_area_point_ctrl/delete/<?php echo $row->da_id?>/<?php echo $row->depoint_inc?>" class="delete">Delete</a></td>

								</tr>
					<?php 		}
						}?>

				</tbody>
	</table>	
	<h3>defined_area_point Data</h3>
	<form action="<?php echo base_url()?>admin/defined_area_point_ctrl/save" method="post" class="jNice">
		<fieldset>
			<p>
						<label>da_id * </label>
						<input name="da_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->da_id; ?>" >
						<?php echo form_error('da_id');?>					</p>
<p>
						<label>depoint_inc * </label>
						<input name="depoint_inc" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->depoint_inc; ?>" >
						<?php echo form_error('depoint_inc');?>					</p>
<p>
						<label>depoint_lat * </label>
						<input name="depoint_lat" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->depoint_lat; ?>" >
						<?php echo form_error('depoint_lat');?>					</p>
<p>
						<label>depoint_lon * </label>
						<input name="depoint_lon" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->depoint_lon; ?>" >
						<?php echo form_error('depoint_lon');?>					</p>

			<p>
				<input type="submit" value="<?php if(empty($obj)) echo 'Save'; else echo 'Edit' ;?> ">
				<input type="reset" value="Cancel">
			</p>
		</fieldset>
	</form>
</div>
<div class="clear"></div>
