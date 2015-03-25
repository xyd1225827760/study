<?php

/**
 * 统计图基类
 */
abstract class AmChart 
{

	public static $swfObjectPath = "/js/amcharts/swfobject.js";
	public static $jQueryPath = "/js/amcharts/jquery.js";
	public static $jsPath = "/js/amcharts/AmCharts.js";
	public static $libraryPath = "/js/amcharts/flash";
	public static $settingsPath = "/js/amcharts/settings";//设置文件路径
	public static $settingsFile = "";//设置文件

	public static $loadJQuery = false;
	private static $jsIncluded = false;

	private $id;
	protected $config = array();
	protected $labels = array();
	protected $title;

	/**
	 * 构造函数
	 *
	 * @param	string				$_id
	 */
	public function __construct($_id = null) 
	{
		if($_id)
		{
			$this->id = $_id;
		}
		else
		{
			$this->id = substr(md5(uniqid() . microtime()), 3, 5);
		}
	}

	public function addLabel($_text, $_x, $_y, array $_config = array()) 
	{
		$this->labels[] = array(
			"text" => $_text,
			"x" => $_x,
			"y" => $_y,
			"config" => $_config
		);
	}

	public function setTitle($_title) 
	{
		$this->title = $_title;
	}

	/**
	 * 返回html代码，插入到页面显示
	 *
	 * @return	string
	 */
	public function getCode() 
	{

		$code = '';

		// 背景颜色
		if(isset($this->config['background.color']) && is_array($this->config['background.color']))
		{
			$bgColor = $this->config['background.color'][0];
		}
		elseif(isset($this->config['background.color']))
		{
			$bgColor = $this->config['background.color'];
		}
		elseif(isset($this->config['background.alpha']))
		{
			$bgColor = "transparent";
		}
		else
		{
			$bgColor = "FFFFFF";
		}

		// Width
		if(isset($this->config['width']))
		{
			$width = $this->config['width'];
		}
		else
		{
			$width = 400;
		}

		// Height
		if(isset($this->config['height']))
		{
			$height = $this->config['height'];
		}
		else
		{
			$height = 300;
		}

		// SWF Object
		if(!self::$jsIncluded) 
		{
			$code .= '<script type="text/javascript" src="' . self::$swfObjectPath . '"></script>' . "\n"
				. '<script type="text/javascript" src="' . self::$jsPath . '"></script>' . "\n";
			if(self::$loadJQuery)
			{
				$code .= '<script type="text/javascript" src="' . self::$jQueryPath . '"></script>' . "\n";
			}
			self::$jsIncluded = true;
		}

		$code .= '<div class="amChart" id="chart_' . $this->id . '_div">' . "\n";

		if($this->title)
		{
			$code .= '<div class="amChartTitle" id="chart_' . $this->id . '_div_title">' . $this->title . '</div>' . "\n";
		}
//print_r(htmlspecialchars($this->getConfigXml()));
		if(empty(self::$settingsFile)){//使用php array配置文件
			$code .= ''
				. '<div class="amChartInner" id="chart_' . $this->id . '_div_inner"><div id="chart_' . $this->id . '_flash">图形数据加载 ...</div></div>' . "\n"
				. '</div>' . "\n"
				. '<script type="text/javascript">' . "\n"
				. '// <![CDATA[' . "\n"
				. 'var flashvars = {};' . "\n"
				. 'flashvars.chart_id = "' . $this->id . '";' . "\n"
				. 'flashvars.chart_settings = escape("' . str_replace("\"", "'", $this->getConfigXml()) . '");' . "\n"
				. 'flashvars.chart_data = escape("' . str_replace("\"", "'", $this->getDataXml()) . '");' . "\n"
				. 'flashvars.path = "' . self::$libraryPath . '";' . "\n"
				. 'var params = {bgcolor:"#'.$bgColor.'"};' . "\n"
				. ($bgColor == "transparent" ? 'params.wmode="transparent";' . "\n" :' params.wmode="transparent"' . "\n")
				. 'swfobject.embedSWF("' . $this->getSwfPath() . '", "chart_' . $this->id . '_flash", "' . $width . '", "' . $height . '", "8", "", flashvars, params, {}, function(e) {' . "\n"
					. 'if(!e.success) {' . "\n"
						. 'document.getElementById("chart_' . $this->id . '_flash").innerHTML = "Flash播放器错误!";' . "\n"
					. '}' . "\n"
				. '});' . "\n"
				. '// ]]>' . "\n"
				. '</script>' . "\n";
		}else{//使用settingsFile xml配置文件
			$code .= ''
				. '<div class="amChartInner" id="chart_' . $this->id . '_div_inner"><div id="chart_' . $this->id . '_flash">图形数据加载 ...</div></div>' . "\n"
				. '</div>' . "\n"
				. '<script type="text/javascript">' . "\n"
				. '// <![CDATA[' . "\n"
				. 'var flashvars = {'."\n"
				. 'chart_id : "' . $this->id . '",' . "\n"
				. 'settings_file : encodeURIComponent("' . self::$settingsPath . '/' . self::$settingsFile . '"),' . "\n"
				. 'chart_data : escape("' . str_replace("\"", "'", $this->getDataXml()) . '"),' . "\n"
				. 'path : "' . self::$libraryPath . '"' . "\n"
				. '};' . "\n"
				. 'var params = {};' . "\n"
				. ($bgColor == "transparent" ? 'params.wmode="transparent";' . "\n" : "")
				. 'swfobject.embedSWF("' . $this->getSwfPath() . '", "chart_' . $this->id . '_flash", "' . $width . '", "' . $height . '", "8", "", flashvars, params, {}, function(e) {' . "\n"
					. 'if(!e.success) {' . "\n"
						. 'document.getElementById("chart_' . $this->id . '_flash").innerHTML = "Flash播放器错误!";' . "\n"
					. '}' . "\n"
				. '});' . "\n"
				. '// ]]>' . "\n"
				. '</script>' . "\n";
		}

		return $code;
	}

	/**
	 * 设置 config array. 格式如下:
	 * array(
	 *   "width" => 200,
	 *   "height" => 100,
	 *   "legend.enabled" => false
	 * )
	 *
	 * @param	array				$_config
	 * @param	bool				$_merge
	 */
	public function setConfigAll(array $_config, $_merge = false) 
	{
		if($_merge) 
		{
			foreach($_config AS $key => $value)
			{
				$this->config[$key] = $value;
			}
		}
		else
		{
			$this->config = $_config;
		}
	}

	/**
	 * 设置单个config variable.
	 *
	 * @param	string				$_key
	 * @param	mixed				$_value
	 */
	public function setConfig($_key, $_value) 
	{
		$this->config[$_key] = $_value;
	}

	/**
	 * 返回 config array.
	 *
	 * @return	array
	 */
	public function getConfig() 
	{
		return $this->config;
	}

	/**
	 * 根据config返回可用xml字符串 或 SimpleXml 元素.
	 *
	 * @param	bool				$_asString
	 * @return	mixed
	 */
	public function getConfigXml($_asString = true) 
	{
		$settings = self::array2xml($this->config, "settings");

		/*
		 * Add Labels
		 */
		if(count($this->labels) > 0) 
		{
			$labels = $settings->addChild("labels");

			foreach($this->labels AS $label) 
			{
				$labelNode = $labels->addChild("label");
				$labelNode->addChild("text", $label['text']);
				$labelNode->addChild("x", $label['x']);
				$labelNode->addChild("y", $label['y']);

				foreach($label['config'] AS $key => $value) 
				{
					$labelNode->addChild($key, $value);
				}
			}
		}

		/*
		 * Return
		 */
		if($_asString) 
		{
			$xmlString = $settings->asXML();
			// Remove XML Tag (not needed for config)
			$xmlString = trim(substr($xmlString, strpos($xmlString, "?>") + 2));
			return $xmlString;
		}
		else
		{
			return $settings;
		}
	}

	/**
	 * 返回可用xml字符串 或 SimpleXml 元素.
	 *
	 * @param	bool				$_asString
	 * @return	mixed
	 */
	public abstract function getDataXml($_asString = true);

	/**
	 * Returns the path to the chart-specific swf file.
	 *
	 * @return	string
	 */
	protected abstract function getSwfPath();

	/**
	 * 根据settings数组创建一个 SimpleXml 元素
	 *
	 * @param	array				$_data
	 * @param	string				$_rootNode
	 * @return	SimpleXmlElement
	 */
	public static function array2xml(array $_data, $_rootNode) 
	{
		$rootNode = new SimpleXmlElement("<" . $_rootNode . "></" . $_rootNode . ">");

		foreach($_data AS $key => $value) 
		{
			$keyPath = (array)explode(".", $key);
			
			$currentNode = $rootNode;

			for($i = 0; $i < count($keyPath) - 1; $i++) 
			{
				$nextNode = null;
				
				$attr = explode("|",$keyPath[$i]);
				$attrVk = array();
				if(count($attr)>1){
					//判断是否添加属性
					$attrVk = explode("=",$attr[1]);
				}

				foreach($currentNode->children() AS $child) 
				{
					if(count($attrVk)>1){
						//echo $child->getName() .'=='. $keyPath[$i].'<br>';
						foreach($child->attributes() as $a => $b){
							if($b == $attrVk[1]){
								$nextNode = $child;
							}
						}
					}else{
						if($child->getName() == $keyPath[$i]) 
						{
							$nextNode = $child;
							break;
						}
					}
				}

				if($nextNode === null)
				{
					if(count($attr)>1){
						$nextNode = $currentNode->addChild($attr[0]);
						$nextNode->addAttribute($attrVk[0], $attrVk[1]);
					}else{
						$nextNode = $currentNode->addChild($keyPath[$i]);
					}
				}

				$currentNode = $nextNode;
			}

			// Convert boolean values
			if($value === true || $value === false)
			{
				$value = (int)$value;
			}

			$currentNode->addChild($keyPath[count($keyPath) - 1], $value);
		}

		return $rootNode;
	}

}