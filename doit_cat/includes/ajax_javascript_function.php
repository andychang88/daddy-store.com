<?php
/**
 * ajax ::    
 *
 * @package ajax_example
 * @copyright Copyright 2007 rainer@langheiter.comn // http://edv.langheiter.com
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: ajax_javascript_function.php 72 2008-11-25 03:44:18Z yellow1912 $
 */


    // BOF: ajax which js-files should globally loaded
        // you can globally load for example prototype.js or any other library
    //$ajax_js['ajax/jquery-latest.js']   = true;
    //$ajax_js['ajax/loading.js']         = true;
    
    // BOF: ajax register functions for xajax
    $ajax_func['ssu_add_input'] = true;
    $ajax_func['ssu_update_input'] = true;
    $ajax_func['ssu_message'] = true;
    $ajax_func['ssu_delete'] = true;
    $ajax_func['ssu_update_status'] = true;
?>