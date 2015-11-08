<?php
/**
 * Login Manager
 *
 * Configuration settings.
 *
 * @package     Login-Manager
 * @author      Y.Yajima <yajima@hatchbit.jp>
 * @copyright   2015, HatchBit & Co.
 * @license     http://www.hatchbit.jp/resource/license.html
 * @link        http://www.hatchbit.jp
 * @since       Version 1.0
 * @filesource
 */

/* DEBUG mode. */
if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '120.143.10.128'){
	define('DEBUG', true);
}else{
	define('DEBUG', false);
}

// コンフィグファイルを読み込み
$ini = parse_ini_file('config.ini',true);

/* COMMONS */
foreach($ini['commons'] as $key => $val){
    define($key, $val);
}
unset($key,$val);

/* DB CONNECTIONS */
/* https://mysql.kagoya.com/o3101-126/ */
define('DB_TYPE', $ini['database']['DB_TYPE']);
define('DB_PREFIX', $ini['database']['DB_PREFIX']);
define('DB_SERVER', $ini['database']['DB_SERVER']);
define('DB_SERVER_USERNAME', $ini['database']['DB_USERNAME']);
define('DB_SERVER_PASSWORD', $ini['database']['DB_PASSWORD']);
define('DB_DATABASE', $ini['database']['DB_DATABASE']);
define('USE_PCONNECT', $ini['database']['USE_PCONNECT']);
define('DB_DSN', 'mysql:dbname='.DB_DATABASE.';host='.DB_SERVER.';charset=ujis;');


define('SECURE_SALT', 'd93087a7cc1d1db16263b60387d458d9683d59ff');
?>