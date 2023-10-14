<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verificar si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $username = $_POST["username_registro"];
    $email = $_POST["email"];
    $password = $_POST["password_registro"];
    $cargo = $_POST["cargo"];

    // Validaciones
    if (empty($username) || empty($email) || empty($password) || empty($cargo)) {
        // Mostrar un mensaje de error y redireccionar al formulario de registro
        header("Location: registro.php?error=Campos obligatorios no completados");
        exit();
    }

    // Conectar a la base de datos (debes completar los datos de conexión)
    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "encuesta_db";

    $conexion = new mysqli($db_host, $db_user, $db_password, $db_name);

    // Verificar si la conexión es exitosa
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Generar un hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (username, email, password, cargo) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    // La cadena de tipos en bind_param debe ser "ssss" ya que estás enlazando cuatro valores de tipo cadena
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $cargo);

    if ($stmt->execute()) {
        // Registro exitoso, redireccionar a una página de éxito
        header("Location: index.html");
    } else {
        // Error en la inserción, mostrar el error
        echo "Error en la inserción: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
} else {
    // Si el formulario no se ha enviado, redireccionar al formulario de registro
    header("Location: registro.html");
}
?>
