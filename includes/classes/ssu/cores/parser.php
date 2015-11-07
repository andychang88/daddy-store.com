<?php
	class SSUParser{
	    protected static $__CLASS__ = __CLASS__;
   		
   		/**
	     * Returns the classname of the child class extending this class
	     *
	     * @return string The class name
	     */
	    protected static function getClass() {
	        $implementing_class = self::$__CLASS__;
	        $original_class = __CLASS__;
	
	        if ($implementing_class === $original_class)
	            throw new Exception("You MUST provide a <code>protected static \$__CLASS__ = __CLASS__;</code> statement in your Singleton-class!");
	      
	        return $implementing_class;
	    } 
	    
	    /*
		 * This function identify if the current page is our main page.
		 */
		static function identifyPage(&$uri_parts, &$_get){
			return self::identifyName($uri_parts[0]);
		}
		
		static protected function identifyName($string, $identifier = ''){
			return (strpos($string, $identifier) !== false) ? true : false; 
		}
		
		static protected function identifyQuery($string, $query_key=''){
			return ($query_key == $string); 
		}
		
		static protected function getName($id, $sql_query, $name_field, $identifier, $cache_folder, $languages_code){
			$cache_filename = self::buildFileName($id, $languages_code);
			if(($name = SSUCache::read($cache_filename, $cache_folder)) !== false)
				return $name;
			
			$name = self::getNameFromDB($sql_query, $name_field);
			if(empty($name)) $name = $name_field;
			$name = SSULanguage::parseName($name, $languages_code).$identifier.$id;
			SSUCache::write($cache_filename, $cache_folder, $name);
			return $name;
		}
		
		static protected function getNameFromDB($sql_query, $name_field){
			global $db;
			$result = '';
			$sql_result = $db->Execute($sql_query);
			if($sql_result->RecordCount() > 0){
				if(!empty($name_field))
					$result = $sql_result->fields[$name_field];
				else 
					$result = $sql_result;
			}
			return $result;
		}
		
		static protected function buildFileName($id, $languages_code){
			return self::getID($id, '_').'_'.$languages_code;
		}
		
		/* 
		* Gets int id from a string (product/category name)
		*/
		static protected function getID($string, $delimiter){
			return end(explode($delimiter, $string));
		}	
		
	}