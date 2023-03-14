<?php
session_start();

if (!isset($_SESSION["Administrador"]) || $_SESSION["Administrador"] !== 1) {
    header("location: index.php");
    exit;
}

require("abrirConexion.php");
$mensaje = "";
$Operacion = "Editar producto";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Id = $_POST["Identificador"];
    $NombreP = $_POST["Nombre"];
    $CategoriaP = intval($_POST["Categoria"]);
    $MarcaP = $_POST["Marca"];
    $PesoP = $_POST["Peso"];
    $PrecioP = floatval($_POST["Precio"]);
    $ImagenP = $_FILES["Imagen"];

    if ($ImagenP["size"] > 0) {
        $sql = "UPDATE productos SET Nombre=?,Categoria=?,Marca=?,Peso=?,Precio=?,Imagen=? WHERE Identificador=?";

        if ($stmt = mysqli_prepare($conexion, $sql)) {

            mysqli_stmt_bind_param($stmt, "sissdbi", $NombreP, $CategoriaP, $MarcaP, $PesoP, $PrecioP, $ImagenP, $Id);

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
        $sql = "UPDATE productos SET Nombre = ?,Categoria = ?,Marca = ?,Peso = ?,Precio = ? WHERE Identificador = ?";

        if ($stmt = mysqli_prepare($conexion, $sql)) {

            mysqli_stmt_bind_param($stmt, "sissdi", $NombreP, $CategoriaP, $MarcaP, $PesoP, $PrecioP, $Id);

            if (mysqli_stmt_execute($stmt)) {
                $mensaje = "Se ha insertado correctamente.";
                header("location: buscar.php");
            } else {
                $mensaje = "Algo salió mal, por favor vuelve a intentarlo.";
            }
        }
    }
} else {
    $Id = $_GET["Id"];

    $sql = "SELECT Identificador, Nombre, Categoria, Marca, Peso, Precio, Imagen FROM productos WHERE Identificador = " . $Id;

    $result = $conexion->query($sql);

    //$productos = array();

    if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();

        $Nombre = $row["Nombre"];
        $Categoria = $row["Categoria"];
        $Marca = $row["Marca"];
        $Peso = $row["Peso"];
        $Precio = $row["Precio"];
    }

}
require("cabecera.php");

mysqli_close($conexion);

require('formulario.view.php');
?>