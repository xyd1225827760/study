<?php
/**
 * 解析 Biz XML
 *
 * @copyright   Copyright: 2010
 * @author      庄飞<27834252@qq.com>
 * @package     CandorPHP
 *
 * 使用说明
 ×
 × 将XML转换成方便识别的数组；
 * $this->getBizArray($wsXml, $type = [query, Biz]);
 ×
 × 将 $this->getBizArray 的解析结果， 按要求转换成二维数组；
 * $this->getGridArray($this->tables, [主表名 or array(需要的主从表字段)]， [从表字段中的链接符默认为逗号]);
 */
Class BizXmlParser
{
	#解析器 object
	private  $parser;

	#结果 array()
	private  $document;

	#
	private  $parent;

	#堆栈
	private  $stack;
	
	#最后的TAG 
	private	 $lastOpenedTag;

	#记录解析结果中所有的表; array();
	public  $tables;

	#记录
	private $grid;

	public function __construct()
	{
    }

	public function destruct()
	{ 
		xml_parser_free($this->parser); 
	}

	/**
	* 将XML转换成方便识别的数组；
	*
	* @param $xml String 要解析的XML
	* @param type string 解析类型   [biz{Model@Table-Field 索引}, query{数字索引}]
	**/
	public function getBizArray($xml, $type = "biz")
	{
		$this->parseXmlFromStr($xml);

		$nums = 0;
		$data = $tables = $subTables = array();

		$nums = count($this->document['root'][0]['table'])/2; #表数量
		$data = $this->document['root'][0]['table'];		  #所有要解析的数据

		#存放解析结果；
		$this->tables = array();

		#如果数据返回成功，则遍历所有表
		if($nums > 0)
		{
			for($i=0; $i<$nums; $i++)
			{
				#取得当前信息；
				$table  = array(
					"key" => $data[$i]["pk"][0], 
					"name"=> str_replace(".", "@", $data["{$i} attr"]["id"])
					);

				#初始主表信息
				$parent = array();
				
				#如果是从表
				if(isset($data[$i]['fk'][0]['parent'][0]))
				{	
					$parent = array(
						"key"=>$data[$i]['fk'][0]['parentid'][0], 
						"name"=>str_replace(".", "@", $data[$i]['fk'][0]['parent'][0])
						);
				}

				#数据格式
				#$this->tables["{$parentTable}-PK_ID"]["SUBTABLE_{$tableName}"]["{$tableName}-PK_ID"]['RECORD'];
				$this->getTable($type, $data[$i], $table, $parent);

				#取得表结构
				$this->getTableStruct($data[$i]['meta'][0]['field'], $table);
			}

			$this->tables['ISSUCCESS'] = "YES";
		}
		else
		{
			#拆分空的返回数组
			foreach($this->document['root'][0] as $key=>$val) $this->tables[strtoupper($key)] = $val;



			if(!$this->tables['ISSUCCESS'] || empty($this->tables['ISSUCCESS'])) $this->tables['ISSUCCESS'] = "NO";
		}
		
		return $this->tables;
	}



	/**
	* 取得表结构
	*
	* @data array 表的Meta信息 table[$i]['meta'][0]['field']			
	* @info array 表信息（主键及表名）table => array("name" => $tableName); 
	*/
    private function getTableStruct($data, $info)
	{
		$struct	= array();

		for($i=0, $m=count($data) /2; $i<$m; $i++)
		{
			$struct[] = $data["{$i} attr"]['name'];
		}

		$this->tables['TABLESTRUCT'][$info['name']] = $struct;
	}  

	/**
	* 根据相应条件返回对应的表信息；
	* 
	× @param array  结果数组
	* @param array	过滤对应的字段
	×               array("model@table"=>array("field", "field"), ... n);
	×        string 返回指定的表
	**/
	public function getGridArray($array, $cond, $split = ",")
	{
		$tableName = $fieldName = "";

		if(is_array($cond))
		{
			$mainFields = $subFields  = $data = array();
			
			#分离主从表字段；
			foreach($cond as $key)
			{
				$tableName = substr($key,0,strpos($key,'-'));
				$fieldName = substr($key,strpos($key,'-')+1);
				
				#如果有指定的表名
				if(isset($array[$tableName]))
				{
					$mainFields[$key]	= $key;
					$mainTable			= $tableName;
				}
				else $subFields[$tableName][$key] = $key;
			}
			
			#如果不存在主表， 返回空数字；
			if("" == $mainTable) return array();

			#遍历主表记录
			foreach($array[$mainTable] as $mainRow)
			{
				$record = array();

				#根据索引计算交集
				$record = array_intersect_key($mainRow['RECORD'], $mainFields);
				
				#处理从表
				if(!empty($subFields))
				{
					#如果有1或多个从表， 遍历从表信息
					foreach($subFields as $subTableName => $subTableFields)
					{
						$subTableIndex = "SUBTABLE_" . $subTableName;

						#如果存在从表信息
						if(isset($mainRow[$subTableIndex]))
						{
							#遍历从表记录；
							foreach($mainRow[$subTableIndex] as $subKey=>$subRow)
							{
								#检查记录中的所需的字段；
								foreach($subTableFields as $subFieldIndex)
								{
									if(isset($subRow['RECORD'][$subFieldIndex]))
									{
										if(isset($record[$subFieldIndex])) $record[$subFieldIndex] .= $split;
										$record[$subFieldIndex] .=  $subRow['RECORD'][$subFieldIndex];
									}
								}
							}
						}
					}
				}

				#将数据记录到表格；
				$this->grid[] = $record;
			}
			return $this->grid;
		}
		elseif(is_string($cond))
		{
			foreach($array as $table => $value)
			{
				#存在指定的主表
				if($table == $cond)
				{
					foreach($value as $row) $this->grid[] = $row['RECORD'];
					return $this->grid;
				}
			}
		}
		
		return array();
	}

	/**
    * 生成[单表table数组]
    * @access private 
    * @param array  $data		单张表的数组	
	* @param array  $parent		主表信息（主键及表名）
	* @param array  $table		从表信息（主键及表名）
    * @param String $type       取得xml数据的方式【query，biz】	
    * @return array $xmlData(row)的数组
	*
	* 数据格式
	* $this->tables["mainTableName"]["{$parentTable}-PK_ID"]["SUBTABLE_{$tableName}"]["{$tableName}-PK_ID"]['RECORD'];
    **/
	private function getTable($type, $data, $table, $parent = array())
	{
		$record = array();

		#用于从从表中分别取得自己的主键值的索引
		$currentRecordIndex=  "{$table['name']}-{$table['key']}";
		$parentRecordIndex =  "{$table['name']}-{$parent['key']}";			
		
		#标识各记录的索引前缀；
		$parentSign	 = "{$parent['name']}-{$parent['key']}"; #=$parentTable-PK
		$currentSign = "{$table['name']}-{$table['key']}";   #=$tableName-PK

		#遍历所有记录
		for($i=0, $m = sizeof($data['row'])/2; $i<$m; $i++)
		{
			# 取得每行的数据
			$record	= $this->getRecord($data['row'][$i],$table['name'],$type); 
			
			#type == query 时， 表没有主从关系， 以数字索引生成；
			$currentIndex	=  "query"==$type ? $i : "{$currentSign}_{$record[$currentRecordIndex]}";
			$parentIndex	=  "{$parentSign}_{$record[$parentRecordIndex]}";
	
			#数据来自从表
			if("query" == $type or empty($parent))
			{
				$this->tables["{$table['name']}"][$currentIndex]['RECORD'] = $record;
			}
			else
			{
				$this->tables["{$parent['name']}"][$parentIndex]["SUBTABLE_{$table['name']}"][$currentIndex]['RECORD'] = $record;
			}
		}
	}
	

	/**
    * 转换TABLE中的每一条数据
	* 
    * @access private 
    * @param array  $record		每行数据的数组
	* @param String $tableName  当前操作的表名
	* @param String $type		取得xml数据的方式【query，biz】
    * @return array $行数据的数组
    **/
	private function getRecord($record, $tableName, $type)
	{
		$return	= array();
		$field	= "";
		$tableName	= ("query" == $type) ? "EXECQUERY" : $tableName;

		for($i=0, $m=count($record["field"]) /2; $i<$m; $i++)
		{
			$field = $record["field"]["{$i} attr"]["name"];
			$return["{$tableName}-{$field}"] = $record['field'][$i];
		}

		return $return;
	}
	
	/**
	* 初始化解析器
	*/
	private function initParser()
	{		
		$this->document = array();    
        $this->stack    = array();    
		$this->tables	= array();

        $this->parser = xml_parser_create();    
        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);    
        xml_set_object($this->parser, $this);    
        xml_set_element_handler($this->parser, 'startElement','endElement');    
        xml_set_character_data_handler($this->parser, 'characterData');    
	}

	/**
	 * 
	 * @param dataUrl
	 */
	public function parseXmlFromUrl($dataUrl)
	{
		$this->initParser();
        $this->parent   =&$this->document; 
		$filehandler = fopen($dataUrl, "r");	
		while ($idata = fread($filehandler, 4096)) {
			xml_parse( $this->parser, $idata, feof($filehandler));
	    }
		fclose($filehandler);
		$this->destruct();
	}

	/**
	 * 
	 * @param dataStr
	 */
	public function parseXmlFromStr($dataStr)
	{  
		$this->initParser();
        $this->parent   = &$this->document; 		
		xml_parse( $this->parser, $dataStr, true);		
		$this->destruct();	
	}


	/**
	 * @param parser
	 * @param tag
	 * @param attributes
	 */
	private function startElement(&$parser, $tag, $attributes)
	{
		$this->data          = '';			#存储临时数据
        $this->lastOpenedTag = $tag;        #当前的标签

		if(isset($this->parent[$tag]) && is_array($this->parent[$tag]) && array_key_exists(0,$this->parent[$tag]))
		{
			# 如果 $this->parent[$tag] 这个数组存在， 并且存在索引 0 计算 Key；
			# 这里为 $tag 生成第三个或更多索引；
			# if the keys are numeric   
			# this is the third or later instance of $tag we've come across    
			$key = $this->countNumericItems($this->parent[$tag]);    
		}
		else
		{   
			#如果 $this->parent[$tag]不存在 ;
			#this is the second instance of $tag that we've seen. shift around   
			/*
			if(is_array($this->parent)) $this->parent=$this->parent;
			else $this->parent=array($this->parent);
			*/	
			if((is_array($this->parent) || is_object($this->parent)) && array_key_exists("$tag attr",$this->parent)){   
				$arr = array('0 attr'=>&$this->parent["$tag attr"], &$this->parent[$tag]);   
				unset($this->parent["$tag attr"]);   
			}else{   
				$arr = array(&$this->parent[$tag]);
				$key = 0;   
			}   
			$this->parent[$tag] = &$arr;   
		  
		}   
        $this->parent = &$this->parent[$tag];   
        
        if($attributes)
		{
         	$this->parent["$key attr"] = $attributes;   
        }
		else
		{
        	$this->parent["$key attr"] = "";   
        }
        $this->parent  = &$this->parent[$key];   
        $this->stack[] = &$this->parent;
	}

	/**
	 * 
	 * @param parser
	 * @param data
	 */
	private function characterData(&$parser, $data)
	{
		if($this->lastOpenedTag != NULL) { 
            $this->data .= $data; 
		}
	}

	/**
	 * 
	 * @param parser
	 * @param tag
	 */
	private function endElement(&$parser, $tag)
	{
		if($this->lastOpenedTag == $tag)
		{  
			#结束后对标签进行解码
            $this->parent = iconv("GBK", "UTF-8", base64_decode($this->data));
            $this->lastOpenedTag = NULL;    
        }    
        array_pop($this->stack);

        if($this->stack) $this->parent = &$this->stack[count($this->stack)-1];
	}

	/**
	 * 
	 * @param array
	 */
	private function countNumericItems(&$array)
	{
		# 是否是数组？ 统计数字的索引 ： 0；
		return is_array($array) ? count(array_filter(array_keys($array), 'is_numeric')) : 0;
	}
}
?>