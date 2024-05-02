<?php
require '../global.php'; 

$collection = $database->preguntasfrecuentes; 

$titulo = $_POST['titulo'];
$detalles = $_POST['detalles'];

// Insertar el documento en la colección
$insertResult = $collection->insertOne([
    'titulo' => $titulo,
    'detalles' => $detalles
]);

// Verificar si la inserción fue exitosa
if ($insertResult->getInsertedCount() > 0) {
    //echo "Insert successful";
    header('Location: ../preguntas.php');
    exit;
} else {
    echo "Insert failed";
}
?>
