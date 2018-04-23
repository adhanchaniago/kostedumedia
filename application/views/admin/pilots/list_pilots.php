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
                window.location = '<?php echo base_url() ?>admin/pilots_ctrl'
            });
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#addPilot").validate({
            rules:{
                plev_id: "required",
                pilot_name: "required",
                pilot_id: "required"
            },
            messages:{
                plev_id: "required",
                pilot_name: "required",
                pilot_id: "required"
            }
        });
        $('.delete').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Pilot"></div>')
            .html('<p>All item related to Pilot will be deleted to ! Are you sure ?</p>').dialog({
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
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">Pilots</a></h2>

<div id="main">
    <h3>List Pilots</h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="header">No</th>						
                <th class="header" style="cursor: pointer ;">Level</th>
                <th class="header" style="cursor: pointer ;">Pilot ID</th>
                <th class="header" style="cursor: pointer ;">Pilot Name</th>
                <th class="header delete">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($pilots)) {
                foreach ($pilots as $row) {
                    ?>
                    <tr class="<?php echo alternator("", "odd"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->plev_name; ?></td>
                        <td><?php echo $row->pilot_id; ?></td>
                        <td><?php echo $row->pilot_name; ?></td>
                        <td class="action"> <a href="<?php echo base_url(); ?>admin/pilots_ctrl/edit/<?php echo $row->plev_id ?>/<?php echo $row->pilot_id ?>" class="edit">Edit</a> 
                            <a href="<?php echo base_url(); ?>admin/pilots_ctrl/delete/<?php echo $row->plev_id ?>/<?php echo $row->pilot_id ?>" class="delete">Delete</a></td>

                    </tr>
                    <?php
                }
            }
            ?>

        </tbody>
    </table>	
    <h3>Pilots Data</h3>
    <form action="<?php echo base_url() ?>admin/pilots_ctrl/save" method="post" id="addPilot">
        <fieldset>
            <p>
                <label>Level ID * </label>
                <select name="plev_id">
                    <option value="" selected>-Select Pilot Grade-</option>
                    <?php foreach ($pilot_grades as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->plev_id == $row->plev_id) { ?>
                            <option value="<?php echo $row->plev_id ?>" selected><?php echo $row->plev_name ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->plev_id ?>"><?php echo $row->plev_name ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>						
            </p>
            <p>
                <label>Pilot ID * </label>
                <input name="pilot_id" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->pilot_id; ?>" <?php if (!empty($obj)) echo "disabled"; ?>>
                <?php echo form_error('pilot_id'); ?>					
                <?php if (!empty($obj)){?>
                <input type="hidden" name="pilot_id" value="<?php echo $obj->pilot_id; ?>"
                <?php } ?>
            </p>
            <p>
                <label>Pilot Name * </label>
                <input name="pilot_name" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->pilot_name; ?>" >
                <?php echo form_error('pilot_name'); ?>					</p>

            <p>
                <input type="submit" value="<?php if (empty($obj)) echo 'Save'; else echo 'Edit'; ?> ">
                <input type="reset" value="Cancel">
            </p>
        </fieldset>
    </form>
</div>
<div class="clear"></div>
