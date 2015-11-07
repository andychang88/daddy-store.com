<?php
	// load the default config file
	require (DIR_FS_CATALOG.DIR_WS_CLASSES.'ssu/config.php');	
	
	if(file_exists(DIR_FS_CATALOG.DIR_WS_CLASSES.'ssu/local.config.php'))
		require (DIR_FS_CATALOG.DIR_WS_CLASSES.'ssu/local.config.php');	
		
	// load the config class
	require (DIR_FS_CATALOG.DIR_WS_CLASSES.'ssu/core.php');	
	
	foreach ($ssuLocalConfig as $key => $config)
		foreach ($config as $subKey => $subConfig)
			if(!is_array($subConfig))
				$ssuConfig[$key][$subKey] = $ssuLocalConfig[$key][$subKey];
			else
				$ssuConfig[$key][$subKey] = array_merge($ssuConfig[$key][$subKey], $ssuLocalConfig[$key][$subKey]);
		
	SSUConfig::init($ssuConfig);
	
	// load the core classes
	foreach(SSUConfig::registry('cores') as $class)
		require(SSUConfig::registry('paths', 'cores')."{$class}.php");	
	
	// set identifiers
	foreach(SSUConfig::registry('identifiers') as $key => $identifier){
		if(is_array($identifier))
			foreach($identifier as $sub_key => $sub_identifier)
				$identifiers[$sub_key] = SSU_ID_DELIMITER.$sub_identifier.SSU_ID_DELIMITER;
		else
			$identifiers = SSU_ID_DELIMITER.$identifier.SSU_ID_DELIMITER;
		SSUConfig::register('identifiers', $key, $identifiers);
	}
	
	// init plugins
	foreach(SSUConfig::registry('plugins') as $className => $classArray){
		foreach($classArray as $plugin){
			require(SSUConfig::registry('paths', 'plugins')."$className/{$plugin}.php");	
		}
	}

	// init alias
	if(SSUConfig::registry('alias_status'))				
		SSUAlias::retrieveAliases();