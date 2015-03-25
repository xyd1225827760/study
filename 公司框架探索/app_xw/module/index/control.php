<?php
/**
 * The control file of index module of CandorPHP.
 *
 * @copyright   Copyright: 2010
 * @author      LuoDong <751450467@qq.com>
 * @package     CandorPHP
 * @version     $Id: control.php,v 1.4 2012/02/16 09:53:49 lj Exp $
 */
require("../../lib/xmlrpc/xmlrpc.inc");

class index extends SecuredControl
{
	/**
	 * ���ݿ����ӡ�
     * 
     * @var object
     * @access pdo
     */
	protected $pdo;
	protected $ado;

    /* ���캯����*/
    public function __construct()
    {
        parent::__construct();
        
		$this->ado = new DbAdo();
		$this->pdo = new DbPdo();


		
		$xmlrpc_oe = new Oe();
		//����һ����������-��һ��
		/*
		$production_data = array(
			'name'=>new xmlrpcval(iconv("UTF-8", "Gb2312", "Luodong/0005"), "string"),
			'product_id'=>new xmlrpcval('2', "int"),//��Ʒid
			'product_uom'=>new xmlrpcval('1', "int"),//��Ʒ������ʼ��Ϊ1
			'routing_id'=>new xmlrpcval('1',"int"),//������·,ʼ��Ϊ1
			'bom_id'=>new xmlrpcval('1',"int"),//��Ʒbom_id
			'location_dest_id'=>new xmlrpcval('13',"int")//Ŀ�Ŀ�λ
		);
		$resp = $xmlrpc_oe->create("mrp.production",$production_data);
		*/

		//ȷ����������ͬʱOE����������-�ڶ���
		//$xmlrpc_oe->call_oe_func("mrp.production","action_confirm",103);

		//��OE���ʵ�ַ���-������

		//����Ƿ��ͻ�-���Ĳ�

		//ȷ���ջ�(��ҵ-����)-��OE�����ƻ�����Ϊ"׼������"״̬-���岽
		//$xmlrpc_oe->call_oe_func("mrp.production","action_ready",103);

		//����OEͶ��������-��OE�����ƻ�����Ϊ"�Ѿ���ʼ����"-����������ҵ-С�䣩
		//$resp = $xmlrpc_oe->action_produce(103,1,"consume_produce");
		
		//��ҵ���-��OE�����ƻ�����Ϊ"���"-���߲�
		//$resp = $xmlrpc_oe->action_production_end(103);

		//������ҵ��ɺ󣬿��Ե��"��ⰴť"����OE����"�ڲ�����"-�ڰ˲�
		//$resp = $xmlrpc_oe->stock_picking("stock.picking","create");

		

		//print_r($resp);
		//exit;
		# ����
		//echo "search:<br />";
		//$ids = $xmlrpc_oe->search("mrp.production", "id", "=", "16");
		//print_r($ids);
		//$xmlrpc_oe->call_oe_func("mrp.production","action_ready",35);

		//exit;
		/*		
		$xmlrpc_oe = new Oes();

		# ����
		echo "search:<br />";
		$ids = $xmlrpc_oe->search("product.product", "id", ">", "0");
		print_r($ids);
		exit;*/
    }
	
	public function adddemo(){
		$this->display('index','addtop');
	}

	public function adddemo1(){
		$this->display('index','addtop1');
	}

	public function layout(){
		$this->display('index','layout');
	}

	public function photo(){
		if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
			exit;
		}
		$folder = WEB_UPLOAD.'\\takephoto\\';
		$filename = md5($_SERVER['REMOTE_ADDR'].rand()).'.jpg';
		$original = $folder.$filename;
		// ��ȡԭʼͼƬ����:
		$input = file_get_contents('php://input');
		//print_r(iconv("gb2312", "UTF-8", $input));exit;
		if(md5($input) == '7d4df9cc423720b7f1f3d672b89362be'){
			exit;
		}

		$result = file_put_contents($original, $input);
		if (!$result) {
			echo '{"error": 1, "message":"ͼƬ����ʧ��.��ȷ��Ŀ¼Ȩ��Ϊ777��"}';
			exit;
		}

		$info = getimagesize($original);
		if($info['mime'] != 'image/jpeg'){
			unlink($original);
			exit;
		}

		// ����ʱ�ļ��ƶ���Ŀ¼�ļ���:
		rename($original,WEB_UPLOAD.'\\takephoto\\original\\'.$filename);
		$original = WEB_UPLOAD.'\\takephoto\\original\\'.$filename;

		// ��������ͼ:
		$origImage	= imagecreatefromjpeg($original);
		$newImage	= imagecreatetruecolor(154,110);
		imagecopyresampled($newImage,$origImage,0,0,0,0,154,110,520,370); 
		imagejpeg($newImage,WEB_UPLOAD.'\\takephoto\\thumbs\\'.$filename);
		echo '{"status":1,"message":"���ճɹ�!","filename":"'.$filename.'"}';
	}

	public function demo(){

		/******************************���ݿ���� start***********************************/
		//Util::alert_msg('��ʾ��Ϣ','succeed','/index/demo',3);
		//��ȡ����
		//$rs = $this->ado->GetAll('select * from mrp_workcenter');
        //print_r($rs);
		//exit;
		
		//ͳ�Ƽ�¼ 
		//$count = $this->ado->CountAll('mrp_workcenter','id>50');
		//print_r($count);exit;

		/**/
		//��ҳ���ݵ�ȡ
		$orderField = isset($_GET['sort']) ? $_GET['sort'] : 'id';
		$orderValue = isset($_GET['flag']) ? $_GET['flag'] : 'asc';
		$page_info = "";
		$pageSize = 5;
		$offset = 0;
		$subPages=5;//ÿ����ʾ��ҳ��
		$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 0;
		if($currentPage>0) $offset=($currentPage-1)*$pageSize;
		$where = ' where 1=1 ';
	   	if($_GET) {
			//������������
	    }
		$select_columns = "select %s from mrp_workcenter %s %s";
	    $order = "order by $orderField $orderValue";
	    $sql = sprintf($select_columns,'*',$where,$order);

		$rs = $this->ado->SelectLimit($sql,$pageSize,$offset);

		$recordCount = $this->ado->GetCount();
		$page=new pager_page($pageSize,$recordCount,$currentPage,$subPages,$page_info,4);
		$splitPageStr=$page->get_page_html();

		//print_r($splitPageStr);
		//print_r($rs);exit;
		//$toHtml = new ToHtml();
		//$table = $toHtml->arr2html($rs,array('id','name','asdf'));

		//$this->assign('table',$table);
		$this->assign('splitPageStr',$splitPageStr);
		//print_r($table);exit;
		

		/*
		//��������
		$record["name"] = "Bob"; 
		$record["code"] = "Smith"; 
		$record["create_date"] = time();
		$record["create_uid"] = 1;
		$record['write_uid'] = 1;
		$record["write_date"] = time();
		$record["product_id"] = 1;
		$record["resource_type"] = 1;
		$record["asdfasdf"] = 1;
		echo $rs = $this->ado->Add($record,'mrp_workcenter');
		*/

		/*
		//�޸�����
		$record1['name'] = "Bob112";
		$rs = $this->ado->Update($record1,'mrp_workcenter','id<10');
		print_r($rs);exit;
		*/

		//��ȡ����
		//$rs = $this->ado->Remove('mrp_workcenter','id=10');
        //print_r($rs);
		//exit;

		

		/******************************���ݿ���� end***********************************/
		//$this->display('index','plan');
		$this->display('index','task');
	}

    /* index������Ҳ��Ĭ�ϵķ�����*/
    public function index()
    {
        //print_r($_SESSION);
		if($this->config->debug){
			$SQL = "select * from dbo.sys_project";
		}else{
			$SQL = "select * from dbo.sys_project where flag>0";
		}
		
		//print_r($_SESSION['userRelateInfo']);
		$projectList = $this->ado->GetAll($SQL);

		if($_SESSION['ISADMIN']!=1){
			$pro_role = $this->getProRole($_SESSION['userRelateInfo']['RIGHTS']);
			foreach ($projectList as $k=>$v){
				if(!in_array($v['project_name'],$pro_role['mod'])){
					unset($projectList[$k]);
				}
			}
			$projectList = array_values($projectList);
		}
		if($this->config->debug){
			$SQL = "select * from dbo.sys_module";
		}else{
			$SQL = "select * from dbo.sys_module where project_code =".$projectList[0]['project_code']." and parent_module=0";
		}
		$moduleList = $this->ado->GetAll($SQL);//print_r($moduleList);

        if($_SESSION['ISADMIN']!=1){
            $pro_role = $this->getProRole($_SESSION['userRelateInfo']['RIGHTS'],true);
            foreach ($moduleList as $k=>$v){ 
                if(!empty($v['module_name'])&&!in_array($v['module_name'],$pro_role['mod'])||!in_array($v['business_name'],$pro_role['name'])){
                    unset($moduleList[$k]);
                }
            }
        }

		$header['title'] = $this->lang->welcome;
        $this->assign('header',  $header);
		$this->assign('projectList', $projectList);
		$this->assign('moduleList',$moduleList);
        $this->display('index','index');
    }

	/* auth del--------------*/
    public function auth()
    {
		$this->display('index','auth');
    }

	/* ����Ӧ�� */
	public function set_app()
	{
		if($this->config->debug){
			$SQL = "select * from sys_project";
		}else{
			$SQL = "select * from sys_project where flag>0";
		}
		$projectList = $this->ado->GetAll($SQL);
        if($_SESSION['ISADMIN']!=1){
            $pro_role = $this->getProRole($_SESSION['userRelateInfo']['RIGHTS']);
            foreach ($projectList as $k=>$v){
                if(!in_array($v['project_name'],$pro_role)){
                    unset($projectList[$k]);
                }
            }
            $projectList = array_values($projectList);
        }
		$this->assign('projectList', $projectList);

		if($this->config->debug){
			$SQL = "select * from sys_module";
		}else{
			$SQL = "select * from sys_module where flag=1";
		}
		$moduleList = $this->ado->GetAll($SQL);

        if($_SESSION['ISADMIN']!=1){
            $pro_role = $this->getProRole($_SESSION['userRelateInfo']['RIGHTS'],true);
            foreach ($moduleList as $k=>$v){ 
                if(!empty($v['module_name'])&&!in_array($v['module_name'],$pro_role['mod'])||!in_array($v['business_name'],$pro_role['name'])){
                    unset($moduleList[$k]);
                }
            }
        }
        //print_r($moduleList);
		foreach($moduleList as $key=>$item){
			//�ж�ģ���Ƿ�ע��ģ��
			if(helper::chechKey($item['serial_number']))
			{
                $moduleName = explode("/",$item['module_name']) ;
                $moduleName = count($moduleName) > 0 ? $moduleName[0] : $moduleName ;
				$currentConfig = $this->app->getmoduleRoot()."/".$moduleName."/config.php";
				if(file_exists($currentConfig))
				{
					//require_once($currentConfig);
					$moduleList[$key]['icon'] = $item['app_icon'] ;
				}else{
					unset($moduleList[$key]);
				}
			}
		}
		$this->assign('moduleList',$moduleList);
        $this->assign('header',  "����Ӧ��");
        $this->display('index','set_app');
	}
	
	/* ajax ��ȡ�Ӳ˵���Ϣ */
	public function ajaxSubMenu() {
		//��sqlite�л�ȡ�Ӳ˵���Ϣ
		$pid = isset($_POST['pid'])?$_POST['pid']:0;
		//$sqlite = new Sqlite();
		if($this->config->debug){
			$SQL = "select * from sys_module where project_code='".$pid."' and parent_module='0'";
		}else{
			$SQL = "select * from sys_module where flag=1 and project_code='".$pid."' and parent_module='0'";
		}
		$subMenuList = $this->ado->GetAll($SQL);
		//$liList = array();
		if(count($subMenuList)<1){
			echo "��ģ��û����ģ��";
		}
		if($_SESSION['ISADMIN']!=1){
			$pro_role = $this->getProRole($_SESSION['userRelateInfo']['RIGHTS'],true);
			foreach ($subMenuList as $k=>$v){ 
				if(!empty($v['module_name'])&&!in_array($v['module_name'],$pro_role['mod'])){
					unset($subMenuList[$k]);
				}
			}
		}

		$liString ="";
		foreach($subMenuList as $key=>$item){
			//�жϸ�ģ���Ƿ������ģ��
			$sqlcount = "select count(id) as cnt from sys_module where flag = 1 and parent_module='".$item['id']."'";
			$childCount = $this->ado->getRow($sqlcount);
			if($childCount['cnt']>0){
				$liString .= '<li><a hidefocus="hidefocus" class="expand"><span>'.$item['business_name'].'</span></a>';
				$sql = "select * from sys_module where flag = 1 and parent_module='".$item['id']."'";
                $childList = $this->ado->GetAll($sql); 
				if($_SESSION['ISADMIN']!=1){
					foreach ($childList as $k=>$v){ 
						if(!empty($v['module_name'])&&!in_array($v['module_name'],$pro_role['mod'])||!in_array($v['business_name'],$pro_role['name'])){
							unset($childList[$k]);
						}
					}
				}
                $liString .= '<ul style="display:none">';
				foreach($childList as $ckye=>$citem){						
					$liString .= ' <li><a hidefocus="hidefocus" href="javascript:frameWorkTab(\'app_'.$citem['id'].'\',\''.$citem['business_name'].'\',\'/'.$citem['module_name'].'\');" id="f60"><span>'.$citem['business_name'].'</span></a></li>';
				}
				$liString .='</ul></li>';
			}else{
				$liString .= '<li><a hidefocus="hidefocus" href="javascript:frameWorkTab(\'app_'.$item['id'].'\',\''.$item['business_name'].'\',\'/'.$item['module_name'].'\');"><span>'.$item['business_name'].'</span></a></li>';
			}
		}
		echo $liString;
	}

	//LDAP
	function ldap(){
		/*
		$ds=ldap_connect('127.0.0.1');
		$justthese = array('cn','userpassword','location');
		$sr=ldap_search($ds,"o=army", "cn=dom*", $justthese);
		echo 'domadmin������'.ldap_count_entries($ds,$sr).'��';
		$info = ldap_get_entries($ds, $sr);
		echo "���ϴ��� ".$info["count"]."��:   ";
		for ($i=0; $i<$info["count"]; $i++) {
			echo "dnΪ��". $info[$i]["dn"] ." ";
			echo "cnΪ��". $info[$i]["cn"][0] ." ";echo "emailΪ��". $info[$i]["mail"][0] ."   ";
			echo "emailΪ��". $info[$i]["userpassword"][0] ." ";
		}
		*/
		
		$ldaprdn = 'dc=fg,dc=com'; 
		$ldappass = 'password';
		$sdn = 'ou=������,dc=fg,dc=com';
		$filter = 'cn=�޶�';

		echo "Connecting ...\n";
		$ds=ldap_connect("localhost",389);  // must be a valid LDAP server!
		echo "connect result is ".$ds."\n\n<br>";
		if ($ds) {
			//echo "Binding ($managerdn)...";
			//$r = ldap_bind($ds, $ldaprdn, $ldappass);
			//echo "Bind result is ".$r."\n\n";
			
			$justthese = array("ou", "sn", "givenname");
			$sr = ldap_search($ds,$sdn,$filter);
			$info = ldap_get_entries($ds, $sr);
			print_r($info);
			// compare value
			$r=ldap_compare($ds, "cn=�޶�,ou=������,dc=fg,dc=com", "password", "123");

			if ($r === -1) {
				echo "Error: " . ldap_error($ds);
			} elseif ($r === true) {
				echo "Password correct.";
			} elseif ($r === false) {
				echo "Wrong guess! Password incorrect.";
			}

			/*
			$entry = ldap_first_entry($ds, $sr);
			do {
			  // do other stuff
			  $sr = "something else now";
			  $values = ldap_get_values($ds, $entry, "cn");
			  //print_r($values);
			  // do other stuff
			} while ($entry = ldap_next_entry($ds, $entry));

			$userdn = $this->getDN($ds,'luo jun',$sdn);
			//print_r($userdn);
			
			//echo $info["count"]." entries returned\n";

			//$sr=ldap_read($ds, $sdn,$filter, $justthese);
			//$entry = ldap_get_entries($ds, $sr);
			//print_r($entry);
			*/	
			ldap_close($ds);
		}

	}

	function getDN($ad, $samaccountname, $basedn) {
		$attributes = array('dn');
		$result = ldap_search($ad, $basedn,
			"(cn={$samaccountname})", $attributes);
		if ($result === FALSE) { return ''; }
		$entries = ldap_get_entries($ad, $result);
		if ($entries['count']>0) { return $entries[0]['dn']; }
		else { return ''; };
	}

	/**
	+----------------------------------------------------------
	* ��¼
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param 
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	public function login()
	{
		$username = $_POST['username']; //='yanglin' ;
		$password = $_POST['password']; //='123123';
		
		$login = new LoginNew($username,$password);
		$content = $login->checkUser();
		if($login->issucess==1)
		{
			$msg['status'] = '1' ;
			foreach ($content as $key=>$item)
			{
				if(!empty($item['loginActionUrl']))
				{
					$url[$key]=$item['loginActionUrl'];
					unset($content[$key]['loginActionUrl']);
				}
				else 
				{
					unset($content[$key]);
				}
			}
			$msg['content'] = $content;
			$msg['url'] = $url;
			$msg['count'] = $login->count ;
		}
		else 
		$msg['status'] = '0' ;
		echo json_encode($msg);exit;
		
//		$login = new Login2($username,$password);
//		//$login->login();
//		echo $login->getHtmlContent('http://localhost');
	}
	public function getHttpHtml()
	{
		if(!empty($_GET['u']))
		{
			$login = new Login2();
			$login->getHtmlContent($_GET['u']);
		}
	}
	
	/* ��¼ϵͳ */
	public function loginAJAX(){
		extract($_POST);
		/*if(md5($_POST['verify'])!=$_SESSION["verify"]){
			echo "<script>alert('��֤�벻��ȷ!');history.back();</script>";
			exit();
		}*/

		$username=strtoupper($username);
		$password = strtoupper($password);
		$base = new base64();
		$password = $base->enCrypt($password);
		 
		$today=date("Y-m-d");
		$md5key=md5($password.$today);
		$md5USBkey = $md5key;
		if($this->config->usbkey){
			if($usbkey=="" || !isset($usbkey) ){
				echo 5;
				exit;
			}else{
				$usbkey = urldecode($usbkey);
			    $md5USBkey = $md5USBkey.";".$this->config->CheckkeyType.",".$usbkey;
			}
		}
	
		$user = new User();

		$returnBl = $user->login($username,$password,$md5USBkey);
		
		//$password = base64_encode($password);

		/*if($this->config->usbkey){
				if($usbkey=="" || !isset($usbkey) ){
					echo 5;
					exit;
				}else{
					$usbkey = urldecode($usbkey);
					 $client=Util::getSoapClient("http://172.29.21.84:9080/login/wsdl/login/LoginService.wsdl");
					 $client->decode_utf8 = false;
					 $client->xml_encoding = 'utf-8';
			         $client->soap_defencoding = 'utf-8';
					 $returnBl=$client->getLogin($usbkey);
					 if($returnBl != iconv('GBK', 'UTF-8',$userRelateInfoArr["username"])){
					 	session_destroy();
					 	session_unset();
					 	echo 6;
						exit;
					 }
				}
			}
		*/

		if($returnBl==1){
			//��¼�ɹ�
			$_SESSION['admin'] = true;
			//��ȡ�û���ɫ
			$userRole = $user->getUserRole($username,$password,$md5key);
			
			$_userArr['LOGIN_ID']= iconv('utf-8','gbk',$username);//$username;
			$_userArr['PASSWORD']= $password;
			$_userArr['IDTYPE']= '';
			$_userArr['OWNERID']= '';
			$_userArr['APPNAME']= '';
			$xuserInfo=$user->getUserAllInfoXml('getUserRelateInfo',$_userArr);
			$xmlProcess = new ProcessBusinessXml();
			$userAllInfoArr= $xmlProcess->dealReturnXml($xuserInfo,'node','message');

			if(count($userAllInfoArr)>1) $msg='4';
			$userAllInfo = base64_decode($userAllInfoArr[0]);
			$userRelateInfoArr= Util::resolveXmlMessage($userAllInfo);
			$userRelateInfoArr['PASSWORD']=$password;
			$_SESSION['userRelateInfo']=$userRelateInfoArr;
			$_SESSION['userAllInfo']=$userAllInfo;

			//��ҵ����
			//userRegisterApp
			$_regiArr['LOGIN_ID']= iconv('utf-8','gbk',$username);
			$_regiArr['PASSWORD']= $password;
			$_regiArr['USERINFO']= $_SESSION['userAllInfo'];
			$regiAppRtS=$user->getUserAllInfoXml('userRegisterApp',$_regiArr);
			$regiAppInfoArr= $xmlProcess->dealReturnXml($regiAppRtS,'node','message');
			$regiAppInfo = base64_decode($regiAppInfoArr[0]);
			$_SESSION['APPSERVERREGIONCODE']=$regiAppInfo;
			//����doGetRegionCodeConfig����
			$_regioncodeArr['LOGIN_ID']=iconv('utf-8','gbk',$username);
			$_regioncodeArr['USBREGIONCODE']='';
			$_regioncodeArr['APPSERVERREGIONCODE']=$regiAppInfo;
			$regionCodeS = $user->getUserAllInfoXml('doGetRegionCodeConfig',$_regioncodeArr);
			$regionCodeArr= $xmlProcess->dealReturnXml($regionCodeS,'node','message');
			$regionCodeInfo = base64_decode($regionCodeArr[0]);
			$_SESSION['REGIONCODE']=$regionCodeInfo;
			$regionCodeInfoArr=Util::resolveXmlMessage($regionCodeInfo);
			$_SESSION['REGIONCODEARR']=$regionCodeInfoArr;
			//����doRegisterRegionCode����
			$_regiRegionCodeArr['LOGIN_ID']= iconv('utf-8','gbk',$username);
			$_regiRegionCodeArr['REGIONCODE']= $regionCodeInfo;
			$regiRegionCodeS = $user->getUserAllInfoXml('doRegisterRegionCode',$_regiRegionCodeArr);
			$regiRegionCodeArr= $xmlProcess->dealReturnXml($regiRegionCodeS,'node','message');
			$regiRegionCodeInfo = base64_decode($regiRegionCodeArr[0]);

			
			$regionInfo = explode(",",$_SESSION['REGIONCODEARR']['CANREADREGIONCODE']);
			if(count($regionInfo) > 1){
				$_SESSION['ISCHKREGION'] = true;
			}else{

				$_SESSION['ISCHKREGION'] = false;
			}
			$_SESSION["region"] = isset($regionInfo[0])?$regionInfo[0]:"510101";
			$temp = isset($_SESSION["_role_"])?$_SESSION["_role_"]:"";
	    	$temp = explode(",",$temp) ;
	    	$role = "";
	    	foreach($temp as $key=>$itme){
	    		$role[]=explode("_",$itme);
	    	}
	    	$_SESSION["role"]=$role;
			if(!$regiRegionCodeInfo){
				$msg = "3";
			}else{
				$msg = "1";
			}
		}else{
			$msg = "2";
		}
		//msg = 1:�ɹ� 2:ʧ�� 3:��Ȩ�� 4:��Ϣ���ֶ��� 5���key 6���������key��Ϣ���¼�û������ϣ���ȷ��
		$msgs['status'] = $msg;
		echo json_encode($msgs);
	}
	
	/* �˳�ϵͳ */
	public function logout(){
		session_destroy();//ɾ���������˵�session�ļ�
		//setcookie(session_name(),'',time()-3600,'/');//ɾ�������������cookie
		session_unset();//����ڴ��е�cookie������$_SESSION = array();
		//
		Util::redirect('/userlogin');
		//header("Location: /index/index.html");
	}
	
	private function getProRole($rolelist,$ismethod = false){ 
		$tmp = array();
		foreach ($rolelist as $k=>$v){
			$tmp['mod'][$k] = $ismethod ? ( !empty($v['METHOD'])&&$v['METHOD']!='index' ? $v['MODULE'].'/'.$v['METHOD'] : $v['MODULE'])  : $v['APPNAME'];
            $tmp['name'][$k] = $v['RIGHT_NAME'] ;
		}
		return $tmp;
	}

	public function modifyPwd(){
		$this->assign('moduleList',$moduleList);
        $this->assign('header',  "�޸�����");
        $this->display('index','modifypwd');		
	}

	public function confirmpwd(){
		$base64 = new base64();		
		if($_POST)
		{			
			$oldpwd = $base64->deCrypt($_SESSION["userRelateInfo"]["PASSWORD"]);			
			if(trim($oldpwd) != trim($_POST["oldpwd"])){			
				$result['code'] = '2';			
				$result['msg'] = '����: ԭʼ�����������';
			}else{
				$userid = $_SESSION["userRelateInfo"]["USER_ID"];
				$pwd1 = $_POST["newpwd"];
				$pwd2 = $_POST["cfrpwd"];
				if($pwd1 != $pwd2){			
					$result['code'] = '2';			
					$result['msg'] = '����: �������������벻����!';
				}else {
					$pwd = $base64->enCrypt($pwd1);
					$params = array("ID"=>$userid,"PASSWORD"=>$pwd,"flag"=>$_SESSION["userRelateInfo"]["flag"]);
					$params['ACTION'] = 'none';
					$params['MAINTABLE'] = 'SYSTEM@CYUSERS';
					$params['SUBTABLE'] = array(
						'SYSTEM@CYUSERS' =>array('PK'=>'ID')
					);
					$vresult = $this->prosoap->doSaveInfo('BBizCYPersons',$params);
					if(!$vresult){
						$result['code'] = '2';			
						$result['msg'] = $this->prosoap->erromsg;					
					}else{
						$result['code'] = '1';			
						$result['msg'] = '';						
					}
				}
			}
		}
		
		echo json_encode($result);
	}
}
