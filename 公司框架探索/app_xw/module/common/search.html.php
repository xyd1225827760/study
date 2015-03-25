<!-- 样式1 -->
<div class="form-inline span6">
			<select id="searchfield" name="searchfield" class="input-small gray radius" style="margin-left: 20px;">
			</select>
			<input type="text" class="input-small search-query" id="searchcontent" name="searchcontent">
			<button class="btn" type="submit" id="btnSearch"><i class="icon-search"></i>搜索</button>
		<div class="form-inline span6" align="right" id="operateBar">
<!-- 			<a href="javascript:;" class="btn" id="cancel">取消</a>&nbsp; -->
<!-- 			<a href="javascript:;" class="btn" id="save"><i class="icon-check"></i>保存</a> -->
<!-- 			<a href="javascript:;" class="btn" id="edit">编辑</a>&nbsp;&nbsp; -->
		</div>
</div>

<script>
$(document).ready(function(){
// 	方案一：不使用模块页，全部采用后台传全部页面代码(js代码得找地方放)+++++直接传到需要的页面
// 	方案二：使用模块页，页面按钮已经存在，不再添加按钮，只控制样式与动作(模板页代码冗余，当添加新功能按钮时需要在模板中添加)++++
// 	方案三：后台与前台结合，自动添加按钮(js代码可以存放于此)

// 	方案三：
	//测试数据
	var allcontent=  {"search":{0:{"value":"name","html":"名称","isauto":"true"},1:{"value":"plan_type","html":"类型"},2:{"value":"plan_director","html":"负责人"}},
// 					"button":{0:{"id":"add","html":"新增","contorlitem":"add,update,opform"},
// 					  1:{"id":"cancel","html":"取消","contorlitem":"cancel,update"},
// 					  2:{"id":"pageload","html":"页面首次加载","contorlitem":"cancel"}},
				"searchstyle":"1",				
				"buttonstyle":"1",
				"searchtable":"mrp_plan",	
				};	
	searchshow(allcontent);
	//为按钮绑定事件
	$("#operateBar a").each(function(){
		$(this).click(function(){
			$("#operateBar a").removeAttr("disabled");
			$("#operateBar a").css("display","");
			$("form").find("input,select,textbox,button").not("[notcontrol]").removeAttr("disabled");
			
			var con=$(this).attr("contorlitem").split(",");	
// 			alert(con[1]);
			for(var i in con){
				if(con[i].toLowerCase().indexOf("form")>=0)
				{
					$("#"+con[i]).find("input,select,textbox,button").not("[notcontrol]").attr("disabled","disabled");
				}else{
					$("#"+con[i]).attr("disabled","disabled");
					$("#"+con[i]).css("display","none");
				}
			}
		});	
	})


// // 	方案二：
// 	//传字符串，然后分割成数组。页面上按钮存在,将要控制的元素写元素中如：<a href="javascript:;" class="btn" id="cancel" control="edit,update,form01">取消</a>	
// 	var searcharray="name,名称,true|type,类型,true";	
// 	var buttonarray="add,edit,update,form01|cancel,add,edit";	
// 	searchshow2(searcharray,buttonarray);



	//alert('<?=$getparams['searchfield']?>');
	<?php foreach($getparams as $key=>$value){?>
	//alert("[name='<?=$key?>']");
	//alert($("[name='"+<?=$key?>+"']").prop('outerHTML'));
	if($("[name='<?=$key?>']").length>0){
		//alert(12);
		$("[name='<?=$key?>']").val('<?=$value?>');
		//alert($("[name='"+<?=$key?>+"']").val());
	}
	<?php }?>
})

	function searchshow(searchcontent)
	{
		//处理搜索框
		var optionstr="";
		var searchend=searchcontent["search"];
		for(var key in searchend)
		{
// 			alert(searchend[key]["show"]);
			var endattr="",html="";
			for(var attr in searchend[key])
			{
				if(attr.toLowerCase()=="html")
				{
					html=searchend[key][attr];
				}else{
					endattr+=' '+attr+'="'+searchend[key][attr]+'"';
				}
			}
			optionstr+='<option '+endattr+'>'+html+'</option>';
		}
		$("#searchfield").append(optionstr);
		$("#searchfield").attr("searchstyle",searchcontent["searchstyle"]);//将样式写入属性中记录下来
		$("#searchfield").attr("searchtable",searchcontent["searchtable"]);
		//处理按钮
		var buttonstr="";
		var buttonend=searchcontent["button"]
		for(var key in buttonend)
		{
			var endattr="",html="";
			for(var attr in buttonend[key])
			{
				if(attr.toLowerCase()=="html")
				{
					html=buttonend[key][attr];
				}else{
					endattr+=' '+attr+'="'+buttonend[key][attr]+'"';
				}
			}
			buttonstr+='<a href="javascript:void(0);" class="btn"'+endattr+'><i class="icon-check"></i>'+html+'</a>&nbsp;&nbsp;';
		}
		$("#operateBar").append(buttonstr);
		$("#operateBar").attr("buttonstyle",searchcontent["buttonstyle"]);//将样式写入属性中记录下来			
	}


// 	//方案二
// 	function searchshow2(searcharray,buttonarray)
// 	{
// 		//拆分字符串为数组
// 		searcharray=searcharray.split("|");
// 		var strend=new Array();
// 		for(var key in searcharray)
// 		{		
// 			strend[key]=searcharray[key].split(",");
// 		}
// 		searcharray=strend;
// 		//拆分字符串为数组
// 		buttonarray=buttonarray.split("|");
// 		var strend=new Array();
// 		for(var key in searcharray)
// 		{		
// 			strend[key]=buttonarray[key].split(",");
// 		}
// 		buttonarray=strend;
// 		//操作搜索框
// 		var option="";
// 		for(var key in searcharray)
// 		{
// 			option+='<option value="'+searcharray[key][0]+'" isauto="'+searcharray[key][2]+'">'+searcharray[key][1]+'</option>';
// 		}
// 		$("#searchfield").append(option);
// 		//操作按钮
// 		var option="",btnresult="";
// 		for(var key in buttonarray)
// 		{
// 			var contorlitem="";
// 			for(var i in buttonarray[key])
// 			{
// 				if(i!=0)contorlitem+=buttonarray[key][i];
// 			}
// 			$("#"+buttonarray[key][0]).attr("contorlitem",contorlitem);
// 			btnresult+=",#"+buttonarray[key][0];
// 		}
// 		$("#operateBar a").not(btnresult.substr(1)).remove();//将未配置的按钮删除
// 	}

	$(window).load(function(){
		//搜索框自动完成功能
		$("#searchcontent").autocomplete("/mrp_plan/autoComplete.candor", {
			dataType: "json",
			width:156,
// 			cacheLength:0,
			delay: 0,
// 			minChars: 0,
			extraParams:{searchcontent:function(){return $("#searchcontent").val()},
						 searchfield:function(){return $("#searchfield").val()},
						 searchTable:function(){return $("#searchfield").attr("searchtable")},
						},
			parse: function(data) { 
				return $.map(data, function(row) {
					return {
						data: row,
						value: row.name,
						result: row.name
					}
				});
			},
			formatItem: function(item) {
				return item.name;
			}	   
		}).result(function(e,item){
			//回调
// 			$("#btnSearch").click();
		});	

		$("#searchfield").change(function(){			
			$("#searchcontent").flushCache();//清空缓存数据
			$("#searchcontent").val("*");
			$("#searchcontent").search();//运行下自动完成函数,先运行下用于清空缓存	
			$("#searchcontent").val("");
			$("#searchcontent").click();	
			});
	})
</script>

