<?php

require_once(dirname(__FILE__) . "/AmLineBarChart.php");

/**
 * 通过amCharts类，创建一个线(折线、曲线)图
 */
class amcharts_AmLineChart extends AmLineBarChart 
{

	/**
	 * @see AmChart::getSwfPath()
	 */
	protected function getSwfPath() 
	{
		return self::$libraryPath . "/amline.swf";
	}

}