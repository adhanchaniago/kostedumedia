<html>

<!-- include another html page -->
<!-- include another html page,, cara makenya: -->
<!-- <div w3-include-html="h1.html"></div>  -->

<head>
	<style>
			html, body, #container {
			  height: 100%;
			  width: 100%;
			  overflow-x: hidden;
			  overflow-y: auto;
			  padding-top: 50px;
			}
			body {
			  padding-top: 50px;
			}
			input[type="radio"], input[type="checkbox"] {
			  margin: 0;
			}

			td.details-control {
			    background: url('<?php echo base_url() ?>assets/html/img/icon/pl.png') no-repeat center center;
			    cursor: pointer;
			}
			tr.shown td.details-control {
			    background: url('<?php echo base_url() ?>assets/html/img/icon/mn.png') no-repeat center center;
			}

			@font-face { font-family: sshh; src: url('../aset/fonts/sshh.ttf'); } 
			h1 {font-family: sshh}

	</style>
	<meta charset=utf-8 />
	<title>Kost Putri EDUMEDIA</title>
	<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />

	<!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url() ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url() ?>vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="<?php echo base_url() ?>vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo base_url() ?>vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url() ?>dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>dist/css/datatable.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url() ?>vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>favicon.ico">
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/font-awesome.min.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/ResilientMaps.css" />
	<!-- <link rel="stylesheet" href="<?php echo base_url() ?>aset/bootleaf/app.css" /> -->
	

<!--     <link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>favicon.ico">
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/font-awesome.min.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/bootleaf/leaflet.groupedlayercontrol.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/ResilientMaps.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/bootleaf/app.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/leaflet102/leaflet.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/MarkerCluster.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/MarkerCluster.Default.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/L.Control.BetterScale.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/leafletdraw/leaflet.draw.css"/>
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/leaflet-search.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/leaflet-measure-path.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>aset/wind-js-leaflet.css" /> -->
</head>

<body>
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header" style="vertical-align:middle;"">
				<!-- <img class="pull-left" style="width:41px;height:41px;margin-top:5px;z-index:999;" src="<?php echo base_url() ?>aset/img/1.png"> -->
				<img class="pull-left" style="vertical-align:middle; width:30px;height:30px;margin-top:5px;z-index:999;" src="<?php echo base_url() ?>aset/img/1.png">
				<!-- <a class="navbar-brand" style="font-family:sshh;font-size:30;font-weight: normal;margin-top:0px;" href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="sidebar-legend-btn">&nbsp;Kost Putri EDUMEDIA</a> -->
				<a class="navbar-brand" style="color:white; vertical-align:middle; font-family:sshh;font-size:20;font-weight: normal;margin-top:0px;" href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="sidebar-legend-btn">&nbsp;Kost Putri EDUMEDIA&nbsp;</a>
				<ul class="nav navbar-nav pull-center">
					<li class="btn-group btn-group-sm" style="vertical-align:middle; margin-top:10px;" role="group">
						<button type="button" class="btn btn-success" id="peta"><i class="fa fa-map"></i>  Peta</button>
						<button type="button" class="btn btn-primary" id="tabel"><i class="fa fa-table"></i>  Lihat Tabel</button>
						<button type="button" class="btn btn-warning" id="about"><i class="fa fa-info-circle"></i> About</button>
					</li>
				</ul>
			</div>
			<ul class="pull-right">
				<i style="vertical-align:middle; font-family:'Arial'; color:white;  font-size:15; font-weight:normal; margin-top:8px">Welcome <?php if ($username) echo $username ?>&nbsp;</i>
				<li class="btn-group btn-group-sm" style="vertical-align:middle; margin-top:10px;" role="group">
					
<?php if ($permission) { ?>
					<button type="button" class="btn btn-info" id="backend"><i class="fa fa-gears"></i>  Halaman Admin</button>
					<button type="button" class="btn btn-danger" id="logout" onclick="location.href='http://google.com';"><i class="fa fa-sign-out"></i>  Logout</button>
<?php } else { ?>       
					<button type="button" class="btn btn-info" id="login"><i class="fa fa-gears"></i>  Login</button>
<?php } ?> 
				</li>
			</ul>
				
			<!-- </div> /.navbar-collapse  -->
		</div>
	</div>

	<div id="container">
		
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            List KOST
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table id="example" class="table table-striped table-bordered table-hover" style="width:100%; font-size:13;">
						        <thead>
						            <tr>
						                <th></th>
						                <th>Name</th>
						                <th>Position</th>
						                <th>Office</	th>
						                <th>Salary</th>
						            </tr>
						        </thead>
						    </table>
    						
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            List KAMAR
                        </div>
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" style="width:100%; font-size:13;">
                                <thead>
                                    <tr>
                                        <th>Rendering engine</th>
                                        <th>Browser</th>
                                        <th>Platform(s)</th>
                                        <th>Engine version</th>
                                        <th>CSS grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd gradeX">
                                        <td>Trident</td>
                                        <td>Internet Explorer 4.0</td>
                                        <td>Win 95+</td>
                                        <td class="center">4</td>
                                        <td class="center">X</td>
                                    </tr>
                                    <tr class="even gradeC">
                                        <td>Trident</td>
                                        <td>Internet Explorer 5.0</td>
                                        <td>Win 95+</td>
                                        <td class="center">5</td>
                                        <td class="center">C</td>
                                    </tr>
                                    <tr class="odd gradeA">
                                        <td>Trident</td>
                                        <td>Internet Explorer 5.5</td>
                                        <td>Win 95+</td>
                                        <td class="center">5.5</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="even gradeA">
                                        <td>Trident</td>
                                        <td>Internet Explorer 6</td>
                                        <td>Win 98+</td>
                                        <td class="center">6</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="odd gradeA">
                                        <td>Trident</td>
                                        <td>Internet Explorer 7</td>
                                        <td>Win XP SP2+</td>
                                        <td class="center">7</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="even gradeA">
                                        <td>Trident</td>
                                        <td>AOL browser (AOL desktop)</td>
                                        <td>Win XP</td>
                                        <td class="center">6</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Firefox 1.0</td>
                                        <td>Win 98+ / OSX.2+</td>
                                        <td class="center">1.7</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Firefox 1.5</td>
                                        <td>Win 98+ / OSX.2+</td>
                                        <td class="center">1.8</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Firefox 2.0</td>
                                        <td>Win 98+ / OSX.2+</td>
                                        <td class="center">1.8</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Firefox 3.0</td>
                                        <td>Win 2k+ / OSX.3+</td>
                                        <td class="center">1.9</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Camino 1.0</td>
                                        <td>OSX.2+</td>
                                        <td class="center">1.8</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Camino 1.5</td>
                                        <td>OSX.3+</td>
                                        <td class="center">1.8</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Netscape 7.2</td>
                                        <td>Win 95+ / Mac OS 8.6-9.2</td>
                                        <td class="center">1.7</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Netscape Browser 8</td>
                                        <td>Win 98SE+</td>
                                        <td class="center">1.7</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Netscape Navigator 9</td>
                                        <td>Win 98+ / OSX.2+</td>
                                        <td class="center">1.8</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Mozilla 1.0</td>
                                        <td>Win 95+ / OSX.1+</td>
                                        <td class="center">1</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Mozilla 1.1</td>
                                        <td>Win 95+ / OSX.1+</td>
                                        <td class="center">1.1</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Mozilla 1.2</td>
                                        <td>Win 95+ / OSX.1+</td>
                                        <td class="center">1.2</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Mozilla 1.3</td>
                                        <td>Win 95+ / OSX.1+</td>
                                        <td class="center">1.3</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Mozilla 1.4</td>
                                        <td>Win 95+ / OSX.1+</td>
                                        <td class="center">1.4</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Mozilla 1.5</td>
                                        <td>Win 95+ / OSX.1+</td>
                                        <td class="center">1.5</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Mozilla 1.6</td>
                                        <td>Win 95+ / OSX.1+</td>
                                        <td class="center">1.6</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Mozilla 1.7</td>
                                        <td>Win 98+ / OSX.1+</td>
                                        <td class="center">1.7</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Mozilla 1.8</td>
                                        <td>Win 98+ / OSX.1+</td>
                                        <td class="center">1.8</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Seamonkey 1.1</td>
                                        <td>Win 98+ / OSX.2+</td>
                                        <td class="center">1.8</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Gecko</td>
                                        <td>Epiphany 2.20</td>
                                        <td>Gnome</td>
                                        <td class="center">1.8</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Webkit</td>
                                        <td>Safari 1.2</td>
                                        <td>OSX.3</td>
                                        <td class="center">125.5</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Webkit</td>
                                        <td>Safari 1.3</td>
                                        <td>OSX.3</td>
                                        <td class="center">312.8</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Webkit</td>
                                        <td>Safari 2.0</td>
                                        <td>OSX.4+</td>
                                        <td class="center">419.3</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Webkit</td>
                                        <td>Safari 3.0</td>
                                        <td>OSX.4+</td>
                                        <td class="center">522.1</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Webkit</td>
                                        <td>OmniWeb 5.5</td>
                                        <td>OSX.4+</td>
                                        <td class="center">420</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Webkit</td>
                                        <td>iPod Touch / iPhone</td>
                                        <td>iPod</td>
                                        <td class="center">420.1</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Webkit</td>
                                        <td>S60</td>
                                        <td>S60</td>
                                        <td class="center">413</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Presto</td>
                                        <td>Opera 7.0</td>
                                        <td>Win 95+ / OSX.1+</td>
                                        <td class="center">-</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Presto</td>
                                        <td>Opera 7.5</td>
                                        <td>Win 95+ / OSX.2+</td>
                                        <td class="center">-</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Presto</td>
                                        <td>Opera 8.0</td>
                                        <td>Win 95+ / OSX.2+</td>
                                        <td class="center">-</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Presto</td>
                                        <td>Opera 8.5</td>
                                        <td>Win 95+ / OSX.2+</td>
                                        <td class="center">-</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Presto</td>
                                        <td>Opera 9.0</td>
                                        <td>Win 95+ / OSX.3+</td>
                                        <td class="center">-</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Presto</td>
                                        <td>Opera 9.2</td>
                                        <td>Win 88+ / OSX.3+</td>
                                        <td class="center">-</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Presto</td>
                                        <td>Opera 9.5</td>
                                        <td>Win 88+ / OSX.3+</td>
                                        <td class="center">-</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Presto</td>
                                        <td>Opera for Wii</td>
                                        <td>Wii</td>
                                        <td class="center">-</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Presto</td>
                                        <td>Nokia N800</td>
                                        <td>N800</td>
                                        <td class="center">-</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Presto</td>
                                        <td>Nintendo DS browser</td>
                                        <td>Nintendo DS</td>
                                        <td class="center">8.5</td>
                                        <td class="center">C/A<sup>1</sup>
                                        </td>
                                    </tr>
                                    <tr class="gradeC">
                                        <td>KHTML</td>
                                        <td>Konqureror 3.1</td>
                                        <td>KDE 3.1</td>
                                        <td class="center">3.1</td>
                                        <td class="center">C</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>KHTML</td>
                                        <td>Konqureror 3.3</td>
                                        <td>KDE 3.3</td>
                                        <td class="center">3.3</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>KHTML</td>
                                        <td>Konqureror 3.5</td>
                                        <td>KDE 3.5</td>
                                        <td class="center">3.5</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeX">
                                        <td>Tasman</td>
                                        <td>Internet Explorer 4.5</td>
                                        <td>Mac OS 8-9</td>
                                        <td class="center">-</td>
                                        <td class="center">X</td>
                                    </tr>
                                    <tr class="gradeC">
                                        <td>Tasman</td>
                                        <td>Internet Explorer 5.1</td>
                                        <td>Mac OS 7.6-9</td>
                                        <td class="center">1</td>
                                        <td class="center">C</td>
                                    </tr>
                                    <tr class="gradeC">
                                        <td>Tasman</td>
                                        <td>Internet Explorer 5.2</td>
                                        <td>Mac OS 8-X</td>
                                        <td class="center">1</td>
                                        <td class="center">C</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Misc</td>
                                        <td>NetFront 3.1</td>
                                        <td>Embedded devices</td>
                                        <td class="center">-</td>
                                        <td class="center">C</td>
                                    </tr>
                                    <tr class="gradeA">
                                        <td>Misc</td>
                                        <td>NetFront 3.4</td>
                                        <td>Embedded devices</td>
                                        <td class="center">-</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="gradeX">
                                        <td>Misc</td>
                                        <td>Dillo 0.8</td>
                                        <td>Embedded devices</td>
                                        <td class="center">-</td>
                                        <td class="center">X</td>
                                    </tr>
                                    <tr class="gradeX">
                                        <td>Misc</td>
                                        <td>Links</td>
                                        <td>Text only</td>
                                        <td class="center">-</td>
                                        <td class="center">X</td>
                                    </tr>
                                    <tr class="gradeX">
                                        <td>Misc</td>
                                        <td>Lynx</td>
                                        <td>Text only</td>
                                        <td class="center">-</td>
                                        <td class="center">X</td>
                                    </tr>
                                    <tr class="gradeC">
                                        <td>Misc</td>
                                        <td>IE Mobile</td>
                                        <td>Windows Mobile 6</td>
                                        <td class="center">-</td>
                                        <td class="center">C</td>
                                    </tr>
                                    <tr class="gradeC">
                                        <td>Misc</td>
                                        <td>PSP browser</td>
                                        <td>PSP</td>
                                        <td class="center">-</td>
                                        <td class="center">C</td>
                                    </tr>
                                    <tr class="gradeU">
                                        <td>Other browsers</td>
                                        <td>All others</td>
                                        <td>-</td>
                                        <td class="center">-</td>
                                        <td class="center">U</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
	</div>
	<!-- container -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <!-- <script src="<?php echo base_url() ?>aset/jQuery-v3.1.1.js"></script> -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    var LOGINSTAT = false;
    $("#login").click(function() {
	window.location.href = "../home/login";
	});
	$("#logout").click(function() {
		window.location.href = "../home/logout";
	});
	$("#backend").click(function() {
		window.location.href = "../admin/pemilik_ctrl";
	});
	$("#peta").click(function() {
		window.location.href = "../html/map";
	});
	$("#about").click(function() {
	window.location.href = "../html/about";
	});

	/* Formatting function for row details - modify as you need */
	function format ( d ) {
	    // `d` is the original data object for the row
	    return '<table class="table table-condensed table-hover" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px; font-size:13;">'+
	        '<tr>'+
	            '<td>Full name:</td>'+
	            '<td>'+d.name+'</td>'+
	        '</tr>'+
	        '<tr>'+
	            '<td>Extension number:</td>'+
	            '<td>'+d.extn+'</td>'+
	        '</tr>'+
	        '<tr>'+
	            '<td>Extra info:</td>'+
	            '<td>And any further details here (images etc)...</td>'+
	        '</tr>'+
	    '</table>';
	}
	 
	$(document).ready(function() {
	    var table = $('#example').DataTable( {
	        "ajax": "<?php echo base_url() ?>json/ajax.txt",
	        "columns": [
	            {
	                "className":      'details-control',
	                "orderable":      false,
	                "data":           null,
	                "defaultContent": ''
	            },
	            { "data": "name" },
	            { "data": "position" },
	            { "data": "office" },
	            { "data": "salary" }
	        ],
	        "order": [[1, 'asc']]
	    } );
	     
	    // Add event listener for opening and closing details
	    $('#example tbody').on('click', 'td.details-control', function () {
	        var tr = $(this).closest('tr');
	        var row = table.row( tr );
	 
	        if ( row.child.isShown() ) {
	            // This row is already open - close it
	            row.child.hide();
	            tr.removeClass('shown');
	        }
	        else {
	            // Open this row
	            row.child( format(row.data()) ).show();
	            tr.addClass('shown');
	        }
	    } );
	} );

	// $('#example').DataTable({
	//     select: {
	//         selector:'td:not(:first-child)',
	//         style:    'os'
	//     }
	// });
    </script>


</body>

</html>
