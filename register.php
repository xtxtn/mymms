<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    //$is_admin = isset($_POST['is_admin']) ? 1 : 0;
    $is_admin = 0;

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password_hash, is_admin) VALUES (:username, :password, :is_admin)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':is_admin', $is_admin);

    if ($stmt->execute()) {
        echo "注册成功. <a href='login.php'>在此登录</a>";
        exit;
    } else {
        echo "Registration failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h2>用户注册</h2>
<form method="post" action="">
    <label>用户名: <input type="text" name="username"></label><br>
    <label>密码: <input type="password" name="password"></label><br>
<!--    <label>Register as admin? <input type="checkbox" name="is_admin"></label><br>-->
    <input type="submit" value="Register">
</form>
</body>
</html>
