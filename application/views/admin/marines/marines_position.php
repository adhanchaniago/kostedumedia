<!-- added by D3-->

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.css" />
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.js"></script>
     
    <script type="text/javascript" src="<?php echo base_url() ?>application/config/config_peta.js"></script>
     
    <script type="text/javascript" src="<?php echo $this->config->item('socket_ip') ?>/socket.io/socket.io.js"></script>
<!-- end -->


<!-- <script type="text/javascript" src="<?php echo $this->config->item('socket_ip') ?>/socket.io/socket.io.js"></script> -->
<?php if ($this->session->flashdata('info')) { ?>
    <script>
        // var socket = io.connect('<?php echo $this->config->item('socket_ip') ?>'); // commented by SKM17
        // socket.emit('reqMarineUpdate');
        
        $(document).ready(function() {
            $('.success').html("<strong> <?php echo $this->session->flashdata('info'); ?>");
            $('.success').attr('style', '');
            $('.success').delay(10000).fadeOut('slow');
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function() {
        $('.pilih-status').change(function() {
            if ($(this).val() == 'sandar') {
                $('.tempat-sandar').slideDown('fast');
            } else {
                $('.tempat-sandar').slideUp('fast');
            }
        });
        $("#addMarPosition").validate({
            rules: {
                mar_id: "required",
                operation_name: "required"
            },
            messages: {
                mar_id: "required",
                operation_name: "required"
            }
        });
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Satgas"></div>')
            .html('Semua terkait Satgas akan ikut dihapus! Hapus data satgas? <div class="clear"></div>').dialog({
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
        $("#mardis_timestamp").datepicker({dateFormat: 'yy-mm-dd', maxDate: '0'});
        //        $('#ship_machinehour').timepicker({ 'timeFormat': 'H:i:s' });
        //        $('#ship_currenthour').timepicker({ 'timeFormat': 'H:i:s' });
    });
    function create_url() {
        var url = $('#form_search_filter').attr('action') + '/?filter=true&';
        var param = '';
        $('.filter_param').each(function() {
            param += $(this).attr('name') + '=' + $(this).val() + '&';
        });
        $('#form_search_filter').attr('action', url + param).submit();
    }
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (!((charCode >= 48 && charCode <= 57) || (charCode == 46) || (charCode == 8) || (charCode == 9)))
            return false;

        return true;
    }
    function redirect(tail){
        window.location = "<?php echo base_url() ?>admin/marines_ctrl/position" + tail;
    }
</script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/tiny_mce.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        mode: "textareas",
        theme: "simple"
    });
</script>
<div id="main">
    <div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>

    <?php if (empty($marines_dislocation)) { ?>
        <p class="notif attention">
            <strong>Data dislokasi marinir tidak ditemukan</strong>
            Kami tidak menemukan data dislokasi marinir. Silahkan terlebih dahulu melengkapi data dislokasi marinir.
            Mohon maaf atas ketidaknyamanan ini
        </p>
    <?php } ?>

    <p class="tit-form">Daftar Satgas<a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
    <div class="filtering" style="display: none;">
        <form action="<?php echo base_url() . 'admin/marines_ctrl/position/' ?>" method="post" id="form_search_filter">
            <ul class="filter-form">
                <li>
                    <label>Nama Operasi</label><br />
                    <input type="text" placeholder="Nama Operasi" name="operation_name" class='filter_param' value="<?php echo $this->input->get('operation_name'); ?>" onkeypress="search_enter_press(event);" />
                </li>
                <li>
                    <label>Lokasi</label><br />
                    <input type="text" placeholder="Lokasi" name="mardis_location" class='filter_param' value="<?php echo $this->input->get('mardis_location'); ?>" />
                </li>
                <li>
                    <label>DPP</label><br />
                    <input type="text" placeholder="DPP" name="mardis_dpp" class='filter_param' value="<?php echo $this->input->get('mardis_dpp'); ?>" />
                </li>
            </ul>

            <div class="clear"></div>
            <div style="border-bottom: 1px dotted #DDD; margin: 15px 0 17px 0;"></div>
            
            <input type="button" value="Bersihkan Pencarian" onclick="redirect('')" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
            <input type="button" value="Cari" name="search_filter" onclick="create_url();" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />

            <div class="clear"></div>
            <div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
        </form>
    </div>
    <table class="tab-admin">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;" rowspan="2">No</td>
                <td class="header" rowspan="2">Nama Operasi</td>
                <td class="header" colspan="3">Posisi</td>
                <td class="header" rowspan="2">Personil</td>
                <td class="header" rowspan="2">Matpur</td>
                <td class="header" rowspan="2">DPP</td>
                <td class="header delete" style="width: 80px;" rowspan="2">Aksi</td>
            </tr>
            <tr class="tittab">
                <td class="header">Lintang</td>
                <td class="header">Bujur</td>
                <td class="header">Lokasi</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            if (!empty($marines_dislocation)) {
                foreach ($marines_dislocation as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                        <td><?php echo ($i++) + $offset; ?></td>
                        <td><?php echo $row->operation_name ?></td>
                        <td><?php echo geoComponent($row->mardis_lat, 'a', 'lat'); ?></td>
                        <td><?php echo geoComponent($row->mardis_lon, 'a', 'lon'); ?></td>
                        <td><?php echo $row->mardis_location ?></td>
                        <td><?php echo $row->mardis_personnel ?></td>
                        <td><?php echo $row->mardis_matpur ?></td>
                        <td><?php echo $row->mardis_dpp ?></td>
                        <td class="action" style="width: 52px;">
                            <a href="<?php echo base_url(); ?>admin/marines_ctrl/view_position/<?php echo $row->mardis_id . '?' . http_build_query($_GET) . '#form-pos' ?>"><div class="tab-view"></div></a> 
                            <a href="<?php echo base_url(); ?>admin/marines_ctrl/edit_position/<?php echo $row->mardis_id . '?' . http_build_query($_GET) . '#form-pos' ?>" class="edit-tab"><div class="tab-edit"></div></a> 
                            <a href="<?php echo base_url(); ?>admin/marines_ctrl/delete_position/<?php echo $row->mardis_id . '?' . http_build_query($_GET) ?>" class="delete-tab"><div class="tab-delete"></div></a></td>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>

    <br />
    <div class="pagination">
        <?php echo $pagination ?>
    </div>
    <br />
    

<!-- added by D3 -->

<?php 
if(empty($obj)){  ?>
    <p class="tit-form">Map: </p>

        <div id="map" style="width: 1080px; height: 590px; margin-left:1%;"></div>    

            <?php    
                $lat = -1.1750;
                $lng = 119.8283;
                $zoom = 5;
            ?>


            <!-- added by D3-->
            <script type="text/javascript">
                
                var osmUrl='<?php echo $this->config->item('map_url') ?>';
                var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
                var osm = new L.TileLayer(osmUrl, {minZoom: 1, maxZoom: 18, attribution: osmAttrib});

                map = L.map('map', {
                    zoomControl: true,
                    layers: [osm]
                }).setView(new L.LatLng(<?php echo $lat; ?>, <?php echo $lng; ?>),<?php echo $zoom; ?>);

            </script>


            <?php
                $icon_name;
                foreach ($marines_dislocation as $row)
                {
                    foreach ($marine_icon as $key) {
                        //print_r($key->maricon_file);

                         if($row->maricon_id == $key->maricon_id){
                            $icon_name = $key->maricon_file;
                           
                          }
                    }

            ?>

            <script>
               
                var marine = new Array();
                var myIcon = L.icon({
                iconUrl: "<?php echo base_url().'assets/img/icon-marine/'.$icon_name;?>",

                iconSize: [30, 30],
                iconAnchor: [9, 21],
                popupAnchor: [0, -14]
            });
               marine[<?php echo $row->mardis_id; ?>] = L.marker([<?php echo $row->mardis_lat; ?>,<?php echo $row->mardis_lon; ?>], {icon: myIcon} )

               .bindPopup("<?=$row->operation_name.' - '.$row->mardis_id; ?>")

               .addTo(map);
                
            </script>

            <?php 

            } 

        }

            ?>  



    <p id="form-pos" class="tit-form">Entri Data Satgas</p>
    <form action="<?php echo base_url() ?>admin/marines_ctrl/save_position<?php echo '?' . http_build_query($_GET) ?>" method="post" id="addMarPosition" enctype="multipart/form-data">
        <ul class="form-admin">
            <?php if (!empty($obj)) { ?>
                <input type="hidden" name="mardis_id" value="<?php echo $obj->mardis_id; ?>" />
            <?php } ?>
            <li>
                <label>Nama Operasi *</label>
                <input class="form-admin" name="operation_name" id="operation_name" type="text" class="text-medium" value="<?php if (!empty($obj)) echo $obj->operation_name; ?>" maxlength="255" <?php if (isset($view)) echo 'disabled'; ?>>
                <?php echo form_error('operation_name'); ?>					
                <div class="clear"></div>
            </li>
            <li>
                <label>Jenis Ikon </label>
                <select name="maricon_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
                    <option value="0" selected>-Pilih Ikon-</option>
                    <?php foreach ($marine_icon as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->maricon_id == $row->maricon_id) { ?>
                            <option value="<?php echo $row->maricon_id ?>" selected><?php echo $row->maricon_desc ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->maricon_id ?>"><?php echo $row->maricon_desc ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <div class="clear"></div>
            </li>
            <li>
                <label>Lokasi</label>
                <input class="form-admin" name="mardis_location" type="text" class="text-medium" value="<?php if (!empty($obj)) echo $obj->mardis_location; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>>
                <?php echo form_error('mardis_location'); ?>					
                <div class="clear"></div>
            </li>

            <!-- Added BY D3 -->
            <?php
                if(!empty($obj)){  ?>

                <li>
                    <label>Map</label>
                    <div id="map" style="width: 400px; height: 200px;margin-left:20%;"></div>

                   
                        <script type="text/javascript">
                            var osmUrl='<?php echo $this->config->item('map_url') ?>';
                            var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
                            var osm = new L.TileLayer(osmUrl, {minZoom: 1, maxZoom: 18, attribution: osmAttrib});

                            map = L.map('map', {
                                zoomControl: true,
                                layers: [osm]
                            }).setView(new L.LatLng(<?php echo $obj->mardis_lat;?>, <?php echo $obj->mardis_lon; ?>),16);

                        </script>
                            <?php
                                $icon_name;
                                foreach ($marines_dislocation as $row)
                                {
                                    foreach ($icon as $key) {

                                         if($row->maricon_id == $key->maricon_id){
                                            $icon_name = $key->maricon_file;
                                          }
                                    }
                            ?>

                                <script>
                                    var marine = new Array();
                                    var myIcon = L.icon({
                                    iconUrl: "<?php echo base_url().'assets/img/icon-marine/'.$icon_name;?>",
                                    iconSize: [30, 30],
                                    iconAnchor: [9, 21],
                                    popupAnchor: [0, -14]
                                });
                                   
                                marine[<?php echo $row->mardis_id; ?>] = L.marker([<?php echo $row->mardis_lat; ?>,<?php echo $row->mardis_lon; ?>], {icon: myIcon} )
                                .bindPopup( "<?=$row->operation_name.' - '.$row->mardis_id; ?>" )
                               .addTo(map);
                                    
                                </script>

                            <?php 
                            } ?>

                </li>
                <div class="clear"></div>
                <?php
                    }
                ?>

            <li>
                <label>Lintang </label>
                <input class="form-admin two-digit" name="mardis_dlat" maxlength="3" 
                	type="text" class="text-medium"
					value="<?php if (!empty($obj)) echo geoComponent($obj->mardis_lat, 'd'); ?>" 
					onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
					
                <input class="form-admin two-digit" name="mardis_mlat" maxlength="2"  
                	type="text" class="text-medium"
					value="<?php if (!empty($obj)) echo geoComponent($obj->mardis_lat, 'm'); ?>" 
					onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
					
                <input class="form-admin two-digit" name="mardis_slat" maxlength="2"
                	type="text" class="text-medium"
					value="<?php if (!empty($obj)) echo geoComponent($obj->mardis_lat, 's'); ?>" 
					onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

                <?php
                $stat = 'class="form-admin" style="width: 47px;"';
                if (!empty($obj) && isset($view))
                    $stat = 'disabled="disabled"';

                if (!empty($obj))
                    echo form_dropdown('mardis_rlat', array(1 => 'U', -1 => 'S'), geoComponent($obj->mardis_lat, 'r'), $stat);
                else
                    echo form_dropdown('mardis_rlat', array(1 => 'U', -1 => 'S'), '', $stat);
                ?>

                <?php echo form_error('mardis_lat'); ?>
                <div class="clear"></div>
            </li>
            <li>
                <label>Bujur </label>
                <input class="form-admin two-digit" name="mardis_dlon" maxlength="3" 
                	type="text" class="text-medium"
                	value="<?php if (!empty($obj)) echo geoComponent($obj->mardis_lon, 'd'); ?>" 
                	onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
                	
                <input class="form-admin two-digit" name="mardis_mlon" maxlength="2" 
                type="text" class="text-medium"
                value="<?php if (!empty($obj)) echo geoComponent($obj->mardis_lon, 'm'); ?>" 
                onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
                
                <input class="form-admin two-digit" name="mardis_slon" maxlength="2" 
                	type="text" class="text-medium"
                	value="<?php if (!empty($obj)) echo geoComponent($obj->mardis_lon, 's'); ?>" 
                	onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

                <?php
                $stat = 'class="form-admin" style="width: 47px;"';
                if (!empty($obj) && isset($view))
                    $stat = 'disabled="disabled"';

                if (!empty($obj))
                    echo form_dropdown('mardis_rlon', array(1 => 'T', -1 => 'B'), geoComponent($obj->mardis_lon, 'r'), $stat);
                else
                    echo form_dropdown('mardis_rlon', array(1 => 'T', -1 => 'B'), '', $stat);
                ?>
                <?php echo form_error('mardis_lon'); ?>									
                <div class="clear"></div>
            </li>
            <li>
                <label>DPP</label>
                <input class="form-admin" name="mardis_dpp" type="text" class="text-medium" value="<?php if (!empty($obj)) echo $obj->mardis_dpp; ?>" maxlength="70" <?php if (isset($view)) echo 'disabled'; ?>>
                <?php echo form_error('mardis_dpp'); ?>					
                <div class="clear"></div>
            </li>
            <!--
            <li>
                <label>Waktu Dislokasi</label>
                <input class="form-admin" name="mardis_timestamp" id="mardis_timestamp" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->mardis_timestamp; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                       <?php echo form_error('mardis_timestamp'); ?>					
                <div class="clear"></div>
            </li>
            -->
            <li>
                <label>Personil </label>
                <textarea class="form-admin" name="mardis_personnel" rows="1" cols="1" id="elm1"><?php if (!empty($obj)) echo $obj->mardis_personnel; ?></textarea>
                <?php echo form_error('mardis_personnel'); ?>					
                <div class="clear"></div>
            </li>
            <li>
                <label>Matpur </label>
                <textarea class="form-admin" name="mardis_matpur" rows="1" cols="1" id="elm2"><?php if (!empty($obj)) echo $obj->mardis_matpur; ?></textarea>
                <?php echo form_error('mardis_matpur'); ?>					
                <div class="clear"></div>
            </li>
            
            <!-- added by SKM17 { -->
            <?php if (!empty($obj)) { ?>
                <li>
                    <label>&nbsp;</label>
                    <?php if ($obj->mardis_image != null || $obj->mardis_image != '') { ?>
                        <img src="<?php echo base_url() ?>assets/img/upload/main/marinir/<?php echo $obj->mardis_image ?>" width="500" />
                    <?php } else { ?>
                        <span style="font-weight:bold;">Gambar Utama Belum ada</span>
                    <?php } ?>
                    <div class="clear"></div>
                </li>
            <?php } ?>
            <li>
            <label>Dalam Operasi</label>
            <div class="form-admin-radio">
                <label>
                    <input type="radio" name="mardis_in_ops" value="true" <?php if (!empty($obj) && $obj->mardis_in_ops == 't') echo "checked" ?> <?php if (empty($obj)) echo "checked" ?> <?php if (isset($view)) echo 'disabled'; ?>>Ya
                </label><br />
                <label>
                    <input type="radio" name="mardis_in_ops" value="false" <?php if (!empty($obj) && $obj->mardis_in_ops == 'f') echo "checked" ?> <?php if (isset($view)) echo 'disabled'; ?>>Tidak
                </label>
            </div>
            <div class="clear"></div>
            </li>
            <li>
                <label>Gambar Utama</label>
                <input type="file" name="mardis_image" <?php if (isset($view)) echo 'disabled'; ?>/>
                <?php if (isset($error_main_image) && $error_main_image == true) { ?>
                    <span class="note error"><?php echo $msg_error_main_image ?></span>
                <?php } ?>
		        <p style="margin-left:210px;color:red;">*Tipe File Gambar yang diperbolehkan: .gif atau. png atau .jpg atau .jpeg</p>
                <p style="margin-left:210px;color:red;">*Maksimum File Gambar adalah 2 MB (Megabtye)</p>
                <div class="clear"></div>
            </li>
            <!-- end ADDED -->
            
            <!-- <li>
                <label>Waktu Dislokasi Unsur Marinir</label>
                <select name="mardis_timestamp_location" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
                    <option value="06:00" <?php if (date("H:i", strtotime($obj->mar_timestamp_location)) == '06:00') echo 'selected' ?>>06:00</option>
                    <option value="18:00" <?php if (date("H:i", strtotime($obj->mar_timestamp_location)) == '18:00') echo 'selected' ?>>18:00</option>
                </select>
                <div class="clear"></div>
            </li> -->
            <li>
                <p class="tit-form"></p>
                <label>&nbsp;</label>
        		<?php if (!isset($view)) { ?>
		            <input class="button-form" type="submit" value="Simpan">
		            <input class="button-form" type="reset" value="Batal" onclick="redirect('')">
        		<?php } ?>
                <input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
                <div class="clear"></div>
            </li>
        </ul>
    </form>
</div>
