<?php 
	if(!empty($url)){
		$_url = explode("|",$url);
		if(count($_url)>1){
			$refresh = $_url[0];
		}else{
			$refresh = $url;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ϵͳ��ʾ��Ϣ</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if($time>0){ ?><meta http-equiv="refresh" content="<?=$time;?>;URL=<?=$refresh;?>" /><?php } ?>
<script type="text/javascript" src="/js/plugins/artDialog/artDialog.source.js?skin=default"></script>
<script type="text/javascript" src="/js/plugins/artDialog/plugins/iframeTools.js"></script>
<script src="/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="/js/candor.common.js" type="text/javascript"></script>
</head>
<body>
</body>
</html>
<script>
var msg = '<?=$msg?>';
var status = '<?=$style?>';
var btn1 = '���ؼ�������';
var btn2 = 'δ��������';
var url1='';
var url2='';
<?php
	if(!empty($url)){
		$_url = explode("|",$url);
		if(count($_url)>1){
			echo "url1 = '".$_url[0]."';";
			echo "btn1 = '".$_url[1]."';";
		}else{
			echo "url1 = '".$url."';";
		}
	}
	
	if(!empty($url2)){
		$_url2 = explode("|",$url2);
		if(count($_url2)>1){
			echo "url2 = '".$_url2[0]."';";
			echo "btn2 = '".$_url2[1]."';";
		}else{
			echo "url2 = '".$url2."';";
		}
	}
?>

var obj = art.dialog({
	lock: true,
	background: '#ccc', // ����ɫ
	opacity: 0.37,	// ͸����
	content: msg,
	icon: 'icon48_'+status,
	button: [
        {
            name: btn1,
            callback: function () {
                if(url1!=''){
					window.location.href=url1;
				}else{
					window.history.go(-1);
				}
                return false;
            },
            focus: true
        }
		<?php if(!empty($url2)){ ?>
		,{
            name: btn2,
            callback: function () {
			   if(url2!=''){
				   window.location.href=url2;
			   }else{
				   window.history.go(-1);
			   }
			   return false;
            }
        }
		<?php } ?>
    ],
	close: function () {
    	if(url1!=''){
			window.location.href=url1;
		}else{
			window.history.go(-1);
		}
    }
	/*
	ok: function () {
		if(callback!=null){
			eval(callback+"()");
		}else{
			//window.location.reload(); 
			//window.location.href=url
		}
		return true;
	},
	cancel: true
	*/
});
</script>