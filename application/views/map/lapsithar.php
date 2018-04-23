<!--
  @author Wira Sakti G
  @added Jul 17, 2013
-->
<script src="<?php echo base_url() ?>assets/js/jquery-1.7.2.min.js"></script>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <form id="lapitshar_form" action="" method="post">
            <fieldset>
                <label for="judul">Judul :</label>
                <input type="text" name="judul_lapitshar" class="text ui-widget-content ui-corner-all"/><br/>

                <label for="lattitude">Lattitude:</label>
                <div style="width: 104px; float: left; margin: 0 20px 0 0;">
                    <input type="text" name="lat_degree_lapitshar" size="5" class="text ui-widget-content ui-corner-all lat_degree" style="float: left; margin-right: 3px;" onkeypress="return validDegree(event,'lat_degree')"/> <span class="symbol">&#176;</span>
                </div>
                <div style="width: 104px; float: left; margin: 0 20px 0 0;">
                    <input type="text" name="lat_minute_lapitshar" size="5" class="text ui-widget-content ui-corner-all lat_minute" style="float: left; margin-right: 3px;" onkeypress="return validMinuteSecond(event,'lat_minute')"/> <span class="symbol">&#39;</span>
                </div>
                <div style="width: 104px; float: left; margin: 0 20px 0 0;">
                    <input type="text" name="lat_second_lapitshar" size="5" class="text ui-widget-content ui-corner-all lat_second" style="float: left; margin-right: 3px;" onkeypress="return validMinuteSecond(event,'lat_second')"/> <span class="symbol">&#34;</span>
                </div>
                <select name="lat_point_lapitshar" class="selecting" style="width: 91px;">
                    <option value="U">U</option>
                    <option value="S">S</option>
                </select>

                <label for="lattitude">Longitude:</label>
                <div style="width: 104px; float: left; margin: 0 20px 0 0;">
                    <input type="text" name="lon_degree_lapitshar" size="5" class="text ui-widget-content ui-corner-all lon_degree" style="float: left; margin-right: 3px;" onkeypress="return validDegree(event,'lon_degree')"/> <span class="symbol">&#176;</span>
                </div>
                <div style="width: 104px; float: left; margin: 0 20px 0 0;">
                    <input type="text" name="lon_minute_lapitshar" size="5" class="text ui-widget-content ui-corner-all lon_minute" style="float: left; margin-right: 3px;" onkeypress="return validMinuteSecond(event,'lon_minute')"/> <span class="symbol">&#39;</span>
                </div>
                <div style="width: 104px; float: left; margin: 0 20px 0 0;">
                    <input type="text" name="lon_second_lapitshar" size="5" class="text ui-widget-content ui-corner-all lon_second" style="float: left; margin-right: 3px;" onkeypress="return validMinuteSecond(event,'lon_second')"/> <span class="symbol">&#34;</span>
                </div>
                <select name="lon_point_lapitshar" class="selecting" style="width: 91px;">
                    <option value="T">T</option>
                    <option value="B">B</option>
                </select>

                <label for="pelanggaran">Tipe Pelanggaran :</label>
                <select name="tipe_pelanggaran" class="selecting">
                    <option></option>
                </select>
                <br/>

                <label for="detail">Detail :</label>
                <textarea name="detail" class="text ui-widget-content ui-corner-all" style="height: 100px;"></textarea>

                <input type="button" value="Cancel"/>
                <input type="submit" value="Create"/>
            </fieldset>
        </form>
    </body>
</html>

