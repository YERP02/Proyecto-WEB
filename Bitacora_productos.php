<?php


$servername = "localhost";
$database = "registro";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


$sql1 = "
CREATE TRIGGER bitacora_insert_productos
AFTER INSERT ON producto
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_productos (fecha, sentencia, contrasentencia) VALUES (
        NOW(),
        CONCAT('INSERT INTO producto (id, nombre, tallas, Marca, precio, color, URLImagen, detalles) VALUES 
        (', NEW.id, ', ''', NEW.nombre, ''', ''', NEW.tallas, ''', ''', NEW.Marca, ''', ', NEW.precio, ', ''', NEW.color, ''', ''', NEW.URLImagen, ''', ''', NEW.detalles, ''')'),
        CONCAT('DELETE FROM producto WHERE id = ', NEW.id)
    );
END;
";

$sql2 = "
CREATE TRIGGER bitacora_update_productos
BEFORE UPDATE ON producto
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_productos (fecha, sentencia, contrasentencia) VALUES (
        NOW(),
        CONCAT('UPDATE producto SET 
                nombre = ''', NEW.nombre, ''',
                tallas = ''', NEW.tallas, ''',
                Marca = ''', NEW.Marca, ''',
                precio = ''', NEW.precio, ''',
                color = ''', NEW.color, ''',
                URLImagen = ''', NEW.URLImagen, ''',
                detalles = ''', NEW.detalles, '''
                WHERE id = ', NEW.id),
            CONCAT('Registro actualizado en la tabla producto. Valores antiguos: 
                Nombre: ', OLD.nombre, ', Tallas: ', OLD.tallas, ', Marca: ', OLD.Marca, ',
                Precio: ', OLD.precio, ', Color: ', OLD.color, ', URLImagen: ', OLD.URLImagen, ', Detalles: ', OLD.detalles)
    );
END;
";


$sql3 = "
CREATE TRIGGER bitacora_delete_productos
AFTER DELETE ON producto
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_productos (fecha, sentencia, contrasentencia) VALUES (
        NOW(),
        CONCAT('DELETE FROM producto WHERE id = ', OLD.id),
        NULL
    );
END;
";

if ($conn->multi_query($sql1 . $sql2 . $sql3) === TRUE) {
    echo "Triggers creados con éxito";
} else {
    echo "Error al crear los triggers: " . $conn->error;
}

$conn->close();


?>