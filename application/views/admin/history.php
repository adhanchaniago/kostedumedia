<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/util.js"> </script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/geo.js"></script>

<script>
	$(document).ready(function(){
		<?php if ($this->session->flashdata('info')) { ?>
			$('.success').html("<strong> <?php echo $this->session->flashdata('info'); ?>");
			$('.success').attr('style','');
			$('.success').delay(10000).fadeOut('slow');
		<?php } ?>

		$('.delete-tab').click(function(){
			var page = $(this).attr("href");
			var $dialog = $('<div title="Hapus Kosan"></div>')
			.html('Semua informasi kosan akan ikut dihapus! Hapus kosan? <div class="clear"></div>').dialog({
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

		var rowTotalKmr = <?php if ($obj) echo sizeof($obj['kamar']);
								else echo 0;
						?>

		$("#addKmr").click(function() {
			var namaKmr = $('#nama_kmr').val();
			var kmrFilled = $('#terisi_kmr').val();

			if ($('#editNumberKmr').val() != "") {
				var editNumberKmr = $('#editNumberKmr').val();
				$('#kmr_' + editNumberKmr + '').val(namaKmr);
				$('#kmr_td_' + editNumberKmr + '').text(namaKmr);
				$('#filledKmr_' + editNumberKmr + '').val(kmrFilled);
				$('#filledKmr_td_' + editNumberKmr + '').text(kmrFilled);
			} else {
				var rowCount = $('#tableKmr').find('tr').size();
				var tableClass = (rowCount % 2 == 0) ? 'row-two' : 'row-one';
				if (kmrFilled != '') {
					rowTotalKmr = rowTotalKmr + 1;
					$("#totalRowKmr").val(rowTotalKmr);

					var row1 = '<tr class=' + tableClass + '><td>' + rowCount + '</td>';
					var row2 = '<td id=kmr_td_' + rowTotalKmr + '>' + namaKmr + '</td>' + '<input type="hidden" name="kmr_' + rowTotalKmr + '" id="kmr_' + rowTotalKmr + '" value="' + namaKmr + '" />';
					var row3 = '<input type="hidden" name="kmr_' + rowTotalKmr + '" id="kmr_' + rowTotalKmr + '" value="' + namaKmr + '" />';
					var row4 = '<td id=filledKmr_td_' + rowTotalKmr + '>' + kmrFilled + '</td>' + '<input type="hidden" name="filledKmr_' + rowTotalKmr + '" id="filledKmr_' + rowTotalKmr + '" value="' + kmrFilled + '" />';
					var action = '<td class="action"><a href="javascript:void(0);" onClick="editKmr(\'' + rowTotalKmr + '\',\'' + namaKmr + '\',\'' + kmrFilled + '\')" id="editKmr" ><div class="tab-edit"></div></a> <a href="javascript:void(0);" id="deleteKmr"><div class="tab-delete"></div></a></td></tr>';

					$("#tableKmr").append(row1 + row2 + row3 + row4 + action);
					$('#nama_kmr').val('');
					$('#terisi_kmr').val('');
				}
			}
		});

		$("#tableKmr").on('click', '#deleteKmr', function() {
			$(this).parent().parent().remove();
			rowTotalKmr = rowTotalKmr - 1;
			$("#totalRowKmr").val(rowTotalKmr);
		});

		$("#cancelKmr").click(function() {
			$('#nama_kmr').val('');
			$('#terisi_kmr').val('');
			$("#addKmr").val('Tambah Kamar');
		});
	});

	function editKmr(noKmr, namaKmr, filledKmr) {
		$('#editNumberKmr').val(noKmr);
		$('#nama_kmr').val(namaKmr);
		$('#terisi_kmr').val(filledKmr);
		$("#addKmr").val('Ubah');
	}

	function isNumberKey(evt)
	{
		var charCode = (evt.which) ? evt.which : evt.keyCode
		if (!((charCode >= 48 && charCode <= 57) || (charCode == 46) || (charCode == 8) || (charCode == 9)))
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

	
	function redirect(){
		window.location = "<?php echo base_url() ?>admin/kost_ctrl";
	}



</script>

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
</style>
<!-- Added by D3 - Disable enter -->
<script type="text/javascript"> 
function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = stopRKey; 
</script> 
<!-- HISTORY HISTORY HISTORY HISTORY HISTORY HISTORY -->
<div id="spotting-holder" style="display: none;"></div>
<div id="backlight" style="display: none;"></div>

<div id="main">
	<div class="clear " id="notif-holder"></div>
	<p class="notif success " style="display:none"><strong>Input Sukses</strong>. Data POI berhasil disimpan.</p>
	
	<p class="tit-form">History Penghuni Kostan <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
	<div class="filtering" style="display: none;">
		<form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
			<ul class="filter-form">
				<li>
					<label>Filter POI</label><br />
					<input type="text" placeholder="Nama Area" name="poi_name" class='filter_param' value="<?php echo $this->input->get('poi_name'); ?>" onkeypress="search_enter_press(event);" />
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
				<td class="header" style="width: 20px;">No</th>                     
				<td class="header">Kost</td>
				<td class="header">Kamar</td>
				<td class="header">Tgl Masuk</td>
				<td class="header">Tgl Keluar</td>
				<td class="header">Nama</td>
				<td class="header">L/P</td>
				<td class="header">Agama</td>
				<td class="header">TTL</td>
				<td class="header">No Hp</td>
				<td class="header">Aktivitas</td>
				<td class="header">Harga</td>
				
				
<!-- 				<td class="header">Lokasi</td>
				<td class="header">Detail</td> -->
				<td class="header" style="width: 10px;">ket	</td>
			</tr>
		</thead>
		<tbody>
			<?php 
				$count=1;
				if(!empty($kosts)){
					foreach($kosts as $kosan) {
						$deskripsi = $kosan['properties']; ?>
						<tr class="<?php echo alternator("row-two", "row-one"); ?>">
							<td><?php echo ($count++); ?></td>
							<td><?php echo $deskripsi['judul'] ?></td>
							<!-- <td><?php echo $deskripsi['desc'] ?></td>							 -->
							<td>Kamar 1</td>
							<td>7 Juli 2015</td>
							<td>7 Juli 2016</td>
							<td>Fulan</td>
							<td>P</td>
							<td>Islam</td>
							<td>Bandung, 10-09-88</td>
							<td>08123345678</td>
							<td>Mahasiswi FPMIPA UPI P.Biologi</td>
							<td>6jt</td>
							<td class="action">
								<a href="<?php echo base_url();?>admin/kost_ctrl/edit/<?php echo $deskripsi['judul'] ?>"><div class="tab-view"></div></a>
								
							</td>
						</tr>
			<?php       }
				}?>

		</tbody>
	</table>
	<br />  
	
</div>
<div class="clear"></div>