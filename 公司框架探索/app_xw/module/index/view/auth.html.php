<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>统一登录平台</title>
<link rel="P3Pv1" href="/p3p.xml"></link>
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/common.css';?>' type='text/css' media='screen' />
<link rel='stylesheet' href='<?php echo $this->app->getWebRoot() .'theme/default/style.css';?>' type='text/css' media='screen' />
</head>
<style>
.group {
	width: 460px;
	float: left;
	margin-right: 40px;
}
.login-form {
	margin-bottom: 60px;
	padding: 20px;
	position: relative;
	display: inline-block;
	zoom: 1; /* ie7 hack for display:inline-block */
	*display: inline;
	border: 1px solid #bbb;
	-moz-border-radius:    10px;
	-webkit-border-radius: 10px;
	border-radius:         10px;
	-moz-box-shadow:    0 1px 2px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.5);
	-webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.5);
	box-shadow:         0 1px 2px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.5);
	behavior:url(/theme/PIE.htc);
}

.login-form.nolabel {   /* only requipurple for the demo */
	margin-bottom: 105px;
}

.login-form label {
	color: #444;
	font-weight: bold;
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
	margin-bottom: 10px;
}

.login-input {
	width: 398px;
	height: 20px;
	padding: 6px 10px;
	margin-bottom: 20px;
	font: 14px 'Helvetica Neue', Helvetica, Arial, sans-serif;
	color: #333;
	outline: none;
	background-color: #fff;
	border: 1px solid #ccc;
	position: relative;
	-moz-border-radius:    8px;
	-webkit-border-radius: 8px;
	border-radius:         8px;
	-moz-box-shadow:    inset 0 0 1px rgba(0, 0, 0, 0.5), 0 0 2px rgba(255, 255, 255, 0.7);
	-webkit-box-shadow: inset 0 0 1px rgba(0, 0, 0, 0.5), 0 0 2px rgba(255, 255, 255, 0.7);
	box-shadow:         inset 0 0 1px rgba(0, 0, 0, 0.5), 0 0 2px rgba(255, 255, 255, 0.7);
	-moz-background-clip:    padding;
	-webkit-background-clip: padding-box;
	background-clip:         padding-box;
	-moz-transition:    all 0.4s ease-in-out;
	-webkit-transition: all 0.4s ease-in-out;
	-o-transition:      all 0.4s ease-in-out;
	-ms-transition:     all 0.4s ease-in-out;
	transition:         all 0.4s ease-in-out;
	behavior:url(/theme/PIE.htc);
}
.login-btn {
	width: 100px;
	height: 30px;
	color: #fff;
	font: bold 12px 'Helvetica Neue', Helvetica, Arial, sans-serif;
	text-shadow: 0 1px 0 rgba(0, 0, 0, 0.5);
	letter-spacing: 1px;
	text-align: center;
	border: 1px solid #1972c4;
	outline: none;
	cursor: pointer;
	position: relative;
	background-color: #1d83e2;
	background-image: -webkit-gradient(linear, left top, left bottom, from(#77b5ee), to(#1972c4)); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient(top, #77b5ee, #1972c4); /* Chrome 10+, Saf5.1+, iOS 5+ */
	background-image:    -moz-linear-gradient(top, #77b5ee, #1972c4); /* FF3.6 */
	background-image:     -ms-linear-gradient(top, #77b5ee, #1972c4); /* IE10 */
	background-image:      -o-linear-gradient(top, #77b5ee, #1972c4); /* Opera 11.10+ */
	background-image:         linear-gradient(top, #77b5ee, #1972c4);
	-pie-background:          linear-gradient(top, #77b5ee, #1972c4); /* IE6-IE9 */
    -moz-box-shadow:    inset 0 1px 0 rgba(255, 255, 255, 0.3), 0 1px 1px rgba(0, 0, 0, 0.5);
	-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.3), 0 1px 1px rgba(0, 0, 0, 0.5);
	box-shadow:         inset 0 1px 0 rgba(255, 255, 255, 0.3), 0 1px 1px rgba(0, 0, 0, 0.5);
	-moz-border-radius:    18px;
	-webkit-border-radius: 18px;
	border-radius:         18px;
	-moz-background-clip:    padding;
	-webkit-background-clip: padding-box;
	background-clip:         padding-box;
	behavior:url(/theme/PIE.htc);
}

.login-btn:active {
	border: 1px solid #77b5ee;
	background-color: #1972c4;
	background-image: -webkit-gradient(linear, left top, left bottom, from(#1972c4), to(#77b5ee)); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient(top, #1972c4, #77b5ee); /* Chrome 10+, Saf5.1+, iOS 5+ */
	background-image:    -moz-linear-gradient(top, #1972c4, #77b5ee); /* FF3.6 */
	background-image:     -ms-linear-gradient(top, #1972c4, #77b5ee); /* IE10 */
	background-image:      -o-linear-gradient(top, #1972c4, #77b5ee); /* Opera 11.10+ */
	background-image:         linear-gradient(top, #1972c4, #77b5ee);
	-pie-background:          linear-gradient(top, #1972c4, #77b5ee); /* IE6-IE9 */
	-moz-box-shadow:    inset 0 0 5px rgba(0, 0, 0, 0.5), 0 1px 0 rgba(255, 255, 255, 0.5);
	-webkit-box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.5), 0 1px 0 rgba(255, 255, 255, 0.5);
	box-shadow:         inset 0 0 5px rgba(0, 0, 0, 0.5), 0 1px 0 rgba(255, 255, 255, 0.5);
}

.forgot {
	color: #555;
	font-style: italic;
	font-size: 12px;
	display: block;
	margin-bottom: 20px;
}

.forgot a {
	color: #3a3a3a;
	-moz-transition:    all 0.4s ease-in-out;
	-webkit-transition: all 0.4s ease-in-out;
	-o-transition:      all 0.4s ease-in-out;
	-ms-transition:     all 0.4s ease-in-out;
	transition:         all 0.4s ease-in-out;	
}

.forgot a:hover {
	color: #000;
}
h2{ color:#fff;
    font: 28px/1.357 'Oswald','Helvetica Neue',Helvetica,Arial,sans-serif;
    margin-bottom: 30px;
    font-weight:bold;
    text-align: center;
}
/*** Light Gray ***/

.login-form.vlgray {
	border: 1px solid #d2d1d0;
	background-color: #ededed;
	background-image: -webkit-gradient(linear, left top, left bottom, from(#f6f6f6), to(#d2d1d0)); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient(top, #f6f6f6, #d2d1d0); /* Chrome 10+, Saf5.1+, iOS 5+ */
	background-image:    -moz-linear-gradient(top, #f6f6f6, #d2d1d0); /* FF3.6 */
	background-image:     -ms-linear-gradient(top, #f6f6f6, #d2d1d0); /* IE10 */
	background-image:      -o-linear-gradient(top, #f6f6f6, #d2d1d0); /* Opera 11.10+ */
	background-image:         linear-gradient(top, #f6f6f6, #d2d1d0);
	-pie-background:          linear-gradient(top, #f6f6f6, #d2d1d0); /* IE6-IE9 */
}

.vlgray .login-input {
	border: 1px solid #d2d1d0;
}
#iframeDiv{display:none;}
</style>
<script src="/js/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="/js/plugins/artDialog/artDialog.js" type="text/javascript"></script>
<script type="text/javascript">
var issucess = false,num = 0;
function goSub()
{
    var issub = true
    $("#form1 input[verify='true']").each(function(){ 
             if($(this).val().length==0){showErroMsg($(this).attr('msg'));$(this).css({'border-color':'red'});issub=false;return false;}else{$(this).css({'border-color':'#969696'});}
    })
	var key = encodeURIComponent($("#usbkey").val());
    if(issub){
        $.ajax({
            type:'post',
            dataType:'json',
            url:'/index/loginAJAX',
            data:{app:'LoginWebService',username:$("#username").val(),password:$("#password").val(),usbkey:key},
            timeout:30000,
            beforeSend: function(){ 
                loadG = art.dialog({
                    lock:true,
                    title:false,
                    border: false,
                    drag: false,
                    esc: false,
                    content:'<div><img src="/theme/loading.gif" /><p style="text-align:center;font-weight:bold;">正在提交,请稍候...</p><div>'
                });
            },
            success:function(msg){ //showErroMsg(msg);return;
                loadG.close();
                if(msg.status=='1'){ 
                    loadG = art.dialog({
                        lock:true,
                        title:false,
                        border: false,
                        drag: false,
                        esc: false,
                        content:'<div><img src="/theme/loading.gif" /><p style="text-align:center;font-weight:bold;">正在登录,请稍候...</p><div>'
                    }); 
                    var $form = msg.content , $url = msg.url;
					window.location.href='/index/platform';
/*
                    if(msg.count>0)
                    {
                        for(var i in $form)
                        {
                                var s = $form[i];
                                $action = $url[i];
                                formInfo(s,$action,i,msg.count);
                        }
                        
                    }
					
					var Int =setInterval(function(){
						num++ ;
						if(issucess||num>3)
						{
							clearInterval(Int);
							window.location.href='/index/platform';
						} 
					},1000)
*/					  
                }
                else
                {
                    loadG.close();
                    showErroMsg('登录失败');return false;
                }
            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                loadG.close();
                showErroMsg('登录失败');return false;
            }
        });
        
    }
        return false;
}
function formInfo($post,action,iframk,count)
{ 
    try{
        var str = '<form action="'+action+'" id="forms'+iframk+'" method="post" target="imLogin'+iframk+'">';
        for(var i in $post)
        {
            str += '<input type="hidden" name="'+i+'" value="'+$post[i]+'" />';
        }
        str += '</form>';
        $(window.frames["imLogin"+iframk].document).find('body').append(str);
        $('#forms'+iframk,window.frames["imLogin"+iframk].document).submit();
		if(parseInt(iframk)==parseInt(count))issucess = true;
    }catch(e)
    {
        return ;
    }
    
}
function showErroMsg($msg)
{
    $.dialog({content:'<b class="red">'+$msg+'</b>',icon: 'error',lock:true,time:1});return false;
}
</script>
<body>
<div style="margin:0 auto;padding:0; width:460px; height:400px; margin-top:100px;">
	<h2>用户登录</h2>
	<div class="group">
		<form class="login-form vlgray" id="form1"  method="post" onsubmit="return false;">
			<label for="username">用户名：</label>
			<input type="text" id="username" name="username" verify='true' class="login-input" required msg="用户名不能为空" />
			
			<label for="password">密码：</label>
			<input type="password" id="password" name="password" verify='true' class="login-input" required msg="密码不能为空" />
			
			<span class="forgot">忘记 <a href="#">用户名</a> / <a href="#">密码</a></span>
			
			<input type="submit" class="login-btn" value="登录" onclick="return goSub();" />
		</form>
	</div>
</div>

<div id="iframeDiv">
<iframe width=0 height=0 src="http://www.pm.com/sysworkflow/zh-CN/classic/login/login"></iframe>

<iframe id="imLogin1" name="imLogin1" width=0 height=0 ><html><body></body></html></iframe>
<iframe id="imLogin2" name="imLogin2" width=0 height=0 ><html><body></body></html></iframe>
<iframe id="imLogin3" name="imLogin3" width=0 height=0 ><html><body></body></html></iframe>
<iframe id="imLogin4" name="imLogin4" width=0 height=0 ><html><body></body></html></iframe>
<iframe id="imLogin5" name="imLogin5" width=0 height=0 ><html><body></body></html></iframe>
<iframe id="imLogin6" name="imLogin6" width=0 height=0 ><html><body></body></html></iframe>

</div>    
</body>
</html>
