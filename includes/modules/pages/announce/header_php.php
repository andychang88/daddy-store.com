<?php
   $anID=isset($_GET['anID'])?$_GET['anID']:'';
   if(zen_not_null($anID)&& is_numeric($anID)){	 	
	 	$announce_sql='select * from '.TABLE_ANNOUNCEMENT. ' 
		               where id='.(int)$anID.' 
					   and   is_visible=1 
					   and   languages_id='.(int)$_SESSION['languages_id'];
		
	 	$announce_db=$db->Execute($announce_sql);
		
	 	if($announce_db->RecordCount()>0){
	 		$announce=array();
			 while(!$announce_db->EOF){
				  $announce[]=array('title'=>$announce_db->fields['title'],
						            'date_added'=>$announce_db->fields['date_added'],
									'ann_content'=>$announce_db->fields['ann_content']
									);
				  $announce_db->MoveNext();									
			 }
	 	}else{
	 		zen_redirect(FILENAME_DEFAULT);
	 	}
	}else{
	 	zen_redirect(FILENAME_DEFAULT);
	}
    require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
	
?>