<?php
/**
 * Login Manager
 *
 * Top page.
 *
 * @package     Login-Manager
 * @author      Y.Yajima <yajima@hatchbit.jp>
 * @copyright   2014, HatchBit & Co.
 * @license     http://www.hatchbit.jp/resource/license.html
 * @link        http://www.hatchbit.jp
 * @since       Version 1.0
 * @filesource
 */

/*====================
  DEFINE
  ====================*/

if(isset($_GET['php']) && $_GET['php'] == "info"){
	phpinfo(); exit();
}

// スタートスクリプト
require './includes/start.php';

// 必要モジュールを読み込み
require './includes/login.class.php';
$login = new loginEngine($db);

/*====================
  BEFORE ACTIONS
  ====================*/

/*====================
  MAIN ACTIONS
  ====================*/

$user_id = $login->token2userid($_GET['token']);
echo $user_id;
exit();

/*====================
  AFTER ACTIONS
  ====================*/

/*====================
  FUNCTIONS
  ====================*/



