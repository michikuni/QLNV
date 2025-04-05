<?php
require_once '../db_connect.php';
require_once '../session.php';

checkAdminOrManager();

if (isset($_POST['edit_user']) && $_SESSION['role'] == 'admin') {
    $sql = "UPDATE users SET 
            username = :username,
            role = :role,
            employee_id = :employee_id,
            status = :status";
    if (!empty($_POST['password'])) {
        $sql .= ", password = :password";
    }
    $sql .= " WHERE id = :id";
    
    $stmt = $conn->prepare($sql);
    $params = [
        ':username' => $_POST['username'],
        ':role' => $_POST['role'],
        ':employee_id' => $_POST['employee_id'],
        ':status' => $_POST['status'],
        ':id' => $_POST['id']
    ];
    if (!empty($_POST['password'])) {
        $params[':password'] = $_POST['password'];
    }
    $stmt->execute($params);
    header("Location: ./users.php");
    exit();
}
?>