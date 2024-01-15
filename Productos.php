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
        
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregarCarrito'])) {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $URLImagen = $_POST['URLImagen'];
            $cantidad = 1; 
    
            $productoExistente = false;
            foreach ($_SESSION['carrito'] as &$producto) {
                if ($producto['id'] == $id) {
                    $producto['cantidad'] += $cantidad;
                    $productoExistente = true;
                    break;
                }
            }

            if (!$productoExistente) {
                $producto = array(
                    'id' => $id,
                    'nombre' => $nombre,
                    'URLImagen' => $URLImagen,
                    'precio' => $precio,
                    'cantidad' => $cantidad
                );
                $_SESSION['carrito'][] = $producto;
            }
    
            $queryInsert = "INSERT INTO carrito (producto, URLImagenC, precio, cantidad, total) 
                            VALUES ('$nombre','$URLImagen', $precio, $cantidad, $precio)";
            $queryUpdate = "UPDATE carrito SET cantidad = cantidad + $cantidad, total = total + $precio 
                            WHERE producto = '$nombre'";
            mysqli_query($con, $productoExistente ? $queryUpdate : $queryInsert);
        }

    } else {
        
    }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
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
<body style="background: white;">
    <div class="conte">
        <nav>
            <input type="checkbox" id="click">
            <label for="click" class="btn">
                <i class="fa-solid fa-bars"></i>
            </label>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="Productos.php">Productos</a></li>
                <?php
                if ($admin === 2) {
                    echo '<li><a href="Adminproductos.php">Editar Productos</a></li>';
                    echo '<li><a href="RegistrarAdmin.php">RegistrarAdmin</a></li>';
                    echo '<li><a href="Mostrar_Bitacoras.php">Bitacora</a></li>';
                    echo '<li><a href="Salir.php">Salir</a></li>';
                }elseif($admin === 1){
                    echo '<li><a href="Salir.php">Salir</a></li>';
                   // echo '<img class="CarritoImg" src=".\Fotos para Css\Carrito.png">';
                }elseif($admin === 0){
                    echo '<li><a href="Registrar.php">Registrarme</a></li>';
                    echo '<li><a href="Login.php">Login</a></li>';
                }
                ?>

            </ul>
            <div class="carrito-desplegable">
                <input type="checkbox" id="carrito-check" style="display: none;">
                <label for="carrito-check" class="carrito-btn">
                    <a href="Carrito.php"><img class="CarritoImg" src=".\Fotos para Css\Carrito2.png"  style="background: black; border-radius: 9px;"></a>
                    <div class="CarritoDat">
                        <div class="ProductoCarrito">

                        </div>
                        <div class="ProductoCarrito">Producto 2</div>
                    </div>
                </label>
                <button type="button" class="ver-carrito"></button>
            </div>
        </nav>
    </div>
    <br><br>
    <div class="TituloIn">
        <h1>Productos</h1>
    </div>

    <main class="ProductoMain">
        
        <section class="IntProductos" >

        <?php
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila['id'];
                $Nombre= $fila['nombre'];  
                $imagen = $fila['URLImagen'];
                if(!file_exists($imagen)){
                  $imagen = "images/no-photo.jpg";
                }
        ?>

                
            <div class="ImgsProducto" style="border: 2px solid 	grey;">
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="nombre" value="<?php echo $fila['nombre']; ?>">
                    <input type="hidden" name="precio" value="<?php echo $fila['precio']; ?>">
                    <input type="hidden" name="URLImagen" value=<?php echo $fila['URLImagen']; ?> >
                    <div class="contentProducto" >
                        <div class="ProductoNombre">
                            <p class="TenisName"><?php echo $fila['nombre']; ?></p>
                        </div>
                        
                        <div class="DvImagen">
                            <img class="tamano-1" src= <?php echo $fila['URLImagen']; ?> alt=$_FILES>
                        </div>
                        <div class="tenistallas">Tallas:<?php echo $fila['tallas']; ?></div>
                        <div class="DvMarca">
                            <p class="TenisName"><?php echo $fila['Marca']; ?></p>
                        </div>
                        <div class="DvPrecio">
                            <p class="TenisName">Precio:</p>
                        </div>
                        <p class="TenisName"><?php echo $fila['precio']; ?></p>
                    </div>
                    <div class="Teniscolor"><?php echo $fila['color']; ?></div>
                    <div class="TenisDetalles"><?php echo $fila['detalles']; ?></div>
                    <button type="submit" name="agregarCarrito" style="font-size: 18px;">Agregar al Carrito</button>
                </form>
            </div>
                
            
    
            <br><br>

            <?php
            }
        }
        ?>

        </section>

    </main>

    <div>
        <br>
        <a href="CreatePDF.php"><button type="button">PDF</button></a>
    </div>
    <!-- <div>
        <br>
        <a href="Bitacora_Admin.php"><button type="button">Triggers</button></a>
    </div> -->


    <br><br>
    <footer>
        <div style="text-align: center;">Yahir Emmanuel Ramirez Pulido</div>
        <div style="text-align: center;">4°p</div>
        <div style="text-align: center;">Desarrollo Web y Base de Datos</div>
    </footer>
</body>


</html>
