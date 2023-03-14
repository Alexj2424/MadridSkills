<?php
	// Include config file
	require_once "abrirConexion.php";
	 
	// Define variables and initialize with empty values
	$Nombre = $Apellido1 = $Apellido2 = $Email = $Direccion = $Codigo_Postal = $Contraseña = $confirm_Contraseña = "";
	$Nombre_err = $Apellido1_err = $Apellido2_err = $Email_err = $Direccion_err = $Codigo_Postal_err = $Contraseña_err = $confirm_Contraseña_err = "";
   
	// Processing form data when form is submitted
	if($_SERVER["REQUEST_METHOD"] == "POST"){
	 
		$Nombre = trim($_POST["Nombre"]);
		$Apellido1 = trim($_POST["Apellido1"]);
		$Apellido2 = trim($_POST["Apellido2"]);
		$Email = trim($_POST["Email"]);
		$Direccion = trim($_POST["Direccion"]);
		$Codigo_Postal = trim($_POST["Codigo_Postal"]);

		// Validate Nombre
		if(empty(trim($_POST["Email"]))){
			$Email_err = "Por favor ingrese un email.";
		} else{
			
			
			// Prepare a select statement
			$sql = "SELECT Id FROM usuarios WHERE Email = ?";
			
			if($stmt = mysqli_prepare($conexion, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_Email);
				
				// Set parameter
			    $param_Email = trim($_POST["Email"]);

				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					/* store result */
					mysqli_stmt_store_result($stmt);
					
					if(mysqli_stmt_num_rows($stmt) == 1){
						$Email_err = "Este email ya está registrado";
					} else{
						$Email = trim($_POST["Email"]);
					}
				} else{
					echo "Al parecer algo salió mal.";
				}
			}
			 
			// Close statement
			mysqli_stmt_close($stmt);
		}
		
		// Validate Contraseña
		if(empty(trim($_POST["Contraseña"]))){
			$Contraseña_err = "Por favor ingresa una contraseña.";     
		} elseif(strlen(trim($_POST["Contraseña"])) < 6){
			$Contraseña_err = "La contraseña al menos debe tener 6 caracteres.";
		} else{            
			$Contraseña = trim($_POST["Contraseña"]);
		}
		
		// Validate confirm Contraseña
		if(empty(trim($_POST["confirm_Contraseña"]))){
			$confirm_Contraseña_err = "Confirma tu contraseña.";     
		} else{
			$confirm_Contraseña = trim($_POST["confirm_Contraseña"]);
			if(empty($Contraseña_err) && ($Contraseña != $confirm_Contraseña)){
				$confirm_Contraseña_err = "No coincide la contraseña.";
			}
		}
		
		// Check input errors before inserting in database
		if(empty($Email_err) && empty($Contraseña_err) && empty($confirm_Contraseña_err) && empty($Apellido1_err) && empty($Apellido2_err) && empty($Email_err)){
			
			// Prepare an insert statement
			$sql = "INSERT INTO usuarios (Nombre, Apellido1, Apellido2, Email, Direccion, Codigo_Postal, Contraseña) VALUES (?, ?, ?, ?, ?, ?, ?)";
			 
			if($stmt = mysqli_prepare($conexion, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "sssssss", $param_Nombre, $param_Apellido1, $param_Apellido2, $param_Email,$param_direccion,$param_codigo_postal, $param_Contraseña);
				
				// Set parameters
				
				$param_Contraseña = password_hash($Contraseña, PASSWORD_DEFAULT); // Creates a Contraseña hash
				
				$param_Nombre = trim($_POST["Nombre"]);
				$param_Apellido1 = trim($_POST["Apellido1"]);
				$param_Apellido2 = trim($_POST["Apellido2"]);
				$param_direccion = trim($_POST["Direccion"]);
				$param_codigo_postal = trim($_POST["Codigo_Postal"]);

				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					// Redirect to login page
					header("location: login.php");
				} else{
					echo "Algo salió mal, por favor inténtalo de nuevo.";
				}
			}
			 
			// Close statement
			mysqli_stmt_close($stmt);
		}
		
		// Close connection
		mysqli_close($conexion);
	}
    require('register.view.php');
?>
