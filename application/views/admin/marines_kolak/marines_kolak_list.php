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
<?php if ($this->session->flashdata('info')) { ?>
    <script>
        $(document).ready(function(){
            alert('<?php echo $this->session->flashdata('info'); ?>');
        });
    </script>
<?php } ?>
<?php if(!empty($saving)){?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.success').fadeOut(5000,function(){
			$(this).remove();
		});
		$('#saveBtn').click(function (){
			var edit = $.trim($(this).prop('value')).toLowerCase();

			if( edit==='edit'){
				$(this).prop('value', 'Save');
				$('input[type=text]').prop('readonly',false);
				return false;
			}else{
				var form = $('input[type=submit]').closest("form");
				form.submit();
			}
		});

		$('#cancelBtn').click(function(){
			window.location = '<?php echo base_url()?>admin/cctv_location_ctrl'
		});
	});
</script>
<?php }?>
<div id="spotting-holder" style="display: none;"></div>
<div id="backlight" style="display: none;"></div>
<div id="main">
    <p class="tit-form">Daftar Komando Pelaksana</p>
	<table class="tab-admin">
        <thead>
            <tr class="tittab">
				<td style="width: 20px;">No</td>						
				<td >ID</td>
				<td >Deskripsi</td>
				<td >Pembina</td>
				<td style="width: 52px;" class="delete">Actions</td>
			</tr>
		</thead>
		<tbody>
			<?php
				$count = 1;
				if(!empty($marines_kolak)){
					foreach($marines_kolak as $row) {?>
					<tr class="<?php echo alternator("row-two", "row-one"); ?>">
						<td><?php echo ($count++)+$offset;?></td>
						<td><?php echo $row->kolak_id;?></td>
						<td><?php echo $row->kolak_description;?></td>
						<td><?php echo $row->corps_name;?></td>
						<td class="action"> 
							<?php if (is_has_access('marines_kolak_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
							<a href="<?php echo base_url();?>admin/marines_kolak_ctrl/edit/<?php echo $row->kolak_id?>"><div class="tab-edit"></div></a> 
							<?php } ?>
							<?php if (is_has_access('marines_kolak_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
							<a href="<?php echo base_url();?>admin/marines_kolak_ctrl/delete/<?php echo $row->kolak_id?>"><div class="tab-delete"></div></a>
							<?php } ?>
						</td>
					</tr>
			<?php 		}
				}?>
		</tbody>
	</table>	
	<br />
		<div class="pagination">
			<?php echo $pagination?>
		</div>
    <br />
	<?php if (is_has_access('marines_kolak_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
	<p class="tit-form">Entri Data Komando Pelaksana</p>
	<form action="<?php echo base_url() ?>admin/marines_kolak_ctrl/save" method="post" id="definedArea">
        <?php if (!empty($obj)) { ?>
            <input type="hidden" name="kolak_id" value="<?php if (!empty($obj)) echo $obj->kolak_id; ?>" />
        <?php } ?>
        <ul class="form-admin">
			<li>
                <label>Deskripsi:</label>
                <input name="kolak_description" type="text" class="form-admin"
                       value="<?php if (!empty($obj)) echo $obj->kolak_description; ?>" >
                <div class="clear"></div>
            </li>
			<li>
                <label>Pembina:</label>
                <select name="corps_id" class="form-admin">
					<?php 
						foreach($corps as $corp){
					?>
						<option value="<?php echo $corp->corps_id?>" <?php echo (!(empty($obj)) && $obj->corps_id==$corp->corps_id)?'selected':''?> ><?php echo $corp->corps_name?></option>
					<?php 
						}
					?>
                </select>
                <div class="clear"></div>
            </li>
        </ul>                     
        <ul class="form-admin">
            <li>
                <input type="submit" value="<?php if (empty($obj)) echo 'Simpan'; else echo 'Ubah'; ?> " class="button-form">
                <input type="reset" value="Batalkan" class="button-form">
            </li>
        </ul>
    </form>
	<?php } ?>
</div>
<div class="clear"></div>