<?php
 /**
　* 数据库PDO操作
　* @version 1.0
　* @author 罗东大侠
  * Created on 2009-01-23
  * Modify on 2009-01-23
　*/

// 加载Smarty类
require_once('adodb5/adodb.inc.php');

class DbAdo {

	/**
	* 单件模式,保存DbAdo类唯一实例,数据库的连接资源
	* @var object
	* @access private
    */
	public $conn;

	/**
	* 数据库的连接参数配置
	* @var array
	* @access private
    */
	private $config;

	/**
	* 是否开启调试模式
	* @var bool
	* @access private
    */
	private $debug;

	/**
	 * 构造函数，
	 * @param $dbconfig 数据库连接相关信息
	 */
    public function __construct(){
		$this->setConfig();
		 if (!isset($this->conn)){
			switch($this->config->driverMode){
				case 'pdo':
					//PDO, which only works with PHP5, accepts a driver specific connection string: 
					if (!class_exists('PDO')) Util::throw_exception("不支持:PDO");
					$this->conn = &ADONewConnection('pdo');
					//$conn->Connect('mysql:host=localhost',$user,$pwd,$mydb);
					$this->conn->Connect($this->config->dsn,$this->config->user,$this->config->password);
					//$conn->Connect("mysql:host=localhost;dbname=mydb;username=$user;password=$pwd");
				case 'ado':
					if($this->config->driver=='odbc_mssql'){
						//ODBC For Microsoft SQL Server
						$this->conn=&ADONewConnection($this->config->driver);
						$this->conn->charSet = 'utf8'; 
						$this->conn->charPage = '65001';
						//$myDSN="DRIVER={SQL Server Native Client 10.0};SERVER=".$this->config->host.";PORT=1433;UID=".$this->config->user.";PWD=".$this->config->password.";DATABASE=".$this->config->name.";";
						//$this->conn->Connect($myDSN);
						$this->conn->PConnect("Driver={SQL Server};Server=".$this->config->host.";Database=".$this->config->name.";",$this->config->user,$this->config->password);
					}else if($this->config->driver=='ado_mssql'){
						//$dsn = "mssql://$username:$password@$hostname/$databasename";
						$this->conn = &ADONewConnection($this->config->driver);
						$this->conn->charPage = 65001;
						$this->conn->Connect("PROVIDER=MSDASQL;DRIVER={SQL Server};SERVER=".$this->config->host.";DATABASE=".$this->config->name.";UID=".$this->config->user.";PWD=".$this->config->password.";");
					}else if($this->config->driver=='db2'){
						$this->conn = &ADONewConnection($this->config->driver);
						$this->conn->charPage = 65001;
						$dsn = "driver={IBM db2 odbc DRIVER};database=".$this->config->name.";hostname=".$this->config->host.";port=".$this->config->port.";protocol=TCPIP;uid=".$this->config->user."; pwd=".$this->config->password;
						$this->conn->Connect($dns);
					}else{
						//use the mysql\mssql extension，使用php扩展连接
						$this->conn=ADONewConnection($this->config->driver);  # create a connection
						$this->conn->SetCharSet($this->config->encoding);
						$this->conn->PConnect($this->config->host,$this->config->user,$this->config->password,$this->config->name); # connect to MySQL, agora db
					}
			}
			
			$this->conn->debug = $this->config->debug;  
			$this->conn->SetFetchMode(ADODB_FETCH_BOTH);
			return $this->conn;
		}else{
			return $this->conn;
		}
    }

	/* 设置config对象。*/
	private function setConfig(){
		global $config;
		$this->config = $config->db;
	}

}
?>