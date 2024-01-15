<?php

include "Conexion.php";

$Nombre = $_POST['nombre'];
$Apellido =$_POST['Apellido'];
$Celular = $_POST['Celular'];
$Date = $_POST['Nacimiento'];
$Direccion = $_POST['Direccion'];
$Usernombre = $_POST['UsuarioR'];
$Correo = $_POST['Correo'];
$Contraseña = $_POST['contraseña'];

$query = "INSERT INTO 
usuarios (Nombre,Apellidos,
Celular,FechaNacimiento,Username,
Direccion,Correo,Contrasena) VALUES 
('$Nombre','$Apellido','$Celular','$Date',
'$Usernombre','$Direccion','$Correo',
'$Contraseña')";

$sql = mysqli_query($con,$query);

if($sql){
    echo"Usuario Agregado";
    header("location: Login.php");
}else{
    echo "Error".$sql ."<br>" . mysqli_error($con);
}
mysqli_close($con);

?>