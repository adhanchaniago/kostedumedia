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
                window.location = '<?php echo base_url() ?>admin/report_type_ctrl'
            });
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#addReportType").validate({
            rules:{
                rt_desc: "required",
                rt_active: "required"
            },
            messages:{
                rt_desc: "required",
                rt_active: "required"
            }
        });
        $('.delete').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Report Type"></div>')
            .html('<p>All item related to Report Type will be deleted to ! Are you sure ?</p>').dialog({
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
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">Report Type</a></h2>

<div id="main">
    <h3>List Report Type</h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="header">No</th>						
                <th class="header" style="cursor: pointer ;">Report Type Description</th>
                <th class="header" style="cursor: pointer ;">Report Type Status</th>
                <th class="header delete">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($report_type)) {
                foreach ($report_type as $row) {
                    ?>
                    <tr class="<?php echo alternator("", "odd"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->rt_desc; ?></td>
                        <td><?php echo $row->rt_active; ?></td>
                        <td class="action"> <a href="<?php echo base_url(); ?>admin/report_type_ctrl/edit/<?php echo $row->rt_id ?>" class="edit">Edit</a> 
                            <a href="<?php echo base_url(); ?>admin/report_type_ctrl/delete/<?php echo $row->rt_id ?>" class="delete">Delete</a></td>

                    </tr>
                <?php
                }
            }
            ?>

        </tbody>
    </table>	
    <h3>report_type Data</h3>
    <form action="<?php echo base_url() ?>admin/report_type_ctrl/save" method="post" class="" id="addReportType">
        <?php if (!empty($obj)) { ?>
            <input type="hidden" name="rt_id" value="<?php if (!empty($obj)) echo $obj->rt_id; ?>" />
        <?php } ?>
        <fieldset>
            <p>
                <label>Report Type Description * </label>
                <input name="rt_desc" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->rt_desc; ?>" >
<?php echo form_error('rt_desc'); ?>					</p>
            <p>
                <label>Report Type Status</label>
                <input type="radio" name="rt_active" value="TRUE" <?php if (!empty($obj)) echo $obj->rt_active == 't' ? 'checked' : ''; ?> />Active<br/>
                <input type="radio" name="rt_active" value="FALSE" <?php if (!empty($obj)) echo $obj->rt_active == 't' ? '' : 'checked'; ?> />Not Active
            </p>
            <p>
                <input type="submit" value="<?php if (empty($obj)) echo 'Save'; else echo 'Edit'; ?> ">
                <input type="reset" value="Cancel">
            </p>
        </fieldset>
    </form>
</div>
<div class="clear"></div>
