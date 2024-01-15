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

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregarCarrito'])) {
            $idProducto = $_POST['id'];
            $cantidadProducto = $_POST['cantidad'];
    
            $productoExistente = false;
            foreach ($_SESSION['carrito'] as &$producto) {
                if ($producto['id'] == $idProducto) {
                    $producto['cantidad'] += $cantidadProducto;
                    $productoExistente = true;
                    break;
                }
            }
    
            if (!$productoExistente) {
                $producto = array(
                    'id' => $_POST['id'],
                    'nombre' => $_POST['nombre'],
                    'precio' => $_POST['precio'],
                    'URLImagen' => $_POST['URLImagen'],
                    'cantidad' => $_POST['cantidad']
                );
    
                $_SESSION['carrito'][] = $producto;
            }
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
    
    <style>
        .conte{
            display: flex;
            justify-content: center;
            align-items: center;
            /* height: 100vh;  */
        }

        body {
            background-color: #fff; 
            color: #000;
        }

        #header {
            background-color: #A50104;
            color: #fff; 
            text-align: center;
            padding: 10px;
        }

        table {
            width: 80%;
            margin-left: 10%;
            border-collapse: collapse;
            text-align: center;
            font-size: 20px;
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
    <title>Calzature</title>
</head>
<body>
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
                <a href=""><label for="carrito-check" class="carrito-btn"></a>
                    <img class="CarritoImg" src=".\Fotos para Css\Carrito2.png">
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
    <div id="header">
        <h1>CALZATURE</h1>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalCarrito = 0;
                foreach ($_SESSION['carrito'] as $producto) {
                    $subtotal = $producto['precio'] * $producto['cantidad'];
                    $totalCarrito += $subtotal;
                ?>
                    <tr>
                        <td><img src="<?php echo $producto['URLImagen']; ?>" alt="no se encontro" style="height: 120px; width: 120px;"></td>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['cantidad']; ?></td>
                        <td><?php echo "$",$producto['precio']; ?></td>
                        <td><?php echo "$",$subtotal; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="4" style="text-align: right;">Total del carrito:</td>
                    <td><?php echo "$",$totalCarrito; ?></td>
                </tr>
            </tbody>
        </table>
    </div>


    <!-- <div>
        <br>
        <a href="pago.php"><button class="BtnComprar" type="button">Agregar Método de Pago</button></a>
        <form action="Carrito.php" method="post" id="formMetodoPago">
        <label for="pago">Pago</label>
        <input type="checkbox" id="pago" name="pago" onchange="toggleComprarButton()">
        <a href="CreatePDF.php"><button class="BtnComprar" type="submit" id="btnComprar" disabled>
            Comprar
        </button></a>
    </div> -->

    <div style="width: 100%; ">
        <br>
        <a href="CreatePDF.php"><button type="button" style="font-size: 25px; align-items:center; margin-left: 80%; ">comprar</button></a>
    </div>


    <br><br>
    <footer>
        <div style="text-align: center;">Yahir Emmanuel Ramirez Pulido</div>
        <div style="text-align: center;">4°p</div>
        <div style="text-align: center;">Desarrollo Web y Base de Datos</div>
    </footer>
</body>


</html>
<script>
    function toggleComprarButton() {
        var checkbox = document.getElementById("pago");
        var comprarButton = document.getElementById("btnComprar");

        comprarButton.disabled = !checkbox.checked;
    }
</script>