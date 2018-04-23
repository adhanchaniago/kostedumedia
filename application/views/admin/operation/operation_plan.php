<?php if ($this->session->flashdata('info')) { ?>
    <script>
        $(document).ready(function() {
            alert('<?php echo $this->session->flashdata('info'); ?>');
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function() {
        var baseUrl = '<?php echo base_url() ?>';
        var htmlHeight = $('html').height();

        $("#operationAdd").validate({
            rules: {
                operation_name: "required",
                operation_year: "required",
                operation_start: "required",
                operation_end: "required",
                sub_onetwo: "required",
                sub_three: "required",
                sub_four: "required",
                kodaloperasi_id: "required"
            },
            messages: {
                operation_name: "required",
                operation_year: "required",
                operation_start: "required",
                operation_end: "required",
                sub_onetwo: "required",
                sub_three: "required",
                sub_four: "required",
                kodaloperasi_id: "required"
            }
        });
        $('.delete-tab').click(function() {
            var page = $(this).attr("href");
            var $dialog = $('<div title="Marines"></div>')
            .html('Anda yakin akan menghapus data rencana operasi ?<div class="clear"></div>').dialog({
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

        $('a.edit').click(function(e) {
            e.preventDefault();
            $('#backlight').height(htmlHeight);
            var url = $(this).attr('href');
            $('#backlight').fadeIn('fast', function() {
                $('#spotting-holder').load(url, function() {
                    $(this).fadeIn('fast');
                })
            });
        });
        //datepicker
        $("#operation_start").datepicker({dateFormat: 'yy-mm-dd'});
        $("#operation_end").datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: $('#operation_start').val()
        });

        $('#operation_start').change(function() {
            $('#operation_end').val("");
            var begin_date = $(this).datepicker('getDate');
            var end_date_min = new Date(begin_date.getTime());
            end_date_min.setDate(end_date_min.getDate() + 1);
            $('#operation_end').datepicker("destroy")
            $('#operation_end').datepicker({minDate: end_date_min, dateFormat: 'yy-mm-dd'});
        });

        $('#backlight').click(function(e) {
            e.preventDefault();

            $('#spotting-holder').fadeOut('fast', function() {
                $('#backlight').fadeOut('fast');
            });
        });

        $('#sub_onetwo').change(
        function() {
            $('#sub_three').empty(); // kosongkan dahulu combobox yang ingin diisi datanya
            $('#sub_three').append('<option value="">-Pilih Kesatrian-</option>');
            // apabila nilai pilihan tidak kosong, load data propinsi
            if ($('#sub_onetwo option:selected').val() != '') {
                loadSubThree($('#sub_onetwo option:selected').val());
            }
        }
    );
        $('#sub_three').change(
        function() {
            $('#sub_four').empty(); // kosongkan dahulu combobox yang ingin diisi datanya
            $('#sub_four').append('<option value="">-Pilih Kesatrian-</option>');
            // apabila nilai pilihan tidak kosong, load data propinsi
            if ($('#sub_three option:selected').val() != '') {
                loadSubFour($('#sub_three option:selected').val());
            }
        }
    );

    });
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (!((charCode >= 48 && charCode <= 57) || (charCode == 46) || (charCode == 8) || (charCode == 9)))
            return false;

        return true;
    }
    function loadSubThree(parentId) {
        // berikan kondisi sedang loading data ketika proses pengambilan data
        $.post('<?php echo base_url() ?>admin/operation_ctrl/get_sub_three', // request ke file load_data.php
        {parent_id: parentId},
        function(data) {
            if (data.error == undefined) {
                $('#sub_three').empty();
                // kosongkan dahulu combobox yang ingin diisi datanya
                $('#sub_three').append('<option value="">- Pilih Jenis 2 -</option>'); // buat pilihan awal pada combobox
                for (var x = 0; x < data.length; x++) {
                    // berikut adalah cara singkat untuk menambahkan element option pada tag <select>
                    $('#sub_three').append($('<option></option>').val(data[x].level3_id).text(data[x].level3));
                }
            } else {
                $('#sub_three').empty();
                // kosongkan dahulu combobox yang ingin diisi datanya
                $('#sub_three').append('<option value="">- Pilih Jenis 2 -</option>'); // buat pilihan awal pada combobox
            }
        }, 'json' // format respon yang diterima langsung di convert menjadi JSON
    );
    }
    function loadSubFour(parentId) {
        // berikan kondisi sedang loading data ketika proses pengambilan data
        $.post('<?php echo base_url() ?>admin/operation_ctrl/get_sub_four', // request ke file load_data.php
        {parent_id: parentId},
        function(data) {
            if (data.error == undefined) {
                $('#sub_four').empty();
                // kosongkan dahulu combobox yang ingin diisi datanya
                $('#sub_four').append('<option value="">- Pilih Jenis 3 -</option>'); // buat pilihan awal pada combobox
                for (var x = 0; x < data.length; x++) {
                    // berikut adalah cara singkat untuk menambahkan element option pada tag <select>
                    $('#sub_four').append($('<option></option>').val(data[x].level4_id).text(data[x].level4));
                }
            } else {
                $('#sub_four').empty();
                // kosongkan dahulu combobox yang ingin diisi datanya
                $('#sub_four').append('<option value="">- Pilih Jenis 3 -</option>'); // buat pilihan awal pada combobox
            }
        }, 'json' // format respon yang diterima langsung di convert menjadi JSON
    );
    }
    function activated(operation_id) {
        $.post('<?php echo base_url() ?>admin/operation_ctrl/setActivatedPlan', // request ke file load_data.php
        {id: operation_id},
        function(data) {
            if (data == 'success') {
                redirect();
            } else if(data == 'marine_max'){
                alert("Pengaktifan operasi gagal. Komponen marinir telah melebihi batas Personil Riil");
            }else{
                alert("Pengaktifan operasi gagal. Salah satu komponen operasi masih digunakan di operasi yang aktif.");
            }
        }
    );
    }
    function redirect() {
        window.location = "<?php echo base_url() ?>admin/operation_ctrl";
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
    <p class="tit-form">Rencana</p>

    <table class="tab-admin">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;">No</td>
                <td class="header">Nama</td>
                <td class="header">Jenis</td>
                <td class="header">Tanggal Mulai</td>
                <td class="header">Tanggal Selesai</td>
                <td class="header">Status</td>
                <td class="header delete" style="width: 52px;">Aksi</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($operation as $ops) {
                ?>
                <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                    <td><?php echo $i++; ?></td>
                    <td><a href="#"> <!--class="open-tab2"--><?php echo $ops->operation_name ?></a></td>
                    <td><?php echo $ops->jenis_ops ?></td>
                    <td><?php echo $ops->operation_start ?></td>
                    <td><?php echo $ops->operation_end ?></td>
                    <td><?php echo ($ops->operation_is_active == 't') ? 'Berlangsung' : 'Rencana'; ?></td>
                    <td class="action">
                        <a href="<?php echo base_url(); ?>admin/operation_ctrl/edit_plan/<?php echo $ops->operation_id . '?' . http_build_query($_GET) ?>"><div class="tab-edit"></div></a> 
                        <a href="<?php echo base_url(); ?>admin/operation_ctrl/delete_plan/<?php echo $ops->operation_id . '?' . http_build_query($_GET) ?>" class="delete-tab"><div class="tab-delete"></div></a>
                        <a href="#" onclick="activated('<?php echo $ops->operation_id ?>')">Aktifkan</div></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <br /><br />

    <div class="komponen" style="display: none;">
        <p class="tit-form">Komponen Nama Operasinya</p>

        <table class="tab-admin">
            <thead>
                <tr class="tittab">
                    <td class="header" style="width: 30px;">No</td>						
                    <td class="header" style="width: 150px;">Jenis Unsur</td>
                    <td class="header" style="width: 150px;">Nomor</td>
                    <td class="header">Nama</td>
                </tr>
            </thead>
            <tbody>
                <tr class="row-one">
                    <td>1</td>
                    <td>KRI Krait (827)</td>
                    <td>Kapal Operasi</td>
                    <td>Tugas patroli keamanan laut kapal ini juga bisa digunakan sebagai kapal SAR</td>
                </tr>
            </tbody>
        </table>

        <br /><br />
    </div>

    <p class="tit-form">Tambah Rencana</p>
    <form action="<?php echo base_url() ?>admin/operation_ctrl/save" method="post" id="operationAdd">
        <?php if (!empty($obj)) { ?>
            <input type="hidden" name="operation_id" value="<?php if (!empty($obj)) echo $obj->operation_id; ?>" />
        <?php } ?>
        <ul class="form-admin">
            <li>
                <label>Nama*</label>
                <input class="form-admin" type="text" class="text-medium" name="operation_name" value="<?php if (!empty($obj)) echo $obj->operation_name; ?>" >			
                <div class="clear"></div>
            </li>
            <li>
                <label style="height: 120px;">Jenis*</label>
                <select name="sub_onetwo" class="form-admin" id="sub_onetwo">
                    <option value="" selected>-Pilih Sub Jenis 1-</option>
                    <?php foreach ($jenis_ops_subonetwo as $row) { ?>
                        <?php if ((!empty($obj)) && $subone_id[0]->level1dan2_id == $row->level1dan2_id) { ?>
                            <option value="<?php echo $row->level1dan2_id ?>" selected><?php echo $row->level1 . ' ' . $row->level2 ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->level1dan2_id ?>"><?php echo $row->level1 . ' ' . $row->level2 ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <br /><br /><br />
                <select name="sub_three" id="sub_three" class="form-admin pilih-status">
                    <option value="" selected="selected">- Pilih Sub Jenis 2 -</option>
                    <?php if (!empty($obj)) { ?>
                        <?php foreach ($jenis_ops_subthree_exist as $row) { ?>
                            <?php if ($subthree_id[0]->level3_id == $row->level3_id) { ?>
                                <option value="<?php echo $row->level3_id ?>" selected><?php echo $row->level3 ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $row->level3_id ?>"><?php echo $row->level3 ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </select>
                <br /><br /><br />
                <select name="sub_four" id="sub_four" class="form-admin pilih-status">
                    <option value="" selected="selected">- Pilih Sub Jenis 3 -</option>
                    <?php if (!empty($obj)) { ?>
                        <?php foreach ($jenis_ops_subfour_exist as $row) { ?>
                            <?php if ($subfour_id[0]->level4_id == $row->level4_id) { ?>
                                <option value="<?php echo $row->level4_id ?>" selected><?php echo $row->level4 ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $row->level4_id ?>"><?php echo $row->level4 ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </select>
                <div class="clear"></div>
            </li>
            <li>
                <label>Kodal*</label>
                <div class="form-admin-check">
                    <?php foreach ($kodals as $row) { ?>
                        <?php if (!empty($obj)) { ?>
                            <?php if (in_array($row->kodaloperasi_id, $kodal_exist)) { ?>
                                <input type="checkbox" name="kodals[]" value="<?php echo $row->kodaloperasi_id ?>" checked><?php echo $row->kodaloperasi_desc ?><div class="clear"></div>
                            <?php } else { ?>
                                <input type="checkbox" name="kodals[]" value="<?php echo $row->kodaloperasi_id ?>"><?php echo $row->kodaloperasi_desc ?><div class="clear"></div>
                            <?php } ?>
                        <?php } else { ?>
                            <input type="checkbox" name="kodals[]" value="<?php echo $row->kodaloperasi_id ?>"><?php echo $row->kodaloperasi_desc ?><div class="clear"></div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="clear"></div>
            </li>
            <li>
                <label>Jenis Operasi:</label>
                <?php
                $stat = 'class="form-admin"';

                if (!empty($obj))
                    echo form_dropdown('optype_id', $operation_type, $obj->optype_id, $stat);
                else
                    echo form_dropdown('optype_id', $operation_type, '', $stat);
                ?>
                <div class="clear"></div>
            </li>
            <li>
                <label>Tahun*</label>
                <input class="form-admin" type="text" class="text-medium" name="operation_year" id="operation_year" value="<?php if (!empty($obj)) echo $obj->operation_year; ?>">			
                <div class="clear"></div>
            </li>
            <li>
                <label>Tanggal Mulai*</label>
                <input class="form-admin" type="text" class="text-medium" name="operation_start" id="operation_start" value="<?php if (!empty($obj)) echo $obj->operation_start; ?>">			
                <div class="clear"></div>
            </li>
            <li>
                <label>Tanggal Selesai*</label>
                <input class="form-admin" type="text" class="text-medium" name="operation_end" id="operation_end" value="<?php if (!empty($obj)) echo $obj->operation_end; ?>">			
                <div class="clear"></div>
            </li>
            <li>
                <label>Keterangan</label>
                <textarea rows="1" cols="1" class="form-admin" id="elm1" name="operation_description"><?php if (!empty($obj)) echo $obj->operation_description; ?></textarea>			
                <div class="clear"></div>
            </li>
            <input type="hidden" name="operation_is_active" value="<?php
                if (!empty($obj)) {
                    echo $obj->operation_is_active;
                } else {
                    echo 'f';
                }
                ?>" />
            <!--<li>
                <label>Status Operasi * </label>

                <div class="form-admin-radio">
                    <label><input type="radio" name="operation_is_active" value="FALSE" <?php if (!empty($obj) && $obj->operation_is_active == 'f') echo "checked" ?> <?php if (empty($obj)) echo "checked" ?>> Rencana</label>
                    <div class="clear"></div>
                    <label><input type="radio" name="operation_is_active" value="TRUE" <?php if (!empty($obj) && $obj->operation_is_active == 't') echo "checked" ?> > Berlangsung</label>
                </div>

                <div class="clear"></div>
            </li>-->
            <li>
                <br />
                <p class="sub-tit-form">Komponen Operasi KRI</p>
            </li>
            <li>
                <div class="select-ops">
                    <p>Siap</p>
                    <ul>
                        <?php foreach ($ships as $kri) { ?>
                            <?php if (!empty($obj)) { ?>
                                <?php if (in_array($kri->ship_id, $ships_exist)) { ?>
                                    <li><label><input type="checkbox" name="ship_list[]" value="<?php echo $kri->ship_id ?>" checked><?php echo $kri->ship_name ?></label></li>
                                <?php } else { ?>
                                    <li><label><input type="checkbox" name="ship_list[]" value="<?php echo $kri->ship_id ?>"><?php echo $kri->ship_name ?></label></li>
                                <?php } ?>
                            <?php } else { ?>
                                <li><label><input type="checkbox" name="ship_list[]" value="<?php echo $kri->ship_id ?>"><?php echo $kri->ship_name ?></label></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </li>
            <li>
                <br />
                <p class="sub-tit-form">Komponen Operasi Pesud</p>
            </li>
            <li>
                <div class="select-ops">
                    <p>Siap</p>
                    <ul>
                        <?php foreach ($aeroplanes as $aer) { ?>
                            <?php if (!empty($obj)) { ?>
                                <?php if (in_array($aer->aer_id, $aeroplanes_exist)) { ?>
                                    <li><label><input type="checkbox" name="aer_list[]" value="<?php echo $aer->aer_id ?>" checked><?php echo $aer->aer_name ?></label></li>
                                <?php } else { ?>
                                    <li><label><input type="checkbox" name="aer_list[]" value="<?php echo $aer->aer_id ?>"><?php echo $aer->aer_name ?></label></li>
                                <?php } ?>
                            <?php } else { ?>
                                <li><label><input type="checkbox" name="aer_list[]" value="<?php echo $aer->aer_id ?>"><?php echo $aer->aer_name ?></label></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </li>
            <li>
                <br />
                <p class="sub-tit-form">Komponen Operasi Marinir</p>
            </li>
            <li>
                <div class="select-ops">
                    <p>Siap</p>
                    <ul>
                        <?php foreach ($marines as $mar) { ?>
                            <?php if (!empty($obj)) { ?>
                                <?php if (in_array($mar->mar_id, $marines_exist)) { ?>
                                    <li>
                                        <label><input type="checkbox" name="mar_list[]" value="<?php echo $mar->mar_id ?>" checked ><?php echo $mar->mar_name ?></label>
                                        <label>Jumlah Personil: <input type="text" name="mar_list_count[]" class="text-medium" style="width: 35px" value="<?php echo $marines_count_exist[$mar->mar_id] ?>"></label>
                                    </li>
                                <?php } else { ?>
                                    <li>
                                        <label><input type="checkbox" name="mar_list[]" value="<?php echo $mar->mar_id ?>" ><?php echo $mar->mar_name ?></label>
                                        <label>Jumlah Personil: <input type="text" name="mar_list_count[]" class="text-medium" style="width: 35px" ></label>
                                    </li>
                                <?php } ?>
                            <?php } else { ?>
                                <li>
                                    <label><input type="checkbox" name="mar_list[]" value="<?php echo $mar->mar_id ?>" ><?php echo $mar->mar_name ?></label>
                                    <label>Jumlah Personil: <input type="text" name="mar_list_count[]" class="text-medium" style="width: 35px" ></label>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </li>
            <p class="tit-form"></p>
            <!--<li>
                <label>Jadikan Template * </label>

                <div class="form-admin-radio">
                    <label><input type="radio" name="operation_is_template" value="TRUE" <?php if (!empty($obj) && $obj->operation_is_template == 't') echo "checked" ?> <?php if (empty($obj)) echo "checked" ?>> Ya</label>
                    <label><input type="radio" name="operation_is_template" value="FALSE" <?php if (!empty($obj) && $obj->operation_is_template == 'f') echo "checked" ?> > Tidak</label>
                </div>

                <div class="clear"></div>
            </li>-->
            <p class="tit-form"></p>
            <li>
                <label>&nbsp;</label>
                <input class="button-form" type="submit" value="Simpan">
                <input class="button-form" type="reset" value="Batal" onclick="redirect()">
                <div class="clear"></div>
            </li>
        </ul>
    </form>
</div>

<script>
    $('a.open-tab2').click(function(event) {
        event.preventDefault();
        $('.komponen').slideDown();
    });
</script>