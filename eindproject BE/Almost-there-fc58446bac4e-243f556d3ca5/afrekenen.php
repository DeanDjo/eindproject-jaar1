<!DOCTYPE html>
<html>
<?php
include('connect.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // pak de items voordat ze deleted worden
    $stmt = $conn->prepare("SELECT persona_id, amount FROM cart WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $persona_details_stmt = $conn->prepare("SELECT id, name, arcana, inherits, price, level FROM persona WHERE id = :persona_id");

    // delete de items uit de cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>

<head>
    <title>afrekenen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Thank you for your purchase!</h1>

    
    <a href="homepage.php"><input type="button" value="Back to Homepage"></a>
    <a href="view_cart.php"><input type="button" value="Back to Cart"></a>

    <h1>Items Purchased:</h1>
    <table>
        <tr>
            <th>Number</th>
            <th>Name</th>
            <th>Arcana</th>
            <th>Inherits</th>
            <th>Price</th>
            <th>Level</th>
            <th>Amount</th>
        </tr>
        <?php if ($cart_items) : ?>
            <?php foreach ($cart_items as $item) : ?>
                <?php
                $persona_details_stmt->bindParam(':persona_id', $item['persona_id']);
                $persona_details_stmt->execute();
                $row = $persona_details_stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['arcana']; ?></td>
                    <td><?= $row['inherits']; ?></td>
                    <td><?= $row['price']; ?></td>
                    <td><?= $row['level']; ?></td>
                    <td><?= $item['amount']; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr><td colspan="7">No items were in the cart</td></tr>
        <?php endif; ?>
    </table>

</body>
</html>
