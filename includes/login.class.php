<?php
/**
 * Login Manager
 *
 * ログイン処理クラス
 *
 * @package     Login-Manager
 * @author      Y.Yajima <yajima@hatchbit.jp>
 * @copyright   2015, HatchBit & Co.
 * @license     http://www.hatchbit.jp/resource/license.html
 * @link        http://www.hatchbit.jp
 * @since       Version 1.0
 * @filesource
 */

class loginEngine {
    	var $db = "";
    var $tableName = "logins";
    
    function __construct(&$db) {
        //DB接続情報
        $this->db =& $db;
    }
    
    function countnum($filter = "") {
        $result = array();
        $tableName = $this->tableName;
        $where = "";
        if($filter != ""){
            $where .= " WHERE ".$filter;
        }
        $sql = "SELECT COUNT(`id`) AS `count` FROM $tableName".$where;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchColumn(0);
        return $result;
    }
    
    function view($filter = "", $orderby = "", $limit = NULL) {
        $result = array();
        $tableName = $this->tableName;
        $where = "";
        if($filter != ""){
            $where .= " WHERE ".$filter;
        }
        $order = "";
        if($orderby != ""){
            $order .= " ORDER BY ".$orderby;
        }
        $sql = "SELECT * FROM $tableName".$where.$order;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }
    
    function delete($login_id) {
        $tableName = $this->tableName;
        $sql = "DELETE FROM $tableName WHERE `id` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1,$login_id,PDO::PARAM_INT);
        $return = $stmt->execute();
        return $return;
    }
    
    function update($tableData, $login_id) {
        $tableName = $this->tableName;
        $this->db->perform($tableName, $tableData, "UPDATE", "`id` = $login_id");
        return true;
    }
    
    function add($username, $password, $status = 1) {
        $return = 0;
        $tableName = $this->tableName;
        $tableData = array();
        $tableData[] = array("fieldName"=>"username", "value"=>$username, "type"=>"string");
        $tableData[] = array("fieldName"=>"password", "value"=>$password, "type"=>"string");
        $tableData[] = array("fieldName"=>"status", "value"=>$status, "type"=>"integer");
        $exec = $this->db->perform($tableName, $tableData, "INSERT");
        $return = $this->db->insert_ID();
        return $return;
    }
    
    function login($username, $password) {
        $nowtime = time();
        $result = 'false';
        $tableName = $this->tableName;
        
        $sql = "SELECT `id`,`username`,`status`,`token`,`modified` 
        FROM $tableName 
        WHERE `username` = :username AND `password` = :password AND `status` IN (1,9) 
        LIMIT 0,1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username,PDO::PARAM_STR,64);
        $stmt->bindParam(':password', $password,PDO::PARAM_STR,64);
        //$stmt->bindParam(':loginerrorcount', 9999,PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchall(PDO::FETCH_ASSOC);
        foreach($res as $r){
            if($r['token'] == "" || intval(time() - $r['modified']) > 86400){
                // token が空か、古かったら新しいトークンを生成。
                $token = $this->_renewtoken($r['id'],$r['username'],$r['status'],$r['modified']);
            }else{
                $token = $r['token'];
            }
            
            // セッションにトークンを登録。
            $_SESSION['token'] = $token;
            $result = 'ok';
        }
        unset($r);
        return $result;
    }
    function managerlogin($username, $password) {
        $nowtime = time();
        $result = 'false';
        $tableName = $this->tableName;
        
        $sql = "SELECT `id`,`username`,`status`,`token`,`modified` 
        FROM $tableName 
        WHERE `username` = :username AND `password` = :password AND `status` = 9 
        LIMIT 0,1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username,PDO::PARAM_STR,64);
        $stmt->bindParam(':password', $password,PDO::PARAM_STR,64);
        //$stmt->bindParam(':loginerrorcount', 9999,PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchall(PDO::FETCH_ASSOC);
        foreach($res as $r){
            if($r['token'] == "" || intval(time() - $r['modified']) > 86400){
                // token が空か、古かったら新しいトークンを生成。
                $token = $this->_renewtoken($r['id'],$r['username'],$r['status'],$r['modified']);
            }else{
                $token = $r['token'];
            }
            
            // セッションにトークンを登録。
            $_SESSION['token'] = $token;
            $result = 'ok';
        }
        unset($r);
        return $result;
    }
    
    function uniqusername($username) {
        $result = false;
        $tableName = $this->tableName;
        $sql = "SELECT `id` FROM $tableName WHERE `username` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1,$username,PDO::PARAM_STR,64);
        $stmt->execute();
        $res = $stmt->fetchall(PDO::FETCH_ASSOC);
        foreach($res as $r){
            $result = true;
        }
        unset($r);
        return $result;
    }
    
    function token2userid($token) {
        $result = 0;
        $tableName = $this->tableName;
        $sql = "SELECT `id` FROM $tableName WHERE `token` = ? LIMIT 0,1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1,$token,PDO::PARAM_STR,128);
        $stmt->execute();
        $res = $stmt->fetchall(PDO::FETCH_ASSOC);
        foreach($res as $r){
            $result = $r['id'];
        }
        unset($r);
        return $result;
    }
    
    function tokenview($token) {
        $result = array();
        $tableName = $this->tableName;
        $sql = "SELECT `id`,`username`,`status`,`token`,`modified` 
        FROM $tableName 
        WHERE `token` = ?
        LIMIT 0,1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1,$token,PDO::PARAM_STR,128);
        $stmt->execute();
        $res = $stmt->fetchall(PDO::FETCH_ASSOC);
        //var_dump($res);
        foreach($res as $r){
            if(intval(time() - strtotime($r['modified'])) > 86400){
                $token = $this->_renewtoken($r['id'],$r['username'],$r['group_id'],$r['modified']);
            }else{
                $token = $r['token'];
            }
            $_SESSION['token'] = $token;
            $result = $r;
        }
        unset($r);
        return $result;
    }
    
    function _renewtoken($login_id,$username,$group_id = 0,$modified) {
        $token = "";
        $tableName = $this->tableName;
        if(intval(time() - $modified) > 86400){
            $token = md5($username.$group_id.time());
            $updates = array();
            $updates[] = array("fieldName"=>"token", "value"=>$token, "type"=>"string");
            $this->db->perform($tableName, $updates, "UPDATE", "`id` = ".$login_id);
        }
        return $token;
    }
    
    // 汎用データUPSERT
    function upsertdb($tableData, $tableName){
        $result = false;
        if(!empty($tableData)){
            $upsert = $this->db->perform($tableName, $tableData, "UPSERT");
            $sql = "SELECT `id` FROM $tableName WHERE ";
            $filter = array();
            foreach($tableData as $td){
                if($td['value'] == "") continue;
                switch($td['type']){
                    case "string":
                        $filter[] = "`".$td['fieldName']."` = '".$td['value']."' ";
                        break;
                    case "integer":
                        $filter[] = "`".$td['fieldName']."` = ".$td['value']." ";
                        break;
                }
            }
            $sql .= implode(" AND ", $filter);
            $sql .= "ORDER BY `id`";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchall(PDO::FETCH_ASSOC);
            foreach($res as $r){
                $result = $r['id'];
            }
            unset($r);
        }
        return $result;
    }
}
?>