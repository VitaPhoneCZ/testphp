<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_databaze";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}

$sql = "SELECT id, jmeno, email FROM uzivatele";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seznam uživatelů</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>Seznam uživatelů</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Jméno</th>
            <th>Email</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["jmeno"] . "</td>
                        <td>" . $row["email"] . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Žádní uživatelé nebyli nalezeni</td></tr>";
        }
        $conn->close();
        ?>
    </table>

</body>
</html>
