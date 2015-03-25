<?php
require_once ('manager/IUser.class.php');

/**
 * 用户类
 * 
 * 实现与用户信息相关的方法
 * @version 1.0
 * @created 13-一月-2011 11:06:01
 */
class User implements IUser
{

    /**
     * 全局的config。
     *
     * @private object
     */
    private $config;

	/**
     * soap对象。
     *
     * @private soap
     */
    private $soap;

	/**
     * pdo对象。
     *
     * @private pdo
     */
    private $pdo;



    /**
     * 构造函数。
     *
     */
    public function __construct()
    {
		$this->setConfig();
		if($this->config->loginType=='mysql'){
			$this->pdo =  new MysqlPdo();
			$this->soap = Util::getSoapClient($this->config->wsdl->$_POST['app']);
		}else{
			$this->soap = Util::getSoapClient($this->config->wsdl->$_POST['app']);
		}
    }

	/******************************* WSDL 方式调用方法 开始  *******************************/
	/**
	 * 获取用户信息。
	 * 
	 * @param userid    用户id
	 */
	function getUserInfo($userid)
	{ //实现抽象
	}

	/**
	 * 获取用户权限。
	 * 
	 * @param userName    用户名。
	 * @param passWord    用户名。
	 * @param md5key     验证码。
	 */
	function getUserRole($userName, $passWord, $md5key='')
	{
		$userName = iconv('utf-8','gbk',$userName);
		$wsXml = '<?xml version="1.0" encoding="gbk" standalone="yes"?><root xmlns="@http://www.cdrj.net.cn/xml" self="@execquery"><query id="user_login"><parameter id="md5key" value="'.base64_encode($md5key).'"/><parameter id="usbkey" value=""/><parameter id="Login_id" value="'.base64_encode($userName).'"/><parameter id="Password" value="'.base64_encode($passWord).'"/></query></root>';
		$_userloginXml = $this->soap->doRequest($wsXml);//$_userloginXml = $util->processDataByWS($_userloginXml);
		//获取该用户下面的所有权限ID
		$xmlProcess = new ProcessBusinessXml();
		$_userloginArr=$xmlProcess->xml2BizArray($_userloginXml,'query');
		$_userloginArr=$xmlProcess->getTableArray($_userloginArr,'EXECQUERY','');
		$_userloginData=$xmlProcess->getTableJson($_userloginArr);
		foreach($_userloginArr as $key => $value){
			$rightid=$value['RECORD']['EXECQUERY-ID'];
			$rightname=$value['RECORD']['EXECQUERY-RIGHT_NAME'];
			$appname=$value['RECORD']['EXECQUERY-APPNAME'];
			$arrRole[] = $rightid."_".$appname."_".$rightname;
		}
		$_SESSION['_role_'] = join(",", $arrRole);
		//print_r($_SESSION);
	}

	/**
	 * 根据应用系统appname获取权限
	 * 
	 * @param array $appName  应用系统名
	 */
	 function getAppModule($appName=array('网上签约系统','网上办件系统')){
		//获取该应用的权限get_app_module
		foreach($appName as $iname){
			$appNameString .= "'".$iname."'".",";
		}
		$appNameString = substr($appNameString,0,-1);
		$wsXml = '<?xml version="1.0" encoding="gbk" standalone="yes"?><root xmlns="@http://www.cdrj.net.cn/xml" self="@execquery"><query id="get_app_module"><parameter id="appname" value="'.base64_encode(iconv('utf-8','gbk',$appNameString)).'"/></query></root>';
		$_appModule = $this->soap->doRequest($wsXml);
		//print_r(htmlspecialchars($_appModule));
		$xmlProcess = new ProcessBusinessXml();
		$_appModuleArr=$xmlProcess->xml2BizArray($_appModule,'query');
		$_appModuleArr=$xmlProcess->getTableArray($_appModuleArr,'EXECQUERY','');
		return $_appModuleArr;
	 }

	/**
	 * 用户登录。
	 * 
	 * @param userName    用户名。
	 * @param passWord    用户名。
	 * @param usbKey     usb密钥。
	 * @param checkCode     验证码。
	 */
	function login($userName, $passWord, $md5key='', $usbKey='')
	{	
		$returnBl = $this->soap->userLongin($userName,$passWord,$md5key);
		return $returnBl;
		//return true;
	}

	/**
	 * 根据userid，修改用户信息。
	 * 
	 * @param userid    修改用户id。
	 * @param userInfo    修改的用户信息。
	 */
	function modifyUserInfo($userid, $userInfo)
	{
	}

	/**
	 * 根据用户id，修改用户密码
	 * 
	 * @param userid    修改用户id。
	 * @param oldPwd    旧密码。
	 * @param newPwd    新密码。
	 */
	function modifyUserPwd($userid, $oldPwd, $newPwd)
	{
	}
	
	/**
	 * author luojun
	 * date 2010-10-25
	 * 根据指定的webservice方法和相应的条件读取相关数据
	 * @param $wsFn 后台调用函数
	 * @param $paramArr 与后台调用函数相对应的查询条件数组
	 * @return xml字符串
	 */
    function getUserAllInfoXml($wsFn, $paramArr){
        $sXml = "";$paraData="";
        if(empty($wsFn))	return $sXml;	
		$sXml="<?xml version='1.0' encoding='gbk' standalone='yes'?>";		
		$sXml= $sXml."<root xmlns='@http://www.cdrj.net.cn/xml' self='@CallRpc'>";		
		$sXml=$sXml. "<sql>".base64_encode($wsFn)."</sql><params>";		
			
		$allkeys=array_keys($paramArr);
		for($i=0;$i<count($allkeys);$i++){
			$key=$allkeys[$i];
			$val=base64_encode($paramArr[$key]);
			$paraData=$paraData."<".$key.">";
			$paraData=$paraData.$val."</".$key.">";
		}
		if(!empty($paraData)){
			$sXml=$sXml.$paraData;
		}
		$sXml=$sXml. "</params></root>";
		$sXml=  $this->soap->doRequest($sXml);
		return $sXml;
    }

	/******************************* WSDL 方式调用方法 结束  *******************************/


	/******************************* MySql 方式调用方法 开始  *******************************/
	/**
	 * MySql用户登录。
	 * 
	 * @param userName    用户名。
	 * @param passWord    用户名。
	 * @param usbKey      usb密钥。
	 */
	function msLogin($userName, $passWord, $usbKey='')
	{	
		$sql = "select * from admin where username='{$userName}' and password='".md5($passWord)."'";
		$userInfo = $this->pdo->getRow($sql);
		if(count($userInfo)){
			return $userInfo;
		}else{
			return false;
		}
	}

	/******************************* MySql 方式调用方法 结束  *******************************/

	
	/******************************* 内部方法  **********************************************/
	/* 设置config对象。*/
	private function setConfig()
	{
		global $config;
		$this->config = $config;
	}

}
?>
