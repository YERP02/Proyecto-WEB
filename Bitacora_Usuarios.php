<?php

$servername = "localhost";
$database = "registro";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Trigger para Auditoría en Inserción (INSERT)
$sql1 = "
CREATE TRIGGER bitacora_insert_usuarios
AFTER INSERT ON usuarios
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_usuarios (fecha, sentencia, contrasentencia) VALUES (
        NOW(),
        CONCAT('INSERT INTO usuarios (id, Nombre, Apellidos, Celular, FechaNacimiento, Username, Direccion, Correo, Contrasena) VALUES 
        (', NEW.id, ', ''', NEW.Nombre, ''', ''', NEW.Apellidos, ''', ''', NEW.Celular, ''', ''', NEW.FechaNacimiento, ''', ''', NEW.Username, ''', ''', NEW.Direccion, ''', ''', NEW.Correo, ''', ''', NEW.Contrasena, ''')'),
        CONCAT('DELETE FROM usuarios WHERE id = ', NEW.id)
    );
END;
";

// Trigger para Auditoría en Actualización (UPDATE)
$sql2 = "
CREATE TRIGGER bitacora_update_usuarios
BEFORE UPDATE ON usuarios
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_usuarios (fecha, sentencia, contrasentencia) VALUES (
        NOW(),
        CONCAT('UPDATE usuarios SET 
                Nombre = ''', NEW.Nombre, ''',
                Apellidos = ''', NEW.Apellidos, ''',
                Celular = ''', NEW.Celular, ''',
                FechaNacimiento = ''', NEW.FechaNacimiento, ''',
                Username = ''', NEW.Username, ''',
                Direccion = ''', NEW.Direccion, ''',
                Correo = ''', NEW.Correo, ''',
                Contrasena = ''', NEW.Contrasena, '''
                WHERE id = ', NEW.id),
        CONCAT('Registro actualizado en la tabla usuarios. Valores antiguos: 
                Nombre: ', OLD.Nombre, ', Apellidos: ', OLD.Apellidos, ', Celular: ', OLD.Celular, ',
                FechaNacimiento: ', OLD.FechaNacimiento, ', Username: ', OLD.Username, ', Direccion: ', OLD.Direccion, ',
                Correo: ', OLD.Correo, ', Contrasena: ', OLD.Contrasena)
    );
END;
";

// Trigger para Auditoría en Eliminación (DELETE)
$sql3 = "
CREATE TRIGGER bitacora_delete_usuarios
AFTER DELETE ON usuarios
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_usuarios (fecha, sentencia, contrasentencia) VALUES (
        NOW(),
        CONCAT('DELETE FROM usuarios WHERE id = ', OLD.id),
        NULL
    );
END;
";

// Ejecutar las declaraciones SQL
if ($conn->multi_query($sql1 . $sql2 . $sql3) === TRUE) {
    echo "Triggers creados con éxito";
} else {
    echo "Error al crear los triggers: " . $conn->error;
}

// Cerrar la conexión
$conn->close();

?>