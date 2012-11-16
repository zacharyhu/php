<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">

<title>Multi Area Select</title>
    
<script type="text/javascript" charset="utf-8" src="js/jquery-1.7.min.js"></script>

</head>
<body>

<?php

/**
 * database connect 
 */
include "database_connect.php";

/**
 * 查找顶级地址分类（parent_id = 0） 
 */
$sql = "SELECT `cate_id`, `parent_id`, `name` FROM category WHERE `parent_id` = 0;";
$result = mysql_query($sql, $dbconnect);
while($row = mysql_fetch_array($result))
{
    $categories[] = $row;
}

?>

<select onchange="ajaxGetArea(this)" name="cate_id" id="area">

    <?php foreach ($categories as $cate): ?>
    <option value="<?php echo $cate['cate_id']?>"><?php echo $cate['name'];?></option>
    <?php endforeach;?>

</select>

<script type="text/javascript">

jQuery(function($) {
    ajaxGetArea($("#area"));
});

function ajaxGetArea(obj)
{
    /**
     * 请求地址 
     */
    var link = "getArea.php";
    /**
     * 请求数据 
     */
    $.post(
        link,
        { 
            /**
             * 参数 
             */
            cate_id : $(obj).val() 
        },
        function(data) 
        {
            /**
             * 清除子类的select
             */
            $(obj).nextAll("select").each(function() {
                $(this).remove();
            });

            if (data) {

                /**
                 * 构造子类select的html 
                 */
                var select = null;
                select = "<select name=\"cate_id\" onchange=\"ajaxGetArea(this)\">"; // 此处注意添加onchange事件
                $.each(data, function(key, item) {
                    select += "<option value="+item.cate_id+">"+item.name+"</option>";
                });
                select += "</select>";

                /**
                 * 插入到右侧 
                 */
                $(obj).after(select);

                /**
                 * 触发下一个子类select的动态加载
                 */
                $(obj).next('select').trigger('change', function() {
                    ajaxGetArea($(this));
                });

                /**
                 * 更新name的位置 
                 */
                $(obj).removeAttr('name');
                $(obj).next('select').attr('name', 'cate_id');
            }
        },
        'json'
    );
}

</script>
    
</body>
</html>
