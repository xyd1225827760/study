<?php
 /**
　* 数据库PDO操作
　* @version 1.0
　* @author Luodong
  * Created on 2012-06-23
　*/

class Sqlite {
	/**
	* 数据库的连接资源
	* @var object
	* @access private
    */
	private $link;
	
	/**
    * 返回影响记录数
    * @var integer
	* @access private
    */
	private $querynum = 0;

	/*连接Sqlite数据库，参数：dbname->数据库名字*/
	function __construct($dbname='../../config/candor.inc') {
		//if(!($this->link = @sqlite_open($dbname))) {
		//	$this->halt('Can not Open to Sqlite');
		//}

		if($this->link = sqlite_open($dbname, 0666, $sqliteerror)) { 
			@sqlite_query($this->link, 'CREATE TABLE module(id INTEGER PRIMARY KEY,business_name VARCHAR(45),module_name VARCHAR(45),project_name VARCHAR(45),parent_module VARCHAR(45),module_prefix VARCHAR(20),app_icon VARCHAR(45),developer VARCHAR(20),access_code VARCHAR(45),flag INT,serial_number VARCHAR(45),time DATATIME,describe text,remark text)');
		} else {
			$this->halt('Can not Open to Sqlite');
			die($sqliteerror);
		}
	}

	/*执行sql语句，返回对应的结果标识*/
	function Query($sql) {
		$this->querynum++;
		if($query = @sqlite_query($this->link, $sql)) {
			return $query;
		} else {
			$this->halt('Sqlite Query Error', $sql);
		}
	}

	/*返回对应的查询标识的结果的一行*/
	function GetRow($sql, $result_type = SQLITE_ASSOC) {
		$query = $this->Query($sql);
		return sqlite_fetch_array($query, $result_type);
	}

	/*返回对应的查询标识的结果的多行*/
	function GetAll($sql, $result_type = SQLITE_ASSOC) {
		$query = $this->Query($sql);
		return sqlite_fetch_all($query, $result_type);
	}

	/*执行Insert Into语句，并返回最后的insert操作所产生的自动增长的id*/
	function Insert($table, $iarr) {
		$value = $this->InsertSql($iarr);
		$this->Query('INSERT INTO "' . $table . '" ' . $value);
		return sqlite_last_insert_rowid($this->link);
	}

	/*执行Update语句，并返回最后的update操作所影响的行数*/
	function Update($table, $uarr, $condition = '') {
		$value = $this->UpdateSql($uarr);
		if ($condition) {
		$condition = ' WHERE ' . $condition;
		}
		$this->Query('UPDATE "' . $table . '"' . ' SET ' . $value . $condition);
		return sqlite_changes($this->link);
	}

	/*执行Delete语句，并返回最后的Delete操作所影响的行数*/
	function Delete($table, $condition = '') {
		if ($condition) {
		$condition = ' WHERE ' . $condition;
		}
		$this->Query('DELETE from"' . $table . '"' . $condition);
		return sqlite_changes($this->link);
	}

	/*将字符转为可以安全保存的sqlite值，比如a'a转为a''a*/
	function EnCode($str) {
		return sqlite_escape_string($str);
	}

	/*将可以安全保存的sqlite值转为正常的值，比如a''a转为a'a*/
	function DeCode($str) {
		if (strpos($str, '\'\'') === false) {
		return $str;
		} else {
		return str_replace('\'\'', '\'', $str);
		}
	}

	/*将对应的列和值生成对应的insert语句，如：array('id' => 1, 'name' => 'name')返回("id", "name") VALUES (1, 'name')*/
	function InsertSql($iarr) {
		if (is_array($iarr)) {
		$fstr = '';
		$vstr = '';
		foreach ($iarr as $key => $val) {
		$fstr .= '"' . $key . '", ';
		$vstr .= '\'' . $val . '\', ';
		}
		if ($fstr) {
		$fstr = '(' . substr($fstr, 0, -2) . ')';
		$vstr = '(' . substr($vstr, 0, -2) . ')';
		return $fstr . ' VALUES ' . $vstr;
		} else {
		return '';
		}
		} else {
		return '';
		}
	}

	/*将对应的列和值生成对应的insert语句，如：array('id' => 1, 'name' => 'name')返回"id" = 1, "name" = 'name'*/
	function UpdateSql($uarr) {
		if (is_array($uarr)) {
		$ustr = '';
		foreach ($uarr as $key => $val) {
		$ustr .= '"' . $key . '" = \'' . $val . '\', ';
		}
		if ($ustr) {
		return substr($ustr, 0, -2);
		} else {
		return '';
		}
		} else {
		return '';
		}
	}

	/*清空查询结果所占用的内存资源*/
	function Clear($query) {
		$query = null;
		return true;
	}

	/*关闭数据库*/
	function Close() {
		return sqlite_close($this->link);
	}

	function halt($message = '', $sql = '') {
		$ei = sqlite_last_error($this->link);
		$message .= '<br />Sqlite Error: ' . $ei . ', ' . sqlite_error_string($ei);
		if ($sql) {
		$sql = '<br />sql:' . $sql;
		}
		exit('DataBase Error.<br />Message: ' . $message . $sql);
	}

}
?>
