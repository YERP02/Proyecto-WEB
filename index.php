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
    <br>
    <main class="indexmain">
    <section class="InicioSec">
        <div class="TituloIn">
            <h1>Calzature</h1>
        </div>
        <div class="DvInicio">
            <h2>Mision</h2>
            <p>Nuestra mision en Calzature es ofrecer una experinencia de compre en linea exepcional para los
                entusiatas de los tenis, brindando una amplia seleccion del calzado de alta calidad que
                combina estilo, comodidad y rendimiento. Nos esforzamos por ser la primera opcion de los amantes
                de los tenis al proporcionar prductos de calidad, junto con un servicio al cliente 
                exepcional </p>
        
            <h2>Vision</h2>
            <p>En Calzature, visualizamos un sitio web lider en las venta de tenis que establece nuevas tendencias
                en la industria. Queremos crear un espacio en linea donde los amantes de los tenis puedan explorar
            una gama diversa de marcas y estilos, respaldados por informacion detallada y reseñas confiables.
            A medida que avanzamos, buscamos expandirnos globalmente y ofrecer una plataforma que celebre la
            pasion por los tenis en todas partes. </p>

            <h2>Acerca de</h2>
            <p>Somos Calzeture: tu destino en línea para los tenis más elegantes y funcionales. Desde ediciones 
                limitadas hasta clásicos atemporales, ofrecemos una selección que fusiona estilo y rendimiento. 
                Únete a nuestra comunidad de amantes de los tenis y descubre el calzado que te llevará más lejos.
            </p>

            <h2>¿Donde Nos Encontramos?</h2>
            <div class="MapContainer">
                <div>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1679.1407184474845!2d-103.38918446086153!3d20.702530761659883!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428ae4e98d5453d%3A0xc4fdd3929a2ecbd1!2sCentro%20de%20Ense%C3%B1anza%20T%C3%A9cnica%20Industrial%20(Plantel%20Colomos)!5e0!3m2!1ses-419!2smx!4v1694013166922!5m2!1ses-419!2smx" 
                    width="600" height="450" margin="auto" style="border:0 ;" allowfullscreen="" loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

    </main>

    <footer class="footer">
        <div style="text-align: center;">Yahir Emmanuel Ramirez Pulido</div>
        <div style="text-align: center;">4°p</div>
        <div style="text-align: center;">Desarrollo Web y Base de Datos</div>
    </footer>
</body>
</html>

</html>