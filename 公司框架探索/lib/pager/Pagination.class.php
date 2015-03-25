<?php
class pager_Pagination{
   private  $page_size;//ÿҳ��ʾ����Ŀ��        *
   private  $page_array = array();//���������ҳ������
   private  $subPage_link;//ÿ����ҳ������        *
   private  $subPage_type;//��ʾ��ҳ������
   private  $page_html;//��󷵻صķ�ҳhtml����
   private  $app;//ȫ�ֵ�app����
   private  $moduleName;//��ǰ�����moduleName��
   private  $methodName;//��ǰ�����methodName��
   private  $getdata_nums;//��ǰ����ȡ�����ݵ���Ŀ��
   private  $act;//��ǰ�������
   private  $order; //����ʽ��Ĭ�ϵ���
   private  $field;//�����ֶ�
   public   $link_param;//��ǰ����������
   static   $dbmaxid;//���м�¼������id��
   static   $dbminid;//���м�¼����С��id��
   static   $totalnum;//�ܼ�¼����
   static   $totalpage;//��ҳ��
   static   $ajax;//����ajax
   private $subpage=5;//ÿ����ʾ��ҳ��

   /*
   __construct��SubPages�Ĺ��캯���������ڴ������ʱ���Զ�����.
   @$page_size   ÿҳ��ʾ����Ŀ��
   @nums ����Ŀ��
   @current_num ��ǰ��ѡ�е�ҳ
   @sub_pages    ÿ����ʾ��ҳ��
   @subPage_link ÿ����ҳ������
   @subPage_type ��ʾ��ҳ������
  
   ��@subPage_type=1��ʱ��Ϊ��ͨ��ҳģʽ
       example��   ��4523����¼,ÿҳ��ʾ10��,��ǰ��1/453ҳ [��ҳ] [��ҳ] [��ҳ] [βҳ]
       ��@subPage_type=2��ʱ��Ϊ�����ҳ��ʽ
       example��   ��ǰ��1/453ҳ [��ҳ] [��ҳ] 1 2 3 4 5 6 7 8 9 10 [��ҳ] [βҳ]lastid=10&order=desc&field=id&nums=10
   */
	function __construct($page_size='10',$orderField='ID',$totalnum='',$ajax=false){
		$this->setApp();
		$this->setModuleName();
        $this->setMethodName();

		$this->page_size    = $page_size;                                              //ÿҳ��ʾ����Ŀ��
		$this->getdata_nums = isset($_GET['nums'])?$_GET['nums']:0;            //�������ݵ��ܼ�¼��
		$this->act          = isset($_GET['act'])?$_GET['act']:'';             //��ǰ�������
		$this->subPage_link = $this->methodName.'.html?';                      //ÿ����ҳ������
		$this->order        = isset($_GET['order']) ? $_GET['order'] : 'desc'; //����ʽ��Ĭ�ϵ���
		$this->field        = $orderField;                                     //�����ֶ�
		$this->totalnum = $totalnum;
		$this->ajax = $ajax ;
		//if(empty($this->field))Util::page_msg('�봫�������ֶ�','error','/');
	}

	/**
	* ���ط�ҳhtml����
	* @access public
	* @return string
	*/
	public function get_page_html($page_size=10,$srcParam,$subPage_type=1){
		//print_r($srcParam);
		$this->page_size=intval($srcParam['pageSize']);   //ÿҳ��ʾ����Ŀ��
		$this->getdata_nums=$srcParam['nums'];            //�������ݵ��ܼ�¼��
		$this->act=$srcParam['act'];                      //��ǰ�������
		$this->subPage_link=$this->methodName.'.html?';   //ÿ����ҳ������
		foreach($srcParam as $key=>$row){
			$this->subPage_link .= $key."=".$row."&";
		}
		$this->show_SubPages($subPage_type);
		$this->link_param = $this->subPage_link;
		return $this->page_html;
	}
	/**
	* ���ط�ҳhtml����
	* @access public
	* @return string
	*/
	public function get_page_html_2013($subPage_html,$subPage_type=1){
		$this->subPage_link='/'.$this->moduleName.'/'.$this->methodName.'.html?'.$subPage_html.'&page=';   //ÿ����ҳ������
		$this->show_SubPages($subPage_type);
		$this->link_param = $this->subPage_link;
		return $this->page_html;
	}

	/**
	* ���ط�ҳhtml����
	* @access public
	* @return string
	*/
	public function get_page_html_2011($dataList,$subPage_type=1,$bizType='getdata'){
		//print_r($srcParam);
		//�������ݵ��ܼ�¼��,����0,���������÷�ҳ���������id����Сidֵ
		//���ݼ�ֵ
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
				//���ݷ������ݵļ�ֵ����ȡ���������Сid���ֽ�ESTATE@CONTDEFMODEL-ID_62
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

		//���ɲ�ѯ����
		unset($_GET['act']);
		foreach($_GET as $key=>$row){
			$this->subPage_link .= $key."=".$row."&";
		}

		$this->show_SubPages($subPage_type);
		$this->link_param = $this->subPage_link;
		return $this->page_html;
	}
	
	/**
	* ���ط�ҳhtml����
	* @access public
	* @return string
	*/
	public function get_page_html_user_2012($dataList,$subPage_type=1,$bizType='getdata'){
		//print_r($srcParam);
		//�������ݵ��ܼ�¼��,����0,���������÷�ҳ���������id����Сidֵ
		//���ݼ�ֵ
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
				
			
				//���ݷ������ݵļ�ֵ����ȡ���������Сid���ֽ�ESTATE@CONTDEFMODEL-ID_62
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
		
		//���ɲ�ѯ����
		unset($_GET['act']);
		foreach($_GET as $key=>$row){
			$this->subPage_link .= $key."=".$row."&";
		} 
		$this->show_SubPages($subPage_type);
		$this->link_param = $this->subPage_link;
		return $this->page_html;
	}

	/**
	 * ���ز�ѯ����
	 * @access public
     * @return string $where
	 */
	public function where_2011(){
		$where = " fetch first {$this->page_size} rows only ";
        //echo "Ĭ������".$this->order."<br>";
		//echo "��ǰ���������".$this->act."<br>";
		//echo "����¼id��".$_GET['maxid']."<br>";
		//echo "��С��¼id��".$_GET['minid']."<br>";
		//�ж�����
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
		//�ж�����
		$_SESSION['pageer'] = empty($_GET['page']) || empty($_SESSION['pageer']) ? 1 : $_SESSION['pageer'];
		$this->totalpage  = ceil($this->totalnum/$this->page_size) ;
		
		if($this->order=='desc'){
			#��һҳ
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
		
		#���õ�ǰҳ
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
	* ���÷�ҳ���������СID 2013-04-18 by young
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
	* ��ȡ��ҳ�� 2013-04-18 by young
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
	 * ���ز�ѯ����
	 * @access public
	 * @param array $srcParam
     * @return string $where
	 */
	public function where($srcParam){
		$where = " fetch first {$srcParam['pageSize']} rows only ";
		//�ж�����
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
	* __destruct�������������಻��ʹ�õ�ʱ����ã��ú��������ͷ���Դ��
	*/
	function __destruct(){
		unset($page_size);
		unset($page_array);
		unset($subPage_link);
		unset($subPage_type);
		unset($page_str);
	}
  
	/*
	* show_SubPages�������ڹ��캯�����档���������ж���ʾʲô���ӵķ�ҳ  
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
  
	/* ����app����*/
    private function setApp()
    {
        global $app;
        $this->app = $app;
    }

    /* ����moduleName��*/
    private function setModuleName()
    {
        $this->moduleName = $this->app->getModuleName();
    }

    /* ����methodName��*/
    private function setMethodName()
    {
        $this->methodName = $this->app->getMethodName();
    }
  
	/*
	 *  ������ͨģʽ�ķ�ҳ
	 *  [��ҳ] [��ҳ] [��ҳ] [βҳ]
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
					$subPageCss1Str.="<li class='off'>[��ҳ]</li>";
					$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>��һҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>βҳ</a>]</li>";
				}elseif(@$_SESSION['dbminid']==$_GET['minid'] and $this->order=='asc'){
					$subPageCss1Str.="<li class='off'>[��ҳ]</li>";
					$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>��һҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>βҳ</a>]</li>";
				}else{
					$subPageCss1Str.="<li class='on'>[<a href='$firstPageUrl'>��ҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$prewPageUrl'>��һҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>��һҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>βҳ</a>]</li>";
				}
			}else{
				//������һ�汾��ҳ����,�����ؼ�¼Ϊ��ʱ����ʾ����һҳ
				$subPageCss1Str.="<li class='off'>[��ҳ]</li>";
				$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>��һҳ</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>βҳ</a>]</li>";
			}
		}elseif($this->act=='next'){//echo $_SESSION['dbminid'].'=='.$_GET['minid'];
			if($this->getdata_nums==$this->page_size){
				//���ؼ�¼��=��ҳ����������βҳ��Ҳ���Բ���βҳ������жϣ���Ŀǰ�޷��ж�
				$subPageCss1Str.="<li class='on'>[<a href='$firstPageUrl'>��ҳ</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='$prewPageUrl'>��һҳ</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>��һҳ</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>βҳ</a>]</li>";
			}else{
				//���ؼ�¼��<��ҳ����ȷ��Ϊβҳ
				$subPageCss1Str.="<li class='on'>[<a href='$firstPageUrl'>��ҳ</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='$prewPageUrl'>��һҳ</a>]</li>";
				$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
				$subPageCss1Str.="<li class='off'>[βҳ]</li>";
			}
		}elseif($this->act=='frist'){
			$subPageCss1Str.="<li class='off'>[��ҳ]</li>";
			$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
			$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>��һҳ</a>]</li>";
			$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>βҳ</a>]</li>";
		}elseif($this->act=='last'){
			$subPageCss1Str.="<li class='on'>[<a href='$firstPageUrl'>��ҳ</a>]</li>";
			$subPageCss1Str.="<li class='on'>[<a href='$prewPageUrl'>��һҳ</a>]</li>";
			$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
			$subPageCss1Str.="<li class='off'>[βҳ]</li>";
		}else{
			if($this->getdata_nums==$this->page_size){
				if(@$_SESSION['dbmaxid']==$_GET['maxid'] and $this->order=='desc'){
					$subPageCss1Str.="<li class='off'>[��ҳ]</li>";
					$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>��һҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>βҳ</a>]</li>";
				}elseif(@$_SESSION['dbminid']==$_GET['minid'] and $this->order=='asc'){
					$subPageCss1Str.="<li class='off'>[��ҳ]</li>";
					$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>��һҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>βҳ</a>]</li>";
				}else{
					$subPageCss1Str.="<li class='on'>[<a href='$firstPageUrl'>��ҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$prewPageUrl'>��һҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$nextPageUrl'>��һҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='$lastPageUrl'>βҳ</a>]</li>";
				}
			}else{
				//������һ�汾��ҳ����,�����ؼ�¼Ϊ��ʱ����ʾ���һҳ
				$subPageCss1Str.="<li class='off'>[��ҳ]</li>";
				$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
				$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
				$subPageCss1Str.="<li class='off'>[βҳ]</li>";
			}
		}
		$this->page_html = $subPageCss1Str;
	}
	
	/*
	 *  ����AJAXģʽ�ķ�ҳ
	 *  [��ҳ] [��ҳ] [��ҳ] [βҳ]
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
					$subPageCss1Str.="<li class='off'>[��ҳ]</li>";
					$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$nextPageUrl\")'>��һҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>βҳ</a>]</li>";
				}elseif(@$_SESSION['dbminid']==$_GET['minid'] and $this->order=='asc'){
					$subPageCss1Str.="<li class='off'>[��ҳ]</li>";
					$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$nextPageUrl\")'>��һҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>βҳ</a>]</li>";
				}else{
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>��ҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>��һҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>��һҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>βҳ</a>]</li>";
				}
			}else{
				//������һ�汾��ҳ����,�����ؼ�¼Ϊ��ʱ����ʾ����һҳ
				$subPageCss1Str.="<li class='off'>[��ҳ]</li>";
				$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>��һҳ</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>βҳ</a>]</li>";
			}
		}elseif($this->act=='next'){//echo $_SESSION['dbminid'].'=='.$_GET['minid'];
			if($this->getdata_nums==$this->page_size){
				//���ؼ�¼��=��ҳ����������βҳ��Ҳ���Բ���βҳ������жϣ���Ŀǰ�޷��ж�
				$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$firstPageUrl\")'>��ҳ</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$prewPageUrl\")'>��һҳ</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$nextPageUrl\")'>��һҳ</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>βҳ</a>]</li>";
			}else{
				//���ؼ�¼��<��ҳ����ȷ��Ϊβҳ
				$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$firstPageUrl\")'>��ҳ</a>]</li>";
				$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$prewPageUrl\")'>��һҳ</a>]</li>";
				$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
				$subPageCss1Str.="<li class='off'>[βҳ]</li>";
			}
		}elseif($this->act=='frist'){
			$subPageCss1Str.="<li class='off'>[��ҳ]</li>";
			$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
			$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$nextPageUrl\")'>��һҳ</a>]</li>";
			$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>βҳ</a>]</li>";
		}elseif($this->act=='last'){
			$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$firstPageUrl\")'>��ҳ</a>]</li>";
			$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$prewPageUrl\")'>��һҳ</a>]</li>";
			$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
			$subPageCss1Str.="<li class='off'>[βҳ]</li>";
		}else{
			if($this->getdata_nums==$this->page_size){
				if(@$_SESSION['dbmaxid']==$_GET['maxid'] and $this->order=='desc'){
					$subPageCss1Str.="<li class='off'>[��ҳ]</li>";
					$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$nextPageUrl\")'>��һҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>βҳ</a>]</li>";
				}elseif(@$_SESSION['dbminid']==$_GET['minid'] and $this->order=='asc'){
					$subPageCss1Str.="<li class='off'>[��ҳ]</li>";
					$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$nextPageUrl\")'>��һҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>βҳ</a>]</li>";
				}else{
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$firstPageUrl\")'>��ҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$prewPageUrl\")'>��һҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$nextPageUrl\")'>��һҳ</a>]</li>";
					$subPageCss1Str.="<li class='on'>[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")'>βҳ</a>]</li>";
				}
			}else{
				//������һ�汾��ҳ����,�����ؼ�¼Ϊ��ʱ����ʾ���һҳ
				$subPageCss1Str.="<li class='off'>[��ҳ]</li>";
				$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
				$subPageCss1Str.="<li class='off'>[��һҳ]</li>";
				$subPageCss1Str.="<li class='off'>[βҳ]</li>";
			}
		}
		$this->page_html = $subPageCss1Str;
	}
	
	/**
	 * �¿��DB2��ҳ
	 * ��4523����¼,ÿҳ��ʾ10��,��ǰ��1/453ҳ [��ҳ] [��ҳ] [��ҳ] [βҳ]
	 * */
	private function subPageCss5(){
		$subPageCss1Str="<div class='pagerbox'>";
		$subPageCss1Str.="��<span class='pagerbox-totalnum'>".$this->totalnum."</span>����¼��";
		$subPageCss1Str.="ÿҳ��ʾ<span class='pagerbox-pagesize'>".$this->page_size."</span>����";
		$subPageCss1Str.="��ǰ��<span class='pagerbox-cpage'>".$this->curr_page."</span>/<span class='pagerbox-tpage'>".$this->totalpage."</span>ҳ <span class='pagerbox-clist'>";
		if($this->curr_page > 1){
			$firstPageUrl=$this->subPage_link."1";
			$prewPageUrl=$this->subPage_link.($this->curr_page-1);
			if($this->ajax) $subPageCss1Str.="[<a href='javascript:;' onclick='getPage(\"$firstPageUrl\")' >��ҳ</a>] "; else $subPageCss1Str.="[<a href='$firstPageUrl'>��ҳ</a>] ";
			if($this->ajax) $subPageCss1Str.="[<a href='javascript:;' onclick='getPage(\"$prewPageUrl\")' >��һҳ</a>] "; else $subPageCss1Str.="[<a href='$prewPageUrl'>��һҳ</a>] ";
		}else {
			$subPageCss1Str.="[��ҳ] ";
			$subPageCss1Str.="[��һҳ] ";
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
			if($this->ajax) $subPageCss1Str.="[<a href='javascript:;' onclick='getPage(\"$nextPageUrl\")' >��һҳ</a>] "; else $subPageCss1Str.=" [<a href='$nextPageUrl'>��һҳ</a>] ";
			if($this->ajax) $subPageCss1Str.="[<a href='javascript:;' onclick='getPage(\"$lastPageUrl\")' >βҳ</a>] "; else $subPageCss1Str.="[<a href='$lastPageUrl'>βҳ</a>] ";
		}else {
			$subPageCss1Str.="[��һҳ] ";
			$subPageCss1Str.="[βҳ] ";
		}
		$this->page_html = $subPageCss1Str."</span><div>";
	}
	
	/*
	* ������������ҳ�������ʼ���ĺ�����
	*/
	private function initArray(){
		for($i=0;$i<$this->subpage;$i++){
		$this->page_array[$i]=$i;
		}
		return $this->page_array;
	}
	/*
	* construct_num_Page�ú���ʹ����������ʾ����Ŀ
	* ��ʹ��[1][2][3][4][5][6][7][8][9][10]
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
