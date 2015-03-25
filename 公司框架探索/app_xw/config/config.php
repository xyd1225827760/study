<?php
/**
 * The config file of CandorPHP.
 *
 * @copyright   Copyright: 2010
 * @author      LuoDong <751450467@qq.com>
 * @package     CandorPHP
 * @version     $Id: config.php,v 1.3 2012/02/15 07:30:02 lj Exp $
 */
$config->version     = '2.0.STABLE.090620'; // 版本号，切勿修改。
$config->debug       = true;              // 是否打开debug功能。
$config->webRoot     = '/';                // web网站的根目录。
$config->encoding    = 'gb2312';            // 网站的编码。
$config->cookiePath  = '/';               // cookie的有效路径。
$config->cookieLife  = time() + 2592000;  // cookie的生命周期。
$config->auth        = false;             //是否开启认证

$config->requestType = 'PATH_INFO';       // 如何获取当前请求的信息，可选值：PATH_INFO|GET
$config->pathType    = 'clean';           // requestType=PATH_INFO: 请求url的格式，可选值为full|clean，full格式会带有参数名称，clean则只有取值。
$config->requestFix  = '/';               // requestType=PATH_INFO: 请求url的分隔符，可选值为斜线、下划线、减号。后面两种形式有助于SEO。
$config->moduleVar   = 'm';               // requestType=GET: 模块变量名。
$config->methodVar   = 'f';               // requestType=GET: 方法变量名。
$config->viewVar     = 't';               // requestType=GET: 模板变量名。

$config->views       = ',html,xml,json,txt,csv,doc,pdf,'; // 支持的视图列表。
$config->langs       = 'zh-cn,zh-tw,zh-hk,en';            // 支持的语言列表。
$config->themes      = 'default';                         // 支持的主题列表。

$config->default->view   = 'html';                      // 默认的视图格式。
$config->default->lang   = 'zh-cn';                     // 默认的语言。
$config->default->theme  = 'default';                   // 默认的主题。已有主题blue、default、
$config->default->module = 'userlogin';                 // 默认的模块。当请求中没有指定模块时，加载该模块。
$config->default->method = 'index';                     // 默认的方法。当请求中没有指定方法或者指定的方法不存在时，调用该方法。
$config->access = true;				                    // 是否开启-权限访问
$config->dbh = false;                                   // 是否开启-MySql链接对象

//SQLServer Config
$config->db->debug       = false;				  // 是否打开debug功能。
$config->db->driverMode = 'ado';                  // 系统支持pdo、adodb5的驱动
$config->db->driver     = 'odbc_mssql';            // 其中pdo目前mysql、pgsql、odbc，adodb5支持pdo/ado_mssql/odbc_mssql,odbc_oracle,db2/扩展mssql,mysql等
$config->db->host       = '129.19.100.195';            // mysql主机。SP2013\SQLEXPRESS
$config->db->port       = '1433';                 // 主机端口号mysql:3306,mssql:1433,pgsql:5432
$config->db->name       = 'xw_production';        // 数据库名称。
$config->db->user       = 'sa';                   // 数据库用户名。
$config->db->password   = 'Cdrj1234';                  // 密码。

//PostgreSQL Config
$config->pgdb->debug       = false;				   // 是否打开debug功能。
$config->pgdb->errorMode  = PDO::ERRMODE_WARNING;  // PDO的错误模式: PDO::ERRMODE_SILENT|PDO::ERRMODE_WARNING|PDO::ERRMODE_EXCEPTION
$config->pgdb->persistant = false;                 // 是否打开持久连接。
$config->pgdb->driver     = 'pgsql';               // pdo模式,目前mysql、pgsql、odbc
$config->pgdb->host       = '129.19.100.195';           // 主机。SP2013\SQLEXPRESS
$config->pgdb->port       = '5432';                // mysql:3306,pgsql:5432
$config->pgdb->name       = 'openerp';            // 数据库名称。
$config->pgdb->user       = 'openpg';             // 数据库用户名。
$config->pgdb->password   = 'openpgpwd';               // 密码。
$config->pgdb->encoding   = 'gbk';                // 数据库的编码utf8,gbk。
$config->pgdb->dsn = "{$config->pgdb->driver}:host={$config->pgdb->host};dbname={$config->pgdb->name}";//php5pdo

$config->wsdl->WSLoginService = "http://129.19.100.195/WSLogin.asmx?wsdl";
$config->wsdl->ProMainService = "http://129.19.100.195/ProMain.asmx?wsdl";

/*************************** 系统文件上传配置 **********************************/
define('WEB_ROOT', str_replace("config", "www", dirname(__FILE__)));// 站点根目录WEB_ROOT
define('WEB_UPLOAD', WEB_ROOT."\\upload");// 文件上传目录WEB_UPLOAD
define('CK_WATER',false);                                 //是否开启水印
define('WATER_POS','4');                                //定义水印位置
define('WATER_PIC_PATH',WEB_ROOT.'/theme/default/images/water/news_mark.gif');//定义水印图片
define('FONTFACE_PATH',WEB_ROOT.'/data/encode/simhei.ttf');     //定义水印字体
define('WATER_TEXT','水印文字');                        //定义水印文字
define('FONT_SIZE','25');                               //定义水印字体大小
define('FONT_COLOR','#ff0000');                         //定义水印字体颜色
define('WATER_PCT','100');                              //定义水印透明度
define('WATER_TYPE','overlay');                         //使用水印类型

/*************************** 项目配置 **********************************/
$config->project->category = array('100'=>'生产线','101'=>'从业主体','102'=>'XXX','109'=>'系统维护','900'=>'系统管理');
$config->project->prefix = array('100'=>'mrp_','101'=>'cyzt_','102'=>'assert_','103'=>'sys_');
$config->project->icon = array('100'=>'crm.gif','101'=>'book.gif','102'=>'bbs2.gif','109'=>'bbs2.gif');
$config->project->submodule = array(
	'100'=>array('100001'=>'生产管理','100002'=>'产品管理','100003'=>'计划管理','100004'=>'生产调度','100005'=>'作业管理','100006'=>'质量管理'),
	'101'=>array('101001'=>'组织管理','101002'=>'角色管理','101003'=>'模块管理'),
	'102'=>array('102001'=>'XXX','102002'=>'XXX','102003'=>'XXX','102004'=>'XXX'),
	'109'=>array('109001'=>'XXX','109002'=>'XXX','103003'=>'XXX','109004'=>'XXX')
);


/*************************** 系统模块配置 **********************************/
$config->workstage_fieldvalue = array(
	0=>"有效:1,无效:0",
	1=>"是:1,否:0",
	2=>"检测:1,自检:2,抽查:3,无视:4"
);

$config->workstage_group = array(
	0=>"1组",
	1=>"2组",
	2=>"3组"
);
