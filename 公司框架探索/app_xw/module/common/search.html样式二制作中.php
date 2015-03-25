<!-- 样式1 -->
<!-- <div class="form-inline span6">
		<select id="searchfield" name="searchfield" class="input-small gray radius" style="margin-left: 20px;"> 	
		</select>
		<input type="text" class="input-small search-query" id="searchcontent" name="searchcontent">
		<button class="btn" type="submit" id="btnSearch"><i class="icon-search"></i>搜索</button>
		<div class="form-inline span6" align="right" id="operateBar">
			<a href="javascript:;" class="btn" id="cancel">取消</a>&nbsp;
			<a href="javascript:;" class="btn" id="save"><i class="icon-check"></i>保存</a>
			<a href="javascript:;" class="btn" id="edit">编辑</a>&nbsp;&nbsp;
		</div>
</div> -->

<!-- 样式2 -->
<div class="form-inline span6">
		<input type="hidden" id="searchsql" name="searchsql"></input>
		<input type="text" class="input-big" id="searchcontent" name="searchcontent" style="margin-left: 20px;">											
		<i class="icon-banner-arrowdown icon-blue" onclick="$('#supersearch').stop(true).slideToggle(500)"></i>
		<div class="form-inline span6" align="right" id="operateBar">
		</div>
</div>

<style>
/* .dropdown_panel{ */
/* 	width: 380px; */
/* 	height:404px; */
/* 	float:left; */
/* 	position:absolute; */
/* 	z-index:10000; */
/* 	left:-999em; 	 */
/* 	text-align:left; */
/* 	/* */
/* 	margin-left:15px; */
/* 	padding:10px 5px 5px 5px; */
/* 	background:#E8EBF0;*/ */
/* } */
/* li:hover .dropdown_panel{left:-1px;top:auto;}	 */
/* .dropdown_panel .head-arrow{height:16px;width:404px;background:url(/theme/default/images/start_menu_panel_bg.png)} */
/* .dropdown_panel .head_panel{height:52px;width:360px;padding:0 22px;background:url(/theme/default/images/start_menu_panel_bg.png) repeat-y;background-position:0 -15px;} */
/* .dropdown_panel .panel-foot{height:16px;width:404px;background:url(/theme/default/images/start_menu_panel_bg.png);background-position: -808px bottom;} */
/* .dropdown_panel .line{border-top:1px solid #999;border-bottom:1px solid #fff; margin-top:5px ;} */
/* .dropdown_panel .menu_panel{height:338px;width:380px;overflow:hidden;background:url(/theme/default/images/start_menu_panel_bg.png) repeat-y;background-position: -404px 0;padding:0 12px;} */
/* .dropdown_panel .head_panel img{border:3px solid #D2D3D7;width:40px;height:40px;float:left} */
/* .dropdown_panel .menu_panel img{border:none;width:20px;height:20px;padding-right:5px;} */
</style>
<!-- <div class="dropdown_pane"> -->
<!-- <div class="head-arrow"></div> -->
<!-- <div class="head_panel"> -->
<!-- 123sjkhfkdsjhdfk jh -->
<!-- </div> -->
<!-- <div class="panel-foot"></div> -->



<div id="supersearch" style="background-color: #00FFFF; width: 455px; height:auto;float:left;position:fixed;display:none;overflow:hidden;">
    <div class="row-fluid">
        <div class="span4">
        	过滤器
        	<ul class="nav">
        	<li>计划开始</li>
        	<li>计划中</li>
        	<li>计划完成</li>
    		</ul>
        </div>
        <div class="span4">
        	分组
        	<ul class="nav">
        	<li>产品</li>
        	<li>数量</li>
        	<li>责任人</li>
    		</ul>
        </div>
        <div class="span4" >
        	自定义过滤
        	<ul class="nav">
        	<li>计划开始</li>
        	<li>计划中</li>
        	<li>计划完成</li>
    		</ul>
    		<input class="btn"  type="button" value="保存"/>
        </div>
    </div>
    <hr/>
    <div class="row-fluid"> 
    高级搜索
    <ul class="nav" id="searchcondition">
    </ul>
    <input class="btn"  type="button" value="添加条件" id="addcondition"/><input class="btn"  type="button" value="运用" id="tosearch"/>        
    </div>
</div>

		<SCRIPT type="text/javascript">
		var field="";
		$(document).ready(function(){			
			var h=$("#searchcontent").offset().top+$("#searchcontent").outerHeight(true);
			var w=$("#searchcontent").offset().left;
			$("#supersearch").css("top",h);
			$("#supersearch").css("left",w);
		})
							
			$("#addcondition").click(function(){
				var str='<li><select class="span1"><option value="and">且</option><option value="or">或</option></select>';
					str+='<select class="input-small" onchange="dataTypeMatch(this)" id="searchfield">';
					str+=field;
// 					str+='<option value="name" datatype="string" selected="selected">名字</option>';
// 					str+='<option value="age" datatype="int">年龄</option>';	
					str+='</select>';
					str+='<select class="span1" id="mark"></select><input type="text" class="input-small"/><i class="icon-remove" onclick="removeItem(this)"></i></li>';
				$("#searchcondition").append(str);
				$("#searchcondition li").last().find("[onchange]").eq(0).change();
			})
			function removeItem(obj){
				$(obj).parent().remove();
			}
			function dataTypeMatch(obj){
				if($(obj).find("option:selected").attr("datatype")=="string")
				{
					$(obj).next().html("");
					var str="";
					str+='<option value="like">包含</option>';
					str+='<option value="not like">不包含</option>';
					str+='<option value="=">等于</option>';
					str+='<option value="!=">不等于</option>';
					str+='<option value="is not null">已设置</option>';
					str+='<option value="is null">未设置</option>';	
					$(obj).next().append(str);
				}else{
					$(obj).next().html("");
					var str="";
					str+='<option value="=">等于</option>';
					str+='<option value="!=">不等于</option>';
					str+='<option value=">">大于</option>';
					str+='<option value="<">小于</option>';
					str+='<option value=">=">大于等于</option>';
					str+='<option value="<=">小于等于</option>';
					str+='<option value="is not null">已设置</option>';
					str+='<option value="is null">未设置</option>';
					$(obj).next().append(str);
				}
			}

			$("#tosearch").click(function(){
				var sql="";
				$("#searchcondition li").each(function(){
					sql+=$(this).find("select").eq(0).val()+" ";
					sql+=$(this).find("select").eq(1).val()+" ";					
					sql+=$(this).find("select").eq(2).val()+" ";

					if($(this).find("select").eq(2).val()!="is null"&&$(this).find("select").eq(2).val()!="is not null")
					{
					if($(this).find("select").eq(1).find("option:selected").attr("datatype")!="int")
					{
						sql+=" '";
					}
					
					if($(this).find("select").eq(2).val()=="like"||$(this).find("select").eq(2).val()=="not like")sql+="%";
					sql+=$(this).find("input").eq(0).val()+"";
					if($(this).find("select").eq(2).val()=="like"||$(this).find("select").eq(2).val()=="not like")sql+="%";
					
					if($(this).find("select").eq(1).find("option:selected").attr("datatype")!="int")
					{
						sql+="'";
					}
					}
					sql+=" ";
				})

				$("#searchsql").val(sql);
				$(this).parents("form").submit();
// 				alert(sql);
			})
		</SCRIPT>

<script>
$(document).ready(function(){
// 	方案一：不使用模块页，全部采用后台传全部页面代码(js代码得找地方放)+++++直接传到需要的页面
// 	方案二：使用模块页，页面按钮已经存在，不再添加按钮，只控制样式与动作(模板页代码冗余，当添加新功能按钮时需要在模板中添加)++++
// 	方案三：后台与前台结合，自动添加按钮(js代码可以存放于此)

// 	方案三：
	//测试数据
	var allcontent=  {"search":{0:{"value":"name","html":"名称","isauto":"true","datatype":"string"},1:{"value":"plan_type","html":"类型","datatype":"int"},2:{"value":"plan_director","html":"负责人","datatype":"string"}},
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
		if(searchcontent["searchstyle"]==2){
			$("#searchfield").append(optionstr);
		}else{
			field=optionstr;
		}
		
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

