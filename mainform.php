<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>后台管理系统</title>
	                 <!--
--> <!--
-->
	<link rel="stylesheet" href="css/style.css" type="text/css">
  </head>

  <body class="menu3_bg" leftmargin="0" topmargin="0">
    
      
	    
    	  <script>
    function changeImage(id){
	    for (var i=1; i<=5; i++) {
             aMenu= document.getElementById("menu_"+i);
	         if(i==id)aMenu.className="menu3_downm";
	         else aMenu.className="menu3_td";
        }
    }
    function openMenu4(menuName){
        var menu4 = parent.document.getElementById('menu4');
		menu4.rows="40,*"; 
        var menu4_top = parent.document.getElementById('menu4_top');
	    menu4_top.src="menu4.jsp?menuname="+menuName;
  
    }
    function closeMenu4(){
        var menu4 = parent.document.getElementById('menu4');
		menu4.rows="0,*";
    }
    function refreshBottom(id){
      var bottom = parent.document.getElementById('bottom');
	  bottom.src = "bottom.jsp?menuName=" + id;
   }
</script>
<table width="149" border="0" align="center" cellpadding="0" cellspacing="0">
  
    <tr>
    <td id="menu_1"  class="menu3_downm" >
		<a href="/managex/jsp/base/baseList.jsp" onclick="changeImage(1);closeMenu4();refreshBottom('6');" target="mainFrame" class="menu3"><img src="images/webui/menu_1.gif" align="absmiddle" border="0">
		系统公告管理</a>
    </td>
  </tr>  <script> refreshBottom('6')</script>   
  
    <tr>
    <td id="menu_2"  class="menu3_td" >
		<a href="/managex/jsp/business/businessList.jsp" onclick="changeImage(2);closeMenu4();refreshBottom('7');" target="mainFrame" class="menu3"><img src="images/webui/menu_1.gif" align="absmiddle" border="0">
		业务数据管理</a>
    </td>
  </tr>   
  
    <tr>
    <td id="menu_3"  class="menu3_td" >
		<a href="/managex/jsp/area/areaList.jsp" onclick="changeImage(3);closeMenu4();refreshBottom('8');" target="mainFrame" class="menu3"><img src="images/webui/menu_1.gif" align="absmiddle" border="0">
		区域信息管理</a>
    </td>
  </tr>   
  
    <tr>
    <td id="menu_4"  class="menu3_td" >
		<a href="/managex/jsp/menu/menuinfo.jsp" onclick="changeImage(4);closeMenu4();refreshBottom('9');" target="mainFrame" class="menu3"><img src="images/webui/menu_1.gif" align="absmiddle" border="0">
		系统菜单管理</a>
    </td>
  </tr>   
  
    <tr>
    <td id="menu_5"  class="menu3_td" >
		<a href="/managex/jsp/tool/doubleSign.jsp" onclick="changeImage(5);closeMenu4();refreshBottom('38');" target="mainFrame" class="menu3"><img src="images/webui/menu_1.gif" align="absmiddle" border="0">
		重号检测管理</a>
    </td>
  </tr>   
</table>
<script>
          mainForm = parent.document.getElementById('mainFrame');
	  mainForm.src="/managex/jsp/base/baseList.jsp";
       
</script>

        
      
  </body>
</html>