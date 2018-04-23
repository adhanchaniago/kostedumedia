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
			window.location = '<?php echo base_url()?>admin/weapon_reff_ctrl'
		});
	});
</script>
<?php }?>
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">weapon_reff</a></h2>

<div id="main">
    <h3>List weapon_reff</h3>
	<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
													<th class="header">No</th>						<th class="header" style="cursor: pointer ;">weap_id</th>
						<th class="header" style="cursor: pointer ;">weap_name</th>
						<th class="header" style="cursor: pointer ;">weap_desc</th>
						<th class="header" style="cursor: pointer ;">weap_shoot_range</th>
							<th class="header delete">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count = 1;
						if(!empty($weapon_reff)){
							foreach($weapon_reff as $row) {?>
								<tr class="<?php echo alternator("","odd"); ?>">
									<td><?php echo $count++;?></td>
																<td><?php echo $row->weap_id;?></td>
							<td><?php echo $row->weap_name;?></td>
							<td><?php echo $row->weap_desc;?></td>
							<td><?php echo $row->weap_shoot_range;?></td>
							<td class="action"> <a href="<?php echo base_url();?>admin/weapon_reff_ctrl/edit/<?php echo $row->weap_id?>" class="edit">Edit</a> 
					<a href="<?php echo base_url();?>admin/weapon_reff_ctrl/delete/<?php echo $row->weap_id?>" class="delete">Delete</a></td>

								</tr>
					<?php 		}
						}?>

				</tbody>
	</table>	
	<h3>weapon_reff Data</h3>
	<form action="<?php echo base_url()?>admin/weapon_reff_ctrl/save" method="post" class="jNice">
		<fieldset>
			<p>
						<label>weap_id * </label>
						<input name="weap_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->weap_id; ?>" >
						<?php echo form_error('weap_id');?>					</p>
<p>
						<label>weap_name * </label>
						<input name="weap_name" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->weap_name; ?>" >
						<?php echo form_error('weap_name');?>					</p>
<p>
						<label>weap_desc * </label>
						<input name="weap_desc" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->weap_desc; ?>" >
						<?php echo form_error('weap_desc');?>					</p>
<p>
						<label>weap_shoot_range * </label>
						<input name="weap_shoot_range" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->weap_shoot_range; ?>" >
						<?php echo form_error('weap_shoot_range');?>					</p>

			<p>
				<input type="submit" value="<?php if(empty($obj)) echo 'Save'; else echo 'Edit' ;?> ">
				<input type="reset" value="Cancel">
			</p>
		</fieldset>
	</form>
</div>
<div class="clear"></div>
