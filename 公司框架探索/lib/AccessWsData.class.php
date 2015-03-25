<?php
require_once ('manager/IAccessWsData.class.php');
require_once ('Xml2Array.class.php');
require_once ('Util.class.php');
require_once ('CreateWsXml.class.php');

/**
 * WebService通信类
 * @author luojun
 * @version 1.0
 * @created 13-一月-2011 11:06:01
 */
class AccessWsData implements IAccessWsData
{

	/**
	 * 定义操作类型
	 */
	var $opType;
	var $m_Xml2Array;
	var $m_CreateWsXml;

	/**
     * soap对象。
     *
     * @private soap
     */
    private $soap;
	
	/**
     * 构造函数。
     *
     */
	function __construct($wsdl)
	{
		$this->soap = Util::getSoapClient($wsdl);
		$this->m_CreateWsXml = new CreateWsXml();
	}

	/**
	 * 获得【查询】结果集，返回Json/Array/E4X
	 * 
	 * @param sqlid    查询sqlid
	 * @param data    查询参数
	 * @param sqlparam    查询参数
	 * @param type    返回数据类型，默认’json‘，其他数据形式array，e4x
	 */
	function getWsQueryData($sqlid, $data, $bizType, $type = 'json',$condition="")
	{	
	    //$ws = Util::getSoapClient($this->config->wsdl->LoginWebService);
		switch($bizType){
			case 'execsqlbyid':$xmlstr = $this->m_CreateWsXml->execsqlbyid($sqlid,$data);break;
			case 'callRpc':$xmlstr = $this->m_CreateWsXml->callRpc($sqlid,$data);break;
			case 'execsqlbycls':$xmlstr = $this->m_CreateWsXml->execsqlbycls($sqlid,$data);break;
			case 'execsql':$xmlstr = $this->m_CreateWsXml->execsql($sqlid,$data);break;
			case 'execquery':$xmlstr = $this->m_CreateWsXml->execquery($sqlid,$data);break;
			case 'getdata':$xmlstr = $this->m_CreateWsXml->getData($sqlid,$condition,$data);break;
			case 'bussiness':$xmlstr = $this->m_CreateWsXml->dealData($sqlid,$data);break;
			default:break;
		}
		//print_r(htmlspecialchars($xmlstr));exit;
		if(empty($data)&&($bizType!='getdata')){
			$wsData = '你传入的参数值为空，请重新传入参数值后调用该方法！';
		}else if(empty($xmlstr)){
			$wsData = '你传入的参数值，没有能生成xml字符串，请联系管理员！';
		}else{
			//$this->soap->setEncoding("UTF-8");
			//print_r(htmlspecialchars($xmlstr));
			$wsData = $this->soap->doRequest($xmlstr);		
		}
		return $wsData;
	}

	/**
	 * 新增信息
	 * 
	 * @param data    新增数组数据
	 */
	function addWsData($data)
	{
		$addSQL=$this->basedata2Sql($data);
		$xmlstr = $this->m_CreateWsXml->execsql($addSQL,'');
		if(empty($xmlstr)){
			$wsRtData = '你传入的参数值，没有能生成xml字符串，请联系管理员！';
		}else{
			$wsRtData = $this->soap->doRequest($xmlstr);		
		}
		return $wsRtData;
	}

	/**
	 * 修改信息
	 * 
	 * @param data    更新数据
	 * @param condition    更新记录条件
	 */
	function updateWsData($data, $condition)
	{
		$updateSQL=$this->basedata2Sql($data);
		$updateSQL.=$condition;
		$xmlstr = $this->m_CreateWsXml->execsql($updateSQL,'');
		if(empty($xmlstr)){
			$wsRtData = '你传入的参数值，没有能生成xml字符串，请联系管理员！';
		}else{
			$wsRtData = $this->soap->doRequest($xmlstr);		
		}
		return $wsRtData;
	}

	/**
	 * 删除数据
	 * 
	 * @param condition    删除条件
	 */
	function deleteWsData($condition)
	{
		$xmlstr = $this->m_CreateWsXml->execsql($condition,'');
		if(empty($xmlstr)){
			$wsRtData = '你传入的参数值，没有能生成xml字符串，请联系管理员！';
		}else{
			$wsRtData = $this->soap->doRequest($xmlstr);		
		}
		return $wsRtData;
	}

	/**
	 * 数组转化为SQL语句
	 * 
	 * @param data   基本参数
	 * @param condition   条件
	 */
	function basedata2Sql($data){
		$sql='';
		return $sql;
	}


}
?>
