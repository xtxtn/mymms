<?php
require_once('auth.php');
require_once('category.php');
require_once('inventory.php');

require_login();

if (isset($_POST['add_category'])) {
    addCategory();
}

if (isset($_POST['delete_category'])) {
    deleteCategory();
}

// 获取分类列表
$categories = get_categories();

// 获取同一分类下的物资信息
$inventoryData = array(); // 初始化为空数组
if (isset($_GET['category_id'])) {
    $categoryId = $_GET['category_id'];
    $inventoryData = get_inventory_by_category($categoryId);
    $jsonInventoryData = json_encode($inventoryData);
    echo $jsonInventoryData;
    exit();
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="manage.css">
    <title>物资分类管理</title>

    <script>
        function fetchInventoryByCategory(categoryId) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    window.alert("完成");
                    var inventoryData = JSON.parse(xhr.responseText);
                    showInventory(inventoryData);
                }
            }
            xhr.open('GET', 'category_management.php?category_id=' + categoryId, true);
            xhr.send();
        }

        function showInventory(inventoryData) {
            var inventoryList = document.getElementById('inventoryList');
            inventoryList.innerHTML = '<tr><th>物资名称</th><th>数量</th></tr>';
            inventoryData.forEach(function(item) {
                var row = document.createElement('tr');
                row.innerHTML = '<td>' + item.name + '</td><td>' + item.quantity + '</td>';
                inventoryList.appendChild(row);
            });
        }
    </script>
</head>
<body>
<header>
    <h2>物资分类管理</h2>
</header>

<!-- 添加分类表单，只有root用户可以使用 -->
<?php if (is_root_user()): ?>
    <h3>添加新分类</h3>
    <form class="add-user-form" method="post" action="">
        <label>分类名称: <input type="text" name="new_category"></label>
        <button type="submit" name="add_category">添加分类</button>
    </form>
<?php endif; ?>

<!-- 显示分类列表及相关内容 -->
<h3>分类列表</h3>
<table border="1">
    <tr>
        <th>分类名称</th>
        <th>操作</th>
    </tr>
    <?php foreach ($categories as $category): ?>
        <tr>
            <td>
                <a href="#" onclick="fetchInventoryByCategory(<?= $category['id'] ?>)">
                    <?= $category['name'] ?>
                </a>
            </td>
            <td>
                <?php if (is_root_user()): ?>
                    <form method="post" action="">
                        <input type="hidden" name="category_id" value="<?= $category['id'] ?>">
                        <button type="submit" name="delete_category">删除分类</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- 显示同一分类下的物资 -->
<h3>同一分类下的物资</h3>
<table border="1" id="inventoryList">
    <tr>
        <th>物资名称</th>
        <th>数量</th>
    </tr>

</table>

<p><a href="index.php">返回首页</a></p>
</body>
</html>
