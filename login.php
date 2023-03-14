<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: buscar.php");
  exit;
}
 
// Include config file
 require_once "abrirConexion.php";
 
// Define variables and initialize with empty values
$Email = $Contraseña = "";
$Email_err = $Contraseña_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if Email is empty
    if(empty(trim($_POST["Email"]))){
        $Email_err = "Por favor ingrese su usuario.";
    } else{
        $Email = trim($_POST["Email"]);
    }
    
    // Check if Contraseña is empty
    if(empty(trim($_POST["Contraseña"]))){
        $Contraseña_err = "Por favor ingrese su contraseña.";
    } else{
        $Contraseña = trim($_POST["Contraseña"]);
    }
    
    // Validate credentials
    if(empty($Email_err) && empty($Contraseña_err)){
        // Prepare a select statement
        $sql = "SELECT Id, Email, Contraseña, Administrador FROM usuarios WHERE Email = ?";
        
        if($stmt = mysqli_prepare($conexion, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_Email);
            
            // Set parameters
            $param_Email = $Email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if Email exists, if yes then verify Contraseña
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $Email, $hashed_Contraseña,$Administrador);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($Contraseña, $hashed_Contraseña)){
                           
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["Id"] = $id;
                            $_SESSION["Email"] = $Email;
                            $_SESSION["Administrador"] = $Administrador;
                           

                            // Redirect user to welcome page

                              
                                header("location: buscar.php");
                            
                        } else{
                            // Display an error message if Contraseña is not valid
                            $Contraseña_err = "La contraseña que has ingresado no es válida.";
                        }
                    }
                } else{
                    // Display an error message if Email doesn't exist
                    $Email_err = "No existe cuenta registrada con ese email de usuario.";
                }
            } else{
                echo "Algo salió mal, por favor vuelve a intentarlo.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conexion);
}
require('login.view.php');
?>




