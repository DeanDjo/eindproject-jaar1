<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

include('../connect.php');

$user_id = $_SESSION['user_id'];



try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM persona");
    $stmt->execute();

    ?>

<!DOCTYPE html>
<html>

<head>
    <title>Persona Shop</title>

<link rel="stylesheet" href="../style.css">
</head>

<body>

<h1>Admin page</h1>

<a href="../view_cart.php"><input type=button value="cart!"></a>
<a href="../index.php"><input type=button value="back to login" ></a>
<a href="edititems.php"><input type=button value="manage items" ></a>

    <table >
        <tr>
            <th>number</th>
            <th>Name</th>
            <th>Arcana</th>
            <th>Inherits</th>
            <th></th>
            <th>Price</th>
            <th>Level</th>
        </tr>
    <?php
        


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>

                <td><?php echo $row["id"]; ?>
                <td><?= $row["name"]; ?></td>
                 <td> <?=  $row["arcana"] ?> </td>
                 <td class="inherits">
                     <?=  $row["inherits"] ?>
                      <td class="inherimg"><?php 
                        if ($row['inherits'] == 'Strike') {
                            echo "<img src='../images/strike.png'>";
                        } elseif ($row['inherits'] == 'Pierce') {
                            echo "<img src='../images/pierce.png'>";
                        } elseif ($row['inherits'] == 'Electric') {
                            echo "<img src='../images/elec.png'>";
                        } elseif ($row['inherits'] == 'Almighty') {
                            echo "<img src='../images/almighty.png'>";
                        } elseif ($row['inherits'] == 'Slash') {
                            echo "<img src='../images/slash.png'>";
                        } elseif ($row['inherits'] == 'Fire') {
                            echo "<img src='../images/fire.png'>";
                        } elseif ($row['inherits'] == 'Healing') {
                            echo "<img src='../images/healing.png'>";
                        } elseif ($row['inherits'] == 'Dark') {
                            echo "<img src='../images/curse.png'>";
                        } elseif ($row['inherits'] == 'Ice') {
                            echo "<img src='../images/ice.png'>";
                        }   
                        ?></td>  </td>
                 <td> <?=  $row["price"] ?> </td>
                <td> <?=  $row["level"] ?> </td>
                </tr>
    <?php }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

            $conn = null;
?>

    </table>

</body>

</html>
