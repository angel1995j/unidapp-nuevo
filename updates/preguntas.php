<?php
//require '../header.php'; // Requiere el archivo header.php
require '../global.php'; 

$collection = $database->preguntasfrecuentes; 

$titulo = $_POST['titulo'];
$detalle = $_POST['detalle'];
$id_pregunta = $_POST['id_pregunta'];

// Convertir el ID de string a ObjectId
$id = new MongoDB\BSON\ObjectId($id_pregunta);

// Actualizar el documento en la colección
$updateResult = $collection->updateOne(
    ['_id' => $id],
    ['$set' => [
        'titulo' => $titulo,
        'detalle' => $detalle
    ]]
);

// Verificar si la actualización fue exitosa
if ($updateResult->getModifiedCount() > 0) {
    //echo "Update successful";
    header('Location: ../preguntas.php');
    exit;
} else {
    echo "Update failed";
}

require '../footer.php'; // Requiere el archivo footer.php
?>
