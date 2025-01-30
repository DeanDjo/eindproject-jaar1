<?php
        include('connect.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>tanakas amazing commodities</title>

<link rel="stylesheet" href="style.css">
</head>

<body>

<script>  
document.addEventListener('DOMContentLoaded', function () {
    function playSound(soundId) {
        var sound = document.getElementById(soundId)
        sound.play()
    }

    document.getElementById('button1').addEventListener('click', function () {
        playSound('sound1')
    })
})
</script>

<audio id="sound1" src="tanaka.mp3"></audio>

    <div class="soundbutton">
        <div class="buttons1">
            <button id="button1">
                <h1>tanakas amazing commodities</h1>
            </button>
        </div>
    </div>

    <a href="view_cart.php"><input type=button value="cart!"> </a>
    <a href="index.php"><input type=button value="back to login"></a>

    <table >
        <tr>
           
            <th>Name</th>
            <th>Arcana</th>
            <th>Inherits</th>
            <th></th>
            <th>Price</th>
            <th>Level</th>
        </tr>
        <?php

        try {
            $stmt = $conn->prepare("SELECT * FROM persona");
            $stmt->execute();


            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>

                <td><a href='persona_details.php?id=<?php echo $row["id"]; ?>'>
                <?php echo $row["name"]; ?></a></td>
                 <td> <?=  $row["arcana"] ?> </td>
                 <td class="inherits">
                     <?=  $row["inherits"] ?>
                      <td class="inherimg"><?php 

                        switch ($row['inherits']) {
                            case 'Strike':    
                                echo "<img src='images/strike.png'>";
                                break;
                            case 'Pierce':  
                                 echo "<img src='images/pierce.png'>";
                                 break;
                         };
                    

                        if ($row['inherits'] == 'Strike') {
                            echo "<img src='images/strike.png'>";
                        } elseif ($row['inherits'] == 'Pierce') {
                            echo "<img src='images/pierce.png'>";
                        } elseif ($row['inherits'] == 'Electric') {
                            echo "<img src='images/elec.png'>";
                        } elseif ($row['inherits'] == 'Almighty') {
                            echo "<img src='images/almighty.png'>";
                        } elseif ($row['inherits'] == 'Slash') {
                            echo "<img src='images/slash.png'>";
                        } elseif ($row['inherits'] == 'Fire') {
                            echo "<img src='images/fire.png'>";
                        } elseif ($row['inherits'] == 'Healing') {
                            echo "<img src='images/healing.png'>";
                        } elseif ($row['inherits'] == 'Dark') {
                            echo "<img src='images/curse.png'>";
                        } elseif ($row['inherits'] == 'Ice') {
                            echo "<img src='images/ice.png'>";
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
