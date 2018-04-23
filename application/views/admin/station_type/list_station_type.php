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
        $("#addStationType").validate({
            rules:{
                stype_id: "required",
                stype_name: "required"
            },
            messages:{
                stype_id: "required",
                stype_name: "required"
            }
        });
        
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Jenis Pangkalan"></div>')
            .html('Hapus jenis pangkalan? <div class="clear"></class>').dialog({
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
        window.location = "<?php echo base_url() ?>admin/station_type_ctrl" + tail;
    }
</script>

<div id="main">

    <div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
    
    <p class="tit-form">Daftar Jenis Pangkalan</p>
    <table class="tab-admin" cellpadding="0" cellspacing="0">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;">No</th>
                <td class="header" style="cursor: pointer ;">Jenis Pangkalan</th>
                <td class="header" style="cursor: pointer ;">Ikon</th>
                <td class="header delete" style="width: 52px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($station_type)) {
                foreach ($station_type as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->stype_name; ?></td>
                        <td><img src="<?php if ($row->stype_icon != null || $row->stype_icon != '') echo base_url() . 'assets/img/icon-station/' . $row->stype_icon ?>" /></td>
                        <td class="action"> 
                            <?php if (is_has_access('station_type-edit', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/station_type_ctrl/edit/<?php echo $row->stype_id . '#form-pos' ?>" ><div class="tab-edit"></div></a> 
                            <?php }?>
                            <?php if (is_has_access('station_type-delete', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/station_type_ctrl/delete/<?php echo $row->stype_id ?>" class="delete-tab"><div class="tab-delete"></div></a>
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
    <?php if (is_has_access('station_type-edit', $permission) || is_has_access('*', $permission)) { ?>
    <p id="form-pos" class="tit-form">Entri Data Jenis Pangkalan</p>
    <form action="<?php echo base_url() ?>admin/station_type_ctrl/save" method="post" id="addStationType" enctype="multipart/form-data">
        <ul class="form-admin">
            <li>
                <?php if (!empty($obj)) { ?>
                    <input class="form-admin" type="hidden" name="stype_id" value="<?php echo $obj->stype_id ?>" />
                <?php } ?>
                <label>Nama * </label>
                <input class="form-admin" name="stype_name" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->stype_name; ?>" />
                       <?php echo form_error('stype_name'); ?>		
                <div class="clear"></div>
			</li>
            <?php if (!empty($obj)) { ?>
                <li>
                    <label>&nbsp;</label>
                    <?php if ($obj->stype_icon != null || $obj->stype_icon != '') { ?>
                        <img src="<?php echo base_url() ?>assets/img/icon-station/<?php echo $obj->stype_icon ?>" />
                    <?php } else { ?>
                        <span style="font-weight:bold;">Ikon tidak ada</span>
                    <?php } ?>
                    <div class="clear"></div>
				</li>
            <?php } ?>
           	<li>
                <label>Ikon </label>
                <input type="file" name="stype_icon" />
                <?php if (!empty($obj) && ($obj->stype_icon != null || $obj->stype_icon != '')) { ?>
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
