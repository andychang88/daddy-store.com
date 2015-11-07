<?php



// the following IF statement can be duplicated/modified as needed to set additional flags

  if (in_array($current_page_base,explode(",",'list_pages_to_skip_all_right_sideboxes_on_here,separated_by_commas,and_no_spaces')) ) {

    $flag_disable_right = true;

  }





  $header_template = 'tpl_header.php';

  $footer_template = 'tpl_footer.php';

  $left_column_file = 'column_left_ucenter.php';

  $right_column_file = 'column_right.php';

  $body_id = ($this_is_home_page) ? 'indexHome' : str_replace('_', '', $_GET['main_page']);

?>




  
  
  
  
<div class="all_efox">

<?php




 /**
  * prepares and displays header output
  *
  */
  if (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_HEADER_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == '')) {
    $flag_disable_header = true;
  }
  
  if(empty($flow_checkout)){
    $tpl_header = "tpl_header.php";
  }else{
    $tpl_header = "tpl_header_checkout.php";
  }
  

  require($template->get_template_dir($tpl_header,DIR_WS_TEMPLATE, $current_page_base,'common'). '/'.$tpl_header);
  
  
  ?>
<?php

 /**

  * prepares and displays header output

  *

  */

  if (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_HEADER_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == '')) {

    $flag_disable_header = true;

  }

  //require($template->get_template_dir('tpl_header.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_header.php');
  ?>  

<div class="center">  

   
	<div class="clear"></div>

	<div class="uc">
				<?php require($template->get_template_dir('tpl_account_left.php',DIR_WS_TEMPLATE, 
														  $current_page_base,
														  'common'). '/tpl_account_left.php');?>
			    <?php require($body_code); ?>

	</div>	 

	

		
	<div class="clear"></div>

		

</div><?php //end center div ?>

<?php

     if(zen_page_path_check($current_page_base,$p_recommend_content_chk) || $user_in_center){

	  require($template->get_template_dir('tpl_modules_products_recommend.php',

	                                       DIR_WS_TEMPLATE, 

										   $current_page_base,

										   'templates'). '/tpl_modules_products_recommend.php');

	 }									 

?>

<?php

     require($template->get_template_dir('tpl_footer.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_footer.php');

?>
</div>
</body>