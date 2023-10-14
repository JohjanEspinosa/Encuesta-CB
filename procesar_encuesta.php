<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.html");
    exit();
}

// Recibir el nombre de usuario
$usuario = $_SESSION["usuario"];

// Conectar a la base de datos
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "encuesta_db";

$conexion = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$evaluado = isset($_POST["evaluado"]) ? $_POST["evaluado"] : "";

if (empty($evaluado)) {
    // Manejar el caso en el que evaluado es nulo
    echo "El campo 'evaluado' no puede estar vacío. Por favor, seleccione a quién desea evaluar.";
} else {
    // Continuar con la inserción en la base de datos
}

$comentarios = $_POST["comentarios"];
$evaluado = $_POST["evaluado"];

// Definir un arreglo para almacenar las preguntas y respuestas
$preguntas = [];
for ($i = 1; $i <= 17; $i++) {
    $pregunta = $_POST["pregunta" . $i];
    $preguntas[] = $pregunta;
}

// Preparar y ejecutar la consulta para insertar las respuestas
$sql = "INSERT INTO respuestas (usuario, evaluado, pregunta, respuesta, comentarios) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);

foreach ($preguntas as $numero => $respuesta) {
    $pregunta = "Pregunta " . ($numero + 1);
    $stmt->bind_param("sssss", $usuario, $evaluado, $pregunta, $respuesta, $comentarios);
    $stmt->execute();
}

$stmt->close();
$conexion->close();

// Redirigir al usuario de vuelta a la página de encuesta o a una página de confirmación
header("Location: encuesta.html");
exit();
?>
