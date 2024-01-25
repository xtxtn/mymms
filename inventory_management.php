<?php
require_once('auth.php');
require_once('inventory.php');

require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_inventory'])) {
        $name = $_POST['new_name'];
        $quantity = $_POST['new_quantity'];
        $category_id = $_POST['new_category_id'];
        addOrUpdateInventory($name, $quantity, $category_id);
    } elseif (isset($_POST['edit_inventory'])) {
        $id = $_POST['inventory_id'];
        $name = $_POST['edited_name'];
        $quantity = $_POST['edited_quantity'];
        $category_id = $_POST['edited_category_id'];
        addOrUpdateInventory($name, $quantity, $category_id, $id);
    } elseif (isset($_POST['delete_inventory'])) {
        $id = $_POST['inventory_id'];
        deleteInventory($id);
    }
}

$inventory = get_inventory();
$categoriesDropdown = get_categories_for_dropdown();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="manage.css">
    <title>物资管理</title>
</head>
<body>
<header>
    <h2>物资管理</h2>
</header>
<!-- 添加物资表单 -->
<h3>更新物资</h3>
<form class="add-user-form" method="post" action="">
    <label>物资名称: <input type="text" name="new_name"></label>
    <label>数量: <input type="number" name="new_quantity" min="0"></label>
    <label>分类:
        <select name="new_category_id">
            <?php foreach ($categoriesDropdown as $category): ?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <button type="submit" name="add_inventory">确认</button>
</form>

<!-- 显示物资列表及相关内容 -->
<h3>物资列表</h3>
<table border="1">
    <tr>
        <th>物资名称</th>
        <th>数量</th>
        <th>分类</th>
        <th>操作</th>
    </tr>
    <?php foreach ($inventory as $item): ?>
        <tr>
            <td><?= $item['name'] ?></td>
            <td><?= $item['quantity'] ?></td>
            <td><?= $item['category_name'] ?></td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="inventory_id" value="<?= $item['id'] ?>">
                    <button type="submit" name="delete_inventory">删除</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="index.php">返回首页</a></p>
</body>
</html>
