<?php
/** 
 * phpBB Class.
 *
 * This class is used to interact with phpBB forum
 *
 * @package classes
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: class.phpbb.php 4824 2006-10-23 21:01:28Z drbyte $
 */

if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

  class recommend_config extends base {
      var $debug = false;
      var $db_phpbb;
      var $phpBB=array();
      var $dir_phpbb=''; 


    function insertRecommendConfig($data) {
    	global $db;
    	
    	$item_key = trim($data['item_key']);
	  	$item_value = trim($data['item_value']);
	  	$item_desp = trim($data['item_desp']);
	  	
	  	if($item_key && $item_value && $item_desp){
	  		$sql = "insert into 2011recommend_config (item_key, item_value, item_desp) values('$item_key', '$item_value', '$item_desp')";
  			$db->Execute($sql);
	  	}
	  	
    }
    
    function updateRecommendConfig($data, $item_key) {
    	global $db;
    	
    	$sql = "select *  from 2011recommend_config where item_key='".$item_key."'" ;
  		$result = $db->Execute($sql);
  		if(!$result->EOF){
  			
  			if ($data['is_delete'] == 1){
  				$update = "is_delete='1'";
  			} else {
  				$update = "item_value='".$item_value."'";
  			}
  			
  			$sql = "update  2011recommend_config set ".$update." where item_key='".$item_key."'";
  			$db->Execute($sql);
  		}
    }

  }
?>