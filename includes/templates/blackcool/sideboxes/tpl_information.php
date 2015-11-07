<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_information.php 2982 2006-02-07 07:56:41Z birdbrain $
 */
 //change $content, add the  Testimonials info  by wushh 20101115,11:30
  $content = '<div class="l_info">
  <h6>Testimonials</h6>
  <p><strong>Thousands of delighted customers</strong></p>
  <p>"Hi <a href="http://www.myefox.com/index.html">myefox.com team</a>,</p>
<p>Just to give you some feedback on my last order with you Transaction ID 0G1987517Y9595369.</p>
  <p>Thank you, I received my touchscreen Android tablet pc in record time and it works great.  <strong>5 star seller!</strong></p>
  <p>Regards Christine Kha" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

</div>';
  $content .= '<div class="l_info">';
  $content .='<h6>'.BOX_HEADING_INFORMATION.'</h6>';
  $content .= '<p>';
  for ($i=0; $i<sizeof($information); $i++) {
    $content .= ($i+1).'. '. $information[$i] . "<br />";
  }
  $content .= '</p>';
  $content .= '</div>';
?>