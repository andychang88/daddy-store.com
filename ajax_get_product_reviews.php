<?php
   require_once 'includes/configure.php';
   require_once 'includes/extra_configures/other_configure.php';
   if(empty($_GET['review_pid']) || !(isset($_GET['review_pid'])) || (!is_numeric($_GET['review_pid'])) || $_GET['review_pid']<=0 ){
     echo 'PIDERROR';
	 exit;
   }
   if(empty($_GET['lng_id']) || !(isset($_GET['lng_id'])) || ( !is_numeric($_GET['lng_id'])) || $_GET['lng_id']<=0 ){
     echo 'LNGIDERROR';
	 exit;
   }
   if(empty($_GET['pageno']) || !(isset($_GET['pageno'])) || ( !is_numeric($_GET['pageno'])) || $_GET['pageno']<=0 ){
     echo 'PAGENOERROR';
	 exit;
   }
   if(isset($_GET['review_pid']) && isset($_GET['lng_id']) && $_GET['pageno']>0){
      $products_id=$_GET['review_pid'];	  
	  $language_id=$_GET['lng_id'];	  
	  $pageno=$_GET['pageno'];
	  
	  $helpful=$_GET['helpful'];
	  $nothelpful=$_GET['nothelpful'];
	  $helpful_or_not=$_GET['helpful_or_not'];
	  
	  $text_price_vr=$_GET['text_price_vr'];
	  $text_value_vr=$_GET['text_value_vr'];
	  $text_quality_vr=$_GET['text_quality_vr'];
	  
	  $pr_conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD);
	  $pr_db=mysql_select_db(DB_DATABASE);
	  //mysql_query('set names utf8');
	  $result_html='';
	  //get split page info
	  $pr_total=0;
	  $pr_pages=0;
	  $pr_total_sql='select r.reviews_id 
					 from   reviews r, 
						    reviews_description rd 
					 where r.products_id ='.$products_id.'
					 and   r.status = 1
					 and   r.reviews_id = rd.reviews_id 
					 and   rd.languages_id = '.$language_id.' 
					 and   rd.reviews_text !=""'; 
	  $pr_total_query=mysql_query($pr_total_sql);
	  if($pr_total=mysql_num_rows($pr_total_query)){
	      $pr_pages=ceil($pr_total/PRODUCTS_REVIEW_PER_PAGE);
		
		  //get needed records
		  $pr_records_sql='select
		                         r.reviews_id,
								 r.price_rating,
								 r.value_rating,
								 r.quality_rating,											
								 r.customers_name,
								 r.date_added, 
								 rd.reviews_text,
								 r.yes_cnt,
								 r.no_cnt
						   from  reviews r,
								 reviews_description rd 
						   where r.products_id = '.$products_id.'
						   and   r.reviews_id=rd.reviews_id
						   and   rd.languages_id = '.$language_id.' 
						   and   r.status=1 
						   order by r.date_added DESC 
						   limit '.(($pageno-1)*PRODUCTS_REVIEW_PER_PAGE).",".PRODUCTS_REVIEW_PER_PAGE;   
		  $pr_records_query=mysql_query($pr_records_sql);
		  if(mysql_num_rows($pr_records_query)>0){
			 while($pr_data=mysql_fetch_assoc($pr_records_query)){
			    $result_html.='<div class="reviews_msg">
									<p class="reviews_name">
										<strong>By '.$pr_data['customers_name'].'</strong>
										<span class="reviews_right">
											<font class="gray_date">'.$pr_data['date_added'].'</font>
										</span>
									</p>
									<table border="0" class="reviews_price">
									  <tbody>
										  <tr>
											<td><strong>'.$text_price_vr.'</strong></td>
											<td>
											   <img src="includes/templates/blackcool/images/stars_'.$pr_data['price_rating'].'.gif">
											</td>
											<td><strong>'.$text_value_vr.'</strong></td>
											<td>
											    <img src="includes/templates/blackcool/images/stars_'.$pr_data['value_rating'].'.gif">
											</td>
											<td><strong>'.$text_quality_vr.'</strong></td>
											<td>
											    <img src="includes/templates/blackcool/images/stars_'.$pr_data['quality_rating'].'.gif">
											</td>
										  </tr>
									  </tbody>
									</table>
									<p class="reviews_content">'.strip_tags($pr_data['reviews_text']).'</p>
									<p class="reviews_evaluate">'.$helpful_or_not.'
									  <input class="Ja" name="Ja" type="button" id="yesid'.$pr_data['reviews_id'].'" 
									         value="'.$helpful.'('.$pr_data['yes_cnt'].')" yesid="'.$pr_data['reviews_id'].'" />
									  <input class="Nein" name="Nein" type="button" id="noid'.$pr_data['reviews_id'].'" 
									         value="'.$nothelpful.'('.$pr_data['no_cnt'].')" noid="'.$pr_data['reviews_id'].'"/>
									</p>
									<hr />
							   </div>';
			 }
			 if($pr_pages>1){
			     $result_html.='<div class="scott2"><div id="pages_r"><ul id="previews_pages_nav">';
				 for($pr_pi=0;$pr_pi<$pr_pages;$pr_pi++){
					if(($pr_pi+1)==$pageno){
					    $result_html.='<li class="review_currpage" id="'.($pr_pi+1).'">'.($pr_pi+1).'</li>';
					}else{
					    $result_html.='<li id="'.($pr_pi+1).'">'.($pr_pi+1).'</li>';
					}
				 }
				 $result_html.=' </ul></div></div>';
			 }
		  } 
	  }
	  mysql_close($pr_conn);
	  echo $result_html;
	  exit;    
   }
?>