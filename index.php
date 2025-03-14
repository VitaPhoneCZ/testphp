<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "prvni_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nazev"]) && isset($_POST["cena"]) && isset($_POST["pocet"])) {
        $nazev = $conn->real_escape_string($_POST["nazev"]);
        $cena = $conn->real_escape_string($_POST["cena"]);
        $pocet = $conn->real_escape_string($_POST["pocet"]);

        // Kontrola 100% duplicity
        $sql_check = "SELECT * FROM `zboží` WHERE Název_produktu = '$nazev' AND Cena_za_kus = '$cena' AND Počet_kusů = '$pocet'";
        $result_check = $conn->query($sql_check);
        if ($result_check->num_rows > 0) {
            echo "Tento záznam již v databázi existuje.";
        } else {
            $sql_insert = "INSERT INTO `zboží` (Název_produktu, Cena_za_kus, Počet_kusů) VALUES ('$nazev', '$cena', '$pocet')";
            if ($conn->query($sql_insert) === TRUE) {
                echo "Nový záznam byl úspěšně přidán.";
            } else {
                echo "Chyba: " . $conn->error;
            }
        }
    }
    if (isset($_POST["delete_id"])) {
        $delete_id = $conn->real_escape_string($_POST["delete_id"]);
        $sql_delete = "DELETE FROM `zboží` WHERE ID = '$delete_id'";
        if ($conn->query($sql_delete) === TRUE) {
            echo "Záznam byl úspěšně smazán.";
        } else {
            echo "Chyba při mazání: " . $conn->error;
        }
    }
}

$sql = "SELECT * FROM `zboží`";
$result = $conn->query($sql);

$duplicate_entries = [];
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $key = $row["Název_produktu"];
        if (!isset($products[$key])) {
            $products[$key] = [];
        }
        $products[$key][] = $row;
    }
}

foreach ($products as $key => $entries) {
    if (count($entries) > 1) {
        $unique_prices = array_unique(array_column($entries, "Cena_za_kus"));
        $unique_counts = array_unique(array_column($entries, "Počet_kusů"));
        if (count($unique_prices) > 1 || count($unique_counts) > 1) {
            foreach ($entries as $entry) {
                $duplicate_entries[$entry["ID"]] = true;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .duplicate {
            background-color: red;
        }
    </style>
</head>
<body>
    <?php include "components/header.php" ?>
    <h1>Funguje</h1>
    
    <h2>Přidat nové zboží</h2>
    <form method="POST">
        <label for="nazev">Název produktu:</label>
        <input type="text" id="nazev" name="nazev" required>
        <br>
        <label for="cena">Cena za kus:</label>
        <input type="number" id="cena" name="cena" required>
        <br>
        <label for="pocet">Počet kusů:</label>
        <input type="number" id="pocet" name="pocet" required>
        <br>
        <button type="submit">Přidat</button>
    </form>
    
    <h2>Tabulka Zboží</h2>
    <table border="1" style="text-align: center;">
        <tr>
            <th>ID</th>
            <th>Název produktu</th>
            <th>Cena za kus</th>
            <th>Počet kusů</th>
            <th>Akce</th>
        </tr>
        <?php
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $class = isset($duplicate_entries[$row["ID"]]) ? "duplicate" : "";
                echo "<tr class='$class'>" .
                    "<td>" . htmlspecialchars($row["ID"]) . "</td>" .
                    "<td>" . htmlspecialchars($row["Název_produktu"]) . "</td>" .
                    "<td>" . htmlspecialchars($row["Cena_za_kus"]) . "</td>" .
                    "<td>" . htmlspecialchars($row["Počet_kusů"]) . "</td>" .
                    "<td><form method='POST' style='display:inline;'><input type='hidden' name='delete_id' value='" . htmlspecialchars($row["ID"]) . "'><button type='submit'>X</button></form></td>" .
                    "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Žádné záznamy</td></tr>";
        }
        ?>
    </table>
</body>
</html>