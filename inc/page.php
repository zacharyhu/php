<?php
/*
 * Created on 2011-07-28
 * Author : LKK , http://lianq.net
 * ʹ�÷�����
	 require_once('mypage.php');
	 $result=mysql_query("select * from mytable", $myconn);
	 $total=mysql_num_rows($result);	//ȡ����Ϣ����
	 pageDivide($total,10);		//���÷�ҳ����
	 
	 //���ݿ����
	 $result=mysql_query("select * from mytable limit $sqlfirst,$shownu", $myconn);
	 while($row=mysql_fetch_array($result)){
	 	...���Ĳ���
	 }
 	 echo $pagecon;	//�����ҳ��������
 */

if(!function_exists("pageDivide")){
#$total		��Ϣ����
#$shownu	��ʾ����,Ĭ��20
#$url		��ҳ����
function pageDivide($total,$shownu=20,$url=''){

	#$page  	��ǰҳ��
	#$sqlfirst 	mysql���ݿ���ʼ��
	#$pagecon	��ҳ��������
	global $page,$sqlfirst,$pagecon,$_SERVER;
	$GLOBALS["shownu"]=$shownu;
	
	if(isset($_GET['page'])){
		$page=$_GET['page'];
	}else $page=1;
	
	#���$urlʹ��Ĭ��,����ֵ,��ֵΪ��ҳURL
	if(!$url){ $url=$_SERVER["REQUEST_URI"];}
	
	#URL����
	$parse_url=parse_url($url);
	@$url_query=$parse_url["query"];	//ȡ�����ʺ�?֮������
	if($url_query){
		$url_query=preg_replace("/(&?)(page=$page)/","",$url_query);
		$url = str_replace($parse_url["query"],$url_query,$url);
		if($url_query){
		  $url .= "&page";
		}else $url .= "page";
	}else $url .= "?page";
	
	#ҳ�����
	$lastpg=ceil($total/$shownu);	//���ҳ,��ҳ��
	$page=min($lastpg,$page);
	$prepg=$page-1; 				//��һҳ
	$nextpg=($page==$lastpg ? 0 : $page+1); //��һҳ
	$sqlfirst=($page-1)*$shownu;
	
	#��ʼ��ҳ��������
	$pagecon = "��ʾ�� ".($total?($sqlfirst+1):0)."-".min($sqlfirst+$shownu,$total)." ����¼���� <B>$total</B> ����¼";
	if($lastpg<=1) return false;	//���ֻ��һҳ������
	
	if($page!=1) $pagecon .=" <a href='$url=1'>��ҳ</a> "; else $pagecon .=" ��ҳ ";
	if($prepg) $pagecon .=" <a href='$url=$prepg'>ǰҳ</a> "; else $pagecon .=" ǰҳ ";
	if($nextpg) $pagecon .=" <a href='$url=$nextpg'>��ҳ</a> "; else $pagecon .=" ��ҳ ";
	if($page!=$lastpg) $pagecon.=" <a href='$url=$lastpg'>βҳ</a> "; else $pagecon .=" βҳ ";
	
	#������ת�б�,ѭ���г�����ҳ��
	$pagecon .="������ <select name='topage' size='1' onchange='window.location=\"$url=\"+this.value'>\n";
	for($i=1;$i<=$lastpg;$i++){
		if($i==$page) $pagecon .="<option value='$i' selected>$i</option>\n";
		else $pagecon .="<option value='$i'>$i</option>\n";
	}
	$pagecon .="</select> ҳ���� $lastpg ҳ";

}
}else die('pageDivide()ͬ�������Ѿ�����!');
?>