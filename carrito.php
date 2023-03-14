<?php

session_start();

if(!isset($_SESSION["Id"])){
    header("Location: login.php");
    return;
}

require("abrirConexion.php");

$IdCliente = $_SESSION["Id"];


$sql = "SELECT p.Identificador, p.Nombre, p.Categoria, p.Marca, p.Peso, p.Precio, p.Imagen, c.Cantidad_Productos FROM carrito c INNER JOIN productos p ON c.Id_Productos = p.Identificador WHERE c.Id_Cliente = " . $IdCliente;

    $result = $conexion->query($sql);

    $ListaCompra = array();

    $total = 0;


    while($obj = $result->fetch_object()){
        
        array_push($ListaCompra,$obj);
        $total = $total+($obj -> Precio * $obj -> Cantidad_Productos);
    }

require("cabecera.php");

mysqli_close($conexion);

require("carrito.view.php");

?>