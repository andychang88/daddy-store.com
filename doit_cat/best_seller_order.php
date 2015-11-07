<?php
/**
 * @package admin
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: server_info.php 6498 2007-06-16 06:30:49Z drbyte $
 */

  require('includes/application_top.php');

  $version_check_sysinfo=true;

  $system = zen_get_system_information();

// the following is for display later
/**
  $sinfo =  '<table width="700" border="1" cellpadding="3" style="border: 0px; border-color: #000000;">' .
         '  <tr align="center"><td><a href="http://www.zen-cart.com"><img border="0" src="images/logo.gif" alt=" Zen Cart " /></a>' .
         '     <h2 class="p"> ' . PROJECT_VERSION_NAME . ' ' . PROJECT_VERSION_MAJOR . '.' . PROJECT_VERSION_MINOR . '</h2>' .
               ((PROJECT_VERSION_PATCH1 =='') ? '' : '<h3>Patch: ' . PROJECT_VERSION_PATCH1 . '::' . PROJECT_VERSION_PATCH1_SOURCE . '</h3>') .
               ((PROJECT_VERSION_PATCH2 =='') ? '' : '<h3>Patch: ' . PROJECT_VERSION_PATCH2 . '::' . PROJECT_VERSION_PATCH2_SOURCE . '</h3>') .
         '     <h2 class="p"> ' . PROJECT_DATABASE_LABEL . ' ' . PROJECT_DB_VERSION_MAJOR . '.' . PROJECT_DB_VERSION_MINOR . '</h2>' .
               ((PROJECT_DB_VERSION_PATCH1 =='') ? '' : '<h3>Patch: ' . PROJECT_DB_VERSION_PATCH1 . '::' . PROJECT_DB_VERSION_PATCH1_SOURCE . '</h3>') .
               ((PROJECT_DB_VERSION_PATCH2 =='') ? '' : '<h3>Patch: ' . PROJECT_DB_VERSION_PATCH2 . '::' . PROJECT_DB_VERSION_PATCH2_SOURCE . '</h3>') ;

  $hist_query = "SELECT * from " . TABLE_PROJECT_VERSION . " WHERE project_version_key = 'Zen-Cart Main' GROUP BY concat(project_version_major, project_version_minor, project_version_comment) ORDER BY project_version_date_applied DESC, project_version_major DESC, project_version_minor DESC";
  $hist_details = $db->Execute($hist_query);
      $sinfo .=  'v' . $hist_details->fields['project_version_major'] . '.' . $hist_details->fields['project_version_minor'];
      if (zen_not_null($hist_details->fields['project_version_patch'])) $sinfo .= '&nbsp;&nbsp;Patch: ' . $hist_details->fields['project_version_patch'];
      if (zen_not_null($hist_details->fields['project_version_date_applied'])) $sinfo .= ' &nbsp;&nbsp;[' . $hist_details->fields['project_version_date_applied'] . '] ';
      if (zen_not_null($hist_details->fields['project_version_comment'])) $sinfo .= ' &nbsp;&nbsp;(' . $hist_details->fields['project_version_comment'] . ')';
      $sinfo .=  '<br />';
  $hist_query = "SELECT * from " . TABLE_PROJECT_VERSION_HISTORY . " WHERE project_version_key = 'Zen-Cart Main' GROUP BY concat(project_version_major, project_version_minor, project_version_comment) ORDER BY project_version_date_applied DESC, project_version_major DESC, project_version_minor DESC, project_version_patch DESC";
  $hist_details = $db->Execute($hist_query);
    while (!$hist_details->EOF) {
      $sinfo .=  'v' . $hist_details->fields['project_version_major'] . '.' . $hist_details->fields['project_version_minor'];
      if (zen_not_null($hist_details->fields['project_version_patch'])) $sinfo .= '&nbsp;&nbsp;Patch: ' . $hist_details->fields['project_version_patch'];
      if (zen_not_null($hist_details->fields['project_version_date_applied'])) $sinfo .= ' &nbsp;&nbsp;[' . $hist_details->fields['project_version_date_applied'] . '] ';
      if (zen_not_null($hist_details->fields['project_version_comment'])) $sinfo .= ' &nbsp;&nbsp;(' . $hist_details->fields['project_version_comment'] . ')';
      $sinfo .=  '<br />';
      $hist_details->MoveNext();
    }
  $sinfo .= '</td>' .
         '  </tr>' .
         '</table>';
         /**/
  function marktime()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
$mark_time1=marktime();
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<style type="text/css">
    #body{ border:1px gray solid; width:600px; height:auto; margin:auto; margin-top:20px;}
	.update{ border:0px; width:auto; height:auto; text-align:center; cursor:pointer;}
	#productsid input{ border:0px gray solid; width:80px; text-align:center;}
</style>
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>

</head>
<body onLoad="init()" >

<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- 内容 //-->
 <div id="body">
       <?php
		   /*$sql = 'select distinct products_id,products_ordered
				  from products  
				  where  products_status = 1
				  and   products_ordered > 0
				  order by he_list_order desc,products_ordered desc limit 10';*/
				  
				
			     $sql ="SELECT DISTINCT p.products_id, pd.products_name, p.products_ordered, p.he_list_order
						FROM products p, products_description pd, products_to_categories p2c
						WHERE p.products_status = '1'
						AND p.products_ordered >0
						AND p.products_id = pd.products_id
						AND p2c.products_id = p.products_id
						AND pd.language_id =3
						ORDER BY p.he_list_order DESC , p.products_ordered DESC , pd.products_name limit 10";
			$result = mysql_query($sql);
			
			
	   ?>
	   
	   
       <table>
	        <tbody class="tbody">
	              <tr style="text-align:center; height:20px;">
				        <td style="width:100px;">排名</td>
						<td style="width:100px;">产品销量</td>
						<td style="width:150px;">现排序ID</td>
						<td style="width:150px;">指定排序ID</td>
						<td style="width:200px;">操作</td>
				  </tr>
		 <?php 
		     $i = 1;
		 while(@$row = mysql_fetch_array($result)){?>
			      <tr style="text-align:center; height:20px;">
				        <td style="width:100px;"><input type="text" style="border:0px; text-align:center; width:100px;" readonly="true" value="<?php echo $i;?>" id="<?php echo $i; ?>"/></td>
						
					    <td style="width:100px;"><span id="productsid<?php echo $i;?>" onMouseOver="showtext('<?php echo 'huo'.$i;?>')"
						                            onMouseOut="hiddeng('<?php echo 'huo'.$i;?>')">
						<input type="text" value="<?php echo $row['products_ordered'];?>" readonly="true" style="width:50px;"/> </span></td>
						<td style="width:150px;"><span id="productsid<?php echo $i;?>" onMouseOver="showtext('<?php echo 'huo'.$i;?>')"
						                            onMouseOut="hiddeng('<?php echo 'huo'.$i;?>')">
						<input type="text" value="<?php echo $row['products_id'];?>"
						         readonly="true"  id="<?php echo 'zhi'.$i;?>"/> </span></td>
						<td style="width:150px;"><span id="productsid<?php echo $i;?>" onMouseOver="showtext('<?php echo 'huo'.$i;?>')"
						                            onMouseOut="hiddeng('<?php echo 'huo'.$i;?>')">
						<input type="text2" value="" id="<?php echo 'huo'.$i?>"/>	   
								   </span></td>
						<td style="width:200px;"><span class = "update" id="update<?php echo $i;?>"
						      onClick="clk('<?php echo 'zhi'.$i;?>','<?php echo 'huo'.$i?>','<?php echo $i; ?>')">修 改</span></td>
				  </tr>
		<?php $i++;}?>
			</tbody>
	   </table>
	  
	   
	   
	   
	   
	   
	   <?php 
	        $qid = $_GET['qid'];
			$hid = $_GET['hid'];
			$pm = $_GET['paiming'];
			
			if(!empty($pm) && !empty($hid))
			{
				//回复之前产品的排序
				 $qsql = 'UPDATE products SET he_list_order = 0 WHERE products.products_id = '.$qid;
				 mysql_query($qsql);
				 //设定指定的产品排序
			      $hsql = 'UPDATE products SET he_list_order = '.$pm.' WHERE products.products_id ='.$hid;
				  
				  if(mysql_query($hsql))
				  {
				         echo '操作成功！';
				  }
				  else
				  {
				         echo '操作失败！';
				  }

			}
	   ?>
 </div>
<!-- 内容 //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
<script type="text/javascript" src="includes/javascript/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
       function a()
	   {
	        var t = $('#select').val();
			
			window.location.href="best_seller_order.php?categoriesid="+t; 
	   }
	   
	    <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
  function hiddeng(items)
  {
       $('#'+items).css('border','1px solid gray');
	   $('#'+items).css('border','1px solid gray'); 
	   $('#'+items).css('backgroundColor','#E7E7E7'); 
  }
  
  function showtext(items)
  {
       $('#'+items).css('border','1px solid gray');
	   $('#'+items).attr('readonly','');
	   $('#'+items).css('backgroundColor','#FFFFFF'); 
  }

  function clk(qian,itemh,itempm)
  {
       var qian = $('#'+qian).val();
       var huo = $('#'+itemh).val();
	   var pm= $('#'+itempm).val();
	    if(huo == '' )
	   {
	        alert('请输入商品编号！');
			return false;
	   }else
	   {
	   
	   if(pm == 1)
	   {
	      pm =10;
	   }
	   else if(pm == 2)
	   {
	      pm = 9;
	   }else if(pm == 3)
	   {
	      pm = 8;
	   }else if(pm == 4)
	   {
	      pm = 7;
	   }else if(pm == 5)
	   {
	      pm = 6;
	   }else if(pm == 6)
	   {
	      pm = 5;
	   }else if(pm == 7)
	   {
	      pm = 4;
	   }
	   else if(pm == 8)
	   {
	      pm = 3;
	   }
	   else if(pm == 9)
	   {
	      pm = 2;
	   }
	   else
	   {
	       pm = 1;
	   }
	   window.location.href="best_seller_order.php?qid="+qian+"&hid="+huo+"&paiming="+pm;
	   }
  }
   
</script>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
