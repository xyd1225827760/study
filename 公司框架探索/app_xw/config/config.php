<?php
/**
 * The config file of CandorPHP.
 *
 * @copyright   Copyright: 2010
 * @author      LuoDong <751450467@qq.com>
 * @package     CandorPHP
 * @version     $Id: config.php,v 1.3 2012/02/15 07:30:02 lj Exp $
 */
$config->version     = '2.0.STABLE.090620'; // �汾�ţ������޸ġ�
$config->debug       = true;              // �Ƿ��debug���ܡ�
$config->webRoot     = '/';                // web��վ�ĸ�Ŀ¼��
$config->encoding    = 'gb2312';            // ��վ�ı��롣
$config->cookiePath  = '/';               // cookie����Ч·����
$config->cookieLife  = time() + 2592000;  // cookie���������ڡ�
$config->auth        = false;             //�Ƿ�����֤

$config->requestType = 'PATH_INFO';       // ��λ�ȡ��ǰ�������Ϣ����ѡֵ��PATH_INFO|GET
$config->pathType    = 'clean';           // requestType=PATH_INFO: ����url�ĸ�ʽ����ѡֵΪfull|clean��full��ʽ����в������ƣ�clean��ֻ��ȡֵ��
$config->requestFix  = '/';               // requestType=PATH_INFO: ����url�ķָ�������ѡֵΪб�ߡ��»��ߡ����š�����������ʽ������SEO��
$config->moduleVar   = 'm';               // requestType=GET: ģ���������
$config->methodVar   = 'f';               // requestType=GET: ������������
$config->viewVar     = 't';               // requestType=GET: ģ���������

$config->views       = ',html,xml,json,txt,csv,doc,pdf,'; // ֧�ֵ���ͼ�б�
$config->langs       = 'zh-cn,zh-tw,zh-hk,en';            // ֧�ֵ������б�
$config->themes      = 'default';                         // ֧�ֵ������б�

$config->default->view   = 'html';                      // Ĭ�ϵ���ͼ��ʽ��
$config->default->lang   = 'zh-cn';                     // Ĭ�ϵ����ԡ�
$config->default->theme  = 'default';                   // Ĭ�ϵ����⡣��������blue��default��
$config->default->module = 'userlogin';                 // Ĭ�ϵ�ģ�顣��������û��ָ��ģ��ʱ�����ظ�ģ�顣
$config->default->method = 'index';                     // Ĭ�ϵķ�������������û��ָ����������ָ���ķ���������ʱ�����ø÷�����
$config->access = true;				                    // �Ƿ���-Ȩ�޷���
$config->dbh = false;                                   // �Ƿ���-MySql���Ӷ���

//SQLServer Config
$config->db->debug       = false;				  // �Ƿ��debug���ܡ�
$config->db->driverMode = 'ado';                  // ϵͳ֧��pdo��adodb5������
$config->db->driver     = 'odbc_mssql';            // ����pdoĿǰmysql��pgsql��odbc��adodb5֧��pdo/ado_mssql/odbc_mssql,odbc_oracle,db2/��չmssql,mysql��
$config->db->host       = '129.19.100.195';            // mysql������SP2013\SQLEXPRESS
$config->db->port       = '1433';                 // �����˿ں�mysql:3306,mssql:1433,pgsql:5432
$config->db->name       = 'xw_production';        // ���ݿ����ơ�
$config->db->user       = 'sa';                   // ���ݿ��û�����
$config->db->password   = 'Cdrj1234';                  // ���롣

//PostgreSQL Config
$config->pgdb->debug       = false;				   // �Ƿ��debug���ܡ�
$config->pgdb->errorMode  = PDO::ERRMODE_WARNING;  // PDO�Ĵ���ģʽ: PDO::ERRMODE_SILENT|PDO::ERRMODE_WARNING|PDO::ERRMODE_EXCEPTION
$config->pgdb->persistant = false;                 // �Ƿ�򿪳־����ӡ�
$config->pgdb->driver     = 'pgsql';               // pdoģʽ,Ŀǰmysql��pgsql��odbc
$config->pgdb->host       = '129.19.100.195';           // ������SP2013\SQLEXPRESS
$config->pgdb->port       = '5432';                // mysql:3306,pgsql:5432
$config->pgdb->name       = 'openerp';            // ���ݿ����ơ�
$config->pgdb->user       = 'openpg';             // ���ݿ��û�����
$config->pgdb->password   = 'openpgpwd';               // ���롣
$config->pgdb->encoding   = 'gbk';                // ���ݿ�ı���utf8,gbk��
$config->pgdb->dsn = "{$config->pgdb->driver}:host={$config->pgdb->host};dbname={$config->pgdb->name}";//php5pdo

$config->wsdl->WSLoginService = "http://129.19.100.195/WSLogin.asmx?wsdl";
$config->wsdl->ProMainService = "http://129.19.100.195/ProMain.asmx?wsdl";

/*************************** ϵͳ�ļ��ϴ����� **********************************/
define('WEB_ROOT', str_replace("config", "www", dirname(__FILE__)));// վ���Ŀ¼WEB_ROOT
define('WEB_UPLOAD', WEB_ROOT."\\upload");// �ļ��ϴ�Ŀ¼WEB_UPLOAD
define('CK_WATER',false);                                 //�Ƿ���ˮӡ
define('WATER_POS','4');                                //����ˮӡλ��
define('WATER_PIC_PATH',WEB_ROOT.'/theme/default/images/water/news_mark.gif');//����ˮӡͼƬ
define('FONTFACE_PATH',WEB_ROOT.'/data/encode/simhei.ttf');     //����ˮӡ����
define('WATER_TEXT','ˮӡ����');                        //����ˮӡ����
define('FONT_SIZE','25');                               //����ˮӡ�����С
define('FONT_COLOR','#ff0000');                         //����ˮӡ������ɫ
define('WATER_PCT','100');                              //����ˮӡ͸����
define('WATER_TYPE','overlay');                         //ʹ��ˮӡ����

/*************************** ��Ŀ���� **********************************/
$config->project->category = array('100'=>'������','101'=>'��ҵ����','102'=>'XXX','109'=>'ϵͳά��','900'=>'ϵͳ����');
$config->project->prefix = array('100'=>'mrp_','101'=>'cyzt_','102'=>'assert_','103'=>'sys_');
$config->project->icon = array('100'=>'crm.gif','101'=>'book.gif','102'=>'bbs2.gif','109'=>'bbs2.gif');
$config->project->submodule = array(
	'100'=>array('100001'=>'��������','100002'=>'��Ʒ����','100003'=>'�ƻ�����','100004'=>'��������','100005'=>'��ҵ����','100006'=>'��������'),
	'101'=>array('101001'=>'��֯����','101002'=>'��ɫ����','101003'=>'ģ�����'),
	'102'=>array('102001'=>'XXX','102002'=>'XXX','102003'=>'XXX','102004'=>'XXX'),
	'109'=>array('109001'=>'XXX','109002'=>'XXX','103003'=>'XXX','109004'=>'XXX')
);


/*************************** ϵͳģ������ **********************************/
$config->workstage_fieldvalue = array(
	0=>"��Ч:1,��Ч:0",
	1=>"��:1,��:0",
	2=>"���:1,�Լ�:2,���:3,����:4"
);

$config->workstage_group = array(
	0=>"1��",
	1=>"2��",
	2=>"3��"
);
