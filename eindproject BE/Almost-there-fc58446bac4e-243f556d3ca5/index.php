<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
    <title>Login/Register</title>
</head>
<body>

<?php
session_start();
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_POST['register'])) {
            $user = $_POST['username'];
            $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // zet default rol als user
            $role = 'user';

            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
            $stmt->bindParam(':username', $user);
            $stmt->bindParam(':password', $pass);
            $stmt->bindParam(':role', $role);
            $stmt->execute();

            $_SESSION['user_id'] = $conn->lastInsertId();
            $_SESSION['role'] = $role;
            header('Location: homepage.php');
            exit();
        } else {
            $user = $_POST['username'];
            $pass = $_POST['password'];

            $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = :username");
            $stmt->bindParam(':username', $user);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row && password_verify($pass, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                
        // gooit je de admin page kiezer in als je admin bent in de db

                if ($row['role'] == 'admin') {
                    header('Location: admin/admin_choice.php');
                } else {
                    header('Location: homepage.php');
                }
                exit();
            } else {
                echo "Invalid username or password";
            }
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>

<h1>Login</h1>
<form method="POST">
    <label class="login" for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>
    <label class="login" for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>
    <input type="submit" value="Login" name="login">
</form>

<h1>Register</h1>
<form method="POST">
    <label class="login" for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>
    <label class="login" for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>
    <input type="submit" value="Register" name="register">
</form>
</body>
</html>
