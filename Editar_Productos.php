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
    $Enc = 0;
    if (isset($_POST['buscar'])) {
        $nombreTenis = $_POST['nombreBusqueda'];
        $queryBuscar = "SELECT * FROM producto WHERE nombre LIKE '%$nombreTenis%'";
        $resultBuscar = mysqli_query($con, $queryBuscar);
    
        if ($resultBuscar && mysqli_num_rows($resultBuscar) > 0) {
            $productoEncontrado = mysqli_fetch_assoc($resultBuscar);
            $ID = $productoEncontrado['id'];
            $nombreT = $productoEncontrado['nombre'];
            $tallas = $productoEncontrado['tallas'];
            $modelo = $productoEncontrado['Marca'];
            $precio = $productoEncontrado['precio'];
            $colores = $productoEncontrado['color'];
            $imagen = $productoEncontrado['URLImagen'];
            $detalles = $productoEncontrado['detalles'];
            $Enc =1;
        } else {
            echo "No se encontró ningún producto con ese nombre.";
        }
    }

    $text = "text";
    $class = "DatosLabel";
    
    if (isset($_POST['Actualizar'])) { 
        $Nombre = $_POST['NombreT'];
        $Id = $_POST['idT'];
        $Tallas =$_POST['Tallas'];
        $Marca = $_POST['Modelo'];
        $Precio = $_POST['Precio'];
        $Color = $_POST['Colores'];
        $Imagen= $_POST['imagen'];
        $Detalles = $_POST['detalles'];
        $query = "UPDATE producto SET 
        nombre = '$Nombre',
        tallas = '$Tallas',
        Marca = '$Marca',
        precio = '$Precio',
        color = '$Color',
        URLImagen = '$Imagen',
        detalles = '$Detalles'
        WHERE id = '$Id'";

        $sql = mysqli_query($con,$query);
        
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
    <title>Calzature</title>
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
        <?php
        if($Enc === 0){
            echo '<h1 class="H1reg">Buscar Productos</h1>' ;
        }elseif($Enc === 1){
            echo  '<h1 class="H1reg">Datos del Producto</h1>';
        }
        ?>
        <form class="Form" action="" method="post">
            <div class="Datos">
                <?php
                if($Enc === 0){
                   echo '<input type="text" name="nombreBusqueda" id="nombreBusqueda" placeholder="Nombre del Producto a Buscar" >' ;
                }elseif($Enc === 1){
                    if (isset($productoEncontrado)) {
                        echo "<input type=$text name='NombreT' value= '$nombreT' >";
                        echo "<input type=$text name='idT' value='$ID' readonly>";
                        echo "<input type=$text name='Tallas' value= '$tallas' >";
                        echo "<input type=$text name='Modelo' value= '$modelo' >";
                        echo "<input type='number' name='Precio' value= '$precio' >";
                        echo "<input type=$text name='Colores' value= '$colores' >";
                        echo "<input type=$text name='imagen' value= '$imagen' >";
                        echo "<input type=$text name='detalles' value= '$detalles' >";
                    }
                }
                ?>

            </div>
            <br>
            <div>
            <?php
                if($Enc === 0){
                   echo '<button type="submit" name="buscar">Buscar</button>' ;
                }elseif($Enc === 1){
                    echo  '<button type="submit" name="Actualizar">Actualizar</button>';
                }
                ?>
                
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
