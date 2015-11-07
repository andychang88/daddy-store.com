<script type="text/javascript" src="<?php echo DIR_WS_INCLUDES; ?>templates/blackcool/login/register_or_login_html.js?<?php echo strtotime(date('Y-m'));?>" ></script>

<script type="text/javascript">
<?php if((!isset($_SESSION['customer_id']) || !zen_get_customer_validate_session($_SESSION['customer_id'])) && $_REQUEST['main_page']=='checkout'){?>	
                $(document).ready(function(){
                        checkout_L_to_R(2);
                });
<?PHP }
        if(isset($_SESSION['customer_id']) && $_SESSION['address_exist_status']==0 && (!$_SESSION['sendto']) && $_REQUEST['main_page']=='checkout'){
?>
                $(document).ready(function(){
                        enroll_address();
                });
<?php } ?> 
</script>


<div style="clear:both;"></div>
<div class="footer">	

     <?php //##################### Company Info, Company Policies, Customer Service, Payment & Shipping ##################################
	
				 require($template->get_template_dir('tpl_HSul.html',
													 DIR_WS_TEMPLATE,
													 $current_page_base,
													 'templates').'/tpl_HSul.html'); 
				  //###############################################################################
	?>

	<div class="clear"></div>
	
  <div class="<?php echo (zen_page_path_check($current_page_base,$main_page_content_chk))?'copyright2':'copyright';?>">
  
				<p>
					<?php
					//change the partner by wushh 20101115,10:26
					  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'partner_images_01.gif');
					  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'partner_images_02.gif').' ';
					  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'partner_images_03.gif').' ';
					  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'partner_images_04.gif').' ';
					  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'moneyback.gif','',70,70).' ';
					 // echo zen_image(DIR_WS_TEMPLATE_IMAGES.'partner_images_05.jpg').' ';
					  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'partner_images_06.jpg').' ';
					  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'partner_images_07.jpg').' ';
					  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'partner_images_08.jpg').' ';
					   echo zen_image(DIR_WS_TEMPLATE_IMAGES.'freeshipping.gif','',70,70);
					  ?> 
				</p> 
				<p style="text-align:center ">Copyright Notice © 2008-2011 <?php echo STORE_NAME;?> All rights reserved.</p>
	</div>

</div>