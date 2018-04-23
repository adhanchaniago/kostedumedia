<?php if ($this->session->flashdata('info')) { ?>
    <script>
        $(document).ready(function() 
        {
<?php if ($this->session->flashdata('update_mongo')) { ?>
            console.log('updatePesanMongo ' + '<?php echo $this->session->flashdata("update_mongo"); ?>');
            socket.emit('updatePesanMongo', <?php echo $this->session->flashdata('update_mongo'); ?>);
<?php } ?>
            $('.success').html("<strong> <?php echo $this->session->flashdata('info'); ?>");
            $('.success').attr('style','');
            $('.success').delay(10000).fadeOut('slow');
        });
    </script>
<?php } ?>

<script>
    $(document).ready(function() 
    {           
        $("#addPesan").validate({
            rules:{
                id_to: "required",
            },
            messages:{
                id_to: "required",
            }
        });     
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Hapus Konsep Pesan"></div>')
            .html('Pesan yang dihapus tidak dapat dikembalikan lagi. Hapus konsep pesan? <div class="clear"></div>').dialog({
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
        window.location = "<?php echo base_url() ?>admin/message_ctrl" + tail;
    }
    
    function kirimPesan() {
        var theForm = document.getElementById("addPesan");
        theForm.action = "<?php echo base_url() ?>admin/message_ctrl/send";
        theForm.submit();
    }
    
    function kirimKeSemua() {
        var theForm = document.getElementById("addPesan");
        theForm.action = "<?php echo base_url() ?>admin/message_ctrl/sendAll";
        theForm.submit();
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
    
    <p id="form-pos" class="tit-form">Entri Pesan</p>
    <form action="<?php echo base_url() ?>admin/message_ctrl/save" method="post" class="jNice" id="addPesan">
        <?php if (!empty($obj)) { ?>
            <input type="hidden" name="msg_id" value="<?php if (!empty($obj)) echo $obj->msg_id; ?>" />
        <?php } ?>
        <ul class="form-admin">
<?php if (!empty($obj)) { ?>
            <li>
                <label>Tanggal Dibuat </label>
                <input name="created_time" type="text" class="form-admin"
                       value="<?php echo $obj->created_time; ?>" >
                <div class="clear"></div>
            </li>
<?php } ?>
            <!--<li>
                <label>Pengirim </label>
                <input name="sender_name" type="text" class="form-admin"
                       value="<?php if (!empty($obj)) echo $obj->sender_name; ?>" >
                <div class="clear"></div>
            </li>
            <li>
                <label>Penerima </label>
                <input name="rcvr_name" type="text" class="form-admin"
                       value="<?php if (!empty($obj)) echo $obj->rcvr_name; ?>" >
                <div class="clear"></div>
            </li>-->
            <li>
                <label>Posisi </label>
                <select name="id_to" class="form-admin">
                    <option value="" selected>-Pilih Posisi Penerima-</option>
                    <?php foreach ($ships as $row) { ?>
                        <?php if ((!empty($obj)) && $obj->id_to == $row->ship_id) { ?>
                            <option value="<?php echo $row->ship_id ?>" selected><?php echo $row->ship_id . ' - ' . $row->ship_name ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $row->ship_id ?>"><?php echo $row->ship_id . ' - ' . $row->ship_name ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <div class="clear"></div>
            </li>
            <li>
                <label>Pesan </label>
                <textarea class="form-admin" name="msg" rows="1" cols="1" id="elm2"><?php if (!empty($obj)) echo $obj->msg; ?></textarea>
                <?php echo form_error('msg'); ?>                    
                <div class="clear"></div>
            </li>
            <li>
                <p class="tit-form"></p>
                <label>&nbsp;</label>
                <input type="submit" class="button-form" value="Simpan">
                <input type="reset" class="button-form" value="Batal" onclick="redirect('')">
                <input class="button-form" type="button" value="Kirim" onclick="kirimPesan()"/>
                <input class="button-form" type="button" value="Kirim ke Semua" onclick="kirimKeSemua()"/>
            </li>
        </ul>
    </form>
    
    
    <p class="tit-form" id="nPesan">Konsep Pesan <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
    <div class="filtering" style="display: none;">
        <form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
            <ul class="filter-form">
                <li>
                    <label>ID Penerima</label><br />
                    <input type="text" name="id_to" class='filter_param' value="<?php echo $this->input->get('operation_name'); ?>" />
                </li>
                <!--<li>
                    <label>Penerima</label><br />
                    <input type="text" placeholder="Nama" name="rcvr_name" class='filter_param' value="<?php echo $this->input->get('operation_name'); ?>" />
                </li>
                <li>
                    <label>Isi Pesan</label><br />
                    <input type="text" placeholder="Pesan" name="msg" class='filter_param' value="<?php echo $this->input->get('operation_name'); ?>" />
                </li>-->
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
                <!--<td class="header" style="cursor: pointer ;">Pengirim</td>
                <td class="header" style="cursor: pointer ;">Penerima</td>
                <td class="header" style="cursor: pointer ;">Posisi</td>-->
                <td class="header" style="cursor: pointer ;">Tanggal Dibuat</td>
                <td class="header" style="cursor: pointer ;">ID Penerima</td>
                <td class="header" style="cursor: pointer ;">Pesan</td>
                <!--<td class="header" style="cursor: pointer ;">Status</td>-->
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
                        <!--<td><?php echo $row->sender_name; ?></td>
                        <td><?php echo $row->rcvr_name; ?></td>-->
                        <td><?php echo $row->created_time; ?></td>
                        <td><?php echo 'KRI ' . $row->id_to; ?></td>
                        <td><?php echo $row->msg; ?></td>
                        <!--<td><?php echo $row->state; ?></td>-->
                        <td class="action">
                            <!--<a href="<?php echo base_url(); ?>admin/message_ctrl/edit/<?php echo $row->id_pesan . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-edit"></div></a> -->
                            <a href="<?php echo base_url(); ?>admin/message_ctrl/edit/<?php echo $row->msg_id . '?' . http_build_query($_GET).'#form-pos' ?>" ><div class="tab-edit"></div></a> 
                            <a href="<?php echo base_url(); ?>admin/message_ctrl/delete/<?php echo $row->msg_id ?>" class="delete-tab"><div class="tab-delete"></div></a>  
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

</div>
<div class="clear"></div>
