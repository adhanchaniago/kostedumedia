<?php if ($this->session->flashdata('info')) { ?>
    <script>
        $(document).ready(function(){
			$('.success').html("<strong> <?php echo $this->session->flashdata('info'); ?>");
			$('.success').attr('style','');
			$('.success').delay(10000).fadeOut('slow');
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#addEnemyForce").validate({ // added by SKM17
            rules:{
                enmap_id: "required",
                enmap_name: "required",
                eforceflag_id: "required"
            },
            messages:{
                enmap_id: "required",
                enmap_name: "required",
                eforceflag_id: "required"
            }
        });
        // added by SKM17 so there is dialog prompt when delete enemy-force
	    $('.delete-tab').click(function(){
	        var page = $(this).attr("href");
	        var $dialog = $('<div title="Hapus Kekuatan Lawan"></div>')
	        .html('Semua terkait Kekuatan Lawan akan ikut dihapus! Hapus data kekuatan lawan? <div class="clear"></div>').dialog({
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
    
    function redirect(tail){
        window.location = "<?php echo base_url() ?>admin/enemy_force_ctrl" + tail;
    }
     function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if(!((charCode>=48&&charCode<=57)|| (charCode==46) || (charCode==8) || (charCode==9)))
            return false;

        return true;
    }
</script>
<!-- Added by D3 - Disable enter -->
<script type="text/javascript"> 
function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = stopRKey; 
</script> 

<script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/tiny_mce.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        mode : "textareas",
        theme : "simple"
    });
</script>
<div id="main">
    
    <div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>

    <p class="tit-form">Daftar Kekuatan Lawan <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
    <div class="filtering" style="display: none;">
        <form action="<?php echo base_url().'admin/enemy_force_ctrl' ?>" method="get" id="form_search_filter">
                    <input type="hidden" placeholder="Nama Pesawat" name="filter" class='filter_param' value="set"/>
            <ul class="filter-form">
                <li>
                    <label>Nama Kekuatan Lawan</label><br />
                    <input type="text" placeholder="Nama Kekuatan Lawan" 
                        name="enmapname_filter" class='filter_param' 
                        value="<?php echo $this->input->get('enmapname_filter'); ?>"/>
                </li>                
                <li>
                    <label>Negara</label><br />
                   <select name="eforceflagid_filter">
                        <option value="">-Pilih Salah Satu-</option>
                        <?php foreach ($force_flags as $force_flag) { ?>
                            <option value="<?php echo $force_flag->eforceflag_id?>" 
                                    <?php if( $this->input->get('eforceflagid_filter') == $force_flag->eforceflag_id ) 
                                        echo 'selected' ?>> <?php echo $force_flag->eforceflag_name?></option>
                        <?php } ?>
                    </select>
                </li>
            </ul>

            <div class="clear"></div>
            <div style="border-bottom: 1px dotted #DDD; margin: 15px 0 17px 0;"></div>
			
			<input type="button" value="Bersihkan Pencarian" onclick="document.location='<?php echo base_url().'admin/enemy_force_ctrl' ?>';" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
            <input type="submit" value="Cari" name="search_filter" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />

            <div class="clear"></div>
            <div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
        </form>
    </div>
    <table class="tab-admin">

        <tr class="tittab">
            <td class="header">No</td>
            <td class="header" style="cursor: pointer ;">Nama Kekuatan Lawan</td>
            <td class="header" style="cursor: pointer ;">Lintang </td>
            <td class="header" style="cursor: pointer ;">Bujur </td>
            <td class="header" style="cursor: pointer ;">Negara</td>            
            <td class="header delete" style="width: 80px;">Aksi</td>
        </tr>
        <?php
        $count = 1;
        if (!empty($enemy_force)) {
            foreach ($enemy_force as $row) {
                ?>
                <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                    <td><?php echo ($count++)+$offset; ?></td>
                    <td><?php echo $row->enmap_name; ?></td>
                    <td><?php echo geoComponent($row->enmap_lat, 'a', 'lat'); ?></td>
                    <td><?php echo geoComponent($row->enmap_lon, 'a', 'lon'); ?></td>
                    <td><?php echo $row->eforceflag_name; ?></td>
                    <td class="action">
                        <a href="<?php echo base_url(); ?>admin/enemy_force_ctrl/view/<?php echo $row->enmap_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-view"></div></a> 
                        <?php if (is_has_access('enemy_force_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/enemy_force_ctrl/edit/<?php echo $row->enmap_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-edit"></div></a> 
                        <?php } ?>
                        <?php if (is_has_access('enemy_force_ctrl-delete', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/enemy_force_ctrl/delete/<?php echo $row->enmap_id . '?' . http_build_query($_GET) ?>" class="delete-tab"><div class="tab-delete"></div></a>
                        <?php } ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>


    </table>
    <br />
     <div class="pagination">
			<?php echo $pagination?>
		</div> 
    <br />

    <?php if (is_has_access('enemy_force_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
        <p id="form-pos" class="tit-form">Data Kekuatan</p>
        <form action="<?php echo base_url() ?>admin/enemy_force_ctrl/save" method="post" id="addEnemyForce" enctype="multipart/form-data">
            <?php if (!empty($obj)) { ?>
                <input class="form-admin" type="hidden" name="enmap_id" value="<?php if (!empty($obj)) echo $obj->enmap_id; ?>" />
            <?php } ?>
            <ul class="form-admin">
                <li>
                    <label>Nama Kekuatan Lawan * </label>
                    <input class="form-admin" name="enmap_name"  type="text" class="text-medium" id="enmap_name"
                           value="<?php if (!empty($obj)) echo $obj->enmap_name; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('enmap_name'); ?>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Jenis Kekuatan Lawan </label>
                    <select name="eforcetype_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
                        <option value="">--Pilih Salah Satu--</option>
                        <?php foreach($force_types as $force_type){?>
                            <option value="<?php echo $force_type->eforcetype_id?>" <?php if(!empty($obj) && $obj->eforcetype_id == $force_type->eforcetype_id) echo 'selected' ?>> <?php echo $force_type->eforcetype_name?></option>
                        <?php } ?>
                    </select>

                    <div class="clear"></div>
                </li>
                <!-- added by SKM17 -->
                <li>
                    <label>Negara * </label>
                    <select name="eforceflag_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
                        <option value="" selected>-Pilih Salah Satu-</option>
                        <?php foreach($force_flags as $force_flag){?>
                            <option value="<?php echo $force_flag->eforceflag_id?>" <?php if(!empty($obj) && $obj->eforceflag_id == $force_flag->eforceflag_id) echo 'selected' ?>> <?php echo $force_flag->eforceflag_name ?> </option>
                        <?php } ?>
                    </select>

                    <div class="clear"></div>
                </li>
                <!-- END ADDED -->
                <li>
                    <label>Lintang </label>
                    <input class="form-admin two-digit" name="enmap_dlat" maxlength="3" type="text" class="text-medium" value="<?php if (!empty($obj)) echo geoComponent($obj->enmap_lat, 'd'); ?>" 
                    onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
                    <input class="form-admin two-digit" name="enmap_mlat" maxlength="2" type="text" class="text-medium" value="<?php if (!empty($obj)) echo geoComponent($obj->enmap_lat, 'm'); ?>" 
                    onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
                    <input class="form-admin two-digit" name="enmap_slat" maxlength="2" type="text" class="text-medium" value="<?php if (!empty($obj)) echo geoComponent($obj->enmap_lat, 's'); ?>" 
                    onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

                    <?php


                    $stat = 'class="form-admin" style="width: 47px;"';
                    if (!empty($obj)  && isset($view))
                        $stat = 'disabled="disabled"';

                    if (!empty($obj))
                        echo form_dropdown('enmap_rlat', array(1 => 'U', -1 => 'S'), geoComponent($obj->enmap_lat, 'r'), $stat);
                    else
                        echo form_dropdown('enmap_rlat', array(1 => 'U', -1 => 'S'), '', $stat);
                    ?>

                    <?php echo form_error('enmap_lat'); ?>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Bujur </label>
                    <input class="form-admin two-digit" name="enmap_dlon" maxlength="3"  
                             type="text" class="text-medium" 
                           value="<?php if (!empty($obj)) echo geoComponent($obj->enmap_lon, 'd'); ?>" 
                            onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

                    <input class="form-admin two-digit" name="enmap_mlon" 
                            maxlength="2"  type="text" class="text-medium" 
                           value="<?php if (!empty($obj)) echo geoComponent($obj->enmap_lon, 'm'); ?>" 
                           onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

                    <input class="form-admin two-digit" name="enmap_slon" 
                            maxlength="2"  type="text" class="text-medium" 
                           value="<?php if (!empty($obj)) echo geoComponent($obj->enmap_lon, 's'); ?>" 
                           onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

                    <?php
                    $stat = 'class="form-admin" style="width: 47px;"';
                    if (!empty($obj)  && isset($view))
                        $stat = 'disabled="disabled"';

                    if (!empty($obj))
                        echo form_dropdown('enmap_rlon', array(1 => 'T', -1 => 'B'), geoComponent($obj->enmap_lon, 'r'), $stat);
                    else
                        echo form_dropdown('enmap_rlon', array(1 => 'T', -1 => 'B'), '', $stat);
                    ?>

                    <?php echo form_error('enmap_lon'); ?>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Keterangan </label>
                    <textarea class="form-admin" name="enmap_desc"  type="text" id="enmap_desc"
                            maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>>

                            <?php if (!empty($obj)) echo $obj->enmap_desc; ?>
                           
                    </textarea>
                    <?php echo form_error('enmap_name'); ?>
                    <div class="clear"></div>
                </li>
    <?php if (!empty($obj)) { ?>
                <li>
                    <label>&nbsp;</label>
                    <?php if ($obj->enmap_icon != null || $obj->enmap_icon != '') { ?>
                        <img src="<?php echo base_url() ?>assets/img/upload/main/lawan/<?php echo $obj->enmap_icon ?>" width="500" />
                    <?php } else { ?>
                        <span style="font-weight:bold;">Gambar Utama Belum ada</span>
                    <?php } ?>
                    <div class="clear"></div>
                </li>
            <?php } ?>
            <li>
                <label>Gambar Utama</label>
                <input type="file" name="enmap_icon" <?php if (isset($view)) echo 'disabled'; ?>/>
                <?php if (isset($error_main_image) && $error_main_image == true) { ?>
                    <span class="note error"><?php echo $msg_error_main_image ?></span>
                <?php } ?>
                <p style="margin-left:210px;color:red;">*Tipe File Gambar yang diperbolehkan: .gif atau. png atau .jpg atau .jpeg</p>
                <p style="margin-left:210px;color:red;">*Maksimum File Ikon adalah 2 MB (Megabtye)  </p>
                <div class="clear"></div>
            </li> 
                <script>
                    /*client side event handler for enemy force component stuff */

                    <?php $row_total = (!empty($eforce_component))?count($eforce_component):0; ?>
                    var totalRow = <?php echo $row_total?>;

                    $('#totalRow').val(totalRow);

                    $(document).ready(function(){
                        $('#addFcomp').click(function(){
                            if($('#').attr('disabled')=="disabled"){

                            }else{
                                var rowCount = $('#eforceList').find('tr').size();
                                var rowClass =(rowCount % 2 == 0)? 'row-two':'row-one';

                                var forceCompType = $('[name="fcomp_type_input"]').val();
                                var forceComp = $('[name="fcomp_input"]').val();
                                var forceCompText = $('[name="fcomp_input"] option:selected').text();                               
                                var power = $('[name="fcomp_power_input"]').val();

                                console.log('force comp :'+forceComp);

                                if(forceComp >= 0 ){
                                    $('#eforceList #fcomp_'+forceComp).remove();

                                    totalRow = $('#eforceList tr.content-data').length;
                                    rowCount = totalRow+1;
                                    console.log('LOLOS');
                                    
                                    var tableRow = "<tr id='fcomp_" + forceComp + "' class='" + rowClass + " content-data'> " +
										"<td> " + rowCount + "</td>" +                                                        
										"<td> " + forceCompText + "</td>" +
										"<input type='hidden' name='force_comp[" + (totalRow) + "]' value='" + forceComp + "'/>" +
										"<td> " + power + '</td>'+
										'<input type="hidden" name="force_power['+(totalRow)+']" value="'+power+'">'+
										'<td class="action"> '+
										'   <a href="javascript:void(0)" onClick="edit(\''+forceComp+'\',\''+power+'\')" ><div class="tab-edit"></div></a>'+
										'   <a href="javascript:void(0)" ><div class="tab-delete"></div></a>'+
										' </td>'+
										'</tr>';

                                    
                                    $('#eforceList').append(tableRow);

                                    totalRow = $('#eforceList tr.content-data').length;
                                    $('#totalRow').val(totalRow);

                                    alert('total row : '+$('#totalRow').val());
                                    clean();
                                    
                                }
                            }                          
                        });
/* commented by SKM17
                        $('#cancelFcomp').click(function(){
                            $('#eforcetype_id').val('');
                        });
                        */

                        $('#eforceList').on('click', '.tab-delete', function(){
                            $(this).parent().parent().parent().remove();
                            totalRow = $('#eforceList tr.content-data').length;
                            $('#totalRow').val(totalRow);
                            
                        });
                    });

                    function edit(forceComp, power){
                        
                        $('[name="fcomp_input"]').val(forceComp);
                        $('[name="fcomp_power_input"]').val(power);
                    }

                    function clean(){
                        $('[name="fcomp_type_input"]').val('');
                        $('[name="fcomp_input"]').val('');
                        $('[name="fcomp_power_input"]').val('');   
                    }
                </script>

<!-- commented by SKM17
                <p class="tit-form">Daftar Komponen Kekuatan Musuh</p>

                <input type="hidden" id="totalRow" name="total_row" value=""/>

                <table id="eforceList" class="tab-admin">
                    <tr class="tittab">
                        <td>No</td>
                        <td>Nama Komponen</td>
                        <td>Jumlah</td>
                        <td style="width: 52px;">Action</td>
                    </tr>

                    <?php if (!empty($eforce_component)) { ?>
                        <?php
                        $count = 0;
                        if (!empty($eforce_component)) {
                            foreach ($eforce_component as $row) {
                                ?>
                                <tr class="<?php echo alternator("row-one", "row-two"); ?> content-data" id="fcomp_<?php echo $row->fcomp_id ?>">
                                    <td><?php echo $count+1; ?></td>
                                    <td><?php echo $row->fcomp_name; ?></td>
                                    <input type="hidden" name="force_comp[<?php echo $count ?>]" class="forceComp" value="<?php echo $row->fcomp_id ?>" />
                                    <td id="marValue_td_<?php echo $count ?>">
                                        <?php echo $row->efcomp_power; ?>
                                    </td>
                                    <input type="hidden" name="force_power[<?php echo $count ?>]" class="forcePower" value="<?php echo $row->efcomp_power ?>" />
                                    <?php if (!isset($view)) { ?>
                                        <td class="action"> 
                                            <a href="javascript:void(0);" onClick="edit('<?php echo $row->fcomp_id ?>', '<?php echo $row->efcomp_power ?>')" >
                                                    <div class="tab-edit"></div></a> 
                                            <a href="javascript:void(0);" ><div class="tab-delete"></div></a>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $count++;
                            }
                        }
                        ?>

                    <?php } ?>
                </table>

                <br />
                <?php if (!isset($view)) { ?>
                    <p class="tit-form">Entri Data Komponen Kekuatan</p>
                    <ul class="form-admin">                       
                        <li>
                            <label>Komponen Kekuatan * </label>
                            <select name="fcomp_input">
                                <option value="-1">Pilih Komponen Kekuatan</option>
                                 <?php foreach($force_component as $fcomp){
                                    if(!isset($fcomp_obj)) { ?>
                                        <option value="<?php echo $fcomp->fcomp_id?>"><?php echo trim($fcomp->fcomp_name)?></option>
                                    <?php }else{?>
                                        <option value="<?php echo $fcomp->fcomp_id?>" <?php if ($fcomp_obj->fcomp_id == $fcomp->fcomp_id) echo 'selected' ?> > <?php echo trim($fcomp->fcomp_name)?></option>
                                    <?php }?>
                                <?php }?>
                            </select>
                            <div class="clear"></div>
                        </li>

                        <li>
                            <label>Jumlah * </label>
                            <input type="text" name="fcomp_power_input" value="<?php if(isset($fcomp_obj)) echo $fcomp_obj->fcomp_power?>"/>
                            <div class="clear"></div>
                        </li>

                        <input type="hidden" value="" id="editNumber"/>
                        <input type="hidden" value="<?php if (!empty($force_components)) echo count($force_components) ?>" id="totalRow" name="totalRow"/>
                        <li>
                            <label></label>
                            <input class="button-form green" id="addFcomp" type="button" value="<?php
                            if (empty($obj))
                                echo 'Simpan';
                            else
                                echo 'Tambah Komponen';
                            ?>" >
                            <input class="button-form red" id="cancelFcomp" type="button" value="Cancel">
                            <div class="clear"></div>
                        </li>
                    </ul>
                <?php } ?> -->
                
                <li>
                    <br />
                    <p class="tit-form"></p>
                    <label>&nbsp;</label>
		        	<?php if (!isset($view)) { ?>
		                <input class="button-form" type="submit" value="Simpan">
		                <input class="button-form" type="reset" onclick="redirect('')" value="Batal">
            			<?php } ?>
                    <input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
                </li>
			</ul>
        </form>
    <?php } ?>
    <div class="clear"></div>
</div>
