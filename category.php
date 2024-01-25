<?php
require_once('db.php');

function get_categories() {
    global $conn;
    $sql = "SELECT * FROM categories";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addCategory() {
    global $conn;
    $newCategory = $_POST['new_category'];

    if (!empty($newCategory)) {
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $newCategory);
        $stmt->execute();
    }
}

function deleteCategory() {
    global $conn;
    $categoryId = $_POST['category_id'];

    if (!empty($categoryId)) {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $categoryId);
        $stmt->execute();
    }
}
?>
