<?php
    require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
    $breadcrumb->add(NAVBAR_TITLE);
	for ($i=65; $i<91; $i++) {
      $pt_list[] =chr($i);
    }
	for ($t=0; $t<10; $t++) {
	  $pt_list[] =$t;
	}
	if(zen_not_null($_GET['tag']) && in_array(trim($_GET['tag']),$pt_list) ){
	  
	  /*$pname_like_str='';
	  if($_GET['tag']=='0-9'){
	     for($j=0;$j<10;$j++){
	     	$pname_like_arr[]='  pd.products_name like "'.$j.'%" ';
		 }
		 $pname_like_str=' 	 and ('.implode(' or ',$pname_like_arr).' )  ';
	  }else{
	     $pname_like_str='   and   pd.products_name like "'.trim($_GET['tag']).'%" ';
	  }*/
	  $pname_like_str='   and   pd.products_name like "'.trim($_GET['tag']).'%" ';
	  
	  $products_tag_sql='select distinct pd.products_name,p.products_id  
						 from '.TABLE_PRODUCTS.' p,
							 '.TABLE_PRODUCTS_DESCRIPTION.' pd,
							 '.TABLE_PRODUCTS_TO_CATEGORIES.' p2c,
							 '.TABLE_CATEGORIES.' c
						 where p.products_id=pd.products_id 
						 and   p.products_id=p2c.products_id
						 and   p2c.categories_id=c.categories_id 
						 and   p.products_status=1 
						 and   c.categories_status=1 
						 and   pd.language_id='.(int)$_SESSION['languages_id'].$pname_like_str.' 					
						 order by pd.products_name desc ';
							
	 $products_tag_db=$db->Execute($products_tag_sql);
	 $products_tags=array();
	 if($products_tag_db->RecordCount()>0){
	    while(!$products_tag_db->EOF){
		   $pname=zen_trunc_string($products_tag_db->fields['products_name'],16,true);
		   $tid=$products_tag_db->fields['products_id'];
		   $plink=zen_href_link(zen_get_info_page($tid),'products_id='.$tid);
		   
		   $products_tags[]=array('product_name'=>$pname,
		                          'product_link'=>$plink);
								  
		   $products_tag_db->MoveNext();
		}
	 }
			
	}else{
	   zen_redirect(zen_href_link(FILENAME_DEFAULT));
	}
?>