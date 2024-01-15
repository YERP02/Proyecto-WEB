<?php

include "conexion.php";

session_start();

$Correo = $_POST['Correo'];
$Contraseña = $_POST['Contrasena'];

$stmt = $con->prepare("SELECT Correo, Contrasena FROM usuarios WHERE Correo = ? AND Contrasena = ?");
$stmt->bind_param("ss", $Correo, $Contraseña);
$stmt->execute();
$stmt->store_result();
$Row = $stmt->num_rows;

$stmt2 = $con->prepare("SELECT Correo, Contrasena FROM administrador WHERE Correo = ? AND Contrasena = ?");
$stmt2->bind_param("ss", $Correo, $Contraseña);
$stmt2->execute();
$stmt2->store_result();
$Row2 = $stmt2->num_rows;

if ($Row == 1) {
    $stmt->bind_result($Correo, $Contraseña);
    $stmt->fetch();
    $_SESSION['Correo'] = $Correo;
    $_SESSION['Rol'] = 'user'; 
    header("location: Productos.php");
    //echo "User";
} else if ($Row2 == 1) {
    $_SESSION['Correo'] = $Correo;
    $_SESSION['Rol'] = 'admin';
    header("location: Productos.php");
    //echo "admin";
} else {
    echo "La contraseña o correo son incorrectos";
}
$stmt->close();
$stmt2->close();
mysqli_close($con);

?>