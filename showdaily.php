<?php 
session_start();
include 'inc/conn.inc.php';//mysql数据库
include 'inc/page.class.php';//分页
?>
<script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<form action="showdaily.php" method="get">
<font color=red>日期:</font><input class="Wdate" type="text" onClick="WdatePicker()", name="date_select">
<select name="select_type">
<option value="cash_sum">充值总金额</option>
<option value="user_active">活跃用户</option>
<option value="cash_type">充值分类 </option>
<option value="vip_data">VIP数据</option>
<option value="game_data">游戏数据</option>
<option value="user_login">用户登录数据</option>
<input type="submit" name="sub" value="查询">
</select>
</form>
<?php

$sub=$_GET['sub'];
//$subpoint=$_GET['subpoint'];
if(!empty($_GET['date_select'])){
    $date_select=$_GET['dateend'];
}else {
	$date_select=date('ymd');
	}
if(!empty($_GET['select_type'])){
    $select_type=$_GET['select_type'];
}else {
	$select_type='cash_sum';
	}
echo $date_select;
echo $select_type;
//确认表单提交查询充值记录
function show_select_data($head_msg,$sql,$subtype){
        $result=mysql_query($sql);
        $_SESSION["excel"]=$sql;
        //$_SESSION["stb"]=$stb;
		$total=mysql_num_rows($result);
        //echo $total."<br>-------total";
        $num=30;	
        $page=new Page($total, $num, "&cid=99");
        $sql=$sql." {$page->limit};";
        //      echo $sql;
        $_SESSION["subtype"]=$subtype;
        //echo $_SESSION["excel"]."  11</br>";
        $result=mysql_query($sql);
	    $cols=mysql_num_fields($result);  
	    //$sql_user="";
	    //$result_user=mysql_query($sql_user);
	    //$col_user=mysql_num_fields($result_user);
	    //$num_u=mysql_num_rows($result);
	    /*if($num_u > 0){
	    	echo '<font  size="3" color="red">用户基本信息:</br></font>';
	    	echo '<table  border="1" style="margin-top:20px;width:80%">';
	    	echo '<tr>';
	    	for($i=0; $i<$col_user; $i++){
	    		echo '<th>'.mysql_field_name($result_user, $i).'</th>';
	    	}
	    	echo '</tr>';
	    	while ($row_user=mysql_fetch_assoc($result_user)){
	    		echo '<tr>';
	    		foreach ($row_user as $col){
	    			echo '<td>'.$col.'</td>';
	    		}
	    		echo '</tr>';
	    	}*/
	    		     
	    
        if(!empty($result)){   
        echo '<table align="center" border="1" width="800" style="margin-top:20px;width:80%">';
        echo $head_msg;
        echo '<thead>'; 
	    echo '<tr>';
             for($i=0; $i<$cols; $i++){
                echo '<th>'.mysql_field_name($result, $i).'</th>';
        }
        echo '</tr>';
        echo '</thead>';
        echo '<tbody class="">';
        while($row=mysql_fetch_assoc($result)){
                echo '<tr onMouseOver=this.style.backgroundColor="#cccccc" onMouseOut=this.style.backgroundColor="#FFFFFF">';
                foreach($row as $col){
                        echo '<td>'.$col.'</td>';
                }
                echo '</tr>';
            }
        //echo '<input name="button" type="button" value="导出数据excel" onclick="excel()" />';
		echo '<tr><td colspan="5" align="right">'.$page->fpage(array(8,3,4,5,6,7,0,1,2)).'</td></tr>';
		echo '</tbody>';
		mysql_free_result($result);
		mysql_close($link);
        }else{
    	echo "没有相关记录！！！！" ;
        }
	echo '</table>';
	    }
	
	
	
if(isset($sub)){
	if(!empty($select_type) && $select_type == 'cash_sum'){
		//echo "begin date:  ".date('ymd',strtotime($datebegin))." date end : ".date('ymd',strtotime($dateend))."----</br>";
		$head_msg="<caption>每天充值总金额：</caption>";
		//echo "stb: ".$stb." datebegin :".$datebegin." dateend :".$dateend."  ";
		//$sql="select * from gp_recharge_his where vc_stb_id='".$stb."' and l_date between '".$datebegin."' and '".$dateend."'  order by l_date desc,l_time desc {$page->limit};";
        $sql="select l_date,sum(cash_sum) as total_cash,sum(total_num) as total_num,sum(cash_sum)/sum(total_num) as avg from dailyreport_boss_cash
              group by l_date order by l_date desc";
        show_select_data($head_msg,$sql,"cash_sum");
    
   }elseif(!empty($select_type) && $select_type == 'subpoint' ){
		//echo "begin date:  ".date('ymd',strtotime($datebegin))." date end : ".date('ymd',strtotime($dateend))."----</br>";
		$datebegin=date('Y/m/d',strtotime($datebegin));
		$dateend=date('Y/m/d',strtotime($dateend));
		//echo "stb: ".$stb." datebegin :".$datebegin." dateend :".$dateend."  ";
        $sql="select * from 
             (SELECT  t2.vc_stb_id,t1.member_id,t1.before_points_busi,t1.chg_game_points,t1.game_points,t1.done_date,t3.l_game_name  
             FROM `point_history` t1,`gp_user_info` t2, `gp_game_info` t3 
             WHERE t1.member_id=t2.member_id  
             and substr(t1.notes,8,3)=t3.l_game_id 
             and t1.done_date between date_format('".$datebegin."','%Y/%m/%d 00:00:00') and date_format('".$dateend."','%Y/%m/%d 00:00:00') 
             and t2.vc_stb_id='".$stb."' 
             UNION 
             SELECT  t2.vc_stb_id,t1.member_id,t1.before_points_busi,t1.chg_game_points,t1.game_points,t1.done_date,t3.l_game_name  
             FROM `point` t1,`gp_user_info` t2 , `gp_game_info` t3 
             WHERE t1.member_id=t2.member_id 
             and substr(t1.notes,8,3)=t3.l_game_id 
             and t1.done_date between date_format('".$datebegin."','%Y/%m/%d 00:00:00') and date_format('".$dateend."','%Y/%m/%d 00:00:00') 
             and t2.vc_stb_id='".$stb."')as g 
             order by g.done_date desc ";
        $head_msg="<caption>机顶盒 ".$stb." 于 ".$datebegin."--".$dateend." 期间游戏点变化记录：</caption>";
        show_select_data($head_msg,$stb,$sql,"point");   	
   }elseif(!empty($select_type) && $select_type == 'login' ){
   		$sql="select v_stbid,v_source,v_time,v_code,v_city from z_visit_log where v_stbid='".$stb."' and v_time between '".$datebegin."' and '".$dateend."' order by v_time desc ";
   		$head_msg="<caption></caption>";
   		show_select_data($head_msg,$sql, "login");  	   	
   }
}

//print_r($_SESSION);
?>	
<script type="text/javascript">
 function excel()
   {
       window.location.href="download_excel.php";
   }
</script>

