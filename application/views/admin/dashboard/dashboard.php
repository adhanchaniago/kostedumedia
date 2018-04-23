<script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/highcharts.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/highcharts-more.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/data.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/exporting.js"></script>
        <script type="text/javascript">
            var baseUrl = '<?php echo base_url() ?>';
            
            // console.log('ship armabar ' + '<?php echo $ship["armabar"] ?>');
            // console.log('ship armatim ' + '<?php echo $ship["armatim"] ?>');
            // console.log('ship kolinlamil ' + '<?php echo $ship["kolinlamil"] ?>');
            // console.log('ship lainlain ' + '<?php echo $ship["lainlain"] ?>');
            // console.log('pesud armabar ' + '<?php echo $aeroplane["armabar"] ?>');
            // console.log('pesud armatim ' + '<?php echo $aeroplane["armatim"] ?>');
            // console.log('pesud kolinlamil ' + '<?php echo $aeroplane["kolinlamil"] ?>');
            // console.log('pesud lainlain ' + '<?php echo $aeroplane["lainlain"] ?>');
            
            var s_armabar = <?php echo $ship["armabar"] ?>;
            var s_armatim = <?php echo $ship["armatim"] ?>;
            var s_kolinlamil = <?php echo $ship["kolinlamil"] ?>;
            var s_lain = <?php echo $ship["lainlain"] ?>;
            var p_armabar = <?php echo $aeroplane["armabar"] ?>;
            var p_armatim = <?php echo $aeroplane["armatim"] ?>;
            var p_kolinlamil = <?php echo $aeroplane["kolinlamil"] ?>;
            var p_lain = <?php echo $aeroplane["lainlain"] ?>;
            var r_armabar = (s_armabar + p_armabar)/2;
            var r_armatim = (s_armatim + p_armatim)/2;
            var r_kolinlamil = (s_kolinlamil + p_kolinlamil)/2;
            var r_lain = (s_lain + p_lain)/2;

            var chart;
            $(window).load(function() {
                $('#combo-chart').highcharts({
                    chart: {
                    },
                    title: {
                        text: 'Kondisi Armada'
                    },
                    xAxis: {
                        categories: ['Armabar', 'Armatim', 'Kolinlamil', 'Lain-lain']
                    },
                    tooltip: {
                        formatter: function() {
                            var s;
                            if (this.point.name) { // the pie chart
                                s = ''+
                                    this.point.name +': '+ this.y +' unit';
                            } else {
                                s = ''+
                                    this.x  +': '+ this.y;
                            }
                            return s;
                        }
                    },
                    labels: {
                        items: [{
                                html: 'Total Armada',
                                style: {
                                    left: '40px',
                                    top: '8px',
                                    color: 'black'
                                }
                            }]
                    },
                    series: [{
                            type: 'column',
                            name: 'KRI',
                            data: [s_armabar, s_armatim, s_kolinlamil, s_lain]
                        }, {
                            type: 'column',
                            name: 'PESUD',
                            data: [p_armabar, p_armatim, p_kolinlamil, p_lain]
                        }, {
                            type: 'spline',
                            name: 'Rata-rata',
                            data: [r_armabar, r_armatim, r_kolinlamil, r_lain],
                            marker: {
                                lineWidth: 2,
                                lineColor: Highcharts.getOptions().colors[3],
                                fillColor: 'white'
                            }
                        }, {
                            type: 'pie',
                            name: 'Total consumption',
                            data: [{
                                    name: 'KRI',
                                    y: s_armabar + s_armatim + s_kolinlamil + s_lain,
                                    color: Highcharts.getOptions().colors[0] // Jane's color
                                }, {
                                    name: 'PESUD',
                                    y: p_armabar + p_armatim + p_kolinlamil + p_lain,
                                    color: Highcharts.getOptions().colors[1] // John's color
                                }],
                            center: [100, 80],
                            size: 100,
                            showInLegend: false,
                            dataLabels: {
                                enabled: false
                            }
                        }]
                });
                
            });
        </script>
<div class="clear"></div>
                <br />

                <div id="combo-chart"></div>
                <div class="clear"></div>
                <br /><br />
                
                <div id="rose"></div>
                <div class="clear"></div>
                <br /><br />
                
                <!-- <div style="display:none">                    
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
 -->