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
        $("#addViolation").validate({
            rules:{
                vt_desc: "required",
                vt_active: "required"
            },
            messages:{
                vt_desc: "required",
                vt_active: "required"
            }
        });
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Jenis Pelanggaran"></div>')
            .html('Hapus jenis pelanggaran? <div class="clear"></class>').dialog({
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
        window.location = "<?php echo base_url() ?>admin/violation_type_ctrl" + tail;
    }
</script>

<div id="main">
    
    <div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
    
    <p class="tit-form">Daftar Jenis Pelanggaran</p>
    <table class="tab-admin">
    
        <tr class="tittab">
            <td class="header" style="width: 30px;">No</td>	
            <td class="header">Nama</td>
            <td class="header">Status</td>
            <td class="header" style="width: 52px;">Aksi</td>
        </tr>
    
        <?php
        $count = 1;
        if (!empty($violation_type)) {
            foreach ($violation_type as $row) {
                ?>
                <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row->vt_desc; ?></td>
                    <td><?php echo ($row->vt_active=='t')?'Aktif':'Tidak Aktif'; ?></td>
                    <td class="action"> 
                        <?php if (is_has_access('violation_type-edit', $permission) || is_has_access('*', $permission)) { ?>
                        <a href="<?php echo base_url(); ?>admin/violation_type_ctrl/edit/<?php echo $row->vt_id . '#form-pos' ?>" ><div class="tab-edit"></div></a> 
                        <?php }?>
                        <?php if (is_has_access('violation_type-delete', $permission) || is_has_access('*', $permission)) { ?>
                        <a href="<?php echo base_url(); ?>admin/violation_type_ctrl/delete/<?php echo $row->vt_id ?>" class="delete-tab"><div class="tab-delete"></div></a>
                        <?php }?>
                    </td>

                </tr>
                <?php
            }
        }
        ?>
    </table>
    
    <br />
    <?php if (is_has_access('violation_type-edit', $permission) || is_has_access('*', $permission)) { ?>
    <p id="form-pos" class="tit-form">Entri Data Pelanggaran</p>
    <ul class="form-admin">
    <form action="<?php echo base_url() ?>admin/violation_type_ctrl/save" method="post" class="" id="addViolation">
        <?php if (!empty($obj)) { ?>
            <input class="form-data" type="hidden" name="vt_id" value="<?php if (!empty($obj)) echo $obj->vt_id; ?>" />
        <?php } ?>
        
            <li>
                <label>Nama * </label>
                <input class="form-admin" name="vt_desc" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->vt_desc; ?>" >
                <?php echo form_error('vt_desc'); ?>
                <div class="clear"></div>
            </li>
            <li>
                <label>Status *</label>
                <div class="form-admin-radio">
                    <label>
                        <input type="radio" name="vt_active" value="TRUE" <?php if (!empty($obj)) echo $obj->vt_active == 't' ? 'checked' : ''; ?> />Aktif
                    </label>
                    <br />
                    <label>
                        <input type="radio" name="vt_active" value="FALSE" <?php if (!empty($obj)) echo $obj->vt_active == 't' ? '' : 'checked'; ?> />Tidak Aktif
                    </label>
                </div>
                <div class="clear"></div>
            </li>
            <li>
                <label>&nbsp;</label>
                <input class="button-form" type="submit" value="Simpan">
		        <input class="button-form" type="reset" onclick="redirect('')" value="Batal">
		        <input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
            </li>
        
    </form>
    <?php } ?>
    </ul>

</div>
<div class="clear"></div>
