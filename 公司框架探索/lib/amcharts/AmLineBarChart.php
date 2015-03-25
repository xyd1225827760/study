<?php

require_once(dirname(__FILE__) . "/AmChart.php");

/*
 * AmLineChart 和 AmBarChart 的基类.
 */
abstract class AmLineBarChart extends AmChart 
{

	protected $series = array();
	protected $graphs = array();

	protected $defaultGraphConfig = array();

	/**
	 * 新增x轴列值.
	 *
	 * @param	string				$_id
	 * @param	string				$_title
	 * @param	array				$_config
	 */
	public function addSerie($_id, $_title, array $_config = array()) 
	{
		$this->series[$_id] = array(
			"title" => $_title,
			"config" => $_config
		);
	}

	/**
	 * 新增一个新的图形数据 (线、柱形数据).
	 *
	 * @param	string				$_id
	 * @param	string				$_title
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
		 * Series
		 */
		$series = $chart->addChild("series");
		foreach($this->series AS $key => $serie) 
		{
			$valueNode = $series->addChild("value", $serie['title']);
			$valueNode->addAttribute("xid", $key);
		}

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
			foreach($graph['data'] AS $key => $value) 
			{
				$valueNode = $graphNode->addChild("value", $value);
				$valueNode->addAttribute("xid", $key);
			$valueNode->addAttribute("description", $key);
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