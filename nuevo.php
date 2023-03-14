<?php
session_start();

if (!isset($_SESSION["Administrador"]) || $_SESSION["Administrador"] !== 1) {
    header("location: index.php");
    exit;
}

require("abrirConexion.php");
$mensaje = "";
$Id = "";
$Operacion = "Nuevo producto";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $NombreP = $_POST["Nombre"];
    $CategoriaP = intval($_POST["Categoria"]);
    $MarcaP = $_POST["Marca"];
    $PesoP = $_POST["Peso"];
    $PrecioP = floatval($_POST["Precio"]);
    $ImagenP = $_FILES["Imagen"];

    $sql = "SELECT Identificador FROM productos WHERE Nombre = '" . $NombreP . "'";

    $result = $conexion->query($sql);


    if ($result->num_rows > 0) {
        $mensaje = "Ese producto ya existe";
        $Nombre = "";
        $Marca = "";
        $Peso = "";
        $Precio = "";
    } else {
        if ($_FILES["Imagen"]["size"] > 0) {
            $sql = "INSERT INTO productos (Nombre,Categoria,Marca,Peso,Precio,Imagen) VALUES (?,?,?,?,?,?)";
            if ($stmt = mysqli_prepare($conexion, $sql)) {
                mysqli_stmt_bind_param($stmt, "sissdb", $NombreP, $CategoriaP, $MarcaP, $PesoP, $PrecioP, $ImagenP);
                $data = file_get_contents($_FILES["Imagen"]["tmp_name"]);
                mysqli_stmt_send_long_data($stmt, 5, $data);
                if (mysqli_stmt_execute($stmt)) {
                    $mensaje = "Se ha insertado correctamente.";
                    header("location: buscar.php");
                } else {
                    $mensaje = "Algo salió mal, por favor vuelve a intentarlo.";
                }
            }
        } else {
            $sql = "INSERT INTO productos (Nombre,Categoria,Marca,Peso,Precio) VALUES (?,?,?,?,?)";
            if ($stmt = mysqli_prepare($conexion, $sql)) {
                mysqli_stmt_bind_param($stmt, "sissd", $NombreP, $CategoriaP, $MarcaP, $PesoP, $PrecioP);
                if (mysqli_stmt_execute($stmt)) {
                    $mensaje = "Se ha insertado correctamente.";
                    header("location: buscar.php");
                } else {
                    $mensaje = "Algo salió mal, por favor vuelve a intentarlo.";
                }
            }
        }
    }
} else {
    $Nombre = "";
    $Marca = "";
    $Peso = "";
    $Precio = "";
}

require("cabecera.php");

mysqli_close($conexion);

require('formulario.view.php');
?>