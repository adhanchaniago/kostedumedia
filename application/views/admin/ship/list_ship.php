<script type="text/javascript" src="<?php echo $this->config->item('socket_ip') ?>/socket.io/socket.io.js"></script>

<?php if ($this->session->flashdata('info')) { ?>
    <script>
        $(document).ready(function() {
    // added by SKM17
    <?php if ($this->session->flashdata('trigger_io')) { ?>
                var socket = io.connect('<?php echo $this->config->item('socket_ip') ?>');
                socket.emit('reqShipUpdate');
    <?php } ?>
            $('.success').html("<strong> <?php echo $this->session->flashdata('info'); ?>");
            $('.success').attr('style','');
            $('.success').delay(10000).fadeOut('slow');
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $.validator.addMethod("regex", function(value, element, regexpr) {          
			return regexpr.test(value);
		}, "Please enter a valid format.");
        $("#addShip").validate({
            rules:{
				ship_id: {
					required : true,
					regex : /^[\w]+$/
				},
				ship_abbr : {
					required : true,
					regex : /^[\w]+$/
				},
				ship_name : {
					required : true,
					regex : /^[\w\s]+$/
				},
				/*ship_commander :{
					regex : /^(?:[\w\s\'\.\,\/]{3,}|)$/
				},*/
				ship_pjl_ops : {
					regex : /^[\d]+((\.|\,)[\d]+)?$/
				},
				ship_realitation : {
					regex : /^[\d]+((\.|\,)[\d]+)?$/
				},
				sisa_jam : {
					regex : /^[\d]+((\.|\,)[\d]+)?$/
				},
                shipcond_id: "required",
                corps_id: "required",
                shiptype_id: "required",
                unit_id: "required",
                //ship_stat_id: "required",
                //ship_hullnumber: "required",
				ship_created : {
					regex : /^(?:[\d]{4}|)$/
				},
				ship_factory : {
					regex : /^(?:[\w\s\.\,\'\\-]+|)$/
				},
				ship_country_created : {
					regex : /^(?:[\w\s]+|)$/
				},
				ship_work_year : {
					regex : /^(?:[\d]{4}|)$/
				},
				ship_nickname : {
					regex : /^(?:[\w]+|)$/
				},
				/*ship_weight : {
					regex : /^(?:([\d]+((\.|\,)[\d]+)?)|)$/
				},
				ship_length : {
					regex : /^(?:([\d]+((\.|\,)[\d]+)?)|)$/
				},
				ship_width : {
					regex : /^(?:([\d]+((\.|\,)[\d]+)?)|)$/
				},
				ship_draft : {
					regex : /^(?:([\d]+((\.|\,)[\d]+)?)|)$/
				},
				ship_machine : {
					regex : /^(?:([\d]+((\.|\,)[\d]+)?)|)$/
				},
				ship_speed_desc : {
					regex : /^(?:([\d]+((\.|\,)[\d]+)?)|)$/
				},
				ship_people : {
					regex : /^(?:([\d]+((\.|\,)[\d]+)?)|)$/
				},*/
				ship_cctv_ip : {
					regex : /^(?:(?:[0-9]{1,3}\.){3}[0-9]{3}|)$/
				}
            },
            messages:{
                ship_id: {
					required : "required",
					regex : "not valid format"
				},
				ship_abbr : {
					required : "required",
					regex : "not valid format"
				},
				ship_name : {
					required : "required",
					regex : "not valid format"
				},
				/*ship_commander : {
					regex : "not valid format"
				},*/
				ship_pjl_ops : {
					regex : "not valid format"
				},
				ship_realitation : {
					regex : "not valid format"
				},
				sisa_jam : {
					regex : "not valid format"
				},
                shipcond_id: "required",
                corps_id: "required",
                shiptype_id: "required",
                unit_id: "required",
                //ship_stat_id: "required",
                //ship_hullnumber: "required",
				ship_created : {
					regex : "not valid format"
				},
				ship_factory : {
					regex : "not valid format"
				},
				ship_country_created : {
					regex : "not valid format"
				},
				ship_work_year : {
					regex : "not valid format"
				},
				ship_nickname : {
					regex : "not valid format"
				},
				/*ship_weight : {
					regex : "not valid format"
				},
				ship_length : {
					regex : "not valid format"
				},
				ship_width : {
					regex : "not valid format"
				},
				ship_draft : {
					regex : "not valid format"
				},
				ship_machine : {
					regex : "not valid format"
				},
				ship_speed_desc : {
					regex : "not valid format"
				},
				ship_people : {
					regex : "not valid format"
				},*/
				ship_cctv_ip : {
					regex : "not valid format"
				},
            }
        });
        /*$("#ship_created").datepicker({ dateFormat:'yy-mm-dd',changeMonth: true,
            changeYear: true,yearRange: "1945:2015"});*/
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Hapus KRI"></div>')
            .html('Semua terkait KRI akan ikut dihapus! Hapus data KRI? <div class="clear"></div>').dialog({
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
        //calculate hour
        $('#ship_pjl_ops').keyup(function(){
            var pjl_ops = $('#ship_pjl_ops').val();
            var realitation = $('#ship_realitation').val();
            if(isNaN(pjl_ops)==false ){
                if(realitation == ""){realitation = 0;}
                if(pjl_ops == ""){pjl_ops = 0;}
                var sisa = pjl_ops-realitation;
                $('#sisa_jam').val(sisa);
            }
        });
        $('#ship_realitation').keyup(function(){
            var pjl_ops = $('#ship_pjl_ops').val();
            var realitation = $('#ship_realitation').val();
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
    function validateValue(val){
        //look for "Hello"
        var string = $('#'+val);
        var patt=/^.{3,3}$/g;
        var result=patt.test(string);
        return result;
    }
    function redirect(tail){
        window.location = "<?php echo base_url() ?>admin/ship_ctrl" + tail;
    }
    function create_url(){
        var url = $('#form_search_filter').attr('action')+'/?filter=true&';
        var param = '';
        $('.filter_param').each(function(){
            param += $(this).attr('name')+'='+$(this).val()+'&';
        });
        //param = param.substr(0,-1);
        $('#form_search_filter').attr('action',url+param).submit();
        //alert(url+param);
    }
    var count_gallery = 1;
	
    /* commented by SKM17
    function add_gallery_image(){
        $('#gallery_image').append('<li><label>Gambar <span>'+(count_gallery+1)+'<span>:</label><input  name="galeri'+count_gallery+'" type="file" /><div class="clear"></div></li>');
        count_gallery++;
        $('#count_gallery_image').val(count_gallery);
    }
    */
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

    <p class="tit-form">Daftar KRI <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
    <div class="filtering" style="display: none;">
        <form action="<?php echo base_url().'admin/ship_ctrl' ?>" method="post" id="form_search_filter" >
            <ul class="filter-form">
                <li>
                    <label>Nomor Lambung Kapal</label><br />
                    <input type="text" placeholder="Nomor Lambung Kapal" name="ship_id" class='filter_param' value="<?php echo $this->input->get('ship_id'); ?>" />
                </li>
                <li>
                    <label>Singkatan Kapal</label><br />
                    <input type="text" placeholder="Singkatan Kapal" name="ship_abbr" class='filter_param' value="<?php echo $this->input->get('ship_abbr'); ?>" />
                </li>
                <li>
                    <label>Nama Kapal</label><br />
                    <input type="text" placeholder="Nama Kapal" name="ship_name" class='filter_param' value="<?php echo $this->input->get('ship_name'); ?>" />
                </li>
                <li>
                    <label>Kondisi Kapal</label><br />
                    <?php
                    $conds = array('' => '-- Pilih Kondisi Kapal --', 1 => 'SIAP', 2 => 'SIAP PANGKALAN', 3 => 'TIDAK SIAP (REPOWERING)', 4 => 'TIDAK SIAP (HARDEPO)', 5 => 'TIDAK SIAP (HARMEN)', 6 => 'TIDAK SIAP (DOCKING)', 7 => 'TIDAK SIAP (TAPKONIS/HARKAN)', 8 => 'TIDAK SIAP (HARWAT)', 9 => 'TIDAK SIAP (LAIN-LAIN)');
                    ?>
                    <select name="shipcond_id" class="filter_param">
                        <?php foreach ($conds as $key => $val) { ?>
                            <?php if (($this->input->get('shipcond_id')) && $key == $this->input->get('shipcond_id')) { ?>
                                <option value="<?php echo $key ?>" selected ><?php echo $val ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $key ?>"><?php echo $val ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </li>
                
                <!--<li>
                    <label>Status Operasional</label><br />
                    <select name="ship_stat_id" class='filter_param'>
                        <option value="">Status Operasional</option>
                <?php foreach ($ship_status as $row) { ?>
                    <?php if (($this->input->get('shiptype_id')) && $this->input->get('shiptype_id') == $row->ship_stat_id) { ?>
                                                                                                                                <option value="<?php echo $row->ship_stat_id ?>" selected><?php echo $row->ship_stat_desc ?></option>
                    <?php } else { ?>
                                                                                                                                <option value="<?php echo $row->ship_stat_id ?>"><?php echo $row->ship_stat_desc ?></option>
                    <?php } ?>
                <?php } ?>
                    </select>
                </li>-->
                <li>
                    <label>Tipe Kapal</label><br />
                    <select name="shiptype_id" class='filter_param'>
                        <option value="">-Pilih Tipe Kapal-</option>
                        <?php foreach ($ship_type as $row) { ?>
                            <?php if (($this->input->get('shiptype_id')) && $this->input->get('shiptype_id') == $row->shiptype_id) { ?>
                                <option value="<?php echo $row->shiptype_id ?>" selected><?php echo $row->shiptype_desc ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $row->shiptype_id ?>"><?php echo $row->shiptype_desc ?></option>
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
        <thead>
            <tr class="tittab">
                <td class="header">No</th>
                <!-- <td class="header" style="cursor: pointer ;">ship_id</th>
                <td class="header" style="cursor: pointer ;">ship_stat_id</th>
                <td class="header" style="cursor: pointer ;">corps_id</th>
                <td class="header" style="cursor: pointer ;">shiptype_id</th> -->
                <td class="header" style="cursor: pointer ;width: 30px;">Kode Puskodal</th>
                <td class="header" style="cursor: pointer ;">Nama</th>
                <!-- <td class="header" style="cursor: pointer ;">Icon</th> -->
                <td class="header" style="cursor: pointer ;">Kesatuan</th>
                <td class="header" style="cursor: pointer ;">Pembina</th>
                <!-- <td class="header" style="cursor: pointer ;">ship_image</th>
                <td class="header" style="cursor: pointer ;">ship_machinehour</th>
                <td class="header" style="cursor: pointer ;">ship_currenthour</th>
                <td class="header" style="cursor: pointer ;">ship_lasttrans</th>
                <td class="header" style="cursor: pointer ;">ship_iskri</th> -->
                <td class="header" style="cursor: pointer ;">Tipe Kapal</th>
                <td class="header" style="cursor: pointer ;">Status Kapal</th>
                <td class="header delete" style="width: 80px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            if (!empty($ship)) {
                foreach ($ship as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                        <td><?php echo ($i++)+$offset; ?></td>                        
                        <td><?php echo $row->ship_id; ?></td>                        
                        <td><?php echo $row->ship_name; ?></td>                        
                        <td><?php echo $row->unit_name ?></td>
                        <td><?php echo $row->corps_name ?></td>                        
                        <td><?php echo $row->shiptype_desc; ?></td>
                        <td><?php echo $row->shipcond_description ?></td>
                        <td class="action" style="width: 52px;">
                            <a href="<?php echo base_url(); ?>admin/ship_ctrl/view/<?php echo $row->ship_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-view"></div></a> 
                            <?php if (is_has_access('ship_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
                                <a href="<?php echo base_url(); ?>admin/ship_ctrl/edit/<?php echo $row->ship_id . '?' . http_build_query($_GET).'#form-pos' ?>" class="edit-tab"><div class="tab-edit"></div></a> 
                            <?php } ?>
                            <?php if (is_has_access('ship_ctrl-delete', $permission) || is_has_access('*', $permission)) { ?>
                                <a href="<?php echo base_url(); ?>admin/ship_ctrl/delete/<?php echo $row->ship_id . '?' . http_build_query($_GET) ?>" class="delete-tab"><div class="tab-delete"></div></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>

        </tbody>
    </table>

    <div class="pagination">
		<?php echo $pagination?>
	</div>

    <br />
    <?php if (is_has_access('ship_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
        <p id="form-pos" class="tit-form">Entri Data KRI</p>
        <form action="<?php echo base_url() ?>admin/ship_ctrl/save<?php echo '?' . http_build_query($_GET) ?>" method="post" class="" id="addShip" enctype="multipart/form-data">
            <ul class="form-admin">
                <?php if (!empty($obj)) { ?>
                    <input type="hidden" name="ship_id" value="<?php echo $obj->ship_id; ?>" />
                <?php } ?>
                <li>
                    <label>Nomor Lambung * </label>
                    <input class="form-admin" name="ship_id" type="text" class="text-medium" id="ship_id"
                           value="<?php if (!empty($obj)) echo $obj->ship_id; ?>" <?php if (!empty($obj)) echo 'disabled'; ?> >
                           <?php echo form_error('ship_id'); ?>					
                    <div class="clear"></div>
                </li>
				<li>
                    <label>Singkatan Kapal * </label>
                    <input class="form-admin" name="ship_abbr" type="text" class="text-medium" id="ship_abbr"
                           value="<?php if (!empty($obj)) echo $obj->ship_abbr; ?>"  >
                           <?php echo form_error('ship_abbr'); ?>                 
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Nama Kapal * </label>
                    <input class="form-admin" name="ship_name" type="text" class="text-medium" id="ship_name"
                           value="<?php if (!empty($obj)) echo $obj->ship_name; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_name'); ?>					
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Nama Komandan </label>
                    <input class="form-admin" name="ship_commander" type="text" class="text-medium" id="ship_commander"
                           value="<?php if (!empty($obj)) echo $obj->ship_commander; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_commander'); ?>					
                    <div class="clear"></div>
                </li>
                <!--<li>
                    <label>Status Operasional KRI*</label>
                    <select name="ship_stat_id" class="form-admin">
                        <option value="" selected>-Select Status-</option>
                <?php // foreach ($ship_status as $row) { ?>
                <?php // if ((!empty($obj)) && $obj->ship_stat_id == $row->ship_stat_id) { ?>
                                <option value="<?php // echo $row->ship_stat_id               ?>" selected><?php // echo $row->ship_stat_desc               ?></option>
                <?php // } else { ?>
                                <option value="<?php // echo $row->ship_stat_id               ?>"><?php // echo $row->ship_stat_desc               ?></option>
                <?php // } ?>
                <?php // } ?>
                    </select>


                    <div class="clear"></div>
                </li>-->

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
                <li>
                    <label>Pembina *</label>
                    <select name="corps_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
                        <option value="" selected>-Pilih Pembina-</option>
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
                    <label>Tipe Kapal *</label>
                    <select name="shiptype_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
                        <option value="" selected>-Pilih Tipe Kapal-</option>
                        <?php foreach ($ship_type as $row) { ?>
                            <?php if ((!empty($obj)) && $obj->shiptype_id == $row->shiptype_id) { ?>
                                <option value="<?php echo $row->shiptype_id ?>" selected><?php echo $row->shiptype_desc ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $row->shiptype_id ?>"><?php echo $row->shiptype_desc ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <div class="clear"></div>
                </li>
                <!--<li>
                    <label>Nomer Lambung Kapal * </label>
                    <input class="form-admin" name="ship_hullnumber" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_hullnumber; ?>" >
                <?php echo form_error('ship_hullnumber'); ?>					
                    <div class="clear"></div></li>-->
                <li>
                    <label>Kondisi Kapal * </label>
                    <?php
                        $conds = array('' => '-- Pilih Kondisi Kapal --', 1 => 'SIAP', 2 => 'SIAP PANGKALAN', 3 => 'TIDAK SIAP (REPOWERING)', 4 => 'TIDAK SIAP (HARDEPO)', 5 => 'TIDAK SIAP (HARMEN)', 6 => 'TIDAK SIAP (DOCKING)', 7 => 'TIDAK SIAP (TAPKONIS/HARKAN)', 8 => 'TIDAK SIAP (HARWAT)', 9 => 'TIDAK SIAP (LAIN-LAIN)');
                    ?>
                    <select name="shipcond_id" class="form-admin" <?php if (isset($view)) echo 'disabled'; ?>>
                        <?php foreach ($conds as $key => $val) { ?>
                            <?php if ((!empty($obj)) && $key == $obj->shipcond_id) { ?>
                                <option value="<?php echo $key ?>" selected ><?php echo $val ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $key ?>"><?php echo $val ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <div class="clear"></div>
                </li>
                
                <!-- added by SKM17 -->
                <li>
                    <label>Dalam Operasi</label>
                    <div class="form-admin-radio">
                        <label>
                            <input type="radio" name="ship_is_in_operation" value="true" <?php if (!empty($obj) && $obj->ship_is_in_operation == 't') echo "checked" ?> <?php if (empty($obj)) echo "checked" ?> <?php if (isset($view)) echo 'disabled'; ?>>Ya
                        </label><br />
                        <label>
                            <input type="radio" name="ship_is_in_operation" value="false" <?php if (!empty($obj) && $obj->ship_is_in_operation == 'f') echo "checked" ?> <?php if (isset($view)) echo 'disabled'; ?>>Tidak
                        </label>
                    </div>
                    <div class="clear"></div>
                </li>
                <!-- END ADDED -->
                
                <li>
                    <label>DSP</label>
                    <textarea class="form-admin" id="elm1" name="ship_dsp" style="width: 30%" <?php if (isset($view)) echo 'disabled'; ?>><?php if (!empty($obj)) echo $obj->ship_dsp; ?></textarea>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Kondisi Teknis</label>
                    <textarea class="form-admin" id="elm2" name="ship_condition" style="width: 30%" <?php if (isset($view)) echo 'disabled'; ?>><?php if (!empty($obj)) echo $obj->ship_condition; ?></textarea>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>PJL Ops</label>
                    <input class="form-admin" name="ship_pjl_ops" type="text" class="text-small" id="ship_pjl_ops" onkeypress="return isNumberKey(event)"
                           value="<?php if (!empty($obj)) echo $obj->ship_pjl_ops; else echo '0'; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>> Jam
                           <?php echo form_error('ship_pjl_ops'); ?> 
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Realisasi</label>
                    <input class="form-admin" name="ship_realitation" type="text" class="text-small" id="ship_realitation" onkeypress="return isNumberKey(event)"
                           value="<?php if (!empty($obj)) echo $obj->ship_realitation;else echo '0'; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>> Jam
                           <?php echo form_error('ship_realitation'); ?>			
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Sisa</label>
                    <input class="form-admin" type="text" class="text-small" name="sisa_jam" id="sisa_jam" readonly value="<?php if (!empty($obj)) echo ($obj->ship_pjl_ops - $obj->ship_realitation); else echo '0'; ?>" <?php if (isset($view)) echo 'readonly'; ?>> Jam
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Riil (PA/BA/TA)</label>
                    <textarea class="form-admin" id="elm5" name="ship_riil" style="width: 30%" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>><?php if (!empty($obj)) echo $obj->ship_riil; ?></textarea>
                    <div class="clear"></div>
                </li>
                <li>
                    <br />
                    <p class="sub-tit-form">Badan Kapal</p>
                </li>
                <li>
                    <label>Skep Kasal</label>
                    <input class="form-admin" name="ship_skep_kasal" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_skep_kasal; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_skep_kasal'); ?>					
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Tahun Pembuatan</label>
                    <input class="form-admin" name="ship_created" type="text" class="text-medium" id="ship_created"
                           value="<?php if (!empty($obj)) echo $obj->ship_created; ?>" <?php if (isset($view)) echo 'disabled'; ?> onkeypress="return isNumberKey(event)">
                           <?php echo form_error('ship_created'); ?>					
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Pabrik</label>
                    <input class="form-admin" name="ship_factory" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_factory; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_factory'); ?>					
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Negara Pembuat</label>
                    <input class="form-admin" name="ship_country_created" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_country_created; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_country_created'); ?>					
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Tahun Penugasan</label>
                    <input class="form-admin" name="ship_work_year" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_work_year; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_work_year'); ?>					
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Nama Panggilan</label>
                    <input class="form-admin" name="ship_nickname" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_nickname; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_nickname'); ?>					
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Berat</label>
                    <input class="form-admin" name="ship_weight" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_weight; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_weight'); ?>					
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Panjang</label>
                    <input class="form-admin" name="ship_length" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_length; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_length'); ?>					
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Lebar</label>
                    <input class="form-admin" name="ship_width" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_width; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_width'); ?>					
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Draft</label>
                    <input class="form-admin" name="ship_draft" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_draft; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_draft'); ?>					
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Tenaga Penggerak</label>
                    <input class="form-admin" name="ship_machine" type="text" class="text-long"
                           value="<?php if (!empty($obj)) echo $obj->ship_machine; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_machine'); ?>					
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Kecepatan</label>
                    <input class="form-admin" name="ship_speed_desc" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_speed_desc; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_speed_desc'); ?>					
                    <div class="clear"></div>
                </li>
                <li>
                    <label>ABK</label>
                    <input class="form-admin" name="ship_people" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_people; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_people'); ?>					
                    <div class="clear"></div>
                </li>
                <?php if (!empty($obj)) { ?>
                    <li>
                        <label>&nbsp;</label>
                        <?php if ($obj->ship_image != null || $obj->ship_image != '') { ?>
                            <img src="<?php echo base_url() ?>assets/img/upload/main/<?php echo $obj->ship_image ?>" width="500" />
                        <?php } else { ?>
                            <span style="font-weight:bold;">Gambar Utama Belum ada</span>
                        <?php } ?>
                        <div class="clear"></div>
                    </li>
                <?php } ?>
                <li>
                    <label>Gambar Utama</label>
                    <input type="file" name="ship_image" <?php if (isset($view)) echo 'disabled'; ?>/>
                    <?php if (isset($error_main_image) && $error_main_image == true) { ?>
                        <span class="note error"><?php echo $msg_error_main_image ?></span>
                    <?php } ?>
			        <p style="margin-left:210px;color:red;">*Tipe File Gambar yang diperbolehkan: .gif atau. png atau .jpg atau .jpeg</p>

                    <p style="margin-left:210px;color:red;">*Maksimum File Gambar adalah 2 MB (Megabyte)</p>

                    <div class="clear"></div>
                </li>
                <?php if (!empty($obj)) { ?>
                    <li>
                        <label>&nbsp;</label>
                        <?php if ($obj->ship_icon != null || $obj->ship_icon != '') { ?>
                            <img src="<?php echo base_url() ?>assets/img/upload/icon/<?php echo $obj->ship_icon ?>" />
                        <?php } else { ?>
                            <span style="font-weight:bold;">Ikon Belum ada</span>
                        <?php } ?>
                        <div class="clear"></div>
                    </li>
                <?php } ?>
                <li>
                    <label>Ikon</label>
                    <input type="file" name="ship_icon" <?php if (isset($view)) echo 'disabled'; ?>/>	
                    <?php if (isset($error_icon) && $error_icon == true) { ?>
                        <span class="note error"><?php echo $msg_error_icon ?></span>
                    <?php } ?>
			        <p style="margin-left:210px;color:red;">*Tipe File Icon yang diperbolehkan: .gif atau. png atau .jpg atau .jpeg</p>
                    <p style="margin-left:210px;color:red;">*Maksimum File Icon adalah 1 MB (Megabyte) 100x100px </p>  

                    <div class="clear"></div>
                </li>
                <li>
                    <br />
                    <p class="sub-tit-form">Riwayat</p>
                </li>
                <li>
                    <label></label>
                    <textarea class="form-admin" id="elm3" name="ship_history" style="width: 30%" <?php if (isset($view)) echo 'disabled'; ?>><?php if (!empty($obj)) echo $obj->ship_history; ?></textarea>
                    <div class="clear"></div>
                </li>
                <li>
                    <br />
                    <p class="sub-tit-form">SEWACO</p>
                </li>
                <li>
                    <label>Senjata</label>
                    <textarea class="form-admin" id="elm4" name="ship_weapon" style="width: 30%" <?php if (isset($view)) echo 'disabled'; ?>><?php if (!empty($obj)) echo $obj->ship_weapon; ?></textarea>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Helicopter</label>
                    <input class="form-admin" name="ship_helicopter" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_helicopter; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_helicopter'); ?>					
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Radar</label>
                    <input class="form-admin" name="ship_radar" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_radar; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_radar'); ?>					
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Sonar</label>
                    <input class="form-admin" name="ship_sonar" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_sonar; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_sonar'); ?>					
                    <div class="clear"></div>
                </li>
                
                <!-- commented by SKM17
                <li>
                    <br />
                    <p class="sub-tit-form">CCTV</p>
                </li>
                <li>
                    <label>IP / DNS</label>
                    <input class="form-admin" name="ship_cctv_ip" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_cctv_ip; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_sonar'); ?>                  
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Username</label>
                    <input class="form-admin" name="ship_cctv_uname" type="text" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_cctv_uname; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_sonar'); ?>                  
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Password</label>
                    <input class="form-admin" name="ship_cctv_pwd" type="password" class="text-medium"
                           value="<?php if (!empty($obj)) echo $obj->ship_cctv_pwd; ?>" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('ship_sonar'); ?>                  
                    <div class="clear"></div>
                </li>
                -->
                
            	<?php if (isset($view)) { ?>
                <li>
                    <br />
                    <p class="sub-tit-form">Gambar Kiriman Kapal</p>
                </li>
	                <?php if (!empty($obj)) { ?>
	                    <li>
	                        <ul style="list-style:none;margin-left:130px;">
	                            <?php foreach ($obj->gallery_image as $image) { ?>
	                                <li style="float:left;margin-right:10px;" class="figures">
	                                	<img width=160 height=120 src="<?php echo base_url() ?>assets/img/upload/gallery/<?php echo $image->shipimg_filename ?>" />
	                                	<span>
	                                		<?php 
	                                			// menambahkan timestamp gambar dg waktu timestamp dr server lokal
	                                			$date = new DateTime($image->shipimg_timestamp);
	                                			// $gmt_hour = date("Z", time()) / 3600;
	                                			$gmt_hour = 7;
												$date->modify("+" . $gmt_hour . " hours");
	                                		if (!$image->shipimg_timestamp) echo '-'; else echo $date->format("Y-m-d H:i:s") . ' WIB'; 
	                                		?>
	                                	</span>
	                            	</li>
	                            <?php } ?>
	                        </ul>	
	                        <div class="clear"></div>
	                    </li>
	                <?php } 
	            } ?>
                <li>
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
