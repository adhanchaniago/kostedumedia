<?php if (!empty($saving)) { ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.success').fadeOut(5000,function(){
                $(this).remove();
            });
            $('#saveBtn').click(function (){
                var edit = $.trim($(this).prop('value')).toLowerCase();

                if( edit==='edit'){
                    $(this).prop('value', 'Save');
                    $('input[type=text]').prop('readonly',false);
                    return false;
                }else{
                    var form = $('input[type=submit]').closest("form");
                    form.submit();
                }
            });

            $('#cancelBtn').click(function(){
                window.location = '<?php echo base_url() ?>admin/skuadron_ctrl'
            });
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#addSkuadron").validate({
            //idv: { required: true, regex: "/^(\d{3})TN(\d{4})$/" },
            rules:{
                plev_id: {required : true}
            },
            messages:{
                plev_id: "required"
            }
        });
        $('.delete').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Skuadron"></div>')
            .html('<p>All item related to Skuadron will be deleted to ! Are you sure ?</p>').dialog({
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
</script>
<div id="main">
    <p class="tit-form">List Skuadron</p>
    <table class="tab-admin">
        <thead>
            <tr class="tittab">
                <td class="header">No</th>						
                <td class="header" style="cursor: pointer ;">Skuadron Code</td>
                <td class="header" style="cursor: pointer ;">Skuadron Name</td>
                <td class="header delete">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($skuadron)) {
                foreach ($skuadron as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->sku_code; ?></td>
                        <td><?php echo $row->sku_name; ?></td>
                        <td class="action"> <a href="<?php echo base_url(); ?>admin/skuadron_ctrl/edit/<?php echo $row->sku_code ?>" class="">Edit</a> 
                            <a href="<?php echo base_url(); ?>admin/skuadron_ctrl/delete/<?php echo $row->sku_code ?>" class="delete">Delete</a></td>

                    </tr>
                    <?php
                }
            }
            ?>

        </tbody>
    </table>	
    <p class="tit-form">Data Skuadron</p>
    <form action="<?php echo base_url() ?>admin/skuadron_ctrl/save" method="post" class="jNice" id="addSkuadron">
        <ul class="form-admin">
            <li>
                <label>Skuadron Code * </label>
                <input name="sku_code" type="text" class="text-medium" maxlength="10"
                       value="<?php if (!empty($obj)) echo $obj->sku_code; ?>" <?php if (!empty($obj)) echo "disabled"; ?>>
                <?php echo form_error('sku_code'); ?>	
                <?php if (!empty($obj)){?>
                <input type="hidden" name="sku_code" value="<?php echo $obj->sku_code; ?>"
                <?php } ?>
            </li>
            <li>
                <label>Skuadron Name * </label>
                <input name="sku_name" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->sku_name; ?>" >
                <?php echo form_error('sku_name'); ?>					
             </li>

            <li>
                <input class="button-form" type="submit" value="<?php if (empty($obj)) echo 'Save'; else echo 'Edit'; ?> ">
                <input class="button-form" type="reset" value="Cancel">
            </li>
        </ul>
    </form>
</div>
<div class="clear"></div>
