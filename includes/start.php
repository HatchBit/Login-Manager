<?php
// 単純な実行時エラーを表示する
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
// E_NOTICE を表示させるのもおすすめ（初期化されていない
// 変数、変数名のスペルミスなど…）
// error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
// E_NOTICE 以外の全てのエラーを表示する
// これは php.ini で設定されているデフォルト値
// error_reporting(E_ALL ^ E_NOTICE);

if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '120.143.10.128'){
    // 全ての PHP エラーを表示する (Changelog を参照ください)
    error_reporting(E_ALL);
}elseif(DEBUG == true){
    error_reporting(E_ALL);
}else{
    // 全てのエラー出力をオフにする
    error_reporting(0);
}
// 全ての PHP エラーを表示する
// error_reporting(-1);
// error_reporting(E_ALL);// と同じ
// ini_set('error_reporting', E_ALL);
if(!isset($_SESSION)){
    session_name("sitecatcher");
    session_start();
}
//header("P3P: CP='UNI CUR OUR'");
$startNowTime = microtime(true);
$timeWraps = array();
ini_set('default_mimetype', 'text/html');
ini_set('default_charset', 'UTF-8');
ini_set("auto_detect_line_endings", true);
mb_language('Japanese');
mb_internal_encoding('UTF-8');
//mb_http_input('pass');
//mb_http_output('UTF-8');

require(dirname(__FILE__) . '/config.php');
require(dirname(__FILE__) . '/classes/mysql.class.php');
require(dirname(__FILE__) . '/functions.php');

$db = new dbEngine(DB_DSN, DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);

//// 初期設定ロード
//require(dirname(__FILE__) . '/classes/config.php');
//$conf = new confEngine();
//$conf->load();

$youbiArr = array(0=>"日",1=>"月",2=>"火",3=>"水",4=>"木",5=>"金",6=>"土");

require dirname(__FILE__).'/classes/config.class.php';
//require dirname(__FILE__) . '/classes/config.php';
$configs = new confEngine($db);
$__cnf = array();
$__cnf = $configs->view();


// Smarty
if(defined('SMARTY_DIR')) require SMARTY_DIR.'/Smarty.class.php';

