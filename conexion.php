<?php
$servidor = "localhost";
$usuario = "root";
$clave = "root";
$base_de_datos = "primer_paso_laboral";

try {
    $conexion = new mysqli($servidor, $usuario, $clave, $base_de_datos);

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }
} catch (Exception $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>