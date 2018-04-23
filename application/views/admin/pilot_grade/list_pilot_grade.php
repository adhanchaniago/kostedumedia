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
                    $('input class="form-admin"[type=text]').prop('readonly',false);
                    return false;
                }else{
                    var form = $('input class="form-admin"[type=submit]').closest("form");
                    form.submit();
                }
            });

            $('#cancelBtn').click(function(){
                window.location = '<?php echo base_url() ?>admin/pilot_grade_ctrl'
            });
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#pilotGradeAdd").validate({
            //idv: { required: true, regex: "/^(\d{3})TN(\d{4})$/" },
            rules:{
                plev_id: {required : true}
            },
            messages:{
                plev_id: "required"
            }
        });
        $('.delete').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Pilot Grade"></div>')
            .html('<li>All item related to Pilot Grade will be deleted to ! Are you sure ?	<div class="clear"></class>
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
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">pilot_grade</a></h2>

<div id="main">
    <p class="tit-form">Daftar Pangkat Pilot</p>
    <table class="tab-admin" cellpadding="0" cellspacing="0">
        <thead>
            <tr class="tittab">
                <td class="header">No</th>						
                <td class="header" style="cursor: pointer ;">ID</th>
                <td class="header" style="cursor: pointer ;">Nama</th>
                <td class="header delete">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($pilot_grade)) {
                foreach ($pilot_grade as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->plev_id; ?></td>
                        <td><?php echo $row->plev_name; ?></td>
                        <td class="action"> <a href="<?php echo base_url(); ?>admin/pilot_grade_ctrl/edit/<?php echo $row->plev_id ?>" class="edit">Edit</a> 
                            <a href="<?php echo base_url(); ?>admin/pilot_grade_ctrl/delete/<?php echo $row->plev_id ?>" class="delete">Delete</a></td>

                    </tr>
                <?php
                }
            }
            ?>

        </tbody>
    </table>

    <p class="tit-form">Data Pangkat Pilot</p>
    <form action="<?php echo base_url() ?>admin/pilot_grade_ctrl/save" method="post" class="jNice" id="pilotGradeAdd">
        <ul class="form-admin">
            <li>
                <label>ID * </label>
                <input class="form-admin" name="plev_id" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->plev_id; ?>" <?php if (!empty($obj)) echo "disabled"; ?>>
<?php echo form_error('plev_id'); ?>
                <?php if (!empty($obj)){?>
                <input class="form-admin" type="hidden" name="plev_id" value="<?php echo $obj->plev_id; ?>"
                <?php } ?>
            	<div class="clear"></class>
			</li>
            <li>
                <label>Nama * </label>
                <input class="form-admin" name="plev_name" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->plev_name; ?>" >
<?php echo form_error('plev_name'); ?>						<div class="clear"></class>
			</li>

            <li>
                <input class="button-form" type="submit" value="<?php if (empty($obj)) echo 'Save'; else echo 'Edit'; ?> ">
                <input class="button-form" type="reset" value="Cancel">
            	<div class="clear"></class>
			</li>
        </ul>
    </form>
</div>
<div class="clear"></div>
