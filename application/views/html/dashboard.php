<!DOCTYPE html>
<html>
    <head>
        <title>Puskodal Side Menu</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/html/css/reset.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/html/css/back-end.puskodal.css" />

        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.9.1.min.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/highcharts.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/highcharts-more.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/data.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/exporting.js"></script>
        <script type="text/javascript">
            var baseUrl = '<?php echo base_url() ?>';
            
            var chart;
            $(window).load(function() {
                $('#combo-chart').highcharts({
                    chart: {
                    },
                    title: {
                        text: 'Combination chart'
                    },
                    xAxis: {
                        categories: ['Apples', 'Oranges', 'Pears', 'Bananas', 'Plums']
                    },
                    tooltip: {
                        formatter: function() {
                            var s;
                            if (this.point.name) { // the pie chart
                                s = ''+
                                    this.point.name +': '+ this.y +' fruits';
                            } else {
                                s = ''+
                                    this.x  +': '+ this.y;
                            }
                            return s;
                        }
                    },
                    labels: {
                        items: [{
                                html: 'Total fruit consumption',
                                style: {
                                    left: '40px',
                                    top: '8px',
                                    color: 'black'
                                }
                            }]
                    },
                    series: [{
                            type: 'column',
                            name: 'Jane',
                            data: [3, 2, 1, 3, 4]
                        }, {
                            type: 'column',
                            name: 'John',
                            data: [2, 3, 5, 7, 6]
                        }, {
                            type: 'column',
                            name: 'Joe',
                            data: [4, 3, 3, 9, 0]
                        }, {
                            type: 'spline',
                            name: 'Average',
                            data: [3, 2.67, 3, 6.33, 3.33],
                            marker: {
                                lineWidth: 2,
                                lineColor: Highcharts.getOptions().colors[3],
                                fillColor: 'white'
                            }
                        }, {
                            type: 'pie',
                            name: 'Total consumption',
                            data: [{
                                    name: 'Jane',
                                    y: 13,
                                    color: Highcharts.getOptions().colors[0] // Jane's color
                                }, {
                                    name: 'John',
                                    y: 23,
                                    color: Highcharts.getOptions().colors[1] // John's color
                                }, {
                                    name: 'Joe',
                                    y: 19,
                                    color: Highcharts.getOptions().colors[2] // Joe's color
                                }],
                            center: [100, 80],
                            size: 100,
                            showInLegend: false,
                            dataLabels: {
                                enabled: false
                            }
                        }]
                });
                
                $('#rose').highcharts({
                    data: {
                        table: 'freq',
                        startRow: 1,
                        endRow: 17,
                        endColumn: 7
                    },
                    chart: {
                        polar: true,
                        type: 'column'
                    },
                    title: {
                        text: 'Wind rose for South Shore Met Station, Oregon'
                    },
                    subtitle: {
                        text: 'Source: or.water.usgs.gov'
                    },
                    pane: {
                        size: '85%'
                    },
                    legend: {
                        reversed: true,
                        align: 'right',
                        verticalAlign: 'top',
                        y: 100,
                        layout: 'vertical'
                    },
                    xAxis: {
                        tickmarkPlacement: 'on'
                    },
                    yAxis: {
                        min: 0,
                        endOnTick: false,
                        showLastLabel: true,
                        title: {
                            text: 'Frequency (%)'
                        },
                        labels: {
                            formatter: function () {
                                return this.value + '%';
                            }
                        }
                    },
                    tooltip: {
                        valueSuffix: '%',
                        followPointer: true
                    },
                    plotOptions: {
                        series: {
                            stacking: 'normal',
                            shadow: false,
                            groupPadding: 0,
                            pointPlacement: 'on'
                        }
                    }
                });
            });
        </script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/back-end.puskodal.js"></script>
    </head>
    <body>
        <img src="<?php echo base_url() ?>assets/html/img/loading.gif" id="loading" style="display: none;" />
        <div id="spotting-holder" style="display: none;">
            <div id="spotting-content">
                <div id="title-pop">
                    <ul>
                        <li><p>Armada Operasi (KRI)</p></li>
                        <li><label>Nama Operasi</label>: Ambalat Sakti</li>
                        <li><label>Waktu</label>: X Juni 2013 s/d Y April 2014</li>
                    </ul>
                </div>

                <div class="list-data" id="lefting">
                    <p style="border-bottom: 1px solid #DDD;" id="first-lefting"><a href="#" id="add-all">Masukan Semua</a> KRI yang tersedia</p>
                    <input type="text" placeholder="Masukan Kata Kunci" class="search-list" />
                    <div class="scrolling">
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 1</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 2</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 3</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 4</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 5</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 6</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 7</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 8</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 9</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 10</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 11</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 12</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 13</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 14</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 15</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 16</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 17</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 18</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 19</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 20</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 21</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 22</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 23</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 24</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 25</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 26</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 27</span></a>
                    </div>
                    <p class="datkos" style="display: none;">Tidak ada data</p>
                    <p>KRI yang tersedia</p>
                </div>
                <div class="list-data" id="righting">
                    <p style="border-bottom: 1px solid #DDD;" id="first-righting"><a href="#" id="remove-all" style="margin-left: 245px;">Hapus Semua</a>List armada yang sudah masuk</p>
                    <input type="text" placeholder="Masukan Kata Kunci" class="search-list" />
                    <div class="scrolling">
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/cancel.png" /><span>KRI 28</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/cancel.png" /><span>KRI 29</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/cancel.png" /><span>KRI 30</span></a>
                    </div>
                    <p class="datkos" style="display: none;">Tidak ada data</p>
                    <p>List armada yang sudah masuk</p>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div id="backlight" style="display: none;"></div>
        <div id="container">
            <ul id="side-menu">
                <li id="logo"><img src="<?php echo base_url() ?>assets/html/img/logo-new-liting.png" /></li>
                <li><a href="#" class="current"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Dashboard</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Kesatuan</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Operasi</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Personel</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Kapal</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Pangkalan</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Skuadron</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />PESUD</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Kapal Selam</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />RANPUR</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Marinir</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Corps</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Pilots</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Skuadron</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Pilot</a></li>
                <li class="category">Reference</li>
                <li class="sub-category"><a href="#"><span>Pengguna</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a></li>
                <li class="Pengguna" style="display: none;"><a href="#">Pengguna</a></li>
                <li class="Pengguna" style="display: none;"><a href="#">Role Pengguna</a></li>
                <li class="Pengguna" style="display: none;"><a href="#">Role</a></li>
                <li class="sub-category"><a href="#"><span>Kapal</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a></li>
                <li class="Kapal" style="display: none;"><a href="#">Logistik Kapal</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Akses Kapal</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Operasi Kapal</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Personel</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Status Kapal</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Ship Logistic</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Ship Viewable</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Ship Operation</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Ship Type</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Ship Status</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Status Operasi</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Akses Operasi</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Tipe Pangkalan</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Logistik Pangkalan</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Tipe Personel</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Tipe Kapal</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Pangkat Pilot</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Tipe Pesawat</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Logistik Pesawat</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Logistik Marinir</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Operation Status</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Operation View Ability</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Station Type</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Station Logistic</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Personnel Type</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Pilot Grade</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Aeroplane Type</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Item Logistik</a></li>
            </ul>
            <div id="content">
                <div id="title-up">
                    Kesatuan <a href="#" class="red">Log Out</a> <a href="#" class="blue">Maps</a>
                </div>

                <div class="clear"></div>
                <br />

                <div id="combo-chart"></div>
                <div class="clear"></div>
                <br /><br />
                
                <div id="rose"></div>
                <div class="clear"></div>
                <br /><br />
                
                <div style="display:none">
                    <!-- Source: http://or.water.usgs.gov/cgi-bin/grapher/graph_windrose.pl -->
                    <table id="freq" border="0" cellspacing="0" cellpadding="0">
                        <tr nowrap bgcolor="#CCCCFF">
                            <th colspan="9" class="hdr">Table of Frequencies (percent)</th>
                        </tr>
                        <tr nowrap bgcolor="#CCCCFF">
                            <th class="freq">Direction</th>
                            <th class="freq">&lt; 0.5 m/s</th>
                            <th class="freq">0.5-2 m/s</th>
                            <th class="freq">2-4 m/s</th>
                            <th class="freq">4-6 m/s</th>
                            <th class="freq">6-8 m/s</th>
                            <th class="freq">8-10 m/s</th>
                            <th class="freq">&gt; 10 m/s</th>
                            <th class="freq">Total</th>
                        </tr>
                        <tr nowrap>
                            <td class="dir">N</td>
                            <td class="data">1.81</td>
                            <td class="data">1.78</td>
                            <td class="data">0.16</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">3.75</td>
                        </tr>		
                        <tr nowrap bgcolor="#DDDDDD">
                            <td class="dir">NNE</td>
                            <td class="data">0.62</td>
                            <td class="data">1.09</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">1.71</td>
                        </tr>
                        <tr nowrap>
                            <td class="dir">NE</td>
                            <td class="data">0.82</td>
                            <td class="data">0.82</td>
                            <td class="data">0.07</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">1.71</td>
                        </tr>
                        <tr nowrap bgcolor="#DDDDDD">
                            <td class="dir">ENE</td>
                            <td class="data">0.59</td>
                            <td class="data">1.22</td>
                            <td class="data">0.07</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">1.88</td>
                        </tr>
                        <tr nowrap>
                            <td class="dir">E</td>
                            <td class="data">0.62</td>
                            <td class="data">2.20</td>
                            <td class="data">0.49</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">3.32</td>
                        </tr>
                        <tr nowrap bgcolor="#DDDDDD">
                            <td class="dir">ESE</td>
                            <td class="data">1.22</td>
                            <td class="data">2.01</td>
                            <td class="data">1.55</td>
                            <td class="data">0.30</td>
                            <td class="data">0.13</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">5.20</td>
                        </tr>
                        <tr nowrap>
                            <td class="dir">SE</td>
                            <td class="data">1.61</td>
                            <td class="data">3.06</td>
                            <td class="data">2.37</td>
                            <td class="data">2.14</td>
                            <td class="data">1.74</td>
                            <td class="data">0.39</td>
                            <td class="data">0.13</td>
                            <td class="data">11.45</td>
                        </tr>
                        <tr nowrap bgcolor="#DDDDDD">
                            <td class="dir">SSE</td>
                            <td class="data">2.04</td>
                            <td class="data">3.42</td>
                            <td class="data">1.97</td>
                            <td class="data">0.86</td>
                            <td class="data">0.53</td>
                            <td class="data">0.49</td>
                            <td class="data">0.00</td>
                            <td class="data">9.31</td>
                        </tr>
                        <tr nowrap>
                            <td class="dir">S</td>
                            <td class="data">2.66</td>
                            <td class="data">4.74</td>
                            <td class="data">0.43</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">7.83</td>
                        </tr>
                        <tr nowrap bgcolor="#DDDDDD">
                            <td class="dir">SSW</td>
                            <td class="data">2.96</td>
                            <td class="data">4.14</td>
                            <td class="data">0.26</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">7.37</td>
                        </tr>
                        <tr nowrap>
                            <td class="dir">SW</td>
                            <td class="data">2.53</td>
                            <td class="data">4.01</td>
                            <td class="data">1.22</td>
                            <td class="data">0.49</td>
                            <td class="data">0.13</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">8.39</td>
                        </tr>
                        <tr nowrap bgcolor="#DDDDDD">
                            <td class="dir">WSW</td>
                            <td class="data">1.97</td>
                            <td class="data">2.66</td>
                            <td class="data">1.97</td>
                            <td class="data">0.79</td>
                            <td class="data">0.30</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">7.70</td>
                        </tr>
                        <tr nowrap>
                            <td class="dir">W</td>
                            <td class="data">1.64</td>
                            <td class="data">1.71</td>
                            <td class="data">0.92</td>
                            <td class="data">1.45</td>
                            <td class="data">0.26</td>
                            <td class="data">0.10</td>
                            <td class="data">0.00</td>
                            <td class="data">6.09</td>
                        </tr>
                        <tr nowrap bgcolor="#DDDDDD">
                            <td class="dir">WNW</td>
                            <td class="data">1.32</td>
                            <td class="data">2.40</td>
                            <td class="data">0.99</td>
                            <td class="data">1.61</td>
                            <td class="data">0.33</td>
                            <td class="data">0.00</td>
                            <td class="data">0.00</td>
                            <td class="data">6.64</td>
                        </tr>
                        <tr nowrap>
                            <td class="dir">NW</td>
                            <td class="data">1.58</td>
                            <td class="data">4.28</td>
                            <td class="data">1.28</td>
                            <td class="data">0.76</td>
                            <td class="data">0.66</td>
                            <td class="data">0.69</td>
                            <td class="data">0.03</td>
                            <td class="data">9.28</td>
                        </tr>		
                        <tr nowrap bgcolor="#DDDDDD">
                            <td class="dir">NNW</td>
                            <td class="data">1.51</td>
                            <td class="data">5.00</td>
                            <td class="data">1.32</td>
                            <td class="data">0.13</td>
                            <td class="data">0.23</td>
                            <td class="data">0.13</td>
                            <td class="data">0.07</td>
                            <td class="data">8.39</td>
                        </tr>
                        <tr nowrap>
                            <td class="totals">Total</td>
                            <td class="totals">25.53</td>
                            <td class="totals">44.54</td>
                            <td class="totals">15.07</td>
                            <td class="totals">8.52</td>
                            <td class="totals">4.31</td>
                            <td class="totals">1.81</td>
                            <td class="totals">0.23</td>
                            <td class="totals">&nbsp;</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="clear"></div>

            <p id="copyrights">Copyrights &copy; 2015 Pusat Komando dan Pengendalian Tentara Nasional Indonesia Angkatan Laut. Semua Hak Cipta Dilindungi.</p>
        </div>
    </body>
</html>