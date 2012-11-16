<?php
/*
 * Created on 2011-07-28
 * Author : LKK , http://lianq.net
 * 使用方法：
	 require_once('mypage.php');
	 $result=mysql_query("select * from mytable", $myconn);
	 $total=mysql_num_rows($result);	//取得信息总数
	 pageDivide($total,10);		//调用分页函数
	 
	 //数据库操作
	 $result=mysql_query("select * from mytable limit $sqlfirst,$shownu", $myconn);
	 while($row=mysql_fetch_array($result)){
	 	...您的操作
	 }
 	 echo $pagecon;	//输出分页导航内容
 */

if(!function_exists("pageDivide")){
#$total		信息总数
#$shownu	显示数量,默认20
#$url		本页链接
function pageDivide($total,$shownu=20,$url=''){

	#$page  	当前页码
	#$sqlfirst 	mysql数据库起始项
	#$pagecon	分页导航内容
	global $page,$sqlfirst,$pagecon,$_SERVER;
	$GLOBALS["shownu"]=$shownu;
	
	if(isset($_GET['page'])){
		$page=$_GET['page'];
	}else $page=1;
	
	#如果$url使用默认,即空值,则赋值为本页URL
	if(!$url){ $url=$_SERVER["REQUEST_URI"];}
	
	#URL分析
	$parse_url=parse_url($url);
	@$url_query=$parse_url["query"];	//取出在问号?之后内容
	if($url_query){
		$url_query=preg_replace("/(&?)(page=$page)/","",$url_query);
		$url = str_replace($parse_url["query"],$url_query,$url);
		if($url_query){
		  $url .= "&page";
		}else $url .= "page";
	}else $url .= "?page";
	
	#页码计算
	$lastpg=ceil($total/$shownu);	//最后页,总页数
	$page=min($lastpg,$page);
	$prepg=$page-1; 				//上一页
	$nextpg=($page==$lastpg ? 0 : $page+1); //下一页
	$sqlfirst=($page-1)*$shownu;
	
	#开始分页导航内容
	$pagecon = "显示第 ".($total?($sqlfirst+1):0)."-".min($sqlfirst+$shownu,$total)." 条记录，共 <B>$total</B> 条记录";
	if($lastpg<=1) return false;	//如果只有一页则跳出
	
	if($page!=1) $pagecon .=" <a href='$url=1'>首页</a> "; else $pagecon .=" 首页 ";
	if($prepg) $pagecon .=" <a href='$url=$prepg'>前页</a> "; else $pagecon .=" 前页 ";
	if($nextpg) $pagecon .=" <a href='$url=$nextpg'>后页</a> "; else $pagecon .=" 后页 ";
	if($page!=$lastpg) $pagecon.=" <a href='$url=$lastpg'>尾页</a> "; else $pagecon .=" 尾页 ";
	
	#下拉跳转列表,循环列出所有页码
	$pagecon .="　到第 <select name='topage' size='1' onchange='window.location=\"$url=\"+this.value'>\n";
	for($i=1;$i<=$lastpg;$i++){
		if($i==$page) $pagecon .="<option value='$i' selected>$i</option>\n";
		else $pagecon .="<option value='$i'>$i</option>\n";
	}
	$pagecon .="</select> 页，共 $lastpg 页";

}
}else die('pageDivide()同名函数已经存在!');
?>