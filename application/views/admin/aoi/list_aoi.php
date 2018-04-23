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
			window.location = '<?php echo base_url()?>admin/aoi_ctrl'
		});
	});
</script>
<?php }?>
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">aoi</a></h2>

<div id="main">
    <h3>List aoi</h3>
	<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
													<th class="header">No</th>						<th class="header" style="cursor: pointer ;">aoi_id</th>
						<th class="header" style="cursor: pointer ;">operation_id</th>
						<th class="header" style="cursor: pointer ;">aoi_name</th>
						<th class="header" style="cursor: pointer ;">aoi_icon</th>
						<th class="header" style="cursor: pointer ;">aoi_description</th>
							<th class="header delete">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count = 1;
						if(!empty($aoi)){
							foreach($aoi as $row) {?>
								<tr class="<?php echo alternator("","odd"); ?>">
									<td><?php echo $count++;?></td>
																<td><?php echo $row->aoi_id;?></td>
							<td><?php echo $row->operation_id;?></td>
							<td><?php echo $row->aoi_name;?></td>
							<td><?php echo $row->aoi_icon;?></td>
							<td><?php echo $row->aoi_description;?></td>
							<td class="action"> <a href="<?php echo base_url();?>admin/aoi_ctrl/edit/<?php echo $row->aoi_id?>" class="edit">Edit</a> 
					<a href="<?php echo base_url();?>admin/aoi_ctrl/delete/<?php echo $row->aoi_id?>" class="delete">Delete</a></td>

								</tr>
					<?php 		}
						}?>

				</tbody>
	</table>	
	<h3>aoi Data</h3>
	<form action="<?php echo base_url()?>admin/aoi_ctrl/save" method="post" class="jNice">
		<fieldset>
			<p>
						<label>aoi_id * </label>
						<input name="aoi_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->aoi_id; ?>" >
						<?php echo form_error('aoi_id');?>					</p>
<p>
						<label>operation_id * </label>
						<input name="operation_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->operation_id; ?>" >
						<?php echo form_error('operation_id');?>					</p>
<p>
						<label>aoi_name * </label>
						<input name="aoi_name" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->aoi_name; ?>" >
						<?php echo form_error('aoi_name');?>					</p>
<p>
						<label>aoi_icon * </label>
						<input name="aoi_icon" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->aoi_icon; ?>" >
						<?php echo form_error('aoi_icon');?>					</p>
<p>
						<label>aoi_description * </label>
						<input name="aoi_description" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->aoi_description; ?>" >
						<?php echo form_error('aoi_description');?>					</p>

			<p>
				<input type="submit" value="<?php if(empty($obj)) echo 'Save'; else echo 'Edit' ;?> ">
				<input type="reset" value="Cancel">
			</p>
		</fieldset>
	</form>
</div>
<div class="clear"></div>
