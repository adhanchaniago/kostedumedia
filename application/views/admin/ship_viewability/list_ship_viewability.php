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
                window.location = '<?php echo base_url() ?>admin/ship_viewability_ctrl'
            });
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#addShipView").validate({
            rules:{
                corps_id: "required",
                ship_id: "required",
                viewable: "required"
            },
            messages:{
                corps_id: "required",
                ship_id: "required",
                viewable: "required"
            }
        });
        $('.delete').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Ship Viewable Delete"></div>')
            .html('<li>Are you sure ?	<div class="clear"></div>
			</li>').dialog({
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
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">ship_viewability</a></h2>

<div id="main">
    <h3>List ship_viewability</h3>
    <table class="tab-admin">
        <thead>
            <tr class="tittab">
                <td class="header">No</th>						
                <td class="header" style="cursor: pointer ;">Corps</th>
                <td class="header" style="cursor: pointer ;">Ship</th>
                <td class="header" style="cursor: pointer ;">Viewable</th>
                <td class="header delete">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($ship_viewability)) {
                foreach ($ship_viewability as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->corps_name; ?></td>
                        <td><?php echo $row->ship_name; ?></td>
                        <td><?php echo $row->viewable == 't' ? 'YES' : 'NO'; ?></td>
                        <td class="action"> <a href="<?php echo base_url(); ?>admin/ship_viewability_ctrl/edit/<?php echo $row->corps_id ?>/<?php echo $row->ship_id ?>" class="edit">Edit</a> 
                            <a href="<?php echo base_url(); ?>admin/ship_viewability_ctrl/delete/<?php echo $row->corps_id ?>/<?php echo $row->ship_id ?>" class="delete">Delete</a></td>

                    </tr>
                    <?php
                }
            }
            ?>

        </tbody>
    </table>	
    <h3>Ship View Ability Data</h3>
    <form action="<?php echo base_url() ?>admin/ship_viewability_ctrl/save" method="post" class="" id="addShipView">
        <ul class="form-admin">
            <li>
                <label>Corps * </label>
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
            	<div class="clear"></div>
			</li>
            <li>
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
            	<div class="clear"></div>
			</li>
            <li>
                <label>Viewable</label>
                <div class="form-data-radio">
                    <label>
                        <input type="radio" name="viewable" value="TRUE" <?php if (!empty($obj)) echo $obj->viewable == 't' ? 'checked' : ''; ?> />Ya
                    </label>
                    <label>
                        <input type="radio" name="viewable" value="FALSE" <?php if (!empty($obj)) echo $obj->viewable == 't' ? '' : 'checked'; ?> />Tidak
                    </label>
                </div>

            	<div class="clear"></div>
			</li>

            <li>
                <input class="button-form" type="submit" value="<?php if (empty($obj)) echo 'Save'; else echo 'Edit'; ?> ">
                <input class="button-form" type="reset" value="Cancel">
            	<div class="clear"></div>
			</li>
        </ul>
    </form>
</div>
<div class="clear"></div>
