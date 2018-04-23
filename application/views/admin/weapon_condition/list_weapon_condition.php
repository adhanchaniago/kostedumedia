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
			window.location = '<?php echo base_url()?>admin/weapon_condition_ctrl'
		});
	});
</script>
<?php }?>
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">weapon_condition</a></h2>

<div id="main">
    <h3>List weapon_condition</h3>
	<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
													<th class="header">No</th>						<th class="header" style="cursor: pointer ;">ship_id</th>
						<th class="header" style="cursor: pointer ;">weap_id</th>
						<th class="header" style="cursor: pointer ;">wstat_id</th>
						<th class="header" style="cursor: pointer ;">ammo_count</th>
							<th class="header delete">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count = 1;
						if(!empty($weapon_condition)){
							foreach($weapon_condition as $row) {?>
								<tr class="<?php echo alternator("","odd"); ?>">
									<td><?php echo $count++;?></td>
																<td><?php echo $row->ship_id;?></td>
							<td><?php echo $row->weap_id;?></td>
							<td><?php echo $row->wstat_id;?></td>
							<td><?php echo $row->ammo_count;?></td>
							<td class="action"> <a href="<?php echo base_url();?>admin/weapon_condition_ctrl/edit/" class="edit">Edit</a> 
					<a href="<?php echo base_url();?>admin/weapon_condition_ctrl/delete/" class="delete">Delete</a></td>

								</tr>
					<?php 		}
						}?>

				</tbody>
	</table>	
	<h3>weapon_condition Data</h3>
	<form action="<?php echo base_url()?>admin/weapon_condition_ctrl/save" method="post" class="jNice">
		<fieldset>
			<p>
						<label>ship_id * </label>
						<input name="ship_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->ship_id; ?>" >
						<?php echo form_error('ship_id');?>					</p>
<p>
						<label>weap_id * </label>
						<input name="weap_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->weap_id; ?>" >
						<?php echo form_error('weap_id');?>					</p>
<p>
						<label>wstat_id * </label>
						<input name="wstat_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->wstat_id; ?>" >
						<?php echo form_error('wstat_id');?>					</p>
<p>
						<label>ammo_count * </label>
						<input name="ammo_count" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->ammo_count; ?>" >
						<?php echo form_error('ammo_count');?>					</p>

			<p>
				<input type="submit" value="<?php if(empty($obj)) echo 'Save'; else echo 'Edit' ;?> ">
				<input type="reset" value="Cancel">
			</p>
		</fieldset>
	</form>
</div>
<div class="clear"></div>
