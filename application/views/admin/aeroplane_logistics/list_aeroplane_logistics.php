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
                window.location = '<?php echo base_url() ?>admin/aeroplane_logistics_ctrl'
            });
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#addAeroLogistic").validate({
            rules:{
                logitem_id: "required",
                aer_id: "required",
                aerlog_value: "required"
            },
            messages:{
                logitem_id: "required",
                aer_id: "required",
                aerlog_value: "required"
            }
        });
        $('.delete').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Aeroplane Logistic"></div>')
            .html('<p>All item related to Aeroplane Logistic will be deleted to ! Are you sure ?</p>').dialog({
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
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">aeroplane_logistics</a></h2>

<div id="main">
    <h3>List aeroplane_logistics</h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="header">No</th>						
                <th class="header" style="cursor: pointer ;">Logistic Item</th>
                <th class="header" style="cursor: pointer ;">Aeroplane</th>
                <th class="header" style="cursor: pointer ;">Value</th>
                <th class="header delete">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($aeroplane_logistics)) {
                foreach ($aeroplane_logistics as $row) {
                    ?>
                    <tr class="<?php echo alternator("", "odd"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->logitem_desc; ?></td>
                        <td><?php echo $row->aer_name; ?></td>
                        <td><?php echo $row->aerlog_value; ?></td>
                        <td class="action"> <a href="<?php echo base_url(); ?>admin/aeroplane_logistics_ctrl/edit/<?php echo $row->logitem_id ?>/<?php echo $row->aer_id ?>" class="edit">Edit</a> 
                            <a href="<?php echo base_url(); ?>admin/aeroplane_logistics_ctrl/delete/<?php echo $row->logitem_id ?>/<?php echo $row->aer_id ?>" class="delete">Delete</a></td>

                    </tr>
                    <?php
                }
            }
            ?>

        </tbody>
    </table>	
    <h3>aeroplane_logistics Data</h3>
    <form action="<?php echo base_url() ?>admin/aeroplane_logistics_ctrl/save" method="post" id="addAeroLogistic">
        <fieldset>
            <p>
                <label>Logistic Item * </label>
                <select name="logitem_id" <?php if (!empty($obj)) echo "disabled"; ?>>
                    <option value="" selected>-Select Logistic Item-</option>
                    <?php foreach ($logistic_item as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->logitem_id == $row->logitem_id) { ?>
                            <option value="<?php echo $row->logitem_id ?>" selected><?php echo $row->logitem_desc ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->logitem_id ?>"><?php echo $row->logitem_desc ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                 <?php if (!empty($obj)){?>
                <input type="hidden" name="logitem_id" value="<?php echo $obj->logitem_id; ?>"
                <?php } ?>
            </p>
            <p>
                <label>Aeroplane * </label>
                <select name="aer_id" <?php if (!empty($obj)) echo "disabled"; ?>>
                    <option value="" selected>-Select Aeroplane-</option>
                    <?php foreach ($aeroplane as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->aer_id == $row->aer_id) { ?>
                            <option value="<?php echo $row->aer_id ?>" selected><?php echo $row->aer_name ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->aer_id ?>"><?php echo $row->aer_name ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if (!empty($obj)){?>
                <input type="hidden" name="aer_id" value="<?php echo $obj->aer_id; ?>"
                <?php } ?>
            </p>
            <p>
                <label>Value * </label>
                <input name="aerlog_value" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->aerlog_value; ?>" >
                <?php echo form_error('aerlog_value'); ?>					</p>

            <p>
                <input type="submit" value="<?php if (empty($obj)) echo 'Save'; else echo 'Edit'; ?> ">
                <input type="reset" value="Cancel">
            </p>
        </fieldset>
    </form>
</div>
<div class="clear"></div>
