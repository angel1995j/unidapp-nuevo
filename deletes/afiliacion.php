<?php
//require '../header.php'; // Requiere el archivo header.php
require '../global.php'; 

$collection = $database->afiliacions; 



$id_afiliación = $_GET['id_afiliacion'];


// Convert the string id to an ObjectId
$id = new MongoDB\BSON\ObjectId($id_afiliación);

$collection->deleteOne(['_id' => $id]);


$result = $collection->deleteOne(['_id' => $id]);
if ($result->getDeletedCount() > 0) {
    //echo "Registro eliminado correctamente";
    header('Location: ../afiliaciones.php');
    exit;
} else {
    //echo "No se pudo eliminar el registro";
    header('Location: ../afiliaciones.php');
    exit;
}

require '../footer.php'; // Requiere el archivo footer.php
?>
