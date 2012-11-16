<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8">

</head>

<body>

<?php

include 'database_connect.php';

if (!empty($_POST)) {

    $sql = "INSERT INTO category (`parent_id`, `name`) VALUES ('{$_POST['parent_id']}', '{$_POST['name']}');";

    if(mysql_query($sql, $dbconnect)) {
        echo "插入成功！";
    } else {

        die("error: ".mysql_error());
    };
}


$sql = "SELECT `cate_id`, `parent_id`, `name` FROM category";

$result = mysql_query($sql, $dbconnect);

while($row = mysql_fetch_array($result))
{
    $categories[] = $row;
}

?>

<form action='insertCategory.php' method="post">

    <select name="parent_id">
        <option value="0">作为父类</option>
        <?php foreach ($categories as $cate): ?>
        <?php if($cate['parent_id'] == 0):?>
        <option value="<?php echo $cate['cate_id']?>"><?php echo $cate['name'] ?></option>
        <?php else:?>
        <option value="<?php echo $cate['cate_id']?>">&nbsp;&nbsp;-- <?php echo $cate['name'] ?></option>
        <?php endif;?>
        <?php endforeach; ?>
    </select>

    <input type="text" name="name" />

    <input type="submit" value="插入" />

</form>

</body>
</html>
