<?php if ($this->session->flashdata('info')) { ?>
    <script>
        $(document).ready(function(){
            $('.success').html('<strong> <?php echo $this->session->flashdata('info'); ?>');
            $('.success').attr('style','');
            $('.success').delay(10000).fadeOut('slow');
        });
    </script>
<?php } ?>
<script>
    $(document).ready(function(){
<?php if (empty($obj)) { ?>
            $("#addUsers").validate({
                rules:{
                    corps_id: "required",
                    password: {
                        required: true,
                        minlength: 5
                    },
                    confirm_password: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
                    },
                    email: "required",
                    username: "required",
                    role_id: "required"
                    //                corps_description: "required"
                },
                messages:{
                    corps_id: "required",
                    password: {
                        required: "required",
                        minlength: "Your password must be at least 5 characters long"
                    },
                    confirm_password: {
                        required: "required",
                        minlength: "Your password must be at least 5 characters long",
                        equalTo: "Please enter the same password as above"
                    },
                    email: "required",
                    username: "required",
                    role_id: "required"
                    //                corps_description: "required"
                }
            });
<?php } else { ?>
            $("#addUsers").validate({
                rules:{
                    corps_id: "required",
                    password: {
                        minlength: 5
                    },
                    confirm_password: {
                        minlength: 5,
                        equalTo: "#password"
                    },
                    email: "required",
                    username: "required",
                    role_id: "required"
                    //                corps_description: "required"
                },
                messages:{
                    corps_id: "required",
                    password: {
                        minlength: "Your password must be at least 5 characters long"
                    },
                    confirm_password: {
                        minlength: "Your password must be at least 5 characters long",
                        equalTo: "Please enter the same password as above"
                    },
                    email: "required",
                    username: "required",
                    role_id: "required"
                    //                corps_description: "required"
                }
            });
<?php } ?>
        $('.delete-tab').click(function(){
            var page = $(this).attr("href");
            var $dialog = $('<div title="Pengguna"></div>')
            .html('Hapus salah satu pengguna? <div class="clear"></div>').dialog({
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
        window.location = "<?php echo base_url() ?>admin/users_ctrl" + tail;
    }
</script>

<div class="clear " id="notif-holder"></div>
    <p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data KRI berhasil disimpan.</p>

<p class="tit-form">Daftar Pengguna</p>
<table class="tab-admin">
    <thead>
        <tr class="tittab">
            <td class="header" style="width: 30px;">No</td>
            <td class="header" style="cursor: pointer ;">Nama Pengguna</td>
            <td class="header" style="cursor: pointer ;">Email</td>
            <td class="header" style="cursor: pointer ;">Kesatuan</td>
            <td class="header" style="cursor: pointer ;">Role</td>
            <td class="header" style="cursor: pointer ;">Status</td>
            <td class="header delete" style="width: 52px;">Aksi</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        if (!empty($users)) {
            foreach ($users as $row) {
                ?>
                <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                    <td><?php echo ($count++)+$offset; ?></td>
                    <td><?php echo $row->username; ?></td>
                    <td><?php echo $row->email; ?></td>
                    <td><?php echo $row->corps_name; ?></td>
                    <td><?php echo $row->role_name; ?></td>
                    <td><?php if ($row->users_isactive == 't') echo 'Aktif'; else echo 'Tidak aktif'; ?></td>
                    <td class="action"> 
                        <?php if (is_has_access('users_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
                        <a href="<?php echo base_url(); ?>admin/users_ctrl/edit/<?php echo $row->user_id . '#form-pos'?>" ><div class="tab-edit"></div></a> 
                        <?php }?>
                        <?php if (is_has_access('users_ctrl-delete', $permission) || is_has_access('*', $permission)) { ?>
                        <a href="<?php echo base_url(); ?>admin/users_ctrl/delete/<?php echo $row->user_id ?>" class="delete-tab"><div class="tab-delete"></div></a>
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
<?php if (is_has_access('users_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
<p id="form-pos" class="tit-form">Entri Data Pengguna</p class="tit-form">
<form action="<?php echo base_url() ?>admin/users_ctrl/save" method="post" class="" id="addUsers">

    <ul class="form-admin">
        <?php if (!empty($obj)) { ?>
            <input type="hidden" value="<?php echo $obj->user_id ?>" name="user_id"/>
        <?php } ?>
        <li>
            <label>Kesatuan * </label>
            <select name="corps_id" class="form-admin">
                <option value="" selected>-Pilih Kesatuan-</option>
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
            <label>Nama pengguna *</label>
            <input class="form-admin" name="username" type="text" class="text-medium"
                   value="<?php if (!empty($obj)) echo $obj->username; ?>" >
                   <?php echo form_error('username'); ?>

            <div class="clear"></div>
        </li>
        <li>
            <label>Kata Sandi *</label>
            <input class="form-admin" name="password" id="password" type="password" class="text-medium" value="" />
                   <?php echo form_error('password'); ?>					

            <div class="clear"></div>
        </li>
        <li>
            <label>Konfirmasi kata sandi *</label>
            <input class="form-admin" name="confirm_password" id="confirm_password" type="password" class="text-medium" />

            <div class="clear"></div>
        </li>
        <?php if (!empty($obj)) { ?>
            <li><label></label>*Kosongkan kolom kata sandi jika anda tidak ingin merubah kata sandi.</li>
        <?php } ?>
        <li>
            <label>Email *</label>
            <input class="form-admin" name="email" type="text" class="text-medium"
                   value="<?php if (!empty($obj)) echo $obj->email; ?>" >
                   <?php echo form_error('email'); ?>					

            <div class="clear"></div>
        </li>
		<li>
            <label>Aktif * </label>
            <div class="form-admin-radio">
                <label><input type="radio" name="users_isactive" value="TRUE" <?php if (!empty($obj) && $obj->users_isactive) echo 'checked'; ?> > Yes</label>
                <div class="clear"></div>
                <label><input type="radio" name="users_isactive" value="FALSE" <?php if (empty($obj) || !$obj->users_isactive) echo 'checked'; ?>> No</label>
            </div>

            <div class="clear"></div>
        </li>
        <li>
            <label>Role * </label>
            <select name="role_id" class="form-admin">
                <option value="" selected>-Pilih Role-</option>
                <?php foreach ($role as $row) { ?>
                    <?php if ((!empty($user_role)) && $user_role[0]->role_id == $row->role_id) { ?>
                        <option value="<?php echo $row->role_id ?>" selected><?php echo $row->role_name ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $row->role_id ?>"><?php echo $row->role_name ?></option>
                    <?php } ?>
                <?php } ?>
            </select>

            <div class="clear"></div>
        </li>
    </ul>
<!-- commented by SKM17
    <script type="text/javascript">
        var rowTotal = <?php
                   if (!empty($user_role)) {
                       echo count($user_role);
                   } else {
                       echo 0;
                   }
                   ?>;
            
                       $(document).ready(function(){
                           $("#addLog").click(function(){
                               var rowCount = $('#addRoleUser').find('tr').size();
                               var tableClass = (rowCount%2==0)?'row-two':'row-one';
                               var logId = $('#role_id option:selected').val();
                               var logText = $('#role_id option:selected').text();
                               var logValue = $('#role_id').val();
                               if(logId!=''){
                                   if(isExist(logText)){
                                       alert('item role sudah ditambahkan, silahkan edit untuk mengubah nilai')
                                   }else {
                                       rowTotal = rowTotal + 1;
                                       $("#totalRow").val(rowTotal);
                                               
                                       var row1 = '<tr class='+tableClass+' id="logitem_'+logText+'"><td>'+rowCount+'</td>';
                                       var row2 = '<td>'+logText+'</td>';
                                       var row4 = '<input type="hidden" name="roleValue_'+rowTotal+'" id="roleValue_'+rowTotal+'" value="'+logValue+'" />';
                                       var action = '<td class="action"><a href="javascript:void(0);" <a href="javascript:void(0);" id="deleteLog" ><div class="tab-delete"></div></a></td></tr>';
                                               
                                       $("#addRoleUser").append(row1+row2+row4+action);
                                       $('#role_id').val('');
                                   }
                               }
                           });
    
                           $("#addRoleUser").on('click', '#deleteLog', function(){
                               $(this).parent().parent().remove();
                               rowTotal = rowTotal - 1;
                               $("#totalRow").val(rowTotal);
                           });
                               
                           $("#cancelLog").click(function(){
                               $('#role_id').val('');
                               $("#addLog").val('Tambah Role');
                           });
                               
                       });
            
                       function editRole(logId,logValue,editNumber){
                           $('#role_id').val(logId);
                           $('#editNumber').val(editNumber);
                           $("#role_id").attr('disabled',true);
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
    <br/>
    <p class="tit-form">Daftar Role</p>
    <table class="tab-admin" id="addRoleUser">

        <tr class="tittab">
            <td style="width: 30px;">No</th>                     
            <td>Role</td>

            <td style="width: 52px;">Actions</td>
        </tr>
        <?php if (!empty($user_role)) { ?>
            <?php
            $count = 1;
            if (!empty($user_role)) {
                foreach ($user_role as $row) {
                    ?>
                    <tr class="<?php echo alternator("row-one", "row-two"); ?>" id="logitem_<?php echo $row->role_name ?>">
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row->role_name; ?></td>
                    <input type="hidden" name="roleValue_<?php echo $count ?>" id="roleValue_<?php echo $count ?>" value="<?php echo $row->role_id ?>" />
                    <td class="action"> 
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
    <p class="tit-form">Entri Role Pengguna</p>
    <ul class="form-admin">
        <li>
            <label>Role * </label>
            <select id="role_id" name="role_id" class="form-admin">
                <option value="" selected>-Select User Role-</option>
                <?php foreach ($role as $row) { ?>
                    <option value="<?php echo $row->role_id ?>" selected><?php echo $row->role_name ?></option>
                <?php } ?>
            </select>
            <div class="clear"></div>
        </li>            
        <input type="hidden" value="" id="editNumber"/>
        <input type="hidden" value="<?php if (!empty($user_role)) echo count($user_role) ?>" id="totalRow" name="totalRow"/>
        <li>
            <label></label>
            <input class="button-form green" id="addLog" type="button" value="<?php if (empty($obj)) echo 'Simpan'; else echo 'Tambah Role'; ?>" >
            <input class="button-form red" id="cancelLog" type="button" value="Batal">
            <div class="clear"></div>
        </li>
	    <div class="clear"></div>
    </ul>
-->
    <p class="tit-form"></p>
    <ul class="form-admin">
        <li>
		    <label>&nbsp;</label>
			<input class="button-form" type="submit" value="Simpan">
	        <input class="button-form" type="reset" onclick="redirect('')" value="Batal">
	        <input class="button-form" type="button" onclick="redirect('?#form-pos')" value="Data Baru"/>
        </li>
	</ul>
</form>
<?php }?>
<div class="clear"></div>
</div>

