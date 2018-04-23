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
        $("#addStation").validate({
            rules:{
                station_name: "required",
                stype_id: "required",
                corps_id: "required"
            },
            messages:{
                station_name: "required",
                stype_id: "required",
                corps_id: "required"
            }
        });
        
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Hapus Pangkalan"></div>')
            .html('Semua terkait Pangkalan akan ikut dihapus! Hapus data pangkalan? <div class="clear"></div>').dialog({
                autoOpen: false,
                width: 280,
                show: "fade",
                hide: "fade",
                modal: true,
                resizable: false,
                buttons: {
                    "Ya": function() {
                        $(this).dialog("close");
                        window.location = page;
                    },
                    "Batal": function() {
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
    function redirect(tail){
        window.location = "<?php echo base_url() ?>admin/station_ctrl" + tail;
    }
    function create_url(){
        var url = $('#form_search_filter').attr('action')+'/?filter=true&';
        var param = '';
        $('.filter_param').each(function(){
            param += $(this).attr('name')+'='+$(this).val()+'&';
        });
        $('#form_search_filter').attr('action',url+param).submit();
    }
    function search_enter_press(e)
    {
        // look for window.event in case event isn't passed in
        if (typeof e == 'undefined' && window.event) { e = window.event; }
        if (e.keyCode == 13)
        {
            create_url();
        }
    }
</script>
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
    
    <p class="tit-form">Daftar Pangkalan<a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
    <div class="filtering" style="display: none;">
        <form action="<?php echo base_url().'admin/station_ctrl' ?>" method="post" id="form_search_filter">
            <ul class="filter-form">
                <li>
                    <label>Nama Pangkalan</label><br />
                    <input type="text" placeholder="Nama Pangkalan" name="station_name" class='filter_param' value="<?php echo $this->input->get('station_name'); ?>" />
                </li>
                <li>
                    <label>Kedudukan Administratif</label><br />
                    <select name="corps_id" class='filter_param'>
                        <option value="">-Pilih Kedudukan Administratif-</option>
                        <?php foreach ($corps as $row) { ?>
                            <?php if (($this->input->get('corps_id')) && $this->input->get('corps_id') == $row->corps_id) { ?>
                                <option value="<?php echo $row->corps_id ?>" selected><?php echo $row->corps_name ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $row->corps_id ?>"><?php echo $row->corps_name ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </li>
                <li>
                    <label>Jenis Pangkalan</label><br />
                    <select name="stype_id" class='filter_param'>
                        <option value="">-Pilih Jenis Pangkalan-</option>
                        <?php foreach ($station_type as $row) { ?>
                            <?php if (($this->input->get('stype_id')) && $this->input->get('stype_id') == $row->stype_id) { ?>
                                <option value="<?php echo $row->stype_id ?>" selected><?php echo $row->stype_name ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $row->stype_id ?>"><?php echo $row->stype_name ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </li>
                <li>
                    <label>Kelas</label><br />
                    <select name="sclass_id" class='filter_param'>
                        <option value="">-Pilih Kelas-</option>
                        <?php foreach ($station_class as $key => $val) { ?>
                            <?php if (($this->input->get('sclass_id')) && $this->input->get('sclass_id') == $key) { ?>
                                <option value="<?php echo $key ?>" selected><?php echo $val ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $key ?>"><?php echo $val ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </li>

            </ul>

            <div class="clear"></div>
            <div style="border-bottom: 1px dotted #DDD; margin: 15px 0 17px 0;"></div>

            <input type="button" value="Filter" name="search_filter" onclick="create_url();" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
			<input type="button" value="Bersihkan Pencarian" onclick="redirect('')" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />

            <div class="clear"></div>
            <div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
        </form>
    </div>

    <table class="tab-admin">

        <tr class="tittab">
            <td class="header">No</th>						
            <td class="header" style="cursor: pointer ;">Nama Pangkalan</th>
            <td class="header" style="cursor: pointer ;">Kedudukan Administratif</th>
            <td class="header" style="cursor: pointer ;">Lokasi</th>
            <td class="header" style="cursor: pointer ;">Lintang</th>
            <td class="header" style="cursor: pointer ;">Bujur</th>
            <td class="header delete" style="width: 80px;">Aksi</th>
        </tr>


        <?php
        $count = 1;
        if (!empty($station)) {
            foreach ($station as $row) {
                ?>
                <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                    <td><?php echo ($count++)+$offset; ?></td>
                    <td><?php echo $row->station_name; ?></td>
                    <td><?php echo $row->corps_name; ?></td>
                    <td><?php echo $row->station_location; ?></td>
                    <td><?php echo geoComponent($row->station_lat, 'a', 'lat'); ?></td>
                    <td><?php echo geoComponent($row->station_lon, 'a', 'lon'); ?></td>
                    <td class="action">
                        <a href="<?php echo base_url(); ?>admin/station_ctrl/view/<?php echo $row->station_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-view"></div></a>
                        <?php if (is_has_access('station_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/station_ctrl/edit/<?php echo $row->station_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-edit"></div></a> 
                        <?php } ?>
                        <?php if (is_has_access('station_ctrl-delete', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/station_ctrl/delete/<?php echo $row->station_id . '?' . http_build_query($_GET) ?>" class="delete-tab"><div class="tab-delete"></div></a></td>
                    <?php } ?>
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
    <?php if (is_has_access('station_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
        <p id="form-pos" class="tit-form">Entri Data Pangkalan</p>
        <form action="<?php echo base_url() ?>admin/station_ctrl/save" method="post" class="" id="addStation" enctype="multipart/form-data">
            <ul class="form-admin">
                <?php if (!empty($obj)) { ?>
                    <input class="form-admin" type="hidden" name="station_id" value="<?php if (!empty($obj)) echo $obj->station_id; ?>" />
                <?php } ?>
                <li>
                    <label>Nama Pangkalan *</label>
                    <input class="form-admin" name="station_name" type="text" class="text-medium" id="station_name"
                           value="<?php if (!empty($obj)) echo $obj->station_name; ?>" <?php if (isset($view)) echo 'disabled'; ?>>

                    <div class="clear"></div>
                </li>
                <li>
                    <label>Nama Komandan</label>
                    <input class="form-admin" name="station_commander" type="text" class="text-medium" id="station_commander" maxlength="250"
                           value="<?php if (!empty($obj)) echo $obj->station_commander; ?>" <?php if (isset($view)) echo 'disabled'; ?>>

                    <div class="clear"></div>
                </li>
                <li>
                    <label>Jenis Pangkalan * </label>
                    <select name="stype_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
                        <option value="" selected>-Pilih Tipe Pangkalan-</option>
                        <?php foreach ($station_type as $row) { ?>
                            <?php if ((!empty($obj)) && $obj->stype_id == $row->stype_id) { ?>
                                <option value="<?php echo $row->stype_id ?>" selected><?php echo $row->stype_name ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $row->stype_id ?>"><?php echo $row->stype_name ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Kedudukan Administratif * </label>
                    <select name="corps_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
                        <option value="" selected>-Pilih Pangkalan-</option>
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
                    <label>Pangkalan Induk</label>

                    <?php
                    $stat = 'class="form-admin"';
                    if (isset($view)) {
                        $stat .= ' disabled';
                    }

                    if (!empty($obj))
                        echo form_dropdown('station_parent', $parent_station, $obj->station_parent, $stat);
                    else
                        echo form_dropdown('station_parent', $parent_station, '', $stat);
                    ?>

                    <div class="clear"></div>
                </li>

                <li>
                    <label>Kelas</label>
                    <?php
                    $stat = 'class="form-admin"';
                    if (isset($view)) {
                        $stat .= ' disabled';
                    }

                    if (!empty($obj)) {
                        echo form_dropdown('sclass_id', $station_class, $obj->sclass_id, $stat);
                    } else {
                        echo form_dropdown('sclass_id', $station_class, '', $stat);
                    }
                    ?>
                    <div class="clear"></div>
                </li>
		        <li>
		            <label>Lokasi </label>
		            <input class="form-admin" name="station_location" type="text" class="text-medium" value="<?php if (!empty($obj)) echo $obj->station_location; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>>
		            <?php echo form_error('station_location'); ?>					
		            <div class="clear"></div>
		        </li>
                <li>
                    <label>Lintang</label>
                    <input class="form-admin two-digit" name="station_dlat" maxlength="3"  maxlength="3" maxlength="3" type="text" class="text-medium 3digit" 
                           value="<?php if (!empty($obj)) echo geoComponent($obj->station_lat, 'd'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
                    <input class="form-admin two-digit" name="station_mlat" maxlength="2"  type="text" class="text-medium " 
                           value="<?php if (!empty($obj)) echo geoComponent($obj->station_lat, 'm'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
                    <input class="form-admin two-digit" name="station_slat" maxlength="2"  type="text" class="text-medium 2digit" 
                           value="<?php if (!empty($obj)) echo geoComponent($obj->station_lat, 's'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

                    <?php
                    $stat = 'class="form-admin" style="width: 47px;"';
                    if (isset($view)) {
                        $stat .= ' disabled';
                    }

                    if (!empty($obj))
                        echo form_dropdown('station_rlat', array(1 => 'U', -1 => 'S'), geoComponent($obj->station_lat, 'r'), $stat);
                    else
                        echo form_dropdown('station_rlat', array(1 => 'U', -1 => 'S'), '', $stat);
                    ?>

                    <?php echo form_error('station_lat'); ?>					

                    <div class="clear"></div>
                </li>
                <li>
                    <label>Bujur</label>
                    <input class="form-admin two-digit" name="station_dlon" maxlength="3"  type="text" class="text-medium 3digit" 
                           value="<?php if (!empty($obj)) echo geoComponent($obj->station_lon, 'd'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
                    <input class="form-admin two-digit" name="station_mlon" maxlength="2"  type="text" class="text-medium 2digit" 
                           value="<?php if (!empty($obj)) echo geoComponent($obj->station_lon, 'm'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
                    <input class="form-admin two-digit" name="station_slon" maxlength="2"  type="text" class="text-medium 2digit" 
                           value="<?php if (!empty($obj)) echo geoComponent($obj->station_lon, 's'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

                    <?php
                    $stat = 'class="form-admin" style="width: 47px;"';
                    if (isset($view)) {
                        $stat .= ' disabled';
                    }

                    if (!empty($obj))
                        echo form_dropdown('station_rlon', array(1 => 'T', -1 => 'B'), geoComponent($obj->station_lon, 'r'), $stat);
                    else
                        echo form_dropdown('station_rlon', array(1 => 'T', -1 => 'B'), '', $stat);
                    ?>

                    <?php echo form_error('station_lon'); ?>					
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Dasar</label>
                    <input class="form-admin" name="station_desc" type="text" class="text-medium" id="station_name"
                           value="<?php if (!empty($obj)) echo $obj->station_desc; ?>" <?php if (isset($view)) echo 'disabled'; ?>>

                    <div class="clear"></div>
                </li>
                <li>
                    <label>Riil (Jumlah Orang)</label>
                    <input class="form-admin" name="station_people" type="text" class="text-medium" id="station_people"
                           value="<?php if (!empty($obj)) echo $obj->station_people; ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

                    <div class="clear"></div>
                </li>
                <li>
                    <label>DSP (PA/BA/TA/PNS)</label>
                    <textarea class="form-admin" id="elm5" name="station_dsp" style="width: 30%"><?php if (!empty($obj)) echo $obj->station_dsp; ?></textarea>
                    <div class="clear"></div>
                </li>
                
                <!-- added by SKM17 { -->
                <?php if (!empty($obj)) { ?>
                    <li>
                        <label>&nbsp;</label>
                        <?php if ($obj->station_image != null || $obj->station_image != '') { ?>
                            <img src="<?php echo base_url() ?>assets/img/upload/main/pangkalan/<?php echo $obj->station_image ?>" width="500" />
                        <?php } else { ?>
                            <span style="font-weight:bold;">Gambar Utama Belum ada</span>
                        <?php } ?>
                        <div class="clear"></div>
                    </li>
                <?php } ?>
                <li>
                    <label>Gambar Utama</label>
                    <input type="file" name="station_image" <?php if (isset($view)) echo 'disabled'; ?>/>
                    <?php if (isset($error_main_image) && $error_main_image == true) { ?>
                        <span class="note error"><?php echo $msg_error_main_image ?></span>
                    <?php } ?>
			        <p style="margin-left:210px;color:red;">*Tipe File Gambar yang diperbolehkan: .gif atau. png atau .jpg atau .jpeg</p>
                    <p style="margin-left:210px;color:red;">*Maksimum File Gambar Utama adalah 2 MB (Megabtye)  </p>
                    <div class="clear"></div>
                </li>
                <!-- end ADDED -->
                
                <li>
                    <label>Fasilitas Sandar</label>
                    <textarea class="form-admin" id="elm1" name="station_fac_sandar" style="width: 30%"><?php if (!empty($obj)) echo $obj->station_fac_sandar; ?></textarea>
                    <div class="clear"></div>
                </li>
                
                <!-- added by SKM17 { -->
                <?php if (!empty($obj)) { ?>
                    <li>
                        <label>&nbsp;</label>
                        <?php if ($obj->station_fac_sandar_image != null || $obj->station_fac_sandar_image != '') { ?>
                            <img src="<?php echo base_url() ?>assets/img/upload/main/pangkalan/fac_sandar/<?php echo $obj->station_fac_sandar_image ?>" width="500" />
                        <?php } else { ?>
                            <span style="font-weight:bold;">Gambar Fasilitas Sandar Belum ada</span>
                        <?php } ?>
                        <div class="clear"></div>
                    </li>
                <?php } ?>
                <li>
                    <label>Gambar Fasilitas Sandar</label>
                    <input type="file" name="station_fac_sandar_image" <?php if (isset($view)) echo 'disabled'; ?>/>
                    <?php if (isset($error_main_image) && $error_main_image == true) { ?>
                        <span class="note error"><?php echo $msg_error_main_image ?></span>
                    <?php } ?>
			        <p style="margin-left:210px;color:red;">*Tipe File Gambar yang diperbolehkan: .gif atau. png atau .jpg atau .jpeg</p>
                    <p style="margin-left:210px;color:red;">*Maksimum File Gambar Fasilitas Sandar adalah 2 MB (Megabtye)  </p>
                    <div class="clear"></div>
                </li>
                <!-- end ADDED -->
                
                <!-- added by SKM17 -->
                <li>
                    <label>FASHARKAN</label>
                    <textarea class="form-admin" id="elm6" name="station_fasharkan" style="width: 30%"><?php if (!empty($obj)) echo $obj->station_fasharkan; ?></textarea>
                    <div class="clear"></div>
                </li>
                <!-- end ADDED -->
                
                <li>
                    <label>Fasilitas Perbekalan</label>
                    <textarea class="form-admin" id="elm2" name="station_fac_perbekalan" style="width: 30%"><?php if (!empty($obj)) echo $obj->station_fac_perbekalan; ?></textarea>
                    <div class="clear"></div>
                </li>
                
                <!-- added by SKM17 { -->
                <?php if (!empty($obj)) { ?>
                    <li>
                        <label>&nbsp;</label>
                        <?php if ($obj->station_fac_perbekalan_image != null || $obj->station_fac_perbekalan_image != '') { ?>
                            <img src="<?php echo base_url() ?>assets/img/upload/main/pangkalan/fac_perbekalan/<?php echo $obj->station_fac_perbekalan_image ?>" width="500" />
                        <?php } else { ?>
                            <span style="font-weight:bold;">Gambar Fasilitas Perbekalan Belum ada</span>
                        <?php } ?>
                        <div class="clear"></div>
                    </li>
                <?php } ?>
                <li>
                    <label>Gambar Fasilitas Perbekalan</label>
                    <input type="file" name="station_fac_perbekalan_image" <?php if (isset($view)) echo 'disabled'; ?>/>
                    <?php if (isset($error_main_image) && $error_main_image == true) { ?>
                        <span class="note error"><?php echo $msg_error_main_image ?></span>
                    <?php } ?>
			        <p style="margin-left:210px;color:red;">*Tipe File Gambar yang diperbolehkan: .gif atau. png atau .jpg atau .jpeg</p>
                    <p style="margin-left:210px;color:red;">*Maksimum File Gambar Fasilitas Perbekalan adalah 2 MB (Megabtye)  </p>
                    <div class="clear"></div>
                </li>
                <!-- end ADDED -->
                
                <li>
                    <label>Fasilitas Perawatan Personil</label>
                    <textarea class="form-admin" id="elm3" name="station_fac_perawatan" style="width: 30%"><?php if (!empty($obj)) echo $obj->station_fac_perawatan; ?></textarea>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>FASBINLAN</label>
                    <textarea class="form-admin" id="elm4" name="station_fac_power" style="width: 30%">
                        <?php if (!empty($obj)) echo $obj->station_fac_power; ?></textarea>
                    <div class="clear"></div>
                </li>
                 <li>
                    <label>Identitas Sensor Arpa</label>
                    <input class="form-admin" name="station_arpaid" type="text" class="text-medium" id="station_arpaid"
                           value="<?php if (!empty($obj)) echo $obj->station_arpaid; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                    <div class="clear"></div>
                </li>
                
                <li>
                    <br />
				    <p class="tit-form"></p>
			        <label>&nbsp;</label>
				    <?php if (!isset($view)) { ?>
				        <input class="button-form" type="submit" value="Simpan">
				        <input class="button-form" type="reset" onclick="redirect('')" value="Batal">
				    <?php } ?>
			        <input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
				    <div class="clear"></div>
                </li>
                
            </ul>
        </form>
    <?php } ?>
</div>
<div class="clear"></div>
