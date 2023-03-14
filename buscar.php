<?php

session_start();



    require("abrirConexion.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $productoCliente = $_POST['texto'];
        $sql = "SELECT Identificador, Nombre, Marca, Precio, Imagen FROM productos WHERE Nombre LIKE '%".$productoCliente."%' OR Marca LIKE '%".$productoCliente."%'";
    } else {
        $sql = "SELECT Identificador, Nombre, Marca, Precio, Imagen FROM productos";
    }
    $result = $conexion->query($sql);

    $productos = array();

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($productos, $row);
        }
    }

    require("cabecera.php");
    // Close connection
    mysqli_close($conexion);

require('buscar.view.php');
?>