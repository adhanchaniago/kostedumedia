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
        $("#addAeroplaneIcon").validate({
            rules:{
                aericon_id: "required",
                aericon_desc: "required"
            },
            messages:{
                aericon_id: "required",
                aericon_desc: "required"
            }
        });
        
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Jenis Pesawat"></div>')
            .html('Semua terkait Jenis Pesawat akan ikut dihapus! Hapus data jenis pesawat? <div class="clear"></class>').dialog({
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
    function redirect(tail){
        window.location = "<?php echo base_url() ?>admin/aeroplane_icon_ctrl" + tail;
    }
</script>

<div id="main">

    <div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
    
    <p class="tit-form">Daftar Jenis Pesawat</p>
    <table class="tab-admin" cellpadding="0" cellspacing="0">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;">No</th>
                <td class="header" style="cursor: pointer ;">Jenis Pesawat</th>
                <td class="header" style="cursor: pointer ;">Ikon</th>
                <td class="header delete" style="width: 52px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($aeroplane_icon)) {
                foreach ($aeroplane_icon as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->aericon_desc; ?></td>
                        <td><img src="<?php if ($row->aericon_file != null || $row->aericon_file != '') echo base_url() . 'assets/img/icon-aeroplane/' . $row->aericon_file ?>" /></td>
                        <td class="action"> 
                            <?php if (is_has_access('aeroplane_icon_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/aeroplane_icon_ctrl/edit/<?php echo $row->aericon_id . '#form-pos' ?>" ><div class="tab-edit"></div></a> 
                            <?php }?>
                            <?php if (is_has_access('aeroplane_icon_ctrl-delete', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/aeroplane_icon_ctrl/delete/<?php echo $row->aericon_id ?>" class="delete-tab"><div class="tab-delete"></div></a>
                            <?php }?>
                        </td>

                    </tr>
                    <?php
                }
            }
            ?>

        </tbody>
    </table>

    <br />
    <?php if (is_has_access('aeroplane_icon_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
    <p id="form-pos" class="tit-form">Entri Data Jenis Pesawat</p>
    <form action="<?php echo base_url() ?>admin/aeroplane_icon_ctrl/save" method="post" id="addAeroplaneIcon" enctype="multipart/form-data">
        <ul class="form-admin">
            <li>
                <?php if (!empty($obj)) { ?>
                    <input class="form-admin" type="hidden" name="aericon_id" value="<?php echo $obj->aericon_id ?>" />
                <?php } ?>
                <label>Deskripsi * </label>
                <input class="form-admin" name="aericon_desc" type="text" class="text-medium" maxlength="70"
                       value="<?php if (!empty($obj)) echo $obj->aericon_desc; ?>" />
                       <?php echo form_error('aericon_desc'); ?>		
                <div class="clear"></div>
			</li>
            <?php if (!empty($obj)) { ?>
                <li>
                    <label>&nbsp;</label>
                    <?php if ($obj->aericon_file != null || $obj->aericon_file != '') { ?>
                        <img src="<?php echo base_url() ?>assets/img/icon-aeroplane/<?php echo $obj->aericon_file ?>" />
                    <?php } else { ?>
                        <span style="font-weight:bold;">Ikon tidak ada</span>
                    <?php } ?>
                    <div class="clear"></div>
				</li>
            <?php } ?>
           	<li>
                <label>Ikon </label>
                <input type="file" name="aericon_file" />
                <?php if (!empty($obj) && ($obj->aericon_file != null || $obj->aericon_file != '')) { ?>
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
