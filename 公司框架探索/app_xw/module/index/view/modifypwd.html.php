<?php
/**
 * 修改密码模板文件
 *
 * @copyright   Copyright: 2013
 * @author      LuoJun
 * @package     CandorPHP
 * @version     $Id: modifypwd.html.php,v 1.1 2013-11-26 luojun Exp $
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>UI</title>
<script src="/js/jquery-1.8.3.min.js" ></script>
<script src="/js/plugins/artDialog/jquery.artDialog.source.js?skin=default" type="text/javascript"></script>

<link rel='stylesheet' href='/theme/cdrstyle.css' type='text/css' media='screen' />
<link rel='stylesheet' href='/theme/default/style.css' type='text/css' media='screen' />
<link rel='stylesheet' href='/theme/default/page.css' type='text/css' media='screen' />
<style>
	.form-horizontal .control-label{text-align: right;}
</style>
<script src="/js/candor.common.js"></script>
<script src="/js/plugins/html5Validate/jquery-html5Validate.js"></script><!--前段检验JS-->
<script src="/js/jquery.form.js.min.js"></script>
<script src="/js/plugins/datepicker/WdatePicker.js" ></script>
<script type="text/javascript">
	art.dialog.data("EstateInfo",{});
	art.dialog.data("IsDone",false);
	var estatelist = {};
	var win = art.dialog.open.origin;//来源页面
	function InsertPerson(id){
	    var elements = $("#modifyPwdFrm").find(":input");
		if ($.html5Validate.isAllpass(elements)){
			var sUrl = "/index/confirmpwd.candor";
			var msgObj;
			 options = {
				url : sUrl,//ajax提交需要跟参数ajax=1
				dataType : "json",
				beforeSubmit:function(){
				  msgObj = alert_msg("正在保存数据,请稍后!","loading","");
				},
				success: function(data) { 
					if(data.code=='1'){
						msgObj.close(); 
						window.parent.location.href = "logout.candor";	
					}
					else{				
						msgObj.close();
						alert(data.msg);  
					}
				} 
			}		
			$("#modifyPwdFrm").ajaxSubmit(options);	
		}
	}
	function CancelPerson(){
		art.dialog.data("IsDone",false);
		art.dialog.close();
	}

</script>
</head>
		<body style="height:auto;padding:0 20px;">		
		<div id="container-fluid">
			 <form class="form-horizontal" id="modifyPwdFrm" name="modifyPwdFrm" action=""  method="post"> 

							<div class="row-fluid" width="90%"> 
								<div class="span12">
								   <div class="control-group">
									<label class="control-label" for="oldpwd">原始密码：</label>
									<div class="controls">
									  <input type="text" class="input-medium" name="oldpwd" id="oldpwd" required value=""/>
								   </div> 
								   </div>
								   <div class="control-group">
									<label class="control-label" for="newpwd">新密码：</label>
									<div class="controls">
									  <input type="text" class="input-medium" name="newpwd" id="newpwd" required value=""/>
								   </div> 
								   </div>
									<div class="control-group">
									  <label class="control-label" for="cfrpwd">确认新密码：</label>
									<div class="controls">
									<input type="text" class="input-medium" name="cfrpwd" id="cfrpwd" required value=""/>
									</div>
								   </div>
								</div>
							</div>
             <div class="row" align="center">
		          <input  id="btnOK_Person" type="button" data="0" onclick="InsertPerson(0);" class="btn btn-primary" value="确认"/> 
			      <input  id="btnCancel_Person" type="button" onclick="CancelPerson()" class="btn btn-info" value="取消"/>
             </div>
			 </form> 
		</div>
	</body>
</html>
