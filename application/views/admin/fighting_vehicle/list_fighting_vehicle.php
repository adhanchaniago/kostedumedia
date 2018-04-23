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
                window.location = '<?php echo base_url() ?>admin/fighting_vehicle_ctrl'
            });
        });
    </script>
<?php } ?>
<div id="main" >
    <p class="tit-form">List Kendaraan Tempur</p class="tit-form">
    <table class="tab-admin">
        <tdead>
            <tr class="tittab">
                <td class="header">No</th>
                <td class="header" style="cursor: pointer ;">Nama</th>
                <td class="header" style="cursor: pointer ;">Lattitude</th>
                <td class="header" style="cursor: pointer ;">Longitude</th>
                <td class="header" style="cursor: pointer ;">Kecepatan</th>
                <td class="header" style="cursor: pointer ;">Jumlah Penumpang</th>
                <td class="header delete">Actions</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                if (!empty($fighting_vehicle)) {
                    foreach ($fighting_vehicle as $row) {
                        ?>
                        <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $row->fv_name; ?></td>
                            <td><?php echo $row->fv_lat; ?></td>
                            <td><?php echo $row->fv_lon; ?></td>
                            <td><?php echo $row->fv_speed; ?></td>
                            <td><?php echo $row->fv_passanger_capacity; ?></td>
                            <td class="action"> <a href="<?php echo base_url(); ?>admin/fighting_vehicle_ctrl/edit/<?php echo $row->fv_id ?>" class="tab-edit">Edit</a> 
                                <a href="<?php echo base_url(); ?>admin/fighting_vehicle_ctrl/delete/<?php echo $row->fv_id ?>" class="tab-delete">Delete</a></td>

                        </tr>
                        <?php
                    }
                }
                ?>

            </tbody>
    </table>	
    <p class="tit-form">Data Kendaraan Tempur</p class="tit-form">
    <form action="<?php echo base_url() ?>admin/fighting_vehicle_ctrl/save" method="post" class="jNice">
        <ul class="form-admin">
            <?php if (!empty($obj)) { ?>
                <input class="form-admin" type="hidden" name="fv_id" value="<?php if (!empty($obj)) echo $obj->fv_id; ?>" />
            <?php } ?>

            <li>
                <label>Nama * </label>
                <input class="form-admin" name="fv_name" type="text" class="text-medium" id="fv_name"
                       value="<?php if (!empty($obj)) echo $obj->fv_name; ?>" >
                       <?php echo form_error('fv_name'); ?>					
                <div class="clear"></div>
            </li>
            <li>
                <label>Deskripsi * </label>
                <textarea class="form-admin" rows="1" cols="1" name="fv_desc"><?php if (!empty($obj)) echo $obj->fv_desc; ?></textarea>

                <div class="clear"></div>
            </li>
            <li>
                <label>Kecepatan * </label>
                <input class="form-admin" name="fv_speed" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->fv_speed; ?>" >
                       <?php echo form_error('fv_speed'); ?>					
                <div class="clear"></div>
            </li>
            <li>
                <label>Kapasitas Penumpang * </label>
                <input class="form-admin" name="fv_passanger_capacity" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->fv_passanger_capacity; ?>" >
                       <?php echo form_error('fv_passanger_capacity'); ?>					
                <div class="clear"></div>
            </li>
            <li>
                <label>Lattitude * </label>
                <input class="form-admin two-digit" name="fv_dlat"  maxlength="3" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo geoComponent($obj->fv_lat, 'd'); ?>" >

                <input class="form-admin two-digit" name="fv_mlat" maxlength="2" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo geoComponent($obj->fv_lat, 'm'); ?>" >

                <input class="form-admin two-digit" name="fv_slat" maxlength="2" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo geoComponent($obj->fv_lat, 's'); ?>" >
                       <?php
                       if (!empty($obj))
                           echo form_dropdown('fv_rlat', array(1 => 'U', -1 => 'S'), geoComponent($obj->fv_lat, 'r'));
                       else
                           echo form_dropdown('fv_rlat', array(1 => 'U', -1 => 'S'));
                       ?>

                <?php echo form_error('fv_lat'); ?>					

                <div class="clear"></div>
            </li>
            <li>
                <label>Longitude * </label>
                <input class="form-admin two-digit" name="fv_dlon" maxlength="3"   type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo geoComponent($obj->fv_lon, 'd'); ?>" >

                <input class="form-admin two-digit" name="fv_mlon" maxlength="2"  maxlength="2" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo geoComponent($obj->fv_lon, 'm'); ?>" >

                <input class="form-admin two-digit" name="fv_slon" maxlength="3"  maxlength="2" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo geoComponent($obj->fv_lon, 's'); ?>" >
                       <?php
                       if (!empty($obj))
                           echo form_dropdown('fv_rlon', array(1 => 'T', -1 => 'B'), geoComponent($obj->fv_lon, 'r'));
                       else
                           echo form_dropdown('fv_rlon', array(1 => 'T', -1 => 'B'));
                       ?>

                <?php echo form_error('fv_lon'); ?>

                <div class="clear"></div>
            </li>
            <li>
                <label>Realtime *</label>
                <div class="form-admin-radio">
                    <label>
                        <input type="radio" name="fv_isrealtime" value="TRUE" <?php if (!empty($obj)) echo $obj->fv_isrealtime == 't' ? 'checked' : ''; ?> />Ya<br/>
                        <div class="clear"></div>
                    </label>
                    <label>
                        <input  type="radio" name="fv_isrealtime" value="FALSE" <?php if (!empty($obj)) echo $obj->fv_isrealtime == 't' ? '' : 'checked'; ?> />Tidak
                        <div class="clear"></div>
                    </label>
                </div>
                <div class="clear"></div>
            </li>

            <li>
                <label>Tanggal Mulai Penggunaan * </label>
                <input class="form-admin" name="fv_establish_date" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->fv_establish_date; ?>" >
                       <?php echo form_error('fv_establish_date'); ?>					
                <div class="clear"></div>
            </li>
            <li>
                <label>Masa Berlaku * </label>
                <input class="form-admin" name="fv_lifespan" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->fv_lifespan; ?>" > Tahun
                       <?php echo form_error('fv_lifespan'); ?>

                <div class="clear"></div>
            </li>



            <li>
                <?php echo form_error('fv_lon'); ?>					

                <div class="clear"></div>
            </li>
        </ul>
        <script type="text/javascript">
            var rowTotal = <?php
                if (!empty($fvehicle_logistics)) {
                    echo count($fvehicle_logistics);
                } else {
                    echo 0;
                }
                ?>;
            
                    $(document).ready(function(){
                        $("#addLog").click(function(){
                            if($('#logitem_id').attr("disabled")=="disabled"){
                                var editNumber = $('#editNumber').val();
                                var logValue = $('#fvlog_value').val();
                                $('#fvValue_'+editNumber+'').val(logValue);
                                $('#fvValue_td_'+editNumber+'').text(logValue);
                            }else{
                                var rowCount = $('#addStationLogistic').find('tr').size();
                                var tableClass = (rowCount%2==0)?'row-two':'row-one';
                                var logId = $('#logitem_id option:selected').val();
                                var logText = $('#logitem_id option:selected').text();
                                var logValue = $('#fvlog_value').val();
                                var aeroPlane = $('#fv_name').val();
                                if(logId!=''){
                                    if(isExist(logText)){
                                        alert('item logistik sudah ditambahkan, silahkan edit untuk mengubah nilai')
                                    }else {
                                        rowTotal = rowTotal + 1;
                                        $("#totalRow").val(rowTotal);
                                               
                                        var row1 = '<tr class='+tableClass+' id="logitem_'+logText+'"><td>'+rowCount+'</td>';
                                        var row2 = '<td>'+logText+'</td>'+'<input type="hidden" name="fvLog_'+rowTotal+'" id="fvLog_'+rowTotal+'" value="'+logId+'" />';
                                        var row3 = '<td>'+aeroPlane+'</td>';
                                        var row4 = '<td id=fvValue_td_'+rowTotal+'>'+logValue+'</td>'+'<input type="hidden" name="fvValue_'+rowTotal+'" id="fvValue_'+rowTotal+'" value="'+logValue+'" />';
                                        var action = '<td class="action"><a href="javascript:void(0);" onClick="editLog(\''+logId+'\',\''+logValue+'\',\''+rowTotal+'\')" id="editLog" class="tab-edit">Edit</a><a href="javascript:void(0);" id="deleteLog" class="tab-delete">Delete</a></td></tr>';
                                               
                                        $("#addStationLogistic").append(row1+row2+row3+row4+action);
                                    }
                                }
                            }
                            $('#fvlog_value').val('');
                            $('#logitem_id').val('');
                            $("#logitem_id").attr('disabled',false);
                        });
    
                        $("#addStationLogistic").on('click', '#deleteLog', function(){
                            $(this).parent().parent().remove();
                            rowTotal = rowTotal - 1;
                            $("#totalRow").val(rowTotal);
                        });
                    });
            
                    function editLog(logId,logValue,editNumber){
                        $('#fvlog_value').val(logValue);
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
        <p class="tit-form">Daftar Logistik Kendaraan Tempur</p>
        <table id="addStationLogistic" class="tab-admin">
            <tr class="tittab">
                <td>No</td>
                <td>Logistic Item</td>
                <td>Kapal</td>
                <td>Value</td>
                <td>Action</td>
            </tr>
            <?php if (!empty($fvehicle_logistics)) { ?>
                <?php
                $count = 1;
                if (!empty($fvehicle_logistics)) {
                    foreach ($fvehicle_logistics as $row) {
                        ?>
                        <tr class="<?php echo alternator("row-one", "row-two"); ?>" id="logitem_<?php echo $row->logitem_desc ?>">
                            <td><?php echo $count; ?></td>
                            <td><?php echo $row->logitem_desc; ?></td>
                        <input type="hidden" name="fvLog_<?php echo $count ?>" id="fvLog_<?php echo $count ?>" value="<?php echo $row->logitem_id ?>" />
                        <td><?php echo $row->fv_name; ?></td>
                        <td id=fvValue_td_<?php echo $count ?>><?php echo $row->fvehicle_value; ?></td>
                        <input type="hidden" name="fvValue_<?php echo $count ?>" id="fvValue_<?php echo $count ?>" value="<?php echo $row->fvehicle_value ?>" />
                        <td class="action"> 
                            <a href="javascript:void(0);" onClick="editLog('<?php echo $row->logitem_id ?>','<?php echo $row->fvehicle_value ?>','<?php echo $count ?>')" id="editLog" class="tab-edit">Edit</a> 
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

        <p class="tit-form">Data Logistik Kendaraan Tempur</p>
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
                <input class="form-admin" name="fvlog_value" type="text" class="text-medium" id="fvlog_value" value="" >
                <div class="clear"></div>
            </li>
            <input type="hidden" value="" id="editNumber"/>
            <input type="hidden" value="<?php if (!empty($fvehicle_logistics_logistics)) echo count($fvehicle_logistics_logistics) ?>" id="totalRow" name="totalRow"/>
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
