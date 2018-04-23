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
                window.location = '<?php echo base_url() ?>admin/operation_viewability_ctrl'
            });
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#opAvailableAdd").validate({
            rules:{
                operation_id: "required",
                corps_id: "required",
                viewability: "required"
            },
            messages:{
                operation_id: "required",
                corps_id: "required",
                viewability: "required"
            }
        });
        $('.delete').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Operation Viewability"></div>')
            .html('<p>All item related to Operation Viewability will be deleted to ! Are you sure ?</p>').dialog({
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
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">operation_viewability</a></h2>

<div id="main">
    <h3>List operation viewability</h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="header">No</th>						
                <th class="header" style="cursor: pointer ;">Operation</th>
                <th class="header" style="cursor: pointer ;">Corps</th>
                <th class="header" style="cursor: pointer ;">Viewability</th>
                <th class="header delete">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($operation_viewability)) {
                foreach ($operation_viewability as $row) {
                    ?>
                    <tr class="<?php echo alternator("", "odd"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->operation_name; ?></td>
                        <td><?php echo $row->corps_name; ?></td>
                        <td><?php echo $row->viewability; ?></td>
                        <td class="action"> <a href="<?php echo base_url(); ?>admin/operation_viewability_ctrl/edit/<?php echo $row->operation_id ?>/<?php echo $row->corps_id ?>" class="edit">Edit</a> 
                            <a href="<?php echo base_url(); ?>admin/operation_viewability_ctrl/delete/<?php echo $row->operation_id ?>/<?php echo $row->corps_id ?>" class="delete">Delete</a></td>

                    </tr>
                    <?php
                }
            }
            ?>

        </tbody>
    </table>	
    <h3>Operation Viewability Data</h3>
    <form action="<?php echo base_url() ?>admin/operation_viewability_ctrl/save" method="post" class="" id="opAvailableAdd">
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
                <label>Corps</label>
                <select name="corps_id">
                    <option value="" selected>-Select Corps-</option>
                    <?php foreach ($corps as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->corps_id == $row->corps_id) { ?>
                            <option value="<?php echo $row->corps_id ?>" selected><?php echo $row->corps_name ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->corps_id ?>"><?php echo $row->corps_name ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </p>
            <p>
                <label>Viewability</label>
                <input type="radio" name="viewability" value="TRUE" <?php if (!empty($obj)) echo $obj->viewability == 't' ? 'checked' : ''; ?> />Yes<br/>
                <input type="radio" name="viewability" value="FALSE" <?php if (!empty($obj)) echo $obj->viewability == 't' ? '' : 'checked'; ?> />No

            </p>

            <p>
                <input type="submit" value="<?php if (empty($obj)) echo 'Save'; else echo 'Edit'; ?> ">
                <input type="reset" value="Cancel">
            </p>
        </fieldset>
    </form>
</div>
<div class="clear"></div>
