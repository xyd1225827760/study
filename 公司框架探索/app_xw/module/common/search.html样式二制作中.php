<!-- ��ʽ1 -->
<!-- <div class="form-inline span6">
		<select id="searchfield" name="searchfield" class="input-small gray radius" style="margin-left: 20px;"> 	
		</select>
		<input type="text" class="input-small search-query" id="searchcontent" name="searchcontent">
		<button class="btn" type="submit" id="btnSearch"><i class="icon-search"></i>����</button>
		<div class="form-inline span6" align="right" id="operateBar">
			<a href="javascript:;" class="btn" id="cancel">ȡ��</a>&nbsp;
			<a href="javascript:;" class="btn" id="save"><i class="icon-check"></i>����</a>
			<a href="javascript:;" class="btn" id="edit">�༭</a>&nbsp;&nbsp;
		</div>
</div> -->

<!-- ��ʽ2 -->
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
        	������
        	<ul class="nav">
        	<li>�ƻ���ʼ</li>
        	<li>�ƻ���</li>
        	<li>�ƻ����</li>
    		</ul>
        </div>
        <div class="span4">
        	����
        	<ul class="nav">
        	<li>��Ʒ</li>
        	<li>����</li>
        	<li>������</li>
    		</ul>
        </div>
        <div class="span4" >
        	�Զ������
        	<ul class="nav">
        	<li>�ƻ���ʼ</li>
        	<li>�ƻ���</li>
        	<li>�ƻ����</li>
    		</ul>
    		<input class="btn"  type="button" value="����"/>
        </div>
    </div>
    <hr/>
    <div class="row-fluid"> 
    �߼�����
    <ul class="nav" id="searchcondition">
    </ul>
    <input class="btn"  type="button" value="�������" id="addcondition"/><input class="btn"  type="button" value="����" id="tosearch"/>        
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
				var str='<li><select class="span1"><option value="and">��</option><option value="or">��</option></select>';
					str+='<select class="input-small" onchange="dataTypeMatch(this)" id="searchfield">';
					str+=field;
// 					str+='<option value="name" datatype="string" selected="selected">����</option>';
// 					str+='<option value="age" datatype="int">����</option>';	
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
					str+='<option value="like">����</option>';
					str+='<option value="not like">������</option>';
					str+='<option value="=">����</option>';
					str+='<option value="!=">������</option>';
					str+='<option value="is not null">������</option>';
					str+='<option value="is null">δ����</option>';	
					$(obj).next().append(str);
				}else{
					$(obj).next().html("");
					var str="";
					str+='<option value="=">����</option>';
					str+='<option value="!=">������</option>';
					str+='<option value=">">����</option>';
					str+='<option value="<">С��</option>';
					str+='<option value=">=">���ڵ���</option>';
					str+='<option value="<=">С�ڵ���</option>';
					str+='<option value="is not null">������</option>';
					str+='<option value="is null">δ����</option>';
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
// 	����һ����ʹ��ģ��ҳ��ȫ�����ú�̨��ȫ��ҳ�����(js������ҵط���)+++++ֱ�Ӵ�����Ҫ��ҳ��
// 	��������ʹ��ģ��ҳ��ҳ�水ť�Ѿ����ڣ�������Ӱ�ť��ֻ������ʽ�붯��(ģ��ҳ�������࣬������¹��ܰ�ťʱ��Ҫ��ģ�������)++++
// 	����������̨��ǰ̨��ϣ��Զ���Ӱ�ť(js������Դ���ڴ�)

// 	��������
	//��������
	var allcontent=  {"search":{0:{"value":"name","html":"����","isauto":"true","datatype":"string"},1:{"value":"plan_type","html":"����","datatype":"int"},2:{"value":"plan_director","html":"������","datatype":"string"}},
// 					"button":{0:{"id":"add","html":"����","contorlitem":"add,update,opform"},
// 					  1:{"id":"cancel","html":"ȡ��","contorlitem":"cancel,update"},
// 					  2:{"id":"pageload","html":"ҳ���״μ���","contorlitem":"cancel"}},
				"searchstyle":"1",				
				"buttonstyle":"1",
				"searchtable":"mrp_plan",	
				};	
	searchshow(allcontent);
	//Ϊ��ť���¼�
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


// // 	��������
// 	//���ַ�����Ȼ��ָ�����顣ҳ���ϰ�ť����,��Ҫ���Ƶ�Ԫ��дԪ�����磺<a href="javascript:;" class="btn" id="cancel" control="edit,update,form01">ȡ��</a>	
// 	var searcharray="name,����,true|type,����,true";	
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
		//����������
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
		
		$("#searchfield").attr("searchstyle",searchcontent["searchstyle"]);//����ʽд�������м�¼����
		$("#searchfield").attr("searchtable",searchcontent["searchtable"]);
		//����ť
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
		$("#operateBar").attr("buttonstyle",searchcontent["buttonstyle"]);//����ʽд�������м�¼����			
	}


// 	//������
// 	function searchshow2(searcharray,buttonarray)
// 	{
// 		//����ַ���Ϊ����
// 		searcharray=searcharray.split("|");
// 		var strend=new Array();
// 		for(var key in searcharray)
// 		{		
// 			strend[key]=searcharray[key].split(",");
// 		}
// 		searcharray=strend;
// 		//����ַ���Ϊ����
// 		buttonarray=buttonarray.split("|");
// 		var strend=new Array();
// 		for(var key in searcharray)
// 		{		
// 			strend[key]=buttonarray[key].split(",");
// 		}
// 		buttonarray=strend;
// 		//����������
// 		var option="";
// 		for(var key in searcharray)
// 		{
// 			option+='<option value="'+searcharray[key][0]+'" isauto="'+searcharray[key][2]+'">'+searcharray[key][1]+'</option>';
// 		}
// 		$("#searchfield").append(option);
// 		//������ť
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
// 		$("#operateBar a").not(btnresult.substr(1)).remove();//��δ���õİ�ťɾ��
// 	}

	$(window).load(function(){
		//�������Զ���ɹ���
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
			//�ص�
// 			$("#btnSearch").click();
		});	

		$("#searchfield").change(function(){			
			$("#searchcontent").flushCache();//��ջ�������
			$("#searchcontent").val("*");
			$("#searchcontent").search();//�������Զ���ɺ���,��������������ջ���	
			$("#searchcontent").val("");
			$("#searchcontent").click();	
			});
	})
</script>

