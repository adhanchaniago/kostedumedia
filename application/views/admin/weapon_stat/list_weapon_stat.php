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
			window.location = '<?php echo base_url()?>admin/weapon_stat_ctrl'
		});
	});
</script>
<?php }?>
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">weapon_stat</a></h2>

<div id="main">
    <h3>List weapon_stat</h3>
	<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
													<th class="header">No</th>						<th class="header" style="cursor: pointer ;">wstat_id</th>
						<th class="header" style="cursor: pointer ;">wstat_desc</th>
							<th class="header delete">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count = 1;
						if(!empty($weapon_stat)){
							foreach($weapon_stat as $row) {?>
								<tr class="<?php echo alternator("","odd"); ?>">
									<td><?php echo $count++;?></td>
																<td><?php echo $row->wstat_id;?></td>
							<td><?php echo $row->wstat_desc;?></td>
							<td class="action"> <a href="<?php echo base_url();?>admin/weapon_stat_ctrl/edit/<?php echo $row->wstat_id?>" class="edit">Edit</a> 
					<a href="<?php echo base_url();?>admin/weapon_stat_ctrl/delete/<?php echo $row->wstat_id?>" class="delete">Delete</a></td>

								</tr>
					<?php 		}
						}?>

				</tbody>
	</table>	
	<h3>weapon_stat Data</h3>
	<form action="<?php echo base_url()?>admin/weapon_stat_ctrl/save" method="post" class="jNice">
		<fieldset>
			<p>
						<label>wstat_id * </label>
						<input name="wstat_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->wstat_id; ?>" >
						<?php echo form_error('wstat_id');?>					</p>
<p>
						<label>wstat_desc * </label>
						<input name="wstat_desc" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->wstat_desc; ?>" >
						<?php echo form_error('wstat_desc');?>					</p>

			<p>
				<input type="submit" value="<?php if(empty($obj)) echo 'Save'; else echo 'Edit' ;?> ">
				<input type="reset" value="Cancel">
			</p>
		</fieldset>
	</form>
</div>
<div class="clear"></div>
