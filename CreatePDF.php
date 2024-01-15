<?php ob_start();?>
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
            $producto = array(
                'id' => $_POST['id'],
                'nombre' => $_POST['nombre'],
                'precio' => $_POST['precio'],
                'URLImagen' => $_POST['URLImagen'],
                'cantidad' => $_POST['cantidad']
            );
        
            $_SESSION['carrito'][] = $producto;
        }
        
    } else {
        
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-color: #fff; 
            color: #000; 
        }

        #header {
            background-color: #000; 
            color: #fff; 
            text-align: center;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
    <div id="header">
        <h1>CALZATURE</h1>
    </div>

    <table>
            <thead>
                <tr>
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
                        <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['cantidad']; ?></td>
                        <td><?php echo "$",$producto['precio']; ?></td>
                        <td><?php echo "$",$subtotal; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="3" style="text-align: right;">Total del carrito:</td>
                    <td><?php echo "$",$totalCarrito; ?></td>
                </tr>
            </tbody>
        </table>
</body>
</html>
<?php

session_start();


require 'vendor/autoload.php';

use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$Login=$_SESSION['Correo'];
echo $Login;

// Generar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml(ob_get_clean());
$dompdf->render();
$contenido = $dompdf->output();
$nombreDelDocumento = "1_Calzature.pdf";
file_put_contents($nombreDelDocumento, $contenido);

// Enviar correo
$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'calzature.tenis@gmail.com';
    $mail->Password   = 'whdz benq vyzs ztca';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->setFrom('calzature.tenis@gmail.com', 'Yahir Ramirez');
    $mail->addAddress($Login, 'usuario'); 

    $mail->isHTML(true);
    $mail->Subject = 'Prueba SMTP';
    $mail->Body    = '<b>¡Hola!</b> este es un mensaje de prueba SMTP';
    $mail->AltBody = 'Este es el cuerpo del mensaje en texto plano para clientes de correo que no admiten HTML. ¡Hola!';

    $mail->addAttachment($nombreDelDocumento, 'ReciveCalzature.pdf');

    $mail->send();
    echo 'se envio el correo exitosamente';
    header("location: Carrito.php");
} catch (Exception $e) {
    echo "El correo no pudo ser enviado. Error del correo: {$mail->ErrorInfo}";
}


unlink($nombreDelDocumento);



?>