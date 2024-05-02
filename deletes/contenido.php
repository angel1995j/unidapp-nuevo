<?php
require '../global.php'; 

$collection = $database->contenidoformacions; 

$id_contenido = $_GET['id_contenido'];

// Convertir el ID de string a ObjectId
$id = new MongoDB\BSON\ObjectId($id_contenido);

$result = $collection->deleteOne(['_id' => $id]);

if ($result->getDeletedCount() > 0) {
    //echo "Registro eliminado correctamente";
    header('Location: ../contenidos.php');
    exit;
} else {
    echo "No se pudo eliminar el registro";
    //header('Location: ../index.php');
    exit;
}
?>
