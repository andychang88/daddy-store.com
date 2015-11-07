<?php
   require_once 'includes/configure.php';
   if(empty($_GET['review_pid']) || !(isset($_GET['review_pid'])) || (!is_numeric($_GET['review_pid'])) || $_GET['review_pid']<=0 ){
     echo 'PIDERROR';
	 exit;
   }
   if(empty($_GET['review_id']) || !(isset($_GET['review_id'])) || ( !is_numeric($_GET['review_id'])) || $_GET['review_id']<=0 ){
     echo 'RIDERROR';
	 exit;
   }
   if(isset($_GET['review_pid']) && isset($_GET['review_id'])){
      $products_id=$_GET['review_pid'];	  
	  $review_id=$_GET['review_id'];	  
	  
	  $review_dig_conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD);
	  $review_dig_db=mysql_select_db(DB_DATABASE);
	  
	  $result_dig='';
	  $review_sql='select yes_cnt from reviews where reviews_id='.$review_id.' and products_id='.$products_id;
	   
	  $review_query=mysql_query($review_sql);
	  if(mysql_num_rows($review_query)>0){	 
		  $dig_sql='update  reviews  set yes_cnt=yes_cnt+1
					where   reviews_id ='.$review_id.' 
					and     products_id = '.$products_id;
		  if(mysql_query($dig_sql)){
				$yes_cnt=mysql_fetch_array($review_query,MYSQL_ASSOC);
				$result_dig=$yes_cnt['yes_cnt']+1;
				echo $result_dig;
				mysql_close($review_dig_conn);
				exit;
		  }else{
		        echo 'DIGERROR';
				exit;
		  }
	  }	
	        
   }
?>