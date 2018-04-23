<script>
	$(document).ready(function() 
	{
<?php if ($this->session->flashdata('info')) { ?>
		$('.success').html("<strong> <?php echo $this->session->flashdata('info'); ?>");
		$('.success').attr('style','');
		$('.success').delay(10000).fadeOut('slow');
<?php } ?>

		$('.delete-tab').click(function(){
			var page = $(this).attr("href");
			var $dialog = $('<div title="Hapus Pesan Masuk"></div>')
			.html('Pesan yang dihapus tidak dapat dikembalikan lagi. Hapus pesan masuk? <div class="clear"></div>').dialog({
				autoOpen: false,
				width: 280,
				show: "fade",
				hide: "fade",
				modal: true,
				resizable: false,
				buttons: {
					"Ok": function() {
						$(this).dialog("close");
						window.location = page;
					},
					"Cancel": function() {
						$(this).dialog("close");
					}
				}
			});
			$dialog.dialog('open');
			return false;
		});
	});

	function redirect(tail) {
		window.location = "<?php echo base_url() ?>admin/message_ctrl/inbox" + tail;
	}
	
	function create_url(){
		var url = $('#form_search_filter').attr('action')+'/?filter=true&';
		var param = '';
		$('.filter_param').each(function(){
			param += $(this).attr('name')+'='+$(this).val()+'&';
		});
		//param = param.substr(0,-1);
		$('#form_search_filter').attr('action',url+param).submit();
	}
</script>
<!-- Added by D3 - Disable enter -->
<script type="text/javascript"> 
function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = stopRKey; 
</script> 
<div id="main">

	<div class="clear " id="notif-holder"></div>
	<p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
	
	<p class="tit-form">Daftar Pesan Masuk<a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
	<div class="filtering" style="display: none;">
		<form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
			<ul class="filter-form">
				<li>
					<label>ID Pengirim</label><br />
					<input type="text" name="id_from" class='filter_param' value="<?php echo $this->input->get('operation_name'); ?>" />
				</li>
			</ul>
			<div class="clear"></div>
			<div style="border-bottom: 1px dotted #DDD; margin: 15px 0 17px 0;"></div>
			<input type="button" value="Bersihkan Pencarian" onclick="redirect('')" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
			<input type="button" value="Cari" name="search_filter" onclick="create_url()" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />

			<div class="clear"></div>
			<div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
		</form>
	</div>
	
	<table class="tab-admin">
	  <thead>
		  <tr class="tittab">
			  <td class="header">No</td>
			  <td class="header" style="cursor: pointer ;">Nomor Lambung</td>
			  <td class="header" style="cursor: pointer ;">Nama Kapal</td>
			  <td class="header delete" style="width: 55px;">Lihat</td>
		  </tr>
	  </thead>
	  <tbody>
<?php
	$count = 1;
	if (!empty($ships)) {
		foreach ($ships as $row) {
?>
			<tr class="<?php echo alternator("row-one", "row-two"); ?>">
				<td><?php echo ($count++)+$offset;?></td>
				<td><?php echo $row->ship_id; ?></td>
				<td><?php echo $row->ship_name; ?></td>
				<td class="action tdcenter">
					<a href="<?php echo base_url(); ?>admin/message_ctrl2/view_msg/<?php echo $row->ship_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-view"></a>
				</td>
			</tr>
<?php
		}
	}
?>
	  </tbody>
	</table>   
	<br />
	<div class="pagination">
			<?php echo $pagination?>
		</div>
	<br />
<?php if (isset($messages)) { ?>
	<p id="form-pos" class="tit-form"><?php echo 'KRI ' . $ship_id; ?></p>
	<div class="msg-content">
	<?php
		foreach ($messages as $row) {
			if ($row->id_to == $ship_id) {
				echo '<ul class="left-msg">';
			} else if ($row->id_from == $ship_id) {
				echo '<ul class="right-msg">';
			}
			echo $row->msg . '<br \>';
			echo '<div class="small">' . $row->waktu . '</div>';
			echo '</ul>';
		}
	?>
	</div>
<?php } ?>
</div>
