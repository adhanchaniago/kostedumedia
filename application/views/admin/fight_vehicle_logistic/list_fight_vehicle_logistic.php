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
                window.location = '<?php echo base_url() ?>admin/fight_vehicle_logistic_ctrl'
            });
        });
    </script>
<?php } ?>
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">fight_vehicle_logistic</a></h2>

<div id="main">
    <h3>List fight_vehicle_logistic</h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="header">No</th>						
                <th class="header" style="cursor: pointer ;">Logistik Item</th>
                <th class="header" style="cursor: pointer ;">Kendaraan Tempur</th>
                <th class="header" style="cursor: pointer ;">Value</th>
                <th class="header delete">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($fight_vehicle_logistic)) {
                foreach ($fight_vehicle_logistic as $row) {
                    ?>
                    <tr class="<?php echo alternator("", "odd"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->logitem_desc; ?></td>
                        <td><?php echo $row->fv_name; ?></td>
                        <td><?php echo $row->fvehicle_value; ?></td>
                        <td class="action"> <a href="<?php echo base_url(); ?>admin/fight_vehicle_logistic_ctrl/edit/<?php echo $row->logitem_id ?>/<?php echo $row->fv_id ?>" class="edit">Edit</a> 
                            <a href="<?php echo base_url(); ?>admin/fight_vehicle_logistic_ctrl/delete/<?php echo $row->logitem_id ?>/<?php echo $row->fv_id ?>" class="delete">Delete</a></td>

                    </tr>
                <?php
                }
            }
            ?>

        </tbody>
    </table>	
    <h3>Data Logistik Kendaraan Tempur</h3>
    <form action="<?php echo base_url() ?>admin/fight_vehicle_logistic_ctrl/save" method="post" class="jNice">
        <fieldset>
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
                <label>Kendaraan Tempur * </label>
                <select name="fv_id">
                    <option value="" selected>-Select Kendaraan Tempur-</option>
                    <?php foreach ($fighting_vehicle as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->fv_id == $row->fv_id) { ?>
                            <option value="<?php echo $row->fv_id ?>" selected><?php echo $row->fv_name ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->fv_id ?>"><?php echo $row->fv_name ?></option>
                        <?php } ?>
<?php } ?>
                </select>
            </p>
            <p>
                <label>Value * </label>
                <input name="fvehicle_value" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->fvehicle_value; ?>" >
<?php echo form_error('fvehicle_value'); ?>					</p>

            <p>
                <input type="submit" value="<?php if (empty($obj)) echo 'Save'; else echo 'Edit'; ?> ">
                <input type="reset" value="Cancel">
            </p>
        </fieldset>
    </form>
</div>
<div class="clear"></div>
