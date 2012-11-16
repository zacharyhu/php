<?php
      $link=@mysql_connect("10.48.179.112","dc","dc")or die("mysql connect error");
      $db_selected=@mysql_select_db("datacenter")or die("db conn error");
      mysql_set_charset("utf8",$link);
