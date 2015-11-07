<?php
	class SSUCache {
		static protected $cache;
		
		static function write($name, $cache_folder, $content){
			self::$cache[$cache_folder][$name] = $content;
			return @file_put_contents(SSUConfig::registry('paths', 'cache')."$cache_folder/$name", $content);
		}
		
		static function read($name, $cache_folder){
			if(isset(self::$cache[$cache_folder][$name]))
				return self::$cache[$cache_folder][$name];
			return @file_get_contents(SSUConfig::registry('paths', 'cache')."$cache_folder/$name");
		}
	}