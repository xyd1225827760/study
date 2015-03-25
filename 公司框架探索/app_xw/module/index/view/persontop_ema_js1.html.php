<?php
/**
 * Html模板文件
 *
 * @copyright   Copyright: 2010
 * @author      LuoDong<751450467@qq.com>
 * @package     CandorPHP
 * @version     $Id: index.html.php,v 1.4 2012/02/16 09:54:23 lj Exp $
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>Css+Html前端框架</title>
</head>
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/common.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/cdrstyle.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/default/metroicon.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/default/style.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/default/page.css';?>' type='text/css' media='screen' />
<style>
body{overflow:visible;color: #000;
    font-family: 'Arial';
    padding: 0px !important;
    margin: 0px !important;
    font-size:13px;
    /*overflow-x: hidden ;*/
    background:#404040 ;
}
.fixed-top #container {
    margin-top: 0;
}
#main-content {
    background: none repeat scroll 0 0 #FFFFFF;
    margin-bottom: 40px !important;
    margin-left: 0px;
    margin-top: 0;
    min-height: 1000px;
}
</style>
<body class="fixed-top">
	<div class="row-fluid" id="container">
      <!-- BEGIN PAGE -->  
      <div id="main-content">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
               <div class="span12">
			   		<div class="space15"></div>
                  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                   <ul class="breadcrumb">
                       <li>
                            <marquee>欢迎进入熙泰运业不动产资产管理平台！&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</marquee>
                       </li>                       
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
             <div class="profile row-fluid">
                 <!-- BEGIN PROFILE PORTLET-->
				 <div class="span2">
					 <a class="profile-features" style="background: none repeat scroll 0 0 #c81207;" href="javascript:frameWorkTab('app_50','资产入库','/eam_Assetsreceipt/index.candor');">
						 <i class="icon-envelope-alt"></i>
						 <p class="info">新增土地</p>
					 </a>
					 <a class="profile-features"  style="background: none repeat scroll 0 0 #0DA38A;" href="javascript:frameWorkTab('app_1','资金管理','/eam_fund/index.candor');">
						 <i class=" icon-user"></i>
						 <p class="info">新增资金</p>
					 </a>
					 <a class="profile-features "  style="background: none repeat scroll 0 0 #FB93A4;"  href="javascript:frameWorkTab('app_2','新增合同','/eam_contract/index.candor')">
						 <i class=" icon-calendar"></i>
						 <p class="info">新增合同</p>
					 </a>
					 <a class="profile-features "  style="background: none repeat scroll 0 0 #0B8CCD;"  href="javascript:frameWorkTab('app_3','新增维修','/eam_maintain/index.candor')">
						 <i class=" icon-phone"></i>
						 <p class="info">新增维修</p>
					 </a>
					 <a class="profile-features "  style="background: none repeat scroll 0 0 #rgb(245, 245, 245);"  href="javascript:dialogInfo(1);">
						 <i class=" icon-legal"></i>
						 <p class="info">综合管理</p>
					 </a>
				 </div>
				 <div class="span10">
					 <!--
					 <div class="profile-head">
						 <div class="span4">
							 <h1>Jonathan Smith</h1>
							 <p>Lead Designer at <a href="#">Vectorlab Inc.</a></p>
						 </div>

						 <div class="span4">
							 <ul class="social-link-pf">
								 <li><a href="#">
									 <i class="icon-facebook"></i>
								 </a></li>
								 <li><a href="#">
									 <i class="icon-twitter"></i>
								 </a></li>
								 <li><a href="#">
									 <i class="icon-linkedin"></i>
								 </a></li>
							 </ul>
						 </div>

						 <div class="span4">
							 <a class="btn btn-edit btn-large pull-right mtop20" href="edit_profile.html"> Edit Profile </a>
						 </div>
					 </div>
					 <div class="space15"></div>
					 -->
					 <div class="row-fluid">
						 <div class="span8 bio">
						 <div class="profile-features"  style="background:none repeat scroll 0 0 ;">
							 <h2>个人信息</h2>
							 <p>当前用户[张三]：&nbsp;管辖不动产资产，其中土地【13】宗，房屋数【70】套，站场数【2】个，车场数【6】个，广告位【17】个 </p>
						</div>
							 <hr>
						 <div style="background:none repeat scroll 0 0;">
							 <h2>资产收益</h2>
 							<div id="slvcharts_container">
								<?=$slvchartdata ?>
							</div>		
						</div>
							 <hr>
						 <div class="profile-features"  style="background:none repeat scroll 0 0 ;">
							<h2>资料下载</h2>
							<ul> 
								<li style="margin-top:20px;height:20px;"><h4><a href="#"  target="_blank">【不动产资产平台系统操作手册.doc】</a></h4>
								</li>
								<li  style="margin-top:10px;height:20px;"><h4><a href="/images/operatebook-sld.doc"  target="_blank">【集团平台资产合同统一模板.doc】</a></h4>
								</li>
								<li  style="margin-top:10px;height:20px;"><h4><a href="/images/operatebook-zgy.doc" target="_blank">【熙泰集团2014年春节放假通知.doc】</a></h4>
								</li>
							</ul>
						</div>
							 <div class="space20"></div>

						 </div>
						 <div class="span4">
							 <div class="profile-side-box red">
								 <h1>资产评估环比</h1>
								 <div class="desk" style="padding:0px 0px 0px 0px;">
									 <div class="row-fluid">
										<div id="emacharts_container">
											<?=$emachartdata ?>
										</div>
									 </div>
								 </div>
							 </div>
							 <div class="profile-side-box green">
								 <h1>通知通告</h1>
								 <div class="desk">
									 <div class="row-fluid experience">
										<ul  style="margin:0 0 0 0;">
											<li style="line-height:30px;"><a>不动产资产信息平台上线工作安排</a></li>
											<li style="line-height:30px;"><a>关于2014熙泰运业集团新春茶话会</a></li>
											<li style="line-height:30px;"><a>熙泰运业集团公布2013年第四季度业绩</a></li>
											<li style="line-height:30px;"><a>2014年1月30号****领导考察乐山运输公司</a></li>
											<li style="line-height:30px;"><a>熙泰运业集团公布2013年第三季度及全年业绩</a></li>
										</ul>
									 </div>
									 <div class="space10"></div>
								 </div>
							 </div>
						 </div>
					 </div>
				 </div>
                 <!-- END PROFILE PORTLET-->
             </div>
            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->  
   </div>
<script src="/js/jquery-1.8.3.min.js" ></script>
<script src="/js/jquery.nicescroll.js"></script>
<script src="/js/bootstrap.min.js" ></script>
<script src="/js/jquery.scrollTo.min.js" ></script>
<script src="/js/candor.portal.js" ></script>
<script src="/js/candor.common.js"></script>
<script src="/js/plugins/artDialog/jquery.artDialog.source.js?skin=default" type="text/javascript"></script>
<script src="/js/plugins/artDialog/plugins/iframeTools.js" type="text/javascript"></script>
<script>
function dialogInfo(type){
	var action = "viewEamInfo";
	var title = "综合查询";
	if(type==2){
		action = "viewMarket";
		title = "市场信息";
	}
	art.dialog.open('/eam_complexquery/'+action+'.candor',{
		title:title,
		width:'50%',
		height:'50%',
		lock:'true',
		esc:'false',
		id:'editiframe',
		window:top,
		ok:function(){
			frameWorkTab('app_5','综合查询管理','/eam_complexquery/index.candor');
		},
		cancel: true
	});
}
</script>
</body>
</html>