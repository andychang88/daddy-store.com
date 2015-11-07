<?php
/**
 * Simple SEO URL
 * @Version: Alpha 2.2c
 * @Authour: yellow1912
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */ 

require_once(DIR_FS_CATALOG.'includes/init_includes/init_ssu.php');
class SSUManager {
	
	static protected $error_counter;
	static protected $file_counter = 0;
	// Part of the code in the below function taken from http://www.php.net/unlink
	// ggarciaa at gmail dot com (04-July-2007 01:57)
	// I needed to empty a directory, but keeping it
	// so I slightly modified the contribution from
	// stefano at takys dot it (28-Dec-2005 11:57)
	// A short but powerfull recursive function
	// that works also if the dirs contain hidden files
	//
	// $dir = the target directory
	// $DeleteMe = if true delete also $dir, if false leave it alone
	// sureRemoveDir('EmptyMe', false);
	// sureRemoveDir('RemoveMe', true);
	
	// TODO: chmod if needed
	function sureRemoveDir($dir, $DeleteMe) {
		global $messageStack;
	    if(!$dh = @opendir($dir)){
	    	$messageStack->add("Could not open dir $dir", 'warning');
	    	return;
	    }
	    while (false !== ($obj = readdir($dh))) {
	        if($obj=='.' || $obj=='..') continue;
	        if (!@unlink($dir.'/'.$obj)) self::sureRemoveDir($dir.'/'.$obj, false);
	        else self::$file_counter++;
	    }
	
	    closedir($dh);
	    if ($DeleteMe){
	        @rmdir($dir);
	    }
	}

	function resetCache($cache_folder){
		global $messageStack;
		self::$file_counter = 0;
		
		if($cache_folder == 'all'){		
			$cache_folder = SSUConfig::registry('paths', 'cache');
			if(!@is_writable($cache_folder))
				$messageStack->add("$cache_folder folder is not writable", 'error');
			else	
				self::sureRemoveDir($cache_folder, false);
		}
		else{
			$cache_folder = SSUConfig::registry('paths', 'cache').$cache_folder;
			if(!@is_writable($cache_folder))
				$messageStack->add("$cache_folder folder is not writable", 'error');
			else	
				self::sureRemoveDir($cache_folder, false);
			
			$cache_folder = SSUConfig::registry('paths', 'cache').'pc';	
			if(!@is_writable($cache_folder))
				$messageStack->add("$cache_folder folder is not writable", 'error');
			else	
				self::sureRemoveDir($cache_folder, false);
		}	
		return self::$file_counter;
	}
}