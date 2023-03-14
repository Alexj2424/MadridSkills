<div class="cabecera">
    <div class="dropdown">
        <button onclick="myFunction()" class="dropbtn menu_icon"></button>
        <div id="myDropdown" class="dropdown-content">

            <a href="index.php">Inicio</a>
            <a href="alimentacion.php">Alimentacion</a>
            <a href="jaulas.php">Jaulas</a>
            <a href="juguetes.php">Juguetes</a>

        </div>
    </div>


    <div>
        <form class="form-search" action="buscar.php" method="post">
            <input type="search" placeholder="Buscar..." name="texto">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="Title">ONLYPARROTS</div>

    <?php
    if (!isset($_SESSION["loggedin"])) {
        ?>
        <div class="registro">
            <button class="Registrase" onclick="window.location='register.php'" value="Registrarse">REGISTRARSE</button>
        </div>

        <div>
            <button class="Login" onclick="window.location='login.php'" value="Login">LOGIN</button>
        </div>
        <?php
    } else {
        ?>
        <h3>
            <?php echo htmlspecialchars($_SESSION["Email"]); ?>
        </h3>
        <a href="gestionDeUsuario.php" class="btn btn-info">Gestionar Cuenta</a>
        <a href="carrito.php" class="btn btn-primary">
            <?php
            if ($carrito_Cantidad > 0) {
                ?>
                <span class="badge badge-light">
                    <?= $carrito_Cantidad ?>
                </span>
                <?php
            }
            ?>
            <span style="font-size:11px">&#128722;</span>
        </a>
        <a href="reset-password.php" class="btn btn-warning">Cambia tu contraseña</a>
        <a href="cerrarConexion.php" class="btn btn-danger mr-5">Cierra la sesión</a>
        <?php
    }
    ?>






</div>



<script>
    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function (event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>