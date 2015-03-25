<?php
/**
 * validate�࣬�ṩ�����ݵ���֤��
 * 
 * @copyright   Copyright: 2010
 * @author      LuoDong <751450467@qq.com>
 * @package     CandorPHP
 * @version     $Id: filter.class.php,v 1.1 2011/11/28 06:12:23 ld Exp $
 */
class validater
{
    /**
     * �������������ֵ��
     */
    const MAX_ARGS = 3;

    /* ����Ƿ��ǲ����͡�*/
    public static function checkBool($var)
    {
        return filter_var($var, FILTER_VALIDATE_BOOLEAN);
    }

    /* ����Ƿ������͡�*/
    public static function checkInt($var)
    {
        $args = func_get_args();
        if($var != 0) $var = ltrim($var, 0);  // ����ߵ�0ȥ����filter��������˹���Ƚ��ϸ�

        /* ������min��*/
        if(isset($args[1]))
        {
            /* ͬʱ������max��*/
            if(isset($args[2]))
            {
                $options = array('options' => array('min_range' => $args[1], 'max_range' => $args[2]));
            }
            else
            {
                $options = array('options' => array('min_range' => $args[1]));
            }

            return filter_var($var, FILTER_VALIDATE_INT, $options);
        }
        else
        {
            return filter_var($var, FILTER_VALIDATE_INT);
        }
    }

    /* ����Ƿ��Ǹ����͡�*/
    public static function checkFloat($var, $decimal = '.')
    {
        return filter_var($var, FILTER_VALIDATE_FLOAT, array('options' => array('decimail' => $decimal)));
    }

    /* ����Ƿ���email��ַ��*/
    public static function checkEmail($var)
    {
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    /* ����Ƿ���URL��ַ����ע��filter�������鲢�����գ��������url��ַ�������ģ��ͻ�ʧЧ�� */
    public static function checkURL($var)
    {
        return fitler_var($var, FILTER_VALIDATE_URL);
    }

    /* ����Ƿ���IP��ַ��NO_PRIV_RANGE�Ǽ���Ƿ���˽�е�ַ��NO_RES_RANGE����Ƿ��Ǳ���IP��ַ��*/
    public static function checkIP($var, $range = 'all')
    {
        if($range == 'all')    return filter_var($var, FILTER_VALIDATE_IP);
        if($range == 'public static') return filter_var($var, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE);
        if($range == 'private')
        {
            if(filter_var($var, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE) === false) return $var;
            return false;
        }
    }

    /* ����Ƿ������ڡ�bug: 2009-09-31�ᱻ��Ϊ�Ϸ������ڣ���Ϊstrtotime�Զ������Ϊ��10-01��*/
    public static function checkDate($date)
    {
        if($date == '0000-00-00') return true;
        $stamp = strtotime($date);
        if(!is_numeric($stamp)) return false; 
        return checkdate(date('m', $stamp), date('d', $stamp), date('Y', $stamp));
    }

    /* ����Ƿ����������ʽ��*/
    public static function checkREG($var, $reg)
    {
        return filter_var($var, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $reg)));
    }
    
    /* ��鳤���Ƿ���ָ���ķ�Χ�ڡ�*/
    public static function checkLength($var, $max, $min = 0)
    {
        return self::checkInt(strlen($var), $min, $max);
    }

    /* ��鳤���Ƿ���ָ���ķ�Χ�ڡ�*/
    public static function checkNotEmpty($var)
    {
        return !empty($var);
    }

    /* ����û�����*/
    public static function checkAccount($var)
    {
        return self::checkREG($var, '|[a-zA-Z0-9._]{3}|');
    }

    /* ���ûص�������*/
    public static function call($var, $func)
    {
        return filter_var($var, FILTER_CALLBACK, array('options' => $func));
    }
}

/**
 * fixer�࣬�ṩ�����ݵ�������
 * 
 * @package CandorPHP
 */
class fixer
{
    /**
     * Ҫ��������ݡ�
     * 
     * @var ojbect
     * @access private
     */
    private $data;

    /* ���캯����*/
    private function __construct($scope)
    {
       switch($scope)
       {
           case 'post':
               $this->data = (object)$_POST;
               break;
           case 'server':
               $this->data = (object)$_SERVER;
               break;
           case 'get':
               $this->data = (object)$_GET;
               break;
           case 'session':
               $this->data = (object)$_SESSION;
               break;
           case 'cookie':
               $this->data = (object)$_COOKIE;
               break;
           case 'env':
               $this->data = (object)$_ENV;
               break;
           case 'file':
               $this->data = (object)$_FILES;
               break;

           default:
               die('scope not supported, should be post|get|server|session|cookie|env');
       }
    }

    /* factory��*/
    public function input($scope)
    {
        return new fixer($scope);
    }

    /* ȥ��email����ķǷ��ַ���*/
    public function cleanEmail($fieldName)
    {
        $fields = $this->processFields($fieldName);
        foreach($fields as $fieldName) $this->data->$fieldName = filter_var($this->data->$fieldName, FILTER_SANITIZE_EMAIL);
        return $this;
    }

    /* ��URL���б��롣*/
    public function encodeURL($fieldName)
    {
        $fields = $this->processFields($fieldName);
        $args   = func_get_args();
        foreach($fields as $fieldName)
        {
            $this->data->$fieldName = isset($args[1]) ?  filter_var($this->data->$fieldname, FILTER_SANITIZE_ENCODE, $args[1]) : filter_var($this->data->$fieldname, FILTER_SANITIZE_ENCODE);
        }
        return $this;
    }

    /* ȥ��url����ķǷ��ַ���*/
    public function cleanURL($fieldName)
    {
        $fields = $this->processFields($fieldName);
        foreach($fields as $fieldName) $this->data->$fieldName = filter_var($this->data->$fieldName, FILTER_SANITIZE_URL);
        return $this;
    }

    /* ��ȡ��������*/
    public function cleanFloat($fieldName)
    {
        $fields = $this->processFields($fieldName);
        foreach($fields as $fieldName) $this->data->$fieldName = filter_var($this->data->$fieldName, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION|FILTER_FLAG_ALLOW_THOUSAND);
        return $this;
    }

    /* ��ȡ���͡�*/
    public function cleanINT($fieldName = '')
    {
        $fields = $this->processFields($fieldName);
        foreach($fields as $fieldName) $this->data->$fieldName = filter_var($this->data->$fieldName, FILTER_SANITIZE_NUMBER_INT);
        return $this;
    }

    /* ���������ַ���*/
    public function specialChars($fieldName)
    {
        $fields = $this->processFields($fieldName);
        foreach($fields as $fieldName) $this->data->$fieldName = htmlspecialchars($this->data->$fieldName);
        return $this;
    }

    /* ȥ���ַ�������ı�ǩ��*/
    public function stripTags($fieldName)
    {
        $fields = $this->processFields($fieldName);
        foreach($fields as $fieldName) $this->data->$fieldName = filter_var($this->data->$fieldName, FILTER_SANITIZE_STRING);
        return $this;
    }

    /* ���б�ߡ�*/
    public function quote($fieldName)
    {
        $fields = $this->processFields($fieldName);
        foreach($fields as $fieldName) $this->data->$fieldName = filter_var($this->data->$fieldName, FILTER_SANITIZE_MAGIC_QUOTES);
        return $this;
    }

    /* ����Ĭ��ֵ��*/
    public function setDefault($fields, $value)
    {
        $fields = strpos($fields, ',') ? explode(',', str_replace(' ', '', $fields)) : array($fields);
        foreach($fields as $fieldName)if(!isset($this->data->$fieldName) or empty($this->data->$fieldName)) $this->data->$fieldName = $value;
        return $this;
    }

    /* �������á�*/
    public function setIF($condition, $fieldName, $value)
    {
        if($condition) $this->data->$fieldName = $value;
        return $this;
    }

    /* ǿ�����á�*/
    public function setForce($fieldName, $value)
    {
        $this->data->$fieldName = $value;
        return $this;
    }

    /* ɾ��ĳһ���ֶΡ�*/
    public function remove($fieldName)
    {
        $fields = $this->processFields($fieldName);
        foreach($fields as $fieldName) unset($this->data->$fieldName);
        return $this;
    }

    /* ����ɾ����*/
    public function removeIF($condition, $fieldName)
    {
        if($condition) unset($this->data->$fieldName);
        return $this;
    }

    /* ���һ���ֶΡ�*/
    public function add($fieldName, $value)
    {
        $this->data->$fieldName = $value;
        return $this;
    }

    /* ������ӡ�*/
    public function addIF($condition, $fieldName, $value)
    {
        if($condition) $this->data->$fieldName = $value;
        return $this;
    }

    /* ���ӡ�*/
    public function join($fieldName, $value)
    {
        if(!isset($this->data->$fieldName) or !is_array($this->data->$fieldName)) return $this;
        $this->data->$fieldName = join($value, $this->data->$fieldName);
        return $this;
    }

    /* ���ûص�������*/
    public function callFunc($fieldName, $func)
    {
        $fields = $this->processFields($fieldName);
        foreach($fields as $fieldName) $this->data->$fieldName = filter_var($this->data->$fieldName, FILTER_CALLBACK, array('options' => $func));
        return $this;
    }

    /* �������մ���֮������ݡ�*/
    public function get($fieldName = '')
    {
        if(empty($fieldName)) return $this->data;
        return $this->data->$fieldName;
    }

    /* ��������ֶ�����������ж��ţ������Ϊ���顣Ȼ����data�������Ƿ�������ֶΡ�*/
    private function processFields($fields)
    {
        $fields = strpos($fields, ',') ? explode(',', str_replace(' ', '', $fields)) : array($fields);
        foreach($fields as $key => $fieldName) if(!isset($this->data->$fieldName)) unset($fields[$key]);
        return $fields;
    }
}
