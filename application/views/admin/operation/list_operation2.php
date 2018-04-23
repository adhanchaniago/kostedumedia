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
        $("#addOperation").validate({
            rules:{
                operation_id: "required",
                operation_name: "required",
                corps_id: "required"
            },
            messages:{
                operation_id: "required",
                operation_name: "required",
                corps_id: "required"
            }
        });
        $("#operation_start").datepicker({dateFormat: 'yy-mm-dd'});
        $("#operation_end").datepicker({dateFormat: 'yy-mm-dd'});
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Operasi"></div>')
            .html('Semua terkait Operasi akan ikut dihapus! Hapus data operasi? <div class="clear"></div>').dialog({
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
        window.location = "<?php echo base_url() ?>admin/operation_ctrl2" + tail;
    }
</script>

<div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
    
<p class="tit-form">Daftar Operasi <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
<div class="filtering" style="display: none;">
    <form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
        <ul class="filter-form">
            <li>
                <label>Nama</label><br />
                <input type="text" placeholder="Nama" name="operation_name" class='filter_param' value="<?php echo $this->input->get('operation_name'); ?>" />
            </li>
            <li>
                <label>Pembina</label><br />
                <select name="corps_id" class='filter_param'>
                    <option value="">-Pilih Pembina-</option>
                    <?php foreach ($corps as $row) { ?>
                        <?php if (($this->input->get('corps_id')) && $this->input->get('corps_id') == $row->corps_id) { ?>
                            <option value="<?php echo $row->corps_id ?>" selected><?php echo $row->corps_name ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->corps_id ?>"><?php echo $row->corps_name ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </li>
            <li>
                <label>Tahun</label><br />
                <input type="text" placeholder="Tahun" name="operation_year" class='filter_param' maxlength="4" value="<?php echo $this->input->get('operation_year'); ?>" />
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
<table class="tab-admin">
    <thead>
        <tr class="tittab">
            <td class="header" style="width: 30px;">No</th>
            <td class="header" style="cursor: pointer ;">Nama</th>
            <td class="header" style="cursor: pointer ;">Kodal</th>
            <td class="header" style="cursor: pointer ;">Keterangan</th>
            <td class="header" style="cursor: pointer ;">Tahun</th>
            <td class="header delete" style="width: 52px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        if (!empty($operation)) {
            foreach ($operation as $row) {
                ?>
                <tr class="<?php echo alternator('row-one', 'row-two'); ?>">
                    <td><?php echo ($count++) + $offset; ?></td>
                    <td><?php echo $row->operation_name; ?></td>
                    <td><?php echo $row->corps_name; ?></td>
                    <td><?php echo $row->operation_description; ?></td>
                    <td><?php echo $row->operation_year; ?></td>
                    <td class="action"> 
                        <?php if (is_has_access('operation-edit', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/operation_ctrl2/edit/<?php echo $row->operation_id . '?' . http_build_query($_GET) . '#form-pos' ?>" ><div class="tab-edit"></div></a> 
                        <?php } ?>
                        <?php if (is_has_access('operation-delete', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/operation_ctrl2/delete/<?php echo $row->operation_id . '?' . http_build_query($_GET) ?>" class="delete-tab"><div class="tab-delete"></div></a>
                        <?php } ?>
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
<?php if (is_has_access('operation-edit', $permission) || is_has_access('*', $permission)) { ?>
    <p id="form-pos" class="tit-form">Entri Data Operasi</p>
    <form action="<?php echo base_url() ?>admin/operation_ctrl2/save" method="post" class="jNice" id="addOperation">
        <ul class="form-admin">
            <?php if (!empty($obj)) { ?>
                <input class="form-admin" type="hidden" name="operation_id" value="<?php if (!empty($obj)) echo $obj->operation_id; ?>" />
            <?php } ?>
            <li>
                <label>Nama * </label>
                <input name="operation_name" type="text" class="form-admin" maxlength="255"
                       value="<?php if (!empty($obj)) echo $obj->operation_name; ?>" >
                       <?php echo form_error('operation_name'); ?>	
                <div class="clear"></div>
            </li>
            <li>
                <label>Pembina *</label>
                <select name="corps_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
                    <option value="" selected>-Pilih Pembina-</option>
                    <?php foreach ($corps as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->corps_id == $row->corps_id) { ?>
                            <option value="<?php echo $row->corps_id ?>" selected><?php echo $row->corps_name ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->corps_id ?>"><?php echo $row->corps_name ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>

                <div class="clear"></div>
            </li>
            <li>
                <label>Deskripsi</label>
                <textarea class="form-admin" name="operation_description"><?php if (!empty($obj)) echo $obj->operation_description; ?></textarea>
                <?php echo form_error('operation_description'); ?>
                <div class="clear"></div>
            </li>
            <li>
                <label>Tahun</label>
                <input name="operation_year" type="text" class="form-admin" maxlength="4"
                       value="<?php if (!empty($obj)) echo $obj->operation_year; ?>" >
                       <?php echo form_error('operation_year'); ?>	
                <div class="clear"></div>
            </li>
            <li>
                <label>Tanggal Mulai</label>
                <input class="form-admin" name="operation_start" id="operation_start" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->operation_start; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                       <?php echo form_error('operation_start'); ?>					
                <div class="clear"></div>
            </li>
            <li>
                <label>Tanggal Selesai</label>
                <input class="form-admin" name="operation_end" id="operation_end" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->operation_end; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                       <?php echo form_error('operation_end'); ?>					
                <div class="clear"></div>
            </li>
            <li>
                <p class="tit-form"></p>
                <label>&nbsp;</label>
                <input type="submit" class="button-form" value="<?php if (empty($obj)) echo 'Simpan'; else echo 'Simpan'; ?> ">
                <input type="reset" class="button-form" value="Batal" onclick="redirect('')">
		        <input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
            </li>
        </ul>
    </form>
<?php } ?>
</div>
<div class="clear"></div>
