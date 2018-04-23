<script>
    $(document).ready(function(){
        $("#lapsitharAdd").validate({
            rules:{
                ar_title: "required",
                vt_id: "required",
                rt_id: "required"
            },
            messages:{
                ar_title: "required",
                vt_id: "required",
                rt_id: "required"
            }
        });
        $("#ar_date").datepicker({ dateFormat:'yy-mm-dd'});
        $("#ar_date_start").datepicker({ dateFormat:'yy-mm-dd'});
        $("#ar_date_end").datepicker({ dateFormat:'yy-mm-dd'});
        $('#ar_time').timepicker({ 'timeFormat': 'H:i:s' });
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Operation"></div>')
            .html('All item related to Lapsithar will be deleted to ! Are you sure ?<div class="clear"></div>').dialog({
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

    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if(!((charCode>=48&&charCode<=57)|| (charCode==46) || (charCode==8) || (charCode==9)))
            return false;

        return true;
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
<script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/tiny_mce.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        mode : "textareas",
        theme : "simple"
    });
</script>

<p class="tit-form">Daftar Laporan <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
<div class="filtering" style="display: none;">
    <form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
        <ul class="filter-form">
            <li>
                <label>Tanggal Mulai</label><br />
                <input type="text" placeholder="Tanggal Mulai" name="ar_date_start" id="ar_date_start" class='filter_param' value="<?php echo $this->input->get('ar_date_start'); ?>" onkeypress="search_enter_press(event);" />
            </li>
            <li>
                <label>Tanggal Akhir</label><br />
                <input type="text" placeholder="Tanggal Akhir" name="ar_date_end" id="ar_date_end" class='filter_param' value="<?php echo $this->input->get('ar_date_end'); ?>" onkeypress="search_enter_press(event);" />
            </li>
            <li>
                <label>Jenis Kejadian</label><br />
                <select name="vt_id" class='filter_param'>
                    <option value="">Tipe Pelanggaran</option>
                    <?php foreach ($violation_type as $row) { ?>
                        <?php if (($this->input->get('vt_id')) && $this->input->get('vt_id') == $row->vt_id) { ?>
                            <option value="<?php echo $row->vt_id ?>" selected><?php echo $row->vt_desc ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->vt_id ?>"><?php echo $row->vt_desc ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </li>
            <li>
                <label>Tipe Laporan</label><br />
                <select name="rt_id" class='filter_param'>
                    <option value="">Tipe Laporan</option>
                    <?php foreach ($report_type as $row) { ?>
                        <?php if (($this->input->get('rt_id')) && $this->input->get('rt_id') == $row->rt_id) { ?>
                            <option value="<?php echo $row->rt_id ?>" selected><?php echo $row->rt_desc ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->rt_id ?>"><?php echo $row->rt_desc ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </li>
        </ul>

        <div class="clear"></div>
        <div style="border-bottom: 1px dotted #DDD; margin: 15px 0 17px 0;"></div>

        <input type="button" value="Filter" name="search_filter" onclick="create_url();" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />

        <div class="clear"></div>
        <div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
    </form>
</div>
<table class="tab-admin">

    <tr class="tittab">
        <td class="header">No</th>						
        <td class="header" style="cursor: pointer ;">Title </td>
        <td class="header" style="cursor: pointer ;">Tipe Pelanggaran</td>
        <td class="header" style="cursor: pointer ;">Tipe Laporan</td>
        <td class="header" style="cursor: pointer ;">Tanggal</td>
        <td class="header" style="cursor: pointer ;">Waktu</td>
        <td class="header" style="cursor: pointer ;">Lat</td>
        <td class="header" style="cursor: pointer ;">Lon</td>
        <td class="header delete" style="width: 52px;">Actions</td>
    </tr>

    <?php
    $count = 1;
    if (!empty($areal_report)) {
        foreach ($areal_report as $row) {
            ?>
            <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                <td><?php echo $count++; ?></td>
                <td><?php echo $row->ar_title; ?></td>
                <td><?php echo $row->vt_desc; ?></td>
                <td><?php echo $row->rt_desc; ?></td>
                <td><?php echo $row->ar_date; ?></td>
                <td><?php echo $row->ar_time; ?></td>
                <td><?php echo geoComponent($row->ar_lat, 'a', 'lat'); ?></td>
                <td><?php echo geoComponent($row->ar_lon, 'a', 'lon'); ?></td>
                <td class="action">
                    <?php if (is_has_access('areal_report-edit', $permission) || is_has_access('*', $permission)) { ?>
                        <a href="<?php echo base_url(); ?>admin/areal_report_ctrl/edit/<?php echo $row->ar_id . '?' . http_build_query($_GET) ?>" ><div class="tab-edit"></div></a> 
                    <?php } ?>
                    <?php if (is_has_access('areal_report-delete', $permission) || is_has_access('*', $permission)) { ?>
                        <a href="<?php echo base_url(); ?>admin/areal_report_ctrl/delete/<?php echo $row->ar_id . '?' . http_build_query($_GET) ?>" class="delete-tab"><div class="tab-delete"></div></a>
                    <?php } ?>
                </td>
            </tr>
            <?php
        }
    }
    ?>


</table>
<br />
<?php echo $pagination ?>
<br />
<?php if (is_has_access('areal_report-edit', $permission) || is_has_access('*', $permission)) { ?>
    <form action="<?php echo base_url() ?>admin/areal_report_ctrl/save" method="post" class="" id="lapsitharAdd" class="jNice">
        <p class="tit-form">Entri Laporan</p>
        <?php if (!empty($obj)) { ?>
            <input class="form-admin" type="hidden" name="ar_id" value="<?php if (!empty($obj)) echo $obj->ar_id; ?>" />
        <?php } ?>
        <ul class="form-admin">
            <li>
                <label>Judul:</label>
                <input class="form-admin" name="ar_title" type="text" class="text-long" value="<?php if (!empty($obj)) echo $obj->ar_title; ?>" >
                <?php echo form_error('ar_title'); ?>
                <div class="clear"></div>
            </li>
            <li>
                <label>Tanggal:</label>
                <input class="form-admin" name="ar_date" id="ar_date" type="text" class="text-long" value="<?php if (!empty($obj)) echo $obj->ar_date; ?>" >
                <?php echo form_error('ar_date'); ?>
                <div class="clear"></div>
            </li>
            <li>
                <label>Waktu:</label>
                <input class="form-admin" name="ar_time" id="ar_time" type="text" class="text-long" value="<?php if (!empty($obj)) echo $obj->ar_time; ?>" onkeypress="return isNumberKey(event)">
                <?php echo form_error('ar_time'); ?>
                <div class="clear"></div>
            </li>

            <li>
                <label>Lattitude</label>
                <input class="form-admin two-digit" name="ar_dlat"  maxlength="3" type="text" class="text-medium" 
                       value="<?php if (!empty($obj)) echo geoComponent($obj->ar_lat, 'd'); ?>" onkeypress="return isNumberKey(event)">
                <input class="form-admin two-digit" name="ar_mlat" maxlength="2" type="text" class="text-medium" 
                       value="<?php if (!empty($obj)) echo geoComponent($obj->ar_lat, 'm'); ?>" onkeypress="return isNumberKey(event)">
                <input class="form-admin two-digit" name="ar_slat" maxlength="2" type="text" class="text-medium" 
                       value="<?php if (!empty($obj)) echo geoComponent($obj->ar_lat, 's'); ?>" onkeypress="return isNumberKey(event)">

                <?php
                $stat = 'class="form-admin" style="width: 47px;"';

                if (!empty($obj))
                    echo form_dropdown('ar_rlat', array(1 => 'U', -1 => 'S'), geoComponent($obj->ar_lat, 'r'), $stat);
                else
                    echo form_dropdown('ar_rlat', array(1 => 'U', -1 => 'S'), '', $stat);
                ?>

                <?php echo form_error('ar_lat'); ?>                    

                <div class="clear"></div>
            </li>
            <li>
                <label>Longitude</label>
                <input class="form-admin two-digit" name="ar_dlon" maxlength="3"  type="text" class="text-medium" 
                       value="<?php if (!empty($obj)) echo geoComponent($obj->ar_lon, 'd'); ?>" onkeypress="return isNumberKey(event)">
                <input class="form-admin two-digit" name="ar_mlon" maxlength="2" type="text" class="text-medium" 
                       value="<?php if (!empty($obj)) echo geoComponent($obj->ar_lon, 'm'); ?>" onkeypress="return isNumberKey(event)">
                <input class="form-admin two-digit" name="ar_slon" maxlength="2" type="text" class="text-medium" 
                       value="<?php if (!empty($obj)) echo geoComponent($obj->ar_lon, 's'); ?>" onkeypress="return isNumberKey(event)">

                <?php
                $stat = 'class="form-admin" style="width: 47px;"';

                if (!empty($obj))
                    echo form_dropdown('ar_rlon', array(1 => 'T', -1 => 'B'), geoComponent($obj->ar_lon, 'r'), $stat);
                else
                    echo form_dropdown('ar_rlon', array(1 => 'T', -1 => 'B'), '', $stat);
                ?>

                <?php echo form_error('ar_lon'); ?>                    
                <div class="clear"></div>
            </li>
            <li>
                <label>Tipe Pelanggaran:</label>
                <select name="vt_id" class="text-long form-admin">
                    <option value="" selected>-Select Tipe-</option>
                    <?php foreach ($violation_type as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->vt_id == $row->vt_id) { ?>
                            <option value="<?php echo $row->vt_id ?>" selected><?php echo $row->vt_desc ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->vt_id ?>"><?php echo $row->vt_desc ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>

                <div class="clear"></div>
            </li>
            <li>
                <label>Tipe Laporan:</label>
                <select name="rt_id" class="text-long form-admin">
                    <option value="" selected>-Select Tipe-</option>
                    <?php foreach ($report_type as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->rt_id == $row->rt_id) { ?>
                            <option value="<?php echo $row->rt_id ?>" selected><?php echo $row->rt_desc ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->rt_id ?>"><?php echo $row->rt_desc ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <div class="clear"></div>
            </li>
            <li>
                <label>Detail</label>
                <textarea class="form-admin" id="elm1" name="ar_content" style="width: 30%"><?php if (!empty($obj)) echo $obj->ar_content; ?></textarea>
                <div class="clear"></div>
            </li>
            <li>
                <label>Pelapor</label>
                <input type="text" name="ar_reporter" class="form-admin" id="ar_reporter" value="<?php if (!empty($obj)) echo $obj->ar_reporter; ?>" />
                <div class="clear"></div>
            </li>
            <li>
                <label>&nbsp;</label>
                <input class="button-form" type="submit" value="Simpan" />
                <input class="button-form" type="reset" value="Cancel">
            </li>
        </ul>
    </form>
<?php } ?>

