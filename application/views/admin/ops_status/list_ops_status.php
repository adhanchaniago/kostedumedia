<?php if ($this->session->flashdata('info')) { ?>
    <script>
        $(document).ready(function(){
             $('.success').html('<strong>Penyimpanan data berhasil.<strong> <?php echo $this->session->flashdata('info'); ?>');
            $('.success').attr('style','');
            $('.success').delay(3000).fadeOut('slow');
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#opStatusAdd").validate({
            rules:{
                ops_stat_id: "required"
            },
            messages:{
                ops_stat_id: "required"
            }
        });
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Operation Status"></div>')
            .html('All item related to Operation status will be deleted to ! Are you sure ?	<div class="clear"></div>').dialog({
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
</script>

<div id="main">

    <div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
    
    <p class="tit-form">Daftar Status Operasi</p>
    <table class="tab-admin">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;">No</th>						
                <td class="header" style="cursor: pointer ;">ID</th>
                <td class="header" style="cursor: pointer ;">Nama</th>
                <td class="header delete" style="width: 52px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($ops_status)) {
                foreach ($ops_status as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->ops_stat_id; ?></td>
                        <td><?php echo $row->ops_stat_desc; ?></td>
                        <td class="action"> 
                            <?php if (is_has_access('ops_status-edit', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/ops_status_ctrl/edit/<?php echo $row->ops_stat_id ?>" ><div class="tab-edit"></div></a> 
                            <?php }?>
                            <?php if (is_has_access('ops_status-delete', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/ops_status_ctrl/delete/<?php echo $row->ops_stat_id ?>" class="delete-tab"><div class="tab-delete"></div></a>
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
    <?php if (is_has_access('ops_status-edit', $permission) || is_has_access('*', $permission)) { ?>
    <p class="tit-form">Entri Data Status Operasi</p>
    <form action="<?php echo base_url() ?>admin/ops_status_ctrl/save" method="post" id="opStatusAdd">
        <ul class="form-admin">
            <li>
                <label>ID * </label>
                <input class="form-admin" name="ops_stat_id" type="text" class="text-medium" onkeypress="return isNumberKey(event)"
                       value="<?php if (!empty($obj)) echo $obj->ops_stat_id; ?>" >
                       <?php echo form_error('ops_stat_id'); ?>					
            	<div class="clear"></div>
			</li>
            <li>
                <label>Nama </label>
                <textarea class="form-admin" name="ops_stat_desc" rows="1" cols="1" maxlength="255"><?php if (!empty($obj)) echo $obj->ops_stat_desc; ?></textarea>
                <?php echo form_error('ops_stat_desc'); ?>					
            	<div class="clear"></div>
			</li>
            <li>
                <label>&nbsp;</label>
                <input class="button-form" type="submit" value="Simpan">
                <input class="button-form" type="reset" value="Batalkan">
            	<div class="clear"></div>
			</li>
        </ul>
    </form>
    <?php }?>
</div>
<div class="clear"></div>
