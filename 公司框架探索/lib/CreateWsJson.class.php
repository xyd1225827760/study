<?php

/**
 * 生成json请求数据类
 * @author nwl
 * @version 1.0
 * @created 2013-01-16 11:06:01
 */
class CreateWsJson {

	/**
	 * @param $params
	 */
	private  $params;
	/**
	 * @param $maintable
	 */
	private  $maintable;
	/**
	 * @param $otherFIelds
	 */
	private  $otherFields;
	/**
	 * @param $tables
	 */
	private  $tables;
	/**
	 * @param sqlid
	 * @param params
	 */
	 function execsqlbyid($sqlid,$params) {
        $jsonstring = "";
        if(empty($sqlid) || empty($params)) return $jsonstring;
        if(isset($params['@operatetype']))
        {
            $optype = $params['@operatetype'];
            unset($params['@operatetype']);
        }
		$jsonstring .= '{"self":"'.base64_encode('@execsqlbyid').'","operatetype":"'.base64_encode($optype).'","sql":"'.base64_encode($sqlid).'","params":[';
		foreach($params as $key=>$value) {
			$jsonstring .= '{"name":"'.base64_encode($key).'","value":"'.base64_encode($value).'"},';
		}
		$jsonstring = substr($jsonstring,0,-1);
		$jsonstring .= ']}';
		return $jsonstring; 
	}
	
	/**
	 * @param sqlcls
	 * @param params
	 */
	 function execsqlbycls($sqlid,$params) {
        $jsonstring = "";
        if(empty($sqlid) || empty($params)) return $jsonstring;
        if(isset($params['@operatetype']))
        {
            $optype = $params['@operatetype'];
            unset($params['@operatetype']);
        }
		$jsonstring .= '{"self":"'.base64_encode('@execsqlbycls').'","operatetype":"'.base64_encode($optype).'","sql":"'.base64_encode($sqlid).'","params":[';
		foreach($params as $key=>$value) {
			$jsonstring .= '{"name":"'.base64_encode($key).'","value":"'.base64_encode($value).'"},';
		}
		$jsonstring = substr($jsonstring,0,-1);
		$jsonstring .= ']}';
		return $jsonstring; 
	}

	/**
	 * @param bizid
	 * @param params
	 * @param condition
	 */
	function getdata($bizid,$params,$condition) {
		$jsonstring = "";
		if(empty($bizid)) return $jsonstring;
//		$all = "";
		$paramsStr = "";
		foreach($params as $key=>$value) {
//			$all .= $value.' and ';
			$paramsStr .= ',{"name":"'.base64_encode($key).'","value":"'.base64_encode($value).'"}';
		}
//		if(!empty($all)) $all = substr($all,0,-4);
//		$all .= $condition;
		
		$jsonstring = '{"self":"'.base64_encode('@getdata').'","bizname":"'.base64_encode($bizid).'","params":[{"name":"'.base64_encode('$condition$').'","value":"'.base64_encode($condition).'"}'.$paramsStr.']}';
//		$jsonstring = '{"self":"'.base64_encode('@getdata').'","bizname":"'.base64_encode($bizid).'","params":[{"name":"'.base64_encode($condition).'","value":"'.base64_encode($all).'"}]}';
//		print_r($jsonstring);
		return $jsonstring;
	}

	/**
	+----------------------------------------------------------
	* 新保存方法 - 2013.06.03 by young
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param 
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	public function dealDataNew($bizid,$params,$flowHis=null,$flowName='')
	{
		#首先对所有字段键值进行大写
		$params = $this->doPostUpperOnly($params);
		$data['bizname'] =  $bizid;
		$data['action'] =  $params['ACTION'];
		$data['maintable'] = $this->maintable =  $params['MAINTABLE'];
		$data['self'] =  '@dealdata';
		$data['dealparams'] =  $params['DEALPARAMS'];
        $data['operatetype'] = $params['@OPERATETYPE'];
        if(isset($params['@OPERATETYPE']))unset($params['@OPERATETYPE']);
		$maintables = $params['SUBTABLE'];
		$this->otherFields = array('FIELDS_TABLE','ACTION','MAINTABLE','SUBTABLE','FIELDS_TABLE','FIELDS_ACTION','FIELDS_PK','FIELDS_FK');
		#去掉其他字段
		foreach ($this->otherFields as $item)
		{
			$this->otherFields[$item] = $params[$item];
			unset($params[$item]);
		}
		$this->getSubTableInfo();
		$this->params = $params ;
		#主表
		foreach ($maintables as $key=>$table)
		{
			$t = array();
			$t['table'] = $key; 
			$t['rows'] = $this->getRows($key);//获取当前表所有字段值
			$records[] = $t;
		} 
		#处理action=append
        if(!empty($flowHis))
        {
            if(!empty($flowName)) $flowHis[0]['rows'][0]['NODENAME'] = $flowName;
            $records = array_merge($records,$flowHis);
        }
		
		$data['records'] = $this->isAppendTodelId($records,$this->otherFields['ACTION']);
		$data = $this->doBase64encode($data);//print_r($data);exit;
		return json_encode($data);
	}
	private function doFlowHisSec($flowhis)
	{
		foreach ($flowhis as $key=>$item)
		{
			if(is_array($item))$FH[$key] = $this->doFlowHisSec($item);
			else $FH[$key] = base64_encode($item);
		}
		return $FH;
	}
	private function dealFlowJson($flowhis)
	{
		$flowhis = json_encode($this->doFlowHisSec($flowhis));
		$flowhis = $this->removeJsonBrackets($flowhis);
		return $flowhis ;
	}
	private function removeJsonBrackets($jsonstr)
	{
		$jsonstr = substr($jsonstr,1,strlen($jsonstr)-1);
		$jsonstr = substr($jsonstr,0,-1);
		return $jsonstr;
	}
	/**
	+----------------------------------------------------------
	* 只对键值进行大写
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param $data 需要进行键值大写的数组
	* @param $isIcnov 需要转换值的编码
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	public function doPostUpperOnly($data,$isconv=0)
	{
		if(is_array($data))
		{
			foreach ($data as $key=>$val)
			{	
				if(is_array($val))
				{
					$dataNew[$key] = $this->doPostUpperOnly($val,$isIcnov,$isconv);
				}
				else {
					if($isconv==0)$dataNew[strtoupper($key)] = $val;
					else $dataNew[$key] = $val;
				}
			}
		}
		return $dataNew;
	}
	
	private function getRows($table)
	{
		#如果是主表，可不加模式名与表名
		$params = $this->params ;
		$row = null ;
		if($table==$this->maintable)
		{
			#是否为已加模式名+表名格式
			foreach ($params as $key=>$item)
			{
				if(strpos($key,$table.'-')!==false&&preg_match('/[\w]+@[\w]+-[\w]+/i',$key))
				{
					$fields_len = strpos($key,$table);
					$fields = substr($key,$fields_len);
					#如果为数组，则循环
					if(is_array($item))
					{
						$row = $this->dataFormat($item,$fields,&$row,$table);
					}
					else 
					{
						$row[0][$fields] = $item;
					}
				}
				else 
				{
					if(!in_array($key,$this->otherFields)&&!preg_match('/[\w]+@[\w]+-[\w]+/i',$key))
					{
						if(is_array($item))
						{
							$this->dataFormat($item,$key,&$row,$table);
						}
						else{
							$row[0][$key] = $item;
						}
					}
					
				}
			}
		}
		else 
		{
			foreach ($params as $key=>$item)
			{
				if(strpos($key,$table)!==false&&preg_match('/[\w]+@[\w]+-[\w]+/i',$key))
				{
					$fields_len = strlen($table);
					$fields = substr($key,$fields_len+1);
					#如果为数组，则循环
					if(is_array($item))
					{
						$this->dataFormat($item,$fields,&$row,$table);
					}
					else 
					{
						$row[0][$fields] = $item;
					}
				}
			}
		}
		#从表
		
		$row = $this->dataSubTables($table,$this->otherFields['SUBTABLE'],$row);
		return $row ;
	}
	private function filterKey($filter)
	{
		foreach ($this->params as $k=>$item)
		{
			if(preg_match('/[\w]+@[\w]+-([\w]+)/i',$k,$keys))$key = $keys[1];
			else $key = $k;
			if($filter!='')
			{
				if ($key==$this->tables[$table]['FK'])
				{
					$filter_key[] = $key;
				}
			}
			else $filter_key[] = $key;
		}
		return $filter_key;
	}
	private function dataFormat($item,$key,$row,$table)
	{
		foreach ($item as $fields_key=>$fields_value)
		{
			$row[$fields_key][$key] =  $fields_value;
		}
		
		return $row;
	}
	private function getSlaveRows($table,$filter)
	{
		$params = $this->params ;
		$row = null ;
		foreach ($params as $key=>$item)
		{
			if(strpos($key,$table)!==false&&preg_match('/[\w]+@[\w]+-[\w]+/i',$key))
			{
				$fields_len = strlen($table);
				$fields = substr($key,$fields_len+1);
				#如果为数组，则循环
				if(is_array($item))
				{
					foreach ($item as $item_key=>$item_value)
					{
						if($fields==$this->tables[$table]['FK']&&$filter==$item_value)
						{ 
							$filter_key[$item_key] = $item_key;
						}
					}
				}
			}
		}
		foreach ($params as $key=>$item)
		{
			if(strpos($key,$table)!==false&&preg_match('/[\w]+@[\w]+-[\w]+/i',$key))
			{
				$fields_len = strlen($table);
				$fields = substr($key,$fields_len+1);
				#如果为数组，则循环
				if(is_array($item))
				{
					foreach ($item as $fields_key=>$fields_value)
					{
						if(in_array($fields_key,$filter_key))$row[$fields_key][$fields] =  $fields_value;
					}
				}
			}
		} 
		return $row;
	}
	private function dataSubTables($table,$subtables,$row)
	{
		$row = array_values($row);
		//$subtables = $this->otherFields['SUBTABLE'];
		$params = $this->params;
		if(count($subtables[$table]['slave'])>0)
		{ 
			$slave = $subtables[$table]['slave'];
			foreach ($slave as $slave_table=>$slave_tables)
			{
                
				$fk = $slave_table.'-'.$slave[$slave_table]['FK'];
				
				foreach ($row as $key=>$item)
				{ 
                    $slave_table_arr['table']=$slave_table;
                    $slave_table_arr['rows'] = array();
					if(is_array($params[$fk]))
					{
						foreach ($params[$fk] as $fk_value)
						{ 
                            
							if ($item[$this->tables[$table]['PK']]==$fk_value)
							{
 									
 								$filter = $fk_value;
 								$slave_row =$this->getSlaveRows($slave_table,$filter);		
								$slave_table_arr['rows'] = $this->dataSubTables($slave_table,$slave,$slave_row);
								$row[$key]['slave'][]=$slave_table_arr;
								break;				
							}
						}
					}
                    else $row[$key]['slave'][]=$slave_table_arr;
				}
                
			}
			
		} 
		return $row;
	}
	
	private function getSubTableInfo($subtables=null)
	{
		$subtables = $subtables==null ? $this->otherFields['SUBTABLE'] : $subtables ;
		foreach ($subtables as $k=>$value)
		{
			if(isset($value['slave']))$this->getSubTableInfo($value['slave']);
			$this->tables[$k]['PK'] = $value['PK'];
			$this->tables[$k]['FK'] = $value['FK'];
			if(empty($value['PK']))$this->jsonErro('表'.$k.'PK未配置');
		}
	}
	
	private function isAppendTodelId($data,$append=false)
	{
		//if($append=='append')
		//{
			foreach ($data as $key=>$item)
			{
				if(is_array($item))
				{
					foreach ($item as $item_key=>$item_value)
					if($item_key='table')
					{
						foreach ($data[$key]['rows'] as $ikey=>$ivalue)
						{
							foreach ($ivalue as $fields=>$value)
							{
								if($fields==$this->tables[$item_value]['PK']||$fields==$this->tables[$item_value]['FK'])
								{ 
									if($append=='append'||$data[$key]['rows'][$ikey][$fields]<=0)$data[$key]['rows'][$ikey][$fields] = '';
								}
								else if($fields=='slave')
								{
									$data[$key]['rows'][$ikey][$fields] = $this->isAppendTodelId($data[$key]['rows'][$ikey][$fields],$append);
								}
							}
						}
					}
				}
				
			}
		//}

		return $data;
	}
	private function doBase64encode($data)
	{
		foreach ($data as $key=>$item)
		{
			if(is_array($item))
			{
				$data[$key] = $this->doBase64encode($data[$key]);
			}
			else{
				if($key=='table'||$key=='maintable')
				{
					$item = str_replace("@",'.',$item);
				}
				$data[$key] = base64_encode($item);
			}
		}
		return $data;
	}
	private function jsonErro($msg)
	{
		echo $msg;exit;
	}
	
}
?>