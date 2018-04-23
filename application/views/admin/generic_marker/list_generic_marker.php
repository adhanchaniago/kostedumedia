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
			window.location = '<?php echo base_url()?>admin/generic_marker_ctrl'
		});
	});
</script>
<?php }?>
<div id="spotting-holder" style="display: none;"></div>
<div id="backlight" style="display: none;"></div>

<div id="main">
    <p class="tit-form">Daftar Peta-peta <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a></p>
	<div class="filtering" style="display: none;">
        <form action="<?php echo current_url() ?>" method="post" id="form_search_filter">
            <ul class="filter-form">
                <li>
                    <label>Nama</label><br />
                    <input type="text" placeholder="Nama" name="gmark_name" class='filter_param' value="<?php echo $this->input->get('gmark_name'); ?>" onkeypress="search_enter_press(event);" />
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
				<td style="width: 20px;">No</td>						
				<td >ID</th>
				<td >Nama</th>
				<td >Lattitude</td>
				<td >Longitude</td>
				<td >Tipe</td>
				<td >Kategori</td>
				<td >Deskripsi</td>
				<td style="width: 52px;" class="delete">Actions</td>
			</tr>
		</thead>
		<tbody>
			<?php
				$count = 1;
				if(!empty($generic_marker)){
					foreach($generic_marker as $row) {?>
				<tr class="<?php echo alternator("row-two", "row-one"); ?>">
					<td><?php echo $count++;?></td>
					<td><?php echo $row->gmark_id;?></td>
					<td><?php echo $row->gmark_name;?></td>
					<td><?php echo $row->gmark_lat;?></td>
					<td><?php echo $row->gmark_lon;?></td>
					<td><?php echo $row->gmarktype_name;?></td>
					<td><?php echo $row->gmarkcat_name;?></td>
					<td><?php echo $row->gmark_desc;?></td>
					<td class="action">
						<?php if (is_has_access('generic_marker_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
						<a href="<?php echo base_url();?>admin/generic_marker_ctrl/edit/<?php echo $row->gmark_id?>"><div class="tab-edit"></div></a> 
						<?php } ?>
						<?php if (is_has_access('generic_marker_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
						<a href="<?php echo base_url();?>admin/generic_marker_ctrl/delete/<?php echo $row->gmark_id?>"><div class="tab-delete"></div></a>
						<?php } ?>
					</td>	
				</tr>
			<?php 		
					}
				}?>

		</tbody>
	</table>
	<br />
		<?php echo $pagination?>
    <br />
	<?php if (is_has_access('generic_marker_ctrl-edit', $permission) || is_has_access('*', $permission)) { ?>
	<p class="tit-form">Entri Data Peta</p>
	<form action="<?php echo base_url() ?>admin/generic_marker_ctrl/save" method="post" id="definedArea">
        <?php if (!empty($obj)) { ?>
            <input type="hidden" name="gmark_id" value="<?php if (!empty($obj)) echo $obj->gmark_id; ?>" />
        <?php } ?>
        <ul class="form-admin">
			<li>
                <label>Nama Peta:</label>
                <input name="gmark_name" type="text" class="form-admin"
                       value="<?php if (!empty($obj)) echo $obj->gmark_name; ?>" >
                <div class="clear"></div>
            </li>
            <li>
                <label>Deskripsi Peta:</label>
                <textarea rows="1" cols="1" name="gmark_desc" class="form-admin"><?php if (!empty($obj)) echo $obj->gmark_desc; ?></textarea>
                <div class="clear"></div>
            </li>
			<li>
                <label>Kategori Peta:</label>
                <select name="gmarkcat_id" class="form-admin" >
					<?php foreach($generic_marker_category as $gmarkcat){ ?>
						<option value="<?php echo $gmarkcat->gmarkcat_id?>" <?php echo (!empty($obj) && $obj->gmarkcat_id==$gmarkcat->gmarkcat_id)?'selected':'';?>><?php echo $gmarkcat->gmarkcat_name?></option>
					<?php } ?>
				</select>
                <div class="clear"></div>
            </li>
			<li>
                <label>Tipe Peta:</label>
				<?php if(empty($obj)){ ?>
                <select name="gmarktype_id" id="gmarktype_id" onchange="select_type(this.value)" class="form-admin" >
					<?php foreach($generic_marker_type as $gmarktype){ ?>
						<option value="<?php echo $gmarktype->gmarktype_id?>" <?php echo (!empty($obj) && $obj->gmarktype_id==$gmarktype->gmarktype_id)?'selected':'';?>><?php echo $gmarktype->gmarktype_name?></option>
					<?php } ?>
				</select>
				<?php }else{ ?>
				<input type="hidden" name="gmarktype_id" value="<?php if (!empty($obj)) echo $obj->gmarktype_id; ?>" />
				<select class="form-admin" disabled >
					<?php foreach($generic_marker_type as $gmarktype){ ?>
						<option value="<?php echo $gmarktype->gmarktype_id?>" <?php echo (!empty($obj) && $obj->gmarktype_id==$gmarktype->gmarktype_id)?'selected':'';?>><?php echo $gmarktype->gmarktype_name?></option>
					<?php } ?>
				</select>
				<?php } ?>
                <div class="clear"></div>
            </li>
			<li>
                <label>Map:</label>
                <div id="map" style="width: 800px; height: 600px"></div>
				<br />
				<?php if(empty($obj)){ ?>
				<input type="button" value="Bersihkan Polygon" onclick="clear_map()" class="button-form" style="margin-left:900px;">
				<?php } ?>
                <div class="clear"></div>
            </li>
        </ul>                     
        <ul class="form-admin">
            <li>
				<div id="bounds_area_input">
					<?php 
						if(!empty($obj)){ 
							foreach($obj->point as $point){
								echo '<input type="hidden" value="'.$point->gmarkarea_lat.'|'.$point->gmarkarea_lon.'" name="area_point[]" />';
							}
						}
					?>
				</div>
				<input type="hidden" name="gmark_lat" id="gmark_lat" value="<?php if (!empty($obj)) echo $obj->gmark_lat; ?>" />
				<input type="hidden" name="gmark_lon" id="gmark_lon" value="<?php if (!empty($obj)) echo $obj->gmark_lon; ?>" />
				<input type="hidden" name="gmark_radius" id="gmark_radius" value="<?php if (!empty($obj)) echo $obj->gmark_radius; ?>" />
				<input type="hidden" name="type_save" value="<?php (!empty($obj))?'edit':'add' ?>" />
                <input type="submit" value="<?php if (empty($obj)) echo 'Simpan'; else echo 'Ubah'; ?> " class="button-form">
                <input type="reset" value="Batalkan" class="button-form">
            </li>
        </ul>
    </form>
	<script type="text/javascript">
	var area_id = <?php echo (!(empty($obj)))?$obj->gmark_id:'false' ?>;
	var area_name = '<?php echo (!(empty($obj)))?$obj->gmark_name:'false' ?>';
	var area_type = <?php echo (!(empty($obj)))?$obj->gmarktype_id:'false' ?>;
	var area_bound = <?php echo (!(empty($obj)))?json_encode($obj->point):'false' ?>;
	var area_rad = <?php echo (!(empty($obj)) && $obj->gmark_radius!=null)?$obj->gmark_radius:'false' ?>;
	var area_lat = <?php echo (!(empty($obj)) && $obj->gmark_lat!=null)?$obj->gmark_lat:'false' ?>;
	var area_lon = <?php echo (!(empty($obj)) && $obj->gmark_lon!=null)?$obj->gmark_lon:'false' ?>;
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
	var bounds_area_input = $("#bounds_area_input");

    //fixation for pan inside bounds

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
	var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);
    var drawControl = new L.Control.Draw({
        draw: {
            position: 'topleft',
            polygon: {
                title: 'Membuat Area Polygon',
                allowIntersection: false,
                drawError: {
                    color: '#b00b00',
                    timeout: 1000
                },
                shapeOptions: {
                    color: '#bada55'
                }
            },
            polyline : false,
            rectangle : false
        },
        edit:false
    });
	var draw_polygon = new L.Draw.Polygon(map, drawControl.options.polygon);
	var draw_marker = new L.Draw.Marker(map, drawControl.options.marker);
	var draw_circle = new L.Draw.Circle(map, drawControl.options.circle);
	if(area_id==false){
		draw_marker.enable();
		draw_polygon.disable();
		draw_circle.disable();
	}
	map.on('draw:created', function (e) {
        var type = e.layerType,layer = e.layer;
        switch(type){
            case 'polygon' : console.log(layer);
				$.each(layer._latlngs,function(i,item){
					bounds_area_input.append('<input type="hidden" name="area_point[]" value="'+item.lat+'|'+item.lng+'" />');
				});
				$('#gmark_lat').val('');
				$('#gmark_lon').val('');
				$('#gmark_radius').val('');
                break;
            case 'circle' : console.log(layer);
				bounds_area_input.empty();
				$('#gmark_lat').val(layer._latlng.lat);
				$('#gmark_lon').val(layer._latlng.lng);
				$('#gmark_radius').val(layer._mRadius);
                break;
            case 'marker' : console.log(layer);
				bounds_area_input.empty();
				$('#gmark_lat').val(layer._latlng.lat);
				$('#gmark_lon').val(layer._latlng.lng);
				$('#gmark_radius').val('');
                break;
        
        }
        drawnItems.addLayer(layer);
		console.log(drawnItems);
    });
	
	// var polygon_area = [];
	if(area_id!=false){
		if(area_type==0){
			var marker = null;
			marker = new L.Marker([area_lat,area_lon]).bindLabel(area_name);
			map.addLayer(marker);
			marker.dragging.enable();
			marker.on('dragend',function(e){
				// console.log(e);
				$('#gmark_lat').val(e.target._latlng.lat);
				$('#gmark_lon').val(e.target._latlng.lng);
			});
		}else if(area_type==1){
			var circle = null;
			circle = new L.Circle([area_lat,area_lon],area_rad).bindLabel(area_name);
			map.addLayer(circle);
			circle.editing.enable();
			circle.on('edit',function(e){
				$('#gmark_lat').val(e.target._latlng.lat);
				$('#gmark_lon').val(e.target._latlng.lng);
				$('#gmark_radius').val(e.target._mRadius);
			});
		}else if(area_type==2){
			var temp_array_point = [];
			var polygon = null;
			$.each(area_bound,function(i,point){
				temp_array_point.push([parseFloat(point.gmarkarea_lat),parseFloat(point.gmarkarea_lon)]);
			});
			console.log(temp_array_point);
			polygon = new L.Polygon(temp_array_point,{color:"red",weight:2,fillOpacity:0.5}).bindLabel(area_name);
			map.addLayer(polygon);
			polygon.editing.enable();
			polygon.on('edit',function(e){
				console.log(e.target._latlngs);
				bounds_area_input.empty();
				$.each(e.target._latlngs,function(i,edit_point){
					bounds_area_input.append('<input type="hidden" name="area_point[]" value="'+edit_point.lat+'|'+edit_point.lng+'" />');
				});
			});
			temp_array_point = [];
		}
	}
	
	function select_type(val){
		$.each(drawnItems._layers,function(i,item){
			map.removeLayer(item);
		});
		console.log(val);
		switch(val){
			case '0' : 
				draw_marker.enable();
				draw_polygon.disable();
				draw_circle.disable();
			break;
			case '1' : 
				draw_marker.disable();
				draw_polygon.disable();
				draw_circle.enable();
			break;
			case '2' : 
				draw_marker.disable();
				draw_polygon.enable();
				draw_circle.disable();
			break;
		};
	} 
	function clear_map(){
		$('#gmark_lat').val('');
		$('#gmark_lon').val('');
		$('#gmark_radius').val('');
		bounds_area_input.empty();
		select_type($('#gmarktype_id').val());
	}
	</script>
	<?php  } ?>
</div>	
<div class="clear"></div>

