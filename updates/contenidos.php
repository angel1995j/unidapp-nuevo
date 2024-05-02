<?php
//require '../header.php'; // Requiere el archivo header.php
require '../global.php'; 

$collection = $database->contenidoformacions; 

$titulo = $_POST['titulo'];
$detalle = $_POST['detalle'];
$video = $_POST['video'];
$id_contenidoformacion = $_POST['id_contenidoformacion'];

// Convertir el ID de string a ObjectId
$id = new MongoDB\BSON\ObjectId($id_contenidoformacion);

// Actualizar el documento en la colección
$updateResult = $collection->updateOne(
    ['_id' => $id],
    ['$set' => [
        'titulo' => $titulo,
        'detalle' => $detalle,
        'video' => $video
    ]]
);

// Verificar si la actualización fue exitosa
if ($updateResult->getModifiedCount() > 0) {
    //echo "Update successful";
    header('Location: ../contenidos.php');
    exit;
} else {
    echo "Update failed";
}

require '../footer.php'; // Requiere el archivo footer.php
?>
