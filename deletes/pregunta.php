<?php
require '../global.php'; 

$collection = $database->preguntasfrecuentes; 

$id_pregunta = $_GET['id_pregunta'];

// Convertir el ID de string a ObjectId
$id = new MongoDB\BSON\ObjectId($id_pregunta);

$result = $collection->deleteOne(['_id' => $id]);

if ($result->getDeletedCount() > 0) {
    //echo "Registro eliminado correctamente";
    header('Location: ../preguntas.php');
    exit;
} else {
    echo "No se pudo eliminar el registro";
    //header('Location: ../index.php');
    exit;
}
?>
