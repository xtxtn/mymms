<?php
session_start();

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit;
    }
}

function is_root_user() {
    require_once('db.php');

    if (!is_logged_in()) {
        return false;
    }
    global $conn;
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT is_admin FROM users WHERE id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return ($user && $user['is_admin'] == 1);
}

?>




