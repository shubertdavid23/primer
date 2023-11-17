<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("conexion.php");

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formularioa
    $tipo_usuario = htmlspecialchars($_POST["tipo_usuario"]);
    $nombre = htmlspecialchars($_POST["nombre"]);
    $apellido = htmlspecialchars($_POST["apellido"]);
    $cedula = htmlspecialchars($_POST["cedula"]);
    $telefono = htmlspecialchars($_POST["telefono"]);
    $direccion = htmlspecialchars($_POST["direccion"]);
    $correo = htmlspecialchars($_POST["correo"]);
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT); // Hash de la contraseña

    // Campos específicos para Estudiantes
    $institucion = isset($_POST["institucion"]) ? htmlspecialchars($_POST["institucion"]) : null;
    $anio_cursado = isset($_POST["anio_cursado"]) ? htmlspecialchars($_POST["anio_cursado"]) : null;
    $orientacion = isset($_POST["orientacion"]) ? htmlspecialchars($_POST["orientacion"]) : null;

    // Campos específicos para Empresas
    $nombre_fantasia = isset($_POST["nombre_fantasia"]) ? htmlspecialchars($_POST["nombre_fantasia"]) : null;
    $razon_social = isset($_POST["razon_social"]) ? htmlspecialchars($_POST["razon_social"]) : null;
    $rut = isset($_POST["rut"]) ? htmlspecialchars($_POST["rut"]) : null;
    $area_empresa = isset($_POST["area_empresa"]) ? htmlspecialchars($_POST["area_empresa"]) : null;
    $persona_contacto = isset($_POST["persona_contacto"]) ? htmlspecialchars($_POST["persona_contacto"]) : null;

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

    // Insertar datos en la tabla de usuarios
    $sql = "INSERT INTO usuarios (username, password, tipo_usuario) VALUES ('$correo', '$contrasena', '$tipo_usuario')";
    if ($conexion->query($sql) === TRUE) {
        $usuario_id = $conexion->insert_id;

        // Insertar datos en la tabla correspondiente al tipo de usuario
        if ($tipo_usuario === "estudiante") {
            $sql = "INSERT INTO estudiantes (usuario_id, nombre, apellido, cedula, direccion, telefono, anio_cursando, institucion, orientacion, correo) VALUES ('$usuario_id', '$nombre', '$apellido', '$cedula', '$direccion', '$telefono', '$anio_cursado', '$institucion', '$orientacion', '$correo')";
        } elseif ($tipo_usuario === "empresa") {
            $sql = "INSERT INTO empresas (usuario_id, nombre_fantasia, razon_social, rut, direccion_empresa, telefono_empresa, persona_a_cargo, area_empresa, correo_empresa) VALUES ('$usuario_id', '$nombre_fantasia', '$razon_social', '$rut', '$direccion', '$telefono', '$persona_contacto', '$area_empresa', '$correo')";
        }

        if ($conexion->query($sql) === TRUE) {
            $url_redireccion = "index.html";
            
            header("Location: $url_redirecion");
        } else {
            echo "Error al registrar: " . $conexion->error;
        }
    } else {
        echo "Error al registrar: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
}
?>
