<?php
	class SSUAlias{
		// store all
		static  $aliases = array();
		static  $links = array();
		
		// store only enabled aliases
		static  $_aliases = array();
		static  $_links = array();
		
		// Aliases needed to be queried on demand
		static function retrieveAliases(){
			if(isset($_SESSION['ssu_aliases'])){
				self::$aliases = $_SESSION['ssu_aliases'];}
			else{
				global $db;
				$aliases = $db->Execute('SELECT * FROM '.TABLE_LINKS_ALIASES);
				while(!$aliases->EOF){
					self::$aliases[] = 	array(	'link'	=>	$aliases->fields['link_url'],
												'alias'	=>	$aliases->fields['link_alias']);
					$aliases->MoveNext();	
				}
				
				$_SESSION['ssu_aliases'] = self::$aliases;
			}
		}
		
		// Aliases needed to be loaded on demand
		static function retrieveAliasesOnDemand($params, $field, $compare, $links, $aliases, $status=null){
			$elements_to_query = array_diff(explode('/',$params), self::$$compare);
			if(count($elements_to_query) > 0)	{
				foreach($elements_to_query as $element){
					$conditions[] = "$field LIKE '%/$element/%' ";	
				}
				$conditions = implode(' OR ', $conditions);
				$query_string = 'SELECT DISTINCT link_url, link_alias FROM '.TABLE_LINKS_ALIASES." WHERE ($conditions)";
				$query_string .= !empty($status) ? " AND status = $status" : '';
				global $db;
				$alias_result = $db->Execute($query_string);
				while(!$alias_result->EOF){
					array_push(self::$$aliases, $alias_result->fields['link_alias']);
					array_push(self::$$links, $alias_result->fields['link_url']);
					$alias_result->MoveNext();	
				}
			}
		}
		
		static function aliasToLink(&$params){
			self::retrieveAliasesOnDemand($params, 'link_alias', 'aliases', 'links', 'aliases');
			$params = trim(str_replace(self::$aliases, self::$links, "/$params/"), '/');
			
		}
		
		static function linkToAlias(&$params){
			self::retrieveAliasesOnDemand($params, 'link_url', '_links', '_links', '_aliases', 1);
			$params = trim(str_replace(self::$_links, self::$_aliases, "/$params/"), '/');
		}
	}