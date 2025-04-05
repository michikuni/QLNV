<?php
require_once '../db_connect.php';
require_once '../session.php';

checkAdminOrManager();

if ($_SESSION['role'] == 'admin') {
    $id = $_GET['id'];
    $sql = "DELETE FROM departments WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    header("Location: ./departments.php");
    exit();
}
?>