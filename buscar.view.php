<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Adrian Blanco Martin">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script scr="https://maxdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>
    <?php
    require('cabecera.view.php');
    $esAdmin = false;
    if (isset($_SESSION["Administrador"]) && $_SESSION["Administrador"] == 1) {
        $esAdmin = true;
    }
    ?>
    <?php
    if ($esAdmin) {
        echo '<a href="./nuevo.php" class="btn btn-success">Añadir producto</a>';
    }
    ?>
    <div class="contenedor-productos">

        <?php
        foreach ($productos as &$producto) {
            ?>
            <div class='producto'>
                <div class="img-producto">
                    <?php
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($producto['Imagen']) . '"/>';
                    ?>
                </div>
                <div class="des-producto">
                    <h4>
                        <?php
                        echo $producto["Nombre"];
                        ?>
                    </h4>
                </div>
                <div class="precio">
                    <?php
                    echo $producto["Precio"] . "€";
                    ?>
                </div>
                <div>
                    <?php
                    if (!$esAdmin) {
                        ?>

                        <a href="./añadirCarrito.php?Id=<?= $producto["Identificador"] ?>" class="btn btn-danger">Agregar</a>

                        <?php
                    }
                    ?>
                </div>
                <div class="contenedor-boton-aniadir">
                    <?php
                    if ($esAdmin) {
                        ?>
                        <a href="./editar.php?Id=<?= $producto["Identificador"] ?>" class="btn btn-primary">Editar</a>
                        <a href="javascript:preguntaBorrar(<?= $producto["Identificador"] ?>)" class="btn btn-danger">Borrar</a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }

        ?>

    </div>


</body>
<script>
    function preguntaBorrar(Id) {
        if (confirm("Estas seguro de borrar este producto !!")) {
            window.location.assign("borrar.php?Id=" + Id);
        }

    }

</script>

</html>