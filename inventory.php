<?php
require_once('db.php');

function get_inventory() {
    global $conn;
    $sql = "SELECT inventory.id, inventory.name, inventory.quantity, categories.name AS category_name
            FROM inventory
            LEFT JOIN categories ON inventory.category_id = categories.id";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addOrUpdateInventory($name, $quantity, $categoryId, $inventoryId = null) {
    global $conn;

    // 检查物资是否已存在
    $existingInventory = get_inventory_by_name($name);

    if ($existingInventory && $existingInventory['id'] != $inventoryId) {
        // 物资已存在，进行编辑操作
        $sql = "UPDATE inventory SET quantity = :quantity, category_id = :category_id WHERE name = :name";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
    } else {
        // 物资不存在，进行添加操作
        $sql = "INSERT INTO inventory (name, quantity, category_id) VALUES (:name, :quantity, :category_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
    }
}

function deleteInventory($id) {
    global $conn;
    $sql = "DELETE FROM inventory WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function get_inventory_by_name($name) {
    global $conn;
    $sql = "SELECT * FROM inventory WHERE name = :name";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_categories_for_dropdown() {
    global $conn;
    $sql = "SELECT id, name FROM categories";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_inventory_by_category($categoryId) {
    global $conn;
    $sql = "SELECT * FROM inventory WHERE category_id = :category_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':category_id', $categoryId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
