<?php
require_once '../db_connect.php';
require_once '../session.php';

checkAdminOrManager();

$id = $_GET['id'];
$sql = "DELETE FROM employees WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id]);

header("Location: ./dashboard.php");
exit();
?>