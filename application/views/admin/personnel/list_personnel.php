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
                window.location = '<?php echo base_url() ?>admin/personnel_ctrl'
            });
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#personnelAdd").validate({
            rules:{
                ship_id: "required",
                psntype_id: "required",
                psnreff_nrp: "required",
                psn_value: "required"
            },
            messages:{
                ship_id: "required",
                psntype_id: "required",
                psnreff_nrp: "required",
                psn_value: "required"
            }
        });
        $('.delete').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Personnel"></div>')
            .html('<p>All item related to Personnel will be deleted to ! Are you sure ?</p>').dialog({
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
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if(!((charCode>=48&&charCode<=57)|| (charCode==46) || (charCode==8) || (charCode==9)))
            return false;

        return true;
    }
</script>
<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">personnel</a></h2>

<div id="main">
    <h3>List personnel</h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="header">No</th>						
                <th class="header" style="cursor: pointer ;">Ship Name</th>
                <th class="header" style="cursor: pointer ;">Type</th>
                <th class="header" style="cursor: pointer ;">NRP</th>
                <th class="header" style="cursor: pointer ;">Personnel Value</th>
                <th class="header delete">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($personnel)) {
                foreach ($personnel as $row) {
                    ?>
                    <tr class="<?php echo alternator("", "odd"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->ship_name; ?></td>
                        <td><?php echo $row->psntype_desc; ?></td>
                        <td><?php echo $row->psnreff_nrp; ?></td>
                        <td><?php echo $row->psn_value; ?></td>
                        <td class="action"> <a href="<?php echo base_url(); ?>admin/personnel_ctrl/edit/<?php echo $row->ship_id ?>/<?php echo $row->psntype_id ?>" class="edit">Edit</a> 
                            <a href="<?php echo base_url(); ?>admin/personnel_ctrl/delete/<?php echo $row->ship_id ?>/<?php echo $row->psntype_id ?>" class="delete">Delete</a></td>

                    </tr>
                <?php
                }
            }
            ?>

        </tbody>
    </table>	
    <!--<h3>personnel Data</h3>
    <form action="<?php echo base_url() ?>admin/personnel_ctrl/save" method="post" class="jNice" id="personnelAdd">
        <fieldset>
            <p>
                <label>Ship*</label>
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
                <label>Personnel Type*</label>
                <select name="psntype_id">
                    <option value="" selected>-Select Personnel Type-</option>
                    <?php foreach ($personnel_type as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->psntype_id == $row->psntype_id) { ?>
                            <option value="<?php echo $row->psntype_id ?>" selected><?php echo $row->psntype_desc ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->psntype_id ?>"><?php echo $row->psntype_desc ?></option>
                        <?php } ?>
<?php } ?>
                </select>
            </p>
            <p>
                <label>Personnel NRP*</label>
                <select name="psnreff_nrp">
                    <option value="" selected>-Select Personnel NRP-</option>
                    <?php foreach ($personnel_reff as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->psnreff_nrp == $row->psnreff_nrp) { ?>
                            <option value="<?php echo $row->psnreff_nrp ?>" selected><?php echo $row->psnreff_name ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->psnreff_nrp ?>"><?php echo $row->psnreff_name ?></option>
                        <?php } ?>
<?php } ?>
                </select>
            </p>
            <p>
                <label>Personnel Value*</label>
                <input name="psn_value" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->psn_value; ?>" >
<?php echo form_error('psn_value'); ?>					</p>

            <p>
                <input type="submit" value="<?php if (empty($obj)) echo 'Save'; else echo 'Edit'; ?> ">
                <input type="reset" value="Cancel">
            </p>
        </fieldset>
    </form>-->
</div>
<div class="clear"></div>
