<script>
    $(document).ready(function() 
    {
<?php if ($this->session->flashdata('info')) { ?>
        $('.success').html("<strong> <?php echo $this->session->flashdata('info'); ?>");
        $('.success').attr('style','');
        $('.success').delay(10000).fadeOut('slow');
<?php } ?>

        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Hapus Pesan Masuk"></div>')
            .html('Pesan yang dihapus tidak dapat dikembalikan lagi. Hapus pesan masuk? <div class="clear"></div>').dialog({
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

function redirect(tail) {
        window.location = "<?php echo base_url() ?>admin/message_ctrl/inbox" + tail;
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

</script>
<div id="main">

    <div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
    
    <p class="tit-form">Daftar Pesan Masuk<a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
    <div class="filtering" style="display: none;">
        <form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
            <ul class="filter-form">
                <li>
                    <label>ID Pengirim</label><br />
                    <input type="text" name="id_from" class='filter_param' value="<?php echo $this->input->get('operation_name'); ?>" />
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
                <td class="header">No</td>
                <td class="header" style="cursor: pointer ;">Tanggal Dibuat</td>
                <!--<td class="header" style="cursor: pointer ;">Received time</td>-->
                <td class="header" style="cursor: pointer ;">ID Pengirim</td>
                <!--<td class="header" style="cursor: pointer ;">Pesan</td>-->
                <td class="header" style="cursor: pointer ;">Status</td>
                <td class="header delete" style="width: 55px;">Aksi</td>
            </tr>
        </thead>
        <tbody>
<?php
    $count = 1;
    if (!empty($messages)) {
        foreach ($messages as $row) {
?>
            <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                <td><?php echo ($count++)+$offset;?></td>
                <td><?php echo $row->created_time; ?></td>
                <!--<td><?php echo $row->changed_state_time; ?></td>-->
                <td><?php echo $row->id_from; ?></td>
               <!-- <td><?php echo $row->msg; ?></td> -->
                <td><?php echo $row->state_description; ?></td>
                <td class="action">
                    <a href="<?php echo base_url(); ?>admin/message_ctrl/view_inbox/<?php echo $row->msg_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-view"></div></a>
                    <a href="<?php echo base_url(); ?>admin/message_ctrl/delete_inbox/<?php echo $row->msg_id ?>" class="delete-tab"><div class="tab-delete"></div></a>  
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
            <?php echo $pagination?>
        </div>
    <br />

<?php if (isset($obj)) { ?>
    <p id="form-pos" class="tit-form">Lihat Pesan</p>
    <form class="jNice">
        <ul class="form-admin">
            <li>
                <label>Tanggal Dibuat </label>
                <input name="created_time" type="text" class="form-admin"
                       value="<?php echo $obj->created_time; ?>" >
                <div class="clear"></div>
            </li>
           <!-- <li>
                <label>Pengirim </label>
                <input name="sender_name" type="text" class="form-admin"
                       value="<?php echo $obj->sender_name; ?>" >
                <div class="clear"></div>
            </li>
            <li>
                <label>Penerima </label>
                <input name="rcvr_name" type="text" class="form-admin"
                       value="<?php echo $obj->rcvr_name; ?>" >
                <div class="clear"></div>
            </li>-->
            <li>
                <label>Pengirim </label>
                <?php foreach ($ships as $row) { 
                    if ((!empty($obj)) && $obj->id_from == $row->ship_id) { ?>
                        <input name="penerima" type="text" class="form-admin"
                               value="<?php echo $row->ship_id . ' - ' . $row->ship_name; ?>" >
<?php 
                    }
                } 
?>
                <div class="clear"></div>
            </li>
            <li>
                <label>Pesan </label>
                <textarea class="form-admin" name="msg" rows="1" cols="1" id="elm2"><?php if (!empty($obj)) echo $obj->msg; ?></textarea>
                <?php echo form_error('msg'); ?>                    
                <div class="clear"></div>
            </li>
        </ul>
    </form> 
<?php } ?>
</div>
