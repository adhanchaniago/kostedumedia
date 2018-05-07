<?php
/**
 * @author Wira Sakti G
 * @added Mar 20, 2013
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    <head>
        <title>Puskodal Side Menu</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

            <link rel="stylesheet" href="<?php echo base_url() ?>aset/font-awesome.min.css" />
    
            <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/html/css/reset.css" />
            <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/redmond/jquery-ui-1.10.2.custom.css" />
            <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/html/css/back-end.puskodal.css" />
            <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.timepicker.css" />
            <link rel="shortcut icon" href="<?php echo base_url() ?>favicon.ico" type="image/x-icon">

            <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.9.1.min.js"></script>
            <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui-1.10.2.js"></script>
            <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
            <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.timepicker.min.js"></script>
            <script type="text/javascript">
                var baseUrl = '<?php echo base_url() ?>';
            </script>
            <script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/back-end.puskodal.js"></script>

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

    </head>
