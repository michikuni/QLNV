<?php
require_once '../db_connect.php';
require_once '../session.php';

checkAdminOrManager();

if ($_SESSION['role'] == 'admin') {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    header("Location: ./users.php");
    exit();
}
?>