<!-- ��ʽ1 -->
<div class="form-inline span6">
			<select id="searchfield" name="searchfield" class="input-small gray radius" style="margin-left: 20px;">
			</select>
			<input type="text" class="input-small search-query" id="searchcontent" name="searchcontent">
			<button class="btn" type="submit" id="btnSearch"><i class="icon-search"></i>����</button>
		<div class="form-inline span6" align="right" id="operateBar">
<!-- 			<a href="javascript:;" class="btn" id="cancel">ȡ��</a>&nbsp; -->
<!-- 			<a href="javascript:;" class="btn" id="save"><i class="icon-check"></i>����</a> -->
<!-- 			<a href="javascript:;" class="btn" id="edit">�༭</a>&nbsp;&nbsp; -->
		</div>
</div>

<script>
$(document).ready(function(){
// 	����һ����ʹ��ģ��ҳ��ȫ�����ú�̨��ȫ��ҳ�����(js������ҵط���)+++++ֱ�Ӵ�����Ҫ��ҳ��
// 	��������ʹ��ģ��ҳ��ҳ�水ť�Ѿ����ڣ�������Ӱ�ť��ֻ������ʽ�붯��(ģ��ҳ�������࣬������¹��ܰ�ťʱ��Ҫ��ģ�������)++++
// 	����������̨��ǰ̨��ϣ��Զ���Ӱ�ť(js������Դ���ڴ�)

// 	��������
	//��������
	var allcontent=  {"search":{0:{"value":"name","html":"����","isauto":"true"},1:{"value":"plan_type","html":"����"},2:{"value":"plan_director","html":"������"}},
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
		$("#searchfield").append(optionstr);
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

