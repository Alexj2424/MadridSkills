<?php

session_start();
if(!isset($_SESSION["Id"])){
    header("Location: login.php?returnUrl=carrito.php?Id=".$_GET["Id"]);
    return;
}
require("abrirConexion.php");
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {

    $Id = $_GET["Id"];
    $IdCliente = $_SESSION["Id"];

    $sql1 = "SELECT Id_Entrada_Carrito FROM carrito WHERE Id_Cliente =" . $IdCliente . " AND Id_Productos =" . $Id;

    $result = $conexion->query($sql1);


    if ($result->num_rows == 0) {
        $sql = "INSERT INTO carrito (Id_Entrada_Carrito, Id_Cliente, Id_Productos, Cantidad_Productos) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conexion, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iisi", $param_Id_Carrito, $param_Id_Cliente, $param_Productos, $param_Cantidad_Productos);

            // Set parameters

            $param_Id_Carrito = "";
            $param_Id_Cliente = $IdCliente;
            $param_Productos = $Id;
            $param_Cantidad_Productos = 1;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: buscar.php");
            }
        }

    } else {


        $sql3 = "UPDATE carrito SET Cantidad_Productos = Cantidad_Productos + 1 WHERE Id_Cliente = ? AND Id_Productos = ?";

        if ($stmt = mysqli_prepare($conexion, $sql3)) {

            mysqli_stmt_bind_param($stmt, 'ii', $IdCliente, $Id);

            if (mysqli_stmt_execute($stmt)) {
                header("location: buscar.php");
            }
        }
    }
}

// Close statement
mysqli_stmt_close($stmt);

mysqli_close($conexion);

?>