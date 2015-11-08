<?php
/**
 * Login Manager
 *
 * 関数ファイル
 *
 * @package     Login-Manager
 * @author      Y.Yajima <yajima@hatchbit.jp>
 * @copyright   2015, HatchBit & Co.
 * @license     http://www.hatchbit.jp/resource/license.html
 * @link        http://www.hatchbit.jp
 * @since       Version 1.0
 * @filesource
 */

// PHP: 多次元配列でarray_searchを使えるようにする関数
// http://qiita.com/yorksyo/items/4b0cbec7dcaec86907ab
function array_search_recursive($search_element, $array)
{
    $recursive_func = function ($search_element, $array) use (&$recursive_func) {
        foreach ($array as $key => $value) {
            if(is_array($value)){
                if($recursive_func($search_element, $value) !== false) return $key;
            }
            if ($search_element == $value) return $key;
        }
        return false;
    };
    return $recursive_func($search_element, $array);
}

function strtotime_nengetsu($str){
    $result = 0;
    $str = str_replace("年","/",$str);
    $str = str_replace("月","/",$str);
    $str = str_replace("日","",$str);
    $strArr = explode("/",$str);
    if(isset($strArr[0]) || $strArr[0] !== 0){
        $year = intval($strArr[0]);
    }else{
        $year = date("Y");
    }
    if(isset($strArr[1])){
        $month = intval($strArr[1]);
    }else{
        $month = date("n");
    }
    if(isset($strArr[2]) && intval($strArr[2]) > 0){
        $date = intval($strArr[2]);
    }else{
        $month += 1;
        $date = 0;
    }
    $result = mktime(0,0,0,$month,$date,$year);
    return $result;
}

function genPass($len = 8){
    return substr(str_shuffle('abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, $len);
}

function shortstr($str = '', $num = 4, $format = '<span style="font-size:80%;">[+str+]</span>'){
    if(mb_strlen($str,'UTF-8') > $num){
        return str_replace('[+str+]', $str, $format);
    }else{
        return $str;
    }
}

function kakunin(){
    $return = array();
    $remote_ip = (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != "") ? $_SERVER['REMOTE_ADDR'] : "";//gethostbyaddr($remote_ip);
    $remote_host = (isset($_SERVER['REMOTE_HOST']) && $_SERVER['REMOTE_HOST'] != "") ? $_SERVER['REMOTE_HOST'] : "";//gethostbyaddr($remote_ip);
    $return['remote_ip'] = $remote_ip;
    $return['remote_host'] = $remote_host;
    if($remote_ip == $remote_host){
        $return['remote_name'] = $remote_ip;
    }else{
        $return['remote_name'] = $remote_host.' ['.$remote_ip.']';
    }
    return $return;
}

/**
 * 文字列（住所）から緯度・軽度を取得
 * http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?appid=dj0zaiZpPWYzVVZXR3dIYzQwUCZzPWNvbnN1bWVyc2VjcmV0Jng9MGE-&query=%E6%9C%AD%E5%B9%8C%E5%B8%82%E7%99%BD%E7%9F%B3%E5%8C%BA%E8%8F%8A%E6%B0%B42%E6%9D%A13%E4%B8%81%E7%9B%AE1-21&ei=UTF-8&output=json
 */
function strtogeo($str,$mode = 0){
    $str = urlencode($str);
    $latlng = array();
    //$url = "http://maps.google.com/maps/api/geocode/json?address='".$str."'&sensor=false";
    $url = "http://maps.googleapis.com/maps/api/geocode/json?address='".$str."'&sensor=false&region=ja";
    //$url = "http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?appid=".YAHOO_APPID."&query=".$str."&ei=UTF-8&output=json";
    // レスポンスを取得
    $res = file_get_contents($url);
    // JSON形式から連想配列へ変換
    $res_array = json_decode($res, TRUE);
    //var_dump($res_array);//exit();
    if(isset($res_array['status']) && $res_array['status'] == 'OK'){
        //x座標とy座標を配列に格納
        $latlng['lat'] = $res_array['results']['0']['geometry']['location']['lat'];
        $latlng['lng'] = $res_array['results']['0']['geometry']['location']['lng'];
        $latlng['json'] = $res;
        return $latlng;
    }elseif(isset($res_array['ResultInfo']) && $res_array['ResultInfo']['Status'] == 200){
        //x座標とy座標を配列に格納
        $latlngArr = explode(",", $res_array['Feature'][0]['Geometry']['Coordinates'], 2);
        $latlng['lat'] = $latlngArr[1];
        $latlng['lng'] = $latlngArr[0];
        $latlng['json'] = $res;
        return $latlng;
    }else{
        switch($mode){
            case 1:
                return $res_array;
                break;
            case 0:
            default:
                return false;
                break;
        }
    }
}

/**
 * フォームから来たデータをエンコードする
 * @param array $post フォームから来たデータ
 */
function FormEncode(&$post){
    if(!isset($post['enc'])){
        return;
    }
    //どのエンコーディングか判定
    $enc = mb_detect_encoding($post['enc']);
    $default_enc = "UTF-8";
    foreach($post as &$value) {
        EncodeCore($value,$default_enc,$enc);
    }
    unset($value);
}
/**
* エンコードのコア部分
* @param unknown_type $value
* @param string $default_enc
* @param string $enc
*/
function EncodeCore(&$value, $default_enc, $enc){
    if(is_array($value)){
        //配列の場合は再帰処理
        foreach ($value as &$value2) {
            EncodeCore($value2, $default_enc, $enc);    
        }
    }elseif($enc != $default_enc){
        //文字コード変換
        $value = mb_convert_encoding($value, $default_enc, $enc) ;
    }
}

/**
 * ファイルポインタから行を取得し、CSVフィールドを処理する
 * @param resource handle
 * @param int length
 * @param string delimiter
 * @param string enclosure
 * @return ファイルの終端に達した場合を含み、エラー時にFALSEを返します。
 */
function fgetcsv_reg (&$handle, $length = NULL, $d = ',', $e = '"', $fromenc = '') {
    $d = preg_quote($d);
    $e = preg_quote($e);
    $_line = "";
    $eof = false;
    while (($eof != true)and(!feof($handle))) {
        $ln = (empty($length) ? fgets($handle) : fgets($handle, $length));
        if($fromenc != ""){
            $ln = mb_convert_encoding($ln, "utf-8", $fromenc);
        }
        $_line .= $ln;
        $itemcnt = preg_match_all('/'.$e.'/', $_line, $dummy);
        if ($itemcnt % 2 == 0) $eof = true;
    }
    $_csv_line = preg_replace('/(?:\\r\\n|[\\r\\n])?$/', $d, trim($_line));
    $_csv_pattern = '/('.$e.'[^'.$e.']*(?:'.$e.$e.'[^'.$e.']*)*'.$e.'|[^'.$d.']*)'.$d.'/';
    preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
    $_csv_data = $_csv_matches[1];
    for($_csv_i=0;$_csv_i<count($_csv_data);$_csv_i++){
        $_csv_data[$_csv_i]=preg_replace('/^'.$e.'(.*)'.$e.'$/s','$1',$_csv_data[$_csv_i]);
        $_csv_data[$_csv_i]=str_replace($e.$e, $e, $_csv_data[$_csv_i]);
    }
    return empty($_line) ? false : $_csv_data;
}
/**
 * ファイルポインタから行を取得し、CSVフィールドを処理する
 * @param resource handle
 * @param int length
 * @param string delimiter
 * @param string enclosure
 * @return ファイルの終端に達した場合を含み、エラー時にFALSEを返します。
 */
/*
function fgetcsv_reg (&$handle, $length = null, $d = ',', $e = '"') {
    $d = preg_quote($d);
    $e = preg_quote($e);
    $_line = "";
    while (($eof != true)and(!feof($handle))) {
        $_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
        $itemcnt = preg_match_all('/'.$e.'/', $_line, $dummy);
        if ($itemcnt % 2 == 0) $eof = true;
    }
    $_csv_line = preg_replace('/(?:\\r\\n|[\\r\\n])?$/', $d, trim($_line));
    $_csv_pattern = '/('.$e.'[^'.$e.']*(?:'.$e.$e.'[^'.$e.']*)*'.$e.'|[^'.$d.']*)'.$d.'/';
    preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
    $_csv_data = $_csv_matches[1];
    for($_csv_i=0;$_csv_i<count($_csv_data);$_csv_i++){
        $_csv_data[$_csv_i]=preg_replace('/^'.$e.'(.*)'.$e.'$/s','$1',$_csv_data[$_csv_i]);
        $_csv_data[$_csv_i]=str_replace($e.$e, $e, $_csv_data[$_csv_i]);
    }
    return empty($_line) ? false : $_csv_data;
}
*/
function date2ym($str, $separator  = "-"){
    $st = explode($separator, $str);
    $newStr = $st[0].$separator.$st[1];
    return $newStr;
}

function mailFormatter($mailtxt=''){
    $return = array();
    $mailStr = file_get_contents(SERVER_DIR.'/includes/email/'.$mailtxt);
    $mailSp = strpos($mailStr, "body:", 0);
    $return["mailbody"] = substr($mailStr, $mailSp + 5);
    $return["subject"] = str_replace("subject:", "", substr($mailStr, 0, $mailSp));
    return $return;
}

function resize_dimensions($goal_width,$goal_height,$width,$height) {
    $return = array('width' => $width, 'height' => $height);
    
    // If the ratio > goal ratio and the width > goal width resize down to goal width 
    if ($width/$height > $goal_width/$goal_height && $width > $goal_width) {
        $return['width'] = $goal_width;
        $return['height'] = $goal_width/$width * $height;
    }
    // Otherwise, if the height > goal, resize down to goal height 
    else if ($height > $goal_height) {
        $return['width'] = $goal_height/$height * $width;
        $return['height'] = $goal_height;
    } 
    
    return $return;
}

function mce($str){
    if(get_magic_quotes_gpc()){
        $str = mb_convert_encoding(stripslashes($str),"UTF-8","auto");
    }else{
        $str = mb_convert_encoding($str,"UTF-8","auto");
    }
    return $str;
}

function hs($str){
    $str = mce($str);
    $str = htmlspecialchars($str);
    return $str;
}

function ue($str){
    $str = mce($str);
    $str  = urlencode($str);
    return $str;
}

function he($str){
    $str = mce($str);
    $str  = htmlentities($str,ENT_QUOTES,"UTF-8");
    return $str;
}

function stringreplace($value){
    $value = str_replace("'","’",$value);
    $value = str_replace("\"","”",$value);
    $value = str_replace(",","，",$value);
    $value = str_replace("#","＃",$value);
    return $value;
}

function data_convert($data){ //GET、POSTデータコンバート
    if(!is_array($data)){
        $data = mce($data);
        $data = str_replace("\r\n","\n",$data);
        $data = str_replace("\r","\n",$data);
        $data = str_replace("&lt;br&gt;","\n",$data);
        $data = str_replace("\n","<br />",$data);
        $data = str_replace("'","’",$data);
        $data = str_replace("\"","”",$data);
        $data = str_replace(",","、",$data);
        $data  = strip_tags($data);
        $data  = htmlspecialchars($data);
    }elseif(is_array($data)){
        foreach($data as $val){
            $newval = mce($val);
            $newval = str_replace("\r\n","\n",$newval);
            $newval = str_replace("\r","\n",$newval);
            $newval = str_replace("&lt;br&gt;","\n",$newval);
            $newval = str_replace("\n","<br />",$newval);
            $newval = str_replace("'","’",$newval);
            $newval = str_replace("\"","”",$newval);
            $newval = str_replace(",","、",$newval);
            $newval  = strip_tags($newval);
            $newval  = htmlspecialchars($newval);
            $newdata[] = $newval;
        }
        unset($val);
        $data = $newdata;
    }
    return $data;
}

function hashconv($d, $raw_output = false, $salt = SECURE_SALT){
    $d .= $salt;
    if(version_compare(PHP_VERSION, '5.0.0', '<')){
        $d = md5($d);
        $d = sha1($d);
    }else{
        $d = md5($d, $raw_output);
        $d = sha1($d, $raw_output);
    }
    return $d;
}

function errors($d = '', $format = '%s<br />'){
    $res = '';
    if(is_array($d)){
        foreach($d as $v){
            $res .= sprintf($format, $v) . "\n";
        }
    }
    return $res;
}

function HBsendMail($to, $subject, $body, $from_email, $from_name, $from_enc="UTF-8", $files=NULL, $reply_email=NULL, $reply_name=NULL){
    mb_language("ja");
    mb_internal_encoding($from_enc);
    $result = false;
    
    /* Mail, headers */
    $headers  = "MIME-Version: 1.0 \n" ;
    
    /* Mail, body */
    $body = mb_convert_encoding($body, "ISO-2022-JP", $from_enc);
    
    /* Mail, optional paramiters. */
    $sendmail_params  = "-f$from_email";
    
    /* Mail, subject */
    $subject = mb_convert_encoding($subject, "ISO-2022-JP", $from_enc);
    $subject = "=?iso-2022-jp?B?" . base64_encode($subject) . "?=";
    
    /* Ataachment */
    if(isset($files) && is_array($files)){
        // boundary
        $semi_rand = md5(time());
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
        // headers for attachment
        $headers .= "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"\n";
        // multipart boundary
        $body = "--{$mime_boundary}\n" . "Content-Type: text/plain;charset=\"ISO-2022-JP\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $body . "\n\n";
        // preparing attachments
        for($i=0;$i<count($files);$i++){
            if(is_file($files[$i])){
                $body .= "--{$mime_boundary}\n";
                $fp = @fopen($files[$i],"rb");
                $data = @fread($fp,filesize($files[$i]));
                @fclose($fp);
                $data = chunk_split(base64_encode($data));
                $body .= "Content-Type: application/octet-stream; name=\"".basename($files[$i])."\"\n" . 
                "Content-Description: ".basename($files[$i])."\n" .
                "Content-Disposition: attachment;\n" . " filename=\"".basename($files[$i])."\"; size=".filesize($files[$i]).";\n" . 
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            }
        }
        $body .= "--{$mime_boundary}--";
    }else{
        $headers .= "Content-Type: text/plain;charset=ISO-2022-JP\n";
    }
    
    /* Additional Header */
    $headers .= "From: " .
        mb_encode_mimeheader (mb_convert_encoding($from_name,"ISO-2022-JP",$from_enc)) .
        "<".$from_email.">\n";
    if(!empty($reply_email)){
        if(!empty($reply_name)){
            $headers .= "Reply-To: " .
            mb_encode_mimeheader (mb_convert_encoding($reply_name,"ISO-2022-JP",$from_enc)) .
            "<".$reply_email.">\n";
        }else{
            $headers .= "Reply-To: " .
            mb_encode_mimeheader (mb_convert_encoding($reply_email,"ISO-2022-JP",$from_enc)) .
            "<".$reply_email.">\n";
        }
    }else{
        $headers .= "Reply-To: " .
        mb_encode_mimeheader (mb_convert_encoding($from_name,"ISO-2022-JP",$from_enc)) .
        "<".$from_email.">\n";
    }
    
    /* Mail, sending */
    $result = mail($to, $subject, $body, $headers, $sendmail_params);
    
    return $result;
}

function mailsending($mailto = '', $mailbody = '', $subject = '') {
    // メール送信
    // カレントの言語を日本語に設定する
    mb_language("ja");
    // 内部文字エンコードを設定する
    mb_internal_encoding("UTF-8");
    
    if($subject == '') $subject = SITE_NAME;
    $headers = "from: " . mb_encode_mimeheader(mb_convert_encoding(SITE_NAME,"ISO-2022-JP","AUTO")) . "<" . FROM_ADDRESS . ">\n";
    if ($mailto != '') {
        $mailsending = mb_send_mail($mailto, $subject, $mailbody, $headers);
    }else{
        return false;
    }
    return $mailsending;
}

function paginate($pageall = 0, $page_current = 0){
    $results = array();
    /* 
    $pageall 全ページ数
    $page_current 現在のページ
    $pagingformat リンクフォーマット　'index.php?mainpage=mypage&amp;pages=%s'
     */
    if(intval($page_current) == 0) $page_current = 1;
    if ( $page_current > 0 ) {
        if($page_current != 1){
            $results[] = array("pagenum"=>(int)$page_current - 1, "type"=>"prev");
        }
    }
    for ( $i=0,$j=1; $i < $pageall; $i++,$j++ ) {
        if ( $j == $page_current ) {
            $results[] = array("pagenum"=>$j, "type"=>"current");
        } else {
            $results[] = array("pagenum"=>$j, "type"=>"page");
        }
    }
    if ( $page_current < $pageall ) { 
        $results[] = array("pagenum"=>(int)$page_current + 1, "type"=>"next");
    }
    return $results;
}

function paging($pageall = 0, $page_current = 0, $linkformat = 'index.php?mainpage=mypage&amp;pages=%s', $outerClass = 'paging tcenter'){
    $contents = '';
    /* 
    $pageall 全ページ数
    $page_current 現在のページ
    $pagingformat リンクフォーマット　'index.php?mainpage=mypage&amp;pages=%s'
     */
    if(intval($page_current) == 0) $page_current = 1;
    $contents .= "\n<ul class=\"".$outerClass."\">\n";
    if ( $page_current > 0 ) {
        if($page_current != 1){
            $contents .= "<li class=\"prev\"><a href=\"" . sprintf($linkformat, (int)$page_current - 1 ) . "\" class=\"prev\">前へ</a></li>&nbsp;\n";
        }
    }
    for ( $i=0,$j=1; $i < $pageall; $i++,$j++ ) {
        if ( $j == $page_current ) {
            $contents .= "<li class=\"current\"><span>$j</span></li>&nbsp;\n";
        } else {
            if($i == 0){
                $contents .= "<li><a href=\"" . sprintf($linkformat, $j ) . "\">$j</a></li>&nbsp;\n";
            }else{
                $contents .= "<li><a href=\"" . sprintf($linkformat, $j ) . "\">$j</a></li>&nbsp;\n";
            }
        }
    }
    if ( $page_current < $pageall ) { 
        $contents .= "<li class=\"next\"><a href=\"" . sprintf($linkformat, (int)$page_current + 1 ) . "\" class=\"next\">次へ</a></li>&nbsp;\n"; 
    }
    $contents .= "</ul>\n";
    return $contents;
}

function debug($data = NULL){
    $result = "";
    if(DEBUG){
        $result .= '<div class="debug"><div class="debugheader"><p>デバッグデータ</p></div><pre class="debugbody">';
        if(is_array($data)){
            $result .= "DEBUGS : \n";
            print_r($data);
            $result .= "\n";
        }
        $result .= "SESSION : \n";
        $result .= print_r($_SESSION, true);
        $result .= "GET : \n";
        $result .= print_r($_GET, true);
        $result .= "POST : \n";
        $result .= print_r($_POST, true);
        $result .= "SERVER : \n";
        $result .= print_r($_SERVER, true);
        $result .= "\nデバッグを解除するには、コンフィグレーションファイルのデバッグモードを解除して下さい。\n";
        $result .= '</pre><div class="debugfooter">&nbsp;</div></div>';
    }
    return $result;
}

?>