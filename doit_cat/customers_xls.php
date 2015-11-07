<?php require('includes/configure.php'); ?>
<?php
    header('Content-Type: text/html; charset=gbk');
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:filename=".date('YmdHis')."xls.xls");
    mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD);
    mysql_select_db(DB_DATABASE);
	mysql_query("set names gbk");
    $customers_xsj =$_GET['xsj'];
    $customers_dsj=$_GET['dsj'];
	if($customers_xsj!="" && $customers_dsj!="")
	{
	   $sql="SELECT c.customers_id,c.customers_email_address,ci.customers_info_date_account_created,c.customers_firstname,c.customers_lastname  FROM customers c
       JOIN customers_info ci ON c.customers_id = ci.customers_info_id
       WHERE ci.customers_info_date_account_created > '".$customers_xsj."'
      AND ci.customers_info_date_account_created < '".$customers_dsj."'
	  ORDER by c.customers_id DESC";
	  $chk_orders_products = mysql_query($sql);
	}
	if($customers_xsj!="" && $customers_dsj=="")
	{
	   $sql="SELECT c.customers_id,c.customers_email_address,ci.customers_info_date_account_created,c.customers_firstname,c.customers_lastname  FROM customers c
      JOIN customers_info ci ON c.customers_id = ci.customers_info_id
      WHERE (ci.customers_info_date_account_created LIKE '%".$customers_xsj."%')
	  ORDER by c.customers_id DESC";
	  $chk_orders_products = mysql_query($sql);
	}
	if($customers_xsj=="" && $customers_dsj!="")
	{
	   $sql="SELECT c.customers_id,c.customers_email_address,ci.customers_info_date_account_created,c.customers_firstname,c.customers_lastname  FROM customers c
       JOIN customers_info ci ON c.customers_id = ci.customers_info_id
       WHERE (ci.customers_info_date_account_created LIKE '%".$customers_dsj."%')
	   ORDER by c.customers_id DESC";
	   $chk_orders_products = mysql_query($sql);
	}
	if($customers_xsj=="" && $customers_dsj=="")
	{
	 $sql="SELECT c.customers_id,c.customers_email_address,ci.customers_info_date_account_created,c.customers_firstname,c.customers_lastname  FROM customers c
           JOIN customers_info ci ON c.customers_id = ci.customers_info_id
	       ORDER by c.customers_id DESC";
	   $chk_orders_products = mysql_query($sql);
	}
echo "客户ID\t"."客户名字\t"."客户邮箱\t"."创建时间\t\n";
   while($arr=mysql_fetch_array($chk_orders_products)) {
echo $arr["customers_id"]."\t";
echo $arr["customers_firstname"].$arr["customers_lastname"]."\t";
echo $arr["customers_email_address"]."\t";
echo $arr["customers_info_date_account_created"]."\t\n";
}
	
?>