<?php
 /**
��* ���ݿ�PDO����
��* @version 1.0
��* @author �޶�����
  * Created on 2009-01-23
  * Modify on 2009-01-23
��*/

// ����Smarty��
require_once('adodb5/adodb.inc.php');

class DbAdo {

	/**
	* ����ģʽ,����DbAdo��Ψһʵ��,���ݿ��������Դ
	* @var object
	* @access private
    */
	public $conn;

	/**
	* ���ݿ�����Ӳ�������
	* @var array
	* @access private
    */
	private $config;

	/**
	* �Ƿ�������ģʽ
	* @var bool
	* @access private
    */
	private $debug;

	/**
	 * ���캯����
	 * @param $dbconfig ���ݿ����������Ϣ
	 */
    public function __construct(){
		$this->setConfig();
		 if (!isset($this->conn)){
			switch($this->config->driverMode){
				case 'pdo':
					//PDO, which only works with PHP5, accepts a driver specific connection string: 
					if (!class_exists('PDO')) Util::throw_exception("��֧��:PDO");
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
						//use the mysql\mssql extension��ʹ��php��չ����
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

	/* ����config����*/
	private function setConfig(){
		global $config;
		$this->config = $config->db;
	}

}
?>