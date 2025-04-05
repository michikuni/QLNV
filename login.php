<?php
require_once 'db_connect.php';
require_once 'session.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT u.*, e.name as employee_name 
            FROM users u 
            JOIN employees e ON u.employee_id = e.id 
            WHERE username = :username AND password = :password AND status = 'active'";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':password' => $password
    ]);
    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: ./Employee/dashboard.php");
        exit();
    } else {
        $error = "Tên đăng nhập hoặc mật khẩu không đúng";
    }
}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="./style.css">

</head>
<body>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <section class="container">
        <div class="login-container">
            <div class="circle circle-one"></div>
            <div class="form-container">
                <img src="https://raw.githubusercontent.com/hicodersofficial/glassmorphism-login-form/master/assets/illustration.png" alt="illustration" class="illustration" />
                <h1 class="opacity">LOGIN</h1>
                <form method="post">
                    <input type="text" name="username" placeholder="USERNAME" required/>
                    <input type="password" name="password" placeholder="PASSWORD" required/>
                    <button class="opacity" type="submit" name="login">SUBMIT</button>
                </form>
                <div class="register-forget opacity">
                    <a href="">REGISTER</a>
                    <a href="">FORGOT PASSWORD</a>
                </div>
            </div>
            <div class="circle circle-two"></div>
        </div>
        <div class="theme-btn-container"></div>
    </section>
</body>
<!-- partial -->
  <script  src="./script.js"></script>

</html>