<?php


/**
 * 流程引擎接口类。
 * 
 * 
 * @package lib
 * @author luojun
 * @version 1.0
 * @created 2012-9-26
 */
interface IFlowControl
{

	/**
	 * 获取上一结点信息
	 * 
	 * @param curnode 当前结点信息
	 * return prenode 
	 */
	function getPreNodeInfo($curnode);

	/**
	 * 获取下一结点信息
	 * 
	 * @param curnode 当前结点信息
	 * return nextnode 
	 */
	function getNextNodeInfo($curnode);

	/**
	 * 获取用户相关信息
	 * 
	 * @param type 1-用户、2-权限组、3-单位、4-角色
	 * @param cnds 条件参数以数组形式表达
	 * return userinfo 
	 */
	function getUserInvolveInfo($type,$cnds);


	/**
	 *  标签方法
	 * 
	 * @param labelname 标签名称
	 * @param cnds 条件参数以数组形式表达
	 * return labelrs 
	 */
	function opLabelBiz($labelname);


	/**
	 * 增加结点
	 * 
	 * @param curnode 当前结点信息
	 * return boolean 
	 */
	function addNodes($curnode);

	/**
	 * 修改结点
	 * 
	 * @param nodeid 当前结点流水号
	 * @param curnode 当前结点信息
	 * return boolean 
	 */
	function updateNodes($nodeid,$curnode);


	/**
	 * 删除结点
	 * 
	 * @param nodeid 结点ID
	 * return boolean 
	 */
	function deleteNodes($nodeid);
}
?>