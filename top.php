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

// SMARTY
require dirname(__FILE__) . '/includes/smarty.class.php';
$smarty = new smartyEngine();
$assets = array();
$template = 'top.html';

/*====================
  BEFORE ACTIONS
  ====================*/
// ログインチェック
// ログインしてなければ、ログインフォームにリダイレクト
if(!isset($_SESSION['login'],$_SESSION['token'])){
    header("Location: login.php");
    exit;
}


/*====================
  MAIN ACTIONS
  ====================*/

/*====================
  AFTER ACTIONS
  ====================*/

// SMARTY出力
$smarty->assign($assets);
$smarty->display($template);

// エンドスクリプト
require './includes/end.php';

/*====================
  FUNCTIONS
  ====================*/



