<?php
	class SSULink{
		protected $original_uri;
		protected $redirect_type	=	0;
		protected $alias_filename;
		
		/**
		 * Rebuilds $_GET array
		 * Takes care of redirection if needed
		 */
		public function parseURL(){
			global $request_type;
			
			// get out if SSU is off or this is not an index.php page		
			if(!SSUConfig::registry('configs', 'status') || (end(explode('/', $_SERVER["SCRIPT_NAME"])) != 'index.php'))
				return false;
				
			// remove the catalog dir from the link	
			$catalog_dir = SSUConfig::registry('paths', 'catalog');
			$regex = array('/'.str_replace('/','\/', $catalog_dir).'/');
			$this->original_uri = trim($catalog_dir=='/' ? $_SERVER['REQUEST_URI'] : preg_replace($regex,'', $_SERVER['REQUEST_URI'], 1), '/');
			
			// if the index.php is in the url, lets see if we need to rebuild the path and redirect.
			if((strpos($this->original_uri, 'index.php') !== false)){
				if(!isset($_GET['main_page']) || empty($_GET['main_page'])){ 
					$_GET['main_page'] = 'index';
					$this->original_uri = $this->original_uri. '&main_page=index';
				}
				if($this->checkPageExcludedList($_GET['main_page']))
					return false;
				$this->redirect_type = 2;
				return false;
			}
			
			// if we are using multi-lang, then we should have language code at the very beginning
			if(SSUConfig::registry('configs', 'multilang_status')){
				$languages_code = substr($this->original_uri, 0, 2);
				if(!array_key_exists($languages_code, SSUConfig::registry('languages')))
					$this->redirect_type = 1;
				else{
					$_get['language'] = $languages_code;
					$this->original_uri   = trim(substr($this->original_uri, 2), '/');
				}
			}
			
			if(empty($this->original_uri)){
				$_get['main_page'] = 'index';
			}
			else{
				// if we have a link like this http://site.com/en/?blah=blahblah, we assume it is an index page
				if(substr($this->original_uri, 0, 1) == '?'){
					parse_str(trim($this->original_uri, '?'), $_get);
					if(!isset($_get['main_page']))
						$_get['main_page'] = 'index';
					$this->rebuildENV($_get, $catalog_dir);
					$this->redirect_type = 1;
					return false;
				}
				
				$this->original_uri = str_replace(array('&amp;','&','=','?'),'/', $this->original_uri);
				
				// if we are using link alias, lets attempt to get the parsed content from cache
				if(SSUConfig::registry('configs', 'alias_status')){
					$this->alias_filename = md5($_SERVER['REQUEST_URI']);
					if(($alias_get_array = SSUCache::read($this->alias_filename, 'aliases')) !== false){
						parse_str($alias_get_array, $_get);
						$this->rebuildENV($_get, $catalog_dir);
						$this->redirect_type = 1;
						return true;
					}
					else
						SSUAlias::aliasToLink($this->original_uri);
				}

				// explode the params link into an array
				$parts = explode('/', preg_replace('/\/\/+/', '/', $this->original_uri));		
				
				// identify and assign main page
				if(!isset($_get['main_page'])){
					$parsers = SSUConfig::registry('plugins', 'parsers');
					foreach($parsers as $key => $parser)
						if(call_user_func_array(array("{$parser}Parser", "identifyPage"), array(&$parts, &$_get))){
							unset($parsers[$key]);
							$this->redirect_type = 1;
							break;
						}
						
					// found nothing?
					if(!isset($_get['main_page'])){
						$_get['main_page'] = $parts[0];
						unset($parts[0]);
					}
				}
				
				/*
				 * This is where we loop thru the query parts and put things into their places
				 * We need to do it this way because we want to keep the generated GET array in the correct order.
				 */
				$parts 		 = array_values($parts);
				$parts_count = count($parts);
				for($counter = 0; $counter < $parts_count; $counter++){
					$parser_encountered = false;
					foreach($parsers as $key => $parser){
						if(call_user_func_array(array("{$parser}Parser", "identifyName"), array($parts[$counter]))){
							call_user_func_array(array("{$parser}Parser", "updateGet"), array($parts[$counter], &$_get));
							$this->redirect_type = 1;
							$parser_encountered = true;
							unset($parsers[$key]);
							break;
						}
					}
					if(!$parser_encountered)
						$_get[$parts[$counter]] = isset($parts[$counter+1]) ? $parts[++$counter] : '';
				}

				// remove extension, it's in the link just for show 
				$extension = SSUConfig::registry('configs', 'extension');
				if(!empty($extension))
					$_get['main_page'] = str_replace(".$extension", '', $_get['main_page']);
				}
				$this->rebuildENV($_get, $catalog_dir);
			
			return true;
		}
		
		/*
		 * If our current link contains names, we want to make sure the names are correct, 
		 * otherwise we do a redirection
		 */
		public function postParseURL(){
        global $request_type;
        if($this->redirect_type==1){
             $params = '';
             // here we will attempt to rebuild the link using $_get array, and see if it matches the current link
             // we want to take out zenid however
             $page = '';
             $temp = $_GET;
             
             if(isset($temp['main_page'])) {$page = $temp['main_page']; unset($temp['main_page']);}
             
             // no need to include session id
            if(isset($temp[zen_session_name()])) unset($temp[zen_session_name()]);
            
             foreach($temp as $key => $value)
                $params .= '&' . $key . '=' . $value;
            
            $regenerated_link = $this->ssu_link($page, $params, $request_type);
        }
        elseif($this->redirect_type==2){
            $regenerated_link = $this->ssu_link($this->original_uri, '', $request_type);
        }


        if(isset($regenerated_link) && ($this->curPageURL() != $regenerated_link)){
            $this->redirect($regenerated_link);
        }
        // save alias to avoid re-scanning
        elseif(SSUConfig::registry('configs', 'alias_status') && !$this->checkPageExcludedList($_GET['main_page']))
            SSUCache::write($this->alias_filename, 'aliases', http_build_query($_GET));
    }  
		
		protected function curPageURL() {
			global $request_type;
			if($request_type == 'SSL' && ENABLE_SSL == 'true')
				$pageURL = HTTPS_SERVER;
			else 
				$pageURL = HTTP_SERVER;

		 	return $pageURL.$_SERVER["REQUEST_URI"];
		}
		
		// currently we support only 1 type of redirection: 301 permanent redirection
		protected function redirect($link){
			if($link === false) $link = SSUConfig::registry('paths', 'link');
			
			// Set POST form info / alpha testing
			if($_SERVER["REQUEST_METHOD"] == 'POST')
				$_SESSION['ssu_post'] = $_POST;
			
			Header( "HTTP/1.1 301 Moved Permanently" );
			Header( "Location: $link" );
			exit;
		}
		
		/**
		 * Enter description here...
		 *
		 * @param unknown_type $_get
		 */
		protected function rebuildENV($_get, $catalog_dir){
			$_GET = $_get;
			$_REQUEST = array_merge($_REQUEST, $_GET);
			// rebuild $PHP_SELF which is used by ZC in several places
			$GLOBALS['PHP_SELF'] = $catalog_dir.'index.php';
			
			// Catch POST form info in case we were redirected here / alpha testing
			if(isset($_SESSION['ssu_post'])){
				$_POST = $_SESSION['ssu_post'];
				$_REQUEST = array_merge($_REQUEST, $_POST);
				unset($_SESSION['ssu_post']);
			}
		}
		
		/* 
		 * Builds the ssu links
		 * Takes the same params as zencart zen_href_link function
		 */
		public function ssu_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true, $static = false, $use_dir_ws_catalog = true){
			global $request_type, $session_started, $http_domain, $https_domain;
			$link = $sid = '';
			$languages_code = SSUConfig::registry('configs', 'languages_code');

			// if we SSU is off, we return the task to zen's original function.
			if(!SSUConfig::registry('configs', 'status'))
				return false;
				
			// if this is anything other than index.php, dont ssu it
			if(strpos($page, '.php') !== false && strpos($page, 'index.php') === false)
				return false;
			
			if(!empty($parameters) || !empty($page)){
				// this is for the way ZC builds ezpage links. $page is empty and $parameters contains main_page
				// remember. non-static links always have index.php?main_page=
				// so first we check if this is static
				if(strpos($page, 'main_page=') !== false){
					$parameters = $page;
				}
				
				// remove index.php? if exists
				if(($index_start = strpos($parameters, 'index.php?')) !== false) $parameters = substr($parameters, $index_start+10);

				// put the "page" into $page, and the rest into $parameters
				if((strpos($parameters, 'main_page=')) !== false){
					parse_str($parameters, $_get);
					$page = $_get['main_page'];
					unset($_get['main_page']);
					$parameters = http_build_query($_get);	
				}
				elseif($static && empty($parameters)){
					return false;
				}
				
				// if we reach this step with an empty $page, let zen handle the job
				if(empty($page))
					return false;
					
				// if this page is our exclude list, let zen handle the job
				if($this->checkPageExcludedList($page)) return false;				
				
				$parameters = $this->parseParams($languages_code, $page, $parameters);
			}
					
			// Build session id
			if ( ($add_session_id == true) && ($session_started == true) && (SESSION_FORCE_COOKIE_USE == 'False') ) {
				if (defined('SID') && zen_not_null(SID)) {
					$sid = SID;
				} elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL == 'true') ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
					if ($http_domain != $https_domain) {
						$sid = zen_session_name() . '=' . zen_session_id();
					}
				}
			}

			if((substr($parameters, 0, 1) == '?' || empty($parameters)) && $page == 'index')
				$page = '';
				
			// build the http://www.site.com
			if($connection == 'SSL' && ENABLE_SSL == 'true')
				$link = HTTPS_SERVER . ($use_dir_ws_catalog ? DIR_WS_HTTPS_CATALOG : '');
			else 
				$link = HTTP_SERVER . ($use_dir_ws_catalog ? DIR_WS_CATALOG : '');
			
			$link = trim($link, '/');
						
			$languages_code = SSUConfig::registry('configs', 'multilang_status') ? $languages_code : '';
			
			if(SSUConfig::registry('configs', 'multilang_status'))
				$link .= "/$languages_code";

			if(!empty($page))
				if(empty($parameters)){
					$extension = SSUConfig::registry('configs', 'extension');
					$extension = empty($extension) ? $extension : ".$extension";
					$link .= "/$page$extension";
				}
				else 
					$link .= "/$page";
						
			if(!empty($parameters))
				$link .= "/$parameters";

			$link = str_replace('/?', '?', $link);
			
			// append sid
			if(!empty($sid))
				$link .= (strpos($link , '?') ? '&' : '?').$sid;
				
			return $link;
		}
		
		/* 
		 * Takes the parameters in the query string and turns that to our nice looking link
		 */
		function parseParams(&$languages_code, &$page, $parameters){
			$parameters = trim($parameters,' ?&');
			$set_cache 	= false;
			$query_string = $params = '';
			$main_page = $page;
			$languages_id = SSUConfig::registry('configs', 'languages_id');
			
			if(!empty($parameters)){
				$parsers = SSUConfig::registry('plugins', 'parsers');
				$cache_filename = md5($page.$parameters);
				
				foreach($parsers as $key => $parser){
					if(call_user_func_array(array("{$parser}Parser", "identifyPage2"), array(&$page, $parameters)) !== false){
						if(($params = SSUCache::read("{$cache_filename}_{$languages_code}", 'pc')) !== false)
							return $params;
						$set_cache = true;
					}
					elseif(call_user_func_array(array("{$parser}Parser", "identifyParam"), array($parameters)) !== false){
						if(($params = SSUCache::read("{$cache_filename}_{$languages_code}", 'pc')) !== false)
							return $params;
						$set_cache = true;
						//unset($parsers[$key]);
					}
					else 
						unset($parsers[$key]);
				}
				
				// take out the empty variables
				$params = array();
				parse_str($parameters, $parameters);
				
				// parse language
				if(isset($parameters['language']) && !empty($parameters['language']) && ($languages_id = $this->getLanguagesID($parameters['language'])) !== false){
					$languages_code = $parameters['language'];
					if(SSUConfig::registry('configs', 'multilang_status')){
						unset($parameters['language']);
					}
				}
				
				foreach($parameters as $key => $value){
					if(!empty($value)){
						// exclude certain query keys from being seo-iezed
						if($this->checkQueryExcludedList($key))
							$query_string .= $key.'='.$value.'&';
						else{
							$params[] = $key;
							$params[] = $value;
						}
					}
				}
				
				$parameters = $params;
						
				foreach($parsers as $key => $parser)
					call_user_func_array(array("{$parser}Parser", "parseParam"), array($main_page, &$parameters, $languages_id, $languages_code));
				
				$params = implode('/', $parameters);	
				
				while(strpos($params,'//') !== false) $params = str_replace('//', '/', $params);
			
				if(SSUConfig::registry('configs', 'alias_status')){
					SSUAlias::linkToAlias($params);
					
				}
	
			}
			
			if(SSUConfig::registry('configs', 'alias_status') && !empty($page)){
				SSUAlias::linkToAlias($page);
			}
			
			// we cache the whole link so that we dont have to recalculate it again
			
			$params .= !empty($query_string) ? '?'.trim($query_string,'&') : '';
			
			if($set_cache) SSUCache::write("{$cache_filename}_{$languages_code}", 'pc', $params); 
			
			return $params;
		}
		
		function checkPageExcludedList($string){
			if(in_array($string, SSUConfig::registry('configs', 'pages_excluded_list')))
				return true;
			return false;
		}
		
		function checkQueryExcludedList($page){
			if(in_array($page, SSUConfig::registry('configs', 'queries_excluded_list')))
				return true;
			return false;
		}
		
		function getLanguagesID($languages_code){
			global $db;
			$languages_query = "select languages_id from " . TABLE_LANGUAGES . " 
		                          WHERE code = '$languages_code' LIMIT 1";

    		$languages = $db->Execute($languages_query);
    		if($languages->RecordCount() > 0)
    			return $languages->fields['languages_id'];
    		return false;
		}
	}