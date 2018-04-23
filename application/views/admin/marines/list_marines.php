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
        $("#addMarines").validate({
            rules:{
                // unit_id: "required",
                port_id: "required"
            },
            messages:{
                // unit_id: "required",
                port_id: "required"
            }
        });
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Satuan Marinir"></div>')
            .html('Semua terkait Satuan Marinir akan ikut dihapus! Hapus data satuan marinir? <div class="clear"></div>').dialog({
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
            $('#addMarines').attr('action', '<?php echo base_url() ?>admin/marines_ctrl/save_logistic');
        });
    //     $('#corps_id').change(
    //     function(){
    //         $('#kolak_id').empty(); // kosongkan dahulu combobox yang ingin diisi datanya
    //         $('#kolak_id').append('<option value="">-Pilih Kesatrian-</option>');
    //         // apabila nilai pilihan tidak kosong, load data propinsi
    //         if($('#corps_id option:selected').val() != ''){
    //             loadKolak($('#corps_id option:selected').val());
    //         }
    //     }
    // );
	$('#mar_personel_ready').keyup(function(){
		var personel_ready = ($(this).val()!='' && $(this).val().length>0)?parseInt($(this).val()):0;
		var personel_notready = ($('#mar_personel_notready').val()!='' && $('#mar_personel_notready').val().length>0)?parseInt($('#mar_personel_notready').val()):0;
		var personel_count_view = $('#mar_personel_count_view');
		var personel_count = $('#mar_personel_count');
		if(personel_ready+personel_notready==0){
			personel_count_view.val('');
			personel_count.val('');
		}else{
			personel_count_view.val(personel_ready+personel_notready);
			personel_count.val(personel_ready+personel_notready);
		}
	}).keydown(function(){
		var personel_ready = ($(this).val()!='' && $(this).val().length>0)?parseInt($(this).val()):0;
		var personel_notready = ($('#mar_personel_notready').val()!='' && $('#mar_personel_notready').val().length>0)?parseInt($('#mar_personel_notready').val()):0;
		var personel_count_view = $('#mar_personel_count_view');
		var personel_count = $('#mar_personel_count');
		if(personel_ready+personel_notready==0){
			personel_count_view.val('');
			personel_count.val('');
		}else{
			personel_count_view.val(personel_ready+personel_notready);
			personel_count.val(personel_ready+personel_notready);
		}
	});
	$('#mar_personel_notready').keyup(function(){
		var personel_ready = ($('#mar_personel_ready').val()!='' && $('#mar_personel_ready').val().length>0)?parseInt($('#mar_personel_ready').val()):0;
		var personel_notready = ($(this).val()!='' && $(this).val().length>0)?parseInt($(this).val()):0;
		var personel_count_view = $('#mar_personel_count_view');
		var personel_count = $('#mar_personel_count');
		if(personel_ready+personel_notready==0){
			personel_count_view.val('');
			personel_count.val('');
		}else{
			personel_count_view.val(personel_ready+personel_notready);
			personel_count.val(personel_ready+personel_notready);
		}
	}).keydown(function(){
		var personel_ready = ($('#mar_personel_ready').val()!='' && $('#mar_personel_ready').val().length>0)?parseInt($('#mar_personel_ready').val()):0;
		var personel_notready = ($(this).val()!='' && $(this).val().length>0)?parseInt($(this).val()):0;
		var personel_count_view = $('#mar_personel_count_view');
		var personel_count = $('#mar_personel_count');
		if(personel_ready+personel_notready==0){
			personel_count_view.val('');
			personel_count.val('');
		}else{
			personel_count_view.val(personel_ready+personel_notready);
			personel_count.val(personel_ready+personel_notready);
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
        window.location = "<?php echo base_url() ?>admin/marines_ctrl" + tail;
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
    function loadKolak(parentId){
        // berikan kondisi sedang loading data ketika proses pengambilan data
        $.post('<?php echo base_url() ?>admin/marines_ctrl/get_kolak', // request ke file load_data.php
        {parent_id: parentId},
        function(data){
            if(data.error == undefined){
                $('#kolak_id').empty();
                // kosongkan dahulu combobox yang ingin diisi datanya
                $('#kolak_id').append('<option value="">-Pilih Kesatrian-</option>'); // buat pilihan awal pada combobox
                for(var x=0;x<data.length;x++){
                    // berikut adalah cara singkat untuk menambahkan element option pada tag <select>
                    $('#kolak_id').append($('<option></option>').val(data[x].kolak_id).text(data[x].kolak_description));
                }
                $('#loading').text(''); // hilangkan text loading

            }else{
                //alert(data.error); // jika ada respon error tampilkan alert
                $('#combobox_'+type).empty();
            }
        },'json' // format respon yang diterima langsung di convert menjadi JSON
    );
    }
</script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/tiny_mce.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        mode : "textareas",
        theme : "simple"
    });
</script>

<div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
    
<p class="tit-form">Daftar Satuan Marinir <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
<div class="filtering" style="display: none;">
    <form action="<?php echo base_url().'admin/marines_ctrl/index/' ?>" method="post" id="form_search_filter">
        <ul class="filter-form">            
            <li>
                <label>Kesatuan</label><br />
                <select name="unit_id" class='filter_param'>
                    <option value="">-Pilih Kesatuan-</option>
                    <?php foreach ($marines_unit as $row) { ?>
                        <?php if (($this->input->get('unit_id')) && $this->input->get('unit_id') == $row->unit_id) { ?>
                            <option value="<?php echo $row->unit_id ?>" selected><?php echo $row->unit_name ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->unit_id ?>"><?php echo $row->unit_name ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </li>
            
            <li>
                <label>Kedudukan</label><br />
                <select name="corps_id" class='filter_param'>
                    <option value="">-Pilih Komando-</option>
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
    <thead>
        <tr class="tittab">
            <td class="header">No</td>
            <td class="header" style="cursor: pointer ;">Kesatuan</td>
            <td class="header" style="cursor: pointer ;">Kedudukan</td>
            <td class="header" style="cursor: pointer ;">Personil</td>
            <td class="header" style="cursor: pointer ;">Matpur</td>
            <td class="header delete" style="width: 80px;">Aksi</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        if (!empty($marines)) {
            foreach ($marines as $row) {
                ?>
                <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                    <td><?php echo ($count++)+$offset; ?></td>
                    <td><?php echo $row->unit_name; ?></td>
                    <td><?php echo $row->corps_name; ?></td>
                    <td><?php echo $row->mar_personel_desc; ?></td>
                    <td><?php echo $row->mar_matpur_desc; ?></td>
                    <td class="action">
                        <a href="<?php echo base_url(); ?>admin/marines_ctrl/view/<?php echo $row->mar_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-view"></div></a> 
                        <?php if (is_has_access('marines_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/marines_ctrl/edit/<?php echo $row->mar_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-edit"></div></a> 
                        <?php } ?>
                        <?php if (is_has_access('marines_ctrl-delete', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/marines_ctrl/delete/<?php echo $row->mar_id . '?' . http_build_query($_GET) ?>" class="delete-tab"><div class="tab-delete"></div></a></td>
                    	<?php } ?>
                </tr>
                <?php
            }
        }
        ?>

    </tbody>
</table>
<br />
<div class="pagination">
			<?php echo $pagination?>
		</div>
<br />
<?php if (is_has_access('marines_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
    <p id="form-pos" class="tit-form">Entri Data Satuan Marinir</p>
    <form action="<?php echo base_url() ?>admin/marines_ctrl/save" method="post" id="addMarines" enctype="multipart/form-data">
        <?php if (!empty($obj)) { ?>
            <input class="form-admin" type="hidden" name="mar_id" value="<?php if (!empty($obj)) echo $obj->mar_id; ?>" />
        <?php } ?>
        <ul class="form-admin">
            <li>
                <label>Kesatuan * </label>
                <select name="unit_id" class="form-admin" id="unit_id" <?php if (isset($view)) echo 'disabled'; ?>>
                    <option value="" selected>-Pilih Kesatuan-</option>
                    <?php foreach ($marines_unit as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->unit_id == $row->unit_id) { ?>
                            <option value="<?php echo $row->unit_id ?>" selected><?php echo $row->unit_name ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->unit_id ?>"><?php echo $row->unit_name ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <div class="clear"></div>
            </li>
            <li>
                <label>Kedudukan * </label>
                <select name="corps_id" class="form-admin" id="corps_id" <?php if (isset($view)) echo 'disabled'; ?>>
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
            <!--<li>
                <label>Kesatrian</label>
                <select name="kolak_id" class="form-admin" id="kolak_id" <?php if (isset($view)) echo 'disabled'; ?>>
                    <option value="" selected>-Pilih Kesatrian-</option>
                    <?php if (!empty($obj)) { ?>
                        <?php foreach ($marines_kolak_exist as $row) { ?>
                            <?php if ($obj->kolak_id == $row->kolak_id) { ?>
                                <option value="<?php echo $row->kolak_id ?>" selected><?php echo $row->kolak_description ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $row->kolak_id ?>"><?php echo $row->kolak_description ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </select>
                <div class="clear"></div>
            </li>-->
            <!--<li>
                <label>Jenis</label>
                <?php
                $stat = 'class="form-admin"';
                if (isset($view)){
                    $stat .= 'disabled';
                }
                if (!empty($obj)) {
                    echo form_dropdown('martype_id', $marines_type, $obj->martype_id, $stat);
                } else {
                    echo form_dropdown('martype_id', $marines_type, '', $stat);
                }
                ?>
                <div class="clear"></div>
            </li>-->
            <li>
                <label>Lokasi </label>
                <input class="form-admin" name="mar_location" type="text" class="text-medium" value="<?php if (!empty($obj)) echo $obj->mar_location; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>>
                <?php echo form_error('mar_location'); ?>					
                <div class="clear"></div>
            </li>
            <li>
                <label>Lintang </label>
                <input class="form-admin two-digit" name="mar_dlat" maxlength="3"  maxlength="3" type="text" class="text-medium" <?php if (!empty($obj) && $obj->mar_isrealtime == 't') echo "readonly" ?>
                       value="<?php if (!empty($obj)) echo geoComponent($obj->mar_lat, 'd'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
                <input class="form-admin two-digit" name="mar_mlat" maxlength="2"  type="text" class="text-medium" <?php if (!empty($obj) && $obj->mar_isrealtime == 't') echo "readonly" ?>
                       value="<?php if (!empty($obj)) echo geoComponent($obj->mar_lat, 'm'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
                <input class="form-admin two-digit" name="mar_slat" maxlength="2"  type="text" class="text-medium" <?php if (!empty($obj) && $obj->mar_isrealtime == 't') echo "readonly" ?>
                       value="<?php if (!empty($obj)) echo geoComponent($obj->mar_lat, 's'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

                <?php
                $stat = 'class="form-admin" style="width: 47px;"';
                if (!empty($obj) && $obj->mar_isrealtime == 't' || isset($view))
                    $stat = 'disabled="disabled"';

                if (!empty($obj))
                    echo form_dropdown('mar_rlat', array(1 => 'U', -1 => 'S'), geoComponent($obj->mar_lat, 'r'), $stat);
                else
                    echo form_dropdown('mar_rlat', array(1 => 'U', -1 => 'S'), '', $stat);
                ?>

                <?php echo form_error('mar_lat'); ?>
                <div class="clear"></div>
            </li>
            <li>
                <label>Bujur </label>
                <input class="form-admin two-digit" name="mar_dlon" maxlength="3" type="text" class="text-medium" <?php if (!empty($obj) && $obj->mar_isrealtime == 't') echo "readonly" ?>
                       value="<?php if (!empty($obj)) echo geoComponent($obj->mar_lon, 'd'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
                <input class="form-admin two-digit" name="mar_mlon" maxlength="2" type="text" class="text-medium" <?php if (!empty($obj) && $obj->mar_isrealtime == 't') echo "readonly" ?>
                       value="<?php if (!empty($obj)) echo geoComponent($obj->mar_lon, 'm'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
                <input class="form-admin two-digit" name="mar_slon" maxlength="2" type="text" class="text-medium" <?php if (!empty($obj) && $obj->mar_isrealtime == 't') echo "readonly" ?>
                       value="<?php if (!empty($obj)) echo geoComponent($obj->mar_lon, 's'); ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>

                <?php
                $stat = 'class="form-admin" style="width: 47px;"';
                if (!empty($obj) && $obj->mar_isrealtime == 't' || isset($view))
                    $stat = 'disabled="disabled"';

                if (!empty($obj))
                    echo form_dropdown('mar_rlon', array(1 => 'T', -1 => 'B'), geoComponent($obj->mar_lon, 'r'), $stat);
                else
                    echo form_dropdown('mar_rlon', array(1 => 'T', -1 => 'B'), '', $stat);
                ?>
                
                <?php echo form_error('mar_lon'); ?>
                <div class="clear"></div>
            </li>
            <li>
                <label>Personil </label>
                <textarea class="form-admin" name="mar_personel_desc" rows="1" cols="1" id="elm2"><?php if (!empty($obj)) echo $obj->mar_personel_desc; ?></textarea>
                <?php echo form_error('mar_personel_desc'); ?>					
                <div class="clear"></div>
            </li>
            <li>
                <label>Matpur </label>
                <textarea class="form-admin" name="mar_matpur_desc" rows="1" cols="1" id="elm3"><?php if (!empty($obj)) echo $obj->mar_matpur_desc; ?></textarea>
                <?php echo form_error('mar_matpur_desc'); ?>					
                <div class="clear"></div>
            </li>
                
            <!-- added by SKM17 -->
            <li>
                <label>Dalam Operasi</label>
                <div class="form-admin-radio">
                    <label>
                        <input type="radio" name="mar_in_ops" value="true" <?php if (!empty($obj) && $obj->mar_in_ops == 't') echo "checked" ?> <?php if (empty($obj)) echo "checked" ?> <?php if (isset($view)) echo 'disabled'; ?>>Ya
                    </label><br />
                    <label>
                        <input type="radio" name="mar_in_ops" value="false" <?php if (!empty($obj) && $obj->mar_in_ops == 'f') echo "checked" ?> <?php if (isset($view)) echo 'disabled'; ?>>Tidak
                    </label>
                </div>
                <div class="clear"></div>
            </li>
            <?php if (!empty($obj)) { ?>
                <li>
                    <label>&nbsp;</label>
                    <?php if ($obj->mar_image != null || $obj->mar_image != '') { ?>
                        <img src="<?php echo base_url() ?>assets/img/upload/main/marinir/<?php echo $obj->mar_image ?>" width="500" />
                    <?php } else { ?>
                        <span style="font-weight:bold;">Gambar Utama Belum ada</span>
                    <?php } ?>
                    <div class="clear"></div>
                </li>
            <?php } ?>
            <li>
                <label>Gambar Utama</label>
                <input type="file" name="mar_image" <?php if (isset($view)) echo 'disabled'; ?>/>
                <?php if (isset($error_main_image) && $error_main_image == true) { ?>
                    <span class="note error"><?php echo $msg_error_main_image ?></span>
                <?php } ?>
		        <p style="margin-left:210px;color:red;">*Tipe File Gambar yang diperbolehkan: .gif atau. png atau .jpg atau .jpeg</p>

                 <p style="margin-left:210px;color:red;">*Maksimum File Gambar adalah 2 MB (Megabtye)  </p>
                <div class="clear"></div> 
            </li>
            <!-- end ADDED -->
             
            <!-- commented by SKM17
            <li>
                <label>Uraian </label>
                <textarea class="form-admin" name="mar_description" rows="1" cols="1" id="elm1"><?php if (!empty($obj)) echo $obj->mar_description; ?></textarea>
                <?php echo form_error('mar_description'); ?>					
                <div class="clear"></div>
            </li>
            -->
            <!-- Uncoment below code for personil data-->
            <!--<li>
                <label>Jumlah Personil :</label>
                <div class="clear"></div>
                <label>Riil</label>
                <input class="form-admin"  id="mar_personel_count_view" type="text" class="text-medium" style="width: 50px"
                       value="<?php if (!empty($obj)) echo $obj->mar_personel_count; ?>" disabled />
                       <?php echo form_error('mar_personel_count'); ?>					
                <div class="clear"></div><br/>
                <input  name="mar_personel_count" id="mar_personel_count" type="hidden"
                       value="<?php if (!empty($obj)) echo $obj->mar_personel_count; ?>" />					
                <label>Siap</label>
                <input class="form-admin"  name="mar_personel_ready" id="mar_personel_ready" type="text" class="text-medium" style="width: 50px"
                       value="<?php if (!empty($obj)) echo $obj->mar_personel_ready; ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>>
                       <?php echo form_error('mar_personel_ready'); ?>					
                <div class="clear"></div><br/>
                <label>Tidak Siap</label>
                <input class="form-admin"  name="mar_personel_notready" id="mar_personel_notready" type="text" class="text-medium" style="width: 50px"
                       value="<?php if (!empty($obj)) echo $obj->mar_personel_notready; ?>" onkeypress="return isNumberKey(event)" <?php if (isset($view)) echo 'disabled'; ?>> 
                       <?php echo form_error('mar_personel_notready'); ?>					
                <div class="clear"></div><br/>
            </li>-->
            <!-- commented by SKM17
            <li>
                <label>Status Marinir</label>
                <?php
                $conds = array('' => '-- Pilih Status Marinir --', 1 => 'SIAP', 2 => 'SIAP PANGKALAN', 3 => 'TIDAK SIAP');
                ?>
                <select name="marcond_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
                    <?php foreach ($conds as $key => $val) { ?>
                        <?php if ((!empty($obj)) && $key == $obj->marcond_id) { ?>
                            <option value="<?php echo $key ?>" selected ><?php echo $val ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key ?>"><?php echo $val ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <div class="clear"></div>
            </li>
            -->
            <li>
            	<p class="tit-form"></p>
                <label>&nbsp;</label>
            	<?php if (!isset($view)){ ?>
		            <input class="button-form" type="submit" value="Simpan">
		            <input class="button-form" type="reset" onclick="redirect('')" value="Batal">
	            <?php }?>
                <input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
                <div class="clear"></div>
            </li>
		</ul>
    </form>
<?php } ?>
</div>
<div class="clear"></div>
