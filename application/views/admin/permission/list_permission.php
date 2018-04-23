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
			window.location = '<?php echo base_url()?>admin/permission_ctrl'
		});
	});
</script>
<?php }?>
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">permission</a></h2>

<div id="main">
    <h3>List permission</h3>
	<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
													<th class="header">No</th>						<th class="header" style="cursor: pointer ;">feature_id</th>
						<th class="header" style="cursor: pointer ;">role_id</th>
						<th class="header" style="cursor: pointer ;">access</th>
						<th class="header" style="cursor: pointer ;">update</th>
						<th class="header" style="cursor: pointer ;">delete</th>
							<th class="header delete">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count = 1;
						if(!empty($permission)){
							foreach($permission as $row) {?>
								<tr class="<?php echo alternator("","odd"); ?>">
									<td><?php echo $count++;?></td>
																<td><?php echo $row->feature_id;?></td>
							<td><?php echo $row->role_id;?></td>
							<td><?php echo $row->access;?></td>
							<td><?php echo $row->update;?></td>
							<td><?php echo $row->delete;?></td>
							<td class="action"> <a href="<?php echo base_url();?>admin/permission_ctrl/edit/<?php echo $row->feature_id?>" class="edit">Edit</a> 
					<a href="<?php echo base_url();?>admin/permission_ctrl/delete/<?php echo $row->feature_id?>" class="delete">Delete</a></td>

								</tr>
					<?php 		}
						}?>

				</tbody>
	</table>	
	<h3>permission Data</h3>
	<form action="<?php echo base_url()?>admin/permission_ctrl/save" method="post" class="jNice">
		<fieldset>
			<p>
						<label>feature_id * </label>
						<input name="feature_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->feature_id; ?>" >
						<?php echo form_error('feature_id');?>					</p>
<p>
						<label>role_id * </label>
						<input name="role_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->role_id; ?>" >
						<?php echo form_error('role_id');?>					</p>
<p>
						<label>access * </label>
						<input name="access" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->access; ?>" >
						<?php echo form_error('access');?>					</p>
<p>
						<label>update * </label>
						<input name="update" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->update; ?>" >
						<?php echo form_error('update');?>					</p>
<p>
						<label>delete * </label>
						<input name="delete" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->delete; ?>" >
						<?php echo form_error('delete');?>					</p>

			<p>
				<input type="submit" value="<?php if(empty($obj)) echo 'Save'; else echo 'Edit' ;?> ">
				<input type="reset" value="Cancel">
			</p>
		</fieldset>
	</form>
</div>
<div class="clear"></div>
