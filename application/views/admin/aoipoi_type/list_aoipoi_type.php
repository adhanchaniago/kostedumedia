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
        $("#addAeroplaneType").validate({
            //idv: { required: true, regex: "/^(\d{3})TN(\d{4})$/" },
            rules:{
                aptype_id: "required",
                aptype_name: "required"
            },
            messages:{
                aptype_id: "required",
                aptype_name: "required"
            }
        });
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Tipe AoiPoi"></div>')
            .html('Semua terkait Tipe AoiPoi akan ikut dihapus! Hapus tipe AoiPoi? <div class="clear"></class>').dialog({
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
        window.location = "<?php echo base_url() ?>admin/aoipoi_type_ctrl" + tail;
    }
</script>

<div id="main">
    
    <div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data AoiPoi Type .</p>

    <p class="tit-form">Daftar AoiPoi Type</p>
    <table class="tab-admin" cellpadding="0" cellspacing="0">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;">No</th>
                <td class="header" style="cursor: pointer ;">Nama</th>
                <td class="header delete" style="width: 52px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($aoipoi_type)) {
                foreach ($aoipoi_type as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->aptype_name; ?></td>
                        <td class="action"> 
                          <?php if (is_has_access('aoipoi_type_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
                                <a href="<?php echo base_url(); ?>admin/aoipoi_type_ctrl/edit/<?php echo $row->aptype_id . '#form-pos' ?>" ><div class="tab-edit"></div></a> 
                            <?php } ?>
                            <?php if (is_has_access('aoipoi_type_ctrl-delete', $permission) || is_has_access('*', $permission)) { ?>
                                <a href="<?php echo base_url(); ?>admin/aoipoi_type_ctrl/delete/<?php echo $row->aptype_id ?>" class="delete-tab"><div class="tab-delete"></div></a>
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
 <?php if (is_has_access('aoipoi_type_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
        <p id="form-pos" class="tit-form">Entri Data AoiPoi Type</p>
        <form action="<?php echo base_url() ?>admin/aoipoi_type_ctrl/save" method="post" id="addAeroplaneType" enctype="multipart/form-data">
            <ul class="form-admin">
                <?php if (!empty($obj)) { ?>
                    <input class="form-admin" type="hidden" name="aptype_id" value="<?php if (!empty($obj)) echo $obj->aptype_id; ?>" />
                <?php } ?>
                <li>
                    <label>Nama * </label>
                    <input class="form-admin" name="aptype_name" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->aptype_name; ?>" >
                    <?php echo form_error('aptype_name'); ?>
                    <div class="clear"></class>
                </li>
                <!-- commented by SKM17
                <?php if (!empty($obj)) { ?>
                    <li>
                        <label></label>
                        <?php if ($obj->aertype_icon != null || $obj->aertype_icon != '') { ?>
                            <img src="<?php echo base_url() ?>assets/img/icon-aeroplane/<?php echo $obj->aertype_icon ?>" />
                        <?php } else { ?>
                            <span style="font-weight:bold;">Gambar/Icon tidak ada</span>
                        <?php } ?>
                        <div class="clear"></div>
                    </li>
                <?php } ?>
                <li>
                    <label>Gambar/Icon</label>
                    <input type="file" name="aertype_icon" />
                    <?php if (!empty($obj) && ($obj->aertype_icon != null || $obj->aertype_icon != '')) { ?>
                        <p style="margin-left:210px;color:red;">*Abaikan apabila Gambar/Icon tidak akan diubah</p>
                    <?php } ?>
                    <p style="margin-left:210px;color:red;">*Tipe File Gambar/Icon yang diperbolehkan : .gif atau. png atau .jpg</p>
                    <p style="margin-left:210px;color:red;">*Maksimum File Gambar/Icon adalah 1 MB (Megabtye) 100x100 px</p>
                    <div class="clear"></div>
                </li>
                -->
                <li>
                    <label>&nbsp;</label>
                    <input class="button-form" type="submit" value="Simpan">
                    <input class="button-form" type="reset" onclick="redirect('')" value="Batal">
                    <input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
                </li>
            </ul>
        </form>
    <?php } ?>
</div>
<div class="clear"></div>