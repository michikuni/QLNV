<?php
require_once '../db_connect.php';
require_once '../session.php';

checkAdminOrManager();

if (isset($_POST['submit'])) {
    $sql = "INSERT INTO employees (name, email, phone, hire_date, department_id, position) 
            VALUES (:name, :email, :phone, :hire_date, :department_id, :position)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $_POST['name'],
        ':email' => $_POST['email'],
        ':phone' => $_POST['phone'],
        ':hire_date' => $_POST['hire_date'],
        ':department_id' => $_POST['department_id'],
        ':position' => $_POST['position']
    ]);
    
    header("Location: ./dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm nhân viên</title>
    <meta charset="UTF-8">
</head>
<body>
    <h2>Thêm nhân viên mới</h2>
    <form method="POST">
        <label>Tên:</label><br>
        <input type="text" name="name" placeholder="Tên" required><br>
        <label>Email:</label><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <label>Số điện thoại:</label><br>
        <input type="text" name="phone" placeholder="Số điện thoại" required><br>
        <label>Ngày tuyển dụng:</label><br>
        <input type="date" name="hire_date" required><br>
        <label>Phòng ban:</label><br>
        <select name="department_id">
            <?php
            $depts = $conn->query("SELECT * FROM departments");
            while ($dept = $depts->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$dept['id']}'>{$dept['name']}</option>";
            }
            ?>
        </select><br>
        <label>Chức vụ:</label><br>
        <input type="text" name="position" placeholder="Chức vụ" required><br>
        <button type="submit" name="submit">Lưu</button>
    </form>
    <a href="./dashboard.php">Quay lại</a>
</body>
</html>