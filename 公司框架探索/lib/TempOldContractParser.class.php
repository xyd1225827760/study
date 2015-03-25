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
Class TempOldContractParser
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



	public function getPairContractData($name)
	{
		$arrReturn = array();

		$this->parseXmlFromStr($name);
		$data = $this->document['root'][0]['fields'][0]['field'];
		//print_r($data);
		for($i = 0, $m=sizeof($data)/2; $i<$m; $i++)
		{
			//echo $data["{$i} attr"]['name'];
			$arrReturn[$data["{$i} attr"]['name']] = $data[$i];
		}
		
		return $arrReturn;
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
           //$this->parent = iconv("GBK", "UTF-8", $this->data);
		    $this->parent = $this->data;
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