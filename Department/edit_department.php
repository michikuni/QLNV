<?php
require_once '../db_connect.php';
require_once '../session.php';

checkAdminOrManager();

if (isset($_POST['edit_department']) && $_SESSION['role'] == 'admin') {
    $sql = "UPDATE departments SET name = :name WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $_POST['name'],
        ':id' => $_POST['id']
    ]);
    header("Location: ./departments.php");
    exit();
}
?>