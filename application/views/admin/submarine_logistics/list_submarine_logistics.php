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
			window.location = '<?php echo base_url()?>admin/submarine_logistics_ctrl'
		});
	});
</script>
<?php }?>
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">submarine_logistics</a></h2>

<div id="main">
    <h3>List submarine_logistics</h3>
	<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
													<th class="header">No</th>						<th class="header" style="cursor: pointer ;">logitem_id</th>
						<th class="header" style="cursor: pointer ;">sbm_id</th>
						<th class="header" style="cursor: pointer ;">sbmlog_value</th>
							<th class="header delete">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count = 1;
						if(!empty($submarine_logistics)){
							foreach($submarine_logistics as $row) {?>
								<tr class="<?php echo alternator("","odd"); ?>">
									<td><?php echo $count++;?></td>
																<td><?php echo $row->logitem_id;?></td>
							<td><?php echo $row->sbm_id;?></td>
							<td><?php echo $row->sbmlog_value;?></td>
							<td class="action"> <a href="<?php echo base_url();?>admin/submarine_logistics_ctrl/edit/<?php echo $row->logitem_id?>/<?php echo $row->sbm_id?>" class="edit">Edit</a> 
					<a href="<?php echo base_url();?>admin/submarine_logistics_ctrl/delete/<?php echo $row->logitem_id?>/<?php echo $row->sbm_id?>" class="delete">Delete</a></td>

								</tr>
					<?php 		}
						}?>

				</tbody>
	</table>	
	<h3>submarine_logistics Data</h3>
	<form action="<?php echo base_url()?>admin/submarine_logistics_ctrl/save" method="post" class="jNice">
		<fieldset>
			<p>
						<label>logitem_id * </label>
						<input name="logitem_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->logitem_id; ?>" >
						<?php echo form_error('logitem_id');?>					</p>
<p>
						<label>sbm_id * </label>
						<input name="sbm_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->sbm_id; ?>" >
						<?php echo form_error('sbm_id');?>					</p>
<p>
						<label>sbmlog_value * </label>
						<input name="sbmlog_value" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->sbmlog_value; ?>" >
						<?php echo form_error('sbmlog_value');?>					</p>

			<p>
				<input type="submit" value="<?php if(empty($obj)) echo 'Save'; else echo 'Edit' ;?> ">
				<input type="reset" value="Cancel">
			</p>
		</fieldset>
	</form>
</div>
<div class="clear"></div>
