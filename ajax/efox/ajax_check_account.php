<?php
	//#############validate email_address data from browser############START
	
chdir('../../');
error_reporting(0);
	
	//email valid function 
	function validate_email($email_address){
		require_once 'includes/configure.php';   
//		require_once 'includes/extra_configures/other_configure.php';
	
		$pr_conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD);
		$pr_db=mysql_select_db(DB_DATABASE);	
			
//		usleep(150000); 
		$email_address = trim($email_address);
		
	    $check_email_query = "select count(*) as total
							  from customers
							  where customers_email_address = '" . $email_address . "'
							  and   COWOA_account != 1";
	    
	    $check_email = mysql_fetch_array(mysql_query($check_email_query));	    
		
	    if ($check_email['total'] > 0) {
	      $valid = 'email already exists';   
	    }else{
	      $valid = 1; 	
	    }
	    mysql_close();
	    return $valid; 			
	}
			  
	//ajax  valid email
	if(isset($_GET['email']) && $_GET['email'] !=''){
		echo validate_email($_GET['email']);
	}	
	
?>