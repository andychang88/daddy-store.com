<?php
   if (!defined('IS_ADMIN_FLAG')) {
	     die('Illegal Access');
   }

?>

   
<script language="javascript">
function indexbanner(namebar){
	var set={
		lit:$(namebar).find(".chang_vietop"),
		point:$(namebar).find(".chang_bg"),
		boimg:$(namebar).find(".chang_bdy"),
		indent:0,
		speed:500,
		interval:4000,
		pointWidth:-70,
		leftbtn:$(namebar).find(".bar_lf"),
		rightbtn:$(namebar).find(".bar_rf")
	},
	leg=set.lit.find("li").length,
	pointListWidth=set.lit.find("li").outerWidth();
	movWidth=set.boimg.find("img").width();
	function MoveBar(indnt){
		//set.boimg.find("ul").stop();
		//set.point.stop();
		set.lit.find("li").eq(set.indent).addClass("chand").siblings().removeClass("chand");
		set.boimg.find("ul").stop().animate({left:-indnt*movWidth},set.speed);
		set.point.stop().animate({left:(set.indent)*pointListWidth+set.pointWidth},set.speed);	
	}
	function AutoAddBar(){
		set.indent++;
		set.indent=set.indent>=leg?0:set.indent;
		MoveBar(set.indent);
	}
	var intervaltime=setInterval(AutoAddBar,set.interval);
	/**
	set.lit.find("li").click(function(){
		//clearInterval(intervaltime);
		set.indent=set.lit.find("li").index($(this));
		MoveBar(set.indent);
		//intervaltime=setInterval(AutoAddBar,set.interval);
	});
	/**/
	set.lit.find("li").hover(function(){
		clearInterval(intervaltime);
		set.indent=set.lit.find("li").index($(this));
		MoveBar(set.indent);
	},function(){
		clearInterval(intervaltime);
		set.indent=set.lit.find("li").index($(this));
		intervaltime=setInterval(AutoAddBar,set.interval);
	});

	
	
	set.leftbtn.click(function(){
		set.indent--;
		set.indent = set.indent<0?leg-1:set.indent;
		MoveBar(set.indent);
	});
	set.rightbtn.click(function(){
		AutoAddBar();
	});
}   
$(function(){
	var bar=indexbanner(".banr_styleA");
	//var bar1=indexbanner(".banr_styleB");
});
</script>


   
 <?php
	
   //首页中间上部图片轮换
   $banner_info=array();
   $banner_sql='select banners_id, banners_title, banners_image, 
                       banners_html_text, banners_open_new_windows, banners_url
                from ' . TABLE_BANNERS . '
                where status = 1
                and  banners_group="IndexFlash"  order by banners_sort_order asc,banners_id asc ';
   $banner_db=$db->Execute($banner_sql);
   if($banner_db->RecordCount()>0){
     while(!$banner_db->EOF){
	   $banner_info[]=array('banner_title'=>$banner_db->fields['banners_title'],
	                        'banner_image'=>$banner_db->fields['banners_image'],
							'banner_url'=>$banner_db->fields['banners_url']
							);
	   $banner_db->MoveNext();
	 }
   }
   
   //echo '<pre>';print_r($banner_info);exit;
?>





  
<DIV class=banr_styleA>
<DIV class=chang_baner>
      <DIV class=chang_vietop>
	    <UL>
	       
	       <?php foreach($banner_info as $key=>$val){?>
	       
	   <LI><SPAN><A data-placement="top" data-toggle="tooltip" 
	   data-original-title="<?php echo $val['banner_title'];?>"><?php echo $val['banner_title'];?> </A></SPAN></LI>
	   
	   <?php }?>
	   
	   </UL>
	    
      </DIV>
      <DIV class=clear></DIV>
      
      <DIV class=chang_bdy>
       <DIV class=chang_bg></DIV>
	 <SPAN class=bar_lf></SPAN>
	 <SPAN class=bar_rf></SPAN>
	
	 <UL>
	    
	    <?php foreach($banner_info as $key=>$val){?>
	    
	    <LI><!--  --><A  href="<?php echo $val['banner_url'];?>" 
	    target=_blank><?php echo zen_image(DIR_WS_IMAGES.$val['banner_image'],$val['banner_title'],660,360,"border=0");?></A> <!--  --></LI>
	    
	    <?php }?>
	    
	    
	 </UL>
      </DIV>
</DIV></DIV>









   