<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "prvni_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } 

$sql = "SELECT * FROM `zboží`";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include "components/header.php"?>
    <h1>funguje</h1>
    <h2>Tabulka Zboží</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Název produktu</th>
            <th>Cena za kus</th>
            <th>Počet kusů</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["ID"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Název_produktu"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Cena_za_kus"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Počet_kusů"]) . "</td>";
                echo "</tr>";
            }
            
        }
        else {
            echo "0 results";
        }
        ?>
    </table>
</body>
</html>