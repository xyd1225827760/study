<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php
    if(isset($header['title']))   echo "<title>$header[title]</title>\n";
    if(isset($header['keyword'])) echo "<meta name='keywords' content='$header[keyword]'>\n";
    if(isset($header['desc']))    echo "<meta name='description' content='$header[desc]'>\n";
    ?>
	<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/cdrstyle.css';?>' type='text/css' media='screen' />
    <link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/common.css';?>' type='text/css' media='screen' />
    <!-- *���� css -->
	<link title="default" label="te" rel="stylesheet" href='<?php echo $this->app->getClientTheme() . 'style.css';?>' type='text/css' media='screen' />
    <link title="blue" label="te" rel="stylesheet" href='/theme/blue/style.css' type='text/css' media='screen' />
	
    <!-- *�Ҽ��˵� css -->
    <link href="/js/plugins/jquery.contextMenu/skins/default/candor.contextmenu.css" rel="stylesheet">
    <!-- *tab���� css -->
    <link href="/js/plugins/jquery.tabPanel/TabPanel.css" rel="stylesheet" type="text/css"/>

    <!-- *����jquery js -->
    <script src="/js/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="/js/jquery.cookie.js" type="text/javascript"></script> 
	<script src="/js/framework.animation.js" type="text/javascript"></script>
	<script src="/js/framework.carousel.js" type="text/javascript"></script>
    <!-- *�Ҽ��˵� js -->
    <script src="/js/plugins/jquery.contextMenu/candor.contextmenu.js" type="text/javascript"></script>
    <!-- *�������� js -->
    <script src="/js/plugins/artDialog/artDialog.source.js?skin=default" type="text/javascript"></script>
	<script src="/js/plugins/artDialog/plugins/iframeTools.js" type="text/javascript"></script>
    <!-- *���صȴ� js 
    <script src="/js/candor.blockui.js" type="text/javascript"></script>
	-->
    <!-- *tab���� js -->
    <script src="/js/plugins/jquery.tabPanel/Fader.js" type="text/javascript"></script>
	<script src="/js/plugins/jquery.tabPanel/TabPanel.js" type="text/javascript"></script>
    
    <script type="text/javascript">
	var is_visible_left_sys_btn = true;
	var left_tools_num_visible;
	var tab_panel;

	//jQuery.jgrid.no_legacy_api = true;
	/*��ѯ������ʼ
	(function($){
		// �ı�Ĭ������
		var d = $.dialog.defaults;
		// Ԥ����Ƥ���������һ��ΪĬ��Ƥ��
		d.skin = ['aero', 'chrome', 'facebook', 'default'];
		d.plus = true;
		// �Ƿ�����Ч
		//d.effect = true;
		// ָ������������ĶԻ����϶���ʱ��������
		//d.showTemp = 0;
	})(art)
	*/

	$(window).load(function(){
		//$.unblockUI();
        setTimeout(function(){
			resetWorkpHeight(0);
		},300);
	});

	$(function(){
		//��ʼ������ƽ̨
		//��ʼ����߹�����
		if($(".my_tools li").size())renderLeftTools()
		
		/*
        $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
		*/

		//��������
		$("#delete_them img").click(function(){ 
			var style = $(this).attr("title"); 
			$("link[label='te']").attr("disabled","disabled"); 
			$("link[title='"+style+"']").removeAttr("disabled"); 
			$.cookie("mystyle",style,{expires:30}); 
			$(this).addClass("cur").siblings().removeClass("cur"); 
		});
		var cookie_style = $.cookie("mystyle"); 
		if(cookie_style==null){ 
			$("link[title='default']").removeAttr("disabled"); 
		}else{ 
			$("link[label='te']").attr("disabled","disabled"); 
			$("link[title='"+cookie_style+"']").removeAttr("disabled"); 
		} 
		
		//��ʼ�����tools������,��ȡitool_ids��cookie��Ϣ
		var cookie_itool_ids = $.cookie('itool_ids'); 
		if(cookie_itool_ids!=null){ 
			var arr_tool_ids = cookie_itool_ids.split("|");
			var itool_item;
			for(var i=0;i<arr_tool_ids.length;i++){
				//id:app_1;title:��Ϣ����;src:http://zhidao.baidu.com;cimg:/theme/default/images/app_icons/sms.png
				itool_item = $.cookie(arr_tool_ids[i]);
				if(itool_item!=null){
					var arr_itool_item = itool_item.split(";");
					var ckey_id = arr_itool_item[0].split(":");
					var ckey_title = arr_itool_item[1].split(":");
					var ckey_src = arr_itool_item[2].split(":");
					var ckey_cimg = arr_itool_item[3].split(":");
					if(ckey_src.length>2)ckey_src[1]=ckey_src[2];
					$(".my_tools ul").append('<li id="'+ckey_id[1]+'" class="itool" title="'+ckey_title[1]+'" src="'+ckey_src[1]+'"><img src="'+ckey_cimg[1]+'" width="48" /></li>');
				}
			}
			renderLeftTools(); 
		}

		//��ʼ��tab����
		tab_panel = new TabPanel({  
			renderTo:'tabs_platform',  
			//border:'none',  
			active : 0,
			//maxLength : 10, 
			autoResizable:true, 
			items : [
				{id:'mydesktop',title:'��������',html:'<iframe src="/index/demo" width="100%" height="100%" frameborder="0" name="mydesktop"></iframe>',closable: false}
			]
		}); 
		
	});
	
	//�����Ļ��Сת��
	function ReSet() {
		if(document.body.clientHeight<400){
			$(".sys_fun_btn").css('display','none');
			is_visible_left_sys_btn = false;
		}else{
			$(".sys_fun_btn").css('display','');
			is_visible_left_sys_btn = true;
		}
		setTimeout(function(){
            resetWorkpHeight(0);
        },800);
	}

	//�����tab�����������¼���߿��
	$("ul.tabpanel_mover li").live('click',function(){
		setTimeout(function(){
			resetWorkpHeight(0);
		},400);
	})
	
  </script>
</head>
<body onResize="ReSet()">