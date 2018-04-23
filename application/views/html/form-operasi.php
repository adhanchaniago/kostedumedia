<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Transdmin Light</title>

        <!-- CSS -->
        <link href="<?php echo base_url() ?>assets/html/css/transdmin.css" rel="stylesheet" type="text/css" media="screen" />
        <!--[if IE 6]><link rel="stylesheet" type="text/css" media="screen" href="style/css/ie6.css" /><![endif]-->
        <!--[if IE 7]><link rel="stylesheet" type="text/css" media="screen" href="style/css/ie7.css" /><![endif]-->
        <style>
            #backlight{
                margin: -15px 0 0 0;
                position: absolute;
                cursor: pointer;
                width: 100%;
                background: rgba(0, 0, 0, 0.5);
            }
            
            #spotting-holder{
                width: 700px;
                left: 50%;
                margin: 20px 0 0 -355px;
                background: #eee;
                position: fixed;
                z-index: 999;
                padding: 5px;
            }
            
            #spotting-content{
                background: #fff;
                border: 1px solid #ddd;
            }
            
            #title-pop{
                background: #F9F9F9;
                border-bottom: 1px solid #DDD;
            }
            
            #title-pop ul{
                padding: 5px;
            }
            
            #title-pop ul li{
                text-align: left;
                padding: 3px 5px;
                text-shadow: 0 1px 1px #FFF;
            }
            
            #title-pop ul li p{
                font-size: 18px;
            }
            
            #title-pop ul li label{
                float: left;
                width: 100px;
                font-size: 11px;
                font-weight: bold;
            }
            
            .list-data{
                width: 332px;
                border: 1px solid #DDD;
                margin: 10px 0 10px 10px;
                float: left;
            }
            
            .list-data .scrolling{
                max-height: 480px;
                overflow-y: scroll;
            }
            
            .list-data .scrolling::-webkit-scrollbar{ 
                display: block; 
                width: 14px;
                height: 15px;
            }

            .list-data .scrolling::-webkit-scrollbar-track-piece{
                background-color: #FFF;
                border-left: 1px solid #DDD;
                box-shadow: inset 0 0 5px #DDD;
            }

            .list-data .scrolling::-webkit-scrollbar-thumb:vertical{
                background-color: #CCC;
                width: 10px;
                height: 10px;
            }
            
            .list-data .scrolling::-webkit-scrollbar-thumb:vertical:hover{
                background-color: #999;
            }
            
            .list-data a{
                background: #EEE;
                color: #999;
                padding: 10px;
                font-weight: bold;
                text-decoration: none;
                text-align: left;
                display: block;
                border-bottom: 1px solid #CCC;
                transition: all 300ms ease-in-out;
                -o-transition: all 300ms ease-in-out;
                -ms-transition: all 300ms ease-in-out;
                -moz-transition: all 300ms ease-in-out;
                -webkit-transition: all 300ms ease-in-out;
            }
            
            .list-data a#add-all,
            .list-data a#remove-all{
                position: absolute;
                padding: 2px 3px 3px 3px;
                border: 1px solid #CCC;
                margin: -3px 0 0 238px;
                font-size: 10px;
            }
            
            .list-data a img{
                float: right;
                margin: -4px 0 0 0;
            }
            
            .list-data a:hover{
                color: #666;
                background: #F9F9F9;
            }
            
            .list-data p{
                padding: 7px 0;
                color: #999;
                font-size: 11px;
            }
            
            .list-data p.datkos{
                font-size: 14px;
                font-weight: bold;
                border-bottom: 1px solid #DDD;
            }
            
            .search-list{
                border: none;
                height: 32px;
                width: 316px;
                padding: 0 8px;
                font-size: 14px;
                border-bottom: 1px solid #CCC;
            }
        </style>

        <!-- JavaScripts-->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.9.1.min.js"></script>
<!--    <script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/jNice.js"></script>-->
        <script type="text/javascript">
            $(document).ready(function(){
                var baseUrl = '<?php echo base_url() ?>';
                var htmlHeight = $('html').height();
//                alert(htmlHeight);
                
                $('a.edit').click(function(e){
                    e.preventDefault();
                    
                    $('#backlight').height(htmlHeight);
                    $('#backlight').fadeIn('fast', function(){
                        $('#spotting-holder').fadeIn('fast');
                    });
                });
                
                $('#backlight').click(function(e){
                    e.preventDefault();
                    
                    $('#spotting-holder').fadeOut('fast', function(){
                        $('#backlight').fadeOut('fast');
                    });
                });
                
                $('.list-data').delegate('a:not(#add-all, #remove-all)', 'click', function(e){
                    e.preventDefault();
                    
                    var banyakA = $(this).parent().find('a').length;
                    var isiHtml = $(this).find('span').text();
                    var idSide = $(this).parent().parent().attr('id');
                    
                    $(this).slideUp('fast', function(){
                        $(this).remove();
                        
                        if(idSide == 'lefting'){
                            if($('.list-data#righting p.datkos').is(':visible')){
                                $('.list-data#righting p.datkos').slideUp('fast', function(){
                                    $('p#first-righting').parent().find('.scrolling').prepend('<a href="#"><img src="' + baseUrl + 'assets/html/img/back-end/cancel.png" /><span>' + isiHtml + '</span></a>');
                                });
                            }else{
                                $('p#first-righting').parent().find('.scrolling').prepend('<a href="#"><img src="' + baseUrl + 'assets/html/img/back-end/cancel.png" /><span>' + isiHtml + '</span></a>');
                            }
                            
                            if($('a#remove-all').not(':visible')){
                                $('a#remove-all').fadeIn('fast');
                            }
                        }else{
                            if($('.list-data#lefting p.datkos').is(':visible')){
                                $('.list-data#lefting p.datkos').slideUp('fast', function(){
                                    $('p#first-lefting').parent().find('.scrolling').prepend('<a href="#"><img src="' + baseUrl + 'assets/html/img/back-end/arrow-right.png" /><span>' + isiHtml + '</span></a>');
                                });
                            }else{
                                $('p#first-lefting').parent().find('.scrolling').prepend('<a href="#"><img src="' + baseUrl + 'assets/html/img/back-end/arrow-right.png" /><span>' + isiHtml + '</span></a>');
                            }
                            
                            if($('a#add-all').not(':visible')){
                                $('a#add-all').fadeIn('fast');
                            }
                        }
                    });
                    
                    if(banyakA == 1){
                        $(this).parent().parent().find('p.datkos').slideDown();
                        
                        if(idSide == 'lefting'){
                            $('a#add-all').fadeOut('fast');
                        }else{
                            $('a#remove-all').fadeOut('fast');
                        }
                    }
                });
                
                $('a#add-all').click(function(e){
                    e.preventDefault();
                    
                    $(this).parent().parent().find('.scrolling a span').each(function(){

                        var isiHtml = $(this).text();
                        
                        $(this).parent().slideUp('fast', function(){
                            $(this).remove();
                            $('p#first-righting').parent().find('.scrolling').prepend('<a href="#"><img src="' + baseUrl + 'assets/html/img/back-end/cancel.png" /><span>' + isiHtml + '</span></a>');
                        });
                    });
                    
                    if($('.list-data#righting p.datkos').is(':visible')){
                        $('.list-data#righting p.datkos').slideUp('fast');
                    }
                    
                    if($('a#remove-all').not(':visible')){
                        $('a#remove-all').fadeIn('fast');
                    }
                    
                    $(this).fadeOut('fast', function(){
                        $(this).parent().parent().find('p.datkos').slideDown('fast');
                    });
                    
                });
                
                $('a#remove-all').click(function(e){
                    e.preventDefault();
                    
                    $(this).parent().parent().find('.scrolling a span').each(function(){

                        var isiHtml = $(this).text();
                        
                        $(this).parent().slideUp('fast', function(){
                            $(this).remove();
                            $('p#first-lefting').parent().find('.scrolling').prepend('<a href="#"><img src="' + baseUrl + 'assets/html/img/back-end/arrow-right.png" /><span>' + isiHtml + '</span></a>');
                        });
                    });
                    
                    if($('.list-data#lefting p.datkos').is(':visible')){
                        $('.list-data#lefting p.datkos').slideUp('fast');
                    }
                    
                    if($('a#add-all').not(':visible')){
                        $('a#add-all').fadeIn('fast');
                    }
                    
                    $(this).fadeOut('fast', function(){
                        $(this).parent().parent().find('p.datkos').slideDown('fast');
                    });
                });
            });
        </script>
    </head>

    <body>
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
                    <p style="border-bottom: 1px solid #DDD;" id="first-righting"><a href="#" id="remove-all" style="margin-left: 252px;">Hapus Semua</a>List armada yang sudah masuk</p>
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
        <div id="wrapper">
            <!-- h1 tag stays for the logo, you can use the a tag for linking the index page -->
            <h1><a href="#"><span>Transdmin Light</span></a></h1>

            <!-- You can name the links with lowercase, they will be transformed to uppercase by CSS, we prefered to name them with uppercase to have the same effect with disabled stylesheet -->
            <ul id="mainNav">
                <li><a href="#" class="active">DASHBOARD</a></li> <!-- Use the "active" class for the active menu item  -->
                <li><a href="#">ADMINISTRATION</a></li>
                <li><a href="#">DESIGN</a></li>
                <li><a href="#">OPTION</a></li>
                <li class="logout"><a href="#">LOGOUT</a></li>
            </ul>
            <!-- // #end mainNav -->

            <div id="containerHolder">
                <div id="container">
                    <div id="sidebar">
                        <ul class="sideNav">
                            <li><a href="#">Exchange</a></li>
                            <li><a href="#" class="active">Print resources</a></li>
                            <li><a href="#">Training &amp; Support</a></li>
                            <li><a href="#">Books</a></li>
                            <li><a href="#">Safari books online</a></li>
                            <li><a href="#">Events</a></li>
                        </ul>
                        <!-- // .sideNav -->
                    </div>    
                    <!-- // #sidebar -->

                    <!-- h2 stays for breadcrumbs -->
                    <h2><a href="#">Dashboard</a> &raquo; <a href="#" class="active">Print resources</a></h2>

                    <div id="main">
                        <form action="" class="jNice">
                            <h3>Another section</h3>
                            <fieldset>
                                <p><label>Nama Ops:</label><input type="text" class="text-long" /></p>
                                <p><label>Desc Ops:</label><textarea rows="1" cols="1"></textarea></p>
                                <p>
                                    <label>Waktu Ops:</label><label><input type="checkbox" /> Tidak Ditentukan</label>
                                    <div style="float: left; margin: -10px 20px 0 20px;"><label>Waktu Mulai</label><input type="text" /></div>
                                    <div style="float: left; margin: -10px 20px 0 20px;"><label>Waktu Akhir</label><input type="text" /></div>
                                </p>
                                <div class="clear"></div>
                                <p style="margin-bottom: 0;"><label>unsur:</label></p>
                                <table cellpadding="0" cellspacing="0" style="width: 660px; margin-bottom: 20px;">
                                    <tr>
                                        <td><strong style="width: 70px; float: left;">KRI</strong>: X Unit</td>
                                        <td class="action"><a href="#" class="edit">Edit</a><a href="#" class="delete">Hapus</a></td>
                                    </tr>                        
                                    <tr class="odd">
                                        <td><strong style="width: 70px; float: left;">Marinir</strong>: Y Unit</td>
                                        <td class="action"><a href="#" class="edit">Edit</a><a href="#" class="delete">Hapus</a></td>
                                    </tr>                        
                                    <tr>
                                        <td><strong style="width: 70px; float: left;">Pesud</strong>: Z Unit</td>
                                        <td class="action"><a href="#" class="edit">Edit</a><a href="#" class="delete">Hapus</a></td>
                                    </tr>                        
                                    <tr class="odd">
                                        <td><strong style="width: 70px; float: left;">Ranpur</strong>: M Unit</td>
                                        <td class="action"><a href="#" class="edit">Edit</a><a href="#" class="delete">Hapus</a></td>
                                    </tr>                        
                                    <tr>
                                        <td><strong style="width: 70px; float: left;">Marinir</strong>: N Unit</td>
                                        <td class="action"><a href="#" class="edit">Edit</a><a href="#" class="delete">Hapus</a></td>
                                    </tr>                        
                                </table>
                                <input type="submit" value="Submit Query" />
                            </fieldset>
                        </form>
                    </div>
                    <!-- // #main -->

                    <div class="clear"></div>
                </div>
                <!-- // #container -->
            </div>	
            <!-- // #containerHolder -->

            <p id="footer">Feel free to use and customize it. <a href="http://www.perspectived.com">Credit is appreciated.</a></p>
        </div>
        <!-- // #wrapper -->
    </body>
</html>