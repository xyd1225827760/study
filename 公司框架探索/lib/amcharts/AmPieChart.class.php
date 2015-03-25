<?php

require_once(dirname(__FILE__) . "/AmChart.php");

/**
 * ͨ��amCharts�࣬����һ����ͼ
 */
class amcharts_AmPieChart extends AmChart 
{

	protected $slices = array();
	protected $defaultSliceConfig = array();

	/**
	 * @see AmChart::getSwfPath()
	 */
	protected function getSwfPath() 
	{
		return self::$libraryPath . "/ampie.swf";
	}

	/**
	 * ��ӱ�ͼ�ֿ�.
	 *
	 * @param	string				$_id
	 * @param	string				$_title
	 * @param	mixed				$_value
	 * @param	array				$_config
	 */
	public function addSlice($_id, $_title, $_value, array $_config = array()) 
	{
		$this->slices[$_id] = array(
			"title" => $_title,
			"value" => $_value,
			"config" => $_config
		);
	}

	/**
	 * ����Ĭ�ϱ�ͼ������
	 *
	 * @param	array				$_config
	 */
	public function setDefaultSliceConfig(array $_config) 
	{
		$this->defaultSliceConfig = $_config;
	}

	/**
	 * @see AmChart::getDataXml()
	 */
	public function getDataXml($_asString = true) 
	{
		$chart = new SimpleXmlElement("<pie></pie>");

		/*
		 * Slices
		 */
		foreach($this->slices AS $id => $slice) 
		{
			$sliceNode = $chart->addChild("slice", $slice['value']);
			$sliceNode->addAttribute("title", $slice['title']);

			// Config
			$allAttributes = array_merge($this->defaultSliceConfig, $slice['config']);

			foreach($allAttributes AS $key => $value) 
			{
				$sliceNode->addAttribute($key, $value);
			}
		}

		/*
		 * Return
		 */
		if($_asString) 
		{
			$xmlString = $chart->asXML();
			// Remove XML Tag (not needed for config)
			$xmlString = trim(substr($xmlString, strpos($xmlString, "?>") + 2));
			return $xmlString;
		}
		else
		{
			return $chart;
		}
	}

}