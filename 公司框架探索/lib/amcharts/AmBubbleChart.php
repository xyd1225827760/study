<?php

require_once(dirname(__FILE__) . "/AmChart.php");

/**
 * 通过amCharts类，创建一个气泡图
 */
class AmBubbleChart extends AmChart 
{

	protected $graphs = array();
	protected $defaultGraphConfig = array();

	/**
	 * @see AmChart::getSwfPath()
	 */
	protected function getSwfPath() 
	{
		return self::$libraryPath . "/amxy.swf";
	}

	/**
	 * 添加一个图形数据.
	 *
	 * @param	string				$_id
	 * @param	array				$_data
	 * @param	array				$_config
	 */
	public function addGraph($_id, $_title, array $_data, array $_config = array()) 
	{
		$this->graphs[$_id] = array(
			"title" => $_title,
			"data" => $_data,
			"config" => $_config
		);
	}

	/**
	 * 设置默认图形配置.
	 *
	 * @param	array				$_config
	 */
	public function setDefaultGraphConfig(array $_config) 
	{
		$this->defaultGraphConfig = $_config;
	}

	/**
	 * @see AmChart::getDataXml()
	 */
	public function getDataXml($_asString = true) 
	{
		$chart = new SimpleXmlElement("<chart></chart>");

		/*
		 * Graphs
		 */

		$graphs = $chart->addChild("graphs");

		foreach($this->graphs AS $key => $graph) 
		{
			$graphNode = $graphs->addChild("graph");

			// Set attributes
			$graphNode->addAttribute("gid", $key);
			$graphNode->addAttribute("title", $graph['title']);

			$allAttributes = array_merge($this->defaultGraphConfig, $graph['config']);

			foreach($allAttributes AS $key => $value) 
			{
				$graphNode->addAttribute($key, ($value === true ? "true" : ($value === false ? "false" : $value)));
			}

			// Set data
			foreach($graph['data'] AS $point) 
			{
				$pointNode = $graphNode->addChild("point", (isset($point['title']) ? $point['title'] : null));

				foreach($point AS $key => $value) 
				{
					if($key == "title")
					{
						continue;
					}

					$pointNode->addAttribute($key, ($value === true ? "true" : ($value === false ? "false" : $value)));
				}
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