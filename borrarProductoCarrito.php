<?php
    require("abrirConexion.php");

    session_start();

    if(!isset($_SESSION["Id"])){
       header("Location: login.php");
        return;
    }

    $Id = intval($_GET["Id"]);


    $IdCliente = $_SESSION["Id"];

    

        $sql3 = "DELETE FROM carrito WHERE Id_Productos =".$Id. " AND Id_Cliente = ".$IdCliente;


        if (mysqli_query($conexion, $sql3)) {
            // Si la consulta ha tenido éxito, redirigir al usuario a la página de inicio

    
            header("Location: carrito.php");
    
        } else {
            // Si ha habido un error, mostrarlo
            echo "Error al borrar el artículo: " . mysqli_error($conexion);
        }
?>