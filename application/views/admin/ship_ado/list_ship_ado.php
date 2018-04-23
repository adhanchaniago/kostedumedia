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
			window.location = '<?php echo base_url()?>admin/ship_ado_ctrl'
		});
	});
</script>
<?php }?>
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">ship_ado</a></h2>

<div id="main">
    <h3>List ship_ado</h3>
	<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
													<th class="header">No</th>						<th class="header" style="cursor: pointer ;">ship_id</th>
						<th class="header" style="cursor: pointer ;">ado_seq</th>
						<th class="header" style="cursor: pointer ;">ado_report</th>
						<th class="header" style="cursor: pointer ;">ado_time</th>
							<th class="header delete">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count = 1;
						if(!empty($ship_ado)){
							foreach($ship_ado as $row) {?>
								<tr class="<?php echo alternator("","odd"); ?>">
									<td><?php echo $count++;?></td>
																<td><?php echo $row->ship_id;?></td>
							<td><?php echo $row->ado_seq;?></td>
							<td><?php echo $row->ado_report;?></td>
							<td><?php echo $row->ado_time;?></td>
							<td class="action"> <a href="<?php echo base_url();?>admin/ship_ado_ctrl/edit/<?php echo $row->ship_id?>/<?php echo $row->ado_seq?>" class="edit">Edit</a> 
					<a href="<?php echo base_url();?>admin/ship_ado_ctrl/delete/<?php echo $row->ship_id?>/<?php echo $row->ado_seq?>" class="delete">Delete</a></td>

								</tr>
					<?php 		}
						}?>

				</tbody>
	</table>	
	<h3>ship_ado Data</h3>
	<form action="<?php echo base_url()?>admin/ship_ado_ctrl/save" method="post" class="jNice">
		<fieldset>
			<p>
						<label>ship_id * </label>
						<input name="ship_id" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->ship_id; ?>" >
						<?php echo form_error('ship_id');?>					</p>
<p>
						<label>ado_seq * </label>
						<input name="ado_seq" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->ado_seq; ?>" >
						<?php echo form_error('ado_seq');?>					</p>
<p>
						<label>ado_report * </label>
						<input name="ado_report" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->ado_report; ?>" >
						<?php echo form_error('ado_report');?>					</p>
<p>
						<label>ado_time * </label>
						<input name="ado_time" type="text" class="text-medium"
						value="<?php if(!empty($obj)) echo $obj->ado_time; ?>" >
						<?php echo form_error('ado_time');?>					</p>

			<p>
				<input type="submit" value="<?php if(empty($obj)) echo 'Save'; else echo 'Edit' ;?> ">
				<input type="reset" value="Cancel">
			</p>
		</fieldset>
	</form>
</div>
<div class="clear"></div>
