<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Lapsithar</title>

        <!-- CSS -->
        <link href="<?php echo base_url() ?>assets/html/css/transdmin.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo base_url() ?>assets/html/css/ui.css" rel="stylesheet" type="text/css" />
        <!--[if IE 6]><link rel="stylesheet" type="text/css" media="screen" href="style/css/ie6.css" /><![endif]-->
        <!--[if IE 7]><link rel="stylesheet" type="text/css" media="screen" href="style/css/ie7.css" /><![endif]-->
        <style>
            
        </style>

        <!-- JavaScripts-->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/tiny_mce.js"></script>
<!--    <script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/jNice.js"></script>-->
        <script type="text/javascript">
            tinyMCE.init({
		mode : "textareas",
		theme : "simple"
            });
        </script>
    </head>
    <body>
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
                                <p><label>Judul:</label><input type="text" class="text-long" /></p>
                                <p>
                                    <label>Posisi:</label>
                                    <div style="float: left; margin: -10px 20px 0 20px;"><label>Lat</label><input type="text" /></div>
                                    <div style="float: left; margin: -10px 20px 0 20px;"><label>Long</label><input type="text" /></div>
                                </p>
                                <p><label>Tipe Pelanggaran:</label>
                                    <select class="text-long">
                                        <option>123</option>
                                    </select>
                                </p>
                                <p>
                                    <textarea id="elm1" name="elm1" style="width: 30%">
                                        &lt;p&gt;
                                                This is some example text that you can edit inside the &lt;strong&gt;TinyMCE editor&lt;/strong&gt;.
                                        &lt;/p&gt;
                                        &lt;p&gt;
                                        Nam nisi elit, cursus in rhoncus sit amet, pulvinar laoreet leo. Nam sed lectus quam, ut sagittis tellus. Quisque dignissim mauris a augue rutrum tempor. Donec vitae purus nec massa vestibulum ornare sit amet id tellus. Nunc quam mauris, fermentum nec lacinia eget, sollicitudin nec ante. Aliquam molestie volutpat dapibus. Nunc interdum viverra sodales. Morbi laoreet pulvinar gravida. Quisque ut turpis sagittis nunc accumsan vehicula. Duis elementum congue ultrices. Cras faucibus feugiat arcu quis lacinia. In hac habitasse platea dictumst. Pellentesque fermentum magna sit amet tellus varius ullamcorper. Vestibulum at urna augue, eget varius neque. Fusce facilisis venenatis dapibus. Integer non sem at arcu euismod tempor nec sed nisl. Morbi ultricies, mauris ut ultricies adipiscing, felis odio condimentum massa, et luctus est nunc nec eros.
                                        &lt;/p&gt;
                                    </textarea>
                                </p>
                                <div class="clear"></div>
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