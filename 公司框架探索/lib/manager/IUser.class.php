<?php


/**
 * 用户接口类。
 * 
 * 
 * @package lib
 * @author luodong
 * @version 1.0
 * @created 13-一月-2011 11:06:01
 */
interface IUser
{

	/**
	 * 获取用户信息。
	 * 
	 * @param userid    用户id
	 */
	function getUserInfo($userid);

	/**
	 * 获取用户权限。
	 * 
	 * @param userName    用户名。
	 * @param passWord    用户名。
	 * @param md5key     验证码。
	 */
	function getUserRole($userName, $passWord, $md5key='');

	/**
	 * 用户登录。
	 * 
	 * @param userName    用户名。
	 * @param passWord    用户名。
	 * @param md5key     验证码。
	 * @param usbKey     usb密钥。
	 */
	function login($userName, $passWord, $md5key='', $usbKey='');

	/**
	 * 根据userid，修改用户信息。
	 * 
	 * @param userid    修改用户id。
	 * @param userInfo    修改的用户信息。
	 */
	function modifyUserInfo($userid, $userInfo);

	/**
	 * 根据用户id，修改用户密码
	 * 
	 * @param userid    修改用户id。
	 * @param oldPwd    旧密码。
	 * @param newPwd    新密码。
	 */
	function modifyUserPwd($userid, $oldPwd, $newPwd);

}
?>