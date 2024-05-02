<?php
require '../global.php'; 

$collection = $database->usuarios; 

$usuario = $_POST['usuario'];
$password = md5($_POST['password']); // Encriptar la contraseña utilizando md5
$rol = $_POST['rol'];

// Insertar el documento en la colección
$insertResult = $collection->insertOne([
    'usuario' => $usuario,
    'password' => $password,
    'rol' => $rol
]);

// Verificar si la inserción fue exitosa
if ($insertResult->getInsertedCount() > 0) {
    header('Location: ../administradores.php');
    exit;
} else {
    echo "Insert failed";
}
?>
