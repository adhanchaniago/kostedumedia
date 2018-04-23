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
        $("#addPersonnelType").validate({
            rules:{
                psntype_id: "required",
                psntype_desc: "required",
                psntype_metric: "required"
            },
            messages:{
                psntype_id: "required",
                psntype_desc: "required",
                psntype_metric: "required"
            }
        });
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Jenis Personil"></div>')
            .html('Hapus jenis personil? <div class="clear"></class>').dialog({
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
        window.location = "<?php echo base_url() ?>admin/personnel_type_ctrl" + tail;
    }
</script>

<div id="main">

    <div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
    
    <p class="tit-form">Daftar Jenis Personil</p>
    <table class="tab-admin" cellpadding="0" cellspacing="0">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;">No</th>						
                <!-- <td class="header" style="cursor: pointer ;">Type ID</th> -->
                <td class="header" style="cursor: pointer ;">Jenis Personil</th>
                <td class="header" style="cursor: pointer ;">Satuan</th>
                <td class="header delete" style="width: 52px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($personnel_type)) {
                foreach ($personnel_type as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                        <td><?php echo $count++; ?></td>
                        <!-- <td><?php echo $row->psntype_id; ?></td> -->
                        <td><?php echo $row->psntype_desc; ?></td>
                        <td><?php echo $row->psntype_metric; ?></td>
                        <td class="action"> 
                            <?php if (is_has_access('personnel_type-edit', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/personnel_type_ctrl/edit/<?php echo $row->psntype_id . '#form-pos' ?>" ><div class="tab-edit"></div></a> 
                            <?php }?>
                            <?php if (is_has_access('personnel_type-delete', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/personnel_type_ctrl/delete/<?php echo $row->psntype_id ?>" class="delete-tab"><div class="tab-delete"></div></a>
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
    <?php if (is_has_access('personnel_type-edit', $permission) || is_has_access('*', $permission)) { ?>
    <p id="form-pos" class="tit-form">Entri Data Jenis Personel</p>
    <form action="<?php echo base_url() ?>admin/personnel_type_ctrl/save" method="post" class="jNice" id="addPersonnelType">
        <ul class="form-admin">
            <li>
                <?php if (!empty($obj)) { ?>
                    <input class="form-admin" type="hidden" name="psntype_id" value="<?php echo $obj->psntype_id ?>" />
                <?php } ?>
                <label>Jenis Personil *</label>
                <input class="form-admin" name="psntype_desc" type="text" class="text-medium" maxlength="250" value="<?php if (!empty($obj)) echo $obj->psntype_desc; ?>" >
                <?php echo form_error('psntype_desc'); ?>
                <div class="clear"></class>
            </li>
            <li>
                <label>Satuan *</label>
                <input class="form-admin" name="psntype_metric" type="text" class="text-medium" maxlength="50"
                       value="<?php if (!empty($obj)) echo $obj->psntype_metric; ?>" >
                <?php echo form_error('psntype_metric'); ?>
                <div class="clear"></class>
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
