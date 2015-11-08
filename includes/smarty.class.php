<?php
/**
 * Smarty管理クラス
 *
 * @package     Login-Manager
 * @author      Y.Yajima <yajima@hatchbit.jp>
 * @copyright   2015, HatchBit & Co.
 * @license     http://www.hatchbit.jp/resource/license.html
 * @link        http://www.hatchbit.jp
 * @since       Version 1.0
 * @filesource
 */
if(defined('SMARTY_DIR')) {
    include_once(SMARTY_DIR.'Smarty.class.php');
}elseif(defined('ROOT_DIR')){
    include_once(ROOT_DIR."/Smarty/libs/Smarty.class.php");
}else{
    
}

class smartyEngine extends Smarty {
    
    function __construct() {
        parent::__construct();
        $this->template_dir = ROOT_DIR.'/templates/';
        $this->compile_dir = ROOT_DIR.'/templates_c/';
        $this->config_dir = ROOT_DIR.'/configs/';
        $this->cache_dir = ROOT_DIR.'/cache/';
        if(DEBUG){
            $this->caching = 0;
            $this->debugging = true;
        }else{
            $this->caching = 0;
            //$this->caching = Smarty::CACHING_LIFETIME_CURRENT;
        }
        $this->assign('app_name', SITE_NAME.'. Modified by Hatchbit & Co.');
    }
    
    function cacheEnable($switch = true) {
        if($switch == true){
            $this->caching = true;
        }else{
            $this->caching = false;
        }
    }
}
?>