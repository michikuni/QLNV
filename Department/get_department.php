<?php
require_once '../db_connect.php';
require_once '../session.php';

checkAdminOrManager();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM departments WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    $department = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($department);
}
?>