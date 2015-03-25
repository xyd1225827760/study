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
<div id="wrapper">
	<?php include '../../common/header.html.php';?>
    <div id="body_container"> 
      <!--left container starts-->
      <?php include '../../common/left.html.php';?>
      <!--left container ends--> 

      <!--right container starts-->
      <div id="right_container">
        <div class="wq_pack_outer">
        	ID:<input name="id" id="id" value="" type="text" /><input type="button" value="查找" onclick="searchData();" /><br />
			<table id="list2"></table>
			<div id="pager2"></div>
            <br />
            <input type="button" value="获取当前选取行ID" onclick="getRowsID();" />
            <input type="button" value="清空数据" onclick="deletAllData()" />
            <input type="button" value="重新加载数据" onclick="refreshData()" />
            <input type="button" value="新增数据" onclick="insertData();" />
            <input type="button" value="修改数据" onclick="updataData();" />
            <input type="button" value="删除数据" onclick="deleteData();" />
            
		</div>
      </div>
      <br class="clear">
      <!--right container ends--> 
    </div>
    <br class="clear">
</div>
<?php include '../../common/footer.html.php';?>
<script>

var jsondata = {"page":1,"total":6,"records":"114","rows":[{"id":"154","cell":["154","\u4e00\u73af\u8def\u5357\u4e00\u6bb5\u597d\u671b\u89d2","\u4e00\u73af\u8def\u5357\u4e00\u6bb52\u53f7","lee","\u597d\u671b\u89d2\u5546\u4e1a\u6587\u5316\u5e7f\u573a","31.00","13558745351"]},{"id":"153","cell":["153","\u91d1\u79d1\u54c1\u8d28","\u4e1c\u4e3d\u8def138\u53f7","lee","\u91d1\u79d1\u4e00\u57ce","48.00","13060044767"]},{"id":"152","cell":["152","\u662d\u89c9\u5bfa\u91d1\u79d1\u4e00\u57ce","\u4e1c\u4e3d\u8def138\u53f7","lee","\u91d1\u79d1\u4e00\u57ce","54.00","13689073336"]},{"id":"151","cell":["151","\u4e1c\u4e3d\u8def\u91d1\u79d1\u4e00\u57ce","\u4e1c\u4e3d\u8def138\u53f7","lee","\u91d1\u79d1\u4e00\u57ce","63.00","13408653326"]},{"id":"150","cell":["150","\u91d1\u79d1\u4e00\u57ce","\u4e1c\u4e3d\u8def138\u53f7","lee","\u91d1\u79d1\u4e00\u57ce","43.00","13880464226"]},{"id":"149","cell":["149","\u4e1c\u4e3d\u8def\u91d1\u79d1\u4e00\u57ce","\u4e1c\u4e3d\u8def138\u53f7","lee","\u91d1\u79d1\u4e00\u57ce","63.00","13308221917"]},{"id":"148","cell":["148","\u91d1\u79d1\u4e00\u57ce","\u4e1c\u4e3d\u8def138\u53f7","lee","\u91d1\u79d1\u4e00\u57ce","54.00","13608084935"]},{"id":"147","cell":["147","\u52a8\u7269\u56ed\u65c1 \u91d1\u79d1\u4e00\u57ce","\u4e1c\u4e3d\u8def138\u53f7","lee","\u91d1\u79d1\u4e00\u57ce","75.00","13881883020"]},{"id":"146","cell":["146","\u9a77\u9a6c\u6865 \u91d1\u79d1\u4e00\u57ce","\u4e1c\u4e3d\u8def138\u53f7","lee","\u91d1\u79d1\u4e00\u57ce","70.00","13908022260"]},{"id":"145","cell":["145","\u57ce\u5317\u7b2c\u4e00\u57ce \u91d1\u79d1\u4e00\u57ce","\u4e1c\u4e3d\u8def138\u53f7","lee","\u91d1\u79d1\u4e00\u57ce","76.00","13882282976"]},{"id":"144","cell":["144","\u57ce\u5317\u9ad8\u7b0b\u5858 \u91d1\u79d1\u4e00\u57ce","\u4e1c\u4e3d\u8def138\u53f7","lee","\u91d1\u79d1\u4e00\u57ce","54.00","13438487223"]},{"id":"143","cell":["143","\u4e1c\u4e3d\u8def\u91d1\u79d1\u4e00\u57ce","\u4e1c\u4e3d\u8def138\u53f7","lee","\u91d1\u79d1\u4e00\u57ce","55.00","13980508548"]},{"id":"142","cell":["142","\u91d1\u79d1\u4e00\u57ce \u4e1c\u4e3d\u8def","\u4e1c\u4e3d\u8def138\u53f7","lee","\u91d1\u79d1\u4e00\u57ce","40.00","13194875412"]},{"id":"141","cell":["141","\u91d1\u79d1\u4e00\u57ce","\u4e1c\u4e3d\u8def138\u53f7","lee","\u91d1\u79d1\u4e00\u57ce","60.00","15928440300"]},{"id":"140","cell":["140","\u4e1c\u4e3d\u8def\u91d1\u79d1\u4e00\u57ce","\u4e1c\u4e3d\u8def138\u53f7","lee","\u91d1\u79d1\u4e00\u57ce","52.00","13880138323"]},{"id":"139","cell":["139","\u6e05\u6c5f\u897f\u8def\u63fd\u80dc\u91d1\u6c99","\u6e05\u6c5f\u897f\u8def90\u53f7","lee","\u63fd\u80dc\u91d1\u6c99","55.00","15183381303"]},{"id":"138","cell":["138","\u63fd\u80dc\u91d1\u6c99 \u6e05\u6c5f\u897f\u8def","\u6e05\u6c5f\u897f\u8def90\u53f7","lee","\u63fd\u80dc\u91d1\u6c99","75.00","15982092175"]},{"id":"137","cell":["137","\u4e1c\u4e3d\u8def\u91d1\u79d1\u4e00\u57ce","\u4e1c\u4e3d\u8def138\u53f7","lee","\u91d1\u79d1\u4e00\u57ce","50.00","15308201843"]},{"id":"136","cell":["136","\u4e1c\u4e3d\u8def\u91d1\u79d1\u4e00\u57ce","\u4e1c\u4e3d\u8def138\u53f7","lee","\u91d1\u79d1\u4e00\u57ce","75.00","13438186675"]},{"id":"135","cell":["135","\u63fd\u80dc\u91d1\u6c99","\u6e05\u6c5f\u897f\u8def90\u53f7","lee","\u63fd\u80dc\u91d1\u6c99","70.00","13541043694"]}]};

var localReader = {
   root: "rows",
   page: "page",
   total: "total",
   records: "records",
   repeatitems: true,
   cell: "cell",
   id: "id"
};
/*
jQuery(document).ready(function(){ 
jQuery("#list2").jqGrid({
		datatype: "jsonstring",
		datastr:jsondata,
        colNames:['id','title', 'address', 'user_name','reside','price','telphone'],
		colModel:[
			{name:'id',index:'id', width:55},
			{name:'title',index:'title', width:90},
			{name:'address',index:'address asc, title', width:100},
			{name:'user_name',index:'user_name', width:80, align:"right"},
			{name:'reside',index:'reside', width:80, align:"right"},		
			{name:'price',index:'price', width:80,align:"right"},		
			{name:'telphone',index:'telphone', width:150, sortable:false}		
		],
        pager: '#pager2',
        rowNum:10,
        viewrecords: true,
        caption: 'My first grid',
		jsonReader :localReader
	});

});
*/

/*
var mystr ="<invoices><rows><row><cell>data1</cell><cell>data2</cell><cell>data3</cell><cell>data4</cell><cell>data5</cell><cell>data6</cell></row></rows></invoices>";
var mystr2="<invoices><rows><row><cell>data1</cell><cell>data2</cell><cell>data3</cell><cell>data4</cell><cell>data5</cell><cell>data6</cell></row></rows></invoices>";
jQuery(document).ready(function(){ 
  jQuery("#list2").jqGrid({
    datatype: 'xmlstring',
    datastr : mystr,
    colNames:['Inv No','Date', 'Amount','Tax','Total','Notes'],
    colModel :[ 
      {name:'invid', index:'invid', width:55, sorttype:'int'}, 
      {name:'invdate', index:'invdate', width:90, sorttype:'date', datefmt:'Y-m-d'}, 
      {name:'amount', index:'amount', width:80, align:'right', sorttype:'float'}, 
      {name:'tax', index:'tax', width:80, align:'right', sorttype:'float'}, 
      {name:'total', index:'total', width:80, align:'right', sorttype:'float'}, 
      {name:'note', index:'note', width:150, sortable:false} ],
    pager: '#pager',
    rowNum:10,
    viewrecords: true,
    caption: 'My first grid',
	onSelectRow: function(id){ 
      if(invid && invid!==lastSel){ 
         jQuery(this).restoreRow(lastSel); 
         lastSel=invid; 
		 alert(lastSel);
      } 
      jQuery(this).editRow(invid, true); 
	  }
  }); 
}); 
*/



jQuery("#list2").jqGrid({
   	//url:'/index/ajaxList.php?q=2',
	datatype: "jsonstring",
	datastr:jsondata,
   	colNames:['id','title', 'address', 'user_name','reside','price','telphone'],
   	colModel:[
   		{name:'id',index:'id', width:55},
   		{name:'title',index:'title', width:90},
   		{name:'address',index:'address asc, title', width:100},
   		{name:'user_name',index:'user_name', width:80, align:"right"},
   		{name:'reside',index:'reside', width:80, align:"right"},		
   		{name:'price',index:'price', width:80,align:"right"},		
   		{name:'telphone',index:'telphone', width:150, sortable:false}		
   	],
   	rowNum:10,
   	rowList:[10,20,30],
   	pager: '#pager2',
   	sortname: 'id',
    viewrecords: true,
    sortorder: "desc",
	cellLayout:10,
	jsonReader:localReader,
	ondblClickRow:function(rowid, iRow, iCol, e){
			alert(123);
		}
});

jQuery("#list2").jqGrid('navGrid','#pager2',{"edit":false,"add":false,"del":false,"search":true,"refresh":true,"view":false,"excel":false,"pdf":false,"csv":false,"columns":false});


function getRowsID(){
	var rowid = $("#list2").getGridParam("selrow");  
	alert(rowid);
	$(".ui-widget-content jqgrow ui-row-ltr:even").addClass("ui-widget-content jqgrow ui-row-ltr t_two"); //给class为stripe_tb的表格的偶数行添加class值为alt
}

function insertData(){
	//新增记录
	$("#list2").addRowData("1", {"id":"1","title":"asdfasd"}, "first");   
}

function updataData(){
	//修改当前选择记录
	var rowid = $("#list2").getGridParam("selrow");  
	if(rowid!=null){
		$("#list2").setRowData( rowid, { title:"5", telphone:"205" });  
	}else{
		alert("请选择要修改的记录id");
	}
}

function deleteAllData(){
	//清空原grid数据  	
	$("#list2" ).clearGridData();   
}

function refreshData(){
	//重新加载数据
	//true:重新加载表格数据, false:不重新加载表格数据   
	//$("#jqGrid").setSelection("1", true);  
	var mygrid = jQuery("#list2")[0];
	var myjsongrid = jsondata; 
	mygrid.addJSONData(myjsongrid); 
	myjsongrid = null; 
	jsonresponse =null;
}

function deleteData(){
	//删除当前选择记录
	var rowid = $("#list2").getGridParam("selrow");  
	if(rowid!=null){
		$("#list2").delRowData( rowid);  
	}else{
		alert("请选择要删除的记录id");
	}
	
}

function searchData(){
	var id = $("#id").val();
	alert(id);	
}
</script>