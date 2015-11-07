<?php
	$langConfig = array('languages_code'		=>	isset($_SESSION['languages_code']) ? $_SESSION['languages_code'] : DEFAULT_LANGUAGE,
						'languages_id'			=>	isset($_SESSION['languages_id']) ? $_SESSION['languages_id'] : 1,
												);
												
	SSUConfig::registerArray('configs', $langConfig);