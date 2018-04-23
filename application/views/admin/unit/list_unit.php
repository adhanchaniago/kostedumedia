<?php if ($this->session->flashdata('info')) { ?>
    <script>
        $(document).ready(function(){
			$('.success').html("<strong> <?php echo $this->session->flashdata('info'); ?>");
			$('.success').attr('style','');
			$('.success').delay(10000).fadeOut('slow');
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#addUnit").validate({
            rules:{
                unit_id: "required",
                unit_name: "required",
                unitcat_id: "required"
            },
            messages:{
                unit_id: "required",
                unit_name: "required",
                unitcat_id: "required"
            }
        });
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Kesatuan"></div>')
            .html('Semua terkait Kesatuan akan ikut dihapus! Hapus data kesatuan? <div class="clear"></div>').dialog({
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
        if(!((charCode>=48&&charCode<=57)|| (charCode==46) || (charCode==8) || (charCode==9)))
            return false;

        return true;
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
    function redirect(tail){
        window.location = "<?php echo base_url() ?>admin/unit_ctrl" + tail;
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
<div id="spotting-holder" style="display: none;"></div>
<div id="backlight" style="display: none;"></div>
<!--<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">defined_area</a></h2>-->

<div id="main">

    <div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
    
    <p class="tit-form">Daftar Kesatuan<a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
<div class="filtering" style="display: none;">
    <form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
        <ul class="filter-form">
            <li>
                <label>Nama Kesatuan</label><br />
                <input type="text" placeholder="Nama Kesatuan" name="unit_name" class='filter_param' value="<?php echo $this->input->get('unit_name'); ?>" />
            </li>
            <li>
                <label>Kategori</label><br />
                <select name="unitcat_id" class="filter_param">
					<option value="" selected >-Pilih Kategori-</option>
					<?php foreach($unit_category as $uc){ ?>
						<option value="<?php echo $uc->unitcat_id?>" <?php echo (($this->input->get('unitcat_id')) && $this->input->get('unitcat_id') == $uc->unitcat_id)?'selected':''?> ><?php echo $uc->unitcat_name?></option>
					<?php } ?>
				</select>
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
                <td style="width: 20px;">No</th>
                <td>Nama Kesatuan</td>
                <td>Kategori</td>
                <td style="width: 52px;" class="delete">Aksi</td>
            </tr>
        </thead>
		<tbody>
			<?php
				$count = 1;
				if(!empty($unit)){
					foreach($unit as $row) {?>
						<tr class="<?php echo alternator("row-two", "row-one"); ?>">
							<td><?php echo ($count++)+$offset;?></td>
							<td><?php echo $row->unit_name;?></td>
							<td><?php echo $row->unitcat_name;?></td>
							<td class="action">
								<?php if (is_has_access('unit_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
								<a href="<?php echo base_url();?>admin/unit_ctrl/edit/<?php echo $row->unit_id . '?' . http_build_query($_GET) . '#form-pos' ?>"><div class="tab-edit"></div></a> 
								<?php }?>
								<?php if (is_has_access('unit_ctrl-delete', $permission) || is_has_access('*', $permission)) { ?>
								<a href="<?php echo base_url();?>admin/unit_ctrl/delete/<?php echo $row->unit_id?>" class="delete-tab"><div class="tab-delete"></div></a>
								<?php }?>
							</td>
						</tr>
			<?php 		}
				}?>

		</tbody>
	</table>
	<br />
		<div class="pagination">
			<?php echo $pagination?>
		</div>
    <br />	
<?php if (is_has_access('unit_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
	<p id="form-pos" class="tit-form">Entri Data Kesatuan</p>
	<form action="<?php echo base_url() ?>admin/unit_ctrl/save" method="post" class="jNice" id="addUnit">
        <?php if (!empty($obj)) { ?>
            <input type="hidden" name="unit_id" value="<?php if (!empty($obj)) echo $obj->unit_id; ?>" />
        <?php } ?>
        <ul class="form-admin">
            <li>
                <label>Nama Kesatuan *</label>
                <input name="unit_name" type="text" class="form-admin"
                       value="<?php if (!empty($obj)) echo $obj->unit_name; ?>" >
                <div class="clear"></div>
            </li>
            <li>
                <label>Kategori *</label>
                <select name="unitcat_id" class="form-admin">
					<option value="" selected >-Pilih Kategori-</option>
					<?php foreach($unit_category as $uc){ ?>
						<option value="<?php echo $uc->unitcat_id?>" <?php echo (!empty($obj) && $obj->unitcat_id == $uc->unitcat_id)?'selected':''?> ><?php echo $uc->unitcat_name?></option>
					<?php } ?>
				</select>
                <div class="clear"></div>
            </li>
            <li>
                <p class="tit-form"></p>
                <label>&nbsp;</label>
                <input type="submit" class="button-form" value="Simpan">
                <input type="reset" class="button-form" value="Batal" onclick="redirect('')">
		        <input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
            </li>
        </ul>
    </form>
</div>
<div class="clear"></div>
<?php } ?>
