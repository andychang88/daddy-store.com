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
	  
	  $review_undig_conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD);
	  $review_undig_db=mysql_select_db(DB_DATABASE);
	  
	  $result_undig='';
	  $review_sql='select no_cnt from reviews where reviews_id='.$review_id.' and products_id='.$products_id;
	   
	  $review_query=mysql_query($review_sql);
	  if(mysql_num_rows($review_query)>0){	 
		  $undig_sql='update  reviews  set no_cnt=no_cnt+1
					  where   reviews_id ='.$review_id.'
			    	  and     products_id = '.$products_id;
		  if(mysql_query($undig_sql)){
				$no_cnt=mysql_fetch_array($review_query,MYSQL_ASSOC);
				$result_undig=$no_cnt['no_cnt']+1;
				echo $result_undig;
				mysql_close($review_undig_conn);
				exit;
		  }else{
		        echo 'UNDIGERROR';
		        exit;
		  }
	  }	
	        
   }
?>