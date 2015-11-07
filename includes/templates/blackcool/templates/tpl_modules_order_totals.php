<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_order_totals.php 2993 2006-02-08 07:14:52Z birdbrain $
 */
 ?>
<?php 
/**
 * Displays order-totals modules' output
 */
 ?>
<?php  for ($i=0; $i<$size; $i++) {
          if(zen_not_null($GLOBALS[$class]->output[$i]['title']) && $GLOBALS[$class]->output[$i]['title'] !=':' ){
?>         
          <tr> 
		     <td width="100%" align="right">
			   <?php echo $GLOBALS[$class]->output[$i]['title']; ?>
                <strong class="neue_text3"><?php echo $GLOBALS[$class]->output[$i]['text']; ?></strong>
		     </td>
		  </tr>
<?php    }?>
<?php  }?>