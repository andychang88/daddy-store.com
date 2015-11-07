<?php
	class categoriesParser extends SSUParser{
		static $table			= TABLE_CATEGORIES_DESCRIPTION;
		static $name_field 		= "categories_name";
		static $main_page 		= "index";
		static $identifier	 	= "categories";
		static $query_key 		= "cPath";
		static $is_main_page	= false;
		
		static function identifyPage(&$params, &$_get){
			if(self::identifyName($params[0])){
				$_get['main_page'] = self::getMainPage();
				self::updateGet($params[0], $_get);
				unset($params[0]);
				return true;
			}
			return false;
		}
		
		static function identifyPage2(&$page, $params){
			if($page == self::getMainPage() && self::identifyParam($params)!== false){
				self::$is_main_page = true;
				$page = '';
				return true;
			}
			return false;
		}

		/*
		 * This function identify if a string contains category identifier
		 */
		static function identifyName($string, $identifier = ''){
			return parent::identifyName($string, SSUConfig::registry('identifiers', self::$identifier)); 
		}
		
		/*
		 * This function identify if a query string matches $query_key
		 */
		static function identifyQuery($string, $query_key=''){
			return parent::identifyQuery($string, self::$query_key); 
		}
		
		static function identifyParam($string){
			return strpos($string, self::$query_key.'=');
		}
		
		static function getMainPage(){
			return self::$main_page;	
		}
		
		static function updateGet($string, &$_get){
			$_get[self::$query_key] = self::getID($string, SSUConfig::registry('delimiters', 'id'));
		}
		
		static function parseParam($page, &$params, $languages_id, $languages_code){
			// do not parse if this is a product page, leave the job
			if(productsParser::getMainPage() == $page)

			return;
			
			// if this function is called, it means that the array_search must return a valid pos, no need to check
			$pos = array_search(self::$query_key, $params);
			if(!empty($params[$pos+1])){
				if(self::$is_main_page){
					$params = array_merge(array(self::getName($params[$pos+1], $languages_id, $languages_code)), $params);
					unset($params[++$pos]);
				}
				else
					$params[$pos] = self::getName($params[$pos+1], $languages_id, $languages_code);
			}
			else 
				unset($params[$pos]);
			unset($params[$pos+1]);
		}
		
		static function getName($cPath, $languages_id, $languages_code){
			$cache_filename = self::buildFileName($cPath, $languages_code);
			if(($name = SSUCache::read($cache_filename, self::$identifier)) !== false)
				return $name;
			
			// do not trust the passed cPath, always rebuild it
			$current_categories_id = self::getID($cPath, '_');
			$category_ids = array();
			zen_get_parent_categories($category_ids, $current_categories_id);	
			$category_ids = array_reverse($category_ids);
			$category_ids[] = $current_categories_id;
			$cat_count = count($category_ids);
			
			$counter = $cat_count - SSUConfig::registry('configs', 'max_level');
			
			if($counter < 0) $counter = 0;
			
			$result = '';
			// this may not be the best way to build the category name, but we do this once per cPath only
			while($counter<=($cat_count-1)){
				$category_ids[$counter] = (int)$category_ids[$counter];
				$sql_query = "SELECT categories_name FROM ".TABLE_CATEGORIES_DESCRIPTION." WHERE categories_id ='".$category_ids[$counter]."' AND language_id= '$languages_id' LIMIT 1";
				
				$result .= self::getNameFromDB($sql_query, self::$name_field).SSUConfig::registry('delimiters', 'name');
				$counter++;
			}
			
			$result = trim(SSULanguage::parseName($result, $languages_code));
			if(empty($result)) $result = self::$name_field;
			$result = $result.SSUConfig::registry('identifiers', self::$identifier).$cPath;
			
			// write to file EVEN if we get an empty content
			SSUCache::write($cache_filename, self::$identifier, $result);
			return $result;
				
			}
	}