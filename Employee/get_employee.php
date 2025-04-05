<?php
require_once '../db_connect.php';
require_once '../session.php';

checkAdminOrManager();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM employees WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($employee);
}
?>