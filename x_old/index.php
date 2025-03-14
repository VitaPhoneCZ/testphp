<?php
$name = "Petr"; // Definice proměnné pro jméno
$text = "Uživatel"; // Definice proměnné pro text
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP projekt</title>
</head>
<body>
    <?php include "components/header.php"?>

    <h1>Náš první projekt v PHP</h1>

    <p>Zde je jméno účastníka zájezdu: <?php echo "$name Breit" ?></p>

    <?php echo "<h3>Proměnná: $name</h3>"; ?>

    <?php
    $i = 1;

    while ($i <= 6) {
        echo "<h3>$text $i</h3>";
        $i++;
    }
    ?>

    <?php
    for ($j = 0; $j <= 10; $j++) {
        if ($j % 2 == 0){
        echo "The number is: $j <br>";}
    }
    ?>

</body>
</html>
