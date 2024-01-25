<?php
require_once('db.php');
require_once('auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
        exit;
    } else {
        echo "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<html>
<head>
    <title>User Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h2>用户登录</h2>
<form method="post" action="">
    <label>用户名: <input type="text" name="username"></label><br>
    <label>密码: <input type="password" name="password"></label><br>
    <input type="submit" value="Login">
</form>
<p>没有账户? <a href="register.php">在此注册</a></p>
</body>
</html>
