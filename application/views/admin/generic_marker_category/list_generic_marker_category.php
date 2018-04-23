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
			window.location = '<?php echo base_url()?>admin/generic_marker_category_ctrl'
		});
	});
</script>
<?php }?>
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">generic_marker_category</a></h2>

<div id="main">
    <h3>List generic_marker_category</h3>
	<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
													<th class="header">No</th>						<th class="header" style="cursor: pointer ;">gmarkcat_id</th>
						<th class="header" style="cursor: pointer ;">gmarkcat_name</th>
						<th class="header" style="cursor: pointer ;">gmarkcat_icon</th>
							<th class="header delete">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count = 1;
						if(!empty($generic_marker_category)){
							foreach($generic_marker_category as $row) {?>
								<tr class="<?php echo alternator("","odd"); ?>">
									<td><?php echo $count++;?></td>
																<td><?php echo $row->gmarkcat_id;?></td>
							<td><?php echo $row->gmarkcat_name;?></td>
							<td><?php echo $row->gmarkcat_icon;?></td>
							<td class="action"> <a href="<?php echo base_url();?>admin/generic_marker_category_ctrl/edit/<?php echo $row->gmarkcat_id?>" class="edit">Edit</a> 
					<a href="<?php echo base_url();?>admin/generic_marker_category_ctrl/delete/<?php echo $row->gmarkcat_id?>" class="delete">Delete</a></td>

								</tr>
					<?php 		}
						}?>

				</tbody>
	</table>	
	<h3>generic_marker_category Data</h3>
	<form action="<?php echo base_url()?>admin/generic_marker_category_ctrl/save" method="post" class="jNice">
		<fieldset>
			<p>
						<label>gmarkcat_id * </label>
						<input name="gmarkcat_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->gmarkcat_id; ?>" >
						<?php echo form_error('gmarkcat_id');?>					</p>
<p>
						<label>gmarkcat_name * </label>
						<input name="gmarkcat_name" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->gmarkcat_name; ?>" >
						<?php echo form_error('gmarkcat_name');?>					</p>
<p>
						<label>gmarkcat_icon * </label>
						<input name="gmarkcat_icon" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->gmarkcat_icon; ?>" >
						<?php echo form_error('gmarkcat_icon');?>					</p>

			<p>
				<input type="submit" value="<?php if(empty($obj)) echo 'Save'; else echo 'Edit' ;?> ">
				<input type="reset" value="Cancel">
			</p>
		</fieldset>
	</form>
</div>
<div class="clear"></div>
