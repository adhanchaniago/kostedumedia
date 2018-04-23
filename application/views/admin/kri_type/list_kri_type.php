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
			window.location = '<?php echo base_url()?>admin/kri_type_ctrl'
		});
	});
</script>
<?php }?>
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">kri_type</a></h2>

<div id="main">
    <h3>List kri_type</h3>
	<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
													<th class="header">No</th>						<th class="header" style="cursor: pointer ;">kritype_id</th>
						<th class="header" style="cursor: pointer ;">kritype_name</th>
							<th class="header delete">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count = 1;
						if(!empty($kri_type)){
							foreach($kri_type as $row) {?>
								<tr class="<?php echo alternator("","odd"); ?>">
									<td><?php echo $count++;?></td>
																<td><?php echo $row->kritype_id;?></td>
							<td><?php echo $row->kritype_name;?></td>
							<td class="action"> <a href="<?php echo base_url();?>admin/kri_type_ctrl/edit/<?php echo $row->kritype_id?>" class="edit">Edit</a> 
					<a href="<?php echo base_url();?>admin/kri_type_ctrl/delete/<?php echo $row->kritype_id?>" class="delete">Delete</a></td>

								</tr>
					<?php 		}
						}?>

				</tbody>
	</table>	
	<h3>kri_type Data</h3>
	<form action="<?php echo base_url()?>admin/kri_type_ctrl/save" method="post" class="jNice">
		<fieldset>
			<p>
						<label>kritype_id * </label>
						<input name="kritype_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->kritype_id; ?>" >
						<?php echo form_error('kritype_id');?>					</p>
<p>
						<label>kritype_name * </label>
						<input name="kritype_name" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->kritype_name; ?>" >
						<?php echo form_error('kritype_name');?>					</p>

			<p>
				<input type="submit" value="<?php if(empty($obj)) echo 'Save'; else echo 'Edit' ;?> ">
				<input type="reset" value="Cancel">
			</p>
		</fieldset>
	</form>
</div>
<div class="clear"></div>
