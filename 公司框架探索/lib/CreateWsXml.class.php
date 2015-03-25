<?php
require_once ('manager/ICreateWsXml.class.php');

/**
 * 生成xml请求数据类
 * @author luojun
 * @version 1.0
 * @created 13-一月-2011 11:06:01
 */
class CreateWsXml implements ICreateWsXml
{

	function CreateWsXml()
	{
	}



	/**
	 * 创建callRpc处理的xml
	 *
	 * @param funid    函数名称id
	 * @param params    参数
	 */
	function callRpc($funid, $params){
	
	    $sXml = "";$paraData="";
        if(empty($funid))	return $sXml;
		$sXml="<?xml version='1.0' encoding='gbk' standalone='yes'?>";
		$sXml= $sXml."<root xmlns='@http://www.cdrj.net.cn/xml' self='@CallRpc'>";
		$sXml=$sXml. "<sql>".base64_encode($funid)."</sql><params>";

		$allkeys=array_keys($params);
		for($i=0;$i<count($allkeys);$i++){
			$key=$allkeys[$i];
			$val=base64_encode($params[$key]);
			$paraData=$paraData."<".$key.">";
			$paraData=$paraData.$val."</".$key.">";
		}
		if(!empty($paraData)){
			$sXml=$sXml.$paraData;
		}
		$sXml=$sXml. "</params></root>";
		
		return $sXml;
	}

	/**
	 *
	 * @param sqlid    查询sqlid
	 * @param params    参数数组(一、二维)
	 */
	function execsqlbycls($sqlid, $params){
        $sXml = "";
        if(empty($sqlid)) return $sXml;
		$sXml="<?xml version='1.0' encoding='gbk' standalone='yes'?>";
		$sXml= $sXml."<root xmlns='@http://www.cdrj.net.cn/xml' self='@execsqlbycls'>";
		$sXml=$sXml. "<sql>".base64_encode($sqlid)."</sql>";
		$paraData="<params>";
		$allkeys=array_keys($params);
		for($i=0;$i<count($allkeys);$i++){
			$key=$allkeys[$i];
			$val=$params[$key];
			$paraData=$paraData."<".$key.">";
			//if($key == "ATTOBJ") $paraData=$paraData.$val."</".$key.">";else 
			
			$paraData=$paraData.base64_encode($val)."</".$key.">";
		}
		$paraData=$paraData."</params>";
		if(!empty($paraData)) $sXml=$sXml.$paraData;
		$sXml=$sXml. "</root>";
		//print_r(htmlspecialchars($sXml));
		return $sXml;
	}

	/**
	 *
	 * @param sqlid
	 * @param params
	 */
	function execsqlbyid($sqlid, $params){
        $sXml = "";
        if(empty($sqlid)) return $sXml;
		$sXml="<?xml version='1.0' encoding='gbk' standalone='yes'?>";
		$sXml= $sXml."<root xmlns='@http://www.cdrj.net.cn/xml' self='@execsqlbyid'>";
		$sXml=$sXml. "<sql>".base64_encode($sqlid)."</sql>";
		$paraData="<params>";
		$allkeys=array_keys($params);
		for($i=0;$i<count($allkeys);$i++){
			$key=$allkeys[$i];
			$val=$paramArr[$key];
			$paraData=$paraData."<".$key.">";
			$paraData=$paraData.base64_encode($val)."</".$key.">";
		}
		$paraData=$paraData."</params>";
		if(!empty($paraData)) $sXml=$sXml.$paraData;
		$sXml=$sXml. "</root>";
		return $sXml; 
	}

	/**
	 *
	 * @param sqlid
	 * @param params
	 */
	function execsql($sqlid, $params){
        $sXml = "";
        if(empty($sqlid)) return $sXml;
		$sXml="<?xml version='1.0' encoding='gbk' standalone='yes'?>";
		$sXml= $sXml."<root xmlns='@http://www.cdrj.net.cn/xml' self='@execsql'>";
		$sXml=$sXml. "<sql>".base64_encode($sqlid)."</sql>";
		$sXml=$sXml. "</root>";
		return $sXml;
	}

	/**
	 *
	 * @param sqlid
	 * @param params
	 */
	public function execquery($sqlid, $params){
        $sXml = "";		$paraData="";
        if(empty($sqlid)) return $sXml;
		$sXml="<?xml version='1.0' encoding='gbk' standalone='yes'?>";
		$sXml= $sXml."<root xmlns='@http://www.cdrj.net.cn/xml' self='@execquery'>";
		$sXml=$sXml. "<query id='".$sqlid."'>";

		$p = array();
		foreach($params as $key=>$val)
		{
			$val = base64_encode($val);
			$p[] = "<parameter id='{$key}' value='{$val}'/>";
		}
		$paraData = implode("", $p);
		if(!empty($paraData)) $sXml=$sXml.$paraData;

		$sXml=$sXml. "</query></root>";

		return $sXml;
	}

	/**
	 *
	 * @param bizid    业务id
	 * @param params
	 */
	function getData($bizid, $condition = "", $params)
	{
        $sXml = "";
        if(empty($bizid)) return $sXml;

        $sXml .= "<?xml version=\"1.0\" encoding=\"gbk\" standalone=\"yes\"?>";
        $sXml .= "<root xmlns=\"@http://www.cdrj.net.cn/xml\" self=\"@getData\" business=\"{$bizid}\">";
        $sXml .= "<params>";

        if(!empty($condition)){
        	$sXml .="<param name=\"@condition\">";
        	$sXml .= base64_encode($condition);
        	$sXml .= "</param>";
        }
        if(!empty($params)){
        	$paraKeys=array_keys($params);
	        for($i=0;$i<count($paraKeys);$i++){
	        	$paraname=$paraKeys[$i];
	        	$paravalue=$params[$paraname];
		        	$sXml .="<param name=\"".$paraname."\">";
		        	$sXml .= base64_encode($paravalue);
		        	$sXml .= "</param>";
	    	}
    	}
        $sXml .="</params>";
        $sXml .= "</root>";
		return $sXml;
	}

   /**
    * 读取数组数据，并转化为webservice需要的XML字符串
	 *
	 * @param bizid
	 * @param params
	 */
	function dealData($bizid, $params)
	{
		$tables =  $actions = array();

		$mainTable = $subTable = $tempTable = "";
		$tableName = $fieldName = $tableAction = $tableId = $wsXml = $fieldValue = "";
		

		//遍历传入的数组
		foreach($params as $key => $val)
		{
			//将定义的分隔符转换成指定的分隔符；
			if(isset($params['xmlheader_separated'])) $key = str_replace($params['xmlheader_separated'], '@', $key);

			if(strpos($key,'_tableAction'))	//提取表信息
			{
				#ESTATE__ESCROWIN_tableAction
				$tableName =substr($key,0,strrpos($key,'_'));
				$val = in_array($val, array("append", "update", "delete", "delete_append"))? $val : "none";
				$actions[$tableName] = $val;
			}
			elseif(preg_match('/[\w]+@[\w]+-[\w]+/i',$key))
			{
				//把不同的信息写入不同的表
				$tableName=substr($key,0,strpos($key,'-'));
				$fieldName=substr($key,strpos($key,'-')+1);

				
				if(strpos($key,'FRONT_'))	continue;


				if(is_array($val))
				{
					//多条信息
					//遍历子表
					for($i=0, $m=sizeof($val); $i<$m; $i++)
					{
						$fieldValue = base64_encode(iconv("utf-8", "GBK", $val[$i]));
						$tables[$tableName][$i][] = "<field name=\"{$fieldName}\">{$fieldValue}</field>";
					}
				}
				else
				{

					$fieldValue = base64_encode(iconv("utf-8", "GBK", $val));
					//单条信息
					$tables[$tableName][0][] = "<field name=\"{$fieldName}\">{$fieldValue}</field>";
				}
			}
		}

		//遍历生成的表的数组
		foreach($tables as $key=>$val)
		{
			$tempTable = "";


			for($i=0, $m=sizeof($val); $i<$m; $i++)
			{
				$tempTable .= "<row>" . implode("", $val[$i]) . "</row>";
			}

			$tempTable = "<table id=\"".str_replace('@','.',$key)."\" action=\"{$actions[$key]}\">{$tempTable}</table>";

			if($key == $params['xmlheader_tableID']) $mainTable = $tempTable;
			else $subTable .= $tempTable;

			unset($actions[$key]);#2011-6-1 庄飞 去掉已经构造的表信息
		}

		#2011-6-1 庄飞 表单无数据提交清空从表信息
		foreach($actions as $key=>$val)
		{
			if(strtolower($val) == "delete_append")
			{
				$subTable .= "<table id=\"".str_replace('@','.',$key)."\" action=\"delete_append\"></table>";
			}
		}

		//生成XML
		$wsXml = "<?xml version='1.0' encoding='gbk' standalone='yes'?>";
		$wsXml .= "<root xmlns='@http://www.cdrj.net.cn/xml' self='@dealdata' action='{$params['xmlheader_action']}' business='{$bizid}' parameter=''>";
		$wsXml .= $mainTable;
		$wsXml .= $subTable;
		$wsXml .=  "</root>";
		
		/*
		echo "<pre>";
		print_r($wsXml);
		die;
		*/

		return $wsXml;
	}
}
?>