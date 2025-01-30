<?php

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../style.css">
    <title>Admin page</title>
</head>
<body>
    <h1>Welcome Admin! choose where you'd like to go to</h1>

    <a href="editpage.php"><input type=button value="go to admin page"> </a>
    <a href="../index.php"><input type=button value="go to user home page"></a>
</body>
</html>
