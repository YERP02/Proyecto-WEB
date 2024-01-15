<?php 
    session_start();
    require 'C:\xampp\htdocs\Calzature\Conexion.php';

    $admin = 0;  
    if (isset($_SESSION['Correo'])) {

        $Correo = $_SESSION['Correo'];
        $queryUsuario = "SELECT * FROM administrador WHERE Correo = '$Correo'";
        $queryUsuario2 = "SELECT * FROM usuarios WHERE Correo = '$Correo'";
        $resultUsuario = mysqli_query($con, $queryUsuario);
        $resultUsuario2 = mysqli_query($con, $queryUsuario2);

        if ($resultUsuario && mysqli_num_rows($resultUsuario) > 0) {
            $usuario = mysqli_fetch_assoc($resultUsuario);
            
            if ($usuario['Rol'] = 'admin') {
                $admin = 2;  
            }
            
        }elseif($resultUsuario2 && mysqli_num_rows($resultUsuario2) > 0){
            $usuario = mysqli_fetch_assoc($resultUsuario2);
            if ($usuario['Rol'] = 'user'){
                $admin = 1; 
                
            }
        }
        
    } else {
        
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Calzature</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ProyectoCSS.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
                           integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" 
                           crossorigin="anonymous" referrerpolicy="no-refferer">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Quattrocento:wght@700&display=swap" rel="stylesheet">
</head>
<body class="bodyReg">
    <div class="conte">
        <nav>
            <input type="checkbox" id="click">
            <label for="click" class="btn">
                <i class="fa-solid fa-bars"></i>
            </label>
            <ul>
            <li><a href="index.html">Inicio</a></li>
                <li><a href="Productos.php">Productos</a></li>
                
                <?php
                if ($admin === 2) {
                    echo '<li><a href="Adminproductos.php">Editar Productos</a></li>';
                    echo '<li><a href="RegistrarAdmin.php">RegistrarAdmin</a></li>';
                    echo '<li><a href="Mostrar_Bitacoras.php">Bitacora</a></li>';
                    echo '<li><a href="Salir.php">Salir</a></li>';
                }if($admin === 1){
                    echo '<li><a href="Salir.php">Salir</a></li>';
                }else if($admin === 0){
                    echo '<li><a href="Registrar.php">Registrarme</a></li>';
                    echo '<li><a href="Login.php">Login</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>
    <section id="RegistroSection">
        <h1 class="H1reg">Agregar Productos</h1>
        <form class="Form" action="RegProductos.php"method="post">
            <div class="Datos">

                <input type="text" name="NombreT" id="NombreT" placeholder="Nombre Del Tenis:"  >
                <input type="text" name="Tallas" id="Tallas" placeholder="Tallas:">
                <input type="text" name="Modelo" id="Modelo" placeholder="Modelo:">
                <input type="number" name="Precio" id="Precio" placeholder="Precio:">
                <input type="text" name="Colores" id="Colores" placeholder="Colores:">
                <input type="text" name="imagen" id="Imagen" placeholder="Link de Imagen:">
                <input type="text" name="detalles" id="contraseña" placeholder="Descripcion:" cols="40" rows="5" class="descripcion">    
    
            </div>
            <br>
            <div>
                <button type="submit" >Registrar</button>
            </div>
        </form>
    </section>
    <br><br><br><br>

    <footer>
       <div style="text-align: center;">Yahir Emmanuel Ramirez Pulido</div>
        <div style="text-align: center;">4°p</div>
        <div style="text-align: center;">Desarrollo Web y Base de Datos</div>
    </footer>
</body>
</html>