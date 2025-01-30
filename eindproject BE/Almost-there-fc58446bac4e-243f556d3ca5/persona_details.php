<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
    <title>tanakas amazing commodities</title>
</head>

<a href="view_cart.php"><input type=button value="cart!"> </a>
    <a href="homepage.php"><input type=button value="back to homepage"> </a>
    



<?php
session_start();

include("connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $amount = $_POST['amount'];
        $persona_id = $_POST['persona_id'];
        $user_id = $_SESSION['user_id'];

        // checkt of er al een prodcut in de cart is!!
        $stmt = $conn->prepare("SELECT amount FROM cart WHERE user_id = :user_id AND persona_id = :persona_id");
        $stmt->execute(['user_id' => $user_id, 'persona_id' => $persona_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // als t er al in zit moet het aantal er van omhoog
            $stmt = $conn->prepare("UPDATE cart SET amount = amount + :amount WHERE user_id = :user_id AND persona_id = :persona_id");
            $stmt->execute(['amount' => $amount, 'user_id' => $user_id, 'persona_id' => $persona_id]);
        } else {
            //gwn toevoegen als t er nog niet in zit:)
            $stmt = $conn->prepare("INSERT INTO cart (user_id, persona_id, amount) VALUES (:user_id, :persona_id, :amount)");
            $stmt->execute(['user_id' => $user_id, 'persona_id' => $persona_id, 'amount' => $amount]);
        }
        
        header('Location: homepage.php');
        exit();
    }
}
?>
<body>
<table>
    <tr>
    <?php
    $stmt = $conn->prepare("SELECT * FROM persona WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
     
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
        <td>number: <?= $row["id"]; ?></td>
        <td>Name: <?= $row["name"]; ?></td> 
        <td>Arcana: <?= $row["arcana"]; ?></td> 
        <td>Inherits: <?= $row["inherits"]; ?></td> 
        <td>Price: <?= $row["price"]; ?></td> 
        <td>Level: <?= $row["level"]; ?></td>
        <td>
            <form method="POST">
                <input type="hidden" name="persona_id" value="<?= $row["id"]; ?>">
                <input type="number" name="amount" value="1" min="1" required>
                <input type="submit" name="add_to_cart" value="Add to Cart">
            </form>
        </td>
        <?php
    } else {
        echo "<p>Persona not found.</p>";
    }
    ?>
    </tr>
</table>
</body>
</html>
