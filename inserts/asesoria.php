<?php
//require '../header.php'; // Requiere el archivo header.php
require '../global.php'; 

$collection = $database->asesorias; 

$usuario = $_POST['usuario'];
$descripcion = $_POST['descripcion'];
// Aquí necesitarías procesar el campo "file" de acuerdo a cómo estés manejando los archivos en tu sistema. 
// Si estás almacenando referencias a archivos, deberías manejar el archivo que se sube en este punto.
$file = $_POST['file']; // Esto probablemente necesitará ser modificado dependiendo de cómo manejes los archivos
$opciones = $_POST['opciones'];
$archivada = $_POST['archivada'];

// Insertar el documento en la colección
$insertResult = $collection->insertOne([
    'usuario' => $usuario,
    'descripcion' => $descripcion,
    'file' => $file,
    'opciones' => $opciones,
    'archivada' => $archivada
]);

// Verificar si la inserción fue exitosa
if ($insertResult->getInsertedCount() > 0) {
    //echo "Insert successful";
    header('Location: ../conversaciones.php');
    exit;
} else {
    echo "Insert failed";
}


?>
