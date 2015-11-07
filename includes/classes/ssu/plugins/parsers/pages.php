<?php
	class pagesParser extends SSUParser{
		static $table			= TABLE_EZPAGES;
		static $name_field 		= "pages_title";
		static $main_page 		= "page";
		static $identifier 		= "pages";
		static $query_key 		= "id";
				
		static function identifyPage(&$params, &$_get){
			if(self::identifyName($params[0])){
				$_get['main_page'] = self::getMainPage();
				self::updateGet($params[0], $_get);
				unset($params[0]);
				return true;
			}
			return false;
		}
	
		static function identifyPage2(&$page){
			if($page == self::getMainPage()){
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
			return false;
		}
		
		static function getMainPage(){
			return self::$main_page;	
		}
		
		static function updateGet($string, &$_get){
			$_get[self::$query_key] = self::getID($string, SSUConfig::registry('delimiters', 'id'));
		}
		
		static function parseParam($page, &$params, $languages_id, $languages_code){
			// if this function is called, it means that the array_search must return a valid pos, no need to check
			$pos = array_search(self::$query_key, $params);
			if(!empty($params[$pos+1]))
				$params[$pos] = self::getName($params[$pos+1], $languages_id, $languages_code);
			else 
				unset($params[$pos]);
			unset($params[$pos+1]);
		}
		
		static function getName($id, $languages_id, $languages_code, $identifier='', $cache_folder='', $languages_code=''){
			$sql_query		= "SELECT ".self::$name_field." FROM ".self::$table." WHERE pages_id ='$id' AND languages_id = '$languages_id'";
			return parent::getName($id, $sql_query, self::$name_field, SSUConfig::registry('identifiers', self::$identifier), self::$identifier, $languages_code);
		}
	}