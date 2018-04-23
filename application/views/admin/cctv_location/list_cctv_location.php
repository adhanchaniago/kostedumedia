<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.js"></script>
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
    <p class="tit-form">Daftar Lokasi CCTV</p>
	<table class="tab-admin">
        <thead>
            <tr class="tittab">
				<td style="width: 20px;">No</td>						
				<td >ID</td>
				<td >Nama</td>
				<td >Lintang</td>
				<td >Bujur</td>
				<td >Alamat (IP/DNS)</td>
				<td >Deskripsi</td>
				<td style="width: 52px;" class="delete">Actions</td>
			</tr>
		</thead>
		<tbody>
			<?php
				$count = 1;
				if(!empty($cctv_location)){
					foreach($cctv_location as $row) {?>
					<tr class="<?php echo alternator("row-two", "row-one"); ?>">
						<td><?php echo $count++;?></td>
						<td><?php echo $row->cctvloc_id;?></td>
						<td><?php echo $row->cctvloc_name;?></td>
						<td><?php echo $row->cctvloc_lat;?></td>
						<td><?php echo $row->cctvloc_lon;?></td>
						<td><?php echo $row->cctvloc_url;?></td>
						<td><?php echo $row->cctvloc_desc;?></td>
						<td class="action"> 
							<?php if (is_has_access('cctv_location_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
							<a href="<?php echo base_url();?>admin/cctv_location_ctrl/edit/<?php echo $row->cctvloc_id?>"><div class="tab-edit"></div></a> 
							<?php } ?>
							<?php if (is_has_access('cctv_location_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
							<a href="<?php echo base_url();?>admin/cctv_location_ctrl/delete/<?php echo $row->cctvloc_id?>"><div class="tab-delete"></div></a>
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
	<?php if (is_has_access('cctv_location_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
	<p class="tit-form">Entri Data Lokasi CCTV</p>
	<form action="<?php echo base_url() ?>admin/cctv_location_ctrl/save" method="post" id="definedArea">
        <?php if (!empty($obj)) { ?>
            <input type="hidden" name="cctvloc_id" value="<?php if (!empty($obj)) echo $obj->cctvloc_id; ?>" />
        <?php } ?>
        <ul class="form-admin">
			<li>
                <label>Nama Lokasi:</label>
                <input name="cctvloc_name" type="text" class="form-admin"
                       value="<?php if (!empty($obj)) echo $obj->cctvloc_name; ?>" >
                <div class="clear"></div>
            </li>
            <li>
                <label>Deskripsi:</label>
                <input name="cctvloc_desc" type="text" class="form-admin"
                       value="<?php if (!empty($obj)) echo $obj->cctvloc_desc; ?>" >
                <div class="clear"></div>
            </li>
			<li>
                <label>Alamat (IP/DNS):</label>
                <input name="cctvloc_url" type="text" class="form-admin"
                       value="<?php if (!empty($obj)) echo $obj->cctvloc_url; ?>" >
                <div class="clear"></div>
            </li>
			<li>
                <label>Nama Pengguna:</label>
                <input name="cctvloc_username" type="text" class="form-admin"
                       value="<?php if (!empty($obj)) echo $obj->cctvloc_username; ?>" >
                <div class="clear"></div>
            </li>
			<li>
                <label>Kata Sandi:</label>
                <input name="cctvloc_password" type="password" class="form-admin"
                       value="<?php if (!empty($obj)) echo $obj->cctvloc_password; ?>" >
                <div class="clear"></div>
            </li>
			<li>
                <label>Map:</label>
                <div id="map" style="width: 800px; height: 600px"></div>
				<br />
				<input type="button" value="Bersihkan Titik" onclick="clear_map()" class="button-form" style="margin-left:900px;">
                <div class="clear"></div>
            </li>
        </ul>                     
        <ul class="form-admin">
            <li>
				<input type="hidden" name="cctvloc_lat" id="cctvloc_lat" value="<?php if (!empty($obj)) echo $obj->cctvloc_lat; ?>" />
				<input type="hidden" name="cctvloc_lon" id="cctvloc_lon" value="<?php if (!empty($obj)) echo $obj->cctvloc_lon; ?>" />
                <input type="submit" value="<?php if (empty($obj)) echo 'Simpan'; else echo 'Ubah'; ?> " class="button-form">
                <input type="reset" value="Batalkan" class="button-form">
            </li>
        </ul>
    </form>
	<script type="text/javascript">
	var area_id = <?php echo (!(empty($obj)))?$obj->cctvloc_id:'false' ?>;
	var area_name = '<?php echo (!(empty($obj)))?$obj->cctvloc_name:'false' ?>';
	var area_lat = <?php echo (!(empty($obj)) && $obj->cctvloc_lat!=null)?$obj->cctvloc_lat:'false' ?>;
	var area_lon = <?php echo (!(empty($obj)) && $obj->cctvloc_lon!=null)?$obj->cctvloc_lon:'false' ?>;
	var configMap = {
		latCenter : -2.108899,
		lonCenter : 117.509766,
		zoom :6,
		mapUrl : '<?php echo $this->config->item('map_url') ?>',
		mapStyleId : 22677
	};
	var minimal   = L.tileLayer(configMap.mapUrl, {styleId: configMap.mapStyleId,continuousWorld: 'false'});
    var southWest = new L.LatLng(85, -180);
    var northEast = new L.LatLng(-85, 180);
    var bounds = new L.LatLngBounds(southWest, northEast);

    //fixation for pan inside bounds
	var point = null;
    L.Map.include({
    panInsideBounds: function(bounds) {
            bounds = L.latLngBounds(bounds);

            var viewBounds = this.getBounds(),
                viewSw = this.project(viewBounds.getSouthWest()),
                viewNe = this.project(viewBounds.getNorthEast()),
                sw = this.project(bounds.getSouthWest()),
                ne = this.project(bounds.getNorthEast()),
                dx = 0,
                dy = 0;

            if (viewNe.y < ne.y) { // north
                dy = ne.y - viewNe.y + Math.max(0, this.latLngToContainerPoint([85.05112878, 0]).y); // + extra vertical scroll
            }
            if (viewNe.x > ne.x) { // east
                dx = ne.x - viewNe.x;
            }
            if (viewSw.y > sw.y) { // south
                dy = sw.y - viewSw.y + Math.min(0, this.latLngToContainerPoint([-85.05112878, 0]).y - this.getSize().y); // + extra vertical scroll
            }
            if (viewSw.x < sw.x) { // west
                dx = sw.x - viewSw.x;
            }

            return this.panBy(new L.Point(dx, dy, true));
        }
    });
	
    //fixation for pan inside bounds
    var map = new L.map('map', {
        center: [configMap.latCenter, configMap.lonCenter],
        zoom: configMap.zoom,
        maxBounds : bounds,
        layers: [minimal],
        maxZoom : 15,
        minZoom : 3
    });
	if(area_id!=false){
		point = new L.Marker([area_lat,area_lon]).bindLabel('lat : '+area_lat+' || lon : '+area_lon);
		map.addLayer(point);
	}
	map.on('click',function(e){
		if(point!=null){
			this.removeLayer(point);
			point=null;
		}
		point = new L.Marker([e.latlng.lat,e.latlng.lng]).bindLabel('lat : '+e.latlng.lat+' || lon : '+e.latlng.lng);
		this.addLayer(point);
		$('#cctvloc_lat').val(e.latlng.lat);
		$('#cctvloc_lon').val(e.latlng.lng);
	});
	
	function clear_map(){
		if(point!=null){
			map.removeLayer(point);
			point=null;
			$('#cctvloc_lat').val('');
			$('#cctvloc_lon').val('');
		}
	}
	</script>
	<?php } ?>
</div>
<div class="clear"></div>
