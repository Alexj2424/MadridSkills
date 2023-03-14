<?php
require("abrirConexion.php");

    $sql = "SELECT Identificador, Nombre, Marca, Precio, Imagen FROM productos WHERE Categoria = 3454";

    $result = $conexion->query($sql);

    $productos = array();

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($productos, $row);
        }
    } else {
        //  echo "0 results";
    }

    // Close connection
    mysqli_close($conexion);

require('buscar.view.php');

?>