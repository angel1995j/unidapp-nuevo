<?php
require '../global.php'; 

$collection = $database->noticias; 

$id_noticia = $_GET['id_noticia'];

// Convertir el ID de string a ObjectId
$id = new MongoDB\BSON\ObjectId($id_noticia);

$result = $collection->deleteOne(['_id' => $id]);

if ($result->getDeletedCount() > 0) {
    //echo "Registro eliminado correctamente";
    header('Location: ../noticias.php');
    exit;
} else {
    echo "No se pudo eliminar el registro";
    //header('Location: ../index.php');
    exit;
}
?>
