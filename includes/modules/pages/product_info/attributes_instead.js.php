<?php
	if(isset($selectoptions_to_text) && count($selectoptions_to_text)>0){
?>
	<script type="text/javascript">var option_instead=[];var previous_choose=[];var cms_need_check=cms_need_check||[];
		<?php
			foreach($instead_options as $option_id){
				if(isset($selectoptions_to_text[$option_id])){
					$tmp_instead_opt=array();
					foreach($selectoptions_to_text[$option_id] as $oop_id){
						if(isset($options_menu[$oop_id])){//note here				
							$tmp_instead_opt[]=$oop_id;	
						}
					}
					if(sizeof($tmp_instead_opt)>0){
		 ?>
						option_instead[<?php echo $option_id;?>]='<?php echo implode(',',$tmp_instead_opt);?>';
		<?php				
					}
				}
			}	
		?>
		function change_attr(attr_id){
			var ele=document.getElementById('attrib-'+attr_id);
			var tri_ele=document.getElementById('tri_attr_'+attr_id);
		
			var second_attr=option_instead[attr_id];
				second_attr=second_attr.split(',');			
			if(tri_ele.checked){//customer want to type what they want
				/*if(ie_type){
					ele.style.color='#000';
					ele.style.backgroundColor='#fff';
				}else{
					ele.setAttribute('class','');
				}*/
				previous_choose[attr_id]=ele.selectedIndex;//save the current chosen
				
				ele.disabled='disabled';//diable what we provide				
				ele.selectedIndex=0;//let it  be default
				cms_need_check[attr_id]=false;//no need to check what we provide 
				
				reverseStatus('attrib-','',second_attr);
			}else{
				ele.disabled='';//enable let customer choose from what we provide
				cms_need_check[attr_id]=true;// need to check what we provide
				
				ele.selectedIndex=previous_choose[attr_id];//more better customer feeling,restore to be  what they chosen before
				
				reverseStatus('attrib-','disabled',second_attr);
			}
		}
		function reverseStatus(id_prefix,disabled,affected_arr){
			for(var i=0;i<affected_arr.length;i++){
				var tmp_ele=document.getElementById(id_prefix+affected_arr[i]);
					tmp_ele.disabled=disabled;
 					/*tmp_ele.style.borderColor='#ccc';
					tmp_ele.style.borderWidth='1px';
					tmp_ele.style.borderStyle='solid';*/
 				if(disabled=='disabled'){
					document.getElementById('wrapper_attr_'+affected_arr[i]).style.display='none';
					tmp_ele.value='';
				}else{
					document.getElementById('wrapper_attr_'+affected_arr[i]).style.display='block';
				}
			}
		}
		$(document).ready(function(){
			for(var opt_id in option_instead){
				var second_attr=option_instead[opt_id];
					second_attr=second_attr.split(',');
				for(var i=0;i<second_attr.length;i++){
					var move_html=$('#wrapper_attr_'+second_attr[i]);
					$('#wrapper_attr_'+opt_id).append(move_html);					
				}
				$('#tri_attr_'+opt_id).click();
			}				
		});
	</script>
<?php
	}
?>