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
			window.location = '<?php echo base_url()?>admin/fvehicle_ops_ctrl'
		});
	});
</script>
<?php }?>
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">fvehicle_ops</a></h2>

<div id="main">
    <h3>List fvehicle_ops</h3>
	<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
													<th class="header">No</th>						<th class="header" style="cursor: pointer ;">operation_id</th>
						<th class="header" style="cursor: pointer ;">fv_id</th>
						<th class="header" style="cursor: pointer ;">fvo_add_timestamp</th>
							<th class="header delete">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count = 1;
						if(!empty($fvehicle_ops)){
							foreach($fvehicle_ops as $row) {?>
								<tr class="<?php echo alternator("","odd"); ?>">
									<td><?php echo $count++;?></td>
																<td><?php echo $row->operation_id;?></td>
							<td><?php echo $row->fv_id;?></td>
							<td><?php echo $row->fvo_add_timestamp;?></td>
							<td class="action"> <a href="<?php echo base_url();?>admin/fvehicle_ops_ctrl/edit/<?php echo $row->operation_id?>/<?php echo $row->fv_id?>" class="edit">Edit</a> 
					<a href="<?php echo base_url();?>admin/fvehicle_ops_ctrl/delete/<?php echo $row->operation_id?>/<?php echo $row->fv_id?>" class="delete">Delete</a></td>

								</tr>
					<?php 		}
						}?>

				</tbody>
	</table>	
	<h3>fvehicle_ops Data</h3>
	<form action="<?php echo base_url()?>admin/fvehicle_ops_ctrl/save" method="post" class="jNice">
		<fieldset>
			<p>
						<label>operation_id * </label>
						<input name="operation_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->operation_id; ?>" >
						<?php echo form_error('operation_id');?>					</p>
<p>
						<label>fv_id * </label>
						<input name="fv_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->fv_id; ?>" >
						<?php echo form_error('fv_id');?>					</p>
<p>
						<label>fvo_add_timestamp * </label>
						<input name="fvo_add_timestamp" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->fvo_add_timestamp; ?>" >
						<?php echo form_error('fvo_add_timestamp');?>					</p>

			<p>
				<input type="submit" value="<?php if(empty($obj)) echo 'Save'; else echo 'Edit' ;?> ">
				<input type="reset" value="Cancel">
			</p>
		</fieldset>
	</form>
</div>
<div class="clear"></div>
