<?php


/**
 * Ws数据访问接口
 * 
 * 根据指定的xml请求格式，返回JsonData数据
 * @author luodong
 * @version 1.0
 * @created 13-一月-2011 11:06:01
 */
interface IAccessWsData
{

	/**
	 * 新增信息
	 * 
	 * @param data    新增数组数据
	 */
	function addWsData($data);

	/**
	 * 修改信息
	 * 
	 * @param data    更新数据
	 * @param condition    更新记录条件
	 */
	function updateWsData($data, $condition);

	/**
	 * 删除数据
	 * 
	 * @param condition    删除条件
	 */
	function deleteWsData($condition);

}
?>