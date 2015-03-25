<?php
class pager_Pagination{
   private  $page_size;//每页显示的条目数        *
   private  $page_array = array();//用来构造分页的数组
   private  $subPage_link;//每个分页的链接        *
   private  $subPage_type;//显示分页的类型
   private  $page_html;//最后返回的分页html代码
   private  $app;//全局的app对象。
   private  $moduleName;//当前请求的moduleName。
   private  $methodName;//当前请求的methodName。
   private  $getdata_nums;//当前请求取回数据的条目数
   private  $act;//当前点击动作
   private  $order; //排序方式，默认倒序
   private  $field;//排序字段
   public   $link_param;//当前搜索参数串
   static   $dbmaxid;//所有记录中最大的id号
   static   $dbminid;//所有记录中最小的id号
   static   $totalnum;//总记录条数
   static   $totalpage;//总页数
   static   $ajax;//开启ajax
   private $subpage=5;//每次显示的页数

   /*
   __construct是SubPages的构造函数，用来在创建类的时候自动运行.
   @$page_size   每页显示的条目数
   @nums 总条目数
   @current_num 当前被选中的页
   @sub_pages    每次显示的页数
   @subPage_link 每个分页的链接
   @subPage_type 显示分页的类型
  
   当@subPage_type=1的时候为普通分页模式
       example：   共4523条记录,每页显示10条,当前第1/453页 [首页] [上页] [下页] [尾页]
       当@subPage_type=2的时候为经典分页样式
       example：   当前第1/453页 [首页] [上页] 1 2 3 4 5 6 7 8 9 10 [下页] [尾页]lastid=10&order=desc&field=id&nums=10
   */
	function __construct($page_size='10',$orderField='ID',$totalnum='',$ajax=false){
		$this->setApp();
		$this->setModuleName();
        $this->setMethodName();

		$this->page_size    = $page_size;                                              //每页显示的条目数
		$this->getdata_nums = isset($_GET['nums'])?$_GET['nums']:0;            //返回数据的总记录数
		$this->act          = isset($_GET['act'])?$_GET['act']:'';             //当前点击动作
		$this->subPage_link = $this->methodName.'.html?';                      //每个分页的链接
		$this->order        = isset($_GET['order']) ? $_GET['order'] : 'desc'; //排序方式，默认倒序
		$this->field        = $orderField;                                     //排序字段
		$this->totalnum = $totalnum;
		$this->ajax = $ajax ;
		//if(empty($this->field))Util::page_msg('请传入排序字段','error','/');
	}

	/**
	* 返回分页html代码
	* @access public
	* @return string
	*/
	public function get_page_html($page_size=10,$srcParam,$subPage_type=1){
		//print_r($srcParam);
		$this->page_size=intval($srcParam['pageSize']);   //每页显示的条目数
		$this->getdata_nums=$srcParam['nums'];            //返回数据的总记录数
		$this->act=$srcParam['act'];                      //当前点击动作
		$this->subPage_link=$this->methodName.'.html?';   //每个分页的链接
		foreach($srcParam as $key=>$row){
			$this->subPage_link .= $key."=".$row."&";
		}
		$this->show_SubPages($subPage_type);
		$this->link_param = $this->subPage_link;
		return $this->page_html;
	}
	/**
	* 返回分页html代码
	* @access public
	* @return string
	*/
	public function get_page_html_2013($subPage_html,$subPage_type=1){
		$this->subPage_link='/'.$this->moduleName.'/'.$this->methodName.'.html?'.$subPage_html.'&page=';   //每个分页的链接
		$this->show_SubPages($subPage_type);
		$this->link_param = $this->subPage_link;
		return $this->page_html;
	}

	/**
	* 返回分页html代码
	* @access public
	* @return string
	*/
	public function get_page_html_2011($dataList,$subPage_type=1,$bizType='getdata'){
		//print_r($srcParam);
		//返回数据的总记录数,大于0,则重新设置分页参数的最大id、最小id值
		//数据键值
		$listkeys = array_keys($dataList);//print_r($listkeys);
		$this->getdata_nums = count($listkeys);
		if($this->getdata_nums>0){
			if($bizType=='getdata'){
				if($this->getdata_nums==1){
					$fristdata = $listkeys[0];
					$lastdata  = $listkeys[0];
				}else{
					$fristdata = $listkeys[0];
					$lastdata  = $listkeys[$this->getdata_nums-1];
				}
				//根据返回数据的键值，获取数据最大、最小id，分解ESTATE@CONTDEFMODEL-ID_62
				$sfristdata = explode("_",$fristdata);
				$slastdata = explode("_",$lastdata);
				if($sfristdata[1]>=$slastdata[1]){
					$_SESSION['lastmaxid'] = $sfristdata[1];
					$_SESSION['lastminid'] = $slastdata[1];
					$_GET['maxid'] = $sfristdata[1];
					$_GET['minid'] = $slastdata[1];
				}else{
					$_SESSION['lastmaxid'] = $slastdata[1];
					$_SESSION['lastminid'] = $sfristdata[1];
					$_GET['maxid'] = $slastdata[1];
					$_GET['minid'] = $sfristdata[1];
				}
			}else{
				if($this->getdata_nums==1){
					$fristdata = $dataList[0];
					$lastdata  = $dataList[0];
				}else{
					$fristdata = $dataList[0];
					$lastdata  = $dataList[$this->getdata_nums-1];
				}
				if($fristdata['RECORD']['EXECQUERY-ID']>=$lastdata['RECORD']['EXECQUERY-ID']){
					$_GET['maxid'] = $fristdata['RECORD']['EXECQUERY-ID'];
					$_GET['minid'] = $lastdata['RECORD']['EXECQUERY-ID'];
				}else{
					$_GET['maxid'] = $lastdata['RECORD']['EXECQUERY-ID'];
					$_GET['minid'] = $fristdata['RECORD']['EXECQUERY-ID'];
				}
			}
		}else{
			$_GET['maxid'] = 0;
			$_GET['minid'] = 0;
		}

		if(!isset($_SESSION['dbminid'])){
			$_SESSION['dbmaxid'] = $_GET['maxid'];
		}elseif($_SESSION['dbmaxid']<$_GET['maxid'] and $_GET['minid']>0){
			$_SESSION['dbmaxid'] = $_GET['maxid'];
		}
		if(!isset($_SESSION['dbminid'])){
			$_SESSION['dbminid'] = $_GET['minid'];
		}elseif($_SESSION['dbminid']>$_GET['minid'] and $_GET['minid']>0){
			$_SESSION['dbminid'] = $_GET['minid'];
		}

		//生成查询参数
		unset($_GET['act']);
		foreach($_GET as $key=>$row){
			$this->subPage_link .= $key."=".$row."&";
		}

		$this->show_SubPages($subPage_type);
		$this->link_param = $this->subPage_link;
		return $this->page_html;
	}
	
	/**
	* 返回分页html代码
	* @access public
	* @return string
	*/
	public function get_page_html_user_2012($dataList,$subPage_type=1,$bizType='getdata'){
		//print_r($srcParam);
		//返回数据的总记录数,大于0,则重新设置分页参数的最大id、最小id值
		//数据键值
		foreach($dataList as $key=>$item)
		{
			$dataList[$key]['id']=isset($dataList[$key]['ID']) ?$dataList[$key]['ID'] :$dataList[$key]['id'];
		}
		$listkeys = array_keys($dataList);
		//print_r($listkeys);
		
		$this->getdata_nums = count($listkeys);
		if($this->getdata_nums>0){
			if($bizType=='getdata'){
				if($this->getdata_nums==1){
					$fristdata = $listkeys[0];
					$lastdata  = $listkeys[0];
				}else{
					$fristdata = $listkeys[0];
					$lastdata  = $listkeys[$this->getdata_nums-1];
				}
				
			
				//根据返回数据的键值，获取数据最大、最小id，分解ESTATE@CONTDEFMODEL-ID_62
				//$sfristdata = explode("_",$fristdata);
				//$slastdata = explode("_",$lastdata);
				//print_r($sfristdata);print_r($slastdata);
				if($dataList[$fristdata]['id']>=$dataList[$lastdata]['id']){
					$_SESSION['lastmaxid'] = $dataList[$fristdata]['id'];
					$_SESSION['lastminid'] = $dataList[$lastdata]['id'];
					$_GET['maxid'] =$dataList[$fristdata]['id'];
					$_GET['minid'] = $dataList[$lastdata]['id'];
				}else{
					$_SESSION['lastmaxid'] = $dataList[$lastdata]['id'];
					$_SESSION['lastminid'] = $dataList[$fristdata]['id'];
					$_GET['maxid'] = $dataList[$lastdata]['id'];
					$_GET['minid'] = $dataList[$fristdata]['id'];
				}
			}else{
				if($this->getdata_nums==1){
					$fristdata = $dataList[0];
					$lastdata  = $dataList[0];
				}else{
					$fristdata = $dataList[0];
					$lastdata  = $dataList[$this->getdata_nums-1];
				}
				
				if($fristdata['RECORD']['EXECQUERY-ID']>=$lastdata['RECORD']['EXECQUERY-ID']){
					$_GET['maxid'] = $fristdata['RECORD']['EXECQUERY-ID'];
					$_GET['minid'] = $lastdata['RECORD']['EXECQUERY-ID'];
				}else{
					$_GET['maxid'] = $lastdata['RECORD']['EXECQUERY-ID'];
					$_GET['minid'] = $fristdata['RECORD']['EXECQUERY-ID'];
				}
			}
		}else{
			$_GET['maxid'] = 0;
			$_GET['minid'] = 0;
		}

		if(!isset($_SESSION['dbminid'])){
			$_SESSION['dbmaxid'] = $_GET['maxid'];
		}elseif($_SESSION['dbmaxid']<$_GET['maxid'] and $_GET['minid']>0){
			$_SESSION['dbmaxid'] = $_GET['maxid'];
		}
		if(!isset($_SESSION['dbminid'])){
			$_SESSION['dbminid'] = $_GET['minid'];
		}elseif($_SESSION['dbminid']>$_GET['minid'] and $_GET['minid']>0){
			$_SESSION['dbminid'] = $_GET['minid'];
		}
		
		//生成查询参数
		unset($_GET['act']);
		foreach($_GET as $key=>$row){
			$this->subPage_link .= $key."=".$row."&";
		} 
		$this->show_SubPages($subPage_type);
		$this->link_param = $this->subPage_link;
		return $this->page_html;
	}

	/**
	 * 返回查询条件
	 * @access public
     * @return string $where
	 */
	public function where_2011(){
		$where = " fetch first {$this->page_size} rows only ";
        //echo "默认排序：".$this->order."<br>";
		//echo "当前点击动作：".$this->act."<br>";
		//echo "最大记录id：".$_GET['maxid']."<br>";
		//echo "最小记录id：".$_GET['minid']."<br>";
		//判断排序
		if($this->order=='desc'){
			if($this->act=='next'){
				if($_GET['minid']){
					$where = " and {$this->field}<{$_GET['minid']} order by {$this->field} {$this->order} ".$where;
				}else{
					$where = " order by {$this->field} {$this->order} ".$where;
				}
			}elseif($this->act=='pre'){
				if($_GET['maxid']){
					$where = " and {$this->field}>{$_GET['maxid']} order by {$this->field} asc ".$where;
				}else{
					$where = " order by {$this->field} asc ".$where;
				}
			}elseif($this->act=='frist'){
				$where = " order by {$this->field} desc ".$where;
			}elseif($this->act=='last'){
				$where = " order by {$this->field} asc ".$where;
			}else{
				$where = " order by {$this->field} desc fetch first {$this->page_size} rows only ";
			}
		}else{
			if($this->act=='next'){
				if($_GET['maxid']){
					$where = " and {$this->field}>{$_GET['maxid']} order by {$this->field} {$this->order} ".$where;
				}else{
					$where = " order by {$this->field} {$this->order} ".$where;
				}
			}elseif($this->act=='pre'){
				if($_GET['minid']){
					$where = " and {$this->field}<{$_GET['minid']} order by {$this->field} desc ".$where;
				}else{
					$where = " order by {$this->field} desc ".$where;
				}
			}elseif($this->act=='frist'){
				$where = " order by {$this->field} asc ".$where;
			}elseif($this->act=='last'){
				$where = " order by {$this->field} desc ".$where;
			}else{
				$where = " order by {$this->field} asc fetch first {$this->page_size} rows only ";
			}
		}
		//echo $where;
		return $where;
	}
	/**
	+----------------------------------------------------------
	* DB2 + JQGRID 2013-04-18 by young
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param 
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	public function where_2013(){
		$where = " fetch first {$this->page_size} rows only ";
		//判断排序
		$_SESSION['pageer'] = empty($_GET['page']) || empty($_SESSION['pageer']) ? 1 : $_SESSION['pageer'];
		$this->totalpage  = ceil($this->totalnum/$this->page_size) ;
		
		if($this->order=='desc'){
			#下一页
			if($_SESSION['pageer']<$_GET['page'])$where = " and {$this->field} < {$_SESSION['pageer_minid']} order by {$this->field} {$this->order} ".$where;
			elseif ($_SESSION['pageer']>$_GET['page']) $where = " and {$this->field}>{$_SESSION['pageer_maxid']} order by {$this->field} asc ".$where;
			elseif ($_GET['page']==1)$where = " order by {$this->field} desc ".$where;
			elseif($_GET['page']==$this->totalpage) $where = " order by {$this->field} asc ".$where;
			else $where = " order by {$this->field} desc fetch first {$this->page_size} rows only ";
		}
		else {
			if($_SESSION['pageer']<$_GET['page'])$where = " and {$this->field} > {$_SESSION['pageer_maxid']} order by {$this->field} {$this->order} ".$where;
			elseif ($_SESSION['pageer']>$_GET['page']) $where = " and {$this->field}<{$_SESSION['pageer_minid']} order by {$this->field} asc ".$where;
			elseif ($_GET['page']==1)$where = " order by {$this->field} asc ".$where;
			elseif($_GET['page']==$this->totalpage) $where = " order by {$this->field} desc ".$where;
			else $where = " order by {$this->field} asc fetch first {$this->page_size} rows only ";
		}
		
		#设置当前页
		$_SESSION['pageer'] = $_GET['page'] ;
		return $where;
	}
	/**
	+----------------------------------------------------------
	* DB2 + JQGRID 2013-04-18 by young
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param 
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	public function where_row(){
		$page = !empty($_GET["page"])?$_GET["page"]:1;
		$this->totalpage  = ceil($this->totalnum/$this->page_size) ;
		$this->curr_page = $page > $this->totalpage && $page!=1 ? $this->totalpage : $page;
		$start = ($this->curr_page-1)*$this->page_size;
		$end = $this->curr_page*$this->page_size;
		$where = " ROW_ID > {$start} and ROW_ID <= {$end} ";

		return $where;
	}
	/**
	+----------------------------------------------------------
	* 设置分页搜索最大最小ID 2013-04-18 by young
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param 
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	public function setPagerId($info)
	{
		if(count($info)>0)
		{ 
			$field = preg_replace("/.*\.(.*)/s","\\1",$this->field) ;
			$_SESSION['pageer_minid'] = $info[0][$field];
			$_SESSION['pageer_maxid'] = $info[count($info)-1][$field];
		}
	}
	/**
	+----------------------------------------------------------
	* 获取总页数 2013-04-18 by young
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param 
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	public  function getTotalPage()
	{
		return $this->totalpage;
	}
	
	/**
	 * 返回查询条件
	 * @access public
	 * @param array $srcParam
     * @return string $where
	 */
	public function where($srcParam){
		$where = " fetch first {$srcParam['pageSize']} rows only ";
		//判断排序
		if($srcParam['order']=='desc'){
			if($srcParam['act']=='next'){
				if($srcParam['minid'])$where = " and {$srcParam['field']}<{$srcParam['minid']} order by {$srcParam['field']} {$srcParam['order']} ".$where;
			}elseif($srcParam['act']=='pre'){
				if($srcParam['maxid'])$where = " and {$srcParam['field']}>{$srcParam['maxid']} order by {$srcParam['field']} asc ".$where;
				//echo "<font color='red'>".$srcParam['id'].'</font>';
			}elseif($srcParam['act']=='frist'){
				$where = " order by {$srcParam['field']} desc ".$where;
			}elseif($srcParam['act']=='last'){
				$where = " order by {$srcParam['field']} asc ".$where;
			}else{
				$where = " order by {$srcParam['field']} desc fetch first {$srcParam['pageSize']} rows only ";
			}
		}else{
			//$where = " order by {$srcParam['field']} asc fetch first {$srcParam['pageSize']} rows only ";
			if($srcParam['act']=='next'){
				if($srcParam['maxid'])$where = " and {$srcParam['field']}>{$srcParam['maxid']} order by {$srcParam['field']} {$srcParam['order']} ".$where;
			}elseif($srcParam['act']=='pre'){
				if($srcParam['minid'])$where = " and {$srcParam['field']}<{$srcParam['minid']} order by {$srcParam['field']} desc ".$where;
				//echo "<font color='red'>".$srcParam['id'].'</font>';
			}elseif($srcParam['act']=='frist'){
				$where = " order by {$srcParam['field']} asc ".$where;
			}elseif($srcParam['act']=='last'){
				$where = " order by {$srcParam['field']} desc ".$where;
			}else{
				$where = " order by {$srcParam['field']} asc fetch first {$srcParam['pageSize']} rows only ";
			}
		}
		return $where;
	}

	/*
	* __destruct析构函数，当类不在使用的时候调用，该函数用来释放资源。
	*/
	function __destruct(){
		unset($page_size);
		unset($page_array);
		unset($subPage_link);
		unset($subPage_type);
		unset($page_str);
	}
  
	/*
	* show_SubPages函数用在构造函数里面。而且用来判断显示什么样子的分页  
	*/
	private function show_SubPages($subPage_type){
		$subtype = subPageCss.$subPage_type;
		if(method_exists(__CLASS__,$subtype))$this->$subtype();
//		if($subPage_type == 1){
//			$this->subPageCss1();
//		}elseif ($subPage_type == 2){
//			$this->subPageCss2();
//		}elseif ($subPage_type == 3){
//			$this->subPageCss3();
//		}elseif ($subPage_type == 3){
//			$this->subPageCss3();
//		}elseif ($subPage_type == 4){
//			$this->subPageCss4();
//		}
	}
  
	/* 设置app对象。*/
    private function setApp()
    {
        global $app;
        $this->app = $app;
    }

    /* 设置moduleName。*/
    private function setModuleName()
    {
        $this->moduleName = $this->app->getModuleName();
    }

    /* 设置methodName。*/
    private function setMethodName()
    {
        $this->methodName = $this->app->getMethodName();
    }
  
	/*
	 *  构造普通模式的分页
	 *  [首页] [上页] [下页] [尾页]
	*/
	private function subPageCss1(){
		$subPageCss1Str="";
		$prewPageUrl=$this->subPage_link."act=pre";
		$firstPageUrl=$this->subPage_link."act=frist";
		$lastPageUrl=$this->subPage_link."act=last";
		$nextPageUrl=$this->subPage_link."act=next";
		
		if($this->act=='pre'){
			if($this->getdata_nums==$this->page_size){
				if(@$_SESSION['dbmaxid']==$_GET['maxid'] and $this->order=='desc'){
					$subPageCss1Str.="<li class='off'>[首页]</li>";
					$subPageCss1Str.="<li class='off'>[上一页]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>下一页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>尾页</a>]</li>";
				}elseif(@$_SESSION['dbminid']==$_GET['minid'] and $this->order=='asc'){
					$subPageCss1Str.="<li class='off'>[首页]</li>";
					$subPageCss1Str.="<li class='off'>[上一页]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>下一页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>尾页</a>]</li>";
				}else{
					$subPageCss1Str.="<li class='on'>[<a href='$firstPageUrl'>首页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$prewPageUrl'>上一页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>下一页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>尾页</a>]</li>";
				}
			}else{
				//兼容上一版本分页程序,当返回记录为空时，表示最上一页
				$subPageCss1Str.="<li class='off'>[首页]</li>";
				$subPageCss1Str.="<li class='off'>[上一页]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>下一页</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>尾页</a>]</li>";
			}
		}elseif($this->act=='next'){//echo $_SESSION['dbminid'].'=='.$_GET['minid'];
			if($this->getdata_nums==$this->page_size){
				//返回记录数=分页数，可能是尾页、也可以不是尾页，如何判断？答：目前无法判断
				$subPageCss1Str.="<li class='on'>[<a href='$firstPageUrl'>首页</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='$prewPageUrl'>上一页</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>下一页</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>尾页</a>]</li>";
			}else{
				//返回记录数<分页数，确定为尾页
				$subPageCss1Str.="<li class='on'>[<a href='$firstPageUrl'>首页</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='$prewPageUrl'>上一页</a>]</li>";
				$subPageCss1Str.="<li class='off'>[下一页]</li>";
				$subPageCss1Str.="<li class='off'>[尾页]</li>";
			}
		}elseif($this->act=='frist'){
			$subPageCss1Str.="<li class='off'>[首页]</li>";
			$subPageCss1Str.="<li class='off'>[上一页]</li>";
			$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>下一页</a>]</li>";
			$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>尾页</a>]</li>";
		}elseif($this->act=='last'){
			$subPageCss1Str.="<li class='on'>[<a href='$firstPageUrl'>首页</a>]</li>";
			$subPageCss1Str.="<li class='on'>[<a href='$prewPageUrl'>上一页</a>]</li>";
			$subPageCss1Str.="<li class='off'>[下一页]</li>";
			$subPageCss1Str.="<li class='off'>[尾页]</li>";
		}else{
			if($this->getdata_nums==$this->page_size){
				if(@$_SESSION['dbmaxid']==$_GET['maxid'] and $this->order=='desc'){
					$subPageCss1Str.="<li class='off'>[首页]</li>";
					$subPageCss1Str.="<li class='off'>[上一页]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>下一页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>尾页</a>]</li>";
				}elseif(@$_SESSION['dbminid']==$_GET['minid'] and $this->order=='asc'){
					$subPageCss1Str.="<li class='off'>[首页]</li>";
					$subPageCss1Str.="<li class='off'>[上一页]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>下一页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>尾页</a>]</li>";
				}else{
					$subPageCss1Str.="<li class='on'>[<a href='$firstPageUrl'>首页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$prewPageUrl'>上一页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>下一页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>尾页</a>]</li>";
				}
			}else{
				//兼容上一版本分页程序,当返回记录为空时，表示最后一页
				$subPageCss1Str.="<li class='off'>[首页]</li>";
				$subPageCss1Str.="<li class='off'>[上一页]</li>";
				$subPageCss1Str.="<li class='off'>[下一页]</li>";
				$subPageCss1Str.="<li class='off'>[尾页]</li>";
			}
		}
		$this->page_html = $subPageCss1Str;
	}
	
	/*
	 *  构造AJAX模式的分页
	 *  [首页] [上页] [下页] [尾页]
	*/
	private function subPageCss4(){
		$subPageCss1Str="";
		$prewPageUrl=$this->subPage_link."act=pre";
		$firstPageUrl=$this->subPage_link."act=frist";
		$lastPageUrl=$this->subPage_link."act=last";
		$nextPageUrl=$this->subPage_link."act=next";
		
		if($this->act=='pre'){
			if($this->getdata_nums==$this->page_size){
				if(@$_SESSION['dbmaxid']==$_GET['maxid'] and $this->order=='desc'){
					$subPageCss1Str.="<li class='off'>[首页]</li>";
					$subPageCss1Str.="<li class='off'>[上一页]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$nextPageUrl\")'>下一页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>尾页</a>]</li>";
				}elseif(@$_SESSION['dbminid']==$_GET['minid'] and $this->order=='asc'){
					$subPageCss1Str.="<li class='off'>[首页]</li>";
					$subPageCss1Str.="<li class='off'>[上一页]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$nextPageUrl\")'>下一页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>尾页</a>]</li>";
				}else{
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>首页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>上一页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>下一页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>尾页</a>]</li>";
				}
			}else{
				//兼容上一版本分页程序,当返回记录为空时，表示最上一页
				$subPageCss1Str.="<li class='off'>[首页]</li>";
				$subPageCss1Str.="<li class='off'>[上一页]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>下一页</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>尾页</a>]</li>";
			}
		}elseif($this->act=='next'){//echo $_SESSION['dbminid'].'=='.$_GET['minid'];
			if($this->getdata_nums==$this->page_size){
				//返回记录数=分页数，可能是尾页、也可以不是尾页，如何判断？答：目前无法判断
				$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$firstPageUrl\")'>首页</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$prewPageUrl\")'>上一页</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$nextPageUrl\")'>下一页</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>尾页</a>]</li>";
			}else{
				//返回记录数<分页数，确定为尾页
				$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$firstPageUrl\")'>首页</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$prewPageUrl\")'>上一页</a>]</li>";
				$subPageCss1Str.="<li class='off'>[下一页]</li>";
				$subPageCss1Str.="<li class='off'>[尾页]</li>";
			}
		}elseif($this->act=='frist'){
			$subPageCss1Str.="<li class='off'>[首页]</li>";
			$subPageCss1Str.="<li class='off'>[上一页]</li>";
			$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$nextPageUrl\")'>下一页</a>]</li>";
			$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>尾页</a>]</li>";
		}elseif($this->act=='last'){
			$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$firstPageUrl\")'>首页</a>]</li>";
			$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$prewPageUrl\")'>上一页</a>]</li>";
			$subPageCss1Str.="<li class='off'>[下一页]</li>";
			$subPageCss1Str.="<li class='off'>[尾页]</li>";
		}else{
			if($this->getdata_nums==$this->page_size){
				if(@$_SESSION['dbmaxid']==$_GET['maxid'] and $this->order=='desc'){
					$subPageCss1Str.="<li class='off'>[首页]</li>";
					$subPageCss1Str.="<li class='off'>[上一页]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$nextPageUrl\")'>下一页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>尾页</a>]</li>";
				}elseif(@$_SESSION['dbminid']==$_GET['minid'] and $this->order=='asc'){
					$subPageCss1Str.="<li class='off'>[首页]</li>";
					$subPageCss1Str.="<li class='off'>[上一页]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$nextPageUrl\")'>下一页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>尾页</a>]</li>";
				}else{
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$firstPageUrl\")'>首页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$prewPageUrl\")'>上一页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$nextPageUrl\")'>下一页</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>尾页</a>]</li>";
				}
			}else{
				//兼容上一版本分页程序,当返回记录为空时，表示最后一页
				$subPageCss1Str.="<li class='off'>[首页]</li>";
				$subPageCss1Str.="<li class='off'>[上一页]</li>";
				$subPageCss1Str.="<li class='off'>[下一页]</li>";
				$subPageCss1Str.="<li class='off'>[尾页]</li>";
			}
		}
		$this->page_html = $subPageCss1Str;
	}
	
	/**
	 * 新框架DB2分页
	 * 共4523条记录,每页显示10条,当前第1/453页 [首页] [上页] [下页] [尾页]
	 * */
	private function subPageCss5(){
		$subPageCss1Str="<div class='pagerbox'>";
		$subPageCss1Str.="共<span class='pagerbox-totalnum'>".$this->totalnum."</span>条记录，";
		$subPageCss1Str.="每页显示<span class='pagerbox-pagesize'>".$this->page_size."</span>条，";
		$subPageCss1Str.="当前第<span class='pagerbox-cpage'>".$this->curr_page."</span>/<span class='pagerbox-tpage'>".$this->totalpage."</span>页 <span class='pagerbox-clist'>";
		if($this->curr_page > 1){
			$firstPageUrl=$this->subPage_link."1";
			$prewPageUrl=$this->subPage_link.($this->curr_page-1);
			if($this->ajax) $subPageCss1Str.="[<a href='javascript:;' onclick='getPage(\"$firstPageUrl\")' >首页</a>] "; else $subPageCss1Str.="[<a href='$firstPageUrl'>首页</a>] ";
			if($this->ajax) $subPageCss1Str.="[<a href='javascript:;' onclick='getPage(\"$prewPageUrl\")' >上一页</a>] "; else $subPageCss1Str.="[<a href='$prewPageUrl'>上一页</a>] ";
		}else {
			$subPageCss1Str.="[首页] ";
			$subPageCss1Str.="[上一页] ";
		}
		
		$a=$this->construct_num_Page();
		for($i=0;$i<count($a);$i++){
			$s=$a[$i];
			if($s == $this->curr_page ){
				 $subPageCss1Str.="<a class='curr' href='javascript:void({$s});'>".$s."</a>";
			}else{
				$url=$this->subPage_link.$s;
				if($this->ajax) $subPageCss1Str.="<a href='javascript:;' onclick='getPage(\"$url\")' >".$s."</a>";else $subPageCss1Str.="<a href='$url' >".$s."</a>";
			}
		}
		
		if($this->curr_page < $this->totalpage){
			$lastPageUrl=$this->subPage_link.$this->totalpage;
			$nextPageUrl=$this->subPage_link.($this->curr_page+1);
			if($this->ajax) $subPageCss1Str.="[<a href='javascript:;' onclick='getPage(\"$nextPageUrl\")' >下一页</a>] "; else $subPageCss1Str.=" [<a href='$nextPageUrl'>下一页</a>] ";
			if($this->ajax) $subPageCss1Str.="[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")' >尾页</a>] "; else $subPageCss1Str.="[<a href='$lastPageUrl'>尾页</a>] ";
		}else {
			$subPageCss1Str.="[下一页] ";
			$subPageCss1Str.="[尾页] ";
		}
		$this->page_html = $subPageCss1Str."</span><div>";
	}
	
	/*
	* 用来给建立分页的数组初始化的函数。
	*/
	private function initArray(){
		for($i=0;$i<$this->subpage;$i++){
		$this->page_array[$i]=$i;
		}
		return $this->page_array;
	}
	/*
	* construct_num_Page该函数使用来构造显示的条目
	* 即使：[1][2][3][4][5][6][7][8][9][10]
	*/
	private function construct_num_Page(){
		if($this->totalpage < $this->subpage){
			$current_array=array();
			for($i=0;$i<$this->totalpage;$i++){ 
				$current_array[$i]=$i+1;
			}
		}else{
			$current_array=$this->initArray();
			if($this->curr_page <= 3){
				for($i=0;$i<count($current_array);$i++){
			   $current_array[$i]=$i+1;
				}
			}elseif ($this->curr_page <= $this->totalpage && $this->curr_page > $this->totalpage - $this->subpage + 1 ){
				for($i=0;$i<count($current_array);$i++){
			   $current_array[$i]=($this->totalpage)-($this->subpage)+1+$i;
				}
			}else{
				for($i=0;$i<count($current_array);$i++){
			   $current_array[$i]=$this->curr_page-2+$i;
				}
			}
		}
		return $current_array;
	}
}
?>
