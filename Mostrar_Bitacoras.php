<?php

$servername = "localhost";
$database = "registro";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sqlProductos = "SELECT * FROM bitacora_productos";
$resultProductos = $conn->query($sqlProductos);

$sqlUsuarios = "SELECT * FROM bitacora_usuarios";
$resultUsuarios = $conn->query($sqlUsuarios);

$sqlAdmins = "SELECT * FROM bitacora_administrador";
$resultAdmins = $conn->query($sqlAdmins);


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Bitácora</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>Bitácora de Productos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Sentencia</th>
                <th>Contrasentencia</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $resultProductos->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['fecha'] . "</td>";
                echo "<td>" . $row['sentencia'] . "</td>";
                echo "<td>" . $row['contrasentencia'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Bitácora de Usuarios</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Sentencia</th>
                <th>Contrasentencia</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $resultUsuarios->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['fecha'] . "</td>";
                echo "<td>" . $row['sentencia'] . "</td>";
                echo "<td>" . $row['contrasentencia'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Bitácora de administrador</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Sentencia</th>
                <th>Contrasentencia</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $resultAdmins->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['fecha'] . "</td>";
                echo "<td>" . $row['sentencia'] . "</td>";
                echo "<td>" . $row['contrasentencia'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    $conn->close();
    ?>

</body>
</html>
