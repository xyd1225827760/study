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
                           <a href="#">��������</a>
                           <span class="divider">/</span>
                       </li>
                       <li class="active">
                           ����ס����ҳ
                       </li>
                       <li class="pull-right search-wrap">
                           <form class="hidden-phone" action="search_result.html">
                               <div class="input-append search-input-area">
                                   <input type="text" id="appendedInputButton" class="">
                                   <button type="button" class="btn"><i class="icon-search"></i> </button>
                               </div>
                           </form>
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
					 <div class="profile-photo">
						 <img alt="" src="/upload/lock-thumb.jpg">
						 <a title="Edit Photo" class="edit" href="javascript:;">
							 <i class="icon-pencil"></i>
						 </a>
					 </div>
					 <a class="profile-features active" href="profile.html">
						 <i class=" icon-user"></i>
						 <p class="info">��Ϣ��ѯ</p>
					 </a>
					 <a class="profile-features " href="profile_activities.html">
						 <i class=" icon-calendar"></i>
						 <p class="info">ҵ��״̬</p>
					 </a>
					 <a class="profile-features " href="profile_contact.html">
						 <i class=" icon-phone"></i>
						 <p class="info">�������</p>
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
							 <h2>����ס����Ϣ</h2>
							 <p>��ĩ�������˵339�㳡��ҵ�ˣ�С�˷��˹����϶�����ʳ�����պ��ڵ����������ϰ࣬��������еط��������ˡ������Ǹտ�ҵ���϶��Żݶ����</p>
							 <div class="space15"></div>
							 <h2>�����ע</h2>
							 <p><label>������</label>: 59��</p>
							 <p><label>��ţ��</label>: 59��</p>
							 <p><label>������</label>: 59��</p>
							 <p><label>�����</label>: 59��</p>
							 <p><label>�ɻ���</label>: 59��</p>
							 <p><label>������</label>: <a href="#">59��</a></p>
							 <p><label>˫��</label>: 59��</p>
							 <p><label>�½�</label>: <a href="#">59��</a></p>
							 <div class="space15"></div>
							 <hr>
							 <div class="space15"></div>

							 <h2>��Ŀͳ��</h2>
							 <ul class="unstyled">
								 <li>
									   סլ <strong class="label"> 48%</strong>
									 <div class="space10"></div>
									 <div class="progress">
										 <div style="width: 48%;" class="bar"></div>
									 </div>
								 </li>
								 <li>
									 ��ҵ <strong class="label label-success"> 85%</strong>
									 <div class="space10"></div>
									 <div class="progress progress-success">
										 <div style="width: 85%;" class="bar"></div>
									 </div>
								 </li>
								 <li>
									 д�� <strong class="label label-important"> 65%</strong>
									 <div class="space10"></div>
									 <div class="progress progress-danger">
										 <div style="width: 65%;" class="bar"></div>
									 </div>
								 </li>

							 </ul>
							 <div class="text-center">
								 <button class="btn btn-primary ">��������</button>
							 </div>
							 <div class="space20"></div>

						 </div>
						 <div class="span4">
							 <div class="profile-side-box red">
								 <h1>�����Ŀ</h1>
								 <div class="desk">
									 <div class="row-fluid">
										 <div class="span4">
											<div class="text-center">
												<a href="#"><img alt="" src="/upload/avatar1.jpg"></a>
												<p><a href="#">·������</a></p>
											</div>
										 </div>
										 <div class="span4">
											 <div class="text-center">
												 <a href="#"><img alt="" src="/upload/avatar2.jpg"></a>
												 <p><a href="#">�츳��԰</a></p>
											 </div>
										 </div>
										 <div class="span4">
											 <div class="text-center">
												 <a href="#"><img alt="" src="/upload/avatar3.jpg"></a>
												 <p><a href="#">�̵�����</a></p>
											 </div>
										 </div>
									 </div>
								 </div>
							 </div>
							 <div class="profile-side-box green">
								 <h1>�������</h1>
								 <div class="desk">
									 <div class="row-fluid experience">
										 <h4>���˹���</h4>
										 <p>���������ϵͼ�� �����ݳ�ϸ�� ͥ��ȫ��¼</p>
										 <a href="#">www.candorsoft.com</a>
									 </div>
									 <div class="space10"></div>
									 <div class="row-fluid experience">
										 <h4>���׷�����</h4>
										 <p>�й�ǰ�׸�����󱻿� �ɷ��ѱ��̾�</p>
										 <a href="#">www.candorsoft.com</a>
									 </div>
									 <div class="space10"></div>
									 <div class="row-fluid experience">
										 <h4>������������</h4>
										 <p>�ź����ڲ��������������� ����ί��ϯ</p>
										 <a href="#">www.candorsoft.com</a>
									 </div>
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
</body>
</html>