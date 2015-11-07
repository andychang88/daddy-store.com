<?php
    require_once 'includes/configure.php';
	if(empty($_GET['review_id']) || !(isset($_GET['review_id'])) || (!is_numeric($_GET['review_id'])) || $_GET['review_id']<=0 ){
		 echo 'RIDERROR';
		 exit;
    }
    if(!(isset($_GET['status_value'])) || ($_GET['status_value']!=1 &&$_GET['status_value']!=0) ){
		 echo 'STATUSERROR';
		 exit;
    }
	if(isset($_GET['review_id']) && isset($_GET['status_value'])){
      $status_value=($_GET['status_value']==1)?0:1;	  
	  $review_id=$_GET['review_id'];	  
	  
	  $review_verify_conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD);
	  $review_verify_db=mysql_select_db(DB_DATABASE);
	  
	  $result_verfiy='';
	  $review_verify_sql='update reviews set status='.(int)$status_value.' where reviews_id='.$review_id;	   
	  if(mysql_query($review_verify_sql)){
	     if($status_value==1){
		    echo '1'; 
		 }else{
		    echo '0';
		 }		 
	     exit;
	  }else{
	     echo 'upate error';
		 exit;
	  }       
    }
?>