<?php

require_once(dirname(__FILE__) . "/AmLineBarChart.php");

/**
 * ͨ��amCharts�࣬����һ����(���ߡ�����)ͼ
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