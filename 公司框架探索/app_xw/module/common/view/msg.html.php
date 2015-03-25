<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="refresh" content="<?=isset($time)?$time:3;?>;URL=<?=$url ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title></title>

<style type="text/css">
body { height:300px; }
.msg { margin:0 auto; border:1px solid #CBD8AC; width:400px; margin-top:50px; }
.msg h1 { border-bottom:1px solid #CBD8AC; font-size:14px; background-image:url(wbg.gif); background-repeat:repeat-x; height:24px; line-height:24px; text-align:center; color:#003399 }
.msg .msgBody { padding:10px; text-align:center; font-size:13px; color:#0099FF }
.msg .msgBody a { color:#000 }
</style>

</head>
<body>
<div class="msg">
  <h1>提示信息!</h1>
  <div class="msgBody">
	<?=$msg ;?>,<?=isset($time)?$time:3;?>秒后将自动返回上级页面
	<p><a href="<?=$url ?>">点击返回前页面</a></p>
  </div>
</div>
</body>
</html>
