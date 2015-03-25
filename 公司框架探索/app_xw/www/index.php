<?php
/**
 * The demo app router file of CandorPHP.
 *
 * All request should be routed by this router.
 *
 * @copyright   Copyright: 2010
 * @author      LuoDong <751450467@qq.com>
 * @package     CandorPHP
 * @version     $Id: index.php,v 1.2 2012/01/31 01:47:22 lj Exp $
 */
ini_set("display_errors","on");// 为一个配置选项设置值
date_default_timezone_set('Etc/GMT-8'); //函数设置用在脚本中所有日期/时间函数的默认时区
//header("Content-type: text/html; charset=utf-8");
header("Content-type: text/html; charset=gbk");//设置页面输出时编码的格式
// added by chs@2011-02-12: 临时会话销毁方案，供调试使用
session_start();//从session仓库中加载已经存储的session变量,猜测（使用后才能访问session）
$_SESSION["region"] = isset($_SESSION["region"])?$_SESSION["region"]:'510101';
//$_SESSION["region"] = "510100";
//session_destroy();
// added by chs@2011-02-12: 临时会话销毁方案，供调试使用


/* 记录最开始的时间。*/
$timeStart = _getTime();//获得当前时间（为啥不用date()）

/* 包含必须的类文件。*/
include '../../lib/Util.class.php';//包含下面文件，工具类，自定义的函数
include '../../framework/router.class.php';//路由类
include '../../framework/control.class.php';//控制类,好像未使用。主要用于继承使用
include '../../framework/SecuredControl.class.php';//控制扩展类。主要用于继承使用
include '../../framework/model.class.php';//模型类,好像未使用。主要用于继承使用
include '../../framework/helper.class.php';//帮助类，

/* 如果CandorPHP框架是通过pear方式安装的，可以将上面的注释掉，打开下面的四行语句。*/
//include 'CandorPHP/framework/router.class.php';
//include 'CandorPHP/framework/control.class.php';
//include 'CandorPHP/framework/model.class.php';
//include 'CandorPHP/framework/helper.class.php';

/* 实例化路由对象，并加载配置，连接到数据库，加载common模块。*/
$app    = router::createApp('fg', dirname(dirname(__FILE__)));//dirname(__FILE__)函数返回当前文件的绝对路径中的目录部分。$app 为router对象
$config= $app->loadConfig(); //导入系统配置文件app\config\config.php
if($config->access)$access= $app->loadAccess(); //导入系统权限文件app\config\access.php
if($config->dbh)$dbh=$app->connectDB();//连接数据库

/* 设置客户端所使用的语言、风格。*/
$app->setClientLang();
$app->setClientTheme();

$lang = $app->loadLang();     //导入公共模块app\module\common\lang\zh-cn.php
$common = $app->loadCommon(); //实例化common，即new common(),让其他模块可以调用公共模块中的方法

/* 处理请求，加载相应的模块。*/
$app->parseRequest();
$app->loadModule();

/* Debug信息，监控页面的执行时间和内存占用。*/
$timeUsed = round(_getTime() - $timeStart, 4) * 1000;//round() 函数对浮点数进行四舍五入。
$memory   = round(memory_get_usage() / 1024, 1);



if(!$config->debug)
{
    //echo "<font color='green'>页面运行时间:$timeUsed ms; 内存</strong>:$memory KB</font>";
}

/* 获取系统时间，微秒为单位。*/
function _getTime()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
