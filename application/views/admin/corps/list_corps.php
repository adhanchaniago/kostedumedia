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
        $("#addCorps").validate({
            rules:{
                corps_id: "required",
                corps_name: "required",
                corps_type_id: "required"
                //                corps_description: "required"
            },
            messages:{
                corps_id: "required",
                corps_name: "required",
                corps_type_id: "required"
                //                corps_description: "required"
            }
        });
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Pembina"></div>')
            .html('Semua terkait Pembina akan ikut dihapus! Hapus data pembina? <div class="clear"></div>').dialog({
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
        //param = param.substr(0,-1);
        $('#form_search_filter').attr('action',url+param).submit();
    }
    function redirect(tail){
        window.location = "<?php echo base_url() ?>admin/corps_ctrl" + tail;
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
<div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
    
<p class="tit-form">Daftar Pembina <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
<div class="filtering" style="display: none;">
    <form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
        <ul class="filter-form">
            <li>
                <label>Nama</label><br />
                <input type="text" placeholder="Nama" name="corps_name" class='filter_param' value="<?php echo $this->input->get('corps_name'); ?>" />
            </li>
            <li>
                <label>Tipe Pembina</label><br />
                <?php $corps_types = array('' => '-Pilih Tipe Pembina-', '1'=>'KRI', '2'=>'Pesawat Udara', '3'=>'Marinir'); ?>
                <select name="corps_type_id" class='filter_param'>
                    <?php foreach ($corps_types as $key=>$val) { ?>
                        <?php if (($this->input->get('corps_type_id')) && $this->input->get('corps_type_id') == $key) { ?>
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
        <input type="button" value="Bersihkan Pencarian" onclick="redirect('')" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
        <input type="button" value="Cari" name="search_filter" onclick="create_url()" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />

        <div class="clear"></div>
        <div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
    </form>
</div>
<table class="tab-admin">
    <thead>
        <tr class="tittab">
            <td class="header" style="width: 30px;">No</th>						
            <!-- <td class="header" style="cursor: pointer ;">Corps ID</th> -->
            <td class="header" style="cursor: pointer ;">Nama</th>
            <td class="header" style="cursor: pointer ;">Deksripsi</th>
            <td class="header" style="cursor: pointer ;">Tipe</th>
            <td class="header delete" style="width: 52px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        if (!empty($corps)) {
            foreach ($corps as $row) {
                ?>
                <tr class="<?php echo alternator('row-one', 'row-two'); ?>">
                    <td><?php echo ($count++)+$offset; ?></td>
                    <!-- <td><?php echo $row->corps_id; ?></td> -->
                    <td><?php echo $row->corps_name; ?></td>
                    <td><?php echo $row->corps_description; ?></td>
                    <td><?php if ($row->corps_type_id == '1') echo 'KRI'; else if ($row->corps_type_id == '2') echo 'Pesawat Udara'; else if ($row->corps_type_id == '3') echo 'Marinir'; ?></td>
                    <td class="action"> 
                        <?php if (is_has_access('corps_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/corps_ctrl/edit/<?php echo $row->corps_id . '?' . http_build_query($_GET) . '#form-pos' ?>" ><div class="tab-edit"></div></a> 
                        <?php } ?>
                        <?php if (is_has_access('corps_ctrl-delete', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/corps_ctrl/delete/<?php echo $row->corps_id . '?' . http_build_query($_GET) ?>" class="delete-tab"><div class="tab-delete"></div></a>
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
<?php if (is_has_access('corps_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
    <p id="form-pos" class="tit-form">Entri Pembina</p>
    <form action="<?php echo base_url() ?>admin/corps_ctrl/save" method="post" class="jNice" id="addCorps">
        <ul class="form-admin">
            <?php if (!empty($obj)) { ?>
                <input class="form-admin" type="hidden" name="corps_id" value="<?php if (!empty($obj)) echo $obj->corps_id; ?>" />
            <?php } ?>
            <li>
                <label>Nama * </label>
                <input name="corps_name" type="text" class="form-admin" maxlength="255"
                       value="<?php if (!empty($obj)) echo $obj->corps_name; ?>" >
                       <?php echo form_error('corps_name'); ?>	
                <div class="clear"></div>
            </li>
            <li>
                <label>Tipe Pembina *</label><br />
                <?php $corps_types = array('1'=>'KRI','2'=>'Pesawat Udara','3'=>'Marinir');?>
                <select name="corps_type_id" class='form-admin'>
                    <option value="">-Pilih Tipe Pembina-</option>
                    <?php foreach ($corps_types as $key=>$val) { ?>
                        <?php if ((!empty($obj)) && $obj->corps_type_id == $key) { ?>
                            <option value="<?php echo $key ?>" selected><?php echo $val ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $key ?>"><?php echo $val ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <div class="clear"></div>
            </li>
            <li>
                <label>Deskripsi </label>
                <textarea class="form-admin" name="corps_description"><?php if (!empty($obj)) echo $obj->corps_description; ?></textarea>
                <?php echo form_error('corps_description'); ?>
                <div class="clear"></div>
            </li>

            <li>
                <label>Lintang</label>
                <input class="form-admin two-digit" name="corps_dlat" maxlength="3"  type="text" class="text-medium" 
                       value="<?php if (!empty($obj)) echo geoComponent($obj->corps_lat, 'd'); ?>" onkeypress="return isNumberKey(event)">
                <input class="form-admin two-digit" name="corps_mlat" maxlength="2"  type="text" class="text-medium" 
                       value="<?php if (!empty($obj)) echo geoComponent($obj->corps_lat, 'm'); ?>" onkeypress="return isNumberKey(event)">
                <input class="form-admin two-digit" name="corps_slat" maxlength="2"  type="text" class="text-medium" 
                       value="<?php if (!empty($obj)) echo geoComponent($obj->corps_lat, 's'); ?>" onkeypress="return isNumberKey(event)">
                       <?php
                       $stat = 'class="form-admin" style="width: 47px;"';

                       if (!empty($obj))
                           echo form_dropdown('corps_rlat', array(1 => 'U', -1 => 'S'), geoComponent($obj->corps_lat, 'r'), $stat);
                       else
                           echo form_dropdown('corps_rlat', array(1 => 'U', -1 => 'S'), '', $stat);
                       ?>

                <?php echo form_error('corps_lat'); ?>                   

                <div class="clear"></div>
            </li>
            <li>
                <label>Bujur</label>
                <input class="form-admin two-digit" name="corps_dlon" maxlength="3"  type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo geoComponent($obj->corps_lon, 'd'); ?>" onkeypress="return isNumberKey(event)">
                <input class="form-admin two-digit" name="corps_mlon" maxlength="2"  type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo geoComponent($obj->corps_lon, 'm'); ?>" onkeypress="return isNumberKey(event)">
                <input class="form-admin two-digit" name="corps_slon" maxlength="2"  type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo geoComponent($obj->corps_lon, 's'); ?>" onkeypress="return isNumberKey(event)">
                       <?php echo form_error('corps_lat'); ?>                    

                <?php
                $stat = 'class="form-admin" style="width: 47px;"';


                if (!empty($obj))
                    echo form_dropdown('corps_rlon', array(1 => 'T', -1 => 'B'), geoComponent($obj->corps_lon, 'r'), $stat);
                else
                    echo form_dropdown('corps_rlon', array(1 => 'T', -1 => 'B'), '', $stat);
                ?>

                <?php echo form_error('ship_lon'); ?>                   
                <div class="clear"></div>
            </li>
            <li>
                <p class="tit-form"></p>
                <label>&nbsp;</label>
                <input type="submit" class="button-form" value="Simpan">
                <input type="reset" class="button-form" value="Batal" onclick="redirect('')">
		        <input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
            </li>
        </ul>
    </form>
<?php } ?>
</div>
<div class="clear"></div>
