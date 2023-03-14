<?php
require("abrirConexion.php");

    session_start();

    if(!isset($_SESSION["Id"])){
        header("Location: login.php");
         return;
     }
     
    $Id = intval($_GET["Id"]);

    $IdCliente = $_SESSION["Id"];

    $sql = "UPDATE carrito SET Cantidad_Productos = Cantidad_Productos +1 WHERE Id_Productos =? AND Id_Cliente =?";

    if ($stmt = mysqli_prepare($conexion, $sql)) {

        mysqli_stmt_bind_param($stmt, "ii", $Id_Productos_param, $Id_cliente_param);

        $Id_Productos_param = $Id;
        $Id_cliente_param = $IdCliente;

        mysqli_stmt_send_long_data($stmt, 2, $data);
        if (mysqli_stmt_execute($stmt)) {
            $mensaje = "Se ha insertado correctamente.";
            header("location: carrito.php");
        } else {
            $mensaje = "Algo salió mal, por favor vuelve a intentarlo.";
        }
    } else {

    }
    


?>