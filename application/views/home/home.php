<!DOCTYPE html>
<html>
    <head>
        <title>Puskodal</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!--        <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>assets/css/960.css" />-->
        <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>assets/css/reset.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>assets/css/login.puskodal.css" />

        <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.animate-shadow-min.js"></script>
        <script type="text/javascript">
            $(window).load(function(){
                $('#logo-splash img').css('opacity', '0');
                $('.lining#line-1').animate({
                    opacity: 0,
                    marginLeft: 900
                }, 2000);
                $('.lining#line-2').delay(75).animate({
                    opacity: 0,
                    marginLeft: 900
                }, 2000);
                $('.lining#line-3').delay(150).animate({
                    opacity: 0,
                    marginLeft: 900
                }, 2000);
                $('.lining#line-4').animate({
                    opacity: 0,
                    marginRight: 900
                }, 2000);
                $('.lining#line-5').delay(75).animate({
                    opacity: 0,
                    marginRight: 900
                }, 2000);
                $('.lining#line-6').delay(150).animate({
                    opacity: 0,
                    marginRight: 900
                }, 2000);
                $('body#splash-screen').animate({
                    boxShadow: "inset 0 0 0 #CCC"
                }, 2000);
                $('#logo-splash img').delay(1200).animate({
                    opacity: 1,
                    height: 122,
                    width: 396
                    }, 1500, function(){
                    $(this).delay(1000).fadeOut(500);
                    setTimeout('foo()',1100);
                });
            });
            
            function foo(){
                document.location='<?php echo base_url() ?>map';
            }
        </script>
    </head>
    <body id="splash-screen">
        <div class="lining" id="line-1"></div>
        <div class="lining" id="line-2"></div>
        <div class="lining" id="line-3"></div>
        <div class="lining" id="line-4"></div>
        <div class="lining" id="line-5"></div>
        <div class="lining" id="line-6"></div>
        <div id="logo-splash">
        	<img src="assets/img/logo-puskodal-big.png" />
        </div>
    </body>
</html>