<?php
/**
 * Login Manager
 *
 * Manager Login page.
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
$template = 'manager/login.html';

/*====================
  BEFORE ACTIONS
  ====================*/
// リダイレクトURI
if(!empty($_GET['return_uri'])){
    $assets['return_uri'] = $_GET['return_uri'];
}

/*====================
  MAIN ACTIONS
  ====================*/
// ログアウト処理
if(isset($_GET['logout']) && $_GET['logout'] == 'logout'){
    $_SESSION = array();
    if(!empty($_GET['return_uri'])){
        header('Location: '.$_GET['return_uri']);
        exit;
    }else{
        header('Location: login.php');
        exit;
    }
}

// ログイン処理
if(isset($_POST['mode'])){
    if($_POST['mode'] == 'login'){
        $_username = strval($_POST['username']);
        $_password = strval($_POST['password']);
        $_hashedPassword = hashconv($_password, false, SECURE_SALT);
        $loginValue = $login->managerlogin($_username, $_hashedPassword);
        $assets['result'] = $loginValue;
        
        if($loginValue > 0){
            $_SESSION['login'] = 'ok';
            $_SESSION['managerlogin'] = 1;
            header('Location: top.php');
            exit;
        }else{
            $assets['msg'] = 'ユーザー名かパスワードが間違っています';
        }
    }
}else{
    $_SESSION = array();
}

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



