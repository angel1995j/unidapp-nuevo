<?php
require '../global.php'; 

$collection = $database->contenidoformacions; 

$titulo = $_POST['titulo'];
$detalle = $_POST['detalle'];
$video = $_POST['video'];

// Insertar el documento en la colección
$insertResult = $collection->insertOne([
    'titulo' => $titulo,
    'detalle' => $detalle,
    'video' => $video
]);

// Verificar si la inserción fue exitosa
if ($insertResult->getInsertedCount() > 0) {
    //echo "Insert successful";
    header('Location: ../contenidos.php');
    exit;
} else {
    echo "Insert failed";
}
?>
