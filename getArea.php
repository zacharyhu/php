<?php

include "database_connect.php";

$cate_id = isset($_POST['cate_id']) ? (int)$_POST['cate_id'] : -1;

$sql = "SELECT `cate_id`, `parent_id`, `name` FROM category WHERE `parent_id` = {$cate_id};";

$result = mysql_query($sql, $dbconnect);

while($row = mysql_fetch_array($result))
{
    $categories[] = $row;
}

if (!empty($categories)) {  
    echo json_encode($categories);
} else {
    return false; 
}

?>
