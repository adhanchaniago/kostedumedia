<?php if ($this->session->flashdata('info')) { ?>
    <script>
        $(document).ready(function(){
			$('.success').html("<strong><?php echo $this->session->flashdata('info'); ?>");
			$('.success').attr('style','');
			$('.success').delay(10000).fadeOut('slow');
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#addEnemyForceFlag").validate({
            rules:{
                eforceflag_name: "required"
            },
            messages:{
                eforceflag_name: "required"
            }
        });
        
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Bendera Pangkalan Lawan"></div>')
            .html('Semua terkait Bendera Lawan akan ikut dihapus! Hapus data bendera lawan? <div class="clear"></class>').dialog({
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
        window.location = "<?php echo base_url() ?>admin/enemy_force_flag_ctrl" + tail;
    }
</script>

<div id="main">

    <div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
    
    <p class="tit-form">Daftar Bendera Pangkalan Lawan</p>
    <table class="tab-admin" cellpadding="0" cellspacing="0">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;">No</th>						
                <td class="header" style="cursor: pointer ;">Negara</th>			
                <td class="header" style="cursor: pointer ;">Bendera</th>
                <td class="header delete" style="width: 52px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($enemy_force_flag)) {
                foreach ($enemy_force_flag as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                        <td><?php echo ($count++) + $offset; ?></td>
                        <td><?php echo $row->eforceflag_name; ?></td>
                        <td><img src="<?php if ($row->eforceflag_icon != null || $row->eforceflag_icon != '') echo base_url() . 'assets/img/icon-enemy-force/' . $row->eforceflag_icon ?>" /></td>
                        <td class="action"> 
                            <?php if (is_has_access('enemy_force_flag-edit', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/enemy_force_flag_ctrl/edit/<?php echo $row->eforceflag_id . '#form-pos' ?>" ><div class="tab-edit"></div></a> 
                            <?php }?>
                            <?php if (is_has_access('enemy_force_flag-delete', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/enemy_force_flag_ctrl/delete/<?php echo $row->eforceflag_id ?>" class="delete-tab"><div class="tab-delete"></div></a>
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
    <?php if (is_has_access('enemy_force_flag-edit', $permission) || is_has_access('*', $permission)) { ?>
    <p id="form-pos" class="tit-form">Entri Data Bendera Pangkalan Lawan</p>
    <form action="<?php echo base_url() ?>admin/enemy_force_flag_ctrl/save" method="post" id="addEnemyForceFlag" enctype="multipart/form-data">
        <ul class="form-admin">
            <li>
                <?php if (!empty($obj)) { ?>
                    <input class="form-admin" type="hidden" name="eforceflag_id" value="<?php echo $obj->eforceflag_id ?>" />
                <?php } ?>
                <label>Negara * </label>
                <input class="form-admin" name="eforceflag_name" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->eforceflag_name; ?>" />
                       <?php echo form_error('eforceflag_name'); ?>		
                <div class="clear"></div>
			</li>
			<li>
                <?php if (!empty($obj)) { ?>
                    <label style="margin-left:110px;">
                        <?php if ($obj->eforceflag_icon != null || $obj->eforceflag_icon != '') { ?>
                            <img src="<?php echo base_url() ?>assets/img/icon-enemy-force/<?php echo $obj->eforceflag_icon ?>" />
                        <?php } else { ?>
                            <span style="font-weight:bold;">Ikon tidak ada</span>
                        <?php } ?>
                    </label>
                    <div class="clear"></div>
                <?php } ?>
                <label>Ikon </label>
                <input type="file" name="eforceflag_icon" />
                <?php if (!empty($obj) && ($obj->eforceflag_icon != null || $obj->eforceflag_icon != '')) { ?>
                    <p style="margin-left:210px;color:red;">*Abaikan apabila Ikon tidak akan diubah</p>
                <?php } ?>
                <p style="margin-left:210px;color:red;">*Tipe File Ikon yang diperbolehkan : .gif atau. png atau .jpg atau .jpeg</p>
                <p style="margin-left:210px;color:red;">*Maksimum File Ikon adalah 1 MB (Megabtye) 100x100 px </p>
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
    <?php }?>
</div>
<div class="clear"></div>
