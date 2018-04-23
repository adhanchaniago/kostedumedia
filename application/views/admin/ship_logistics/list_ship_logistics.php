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
                window.location = '<?php echo base_url() ?>admin/ship_logistics_ctrl'
            });
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#shipLogAdd").validate({
            rules:{
                ship_id: "required",
                logitem_id: "required"
            },
            messages:{
                ship_id: "required",
                logitem_id: "required"
            }
        });
        $('.delete').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Ship Logistic Delete"></div>')
            .html('<p>All item related to station will be deleted to ! are you sure ?</p>').dialog({
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
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">ship_logistics</a></h2>

<div id="main">
    <h3>List ship_logistics</h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="header">No</th>						
                <th class="header" style="cursor: pointer ;">Ship</th>
                <th class="header" style="cursor: pointer ;">Logistic Item</th>
                <th class="header" style="cursor: pointer ;">Value</th>
                <th class="header delete">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($ship_logistics)) {
                foreach ($ship_logistics as $row) {
                    ?>
                    <tr class="<?php echo alternator("", "odd"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->ship_name; ?></td>
                        <td><?php echo $row->logitem_desc; ?></td>
                        <td><?php echo $row->shiplog_value; ?></td>
                        <td class="action"> <a href="<?php echo base_url(); ?>admin/ship_logistics_ctrl/edit/<?php echo $row->ship_id ?>" class="edit">Edit</a> 
                            <a href="<?php echo base_url(); ?>admin/ship_logistics_ctrl/delete/<?php echo $row->ship_id ?>" class="delete">Delete</a></td>

                    </tr>
                <?php
                }
            }
            ?>

        </tbody>
    </table>	
    <!--<h3>ship_logistics Data</h3>
    <form action="<?php echo base_url() ?>admin/ship_logistics_ctrl/save" method="post" class="jNice" id="shipLogAdd">
        <fieldset>
            <p>
                <label>Ship * </label>
                <select name="ship_id">
                    <option value="" selected>-Select Ship-</option>
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
                <label>Logistic Item * </label>
                <select name="logitem_id">
                    <option value="" selected>-Select Logistic-</option>
                    <?php foreach ($logistic_item as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->logitem_id == $row->logitem_id) { ?>
                            <option value="<?php echo $row->logitem_id ?>" selected><?php echo $row->logitem_desc ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->logitem_id ?>"><?php echo $row->logitem_desc ?></option>
                        <?php } ?>
<?php } ?>
                </select>
            </p>
            <p>
                <label>Ship Logistic Value * </label>
                <input name="shiplog_value" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->shiplog_value; ?>" >
<?php echo form_error('shiplog_value'); ?>					</p>

            <p>
                <input type="submit" value="<?php if (empty($obj)) echo 'Save'; else echo 'Edit'; ?> ">
                <input type="reset" value="Cancel">
            </p>
        </fieldset>
    </form>-->
</div>
<div class="clear"></div>
