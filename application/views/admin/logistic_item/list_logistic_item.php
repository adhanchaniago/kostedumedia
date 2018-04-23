<?php if ($this->session->flashdata('info')) { ?>
    <script>
        $(document).ready(function(){
            $('.success').html('<strong>Penyimpanan data berhasil.<strong> <?php echo $this->session->flashdata('info'); ?>');
            $('.success').attr('style','');
            $('.success').delay(10000).fadeOut('slow');
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
        $("#addLogisticItem").validate({
            rules:{
                logitem_id: "required",
                logitem_desc: "required",
                logitem_metric: "required",
                logitemctx_id: "required"
            },
            messages:{
                logitem_id: "required",
                logitem_desc: "required",
                logitem_metric: "required",
                logitemctx_id: "required"
            }
        });
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Kondisi Teknis"></div>')
            .html('Semua terkait Kondisi Teknis akan ikut dihapus! Hapus data kondisi teknis? <div class="clear"></class>').dialog({
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
    function redirect(tail){
        window.location = "<?php echo base_url() ?>admin/logistic_item_ctrl" + tail;
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

<div id="main">

    <div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
    
    <p class="tit-form">Daftar Kondisi Teknis <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
    <div class="filtering" style="display: none;">
        <form action="<?php echo base_url().'admin/logistic_item_ctrl' ?>" method="post" id="form_search_filter">
            <ul class="filter-form">
                <li>
                    <label>Nama</label><br />
                    <input type="text" placeholder="Nama" name="logitem_desc" class='filter_param' value="<?php echo $this->input->get('logitem_desc'); ?>" />
                </li>
				<li>
                    <label>Kelompok</label><br />
                    <select name="logitemctx_id" class='filter_param'>
                        <?php foreach ($logctx as $key => $real) { ?>
                            <?php if (($this->input->get('logitemctx_id')) && $this->input->get('logitemctx_id') == $key) { ?>
                                <option value="<?php echo $key ?>" selected><?php echo $real ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $key ?>"><?php echo $real ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </li>
				<li>
                    <label>Kategori</label><br />
                    <select name="logitemcat_id" class='filter_param'>
                        <?php foreach ($logcat as $key => $real) { ?>
                            <?php if (($this->input->get('logitemcat_id')) && $this->input->get('logitemcat_id') == $key) { ?>
                                <option value="<?php echo $key ?>" selected><?php echo $real ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $key ?>"><?php echo $real ?></option>
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
    <table class="tab-admin" cellpadding="0" cellspacing="0">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;">No</th>
                <td class="header" style="cursor: pointer ;">Nama</th>
                <td class="header" style="cursor: pointer ;">Satuan</th>
                <td class="header" style="cursor: pointer ;">Kelompok</th>
                <td class="header" style="cursor: pointer ;">Kategori</th>
                <td class="header delete" style="width: 52px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($logistic_item)) {
                foreach ($logistic_item as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                        <td><?php echo $count+$this->uri->segment(4); ?></td>
                        <td><?php echo $row->logitem_desc; ?></td>
                        <td><?php echo $row->logitem_metric; ?></td>
                        <td><?php echo $row->logitemctx_name; ?></td>
                        <td><?php echo $row->logitemcat_name; ?></td>
                        <td class="action">
                            <?php if (is_has_access('logistic_item-edit', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/logistic_item_ctrl/edit/<?php echo $row->logitem_id.'?'.http_build_query($_GET) . '#form-pos' ?>" ><div class="tab-edit"></div></a> 
                            <?php }?>
                            <?php if (is_has_access('logistic_item-delete', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/logistic_item_ctrl/delete/<?php echo $row->logitem_id.'?'.http_build_query($_GET) ?>" class="delete-tab"><div class="tab-delete"></div></a>
                            <?php }?>
                        </td>

                    </tr>
                    <?php
					$count++;
				}
            }
            ?>

        </tbody>
    </table>
    
    <style>
        .pagination{
            margin: 10px 0 0 15px;
        }
        
        .pagination a{
            padding: 5px 10px;
            background: #DDD;
            margin: 0 2px;
            display: block;
            float: left;
            color: #666;
            text-decoration: none;
            border: 1px solid #BBB;
        }
        
        .pagination strong{
            float: left;
            margin: 0 10px;
            padding: 6px 0;
        }
        
        .pagination a:hover{
            background: #BBB;
            color: #333;
            border: 1px solid #999;
        }
    </style>
    
    <div class="pagination">
        <?php echo $pagination ?>
    </div>
    
    <br /><br />
    <?php if (is_has_access('logistic_item-edit', $permission) || is_has_access('*', $permission)) { ?>    
    <p id="form-pos" class="tit-form">Entri Data Kondisi Teknis</p>
    <form action="<?php echo base_url() ?>admin/logistic_item_ctrl/save" method="post" id="addLogisticItem">
        <?php if (!empty($obj)) { ?>
            <input class="form-data" type="hidden" name="logitem_id" value="<?php if (!empty($obj)) echo $obj->logitem_id; ?>" />
        <?php } ?>
        <ul class="form-admin">
            <li>
                <label>Nama Kondisi Teknis * </label>
                <textarea class="form-admin" rows="1" cols="1" name="logitem_desc"><?php if (!empty($obj)) echo $obj->logitem_desc; ?></textarea>
                <?php echo form_error('logitem_desc'); ?>
                <div class="clear"></class>
            </li>
            <li>
                <label>Satuan Ukur * </label>
                <input class="form-admin" name="logitem_metric" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->logitem_metric; ?>" >
                <?php echo form_error('logitem_metric'); ?>
                <div class="clear"></class>
            </li>
            <li>
                <label>Kelompok *</label>
                <?php
                $stat = 'class="form-admin"';
                
                if (!empty($obj)) {
                    echo form_dropdown('logitemctx_id', $logctx, $obj->logitemctx_id, $stat);
                } else {
                    echo form_dropdown('logitemctx_id', $logctx, '', $stat);
                }
                ?>
                <div class="clear"></class>
            </li>
            <li>
                <label>Kategori</label>
                <?php
                $stat = 'class="form-admin"';
                
                if (!empty($obj)) {
                    echo form_dropdown('logitemcat_id', $logcat, $obj->logitemcat_id, $stat);
                } else {
                    echo form_dropdown('logitemcat_id', $logcat, '', $stat);
                }
                ?>
                <div class="clear"></class>
            </li>
            <li>
                <label>&nbsp;</label>
                <input class="button-form" type="submit" value="Simpan">
		        <input class="button-form" type="reset" onclick="redirect('')" value="Batal">
		        <input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
            </li>
        </ul>
    </form>
    <?php }?>
</div>
<div class="clear"></div>
