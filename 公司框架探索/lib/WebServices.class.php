<?php
//require_once ('CreateWsJson.class.php');
/**
 * WebServiceͨ����
 * @author luodong
 * @version 1.0
 * @created 2013-06-05 11:06:01
 */
class WebServices
{
	/**
     * soap����
     *
     * @private soap
     */
    private $soap;
    /**
     * inflowHis����
     *
     * @public inflowHis
     */
    public $inflowHis;
	
	/**
     * ���캯����
     *
     */
	function __construct($wsdl)
	{
		$wsdl = !empty($wsdl) ? $wsdl : $this->app->config->wsdl->ServiceName;
		#�ж�WSDL�Ƿ���ͨ
        $this->checkSoapIsOpen($wsdl);
		$this->soap = new SoapClient($wsdl);
	}

        /**
    +----------------------------------------------------------
    * �ж�WSDL�Ƿ��Ѿ���
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param 
    +----------------------------------------------------------
    * @return 
    +----------------------------------------------------------
    */
    private function checkSoapIsOpen($wsdl)
    {
        $ch=curl_init($wsdl); 
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); 
        curl_setopt($ch,CURLOPT_TIMEOUT,30); 
        $data=curl_exec($ch); 
        $curl_errno=curl_errno($ch); 
        $curl_error=curl_error($ch); 
        curl_close($ch); 
        if($curl_errno>0) {
			echo 'Զ��WebServiceû�д򿪣�����';
			exit;
		}
    }
    
	/**
	* DoRequest����
	* @access public 
	* @param 
	* @return 
	*/
	public  function DoRequest($input=null)
	{
		return $this->soap->DoRequest($input);
	}

	/**
	* soap��������
	* @access public 
	* @param 
	* @return 
	*/
	public function doGetRequest($requestStr,$buss=false)
	{
		$input = array(
			"loginId" => $_SESSION['userRelateInfo']['LOGIN_ID'],
			"password" => $_SESSION['userRelateInfo']['PASSWORD'],
			"key" => $this->getMD5Key(),
			"requestStr" => $requestStr
		);
		//print_r($input);exit;
		$output = $this->soap->DoRequest($input);
		$output = json_decode($output->DoRequestResult,true);
		if(empty($output)){
			$this->erromsg =  '���ݿ����Ѿ������������޸ģ���ˢ�º����ԣ�';
			return false;
		}
		if ($buss)$output['issuccess'] = base64_decode($output['issuccess']);
		if(isset($output['issuccess']) && $output['issuccess']== 'false') {
			$this->erromsg =  base64_decode($output['message']);
			return false;
		}else{
			//��else���ǰ̨��issuccess���жϲ����ɹ��������� add wangjiang 2014-03-04
			$output['issuccess'] = base64_encode($output['issuccess']);
		}
		return $output;
	}
	
	/**
	* ����class��bizid��ȡ����
	* @access public 
	* @param $bizid 
	* @param $tabaname ��ѯ�ı���
	* @param  $params ���������
	* @param $condition ����
	* @return 
	*/
	public function getDataInfo($bizid,$params,$condition=null,$tabname){
		$cwj = new CreateWsJson();
		$requestStr = $cwj->getdata($bizid,$params,$condition);
		$output = $this->doGetRequest($requestStr,true);
		if(!$output)return false;
		$data = $this->doTableArrayToOne($output['records'],$tabname);
		$data = $this->doBase64ToReal($data);
		return $data;
	}

	public function doSaveInfo($bizid,$params,$flow=false,$flowname=null){
        $cwj = new CreateWsJson();
        $requestStr = $flow==true ? $cwj->dealDataNew($bizid,$params,$this->inflowHis,$flowname) : $cwj->dealDataNew($bizid,$params) ;
        //echo $requestStr;exit;
        $output = $this->doGetRequest($requestStr,true);
        if(!$output)return false;
        $output = $this->doBase64ToReal($output);
        return $output;
	}

	public function getSqlidInfo($sqlid,$params,$cls=false){
		$cwj = new CreateWsJson();
		$requestStr = $cls!==false ? $cwj->execsqlbycls($sqlid,$params) : $cwj->execsqlbyid($sqlid,$params);
		$output = $this->doGetRequest($requestStr);
		if(!$output)return false;
		$data = $this->doTableArrayToOne($output['records']);//print_r($output);
		$data = $this->doBase64ToReal($data);
		return $data;
	}

	private function getMD5Key()
	{
		$today=date("Y-m-d");
		$md5key=md5($_SESSION['userRelateInfo']['LOGIN_ID'].$_SESSION['userRelateInfo']['PASSWORD'].$today);
		return $md5key;
	}

	public function doTableArrayToOne($data,$table=false)
	{
		if($table&&isset($data[0][$table]))$data = $data[0][$table];
		return $data;
	}

	private function doBase64ToReal($data)
	{
		foreach($data as $key =>$value){	
			if (is_array($value))
			{
				foreach ($value as $k=>$val)
				{
					if(is_array($val))
					{
						$data[$key][$k] = $this->doBase64ToReal($val);	
					}
					else $data[$key][$k] = base64_decode($val);	
				}
			}
			else 
			{
				$data[$key] = base64_decode($value);	
			}
				
		}	
		return $data;
	}
}
?>
