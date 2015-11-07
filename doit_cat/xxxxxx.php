<?php
/**
 * @package admin
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: server_info.php 6498 2007-06-16 06:30:49Z drbyte $
 */

  require('includes/application_top.php');
  include('dong/dong_api.php');
  $version_check_sysinfo=true;

  $system = zen_get_system_information();

// the following is for display later
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
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<style type="text/css">
    #body{ border:1px gray solid; width:600px; height:auto; margin:auto; margin-top:20px;}
	.update{ border:0px; width:auto; height:auto; text-align:center; cursor:pointer;}
	#productsid input{ border:0px gray solid; widows:80px; text-align:center;}
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
        <select name="select" onChange="a()" id="select">
<option selected>选择目录</option>
<?php 
$result=mysql_query("select * from categories where 1 and parent_id=0");
while($row=mysql_fetch_array($result))
{
	
	if($row[categories_id]==$_GET[zen_c_id]) $selected=' selected ';
	else
	$selected='';
	echo "<option $selected value='$row[categories_id]'>".get_contents2(categories_description,$row[categories_id],'categories_name',categories_id)."</option>";
	$result_2=mysql_query("select * from categories where 1 and parent_id='$row[categories_id]'");
	while($row2=mysql_fetch_array($result_2))
	{
		if($row2[categories_id]==$_GET[zen_c_id]) $selected=' selected ';
		else
		$selected='';
		echo "<option $selected value='$row2[categories_id]'>&nbsp;&nbsp;_".get_contents2(categories_description,$row2[categories_id],'categories_name',categories_id)."</option>";
		
			$result_3=mysql_query("select * from categories where  parent_id='$row2[categories_id]'");
			while($row3=mysql_fetch_array($result_3))
			{
				if($row3[categories_id]==$_GET[zen_c_id]) $selected=' selected ';
				else
				$selected='';
				echo "<option $selected value='$row3[categories_id]'>&nbsp;&nbsp;&nbsp;&nbsp;__".get_contents2(categories_description,$row3[categories_id],'categories_name',categories_id)."</option>";
	
				
				$result_4=mysql_query("select * from categories where  parent_id='$row3[categories_id]'");
			while($row4=mysql_fetch_array($result_4))
			{
				if($row4[categories_id]==$_GET[zen_c_id]) $selected=' selected ';
				else
				$selected='';
				echo "<option $selected value='$row4[categories_id]'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;___".get_contents2(categories_description,$row4[categories_id],'categories_name',categories_id)."</option>";
	
	
				$result_5=mysql_query("select * from categories where  parent_id='$row4[categories_id]'");
			while($row5=mysql_fetch_array($result_5))
			{
				if($row5[categories_id]==$_GET[zen_c_id]) $selected=' selected ';
				else
				$selected='';
				echo "<option $selected value='$row5[categories_id]'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;___".get_contents2(categories_description,$row5[categories_id],'categories_name',categories_id)."</option>";
	
	
				
				
			}
				
			}
				
				
				
				
				
				
				
				
				
			}
		
		
		
			
	}
}
?>

</select>
 
  
       <?php
	          $categoriesid = $_GET['categoriesid'];
			  echo $categoriesid;
				$sql = 'SELECT DISTINCT p.products_id, p.products_image, pd.products_name, pd.products_short_description,
				p.products_afterbuy_model, p.products_weight
				FROM products p, products_to_categories p2c, products_description pd, categories c
				WHERE p.products_status =1
				AND p.products_id = p2c.products_id
				AND p.products_id = pd.products_id
				AND p2c.categories_id = c.categories_id
				AND c.categories_id ='.$categoriesid.'
				AND c.categories_status =1
				AND pd.language_id =3
				ORDER BY p.`he_given_position` DESC,p.products_ordered desc limit 8';
			  $result = mysql_query($sql);
			  $sqll = '';
			  $num_rows = mysql_num_rows($result);
			  if($num_rows == '0')
			  {
			       $sqll = 'select distinct p.products_id,p.products_image,
							pd.products_name,pd.products_short_description,
							p.products_afterbuy_model,p.products_weight
							from products p,
							products_to_categories p2c,
							products_description pd,
							categories c
							where p.products_status=1 						  
							and   p.products_id=p2c.products_id 
							and   p.products_id = pd.products_id
							and   p2c.categories_id=c.categories_id
							and   c.categories_id='.$categoriesid.'
							and   c.categories_status=1 
							and   pd.language_id = 3
							order by p.products_ordered DESC,pd.products_name limit 8';
			  }else
			  {
			       $sqll = $sql;
			  }
			  
			  $rowww = mysql_query($sqll);
	   ?>
	   
	   
       <table>
	        <tbody class="tbody">
	              <tr style="text-align:center; height:20px;">
				        <td style="width:200px;">排名</td>
						<td style="width:200px;">产品ID</td>
						<td style="width:200px;">操作</td>
				  </tr>
		 <?php 
		     $i = 1;
		 while($row = mysql_fetch_array($rowww)){?>
			      <tr style="text-align:center; height:20px;">
				        <td style="width:200px;"><input type="text" style="border:0px;" readonly="true" value="<?php echo $i;?>" id="<?php echo $i; ?>"/></td>
						
					    <td style="width:400px;"><span id="productsid<?php echo $i;?>" onMouseOver="showtext('<?php echo 'huo'.$i;?>')"
						                            onMouseOut="hiddeng('<?php echo 'huo'.$i;?>')">
						<input type="text" value="<?php echo $row['products_id'];?>"
						         readonly="true"  id="<?php echo 'zhi'.$i;?>"/>
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
			
			$qsql = 'UPDATE products SET `he_given_position` = 0 WHERE products.products_id = '.$qid; 
			if(mysql_query($qsql))
			{
			      $hsql = 'UPDATE products SET `he_given_position` = '.$pm.' WHERE products.products_id ='.$hid;
				  if(mysql_query($hsql))
				  {
				         echo '操作成功！';
				  }
				  else
				  {
				         echo '操作失败！';
				  }

			}
			else
			{
			    echo '删除失败！';
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
			alert(t);
			window.location.href="http://www.myefox.com/eF0Xsh0p/xxxxxx.php?categoriesid="+t; 
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
	   if(huo == '')
	   {
	        alert('请输入商品编号！');
			return false;
	   }else{
	   if(pm == 1)
	   {
	      pm =8;
	   }
	   else if(pm == 2)
	   {
	      pm = 7;
	   }else if(pm == 3)
	   {
	      pm = 6;
	   }else if(pm == 4)
	   {
	      pm = 5;
	   }else if(pm == 5)
	   {
	      pm = 4;
	   }else if(pm == 6)
	   {
	      pm = 3;
	   }else if(pm == 7)
	   {
	      pm = 2;
	   }
	   else
	   {
	       pm = 1;
	   }
	   window.location.href="http://www.myefox.com/eF0Xsh0p/xxxxxx.php?qid="+qian+"&hid="+huo+"&paiming="+pm;
	   }
  }
   
</script>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
