<?php
/**
 * Htmlģ���ļ�
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
<title>Css+Htmlǰ�˿��</title>
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
                            <marquee>��ӭ����˫���ص�˰�ַ��ز�������ҵ����Ʒ����˰�����ܸ���ϵͳ��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</marquee>
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
					 <a class="profile-features" style="background: none repeat scroll 0 0 #c81207;" href="javascript:dialogInfo(1);">
						 <i class="icon-envelope-alt"></i>
						 <p class="info">�г���Ϣ</p>
					 </a>
					 <a class="profile-features"  style="background: none repeat scroll 0 0 #0DA38A;" href="javascript:dialogInfo(2);">
						 <i class=" icon-user"></i>
						 <p class="info">Ԥ����Ϣ</p>
					 </a>
					 <a class="profile-features "  style="background: none repeat scroll 0 0 #FB93A4;"  href="javascript:frameWorkTab('app_5','��ҵ����','/cyzt_companylist/index.candor')">
						 <i class=" icon-calendar"></i>
						 <p class="info">��ҵ����</p>
					 </a>
					 <a class="profile-features "  style="background: none repeat scroll 0 0 #0B8CCD;"  href="javascript:frameWorkTab('app_5','��ҵ����','/tax_paytaxes/index.candor')">
						 <i class=" icon-phone"></i>
						 <p class="info">��˰����</p>
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
							 <h2>������Ϣ</h2>
							 <p>��ǰ�û�[<?= $pagedata['username'] ?>]��&nbsp;��Ͻ��ҵ����<a href="#"><?= $pagedata['cmpcnt'] ?></a>���ң���Ŀ����<a href="#"><?= $pagedata['procnt'] ?></a>������Ԥ��֤����<a href="#"><?= $pagedata['prescnt'] ?></a>����<!-- ������Ͻ��ҵ�ܹ�Ӫҵ����<a href="#">56</a>����Ԫ��������ֵ˰Ԥ��ֵ��<a href="#">56</a>����Ԫ����ҵ����˰Ԥ��ֵ ��<a href="#">56</a>����Ԫ��Ӫҵ˰�����ӵ�Ԥ��ֵ��<a href="#">56</a>����Ԫ --> </p>
						</div>
							 <hr>
						 <div style="background:none repeat scroll 0 0;">
							 <h2>��˰��Ϣ</h2>
 							<div id="estatecharts_container">
								<?=$estatechartdata ?>
							</div>		
						</div>
							 <hr>
						 <div class="profile-features"  style="background:none repeat scroll 0 0 ;">
							<h2>��������</h2>
							<ul> 
								<li style="margin-top:20px;height:20px;"><h4><a href="/images/operatebook-jld.doc"  target="_blank">˫���ص�˰�ַ��ز�������ҵ˰�����ܸ���ϵͳ-�����ֲ�(���쵼�汾)</a></h4>
								</li>
								<li  style="margin-top:10px;height:20px;"><h4><a href="/images/operatebook-sld.doc"  target="_blank">˫���ص�˰�ַ��ز�������ҵ˰�����ܸ���ϵͳ-�����ֲ�(���쵼�汾)</a></h4>
								</li>
								<li  style="margin-top:10px;height:20px;"><h4><a href="/images/operatebook-zgy.doc" target="_blank">˫���ص�˰�ַ��ز�������ҵ˰�����ܸ���ϵͳ-�����ֲ�(˰��Ա�汾)</a></h4>
								</li>
							</ul>
						</div>
							 <div class="space20"></div>

						 </div>
						 <div class="span4">
							 <div class="profile-side-box red">
								 <h1>�г���Ϣ</h1>
								 <div class="desk" style="padding:0px 0px 0px 0px;">
									 <div class="row-fluid">
 							<div id="stotchart_container">
								<?=$chartdata ?>
							</div>
									 </div>
								 </div>
							 </div>
							 <div class="profile-side-box green">
								 <h1>������Ŀ</h1>
								 <div class="desk">
		<?php foreach($newprojlist as $key=>$item){?>
									 <div class="row-fluid experience">
										 <h4><a href="#"><?= $item['PROJECTNAME'] ?></a></h4>
										 <p>����Ŀ�滮���Ϊ[<?= $item['LUAREA'] ?>]�O,�滮����Ϊ[<?= $item['LUTOT'] ?>]��,�������Ϊ[<?= $item['SLUAREA'] ?>]��,��������Ϊ[<?= $item['SLUTOT'] ?>]��</p>
										 <a href="#"><?= $item['FULLNAME'] ?></a>
									 </div>
									 <div class="space10"></div>
		<?php }?>

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
	var action = "viewPresell";
	var title = "Ԥ����Ϣ";
	if(type==2){
		action = "viewMarket";
		title = "�г���Ϣ";
	}
	art.dialog.open('/tax_base/'+action+'.candor',{
		title:title,
		width:'90%',
		height:'90%',
		lock:'true',
		esc:'false',
		id:'editiframe',
		window:top,
		ok:function(){
			return false;
		},
		cancel: true
	});
}
</script>
</body>
</html>