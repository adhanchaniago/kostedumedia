<?php if ($this->session->flashdata('info')) { ?>
    <script>
        $(document).ready(function(){
            $('.success').html('<strong>Penyimpanan data berhasil.<strong> <?php echo $this->session->flashdata('info'); ?>');
            $('.success').attr('style','');
            $('.success').delay(3000).fadeOut('slow');
        });
    </script>
<?php } ?>

<!-- jquery upload -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/uploadify.css">
<script src="<?php echo base_url()?>assets/js/jquery.uploadify.min.js"></script>

<script>
    // $(document).ready(function(){
    //     $('#fcomp_icon').uploadify({
    //         'swf' : '<?php echo base_url()?>assets/img/uploadify.swf',
    //         'uploader' : '<?php echo base_url()?>admin/force_component_ctrl/upload_handler'
    //     });
    // });
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

    <p class="tit-form">Daftar Komponen Kekuatan <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
    <div class="filtering" style="display: none;">
        <form action="<?php echo base_url().'admin/force_component_ctrl' ?>" method="get" id="form_search_filter">
                    <input type="hidden" placeholder="Nama Pesawat" name="filter" class='filter_param' value="set"/>
            <ul class="filter-form">
                <li>
                    <label>Nama Komponen</label><br />
                    <input type="text" placeholder="Nama Kekuatan Lawan" 
                        name="fcompname_filter" class='filter_param' 
                        value="<?php echo $this->input->get('fcompname_filter'); ?>"/>
                </li>
                <li>
                    <label>Jenis Komponen</label><br />
                   <select name="eforcetypeid_filter">
                        <option value="">--Pilih Salah Satu--</option>
                        <?php foreach($fcomp_types as $fcomp_type){?>
                            <option value="<?php echo $fcomp_type->fcomptype_id?>" 
                                    <?php if( $this->input->get('fcomptype_filter') == $fcomp_type->fcomptype_id ) 
                                        echo 'selected' ?>> <?php echo $fcomp_type->fcomptype_name?></option>
                        <?php } ?>
                    </select>
                </li>
                <li>
                    <label>Ikon Komponen</label><br />
                    <input type="text" placeholder="Nama Kekuatan Lawan" 
                        name="fcompname_filter" class='filter_param' 
                        value="<?php echo $this->input->get('fcompname_filter'); ?>"/>
                    <div id="progress">
                        <div class="bar"></div>
                    </div>   
                </li>
            </ul>

            <div class="clear"></div>
            <div style="border-bottom: 1px dotted #DDD; margin: 15px 0 17px 0;"></div>
			
            <input type="submit" value="Filter" name="search_filter" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
			<input type="button" value="Bersihkan Pencarian" onclick="document.location='<?php echo base_url().'admin/force_component_ctrl' ?>';" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />

            <div class="clear"></div>
            <div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
        </form>
    </div>
    <table class="tab-admin">

        <tr class="tittab">
            <td class="header">No</td>
            <td class="header" style="cursor: pointer ;">Nama Komponen Kekuatan</td>
            <td class="header" style="cursor: pointer ;">Kelompok Komponen Kekuatan </td>
            <td class="header" style="cursor: pointer ;">Aksi </td>
        </tr>
        <?php
        $count = 1;
        if (!empty($force_component)) {
            foreach ($force_component as $row) {
                ?>
                <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                    <td><?php echo ($count++)+$offset; ?></td>
                    <td><?php echo $row->fcomp_name; ?></td>
                    <td><?php echo $row->fcomptype_name ?></td>
                    
                    <td class="action">
                        <a href="<?php echo base_url(); ?>admin/force_component_ctrl/view/<?php echo $row->fcomp_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-view"></div></a> 
                        <?php if (is_has_access('force_component_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/force_component_ctrl/edit/<?php echo $row->fcomp_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-edit"></div></a> 
                        <?php } ?>
                        <?php if (is_has_access('force_component_ctrl-delete', $permission) || is_has_access('*', $permission)) { ?>
                            <a href="<?php echo base_url(); ?>admin/force_component_ctrl/delete/<?php echo $row->fcomp_id . '?' . http_build_query($_GET).'#form-pos' ?>" class="delete-tab"><div class="tab-delete"></div></a>
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

    <?php if (is_has_access('force_component_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
        <p id="form-pos" class="tit-form">Data Kekuatan</p>
        <form action="<?php echo base_url() ?>admin/force_component_ctrl/save" method="post" id="addfcompoplane"
                enctype="multipart/form-data">
            <?php if (!empty($obj)) { ?>
                <input class="form-admin" type="hidden" name="fcomp_id" value="<?php if (!empty($obj)) echo $obj->fcomp_id; ?>" />
            <?php } ?>
            <ul class="form-admin">
                <li>
                    <label>Nama Komponen Kekuatan* </label>
                    <input class="form-admin" name="fcomp_name"  type="text" class="text-medium" id="fcomp_name"
                           value="<?php if (!empty($obj)) echo $obj->fcomp_name; ?>" maxlength="250" <?php if (isset($view)) echo 'disabled'; ?>>
                           <?php echo form_error('fcomp_name'); ?>
                    <div class="clear"></div>
                </li>
                <li>
                    <label>Jenis Komponen Kekuatan* </label>
                    <select name="eforcetype_id">
                        <option value="">--Pilih Salah Satu--</option>
                        <?php foreach($fcomptypes as $fcomptype){?>
                            <option value="<?php echo $fcomptype->fcomptype_id?>" 
                                    <?php if(!empty($obj) && $obj->fcomptype_id == $fcomptype->fcomptype_id) echo 'selected' ?>> 
                                    <?php echo $fcomptype->fcomptype_name?></option>
                        <?php } ?>
                    </select>

                    <div class="clear"></div>
                </li>
                
                <?php if(isset($obj)){?>
                <li>
                    <label>Icon Komponen Kekuatan* </label>                    
                        <img src="<?php echo base_url()?>assets/img/nato-icon/<?php echo $obj->fcomp_icon ?>"/>                    
                    <div class="clear"></div>
                </li>
                <?php }?>
                <li>
                    <label>upload icon :</label>
                    <input name="fcomp_icon" type="file" id="fcomp_icon" value="<?php if (!empty($obj)) echo $obj->fcomp_icon; ?>" 
                            <?php if (isset($view)) echo 'disabled'; ?>>

                           <?php echo form_error('fcomp_icon'); ?>
                    <div class="clear"></div>
                </li>
                
                <?php if (!isset($view)) { ?>
                    <li>
                        <br />
                        <p class="tit-form"></p>
                        <label>&nbsp;</label>
                        <input class="button-form" type="submit" value="Simpan">
                        <input class="button-form" type="reset" onclick="redirect()" value="Batalkan">
                        <input class="button-form" type="button" onclick="redirect()" value="Data Baru"/>
                    </li>
                <?php } ?>
        </form>
    <?php } ?>
    <div class="clear"></div>
</div>