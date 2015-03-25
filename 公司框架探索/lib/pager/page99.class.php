<?php
class pager_page{
   private   $page_size;//ÿҳ��ʾ����Ŀ��
   private   $nums;//����Ŀ��
   private   $current_page;//��ǰ��ѡ�е�ҳ
   private   $sub_pages;//ÿ����ʾ��ҳ��
   private   $page_nums;//��ҳ��
   private   $page_array = array();//���������ҳ������
   private   $subPage_link;//ÿ����ҳ������
   private   $subPage_type;//��ʾ��ҳ������
   private   $page_html;//��󷵻صķ�ҳhtml����
   /*
   __construct��SubPages�Ĺ��캯���������ڴ������ʱ���Զ�����.
   @$page_size   ÿҳ��ʾ����Ŀ��
   @nums ����Ŀ��
   @current_num ��ǰ��ѡ�е�ҳ
   @sub_pages    ÿ����ʾ��ҳ��
   @subPage_link ÿ����ҳ������
   @subPage_type ��ʾ��ҳ������
  
   ��@subPage_type=1��ʱ��Ϊ��ͨ��ҳģʽ
       example��   ��4523����¼,ÿҳ��ʾ10��,��ǰ��1/453ҳ [��ҳ] [��ҳ] [��ҳ] [βҳ]
       ��@subPage_type=2��ʱ��Ϊ�����ҳ��ʽ
       example��   ��ǰ��1/453ҳ [��ҳ] [��ҳ] 1 2 3 4 5 6 7 8 9 10 [��ҳ] [βҳ]
   */
function __construct($page_size,$nums,$current_page,$sub_pages=5,$subPage_link,$subPage_type){
	$this->page_size=intval($page_size);
	$this->nums=intval($nums);
	if(!$current_page){
		$this->current_page=1;
	}else{
		$this->current_page=intval($current_page);
	}
	$this->sub_pages=intval($sub_pages);
	$this->page_nums=ceil($nums/$page_size);
	$this->subPage_link='?'.$subPage_link.'page='; 
	$this->show_SubPages($subPage_type);
	//echo $this->page_nums."--".$this->sub_pages;
}

/**
* ���ط�ҳhtml����
* @access public
* @return string
*/
public function get_page_html(){
	return $this->page_html;
}

/*
* __destruct�������������಻��ʹ�õ�ʱ����ã��ú��������ͷ���Դ��
*/
function __destruct(){
	unset($page_size);
	unset($nums);
	unset($current_page);
	unset($sub_pages);
	unset($page_nums);
	unset($page_array);
	unset($subPage_link);
	unset($subPage_type);
	unset($page_str);
}
  
/*
* show_SubPages�������ڹ��캯�����档���������ж���ʾʲô���ӵķ�ҳ  
*/
private function show_SubPages($subPage_type){
	if($subPage_type == 1){
		$this->subPageCss1();
	}elseif ($subPage_type == 2){
		$this->subPageCss2();
	}elseif ($subPage_type == 3){
		$this->subPageCss3();
	}elseif ($subPage_type == 4){
		$this->subPageCss4();
	}
}
  
  
/*
* ������������ҳ�������ʼ���ĺ�����
*/
private function initArray(){
	for($i=0;$i<$this->sub_pages;$i++){
	$this->page_array[$i]=$i;
	}
	return $this->page_array;
}
  
  
/*
* construct_num_Page�ú���ʹ����������ʾ����Ŀ
* ��ʹ��[1][2][3][4][5][6][7][8][9][10]
*/
private function construct_num_Page(){
	if($this->page_nums < $this->sub_pages){
		$current_array=array();
		for($i=0;$i<$this->page_nums;$i++){ 
			$current_array[$i]=$i+1;
		}
	}else{
		$current_array=$this->initArray();
		if($this->current_page <= 3){
			for($i=0;$i<count($current_array);$i++){
		   $current_array[$i]=$i+1;
			}
		}elseif ($this->current_page <= $this->page_nums && $this->current_page > $this->page_nums - $this->sub_pages + 1 ){
			for($i=0;$i<count($current_array);$i++){
		   $current_array[$i]=($this->page_nums)-($this->sub_pages)+1+$i;
			}
		}else{
			for($i=0;$i<count($current_array);$i++){
		   $current_array[$i]=$this->current_page-2+$i;
			}
		}
	}
	return $current_array;
}
  
/*
 *  ������ͨģʽ�ķ�ҳ
 *  ��4523����¼,ÿҳ��ʾ10��,��ǰ��1/453ҳ [��ҳ] [��ҳ] [��ҳ] [βҳ]
 */
private function subPageCss1(){
	$subPageCss1Str="";
	$subPageCss1Str.="��".$this->nums."����¼��";
	$subPageCss1Str.="ÿҳ��ʾ".$this->page_size."����";
	$subPageCss1Str.="��ǰ��".$this->current_page."/".$this->page_nums."ҳ ";
	if($this->current_page > 1){
	$firstPageUrl=$this->subPage_link."1";
	$prewPageUrl=$this->subPage_link.($this->current_page-1);
	$subPageCss1Str.="[<a href='$firstPageUrl'>��ҳ</a>] ";
	$subPageCss1Str.="[<a href='$prewPageUrl'>��һҳ</a>] ";
	}else {
	$subPageCss1Str.="[��ҳ] ";
	$subPageCss1Str.="[��һҳ] ";
	}

	if($this->current_page < $this->page_nums){
	$lastPageUrl=$this->subPage_link.$this->page_nums;
	$nextPageUrl=$this->subPage_link.($this->current_page+1);
	$subPageCss1Str.=" [<a href='$nextPageUrl'>��һҳ</a>] ";
	$subPageCss1Str.="[<a href='$lastPageUrl'>βҳ</a>] ";
	}else {
		$subPageCss1Str.="[��һҳ] ";
		$subPageCss1Str.="[βҳ] ";
	}
	$this->page_html = $subPageCss1Str;
}
  
  
/*
 *  ���쾭��ģʽ�ķ�ҳ
 *  ��ǰ��1/453ҳ [��ҳ] [��ҳ] 1 2 3 4 5 6 7 8 9 10 [��ҳ] [βҳ]
 */
private function subPageCss2(){
	$subPageCss2Str="";
	$subPageCss2Str.="��ǰ��".$this->current_page."/".$this->page_nums."ҳ ";

	if($this->current_page > 1){
		$firstPageUrl=$this->subPage_link."1";
		$prewPageUrl=$this->subPage_link.($this->current_page-1);
		$subPageCss2Str.="[<a href='$firstPageUrl'>��ҳ</a>] ";
		$subPageCss2Str.="[<a href='$prewPageUrl'>��һҳ</a>] ";
	}else {
		$subPageCss2Str.="[��ҳ] ";
		$subPageCss2Str.="[��һҳ] ";
	}

	$a=$this->construct_num_Page();
	for($i=0;$i<count($a);$i++){
		$s=$a[$i];
		if($s == $this->current_page ){
			$subPageCss2Str.="[<span style='color:red;font-weight:bold;'>".$s."</span>]";
		}else{
			$url=$this->subPage_link.$s;
			$subPageCss2Str.="[<a href='$url'>".$s."</a>]";
		}
	}

	if($this->current_page < $this->page_nums){
		$lastPageUrl=$this->subPage_link.$this->page_nums;
		$nextPageUrl=$this->subPage_link.($this->current_page+1);
		$subPageCss2Str.=" [<a href='$nextPageUrl'>��һҳ</a>] ";
		$subPageCss2Str.="[<a href='$lastPageUrl'>βҳ</a>] ";
	}else {
		$subPageCss2Str.="[��һҳ] ";
		$subPageCss2Str.="[βҳ] ";
	}
	$this->page_html = $subPageCss2Str;
}

/*
 *  üɽ��ҳ
 *  ���� 120 ����¼����ǰ�� 1/10 ҳ  [��ҳ] [��ҳ] [��ҳ] [βҳ]  ת���� ҳ 
 */
private function subPageCss3(){
	$subPageCss3Str='<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>  ';
	$subPageCss3Str.="����&nbsp;".$this->nums."&nbsp;����¼����ǰ��".$this->current_page."/".$this->page_nums."&nbsp;</td><td><table border=0 align=right  cellpadding=0 cellspacing=0 ><tr>";
	if($this->current_page > 1){
		$firstPageUrl=$this->subPage_link."1";
		$prewPageUrl=$this->subPage_link.($this->current_page-1);
		$subPageCss3Str.='<td width="40"><a href="'.$firstPageUrl.'"><img src="/theme/default/images/table/first.gif" width="37" height="15" /></a></td>';
		$subPageCss3Str.='<td width="45"><a href="'.$prewPageUrl.'"><img src="/theme/default/images/table/back.gif" width="37" height="15" /></a></td>';
	}else {
		$subPageCss3Str.='<td width="40"><img src="/theme/default/images/table/first_off.gif" width="37" height="15" /></td>';
		$subPageCss3Str.='<td width="45"><img src="/theme/default/images/table/back_off.gif" width="37" height="15" /></td>';
	}

	if($this->current_page < $this->page_nums){
		$lastPageUrl=$this->subPage_link.$this->page_nums;
		$nextPageUrl=$this->subPage_link.($this->current_page+1);
		$subPageCss3Str.='<td width="45"><a href="'.$nextPageUrl.'"><img src="/theme/default/images/table/next.gif" width="43" height="15" /></a></td>';
		$subPageCss3Str.='<td width="40"><a href="'.$lastPageUrl.'"><img src="/theme/default/images/table/last.gif" width="43" height="15" /></a></td>';
	}else {
		$subPageCss3Str.='<td width="45"><img src="/theme/default/images/table/next_off.gif" width="43" height="15" /></td>';
		$subPageCss3Str.='<td width="40"><img src="/theme/default/images/table/last_off.gif" width="43" height="15" /></td>';
	}
	$subPageCss3Str.='<td width="100">&nbsp;ת���� <input name="textfield" type="text" size="4" style="height:12px; width:20px; border:1px solid #999999;" onBlur="$(\'#gotoPage\').attr(\'href\',$(\'#gotoPage\').attr(\'href\')+this.value)" /> ҳ</td>';
	$subPageCss3Str.='<td width="40"><a id="gotoPage" href="'.$this->subPage_link.'"><img src="/theme/default/images/table/go.gif" width="37" height="15" /></a></td></tr></table></table>';
	$this->page_html = $subPageCss3Str;
}

/*
 *  ����Ϸ�ҳ
 *  [��ҳ] [��ҳ] 1 2 3 4 5 6 7 8 9 10 [��ҳ] [βҳ]
 */
private function subPageCss4(){
	$subPageCss3Str="";

	if($this->current_page > 1){
		$firstPageUrl=$this->subPage_link."1";
		$prewPageUrl=$this->subPage_link.($this->current_page-1);
		$subPageCss3Str.="<li class='previous-on'><a href='$prewPageUrl'>&laquo;��һҳ</a></li> ";
	}else {
		$subPageCss3Str.="<li class='previous-off'>&laquo;��һҳ</li> ";
	}

	$a=$this->construct_num_Page();
	for($i=0;$i<count($a);$i++){
		$s=$a[$i];
		if($s == $this->current_page ){
			$subPageCss3Str.="<li class='active'>".$s."</li>";
		}else{
			$url=$this->subPage_link.$s;
			$subPageCss3Str.="<li><a href='$url'>".$s."</a></li>";
		}
	}

	if($this->current_page < $this->page_nums){
		$lastPageUrl=$this->subPage_link.$this->page_nums;
		$nextPageUrl=$this->subPage_link.($this->current_page+1);
		$subPageCss3Str.=" <li class='next'><a href='$nextPageUrl'>��һҳ &raquo;</a></li> ";
	}else {
		$subPageCss3Str.="<li class='next-off'>��һҳ &raquo;</li> ";
	}
	$subPageCss3Str .= "<li class='next-off'>����".$this->nums."����¼����ǰ��".$this->current_page."/".$this->page_nums."ҳ</li>";
	$this->page_html = $subPageCss3Str;
}

}
?>
