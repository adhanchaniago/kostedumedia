<?php if ($this->session->flashdata('info')) { ?>
    <script>
        $(document).ready(function(){
			$('.success').html('<strong>Penyimpanan data berhasil.<strong> <?php echo $this->session->flashdata('info'); ?>');
			$('.success').attr('style','');
			$('.success').delay(10000).fadeOut('slow');
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#shipTypeAdd").validate({
            rules:{
                shiptype_id: "required",
                shiptype_desc: "required" // added by SKM17
            },
            messages:{
                shiptype_id: "required",
                shiptype_desc: "required" // added by SKM17
            }
        });
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Jenis Kapal"></div>')
            .html('Hapus jenis kapal? <div class="clear"></class>').dialog({
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
    function redirect(tail){
        window.location = "<?php echo base_url() ?>admin/ship_type_ctrl" + tail;
    }
</script>

<div id="main">

    <div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
    
    <p class="tit-form">Daftar Jenis Kapal</p>
    <table class="tab-admin" cellpadding="0" cellspacing="0">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;">No</th>						
                <td class="header" style="cursor: pointer ;">ID</th>
                <td class="header" style="cursor: pointer ;">Deskripsi</th>
                <td class="header" style="cursor: pointer ;">Ikon</th>
                <td class="header delete" style="width: 52px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($ship_type)) {
                foreach ($ship_type as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                        <td><?php echo ($count++)+$offset; ?></td>
                        <td><?php echo $row->shiptype_id; ?></td>
                        <td><?php echo $row->shiptype_desc; ?></td>
                        <td><img src="<?php if ($row->shiptype_icon != null || $row->shiptype_icon != '') echo base_url() . 'assets/img/icon-ship/not-realtime/blue/blue-' . $row->shiptype_icon ?>" /></td>
                        <td class="action">
                            <?php if (is_has_access('ship_type-edit', $permission) || is_has_access('*', $permission)) { ?>
                                <a href="<?php echo base_url(); ?>admin/ship_type_ctrl/edit/<?php echo $row->shiptype_id . '#form-pos' ?>" ><div class="tab-edit"></div></a> 
                            <?php } ?>
                            <?php if (is_has_access('ship_type-delete', $permission) || is_has_access('*', $permission)) { ?>
                                <a href="<?php echo base_url(); ?>admin/ship_type_ctrl/delete/<?php echo $row->shiptype_id ?>" class="delete-tab"><div class="tab-delete"></div></a>
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
    <?php if (is_has_access('ship_type-edit', $permission) || is_has_access('*', $permission)) { ?>
        <p id="form-pos" class="tit-form">Entri Data Tipe Kapal</p>
        <form action="<?php echo base_url() ?>admin/ship_type_ctrl/save" method="post" class="jNice" id="shipTypeAdd" enctype="multipart/form-data">
            <ul class="form-admin">
                <li>
                    <label>Kode * </label>
				    <?php if (!empty($obj)) { ?>
				        <input class="form-admin" type="hidden" name="shiptype_id" value="<?php if (!empty($obj)) echo $obj->shiptype_id; ?>" />
				    <?php } ?>
                    <input class="form-admin" name="shiptype_id" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->shiptype_id; ?>" maxlength="20"
                           <?php if (isset($obj)) echo 'disabled'; ?>>
                    <?php echo form_error('shiptype_id'); ?>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Deskripsi * </label>
                    <textarea class="form-admin"  name="shiptype_desc" rows="1" cols="1" maxlength="255"><?php if (!empty($obj)) echo $obj->shiptype_desc; ?></textarea>
                    <div class="clear"></div>
                </li>
                <!-- commented by SKM17
                <?php if (!empty($obj)) { ?>
                    <li>
                        <label></label>
                        <?php if ($obj->shiptype_icon != null || $obj->shiptype_icon != '') { ?>
                            <img src="<?php echo base_url() ?>assets/img/icon-ship/<?php echo $obj->shiptype_icon ?>" />
                        <?php } else { ?>
                            <span style="font-weight:bold;">Ikon tidak ada</span>
                        <?php } ?>
                        <div class="clear"></div>
                    </li>
                <?php } ?>
                <li>
                    <label>Ikon</label>
                    <input type="file" name="shiptype_icon" />
                    <?php if (!empty($obj) && ($obj->shiptype_icon != null || $obj->shiptype_icon != '')) { ?>
                        <p style="margin-left:210px;color:red;">*Abaikan apabila Ikon tidak akan diubah</p>
                    <?php } ?>
                    <p style="margin-left:210px;color:red;">*Tipe File Ikon yang diperbolehkan : .gif atau. png atau .jpg</p>
                    <p style="margin-left:210px;color:red;">*Maksimum File Ikon adalah 1 MB (Megabtye) 100x100 px</p>
                    <div class="clear"></div>
                </li>
                -->
                <li>
                    <label>&nbsp;</label>
                    <input class="button-form" type="submit" value="Simpan ">
			        <input class="button-form" type="reset" onclick="redirect('')" value="Batal">
			        <input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
                </li>
            </ul>
        </form>
    <?php } ?>
</div>
<div class="clear"></div>
