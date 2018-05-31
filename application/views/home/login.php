<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
        'placeholder' => 'Username or Email',
        'class' => 'put-login',
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or Username';
} else if ($login_by_username) {
	$login_label = 'Username';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
        'placeholder' => 'Password',
        'class' => 'put-login',
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
?>
<html>
    <head>
        <title>Kost Edumedia - Login</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/css/960.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/css/reset.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/css/login.puskodal.css" />
        <link rel="shortcut icon" href="<?php echo base_url() ?>favicon.ico" type="image/x-icon">
    </head>
    <body>
        <div class="container_12">
            <div class="grid_12">
                <div id="logo">
                    <!-- <img src="<?php echo base_url() ?>assets/img/logo-new-lite.png" /> -->
                    <img src="<?php echo base_url() ?>aset/img/1.png" width="226" height="226" />
                </div>
                <div id="login">
                    <?php echo form_open($this->uri->uri_string()); ?>
                    <div id="title">
                        Login Kost Edumedia
                    </div>
                    <ul style="width: 312px;">
                        <li>
                            <label>Username</label><br />
                            <input type="text" placeholder="Nama Pengguna" class="put-login" name="login" id="login" value="<?php echo set_value('login')?>" maxlength="80" />
                        </li>
                        <li>
                            <label>Password</label><br />
                            <input type="password" placeholder="Kata Kunci" class="put-login" name="password" id="password" />
                        </li>
			<?php
				if ($show_captcha) {
					if ($use_recaptcha) { ?>
						<tr>
							<td colspan="2">
								<div id="recaptcha_image"></div>
							</td>
							<td>
								<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
								<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
								<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="recaptcha_only_if_image">Enter the words above</div>
								<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
							</td>
							<td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
							<td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
							<?php echo $captcha_html; ?>							
						</tr>
					
					<?php } else { ?>
							<li>
							    <label>Enter the code exactly as it appears:</label><br />
							    <?php echo $captcha_html; ?>							    
							</li>
							<li>
							    <label><?php echo form_label('Confirmation Code', $captcha['id']); ?></label>
							    <td><?php echo form_input($captcha); ?></td>
							    </br><label><td style="color: red;"><?php echo form_error($captcha['name']); ?></td></label>
							</li>
						<?php }
				}
			?>
                        <li>
                            <input type="submit" id="button-submit">
                            <div class="clear"></div>
                        </li>
                    </ul>
                    <div class="clear"></div>
                    <?php echo form_close(); ?>
                </div>
                <p id="footer">
                    Copyrights &copy; 2018 <a target="_blank" href="https://www.youtube.com/c/resilientonamission"><strong>Gopal & Sesdika</strong></a>. All Rights Reserved.
                </p>
            </div>
            <div class="clear"></div>
        </div>
    </body>
</html>
