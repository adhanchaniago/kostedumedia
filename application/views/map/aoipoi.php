<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<script src="<?php echo base_url() ?>assets/js/jquery-1.7.2.min.js"></script>
<script>
    var count_line=2;
    function add_more_line(){
        var line = document.createElement('div');
        line.setAttribute('id', 'line'+ count_line);
        line.innerHTML = '<label for="lattitude">Lattitude :</label>'+
            '<input type="text" name="pol_lat_degree'+count_line+'" size="5"/>&#176;'+
            '<input type="text" name="pol_lat_minute'+count_line+'" size="5"/>&#39;'+
            '<input type="text" name="pol_lat_second'+count_line+'" size="5"/>&#34;'+
            '<select name="pol_lat_point'+count_line+'">'+
            '<option value="U">U</option>'+
            '<option value="S">S</option>'+
            '</select>'+
            '&nbsp;&nbsp;&nbsp;'+
            '<label for="lattitude">Longitude :</label>'+
            '<input type="text" name="pol_lon_degree'+count_line+'" size="5"/>&#176;'+
            '<input type="text" name="pol_lon_minute'+count_line+'" size="5"/>&#39;'+
            '<input type="text" name="pol_lon_second'+count_line+'" size="5"/>&#34;'+
            '<select name="pol_lon_point'+count_line+'">'+
            '<option value="T">T</option>'+
            '<option value="B">B</option>'+
            '</select>';
        $("#add_more_line").append(line);
        $("#total_line_polygon").val(count_line);
        count_line++;
    }
    
    function point(){
        $('#latlon').empty();
        $('#radius').empty();
        $('#polygon').empty();
        var latlon = '<label for="lattitude">Lattitude :</label>'+
            '<input type="text" name="lat_degree" size="5"/>&#176;'+
            '<input type="text" name="lat_minute" size="5"/>&#39;'+
            '<input type="text" name="lat_second" size="5"/>&#34;'+
            '<select name="lat_point">'+
            '<option value="U">U</option>'+
            '<option value="S">S</option>'+
            '</select>'+
            '&nbsp;&nbsp;&nbsp;'+
            '<label for="lattitude">Longitude :</label>'+
            '<input type="text" name="lon_degree" size="5"/>&#176;'+
            '<input type="text" name="lon_minute" size="5"/>&#39;'+
            '<input type="text" name="lon_second" size="5"/>&#34;'+
            '<select name="lon_point">'+
            '<option value="T">T</option>'+
            '<option value="B">B</option>'+
            '</select>';
        $('#latlon').append(latlon);
    }
    function circle(){
        $('#latlon').empty();
        $('#radius').empty();
        $('#polygon').empty();
        var latlon = '<label for="lattitude">Lattitude :</label>'+
            '<input type="text" name="lat_degree" size="5"/>&#176;'+
            '<input type="text" name="lat_minute" size="5"/>&#39;'+
            '<input type="text" name="lat_second" size="5"/>&#34;'+
            '<select name="lat_point">'+
            '<option value="U">U</option>'+
            '<option value="S">S</option>'+
            '</select>'+
            '&nbsp;&nbsp;&nbsp;'+
            '<label for="lattitude">Longitude :</label>'+
            '<input type="text" name="lon_degree" size="5"/>&#176;'+
            '<input type="text" name="lon_minute" size="5"/>&#39;'+
            '<input type="text" name="lon_second" size="5"/>&#34;'+
            '<select name="lon_point">'+
            '<option value="T">T</option>'+
            '<option value="B">B</option>'+
            '</select>';
        var radius = '<label for="radius">Rad :</label>'+
            '<input type="text" name="radius" size="10" />';
        $('#latlon').append(latlon);
        $('#radius').append(radius);
    }
    function polygon(){
        $('#latlon').empty();
        $('#radius').empty();
        $('#polygon').empty();
        $('#total_line_polygon').val('1');
        count_line = 2;
        var polygon = '<label for="lattitude">Lattitude :</label>'+
            '<input type="text" name="pol_lat_degree1" size="5"/>&#176;'+
            '<input type="text" name="pol_lat_minute1" size="5"/>&#39;'+
            '<input type="text" name="pol_lat_second1" size="5"/>&#34;'+
            '<select name="pol_lat_point1">'+
            '<option value="U">U</option>'+
            '<option value="S">S</option>'+
            '</select>'+
            '&nbsp;&nbsp;&nbsp;'+
            '<label for="lattitude">Longitude :</label>'+
            '<input type="text" name="pol_lon_degree1" size="5"/>&#176;'+
            '<input type="text" name="pol_lon_minute1" size="5"/>&#39;'+
            '<input type="text" name="pol_lon_second1" size="5"/>&#34;'+
            '<select name="pol_lon_point1">'+
            '<option value="T">T</option>'+
            '<option value="B">B</option>'+
            '</select>'+
            '<div id="add_more_line"></div>'+
            '<p class="right">'+
            '<a href="javascript:add_more_line();" class="buttons">&nbsp;&nbsp;+ add more&nbsp;&nbsp;</a>'+
            '&nbsp;&nbsp;'+
            '</p>';
        $('#polygon').append(polygon);
    }
    
    function emptyDiv(){
        $('#latlon').empty();
        $('#radius').empty();
        $('#polygon').empty();
    }
    
    $(document).ready(function() {
        $('#latlon').empty();
        $('#radius').empty();
        $('#polygon').empty();
        $('#aoitype').change(function() {
            var type = $(this).val();
            switch(type){
                case 'point': point();
                    break;
                case 'circle': circle();
                    break;
                case 'polygon': polygon();
                    break;
                case '': emptyDiv();
                    break;
            }
        });
        
        $('#search-form').submit(function(){
            var formAction = $("#aoitype").val();
            switch(formAction){
                case 'point': $("#search-form").attr("action", "<?php echo base_url() ?>map_service/poi/saveFormPOI");
                    break;
                case 'circle': $("#search-form").attr("action", "<?php echo base_url() ?>map_service/aoi_circle/saveFormCircle");
                    break;
                case 'polygon': $("#search-form").attr("action", "<?php echo base_url() ?>map_service/aoi/saveFormAOI");
                    break;
            }
        });
    });
</script>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <form id="search-form" action="<?php echo base_url() ?>/map_service" method="post">
            <fieldset>
                <label for="name_area">Nama Area :</label>
                <input type="text" name="name" /><br/>

                <label for="description_area">Deskripsi Area :</label>
                <textarea name="description"></textarea>

                <label for="category" style="margin-bottom: 2px;">Category :</label>
                <select name="category">
                    <?php foreach ($aoipoi_type as $row) { ?>
                        <option value="<?php echo $row->aptype_id ?>"><?php echo $row->aptype_name ?></option>
                    <?php } ?>
                </select><br/>

                <label for="type">Type :</label>
                <select id="aoitype" name="aoitype">
                    <option value="" selected >-Select Type-</option>
                    <option value="point">Point</option>
                    <option value="circle">Circle</option>
                    <option value="polygon">Polygon</option>
                </select>
                <br/>
                <!-- optional for circle/point -->
                <div id="latlon">
                    <label for="lattitude">Lattitude :</label>
                    <input type="text" name="lat_degree" size="5"/>&#176;
                    <input type="text" name="lat_minute" size="5"/>&#39;
                    <input type="text" name="lat_second" size="5"/>&#34;
                    <select name="lat_point">
                        <option value="U">U</option>
                        <option value="S">S</option>
                    </select>
                    &nbsp;&nbsp;&nbsp;
                    <label for="lattitude">Longitude :</label>
                    <input type="text" name="lon_degree" size="5"/>&#176;
                    <input type="text" name="lon_minute" size="5"/>&#39;
                    <input type="text" name="lon_second" size="5"/>&#34;
                    <select name="lon_point">
                        <option value="T">T</option>
                        <option value="B">B</option>
                    </select>
                </div>
                <br/>
                <!-- optional for Circle -->
                <div id="radius">
                    <label for="radius">Rad :</label>
                    <input type="text" name="radius" size="10" />
                </div>
                <br/>
                <!-- optional for polygon -->
                <div id="polygon">
                    <label for="lattitude">Lattitude :</label>
                    <input type="text" name="pol_lat_degree1" size="5"/>&#176;
                    <input type="text" name="pol_lat_minute1" size="5"/>&#39;
                    <input type="text" name="pol_lat_second1" size="5"/>&#34;
                    <select name="pol_lat_point1">
                        <option value="U">U</option>
                        <option value="S">S</option>
                    </select>
                    &nbsp;&nbsp;&nbsp;
                    <label for="lattitude">Longitude :</label>
                    <input type="text" name="pol_lon_degree1" size="5"/>&#176;
                    <input type="text" name="pol_lon_minute1" size="5"/>&#39;
                    <input type="text" name="pol_lon_second1" size="5"/>&#34;
                    <select name="pol_lon_point1">
                        <option value="T">T</option>
                        <option value="B">B</option>
                    </select>
                    <div id="add_more_line"></div>
                    <p class="right">
                        <a href="javascript:add_more_line();" class="buttons" />&nbsp;&nbsp;+ add more&nbsp;&nbsp;</a>
                        &nbsp;&nbsp;
                    </p>
                </div>
                <input type="hidden" id="total_line_polygon" name="total_line_polygon" value="1" />
                <input type="button" value="Cancel"/>
                <input type="submit" value="Create"/>
            </fieldset>
        </form>
    </body>
</html>
