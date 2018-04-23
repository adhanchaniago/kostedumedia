// Ini adalah file untuk menginisialisasi properti marker
var tugLayer = new L.MarkerClusterGroup();
var tankerLayer = new L.MarkerClusterGroup();
var cargoLayer = new L.MarkerClusterGroup();
var passengerLayer = new L.MarkerClusterGroup();
var highspeedLayer = new L.MarkerClusterGroup();
var fishingLayer = new L.MarkerClusterGroup();
var yachtLayer = new L.MarkerClusterGroup();
var otherLayer = new L.MarkerClusterGroup();
var searchLayer = new L.MarkerClusterGroup();
var arpaLayer = new L.MarkerClusterGroup();

//Ini adalah inisialisasi gambar kapal yang sedang berlayar
var tug_layar = L.icon({
    iconUrl: '../assets/img/icon_kapal/layar_tug.png',
    iconSize: [15, 25],
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var tanker_layar = L.icon({
    iconUrl: '../assets/img/icon_kapal/layar_tanker.png',
    iconSize: [15, 25],
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var cargo_layar = L.icon({
    iconUrl: '../assets/img/icon_kapal/layar_cargo.png',
    iconSize: [15, 25],
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var passenger_layar = L.icon({
    iconUrl: '../assets/img/icon_kapal/layar_passenger.png',
    iconSize: [15, 25],
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var highspeed_layar = L.icon({
    iconUrl: '../assets/img/icon_kapal/layar_highspeed.png',
    iconSize: [15, 25],
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var fishing_layar = L.icon({
    iconUrl: '../assets/img/icon_kapal/layar_fishing.png',
    iconSize: [15, 25],
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var yacht_layar = L.icon({
    iconUrl: '../assets/img/icon_kapal/layar_yacht.png',
    iconSize: [15, 25],
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var other_layar = L.icon({
    iconUrl: '../assets/img/icon_kapal/layar_other.png',
    iconSize: [15, 25],
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});


// Ini adalah inisialisasi gambar kapal yang sedang sandar
var tug_sandar = L.icon({
    iconUrl: '../assets/img/icon_kapal/sandar_tug.png',    
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var tanker_sandar = L.icon({
    iconUrl: '../assets/img/icon_kapal/sandar_tanker.png',    
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var cargo_sandar = L.icon({
    iconUrl: '../assets/img/icon_kapal/sandar_cargo.png',    
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var passenger_sandar = L.icon({
    iconUrl: '../assets/img/icon_kapal/sandar_passenger.png',    
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var highspeed_sandar = L.icon({
    iconUrl: '../assets/img/icon_kapal/sandar_highspeed.png',    
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var fishing_sandar = L.icon({
    iconUrl: '../assets/img/icon_kapal/sandar_fishing.png',    
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var yacht_sandar = L.icon({
    iconUrl: '../assets/img/icon_kapal/sandar_yacht.png',    
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var other_sandar = L.icon({
    iconUrl: '../assets/img/icon_kapal/sandar_other.png',    
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var data_arpa = L.icon({
    iconUrl: '../assets/img/target-icon/ARPA-active.png',
    iconSize: [22, 22],  
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});
