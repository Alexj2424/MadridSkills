<?php
    require("abrirConexion.php");

    session_start();

    if(!isset($_SESSION["Id"])){
        header("Location: login.php");
         return;
     }

     $IdCliente = $_SESSION["Id"];

        $sql3 = "DELETE FROM usuarios WHERE Id =".$IdCliente;


        if (mysqli_query($conexion, $sql3)) {
            // Si la consulta ha tenido éxito, redirigir al usuario a la página de inicio

            session_destroy();
            header("Location: login.php");
    
        } else {
            // Si ha habido un error, mostrarlo
            echo "Error al borrar el usuario: " . mysqli_error($conexion);
        }
?>