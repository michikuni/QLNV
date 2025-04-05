<?php
session_start();
define('BASE_URL', '/QLNV/');

function checkLogin() {
    if (!isset($_SESSION['username'])) {
        header("Location: " . BASE_URL . "index.php"); // Dùng BASE_URL để trỏ về trang đăng nhập
        exit();
    }
}

function checkAdminOrManager() {
    if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'manager')) {
        header("Location: " . BASE_URL . "Employee/dashboard.php"); // Chuyển hướng tới dashboard
        exit();
    }
}

function logout() {
    if (isset($_GET['logout']) && $_GET['logout'] == 1) {
        session_destroy(); // Chỉ cần hủy session là đủ
        header("Location: " . BASE_URL . "index.php"); // Dùng BASE_URL để trỏ về trang đăng nhập
        exit();
    }
}
?>