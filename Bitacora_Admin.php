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
CREATE TRIGGER bitacora_insert_administrador
AFTER INSERT ON administrador
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_administrador (fecha, sentencia, contrasentencia) VALUES (
        NOW(),
        CONCAT('INSERT INTO administrador (id,Username, Correo, Contrasena) VALUES 
        (', NEW.id, ', ''', NEW.Username, ''',''', NEW.Correo, ''', ''', NEW.Contrasena, ''')'),
        CONCAT('DELETE FROM administrador WHERE id = ', NEW.id)
    );
END;
";

// Trigger para Auditoría en Actualización (UPDATE)
$sql2 = "
CREATE TRIGGER bitacora_update_administrador
BEFORE UPDATE ON administrador
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_administrador (fecha, sentencia, contrasentencia) VALUES (
        NOW(),
        CONCAT('UPDATE administrador SET 
                Username = ''', NEW.Username, ''',
                Correo = ''', NEW.Correo, ''',
                Contrasena = ''', NEW.Contrasena, '''
                WHERE id = ', NEW.id),
        CONCAT('Registro actualizado en la tabla administrador. Valores antiguos: 
                Username: ', OLD.Username, ',Correo: ', OLD.Correo, ', Contrasena: ', OLD.Contrasena)
    );
END;
";

// Trigger para Auditoría en Eliminación (DELETE)
$sql3 = "
CREATE TRIGGER bitacora_delete_administrador
AFTER DELETE ON administrador
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_administrador (fecha, sentencia, contrasentencia) VALUES (
        NOW(),
        CONCAT('DELETE FROM administrador WHERE id = ', OLD.id),
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