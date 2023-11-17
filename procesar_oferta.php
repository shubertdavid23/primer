<?php
session_start();
include("conexion.php");

// Función para obtener el empresa_id
function obtenerEmpresaId() {
    // Verifica si la variable de sesión 'empresa_id' está configurada y si la empresa ha iniciado sesión.
    if (isset($_SESSION['empresa_id'])) {
        return $_SESSION['empresa_id'];
    } else {
        return null;
    }
}

// Recuperar datos del formulario
$titulo = $_POST['titulo'];
$duracion = $_POST['duracion'];
$tareas = $_POST['tareas'];
$horario = $_POST['horario'];
$descripcion = $_POST['descripcion'];
$area = implode(', ', $_POST['area']);
$fechaInicio = $_POST['fecha_inicio'];
$remuneracion = $_POST['remuneracion'];

// Crear un diccionario con las ofertas
$ofertas = array();

// Obtener el 'empresa_id' de la empresa actualmente autenticada
$empresa_id = obtenerEmpresaId();

if ($empresa_id === null) {
    echo "Error: No se pudo determinar la empresa que publica la oferta. Asegúrate de haber iniciado sesión como empresa.";
} else {
    // Insertar los datos en la base de datos
    $sql = "INSERT INTO ofertas (titulo, tareas, remuneracion, area, fecha_inicio, fecha_final, duracion, detalles, usuario_id, empresa_id) 
            VALUES ('$titulo',  '$tareas', '$remuneracion', '$area',  '$fechaInicio',  '$fechaInicio', '$duracion', '$descripcion', " . $_SESSION["usuario_id"] . "," . $_SESSION["empresa_id"] . ")";

    if ($conexion->query($sql) !== TRUE) {
        echo "Error al publicar la oferta: " . $conexion->error;
    }
}

header('Location: menuempresa.php');

$conexion->close();
?>

