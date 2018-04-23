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
        $("#addShipStatus").validate({
            rules:{
                ship_stat_id: "required",
                ship_stat_desc: "required"
            },
            messages:{
                ship_stat_id: "required",
                ship_stat_desc: "required"
            }
        });
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Status Kapal"></div>')
            .html('Hapus status kapal?<div class="clear"></div>').dialog({
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
        window.location = "<?php echo base_url() ?>admin/ship_status_ctrl" + tail;
    }
</script>

<div id="main">

    <div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
    
    <p class="tit-form">Daftar Status Kapal</p>
    <table class="tab-admin">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;">No</td>						
                <!-- <td class="header" style="cursor: pointer ;">ID</td> -->
                <td class="header" style="cursor: pointer ;">Nama</td>
                <td class="header delete" style="width: 52px;">Aksi</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($ship_status)) {
                foreach ($ship_status as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                        <td><?php echo $count++; ?></td>
                        <!-- <td><?php echo $row->ship_stat_id; ?></td> -->
                        <td><?php echo $row->ship_stat_desc; ?></td>
                        <td class="action"> 
                            <?php if (is_has_access('ship_status-edit', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/ship_status_ctrl/edit/<?php echo $row->ship_stat_id . '#form-pos' ?>"><div class="tab-edit"></div></a> 
                            <?php }?>
                            <?php if (is_has_access('ship_status-delete', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/ship_status_ctrl/delete/<?php echo $row->ship_stat_id ?>" class="delete-tab"><div class="tab-delete"></div></a>
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
    <?php if (is_has_access('ship_status-edit', $permission) || is_has_access('*', $permission)) { ?>
    <p id="form-pos" class="tit-form">Entri Data Status Kapal</p>
    <form action="<?php echo base_url() ?>admin/ship_status_ctrl/save" method="post" id="addShipStatus">
        <?php if (!empty($obj)) { ?>
            <input class="form-admin" type="hidden" name="ship_stat_id" value="<?php if (!empty($obj)) echo $obj->ship_stat_id; ?>" />
        <?php } ?>
        <ul class="form-admin">
        	<!-- commented by SKM17
            <li>
                <label>ID (sembarang angka)* </label>
                <input class="form-admin" name="ship_stat_id" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->ship_stat_id; ?>" onkeypress="return isNumberKey(event)">
                       <?php echo form_error('ship_stat_id'); ?>						
                <div class="clear"></div>
            </li>
            -->
            <li>
                <label>Nama * </label>
                <input class="form-admin" name="ship_stat_desc" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->ship_stat_desc; ?>" maxlength="250" >
				<?php echo form_error('ship_stat_desc'); ?>						
                <div class="clear"></div>
            </li>
                            
            <li>
                <label>&nbsp;</label>
                <input class="button-form" type="submit" value="Simpan">
                <input class="button-form" type="reset" onclick="redirect('')" value="Batal">
                <input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
                <div class="clear"></div>
            </li>
        </ul>
    </form>
    <?php }?>
</div>
<div class="clear"></div>
