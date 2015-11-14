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
$template = 'manager/user-update.html';
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

// 対象のユーザー
if(isset($_GET['user_id'])){
    $user_id = intval($_GET['user_id']);
    $userInfo = $login->view("`id` = $user_id", "`id`", "0,1");
    $assets['user'] = $userInfo[0];
}

// 更新処理
if(isset($_POST['mode']) && $_POST['mode'] == 'update'){
    $login_id = intval($_POST['user_id']);
    $tableData = array();
    if(!empty($_POST['username'])){
        $username = trim($_POST['username']);
        $tableData[] = array('fieldName'=>'username','value'=>$username,'type'=>'string');
    }
    if(!empty($_POST['password'])){
        $password = hashconv($_POST['password']);
        $tableData[] = array('fieldName'=>'password','value'=>$password,'type'=>'string');
    }
    if(!empty($_POST['status'])){
        $status = intval($_POST['status']);
        $tableData[] = array('fieldName'=>'status','value'=>$status,'type'=>'integer');
    }
    $login->update($tableData, $login_id);
    $msg[] = array('value'=>'更新しました', 'style'=>'success');
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



