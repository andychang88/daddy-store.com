<?php
function arraytotext($arr)
{
	return serialize($arr);	
}

function texttoarray($text)
{
	return unserialize($text);
}
function get_value($table,$id,$condition='id')
{
	//echo "select * from `$table` where id='$id'";
	return $row=mysql_fetch_array(mysql_query("select * from `".qj."$table` where `$condition`='$id'"));
}
function get_value2($table,$id,$condition='id',$and='')
{
	//echo "select * from `$table` where id='$id'";
	return $row=mysql_fetch_array(mysql_query("select * from `$table` where `$condition`='$id' $and"));
}
function get_contents($table,$id,$what='contents',$field='id')
{
	

		$a=mysql_fetch_array(mysql_query("select * from `".qj."$table` where `$field`='$id'"));
		
		
		return $a[$what];
		

	
}

function get_contents2($table,$id,$what='contents',$field='id')
{

	
		$a=mysql_fetch_array(mysql_query("select * from `$table` where `$field`='$id'"));
		if(!$a)
		echo "select * from `$table` where `$field`='$id'";
		
		
		return $a[$what];
		

	
}
//智能内容获取
function zhineng_contents($url)
{
	$a=getrobotmeg($url);
	
	$title=$a[leachsubject];
	$contents=$a[leachmessage];
	$fh=array('|','_','-',' ','―','＿','！');
	foreach($fh as $s)
	{
		$title=ex($title,$s,0);
		
	}
	
	
	return array(title=>' '.trim($title),contents=>$contents,tag=>getkeyword($title));
}

function getkeyword($title,$contents='')
{
	
	// 加入头文件
require_once 'pscws4.class.php';

// 建立分词类对像, 参数为字符集, 默认为 gbk, 可在后面调用 set_charset 改变
$pscws = new PSCWS4('utf8');

$pscws->set_dict('../function/etc/dict.xdb');
$pscws->set_rule('../function/etc/rules.ini');
$pscws->set_duality(true);

 $text=$title;
$pscws->send_text($text);
$tops = $pscws->get_tops(10, '');

foreach ($tops as $k)
$keywords=$keywords.$k[word].' ';

return ' '.trim($keywords); 
}


function url($type,$id=0,$make_html=0,$page='')
{
	if($make_html==1)
	$website_dir='../';
	else
	global $website_dir;
	
	if($type=='index')
	$dir=$website_dir;
	if($type=='article_list')
	{
		$dir_arr=get_value(keywords,$id);
		$dir=$website_dir.'/'.$dir_arr['dir'];
		if($page=='')
		$filename='index.htm';
		else
		$filename="list_$page.htm";
	}
	if($type=='article_view')
	{
		//url=type_dir+class_dir+mode_dir+filename
		$filename_a=get_value(article,$id);
		if($filename_a[filename]=='')
		$filename=$id.'.htm';
		else
		$filename=$filename_a[filename];
		$class_dir_a=get_value(article_class,$filename_a[classid]);
		$class_dir=$class_dir_a['dir'];
		$type_dir_a=get_value(article_type,$class_dir_a[type_id]);
		$type_dir=$type_dir_a['dir'];
		$mode=$type_dir_a[url_mode];
		
		if($mode==1)
		{
			$mode_dir=$id % 100;
		}
		
		
		$url="/$type_dir/$class_dir/$mode_dir/$filename";
	
		
	}
	//url修剪
		$url=str_replace('///','/',$url);
		$url=str_replace('//','/',$url);
		
		
	return $url;
}

function dangqianweizhi($type,$id)
{
	if($type=='article_view')
	{
		$keyword1=get_value(article,$id);

	$k2=get_value(keywords,$keyword1[keyword_id]);
			$weizhi="当前位置："."<a href='/$website_dir'>首页</a>-<a href='".url(article_list,$k2[id])."'>".$k2[keyword]."</a>-<a href='".url('article_view',$id)."'>".$keyword1[title]."</a>";
	}
	
	if($type=='article_list')
	{
		$k2=get_value(keywords,$id);
		$weizhi="当前位置："."<a href='/$website_dir'>首页</a>-<a href='".url(article_list,$k2[id])."'>".$k2[keyword]."</a>";
	}
	return $weizhi;
}


function sql_select($table,$html=0,$get='',$value='')
{	
	
	//生成HTML模式的处理
	if($html==1 and $get!='')
	$_GET[$get]=$value;
	
	if($html!=1)
	{
	global $tag;
	$_GET[tag]=$tag;
	} 
	
	
	
	$array=array('classid','keywordid','up_id','c_id','class_id','sorce_id','zen_id');
	foreach($array as $name)
	{
		if($_GET[$name]!='' and $name!='c_id')
		$where.=" and `$name`='$_GET[$name]' ";
		if($name=='c_id')
		{
		$where.=" and `c_id` in (select id from dong_categories where up_id='$_GET[$name]' or id='$_GET[$name]')";
		}
	}
	if($table!='danye')
	{
		if($_POST[keyword]!='')
		$where.=" and `title`like '%$_POST[keyword]%' ";
	}
	//tag
	if($_GET[tag]!='')
	{
	
	$where.=" and `tag` like '% $_GET[tag] %' ";
	}
	
	return $sql="select * from `".qj."$table` where 1 $where";
}

function del($table,$id,$kaiguan) //记录删除函数
{
	if($_GET[$kaiguan]=='del' and $id!='')
	{
		mysql_query("delete from `{$qj}$table` where id='$id'");
	}
	
}




function page($sql,$page,$everypage=20,$div_mode='php')
{

		
	//SELECT * FROM `keywords` 
	if($page=='')
	{
		$page=1;
	}
	$all=mysql_num_rows(mysql_query($sql));
$t=$all/$everypage;
$all_page= ceil($t) ;
$l=($page-1)*$everypage;
	
	//排序
	$order=$_GET['order'];
	if($order=='')
	$order='id';
	$by=$_GET['by'];
	if($by=='')
	$by='desc';

	
	$newsql=$sql."  order by $order $by  limit $l,$everypage ";
	
	if($div_mode=='')
	{
		$div="<div class=\"fpage\"><span>共有&nbsp;$all&nbsp;条记录&nbsp;第 $page /$all_page 页&nbsp;&nbsp;&nbsp;<a href=\"\">[首 页]</a>&nbsp;";
		if($page!=1)
		$div.="<a href=\"list_".($page-1).".htm\">[上一页]</a>";
		else
		$div.="[下一页]";
		$div.='&nbsp;&nbsp;';
		if($page==$all_page)
		$div.='[下一页]';
		else
		$div.="<a href='list_".($page+1).".htm'>[下一页]</a>";
		$div.="&nbsp; <a href=\"list_$all_page.htm\">[尾页]</a></span></div>";
	}
	elseif($div_mode=='php')
	{
	
		
		$keyword=$_GET[keyword];
		$classid=$_GET[c_id];
		$keywordid=$_GET[keywordid];
		//print_r($_SERVER);
		$div="<div class=\"fpage\"><span>共有&nbsp;$all&nbsp;条记录&nbsp;第 $page /$all_page 页&nbsp;&nbsp;&nbsp;<a href=\"?c_id=$classid&order=$_GET[order]&by=$_GET[by]&keyword=$keyword&page=1\">[首 页]</a>&nbsp;";
		if($page!=1)
		$div.="<a href=\"?c_id=$classid&keyword=$keyword&order=$_GET[order]&by=$_GET[by]&page=".($page-1)."\">[上一页]</a>";
		else
		$div.="[上一页]";
		$div.='&nbsp;&nbsp;';
		if($page==$all_page)
		$div.='[下一页]';
		else
		$div.="<a href='?c_id=$classid&keyword=$keyword&order=$_GET[order]&by=$_GET[by]&page=".($page+1)."'>[下一页]</a>";
		$div.="&nbsp; <a href=\"?c_id=$classid&order=$_GET[order]&by=$_GET[by]&keyword=$keyword&page=$all_page\">[尾页]</a></span></div>";
	}
	
	
	return array(sql=>$newsql,div=>$div);
}

function auto_seo($str,$keywordid)
{
	
	//规则 1.所有包含数据里面关键词全部加上<stront></stront>，2是本页关键词的话加链接，链接地址从后台可以设置 3.测试期间链接到globalzy.com
	$result=mysql_query("select * from keywords where classid!=4 order by LENGTH(`keyword`) asc");
	while($row=mysql_fetch_array($result))
	{
		if($row[id]!=$keywordid)
		$str=str_replace($row[keyword],"<strong>$row[keyword]</strong>",$str);
		else
		$str=str_replace($row[keyword],"<strong><a href='http://www.globalzy.com'>$row[keyword]</a></strong>",$str);
	}
	return $str;
}

//seo标签
function dong_seo($type)
{
	if($type=='index')
	{
		$get=get_value(config,1);
		
	}
	echo "
	<title>$get[index_title]</title>
<meta name=\"keywords\" content=\"$get[index_keyword]\" />
<meta name=\"description\" content=\"$get[index_desc]\" />
	
	";
}
function jindu($all,$now,$every)
{
			//进度

		if(($now%500)==0)
		{
			$rate=$now/$all*100;
		echo "<script>jindutiao.value='$rate'</script>";
		flush();
		}	
		if($k==$all)
		{
			$rate=$now/$all*100;
		echo "<script>jindutiao.value='$rate'</script>";
		flush();
		}
		//。。。
}

function get_auto_id($table)
{
	//东东---数据整理---预先获取将一个表将要插入的id值
	$row=mysql_fetch_array(mysql_query("show create table `$table`"));
	print_r($row);
	$id=cut($row['Create Table'],'AUTO_INCREMENT=',' ');
	return $id;
}

function get_max_id($table)
{
	echo "select  max(id) from `$table` ";
	$row=mysql_fetch_array(mysql_query("select  max(id) from `$table` "));
	return $row['max(id)'];
}
function get_min_id($table)
{
	$row=mysql_fetch_array(mysql_query("select  min(id) from `$table` "));
	return $row['min(id)'];
}
function yulan($str,$len)
{//固定长度字符串的截取 if($len>=strlen($str)||!$len)return$str; 
$len-=3; 
$tempstr1=substr($str,0,$len);//截取字符串 
$tempstr2=preg_replace('/([\x81-\xff]+)$/ms','',$tempstr1,1); 
//去掉结尾的连续汉字字符 
if(!is_int((strlen($tempstr1)-strlen($tempstr2))/2)){
//去掉的字符为奇数? 
$tempstr1=substr($str,0,$len-1); 
} 
return$tempstr1."…"; 
} 





function check_num($str)
{
	$a=0;
	$b=0;
	for($i=0;$i<strlen($str); $i++)
	{
	$v=ord(substr($str,$i,1));
	if($v>=48 and $v<=57){
	$a=1;
	}else{
	$b=2;
	}
	}
	return $a+$b;
	}
　　
?>