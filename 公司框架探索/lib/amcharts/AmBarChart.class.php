<?php

require_once(dirname(__FILE__) . "/AmLineBarChart.php");

/**
 * 创建一个柱形图
 */
class amcharts_AmBarChart extends AmLineBarChart 
{

	/**
	 * @see AmChart::getSwfPath()
	 */
	protected function getSwfPath() 
	{
		return self::$libraryPath . "/amcolumn.swf";
	}

}