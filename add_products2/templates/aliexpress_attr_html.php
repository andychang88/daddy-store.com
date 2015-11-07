<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div id="attr_container" style="display:none;margin-top:20px;">
<fieldset>
	<legend>为一个产品添加属性</legend>
    
<input type="hidden" name="act" value="save_detail" />

<p><b>属性名</b>：<input type="text" style="width:300px;" name="attr_name" value="" /></p>
<p><b>属性展示方式</b>：
<select name="attr_type">
			<option value="0">下拉列表</option>
			<option value="1">文本域</option>
			<option value="2">单选按钮</option>
			<option value="3">复选按钮</option>
			<option value="4">文件域</option>
			<option value="5">只读</option>
		</select>
</p>

<table>
	
	<tr><td colspan=5><center><b>属性值设置</b></center></td></tr>
	
	<tr><td class="align_center">属性值:</td><td class="align_center">价格<br>（+表示增加价格，-表示减少价格。默认为+）:</td><td class="align_center">重量（单位为克）:</td><td class="align_center">排序:</td>
	<td class="align_center">操作</td>
	</tr>
	
	<tr class="attr_tr"><td class="align_center"><input type="text" class="w50" name="attr_value[]" value="" /></td>
	<td class="align_center"><input type="text" class="w50" name="attr_price[]" value="" /></td>
	<td class="align_center"><input type="text" class="w50" name="attr_weight[]" value="" /></td>
	<td class="align_center"><input type="text" class="w50" name="attr_sort[]" value="" /></td>
	<td class="align_center"><a  href="javascript:void(0)" onclick="deleteAttrValue(this);">删除</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="addAttrValue(this);">之后添加行</a></td>
	</tr>
	
	
	<tr><td colspan=5 align="center">
	
	</td>
	
	</tr>
	
	
	</td>
	
	</tr>
	
	
	
</table>

</fieldset>
</div>