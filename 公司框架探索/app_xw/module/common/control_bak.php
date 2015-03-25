<?php
/**
 * The control file of common module of CandorPHP.
 *
 * @copyright   Copyright: 2010
 * @author      LuoDong <751450467@qq.com>
 * @package     CandorPHP
 * @version     $Id: control.php,v 1.4 2012/02/16 09:53:49 lj Exp $
 */
class common extends control
{
    public function __construct()
    {
		//session_start();
        parent::__construct();

		//����Ȩ�޿��ƣ�����indexģ���У��������淽��ʱ��������÷��ʿ���
		$accessModule = $this->config->default->module;
		$accessMethod = $this->config->default->method;
		$pathInfo = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'';
		$pathInfo = trim($pathInfo, '/');
		if(!empty($pathInfo))
        {
			$dotPos = strpos($pathInfo, '.');
            if($dotPos)
            {
                $pathInfo      = substr($pathInfo, 0, $dotPos);
            }
		}
		if(!empty($pathInfo))
        {
            /* URL�к��в�����Ϣ��*/
            if(strpos($pathInfo, '/') !== false)
            {
                $items = explode('/', $pathInfo);
				$accessModule = $items[0];
				$accessMethod = $items[1];
            }    
            else
            {
				$accessModule = $pathInfo;
            }
        }
		
		if($this->config->access === true)
		{
			$this->accessControl($accessModule,$accessMethod);
		}
    }
	
	/* ���ʿ��� */
	public function accessControl($accessModule='',$accessMethod='')
	{	
		if($_SESSION['admin']=='1') {
			//����ǳ�������Ա�����Է���ϵͳ�����й���
		}else{
			$crt = isset($this->app->access->$accessModule->$accessMethod->access)?$this->app->access->$accessModule->$accessMethod->access:false;
			if(!$crt){
				//ģ���еĸ÷���������ҪȨ�޿���
				//$msg = '��ȷ��'.$accessModule.' ģ�� '.$accessMethod.' �����Ƿ���config/access.phpȨ�޿����ļ��д��ڣ�';
				//Util::page_msg($msg,'alert','/');exit;
			}else{
				/*********************************************************
				TODO:
				���Ҫʵ�ַ������ƣ����뱣֤���߻�ȡ�� ���ʿ���Ȩ�������ʽһ�£�����ʵ��ͳһ�ķ��ʿ���
				Ȩ�޿���˵����mysql��¼��ȡ��Ȩ�������ʽ���£�
				Array(
						[0] => 100101
						[1] => 200101
						[2] => 200102
						[3] => 200103
						[4] => 200104
						[5] => 200105
						[6] => 200106
						[7] => 200107
						[column_7] => Array
							(
								[columnid] => 7
								[parentid] => 0
								[depth] => 1
							)

						[column_72] => Array
							(
								[columnid] => 72
								[parentid] => 7
								[depth] => 2
							)

						[column_74] => Array
							(
								[columnid] => 74
								[parentid] => 72
								[depth] => 3
							)

						[column_73] => Array
							(
								[columnid] => 73
								[parentid] => 7
								[depth] => 2
							)

					)

				 * Ȩ�޿���˵������ҵ������¼��ȡ��Ȩ�������ʽ���£�
					 Array(
							[0] => Array
								(
									[0] => 150136
									[1] => ����ǩԼϵͳ
									[2] => ����Ȩ
								)

							[1] => Array
								(
									[0] => 150112
									[1] => ����ǩԼϵͳ
									[2] => �鿴Ȩ
								)

							[2] => Array
								(
									[0] => 150118
									[1] => ����ǩԼϵͳ
									[2] => �鿴Ȩ
								)

							[3] => Array
								(
									[0] => 150125
									[1] => ����ǩԼϵͳ
									[2] => �鿴Ȩ
								)
					)
				************************************************************/
				
				if(in_array($crt,$_SESSION['role'])){
					//����cms��ĿȨ�޹�����Ϊ����ģ���¿��Գ��ֺܶ���Ŀ
					//TODO:
				}else{
					$msg = '��û�з��� '.$accessModule.' ģ�� '.$accessMethod.' ������Ȩ��';
					Util::page_msg($msg,'alert','/');exit;
				}
			}
		}
	}

	/**
	 * ��ɫ�б�
	 *
	 * @return array $list
	 * 
	 */
	public function rolearray(){
    	$dom = new DOMDocument("1.0","utf-8");
		$dom->load($this->app->getAppRoot().'/module/rolemanage/role.xml');
    	$role=$dom->getElementsByTagName('role');
    	$list = array();
		foreach ($role as $key=>$root){
			foreach($root->attributes as $mk){
				$list[$mk->nodeValue] = array();
				$access=$root->getElementsByTagName('access');
				$i=0;
				$columnid = '';
				foreach ($access as $k=>$item){
					foreach($item->attributes as $itemchild){
						if($itemchild->nodeName=='value') {
							$list[$mk->nodeValue][$i] = $itemchild->nodeValue;
							$i++;
							//break;
						}
						if($itemchild->nodeName=='columnid') {
							$columnid = $itemchild->nodeValue;
							$list[$mk->nodeValue]["column_".$columnid][$itemchild->nodeName] = $itemchild->nodeValue;
							//break;
						}
						if($itemchild->nodeName=='parentid') {
							$list[$mk->nodeValue]["column_".$columnid][$itemchild->nodeName] = $itemchild->nodeValue;
						}
						if($itemchild->nodeName=='depth') {
							$list[$mk->nodeValue]["column_".$columnid][$itemchild->nodeName] = $itemchild->nodeValue;
						}
					}
				}
			}	
		}
		return $list;
    }

}
