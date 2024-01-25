<?php
require_once('auth.php');
require_once('user.php');

require_login();

// Ensure only root users can access this page
if (!is_root_user()) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['add_user'])) {
    addUser();
}

if (isset($_POST['delete_user'])) {
    deleteUser();
}

$users = get_users();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户管理</title>
    <link rel="stylesheet" type="text/css" href="manage.css">
</head>
<body>
<header>
    <h2>用户管理</h2>
</header>

<?php if (is_root_user()): ?>
    <form class="add-user-form"  method="post" action="">
        <h3>添加新用户</h3>
        <label>用户名: <input type="text" name="new_username"></label>
        <label>密码: <input type="password" name="new_password"></label>
        <button type="submit" name="add_user">添加用户</button>
    </form>
<?php endif; ?>

<h3>用户列表</h3>
<table>
    <tr>
        <th>用户名</th>
        <th>操作</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <?php if ($user['username'] == "root") continue;  ?>
            <td><?= $user['username'] ?></td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                    <button type="submit" name="delete_user">删除</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="index.php">返回首页</a></p>
</body>
</html>
