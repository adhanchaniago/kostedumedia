<?php
//$login = array(
//	'name'	=> 'login',
//	'id'	=> 'login',
//	'value' => set_value('login'),
//	'maxlength'	=> 80,
//	'size'	=> 30,
//        'placeholder' => 'Username or Email',
//        'class' => 'put-login',
//);
//if ($login_by_username AND $login_by_email) {
//	$login_label = 'Email or Username';
//} else if ($login_by_username) {
//	$login_label = 'Username';
//} else {
//	$login_label = 'Email';
//}
//$password = array(
//	'name'	=> 'password',
//	'id'	=> 'password',
//	'size'	=> 30,
//        'placeholder' => 'Password',
//        'class' => 'put-login',
//);
//$remember = array(
//	'name'	=> 'remember',
//	'id'	=> 'remember',
//	'value'	=> 1,
//	'checked'	=> set_value('remember'),
//	'style' => 'margin:0;padding:0',
//);
//$captcha = array(
//	'name'	=> 'captcha',
//	'id'	=> 'captcha',
//	'maxlength'	=> 8,
//);
?>
<?php echo form_open($this->uri->uri_string()); ?>
<html>
    <head>
        <title>Puskodal</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/css/960.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/css/reset.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/css/login.puskodal.css" />
    </head>
    <body>
        <div class="container_12">
            <div class="grid_12">
                <div id="logo">
                    <img src="<?php echo base_url() ?>assets/img/logo-puskodal.png" />
                </div>
                <div id="login">
                    <div id="title">
                        Login
                    </div>
                    <ul>
                        <li>
                            <label>Username or Email</label><br />
                            <input type="text" placeholder="Nama Pengguna" class="put-login" name="login" id="login" value="<?php echo set_value('login')?>" maxlength="80" />
                        </li>
                        <li>
                            <label>Password</label><br />
                            <input type="password" placeholder="Kata Kunci" class="put-login" name="password" id="password" />
                        </li>
                        <li>
                            <input type="submit" id="button-submit">
                            <div class="clear"></div>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <p id="footer">
                    Copyrights &copy; 2015 <strong>PUSKODAL</strong>. All Rights Reserved.
                </p>
            </div>
            <div class="clear"></div>
        </div>
    </body>
</html>