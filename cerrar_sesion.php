<?php
session_start();
// Destruir la sesión
session_destroy();
// Redirigir al usuario a la página de inicio de sesión
header("Location: index.html");
exit();

session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: index.html");
    exit();
}
?>


