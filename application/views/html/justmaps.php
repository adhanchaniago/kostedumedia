<!DOCTYPE html>
<html>
    <head>
        <title>Puskodal Side Menu</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet-search.css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.css" />
        
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/base.js"> </script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui-1.10.2.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->item('socket_ip') ?>/socket.io/socket.io.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.draw.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet-search.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/leaflet.label.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/leaflet/Marker.Rotate.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.jgrowl.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.sidebar.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/geo.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/latlon.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/css-pop.js"></script>
        <script type="text/javascript">
            var month=new Array(12);
            month[0]="Januari";
            month[1]="Februari";
            month[2]="Maret";
            month[3]="April";
            month[4]="Mei";
            month[5]="Juni";
            month[6]="Juli";
            month[7]="Agustus";
            month[8]="September";
            month[9]="Oktober";
            month[10]="November";
            month[11]="Desember";

            var tempIntelegent,tempRanpur,tempSubmarine = [];

            var measuring_line = null;
            var stat_ukur_jarak = false;
            var isMeasuring = false;
            var stopMeasuring = false;

            var start_lat = null;
            var start_lon = null;
            var distancePopup = false;
            var stat_draw_area = false;
            var type_draw_area = 'polygon';
            var draw_circle,draw_point,draw_polygon = null;
            var configMap = {
                latCenter : -2.108899,
                lonCenter : 117.509766,
                zoom :6,
                mapUrl : '<?php echo $this->config->item('map_url') ?>',
                mapStyleId : 22677
            };
            var conf = {
                url : '<?php echo base_url() ?>'
            };
            var map,marker = new Array(),groupMarkerPoi,markerPoi = new Array(),dataMarkerPoi = new Array(),temp_path = new Array(),polygon_area = new Array(),data_area = new Array(),circle_area = new Array(),data_area_circle = new Array();
            var count_area = 0,count_area_circle=0,count_marker=0;
            var socket = io.connect('<?php echo $this->config->item('socket_ip') ?>');
            var markersLayer = new Array();
            var markerKRI = new Array(),markerKRIdata = new Array();
            var stat_view = {kri:true,track:false,intelegent:false,ranpur:false,submarine:false};
            var dataIntelegent,dataRanpur,dataSubmarine = null;
            var markerAdditional = new Array();
            var markerTrack = null;
            var markersSearch = new L.LayerGroup();
            var ShipMarker = L.Icon.extend({
                options: {
                    iconSize:     [20, 20],
                    iconAnchor: [8, 20]
                }
            });
            var IconKI = new ShipMarker({iconUrl:conf.url+'assets/img/icon-ship/blue2/1.-KI.png'}),//MEMASUKAN GAMBAR IKON 
            IconUnk = new ShipMarker({iconUrl: conf.url+'assets/img/icon-ship/non-kri/1.-Non-NKRI-(Red).png'}),
            IconMarine = new ShipMarker({iconUrl: conf.url+'assets/img/icon-ship/non-kri/1.-Non-NKRI-(Blue).png'}),
            IconIntelegent = new ShipMarker({iconUrl: conf.url+'assets/img/icon-ship/non-kri/1.-Non-NKRI-(Green).png'}),
            IconAeroplane = new ShipMarker({iconUrl: conf.url+'assets/img/icon-ship/blue2/2.-PKR.png'}),
            IconRanpur = new ShipMarker({iconUrl: conf.url+'assets/img/icon-ship/blue2/5.-KCR.png'}),
            IconSubmarine = new ShipMarker({iconUrl: conf.url+'assets/img/icon-ship/blue2/9.-SS.png'}),
            IconStation = new ShipMarker({iconUrl: conf.url+'assets/img/icon-ship/non-kri/1.-Non-NKRI-(Yellow).png'});
            var tempTrack = null;
            var array_search = new Array();
            var array_additional = new Array();
            var circleAnimation = null;
        </script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/maps.js"> </script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/chat.js"> </script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/forms.js"> </script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/tools.js"> </script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/util.js"> </script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/control/feature.js"> </script>
    </head>
    <body>
        <div style="width:100%; height: 500px;" id="map"></div>
        <div id="blanket" style="display:none;"><img src="<?php echo base_url() ?>assets/html/img/loading.gif" /></div>
        <div id="popUpDiv" style="display:none;"><img src="<?php echo base_url() ?>assets/html/img/loading.gif" /></div>
    </body>
</html>