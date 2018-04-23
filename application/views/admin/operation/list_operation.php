<?php if ($this->session->flashdata('info')) { ?>
    <script>
        $(document).ready(function(){
             $('.success').html('<strong>Penyimpanan data berhasil.<strong> <?php echo $this->session->flashdata('info'); ?>');
            $('.success').attr('style','');
            $('.success').delay(3000).fadeOut('slow');
        });
    </script>
<?php } ?>
<style>
    #backlight{
        margin: -15px 0 0 0;
        position: absolute;
        cursor: pointer;
        width: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    #spotting-holder{
        width: 700px;
        left: 50%;
        margin: 20px 0 0 -355px;
        background: #eee;
        position: fixed;
        z-index: 999;
        padding: 5px;
    }

    #spotting-content{
        background: #fff;
        border: 1px solid #ddd;
    }

    #title-pop{
        background: #F9F9F9;
        border-bottom: 1px solid #DDD;
    }

    #title-pop ul{
        padding: 5px;
    }

    #title-pop ul li{
        text-align: left;
        padding: 3px 5px;
        text-shadow: 0 1px 1px #FFF;
    }

    #title-pop ul li p{
        font-size: 18px;
    }

    #title-pop ul li label{
        float: left;
        width: 100px;
        font-size: 11px;
        font-weight: bold;
    }

    .list-data{
        width: 332px;
        border: 1px solid #DDD;
        margin: 10px 0 10px 10px;
        float: left;
    }

    .list-data .scrolling{
        max-height: 480px;
        overflow-y: scroll;
    }

    .list-data .scrolling::-webkit-scrollbar{ 
        display: block; 
        width: 14px;
        height: 15px;
    }

    .list-data .scrolling::-webkit-scrollbar-track-piece{
        background-color: #FFF;
        border-left: 1px solid #DDD;
        box-shadow: inset 0 0 5px #DDD;
    }

    .list-data .scrolling::-webkit-scrollbar-thumb:vertical{
        background-color: #CCC;
        width: 10px;
        height: 10px;
    }

    .list-data .scrolling::-webkit-scrollbar-thumb:vertical:hover{
        background-color: #999;
    }

    .list-data a{
        background: #EEE;
        color: #999;
        padding: 10px;
        font-weight: bold;
        text-decoration: none;
        text-align: left;
        display: block;
        border-bottom: 1px solid #CCC;
        transition: all 300ms ease-in-out;
        -o-transition: all 300ms ease-in-out;
        -ms-transition: all 300ms ease-in-out;
        -moz-transition: all 300ms ease-in-out;
        -webkit-transition: all 300ms ease-in-out;
    }

    .list-data a#add-all,
    .list-data a#remove-all{
        position: absolute;
        padding: 2px 3px 3px 3px;
        border: 1px solid #CCC;
        margin: -3px 0 0 238px;
        font-size: 10px;
    }

    .list-data a img{
        float: right;
        margin: -4px 0 0 0;
    }

    .list-data a:hover{
        color: #666;
        background: #F9F9F9;
    }

    .list-data p{
        padding: 7px 0;
        color: #999;
        font-size: 11px;
    }

    .list-data p.datkos{
        font-size: 14px;
        font-weight: bold;
        border-bottom: 1px solid #DDD;
    }

    .search-list{
        border: none;
        height: 32px;
        width: 316px;
        padding: 0 8px;
        font-size: 14px;
        border-bottom: 1px solid #CCC;
    }
</style>
<script>
    $(document).ready(function(){
        var baseUrl = '<?php echo base_url() ?>';
        var htmlHeight = $('html').height();
        
        $("#operationAdd").validate({
            rules:{
                operation_name: "required",
                operation_year: "required",
                operation_start: "required",
                operation_end: "required"
            },
            messages:{
                operation_name: "required",
                operation_year: "required",
                operation_start: "required",
                operation_end: "required"
            }
        });
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Marines"></div>')
            .html('All item related to Marine will be deleted to ! Are you sure ?<div class="clear"></div>').dialog({
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
        
        $('a.edit').click(function(e){
            e.preventDefault();
            $('#backlight').height(htmlHeight);
            var url = $(this).attr('href');
            $('#backlight').fadeIn('fast', function(){
                $('#spotting-holder').load(url,function(){
                    $(this).fadeIn('fast');
                })
            });
        });
        //datepicker
        $("#operation_start").datepicker({dateFormat:'yy-mm-dd'});        
        $("#operation_end" ).datepicker({
            dateFormat: 'yy-mm-dd',
            minDate:$('#operation_start').val()
        });        
        
        $('#operation_start').change(function(){
            $('#operation_end').val("");
            var begin_date = $(this).datepicker('getDate');
            var end_date_min = new Date(begin_date.getTime());
            end_date_min.setDate(end_date_min.getDate()+1);
            $('#operation_end').datepicker( "destroy" )
            $('#operation_end').datepicker({minDate:end_date_min ,dateFormat : 'yy-mm-dd'});
        });
                    
        $('#backlight').click(function(e){
            e.preventDefault();
                    
            $('#spotting-holder').fadeOut('fast', function(){
                $('#backlight').fadeOut('fast');
            });
        });
                
    });
    function close_page(){
        $('#spotting-holder').fadeOut('fast');
        $('#backlight').fadeOut('fast');
    };
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
<!-- h2 stays for breadcrumbs -->
<!--<h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">Operation</a></h2>-->
<div id="spotting-holder" style="display: none;"></div>
<div id="backlight" style="display: none;"></div>
<div id="main">

    <div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
    
    <p class="tit-form">Daftar Operasi <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
    <div class="filtering" style="display: none;">
        <form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
            <ul class="filter-form">
                <li>
                    <label>Nama Operasi</label><br />
                    <input type="text" placeholder="Nama Pesawat" name="operation_name" class='filter_param' value="<?php echo $this->input->get('operation_name'); ?>" onkeypress="search_enter_press(event);" />
                </li>
				<li>
                    <label>Jenis Operasi</label><br />
                    <select name="optype_id" class='filter_param'>
                        <option value="">Jenis Operasi</option>
                        <?php foreach ($operation_type as $key => $real) { ?>
                            <?php if (($this->input->get('optype_id')) && $this->input->get('optype_id') == $key) { ?>
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

            <div class="clear"></div>
            <div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
        </form>
    </div>
    <table class="tab-admin">
        <thead>
            <tr class="tittab">
                <td style="width: 20px;">No</th>						
                <td>Nama Operasi</td>
                <td>Deskripsi Operasi</td>
                <td>Tanggal Mulai</td>
                <td>Tanggal Berakhir</td>
                <td style="width: 52px;" class="delete">Actions</td>
            </tr>
        </thead>							
        <tbody>
            <?php
            $count = 1;
            if (!empty($operation)) {
                foreach ($operation as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-two", "row-one"); ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->operation_name; ?></td>
                        <td><?php echo $row->operation_description; ?></td>
                        <td><?php echo $row->operation_start; ?></td>
                        <td><?php echo $row->operation_end; ?></td>
                        <td class="action">
                            <?php if (is_has_access('operation-edit', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/operation_ctrl/edit/<?php echo $row->operation_id.'?'.http_build_query($_GET) ?>"><div class="tab-edit"></div></a> 
                            <?php }?>
                            <?php if (is_has_access('operation-delete', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/operation_ctrl/delete/<?php echo $row->operation_id.'?'.http_build_query($_GET) ?>" class="delete"><div class="tab-delete"></div></a>
                            <?php }?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>	                      
    </table>
	<br />
	<?php echo $pagination?>
    <br />
    <?php if (is_has_access('operation-edit', $permission) || is_has_access('*', $permission)) { ?>
    <p class="tit-form">Entri Data Operasi</p>
    <form action="<?php echo base_url() ?>admin/operation_ctrl/save" method="post" id="operationAdd">
        <?php if (!empty($obj)) { ?>
            <input type="hidden" name="operation_id" value="<?php if (!empty($obj)) echo $obj->operation_id; ?>" />
        <?php } ?>
        <ul class="form-admin">
            <li>
                <label>Nama Ops:</label>
                <input name="operation_name" type="text" class="form-admin"
                       value="<?php if (!empty($obj)) echo $obj->operation_name; ?>" >
                <div class="clear"></div>
            </li>
            <li>
                <label>Deskripsi Ops:</label>
                <textarea rows="1" cols="1" name="operation_description" class="form-admin"><?php if (!empty($obj)) echo $obj->operation_description; ?></textarea>
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
                <label>Sepanjang Tahun:</label>
                <div class="form-admin-radio">
                    <label>

                        <input type="radio"  name="operation_annual" value="true" <?php if (!empty($obj)) iff($obj->operation_annual == 't', 'checked', '') ?> > Ya
                    </label>
                    <div class="clear"></div>
                    <label>

                        <input type="radio" name="operation_annual" value="false" <?php if (!empty($obj)) iff($obj->operation_annual == 'f', 'checked', '') ?> > Tidak
                    </label>
                    <div class="clear"></div>

                </div>
                <div class="clear"></div>
            </li>
            <li>
                <label>Tahun Pelaksanaan:</label>
                <input name="operation_year" id="operation_year" type="text" class="form-admin" value="<?php if (!empty($obj)) echo $obj->operation_year ?>" onkeypress="return isNumberKey(event)" maxlength="4"/>
                <div class="clear"></div>
            </li>
            <li>
                <div>
                    <label>Waktu Mulai</label>
                    <input name="operation_start" id="operation_start" type="text" class="form-admin"
                           value="<?php if (!empty($obj)) echo $obj->operation_start; ?>" >
                </div>
                <div class="clear"></div>
            </li>
            <li>	
                <div>
                    <label>Waktu Akhir</label>
                    <input name="operation_end" id="operation_end" type="text" class="form-admin" 
                           value="<?php if (!empty($obj)) echo $obj->operation_end; ?>" >
                </div>
                <div class="clear"></div>
            </li>
        </ul>

        <br />
        <p class="tit-form">Unsur</p>
        <table class="tab-admin">
            <tr class="row-one">
                <td style="width: 25px;">
                    <strong style="width: 70px; float: left;">Kapal</strong>: <?php
                if (!empty($ship_surface_total)) {
                    echo count($ship_surface_total);
                } else {
                    echo 0;
                }
                ?> Unit
                </td>
                <?php if (!empty($obj)) { ?>
                    <td style="width: 15px;">
                        <a href="<?php echo base_url() ?>admin/operation_ctrl/operationData/ship/<?php echo $obj->operation_id; ?>" class="edit"><div class="tab-edit"></div></a>
                    </td>
                <?php } ?>
            </tr >                        
            <tr class="row-two">
                <td>
                    <strong style="width: 70px; float: left;">Marinir</strong>: <?php
                if (!empty($satpurmar_total)) {
                    echo count($satpurmar_total);
                } else {
                    echo 0;
                }
                ?> Unit
                </td>
                <?php if (!empty($obj)) { ?>
                    <td>
                        <a href="<?php echo base_url() ?>admin/operation_ctrl/operationData/marines/<?php echo $obj->operation_id; ?>" class="edit"><div class="tab-edit"></div></a>
                    </td>
                <?php } ?>
            </tr>                        
            <tr class="row-one">
                <td>
                    <strong style="width: 70px; float: left;">Pasud</strong>: <?php
                if (!empty($aeroplane_total)) {
                    echo count($aeroplane_total);
                } else {
                    echo 0;
                }
                ?> Unit
                </td>
                <?php if (!empty($obj)) { ?>
                    <td>
                        <a href="<?php echo base_url() ?>admin/operation_ctrl/operationData/aeroplane/<?php echo $obj->operation_id; ?>" class="edit"><div class="tab-edit"></div></a>
                    </td>
                <?php } ?>
            </tr>                        
            <tr class="row-two">
                <td>
                    <strong style="width: 70px; float: left;">Ranpur</strong>: <?php
                if (!empty($ranpurmar_total)) {
                    echo count($ranpurmar_total);
                } else {
                    echo 0;
                }
                ?> Unit
                </td>
                <?php if (!empty($obj)) { ?>
                    <td>
                        <a href="<?php echo base_url() ?>admin/operation_ctrl/operationData/fvehicle/<?php echo $obj->operation_id; ?>" class="edit"><div class="tab-edit"></div></a>
                    </td>
                <?php } ?>
            </tr>                        
            <tr class="row-one">
                <td>
                    <strong style="width: 70px; float: left;">Submarine</strong>: <?php
                if (!empty($ship_submarine_total)) {
                    echo count($ship_submarine_total);
                } else {
                    echo 0;
                }
                ?> Unit
                </td>
                <?php if (!empty($obj)) { ?>
                    <td>
                        <a href="<?php echo base_url() ?>admin/operation_ctrl/operationData/submarine/<?php echo $obj->operation_id; ?>" class="edit"><div class="tab-edit"></div></a>
                    </td>
                <?php } ?>
            </tr>                        
        </table>
        <ul class="form-admin">
            <li>
                <input type="submit" value="Simpan" class="button-form">
                <input type="reset" value="Batalkan" class="button-form">
            </li>
        </ul>
    </form>
    <?php }?>
</div>
<div class="clear"></div>