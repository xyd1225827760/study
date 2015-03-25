<?php
/**
 * DAO�ࡣ�ṩ���ֱ��������ݿ����������
 * 
 * @copyright   Copyright: 2010
 * @author      LuoDong <751450467@qq.com>
 * @package     CandorPHP
 * @version     $Id: dao.class.php,v 1.1 2011/11/28 06:12:23 ld Exp $
 */
class dao
{
    /**
     * ȫ�ֵ�$app����
     * 
     * @var object
     * @access protected
     */
    protected $app;

    /**
     * ȫ�ֵ�$config���� 
     * 
     * @var object
     * @access protected
     */
    protected $config;

    /**
     * ȫ�ֵ�$lang����
     * 
     * @var object
     * @access protected
     */
    protected $lang;

    /**
     * ȫ�ֵ�$dbh�����ݿ���ʾ��������
     * 
     * @var object
     * @access protected
     */
    protected $dbh;

    /**
     * ��ǰmodel����Ӧ��table name��
     * 
     * @var object
     * @access private
     */
    public $table;

    /**
     * ��ǰ��ѯ�����ص��ֶ��б�
     * 
     * @var object
     * @access private
     */
    public $fields;

    /**
     * ��ѯ��ģʽ������֧�����֣�һ����ͨ��ħ��������һ����ֱ��ƴдsql��ѯ��
     * 
     * ��Ҫ��������dao::from()������sql::from()������
     *
     * @var object
     * @access private
     */
    public $mode;

    /**
     * ִ�е�sql��ѯ�б�
     * 
     * ������¼��ǰҳ�����е�sql��ѯ��
     *
     * @var array
     * @access public
     */
    static public $querys = array();

    /**
     * ���ݼ������
     * 
     * @var array
     * @access public
     */
    static public $errors = array();

    /**
     * ���캯����
     * 
     * ���õ�ǰmodel��Ӧ�ı�����������ȫ�ֵı�����
     *
     * @param string $table   ������
     * @access public
     * @return void
     */
    public function __construct($table = '')
    {
        global $app, $config, $lang, $dbh;
        $this->app    = $app;
        $this->config = $config;
        $this->lang   = $lang;
        $this->dbh    = $dbh;

        $this->reset();
    }

    /**
     * �������ݱ�
     * 
     * @param string $table   ������
     * @access private
     * @return void
     */
    private function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * ���÷��ص��ֶ��б�
     * 
     * @param string $fields   �ֶ��б�
     * @access private
     * @return void
     */
    private function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * ��������table, field, mode��
     * 
     * @access private
     * @return void
     */
    private function reset()
    {
        $this->setFields('');
        $this->setTable('');
        $this->setMode('');
    }

    //-------------------- ���ݲ�ѯ��ʽ�Ĳ�ͬ������SQL��Ķ�Ӧ������--------------------//

    /**
     * ���ò�ѯģʽ��magic��ͨ��findby֮���ħ���������в�ѯ�ģ���raw��ֱ��ƴװsql���в�ѯ��
     * 
     * @param string mode   ��ѯģʽ�� empty|magic|raw
     * @access private
     * @return void
     */
    private function setMode($mode = '')
    {
        $this->mode = $mode;
    }
    
    /* select������SQL���select������*/
    public function select($fields = '*')
    {
        $this->setMode('raw');
        $this->sqlobj = sql::select($fields);
        return $this;
    }

    /* update������SQL���update������*/
    public function update($table)
    {
        $this->setMode('raw');
        $this->sqlobj = sql::update($table);
        $this->setTable($table);
        return $this;
    }

    /* delete������SQL���delete������*/
    public function delete()
    {
        $this->setMode('raw');
        $this->sqlobj = sql::delete();
        return $this;
    }

    /* insert������SQL���insert������*/
    public function insert($table)
    {
        $this->setMode('raw');
        $this->sqlobj = sql::insert($table);
        $this->setTable($table);
        return $this;
    }

    /* replace������SQL���replace������*/
    public function replace($table)
    {
        $this->setMode('raw');
        $this->sqlobj = sql::replace($table);
        $this->setTable($table);
        return $this;
    }

    /* from: �趨Ҫ��ѯ��table name��*/
    public function from($table) 
    {
        $this->setTable($table);
        if($this->mode == 'raw') $this->sqlobj->from($table);
        return $this;
    }

    /* fields����������Ҫ��ѯ���ֶ��б�*/
    public function fields($fields)
    {
        $this->setFields($fields);
        return $this;
    }

    //-------------------- ƴװ֮���SQL��ش�������--------------------//

    /* ����SQL��䡣*/
    public function get()
    {
        return $this->processSQL();
    }

    /* ��ӡSQL��䡣*/
    public function printSQL()
    {
        echo $this->processSQL();
    }

    /* ����SQL����table��fields�ֶ��滻�ɶ�Ӧ��ֵ��*/
    private function processSQL()
    {
        if($this->mode == 'magic')
        {
            if($this->fields == '') $this->fields = '*';
            if($this->table == '')  $this->app->error('Must set the table name', __FILE__, __LINE__, $exit = true);
            $sql = sprintf($this->sqlobj->get(), $this->fields, $this->table);
            self::$querys[] = $sql;
            return $sql;
        }
        else
        {
            $sql = $this->sqlobj->get();
            self::$querys[] = $sql;
            return $sql;
        }
    }

    //-------------------- SQL��ѯ��صķ�����--------------------//
    
    /* ִ��sql��ѯ������stmt����*/
    public function query()
    {
        /* ���dao::$errors��Ϊ�գ�����һ���յ�stmt�������������ķ������û����Լ�����*/
        if(!empty(dao::$errors)) return new PDOStatement();

        /* ����һ��SQL��䡣*/
        $sql = $this->processSQL();
        try
        {
            $this->reset();
            return $this->dbh->query($sql);
        }
        catch (PDOException $e) 
        {
            $this->app->error($e->getMessage() . "<p>The sql is: $sql</p>", __FILE__, __LINE__, $exit = true);
        }
    }

    /* ִ�з�ҳ��*/
    public function page($pager)
    {
        if(!is_object($pager)) return $this;

        /* û�д���recTotal�����Լ����м��㡣*/
        if($pager->recTotal == 0)
        {
            /* ���SELECT��FROM��λ�ã��ݴ������ѯ���ֶΣ�Ȼ�����滻Ϊcount(*)��*/
            $sql       = $this->get();
            $selectPOS = strpos($sql, 'SELECT') + strlen('SELECT');
            $fromPOS   = strpos($sql, 'FROM');
            $fields    = substr($sql, $selectPOS, $fromPOS - $selectPOS );
            $sql       = str_replace($fields, ' COUNT(*) AS recTotal ', $sql);

            /* ȡ��order ����limit��λ�ã��������ȥ����*/
            $subLength = strlen($sql);
            $orderPOS  = strripos($sql, 'order');
            $limitPOS  = strripos($sql , 'limit');
            if($limitPOS) $subLength = $limitPOS;
            if($orderPOS) $subLength = $orderPOS;
            $sql = substr($sql, 0, $subLength);
            self::$querys[] = $sql;

            /* ��ü�¼������*/
            try
            {
                $row = $this->dbh->query($sql)->fetch(PDO::FETCH_OBJ);
            }
            catch (PDOException $e) 
            {
                $this->app->error($e->getMessage() . "<p>The sql is: $sql</p>", __FILE__, __LINE__, $exit = true);
            }

            $pager->setRecTotal($row->recTotal);
            $pager->setPageTotal();
        }
        $this->sqlobj->limit($pager->limit());
        return $this;
    }

    /* ִ��sql��ѯ��������Ӱ��ļ�¼����*/
    public function exec()
    {
        /* ���dao::$errors��Ϊ�գ�����һ���յ�stmt�������������ķ������û����Լ�����*/
        if(!empty(dao::$errors)) return new PDOStatement();

        /* ����һ��SQL��䡣*/
        $sql = $this->processSQL();
        try
        {
            $this->reset();
            return $this->dbh->exec($sql);
        }
        catch (PDOException $e) 
        {
            $this->app->error($e->getMessage() . "<p>The sql is: $sql</p>", __FILE__, __LINE__, $exit = true);
        }
    }

    //-------------------- ���ݻ�ȡ��صķ�����--------------------//

    /* ����һ����¼�����ָ����$field�ֶ�, ��ֱ�ӷ��ظ��ֶζ�Ӧ��ֵ��*/
    public function fetch($field = '')
    {
        if(empty($field)) return $this->query()->fetch();
        $this->setFields($field);
        $result = $this->query()->fetch(PDO::FETCH_OBJ);
        if($result) return $result->$field;
    }

    /* ����ȫ���Ľ�������ָ����$keyField������keyField��ֵ��Ϊkey��*/
    public function fetchAll($keyField = '')
    {
        $stmt = $this->query();
        if(empty($keyField)) return $stmt->fetchAll();
        $rows = array();
        while($row = $stmt->fetch()) $rows[$row->$keyField] = $row;
        return $rows;
    }

    /* ���ؽ��������ĳ���ֶν��з��顣*/
    public function fetchGroup($groupField, $keyField = '')
    {
        $stmt = $this->query();
        $rows = array();
        while($row = $stmt->fetch())
        {
            empty($keyField) ?  $rows[$row->$groupField][] = $row : $rows[$groupField][$row->$keyField] = $row;
        }
        return $rows;
    }

    /* fetchPairs���������û��ָ��key��value�ֶΣ���ȡ���ֶ�����ĵ�һ����Ϊkey�����һ����Ϊvalue��*/
    public function fetchPairs($keyField = '', $valueField = '')
    {
        $pairs = array();
        $ready = false;
        $stmt  = $this->query();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            if(!$ready)
            {
                if(empty($keyField)) $keyField = key($row);
                if(empty($valueField)) 
                {
                    end($row);
                    $valueField = key($row);
                }
                $ready = true;
            }

            $pairs[$row[$keyField]] = $row[$valueField];
        }
        return $pairs;
    }

    /* ��ȡ�������id��*/
    public function lastInsertID()
    {
        return $this->dbh->lastInsertID();
    }

    //-------------------- ����ħ��������--------------------//

    /**
     * ħ�������������ṩ���ֱ����Ĳ�ѯ������
     * 
     * @param string $funcName  �����õķ�������
     * @param array  $funcArgs  ����Ĳ����б�
     * @access public
     * @return void
     */
    public function __call($funcName, $funcArgs)
    {
        /* ��funcNameתΪСд��*/
        $funcName = strtolower($funcName);

        /* findBy��ķ�����*/
        if(strpos($funcName, 'findby') !== false)
        {
            $this->setMode('magic');
            $field = str_replace('findby', '', $funcName);
            if(count($funcArgs) == 1)
            {
                $operator = '=';
                $value    = $funcArgs[0];
            }
            else
            {
                $operator = $funcArgs[0];
                $value    = $funcArgs[1];
            }
            $this->sqlobj = sql::select('%s')->from('%s')->where($field, $operator, $value);    // ʹ��ռλ����ִ�в�ѯ֮ǰ�滻Ϊ��Ӧ���ֶκͱ�����
            return $this;
        }
        /* fetch10���������������ݲ�ѯ��*/
        elseif(strpos($funcName, 'fetch') !== false)
        {
            $max  = str_replace('fetch', '', $funcName);
            $stmt = $this->query();

            /* �趨��key�ֶΡ� */
            $rows = array();
            $key  = isset($funcArgs[0]) ? $funcArgs[0] : '';
            $i    = 0;
            while($row = $stmt->fetch())
            {
                $key ? $rows[$row->$key] = $row : $rows[] = $row;
                $i ++;
                if($i == $max) break;
            }
            return $rows;
        }
        /* ����Ķ�ֱ�ӵ���sql������ķ�����*/
        else
        {
            /* ȡSQL�෽���в����������ֵ������һ����󼯺ϵĲ����б���*/
            for($i = 0; $i < SQL::MAX_ARGS; $i ++)
            {
                ${"arg$i"} = isset($funcArgs[$i]) ? $funcArgs[$i] : null;
            }
            $this->sqlobj->$funcName($arg0, $arg1, $arg2);
            return $this;
        }
    }

    //-------------------- ���ݼ����صķ�����--------------------//
    
    /* ����ĳ��������ֵ�Ƿ����Ҫ��*/
    public function check($fieldName, $funcName)
    {
        /* ���data��������û������ֶΣ�ֱ�ӷ��ء�*/
        if(!isset($this->sqlobj->data->$fieldName)) return $this;

        /* ����ȫ�ֵ�config, lang��*/
        global $lang, $config;
        $table = str_replace($config->db->prefix, '', $this->table);
        $fieldLabel = isset($lang->$table->$fieldName) ? $lang->$table->$fieldName : $fieldName;
        $value = $this->sqlobj->data->$fieldName;
        
        if($funcName == 'unique')
        {
            $args  = func_get_args();
            $sql = "SELECT COUNT(*) AS count FROM $this->table WHERE `$fieldName` = " . $this->sqlobj->quote($value); 
            if(isset($args[2])) $sql .= ' AND ' . $args[2];
            try
            {
                 $row = $this->dbh->query($sql)->fetch();
                 if($row->count != 0) $this->logError($funcName, $fieldName, $fieldLabel, array($value));
            }
            catch (PDOException $e) 
            {
                $this->app->error($e->getMessage() . "<p>The sql is: $sql</p>", __FILE__, __LINE__, $exit = true);
            }
        }
        else
        {
            /* ȡvalidate�෽���в����������ֵ������һ����󼯺ϵĲ����б���*/
            $funcArgs = func_get_args();
            unset($funcArgs[0]);
            unset($funcArgs[1]);

            for($i = 0; $i < VALIDATER::MAX_ARGS; $i ++)
            {
                ${"arg$i"} = isset($funcArgs[$i + 2]) ? $funcArgs[$i + 2] : null;
            }
            $checkFunc = 'check' . $funcName;
            if(validater::$checkFunc($value, $arg0, $arg1, $arg2) === false)
            {
                $this->logError($funcName, $fieldName, $fieldLabel, $funcArgs);
            }
        }

        return $this;
    }

    /* �������ĳһ������������ĳ��������ֵ�Ƿ����Ҫ��*/
    public function checkIF($condition, $fieldName, $funcName)
    {
        if(!$condition) return $this;
        $funcArgs = func_get_args();
        for($i = 0; $i < VALIDATER::MAX_ARGS; $i ++)
        {
            ${"arg$i"} = isset($funcArgs[$i + 3]) ? $funcArgs[$i + 3] : null;
        }
        $this->check($fieldName, $funcName, $arg0, $arg1, $arg2);
        return $this;
    }

    /* ������顣*/
    public function batchCheck($fields, $funcName)
    {
        $fields = explode(',', str_replace(' ', '', $fields));
        $funcArgs = func_get_args();
        for($i = 0; $i < VALIDATER::MAX_ARGS; $i ++)
        {
            ${"arg$i"} = isset($funcArgs[$i + 2]) ? $funcArgs[$i + 2] : null;
        }
        foreach($fields as $fieldName) $this->check($fieldName, $funcName, $arg0, $arg1, $arg2);
        return $this;
    }
 
    /* �Զ��������ݿ��б���ֶθ�ʽ���м�顣*/
    public function autoCheck($skipFields = '')
    {
        $fields     = $this->getFieldsType();
        $skipFields = ",$skipFields,";

        foreach($fields as $fieldName => $validater)
        {
            if(strpos($skipFields, $fieldName) !== false) continue;    // ���ԡ�
            if(!isset($this->sqlobj->data->$fieldName)) continue;
            if($validater['rule'] == 'skip') continue;
            $options = array();
            if(isset($validater['options'])) $options = array_values($validater['options']);
            for($i = 0; $i < VALIDATER::MAX_ARGS; $i ++)
            {
                ${"arg$i"} = isset($options[$i]) ? $options[$i] : null;
            }
            $this->check($fieldName, $validater['rule'], $arg0, $arg1, $arg2);
        }
        return $this;
    }

    /* ��¼����*/
    public function logError($checkType, $fieldName, $fieldLabel, $funcArgs = array())
    {
        global $lang;
        $error    = $lang->error->$checkType;
        $replaces = array_merge(array($fieldLabel), $funcArgs);

        /* ���error�������飬ֻ���ַ�������ѭ��replace�������滻%s��*/
        if(!is_array($error))
        {
            foreach($replaces as $replace)
            {
                $pos = strpos($error, '%s');
                if($pos === false) break;
                $error = substr($error, 0, $pos) . $replace . substr($error, $pos +2);
            }
        }
        /* ���error��һ�����飬�����������ѡ%s������replaceԪ�ظ�����ͬ�ġ�*/
        else
        {
            /* ȥ��replace�пհ׵�Ԫ�ء�*/
            foreach($replaces as $key => $value) if(is_null($value)) unset($replaces[$key]);
            $replacesCount = count($replaces);
            foreach($error as $errorString)
            {
                if(substr_count($errorString, '%s') == $replacesCount)
                {
                    $error = vsprintf($errorString, $replaces);
                }
            }
        }
        dao::$errors[$fieldName][] = $error;
    }

    /* �ж���β�ѯ�Ƿ��д���*/
    public function isError()
    {
        return !empty(dao::$errors);
    }

    /* ����error��*/
    public function getError()
    {
        $errors = dao::$errors;
        dao::$errors = array();
        return $errors;
    }

    /* ���ĳһ������ֶ����͡�*/
    private function getFieldsType()
    {
        try
        {
            $this->dbh->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
            $sql = "DESC $this->table";
            $rawFields = $this->dbh->query($sql)->fetchAll();
            $this->dbh->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        }
        catch (PDOException $e) 
        {
            $this->app->error($e->getMessage() . "<p>The sql is: $sql</p>", __FILE__, __LINE__, $exit = true);
        }

        foreach($rawFields as $rawField)
        {
            $firstPOS = strpos($rawField->type, '(');
            $type     = substr($rawField->type, 0, $firstPOS > 0 ? $firstPOS : strlen($rawField->type));
            $type     = str_replace(array('big', 'small', 'medium', 'tiny', 'var'), '', $type);
            $field    = array();

            if($type == 'enum' or $type == 'set')
            {
                $rangeBegin  = $firstPOS + 2;  // ����һ������ȥ����
                $rangeEnd    = strrpos($rawField->type, ')') - 1; // �����һ������ȥ����
                $range       = substr($rawField->type, $rangeBegin, $rangeEnd - $rangeBegin);
                $field['rule'] = 'reg';
                $field['options']['reg']  = '/' . str_replace("','", '|', $range) . '/';
            }
            elseif($type == 'char')
            {
                $begin  = $firstPOS + 1;
                $end    = strpos($rawField->type, ')', $begin);
                $length = substr($rawField->type, $begin, $end - $begin);
                $field['rule']   = 'length';
                $field['options']['max'] = $length;
                $field['options']['min'] = 0;
            }
            elseif($type == 'int')
            {
                $field['rule'] = 'int';
            }
            elseif($type == 'float' or $type == 'double')
            {
                $field['rule'] = 'float';
            }
            elseif($type == 'date')
            {
                $field['rule'] = 'date';
            }
            else
            {
                $field['rule'] = 'skip';
            }
            $fields[$rawField->field] = $field;
        }
        return $fields;
    }
}

/**
 * SQL��ѯ��װ�ࡣ
 * 
 * @package CandorPHP
 */
class sql
{
    /**
     * ���з����Ĳ����������ֵ��
     * 
     */
    const MAX_ARGS = 3;

    /**
     * SQL��䡣
     * 
     * @var string
     * @access private
     */
    private $sql = '';

    /**
     * ���ݱ�����
     * 
     * @var string
     * @access private
     */
    private $table = '';

    /**
     * ȫ�ֵ�$dbh�����ݿ���ʾ��������
     * 
     * @var object
     * @access protected
     */
    protected $dbh;

    /**
     * INSERT����UPDATEʱ���������ݡ�
     * 
     * @var mix
     * @access protected
     */
    public $data;

    /**
     * �Ƿ����״ε���set��
     * 
     * @var bool    
     * @access private;
     */
    private $isFirstSet = true;

    /**
     * �Ƿ��������ж��С�
     * 
     * @var bool
     * @access private;
     */
    private $inCondition = false;

    /**
     * �ж������Ƿ�Ϊture��
     * 
     * @var bool
     * @access private;
     */
    private $conditionIsTrue = false;

    /**
     * �Ƿ��Զ�magic quote��
     * 
     * @var bool
     * @access public
     */
     public $magicQuote; 

    /* ���캯����*/
    private function __construct($table = '')
    {
        global $dbh;
        $this->dbh        = $dbh;
        $this->table      = $table;
        $this->magicQuote = get_magic_quotes_gpc();
    }

    /* ʵ����������ͨ���÷���ʵ������*/
    public function factory($table = '')
    {
        return new sql($table);
    }

    /* ��ѯ��俪ʼ��*/
    public function select($field = '*')
    {
        $sqlobj = self::factory();
        $sqlobj->sql = "SELECT $field ";
        return $sqlobj;
    }

    /* ������俪ʼ��*/
    public function update($table)
    {
        $sqlobj = self::factory();
        $sqlobj->sql = "UPDATE $table SET ";
        return $sqlobj;
    }

    /* ������俪ʼ��*/
    public function insert($table)
    {
        $sqlobj = self::factory();
        $sqlobj->sql = "INSERT INTO $table SET ";
        return $sqlobj;
    }

    /* �滻��俪ʼ��*/
    public function replace($table)
    {
        $sqlobj = self::factory();
        $sqlobj->sql = "REPLACE $table SET ";
        return $sqlobj;
    }

    /* ɾ����俪ʼ��*/
    public function delete()
    {
        $sqlobj = self::factory();
        $sqlobj->sql = "DELETE ";
        return $sqlobj;
    }

    /* ����һ��key=>value�ṹ��������߶���ƴװ��key = value����ʽ��*/
    public function data($data)
    {
        $this->data = $data;
        foreach($data as $field => $value) $this->sql .= "`$field` = " . $this->quote($value) . ',';
        $this->sql = rtrim($this->sql, ',');    // ȥ�������Ķ��š�
        return $this;
    }

    /* ����ߵ�������*/
    public function markLeft($count = 1)
    {
        $this->sql .= str_repeat('(', $count);
        return $this;
    }

    /* ���ұߵ�������*/
    public function markRight($count = 1)
    {
        $this->sql .= str_repeat(')', $count);
        return $this;
    }

    /* SET key=value��*/
    public function set($set)
    {
        if($this->isFirstSet)
        {
            $this->sql .= " $set ";
            $this->isFirstSet = false;
        }
        else
        {
            $this->sql .= ", $set";
        }
        return $this;
    }

    /* �趨Ҫ��ѯ�ı�����*/
    public function from($table)
    {
        $this->sql .= "FROM $table";
        return $this;
    }

    /* ���ñ�����*/
    public function alias($alias)
    {
        $this->sql .= " AS $alias ";
    }

    /* �趨LEFT JOIN��䡣*/
    public function leftJoin($table)
    {
        $this->sql .= " LEFT JOIN $table";
        return $this;
    }

    /* �趨ON������*/
    public function on($condition)
    {
        $this->sql .= " ON $condition ";
        return $this;
    }

    /* �����жϿ�ʼ��*/
    public function onCaseOf($condition)
    {
        $this->inCondition = true;
        $this->conditionIsTrue = $condition;
    }

    /* �����жϽ�����*/
    public function endCase()
    {
        $this->inCondition = false;
        $this->conditionIsTrue = false;
    }

    /* WHERE��䲿�ֿ�ʼ��*/
    public function where($arg1, $arg2 = null, $arg3 = null)
    {
        if($this->inCondition and !$this->conditionIsTrue) return $this;
        if($arg3 !== null)
        {
            $value     = $this->quote($arg3);
            $condition = "`$arg1` $arg2 " . $this->quote($arg3);
        }
        else
        {
            $condition = $arg1;
        }

        $this->sql .= " WHERE $condition ";
        return $this;
    } 

    /* ׷��AND������*/
    public function andWhere($condition)
    {
        if($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " AND $condition ";
        return $this;
    }

    /* ׷��OR������*/
    public function orWhere($condition)
    {
        if($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " OR $condition ";
        return $this;
    }

    /* ���ڡ�*/
    public function eq($value)
    {
        if($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " = " . $this->quote($value);
        return $this;
    }

    /* �����ڡ�*/
    public function ne($value)
    {
        if($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " != " . $this->quote($value);
        return $this;
    }

    /* ���ڡ�*/
    public function gt($value)
    {
        if($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " > " . $this->quote($value);
        return $this;
    }

    /* С�ڡ�*/
    public function lt($value)
    {
        if($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " < " . $this->quote($value);
        return $this;
    }

    /* ����between��䡣*/
    public function between($min, $max)
    {
        if($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " BETWEEN $min AND $max ";
        return $this;
    }

    /* ���� IN������䡣*/
    public function in($ids)
    {
        if($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= helper::dbIN($ids);
        return $this;
    }

    /* ����LIKE������䡣*/
    public function like($string)
    {
        if($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " LIKE " . $this->quote($string);
        return $this;
    }

    /* �趨ORDER BY��*/
    public function orderBy($order)
    {
        $order = str_replace('|', ' ', $order);
        $this->sql .= " ORDER BY $order";
        return $this;
    }

    /* �趨LIMIT��*/
    public function limit($limit)
    {
        if(empty($limit)) return $this;
        stripos($limit, 'limit') !== false ? $this->sql .= " $limit " : $this->sql .= " LIMIT $limit ";
        return $this;
    }

    /* �趨GROUP BY��*/
    public function groupBy($groupBy)
    {
        $this->sql .= " GROUP BY $groupBy";
        return $this;
    }

    /* �趨having��*/
    public function having($having)
    {
        $this->sql .= " HAVING $having";
        return $this;
    }

    /* ����ƴװ�õ���䡣*/
    public function get()
    {
        return $this->sql;
    }

    /* ת�塣*/
    public function quote($value)
    {
        if($this->magicQuote) $value = stripslashes($value);
        return $this->dbh->quote($value);
    }
}
