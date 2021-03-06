<?php
/**
 * ajax ::    inits xajax & registers the functions
 *    
 * @package ajax
 * @copyright Copyright 2007 rainer@langheiter.comn // http://edv.langheiter.com
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: ajax.common.php 72 2008-11-25 03:44:18Z yellow1912 $
 */
// pi_1.php, pi_1.common.php, pi_1.server.php
// demonstrate a very basic xajax implementation
// using xajax version 0.5
// http://xajaxproject.org

require_once (DIR_FS_CATALOG."ajax/xajax5/xajax_core/xajax.inc.php");
#require_once ("ajax/xajax.inc.php");
$xajax = new xajax();
//$xajax->configure('debug', true);
$xajax->configure("javascript URI",'../ajax/xajax5');
if(isset($ajax_func)){
    foreach ($ajax_func as $key => $value) {
        if(true==$value){
            $xajax->registerFunction($key);
        }
    
    }
}
$xajax->processRequest();  
?>
