<?php
// Incluir el archivo de conexión a la base de datos
require 'global.php';

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el usuario y la contraseña enviados desde el formulario
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Realizar la consulta a la colección de usuarios
    $usuarioDocument = $database->usuarios->findOne(['usuario' => $usuario]);

    // Verificar si se encontró un usuario con el nombre proporcionado
    if ($usuarioDocument) {
        // Verificar si la contraseña ingresada coincide con la contraseña almacenada en la base de datos
        if (md5($password) == $usuarioDocument['password']) {
            // Iniciar sesión y redirigir al usuario a la página correspondiente según su rol
            session_start();
            $_SESSION['usuario'] = $usuario;
            $rol = $usuarioDocument['rol'];
            switch ($rol) {
                case 'gestor':
                    header('Location: conversaciones.php');
                    break;
                case 'editor':
                    header('Location: contenidos.php');
                    break;
                case 'superadministrador':
                    header('Location: index.php');
                    break;
                default:
                    // Si el rol no coincide con ninguno de los anteriores, redirigir a una página predeterminada
                    header('Location: pagina_default.php');
                    break;
            }
            exit;
        } else {
            // Contraseña incorrecta, mostrar mensaje de error
            echo "<script>alert('Contraseña incorrecta'); window.location.href = 'login.php';</script>";
        }
    } else {
        // Usuario no encontrado, mostrar mensaje de error
        echo "Usuario no encontrado";
    }
} else {
    // Redirigir a la página de inicio de sesión si no se enviaron los datos del formulario
    header('Location: login.php');
    exit;
}
?>
