<?php

$servername= "localhost";
$database = "registro";
$username= "root";
$password = "";

$con = mysqli_connect($servername, $username, 
$password, $database );

if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

$Nombre = $_POST['NombreT'];
$Tallas =$_POST['Tallas'];
$Marca = $_POST['Modelo'];
$Precio = $_POST['Precio'];
$Color = $_POST['Colores'];
$Imagen= $_POST['imagen'];
$Detalles = $_POST['detalles'];


$query = "INSERT INTO 
producto (nombre,tallas,
Marca,precio,color,URLImagen,detalles) VALUES 
('$Nombre','$Tallas','$Marca','$Precio','$Color','$Imagen',
'$Detalles')";

$sql = mysqli_query($con,$query);

if($sql){
    echo"Usuario Agregado";
    header("location: Productos.php");
}else{
    echo "Error".$sql ."<br>" . mysqli_error($con);
}
mysqli_close($con);

?>