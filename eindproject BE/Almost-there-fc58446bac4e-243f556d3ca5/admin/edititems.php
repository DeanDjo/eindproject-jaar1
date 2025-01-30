<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

include('../connect.php');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['add_item'])) {
            $name = $_POST['name'];
            $arcana = $_POST['arcana'];
            $inherits = $_POST['inherits'];
            $price = $_POST['price'];
            $level = $_POST['level'];

            $stmt = $conn->prepare("INSERT INTO persona (name, arcana, inherits, price, level) VALUES (:name, :arcana, :inherits, :price, :level)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':arcana', $arcana);
            $stmt->bindParam(':inherits', $inherits);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':level', $level);
            $stmt->execute();
        } elseif (isset($_POST['remove_item'])) {
            $id = $_POST['id'];
            $stmt = $conn->prepare("DELETE FROM persona WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } elseif (isset($_POST['edit_item'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $arcana = $_POST['arcana'];
            $inherits = $_POST['inherits'];
            $price = $_POST['price'];
            $level = $_POST['level'];

            $stmt = $conn->prepare("UPDATE persona SET name = :name, arcana = :arcana, inherits = :inherits, price = :price, level = :level WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':arcana', $arcana);
            $stmt->bindParam(':inherits', $inherits);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':level', $level);
            $stmt->execute();
        }
    }

    $stmt = $conn->prepare("SELECT * FROM persona");
    $stmt->execute();
    $personas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../style.css">
    <title>admin page</title>
</head>
<body>
    <h1>Manage Items</h1>

<a href="editpage.php"><input type=button value="back to admin page"></a>
<a href="../index.php"><input type=button value="back to login"></a>
    

    <h1>Add Item</h1>
    <form method="POST">
        <label class="login" for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        <label class="login" for="arcana">Arcana:</label>
        <input type="text" id="arcana" name="arcana" required><br>
        <label class="login" for="inherits">Inherits:</label>
        <input type="text" id="inherits" name="inherits" required><br>
        <label class="login"  for="price">Price:</label>
        <input type="number" id="price" name="price" required><br>
        <label class="login" for="level">Level:</label>
        <input type="number" id="level" name="level" required><br>
        <input type="submit" value="Add Item" name="add_item">
    </form>

    <h1>Existing Items</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Arcana</th>
            <th>Inherits</th>
            <th>Price</th>
            <th>Level</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($personas as $persona) : ?>
            <tr>
                <td><?= $persona['id']; ?></td>
                <td><?= $persona['name']; ?></td>
                <td><?= $persona['arcana']; ?></td>
                <td><?= $persona['inherits']; ?></td>
                <td><?= $persona['price']; ?></td>
                <td><?= $persona['level']; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $persona['id']; ?>">
                        <input type="submit" value="Remove" name="remove_item">
                    </form>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $persona['id']; ?>">
                        <input type="text" name="name" value="<?= $persona['name']; ?>" required>
                        <input type="text" name="arcana" value="<?= $persona['arcana']; ?>" required>
                        <input type="text" name="inherits" value="<?= $persona['inherits']; ?>" required>
                        <input type="number" name="price" value="<?= $persona['price']; ?>" required>
                        <input type="number" name="level" value="<?= $persona['level']; ?>" required>
                        <input type="submit" value="Edit" name="edit_item">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
