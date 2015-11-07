<?php if(isset($find_img_cnt) && $find_img_cnt>1){?>
<script type="text/javascript">
	/*var id_images=[];*/
	var iiii=0;	
	var jjjj=0;
	var start_top=$('#item_desc_images').offset().top;
	var ll_imgs=$('#item_desc_images img');
		iiii=ll_imgs.length;
	$(window).scroll(function(){
		var h=0;
		var ch=0;
		if(document.documentElement&& document.documentElement.scrollTop){
			h=document.documentElement.scrollTop;
		}else if(document.body.scrollTop){
			h=document.body.scrollTop;
		}	
		
		if(h>start_top){
			if(jjjj<iiii){
				$('#item_desc_images img').each(function(index){
					var src8=$(this).attr('src8');
					if(src8){					
						var offset=$(this).offset();
						if((offset.top)<h){
							$(this).fadeIn();				
							$(this).attr('src',src8);
							$(this).removeAttr('src8');
							jjjj++;
						}					
					}
				});
			}	
		}
	});
</script>
<?php }?>