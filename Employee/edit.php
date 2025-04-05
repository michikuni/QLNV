<?php
require_once '../db_connect.php';
require_once '../session.php';

checkAdminOrManager();

if (isset($_POST['edit_employee'])) {
    $sql = "UPDATE employees SET 
            name = :name,
            email = :email,
            phone = :phone,
            hire_date = :hire_date,
            department_id = :department_id,
            position = :position
            WHERE id = :id";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $_POST['name'],
        ':email' => $_POST['email'],
        ':phone' => $_POST['phone'],
        ':hire_date' => $_POST['hire_date'],
        ':department_id' => $_POST['department_id'],
        ':position' => $_POST['position'],
        ':id' => $_POST['id']
    ]);
    
    header("Location: ./dashboard.php");
    exit();
}
?>