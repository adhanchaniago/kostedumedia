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
                window.location = '<?php echo base_url() ?>admin/user_role_ctrl'
            });
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#addUserRole").validate({
            rules:{
                user_id: "required",
                role_id: "required"
            },
            messages:{
                user_id: "required",
                role_id: "required"
            }
        });
        $('.delete').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="User Role"></div>')
            .html('<p>All item related to user role will be deleted to ! Are you sure ?</p>').dialog({
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
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">User Role</a></h2>

<div id="main">
    <h3>List User Role</h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="header">No</th>						
                <th class="header" style="cursor: pointer ;">user_id</th>
                <th class="header" style="cursor: pointer ;">role_id</th>
                <th class="header delete">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($user_role)) {
                foreach ($user_role as $row) {
                    ?>
                    <tr class="<?php echo alternator("", "odd"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->username; ?></td>
                        <td><?php echo $row->role_name; ?></td>
                        <td class="action"> <a href="<?php echo base_url(); ?>admin/user_role_ctrl/edit/<?php echo $row->user_id ?>/<?php echo $row->role_id ?>" class="edit">Edit</a> 
                            <a href="<?php echo base_url(); ?>admin/user_role_ctrl/delete/<?php echo $row->user_id ?>/<?php echo $row->role_id ?>" class="delete">Delete</a></td>

                    </tr>
                    <?php
                }
            }
            ?>

        </tbody>
    </table>	
    <h3>user_role Data</h3>
    <form action="<?php echo base_url() ?>admin/user_role_ctrl/save" method="post" id="addUserRole">
        <fieldset>
            <p>
                <label>User</label>
                <select name="user_id" <?php if (!empty($obj)) echo "disabled"; ?>>
                    <option value="" selected>-Select User-</option>
                    <?php foreach ($users as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->user_id == $row->user_id) { ?>
                            <option value="<?php echo $row->user_id ?>" selected><?php echo $row->username ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->user_id ?>"><?php echo $row->username ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if (!empty($obj)){?>
                <input type="hidden" name="user_id" value="<?php echo $obj->user_id; ?>"/>
                <?php } ?>
            </p>
            <p>
                <label>Role</label>
                <select name="role_id">
                    <option value="" selected>-Select Role-</option>
                    <?php foreach ($role as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->role_id == $row->role_id) { ?>
                            <option value="<?php echo $row->role_id ?>" selected><?php echo $row->role_name ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->role_id ?>"><?php echo $row->role_name ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </p>

            <p>
                <input type="submit" value="<?php if (empty($obj)) echo 'Save'; else echo 'Edit'; ?> ">
                <input type="reset" value="Cancel">
            </p>
        </fieldset>
    </form>
</div>
<div class="clear"></div>
