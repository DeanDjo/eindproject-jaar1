<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

include('connect.php');

$user_id = $_SESSION['user_id'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // verwijder volledig uit cart
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_from_cart'])) {
        $persona_id = $_POST['persona_id'];
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id AND persona_id = :persona_id");
        $stmt->execute(['user_id' => $user_id, 'persona_id' => $persona_id]);
    }

    // verander/update item amount in cart
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_amount'])) {
        $persona_id = $_POST['persona_id'];
        $new_amount = $_POST['amount'];
        $stmt = $conn->prepare("UPDATE cart SET amount = :amount WHERE user_id = :user_id AND persona_id = :persona_id");
        $stmt->execute(['amount' => $new_amount, 'user_id' => $user_id, 'persona_id' => $persona_id]);
    }

    $stmt = $conn->prepare("SELECT persona_id, amount FROM cart WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $persona_details_stmt = $conn->prepare("SELECT id, name, arcana, inherits, price, level FROM persona WHERE id = :persona_id");
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Shopping Cart</title>
</head>
<body>
    <h1>Shopping Cart</h1>
    <table>
        <a href="homepage.php"><input type="button" value="Back Home"></a>
        <a href="index.php"><input type="button" value="Back to Login"></a>
        <a href="afrekenen.php"><input type="button" value="Betalen!"></a>

        <tr>
            <th>Number</th>
            <th>Name</th>
            <th>Arcana</th>
            <th>Inherits</th>
            <th>Price</th>
            <th>Level</th>
            <th>Amount</th>
            <th></th>
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
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="persona_id" value="<?= $item['persona_id']; ?>">
                            <input type="number" name="amount" value="<?= $item['amount']; ?>" min="1">
                            <input type="submit" name="update_amount" value="Update">
                        </form>
                    </td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="persona_id" value="<?= $item['persona_id']; ?>">
                            <input type="submit" name="remove_from_cart" value="Remove">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr><td colspan="8">Your cart is empty.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
