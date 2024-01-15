<?php
session_start();
require 'C:\xampp\htdocs\Calzature\Conexion.php';

$correoUsuario = '';

if (isset($_SESSION['Correo'])) {
    $correoUsuario = $_SESSION['Correo'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recoger los datos del formulario
        $tipo = $_POST['tipo'];
        $direccion = $_POST['direccion'];
        $titular = $_POST['titular'];

        $query = "INSERT INTO Pago (tipo, direccion, titular) VALUES ('$tipo', '$direccion', '$titular')";
        $result = mysqli_query($con, $query);

        if ($result) {
            // Operación exitosa
            echo "<p style='color: green;'>¡Método de pago guardado exitosamente!</p>";
        } else {
            // Error en la operación
            echo "<p style='color: red;'>Error al guardar el método de pago.</p>";
        }
        header("location: Carrito.php");
    }
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
    <title>Calzature - Método de Pago</title>
</head>
<body style="background: white;">
    <div class="conte">
        <nav>
            <input type="checkbox" id="click">
            <label for="click" class="btn">
                <i class="fa-solid fa-bars"></i>
            </label>
            <ul>
            </ul>
        </nav>
    </div>

    <section id="RegistroSection">
        <h1 class="H1reg">Método de Pago</h1>
        <form action="" method="post">
            <div class="Datos">
                <label for="tipo">Tipo de Pago:</label>
                <div >
                    <select name="tipo" id="tipo">
                        <option value="efectivo">Efectivo</option>
                        <option value="credito">Crédito</option>
                        <option value="debito">Débito</option>
                    </select>
                </div>

                <label for="direccion">Dirección de Envío:</label>
                <input type="text" name="direccion" id="direccion" placeholder="Dirección de envío" required>

                <label for="titular">Titular de la Tarjeta:</label>
                <input type="text" name="titular" id="titular" placeholder="Titular de la tarjeta" required>
            </div>

            <br>

            <div>
                <button type="submit">Guardar Método de Pago</button>
            </div>
        </form>
    </section>

    <footer>
        <div style="text-align: center;">Yahir Emmanuel Ramirez Pulido</div>
        <div style="text-align: center;">4°p</div>
        <div style="text-align: center;">Desarrollo Web y Base de Datos</div>
    </footer>
</body>
</html>