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
        $("#addAeroplane").validate({
            rules:{
                aertype_id: "required",
                aer_name: "required",
                corps_id: "required",
                unit_id: "required",
                aercond_id: "required"
            },
            messages:{
                aertype_id: "required",
                aer_name: "required",
                corps_id: "required",
                unit_id: "required",
                aercond_id: "required"
            }
        });
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Hapus Pesawat Udara"></div>')
            .html('Semua terkait Pesawat Udara akan ikut dihapus! Hapus data pesawat udara? <div class="clear"></div>').dialog({
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
        $('#add_new_logistic').click(function(){
            $('#addAeroplane').attr('action', '<?php echo base_url() ?>admin/aeroplane_ctrl/save_logistic');
        });
        //calculate hour
        $('#aer_pjl_ops').keyup(function(){
            var pjl_ops = $('#aer_pjl_ops').val();
            var realitation = $('#aer_realitation').val();
            if(isNaN(pjl_ops)==false ){
                if(realitation == ""){realitation = 0;}
                if(pjl_ops == ""){pjl_ops = 0;}
                var sisa = pjl_ops-realitation;
                $('#sisa_jam').val(sisa);
            }
        });
        $('#aer_realitation').keyup(function(){
            var pjl_ops = $('#aer_pjl_ops').val();
            var realitation = $('#aer_realitation').val();
            if(isNaN(pjl_ops)==false ){
                if(realitation == ""){realitation = 0;}
                if(pjl_ops == ""){pjl_ops = 0;}
                var sisa = pjl_ops-realitation;
                $('#sisa_jam').val(sisa);
            }
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
        window.location = "<?php echo base_url() ?>admin/aeroplane_ctrl" + tail;
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

    <p class="tit-form">Daftar Pesawat <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
    <div class="filtering" style="display: none;">
        <form action="<?php echo base_url().'admin/aeroplane_ctrl' ?>" method="post" id="form_search_filter">
            <ul class="filter-form">
                <li>
                    <label>Nama Pesawat</label><br />
                    <input type="text" placeholder="Nama Pesawat" name="aer_name" class='filter_param' value="<?php echo $this->input->get('aer_name'); ?>" /> <!-- onkeypress="search_enter_press(event);" /> -->
                </li>
                <!--<li>
                    <label>Realtime</label><br />
                    <select name="aer_isrealtime" class='filter_param'>
                        <option value="">Realtime</option>
                <?php foreach ($realtime as $key => $real) { ?>
                    <?php if (($this->input->get('aer_isrealtime')) && $this->input->get('aer_isrealtime') == $key) { ?>
                                                                                                        <option value="<?php echo $key ?>" selected><?php echo $real ?></option>
                    <?php } else { ?>
                                                                                                        <option value="<?php echo $key ?>"><?php echo $real ?></option>
                    <?php } ?>
                <?php } ?>
                    </select>
                </li>-->
                <!--<li>
                    <label>Skuadron</label><br />
                    <select name="station_id" class='filter_param'>
                        <option value="">Skuadron</option>
                <?php foreach ($skuadron as $row) { ?>
                    <?php if (($this->input->get('station_id')) && $this->input->get('station_id') == $row->station_id) { ?>
                                                                        <option value="<?php echo $row->station_id ?>" selected><?php echo $row->station_name ?></option>
                    <?php } else { ?>
                                                                        <option value="<?php echo $row->station_id ?>"><?php echo $row->station_name ?></option>
                    <?php } ?>
                <?php } ?>
                    </select>
                </li>-->
                <li>
                    <label>Tipe Pesawat</label><br />
                    <select name="aertype_id" class='filter_param'>
                        <option value="">-Pilih Tipe Pesawat-</option>
                        <?php foreach ($aeroplane_type as $row) { ?>
                            <?php if (($this->input->get('aertype_id')) && $this->input->get('aertype_id') == $row->aertype_id) { ?>
                                <option value="<?php echo $row->aertype_id ?>" selected><?php echo $row->aertype_name ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $row->aertype_id ?>"><?php echo $row->aertype_name ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </li>
                <li>
                    <label>Pembina</label><br />
                    <select name="corps_id" class='filter_param'>
                        <option value="">-Pilih Pembina-</option>
                        <?php foreach ($corps as $row) { ?>
                            <?php if (($this->input->get('corps_id')) && $this->input->get('corps_id') == $row->corps_id) { ?>
                                <option value="<?php echo $row->corps_id ?>" selected><?php echo $row->corps_name ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $row->corps_id ?>"><?php echo $row->corps_name ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
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

        <tr class="tittab">
            <td class="header">No</td>
            <td class="header" style="cursor: pointer ;">Nama Pesawat</td>
            <td class="header" style="cursor: pointer ;">Tipe Pesawat</td>
            <td class="header" style="cursor: pointer ;">Pembina</td>
            <td class="header" style="cursor: pointer ;">Kesatuan</td>
            <td class="header" style="cursor: pointer ;">Status Pesawat</td>
            <td class="header delete" style="width: 80px;">Aksi</td>
        </tr>
        <?php
        $count = 1;
        if (!empty($aeroplane)) {
            foreach ($aeroplane as $row) {
                ?>
                <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                    <td><?php echo ($count++)+$offset; ?></td>
                    <td><?php echo $row->aer_name; ?></td>
                    <td><?php echo $row->aertype_name; ?></td>
                    <td><?php echo $row->corps_name; ?></td>
                    <td><?php echo $row->unit_name; ?></td>
                    <td><?php echo $row->aercond_description; ?></td>

                    <td class="action">
                        <a href="<?php echo base_url(); ?>admin/aeroplane_ctrl/view/<?php echo $row->aer_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-view"></div></a> 
                        <?php if (is_has_access('aeroplane_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/aeroplane_ctrl/edit/<?php echo $row->aer_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-edit"></div></a> 
                        <?php } ?>
                        <?php if (is_has_access('aeroplane_ctrl-delete', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/aeroplane_ctrl/delete/<?php echo $row->aer_id . '?' . http_build_query($_GET) ?>" class="delete-tab"><div class="tab-delete"></div></a>
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
    <?php if (is_has_access('aeroplane_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
        <p id="form-pos" class="tit-form">Data Pesawat</p>
        <form action="<?php echo base_url() ?>admin/aeroplane_ctrl/save" method="post" id="addAeroplane" enctype="multipart/form-data">
            <?php if (!empty($obj)) { ?>
                <input class="form-admin" type="hidden" name="aer_id" value="<?php if (!empty($obj)) echo $obj->aer_id; ?>" />
            <?php } ?>
            <ul class="form-admin">
                <li>
                    <label>Nama Pesawat * </label>
                    <input class="form-admin" name="aer_name"  type="text" class="text-medium" id="aer_name"
                           value="<?php if (!empty($obj)) echo $obj->aer_name; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('aer_name'); ?>									
                    <div class="clear"></div>
                </li>
                <li>
                    <label>DAN Pesud </label>
                    <input class="form-admin" name="aer_commander"  type="text" class="text-medium" id="aer_commander"
                           value="<?php if (!empty($obj)) echo $obj->aer_commander; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('aer_commander'); ?>									
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Tipe Pesawat * </label>
                    <select name="aertype_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
                        <option value="" selected>-Pilih Tipe-</option>
                        <?php foreach ($aeroplane_type as $row) { ?>
                            <?php if ((!empty($obj)) && $obj->aertype_id == $row->aertype_id) { ?>
                                <option value="<?php echo $row->aertype_id ?>" selected><?php echo $row->aertype_name ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $row->aertype_id ?>"><?php echo $row->aertype_name ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Jenis Ikon </label>
                    <select name="aericon_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
                        <option value="0" selected>-Pilih Ikon-</option>
                        <?php foreach ($aeroplane_icon as $row) { ?>
                            <?php if ((!empty($obj)) && $obj->aericon_id == $row->aericon_id) { ?>
                                <option value="<?php echo $row->aericon_id ?>" selected><?php echo $row->aericon_desc ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $row->aericon_id ?>"><?php echo $row->aericon_desc ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <div class="clear"></div>
                </li>
                <!--<li>
                    <label>Pilot * </label>
                    <select name="psnreff_nrp" class="form-admin">
                        <option value="" selected>-Pilih Pilot-</option>
                <?php foreach ($pilots as $row) { ?>
                    <?php if ((!empty($obj)) && $obj->psnreff_nrp == $row->psnreff_nrp) { ?>
                                                                                        <option value="<?php echo $row->psnreff_nrp ?>" selected><?php echo $row->psnreff_name ?></option>
                    <?php } else { ?>
                                                                                        <option value="<?php echo $row->psnreff_nrp ?>"><?php echo $row->psnreff_name ?></option>
                    <?php } ?>
                <?php } ?>
                    </select>
                    <div class="clear"></div>
                </li>-->
                <li>
                    <label>Pembina * </label>
                    <select name="corps_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
                        <option value="" selected>-Pilih Komando-</option>
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
                <!--<li>
                    <label>Skuadron * </label>
                    <select name="station_id" class="form-admin">
                        <option value="" selected>-Pilih Skuadron-</option>
                <?php foreach ($skuadron as $row) { ?>
                    <?php if ((!empty($obj)) && $obj->station_id == $row->station_id) { ?>
                    	<option value="<?php echo $row->station_id ?>" selected><?php echo $row->station_name ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $row->station_id ?>"><?php echo $row->station_name ?></option>
                    <?php } ?>
                <?php } ?>
                    </select>				
                    <div class="clear"></div>
                </li>-->
                <li>
                    <label>Kondisi Pesawat Udara * </label>
                    <?php
                    $conds = array('' => '-- Pilih Kondisi --', 1 => 'SIAP', 2 => 'SIAP PANGKALAN', 3 => 'TIDAK SIAP');
                    ?>
                    <select name="aercond_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
                        <?php foreach ($conds as $key => $val) { ?>
                            <?php if ((!empty($obj)) && $key == $obj->aercond_id) { ?>
                                <option value="<?php echo $key ?>" selected ><?php echo $val ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $key ?>"><?php echo $val ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <div class="clear"></div>
                </li>
				<li>

                    <label>Kesatuan *</label>
                    <?php
                    if (!empty($obj))
                        if (isset($view)) {
                            echo form_dropdown('unit_id', $unit, $obj->unit_id, 'class="form-admin" disabled');
                        } else {
                            echo form_dropdown('unit_id', $unit, $obj->unit_id, 'class="form-admin"');
                        }
                    else
                        echo form_dropdown('unit_id', $unit, '', 'class="form-admin"');
                    ?>

                    <div class="clear"></div>
                </li>
                
                <!-- added by SKM17 -->
                <li>
                    <label>Dalam Operasi</label>
                    <div class="form-admin-radio">
                        <label>
                            <input type="radio" name="aer_is_in_operation" value="true" <?php if (!empty($obj) && $obj->aer_is_in_operation == 't') echo "checked" ?> <?php if (empty($obj)) echo "checked" ?> <?php if (isset($view)) echo 'disabled'; ?>>Ya
                        </label><br />
                        <label>
                            <input type="radio" name="aer_is_in_operation" value="false" <?php if (!empty($obj) && $obj->aer_is_in_operation == 'f') echo "checked" ?> <?php if (isset($view)) echo 'disabled'; ?>>Tidak
                        </label>
                    </div>
                    <div class="clear"></div>
                </li>
                <!-- END ADDED -->
                
                <li>
                    <label>PJT  Ops</label>
                    <input class="form-admin" name="aer_pjl_ops" type="text" class="text-small" id="aer_pjl_ops" onkeypress="return isNumberKey(event)"
                           value="<?php if (!empty($obj)) echo $obj->aer_pjl_ops; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>> Jam
                           <?php echo form_error('aer_pjl_ops'); ?>			
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Realisasi</label>
                    <input class="form-admin" name="aer_realitation" type="text" class="text-small" id="aer_realitation" onkeypress="return isNumberKey(event)"
                           value="<?php if (!empty($obj)) echo $obj->aer_realitation; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>> Jam
                           <?php echo form_error('aer_realitation'); ?>			
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Sisa</label>
                    <input class="form-admin" type="text" class="text-small" name="sisa_jam" id="sisa_jam" readonly value="<?php if (!empty($obj)) echo ($obj->aer_pjl_ops - $obj->aer_realitation); ?>" <?php if (isset($view)) echo 'disabled'; ?>> Jam
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Data Taktis</label>
                    <textarea class="form-admin" id="elm1" name="aer_data_taktis" style="width: 30%"><?php if (!empty($obj)) echo $obj->aer_data_taktis; ?></textarea>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Data Utama</label>
                    <textarea class="form-admin" id="elm2" name="aer_data_utama" style="width: 30%"><?php if (!empty($obj)) echo $obj->aer_data_utama; ?></textarea>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Sistem Penggerak Pokok</label>
                    <textarea class="form-admin" id="elm3" name="aer_sistem_penggerak" style="width: 30%"><?php if (!empty($obj)) echo $obj->aer_sistem_penggerak; ?></textarea>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Sistem Alat Penolong</label>
                    <textarea class="form-admin" id="elm4" name="aer_alat_penolong" style="width: 30%"><?php if (!empty($obj)) echo $obj->aer_alat_penolong; ?></textarea>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Sistem Kendali dan Senjata</label>
                    <textarea class="form-admin" id="elm5" name="aer_sistem_kendali" style="width: 30%"><?php if (!empty($obj)) echo $obj->aer_sistem_kendali; ?></textarea>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Data Dukungan Logistik dan Akomodasi</label>
                    <textarea class="form-admin" id="elm6" name="aer_logistik" style="width: 30%"><?php if (!empty($obj)) echo $obj->aer_logistik; ?></textarea>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Fasilitas Pangkalan Udara yang diperlukan</label>
                    <textarea class="form-admin" id="elm7" name="aer_facility_needed" style="width: 30%"><?php if (!empty($obj)) echo $obj->aer_facility_needed; ?></textarea>
                    <div class="clear"></div>
                </li>
                
                <!-- added by SKM17 { -->
                <?php if (!empty($obj)) { ?>
                    <li>
                        <label>&nbsp;</label>
                        <?php if ($obj->aer_image != null || $obj->aer_image != '') { ?>
                            <img src="<?php echo base_url() ?>assets/img/upload/main/pesud/<?php echo $obj->aer_image ?>" width="500" />
                        <?php } else { ?>
                            <span style="font-weight:bold;">Gambar Utama Belum ada</span>
                        <?php } ?>
                        <div class="clear"></div>
                    </li>
                <?php } ?>
                <li>
                    <label>Gambar Utama</label>
                    <input type="file" name="aer_image" <?php if (isset($view)) echo 'disabled'; ?>/>
                    <?php if (isset($error_main_image) && $error_main_image == true) { ?>
                        <span class="note error"><?php echo $msg_error_main_image ?></span>
                    <?php } ?>
			        <p style="margin-left:210px;color:red;">*Tipe File Gambar yang diperbolehkan: .gif atau. png atau .jpg atau .jpeg</p>
                    <p style="margin-left:210px;color:red;">*Maksimum File Gambar adalah 2 MB (Megabtye)  </p>
                    <div class="clear"></div>
                </li>
                <!-- end ADDED -->
                
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
    <div class="clear"></div>
</div>
