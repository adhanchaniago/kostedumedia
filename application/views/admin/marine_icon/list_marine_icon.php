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
        $("#addMarineIcon").validate({
            rules:{
                maricon_id: "required",
                maricon_desc: "required"
            },
            messages:{
                maricon_id: "required",
                maricon_desc: "required"
            }
        });
        
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Jenis Satuan Marinir"></div>')
            .html('Semua terkait Jenis Satuan Marinir akan ikut dihapus! Hapus data jenis satuan marinir? <div class="clear"></class>').dialog({
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
        window.location = "<?php echo base_url() ?>admin/marine_icon_ctrl" + tail;
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
    
    <p class="tit-form">Daftar Jenis Satuan Marinir <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
	<div class="filtering" style="display: none;">
		<form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
		    <ul class="filter-form">
		        <li>
		            <label>Jenis Marinir</label><br />
		            <input type="text" placeholder="Nama" name="maricon_desc" class='filter_param' value="<?php echo $this->input->get('operation_name'); ?>" />
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

    <table class="tab-admin" cellpadding="0" cellspacing="0">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;">No</th>
                <td class="header" style="cursor: pointer ;">Jenis Satuan Marinir</th>
                <td class="header" style="cursor: pointer ;">Ikon</th>
                <td class="header delete" style="width: 52px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($marine_icon)) {
                foreach ($marine_icon as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                        <td><?php echo ($count++)+$offset; ?></td>
                        <td><?php echo $row->maricon_desc; ?></td>
                        <td><img src="<?php if ($row->maricon_file != null || $row->maricon_file != '') echo base_url() . 'assets/img/icon-marine/' . $row->maricon_file ?>" /></td>
                        <td class="action"> 
                            <?php if (is_has_access('marine_icon_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/marine_icon_ctrl/edit/<?php echo $row->maricon_id . '?' . http_build_query($_GET) . '#form-pos' ?>" ><div class="tab-edit"></div></a> 
                            <?php }?>
                            <?php if (is_has_access('marine_icon_ctrl-delete', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/marine_icon_ctrl/delete/<?php echo $row->maricon_id . '?' . http_build_query($_GET) ?>" class="delete-tab"><div class="tab-delete"></div></a>
                            <?php }?>
                        </td>

                    </tr>
                    <?php
                }
            }
            ?>

        </tbody>
    </table>

<div class="pagination">
	<?php echo $pagination?>
</div>

    <br />
    <?php if (is_has_access('marine_icon_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
    <p id="form-pos" class="tit-form">Entri Data Jenis Satuan Marinir</p>
    <form action="<?php echo base_url() ?>admin/marine_icon_ctrl/save" method="post" id="addMarineIcon" enctype="multipart/form-data">
        <ul class="form-admin">
            <li>
                <?php if (!empty($obj)) { ?>
                    <input class="form-admin" type="hidden" name="maricon_id" value="<?php echo $obj->maricon_id ?>" />
                <?php } ?>
                <label>Deskripsi * </label>
                <input class="form-admin" name="maricon_desc" type="text" class="text-medium" maxlength="40"
                       value="<?php if (!empty($obj)) echo $obj->maricon_desc; ?>" />
                       <?php echo form_error('maricon_desc'); ?>		
                <div class="clear"></div>
			</li>
            <?php if (!empty($obj)) { ?>
                <li>
                    <label>&nbsp;</label>
                    <?php if ($obj->maricon_file != null || $obj->maricon_file != '') { ?>
                        <img src="<?php echo base_url() ?>assets/img/icon-marine/<?php echo $obj->maricon_file ?>" />
                    <?php } else { ?>
                        <span style="font-weight:bold;">Ikon tidak ada</span>
                    <?php } ?>
                    <div class="clear"></div>
				</li>
            <?php } ?>
           	<li>
                <label>Ikon </label>
                <input type="file" name="maricon_file" />
                <?php if (!empty($obj) && ($obj->maricon_file != null || $obj->maricon_file != '')) { ?>
                    <p style="margin-left:210px;color:red;">*Abaikan apabila Ikon tidak akan diubah</p>
                <?php } ?>
                <p style="margin-left:210px;color:red;">*Tipe File Ikon yang diperbolehkan : .gif atau. png atau .jpg</p>
                <p style="margin-left:210px;color:red;">*Maksimum File Ikon adalah 1 MB (Megabtye) 100x100 px </p>
                <div class="clear"></div>
            </li>

            <li>
                <label>&nbsp;</label>
                <input class="button-form" type="submit" value="Simpan">
                <input class="button-form" type="reset" value="Batal" onclick="redirect('')" >
                <input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
            </li>
        </ul>
    </form>
    <?php }?>
</div>
<div class="clear"></div>
