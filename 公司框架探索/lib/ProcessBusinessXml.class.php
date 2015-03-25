<?php
/**
 * Created on 2009-5-21 
 * 解析后台xml到前台需要的各种数据格式
 * @since webframes
 * @author luojun
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: ProcessBusinessXml.class.php,v 1.2 2012/04/01 02:02:20 lj Exp $
 */

 /*******************************************新框架测试代码段【FOR QUERY】*****************************************/
        //echo htmlspecialchars($tmpResXml);
        /*$bizArray=$opXml->xml2BizArray($tmpResXml,'query');
		$tableArr=$opXml->getTableArray($bizArray,'EXECQUERY',$pk);
		//print_r($bizArray);
		$vJson=$opXml->getTableJson($tableArr);*/
/*******************************************新框架测试代码段*********************************************************/

/***************************************新框架测试代码段【FOR BUSINESS】****************************************/
		  /*$bizArray=$opXml->xml2BizArray($xmlData);
		  $showFields['POLITICAL.WGQYZZHD-C_NAME']='rule';
		  $showFields['POLITICAL.WGQYPEPOLE-NAME']='rule';
		  $showFields['POLITICAL.WGQYZZHD-C_TYPE']='rule';
		  //$tableArr=$opXml->getTableArray($bizArray,'POLITICAL.WGQYZZHD',$pk); //当system.xml的field属性是字段名，传tableid属性值为形如：'POLITICAL.WGQYZZHD'；
		  $tableArr=$opXml->getGridArray($bizArray,$showFields,$pk);   //当system.xml的field属性是表名-字段名
		  //print_r($tableArr);
		  $vJson=$opXml->getTableJson($tableArr);
		  echo 	$vJson;	 */
 /***************************************新框架测试代码段*****************************************************/

new Xml2Array();

class ProcessBusinessXml{  
    //从后台取回的每个表的字段数组
    public $columnIds=array();	public $columnIds1=array();
    //该业务的主键
    public $pKey;
	//该次解析的主gird总数
    public $tRows=0;
	//该次解析的STARTID
    public $STARTID;	
	//该次解析的ENDID
    public $ENDID;
	//表的字段结构，索引为表名，值为字段名数组
	public $tbStructs;
   /**
    * 根据已知路径生成XML数组
    * @access public 
    * @param string $url  xml的路径
    * @return array 返回XML数组
    */ 
   public function getXmlArrayFromUrl($url){  
		//session_start();
		$xmlArr;
		
		//echo "getXmlArrayFromUrl...";
		if(strpos($url,"System_")!==false){
			if(empty($_SESSION['SYSTEMXML_CONFIG'])){
				$xmlArr=XML_unserializeFromUrl($url);
				$_SESSION['SYSTEMXML_CONFIG']=$xmlArr;
			}
			else{
				$xmlArr=$_SESSION['SYSTEMXML_CONFIG'];
			}
			//print_r($xmlArr);
		}
		else{
			$xmlArr=XML_unserializeFromUrl($url);
		}
		
       //echo "  getXmlArrayFromUrl ok";
	    //$xmlArr=XML_unserializeFromUrl($url);
        return $xmlArr;
   }
   
   public function getXmlArrayFromStr($xmlContent){       		
        $xmlArr=XML_unserializeFromStr($xmlContent);
        return $xmlArr;
   }

   public function getXmlArrayFromUTFStr($xmlContent){        
		$xmlContent=iconv("UTF-8","GBK",$xmlContent);
        $xml = $xmlContent; 		
        $xmlArr=XML_unserializeFromStr($xml);
        return $xmlArr;
   }
   /**
    * 根据System.XML配置 创建要显示列表的表头
    * @access public 
    * @param array $xml  System.xml的路径
	* @param array $id   业务ID
    * @param array $tableID   要处理的tableID	
    * @return array 列数组
    */
    public function buildHeaderColumnsFromUrl($url,$bid,$tableID){
        $BBiz=$this->getXmlArrayFromUrl($url);
        $bbizArr=$BBiz['root']['0']['business'];		
		//取相应的business数组
		$businessArray=array();
		$businessSize=count($bbizArr)/2;
        for($i=0;$i<$businessSize;$i++){
            $bbizID=$bbizArr[$i.' attr']['id'];
			if(empty($tableID)){
				if($bid==$bbizID){
					$businessArray=$bbizArr[$i];
					break;
				}else{
					continue;
				}
			}else{
				if($bid==$bbizID && $tableID==$bbizArr[$i.' attr']['tableID']){
					$businessArray=$bbizArr[$i];
					break;
				}else{
					continue;
				}
			}
        }
        $fieldSize=count($businessArray['field'])/2;
        $fieldIDArr=array();
		$fieldArr=array();		
        for($j=0;$j<$fieldSize;$j++){  
			//if($businessArray['field'][$j.' attr']['hidden']!="yes"){//缺省情况下hidden为no
				array_push($fieldIDArr,$businessArray['field'][$j.' attr']['name']);
				$fieldValue=array();
				//print_r($businessArray['field'][$j.' attr']);
				$fieldValue[]=$businessArray['field'][$j.' attr']['title'];
				$fieldValue[]=$businessArray['field'][$j.' attr']['width'];
				$fieldValue[]=$businessArray['field'][$j.' attr']['hidden'];
				if(empty($businessArray['field'][$j.' attr']['mapping'])){
					$theSqlid=str_replace(".","@",$tableID);
					$fieldValue[]=str_replace('EXECQUERY',$theSqlid,$businessArray['field'][$j.' attr']['name']);
				}else{
					$fieldValue[]=$businessArray['field'][$j.' attr']['mapping'];
				}
				array_push($fieldArr,$fieldValue);
			//}
        }
		//print_r($fieldArr);
        $columnsArr=array_combine($fieldIDArr,$fieldArr);	 
		//print_r($columnsArr);
        return $columnsArr;
	   
    }



   /**
    *  根据后台返回的业务XML URL返回table数组
    * @access public 
    * @param string $url  业务XML url
    * @return array $xmlData(row)的数组
    */
   public function getTableArrayFromUrl($url){
           $xmlArray=$this->getXmlArrayFromUrl($url);            
           $tableData = $xmlArray['root']['0']['table']; 		  
           $this->pKey=base64_decode($tableData['0']['pk']['0']); 
           return $tableData;
   
   }

   /**
    *  根据传入的数组取出指定的列
    * @access public 
    * @param string $arr  传入数组
	* @param string $index  要取的列的索引
    * @return array 
    */
	public function getSpecialColumn($arr,$index){   
		$returnArr=array();
		while (list($ind, $val) = each($arr)) {			
			$temArr=$val;
			if($index==2){
				array_push($returnArr,$val[$index]);
			}else{
				if(empty($val[2]) || $val[2]=="no"){
					array_push($returnArr,$val[$index]);
				}
			}
			//print_r($val);
		}
		return  $returnArr;
	}
     /**
    *  根据指定的xml配置文件和相应的要读取的表读取该该表的属性值(query 单表数据)
    * @access public 
    * @param string $url  system.xml	
	* @param string $tableName 表名
    * @return array 表的属性的数组
    */
   public function getTableAttributes($url,$bid,$tableName){
		$BBiz=$this->getXmlArrayFromUrl($url);
        $bbizArr=$BBiz['root']['0']['business'];	
		//print_r($bbizArr);
		//取相应的business数组
		$businessArray=array();
		$businessSize=count($bbizArr)/2;
        for($i=0;$i<$businessSize;$i++){
            $bbizID=$bbizArr[$i.' attr']['id'];
			//echo "bbizID:".$bbizID." bid:".$bid." tableName:".$tableName."<br/>";
			if(empty($tableName)){
				if($bid==$bbizID && "yes"==$bbizArr[$i.' attr']['maingrid']){
					$businessArray=$bbizArr[$i .' attr'];
					break;
				}else{
					continue;
				}
			}else{
				if($bid==$bbizID && $tableName==$bbizArr[$i.' attr']['tableID']){
					$businessArray=$bbizArr[$i.' attr'];
					break;
				}else{
					continue;
				}
			}
        }	
		if(empty($tableID)){
			$tableName=$businessArray['tableID'];
		}
		return $businessArray;
   }

   /**
    * 根据后台返回的业务XML字符串返回的table数组
    * @access public 
    * @param string $xmlData  业务XML字符串	
	* @param String $qType   取得xml数据的方式【query，biz】
    * @return array $xmlData(row)的数组
    */
   public function xml2BizArray($xmlData,$qType){
       $xmlArray=$this->getXmlArrayFromStr($xmlData);
	   
	   $tablenum=count($xmlArray['root'][0]['table'])/2;   //统计返回的xml是几张表的数据
	   $tablesData=$xmlArray['root'][0]['table']; 
	   
	   $tablesArr=array();   //主表名数组
	   $subtablesArr=array();   //从表名数组
	 			  // print_r($tablesData);  
	   if($tablenum>0){
		   for($i=0;$i<$tablenum;$i++){
			   $tablenames=$tablesData[$i.' attr']['id'];  //xml包含的所有表名的数组
			   $tablenames=str_replace('.','@',$tablenames);	  //modify by luojun 2009-8-21
			   @$parentTab=base64_decode($tablesData[$i]['fk'][0]['parent'][0]);  //取得该表的【父亲表】
			   $parentTab=str_replace('.','@',$parentTab);
			   //print_r($tablesData[$i]['meta']);
			   if(empty($parentTab)){                   //应该判断当返回的xml里面有多个主表部分无从表得情况
				   $tablesArr+=$this->setSingleTableArr($tablesData[$i],$tablenames,'',$qType);
			   }else{
				   if(array_key_exists($parentTab,$tablesArr)){
					   for($j=0;$j<count($tablesArr[$parentTab]);$j++){
						  $idxarr=array_keys($tablesArr[$parentTab]);
						  $idx=$idxarr[$j];$mainPk=substr($idx,0,strpos($idx,'_'));
						  $fkVal=$tablesArr[$parentTab][$idx]['RECORD'][$mainPk];
						  $subtablesArr=$this->setSingleTableArr($tablesData[$i],$tablenames,$fkVal,$qType);
						  $tablesArr[$parentTab][$idx]+=$subtablesArr;
					   }
				   }			   
			   }
			   $tablesArr['ISSUCCESS']='YES';
		   }
	   }else{
//		   print_r($xmlArray);exit;
	      $errorArr=$xmlArray['root'][0];
		  foreach($errorArr as $errKey=>$errVal){
		      $tablesArr[strtoupper($errKey)]=iconv('gbk','utf-8',base64_decode($errVal[0]));
		  }
		  if(empty($tablesArr['ISSUCCESS'])) $tablesArr['ISSUCCESS']='NO';
	   }
		 $tablesArr['TABLESTRUCT']=$this->getTableStruct($tablesData,$qType);  //ADD BY LUOJUN 2009-7-20

		 //print_r($tablesArr['TABLESTRUCT']);
		 //echo 'aaaaa';
	   return $tablesArr;

   }

   /**
    * 生成[单表table数组]
    * @access private 
    * @param array $tableData  单张表的数组	
	* @param String $tablename  单张表的表名
    * @param String $qType   取得xml数据的方式【query，biz】	
    * @return array $xmlData(row)的数组
    **/
    private function setSingleTableArr($tableData,$tablename,$fkVal,$qType){
		$tableArr=array();
		$tabPK=base64_decode($tableData['pk'][0]);                   //取得该表的【主键名】
		@$tabFK=base64_decode($tableData['fk'][0]['parentid'][0]);    //取得该表的【外键】
		$tabFK=$tablename.'-'.$tabFK;
		@$parentTab=base64_decode($tableData['fk'][0]['parent'][0]);  //取得该表的【父亲表】
		$records=count($tableData['row'])/2;
		for($i=0;$i<$records;$i++){
			   $tmpRecs=array();
    		   $record=$this->setSingleRecord($tableData['row'][$i],$tablename,$qType); //每行的数据
			   if(!empty($parentTab)){
				   if($record[$tabFK]==$fkVal) $tmpRecs['RECORD']=$record;
			       else continue;
			   }else $tmpRecs['RECORD']=$record;			   
				if($qType=='query') $tmpTableArr[$i]=$tmpRecs;
				//else $tmpTableArr[$tabPK.'_'.$record[$tabPK]]=$tmpRecs;     //构成以键名_主键值为KEY的数组  
			    else $tmpTableArr[$tablename.'-'.$tabPK.'_'.$record[$tablename.'-'.$tabPK]]=$tmpRecs;     //构成以键名_主键值为KEY的数组  
		}
		if(empty($parentTab)) $tableArr[$tablename]=$tmpTableArr;   //empty($parentTab)表明此次操作是主表
		else $tableArr['SUBTABLE_'.$tablename]=$tmpTableArr;		//表明此次操作是从表

		return $tableArr;
	}

   /**
    * 生成表table得[每行数据]
    * @access private 
    * @param array $recordData  每行数据的数组
	* @param String $qType   取得xml数据的方式【query，biz】
    * @return array $行数据的数组
    **/
	private function setSingleRecord($recordData,$tablename,$qType){
		global $config;
		$returnRec=array();
	    $fieldnum=count($recordData['field'])/2;
$replace = array();
		for($a=0;$a<$fieldnum;$a++){
			
		     $fieldName=$recordData['field'][$a.' attr']['name'];
			 if($qType=='query'){
				 $fieldVal=iconv('gbk','utf-8',base64_decode($recordData['field'][$a]));
				 $tablename='EXECQUERY';
			 }else{
				 $fieldVal=iconv('gbk','utf-8',base64_decode($recordData['field'][$a]));
			 }
			 $returnRec[$tablename.'-'.$fieldName]=$fieldVal;

			 /**2011-5-27 仅为家庭成员特殊汉字无法显示临时添加*/
			 if(in_array("{$tablename}-{$fieldName}",$config->specailNameKey) 
				 && in_array("{$fieldVal}", array_keys($config->specailNameDic["{$tablename}-{$fieldName}"]))) 
			{
				 $replace = $config->specailNameDic["{$tablename}-{$fieldName}"][$fieldVal];
			}
			/**2011-5-27 仅为家庭成员特殊汉字无法显示临时添加*/

			 //$returnRec[$fieldName]=$fieldVal;
		}
		!empty($replace) && $returnRec[$replace[1]] = $replace[0];#2011-5-27 仅为家庭成员特殊汉字无法显示临时添加

		return $returnRec;
	}


   /**
    * 取的指定表的表结构
	* @create on 2009-7-20 by luojun
    * @access public  
    * @param array $xmlArrs  xml的数组结构	
	* @param String $showFields 页面字段来源表名	
    * @return array $xmlData(row)的数组
    **/
    private function getTableStruct($xmlArrs,$qType){
		if($qType=='biz'){
			$tableStructs = array();
			$tbCnt=count($xmlArrs)/2;
			for($i=0;$i<$tbCnt;$i++){     //循环表的数量
				$fldArrs = array();
				$tablename=$xmlArrs[$i.' attr']['id'];   //表名
				$tablename=str_replace('.','@',$tablename);
				$flds=$xmlArrs[$i]['meta'][0]['field'];	  //xml字段结构
				$fldCnd=count($flds)/2;
				for($j=0;$j<$fldCnd;$j++)				   //字段的数量
				     array_push($fldArrs,$tablename.'-'.$flds[$j.' attr']['name']);
				
				$tableStructs[$tablename]= $fldArrs;   //生成以表名为数组索引，字段名为值的数组
			}				 
		}
		
		return $tableStructs;
	}  

   /**
    * 保存数据同时往已有的session数组操作记录
    * @access public 
    * @param array $recordXml  记录数据的xml	
    * @return array $bizArray
    **/
	public function operRecords($recordXml,$lastappendid){
		$returnRec=$this->getXmlArrayFromUTFStr($recordXml);
		$recTable=$returnRec['root'][0]['table'];
		$bizz=$returnRec['root']['0 attr']['business'];
		for($i=0;$i<count($recTable)/2;$i++){
            $action=$recTable[$i.' attr']['action'];                        //每个表的操作类型
			$tablename=$recTable[$i.' attr']['id'];                         //每个表的表名称
			switch($action){
			   case 'append' : $tmpStr=$this->addRecord($recTable[$i],$tablename,$bizz);break;
			   case 'update' : $tmpStr=$this->updRecord($recTable[$i],$tablename,$bizz);break;
			   case 'delete' : $tmpStr=$this->delRecord($recTable[$i],$tablename,$bizz);break;
			   case 'delete_append' : $tmpStr=$this->updRecord($recTable[$i],$tablename,$bizz);
			   default : '传入的xml未加action属性，请联系管理员';break;
			}
	    }
		return $tmpStr;
	}


   /**
    * 新增一条记录，往session添加一条biz记录
    * @access private 
    * @param array $recordXml  每条记录数据的xml	
    * @return array $bizArray
    **/
	private function addRecord($recTable,$tablename,$bizz){
		return $returnRec;
	}


   /**
    * 修改一条记录，往session修改一条biz记录
    * @access private 
    * @param array $recordXml  每条记录数据的xml	
    * @return array $bizArray
    **/
	private function updRecord($recTable,$tablename,$bizz){
		if(empty($_SESSION['xmlData_'.$bizz])){
		   $returnRec=$tablename.'=系统未取得session，联系管理员！'.$bizz;
		}else{
		   $returnRec=(count($recTable['row'])/2).$tablename.'=操作的bizz的名称：'.$bizz;
		}
		return $returnRec;
	}


   /**
    * 删除一条记录，往session删除一条biz记录，暂时不考虑
    * @access private 
    * @param array $recordXml  每条记录数据的xml	
    * @return array $bizArray
    **/
	private function delRecord($recordXml){
		return $returnRec;
	}


   /**
    * 通过传入的条件生成每个表的【数组】数据，便于在页面显示
    * @access public 
    * @param array $bizArr  后台返回的biz的数组数据
    * @param array $tablename  表名称
    * @param array $pk   需要得出数据的条件  可以为空（显示maingrid）	
    * @return array $tableArr  返回单个表的数组数据
    **/
	public function getTableArray($bizArr,$tablename,$pk,$subPk=''){
        $tableArr=array();
		//print_r($bizArr);
		foreach($bizArr as $key=>$value){
		   $keyarr=array_keys($value);
		   $tmpKey=substr($keyarr[0],0,strpos($keyarr[0],'_'));       //取的主键名称		   
		   if($key==$tablename){                 //判断当传入的tablename等于biz数组主表或者等于与主表同级得表名
     		  if(!empty($pk)) 
				  $tableArr[$tmpKey.'_'.$pk]=$value[$tmpKey.'_'.$pk];//如果传入主键ID，就只能取改ID下的record 
			  else   $tableArr=$value;//返回该表的数组数据
			  break;
		   }else{                                //获取子表信息
			 if(!empty($pk)){      //当传入了具体条件才能取到某条件下得子表数据比如：父表的主键值
			 //print_r($pk);
				  foreach($value as $subkey=>$subval){
					  if(!empty($subPk)){
					     if(array_key_exists('SUBTABLE_'.$tablename,$subval)){
						     foreach($subval['SUBTABLE_'.$tablename] as $sbkeyname=>$sbkeyval){
							    $tmpKey= substr($sbkeyname,0,strpos($sbkeyname,'_'));       //取的主键名称
                                if($tmpKey.'_'.$subPk==$sbkeyname){
								  $tableArr[$sbkeyname]=$subval['SUBTABLE_'.$tablename][$sbkeyname];
								  break;
								}
							 }
						 }
						 break;
					  }
					  //if($subval['RECORD']['CQWEB@CQLICENCE-ID']==115) print_r($subval['RECORD']);
					  if(array_key_exists('SUBTABLE_'.$tablename,$subval)&&(trim($subkey)==trim($tmpKey.'_'.$pk))){   
						 $tableArr=$subval['SUBTABLE_'.$tablename];
					  }
				  }
			 }else break;
		   }
		}
		return $tableArr;
	}


   /**
    * 根据已知的表得数据构造出相应的json数据格式
    * @access public getJsonData($tableArr,$cnd)
    * @param array  $tableArr  表的数组
    * @param string $cnd        需要的结果的条件
    * @return string  $jsonstr  表的json字符串
    */
    public function getTableJson($tableArr,$cnd=''){
		//print_r($tableArr);
	   $jsonstr='{root:[';
	   if(empty($tableArr))  return '{root:[]}'; 
	   $this->tRows=count($tableArr);
       if(empty($cnd)){
            foreach($tableArr as $key=>$val){
				$jsonstr.='{';$data='';
				foreach($val['RECORD'] as $sKey=>$sVal){
				   $data.='"'.$sKey.'":"'.$this->replce_bizstr($sVal).'",';
				}
				//$this->columnIds=array_keys($val['RECORD']);  //===注释于 LUOJUN 2009-7-20
				$jsonstr.=substr($data,0,-1).'},';
			}
	   }
	   $jsonstr=substr($jsonstr,0,-1).']}';
	   return $jsonstr;
	}

   /**
    * 通过前端页面传入的参数生成相应的数组
	* 【如果是query情况：$showFields['EXECQUERY-字段名']=$rule;$cnd为翻页需要的字段名如：ID】
	* 【如果是BIZ情况：$showFields['表名-字段名']=$rule;$cnd主grid时为空，子grid为主键值】
    * @access public getGridArray($bizArr,$showFields,$cnd)
	* @param  array    $bizArr      业务的数组  	$showFields['POLITICAL.WGQYZZHD-C_NAME']=$rule;
    * @param  array    $showFields  需要显示的字段名(形如:表名-字段名) 来自system.xml的field属性
    * @param  string   $cnd         需要的结果的条件 
    * @return array    $resultArray gird显示的数组
    */
	public function getGridArray($bizArr,$showFields,$cnd,$type){
		$tabarr=array();  $fieldarr=array();$rowarr=array();
		  //print_r($bizArr);
        //ADD BY LUOJUN 2009-7-20
		$tmpArr=array();
		//echo "pp<br/>";
		//print_r($bizArr$bizArr['TABLESTRUCT']);
		unset($this->columnIds1);
		$this->columnIds1=array(0=>'front_x');
		foreach($showFields as $tmpKey1=>$rule1){
			
			 $tablename1=substr($tmpKey1,0,strpos($tmpKey1,'-'));
			 //echo $tmpKey1."===".$tablename1."<br/>";
			 if(!array_key_exists($tablename1,$tmpArr)){
			     $tmpArr[$tablename1]=''; 				 
				
				//print_r($bizArr['TABLESTRUCT'][$tablename1]);
				//echo $tablename1."<br/>";
				if(empty($bizArr['TABLESTRUCT'][$tablename1])){
					$this->columnIds[count($this->columnIds)]=$tmpKey1;
				}
				else{
					//print_r($this->columnIds1);
					$this->columnIds1=array_merge($this->columnIds1,array_values($bizArr['TABLESTRUCT'][$tablename1]));
				 }
				 //print_r($this->columnIds);
			 }			 
		}
		if(!empty($this->columnIds1))  $this->columnIds	=$this->columnIds1;
		//print_r($this->columnIds);
		//ADD BY LUOJUN 2009-7-20
		foreach($showFields as $tmpKey=>$rule){
			 $tablename=substr($tmpKey,0,strpos($tmpKey,'-'));
		     $fieldname=substr($tmpKey,strpos($tmpKey,'-')+1);
		     if($tablename=='EXECQUERY') $tabarr=$this->getTableArray($bizArr,$tablename);   //因为没带$pk条件所以取出来的只能是主表
			 else $tabarr=$this->getTableArray($bizArr,$tablename,$cnd); 
			 if(!empty($tabarr)) break;
		}
		if($tablename=='EXECQUERY')  $rowarr=$this->getTableArray($bizArr,$tablename);
		else{
			//print_r($tabarr);
			foreach($tabarr as $key=>$val){
		      $tmppk=substr($key,strpos($key,'_')+1);
		      foreach($showFields as $fKey=>$fName){
			   $fieldname=substr($fKey,strpos($fKey,'-')+1);  //tablename-front_field ==>tablename-field
			   if((strpos($fKey,'-front_')>0)||(strpos($fKey,'-FRONT_')>0)){

			   	   $tmpfKey=substr($fKey,substr($fKey,(strpos($fKey,'front_')+6)));
			   }else{
			   	   $tmpfKey= $fKey;
			   }
			   $field=substr($tmpfKey,strpos($tmpfKey,'-')+1);
			   //echo $field.'--'.$cnd.'---'.$tmpfKey.'<br/>';
               if(empty($cnd)) $fieldarr[$fKey]=$this->getFieldVal($bizArr,$tmpfKey,$tmppk);
			   elseif($type=='SUBTAB'){
			   	   $fieldarr= $tabarr[$key]['RECORD'];
				   break;
			   }else  $fieldarr[$fKey]= $tabarr[$key]['RECORD'][$tmpfKey];
		      }
		   $rec['RECORD'] =$fieldarr;
		   $rowarr[$key]=$rec;
		   }
		}
		//print_r($rowarr);
	   $this->getTurnPageCnd($tablename,$rowarr,$cnd);
		return $rowarr;
	}  

    /**
    * 取得单个字段的相应的结果值
    * @access private  getFieldVal($bizArr,$tabName,$cnd)
	* @param  array    $bizArr      biz的数组
    * @param  array    $showFields  需要显示的字段名(形如:表名-字段名) 来自system.xml的field属性
    * @param  string   $pk          需要的结果的条件,父亲表的主键值
    * @return array    $fieldVal    字段名为索引的字段值 
	*/
	private function getFieldVal($bizArr,$field,$pk){
		 $unVal='';	
		 $tablename=substr($field,0,strpos($field,'-'));
		 $fieldname=substr($field,strpos($field,'-')+1);
		 if(!empty($pk)){
		 	 $tmpTabArr=$this->getTableArray($bizArr,$tablename,$pk);
			 foreach($tmpTabArr as $tmpKey=>$tmpVal){
				foreach($tmpVal['RECORD'] as $fName=>$fVal){
					if($fName==$field){
						if(count($tmpTabArr)>1)   $unVal.=$fVal.';';
						elseif(count($tmpTabArr)==1) $unVal=$fVal;
					}
				}
			 }
		 }
		 return $unVal;
	}

    /**
    * 取得翻页需要的STARTID,ENDID
    * @access private  getTurnPageCnd($tablename,$rowarr)
	* @param  string   $tablename      区分出执行类型（QUERY,BIZ）
    * @param  array    $rowarr         最终的显示的结果表数组
	* @param  string   $cnd            以什么字段为标准收取	STARTID,ENDID
    * @return void  
	*/
	private function getTurnPageCnd($tablename,$rowarr,$cnd){
		//echo "$tablename:".$tablename." cnd:".$cnd."<br/>";
		//print_r($rowarr);
	  if($tablename=='EXECQUERY'){
		for($i=0;$i<count($rowarr);$i++){
			 if($i==0) $this->STARTID=$rowarr[$i]['RECORD'][$cnd];
			 if($i==(count($rowarr)-1)) $this->ENDID=$rowarr[$i]['RECORD'][$cnd];
		} 
	  }else{
		for($i=0;$i<count(array_keys($rowarr));$i++){
			 $tmpVal= array_keys($rowarr);
			 if($i==0) $this->STARTID=substr($tmpVal[$i],strpos($tmpVal[$i],'_')+1);
			 if($i==(count(array_keys($rowarr))-1)) $this->ENDID=substr($tmpVal[$i],strpos($tmpVal[$i],'_')+1);	
		} 	  
	  }
	}

   /**
    * 把$bizArray的某个$fieldname通过行数来合并成ID1#ID2#ID3
	* author luojun
	$ date 2009-6-17
    * @access public 
    * @param array $dataArray  传入的数组
	* @param string $field     合并的字段名
	* @param string $vMark     分隔符号【#】
    * @return string           形如：ID1#ID2#ID3
	*/
	public function getIDDataFromStrForSearchQuery($bizArray,$field,$vMark){
	    $tmpTabArr=$this->getTableArray($bizArray,'EXECQUERY');
		foreach($tmpTabArr as $tmpKey=>$tmpVal){
		    if(array_key_exists("EXECQUERY-".$field,$tmpVal['RECORD'])) 
				$vResult.=$tmpVal['RECORD']["EXECQUERY-".$field].$vMark;
		} 		
		$this->tRows=count($tmpTabArr);	 
		if(!empty($vResult)) $vResult=substr($vResult,0,(0-strlen($vMark)));		
		return $vResult;
	}


   //替换乱字符
   private function replce_bizstr($tempstr){
		$tempstr=str_replace("<br>", "", $tempstr);
		$tempstr=str_replace("<br/>", "", $tempstr);
		$tempstr=str_replace("<BR>", "", $tempstr);
		$tempstr=str_replace("<BR/>", "",$tempstr);
		$tempstr=str_replace("\"", "”",$tempstr);
		$tempstr=str_replace("'", "’",$tempstr);
		$search = array ("'<script[^>]*?>.*?</script>'si", // 去掉 javascript 
          "'<[/!]*?[^<>]*?>'si",       // 去掉 HTML 标记 
          "'([rn])[s]+'",           // 去掉空白字符 
          "'&(quot|#34);'i",           // 替换 HTML 实体
          "'&(amp|#38);'i","'&(lt|#60);'i","'&(gt|#62);'i","'&(nbsp|#160);'i","'&(iexcl|#161);'i", "'&(cent|#162);'i", 
          "'&(pound|#163);'i","'&(copy|#169);'i", "'&#(d+);'e"
		);             // 作为 PHP 代码运行

	     $replace = array ("", "","\1","”", "&", "<",  ">"," ", chr(161),chr(162),chr(163),chr(169),"chr(\1)"); 
		 $tempstr=preg_replace($search, $replace, $tempstr );	
         $tempstr = preg_replace('/\s(?=\s)/', '', $tempstr);
		 $tempstr= preg_replace('/[\n\r\t]/', '', $tempstr);	   
         return $tempstr;
   }
   /**
    * 通过传入的条件生成每个表的【数组】数据，便于在页面显示
    * @access public 
    * @param array $bizArr  后台返回的biz的数组数据
    * @param array $tablename  表名称    
    * @return array ColumnIds  返回单个表的字段数组
    **/
   public function getColumnIds($bizArr,$tablename){
   }


   /**
    * 通过传入的条件生成每个表的【数组】数据，便于在页面显示
    * @access public 
    * @param array $bizArr  后台返回的biz的数组数据
    * @param array $tablename  表名称    
    * @return array ColumnIds  返回单个表的字段数组
    **/
   public function getStoreDataIndex($columnIds,$gridheader,$tableID){
	   $finalClIds=array();
	   foreach($columnIds as $clKey=>$clVal){
			if(array_key_exists($clVal,$gridheader)){ 
				if(!empty($gridheader[$clVal][3])){
				  $finalClIds[]=$gridheader[$clVal][3];
				}else{
				  $finalClIds[]=str_replace('EXECQUERY',$tableID,$clVal);
				}
			}else{
			   $finalClIds[]=str_replace('EXECQUERY',$tableID,$clVal); 
			}
	   }
	   return $finalClIds;
   }

   /**
    * 处理后台操作是否成功返回结果的XML
    * @access public 
    * @param string $resultXml  后台返回的是否成功数据
    * @param string $type  类型值，attr属性，node结点   
    * @return string $key  键值
    **/
   public function dealReturnXml($resultXml,$type,$key){
	   $xResultset=array();$i=0;$suc=false;
	   $rsArray = $this->getXmlArrayFromStr($resultXml);
	   $rsArray = $rsArray['root'];
	   if(is_array($rsArray)){
		   $tmpArray= $rsArray;
		   foreach($tmpArray as $k => $v){
				if(($type=='attr'||$type=='ATTR')&&(array_key_exists($key,$tmpArray[$k]))){
					$xResultset[$i]=$tmpArray[$k][$key];
					$i++;
				}else if(($type=='node'||$type=='NODE')&&(array_key_exists($key,$tmpArray[$k]))){
					if(count($tmpArray[$k][$key])>2){
						$rsArray=$tmpArray[$k][$key];
						$suc = true;
					}else{
						$xResultset[$i]=$tmpArray[$k][$key]['0'];
						$i++;					
					}
				}
		   }
		   if(!$suc) unset($rsArray);
	   }
	   return $xResultset;
   }

//判断函数，如果所有过滤条件都不成立则返回true,至少一个成立则返回false,
	//$desTable是目标函数，其包含RECORD
	//add by add by 马世钊 唐德平 2011-03-11 
	
	public  function judgeFilter($desTable,$souTable)
	{
		$bool=false;
		if($souTable==null) $bool=true;
		else
		{
			foreach($desTable['RECORD'] as $deskey=>$desvalue)
			{
				foreach($souTable as $soukey=>$souvalue)
				{
					if($deskey==$soukey && $desvalue!=$souvalue)
					   $bool=true;
				}
			}
			return $bool;
		}
	}
/**
    * 通过前端页面传入的参数生成相应的数组
	* 【如果是query情况：$showFields['EXECQUERY-字段名']=$rule;$cnd为翻页需要的字段名如：ID】
	* 【如果是BIZ情况：$showFields['表名-字段名']=$rule;$cnd主grid时为空，子grid为主键值】
    * @access public getGridArray($bizArr,$showFields,$cnd)
	* @param  array    $bizArr      业务的数组  	$showFields['POLITICAL.WGQYZZHD-C_NAME']=$rule;
    * @param  array    $showFields  需要显示的字段名(形如:表名-字段名) 来自system.xml的field属性
    * @param  string   $cnd         需要的结果的条件 
    * @return array    $resultArray gird显示的数组
	* add by add by 马世钊 唐德平 2011-03-11
    */
	public function getGridArray2011($bizArr,$showFields,$cnd,$type){
		$filter=$this->splideFilters($showFields);
		$tabarr=array();  $fieldarr=array();$rowarr=array();
		$tmpArr=array(); //存表的名称
		unset($this->columnIds1);
		$this->columnIds1=array(0=>'front_x');
		foreach($showFields as $tmpKey1=>$rule1){

			$tablename1=substr($tmpKey1,0,strpos($tmpKey1,'-'));
			if(!array_key_exists($tablename1,$tmpArr)){
				$tmpArr[$tablename1]='';
				if(empty($bizArr['TABLESTRUCT'][$tablename1])){
					$this->columnIds[count($this->columnIds)]=$tmpKey1; //保存过滤的key
				}
				else{
					$this->columnIds1=array_merge($this->columnIds1,array_values($bizArr['TABLESTRUCT'][$tablename1]));//表名
				}
			}
		}
		if(!empty($this->columnIds1))  $this->columnIds	=$this->columnIds1;
		foreach($showFields as $tmpKey=>$rule){
			$tablename=substr($tmpKey,0,strpos($tmpKey,'-'));
			$fieldname=substr($tmpKey,strpos($tmpKey,'-')+1);
			if($tablename=='EXECQUERY')
			$tabarr=$this->getTableArray($bizArr,$tablename);   //因为没带$pk条件所以取出来的只能是主表
			else
			$tabarr=$this->getTableArray($bizArr,$tablename,$cnd);
			if(!empty($tabarr)) break;
		}
		if($tablename=='EXECQUERY')
		$rowarr=$this->getTableArray($bizArr,$tablename);
		else{
			foreach($tabarr as $key=>$val){
				$tmppk=substr($key,strpos($key,'_')+1);
				foreach($showFields as $fKey=>$fName){
					$fieldname=substr($fKey,strpos($fKey,'-')+1);  //tablename-front_field ==>tablename-field
					if((strpos($fKey,'-front_')>0)||(strpos($fKey,'-FRONT_')>0)){
						$tmpfKey=substr($fKey,substr($fKey,(strpos($fKey,'front_')+6)));
					}
					else{
						$tmpfKey= $fKey;
					}

					/*求当前需列出字段的条件*/
					$tmpshowfield = $showFields;
					foreach($tmpshowfield as $showkey =>$v){
						if($fKey!=$showkey){
							unset($tmpshowfield[$showkey]);
						}
					}
					$filter=$this->splideFilters($tmpshowfield);

					$field=substr($tmpfKey,strpos($tmpfKey,'-')+1);
					if(empty($cnd))
					$fieldarr[$fKey]=$this->getFieldVal1($bizArr,$tmpfKey,$filter,$tmppk);
					elseif($type=='SUBTAB'){
						$fieldarr= $tabarr[$key]['RECORD'];
						break;
					}
					else  $fieldarr[$fKey]= $tabarr[$key]['RECORD'][$tmpfKey];
				}
				$rec['RECORD'] =$fieldarr;
				$rowarr[$key]=$rec;
			}
		}
		$this->getTurnPageCnd($tablename,$rowarr,$cnd);
		return $rowarr;
	}
	/**
   * 过滤字段的标准形式
   * @access public function splideFilters($showFields)
   * @param  array    $showFields  需要显示的字段名(形如:表名-字段名) 来自system.xml的field属性
   *  add by add by 马世钊 唐德平 2011-03-11   
	   */
	public function splideFilters($showFields)
	{
		$fields=array();
		foreach($showFields as $key=>$value)
		{
			if($value!='')
			{
				while(strpos($value,';')!=false)
				{
					$item=substr($value,0,strpos($value,';'));
					$tempfield=substr($item,0,strpos($item,'=='));
					$tempvalue=substr($item,strpos($item,'==')+2);
					if(!array_key_exists($tempfield,$fields))
					{
						$fields[$tempfield]=$tempvalue;
						$showFields[$key]='';
					}
					$value=substr($value,strpos($value,';')+1);
				}
			}
		}
		return $fields;
	}
	/**
    * 取得单个字段的相应的结果值
    * @access private  getFieldVal($bizArr,$tabName,$cnd)
	* @param  array    $bizArr      biz的数组
    * @param  array    $showFields  需要显示的字段名(形如:表名-字段名) 来自system.xml的field属性
    * @param  string   $pk          需要的结果的条件,父亲表的主键值
    * @return array    $fieldVal    字段名为索引的字段值 
	*  add by add by 马世钊 唐德平 2011-03-11
	    */
	private function getFieldVal1($bizArr,$field,$filter,$pk){
		$unVal='';
		$tablename=substr($field,0,strpos($field,'-'));
		$fieldname=substr($field,strpos($field,'-')+1);
		if(!empty($pk)){
			$tmpTabArr=$this->getTableArray($bizArr,$tablename,$pk);
			foreach($tmpTabArr as $tmpKey=>$tmpVal){
				if($this->judgeFilter($tmpVal,$filter))
					continue;
				else{
					foreach($tmpVal['RECORD'] as $fName=>$fVal){
						if($fName==$field){
							if(count($tmpTabArr)>1)   $unVal.=$fVal.'；';
							elseif(count($tmpTabArr)==1) $unVal=$fVal;
						}
					}
				}
			}
		}
		return $unVal;
	}

}

?>
