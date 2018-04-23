<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/*puskodal app specific constant*/
define('MARINES_RANPURMAR_CODE' , '1');
define('MARINES_SATPURMAR_CODE' , '2');

define('SHIP_SURFACE_CODE', '2');
define('SHIP_SUBMARINE_CODE', '1');

define('CTX_SHIP_CODE' , '1');
define('CTX_MARINES_CODE' , '3');
define('CTX_STATION_CODE' , '4');
define('CTX_AEROPLANE_CODE' , '2');

define('OLD_COMMANDO_MABESAL' , 3);
define('COMMANDO_MABESAL' , 27);
define('COMMANDO_KOLINLAMIL' , 4);
define('COMMANDO_ARMABAR' , 1);
define('COMMANDO_ARMATIM' , 2);

define('STATIONCODE_LANUDAL' , 4);
/*sessions*/
define('SESSION_USERGROUP', 'user_group');
define('SESSION_USERMSGID', 'user_msg_id'); // added by SKM17
/* End of file constants.php */
/* Location: ./application/config/constants.php */
