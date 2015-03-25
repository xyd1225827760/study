<?php
/**
 * 流程引擎类
 * @author luojun
 * @version 1.0
 * @created 17-十月-2012 17:06:01
 */
class FlowControl extends control  {
	/**
	* 流程flowId
	* @var int
	* @access private
    */
	private $flowId;
	
	/**
	* 业务流程业务id 
	* @var int
	* @access private
    */
	public $bizid;

	/**
	* 进程processId
	* @var int
	* @access private
    */
	private $processId;
	
	/**
	* 流程节点Id
	* @var int
	* @access private
    */
	private $tid;
	
	/**
	* 流程节点nodeId
	* @var int
	* @access private
    */
	private $nodeId;
	
	/**
	* 流程下一节点nextId
	* @var int
	* @access private
    */
	private $nextId;
	
	/**
	* 流程节点条件节点
	* @var bool
	* @access private
    */
	private $iscondition = false;
	/**
	* 流程执行业务是否成功
	* @var bool
	* @access private
    */
	private $isSuccessFlow = true;

	/**
	* 数据库连接对象
	* @var obj
	* @access private
    */
	private $mysqldb;
	
	/**
	* 当前action
	* @var obj
	* @access private
    */
	//private $methdName;
	
	/**
	* 用户ID
	* @var obj
	* @access private
    */
	private $userid;
	private $username;
	private $password;
	/**
	* 原始模版文件
	* @var obj
	* @access private
    */
	private $viewFile;
	
	/**
	* 临时模版文件
	* @var obj
	* @access private
    */
	private $tempFile;
	
	/**
	* $wsData
	* @var obj
	* @access private
    */
	private $wsData;
	/**
	* $pXml
	* @var obj
	* @access private
    */
	private $pXml;
	
	private  $wsdl ;
	
	public $ajax = false ;
	
	/**
	 * $NO - 保存唯一编号 ， 用于展示我的工作中的申请编号等
	 *
	 * @var obj
	 */
	public  $NO ; 
	/**
	 * $NOTE - 保存其他的新 ， 用于展示我的工作中的人员姓名等
	 *
	 * @var obj
	 */
	public $NOTE ;
	
	public $nodeInfo ;
	
	private $nodeStyles;
    /**
    *$nextSteps 下一步 
    */
    public $nextSteps;
    /**
    *$stepParam 下一步参数 
    */
    private $stepParam = 'AUDITRESULT';
    /**
    *$paramJB 全局判断参数 
    */
    private $paramJB ;
	/**
	 * $isLoginStatus
	 * @var  obj
	 * @access public
	 * */
	public  $isLoginStatus = false ;
	public $msgOther ;
    private $zanStop = 'zanStop' ;
	public $bizStatus  ;
	
	public function __construct(){
		parent::__construct();
		global $app;
		$this->userid = $_SESSION['userRelateInfo']['USERID'] ;
		$this->username= $_SESSION['userRelateInfo']['LOGIN_ID'];
		$this->password = $_SESSION['userRelateInfo']['PASSWORD'] ;

		$this->loginCheckOut();

        $this->soapLink = new  WebServices($this->config->wsdl->FlowService);
		$this->codeInfo = new CodeInfo();
		$this->mysqldb = new MysqlPdo();
		$this->flowId = $this->config->module->flowid;
		$this->ajax = $_GET['ajax'] == 1 ? true : false ;
		if($this->methodName == 'doFlow' )$this->startFlow();
		//if($this->methodName == 'getFlow')$this->getFlowWork();
		
	}
	/**
	 * 开始构造流程
	 * 
	 */
	private  function startFlow()
	{
		#判断流程是否已经设置（即画流程图），否则不能往下执行
		if($this->flowId<=0)$this->erro(1);
		$this->bizid = $_GET['bizid'] ;
		#获取当前流程执行到的线程
		if(($this->tid = $this->getFlowInThread())>0)$nodeInfo = $this->getNodeByTheadTid();
		else $nodeInfo = $this->getStartNode();
		if (isset($_GET['nid'])&&($this->nodeId=$_GET['nid'])>0)$nodeInfo = $this->getNodeByNodeid();
		$this->nodeInfo = $nodeInfo ;
		$this->nodeName = $nodeInfo[0]['NODENAME'];
		#权限相关检验
		//$this->checkFlowRights($nodeInfo);
		#流程开始前的检验
		$this->beforeIntoFlow($nodeInfo[0]['ENTERCHECK']);
		#流程处理方向
        $this->getNextStepLine();
        #进入流程
		$this->inFlow($nodeInfo);
		#流程结束后的检验
		$this->afterOutFlow($nodeInfo[0]['LEAVECHECK']);
		#开始跳转信息
		if($this->ajax)$this->erro(0);
		if(!empty($_GET['did']))$this->showMsg('操作成功',"javascript:parent.art.dialog.get('".$_GET['did']."').close();",'5');
		else $this->showMsg('操作成功','/'.$this->moduleName.'/index.candor?app='.$_GET['app'].'&flowid='.$this->flowId,'5');
		#停止进入当前方法！
		exit;
	}
	
	/**
	 * 获取流程工作信息
	 * 
	 * */
	public function getFlowWork($bizid=null)
	{
		#取当前用户权限所有信息
		$flowinfo = $this->getAllFlowIndb($bizid);
		$i=0;
		foreach ($flowinfo as $key=>$item)
		{
			$nodeinfo = $this->getAllNodeByNodeid($item['FLOWID'],$item['TID']);//print_r($nodeinfo);
			//$nodeinfo = $this->getAllWorkIndb($item['FLOWID']);
			#1.非条件节点
			if($nodeinfo[0]['NODETYPE']!='condition')
			{
				#检查是否拥有改条语句权限
				$flowInfos = $this->getAllNodeRightsIndb($item['FLOWID'],$nodeinfo[0]['NODEID']);
				if (!empty($flowInfos))
				{
					#只展示未完成的流程 , 其中有可能存在2的情况，2为不通过，表示不处理
					$i = $item['BIZID'].'_'.$flowInfos[0]['ID']; // 避免出现重复ID项，将键值设为bizid_id避免重复
					$bizname = empty($nodeinfo[0]['BIZNAME']) || $nodeinfo[0]['BIZNAME']=='__CLASS' ? $item['BIZCONTROL'] : $nodeinfo[0]['BIZNAME'];
					$flowList[$i]['URL'] = "/".$bizname."/doFlow.candor?bizid=".$item['BIZID']."&nid=".$flowInfos[0]['NODEID'] ;
					$flowList[$i]['NAME'] = $flowInfos[0]['NODENAME'] ;
					$flowList[$i]['NO'] = $item['NO'] ;
					$flowList[$i]['NOTE'] = $item['NOTE'] ;
					$flowList[$i]['MODULENAME'] = $item['FLOWNAME'];
					
				}
			}
			else 
			{ 
				#2.条件节点
				foreach ($nodeinfo as $keys=>$items)
				{
					#检查是否拥有下一条条节点权限
					$flowInfos = $this->getAllNodeRightsIndb($item['FLOWID'],$items['NEXTNODE']);//print_r($flowInfos);
					
					if(!empty($flowInfos)):
						#查找当前节点是否完成
						foreach ($flowInfos as $fns)
						{ //echo $fns['NODEID'];
							$fis = $this->getAllWorkIndb($item['FLOWID'],$fns['NODEID'],$item['BIZID']);//print_r($fis);
							#只展示未完成的流程 , 其中有可能存在2的情况，2为不通过，表示不处理
							if (empty($fis)||$fis[0]['ISDONE']==0)
							{
								$i = $item['BIZID'].'_'.$flowInfos[0]['ID']; // 避免出现重复ID项，将键值设为bizid_id避免重复
								$bizname = empty($$fns['BIZNAME']) || $$fns['BIZNAME']=='__CLASS' ? $item['BIZCONTROL'] : $fns['BIZNAME'];
								$flowList[$i]['URL'] = "/".$item['BIZCONTROL']."/doFlow.candor?bizid=".$item['BIZID']."&nid=".$fns['NODEID'] ;
								$flowList[$i]['NAME'] = $flowInfos[0]['NODENAME'] ;
								$flowList[$i]['NO'] = $item['NO'] ;
								$flowList[$i]['NOTE'] = $item['NOTE'] ;
								$flowList[$i]['MODULENAME'] = $item['FLOWNAME'];
							}
							
						}
						

					endif;
				}
			}
		}
		//print_r($flowList);
		return $flowList ;
	}
	/**
	 * 取流程所有审批过程
	 * */
	public  function getNextTree($bizid,$table)
	{
		#取当前流程已完成过的流程CSBIZ.FLOWHIS
		$parmas['TABLENAME'] = $table;
		$parmas['REGIID'] = $bizid;
		$flowList['process'] = $this->soapLink->getSqlidInfo('getTheLastFlowHis',$parmas);
		$flowList['flowlist'] = $this->getFlowWork($bizid);
		
		return $flowList;
	}

	private function getAllWorkIndb($flowid,$nextid,$bizid)
	{
		$user1 = 'u:'.$this->userid.',';
		$user2 = ','.$this->userid.',';
		$where = " userrights = '%%' ";
		$sql = " select fp.* from flownode fn left join flowprocess fp on fp.flowid=fn.flowid and fp.nodeid = fn.nodeid and fp.nextnode = fn.nextnode where fn.FLOWID = '{$flowid}' and fn.NODEID = '{$nextid}' and fp.bizid = '{$bizid}'  ";
		$flowinfo = $this->mysqldb->getAll($sql);
		return  $flowinfo;
	}
	private function getAllNodeByNodeid($flowId,$nodeId) {
		$sql = "select * from flownode where FLOWID={$flowId} and NODEID={$nodeId}";
		$nodeInfo = $this->mysqldb->getAll($sql);
		return $nodeInfo;
	}
	private function getAllNodeProcessIndb()
	{
		
	}
	private function getAllNodeRightsIndb($flowId,$nodeId)
	{
		$user1 = 'u:'.$this->userid.',';
		$user2 = ','.$this->userid.',';
		$sql = "select * from flownode where ( userrights like '%$user1%' or userrights like '%$user2%' ) and FLOWID={$flowId} and NODEID={$nodeId}";
		$nodeInfo = $this->mysqldb->getAll($sql);
		return $nodeInfo;
	}
	private function getAllFlowIndb($bizid=null)
	{
		if($bizid>0)$where = " and ft.bizid='$bizid' and ft.flowid = '{$this->flowId}' ";
		$sql = " select fi.FLOWNAME,ft.* from flowthread ft left join flowinfo fi on fi.id = ft.flowid where fi.isuse = '1' and ft.isend = '0' $where ";
		$flowinfo = $this->mysqldb->getAll($sql);
		return  $flowinfo;
	}
    
    /**
    +----------------------------------------------------------
    * 取得下一节点走向
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param 
    +----------------------------------------------------------
    * @return 
    +----------------------------------------------------------
    */
    
    private function getNextStepLine()
    {
        $flowid = $this->flowId ;
        //去当前流程节点信息，如为空取开始节点
        if(!empty($this->nodeInfo))
        {
            $flowinfo = $this->nodeInfo;
        }
        else
        {
            $flowinfo = $this->getNodeByNodeid();
        }
        $this->nextId = $flowinfo[0]['NEXTNODE'];
        //取下一节点信息
        $nextInfo  = $this->getNodeByNextId($this->nextId);
        
        $nextStep = array();
        if($nextInfo[0]['NODETYPE']=='condition'&&$nextInfo[0]['isoneline']=='1')
        {
            foreach($nextInfo as $key=>$item)
            {
                $nextStep[$key]['tagname'] = $item['TAGNAME'];
                $nextStep[$key]['value'] = $item['CONDITIONS'];
                $nextStep[$key]['nodeid'] = $item['NEXTNODE'];
                $nextStep[$key]['status'] = $item['BIZSTATUS'];
            }
            
        }
        else
        {
            $nextStep[0]['tagname'] = '通过';
            $nextStep[0]['value'] = '1';
            $nextStep[0]['status'] = $flowinfo[0]['NODENAME'];
            $nextStep[1]['tagname'] = '不通过';
            $nextStep[1]['value'] = '2';
            $nextStep[1]['status'] = $flowinfo[0]['NODENAME'];
        }
        //$len = count($nextStep);
//        $nextStep[$len]['tagname'] = '暂缓';
//        $nextStep[$len]['value'] = $this->zanStop;    
        
        $this->nextSteps = $nextStep ;
        $this->assign('nextStep',$this->nextStep());
		$isflow = ($this->methodName=='doFlow' && isset($_GET['nid'])) ? $this->methodName : '';
        $this->assign('isflow',$isflow);  //提过前端判断当前页面是否流程
    }
    private function nextStep()
    {
        $param = $this->stepParam ;
        $select = "<select name='$param' id='$param' >";
        foreach($this->nextSteps as $item)
        {
            $select .= "<option value='".$item['value']."'>".$item['tagname']."</option>";
        }
        $select .="</select>";
        return $select ;
    }
	/**
	 * 获取上一结点信息
	 * 
	 * @param curnode 当前结点信息
	 * return nextnode 
	 */
	public function getPreNodeInfo($curnodeid){
		$rsnodes =array();
		if(!empty($curnodeid)) $rs = 'SELECT * FROM FLOWNODE where ID='.$curnodeid;
		else throw new Exception('你未传入当前流程结点信息，请联系管理员！');
		$curnodes=$this->mysqldb->getAll($rs);
		foreach($curnodes as $k=>$v){
			$prenodes = $this->mysqldb->getAll('SELECT * FROM FLOWNODE WHERE NEXTNODE='.$curnodes[$k]['ID']);		
			foreach($prenodes as $prekey=>$preval){
				$nodetype = $prenodes[$prekey]['NODETYPE'];
				if($nodetype=='1'){
					//说明当前结点为【流程结点】
					$prenodeid= $prenodes[$prekey]['ID'];				
//					if($prenodeid)
					$rsnodes= array_merge($rsnodes,$prenodes[$prekey]);
					//print_r($rsnodes);exit;
				}else if($nodetype=='2'){
					//说明当前结点为【判断结点】
					$tmparr = $this->getPreNodeInfo($prenodes[$prekey]['ID']);
						
						
					$rsnodes= array_merge($rsnodes,$tmparr);
				}else{
					throw new Exception('上一结点信息的结点类型有异常，请联系管理员！');
				}			
			}			
		}

		return $rsnodes;
	}



	/**
	 * 获取用户相关信息
	 * 
	 * @param type 1-用户、2-权限组、3-单位、4-角色
	 * @param cnds 条件参数以数组形式表达
	 * return userinfo 
	 */
	function getUserInvolveInfo($type,$cnds){
	
	}


	/**
	 *  标签方法
	 * 
	 * @param labelname 标签名称
	 * @param cnds 条件参数以数组形式表达
	 * return labelrs 
	 */
	function opLabelBiz($labelname){
	
	}


	/**
	 * 增加结点
	 * 
	 * @param curnode 当前结点信息
	 * return boolean 
	 */
	function addNodes($curnode){
	}

	/**
	 * 修改结点
	 * 
	 * @param nodeid 当前结点流水号
	 * @param curnode 当前结点信息
	 * return boolean 
	 */
	function updateNodes($nodeid,$curnode){
	}


	/**
	 * 删除结点
	 * 
	 * @param nodeid 结点ID
	 * return boolean 
	 */
	function deleteNodes($nodeid){
		//return '11111111';
		if($nodeid==''||empty($nodeid)) throw new exception("xxxxxxxxxxxxxxxxx");
	}

	/****************************************************************************************************************/
	/*                                            解析流程XML														*/
	/*原理：传入建模工具生成的XML字符串和流程ID，解析XML中是否有【连线】并且符合连线两端有结点存在，不存在抛出异常；*/
	/*		如果存在，获取所有连线两端的结点并能找出前后结点关系，生成为以结点ID为索引的结点数组（包含结点ID，结点名*/
	/*		称，结点父亲流程ID，下一结点ID），对该数组进行循环生成SQL语句，通过结点ID和流程ID判断是否数据库存在,如果*/
	/*		存在进行更新操作，不存在进行插入操作。整个数据库操作中，采用事务机制.									*/
	/****************************************************************************************************************/

	/**
	 * 操作结点表信息到数据库
	 * 
	 * @param xml 流程XML字符串
	 * @param flowid 流程流水号
	 * return $message 操作结果数组
	 */
	public function OpFlowNodesDB($xml,$flowid){
		$message = array();
		$flowIsExistsSql = "SELECT * FROM FLOWINFO WHERE ID = ".$flowid; //流程表中是否存在
		$nodeIsExistsSql = "SELECT * FROM FLOWNODE WHERE FLOWID = %s AND NODEID=%s"; //结点表中是否存在
		$nodeNextNodeIsExistsSql = "SELECT * FROM FLOWNODE WHERE FLOWID = %s AND NODEID=%s AND NEXTNODE %s "; //结点表中是否存在该节点和下一节点
		$deleteNotInIdsSql = "DELETE FROM FLOWNODE WHERE FLOWID= %s AND NODEID NOT IN (%s)";//删除流程结点表中not in 这些id号的结点记录

		$XMLNodeArr = $this->parserFlowXml($xml,$flowid);
		if(empty($XMLNodeArr)) throw new Exception("传入的XML格式不规范，请检查是否流程创建正确！");
		$flows = $this->mysqldb->getAll($flowIsExistsSql);
		if(empty($flows)){
			throw new Exception('当前未发现流程信息，请联系管理员！');
		}else{
			//先除去数据库里面不在$XMLNodeArr中的ID号
			#判断数据库中实付存在改节点再进行删除等操作
			foreach(array_keys($XMLNodeArr) as $k => $v){
				$sql = sprintf($nodeIsExistsSql,$flowid,$v);
				$nodeInfo = $this->mysqldb->getAll($sql);
				if(!empty($nodeInfo))$NOTINIDS .=','.$v;
				#判断是否存在更改上下节点问题，存在则需删除当前节点信息
//				foreach ($XMLNodeArr[$k]['NEXTNODE'] as $next_nid)
//				{
//					foreach ($nodeInfo as $item)
//					{echo $next_nid.'='.$item['NEXTNODE'].'..'.$item['NODEID'].'<br>';
//						if($item['NEXTNODE']==$next_nid)
//						{
//							$FIDS[] = $item['ID'];
//						}
//					}
//					//if($next_nid==$nodeInfo['NEXTNODE'])
//				}
				//if($nodeInfo['NEXTID']==$XMLNodeArr)
			}
			$this->mysqldb->startTrans();//启动事务
			//执行结点数据库操作
			try{
				$NOTINIDS = substr($NOTINIDS,1);
				if(!empty($NOTINIDS)&&($NOTINIDS!=',')){//如果至少有一个结点ID，执行先删除流程结点表中not in 这些id号的结点记录
					$delsql = sprintf($deleteNotInIdsSql,$flowid,$NOTINIDS);
					if($this->mysqldb->doSql($delsql)===false) throw new Exception('删除流程结点记录异常，请联系管理员！');
				}
				#删除流程节点中：条件节点多条，没画流程线条的 需要删除
				//var_dump($XMLNodeArr);
				foreach($XMLNodeArr as $idx=>$node){
					if(!empty($node['NEXTNODE']))
					{
						$NEXTNODES = '';						
						foreach ($node['NEXTNODE'] as $nenode)
						{
							$NEXTNODES .=','.$nenode;
						}
						$NEXTNODES = substr($NEXTNODES,1);
						$sql = " delete  from   FLOWNODE where flowid = '$flowid' and NODEID = '$idx' and NEXTNODE NOT in ($NEXTNODES) ";
						//echo $sql.'<br>';
						$this->mysqldb->doSql($sql);
					}
				}
				foreach($XMLNodeArr as $idx=>$node){					
					if(empty($node['NEXTNODE'])) $nextnode="null";
					else $nextnode=$node['NEXTNODE'];
					$node['ID'] = empty($node['ID']) ? $idx : $node['ID'];
					$node['NAME'] = empty($node['NAME']) ? "条件" : $node['NAME'];
					
 					if(!empty($nextnode))
					{
						foreach ($nextnode as $nenode)
						{
							$nnode = empty($nenode)?'is null':'='.$nenode;
							$nenode = empty($nenode)?'null':$nenode;
							$nenode.$sql = sprintf($nodeNextNodeIsExistsSql,$flowid,$idx,$nnode);
							$hasnode = $this->mysqldb->getRow($sql);
							if(empty($hasnode)){
								//新增结点到数据库表中
								$opNodeSql = "INSERT INTO FLOWNODE SET NEXTNODE=".$nenode.",NODENAME='".$node['NAME']."', FLOWID=".$flowid." , NODEID=".$node['ID']." , NODETYPE = '{$node['NODETYPE']}' ";
							}else{
								//到数据库表中更新结点
								$opNodeSql = "UPDATE FLOWNODE SET NEXTNODE=".$nenode.",NODENAME='".$node['NAME']."' , NODETYPE = '{$node['NODETYPE']}'  WHERE FLOWID=".$flowid." AND NODEID=".$node['ID']." AND NEXTNODE ".$nnode." ";
							}
							echo $opNodeSql.'<br>';
							$this->mysqldb->doSql($opNodeSql);
							
						}
					}
					
					//if($this->mysqldb->doSql($opNodeSql)===false) throw new Exception('操作流程结点记录异常，请联系管理员！');
				}
				$this->mysqldb->commit();//事务提交
				$message['ISSUCESS'] = true;
				$message['INFO'] = '操作成功！';
			}catch(Exception $sqlexception){
				$this->mysqldb->rollback();//事务回滚
				$message['ISSUCESS'] = false;
				$message['INFO'] = '操作失败出现异常【'.$sqlexception->getMessage().'】，请联系管理员！';
			}	
		}
		return $message;
	}


 	/**
	 * 解析流程info表的XML
	 * 
	 * @param xml XML字符串
	 * return  
	 */
	function parserFlowXml($xml,$flowid){
		$dom = new DOMDocument("1.0","utf-8");
		$dom->loadXML($xml);
		$degeDom=$dom->getElementsByTagName('Edge');
		$this->getStyleInNode($dom->getElementsByTagName('Shape'));
		$this->getStyleInNode($dom->getElementsByTagName('Task'));
		$this->getStyleInNode($dom->getElementsByTagName('End'));
		foreach($degeDom as $dege){
			$pANDcNodes = $this->findParentOrChildNode($dege);
			foreach($pANDcNodes as $k=>$v){
				$node[$k] = $this->findFlowNodesByXml($dom,$k);//task表示为任务结点，Edge表示为连线
//				if($k == "PRENODEID"){
//					$nodes[$id]['NEXTNODE'] =  $pANDcNodes['NEXTNODEID'];
//				}
				$nodes[$k]['NEXTNODE'][] = $v;
				$nodes[$k]['NODETYPE'] = $this->nodeStyles[$k];
			}
			$nodes[$k] = array_merge($node[$k],$nodes[$k]);	
		} 
		return $nodes;
	}
	
	/**
	+----------------------------------------------------------
	* 获取所有节点style
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param 
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	private function getStyleInNode($nodeDom)
	{
		foreach ($nodeDom as $domEdge)
		{
			if($domEdge->hasChildNodes()){
				foreach($domEdge->childNodes as $mxCell){
					if(($mxCell->nodeType=='1')&&($mxCell->nodeName=='mxCell')){//当结点类型为element，并且结点名称为mxCell，获取当前线上的属性值
						$style = $mxCell->getAttribute("style") ;
						if(!empty($style)&&$style=='rhombus')$nodeType =  'condition';
						else if (!empty($style)&&$style=='end') $nodeType = 'end' ;
						else $nodeType = 'task' ;
						$this->nodeStyles[$domEdge->getAttribute('id')] = $nodeType;
					}
				}
			}
		}
	}
	 /**
	 * 当前结点的相关信息
	 * 
	 * @param $domObj 整个XMLdom对象
	 * @param $id	  结点ID 
	 * return  $nodearray 当前结点的相关信息以结点ID作为数组索引
	 */
	private function findFlowNodesByXml($domObj,$id,$nodename='Task'){
		$nodearray = array();
		$tmpDom = $domObj->getElementsByTagName($nodename);
		foreach($tmpDom as $nodes){
			if($nodes->getAttribute("id")==$id){
				$nodearray['NAME'] = $nodes->getAttribute("label");
				$nodearray['ID'] = $nodes->getAttribute("id");
			}
		}
		return $nodearray;
	}
	private function findFlowNodesByXmlAttr()
	{
		
	}
	
 	/**
	 * 当前线上的前后结点
	 * 
	 * @param domEdge 连接线对象
	 * return  $pORcNode 连接线前后结点ID数组
	 */
    private function findParentOrChildNode($domEdge){
		$pORcNode = array();
		if($domEdge->hasChildNodes()){
			foreach($domEdge->childNodes as $mxCell){
				if(($mxCell->nodeType=='1')&&($mxCell->nodeName=='mxCell')){//当结点类型为element，并且结点名称为mxCell，获取当前线上的属性值
					$parantid = $mxCell->getAttribute("source") ;
					$childid = $mxCell->getAttribute("target");			
					//$pORcNode['PRENODEID'] = $parantid;
					//$pORcNode['NEXTNODEID'][] = $childid;
					$pORcNode[$parantid] = $childid;
				}
			}
		}		
		return $pORcNode;
	}

	/**
     * 根据流程id获取流程在线程中执行到的地点
     * @access public
     * @return object
     */
	private function getFlowInThread() {
		$sql = "select * from flowthread where FLOWID={$this->flowId} and BIZID = '{$this->bizid}' ";
		$nodeInfo = $this->mysqldb->getRow($sql);
		return $nodeInfo['TID'];
	}
	/**
     * 根据流程id与节点id获取节点信息
     * @access public
     * @return object
     */
	private function getNodeByNodeid() {
		$sql = "select * from flownode where FLOWID={$this->flowId} and NODEID={$this->nodeId}";
		$nodeInfo = $this->mysqldb->getAll($sql);
		return $nodeInfo;
	}
	/**
     * 根据流程id与节点id获取节点信息
     * @access public
     * @return object
     */
	private function getNodeById() {
		$sql = "select * from flownode where FLOWID={$this->flowId} and ID={$this->tid}";
		$nodeInfo = $this->mysqldb->getRow($sql);
		return $nodeInfo;
	}
	/**
     * 根据流程id与进程tid获取节点信息
     * @access public
     * @return object
     */
	private function getNodeByTheadTid() {
		$sql = "select * from flownode where FLOWID={$this->flowId} and NODEID={$this->tid}";
		$nodeInfo = $this->mysqldb->getAll($sql);
		return $nodeInfo;
	}
	/**
	 * 根据下一节点ID获取下一节点信息
	 * */
	private function getNodeByNextId($nextid)
	{
		$sql = " select fn.*,fp.bizid,fp.ISDONE,fn.isoneline from flownode fn left join flowprocess fp on fp.flowid=fn.flowid and fp.nodeid = fn.nodeid and fp.nextnode = fn.nextnode where fn.FLOWID = '{$this->flowId}' and fn.NODEID = '{$nextid}' ";
		$info = $this->mysqldb->getAll($sql);
		if ($info[0]['NODETYPE']=='condition')$this->iscondition = true;
		else $this->iscondition = false ;
		return $info;
	}
	/**
	 * 根据下一节点ID获取当前节点支线信息
	 * */
	private function getExtensionByNextId($nextid)
	{
		$sql = " select fn.* from flownode fn  where fn.FLOWID = '{$this->flowId}' and fn.NEXTNODE  = '{$nextid}' ";
		$info = $this->mysqldb->getAll($sql);
		return $info;
	}
	/**
	 * 根据下一节点ID获取当前节点支线process信息
	 * */
	private function getExtensionProcessByNextId($nextid)
	{
		$sql = " select fn.*,fp.bizid,fp.ISDONE from flownode fn left join flowprocess fp on fp.flowid=fn.flowid  and fp.nodeid = fn.nodeid and fp.nextnode = fn.nextnode where fn.FLOWID = '{$this->flowId}' and fn.NEXTNODE  = '{$nextid}' and bizid = '{$this->bizid}' ";
		$info = $this->mysqldb->getAll($sql);
		return $info;
	}
	/**
	 * 根据下一节点ID获取当前节点支线process信息
	 * */
	private function getCountProcessByNextId($nextid)
	{
		$sql = " select count(*) as cnt from flownode fn left join flowprocess fp on fp.flowid=fn.flowid  and fp.nodeid = fn.nodeid and fp.nextnode = fn.nextnode where fn.FLOWID = '{$this->flowId}' and fn.NEXTNODE  = '{$nextid}' and bizid = '{$this->bizid}' ";
		$info = $this->mysqldb->getAll($sql);
		return $info;
	}
	/**
	 * 删除当前流程中同一bizid的节点，
	 * */
	private function delProcessNode($flowid,$bizid)
	{
		if(!empty($flowid)&&!empty($bizid))
		{
			$sql = " delete from flowprocess where bizid = '$bizid' and flowid = '$flowid' ";
			if($this->mysqldb->execute($sql)===false)return false;
			else return true;
		}
		
		
	}
	/**
     * 根据流程id与当前action获取节点信息
     * @access public
     * @return object
     */
	private function getNodeByAction() {
		$sql = "select * from flownode where FLOWID={$this->flowId} and ACTION={$this->methdName}";
		$info = $this->mysqldb->getRow($sql);
		$this->nodeId = $info['nodeid'];
		return $info;
	}

	/**
     * 根据流程id获取开始节点id
     * @access public
     * @return null
     */
	private function getStartNode() {
		$sql = "select * from flownode  where FLOWID=".$this->flowId." and isstart=1 and nodetype = 'task'";
		$info = $this->mysqldb->getAll($sql);
		$this->nodeId = $info['nodeid'];
		return $info;
	}
	/**
	 * 更新当前节点已完成
	 * @access public
	 * @return 
	 * */
	private function upNowNodeIsDone($NODEID,$NEXTID)
	{
		#由于节点状态可能存在 审核 通过、暂缓、不通过等情况 ，ISDONE需要更新为几个状态！ 暂缓0，审核1，未通过2
		$isdone = $this->inJB ;
		#为避免更新不提示 需要先查询一次，已更新过则返回true
		$info = $this->mysqldb->getRow("select ISDONE from flowprocess  where  FLOWID=".$this->flowId." and NODEID='".$NODEID."' AND bizid = '".$this->bizid."' AND NEXTNODE = '".$NEXTID."'  ");
		if ($info['ISDONE']=='1')return true;
		if(empty($info)) $sql = " insert into flowprocess set ISDONE = '$isdone' ,  FLOWID=".$this->flowId." , NODEID='".$NODEID."' , bizid = '".$this->bizid."' , NEXTNODE = '".$NEXTID."'  ";
		else $sql = " update flowprocess set ISDONE = '$isdone' where  FLOWID=".$this->flowId." and NODEID='".$NODEID."' AND bizid = '".$this->bizid."' AND NEXTNODE = '".$NEXTID."' ";
		$info = $this->mysqldb->execute($sql);
		if($info===false)return false;
		else return true;
	}
	/**
	 * 流程权限相关检验
	 * @access  private
	 * @param $info 
	 * */
	private function checkFlowRights($info)
	{
		#流程是否存在
		if($info[0]['ID']<=0)$this->erro(1);
		#该用户是否存在权限
		$norights = false ;
		if (strpos($info[0]['USERRIGHTS'],'u:'.$this->userid.',')>-1) $norights = true;
		if (strpos($info[0]['USERRIGHTS'],','.$this->userid.',')>-1)  $norights = true;
		if(!$norights)$this->erro(2);
		#流程是否启用
		if($info[0]['ISUSE']!=null&&$info[0]['ISUSE']==0)$this->erro(3);
	}
	/**
     * 流程开始前检验
     * @access public
     * @return null
     */
	private function beforeIntoFlow($entercheck) {
		#开始流程前执行的检查
		$this->doNeedCheck($entercheck);
	}
	/**
     * 进入流程
     * @access public
     * @return null
     */
	private function inFlow($nodeInfo) {
		#定义当前地址
		define('__URL__',"/".$this->moduleName."/doFlow.candor?bizid=".$this->bizid."&nid=".$_GET['nid']);
		# 一 -- 判断当前节点是否为条件节点 ！如果是则进行下一节点多支线展示
		if($nodeInfo[0]['NODETYPE']=='condition')
		{ 
			#显示步骤(show)
			$action = $nodeInfo[0]['DISPLAY'];
			#展示进程列表 - 即下一节点的多条支线
			#获取下一节点支线 
			#展示流程审批
			//$this->getNextTree();
			if(!method_exists($this->moduleName,$action))$this->erro(9,$action);
			$this->$action();
			exit;
		}
		else 
		{
			# 二 -- 
			#下一流程节点
			$this->nextId = $nodeInfo[0]['NEXTNODE'];
			#biz , action
			$bizName = $nodeInfo[0]['BIZNAME'];
			$action = $nodeInfo[0]['ACTION'];
			#是否为保存方法 - 给定一个参数do=save 只用于展示do=show
			#不是保存方法则继续执行该程序
			if ($_GET['do'] == 'save') {
                #保存前才流程检查
                $this->saveBeforeCheck($nodeInfo[0]['SAVEBEFORECHECK']);
                
                $this->setDefaultParamStep();
				#保存步骤（save）
				//下一节点信息
				//$nextInfo = $this->getNodeByNextId($this->nextId);
				//if (empty($nextInfo[0]['ACTION']))$this->erro(5,$nextInfo[0]['NODEID']);
				if (empty($nodeInfo[0]['ACTION']))$this->erro(5,$nodeInfo[0]['NODEID']);
				$action = $this->methodName = $nodeInfo[0]['ACTION'] ; 
				if(!method_exists($this->moduleName,$action))$this->erro(9,$action);
				#处理后台审核日志flowhis,flowtrans信息
				$this->nextInfo = $this->getNodeByNextId($this->nextId);
				$this->getFlowHisInTable();
				$this->isSuccessFlow = $this->$action();
				$this->bizid = $this->tid > 0||$this->bizid > 0 ? $this->bizid : $this->isSuccessFlow ;
			}
			else{
				#显示步骤(show)
				$action = $nodeInfo[0]['DISPLAY'];
				#展示流程审批
				//$this->getNextTree();
				if(!method_exists($this->moduleName,$action))$this->erro(9,$action);
				$this->$action();
				exit;
			}
		}
	}
    
    /**
    +----------------------------------------------------------
    * 设置比较下一值状态
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param 
    +----------------------------------------------------------
    * @return 
    +----------------------------------------------------------
    */
    
    private function setDefaultParamStep()
    {
        $nextInfo = $this->getNodeByNextId($this->nextId);
        if($nextInfo[0]['ISONELINE']!='1')return true;
        $param = $this->stepParam ;
        
      //  $_POST[$param] = '@@name<10';
        //1、默认取 下一步选择
        if(!empty($_POST[$param]))
        {
            $inJB = $this->inJB = $_POST[$param];
        }
        
        #如果选择为暂缓 则不处理
        if($inJB == $this->zanStop)$this->nextStepId = $this->zanStop ;
        
        $isEvalue = false;
        foreach($this->nextSteps as $key=>$item)
        {
            if($item['value']==$inJB)
            {
                $isEvalue = true ;
                $this->nextStepId = $this->nextSteps[$key]['nodeid'];
                $this->bizStatus = $this->nextSteps[$key]['status'];
            }
        }
        if(!$isEvalue)$this->erro(-1,'下一步判断条件不存在或已更改，请重新审核');
        
        
        
        /** 如果存在变量 或 方法 ，则不依照 传递的值 进行判断
        *  根据下一条件节点设置的 判断条件 执行
        *  首先是多条支线 
        */
        $this->doNextStepCheck();

        
       // var_dump($this->nextStepId);
        //print_r($this->nextSteps);

        //exit;
    }
    
    /**
    +----------------------------------------------------------
    * 判断流程的走向
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param 
    +----------------------------------------------------------
    * @return 
    +----------------------------------------------------------
    */
    
    private function doNextStepCheck()
    {
        
        $para = "@@[a-zA-Z]+\d*"; 

        $fun = "((Front:)|(Back:))[a-zA-Z]+\(([a-zA-Z]+\d*(,[a-zA-Z]+\d*)*)*\)";
        $ysuan = "(&&|(\|\|))";
        $bj = "((>|<|(==)|(>=)|(<=))\w+)*";
        
       $paramRule = "/^".$para.$bj."(".$ysuan.$para.$bj.")*$|^(\(?(\(?".$fun."(".$ysuan."\(?".$fun.")*\)?)+\)?(\s)*([a-zA-Z]+)?)".$bj."$/" ;     
       
     //  $inJB = "@@INCOME==1&&@@MINIMUMNUMBER>=1";
        foreach($this->nextSteps as $k=>$ns)
        {
            if(preg_match($paramRule,$ns['value']))
            { 
                $inJB = $ns['value'];
                preg_match_all("($para)",$inJB,$inJB_arr);
                
                if(!empty($inJB_arr))
                {
                    #开始从POST表单中取同名键值并赋值
                    foreach($_POST as $key=>$item)
                    {
                        
                        foreach($inJB_arr[0] as $ivalue)
                        {
                            if(!empty($ivalue)&&'@@'.strtoupper($key)==strtoupper($ivalue))
                            { 
                                 $paramP[$key] = $item ;
                                
                            }
                        }
                        
                    }
                   
                }
                
            }
        }
        
        if(is_array($paramP))
        {
            foreach($this->nextSteps as $k=>$item)
            {
                $matches = $item['value'] ;
                foreach($paramP as $key=>$p)
                {
                    //$matches .= str_replace("@@".$key,$p,$item['value']);
                    $matches = str_replace("@@".$key,$p,$matches );
                }
                #如果在替换后还存在 未替换的值，则流程不应继续往下走
                if(preg_match($paramRule,$matches))$this->erro(-1,'流程配置中存在未定义参数!');
                eval(' \$result = '.$matches.' ;');
                if($result)
                {
                    $this->nextStepId = $item['nodeid'];
                    $this->bizStatus = $item['status'];
                    return true;
                }
            }
            
        }

        
    }
    
    /**
    +----------------------------------------------------------
    * 保存流程前检验方法
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param 
    +----------------------------------------------------------
    * @return 
    +----------------------------------------------------------
    */
    
    private function saveBeforeCheck($savebeforcheck)
    {
        #保存流程前检验方法
        $this->doNeedCheck($savebeforcheck);
    }
    
	/**
     * 流程结束后检验
     * @access public
     * @return null
     */
	private function afterOutFlow($leaveCheck) {
		if (!$this->isSuccessFlow)$this->erro(4);
		#结束成功执行间检验方法
		$this->doNeedCheck($leaveCheck);
		#结束后 开始进去更新线程
		$this->upThreadInFlow();
	}
	/**
	 * 更新线程执行到的节点
	 * */
	private function upThreadInFlow()
	{
		#获取下一节点信息
		$nowInfo = $this->nodeInfo;
		$fnextId = $nowInfo[0]['NEXTNODE'];
		$nextInfo = $this->getNodeByNextId($this->nextId);
		$isEnd = $nextInfo[0]['NEXTNODE'];
		//$snextId = $nextInfo['ID'];
		#下一节点是否为条件节点
		if ($this->iscondition)
		{
			#..一、当前节点不为条件节点，直接更新到下一条件节点
			#..且上一节点为单向或不存在
			if($nowInfo[0]['NODETYPE']!='condition')
			{
				#获取当前节点平行的节点条数
				$thisThreadNode = $this->getExtensionByNextId($fnextId,$isEnd);
				$isone = false ;
				foreach ($thisThreadNode as $item)
				{
					if($item['ISONELINE']=='1'||$item['NODETYPE']=='task')$isone = true;
				}
				if($isone)
				{ 
                    
					//$this->upThreadDb($fnextId,$isEnd);
                    if($this->nextStepId!=$this->zanStop&&!empty($this->nextStepId))
                    {
                        $this->upThreadDb($this->nextStepId,$this->nextStepId);
                    }
                    else $this->upThreadDb($fnextId,$isEnd);
                    
					return true;
				}
                
                //print_r($thisThreadNode);exit;
			}
			#..二、
			#1 、满足条件-单独走一条线路 ： 条件节点判断 ，根据执行结果判断下一节点
			#2013-05-13 更改为根据当前条件节点来判断 上一部多个节点是否完成 
			# - 如果上一部为一条数据 即单方向执行
			//$cNextId = $this->doCondition($nextInfo) ;
			#获取当前节点平行的节点条数
			$thisThreadNode = $this->getExtensionByNextId($fnextId,$isEnd);
			if(count($thisThreadNode)==1){
				# 如果当前节点的下一节点为条件节点 ，判断条件节点是否为单向走向
				if($nextInfo[0]['ISONELINE']=='1')
				{
                    /*
					$nresult = false ;
					foreach ($nextInfo as $n=>$nitem)
					{
						if($nitem['CONDITIONS']==$this->isSuccessFlow)$nresult = $n ;
					}
					$this->oneline = $ni;
					#取返回的值，确定走向、
					if(false===$nresult)$this->erro(10);
					$this->upThreadDb($nextInfo[$nresult]['NEXTNODE'],$nextInfo[$nresult]['NEXTNODE']);
                    
                    */
                    
                    if($this->nextStepId!=$this->zanStop&&!empty($this->nextStepId))
                    {
                        $this->upThreadDb($this->nextStepId,$this->nextStepId);
                    }
                    else{
                        
                        return true;
                    } 
				}
				else $this->upThreadDb($fnextId,$isEnd);
			}
			else { 
				# - 上一部为多条支线。 根据条件判断当前节点上的信息 ，各支线是否都完成 
				#更新当前节点状态
				if(!$this->upNowNodeIsDone($nowInfo[0]['NODEID'],$nowInfo[0]['NEXTNODE']))$this->erro(7);
				#判断当前所有条件是否已完成，
				if ($results = $this->doExtension($nowInfo,$thisThreadNode,$nextInfo))
				{
					#满足所有条件 - 更新节点到当前判断节点
					#-1-- 不通过的情况 $result = 2
					if($results===2)
					{
						foreach ($nextInfo as $item)
						{
							if($item['CONDITIONS']==$result)
							{
								$this->delProcessNode($this->flowId,$this->bizid);
								$this->upThreadDb($item['NEXTNODE'],$item['NEXTNODE']);
							}
						}

					}
					else
					{
						if($nextInfo[0]['ISONELINE']=='1')
						{
							
							//$nresult = false ;
//							foreach ($nextInfo as $n=>$nitem)
//							{
//								if($nitem['CONDITIONS']==$this->isSuccessFlow)$nresult = $n ;
//							}
//							$this->oneline = $ni;
//							#取返回的值，确定走向、
//							if($nresult===false)$this->erro(10);
//							$this->upThreadDb($nextInfo[$nresult]['NEXTNODE'],$nextInfo[$nresult]['NEXTNODE']);
                            if($this->nextStepId!=$this->zanStop&&!empty($this->nextStepId))
                            {
                                $this->upThreadDb($this->nextStepId,$this->nextStepId);
                            }
						}
						else $this->upThreadDb($nextInfo[0]['NODEID'],$nextInfo[0]['NEXTNODE']);
					}
				}
				#返回false则表示，还有步骤没有做或暂缓等状态
			}
		}
		else { //非条件节点直接进去下一节点流程
			
			$this->upThreadDb($fnextId,$isEnd);
		}
	}
	/**
	 * 处理上一支线是否符合条件 往下走
	 * **/
	private function doExtension($nowInfo , $thisThreadNode,$nextInfo)
	{
		if($nextInfo[0]['NEEDCOMP']>0)
		{
			#只要完成数大于或等于条件设定条数，便返回TRUE
			$count = $this->getCountProcessByNextId($nowInfo[0]['NEXTNODE']);
			if($count[0]['cnt']>=$nextInfo[0]['NEEDCOMP'])return true;
		}
		#判断同一条支线上所有信息是否满足条件
		$exInfo = $this->getExtensionProcessByNextId($nowInfo[0]['NEXTNODE']);
		foreach ($exInfo as $eitem)
		{
			$ep[$eitem['NODEID']] = $eitem['ISDONE'];
		}
		$comp = true ;
		foreach ($thisThreadNode as $item)
		{
			if($ep[$item['NODEID']]<=0)$comp = false;
			else if($ep[$item['NODEID']]=='2')$comp = 2;
			#只要其中一条出现未完成状态则停止匹配
			if($comp==false)break;
		}
		return $comp;
	}
	/**
	 * 更新线程
	 * */
	private function upThreadDb($cNextId,$isEnd)
	{
		if (is_array($this->bizid)||$this->bizid<=0)$this->erro(4);
		$isEnd = empty($isEnd) ? 1 : 0 ;
        #取下一节点的下一节点是否为空或下一节点为结束节点 则该流程结束
        $cNextInfo = $this->getNodeByNextId($cNextId); 
        if($cNextInfo[0]['NEXTNODE']<=0)$isEnd = 1;
		#首先判断是否存在该线程
        $this->tid = $this->getFlowInThread() ;
		if ($this->tid >0)$sql = " update flowthread set tid='{$cNextId}' , lastnode = '{$_GET['nid']}' , isend = '$isEnd' where tid = '{$this->tid}' and flowid = '{$this->flowId}' and bizid = '{$this->bizid}'  ";
		else{
             $sql = " insert into flowthread set flowid = '{$this->flowId}' , tid = '{$cNextId}' , lastnode = '{$_GET['nid']}' , type='1' , bizid = '{$this->bizid}' , BIZCONTROL = '{$this->moduleName}' , NO = '{$this->NO}' , NOTE = '{$this->NOTE}' ";
        }
		//echo $sql;exit;
		$this->mysqldb->execute($sql);
	}
	/**
	 * 条件节点的判断
	 * 条件判断类型 1、方法 ：格式：f:check:true
	 * */
	private function doCondition($nextInfo)
	{
		foreach ($nextInfo as $item)
		{
			$condition = explode(':',$item['condition']);
			switch ($condition[0])
			{
				case 'f':$cNextId = $this->cFunc($condition);break;
				case 'sql':$cNextId = $this->cSql($condition);break;
				case 'webService':$cNextId = $this->cWebService($condition);break;
			}
		}
		$cNextId = empty($cNextId) ? $nextInfo[0]['ID'] : $cNextId ;
		//根据判断条件得出将执行哪一条节点
		//if($cNextSuc)
		return $cNextId;
	}
	/**
	 * 节点完成后的检验处理方法
	 * */
	private function doNeedCheck($condition)
	{
		$check = $condition;
		$doway = explode(":",$check);
		$arr = array('func'=>'cFunc','sql'=>'cSql','webService'=>'cWebService');
		if(array_key_exists($doway[0],$arr))
		{
			$func = $arr[$doway[0]];
			$this->$func($doway[1]);
		}
	}
	/**
	 * 判断执行类型 function
	 * */
	private function cFunc($func)
	{
		if (empty($func))return true;
		#引入当前module类
		$class = $this->moduleName;
		$mod = $class.'Model';
		$model = new $mod();
		if(!method_exists($mod,$func))$this->erro(8,$func);
		$model->bizid = $this->bizid;
		$model->nodeId = $this->nodeId;
		$model->nodeName = $this->nodeName;
		return $model->$func();
	}
	/**
	 * 判断执行类型 sql
	 * */
	private function cSql($condition)
	{
		return $cNextId;
	}
	/**
	 * 判断执行类型 webService
	 * */
	private function cWebService($condition)
	{
		return $cNextId;
	}

	/********************数据库处理******************************/
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
	public function doPostUpperOnly($data,$isIcnov='utf-8',$isconv=0)
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
					if($isIcnov=='utf-8'||$isIcnov=='UTF-8')$val = iconv('GBK','UTF-8',$val);
					elseif($isIcnov=='gbk'||$isIcnov=='GBK')$val = iconv('UTF-8','GBK',$val);
					if($isconv==0)$dataNew[strtoupper($key)] = $val;
					else $dataNew[$key] = $val;
				}
			}
		}
		return $dataNew;
	}
	/********************模版文件处理方式******************************/
	/**
	 * 重写display方法
	 * */
	public function display($moduleName = '', $methodName = '')
	{
		$this->parse($moduleName, $methodName);
	}
	/**
	 * 重写assign方法
	 * */
//	public function assign($name,$value)
//	{
//		//var_dump($this->view);
//	}
	/**
	 * 模版正则替换页面中form表单
	 * 如：在html页面中添加有“<CANDORFORM></CANDORFORM>”标签 则，将像html页面中插入隐藏input及替换掉form
	 * @access $content 页面源码
	 * @access $temp 0，为模版解析带PHP执行代码解析 1 生成temp临时文件 2 直接包含原始文件
	 * */
	private function temp_parse($content,$temp=0)
	{
		
		$view = (array)$this->view;
		if($temp==2){
			extract($view);
			/* 切换到视图文件所在的目录，以保证视图文件中的包含路径有效。*/
	        $currentPWD = getcwd();
	        $viewFile = $this->viewFile ;
	        chdir(dirname($viewFile));
	        //ob_start();

			include ($viewFile);
			//$this->output .= ob_get_contents();
        	//ob_end_clean();
			chdir($currentPWD);
			exit;
		}
		$content = preg_replace("/([\n\r]+)\t+/s","\\1",$content);
		#去掉PHP注释
		$content = preg_replace("/\/\*(.*)\*\//s","",$content);
		#执行php语句
		$content = $temp == 0 ? $this->temp_php_replace($content,$view) : $content;
		#form表单
		//$content = $this->temp_form_replace($content);
		//$content = preg_replace("/\<CANDORFORM\>/s", "aaa",$content);//替换掉__candorForm__
		
		if ($temp==1) {#暂时不开启
			/*
			if(file_exists($this->tempFile))include($this->tempFile);
			else 
			{
				$strlen = file_put_contents($this->tempFile, $content);  //将编译后的内容放在php文件中   
 	    		@chmod($compiledtplfile, 0777); 
			}
			*/
		}
		else exit($content);
	}
	/**
	 * 模版php执行语句替换
	 * */
	private function temp_php_replace($content,$view)
	{
		extract($view);
		#<?= 获取替换
		$phpTag = '/<\?=\s*([^;]+)[\s;]*\?>/';
		preg_match_all($phpTag, $content,$php);//print_r($php);
		if (count($php[1])>0) {
			foreach ($php[1] as $key=>$item)
			{ 
				eval("\$val = $item;");
				$content = preg_replace($phpTag,$val,$content,1);
			}
		}

		#<? 获取替换
		$phpTag = "/<\?(.+)\?>/";
		preg_match_all($phpTag, $content,$php);
		if (count($php[1])>0) {
			foreach ($php[1] as $key=>$item)
			{
				$val = eval($item);
				$content = preg_replace($phpTag,$val,$content,1);
			}
		}
		return $content;
	}
	/**
	 * 模版form替换
	 */
	private function temp_form_replace($content)
	{
		
		preg_match_all("/<CANDORFORM>(.*?)<\/CANDORFORM>/s", $content,$cform);
		foreach ($cform[1] as $item)
		{
			$content = preg_replace("/<CANDORFORM>[\n\r]*(.*?)[\n\r]*<\/CANDORFORM>[\n\r]*/s", "\\1",$content,1);
		}
		//$content = $content[1];
		return $content;
	}
	/**
	 *提交页面form表单返回地址 
	 * 
	 */
	private function temp_deparse($content)
	{
		
	}
	/**
	 *更新模版文件 
	 */
	public function temp_update($moduleName = '', $methodName = '')
	{
		if(empty($moduleName)) $moduleName = $this->moduleName;
        if(empty($methodName)) $methodName = $this->methodName;
        $moduleName = strtolower(trim($moduleName));
        $methodName = strtolower(trim($methodName));
        $tempFile  = $this->app->getModuleRoot() . $moduleName. $this->pathFix . 'tmp' . $this->pathFix . $methodName . '.tpl.php';
        if(file_exists($tempFile))@unlink($tempFile);
	}
	/**
     * 解析视图文件。
     *
     * 如果没有指定模块名和方法名，则取当前模块的当前方法。
     *
     * @param string $moduleName    模块名。
     * @param string $methodName    方法名。
     * @access public
     * @return void
     */
    public function parse($moduleName = '', $methodName = '')
    {
        if(empty($moduleName)) $moduleName = $this->moduleName;
        if(empty($methodName)) $methodName = $this->methodName;
        $moduleName = strtolower(trim($moduleName));
        $methodName = strtolower(trim($methodName));
        $this->viewFile = $this->app->getModuleRoot() . $moduleName . $this->pathFix . 'view' . $this->pathFix . $methodName . '.' . $this->app->getViewType() . '.php';
        $this->tempFile  = $this->app->getModuleRoot() . $moduleName. $this->pathFix . 'tmp' . $this->pathFix . $methodName . '.tpl.php';
        if(!file_exists($this->viewFile)) $this->app->error("the view file $this->viewFile not found", __FILE__, __LINE__, $exit = true);
		$fileContent = file_get_contents($viewFile);
		$fileContent = $this->temp_parse($fileContent,2); //0直接输出1生成temp文件包含
    }
/***********************错误处理**************************************/ 
	/**
     * 错误信息输出
     * @access public
     * @return null
     */
	public function erro($type,$nodeid='')
	{
		$style = 'error';
		$url =  'javascript:;';
		switch ($type)
		{
			case 1 : $mess = '该流程不存在';break;
			case 2 : $mess = '您没有该流程的权限';break;
			case 3 : $mess = '该流程没有启用';break;
			case 4 : $mess = '流程执行失败';break;
			case 5 : $mess = '流程'.$this->flowId.'执行节点'.$nodeid.'中缺少ACTION';break;
			case 6 : $mess = '远程WebService没有打开！请检查';break;
			case 7 : $mess = '操作当前流程失败！';break;
			case 8 : $mess = '当前module中无'.$nodeid.'此方法！';break;
			case 9 : $mess = '当前control中无'.$nodeid.'此方法！';break;
			case 10 : $mess = '当前control中返回的值不在判断条件中！';break;
			case -1 : $mess = '[错误提示]：'.$nodeid;break;
			case 0 : $mess = '流程执行成功';$style='yes';$url=Util::creferer();break;
		} 
		if($this->ajax)
		{
			$msg['res']= $type==0 ? 0 : 1;
			$msg['msg'] = $type." , ".$mess;
			$msg['bizid'] = $this->bizid ;
			$msg['msgOther'] = $this->msgOther ;
			echo json_encode($msg);exit;
		}
		Util::page_msg($mess,$style,$url);
		exit;
	}
	/**
	 * 错误信息输出，页面错误输出
	 * */
	public function showMsg($message,$url,$time='2')
	{
		$this->assign("msg",$message); //提示信息
		$this->assign("time",$time); //跳转时间
		$this->assign("url",$url); //跳转地址
		$this->display("common","msg"); //调用模板
		exit;
	}
	/**
	 * 登录超时检查
	 * */
	public function loginCheckOut()
	{
		if($this->isLoginStatus===false)return false;
		if (empty($this->userid)) {
        	$this->showMsg("[错误代码]:登录超时，请重新登录！","/index/logout");
        }
	}
	private function getFlowHisInTable()
	{
		#插入后台审核日志
		$AUDITRESULT = is_array($_POST['AUDITRESULT']) ? $_POST['AUDITRESULT'][0] : $_POST['AUDITRESULT'];
		$AUDITNOTE = is_array($_POST['AUDITNOTE']) ? $_POST['AUDITNOTE'][0] : $_POST['AUDITNOTE'];
        foreach($this->nextSteps as $item)
        {
            if($AUDITRESULT==$item['value'])$AUDITRESULT = $item['tagname'];
        }
		$flowTable[] = array('table'=>'CSBIZ.FLOWHIS','rows'=>array(
																array(
																	'ID'=>'',
																	'FLOWTYPE'=>$this->config->module->name,
																	'NODEORDER'=>$this->nodeId,
																	'NODELEVEL'=>'1',
																	'NODELEVELNAME'=>$this->nextInfo[0]['NODEID'],
																	'NODENAME'=>$this->nodeName,
																	'AUDITRESULT'=>$AUDITRESULT,
																	'AUDITNOTE'=>$AUDITNOTE,
																),
															));
		#取当前节点信息，并查找当前节点平行的节点是否完成
		#判断同一条支线上所有信息是否满足条件
		$nextInfo = $this->nextInfo;
		$exInfo = $this->getExtensionProcessByNextId($nextInfo[0]['NODEID']);
		foreach ($exInfo as $eitem)
		{
			$ep[$eitem['NODEID']] = $eitem['ISDONE'];
		}
		$comp = true ;
		$thisThreadNode = $this->getExtensionByNextId($nextInfo[0]['NODEID']);
		foreach ($thisThreadNode as $item)
		{
//			if($ep[$item['NODEID']]<=0)$comp = false;
//			else if($ep[$item['NODEID']]=='2')$comp = 2;
//			if($comp==false)break;
			if($item['NODETYPE']!='condition')
			{
				$isdone = $ep[$item['NODEID']]<=0&&$item['NODEID']!=$this->nodeId ? '否' : '是' ;
				$rows[] = array(
								'ID'=>'',
								'FLOWTYPE'=>$this->config->module->name,
								'NODEORDER'=>$item['NODEID'],
								'NODELEVEL'=>$item['NEXTNODE'],
								'ISDONE'=>$isdone,
							);
			}
		}

		$flowTable[] = array('table'=>'CSBIZ.FLOWTRANS','rows'=>$rows);
		$this->inflowHis = $flowTable;
        $this->soapLink->inflowHis = $this->inflowHis ;
	}
	/**
	+----------------------------------------------------------
	* 附件处理
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param $attatch $_FILES['img']
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	public function attatchDealTo64($attatch)
	{
		$path = $this->app->getAppRoot()."www/upload/";
		if(!is_dir($path))Util::mk_dir($path);
		$form_data = $attatch['tmp_name'];
		$form_name = $attatch['name'];
		$form_error = $attatch['error'];
		$form_type = pathinfo($form_name);
		$tempname = time().rand();
		$path = $path.$tempname.".".$form_type['extension'];
		if($form_error==0) {
				move_uploaded_file($form_data,$path);
				//将图片转化为二进制
				$picture =  $path;
				$psize = filesize($picture);
				$handle = fopen($picture, "rb");
				$doccontent = base64_encode(fread($handle, $psize));
				fclose($handle);
				@unlink($path);
		}
		$images['type'] = $form_type['extension'];
		$images['size'] = $psize;
		$images['content'] = $doccontent; 
		return $images;
	}

}
?>
