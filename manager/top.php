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
$template = 'manager/top.html';

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

// ユーザー一覧
$perpage = PAGEMAX;
$filter = "1 = 1";

$allUserCounts = $login->countnum($filter);
$pageall = ceil($allUserCounts / $perpage);
$page_current = 0;
if(isset($_GET['p'])){
    $page_current = intval($_GET['p']) - 1;
}
$pages = paginate($pageall, $page_current = 0);
$assets['pages'] = $pages;

$orderby = "`id` DESC";
$limit = $page_current.", ".$perpage;
$users = $login->view($filter, $orderby, $limit);
foreach($users as &$u){
    switch($u['status']){
        case '9':
        $u['statusstr'] = '管理';
        break;
        case '1':
        $u['statusstr'] = '通常';
        break;
        case '0':
        default:
        $u['statusstr'] = '停止';
        break;
    }
}
unset($u);
$assets['users'] = $users;

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



