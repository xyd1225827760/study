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
<title>UI</title>
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/cdrstyle.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/default/style.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/default/page.css';?>' type='text/css' media='screen' />
<script src="/js/jquery-1.8.3.min.js" type="text/javascript"></script>
<!-- *���صȴ� js -->
<script src="/js/candor.blockui.js" type="text/javascript"></script>
<script src="/js/candor.common.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {

	});
</script>
</head>
<style></style>
<body>
<div class="subnav subnav-fixed navbar-fixed-top">
	<form class="form-inline span6">
		ҵ���ں�:<input type="text" id="input01" class="input-small">
		��ˮ��:<input type="text" class="input-small search-query">
		<button type="submit" class="btn"><i class="icon-search"></i>����</button>
	</form>
			
	<ul class="nav nav-pills">
      <li><a href="#labels">��ǩ</a></li>
      <li><a href="#badges">���</a></li>
      <li><a href="#typography">�Ű�</a></li>
      <li><a href="#thumbnails">����ͼ</a></li>
      <li><a href="#alerts">����</a></li>
      <li><a href="#progress">������</a></li>
      <li><a href="#misc">����</a></li>
	  
	  <li style="float:right; line-height:32px;"><input class="btn" type="button" value="Input" />&nbsp;&nbsp;&nbsp;</li>
    </ul>
	
	
</div>
<div class="container-fluid">

  <div class="row-fluid">
	<div class="span12">
		<br><br>
		<button class="btn" onclick="alert_msg('�ɹ���ʾ','succeed','/index/demo.php|����')">�ɹ���ʾ</button>
		<?=$table?>
		<?=$splitPageStr?>
	</div>
	
  </div>
</div>


</body>
</html>