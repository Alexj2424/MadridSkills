<?php
session_start();

if(!isset($_SESSION["Id"])){
    header("Location: login.php");
     return;
 }
 
require("abrirConexion.php");

$IdCliente = $_SESSION["Id"];

$mensaje = "";
$Operacion = "Editar usuario";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $NombreU = $_POST["Nombre"];
    $Apellido1U = $_POST["Apellido1"];
    $Apellido2U = $_POST["Apellido2"];
    $EmailU = $_POST["Email"];
    $DireccionU = $_POST["Direccion"];
    $Codigo_PostalU = $_POST["Codigo_Postal"];


    $sql = "UPDATE usuarios SET Nombre=?,Apellido1=?,Apellido2=?,Email=?,Direccion=?,Codigo_Postal=? WHERE Id=?";

    if ($stmt = mysqli_prepare($conexion, $sql)) {

        mysqli_stmt_bind_param($stmt, "sssssii", $NombreU, $Apellido1U, $Apellido2U, $EmailU, $DireccionU, $Codigo_PostalU, $IdCliente);

        mysqli_stmt_send_long_data($stmt, 7, $data);
        if (mysqli_stmt_execute($stmt)) {
            $mensaje = "Se ha insertado correctamente.";
            header("location: gestionDeUsuario.php");
        } else {
            $mensaje = "Algo salió mal, por favor vuelve a intentarlo.";
        }
    }
} else {

    $sql = "SELECT Id, Nombre, Apellido1, Apellido2, Email, Direccion, Codigo_Postal FROM usuarios WHERE Id = " . $IdCliente;

    $result = $conexion->query($sql);

    $obj = $result->fetch_object();
   

    $Id = $obj->Id;
    $Nombre = $obj->Nombre;
    $Apellido1 = $obj->Apellido1;
    $Apellido2 = $obj->Apellido2;
    $Email = $obj->Email;
    $Direccion = $obj->Direccion;
    $Codigo_Postal = $obj->Codigo_Postal;
}


require("cabecera.php");

mysqli_close($conexion);

require('gestionDeUsuario.view.php');
?>