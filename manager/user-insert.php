<?php
/**
 * Login Manager
 *
 * Manager top page.
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
require dirname(dirname(__FILE__)) . '/includes/start.php';

// 必要モジュールを読み込み
require dirname(dirname(__FILE__)) . '/includes/login.class.php';
$login = new loginEngine($db);

// SMARTY
require dirname(dirname(__FILE__)) . '/includes/smarty.class.php';
$smarty = new smartyEngine();
$assets = array();
$template = 'manager/user-insert.html';
$msg = array();

/*====================
  BEFORE ACTIONS
  ====================*/
// ログインチェック
if(!isset($_SESSION['login'],$_SESSION['token'])){
    header("Location: login.php");
    exit;
}

/*====================
  MAIN ACTIONS
  ====================*/

// 登録処理
if(isset($_POST['mode']) && $_POST['mode'] == 'insert'){
    if(!empty($_POST['username'])){
        $username = trim($_POST['username']);
    }
    if(!empty($_POST['password'])){
        $password = hashconv($_POST['password']);
    }
    if(!empty($_POST['status'])){
        $status = intval($_POST['status']);
    }
    $login->add($username, $password, $status);
    $msg[] = array('value'=>'登録しました', 'style'=>'success');
}

$assets['msg'] = $msg;

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



