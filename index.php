<?php
require_once('auth.php');
require_login();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>首页</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1em;
        }

        nav {
            display: flex;
            justify-content: space-around;
            background-color: #f2f2f2;
            padding: 10px;
        }

        nav a {
            text-decoration: none;
            padding: 10px;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #ddd;
        }

        .logout-link {
            display: inline-block;
            margin-top: 200px;
            background-color: #f44336;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-left: 820px;
        }

        .logout-link:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
<header>
    <h2>首页</h2>
</header>

<!-- 导航栏链接到其他功能页面 -->
<nav>
    <a href="category_management.php">物资分类</a>
    <a href="inventory_management.php">物资管理</a>
    <a href="user_management.php">用户管理</a>
</nav>

<!-- 首页内容 -->
<a class="logout-link" href="logout.php">退出登录</a>
</body>
</html>
