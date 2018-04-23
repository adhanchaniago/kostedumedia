<!DOCTYPE html>
<html>
    <head>
        <title>Puskodal PDF Generator</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style>
            body{
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
            }
            
            a{
                display: block;
                padding: 10px;
                text-shadow: 0 1px 1px #FFF;
                text-decoration: none;
                background: #EEE;
                border: 1px solid #DDD;
                margin: 10px 0;
                opacity: .5;
                color: #666;
                text-transform: capitalize;
                font-weight: bold;
                transition: all 200ms ease-in-out;
                -o-transition: all 200ms ease-in-out;
                -ms-transition: all 200ms ease-in-out;
                -moz-transition: all 200ms ease-in-out;
                -webkit-transition: all 200ms ease-in-out;
            }
            
            a:hover{
                color: #333;
                background: #DDD;
                border: 1px solid #CCC;
            }
            
            a.on{
                opacity: 1;
            }
        </style>
    </head>
    <body>
        <img src="<?php echo base_url() ?>assets/html/img/logo-new-lite.png" style="width: 150px; margin: 0 auto; text-align: center;" />
        
<!--        <a href="#">Laporan harian dislokasi jam 06.00</a>-->
<!--        <a href="#">Laporan harian dislokasi unsur</a>-->
        <a href="<?php echo base_url() ?>html/pdflaporanhariankesiapankal" class="on">Laporan harian kesiapan kal</a>
        <a href="<?php echo base_url() ?>html/pdflaporanhariankesiapankri" class="on">Laporan harian kesiapan kri</a>
        <a href="<?php echo base_url() ?>html/pdflaporanhariankesiapanpesud" class="on">Laporan harian kesiapan pesud</a>
        <a href="<?php echo base_url() ?>html/pdflaporanhariankesiapanranpurmarinir" class="on">Laporan harian kesiapan ranpur marinir</a>
<!--        <a href="#">Laporan harian map info (dislokasi unsur)</a>-->
        <a href="<?php echo base_url() ?>html/pdfperintahmalam" class="on">Laporan harian perintah malam (prima)</a>
        <a href="<?php echo base_url() ?>html/pdflaporansiaga" class="on">Laporan harian siaga jam 06.00</a>
        <a href="<?php echo base_url() ?>html/pdflampiranlaporansiaga" class="on">Lampiran Laporan harian siaga jam 06.00</a>
        <a href="<?php echo base_url() ?>html/pdflaporandislokasi" class="on">Laporan Dislokasi</a>
<!--        <a href="#">laporan mingguan</a>-->
<!--        <a href="#">Laporan bulanan</a>-->
<!--        <a href="#">Laporan tahunan</a>-->
    </body>
</html>