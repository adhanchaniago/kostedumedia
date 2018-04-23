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
                window.location = '<?php echo base_url() ?>admin/ship_ops_ctrl'
            });
        });
    </script>
<?php } ?>
    <script>
    $(document).ready(function(){
        $("#addShipOperation").validate({
            rules:{
                operation_id: "required",
                ship_id: "required",
                ops_stat_id: "required"
            },
            messages:{
                operation_id: "required",
                ship_id: "required",
                ops_stat_id: "required"
            }
        });
        $('.delete').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Ship Operation Delete"></div>')
            .html('<p>Are you sure ?</p>').dialog({
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
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">ship_ops</a></h2>

<div id="main">
    <h3>List ship_ops</h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="header">No</th>						
                <th class="header" style="cursor: pointer ;">Operation</th>
                <th class="header" style="cursor: pointer ;">Ship</th>
                <th class="header" style="cursor: pointer ;">Operation Status</th>
                <th class="header" style="cursor: pointer ;">Program Turn Hour</th>
                <th class="header" style="cursor: pointer ;">Current Turn Hour</th>
                <th class="header delete">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($ship_ops)) {
                foreach ($ship_ops as $row) {
                    ?>
                    <tr class="<?php echo alternator("", "odd"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->operation_name; ?></td>
                        <td><?php echo $row->ship_name; ?></td>
                        <td><?php echo $row->ops_stat_desc; ?></td>
                        <td><?php echo $row->shipops_program_hour; ?></td>
                        <td><?php echo $row->shipops_current_hour; ?></td>
                        <td class="action"> <a href="<?php echo base_url(); ?>admin/ship_ops_ctrl/edit/<?php echo $row->operation_id ?>/<?php echo $row->ship_id ?>/<?php echo $row->ops_stat_id ?>" class="edit">Edit</a> 
                            <a href="<?php echo base_url(); ?>admin/ship_ops_ctrl/delete/<?php echo $row->operation_id ?>/<?php echo $row->ship_id ?>/<?php echo $row->ops_stat_id ?>" class="delete">Delete</a></td>

                    </tr>
                <?php
                }
            }
            ?>

        </tbody>
    </table>	
    <h3>ship_ops Data</h3>
    <form action="<?php echo base_url() ?>admin/ship_ops_ctrl/save" method="post" class="" id="addShipOperation">
        <fieldset>
            <p>
                <label>Operation</label>
                <select name="operation_id">
                    <option value="" selected>-Select Operation-</option>
                    <?php foreach ($operation as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->operation_id == $row->operation_id) { ?>
                            <option value="<?php echo $row->operation_id ?>" selected><?php echo $row->operation_name ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->operation_id ?>"><?php echo $row->operation_name ?></option>
                        <?php } ?>
<?php } ?>
                </select>					
            </p>
            <p>
                <label>Ship * </label>
                <select name="ship_id">
                    <option value="" selected>-Select Ships-</option>
                    <?php foreach ($ship as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->ship_id == $row->ship_id) { ?>
                            <option value="<?php echo $row->ship_id ?>" selected><?php echo $row->ship_name ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->ship_id ?>"><?php echo $row->ship_name ?></option>
                        <?php } ?>
<?php } ?>
                </select>
            </p>
            <p>
                <label>Operation Status * </label>
                <select name="ops_stat_id">
                    <option value="" selected>-Select Operation Status-</option>
                    <?php foreach ($ops_status as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->ops_stat_id == $row->ops_stat_id) { ?>
                            <option value="<?php echo $row->ops_stat_id ?>" selected><?php echo $row->ops_stat_desc ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->ops_stat_id ?>"><?php echo $row->ops_stat_desc ?></option>
                        <?php } ?>
<?php } ?>
                </select>
            </p>
            <?php if(!empty($obj)){?>
            <input type="hidden" name="old_ship_id" value="<?php echo $obj->ship_id?>" />
            <input type="hidden" name="old_operation_id" value="<?php echo $obj->operation_id?>" />
            <input type="hidden" name="old_ops_stat_id" value="<?php echo $obj->ops_stat_id?>" />
            <?php }?>
            <p>
                <input type="submit" value="<?php if (empty($obj)) echo 'Save'; else echo 'Edit'; ?> ">
                <input type="reset" value="Cancel">
            </p>
        </fieldset>
    </form>
</div>
<div class="clear"></div>
