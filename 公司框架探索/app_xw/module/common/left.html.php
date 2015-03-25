<script type="text/javascript">
/* 调用框架tab */
function frameWorkTab(id,title,url){
	var tabWinC = '<iframe src="'+url+'" width="100%" height="100%" frameborder="0"></iframe>';
	window.top.tab_panel.addTab({id:id+"_1", 
						  title:title,
						  html:tabWinC,
						  closable: true, 
						  disabled:false
					   });
}

function set_app(){
	art.dialog.open("/index/set_app", {
			title: '应用设置'
		});
}

function exit(){
	var isok = confirm('你确定退出关闭页面吗？','2222');
	if(isok==1){
		window.close();
	}
}

function modifyPwd(){
	art.dialog.open("/index/modifyPwd", {
			title: '密码修改',
			lock:true
		});
}
function isVisibleNum(){
	height=$("#left_container").height();
	iheight=$("#left_container").innerHeight();//元素内部区域高度，忽略padding、border
	oheight=$("#left_container").outerHeight();//忽略边框
	oheight2=$("#left_container").outerHeight(true);//包含边框高度
	if(is_visible_left_sys_btn){
		rheight = oheight-230-22-40;
	}else{
		rheight = oheight-22-40;
	}
	left_tools_num_visible = Math.floor(rheight/64);
	return left_tools_num_visible;	
}

function renderLeftTools(){
	if($(".my_tools li").size()>isVisibleNum()){
		$(".prev").css("display","");
		$(".next").css("display","");
	}else{
		$(".prev").css("display","none");
		$(".next").css("display","none");
	}
	$(".my_tools").jCarouselLite({
			btnNext: ".next",
			btnPrev: ".prev",
			visible: left_tools_num_visible,
			circular: false
		});
	
		//初始化左边工具右键菜单
		$('.my_tools li').each(function(){
			var win_contextmenu = $(this).WinContextMenu({
				cancel:'.cancel',
				items:[{
					id:'open_my_tools',
					cid:$(this).parent().parent().parent().attr('id'),
					text:'打开',
					icon:'/js/plugins/jquery.contextMenu/skins/default/contextmenu/icons/open.png',
					disable:0,//打开
					action:function(){
						if($(win_contextmenu).attr("type")=="html"){
							var tabWinC = $(win_contextmenu).attr("src");
						}else{
							var tabWinC = '<iframe src="'+$(win_contextmenu).attr("src")+'" width="100%" height="100%" frameborder="0"></iframe>';
						}
						tab_panel.addTab({id:$(win_contextmenu).attr("id")+"_1", 
						  title:$(win_contextmenu).attr("title"),
						  html:tabWinC,
						  closable: true, 
						  disabled:false
					   });
					}
				},
				{
					id:'refresh_my_tools',
					text:'刷新',
					icon:'/js/plugins/jquery.contextMenu/skins/default/contextmenu/icons/refresh.png',
					action:function(){
						if(confirm("确定要刷新该页面嘛，刷新后数据将重新载入，现有数据将会丢失？"))
						{
								
						}else{
								
						}	
					}
				},
				{
					id:'remove_my_tools',
					text:'移除',
					icon:'/js/plugins/jquery.contextMenu/skins/default/contextmenu/icons/remove.png',
					action:function(){
						//删除cookie
						$(win_contextmenu).remove();
						var cookie_itool_ids = $.cookie('itool_ids'); 
						if(cookie_itool_ids!=null){ 
							var arr_tool_ids = cookie_itool_ids.split("|");
							var new_arr_tool_ids="";
							for(var i=0;i<arr_tool_ids.length;i++){
								if($(win_contextmenu).attr("id")!=arr_tool_ids[i]){
									new_arr_tool_ids = new_arr_tool_ids +"|"+arr_tool_ids[i];
								}
							}
							if(new_arr_tool_ids==""){ 
								$.cookie("itool_ids",null);
							}else{
								$.cookie("itool_ids",new_arr_tool_ids,{expires:30,path:'/'});
							}
						}
						$.cookie($(win_contextmenu).attr("id"),null);
					}
				},
				{
					id:'remove_my_tools',
					text:'关闭菜单',
					icon:'/js/plugins/jquery.contextMenu/skins/default/contextmenu/icons/close.png',
					action:function(){
						//this.remove();
						tab_panel.kill($(win_contextmenu).attr("id")+"_1");
					}
				}]
			});		
		});
}
$(function(){
    $("#first_menu li:eq(0)").click();
})
</script>
<style>
.expand_on{ display:block}
.expand_off{ display:none}
#start_menu li {
	display:block;
	text-align:center;
	/*padding: 1px 2px 1px 2px;*/
	margin-top:1px;
	border:none;
	overflow:hidden;
}
#start_menu .dropdown_panel{
	width: 380px;
	height:404px;
	float:left;
	position:absolute;
	z-index:10000;
	left:-999em; 	
	text-align:left;
	/*
	margin-left:15px;
	padding:10px 5px 5px 5px;
	background:#E8EBF0;*/
}
#start_menu li:hover .dropdown_panel{left:-1px;top:auto;}	
.dropdown_panel .head-arrow{height:16px;width:404px;background:url(/theme/default/images/start_menu_panel_bg.png)}
.dropdown_panel .head_panel{height:52px;width:360px;padding:0 22px;background:url(/theme/default/images/start_menu_panel_bg.png) repeat-y;background-position:0 -15px;}
.dropdown_panel .panel-foot{height:16px;width:404px;background:url(/theme/default/images/start_menu_panel_bg.png);background-position: -808px bottom;}
.dropdown_panel .line{border-top:1px solid #999;border-bottom:1px solid #fff; margin-top:5px ;}
.dropdown_panel .menu_panel{height:338px;width:380px;overflow:hidden;background:url(/theme/default/images/start_menu_panel_bg.png) repeat-y;background-position: -404px 0;padding:0 12px;}
.dropdown_panel .head_panel img{border:3px solid #D2D3D7;width:40px;height:40px;float:left}
.dropdown_panel .menu_panel img{border:none;width:20px;height:20px;padding-right:5px;}
.menu_panel a {text-decoration: none;display: block;margin: 0;}
.head_panel .tools{margin-top:20px;float:left;width:150px;height:30px;}
.head_panel .tools .logout{
background: url("/theme/default/images/logout.jpg") no-repeat scroll 0 0 transparent;
    display: inline-block;
    height: 24px;
    margin-right: 14px;
    overflow: hidden;
    width: 58px;
}
.head_panel .tools .logout:hover{ background-position:0 -24px;}
.head_panel .tools .exit {
    background: url("/theme/default/images/logout.jpg") no-repeat scroll -62px 0 transparent;
    display: inline-block;
    height: 24px;
    overflow: hidden;
    width: 55px;
}
.head_panel .tools .exit:hover{ background-position:-62px -24px;}
.head_panel .userinfo{width:143px;padding:30px 5px 0 10px;float:left;height:22px; vertical-align:bottom}
.menu_panel #first_panel{width:200px;float:left;position:relative; z-index:10003;padding:5px 0;overflow: auto}
.menu_panel #second_panel{width:180px;height:336px;float:left;position:absolute;left:202px;z-index:10002;background: #E8EBF0 url(/theme/default/images/second_menu_bg.png) repeat-y; padding:3px 0; overflow:auto}
#second_panel .second-panel-head{ height:5px; overflow:hidden;}
#second_panel .second-panel-foot{ height:5px; overflow:hidden;}
#first_menu{margin-top:4px;}
#first_menu ul{width:200px;}
#first_menu li{text-align:left;}
#first_menu li a {
    background:url(/theme/default/images/menu_bg.png) right top;
    color: #000000;
    display: block;
    font-size: 12px;
    height: 25px !important;
    line-height: 20px;
    overflow: hidden;
    padding-left: 10px;
    padding-top: 5px !important;
    text-decoration: none;
}
#first_menu li a.active,#first_menu li:hover > a {
	background-position:right -30px;
	color:#FFF;
}

#second_menu li a{line-height:28px;padding-left:10px;text-align:left;color:#000000}
#second_menu li a.expand{background:url(/theme/default/images/menu_bg.png) no-repeat right -60px}
#second_menu li a:hover{background:url(/theme/default/images/menu_bg.png) no-repeat left -90px;color:#fff}
#second_menu li a.active,#second_menu li a.expand:hover  {background-position:right -90px; color:#fff}
#second_menu li a span{background:url(/theme/default/images/menu_span_bg.png) no-repeat;
    cursor: pointer;
    display: block;
    height: 30px;
    line-height: 30px;
    overflow: hidden;
    padding-left: 20px;}
#second_menu li a:hover span{ background-position:0 -30px;}	

#second_menu ul li a {
    overflow: hidden;
    padding-left: 30px;
}
#second_menu ul li a:hover {
    background: none;color:#1E66C7;
}
#second_menu ul li a span {
    background: url(/theme/default/images/menu_span_bg.png) no-repeat 0 -60px;
    cursor: pointer;
	
}
#second_menu ul li a:hover span {
	background-position:0 -90px;
}

</style>
<div id="left_container">
	<ul id="start_menu">
        <li>
            <a class="button blue">菜 单</a>
            <div class="dropdown_panel box-shadow corner-all">
            	<!--div class="arrow-up"></div-->
				<div class="head-arrow"></div>
                <div class="head_panel">
                    <img src="/images/app_icons/erp.png" class="corner-all ml5" />
					<div class="userinfo">
						当前用户:<?php echo $_SESSION["userInfo"]["login"];?>
					</div>
                    <div class="tools">
            			<a class="logout" href="/index/logout" title="注销"></a>
            			<a class="exit" href="/index/logout" onclick="exit();"  title="退出"></a>
                    </div>
                </div>
        		<!--div class="line"></div-->
                <div class="menu_panel">
                    <div id="first_panel">
                        <div class="scroll-up"></div>
                        <ul id="first_menu">
                        <?php foreach($projectList as $key=>$iproject) {?>
                        <li class="current" pid="<?=$iproject["project_code"]?>"><a hidefocus="hidefocus" href="javascript:;" title="<?=$iproject["project_name"]?>"><img align="absMiddle" src="/images/icon/<?=$iproject["project_icon"]?>" /><?=$iproject["project_name"]?></a></li>
                        <?php }?>
                       </ul>
                        <div class="scroll-down"></div>
                     </div><!-- first_panel end -->
                    <div id="second_panel">
					<div class="second-panel-head"></div>
					<div class="second-pane-menu"></div>
						<ul id="second_menu">
						   <!--li><a hidefocus="hidefocus" class="expand" id="f27"><span>人事管理</span></a>
							<ul style="display:none">
							 <li><a hidefocus="hidefocus" onclick="createTab(60,'人事档案','hr/manage/staff_info','');" href="javascript:;" id="f60"><span>人事档案</span></a></li>
							 <li><a hidefocus="hidefocus" onclick="createTab(61,'档案查询','hr/manage/query','');" href="javascript:;" id="f61"><span>档案查询</span></a></li>
							 <li><a hidefocus="hidefocus" onclick="createTab(481,'合同管理','hr/manage/staff_contract','');" href="javascript:;" id="f481"><span>合同管理</span></a></li>
							</ul>
						   </li
						   <?php foreach($moduleList as $key=>$imodule){ ?>
						   <li><a hidefocus="hidefocus" onclick="" href="javascript:frameWorkTab('<?=$imodule['id'] ?>','<?=$imodule['business_name'] ?>','/<?=$imodule['module_name'] ?>');" id="f27"><span><?=$imodule['business_name'] ?></span></a></li>
						   <?php  } ?>-->
						</ul>
					</div>
					<div class="second-panel-foot"></div>
				 </div><!-- second panel end -->
				 
				 <div class="panel-foot"></div>
				 
            </div>
        </li>
    </ul>

    <div id="left_container_top"></div>
    <div id="left_container_box">
    	<div class="prev"></div>
    	<div class="my_tools">
            <ul>
                
            </ul>
        </div>
        <div class="next"></div>
    	<a href="#" class="sys_fun_btn" style="height:55px"><div id="candor_logo"></div></a>
<!--         <a href="#" class="sys_fun_btn" style="bottom:65px"><div id="delete_them"><img title="default" src="/theme/default/images/set.png" class="ml10" /><img title="blue" src="/theme/default/images/skin.png" class="ml15" /></div></a> -->
        <a href="#" class="sys_fun_btn" style="bottom:55px"><div><img title="default" src="/theme/default/images/set_app.png" class="ml10" onclick="set_app();" /><img src="/theme/default/images/cancel.png" class="ml15" onclick="modifyPwd();"/></div></a>
    </div>
</div>