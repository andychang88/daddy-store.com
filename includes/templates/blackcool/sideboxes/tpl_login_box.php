<?php
   $content='';
   $content="<div class='anmelden'>";
   $content.=' <h6>Willkommen zurück!</h6>';
   $content.=' <ul>';
   if(isset($_SESSION['customer_id']) && is_numeric($_SESSION['customer_id']) && $_SESSION['customer_id']!=0){
      $customer_name=$_SESSION['customer_first_name'].$_SESSION['customer_last_name'];
	  $last_login_time=$_SESSION['customer_last_logontime'];
	  $content.='<li>'.$customer_name.'</li>';
	  $content.='<li>Last Logon:<br>'.$last_login_time.'</li>';
	  /*$content.='<li>'.TEXT_TITLE_EMAIL.'</li>';
	  $content.='<li>'.TEXT_TITLE_EMAIL.'</li>';*/
   }else{
     
      $login_form = zen_draw_form('login_form', zen_href_link(FILENAME_LOGIN, 'action=process', 'NONSSL', false), 'post');
      $security_token=zen_draw_hidden_field('securityToken', $_SESSION['securityToken']);
	  $email_input_field=zen_draw_input_field('email_address', '', ' class="a_input"');
      $pwd_input_field=zen_draw_password_field('password', '', '  class="a_input"');
	  $login_submit=zen_image_submit(BUTTON_IMAGE_LOGIN, BUTTON_LOGIN_ALT);
	  $forgotten_pwd_link=zen_href_link(FILENAME_PASSWORD_FORGOTTEN,'','SSL');
	  
	  $content.=$login_form;
	  $content.=$security_token;
	  $content.='<li>'.TEXT_TITLE_EMAIL.'</li>';
	  $content.='<li>'.$email_input_field.'</li>';
	  $content.='<li>'.TEXT_PASSWORD.'</li>';
	  $content.='<li>'.$pwd_input_field.'</li>';
	  $content.='<li>'.$login_submit.'</li>';
      $content.='<li><a class="xhx" href="'.$forgotten_pwd_link.'">'.TEXT_LOST_PASSWORD.'</a></li>';	  
   }
   $content.=' </ul>';
   $content.=' </div>';
?>