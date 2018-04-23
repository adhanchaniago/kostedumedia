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
        $("#addRole").validate({
            rules:{
                role_id: "required",
                role_name : "required"
            },
            messages:{
                role_id: "required",
                role_name: "required"
            }
        });
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Role"></div>')
            .html('Semua terkait Role akan ikut dihapus! Hapus data role? <div class="clear"></div>').dialog({
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
        
    function redirect(tail){
        window.location = "<?php echo base_url() ?>admin/role_ctrl" + tail;
    }
</script>
<div id="main">

  <div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>
    
    <p class="tit-form">Daftar Role</p>
    <table class="tab-admin">

        <tr class="tittab">
            <td class="header" style="width: 30px;">No</th>
            <td class="header" style="cursor: pointer ;">Nama Role</th>
            <td class="header" style="cursor: pointer ;">Map URL</th>
            <td class="header delete" style="width: 52px;">Aksi</th>
        </tr>
        <?php
        $count = 1;
        if (!empty($role)) {
            foreach ($role as $row) {
                ?>
                <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row->role_name; ?></td>
                    <td><?php echo $row->role_mapurl; ?></td>
                    <td class="action">
                        <?php if (is_has_access('role_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
                        <a href="<?php echo base_url(); ?>admin/role_ctrl/edit/<?php echo $row->role_id . '#form-pos' ?>" ><div class="tab-edit"></div></a> 
                        <?php }?>
                        <?php if (is_has_access('role_ctrl-delete', $permission) || is_has_access('*', $permission)) { ?>
                        <a href="<?php echo base_url(); ?>admin/role_ctrl/delete/<?php echo $row->role_id ?>" class="delete-tab"><div class="tab-delete"></div></a>
                        <?php }?>
                    </td>

                </tr>
                <?php
            }
        }
        ?>


    </table>
    
    <br />
    <?php if (is_has_access('role_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
    <p id="form-pos" class="tit-form">Entri Role</p>
    <form action="<?php echo base_url() ?>admin/role_ctrl/save" method="post" id="addRole">
        <ul class="form-admin">
	        <input type="hidden" value="<?php if (!empty($obj)) echo $obj->role_id; else echo $total_rows + 1; ?>" name="role_id"/>
		    <!-- commented by SKM17
            <li>
                <label>ID * </label>
                <input class="form-admin" name="role_id" type="text" class="text-medium" value="<?php if (!empty($obj)) echo $obj->role_id; ?>" />
                <?php echo form_error('role_id'); ?>
                <div class="clear"></div>
            </li>
            -->
            <li>
                <label>Nama * </label>
                <input class="form-admin" name="role_name" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->role_name; ?>" />
                       <?php echo form_error('role_name'); ?>							
                <div class="clear"></div>
            </li>
            <li>
                <label>Map URL </label>
                <input class="form-admin" name="role_mapurl" type="text" class="text-medium"
                       value="<?php if (!empty($obj)) echo $obj->role_mapurl; ?>" />
                       <?php echo form_error('role_mapurl'); ?>             
                <div class="clear"></div>
            </li>
        </ul>
        <script type="text/javascript">
            var rowTotal = <?php
                       if (!empty($feature_access)) {
                           echo count($feature_access);
                       } else {
                           echo 0;
                       }
                       ?>;
            
                           $(document).ready(function(){
                               $("#addLog").click(function(){
                                   if($('#feature_id').attr("disabled")=="disabled"){
                                       var editNumber = $('#editNumber').val();
                                       var feat_access = $("#feat_access").is(":checked");
                                       var feat_edit = $("#feat_edit").is(":checked");
                                       var feat_delete = $("#feat_delete").is(":checked");
                                       var valFeature = 0;
                                       
                                       if(feat_access==true){
                                           valFeature = valFeature + 1;
                                       }
                                       if(feat_edit==true){
                                           valFeature = valFeature + 2;
                                       }
                                       if(feat_delete==true){
                                           valFeature = valFeature + 4;
                                       }
                                       $('#fiturAkses_'+editNumber+'').val(valFeature);
                                       //                                       $('#fiturAkses_td_'+editNumber+'').text(logValue);
                                   }else{
                                       var rowCount = $('#addFitur').find('tr').size();
                                       var tableClass = (rowCount%2==0)?'row-two':'row-one';
                                       var logId = $('#feature_id option:selected').val();
                                       var logText = $('#feature_id option:selected').text();
                                       var feat_access = $("#feat_access").is(":checked");
                                       var feat_edit = $("#feat_edit").is(":checked");
                                       var feat_delete = $("#feat_delete").is(":checked");
                                       var valFeature = 0;
                                       
                                       if(feat_access==true){
                                           valFeature = valFeature + 1;
                                       }
                                       if(feat_edit==true){
                                           valFeature = valFeature + 2;
                                       }
                                       if(feat_delete==true){
                                           valFeature = valFeature + 4;
                                       }
                                       
                                       if(logId!=''){
                                           if(isExist(logText)){
                                               alert('item fitur sudah ditambahkan, silahkan edit untuk mengubah nilai')
                                           }else {
                                               rowTotal = rowTotal + 1;
                                               $("#totalRow").val(rowTotal);
                                               
                                               var row1 = '<tr class='+tableClass+' id="logitem_'+logText+'"><td>'+rowCount+'</td>';
                                               var row2 = '<td>'+logText+'</td>'+'<input type="hidden" name="fiturVal_'+rowTotal+'" id="fiturVal_'+rowTotal+'" value="'+logId+'" />';
                                               var row4 = '<input type="hidden" name="fiturAkses_'+rowTotal+'" id="fiturAkses_'+rowTotal+'" value="'+valFeature+'" />';
                                               var action = '<td class="action"><a href="javascript:void(0);" onClick="editLog(\''+logId+'\',\''+valFeature+'\',\''+rowTotal+'\')" id="editLog" ><div class="tab-edit"></div></a><a href="javascript:void(0);" id="deleteLog"><div class="tab-delete"></div></a></td></tr>';
                                               
                                               $("#addFitur").append(row1+row2+row4+action);
                                               $('#feature_id').val('');
                                               $('#feat_access').attr("checked",false);
                                               $('#feat_edit').attr("checked",false);
                                               $('#feat_delete').attr("checked",false);
                                           }
                                       }
                                   }
                               });
    
                               $("#addFitur").on('click', '#deleteLog', function(){
                                   $(this).parent().parent().remove();
                                   rowTotal = rowTotal - 1;
                                   $("#totalRow").val(rowTotal);
                               });
                               
                               $("#cancelLog").click(function(){
                                   $('#feature_id').val('');
                                   $('#feat_access').attr("checked",false);;
                                   $('#feat_edit').attr("checked",false);;
                                   $('#feat_delete').attr("checked",false);;
                                   $("#feature_id").attr('disabled',false);
                                   $("#addLog").val('Tambah Fitur');
                               });
                               
                           });
            
                           function editLog(logId,logValue,editNumber){
                               switch(logValue)
                               {
                                   case '1':
                                       $('#feat_access').attr('checked', true);
                                       break;
                                   case '2':
                                       $('#feat_access').attr("checked",false);$('#feat_edit').attr("checked",true);$('#feat_delete').attr("checked",false);
                                       break;
                                   case '3':
                                       $('#feat_access').attr("checked",true);$('#feat_edit').attr("checked",true);$('#feat_delete').attr("checked",false);
                                       break;
                                   case '4':
                                       $('#feat_access').attr("checked",false);$('#feat_edit').attr("checked",false);$('#feat_delete').attr("checked",true);
                                       break;
                                   case '5':
                                       $('#feat_access').attr("checked",true);$('#feat_edit').attr("checked",false);$('#feat_delete').attr("checked",true);
                                       break;
                                   case '6':
                                       $('#feat_access').attr("checked",false);$('#feat_edit').attr("checked",true);$('#feat_delete').attr("checked",true);
                                       break;
                                   case '7':
                                       $('#feat_access').attr("checked",true);$('#feat_edit').attr("checked",true);$('#feat_delete').attr("checked",true);
                                       break;
                               }
                               $('#feature_id').val(logId);
                               $('#editNumber').val(editNumber);
                               $("#feature_id").attr('disabled',true);
                               $("#addLog").val('Ubah');
                           }
                           function isExist(strd){
                               console.log($('tr[id*=logitem]').length)
                               testme=false;
                               $('tr[id*=logitem]').each(function(){
                                   console.log($('td:nth(1)',$(this)).html());
                                   console.log($('td:nth(2)',$(this)).html());
                                   if($('td:nth(1)',$(this)).html()===strd) {
                                       testme=true;            
                                   }   
                               })
                               return testme;
                           }
        </script>
        
        <br />
        
        <p class="tit-form">Daftar Permisi Fitur</p>
        <table class="tab-admin" id="addFitur">

            <tr class="tittab">
                <td style="width: 30px;">No</th>                     
                <td>Fitur</td>
                <td style="width: 52px;">Aksi</td>
            </tr>
            <?php if (!empty($feature_access)) { ?>
                <?php
                $count = 1;
                if (!empty($feature_access)) {
                    foreach ($feature_access as $row) {
                        ?>
                        <tr class="<?php echo alternator("row-one", "row-two"); ?>" id="logitem_<?php echo $row->feat_name ?>">
                            <td><?php echo $count; ?></td>
                            <td><?php echo $row->feat_name; ?></td>
                        <input type="hidden" name="fiturVal_<?php echo $count ?>" id="fiturVal_<?php echo $count ?>" value="<?php echo $row->feat_id ?>" />
                        <!--<td id=fiturAkses_td_<?php echo $count ?>><?php echo $row->aerlog_value; ?></td>-->
                        <input type="hidden" name="fiturAkses_<?php echo $count ?>" id="fiturAkses_<?php echo $count ?>" value="<?php echo $row->featacc_access ?>" />
                        <td class="action"> 
                            <a href="javascript:void(0);" onClick="editLog('<?php echo $row->feat_id ?>','<?php echo $row->featacc_access ?>','<?php echo $count ?>')" id="editLog"><div class="tab-edit"></div></a> 
                            <a href="javascript:void(0);" id="deleteLog"><div class="tab-delete"></div></a>
                        </td>
                        </tr>
                        <?php
                        $count++;
                    }
                }
                ?>

            <?php } ?>
        </table>
        <br />
        <p class="tit-form">Entri Permisi Fitur</p>
        <ul class="form-admin">
            <li>
                <label>Fitur * </label>
                <select id="feature_id" name="feature_id" class="form-admin">
                    <option value="" selected>-Pilih Fitur-</option>
                    <?php foreach ($features as $row) { ?>
                        <option value="<?php echo $row->feat_id ?>"><?php echo $row->feat_name ?></option>
                    <?php } ?>
                </select>
                <div class="clear"></div>
            </li>
            <li>
                <label> Permisi </label>
                <div class="form-admin-check">
                    <label><input type="checkbox" name="feat_access" id="feat_access">Akses</label>
                    <div class="clear"></div>
                    <label><input type="checkbox" name="feat_edit" id="feat_edit">Edit</label>
                    <div class="clear"></div>
                    <label><input type="checkbox" name="feat_delete" id="feat_delete">Hapus</label>
                </div>
                <div class="clear"></div>

            </li>

            <input type="hidden" value="" id="editNumber"/>
            <input type="hidden" value="<?php if (!empty($feature_access)) echo count($feature_access) ?>" id="totalRow" name="totalRow"/>
            <li>
                <label></label>
                <input class="button-form green" id="addLog" type="button" value="<?php if (empty($obj)) echo 'Simpan'; else echo 'Tambah Permisi Fitur'; ?>" >
                <input class="button-form red" id="cancelLog" type="button" value="Batalkan">
                <div class="clear"></div>
            </li>
        </ul>
        <br />
        <p class="tit-form"></p>
		<ul class="form-admin"><li>
		    <label>&nbsp;</label>
		    <input class="button-form" type="submit" value="Simpan">
	        <input class="button-form" type="reset" onclick="redirect('')" value="Batal">
	        <input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
		    <div class="clear"></div>
	    </li></ul>
    </form>
    <?php }?>
</div>
<div class="clear"></div>
