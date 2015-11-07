<?php
	class SSUConfig{
		static $registry;
		
		static function init($configs){
			foreach($configs as $key => $value){
				if(is_array($value))
					self::registerArray($key, $value);
				else
					self::register($key, $value);
			}
		}
		
		static function register($class, $name, $value){
			self::$registry[$class][$name] = $value;	
		}
		
		static function registry($class, $name=""){
			if(isset(self::$registry[$class])){
				if(!empty($name)){
					if(isset(self::$registry[$class][$name]))
						return self::$registry[$class][$name];
				}
				else
					return self::$registry[$class];
			}
			return null;
		}
	
		static function registerArray($class, $params){
			foreach ($params as $key => $value)
				self::register($class, $key, $value);	
		}
		
	}