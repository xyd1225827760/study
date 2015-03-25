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
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/mtek_font-awesome.min.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/mtek_simple-line-icons';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/bootstrap.min.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/mtek_animate.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/mtek_all.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/bootstrap-switch.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/prettify.css';?>' type='text/css' media='screen' />
<link type="text/css" rel="stylesheet" href="" id="font-layout">
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/toastr.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/mtek_core.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/mtek_system.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/mtek_system-responsive.css';?>' type='text/css' media='screen' />
<style>
.the-price{padding:3px;}
</style>
<body>
<div class="page-wrapper">

<div class="page-content">
	<!-- begin page header-->
	<div class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">�ƻ�����</div>
		</div>
		<ol class="breadcrumb page-breadcrumb hidden-xs">
			<li><i class="fa fa-home"></i>&nbsp;<a href="index.html">��������</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
			<li><a href="#">�ƻ�����</a>&nbsp;&nbsp;</li>
		</ol>
	</div>
	<!-- end  page header-->
	
	<!-- begin box-content -->
	<div class="box-content">
		<!--begin content-->
		<div class="content">
			<div class="page-profile">
				<div class="row">
					<div class="col-lg-12">
						<!-- begin panel -->
						<div class="panel">
							<div class="panel-body">
								<div class="row">
									<div class="profile-left-side col-md-3">
										<div class="user-img text-center"><img class="img-circle" src="/images/app_icons/diary.png"></div>
										<!--div class="social-icon-group">
											<ul class="social-icons list-unstyled list-inline text-center mbl mtl">
												<li><a class="facebook" data-original-title="facebook" data-hover="tooltip" href="#"><i class="fa fa-facebook"></i></a></li>
												<li><a class="googleplus" data-original-title="google Plus" data-hover="tooltip" href="#"><i class="fa fa-google-plus"></i></a></li>
												<li><a class="twitter" data-original-title="twitter" data-hover="tooltip" href="#"><i class="fa fa-twitter"></i></a></li>
											</ul>
										</div-->
										<div class="text-center"><br /><br />
										<!--<a class="btn btn-default" href="javascript:Add();"><i class="fa fa-file-o"></i>&nbsp;�½��ƻ�</a>-->
										<a class="btn btn-default" href="/index/adddemo1.candor"><i class="fa fa-file-o"></i>&nbsp;�½��ƻ�</a>
										<!--<a class="btn btn-default" href="/index/layout.candor"><i class="fa fa-file-o"></i>&nbsp;�½��ƻ�</a>-->
										</div>
										<div class="row">
											
											<dl class="recent-post-list col-sm-6 col-md-12 mtl">
												<dt>
												<p class="title-line"><i class="fa fa-list-alt"></i>&nbsp;�ƻ�����<span class="text-muted"></span>
												</p></dt>
												<dd class="mtm"><a class="post-title" href="#"><img class="mrs" src="/images/app_icons/work_plan.png"><span>�ռƻ�</span></a>
												</dd>
												<dd class="mtm"><a class="post-title" href="#"><img class="mrs" src="/images/app_icons/work_plan.png"><span>�ܼƻ�</span></a>
												</dd>
												<dd class="mtm"><a class="post-title" href="#"><img class="mrs" src="/images/app_icons/work_plan.png"><span>�¼ƻ�</span></a>
												</dd>
												<dd class="mtm"><a class="post-title" href="#"><img class="mrs" src="/images/app_icons/work_plan.png"><span>�ƻ�ִ��</span></a>
												</dd>
												</dd>
											</dl>
										</div>
									</div>
									<div class="profile-right-side col-md-9">
										<div class="row">
											<div class="col-xs-12">
												<h3 class="mbs mlx plm" style="color: #222">�ռƻ�����</h3>
												<div class="pricing-table">
													<div class="row mtl">
														<div class="col-xs-12 col-md-6 col-lg-3">
															<div class="panel">
																<div class="panel-heading">
																	<div class="caption">2014-12-30</div>
																</div>
																<div class="panel-body pan text-center">
																	<div class="the-price"><h1 class="mtn">10<span class="subscript">/��</span></h1>
																		<small>�����ƻ�</small>
																	</div>
																	<table class="table mbn">
																		<tbody>
																		<tr>
																			<td>��������</td>
																		</tr>
																		<tr class="active">
																			<td>1��</td>
																		</tr>
																		
																		</tbody>
																	</table>
																</div>
																<div class="panel-footer pal">
																	<p class="text-muted text-center">����鿴��ϸ��Ϣ</p>
																	<a class="btn btn-success btn-block" role="button" href="javascript:void(0);">��ϸ</a>
																</div>
															</div>
														</div>
														<div class="col-xs-12 col-md-6 col-lg-3">
															<div class="panel">
																<div class="ribbon-wrapper">
																	<div class="ribbon-inner">����</div>
																</div>
																<div class="panel-heading">
																	<div class="caption">2014-12-31</div>
																</div>
																<div class="panel-body pan text-center">
																	<div class="the-price"><h1 class="mtn">20<span class="subscript">/��</span></h1>
																		<small>�����ƻ�</small>
																	</div>
																	<table class="table mbn">
																		<tbody>
																		<tr>
																			<td>2����Ʒ</td>
																		</tr>
																		<tr class="active">
																			<td>5����Ŀ</td>
																		</tr>
																		</tbody>
																	</table>
																</div>
																<div class="panel-footer pal">
																	<p class="text-muted text-center">����鿴��ϸ��Ϣ</p>
																	<a class="btn btn-success btn-block" role="button" href="javascript:void(0);">��ϸ</a>
																</div>
															</div>
														</div>
														<div class="col-xs-12 col-md-6 col-lg-3">
															<div class="panel">
																<div class="panel-heading">
																	<div class="caption">2015-01-01</div>
																</div>
																<div class="panel-body pan text-center">
																	<div class="the-price"><h1 class="mtn">35<span class="subscript">/��</span></h1>
																		<small>�����ƻ�</small>
																	</div>
																	<table class="table mbn">
																		<tbody>
																		<tr>
																			<td>������</td>
																		</tr>
																		<tr class="active">
																			<td>ң����</td>
																		</tr>
																		</tbody>
																	</table>
																</div>
																<div class="panel-footer pal">
																	<p class="text-muted text-center">����鿴��ϸ��Ϣ</p>
																	<a class="btn btn-success btn-block" role="button" href="javascript:void(0);">��ϸ</a>
																</div>
															</div>
														</div>
														<div class="col-xs-12 col-md-6 col-lg-3">
															<div class="panel">
																<div class="panel-heading">
																	<div class="caption">2015-01-01</div>
																</div>
																<div class="panel-body pan text-center">
																	<div class="the-price"><h1 class="mtn">99<span class="subscript">/��</span></h1>
																		<small>�����ƻ�</small>
																	</div>
																	<table class="table mbn">
																		<tbody>
																		<tr>
																			<td>������</td>
																		</tr>
																		<tr class="active">
																			<td>������</td>
																		</tr>
																		</tbody>
																	</table>
																</div>
																<div class="panel-footer pal"><p class="text-muted text-center">����鿴��ϸ��Ϣ</p><a class="btn btn-success btn-block" role="button" href="javascript:void(0);">��ϸ</a></div>
															</div>
														</div>
													</div>
												</div>
												<!--p class="mlx plm">ģ�鹦������</p-->

												<div class="row">
													<div class="tabbable-line col-md-12">
														<ul class="row nav nav-tabs responsive mtm">
															<li class="active"><a style="padding-top: 8px" data-toggle="tab" href="#tab-all"><strong><i class="fa fa-calendar"></i>&nbsp;
																ȫ��</strong></a></li>
															<li class=""><a style="padding-top: 8px" data-toggle="tab" href="#tab-draf"><strong><i class="fa fa-calendar"></i>&nbsp;
																�ݸ�</strong></a></li>
															<li class=""><a style="padding-top: 8px" data-toggle="tab" href="#tab-activity"><strong><i class="fa fa-glass"></i>&nbsp;
																ִ����</strong></a></li>
															<li class=""><a style="padding-top: 8px" data-toggle="tab" href="#tab-done"><strong><i class="fa fa-calendar-o"></i>&nbsp;
																���</strong></a></li>
														</ul>
														<div class="tab-content">
															<div class="tab-pane fade active in" id="tab-all">
																<div class="row">
																<div class="col-lg-12">
																	<div class="input-group mtm mbm"><input type="text" class="form-control" placeholder="Enter text...">
				
																		<div class="input-group-btn">
																			<button class="btn btn-info">����</button>
																		</div>
																	</div>
																</div>
																<div class="col-lg-12">
																<table class="table table-hover-color">
																<thead>
																<tr>
																<th>ID</th>
																<th>����</th>
																<th>��Ʒ</th>
																<th>����</th>
																<th>������</th>
																</tr>
																</thead>
																<tbody>
																<tr>
																<td>1</td>
																<td>��ͷ</td>
																<td>23</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>2</td>
																<td>����</td>
																<td>45</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>3</td>
																<td>��β</td>
																<td>30</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>4</td>
																<td>������</td>
																<td>15</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>5</td>
																<td>������</td>
																<td>15</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>6</td>
																<td>������</td>
																<td>15</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																</tbody>
																</table>
																</div>
																</div>
																<div class="row">
																	<ul class="pagination pull-right">
																		<?=$splitPageStr?>
																	</ul>
																</div>
															</div><!-- tab-about end -->
															
															<div class="tab-pane fade" id="tab-draf">
																<table class="table table-hover-color">
																<thead>
																<tr>
																<th>ID</th>
																<th>����</th>
																<th>��Ʒ</th>
																<th>����</th>
																<th>������</th>
																</tr>
																</thead>
																<tbody>
																<tr>
																<td>1</td>
																<td>��ͷ</td>
																<td>23</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>2</td>
																<td>����</td>
																<td>45</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>3</td>
																<td>��β</td>
																<td>30</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>4</td>
																<td>������</td>
																<td>15</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>5</td>
																<td>������</td>
																<td>15</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>6</td>
																<td>������</td>
																<td>15</td>
																<td>XXX</td>
																<td><a href="javascript:confirm('/index/adddemo1');">Delete</a>
																<a  href="/index/adddemo1" onclick="javascript:if(!confirmtest('ȷ��Ҫɾ��ѡ�����Ϣ��\n�˲��������Իָ���')){ return false; }"><font color="green">ɾ��</font></a>
																</td>
																</tr>
																</tbody>
																</table>
															</div><!-- tab-about end -->
															
															<div class="tab-pane fade" id="tab-activity">
																<table class="table table-hover-color">
																<thead>
																<tr>
																<th>ID</th>
																<th>����</th>
																<th>��Ʒ</th>
																<th>����</th>
																<th>������</th>
																</tr>
																</thead>
																<tbody>
																<tr>
																<td>1</td>
																<td>��ͷ</td>
																<td>23</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>2</td>
																<td>����</td>
																<td>45</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>3</td>
																<td>��β</td>
																<td>30</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>4</td>
																<td>������</td>
																<td>15</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>5</td>
																<td>������</td>
																<td>15</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>6</td>
																<td>������</td>
																<td>15</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																</tbody>
																</table>
															</div><!-- tab-activity end -->
															
															<div class="tab-pane fade" id="tab-done">
																<table class="table table-hover-color">
																<thead>
																<tr>
																<th>ID</th>
																<th>����</th>
																<th>��Ʒ</th>
																<th>����</th>
																<th>������</th>
																</tr>
																</thead>
																<tbody>
																<tr>
																<td>1</td>
																<td>��ͷ</td>
																<td>23</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>2</td>
																<td>����</td>
																<td>45</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>3</td>
																<td>��β</td>
																<td>30</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>4</td>
																<td>������</td>
																<td>15</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>5</td>
																<td>������</td>
																<td>15</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																<tr>
																<td>6</td>
																<td>������</td>
																<td>15</td>
																<td>XXX</td>
																<td>XXX</td>
																</tr>
																</tbody>
																</table>
															</div><!-- tab-mail end -->
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="panel">
														<div class="panel-heading">
															<div class="caption">�°�ť�ο�Ч��</div>
														</div>
														<div class="panel-body">
															<div class="viewcode-example">
																<div class="demo-btn">
																	<button class="btn btn-default" type="button">Ĭ��</button>
																	<button class="btn btn-primary" type="button">��Ҫ</button>
																	<button class="btn btn-success" type="button">�ɹ�</button>
																	<button class="btn btn-info" type="button">��Ϣ</button>
																	<button class="btn btn-warning" type="button">����</button>
																	<button class="btn btn-danger" type="button">Σ��</button>
																</div>
															<a class="btn-view-code" href="javascript:;" style="display: none;"><i class="fa fa-code"></i></a></div>
														</div>
													</div>
												</div><!--button css-->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end panel -->
					</div>
				</div>
				
			</div>
		</div>
		<!--end content-->
	</div>
	<!-- end box-content -->
</div>
</div>

<script src="/js/jquery-1.10.2.min.js" ></script>
<script src="/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/js/candor.blockui.js"></script>
<script src="/js/jquery.nicescroll.js"></script>
<script src="/js/jquery-ui.js"></script>
<script src="/js/bootstrap.min.js" ></script>
<script src="/js/bootstrap-hover-dropdown.js"></script>
<script src="/js/mtek_html5shiv.js"></script>
<script src="/js/respond.min.js"></script>
<script src="/js/jquery.metisMenu.js"></script>
<script src="/js/mtek_icheck.min.js"></script>
<script src="/js/mtek_custom.min.js"></script>
<script src="/js/jquery.slimscroll.js"></script>
<script src="/js/bootstrap-switch.min.js"></script>
<script src="/js/prettify.js"></script>
<script src="/js/jquery.cookie.js"></script>
<script src="/js/jquery.pulsate.js"></script>

<!--LOADING SCRIPTS FOR PAGE-->


<!--LOADING SCRIPTS FOR PAGE--><!--CORE JAVASCRIPT-->
<script src="/js/mtek_core.js"></script>
<script src="/js/mtek_system-layout.js"></script>
<script src="/js/jquery-responsive.js"></script>
<script src="/js/candor.portal.js"></script>
<script src="/js/candor.common.js"></script>
</body>
</html>
<script>jQuery(document).ready(function () {
    "use strict";
    JQueryResponsive.init();
    Layout.init();
});
</script>
<script>
jQuery(document).ready(function () {
    //ui_toastr.init();
});

function Add() {
	var url="/index/adddemo.candor";
    art.dialog.open(url, {
        title: '�����ƻ�',
        width: '80%',
        height: '80%',
        lock: 'true',
        esc: 'false',
        id: 'editiframe',
        window: top,
    	ok:function(){ 
    		//���ø�����Ԫ��
    		var iframe = this.iframe.contentWindow;
            var sbutton = iframe.document.getElementById('opform');            
    		if (!iframe.document.body) {
                    alert('ҳ�滹û���������');
                    return false;
                };
            sbutton.submit();
            return false;   
    	},
    	cancel:true
    });
}
</script>