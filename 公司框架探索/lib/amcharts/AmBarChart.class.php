<?php

require_once(dirname(__FILE__) . "/AmLineBarChart.php");

/**
 * ����һ������ͼ
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