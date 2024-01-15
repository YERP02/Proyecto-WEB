<?php

$servername= "localhost";
$database = "registro";
$username= "root";
$password = "";

$con = mysqli_connect($servername, $username, 
$password, $database );

if(!$con){
    die("Fallo la conexion " . mysqli_connect_error() );
}else{
    //echo "Conexion Exitosa";
}

$sql = 'SELECT id, nombre, tallas, Marca, precio, color, URLImagen,detalles FROM producto';
        $resultado = $con->query($sql);

?>