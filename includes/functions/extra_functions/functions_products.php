<?php
  /*
   *functons for products operations
   *author:john
   *date:2010-03-20
   *oasis
   */
   function zen_get_reviews_of_product($products_id=0,$curr_page=0){
	   global $db,$template,$current_page_base;
	   if(!is_numeric($products_id) || $products_id==0) return array();
	   
	   $data_reviews = array ();
	   //$db->Execute('set names utf8');
	   $reviews_db = $db->Execute("select
	                                     r.reviews_id,
										 r.price_rating,
										 r.value_rating,
										 r.quality_rating,											
										 r.customers_name,
										 r.date_added, 
										 rd.reviews_text,
										 r.yes_cnt,
										 r.no_cnt
								   from ".TABLE_REVIEWS." r,
									    ".TABLE_REVIEWS_DESCRIPTION." rd
								   where r.products_id = '".$products_id."'
								   and   r.reviews_id=rd.reviews_id
								   and   rd.languages_id = '".$_SESSION['languages_id']."'
								   and   r.status=1 
								   order by r.date_added DESC 
								   limit ".($curr_page*PRODUCTS_REVIEW_PER_PAGE).",".PRODUCTS_REVIEW_PER_PAGE);
		if ($reviews_db->RecordCount()>0) {
			//$row = 0;
			$data_reviews = array ();
			while (!$reviews_db->EOF) {
				//$row ++;
				$data_reviews[] = array ('reviews_id'=>$reviews_db->fields['reviews_id'],
				                         'author' => $reviews_db->fields['customers_name'], 
										 //'date' =>zen_date_short($reviews_db->fields['date_added']),
										 'date' =>$reviews_db->fields['date_added'], 
										 'value_rating'=>zen_image(DIR_WS_TEMPLATE_IMAGES.'stars_'.$reviews_db->fields['value_rating'].'.gif'),
										 'price_rating'=>zen_image(DIR_WS_TEMPLATE_IMAGES.'stars_'.$reviews_db->fields['price_rating'].'.gif'),
										 'quality_rating'=>zen_image(DIR_WS_TEMPLATE_IMAGES.'stars_'.$reviews_db->fields['quality_rating'].'.gif'),	    
										 'text' => $reviews_db->fields['reviews_text'],
										 'yes_cnt'=>$reviews_db->fields['yes_cnt'],
										 'no_cnt'=>$reviews_db->fields['no_cnt']
									     );
				/*if ($row == PRODUCT_REVIEWS_VIEW)
					break;*/
				$reviews_db->MoveNext();
			}
		}
		return $data_reviews;
   }
   function zen_get_reviews_of_product_count($products_id=0){
	   global $db;
	   
	   if(!is_numeric($products_id) || $products_id==0) return 0;
	   
	   $review_cnt=0;
	  
	   $reviews_db = $db->Execute("select r.reviews_id 
								   from ".TABLE_REVIEWS." r, 
								        ".TABLE_REVIEWS_DESCRIPTION." rd 
								   where r.products_id = '".$products_id."' 
								   and   r.status = 1
								   and   r.reviews_id = rd.reviews_id 
								   and   rd.languages_id = '".$_SESSION['languages_id']."' 
								   and   rd.reviews_text !=''");
	  if($reviews_db->RecordCount()>0){
	    $review_cnt=$reviews_db->RecordCount();
	  }	  
	  
	  return $review_cnt;	  	   
   }
   function zen_get_one_review_of_product($review_id){
	    global $db,$template,$current_page_base;
	    $data_review = array ();
		$review_db = $db->Execute("select
		                                 r.reviews_id,
										 r.value_rating,
										 r.price_rating,
										 r.quality_rating,
										 r.customers_name,
										 r.date_added,
										 rd.reviews_text,
										 r.yes_cnt,
										 r.no_cnt
								   from ".TABLE_REVIEWS." r,
										".TABLE_REVIEWS_DESCRIPTION." rd
								   where r.reviews_id=rd.reviews_id
								   and   rd.languages_id = '".$_SESSION['languages_id']."' 
								   and   r.reviews_id=".(int)$review_id." 
								   and   r.status=1");
		if ($review_db->RecordCount()>0) {
			//$row = 0;
			$data_review = array ();
			while (!$review_db->EOF) {
				//$row ++;
				$data_review[] = array ('reviews_id'=>$reviews_db->fields['reviews_id'],
				                        'author' => $review_db->fields['customers_name'], 
										//'date' => zen_date_short($review_db->fields['date_added']),
										'date' => $review_db->fields['date_added'], 										
										'value_rating'=>zen_image(DIR_WS_TEMPLATE_IMAGES.'stars_'.$review_db->fields['value_rating'].'.gif'),
										'price_rating'=>zen_image(DIR_WS_TEMPLATE_IMAGES.'stars_'.$review_db->fields['price_rating'].'.gif'),
										'quality_rating'=>zen_image(DIR_WS_TEMPLATE_IMAGES.'stars_'.$review_db->fields['quality_rating'].'.gif'),	
										'text' => $review_db->fields['reviews_text']);
				/*if ($row == PRODUCT_REVIEWS_VIEW)
					break;*/
				$review_db->MoveNext();
			}
		}
		return $data_review;
	}
   function zen_get_reviews_splitpage_info($pid=0){
       //global $db;
	   if(!is_numeric($pid) || $pid==0) return false;
	   $pr_total=zen_get_reviews_of_product_count($pid);
	   $pr_pages=ceil($pr_total/PRODUCTS_REVIEW_PER_PAGE);
	   return array('pr_total'=>$pr_total,
	                'pr_pages'=>$pr_pages
					);
   }
   
   function zen_get_average_rating($pid=0,$rcnt){
     global $db;
	 if(!is_numeric($pid) || $pid==0 || $rcnt==0) return 0;
	 $sum_rating_sql='select sum(r.price_rating) pr,sum(r.value_rating) vr,sum(r.quality_rating) qr
	                  from   '.TABLE_REVIEWS.' r 
					  where  r.products_id = '.$pid.' 
					  and    r.status=1';
	 $sum_rating_db=$db->Execute($sum_rating_sql);
	 $average_rating=0;
	 if($sum_rating_db->RecordCount()>0){
	    $sum_pr=$sum_rating_db->fields['pr'];
		$sum_vr=$sum_rating_db->fields['vr'];
		$sum_qr=$sum_rating_db->fields['qr'];
	    $average_rating=round(($sum_pr+$sum_vr+$sum_qr)/(3*$rcnt));
	 }
	 return $average_rating;
   }
   
   
   function getRecommendConfig($item_key, $return_rows = false){
   	global $db;
   	$sql = "select * from 2011recommend_config where item_key='{$item_key}' and is_delete=0";
   	$result = $db->Execute($sql);
   	
   	if ( $result->EOF ){
   		return array();
   	} else {
   		if ( $return_rows ){
   			return $result->fields;
   		}
   		
   		$item_value = $result->fields['item_value'];
   		$item_value = parseRecommendConfigVal($item_value);
   		return $item_value;
   		
   	}
   	
   }
   
   
   function parseRecommendConfigVal($item_value){
   	$matches = preg_split('/\r\n/', $item_value);
   	
   	return array_filter($matches);
   }
   /***********************************end*************************************************************/
?>