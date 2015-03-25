<?php
/**
 * Html模板文件
 *
 * @copyright   Copyright: 2010
 * @author      LuoDong<751450467@qq.com>
 * @package     CandorPHP
 * @version     $Id: index.html.php,v 1.4 2012/02/16 09:54:23 lj Exp $
 */
?>
<?php include '../../common/head.html.php';?>

<?php include '../../common/header.html.php';?>
<div id="body_container"> 
  <!--left container starts-->
  <?php include '../../common/left.html.php';?>
  <!--left container ends--> 

  <!--right container starts-->
  <div id="right_container" class="container-fluid" style="padding-left:0;padding-right:0">
		
        <div id="tabs_platform">
			<div id="taskbar">
        	<ul id="taskbar_list">
                <li class="taskbar_btn">
                     <a title="隐藏顶部" href="javascript:;" id="hide_topbar"></a>
                </li>
            </ul>
        </div>
		</div>
  </div>
  <!--right container ends--> 
</div>
<?php include '../../common/footer.html.php';?>