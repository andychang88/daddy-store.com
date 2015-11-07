<?php
	class SSUPlugin{
		
		static function load($class, $name){
			require(SSUConfig::registry('paths', 'plugins')."$class/$name.php");
		}
	}