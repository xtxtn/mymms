<?php
require_once('db.php');

function get_users() {
    global $conn;
    $sql = "SELECT * FROM users";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addUser() {
    global $conn;
    $newUsername = $_POST['new_username'];
    $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $is_admin = 0;
    if (!empty($newUsername) && !empty($newPassword)) {
        $sql = "INSERT INTO users (username, password_hash, is_admin) VALUES (:username, :password, :is_admin)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $newUsername);
        $stmt->bindParam(':password', $newPassword);
        $stmt->bindParam(':is_admin', $is_admin);
        $stmt->execute();
    }
}


function deleteUser() {
    global $conn;
    $userId = $_POST['user_id'];

    if (!empty($userId)) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
    }
}
?>
