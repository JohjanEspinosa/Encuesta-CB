<?php
session_start(); // Iniciar la sesión (si no está iniciada)
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $login_username = $_POST["login_username"];
    $login_password = $_POST["login_password"];

    // Conectar a la base de datos
    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "encuesta_db";

    $conexion = new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta para verificar las credenciales
    $sql = "SELECT * FROM usuarios WHERE username = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $login_username);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            // El usuario existe, verificar la contraseña
            $row = $result->fetch_assoc();
            if (password_verify($login_password, $row["password"])) {
                // Contraseña válida, inicio de sesión exitoso
                $_SESSION["usuario"] = $login_username;
                header("Location: ./encuesta.html"); // Redireccionar al panel de control
                exit();
            } else {
                echo "Contraseña incorrecta";
            }
        } else {
            echo "Nombre de usuario no encontrado";
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($conexion);
    }

    $stmt->close();
    $conexion->close();
} else {
    // Si el formulario no se ha enviado, redireccionar al formulario de inicio de sesión
    header("Location: login.html");
}
?>
