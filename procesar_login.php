<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("conexion.php");

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $user_type = htmlspecialchars($_POST["user-type"]);
    $correo = htmlspecialchars($_POST["email"]);
    $contrasena = htmlspecialchars($_POST["password"]);

    // Conectar a la base de datos
    $servidor = "localhost";
    $usuario = "root";
    $clave = "root";
    $base_de_datos = "primer_paso_laboral";

    $conexion = new mysqli($servidor, $usuario, $clave, $base_de_datos);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Consulta para verificar las credenciales
    $sql = "SELECT id, username, password, tipo_usuario FROM usuarios WHERE username = '$correo'";
    $resultado = $conexion->query($sql);

    if($resultado === false){
        die("error en la consulta SQL: . $CONEXION->error");
    }

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        if (password_verify($contrasena, $fila["password"])) {
            $_SESSION["usuario_id"] = $fila["id"];
            $sqlEmpresas = "SELECT id FROM empresas WHERE usuario_id = " . $fila["id"];
            $resultadoEmpresas = $conexion->query($sqlEmpresas);       
            
            if ($resultadoEmpresas->num_rows > 0) {
                $filaEmpresas = $resultadoEmpresas->fetch_assoc();
                $_SESSION["empresa_id"] = $filaEmpresas["id"];
            }

            // Redirigir según el tipo de usuario
            if ($fila["tipo_usuario"] == "estudiante") {
                include("menuempresa.php");
                exit();
            } elseif ($fila["tipo_usuario"] == "empresa") {
                include("menuempresa.php");
                exit();
            }
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }

    // Cerrar la conexión
    $conexion->close();
}
?>