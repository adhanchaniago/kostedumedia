
  <script>
  
	$(document).ready(function(){
	  <?php if ($this->session->flashdata('info')) { ?>
	  $('.success').html("<strong><?php echo $this->session->flashdata('info'); ?>");
	  $('.success').attr('style','');
	  $('.success').delay(10000).fadeOut('slow');
   
<?php } ?>

//box dialog
$("#form_groundstation").validate({
            rules:{
               	gs_place: "required",
                gs_ip	: "required"/*,
                gs_desc	: "required"*/
            },
            messages:{
                gs_place: "required",
                gs_ip	: "required"/*,
                gs_desc	: "required"*/
            }
        });

$('.delete-tab').click(function(){
			var page = $(this).attr("href");
			var $dialog = $('<div title="Hapus Data GS"></div>')
			.html('Semua terkait Data GS akan ikut dihapus! Hapus data GS? <div class="clear"></div>').dialog({
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

  function isNumberKey(evt)
	{
		var charCode = (evt.which) ? evt.which : evt.keyCode
		if (!((charCode >= 48 && charCode <= 57) || (charCode == 46) || (charCode == 8) || (charCode == 9)))
			return false;

		return true;
	}
	function create_url(){
		var url = $('#form_search_filter').attr('action')+'/?filter=true&';
		var param = '';
		$('.filter_param').each(function(){
			param += $(this).attr('name')+'='+$(this).val()+'&';
		});
		
		$('#form_search_filter').attr('action',url+param).submit();
	}

	
	function redirect(tail){
		window.location = "<?php echo base_url() ?>admin/gs_ctrl" + tail;
	}
  </script>



<div id="spotting-holder" style="display: none;"></div>
<div id="backlight" style="display: none;"></div>

<div id="main">
	<div class="clear " id="notif-holder"></div>
	<p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data GS berhasil disimpan.</p>
	
	<p class="tit-form">Daftar GS <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
	<div class="filtering" style="display: none;">
		<form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
			<ul class="filter-form">
				<li>
					<label>Lokasi GS</label><br />
					<input type="text" placeholder="Lokasi GS" name="gs_place" class='filter_param' value="<?php echo $this->input->get('gs_place'); ?>" onkeypress="search_enter_press(event);" />
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
				<td class="header" style="width: 20px;">No</th>                     
				<td class="header">Nama GS</td>                
				<td class="header">IP GS</td>
				<td class="header">Lintang</td>
				<td class="header">Bujur</td>
				<td class="header">Frekuensi</td>
				<td class="header">Deskripsi GS</td>                
				<td class="header">Status Koneksi</td>
				<td class="header delete" style="width: 60px;">Aksi</td>
			</tr>
		</thead>
		<tbody>
			<?php
				$count=1;
				if(!empty($gs)){
					foreach($gs as $row) {?>
						<tr class="<?php echo alternator("row-two", "row-one"); ?>">
							<td><?php echo ($count++) + $offset;?></td>
							<td><?php echo $row->gs_place;?></td>                            
							<td><?php echo $row->gs_ip;?></td>
							<td><?php echo geoComponent($row->gs_lat, 'a', 'lat'); ?></td>
							<td><?php echo geoComponent($row->gs_lon, 'a', 'lon'); ?></td>
							<td><?php echo $row->gs_frec;?></td>
							<td><?php echo $row->gs_desc;?></td>
							<td>
								<?php 
									if ($row->connection_status == 't') echo 'Terhubung';
									else if ($row->connection_status == 'f') echo 'Koneksi putus';
								?>
							</td>
							<td class="action">
								<?php if (is_has_access('gs_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
									<a href="<?php echo base_url(); ?>admin/gs_ctrl/edit/<?php echo $row->gs_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-edit"></div></a> 
								<?php } ?>
								<?php if (is_has_access('gs_ctrl-delete', $permission) || is_has_access('*', $permission)) { ?>
									<a href="<?php echo base_url(); ?>admin/gs_ctrl/delete/<?php echo $row->gs_id . '?' . http_build_query($_GET) ?>" class="delete-tab"><div class="tab-delete"></div></a>
								<?php } ?>
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

	<p id="form-pos" class="tit-form">Entri Data GS</p>
	<form action="<?php echo base_url() ?>admin/gs_ctrl/save" method="post" id="form_groundstation" enctype="multipart/form-data">
		<?php if (!empty($obj)) { ?>
			<input type="hidden" name="gs_id" value="<?php if (!empty($obj)) echo $obj->gs_id; ?>" />
		<?php } ?>
		<ul class="form-admin">             
			<li>
				<label>Lokasi GS:</label>
				<input name="gs_place" type="text" class="form-admin"
					   value="<?php if (!empty($obj)) echo $obj->gs_place; ?>" >
				<div class="clear"></div>
			</li>  

			<li>
				<label>IP GS:</label>
				<input name="gs_ip" type="text" class="form-admin"
					   value="<?php if (!empty($obj)) echo $obj->gs_ip; ?>" >
				<div class="clear"></div>
			</li>            
			
			<li>
				<label>Lintang </label>
				<input class="form-admin two-digit" name="gs_dlat" maxlength="3"  maxlength="3" type="text" class="text-medium" 
						value="<?php if (!empty($obj)) echo geoComponent($obj->gs_lat, 'd'); ?>"onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
				<input class="form-admin two-digit" name="gs_mlat" maxlength="2"  type="text" class="text-medium" 
						value="<?php if (!empty($obj)) echo geoComponent($obj->gs_lat, 'm'); ?>"onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
				<input class="form-admin two-digit" name="gs_slat" maxlength="2"  type="text" class="text-medium" 
					   value="<?php if (!empty($obj)) echo geoComponent($obj->gs_lat, 's'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

				<?php
				$stat = 'class="form-admin" style="width: 47px;"';
				
				if (!empty($obj))
					echo form_dropdown('gs_rlat', array(1 => 'U', -1 => 'S'), geoComponent($obj->gs_lat, 'r'), $stat);
				else
					echo form_dropdown('gs_rlat', array(1 => 'U', -1 => 'S'), '', $stat);
				?>

				<?php echo form_error('gs_lat'); ?>
				<div class="clear"></div>
			</li>

		   <li>
				<label>Bujur </label>
				<input class="form-admin two-digit" name="gs_dlon" maxlength="3" type="text" class="text-medium" 
						value="<?php if (!empty($obj)) echo geoComponent($obj->gs_lon, 'd'); ?>"onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
				<input class="form-admin two-digit" name="gs_mlon" maxlength="2" type="text" class="text-medium" 
					   value="<?php if (!empty($obj)) echo geoComponent($obj->gs_lon, 'm'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
				<input class="form-admin two-digit" name="gs_slon" maxlength="2" type="text" class="text-medium" 
						value="<?php if (!empty($obj)) echo geoComponent($obj->gs_lon, 's'); ?>"onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

				<?php
				$stat = 'class="form-admin" style="width: 47px;"';
				
				if (!empty($obj))
					echo form_dropdown('gs_rlon', array(1 => 'T', -1 => 'B'), geoComponent($obj->gs_lon, 'r'), $stat);
				else
					echo form_dropdown('gs_rlon', array(1 => 'T', -1 => 'B'), '', $stat);
				?>

				<?php echo form_error('gs_lon'); ?>
				<div class="clear"></div>
			</li> 

			<li>
				<label>Frekuensi GS:</label>
				<input name="gs_frec" type="text" class="form-admin"
					   value="<?php if (!empty($obj)) echo $obj->gs_frec; ?>" >
				<div class="clear"></div>
			</li>       

			<li>
				<label>Deskripsi GS:</label>
				<textarea rows="1" cols="1" name="gs_desc" class="form-admin"><?php if (!empty($obj)) echo $obj->gs_desc; ?></textarea>
				<div class="clear"></div>
			</li>

			<li>                
				<p class="tit-form"></p>
				<label>&nbsp;</label>
				<input class="button-form" type="submit" value="Simpan">
				<input class="button-form" type="reset" onclick="redirect('')" value="Batal">
				<input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>               
			</li>
		</ul>
	</form>
</div>
<div class="clear"></div>
