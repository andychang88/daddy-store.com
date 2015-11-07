<?php
	class productsParser extends SSUParser{
		static $table			= TABLE_PRODUCTS_DESCRIPTION;
		static $name_field 		= "products_name";
		static $main_page 		= "product_info";
		static $identifier 		= "products";
		static $query_key 		= "products_id";
				
		static function identifyPage(&$params, &$_get){
			if(isset($params[1]) && categoriesParser::identifyName($params[0]) && self::identifyName($params[1])){
				categoriesParser::updateGet($params[0], $_get);
				self::updateGet($params[1], $_get);
				$_get['main_page'] = self::getMainPage();
				unset($params[0]);
				unset($params[1]);
				return true;
			}
			elseif(self::identifyName($params[0])){
				$_get['main_page'] = self::getMainPage();
				self::updateGet($params[0], $_get);
				unset($params[0]);
				return true;
			}
			return false;
		}
	
		static function identifyPage2(&$page){
			foreach(SSUConfig::registry('identifiers', self::$identifier) as $main_page => $identifier)
				if($page == $main_page){		
					self::$main_page = $main_page;	
					$page = '';
					return true;
				}
			return false;
		}
		
		/*
		 * This function identify if a string contains category identifier
		 */
		static function identifyName($string, $identifier = ''){
			foreach(SSUConfig::registry('identifiers', self::$identifier) as $main_page => $identifier)
				if(strpos($string, $identifier) !== false){			
				self::$main_page = $main_page;
				return true;
				}
			
			return false;
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
			// urldecode is used as a hot fix for the problem with attribute id attached to product id
			// TODO: find a better way to resolve this
			$_get[self::$query_key] = urldecode(self::getID($string, SSUConfig::registry('delimiters', 'id')));
		}
		
		static function parseParam(&$page, &$params, $languages_id, $languages_code){
			$pos = array_search(self::$query_key, $params);
			if(!empty($params[$pos+1])){
				$products_id = $params[$pos+1];
				
				// recalculate 'page', just in case the product_type passed is wrong
				if(self::getMainPage() == $page)
					self::$main_page = $page = zen_get_info_page($products_id);
				
				$params[$pos] = self::getName($products_id, $languages_id, $languages_code);
				
				// recalculate cPath if needed to
				/*if(self::getMainPage() == $page){
					if(($cPos  = array_search(categoriesParser::$query_key, $params)) !== false){
						$cPath = self::getProductPath($products_id, $params[$cPos+1]);
						$params[$cPos] = categoriesParser::getName($cPath, $languages_id, $languages_code);
						unset($params[$cPos+1]);
					}
					else {
						$cPath = self::getProductPath($products_id, 0);
						$params = array_merge(array(categoriesParser::getName($cPath, $languages_id, $languages_code)), $params);
						$pos++;
					}
				}*/
			}
			else 
				unset($params[$pos]);
			unset($params[$pos+1]);
		}
		
		static function getName($id, $languages_id, $languages_code){
			$sql_query		= "SELECT ".self::$name_field." FROM ".self::$table." WHERE products_id ='$id' AND language_id = '$languages_id'";
			$identifiers 	= SSUConfig::registry('identifiers', self::$identifier);
			return parent::getName($id, $sql_query, self::$name_field, $identifiers[self::$main_page], self::$identifier, $languages_code);
		}
		
		function getProductPath($products_id, $cPath) {    
			global $db;
			$categories_id = self::getID($cPath, '_');
			$category_query = "select p2c.categories_id, p.master_categories_id
			                   from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
			                   where p.products_id = '" . $products_id . "'
			                   and p.products_id = p2c.products_id 
			                   and (p.master_categories_id = '$categories_id' or p2c.categories_id='$categories_id') limit 1";
			
			$category = $db->Execute($category_query);
			
			// fall back if needed to
			if ($category->RecordCount() == 0){
			 	$category_query = "select p.master_categories_id
			 						from " . TABLE_PRODUCTS . " p 
			 						where p.products_id = '" . $products_id . "' limit 1";
			 	$category = $db->Execute($category_query);
			 	if ($category->RecordCount() > 0)
			 		$categories_id = $category->fields['master_categories_id'];
			}
			
			$cPath = "";
			$categories = array();
			zen_get_parent_categories($categories, $categories_id);
			
			$categories = array_reverse($categories);
			
			$cPath = implode('_', $categories);
			
			if (zen_not_null($cPath)) $cPath .= '_';
			$cPath .= $categories_id;
			
			return $cPath;
		}	
	}
