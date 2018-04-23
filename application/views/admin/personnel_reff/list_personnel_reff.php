<?php if ($this->session->flashdata('info')) { ?>
    <script>
        $(document).ready(function(){
            alert('<?php echo $this->session->flashdata('info'); ?>');
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#personnelReffAdd").validate({
            //idv: { required: true, regex: "/^(\d{3})TN(\d{4})$/" },
            rules:{
                psnreff_nrp: "required",//{required : true, regex : "/^(\d{5})\/L$/"},
                psnreff_name: "required"
            },
            messages:{
                psnreff_nrp: "required",
                psnreff_name: "required"
            }
        });
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Personnel Reff"></div>')
            .html('All item related to Personnel reff will be deleted to ! Are you sure ?<div class="clear"></div>').dialog({
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
	
	function create_url(){
        var url = $('#form_search_filter').attr('action')+'/?filter=true&';
        var param = '';
        $('.filter_param').each(function(){
            param += $(this).attr('name')+'='+$(this).val().replace('/','_')+'&';
        });
        $('#form_search_filter').attr('action',url+param).submit();
    }
	
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if(!((charCode>=48&&charCode<=57)|| (charCode==46) || (charCode==8) || (charCode==9)))
            return false;

        return true;
    }
    function redirect(){
        window.location = "<?php echo base_url() ?>admin/personnel_reff_ctrl";
    }
</script>
<p class="tit-form">Daftar Personel <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
<div class="filtering" style="display: none;">
    <form action="<?php echo base_url().'admin/personnel_reff_ctrl' ?>" method="post" id="form_search_filter">
        <ul class="filter-form">
            <li>
                <label>RNP</label><br />
                <input type="text" placeholder="RNP" name="psnreff_nrp" class="filter_param" value="<?php echo ($this->input->get('psnreff_nrp')) ? str_replace('_','/',$this->input->get('psnreff_nrp')) : ''; ?>" />
            </li>
            <li>
                <label>Nama Personel</label><br />
                <input type="text" placeholder="Nama Personel" class="filter_param" name="psnreff_name" value="<?php echo ($this->input->get('psnreff_name')) ? $this->input->get('psnreff_name') : ''; ?>" />
            </li>
        </ul>

        <div class="clear"></div>
        <div style="border-bottom: 1px dotted #DDD; margin: 15px 0 17px 0;"></div>

        <input type="button" value="Filter" name="search_filter" onclick="create_url();" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
		<input type="button" value="Bersihkan Pencarian" onclick="document.location='<?php echo base_url().'admin/personnel_reff_ctrl' ?>';" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
        <div class="clear"></div>
        <div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
    </form>
</div>
<table class="tab-admin">
    <thead>
        <tr class="tittab">
            <td class="header" style="width: 35px;">No</th>						
            <td class="header" style="cursor: pointer; width: 150px;">RNP Personel </th>
            <td class="header" style="cursor: pointer;">Nama Personel</th>
            <td class="header delete" style="width: 52px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        if (!empty($personnel_reff)) {
            foreach ($personnel_reff as $row) {
                ?>
                <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                    <td><?php echo $count++; ?></td>
                    <td><?php echo str_replace('_', '/', $row->psnreff_nrp); ?></td>
                    <td><?php echo $row->psnreff_name; ?></td>
                    <td class="action">
                        <?php if (is_has_access('personnel_ref-edit', $permission) || is_has_access('*', $permission)) { ?>
                        <a href="<?php echo base_url(); ?>admin/personnel_reff_ctrl/edit/<?php echo $row->psnreff_nrp.'?'.http_build_query($_GET) ?>"><div class="tab-edit"></div></a> 
                        <?php }?>
                        <?php if (is_has_access('personnel_ref-delete', $permission) || is_has_access('*', $permission)) { ?>
                        <a href="<?php echo base_url(); ?>admin/personnel_reff_ctrl/delete/<?php echo $row->psnreff_nrp.'?'.http_build_query($_GET) ?>" class="delete-tab"><div class="tab-delete"></div></a>
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
 <div class="pagination">
			<?php echo $pagination?>
		</div>
<br />
<?php if (is_has_access('personnel_ref-edit', $permission) || is_has_access('*', $permission)) { ?>
<p class="tit-form">Entri Data Personil</p>
<form action="<?php echo base_url() ?>admin/personnel_reff_ctrl/save" method="post" id="personnelReffAdd">
    <ul class="form-admin">
        <li>
            <label>NRP Personel *</label>
            <input class="form-admin" name="psnreff_nrp" type="text" class="text-medium" maxlength="25"
                   value="<?php if (!empty($obj)) echo str_replace('_', '/', $obj->psnreff_nrp); ?>" >
                   <?php echo form_error('psnreff_nrp'); ?>					
            <div class="clear"></div>
        </li>
        <li>
            <label>Nama Personel</label>
            <input class="form-admin" name="psnreff_name" type="text" class="text-long"
                   value="<?php if (!empty($obj)) echo $obj->psnreff_name; ?>" >
                   <?php echo form_error('psnreff_name'); ?>					
            <div class="clear"></div>
        </li>
        <li>
            <label>&nbsp;</label>
            <input class="button-form" type="submit" value="Simpan">
            <input class="button-form" type="reset" value="Batalkan">
            <?php if (!empty($obj)) { ?>
                <input class="button-form" type="button" onclick="redirect()" value="Data Baru"/>
            <?php } ?>
            <div class="clear"></div>
        </li>
    </ul>
</form>
<?php }?>
