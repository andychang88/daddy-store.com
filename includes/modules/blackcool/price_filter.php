<?php
  if(!defined('IS_ADMIN_FLAG')){
     die('Illegal Access');
  }
  $need_filter=false;
  $price_filter_sql='';
  $pf_from='';
  $pf_to='';
  //fitler action
  if($current_page_base=='index' && $category_depth=='products'){
     if(isset($_GET['price_filter_from']) && isset($_GET['price_filter_to'])){
	      if(empty($_GET['price_filter_from']) && empty($_GET['price_filter_to'])){//select 'all' then show all
			  unset($_SESSION['pf_from']);
			  unset($_SESSION['pf_to']);
		  }else if( is_numeric($_GET['price_filter_from']) && is_numeric($_GET['price_filter_from']) 
		           && $_GET['price_filter_from']>=0 && ($_GET['price_filter_from']<$_GET['price_filter_to']) ){
			  //select specific price range then show items in specific price range
	 
			  $price_filter_sql.='  and p.products_price >='.(int)$_GET['price_filter_from'].' and p.products_price <='.(int)$_GET['price_filter_to'].'  ';
			  $_SESSION['pf_from']=$_GET['price_filter_from'];
			  $_SESSION['pf_to']=$_GET['price_filter_to'];
			  $need_filter=true;			  
		  }
		  $_SESSION['pfilter_cate_id']=$current_category_id;//be used to check category switch or not
	 }else{
	     if(isset($_SESSION['pfilter_cate_id']) && $_SESSION['pfilter_cate_id']==$current_category_id) {// the same category with prviouse page
			  if(isset($_SESSION['pf_from']) && isset($_SESSION['pf_to'])){
				 $price_filter_sql.='  and p.products_price >='.(int)$_SESSION['pf_from'].' and p.products_price <='.(int)$_SESSION['pf_to'].'  ';
				 $need_filter=true;
			  }
		 }else{//another different category, so remove the display order 
		      unset($_SESSION['ss_disp_order']);
		 }
	 } 
	 
	  //get price range
	  $need_price_range=false;
	  $price_range_arr=array();
	  $pf_range_sql='select max(p.products_price) price_max,min(p.products_price) price_min 
					 from products p
					 left join products_to_categories p2c 
					 on p.products_id=p2c.products_id 
					 where p2c.categories_id='.$current_category_id;
	  $pf_range_db=$db->Execute($pf_range_sql);
	  if($pf_range_db->RecordCount()>0){
		 $price_max=$pf_range_db->fields['price_max'];
		 $price_min=$pf_range_db->fields['price_min'];
		 
		 $price_per_range=$price_max/PRICE_FILTER_CLASS;
		 
		 if(($price_max-$price_min)>$price_per_range){
		   $need_price_range=true;
		 }
		 $tmp_pf=0;
		 while(($price_per_range*$tmp_pf)<$price_max){	   
			  $price_range_arr[]=array('p_from'=>$currencies->value(ceil($price_per_range*$tmp_pf),true),
									   'p_to'=>$currencies->value(ceil($price_per_range*($tmp_pf+1)),true)
									   );
			  $tmp_pf++; 
			  $need_price_range=true;
		 }
	  }	 
  } 
?>