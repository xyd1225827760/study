<?php
/**
 * Html模板文件
 *
 * @copyright   Copyright: 2010
 * @author      LuoDong<751450467@qq.com>
 * @package     CandorPHP
 * @version     $Id: set_app.html.php,v 1.3 2013/11/18 09:47:36 yl Exp $
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>应用设置</title>
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/common.css';?>' type='text/css' media='screen' />
<script src="/js/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="/js/jquery.cookie.js" type="text/javascript"></script> 
<!-- *加载等待 js -->
<script src="/js/candor.blockui.js" type="text/javascript"></script>
<style>
body{ background:url(/js/plugins/jquery.tabPanel/image/TabPanel/content_bg.png) repeat;}
a {
  color:#000;
  text-decoration: none;
}
a:hover {
  text-decoration: underline;
}
#btnAppSet {
    background: url("/theme/default/images/bar_btn_appset.png") repeat scroll center center transparent;
    cursor: pointer;
    display: block;
    float: left;
    height: 22px;
    margin:6px 10px 0 10px;
    width: 102px;
}

.app_wrap{width:600px;height:380px; background:#FFF}
.app_wrap .app_content{width:100%;height:350px;}
.app_wrap .app_content img{ vertical-align:middle; display:block; margin:0 auto}


.app_wrap .app_content .right{float:left;width:auto;height:350px;}
.app_wrap .app_content .right ul{width:100%;height:100%;}
.app_wrap .app_content .right li{cursor: pointer;float:left;margin:10px 0 10px 9px; text-align:center;width: 85px;}
.app_wrap .app_content .right li a:hover{color: #fff;background:#658EC5;}
.box-opacity{filter:gray; -moz-opacity:.4;opacity:0.4;}
.box-opacity:hover{ cursor:not-allowed}
</style>
<script>			
function addtool(obj){
	var rtopFrame = $(self.parent.window.document);
	var id=$(obj).attr("id");
	var cimg = $(obj).find('img').attr('src');
	var title = $(obj).attr('title');
	var src = $(obj).attr('appurl');
	$(".my_tools ul",rtopFrame).append('<li id="'+id+'" class="itool" title="'+title+'" src="'+src+'"><img src="'+cimg+'" width="48" /></li>');
	$(obj).addClass('box-opacity');
	$(obj).attr('onclick','');
	window.parent.renderLeftTools(); 
	
	//设置cookie信息
	var cookie_itool = $.cookie(id);
	var cookie_itool_ids = $.cookie("itool_ids"); 
	if(cookie_itool==null){ 
		if(cookie_itool_ids==null){ 
			$.cookie("itool_ids",id,{expires:30,path:'/'});
		}else{
			$.cookie("itool_ids",cookie_itool_ids+"|"+id,{expires:30,path:'/'});
		}
		$.cookie(id,"id:"+id+";title:"+title+";src:"+src+";cimg:"+cimg,{expires:30,path:'/'});
	}
}

$(function(){
	//获取所有应用判断是否存在cookie信息
	$("#app_box a").each(function(i){
	   //检查cookie信息是否存在
		var cookie_itool = $.cookie($(this).attr('id'));
		if(cookie_itool!=null){ 
			$(this).addClass('box-opacity');
			$(this).attr('onclick','');
		}
	 }); 
});

//关闭加载等待提示
$(window).load(function(){
	$('.html_content',$(self.parent.window.document)).unblock();
});

</script>
</head>
<body>
	<div class="app_wrap" style="position:relative">
        <div class="app_content">
            <div class="right">
            	<ul style="cursor:pointer" id="app_box">
                	<?php foreach($moduleList as $key=>$item){ ?>
                	<li><a id="app_<?php echo $item['id']; ?>" appid="<?php echo $item['id']; ?>" appurl="<?php echo "/".$item['module_name']; ?>/index.candor?app=CripService&flowid=1" href="javascript:;" onclick="addtool(this)" title="<?php echo $item['business_name']; ?>">
                    	<img src="/images/app_icons/<?php echo $item['icon']; ?>" align="absMiddle" width="48" height="48">
                    	<span class="lright"><?php echo $item['business_name']; ?></span>
						</a>
                    </li>
                    <?php } if($_SESSION['userRelateInfo']['ISADMIN']==1){ ?>
					<li><a id="app_97" appid="97" appurl="http://www.pm.com/sysworkflow/zh-CN/classic/cases/main" onclick="addtool(this)" title="工作流程">
                    	<img src="/images/app_icons/attendance.png" align="absMiddle" width="48" height="48">
                    	<span class="lright">工作流程</span>
						</a>
                    </li>
					<li><a  id="app_98" appid="98" appurl="/admin/workFlowList" onclick="addtool(this)" title="流程建模">
                    	<img src="/images/app_icons/project.png" align="absMiddle" width="48" height="48">
                    	<span class="lright">流程建模</span>
						</a>
                    </li>
					<li><a  id="app_99" appid="99" appurl="/demo" onclick="addtool(this)" title="demo">
                    	<img src="/images/app_icons/comm.png" align="absMiddle" width="48" height="48">
                    	<span class="lright">demo</span>
						</a>
                    </li>
                    <? } ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>