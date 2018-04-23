<script>
    function setShipCondition(ship_id) {
        var ship_dlat = $("#ship_dlat_" + ship_id).val();
        var ship_mlat = $("#ship_mlat_" + ship_id).val();
        var ship_slat = $("#ship_slat_" + ship_id).val();
        var ship_rlat = $("#ship_rlat_" + ship_id).val();

        var ship_dlon = $("#ship_dlon_" + ship_id).val();
        var ship_mlon = $("#ship_mlon_" + ship_id).val();
        var ship_slon = $("#ship_slon_" + ship_id).val();
        var ship_rlon = $("#ship_rlon_" + ship_id).val();

        var ship_location = $("#ship_location_" + ship_id).val();
        var ship_direction = $("#ship_direction_" + ship_id).val();
        var ship_speed = $("#ship_speed_" + ship_id).val();
        var ship_timestamp = $('select[name="ship_timestamp_' + ship_id + '"]').val();

        var operation_id = $("#operation_id").val();
        //var ship_cond = $("#shipcond_"+ship_id).val()
        $.post('<?php echo base_url() ?>admin/ship_ctrl/ops_update_', // request ke file load_data.php
                {ship_id: ship_id, ship_dlat: ship_dlat, ship_mlat: ship_mlat, ship_slat: ship_slat, ship_rlat: ship_rlat,
                    ship_dlon: ship_dlon, ship_mlon: ship_mlon, ship_slon: ship_slon, ship_rlon: ship_rlon, ship_location: ship_location,
                    ship_direction: ship_direction, ship_speed: ship_speed, ship_timestamp: ship_timestamp, operation_id: operation_id
                },
        function(data) {
            if (data == 'success') {
                alert("Perubahan posisi KRI berhasil disimpan.")
            } else {
                alert("Perubahan posisi KRI gagal disimpan.");
            }
        }
        );
    }

    function setAerCondition(aer_id) {
        var aer_dlat = $("#aer_dlat_" + aer_id).val();
        var aer_mlat = $("#aer_mlat_" + aer_id).val();
        var aer_slat = $("#aer_slat_" + aer_id).val();
        var aer_rlat = $("#aer_rlat_" + aer_id).val();

        var aer_dlon = $("#aer_dlon_" + aer_id).val();
        var aer_mlon = $("#aer_mlon_" + aer_id).val();
        var aer_slon = $("#aer_slon_" + aer_id).val();
        var aer_rlon = $("#aer_rlon_" + aer_id).val();

        var aer_location = $("#aer_location_" + aer_id).val();
        var aer_endurance = $("#aer_endurance_" + aer_id).val();
        var aer_speed = $("#aer_speed_" + aer_id).val();
        var aer_timestamp = $('select[name="aer_timestamp_' + aer_id + '"]').val();

        var operation_id = $("#operation_id").val();

        //var aer_cond = $("#aercond_" + aer_id).val()

        $.post('<?php echo base_url() ?>admin/aeroplane_ctrl/ops_update_', // request ke file load_data.php
                {aer_id: aer_id, aer_dlat: aer_dlat, aer_mlat: aer_mlat, aer_slat: aer_slat, aer_rlat: aer_rlat,
                    aer_dlon: aer_dlon, aer_mlon: aer_mlon, aer_slon: aer_slon, aer_rlon: aer_rlon, aer_location: aer_location,
                    aer_endurance: aer_endurance, aer_speed: aer_speed, aer_timestamp: aer_timestamp, operation_id: operation_id
                },
        function(data) {
            if (data == 'success') {
                alert("Perubahan posisi Pesud berhasil disimpan.")
            } else {
                alert("Perubahan posisi Pesud gagal disimpan.");
            }
        }
        );
    }

    function setMarCondition(mar_id) {
        var mar_dlat = $("#mar_dlat_" + mar_id).val();
        var mar_mlat = $("#mar_mlat_" + mar_id).val();
        var mar_slat = $("#mar_slat_" + mar_id).val();
        var mar_rlat = $("#mar_rlat_" + mar_id).val();

        var mar_dlon = $("#mar_dlon_" + mar_id).val();
        var mar_mlon = $("#mar_mlon_" + mar_id).val();
        var mar_slon = $("#mar_slon_" + mar_id).val();
        var mar_rlon = $("#mar_rlon_" + mar_id).val();
        
        var mar_location = $("#mar_location_"+mar_id).val();
        var mar_personel = $("#mar_personel_"+mar_id).val();
        var mar_matpur = $("#mar_matpur_"+mar_id).val();
        var mar_dpp = $("#mar_dpp_"+mar_id).val();
        
        var mar_timestamp = $('select[name="mar_timestamp_' + mar_id + '"]').val();
        
        var operation_id = $("#operation_id").val();
//        var mar_cond = $("#aercond_"+mar_id).val()

        $.post('<?php echo base_url() ?>admin/marines_ctrl/ops_update_', // request ke file load_data.php
                {mar_id: mar_id, mar_dlat: mar_dlat, mar_mlat: mar_mlat, mar_slat: mar_slat, mar_rlat: mar_rlat,
                    mar_dlon: mar_dlon, mar_mlon: mar_mlon, mar_slon: mar_slon, mar_rlon: mar_rlon,mar_location:mar_location,
                    mar_personel:mar_personel,mar_matpur:mar_matpur,mar_dpp:mar_dpp,mar_timestamp:mar_timestamp,operation_id:operation_id
                },
        function(data) {
            if (data == 'success') {
                alert("Perubahan posisi Marinir berhasil disimpan.")
            } else {
                alert("Perubahan posisi Marinir gagal disimpan.");
            }
        }
        );
    }
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (!((charCode >= 48 && charCode <= 57) || (charCode == 46) || (charCode == 8) || (charCode == 9)))
            return false;

        return true;
    }
    
    function setFinishedStatus(id,event){
		event.preventDefault();
		$('#dialog-confirm').show();
		$('#dialog-confirm').dialog({
			resizable : false,
			modal : true,
			width : 400,
			buttons : {
				"Ya" : function(){
					$(this).dialog("close");
					document.location = '<?php echo base_url()."admin/operation_ctrl/setOperationStatus/"; ?>'+id+'/2';
				},
				"Tidak" : function(){
					$(this).dialog("close");
				}
			}
		});
    }
</script>
<p class="tit-form">Keterangan Operasi</p>

<?php
	if($operations->opstatus_id==1){ //Jika status = berlangsung
?>
	<div id="dialog-confirm" title="Akhiri Operasi?" style="display:none;">
		<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
		Dengan menekan tombol "OK" di bawah ini, Anda akan mengakhiri operasi ini, lanjutkan?</p>
	</div>
	<a class="button-red" href="#" onclick="setFinishedStatus(<?php echo $operations->operation_id; ?>,event)"><b>Akhiri</b></a>
<?php } ?>
<div class="keterangan-ops">
    <ul>
        <li><strong><?php echo $operations->operation_name ?></strong></li>
        <li><label>Jenis Operasi</label>: <?php echo $ops_type[0]->level4 ?></li>
        <?php
        $kodal_ops = '';
        foreach ($kodal as $k) {
            $kodal_ops .= $k->kodaloperasi_desc . '/';
        }
        $kodal_ops = substr($kodal_ops, 0, -1);
        ?>
        <li><label>Kodal</label>: <?php echo $kodal_ops ?></li>
    </ul>
</div>

<br /><br />
<?php
$condition = array('1' => 'SIAP', '2' => 'SIAP PANGKALAN', '3' => 'TIDAK SIAP');
?>
<p class="tit-form">Komponen Unsur KRI</p>
<table class="tab-admin">
    <thead>
        <tr class="tittab">
            <td class="header" style="width: 5px;">No</td>						
            <td class="header" style="width: 10px;">Nomor Lambung</td>
            <td class="header" style="width: 100px;">Nama</td>
            <td class="header" style="width: 200px;">Lintang</td>
            <td class="header" style="width: 200px;">Bujur</td>
            <!--<td class="header" style="width: 20px;">Status</td>-->
            <td class="header" style="width: 100px;">Lokasi</td>
            <td class="header" style="width: 20px;">Arah</td>
            <td class="header" style="width: 20px;">Kecepatan</td>
            <td class="header" style="width: 20px;">Dislokasi Unsur</td>
            <td class="header" style="width: 20px;">Aksi</td>
        </tr>
    </thead>
    <tbody>
    <input type="hidden" value="<?php echo $operations->operation_id ?>" id="operation_id" />
    <?php
    $i = 1;
    foreach ($ships as $s) {
        ?>
        <tr class="<?php echo alternator("row-one", "row-two"); ?>">
            <td><?php echo $i; ?></td>
            <td><?php echo $s->ship_id ?></td>
            <td><?php echo $s->ship_name ?></td>
            <td style="width:150px;"><?php if ($s->ship_isrealtime == 't') { ?><b><i style="color:red">Realtime</i></b><?php } ?>
                <input style="width: 30px;" name="ship_dlat_<?php echo $s->ship_id ?>" id="ship_dlat_<?php echo $s->ship_id ?>" maxlength="3"  type="text" class="text-medium" <?php if (!empty($s)) iff($s->ship_isrealtime == 't', 'readonly', ''); ?>
                       value="<?php if (!empty($s)) echo geoComponent($s->ship_lat, 'd'); ?>" onkeypress="return isNumberKey(event)" >
                <input style="width: 30px;" name="ship_mlat_<?php echo $s->ship_id ?>" id="ship_mlat_<?php echo $s->ship_id ?>" maxlength="2"  type="text" class="text-medium" <?php if (!empty($s)) iff($s->ship_isrealtime == 't', 'readonly', ''); ?>
                       value="<?php if (!empty($s)) echo geoComponent($s->ship_lat, 'm'); ?>" onkeypress="return isNumberKey(event)" >
                <input style="width: 30px;" name="ship_slat_<?php echo $s->ship_id ?>" id="ship_slat_<?php echo $s->ship_id ?>" maxlength="2"  type="text" class="text-medium" <?php if (!empty($s)) iff($s->ship_isrealtime == 't', 'readonly', ''); ?>
                       value="<?php if (!empty($s)) echo geoComponent($s->ship_lat, 's'); ?>" onkeypress="return isNumberKey(event)" >
                       <?php
                       $stat = 'id="ship_rlat_' . $s->ship_id . '" style="width: 35px;"';
                       if (!empty($s) && $s->ship_isrealtime == 't')
                           $stat = 'id="ship_rlat_' . $s->ship_id . '" style="width: 35px;" disabled';

                       if (!empty($s))
                           echo form_dropdown('ship_rlat' . '_' . $s->ship_id, array(1 => 'U', -1 => 'S'), geoComponent($s->ship_lat, 'r'), $stat);
                       else
                           echo form_dropdown('ship_rlat' . '_' . $s->ship_id, array(1 => 'U', -1 => 'S'), '', $stat);
                       ?>
            </td>
            <td style="width:150px;"><?php if ($s->ship_isrealtime == 't') { ?><b><i style="color:red">Realtime</i></b><?php } ?>
                <input style="width: 30px;" name="ship_dlon_<?php echo $s->ship_id ?>" id="ship_dlon_<?php echo $s->ship_id ?>" maxlength="3"  type="text" class="text-medium" <?php if (!empty($s)) iff($s->ship_isrealtime == 't', 'readonly', ''); ?>
                       value="<?php if (!empty($s)) echo geoComponent($s->ship_lon, 'd'); ?>" onkeypress="return isNumberKey(event)" >
                <input style="width: 30px;" class="form-admin two-digit" name="ship_mlon_<?php echo $s->ship_id ?>" id="ship_mlon_<?php echo $s->ship_id ?>" maxlength="2"  type="text" class="text-medium" <?php if (!empty($s)) iff($s->ship_isrealtime == 't', 'readonly', ''); ?>
                       value="<?php if (!empty($s)) echo geoComponent($s->ship_lon, 'm'); ?>" onkeypress="return isNumberKey(event)" >
                <input style="width: 30px;" class="form-admin two-digit" name="ship_slon_<?php echo $s->ship_id ?>" id="ship_slon_<?php echo $s->ship_id ?>" maxlength="2"  type="text" class="text-medium" <?php if (!empty($s)) iff($s->ship_isrealtime == 't', 'readonly', ''); ?>
                       value="<?php if (!empty($s)) echo geoComponent($s->ship_lon, 's'); ?>" onkeypress="return isNumberKey(event)" >

                <?php
                $stat = 'id="ship_rlon_' . $s->ship_id . '" style="width: 35px;"';
                if (!empty($s) && $s->ship_isrealtime == 't')
                    $stat = 'id="ship_rlon_' . $s->ship_id . '" style="width: 35px;" disabled';

                if (!empty($s))
                    echo form_dropdown('ship_rlon', array(1 => 'T', -1 => 'B'), geoComponent($s->ship_lon, 'r'), $stat);
                else
                    echo form_dropdown('ship_rlon', array(1 => 'T', -1 => 'B'), '', $stat);
                ?>

            </td>
            <!--<td>
                <select name="shipcond_<?php echo $s->ship_id ?>" id="shipcond_<?php echo $s->ship_id ?>">
                    <option>- Pilih Status -</option>
            <?php foreach ($condition as $key => $val) { ?>
                <?php if ($key == $s->shipcond_id) { ?>
                                                    <option value="<?php echo $key ?>" selected><?php echo $val ?></option>
                <?php } else { ?>
                                                    <option value="<?php echo $key ?>"><?php echo $val ?></option>
                <?php } ?>
            <?php } ?>
                </select>
            </td>-->
            <td>
                <input type="text" name="ship_location_<?php echo $s->ship_id ?>" id="ship_location_<?php echo $s->ship_id ?>" maxlength="250" <?php if (!empty($s)) iff($s->ship_isrealtime == 't', 'readonly', ''); ?> 
                       value="<?php if (!empty($s)) echo $s->ship_water_location; ?>" style="width: 150px;"/>
            </td>
            <td>
                <input type="text" name="ship_direction_<?php echo $s->ship_id ?>" id="ship_direction_<?php echo $s->ship_id ?>" maxlength="10" <?php if (!empty($s)) iff($s->ship_isrealtime == 't', 'readonly', ''); ?> 
                       value="<?php if (!empty($s)) echo $s->ship_direction; ?>" style="width: 30px;" onkeypress="return isNumberKey(event)" />
            </td>
            <td>
                <input type="text" name="ship_speed_<?php echo $s->ship_id ?>" id="ship_speed_<?php echo $s->ship_id ?>" maxlength="10" <?php if (!empty($s)) iff($s->ship_isrealtime == 't', 'readonly', ''); ?> 
                       value="<?php if (!empty($s)) echo $s->ship_speed; ?>" style="width: 30px;" onkeypress="return isNumberKey(event)" />
            </td>
            <td style="width: 35px;">
                <select name="ship_timestamp_<?php echo $s->ship_id ?>" id="ship_timestamp_<?php echo $s->ship_id ?>" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
                    <option value="06:00" <?php if (!empty($s) && date("H:i", strtotime($s->ship_timestamp_location)) == '06:00') echo 'selected' ?>>06:00</option>
                    <option value="18:00" <?php if (!empty($s) && date("H:i", strtotime($s->ship_timestamp_location)) == '18:00') echo 'selected' ?>>18:00</option>
                </select>
            </td>
            <td>
                <input type="button" value="Simpan" <?php if ($s->ship_isrealtime == 't') echo "disabled" ?> onclick="setShipCondition('<?php echo $s->ship_id ?>')"/>
            </td>
        </tr>
        <?php
        $i++;
    }
    ?>
</tbody>
</table>
<p class="tit-form">Komponen Unsur Pesud</p>
<table class="tab-admin">
    <thead>
        <tr class="tittab">
            <td class="header" style="width: 5px;">No</td>						
            <td class="header" style="width: 100px;">Nama Pesud</td>
            <!--<td class="header">Tipe Pesud</td>-->
            <td class="header" style="width: 100px;">Pembina</td>
            <td class="header" style="width: 200px;">Lintang</td>
            <td class="header" style="width: 200px;">Bujur</td>
            <td class="header" style="width: 100px;">Lokasi</td>
            <td class="header" style="width: 20;">Kecepatan</td>
            <td class="header" style="width: 20;">Jangkauan</td>
            <td class="header" style="width: 20;">Dislokasi Unsur</td>
            <!--<td class="header">Status</td>-->
            <td class="header">Aksi</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($aeroplanes as $a) {
            ?>
            <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                <td><?php echo $i; ?></td>
                <td><?php echo $a->aer_name ?></td>
                <!--<td><?php echo $a->aertype_name ?></td>-->
                <td><?php echo $a->corps_name ?></td>
                <td style="width: 150px;"><?php if ($a->aer_isrealtime == 't') { ?><b><i style="color:red">Realtime</i></b><?php } ?>
                    <input style="width: 30px" name="aer_dlat" id="aer_dlat_<?php echo $a->aer_id ?>" maxlength="3"  type="text" class="text-medium" <?php if (!empty($a) && $a->aer_isrealtime == 't') echo "readonly" ?>
                           value="<?php if (!empty($a)) echo geoComponent($a->aer_lat, 'd'); ?>" onkeypress="return isNumberKey(event)" >
                    <input style="width: 30px;" name="aer_mlat" id="aer_mlat_<?php echo $a->aer_id ?>" maxlength="2"  type="text" class="text-medium" <?php if (!empty($a) && $a->aer_isrealtime == 't') echo "readonly" ?>
                           value="<?php if (!empty($a)) echo geoComponent($a->aer_lat, 'm'); ?>" onkeypress="return isNumberKey(event)" >
                    <input style="width: 30px;" name="aer_slat" id="aer_slat_<?php echo $a->aer_id ?>" maxlength="2"  type="text" class="text-medium" <?php if (!empty($a) && $a->aer_isrealtime == 't') echo "readonly" ?>
                           value="<?php if (!empty($a)) echo geoComponent($a->aer_lat, 's'); ?>" onkeypress="return isNumberKey(event)" >

                    <?php
                    $stat = 'id="aer_rlat_' . $a->aer_id . '" style="width: 35px;"';
                    if (!empty($a) && $a->aer_isrealtime == 't')
                        $stat = 'id="aer_rlat_' . $a->aer_id . '" disabled="disabled"';

                    if (!empty($a))
                        echo form_dropdown('aer_rlat', array(1 => 'U', -1 => 'S'), geoComponent($a->aer_lat, 'r'), $stat);
                    else
                        echo form_dropdown('aer_rlat', array(1 => 'U', -1 => 'S'), '', $stat);
                    ?>
                </td>
                <td style="width: 150px;"><?php if ($a->aer_isrealtime == 't') { ?><b><i style="color:red">Realtime</i></b><?php } ?>
                    <input style="width: 30px;" name="aer_dlon" id="aer_dlon_<?php echo $a->aer_id ?>" maxlength="3" type="text" class="text-medium" <?php if (!empty($a) && $a->aer_isrealtime == 't') echo "readonly" ?>
                           value="<?php if (!empty($a)) echo geoComponent($a->aer_lon, 'd'); ?>" onkeypress="return isNumberKey(event)" >
                    <input style="width: 30px;" name="aer_mlon" id="aer_mlon_<?php echo $a->aer_id ?>" maxlength="2" type="text" class="text-medium" <?php if (!empty($a) && $a->aer_isrealtime == 't') echo "readonly" ?>
                           value="<?php if (!empty($a)) echo geoComponent($a->aer_lon, 'm'); ?>" onkeypress="return isNumberKey(event)" >
                    <input style="width: 30px;" name="aer_slon" id="aer_slon_<?php echo $a->aer_id ?>" maxlength="2" type="text" class="text-medium" <?php if (!empty($a) && $a->aer_isrealtime == 't') echo "readonly" ?>
                           value="<?php if (!empty($a)) echo geoComponent($a->aer_lon, 's'); ?>" onkeypress="return isNumberKey(event)" >

                    <?php
                    $stat = 'id="aer_rlon_' . $a->aer_id . '" style="width: 35px;"';
                    if (!empty($a) && $a->aer_isrealtime == 't')
                        $stat = 'id="aer_rlon_' . $a->aer_id . '" disabled="disabled"';

                    if (!empty($a))
                        echo form_dropdown('aer_rlon', array(1 => 'T', -1 => 'B'), geoComponent($a->aer_lon, 'r'), $stat);
                    else
                        echo form_dropdown('aer_rlon', array(1 => 'T', -1 => 'B'), '', $stat);
                    ?>
                </td>
                <!--<td>
                    <select name="aercond_<?php echo $a->aer_id ?>" id="aercond_<?php echo $a->aer_id ?>">
                        <option>- Pilih Status -</option>
                <?php foreach ($condition as $key => $val) { ?>
                    <?php if ($key == $a->aercond_id) { ?>
                                                <option value="<?php echo $key ?>" selected><?php echo $val ?></option>
                    <?php } else { ?>
                                                <option value="<?php echo $key ?>"><?php echo $val ?></option>
                    <?php } ?>
    <?php } ?>
                    </select>
                </td>-->
                <td>
                    <input type="text" name="aer_location_<?php echo $a->aer_id ?>" id="aer_location_<?php echo $a->aer_id ?>" maxlength="250" <?php if (!empty($a)) iff($a->aer_isrealtime == 't', 'readonly', ''); ?> 
                           value="<?php if (!empty($a)) echo $a->aer_location; ?>" style="width: 150px;"/>
                </td>
                <td>
                    <input type="text" name="aer_endurance_<?php echo $a->aer_id ?>" id="aer_endurance_<?php echo $a->aer_id ?>" maxlength="10" <?php if (!empty($a)) iff($a->aer_isrealtime == 't', 'readonly', ''); ?> 
                           value="<?php if (!empty($a)) echo $a->aer_endurance; ?>" style="width: 30px;" onkeypress="return isNumberKey(event)" />
                </td>
                <td>
                    <input type="text" name="aer_speed_<?php echo $a->aer_id ?>" id="aer_speed_<?php echo $a->aer_id ?>" maxlength="10" <?php if (!empty($a)) iff($a->aer_isrealtime == 't', 'readonly', ''); ?> 
                           value="<?php if (!empty($a)) echo $a->aer_speed; ?>" style="width: 30px;" onkeypress="return isNumberKey(event)" />
                </td>
                <td style="width: 35px;">
                    <select name="aer_timestamp_<?php echo $a->aer_id ?>" id="aer_timestamp_<?php echo $s->ship_id ?>" class="form-admin">
                        <option value="06:00" <?php if (!empty($a) && date("H:i", strtotime($a->aer_timestamp_location)) == '06:00') echo 'selected' ?>>06:00</option>
                        <option value="18:00" <?php if (!empty($a) && date("H:i", strtotime($a->aer_timestamp_location)) == '18:00') echo 'selected' ?>>18:00</option>
                    </select>
                </td>
                <td>
                    <input type="button" value="Simpan" <?php if ($a->aer_isrealtime == 't') echo "disabled" ?> onclick="setAerCondition('<?php echo $a->aer_id ?>')"/>
                </td>
            </tr>
            <?php
            $i++;
        }
        ?>
    </tbody>
</table>
<p class="tit-form">Komponen Unsur Marinir</p>
<table class="tab-admin">
    <thead>
        <tr class="tittab">
            <td class="header" style="width: 5px;">No</td>						
            <!--<td class="header">Nama Marinir</td>-->
            <td class="header" style="width:100px;">Kedudukan</td>
            <!--<td class="header">Kesatrian</td>-->
            <td class="header" style="width:200px;">Lintang</td>
            <td class="header" style="width:200px;">Bujur</td>
            <td class="header" style="width:100px;">Lokasi</td>
            <td class="header" style="width:100px;">Personil</td>
            <td class="header" style="width:100px;">Matpur</td>
            <td class="header" style="width:100px;">DPP</td>
            <td class="header" style="width:20px;">Dislokasi Unsur</td>
            <!--<td class="header">Jumlah Personil</td>
            <td class="header">Status</td>-->
            <td class="header" style="width:20px;">Aksi</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($marines as $m) {
            ?>
            <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                <td><?php echo $i ?></td>
                <!--<td><?php echo $m->mar_name ?></td>-->
                <td><?php echo $m->corps_name ?></td>
                <!--<td><?php echo $m->kolak_description ?></td>-->
                <td style="width: 200px;"><?php if ($m->mar_isrealtime == 't') { ?><b><i style="color:red">Realtime</i></b><?php } ?>
                    <input style="width: 30px;" name="mar_dlat" id="mar_dlat_<?php echo $m->mar_id ?>" maxlength="3"  type="text" class="text-medium" <?php if (!empty($m) && $m->mar_isrealtime == 't') echo "readonly" ?>
                           value="<?php if (!empty($m)) echo geoComponent($m->mar_lat, 'd'); ?>" onkeypress="return isNumberKey(event)" >
                    <input style="width: 30px;" name="mar_mlat" id="mar_mlat_<?php echo $m->mar_id ?>" maxlength="2"  type="text" class="text-medium" <?php if (!empty($m) && $m->mar_isrealtime == 't') echo "readonly" ?>
                           value="<?php if (!empty($m)) echo geoComponent($m->mar_lat, 'm'); ?>" onkeypress="return isNumberKey(event)" >
                    <input style="width: 30px;" name="mar_slat" id="mar_slat_<?php echo $m->mar_id ?>" maxlength="2"  type="text" class="text-medium" <?php if (!empty($m) && $m->mar_isrealtime == 't') echo "readonly" ?>
                           value="<?php if (!empty($m)) echo geoComponent($m->mar_lat, 's'); ?>" onkeypress="return isNumberKey(event)" >

                    <?php
                    $stat = 'id="mar_rlat_' . $m->mar_id . '" style="width: 35px;"';
                    if (!empty($m) && $m->mar_isrealtime == 't')
                        $stat = 'id="mar_rlat_' . $m->mar_id . ' disabled="disabled"';

                    if (!empty($m))
                        echo form_dropdown('mar_rlat', array(1 => 'U', -1 => 'S'), geoComponent($m->mar_lat, 'r'), $stat);
                    else
                        echo form_dropdown('mar_rlat', array(1 => 'U', -1 => 'S'), '', $stat);
                    ?>
                </td>
                <td style="width: 200px;"><?php if ($m->mar_isrealtime == 't') { ?><b><i style="color:red">Realtime</i></b><?php } ?>
                    <input style="width: 30px;" name="mar_dlon" id="mar_dlon_<?php echo $m->mar_id ?>" maxlength="3" type="text" class="text-medium" <?php if (!empty($m) && $m->mar_isrealtime == 't') echo "readonly" ?>
                           value="<?php if (!empty($m)) echo geoComponent($m->mar_lon, 'd'); ?>" onkeypress="return isNumberKey(event)" >
                    <input style="width: 30px;" name="mar_mlon" id="mar_mlon_<?php echo $m->mar_id ?>" maxlength="2" type="text" class="text-medium" <?php if (!empty($m) && $m->mar_isrealtime == 't') echo "readonly" ?>
                           value="<?php if (!empty($m)) echo geoComponent($m->mar_lon, 'm'); ?>" onkeypress="return isNumberKey(event)" >
                    <input style="width: 30px;" name="mar_slon" id="mar_slon_<?php echo $m->mar_id ?>" maxlength="2" type="text" class="text-medium" <?php if (!empty($m) && $m->mar_isrealtime == 't') echo "readonly" ?>
                           value="<?php if (!empty($m)) echo geoComponent($m->mar_lon, 's'); ?>" onkeypress="return isNumberKey(event)" >

                    <?php
                    $stat = 'id="mar_rlon_' . $m->mar_id . '" style="width: 35px;"';
                    if (!empty($m) && $m->mar_isrealtime == 't')
                        $stat = 'id="mar_rlon_' . $m->mar_id . '" disabled="disabled"';

                    if (!empty($m))
                        echo form_dropdown('mar_rlon', array(1 => 'T', -1 => 'B'), geoComponent($m->mar_lon, 'r'), $stat);
                    else
                        echo form_dropdown('mar_rlon', array(1 => 'T', -1 => 'B'), '', $stat);
                    ?>
                </td>
                <!--<td><input type="text" name="personil_count" value="<?php echo $m->mar_personel_count ?>" /></td>
                <td>
                    <select>
                        <option>- Pilih Status -</option>
                <?php foreach ($condition as $key => $val) { ?>
                    <?php if ($key == $m->marcond_id) { ?>
                                                        <option value="<?php echo $key ?>" selected><?php echo $val ?></option>
                    <?php } else { ?>
                                                        <option value="<?php echo $key ?>"><?php echo $val ?></option>
        <?php } ?>
    <?php } ?>
                    </select>
                </td>-->
                <td>
                    <input type="text" name="mar_location_<?php echo $m->mar_id ?>" id="mar_location_<?php echo $m->mar_id ?>" maxlength="250" <?php if (!empty($m)) iff($m->mar_isrealtime == 't', 'readonly', ''); ?> 
                           value="<?php if (!empty($m)) echo $m->mar_location; ?>" style="width: 110px;"/>
                </td>
                <td>
                    <input type="text" name="mar_personel_<?php echo $m->mar_id ?>" id="mar_personel_<?php echo $m->mar_id ?>" maxlength="250" <?php if (!empty($m)) iff($m->mar_isrealtime == 't', 'readonly', ''); ?> 
                           value="<?php if (!empty($m)) echo $m->mar_personel_desc; ?>" style="width: 110px;" />
                </td>
                <td>
                    <input type="text" name="mar_matpur_<?php echo $m->mar_id ?>" id="mar_matpur_<?php echo $m->mar_id ?>" maxlength="250" <?php if (!empty($m)) iff($m->mar_isrealtime == 't', 'readonly', ''); ?> 
                           value="<?php if (!empty($m)) echo $m->mar_matpur_desc; ?>" style="width: 110px;"  />
                </td>
                <td>
                    <input type="text" name="mar_dpp_<?php echo $m->mar_id ?>" id="mar_dpp_<?php echo $m->mar_id ?>" maxlength="250" <?php if (!empty($m)) iff($m->mar_isrealtime == 't', 'readonly', ''); ?> 
                           value="<?php if (!empty($m)) echo $m->mar_dpp; ?>" style="width: 100px;" />
                </td>
                <td style="width: 35px;">
                    <select name="mar_timestamp_<?php echo $m->mar_id ?>" id="mar_timestamp_<?php echo $s->ship_id ?>" class="form-admin">
                        <option value="06:00" <?php if (!empty($m) && date("H:i", strtotime($m->mar_timestamp_location)) == '06:00') echo 'selected' ?>>06:00</option>
                        <option value="18:00" <?php if (!empty($m) && date("H:i", strtotime($m->mar_timestamp_location)) == '18:00') echo 'selected' ?>>18:00</option>
                    </select>
                </td>
                <td>
                    <input type="button" value="Simpan" <?php if ($m->mar_isrealtime == 't') echo "disabled" ?> onclick="setMarCondition('<?php echo $m->mar_id ?>')"/>
                </td>
            </tr>
            <?php
            $i++;
        }
        ?>
    </tbody>
</table>

<br /><br />
