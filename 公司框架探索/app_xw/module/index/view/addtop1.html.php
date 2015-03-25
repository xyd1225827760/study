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
body{
    background:#ebf0f3 ;}
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
			<li><a href="/index/demo">�ƻ�����</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
			<li class="active">�����ƻ�����</li>
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
						<div class="panel">
							<div class="panel-body">
								<div class="row">
									<div class="col-xs-12">
										<ul class="list-group mail-action list-unstyled list-inline mbm">
											<li><h3 class="mbs mtm" style="color: #222">�����ռƻ�</h3></li>
											<li class="pull-right">
											<div class="demo-btn">
                                                <button class="btn btn-default" type="button">ȡ��</button>
                                                <button class="btn btn-success" type="button">����</button>
                                                <button class="btn btn-info" type="button">�༭</button>
                                            </div>
											</li>
										</ul>

										<!--p class="mlx plm">ģ�鹦������</p-->												
										<div class="row">
													<form>
													<div class="col-md-4">
														<div class="form-group"><label class="control-label" for="title">����</label>
														<input type="text" class="form-control input-medium" placeholder="������ƻ�����" id="title">
														</div>
														<div class="form-group"><label class="control-label" for="title">��Ʒ����</label>
														<input type="text" class="form-control input-medium" placeholder="�������Ʒ����" id="title"></div>
														<div class="form-group"><label class="control-label" for="title">������·</label>
														<input type="text" class="form-control input-medium" placeholder="������·" id="title"></div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label" for="showEasing">��ʼʱ��</label>
															<input type="text" class="form-control input-medium" value="" placeholder="��ʼʱ��" id="showEasing">
														</div>
														<div class="form-group">
															<label class="control-label" for="hideEasing">��Ʒ����</label>
															<input type="text" class="form-control input-medium" value="" placeholder="��Ʒ����" id="hideEasing">
														</div>
														<div class="form-group">
															<label class="control-label" for="showMethod">�ƻ�������</label>
															<input type="text" class="form-control input-medium" value="slideDown" placeholder="�ƻ�������" id="showMethod">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label" for="showEasing">����ʱ��</label>
															<input type="text" class="form-control input-medium" value="" placeholder="����ʱ��" id="showEasing">
														</div>
														<div class="form-group">
															<label class="control-label" for="hideEasing">�����嵥</label>
															<input type="text" class="form-control input-medium" value="" placeholder="�����嵥" id="hideEasing">
														</div>
														<div class="form-group">
															<label class="control-label">�ƻ�״̬</label>
															<div class="radio">
																<label>
																<input id="optionsRadios4" name="optionsRadiosInline" value="option1" checked="checked" class="form-control-shadow" type="radio">&nbsp; �ݸ�
																</label>
																<label>
																<input id="optionsRadios5" name="optionsRadiosInline" value="option2" type="radio">&nbsp; ִ��
																</label>
															</div>
														</div>
													</div>
													<div class="col-md-11">
														<div class="form-group"><label class="control-label" for="message">˵��</label><textarea class="form-control" placeholder="����д˵����Ϣ ..." rows="3" id="message"></textarea></div>
													</div>
													</form>
												</div>

										<div class="row">
											<div class="tabbable-line col-md-12">
												<ul class="row nav nav-tabs responsive mtm">
													<li class="active"><a style="padding-top: 8px" data-toggle="tab" href="#tab-about"><strong><i class="fa fa-calendar"></i>&nbsp;
														Ͷ��</strong></a></li>
													<li class=""><a style="padding-top: 8px" data-toggle="tab" href="#tab-activity"><strong><i class="fa fa-glass"></i>&nbsp;
														���չ���</strong></a></li>
													<li class=""><a style="padding-top: 8px" data-toggle="tab" href="#tab-mail"><strong><i class="fa fa-calendar-o"></i>&nbsp;
														����</strong></a></li>
												</ul>
												<div class="tab-content">
													<div class="tab-pane fade active in" id="tab-about">
														<table class="table table-hover-color">
														<thead>
														<tr>
														<th>ID</th>
														<th>��������</th>
														<th>����</th>
														<th>״̬</th>
														</tr>
														</thead>
														<tbody>
														<tr>
														<td>1</td>
														<td>��ͷ</td>
														<td>23</td>
														<td><span class="label label-sm label-success">����</span></td>
														</tr>
														<tr>
														<td>2</td>
														<td>����</td>
														<td>45</td>
														<td><span class="label label-sm label-info">�ȴ�����</span></td>
														</tr>
														<tr>
														<td>3</td>
														<td>��β</td>
														<td>30</td>
														<td><span class="label label-sm label-warning">�Ѿ�����</span></td>
														</tr>
														<tr>
														<td>4</td>
														<td>������</td>
														<td>15</td>
														<td><span class="label label-sm label-danger">ȱ��</span></td>
														</tr>
														</tbody>
														</table>
													</div><!-- tab-about end -->
													
													<div class="tab-pane fade" id="tab-activity">
														<table class="table table-hover-color">
														<thead>
														<tr>
														<th>ID</th>
														<th>��������</th>
														<th>ִ�й���վ</th>
														<th>����</th>
														</tr>
														</thead>
														<tbody>
														<tr>
														<td>1</td>
														<td>��ͷ����</td>
														<td>5�Ź���վ</td>
														<td>���</td>
														</tr>
														<tr>
														<td>2</td>
														<td>����װ</td>
														<td>4�Ź���վ</td>
														<td>��װ</td>
														</tr>
														<tr>
														<td>3</td>
														<td>��β����</td>
														<td>3�Ź���վ</td>
														<td>����</td>
														</tr>
														<tr>
														<td>4</td>
														<td>��������װ</td>
														<td>1�Ź���վ</td>
														<td>��װ</td>
														</tr>
														</tbody>
														</table>
													</div><!-- tab-activity end -->
													
													<div class="tab-pane fade" id="tab-mail">
														<table class="table table-hover-color">
														<thead>
														<tr>
														<th>ID</th>
														<th>��������</th>
														<th>����</th>
														<th>״̬</th>
														</tr>
														</thead>
														<tbody>
														<tr>
														<td>1</td>
														<td>��ͷ</td>
														<td>23</td>
														<td><span class="label label-sm label-success">����</span></td>
														</tr>
														<tr>
														<td>2</td>
														<td>����</td>
														<td>45</td>
														<td><span class="label label-sm label-info">�ȴ�����</span></td>
														</tr>
														<tr>
														<td>3</td>
														<td>��β</td>
														<td>30</td>
														<td><span class="label label-sm label-warning">�Ѿ�����</span></td>
														</tr>
														<tr>
														<td>4</td>
														<td>������</td>
														<td>15</td>
														<td><span class="label label-sm label-danger">ȱ��</span></td>
														</tr>
														</tbody>
														</table>
													</div><!-- tab-mail end -->
												</div>
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal fade" aria-hidden="true" aria-labelledby="modal-default-label" role="dialog" tabindex="-1" id="modal-default">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-primary">
								<button class="close" aria-hidden="true" data-dismiss="modal" type="button">��</button>
								<h4 class="modal-title text-center" id="modal-default-label">Edit
									Profile</h4></div>
							<div class="modal-body">
								<div class="st-title">Modal title goes here</div>
								<p class="st-description">Your form component goes here</p></div>
							<div class="modal-footer">
								<button class="btn btn-default" data-dismiss="modal" type="button">Close
								</button>
								<button class="btn btn-primary" type="button">Save changes</button>
							</div>
						</div>
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
<script src="/js/candor.portal.js" ></script>
</body>
</html>
<script>jQuery(document).ready(function () {
    "use strict";
    JQueryResponsive.init();
    Layout.init();
});
</script>
