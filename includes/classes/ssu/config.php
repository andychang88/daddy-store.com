<?php

	$ssuConfig = array(
	'cores'			=>	array('plugin', 'link', 'language', 'alias', 'cache' , 'parser'),
	// We define plugins in array so that we can just disable any plugin anytime we want
	'plugins'		=>	array(// we can have more than 1 plugin type here
								'parsers'	=>	array('products', 'categories', 'pages')
							),
	
	'identifiers'	=>	array(	'products'		=>	array(	'product_info'					=>	'p',
															'product_music_info'			=>	'm',
															'document_general_info'			=>	'g',
															'document_product_info'			=>	'd',
															'product_free_shipping_info'	=>	'f',
															'document_website_info'			=>	'w',
															),
								'categories'	=>	'c',
								'pages'			=>	'page',
								'manufacturers'	=>	'manufacturer'
								),
								
	'configs'		=>	array('status'				=> 	SSU_STATUS == 'true' ? true : false,
							'alias_status'			=>	SSU_LINK_ALIAS == 'true' ? true : false,
							'multilang_status'		=>	SSU_MULTI_LANGUAGE_STATUS == 'true' ? true : false,
							'extension'				=>	SSU_FILE_EXTENSION,
							'max_level'				=>	(int)SSU_MAX_LEVEL,
							'minimum_word_length'	=>	(int)SSU_MINIMUM_WORD_LENGTH,
							'max_name_length'		=>	(int)SSU_MAX_NAME_LENGTH,
							'pages_excluded_list'	=>  explode(',', SSU_EXCLUDE_LIST),
							'queries_excluded_list'	=>  explode(',', SSU_QUERY_EXCLUDE_LIST)
								),
								
	'paths'			=>	array('cores'		=>  DIR_FS_CATALOG.DIR_WS_CLASSES.'ssu/cores/',
							'cache'			=>	DIR_FS_SQL_CACHE.'/ssu/',
							'catalog'		=>	($request_type == 'NONSSL') ? DIR_WS_CATALOG : DIR_WS_HTTPS_CATALOG,
							'plugins'		=>	DIR_FS_CATALOG.DIR_WS_CLASSES.'ssu/plugins/',
							'link'			=>	($request_type == 'NONSSL') ? HTTP_SERVER.DIR_WS_CATALOG : HTTPS_SERVER.DIR_WS_HTTPS_CATALOG),
								
	'delimiters'	=>	array(	'id'	=>	SSU_ID_DELIMITER,
								'name'	=>	SSU_NAME_DELIMITER),
								
	'languages'		=>	array(	'default'	=>	'default',
								'en'		=>	'default')
	);