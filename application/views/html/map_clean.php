<html>

<!-- include another html page -->
<script>
var dataKosan = null;
<?php  // susun data dari database menjadi data dg format puskesmas.json
echo 'dataKosan = {"type":"FeatureCollection","features":['; // bukaan pertama

// mulai iterasi data, dikelompokkan per rumah
$curIdKosan = -1;
foreach($kosans as $data) {
	if ($curIdKosan < 0) { // masih yg pertama
		$curIdKosan = $data->id_kosan;
		echo '{"type":"Feature",';
		echo '"geometry":{"type":"Point","coordinates":[' . $data->lon . ',' . $data->lat . ']},';
		echo '"properties": {';
		echo '"judul":"' . $data->nama_kosan . '",';
		echo '"jenis":"marker",';
		echo '"desc":"' . $data->alamat . '",';
		echo '"fasum":"' . $data->fasum . '",';
		echo '"foto":"' . $data->foto_kosan . '",';
		echo '"kontak":"' . $data->kontak . '",';
		echo '"lokasi":"' . $data->lokasi . '",';
		echo '"kamarmandi":"' . $data->kamarmandi . '",';
		echo '"desclok":"' . $data->deskripsilokasi . '",';
		echo '"kamar":[';

		if ($data->id_kamar != NULL) { 
			echo '{"nama" : "' . $data->nama_kamar . '",';
			echo '"luas":"' . $data->luas . 'm<sup>2</sup>",';
			echo '"fasilitas":"' . $data->fasilitas . '",';
			echo '"hargath":"' . $data->hargath . '",';
			echo '"terisi":"' . ($data->id_penghuni > 0 ? 'terisi' : 'kosong') . '",';
			echo '"penghuninama":"' . $data->nama_penghuni . '",';
			echo '"penghunihp":"' . $data->hp . '",';
			echo '"penghunihpdarurat":"' . $data->hpdarurat . '",';
			echo '"penghunifoto":"' . $data->foto . '",';
			echo '"penghunialamat":"' . $data->alamat . '",';
			echo '"penghuninoktp":"' . $data->no_ktp . '",';
			echo '"tglmasuk":"' . $data->tglmasuk . '",';
			echo '"tglkeluar":"' . $data->tglkeluar . '",';
			echo '"penghunifotoktp":"' . $data->fotoktp . '",';
			echo '"penghunifotoktm":"' . $data->fotoktm . '",';
			echo '"penghunilatar":"' . $data->lb . '"}';
		}
	} else {
		if ($data->id_kosan == $curIdKosan) { // rumah data selanjutnya = rumah data sebelumnya
			// lanjut data penghuni rumah
			echo ','; // tambahin koma penutup utk penghuni sebelumnya
				echo '{"nama" : "' . $data->nama_kamar . '",';
				echo '"luas":"' . $data->luas . 'm<sup>2</sup>",';
				echo '"fasilitas":"' . $data->fasilitas . '",';
				echo '"hargath":"' . $data->hargath . '",';
				echo '"terisi":"' . ($data->id_penghuni > 0 ? 'terisi' : 'kosong') . '",';
				echo '"penghuninama":"' . $data->nama_penghuni . '",';
				echo '"penghunihp":"' . $data->hp . '",';
				echo '"penghunihpdarurat":"' . $data->hpdarurat . '",';
				echo '"penghunifoto":"' . $data->foto . '",';
				echo '"penghunialamat":"' . $data->alamat . '",';
				echo '"penghuninoktp":"' . $data->no_ktp . '",';
				echo '"tglmasuk":"' . $data->tglmasuk . '",';
				echo '"tglkeluar":"' . $data->tglkeluar . '",';
				echo '"penghunifotoktp":"' . $data->fotoktp . '",';
				echo '"penghunifotoktm":"' . $data->fotoktm . '",';
				echo '"penghunilatar":"' . $data->lb . '"}';
		}
		else { // ganti rumah, bikin data rumah baru
			echo ']}'; // tutup dulu data penghuni sebelumnya & properties
			echo '},';	 // tutup Feature

			// isian rumah selanjutnya
			echo '{"type":"Feature",';
			echo '"geometry":{"type":"Point","coordinates":[' . $data->lon . ',' . $data->lat . ']},';
			echo '"properties": {';
			echo '"judul":"' . $data->nama_kosan . '",';
			echo '"jenis":"marker",';
			echo '"desc":"' . $data->alamat . '",';
			echo '"fasum":"' . $data->fasum . '",';
			echo '"foto":"' . $data->foto_kosan . '",';
			echo '"kontak":"' . $data->kontak . '",';
			echo '"lokasi":"' . $data->lokasi . '",';
			echo '"kamarmandi":"' . $data->kamarmandi . '",';
			echo '"desclok":"' . $data->deskripsilokasi . '",';
			echo '"kamar":[';

			if ($data->id_kamar != NULL) { 
				echo '{"nama" : "' . $data->nama_kamar . '",';
				echo '"luas":"' . $data->luas . 'm<sup>2</sup>",';
				echo '"fasilitas":"' . $data->fasilitas . '",';
				echo '"hargath":"' . $data->hargath . '",';
				echo '"terisi":"' . ($data->id_penghuni > 0 ? 'terisi' : 'kosong') . '",';
				echo '"penghuninama":"' . $data->nama_penghuni . '",';
				echo '"penghunihp":"' . $data->hp . '",';
				echo '"penghunihpdarurat":"' . $data->hpdarurat . '",';
				echo '"penghunifoto":"' . $data->foto . '",';
				echo '"penghunialamat":"' . $data->alamat . '",';
				echo '"penghuninoktp":"' . $data->no_ktp . '",';
				echo '"tglmasuk":"' . $data->tglmasuk . '",';
				echo '"tglkeluar":"' . $data->tglkeluar . '",';
				echo '"penghunifotoktp":"' . $data->fotoktp . '",';
				echo '"penghunifotoktm":"' . $data->fotoktm . '",';
				echo '"penghunilatar":"' . $data->lb . '"}';
			}
		}
		$curIdKosan = $data->id_kosan;
	}
}

echo ']}}'; // kurawal penutup array penghuni & kurawal rumah
echo ']};'; // kurawal penutup akhir
?>

var LOGINSTAT = false;
function includeHTML() {
	var z, i, elmnt, file, xhttp;
	/*loop through a collection of all HTML elements:*/
	z = document.getElementsByTagName("*");
	for (i = 0; i < z.length; i++) {
		elmnt = z[i];
		/*search for elements with a certain atrribute:*/
		file = elmnt.getAttribute("w3-include-html");
		if (file) {
			/*make an HTTP request using the attribute value as the file name:*/
			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4) {
					if (this.status == 200) {elmnt.innerHTML = this.responseText;}
					if (this.status == 404) {elmnt.innerHTML = "Page not found.";}
					/*remove the attribute, and call this function once more:*/
					elmnt.removeAttribute("w3-include-html");
					includeHTML();
				}
			}      
			xhttp.open("GET", file, true);
			xhttp.send();
			/*exit the function:*/
			return;
		}
	}
};
</script>
<!-- include another html page,, cara makenya: -->
<!-- <div w3-include-html="h1.html"></div>  -->

<head>
	<style>
			@font-face { font-family: sshh; src: url('../aset/fonts/sshh.ttf'); } 
			h1 {font-family: sshh}
	</style>
	<meta charset=utf-8 />
	<title>Kost Putri EDUMEDIA</title>
	<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />

<!-- klo ngambil dari luar -->
	<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet-src.js"></script>
	<script src="https://unpkg.com/esri-leaflet@2.0.6"></script>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->

	<!-- bootstrap dan font awesome -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->
	<link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>favicon.ico">
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/font-awesome.min.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/bootleaf/leaflet.groupedlayercontrol.css" />
	<!-- <link rel="stylesheet" href="<?php echo base_url() ?>aset/bootleaf/L.Control.Locate.css" /> -->

	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/ResilientMaps.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/bootleaf/app.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/leaflet102/leaflet.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/MarkerCluster.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/MarkerCluster.Default.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/L.Control.BetterScale.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/leafletdraw/leaflet.draw.css"/>
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/leaflet-search.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/leaflet-measure-path.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/wind-js-leaflet.css" />
	<link href="<?php echo base_url() ?>vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

</head>

<body>
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header" style="vertical-align:middle;"">
				<!-- <img class="pull-left" style="width:41px;height:41px;margin-top:5px;z-index:999;" src="<?php echo base_url() ?>aset/img/1.png"> -->
				<img class="pull-left" style="vertical-align:middle; width:30px;height:30px;margin-top:5px;z-index:999;" src="<?php echo base_url() ?>aset/img/1.png">
				<!-- <a class="navbar-brand" style="font-family:sshh;font-size:30;font-weight: normal;margin-top:0px;" href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="sidebar-legend-btn">&nbsp;Kost Putri EDUMEDIA</a> -->
				<a class="navbar-brand" style="vertical-align:middle; font-family:sshh;font-size:20;font-weight: normal;margin-top:0px;" href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="sidebar-legend-btn">&nbsp;Kost Putri EDUMEDIA&nbsp;</a>
				<ul class="nav navbar-nav pull-center">
					<li class="btn-group btn-group-sm" style="vertical-align:middle; margin-top:10px;" role="group">
						<button type="button" class="btn btn-success" id="peta"><i class="fa fa-map"></i>  Peta</button>
						<button type="button" class="btn btn-primary" id="tabel"><i class="fa fa-table"></i>  Tabel</button>
						<button type="button" class="btn btn-warning" id="about"><i class="fa fa-info-circle"></i> About</button>
					</li>
					<li class="hidden-xs"><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="sidebar-form-btn"><i class="fa fa-pencil "></i>&nbsp;&nbsp;ketersediaan kamar</a></li>
				</ul>
			</div>
			<ul class="pull-right">
				<i style="vertical-align:middle; font-family:'Arial'; color:white;  font-size:15; font-weight:normal; margin-top:8px">Welcome <?php if ($username) echo $username ?>&nbsp;</i>
				<li class="btn-group btn-group-sm" style="vertical-align:middle; margin-top:10px;" role="group">
					
<?php if ($permission) { ?>
					<button type="button" class="btn btn-info" id="backend"><i class="fa fa-gears"></i>  Halaman Admin</button>
					<button type="button" class="btn btn-danger" id="logout" onclick="location.href='';"><i class="fa fa-sign-out"></i>  Logout</button>
<?php } else { ?>       
					<button type="button" class="btn btn-info" id="login"><i class="fa fa-gears"></i>  Login</button>
<?php } ?> 
				</li>
			</ul>
				
			<!-- </div> /.navbar-collapse  -->
		</div>
	</div>

	<!-- <div id="atasbar">
			<div id="logonoah"><img src="<?php echo base_url() ?>aset/img/logo atas.png"></div>
			<div style="font-size:24;"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TPAS </b>
				<l style="font-size:13;">- Theatre Planning Analysis System</l>
						<button type="button" class="btn btn-xs btn-default pull-right" id="sidebar-hide-btn">KANAN</button>
						<button type="button" class="btn btn-xs btn-default pull-right" id="sidebar-hide-btn">KIRI</button>      
			</div>
	</div>  -->
	
	<!-- <div id="infokiri">sdgdfgdfgdfg</div> -->
	<!-- <div id="infokanan"></div> -->
	

	<div id="container">
		<div id="sidebar">
			<div class="sidebar-wrapper">
				<!-- <div class="panel panel-default" style="max-height: 100%; overflow-y: scroll; overflow-x: hidden;" id="features"> -->
				<div class="panel panel-default" style="max-height: 100%; " id="features">
					
					<!-- <div class="panel-heading">
						<h3 class="panel-title">Legend Draw Map
						<button type="button" class="btn btn-xs btn-default pull-right" id="tutupS"><i class="fa fa-chevron-left"></i></button></h3>
					</div>

					<div class="panel-body">
						<div class="row">
							<div class="col-xs-8 col-md-8">
								<input type="text" class="form-control search" placeholder="Filter" />
							</div>
							<div class="col-xs-4 col-md-4">
								<button type="button" class="btn btn-primary pull-right sort" data-sort="feature-name" id="download-btn"><i class="fa fa-download"></i>&nbsp;&nbsp;Download All</button>
							</div>
						</div>
					</div> -->
					
					<div class="sidebar-table">
						<table class="table table-hover table-striped table-condensed" id="feature-list" style="font-size:12px;" >
							<!-- <thead class="hidden"> -->
							<thead>
								<tr>
									<th>Jenis</th>
									<th>Judul</th>
									<th>Deskripsi</th>
								<tr>
							</thead>
							<tbody class="list">
							 <!--  <tr>
									<td><img src="<?php echo base_url() ?>aset/img/lingkaran.png" width="20" height="20"></td>
									<td>kawasan bajak laut</td>
								</tr>
								<tr>
									<td><img src="<?php echo base_url() ?>aset/img/marker.png" width="20" height="20"></td>
									<td>kawasan bajak laut</td>
								</tr>
								<tr>
									<td><img src="<?php echo base_url() ?>aset/img/markerbulat.png" width="20" height="20"></td>
									<td>kawasan bajak laut</td>
								</tr><tr>
									<td><img src="<?php echo base_url() ?>aset/img/polyline.png" width="20" height="20"></td>
									<td>kawasan bajak laut</td>
								</tr>
								<tr>
									<td><img src="<?php echo base_url() ?>aset/img/polygon.png" width="20" height="20"></td>
									<td>kawasan bajak laut</td>
								</tr>
								<tr>
									<td><img src="<?php echo base_url() ?>aset/img/kotak.png" width="20" height="20"></td>
									<td>kawasan bajak laut</td>
								</tr> -->
							</tbody>
						</table>
					</div>
				
				</div>
			</div>
		</div>

		<div id="rightbar" style="max-height: 100%; max-width: 100%; overflow-y: scroll; ">
	      <div class="rightbar-wrapper">
	        <!-- <div class="panel panel-default" style="max-height: 100%; overflow-y: scroll; overflow-x: hidden;" id="features"> -->
	        <div class="panel panel-default"  id="features">
      		  <div class="right-panel-body">
			  	<div class="row">
					<div class="col-xs-12 col-md-12">
						<!-- <input type="text" class="form-control search" id="myinput" onkeyup="ngefilter()" placeholder="cari nama / alamat" /> -->
						<div id="piechart"></div>
						<canvas id="myChart" width="515" height="200"></canvas>

					</div>
					<div class="rightbar-table" style="overflow-x: hidden;">
		              <table class="table table-hover table-striped table-condensed" id="dataTables-example" style="font-size:12px;">
		                <thead>
							<tr>
								<th>Kosan</th>
								<th>Kamar</th>
								<th>Luas</th>
								<th>Harga</th>
								<th>Terisi</th>
							</tr>
						</thead>
		                <tbody class="list">
<?php 
	if(!empty($kosans)){
		foreach($kosans as $datakamar) {
?>
								<tr class="<?php echo alternator("even", "odd"); ?>">
									<td><?php echo $datakamar->nama_kosan ?></td>
									<td><?php echo $datakamar->nama_kamar ?></td>
									<td><?php echo $datakamar->luas ?></td>
									<td><?php echo $datakamar->hargath ?></td>
									<td><?php echo ($datakamar->id_penghuni > 0 ? 'terisi' : 'kosong') ?></td>
								</tr>
<?php
		}
	}
?>
		                </tbody>
		              </table>
		            </div>
				</div>
			  </div>

	          <!-- <div class="right-panel-body" id="tabellaporan" > -->
	            <!-- <div class="rightbar-table">
	              <table class="table table-hover table-striped table-condensed" id="tabellap" style="font-size:12px;">
	                <thead>
	                  <tr>
	                    <th>Nama</th>
	                    <th>Alamat</th>
	                    <th>Gender</th>
	                    <th>TTL</th>
	                    <th>Keterangan Penyakit</th>
	                  <tr>
	                </thead>
	                <tbody class="list">
	                  
	                </tbody>
	              </table>
	            </div> -->

	          <!-- </div> --> <!-- right panel body -->
	        
	        </div>
	      </div>
	    </div>

		
		<div id="map"></div>

		<!-- Modal content -->
		<!-- <div id="modalcoba" class="modal">
			<div class="modal-content">
				<span class="close">&times;</span>
				<p>Some text in the Modal..</p>
			</div>
		</div> -->
					<div class="modal fade" id="modalcoba" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Detail Kamar</h4>
								</div>
								<div id="modalcobabody" class="modal-body">
									<!-- EMPTY -->
								</div>
							</div>
						</div>
					</div>


					<!-- MODAL GALERY -->
					<div class="modal fade" id="modalgalery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<!-- <div class="modal-dialog modal-lg" role="document"> -->
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">GALERY</h4>
								</div>
								<div class="modal-body" style="text-align: center;">
									
									<a id="goleft" style="position:absolute; left:10px;" class="fa fa-chevron-left"></a>
									<div style="position:absolute; left:50%;" id="modalgaleryinfo"> </div>
									<a id="goright" style="position:absolute; right:10px;" class="fa fa-chevron-right"></a><br>
									<img id="modalgaleryviewer" src="" width="100%" />
								</div>
							</div>
						</div>
					</div>
	</div>

	<!-- <div id="map"></div>    -->
	<!-- <div id="logoresilient" > -->
		<!-- <img src="<?php echo base_url() ?>aset/img/logosk.png"> -->
	<!-- </div> -->




	<!-- leaflet -->
	<script src="<?php echo base_url() ?>aset/leaflet102/leaflet-src.js"></script>
	<script src="<?php echo base_url() ?>aset/leaflet.rotatedMarker.js"></script>
	<script src="<?php echo base_url() ?>aset/esri-leaflet-2.0.6.js"></script>
	<script src="<?php echo base_url() ?>aset/esri-leaflet-cluster-debug.js"></script>
	<script src="<?php echo base_url() ?>aset/jQuery-v3.1.1.js"></script>

	<!-- leaflet search -->
	<script src="<?php echo base_url() ?>aset/leaflet-search.js"></script>

	<!-- leaflet grouplayer -->
	<script src="<?php echo base_url() ?>aset/bootleaf/leaflet.groupedlayercontrol.js"></script>

	<!-- wind -->
	<script src="<?php echo base_url() ?>aset/wind-js-leaflet.js"></script>

	<!-- leaflet control locate -->
	<!-- <script src="<?php echo base_url() ?>aset/bootleaf/L.Control.Locate.min.js"></script> -->

	<!-- marker cluster -->
	<script src="<?php echo base_url() ?>aset/MarkerCluster.js"></script>
	<script src="<?php echo base_url() ?>aset/DistanceGrid.js"></script>
	<script src="<?php echo base_url() ?>aset/MarkerClusterGroup.js"></script>
	<script src="<?php echo base_url() ?>aset/MarkerOpacity.js"></script>
	<script src="<?php echo base_url() ?>aset/MarkerClusterGroup.Refresh.js"></script>
	<script src="<?php echo base_url() ?>aset/MarkerCluster.Spiderfier.js"></script>
	<script src="<?php echo base_url() ?>aset/MarkerCluster.QuickHull.js"></script>

	<!-- scale -->
	<script src="<?php echo base_url() ?>aset/leaflet.nauticscale.js"></script>
	<script src="<?php echo base_url() ?>aset/L.Control.BetterScale.js"></script>

	<!-- measurement -->
	<script src="<?php echo base_url() ?>aset/leaflet-measure-path.js"></script>
	
	<!-- draw -->
	<script src="<?php echo base_url() ?>aset/leafletdraw/Leaflet.draw.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/Leaflet.Draw.Event.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/Toolbar.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/Tooltip.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/ext/GeometryUtil.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/ext/LatLngUtil.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/ext/LineUtil.Intersect.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/ext/Polygon.Intersect.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/ext/Polyline.Intersect.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/ext/TouchEvents.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/DrawToolbar.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.Feature.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.SimpleShape.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.Polyline.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.Circle.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.Marker.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.MarkerMerah.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.MarkerBulat.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.MarkerBiru.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.MarkerAbu.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.MarkerHijau.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.MarkerUngu.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.Polygon.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/draw/handler/Draw.Rectangle.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/edit/EditToolbar.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/edit/handler/EditToolbar.Edit.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/edit/handler/EditToolbar.Delete.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/Control.Draw.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/edit/handler/Edit.Poly.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/edit/handler/Edit.SimpleShape.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/edit/handler/Edit.Circle.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/edit/handler/Edit.Rectangle.js"></script>
	<script src="<?php echo base_url() ?>aset/leafletdraw/edit/handler/Edit.Marker.js"></script>

	<!-- button menu -->
	<!-- <script src="<?php echo base_url() ?>aset/easy-button.js"></script> -->
	<!-- <link rel="stylesheet" href="<?php echo base_url() ?>aset/easy-button.css" /> -->
	<script src="<?php echo base_url() ?>aset/Leaflet.Control.Custom.js"></script>
	
	<!-- ESRI -->
	<!-- <script src="https://unpkg.com/esri-leaflet-vector@1.0.5"></script> -->
	<!-- <script src="https://unpkg.com/esri-leaflet-cluster@2.0.0"></script> -->

	<!-- piechart -->
	<script src="<?php echo base_url() ?>aset/chartjs/Chart.bundle.js"></script>
	<script src="<?php echo base_url() ?>aset/chartjs/Chart.bundle.min.js"></script>

	<!-- bootstrap -->
	<script src="<?php echo base_url() ?>aset/bootstrap.min.js"></script>

	<!-- JSONjs -->
	<script src="<?php echo base_url() ?>aset/JSONjs/json2.js"></script>

	<!-- DataTables JavaScript -->
	<script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
	<script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>


	<!-- MAP ASLI -->
	<script src="<?php echo base_url() ?>aset/ResilientMaps.js"></script>
	<script>
	// $(document).ready(function() {
	// 	$('#dataTables-example').DataTable({
	// 		responsive: true,
	// 		"lengthMenu": [[25, 50, 100], [25, 50, 100]]
	// 	});
	// });

	$(document).ready(function() {
	    $('#dataTables-example').DataTable( {
	        "paging":   false,
	        "searching":   false,
	        "ordering": true,
	        "info":     false
	    } );
	} );

	
<?php if ($permission) { ?>
	function modalkamar(i,ii){
		// console.log("bikin append");
		// console.log(KOSANS);
		$("#modalcobabody").empty();
		
		$("#modalcobabody").append(
			'<ul class="nav nav-tabs" role="tablist">'+
				'<li role="presentation" class="active"><a href="#ketdetail" aria-controls="ketdetail" role="tab" data-toggle="tab">Keterangan</a></li>'+
				'<li role="presentation"><a onclick="gambarkamar('+i+','+ii+')" href="#ketgalery" aria-controls="ketgalery" role="tab" data-toggle="tab">Galery</a></li>'+
				'<li role="presentation"><a href="#ketpenghuni" aria-controls="ketpenghuni" role="tab" data-toggle="tab">Penghuni (khusus admin)</a></li>'+
			'</ul>'+
			'<div class="tab-content">'+
				'<div role="tabpanel" class="tab-pane active" id="ketdetail">'+
					'<table class="table table-hover table-striped table-condensed" style="font-size:12px;" >'+
						'<tbody class="list">'+
							'<tr><td>Nama :</td>                  <td>'+KOSANS[i].properties.kamar[ii].nama+'</td></tr>'+ 
							'<tr><td>Luas :</td>                  <td>'+KOSANS[i].properties.kamar[ii].luas+'</td></tr>'+
							'<tr><td>Fasilitas :</td>             <td>'+KOSANS[i].properties.kamar[ii].fasilitas+'</td></tr>'+
							'<tr><td>Harga /thn :</td>            <td>'+KOSANS[i].properties.kamar[ii].hargath+'</td></tr>'+
							'<tr><td>Terisi :</td>                <td>'+KOSANS[i].properties.kamar[ii].terisi+'</td></tr>'+
						'</tbody>'+
					'</table>'+
				'</div>'+
				'<div role="tabpanel" style="text-align: center;" class="tab-pane" id="ketgalery">'+
					'<a id="gileft" style="position:absolute; left:10px;" class="fa fa-chevron-left"></a>'+
					'<div style="position:absolute; left:50%;" id="modalkamarinfo"> </div>'+
					'<a id="giright" style="position:absolute; right:10px;" class="fa fa-chevron-right"></a><br>'+
					'<img id="modalkamarviewer" src="" width="80%" />'+
				'</div>'+
				'<div role="tabpanel" class="tab-pane" id="ketpenghuni">'+
					'<table class="table table-hover table-striped table-condensed" style="font-size:12px;" >'+
						'<tbody class="list">'+
							'<tr><td>Foto :</td>             <td>'+KOSANS[i].properties.kamar[ii].penghunifoto+'</td></tr>'+
							'<tr><td>Nama Penghuni :</td>     <td>'+KOSANS[i].properties.kamar[ii].penghuninama+'</td></tr>'+ 
							'<tr><td>No HP :</td>            <td>'+KOSANS[i].properties.kamar[ii].penghunihp+'</td></tr>'+
							'<tr><td>No HP darurat :</td>    <td>'+KOSANS[i].properties.kamar[ii].penghunihpdarurat+'</td></tr>'+
							'<tr><td>Alamat :</td>           <td>'+KOSANS[i].properties.kamar[ii].penghunialamat+'</td></tr>'+
							'<tr><td>No KTP :</td>           <td>'+KOSANS[i].properties.kamar[ii].penghuninoktp+'</td></tr>'+
							'<tr><td>Foto KTP :</td>         <td><a>'+KOSANS[i].properties.kamar[ii].penghunifotoktp+'</a></td></tr>'+
							'<tr><td>Foto KTM :</td>         <td><a>'+KOSANS[i].properties.kamar[ii].penghunifotoktm+'</a></td></tr>'+
							'<tr><td>Latar Belakang :</td>   <td>'+KOSANS[i].properties.kamar[ii].penghunilatar+' </td></tr>'+
							'<tr><td>Tgl Masuk :</td>        <td>'+KOSANS[i].properties.kamar[ii].tglmasuk+'</td></tr>'+
							'<tr><td>Tgl Keluar :</td>       <td>'+KOSANS[i].properties.kamar[ii].tglkeluar+'</td></tr>'+
							'<tr><td>Pembayaran :</td>       <td>'+KOSANS[i].properties.kamar[ii].pmbayaran+'</td></tr>'+
							'<tr><td>Sisa Pembayaran :</td>  <td>'+KOSANS[i].properties.kamar[ii].sisapmbayaran+' </td></tr>'+
						'</tbody>'+
					'</table>'+
				'</div>'+
			'</div>');
		
		syncSidebar();
	}
<?php } else { ?>
	function modalkamar(i,ii){
		// console.log("bikin append");
		// console.log(KOSANS);
		$("#modalcobabody").empty();
		
		$("#modalcobabody").append(
			'<ul class="nav nav-tabs" role="tablist">'+
				'<li role="presentation" class="active"><a href="#ketdetail" aria-controls="ketdetail" role="tab" data-toggle="tab">Keterangan</a></li>'+
				'<li role="presentation"><a onclick="gambarkamar('+i+','+ii+')" href="#ketgalery" aria-controls="ketgalery" role="tab" data-toggle="tab">Galery</a></li>'+
			'</ul>'+
			'<div class="tab-content">'+
				'<div role="tabpanel" class="tab-pane active" id="ketdetail">'+
					'<table class="table table-hover table-striped table-condensed" style="font-size:12px;" >'+
						'<tbody class="list">'+
							'<tr><td>Nama :</td>                  <td>'+KOSANS[i].properties.kamar[ii].nama+'</td></tr>'+ 
							'<tr><td>Luas :</td>                  <td>'+KOSANS[i].properties.kamar[ii].luas+'</td></tr>'+
							'<tr><td>Fasilitas :</td>             <td>'+KOSANS[i].properties.kamar[ii].fasilitas+'</td></tr>'+
							'<tr><td>Harga /thn :</td>            <td>'+KOSANS[i].properties.kamar[ii].hargath+'</td></tr>'+
							'<tr><td>Terisi :</td>                <td>'+KOSANS[i].properties.kamar[ii].terisi+'</td></tr>'+
						'</tbody>'+
					'</table>'+
				'</div>'+
				'<div role="tabpanel" style="text-align: center;" class="tab-pane" id="ketgalery">'+
					'<a id="gileft" style="position:absolute; left:10px;" class="fa fa-chevron-left"></a>'+
					'<div style="position:absolute; left:50%;" id="modalkamarinfo"> </div>'+
					'<a id="giright" style="position:absolute; right:10px;" class="fa fa-chevron-right"></a><br>'+
					'<img id="modalkamarviewer" src="" width="80%" />'+
				'</div>'+
			'</div>');
		
		syncSidebar();
	}
<?php } ?>
	</script>
</body>
</html>
