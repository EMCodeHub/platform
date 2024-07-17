<?php


        //$servername = "localhost";
        //$username = "root";
        //$password = "emdevapps123";
        //$dbname = "landing";

        $servername = "qajv883.medifestructuras.com";
        $username = "qajv883";
        $password = "Ghd&8jjd&hh7";
        $dbname = "qajv883";



// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos POST de manera segura
$sessionid = isset($_POST['sessionid']) ? $_POST['sessionid'] : '';
$mensaje1 = isset($_POST['mensaje1']) ? $_POST['mensaje1'] : '';
$mensaje2 = isset($_POST['mensaje2']) ? $_POST['mensaje2'] : '';

// Verificar si los datos no están vacíos antes de insertar
if (!empty($sessionid) && isset($mensaje1) && isset($mensaje2)) {

    // Insertar datos en la tabla usando sentencias preparadas
    $stmt_insert = $conn->prepare("INSERT INTO conversacionbotmedif (sessionid, mensaje1, mensaje2) VALUES (?, ?, ?)");
    $stmt_insert->bind_param("sss", $sessionid, $mensaje1, $mensaje2);

    if ($stmt_insert->execute()) {
        echo "Nuevo registro creado con éxito";
    } else {
        echo "Error al insertar registro: " . $stmt_insert->error;
    }

    $stmt_insert->close();

} else {
    echo "Datos insuficientes para insertar en la base de datos";
}

// Cerrar conexión
$conn->close();
?>
