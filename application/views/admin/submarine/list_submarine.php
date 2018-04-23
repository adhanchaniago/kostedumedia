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
                window.location = '<?php echo base_url() ?>admin/submarine_ctrl'
            });
        });
    </script>
<?php } ?>
<div id="main">
<p class="tit-form">List Kapal Selam</p>
<table class="tab-admin">

    <tr class="tittab">
        <td class="header">No</th>						
        <td class="header" style="cursor: pointer ;">Nomor Lambung</th>
        <td class="header" style="cursor: pointer ;">Nama</th>
        <td class="header" style="cursor: pointer ;">Lattitude</th>
        <td class="header" style="cursor: pointer ;">Longitude</th>
        <td class="header" style="cursor: pointer ;">Jarak Tempuh</th>
        <td class="header delete">Aksi</th>
    </tr>



    <?php
    $count = 1;
    if (!empty($submarine)) {
        foreach ($submarine as $row) {
            ?>
            <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                <td><?php echo $count++; ?></td>
                <td><?php echo $row->sbm_hull_number; ?></td>
                <td><?php echo $row->sbm_name; ?></td>
                <td><?php echo $row->sbm_lat; ?></td>
                <td><?php echo $row->sbm_lon; ?></td>
                <td><?php echo $row->sbm_cruising_range; ?></td>
                <td class="action"> <a href="<?php echo base_url(); ?>admin/submarine_ctrl/edit/<?php echo $row->sbm_id ?>" class="tab-edit">Edit</a> 
                    <a href="<?php echo base_url(); ?>admin/submarine_ctrl/delete/<?php echo $row->sbm_id ?>" class="tab-delete">Delete</a></td>

            </tr>
        <?php
        }
    }
    ?>


</table>	

<p class="tit-form">Data Kapal Selam</p>
<form action="<?php echo base_url() ?>admin/submarine_ctrl/save" method="post" class="">
    <ul class="form-admin">
        <?php if (!empty($obj)) { ?>
            <input class="form-admin" type="hidden" name="sbm_id" value="<?php if (!empty($obj)) echo $obj->sbm_id; ?>" />
        <?php } ?>
        <li>
            <label>Nomor Lambung * </label>
            <input class="form-admin" name="sbm_hull_number" type="text" class="text-medium"
                   value="<?php if (!empty($obj)) echo $obj->sbm_hull_number; ?>" >
<?php echo form_error('sbm_hull_number'); ?>					
            <div class="clear"></div>
        </li>
        <li>
            <label>Nama * </label>
            <input class="form-admin" name="sbm_name" type="text" class="text-medium" id="submarine_name"
                   value="<?php if (!empty($obj)) echo $obj->sbm_name; ?>" >
<?php echo form_error('sbm_name'); ?>					
            <div class="clear"></div>
        </li>
        <li>
            <label>Penjelasan * </label>
            <input class="form-admin" name="sbm_description" type="text" class="text-medium"
                   value="<?php if (!empty($obj)) echo $obj->sbm_description; ?>" >
<?php echo form_error('sbm_description'); ?>					
            <div class="clear"></div>
        </li>
        <li>
            <label>Lattitude * </label>
            <input class="form-admin two-digit" name="sbm_dlat" maxlength="3"   maxlength="3"type="text" class="text-medium" <?php if (!empty($obj) && $obj->sbm_isrealtime) echo "readonly" ?>
                   value="<?php if (!empty($obj)) echo geoComponent($obj->sbm_lat, 'd'); ?>" >

            <input class="form-admin two-digit" name="sbm_mlat" maxlength="2"   type="text" class="text-medium" <?php if (!empty($obj) && $obj->sbm_isrealtime) echo "readonly" ?>
                   value="<?php if (!empty($obj)) echo geoComponent($obj->sbm_lat, 'm'); ?>" >

            <input class="form-admin two-digit" name="sbm_slat" maxlength="2"   type="text" class="text-medium" <?php if (!empty($obj) && $obj->sbm_isrealtime) echo "readonly" ?>
                   value="<?php if (!empty($obj)) echo geoComponent($obj->sbm_lat, 's'); ?>" >

            <?php
            $stat = '';
            if (!empty($obj) && $obj->sbm_isrealtime)
                $stat = 'disabled="disabled"';

            if (!empty($obj))
                echo form_dropdown('sbm_rlat', array(1 => 'U', -1 => 'S'), geoComponent($obj->sbm_lat, 'r'), $stat);
            else
                echo form_dropdown('sbm_rlat', array(1 => 'U', -1 => 'S'), '', $stat);
            ?>

<?php echo form_error('sbm_lat'); ?>

            <div class="clear"></div>
        </li>
        <li>
            <label>Longitude * </label>
            <input class="form-admin two-digit" name="sbm_dlon" maxlength="3"   type="text" class="text-medium" <?php if (!empty($obj) && $obj->sbm_isrealtime) echo "readonly" ?>
                   value="<?php if (!empty($obj)) echo geoComponent($obj->sbm_lon, 'd'); ?>" >

            <input class="form-admin two-digit" name="sbm_mlon" maxlength="2"  maxlength="2" type="text" class="text-medium" <?php if (!empty($obj) && $obj->sbm_isrealtime) echo "readonly" ?>
                   value="<?php if (!empty($obj)) echo geoComponent($obj->sbm_lon, 'm'); ?>" >

            <input class="form-admin two-digit" name="sbm_slon" maxlength="2"  maxlength="2" type="text" class="text-medium" <?php if (!empty($obj) && $obj->sbm_isrealtime) echo "readonly" ?>
                   value="<?php if (!empty($obj)) echo geoComponent($obj->sbm_lon, 's'); ?>" >

            <?php
            $stat = '';
            if (!empty($obj) && $obj->sbm_isrealtime)
                $stat = 'disabled="disabled"';

            if (!empty($obj))
                echo form_dropdown('sbm_rlon', array(1 => 'T', -1 => 'B'), geoComponent($obj->sbm_lon, 'r'), $stat);
            else
                echo form_dropdown('sbm_rlon', array(1 => 'T', -1 => 'B'), '', $stat);
            ?>


<?php echo form_error('sbm_lon'); ?>

            <div class="clear"></div>
        </li>

        <li>
            <label>Realtime * </label>

            <div class="form-admin-radio">
                <label>
                    <input type="radio" name="mar_isrealtime" value="TRUE" <?php if (!empty($obj) && $obj->sbm_isrealtime) echo "checked" ?> >Yes
                    <input type="radio" name="mar_isrealtime" value="FALSE" <?php if (!empty($obj) && !$obj->sbm_isrealtime) echo "checked" ?> >No
                </label>
            </div>
            <div class="clear"></div>
        </li>
        <li>
            <label>Jarak Tempuh * </label>
            <input class="form-admin" name="sbm_cruising_range" type="text" class="text-medium"
                   value="<?php if (!empty($obj)) echo $obj->sbm_cruising_range; ?>" >
<?php echo form_error('sbm_cruising_range'); ?>					
            <div class="clear"></div>
        </li>
    </ul>
<script type="text/javascript">
            var rowTotal = <?php
                if (!empty($submarine_logistics)) {
                    echo count($submarine_logistics);
                } else {
                    echo 0;
                }
                ?>;
            
                    $(document).ready(function(){
                        $("#addLog").click(function(){
                            if($('#logitem_id').attr("disabled")=="disabled"){
                                var editNumber = $('#editNumber').val();
                                var logValue = $('#submarinelog_value').val();
                                $('#submarineValue_'+editNumber+'').val(logValue);
                                $('#submarineValue_td_'+editNumber+'').text(logValue);
                            }else{
                                var rowCount = $('#addStationLogistic').find('tr').size();
                                var tableClass = (rowCount%2==0)?'row-two':'row-one';
                                var logId = $('#logitem_id option:selected').val();
                                var logText = $('#logitem_id option:selected').text();
                                var logValue = $('#submarinelog_value').val();
                                var aeroPlane = $('#submarine_name').val();
                                if(logId!=''){
                                    if(isExist(logText)){
                                        alert('item logistik sudah ditambahkan, silahkan edit untuk mengubah nilai')
                                    }else {
                                        rowTotal = rowTotal + 1;
                                        $("#totalRow").val(rowTotal);
                                               
                                        var row1 = '<tr class='+tableClass+' id="logitem_'+logText+'"><td>'+rowCount+'</td>';
                                        var row2 = '<td>'+logText+'</td>'+'<input type="hidden" name="submarineLog_'+rowTotal+'" id="submarineLog_'+rowTotal+'" value="'+logId+'" />';
                                        var row3 = '<td>'+aeroPlane+'</td>';
                                        var row4 = '<td id=submarineValue_td_'+rowTotal+'>'+logValue+'</td>'+'<input type="hidden" name="submarineValue_'+rowTotal+'" id="submarineValue_'+rowTotal+'" value="'+logValue+'" />';
                                        var action = '<td class="action"><a href="javascript:void(0);" onClick="editLog(\''+logId+'\',\''+logValue+'\',\''+rowTotal+'\')" id="editLog" class="tab-edit">Edit</a><a href="javascript:void(0);" id="deleteLog" class="tab-delete">Delete</a></td></tr>';
                                               
                                        $("#addStationLogistic").append(row1+row2+row3+row4+action);
                                        $('#submarinelog_value').val('');
                                        $('#logitem_id').val('');
                                    }
                                }
                            }
                        });
    
                        $("#addStationLogistic").on('click', '#deleteLog', function(){
                            $(this).parent().parent().remove();
                            rowTotal = rowTotal - 1;
                            $("#totalRow").val(rowTotal);
                        });
                    });
            
                    function editLog(logId,logValue,editNumber){
                        $('#submarinelog_value').val(logValue);
                        $('#logitem_id').val(logId);
                        $('#editNumber').val(editNumber);
                        $("#logitem_id").attr('disabled',true);
                    }
                    function isExist(strd){
                        console.log($('tr[id*=logitem]').length)
                        testme=false;
                        $('tr[id*=logitem]').each(function(){
                            console.log($('td:nth(1)',$(this)).html());
                            console.log($('td:nth(2)',$(this)).html());
                            if($('td:nth(1)',$(this)).html()===strd) {
                                testme=true;            
                            }   
                        })
                        return testme;
                    }
        </script>
        <!--used to store logistic data-->
        <p class="tit-form">Daftar Logistik Kapal Selam</p>
        <table id="addStationLogistic" class="tab-admin">
            <tr class="tittab">
                <td>No</td>
                <td>Logistic Item</td>
                <td>Pangkalan</td>
                <td>Value</td>
                <td>Action</td>
            </tr>
            <?php if (!empty($submarine_logistics)) { ?>
                <?php
                $count = 1;
                if (!empty($submarine_logistics)) {
                    foreach ($submarine_logistics as $row) {
                        ?>
                        <tr class="<?php echo alternator("row-one", "row-two"); ?>" id="logitem_<?php echo $row->logitem_desc ?>">
                            <td><?php echo $count; ?></td>
                            <td><?php echo $row->logitem_desc; ?></td>
                        <input type="hidden" name="submarineLog_<?php echo $count ?>" id="submarineLog_<?php echo $count ?>" value="<?php echo $row->logitem_id ?>" />
                        <td><?php echo $row->sbm_name; ?></td>
                        <td id=submarineValue_td_<?php echo $count ?>><?php echo $row->sbmlog_value; ?></td>
                        <input type="hidden" name="submarineValue_<?php echo $count ?>" id="submarineValue_<?php echo $count ?>" value="<?php echo $row->sbmlog_value ?>" />
                        <td class="action"> 
                            <a href="javascript:void(0);" onClick="editLog('<?php echo $row->logitem_id ?>','<?php echo $row->sbmlog_value ?>','<?php echo $count ?>')" id="editLog" class="tab-edit">Edit</a> 
                            <a href="javascript:void(0);" id="deleteLog" class="tab-delete">Delete</a>
                        </td>
                        </tr>
                        <?php
                        $count++;
                    }
                }
                ?>

            <?php } ?>
        </table>

        <p class="tit-form">Data Logistik Kapal Selam</p>
        <ul class="form-admin">
            <li>
                <label>Item Logistik * </label>
                <select id="logitem_id" name="logitem_id" <?php if (!empty($obj_logistic)) echo "disabled"; ?>>
                    <option value="" selected>-Select Logistic Item-</option>
                    <?php foreach ($logistic_item as $row) { ?>
                        <?php if ((!empty($obj_logistic)) && $obj_logistic->logitem_id == $row->logitem_id) { ?>
                            <option value="<?php echo $row->logitem_id ?>" selected><?php echo $row->logitem_desc ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->logitem_id ?>"><?php echo $row->logitem_desc ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <div class="clear"></div>
            </li>
            <li>
                <label>Kondisi * </label>
                <input class="form-admin" name="submarinelog_value" type="text" class="text-medium" id="submarinelog_value" value="" >
                <div class="clear"></div>
            </li>
            <input type="hidden" value="" id="editNumber"/>
            <input type="hidden" value="<?php if (!empty($submarine_logistics)) echo count($submarine_logistics) ?>" id="totalRow" name="totalRow"/>
            <li>
                <label></label>
                <input class="button-form green" id="addLog" type="button" value="<?php if (empty($obj)) echo 'Simpan'; else echo 'Tambah Logistik'; ?>" >
                <input class="button-form red" id="cancelLog" type="button" value="Cancel">
                <div class="clear"></div>
            </li>
        </ul>
    
    <p class="tit-form"></p>
    <label>&nbsp;</label>
    <input class="button-form" type="submit" value="<?php if (empty($obj)) echo 'Save'; else echo 'Edit'; ?> ">
    <input class="button-form" type="reset" value="Cancel">
    <div class="clear"></div>
    </form>
</div>
<div class="clear"></div>
