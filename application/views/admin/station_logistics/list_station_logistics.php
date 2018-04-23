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
                window.location = '<?php echo base_url() ?>admin/station_logistics_ctrl'
            });
                    
            $('.delete').click(function(){
                var page = $(this).attr("href");
                var $dialog = $('<div title="Cancellation Policy Delete"></div>')
                .html('<p>Are you sure to delete this cancellation policy ?</p>').dialog({
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
<?php } ?>
<script>
    $(document).ready(function(){
        $("#stationLog").validate({
            rules:{
                logitem_id: "required",
                station_id: "required",
                stationlog_value: "required"
            },
            messages:{
                logitem_id: "required",
                station_id: "required",
                stationlog_value: "required"
            }
        });
        $('.delete').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Station Logistic Delete"></div>')
            .html('<p>Are you sure to delete this station logistic ?</p>').dialog({
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
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">station_logistics</a></h2>

<div id="main">
    <h3>List station_logistics</h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="header">No</th>						
                <th class="header" style="cursor: pointer ;">Logistic Item ID</th>
                <th class="header" style="cursor: pointer ;">Station</th>
                <th class="header" style="cursor: pointer ;">stationlog_value</th>
                <th class="header delete">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($station_logistics)) {
                foreach ($station_logistics as $row) {
                    ?>
                    <tr class="<?php echo alternator("", "odd"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->logitem_id; ?></td>
                        <td><?php echo $row->station_name; ?></td>
                        <td><?php echo $row->stationlog_value; ?></td>
                        <td class="action"> <a href="<?php echo base_url(); ?>admin/station_logistics_ctrl/edit/<?php echo $row->logitem_id ?>/<?php echo $row->station_id ?>" class="edit">Edit</a> 
                            <a href="<?php echo base_url(); ?>admin/station_logistics_ctrl/delete/<?php echo $row->logitem_id ?>/<?php echo $row->station_id ?>" class="delete">Delete</a></td>

                    </tr>
                    <?php
                }
            }
            ?>

        </tbody>
    </table>	
    <h3>station_logistics Data</h3>
    <form action="<?php echo base_url() ?>admin/station_logistics_ctrl/save" method="post" class="" id="stationLog">
        <fieldset>
            <p>
                <label>Logistic Item</label>
                <select name="logitem_id">
                    <option value="" selected>-Select Corps-</option>
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
                <label>Station</label>
                <select name="station_id">
                    <option value="" selected>-Select Corps-</option>
                    <?php foreach ($station as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->station_id == $row->station_id) { ?>
                            <option value="<?php echo $row->station_id ?>" selected><?php echo $row->station_name ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->station_id ?>"><?php echo $row->station_name ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </p>
            <p>
                <label>Value</label>
                <input name="stationlog_value" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->stationlog_value; ?>" >
                <?php echo form_error('stationlog_value'); ?>					</p>

            <p>
                <input type="submit" value="<?php if (empty($obj)) echo 'Save'; else echo 'Edit'; ?> ">
                <input type="reset" value="Cancel">
            </p>
        </fieldset>
    </form>
</div>
<div class="clear"></div>
