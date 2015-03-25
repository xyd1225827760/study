<?php
/**
 * pager�࣬�ṩ�����ݿ��ҳ�Ĳ�����
 * 
 * @copyright   Copyright: 2010
 * @author      LuoDong <751450467@qq.com>
 * @package     CandorPHP
 * @version     $Id: pager.class.php,v 1.1 2011/11/28 06:12:23 ld Exp $
 */
class page_pager
{
    /**
     * Ĭ��ÿҳ��ʾ��¼����
     *
     * @public int
     */
    const DEFAULT_REC_PRE_PAGE = 20;

    /**
     * ��¼������
     *
     * @public int
     */
    public $recTotal;

    /**
     * ÿҳ��ʾ��¼����
     *
     * @public int
     */
    public $recPerPage;

    /**
     * �ܹ���ҳ����
     *
     * @public int
     */
    public $pageTotal;

    /**
     * ��ǰҳ����Χ��
     *
     * @public int
     */
    public $pageID;

    /**
     * ȫ�ֵ�app����
     *
     * @private object
     */
    private $app;

    /**
     * ȫ�ֵ�lang����
     *
     * @private object
     */
    private $lang;

    /**
     * ��ǰ�����moduleName��
     *
     * @private string
     */
    private $moduleName;

    /**
     * ��ǰ�����methodName��
     *
     * @private string
     */
    private $methodName;

    /**
     * ��ǰ����Ĳ�����
     *
     * @private array
     */
    private $params;

    /**
     * ���캯����
     *
     * @param  int      $recTotal       ��¼����
     * @param  int      $recPerPage     ÿҳ��¼����
     * @param  int      $pageID         ��ǰ��ҳID��
     */
    public function __construct($recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->setRecTotal($recTotal);
        $this->setRecPerPage($recPerPage);
        $this->setPageTotal();
        $this->setPageID($pageID);
        $this->setApp();
        $this->setLang();
        $this->setModuleName();
        $this->setMethodName();
    }

    /* factory. */
    public function init($recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        return new pager($recTotal, $recPerPage, $pageID);
    }

    /* ���ü�¼������*/
    public function setRecTotal($recTotal = 0)
    {
        $this->recTotal = (int)$recTotal;
    }

    /* ����ÿҳ��ʾ�ļ�¼����*/
    public function setRecPerPage($recPerPage)
    {
        $this->recPerPage = ($recPerPage > 0) ? $recPerPage : SELF::DEFAULT_REC_PRE_PAGE;
    }

    /* �����ܹ���ҳ����*/
    public function setPageTotal()
    {
        $this->pageTotal = ceil($this->recTotal / $this->recPerPage);
    }

    /* ���õ�ǰ�ķ�ҳID��*/
    public function setPageID($pageID)
    {
        if($pageID > 0 and $pageID <= $this->pageTotal)
        {
            $this->pageID = $pageID;
        }
        else
        {
            $this->pageID = 1;
        }
    }

    /* ����app����*/
    private function setApp()
    {
        global $app;
        $this->app = $app;
    }

    /* ����lang����*/
    private function setLang()
    {
        global $lang;
        $this->lang = $lang;
    }

    /* ����moduleName��*/
    private function setModuleName()
    {
        $this->moduleName = $this->app->getModuleName();
    }

    /* ����methodName��*/
    private function setMethodName()
    {
        $this->methodName = $this->app->getMethodName();
    }

    /* ����params����ע���÷���Ӧ��������html����֮ǰ�����á�*/
    private function setParams()
    {
        $this->params = $this->app->getParams();
        foreach($this->params as $key => $value)
        {
            if(strtolower($key) == 'rectotal')   $this->params[$key] = $this->recTotal;
            if(strtolower($key) == 'recperpage') $this->params[$key] = $this->recPerPage;
            if(strtolower($key) == 'pageID')     $this->params[$key] = $this->pageID;
        }
    }

    /* ����limit��䡣*/
    public function limit()
    {
        $limit = '';
        if($this->pageTotal > 1) $limit = ' limit ' . ($this->pageID - 1) * $this->recPerPage . ", $this->recPerPage";
        return $limit;
    }
   
    /**
     * ����pager��html���롣
     *
     * @param  string $align  Alignment, left|center|right, the default is right.
     * @param  string $type   type, full|short|shortest.
     * @return string         The html code of the pager.
     */
    function get($align = 'right', $type = 'full')
    {
        /* If the RecTotal is zero, return with no record. */
        if($this->recTotal == 0) { return "<div style='float:$align; clear:none'>{$this->lang->pager->noRecord}</div>"; }

        /* ���õ�ǰ���󴫵ݵĲ�����*/
        $this->setParams();
        
        /* ����ģʽ�¶��е����ݡ�*/
        $pager  = $this->createPrePage();
        $pager .= $this->createNextPage();

        /* short��fullģʽ���е����ݡ�*/
        if($type !== 'shortest')
        {
            $pager  = $this->createFirstPage() . $pager;
            $pager .= $this->createLastPage();
        }

        /* Fullģʽ�е����ݡ�*/
        if($type == 'full')
        {
            $pager  = $this->createDigest() . $pager;
            $pager .= $this->createGoTo();
            $pager .= $this->createRecPerPageJS();
        }

        return "<div style='float:$align; clear:none'>$pager</div>";
    }

    /* ����ժҪ���롣*/
    function createDigest()
    {
        return sprintf($this->lang->pager->digest, $this->recTotal, $this->createRecPerPageList(), $this->pageID, $this->pageTotal);
    }

    /* ������ҳ���ӡ�*/
    function createFirstPage()
    {
        if($this->pageID == 1) return $this->lang->pager->first . ' ';
        $this->params['pageID'] = 1;
        return html::a(helper::createLink($this->moduleName, $this->methodName, $this->params), $this->lang->pager->first);
    }

    /* ����ǰҳ���ӡ�*/
    function createPrePage()
    {
        if($this->pageID == 1) return $this->lang->pager->pre . ' ';
        $this->params['pageID'] = $this->pageID - 1;
        return html::a(helper::createLink($this->moduleName, $this->methodName, $this->params), $this->lang->pager->pre);
    }    

    /* ������ҳ���ӡ�*/
    function createNextPage()
    {
        if($this->pageID == $this->pageTotal) return $this->lang->pager->next . ' ';
        $this->params['pageID'] = $this->pageID + 1;
        return html::a(helper::createLink($this->moduleName, $this->methodName, $this->params), $this->lang->pager->next);
    }

    /* ����ĩҳ���ӡ�*/
    function createLastPage()
    {
        if($this->pageID == $this->pageTotal) return $this->lang->pager->last . ' ';
        $this->params['pageID'] = $this->pageTotal;
        return html::a(helper::createLink($this->moduleName, $this->methodName, $this->params), $this->lang->pager->last);
    }    

    /* ����JS���롣*/
    function createRecPerPageJS()
    {
        /* ��������params�������й��ڷ�ҳ�ı�����Ӧ��ֵ����Ϊ����ı�ǣ�Ȼ��ʹ��js�����滻Ϊ��Ӧ��ֵ��*/
        $params = $this->params;
        foreach($params as $key => $value)
        {
            if(strtolower($key) == 'rectotal')   $params[$key] = '_recTotal_';
            if(strtolower($key) == 'recperpage') $params[$key] = '_recPerPage_';
            if(strtolower($key) == 'pageid')     $params[$key] = '_pageID_';
        }
        $vars = '';
        foreach($params as $key => $value) $vars .= "$key=$value&";
        $vars = rtrim($vars, '&');

        $js  = <<<EOT
        <script language='Javascript'>
        vars = '$vars';
        function submitPage(mode)
        {
            pageTotal  = parseInt(document.getElementById('_pageTotal').value);
            pageID     = document.getElementById('_pageID').value;
            recPerPage = document.getElementById('_recPerPage').value;
            recTotal   = document.getElementById('_recTotal').value;
            if(mode == 'changePageID')
            {
                if(pageID > pageTotal) pageID = pageTotal;
                if(pageID < 1) pageID = 1;
            }
            else if(mode == 'changeRecPerPage')
            {
                pageID = 1;
            }

            vars = vars.replace('_recTotal_', recTotal)
            vars = vars.replace('_recPerPage_', recPerPage)
            vars = vars.replace('_pageID_', pageID);
            location.href=createLink('$this->moduleName', '$this->methodName', vars);
        }
        </script>
EOT;
        return $js;
    }

    /* Create the select list of RecPerPage. */
    function createRecPerPageList()
    {
        for($i = 5; $i <= 50; $i += 5) $range[$i] = $i;
        $range[100] = 100;
        $range[200] = 200;
        $range[500] = 500;
        return html::select('_recPerPage', $range, $this->recPerPage, "onchange='submitPage(\"changeRecPerPage\");'");
    }

    /* Create the link html code of goto box. */ 
    function createGoTo()
    {
        $goToHtml  = "<input type='hidden' id='_recTotal'  value='$this->recTotal' />\n";
        $goToHtml .= "<input type='hidden' id='_pageTotal' value='$this->pageTotal' />\n";
        $goToHtml .= "<input type='text'   id='_pageID'    value='$this->pageID' style='text-align:center;width:30px;' /> \n";
        $goToHtml .= "<input type='button' id='goto'       value='{$this->lang->pager->locate}' onclick='submitPage(\"changePageID\");' />";
        return $goToHtml;
    }    
}
