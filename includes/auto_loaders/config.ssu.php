<?php
/**
 * Simple SEO URL
 * @Version: Alpha 2.4b
 * @Authour: yellow1912
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */ 
if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}
	
	/*                
	 * Include SSU Config
	 */               
	$autoLoadConfig[80][] = array('autoType'=>'init_script', 'loadFile'=> 'init_ssu.php'); 
	
    $autoLoadConfig[80][] = array('autoType'=>'classInstantiate', 'className'=>'SSULink', 'objectName'=>'ssu', 'checkInstantiated'=>true, 'classSession'=>false);
	
	$autoLoadConfig[80][] = array('autoType'=>'objectMethod', 'objectName'=>'ssu', 'methodName' => 'parseUrl');
	
	// We need to modify the default load order of Zen. Language class must be loaded first
	$autoLoadConfig[80][] = array('autoType'=>'init_script', 'loadFile'=> 'init_languages.php');
	foreach ($autoLoadConfig[110] as $key => $value){
		if($value['loadFile'] == 'init_languages.php'){
			unset($autoLoadConfig[110][$key]);
			break;
		}
	}
	$autoLoadConfig[80][] = array('autoType'=>'init_script', 'loadFile'=> 'init_ssu_language.php'); 
	
	$autoLoadConfig[80][] = array('autoType'=>'objectMethod', 'objectName'=>'ssu', 'methodName' => 'postParseUrl');