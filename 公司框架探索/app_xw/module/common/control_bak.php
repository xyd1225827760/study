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

		//访问权限控制，即在index模块中，访问下面方法时，不许调用访问控制
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
            /* URL中含有参数信息。*/
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
	
	/* 访问控制 */
	public function accessControl($accessModule='',$accessMethod='')
	{	
		if($_SESSION['admin']=='1') {
			//如果是超级管理员，可以访问系统的所有功能
		}else{
			$crt = isset($this->app->access->$accessModule->$accessMethod->access)?$this->app->access->$accessModule->$accessMethod->access:false;
			if(!$crt){
				//模块中的该方法，不需要权限控制
				//$msg = '请确认'.$accessModule.' 模块 '.$accessMethod.' 方法是否在config/access.php权限控制文件中存在！';
				//Util::page_msg($msg,'alert','/');exit;
			}else{
				/*********************************************************
				TODO:
				框架要实现方法控制，必须保证两边获取的 访问控制权限数组格式一致，才能实现统一的访问控制
				权限控制说明，mysql登录获取的权限数组格式如下：
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

				 * 权限控制说明，从业主体获登录获取的权限数组格式如下：
					 Array(
							[0] => Array
								(
									[0] => 150136
									[1] => 网上签约系统
									[2] => 备案权
								)

							[1] => Array
								(
									[0] => 150112
									[1] => 网上签约系统
									[2] => 查看权
								)

							[2] => Array
								(
									[0] => 150118
									[1] => 网上签约系统
									[2] => 查看权
								)

							[3] => Array
								(
									[0] => 150125
									[1] => 网上签约系统
									[2] => 查看权
								)
					)
				************************************************************/
				
				if(in_array($crt,$_SESSION['role'])){
					//处理cms栏目权限管理，因为功能模块下可以出现很多栏目
					//TODO:
				}else{
					$msg = '您没有访问 '.$accessModule.' 模块 '.$accessMethod.' 方法的权限';
					Util::page_msg($msg,'alert','/');exit;
				}
			}
		}
	}

	/**
	 * 角色列表
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
