<?php

$host = 'localhost';
$database = 'area';
$login = 'root';
$pass = 'abcd1234';

$dbconnect = mysql_connect($host, $login, $pass);
if (!$dbconnect) { die("数据库链接出错！"); } 
mysql_query("set names utf8", $dbconnect);
mysql_select_db($database, $dbconnect);


?>
