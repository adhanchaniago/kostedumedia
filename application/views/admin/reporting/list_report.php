
<style>
    a.report-link {
        display: block;
        padding: 10px;
        text-shadow: 0 1px 1px #FFF;
        text-decoration: none;
        background: #EEE;
        border: 1px solid #DDD;
        margin: 10px;
        opacity: .7;
        color: #666;
        text-transform: capitalize;
        font-weight: bold;
        transition: all 200ms ease-in-out;
        -o-transition: all 200ms ease-in-out;
        -ms-transition: all 200ms ease-in-out;
        -moz-transition: all 200ms ease-in-out;
        -webkit-transition: all 200ms ease-in-out;
    }

    a.report-link:hover{
        color: #333;
        background: #DDD;
        border: 1px solid #CCC;
    }

    a.report-link .on{
        opacity: 1;
    }
</style>
<!--        <a href="#">Laporan harian dislokasi jam 06.00</a>-->
<!--        <a href="#">Laporan harian dislokasi unsur</a>-->
<a href="<?php echo base_url() ?>admin/reporting_ctrl/pdflaporanhariankesiapankal" class="report-link on">Laporan harian kesiapan kal</a>
<a href="<?php echo base_url() ?>admin/reporting_ctrl/pdflaporanhariankesiapankri" class="report-link on">Laporan harian kesiapan kri</a>
<a href="<?php echo base_url() ?>admin/reporting_ctrl/pdflaporanhariankesiapanpesud" class="report-link on">Laporan harian kesiapan pesud</a>
<a href="<?php echo base_url() ?>admin/reporting_ctrl/pdflaporanhariankesiapanranpurmarinir" class="report-link on">Laporan harian kesiapan ranpur marinir</a>
<!--        <a href="#">Laporan harian map info (dislokasi unsur)</a>-->
<a href="<?php echo base_url() ?>admin/reporting_ctrl/pdfperintahmalam" class="report-link on">Laporan harian perintah malam (prima)</a>
<a href="<?php echo base_url() ?>admin/reporting_ctrl/pdflaporansiaga" class="report-link on">Laporan harian siaga jam 06.00</a>
<a href="<?php echo base_url() ?>admin/reporting_ctrl/pdflampiranlaporansiaga" class="report-link on">Lampiran Laporan harian siaga jam 06.00</a>
<a href="<?php echo base_url() ?>admin/reporting_ctrl/pdflaporandislokasi" class="report-link on">Laporan Dislokasi</a>
<!--        <a href="#">laporan mingguan</a>-->
<!--        <a href="#">Laporan bulanan</a>-->
<!--        <a href="#">Laporan tahunan</a>-->