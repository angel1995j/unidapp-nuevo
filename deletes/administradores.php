<?php
require '../global.php'; 

$collection = $database->usuarios; 

$id_usuario = $_GET['id_usuario'];

// Convertir el ID de string a ObjectId
$id = new MongoDB\BSON\ObjectId($id_usuario);

$result = $collection->deleteOne(['_id' => $id]);

if ($result->getDeletedCount() > 0) {
    //echo "Registro eliminado correctamente";
    header('Location: ../administradores.php');
    exit;
} else {
    echo "No se pudo eliminar el registro";
    //header('Location: ../index.php');
    exit;
}
?>

?>
