<?php


/**
 * 创建WebService所能接受的xml格式数据
 * @author luodong
 * @version 1.0
 * @created 13-一月-2011 11:06:01
 */
interface ICreateWsXml
{

	/**
	 * 创建callRpc处理的xml
	 * 
	 * @param funid    函数名称id
	 * @param params    参数
	 */
	function callRpc($funid, $params);

	/**
	 * 
	 * @param sqlid    查询sqlid
	 * @param params    参数数组(一、二维)
	 */
	function execsqlbycls($sqlid, $params);

	/**
	 * 创建execsqlbyid处理的xml
	 * 
	 * @param sqlid
	 * @param params
	 */
	function execsqlbyid($sqlid, $params);

	/**
	 * 创建execsql处理的xml
	 * 
	 * @param sqlid
	 * @param params
	 */
	function execsql($sqlid, $params);

	/**
	 * 创建execquery处理的xml
	 * 
	 * @param sqlid
	 * @param params
	 */
	function execquery($sqlid, $params);

	/**
	 * 创建getData处理的xml
	 * 
	 * @param bizid    业务id
	 * @param params
	 */
	function getData($bizid,$condition, $params);

	/**
	 * 创建dealData处理的xml
	 * 
	 * @param bizid    业务id
	 * @param params
	 */
	function dealData($bizid, $params);

}
?>