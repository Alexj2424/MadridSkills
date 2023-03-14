<?php

session_start();

if (!isset($_SESSION["Administrador"]) || $_SESSION["Administrador"] !== 1) {
    header("location: index.php");
    exit;
}


require("abrirConexion.php");

$Id = $_GET['Id'];


    // Borrar el artículo
    $sql = "DELETE FROM productos WHERE Identificador = ".$Id;

    if (mysqli_query($conexion, $sql)) {
        // Si la consulta ha tenido éxito, redirigir al usuario a la página de inicio

        header("Location: buscar.php");

    } else {
        // Si ha habido un error, mostrarlo
        echo "Error al borrar el artículo: " . mysqli_error($conexion);
    }


// Cerrar la conexión
mysqli_close($conexion);


?>