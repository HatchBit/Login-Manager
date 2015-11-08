<?php
/**
 * Login Manager
 *
 * End Script.
 *
 * @package     Login-Manager
 * @author      Y.Yajima <yajima@hatchbit.jp>
 * @copyright   2015, HatchBit & Co.
 * @license     http://www.hatchbit.jp/resource/license.html
 * @link        http://www.hatchbit.jp
 * @since       Version 1.0
 * @filesource
 */
$endNowTime = microtime(true);
if($startNowTime){
    $spanTime = $endNowTime - $startNowTime;
}else{
    $spanTime = $endNowTime;
}
if(DEBUG){
    echo '<!-- SESSION : '.print_r($_SESSION, true).' -->'.PHP_EOL;
    echo '<!-- POST : '.print_r($_POST, true).' -->'.PHP_EOL;
    echo '<!-- GET : '.print_r($_GET, true).' -->'.PHP_EOL;
    echo '<!-- FILES : '.print_r($_FILES, true).' -->'.PHP_EOL;
    if(isset($timeWraps) && count($timeWraps) > 0){
        foreach($timeWraps as $tw){
            echo $tw.PHP_EOL;
        }
        unset($tw);
    }
}
?>
<!-- <?php echo $spanTime; ?> -->