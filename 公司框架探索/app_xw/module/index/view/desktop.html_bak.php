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
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/mtek_font-awesome.min.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/mtek_font-awesome.min.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/bootstrap.min.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/mtek_core.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/mtek_system.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/mtek_system-responsive.css';?>' type='text/css' media='screen' />

<style>
body{overflow:visible;color: #000;
    font-family: 'Arial';
    padding: 0px !important;
    margin: 0px !important;
    font-size:13px;
    /*overflow-x: hidden ;*/
    background:#ebf0f3 ;}

</style>
<body>
<div class="page-wrapper">

<div class="page-content">
	<!-- begin page header-->
	<div class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Profile</div>
		</div>
		<ol class="breadcrumb page-breadcrumb hidden-xs">
			<li><i class="fa fa-home"></i>&nbsp;<a href="index.html">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
			<li><a href="#">User</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
			<li class="active">Profile</li>
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
									<div class="profile-left-side col-md-3">
										<div class="user-img text-center"><img class="img-circle" src="/images/app_icons/person_info.png"></div>
										<!--div class="social-icon-group">
											<ul class="social-icons list-unstyled list-inline text-center mbl mtl">
												<li><a class="facebook" data-original-title="facebook" data-hover="tooltip" href="#"><i class="fa fa-facebook"></i></a></li>
												<li><a class="googleplus" data-original-title="google Plus" data-hover="tooltip" href="#"><i class="fa fa-google-plus"></i></a></li>
												<li><a class="twitter" data-original-title="twitter" data-hover="tooltip" href="#"><i class="fa fa-twitter"></i></a></li>
											</ul>
										</div-->
										<div class="text-center"><br /><br /><a class="btn btn-default" href="#"><i class="fa fa-envelope"></i>&nbsp;新建计划</a></div>
										<div class="row">
											
											<dl class="recent-post-list col-sm-6 col-md-12 mtl">
												<dt>
												<p class="title-line">计划管理<span class="text-muted">(5 mins ago)</span>
												</p></dt>
												<dd class="mtm"><a class="post-title" href="#"><img class="mrs" src=""><span>日计划</span></a>
												</dd>
												<dd class="mtm"><a class="post-title" href="#"><img class="mrs" src=""><span>周计划</span></a>
												</dd>
												<dd class="mtm"><a class="post-title" href="#"><img class="mrs" src=""><span>计划执行</span></a>
												</dd>
												</dd>
											</dl>
										</div>
									</div>
									<div class="profile-right-side col-md-9">
										<div class="row">
											<div class="col-xs-12"><h3 class="mbs mlx plm" style="color: #222">日计划管理</h3>

												<p class="mlx plm">&nbsp;</p>

												<div class="row">
													<div class="tabbable-line col-md-12">
														<ul class="row nav nav-tabs responsive mtxl">
															<li class=""><a style="padding-top: 8px" data-toggle="tab" href="#tab-about"><strong><i class="fa fa-info"></i>&nbsp;
																About</strong></a></li>
															<li class=""><a style="padding-top: 8px" data-toggle="tab" href="#tab-activity"><strong><i class="fa fa-bolt"></i>&nbsp;
																Activity</strong></a></li>
															<li class="active"><a style="padding-top: 8px" data-toggle="tab" href="#tab-mail"><strong><i class="fa fa-envelope-o"></i>&nbsp;
																Messages</strong></a></li>
														</ul>
														<div class="tab-content">
															<div class="tab-pane fade" id="tab-about">
																<div class="row">
																	<div class="col-lg-6">
																		<div class="article article-danger">
																			<div class="article-head"><h4 class="article-title">
																				Basic Information</h4></div>
																			<div class="article-body">
																				<div class="st-section">
																					<table>
																						<tbody>
																						<tr>
																							<td class="tr-head">
																								Gender
																							</td>
																							<td>Male</td>
																						</tr>
																						<tr>
																							<td class="tr-head">
																								Email
																							</td>
																							<td>
																								user@example.com
																							</td>
																						</tr>
																						<tr>
																							<td class="tr-head">
																								Address
																							</td>
																							<td>Street 123,
																								Avenue 45,
																								Country
																							</td>
																						</tr>
																						<tr>
																							<td class="tr-head">
																								Status
																							</td>
																							<td><span class="label label-success">Active</span>
																							</td>
																						</tr>
																						<tr>
																							<td class="tr-head">
																								Rating
																							</td>
																							<td>
																								<i class="fa fa-star text-warning fa-fw"></i><i class="fa fa-star text-warning fa-fw"></i><i class="fa fa-star text-warning fa-fw"></i><i class="fa fa-star text-warning fa-fw"></i><i class="fa fa-star fa-fw"></i>
																							</td>
																						</tr>
																						<tr>
																							<td class="tr-head">
																								Join
																							</td>
																							<td>Jun 03,
																								2014
																							</td>
																						</tr>
																						</tbody>
																					</table>
																				</div>
																			</div>
																			<div class="article-footer"><a data-toggle="modal" data-target="#modal-default" type="button" href="#">Edit</a>
																			</div>
																		</div>
																		<div class="article article-info">
																			<div class="article-head"><h4 class="article-title">
																				Education</h4></div>
																			<div class="article-body">
																				<div class="st-section"><h5 class="st-title">The
																					University of
																					Melbourne</h5>

																					<p class="st-description">
																						2012 - 2014</p>

																					<p class="st-description">
																						Oldest Victorian
																						university
																						(established 1855)
																						offering a vast
																						range of
																						coursework</p></div>
																				<div class="st-section"><h5 class="st-title">The
																					University of
																					Sydney</h5>

																					<p class="st-description">
																						2014</p>

																					<p class="st-description">
																						Australia's leading
																						higher education and
																						research
																						University.</p>
																				</div>
																			</div>
																			<div class="article-footer"><a data-toggle="modal" data-target="#modal-default" type="button" href="#">Edit</a>
																			</div>
																		</div>
																		<div class="article article-danger">
																			<div class="article-head"><h4 class="article-title">
																				Contact Information</h4>
																			</div>
																			<div class="article-body">
																				<div class="st-section"><h5 class="ci-title st-title">
																					Home</h5>

																					<p class="st-description">
																					</p><table>
																						<tbody>
																						<tr>
																							<td class="tr-head">
																								Phone
																							</td>
																							<td>
																								08-1234-567
																							</td>
																						</tr>
																						<tr>
																							<td class="tr-head">
																								Fax
																							</td>
																							<td>021-56789
																							</td>
																						</tr>
																						<tr>
																							<td class="tr-head">
																								Website
																							</td>
																							<td><a href="#">http://www.yoursite.com</a>
																							</td>
																						</tr>
																						<tr>
																							<td class="tr-head">
																								Blog
																							</td>
																							<td><a href="#">http://www.yourblog.com</a>
																							</td>
																						</tr>
																						</tbody>
																					</table>
																					<p></p></div>
																				<div class="st-section"><h5 class="ci-title st-title">
																					Work</h5>

																					<p class="st-description">
																					</p><table>
																						<tbody>
																						<tr>
																							<td class="tr-head">
																								Phone
																							</td>
																							<td>
																								08-1234-567
																							</td>
																						</tr>
																						<tr>
																							<td class="tr-head">
																								Fax
																							</td>
																							<td>021-56789
																							</td>
																						</tr>
																						<tr>
																							<td class="tr-head">
																								Website
																							</td>
																							<td><a href="#">http://www.yoursite.com</a>
																							</td>
																						</tr>
																						<tr>
																							<td class="tr-head">
																								Blog
																							</td>
																							<td><a href="#">http://www.yourblog.com</a>
																							</td>
																						</tr>
																						</tbody>
																					</table>
																					<p></p></div>
																			</div>
																			<div class="article-footer"><a data-toggle="modal" data-target="#modal-default" type="button" href="#">Edit</a>
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-6">
																		<div class="article article-success">
																			<div class="article-head"><h4 class="article-title">
																				Work</h4></div>
																			<div class="article-body">
																				<div class="st-section"><h5 class="st-title">
																					Occupation</h5>

																					<p class="st-description">
																						What do you do?</p>
																				</div>
																				<div class="st-section"><h5 class="st-title">
																					Skills</h5>

																					<p class="st-description">
																						What are your best
																						skils?</p></div>
																				<div class="st-section"><h5 class="st-title">
																					Employment</h5>

																					<p class="st-description">
																						Where have you
																						worked?</p></div>
																			</div>
																			<div class="article-footer"><a data-toggle="modal" data-target="#modal-default" type="button" href="#">Edit</a>
																			</div>
																		</div>
																		<div class="article">
																			<div class="article-head"><h4 class="article-title">
																				Places</h4></div>
																			<div class="article-body">
																				<div class="st-section">
																					<iframe width="100%" height="350" frameborder="0" src="http://www.xw.com" style="border:0"></iframe>
																				</div>
																			</div>
																			<div class="article-footer"><a data-toggle="modal" data-target="#modal-default" type="button" href="#">Edit</a>
																			</div>
																		</div>
																		<div class="article article-warning">
																			<div class="article-head"><h4 class="article-title">
																				Link Connection</h4></div>
																			<div class="article-body">
																				<div class="st-section"><img class="pull-left mrm" src="http://next-themes.com/mtek/code/assets/images/icon-html5.png"><a class="lc-link" href="#">HTML5
																					Community</a>
																					<button class="btn btn-default pull-right mts">
																						View
																					</button>
																				</div>
																				<div class="st-section"><img class="pull-left mrm" src="http://next-themes.com/mtek/code/assets/images/icon-css3.png"><a class="lc-link" href="#">Bootstrap
																					framework</a>
																					<button class="btn btn-default pull-right mts">
																						View
																					</button>
																				</div>
																				<div class="st-section"><img class="pull-left mrm" src="http://next-themes.com/mtek/code/assets/images/icon-angular.png"><a class="lc-link" href="#">Superheroic
																					Javascript framework</a>
																					<button class="btn btn-default pull-right mts">
																						View
																					</button>
																				</div>
																			</div>
																			<div class="article-footer"><a data-toggle="modal" data-target="#modal-default" type="button" href="#">Edit</a>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="tab-pane fade" id="tab-activity">
																<ul class="list-activity list-unstyled">
																	<li class="post-list clearfix">
																		<div class="avatar"><img class="img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/mlane/48.jpg"></div>
																		<div class="post-body">
																			<div class="desc"><strong class="post-user mrs">Diane
																				Harris</strong>
																				<small class="text-muted">
																					posted a new note
																				</small>
																				&nbsp; - &nbsp;
																				<small class="text-muted">1
																					days ago at 6:18am
																				</small>
																			</div>
																			<div class="post-content"><a class="post-title" href="#"><img class="mrs" src="http://next-themes.com/mtek/code/assets/images/icon-html5.png"><strong>HTML5
																				Weekly: A Free, Weekly Email
																				Newsletter</strong></a>

																				<div class="summary mts cleafix">
																					<div class="img-wrapper">
																						<img class="mrs" src="http://next-themes.com/mtek/code/assets/images/06.jpg">
																					</div>
																					<p>Lorem ipsum dolor sit
																						amet, consectetur
																						adipisicing. Lorem
																						ipsum dolor
																						sit amet,consectetur
																						adipisicing elit.
																						Laudantium, quo.
																						Lorem
																						it amet,consectetur
																						adipisicing elit.
																						Laudantium, quo.
																						Lorem</p></div>
																				<div class="clearfix"></div>
																			</div>
																			<div class="action-post mtl"><a href="#"><i class="fa fa-heart-o mrx"></i>Like</a>&nbsp;
																				- &nbsp;<a href="#"><i class="fa fa-comments-o mrx"></i>Comments</a>&nbsp;
																				- &nbsp;<a href="#"><i class="fa fa-share-square-o mrx"></i>Share</a>
																			</div>
																		</div>
																	</li>
																	<li class="post-list clearfix">
																		<div class="avatar"><img class="img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/adellecharles/48.jpg"></div>
																		<div class="post-body">
																			<div class="desc"><strong class="post-user mrs">Ava
																				Martin</strong>
																				<small class="text-muted">
																					posted a new note
																				</small>
																				&nbsp; - &nbsp;
																				<small class="text-muted">1
																					days ago at 6:18am
																				</small>
																			</div>
																			<div class="post-content"><a class="post-title" href="#"><img class="mrs" src="http://next-themes.com/mtek/code/assets/images/icon-angular.png"><strong>AngularJS
																				Stories for Web
																				Architects</strong></a>

																				<div class="summary mts cleafix">
																					<div class="img-wrapper">
																						<img class="mrs" src="http://next-themes.com/mtek/code/assets/images/02-sm.jpg">
																					</div>
																					<p>Lorem ipsum dolor sit
																						amet, consectetur
																						adipisicing. Lorem
																						ipsum dolor
																						sit amet,consectetur
																						adipisicing elit.
																						Laudantium, quo.
																						Lorem
																						it amet,consectetur
																						adipisicing elit.
																						Laudantium, quo.
																						Lorem</p></div>
																				<div class="clearfix"></div>
																			</div>
																			<div class="action-post mtl"><a href="#"><i class="fa fa-heart-o mrx"></i>Like</a>&nbsp;
																				- &nbsp;<a href="#"><i class="fa fa-comments-o mrx"></i>Comments</a>&nbsp;
																				- &nbsp;<a href="#"><i class="fa fa-share-square-o mrx"></i>Share</a>
																			</div>
																		</div>
																	</li>
																	<li class="post-list clearfix">
																		<div class="avatar"><img class="img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/kurafire/48.jpg"></div>
																		<div class="post-body">
																			<div class="desc"><strong class="post-user mrs">Charlotte
																				Robinson</strong>
																				<small class="text-muted">
																					upload new photos
																				</small>
																				&nbsp; - &nbsp;
																				<small class="text-muted">1
																					week ago at 9:18am
																				</small>
																			</div>
																			<div class="post-content">
																				<div class="img-upload-wrap">
																					<img class="img-responsive mts" src="http://next-themes.com/mtek/code/assets/images/04-sm.jpg"><img class="img-responsive mts" src="http://next-themes.com/mtek/code/assets/images/05-sm.jpg"><img class="img-responsive mts" src="http://next-themes.com/mtek/code/assets/images/07-sm.jpg"><img class="img-responsive mts" src="http://next-themes.com/mtek/code/assets/images/09-sm.jpg">
																				</div>
																			</div>
																		</div>
																	</li>
																	<li class="post-list clearfix">
																		<div class="avatar"><img class="img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/chadengle/48.jpg"></div>
																		<div class="post-body">
																			<div class="desc"><strong class="post-user mrs">Sophia
																				Lee</strong>
																				<small class="text-muted">
																					upload new photos
																				</small>
																				&nbsp; - &nbsp;
																				<small class="text-muted">1
																					week ago at 9:18am
																				</small>
																			</div>
																			<div class="post-content">
																				<div class="row">
																					<div class="col-md-6">
																						<span class="task-item">Admin Template<small class="pull-right text-muted">
																							80%
																						</small></span>

																						<div class="progress">
																							<div class="progress-bar progress-bar-orange" style="width: 80%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="80" role="progressbar">
																								<span class="sr-only">80% Complete (success)</span>
																							</div>
																						</div>
																						<span class="task-item">Wordpress Themes<small class="pull-right text-muted">
																							40%
																						</small></span>

																						<div class="progress">
																							<div class="progress-bar progress-bar-success" style="width: 40%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar">
																								<span class="sr-only">40% Complete (success)</span>
																							</div>
																						</div>
																						<span class="task-item">Landing Page<small class="pull-right text-muted">
																							67%
																						</small></span>

																						<div class="progress">
																							<div class="progress-bar progress-bar-warning" style="width: 67%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="67" role="progressbar">
																								<span class="sr-only">67% Complete (success)</span>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</li>
																	<li class="post-list clearfix">
																		<div class="avatar"><img class="img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/oliveirasimoes/48.jpg"></div>
																		<div class="post-body">
																			<div class="desc"><strong class="post-user mrs">Diane
																				Harris</strong>
																				<small class="text-muted">
																					posted a new note
																				</small>
																				&nbsp; - &nbsp;
																				<small class="text-muted">1
																					days ago at 6:18am
																				</small>
																			</div>
																			<div class="post-content"><a class="post-title" href="#"><img class="mrs" src="http://next-themes.com/mtek/code/assets/images/icon-html5.png"><strong>HTML5
																				Weekly: A Free, Weekly Email
																				Newsletter</strong></a>

																				<div class="summary mts cleafix">
																					<div class="img-wrapper">
																						<img class="mrs" src="http://next-themes.com/mtek/code/assets/images/04-sm.jpg">
																					</div>
																					<p>Lorem ipsum dolor sit
																						amet, consectetur
																						adipisicing. Lorem
																						ipsum dolor
																						sit amet,consectetur
																						adipisicing elit.
																						Laudantium, quo.
																						Lorem
																						it amet,consectetur
																						adipisicing elit.
																						Laudantium, quo.
																						Lorem</p></div>
																				<div class="clearfix"></div>
																			</div>
																			<div class="action-post mtl"><a href="#"><i class="fa fa-heart-o mrx"></i>Like</a>&nbsp;
																				- &nbsp;<a href="#"><i class="fa fa-comments-o mrx"></i>Comments</a>&nbsp;
																				- &nbsp;<a href="#"><i class="fa fa-share-square-o mrx"></i>Share</a>
																			</div>
																		</div>
																	</li>
																	<li class="post-list clearfix">
																		<div class="avatar"><img class="img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/claudioguglieri/48.jpg"></div>
																		<div class="post-body">
																			<div class="desc"><strong class="post-user mrs">Diane
																				Harris</strong>
																				<small class="text-muted">
																					posted a new note
																				</small>
																				&nbsp; - &nbsp;
																				<small class="text-muted">1
																					days ago at 6:18am
																				</small>
																			</div>
																			<div class="post-content"><a class="post-title" href="#"><img class="mrs" src="http://next-themes.com/mtek/code/assets/images/icon-html5.png"><strong>HTML5
																				Weekly: A Free, Weekly Email
																				Newsletter</strong></a>

																				<div class="summary mts cleafix">
																					<div class="img-wrapper">
																						<img class="mrs" src="http://next-themes.com/mtek/code/assets/images/05-sm.jpg">
																					</div>
																					<p>Lorem ipsum dolor sit
																						amet, consectetur
																						adipisicing. Lorem
																						ipsum dolor
																						sit amet,consectetur
																						adipisicing elit.
																						Laudantium, quo.
																						Lorem
																						it amet,consectetur
																						adipisicing elit.
																						Laudantium, quo.
																						Lorem</p></div>
																				<div class="clearfix"></div>
																			</div>
																			<div class="action-post mtl"><a href="#"><i class="fa fa-heart-o mrx"></i>Like</a>&nbsp;
																				- &nbsp;<a href="#"><i class="fa fa-comments-o mrx"></i>Comments</a>&nbsp;
																				- &nbsp;<a href="#"><i class="fa fa-share-square-o mrx"></i>Share</a>
																			</div>
																		</div>
																	</li>
																</ul>
															</div>
															<div class="tab-pane fade active in" id="tab-mail">
																<div class="mail-action-group form-inline mtl mbl">
																	<div class="row">
																		<div class="col-lg-6"><a class="btn btn-danger mrm" role="button" href="#"><i class="fa fa-send-o mrs"></i>COMPOSE</a><a class="btn btn-default" role="button" href="#"><i class="fa fa-trash-o mrs"></i>Trash</a>
																		</div>
																		<div class="col-lg-6">
																			<div class="input-group pull-right">
																				<input type="text" class="form-control input-inline"><a class="input-group-addon" href="#">Search</a>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="list-group mail-box"><a class="list-group-item">
																	<div class="row">
																		<div class="col-lg-4"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><span class="fa fa-star-o mrm mlm"></span><span class="mail-from">Bhaumik Patel</span>
																		</div>
																		<div class="col-lg-8"><i class="mail-title">Sed ut
																			perspiciatis unde</i>&nbsp; -
																			&nbsp;<span class="text-muted" style="font-size: 11px;">Lorem ipsum dolor sit amet...</span><span class="pull-right">12:10 AM</span><span class="pull-right mrl"><span class="glyphicon glyphicon-paperclip"></span></span>
																		</div>
																	</div>
																</a><a class="list-group-item">
																	<div class="row">
																		<div class="col-lg-4"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><span class="fa fa-star-o mrm mlm"></span><span class="mail-from">Bhaumik Patel</span>
																		</div>
																		<div class="col-lg-8"><i class="mail-title">Sed ut
																			perspiciatis unde</i>&nbsp; -
																			&nbsp;<span class="text-muted" style="font-size: 11px;">Lorem ipsum dolor sit amet...</span><span class="pull-right">12:10 AM</span><span class="pull-right mrl"><span class="glyphicon glyphicon-paperclip"></span></span>
																		</div>
																	</div>
																</a><a class="list-group-item">
																	<div class="row">
																		<div class="col-lg-4"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><span class="fa fa-star-o mrm mlm"></span><span class="mail-from">Bhaumik Patel</span>
																		</div>
																		<div class="col-lg-8"><i class="mail-title">Sed ut
																			perspiciatis unde</i>&nbsp; -
																			&nbsp;<span class="text-muted" style="font-size: 11px;">Lorem ipsum dolor sit amet...</span><span class="pull-right">12:10 AM</span><span class="pull-right mrl"><span class="glyphicon glyphicon-paperclip"></span></span>
																		</div>
																	</div>
																</a><a class="list-group-item">
																	<div class="row">
																		<div class="col-lg-4"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><span class="fa fa-star-o mrm mlm"></span><span class="mail-from">Bhaumik Patel</span>
																		</div>
																		<div class="col-lg-8"><i class="mail-title">Sed ut
																			perspiciatis unde</i>&nbsp; -
																			&nbsp;<span class="text-muted" style="font-size: 11px;">Lorem ipsum dolor sit amet...</span><span class="pull-right">12:10 AM</span><span class="pull-right mrl"><span class="glyphicon glyphicon-paperclip"></span></span>
																		</div>
																	</div>
																</a><a class="list-group-item">
																	<div class="row">
																		<div class="col-lg-4"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><span class="fa fa-star-o mrm mlm"></span><span class="mail-from">Bhaumik Patel</span>
																		</div>
																		<div class="col-lg-8"><i class="mail-title">Sed ut
																			perspiciatis unde</i>&nbsp; -
																			&nbsp;<span class="text-muted" style="font-size: 11px;">Lorem ipsum dolor sit amet...</span><span class="pull-right">12:10 AM</span><span class="pull-right mrl"><span class="glyphicon glyphicon-paperclip"></span></span>
																		</div>
																	</div>
																</a><a class="list-group-item">
																	<div class="row">
																		<div class="col-lg-4"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><span class="fa fa-star-o mrm mlm"></span><span class="mail-from">Bhaumik Patel</span>
																		</div>
																		<div class="col-lg-8"><i class="mail-title">Sed ut
																			perspiciatis unde</i>&nbsp; -
																			&nbsp;<span class="text-muted" style="font-size: 11px;">Lorem ipsum dolor sit amet...</span><span class="pull-right">12:10 AM</span><span class="pull-right mrl"><span class="glyphicon glyphicon-paperclip"></span></span>
																		</div>
																	</div>
																</a><a class="list-group-item">
																	<div class="row">
																		<div class="col-lg-4"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><span class="fa fa-star-o mrm mlm"></span><span class="mail-from">Bhaumik Patel</span>
																		</div>
																		<div class="col-lg-8"><i class="mail-title">Sed ut
																			perspiciatis unde</i>&nbsp; -
																			&nbsp;<span class="text-muted" style="font-size: 11px;">Lorem ipsum dolor sit amet...</span><span class="pull-right">12:10 AM</span><span class="pull-right mrl"><span class="glyphicon glyphicon-paperclip"></span></span>
																		</div>
																	</div>
																</a><a class="list-group-item">
																	<div class="row">
																		<div class="col-lg-4"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><span class="fa fa-star-o mrm mlm"></span><span class="mail-from">Bhaumik Patel</span>
																		</div>
																		<div class="col-lg-8"><i class="mail-title">Sed ut
																			perspiciatis unde</i>&nbsp; -
																			&nbsp;<span class="text-muted" style="font-size: 11px;">Lorem ipsum dolor sit amet...</span><span class="pull-right">12:10 AM</span><span class="pull-right mrl"><span class="glyphicon glyphicon-paperclip"></span></span>
																		</div>
																	</div>
																</a><a class="list-group-item">
																	<div class="row">
																		<div class="col-lg-4"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><span class="fa fa-star-o mrm mlm"></span><span class="mail-from">Bhaumik Patel</span>
																		</div>
																		<div class="col-lg-8"><i class="mail-title">Sed ut
																			perspiciatis unde</i>&nbsp; -
																			&nbsp;<span class="text-muted" style="font-size: 11px;">Lorem ipsum dolor sit amet...</span><span class="pull-right">12:10 AM</span><span class="pull-right mrl"><span class="glyphicon glyphicon-paperclip"></span></span>
																		</div>
																	</div>
																</a><a class="list-group-item">
																	<div class="row">
																		<div class="col-lg-4"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><span class="fa fa-star-o mrm mlm"></span><span class="mail-from">Bhaumik Patel</span>
																		</div>
																		<div class="col-lg-8"><i class="mail-title">Sed ut
																			perspiciatis unde</i>&nbsp; -
																			&nbsp;<span class="text-muted" style="font-size: 11px;">Lorem ipsum dolor sit amet...</span><span class="pull-right">12:10 AM</span><span class="pull-right mrl"><span class="glyphicon glyphicon-paperclip"></span></span>
																		</div>
																	</div>
																</a><a class="list-group-item">
																	<div class="row">
																		<div class="col-lg-4"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><span class="fa fa-star-o mrm mlm"></span><span class="mail-from">Bhaumik Patel</span>
																		</div>
																		<div class="col-lg-8"><i class="mail-title">Sed ut
																			perspiciatis unde</i>&nbsp; -
																			&nbsp;<span class="text-muted" style="font-size: 11px;">Lorem ipsum dolor sit amet...</span><span class="pull-right">12:10 AM</span><span class="pull-right mrl"><span class="glyphicon glyphicon-paperclip"></span></span>
																		</div>
																	</div>
																</a><a class="list-group-item">
																	<div class="row">
																		<div class="col-lg-4"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><span class="fa fa-star-o mrm mlm"></span><span class="mail-from">Bhaumik Patel</span>
																		</div>
																		<div class="col-lg-8"><i class="mail-title">Sed ut
																			perspiciatis unde</i>&nbsp; -
																			&nbsp;<span class="text-muted" style="font-size: 11px;">Lorem ipsum dolor sit amet...</span><span class="pull-right">12:10 AM</span><span class="pull-right mrl"><span class="glyphicon glyphicon-paperclip"></span></span>
																		</div>
																	</div>
																</a><a class="list-group-item">
																	<div class="row">
																		<div class="col-lg-4"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><span class="fa fa-star-o mrm mlm"></span><span class="mail-from">Bhaumik Patel</span>
																		</div>
																		<div class="col-lg-8"><i class="mail-title">Sed ut
																			perspiciatis unde</i>&nbsp; -
																			&nbsp;<span class="text-muted" style="font-size: 11px;">Lorem ipsum dolor sit amet...</span><span class="pull-right">12:10 AM</span><span class="pull-right mrl"><span class="glyphicon glyphicon-paperclip"></span></span>
																		</div>
																	</div>
																</a><a class="list-group-item">
																	<div class="row">
																		<div class="col-lg-4"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><span class="fa fa-star-o mrm mlm"></span><span class="mail-from">Bhaumik Patel</span>
																		</div>
																		<div class="col-lg-8"><i class="mail-title">Sed ut
																			perspiciatis unde</i>&nbsp; -
																			&nbsp;<span class="text-muted" style="font-size: 11px;">Lorem ipsum dolor sit amet...</span><span class="pull-right">12:10 AM</span><span class="pull-right mrl"><span class="glyphicon glyphicon-paperclip"></span></span>
																		</div>
																	</div>
																</a><a class="list-group-item">
																	<div class="row">
																		<div class="col-lg-4"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><span class="fa fa-star-o mrm mlm"></span><span class="mail-from">Bhaumik Patel</span>
																		</div>
																		<div class="col-lg-8"><i class="mail-title">Sed ut
																			perspiciatis unde</i>&nbsp; -
																			&nbsp;<span class="text-muted" style="font-size: 11px;">Lorem ipsum dolor sit amet...</span><span class="pull-right">12:10 AM</span><span class="pull-right mrl"><span class="glyphicon glyphicon-paperclip"></span></span>
																		</div>
																	</div>
																</a><a class="list-group-item">
																	<div class="row">
																		<div class="col-lg-4"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><span class="fa fa-star-o mrm mlm"></span><span class="mail-from">Bhaumik Patel</span>
																		</div>
																		<div class="col-lg-8"><i class="mail-title">Sed ut
																			perspiciatis unde</i>&nbsp; -
																			&nbsp;<span class="text-muted" style="font-size: 11px;">Lorem ipsum dolor sit amet...</span><span class="pull-right">12:10 AM</span><span class="pull-right mrl"><span class="glyphicon glyphicon-paperclip"></span></span>
																		</div>
																	</div>
																</a></div>
															</div>
														</div>
													</div>
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
								<button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
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

 
<script src="/js/jquery-1.8.3.min.js" ></script>
<script src="/js/candor.blockui.js"></script>
<script src="/js/jquery.nicescroll.js"></script>
<script src="/js/jquery-ui.custom.min.js"></script>
<script src="/js/bootstrap.min.js" ></script>
</body>
</html>
