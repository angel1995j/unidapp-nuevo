<?php
//require '../header.php'; // Requiere el archivo header.php
require '../global.php'; 

$collection = $database->afiliacions; 


$firmaAfiliacion = $_POST['firmaAfiliacion'];
$nombre = $_POST['nombre'];
$tipoDocumento = $_POST['tipoDocumento'];
$numeroDocumento = $_POST['numeroDocumento'];
$direccion = $_POST['direccion'];
$telefonoFijo = $_POST['telefonoFijo'];
$telefonoMovil = $_POST['telefonoMovil'];
$correo = $_POST['correo'];
$edad = $_POST['edad'];
$ciudad = $_POST['ciudad'];
$id_afiliación = $_POST['id_afiliación'];
$archivada = $_POST['archivada'];
$afiliado = $_POST['afiliado'];


// Convert the string id to an ObjectId
$id = new MongoDB\BSON\ObjectId($id_afiliación);

// Consulta a la colección
$documents = $collection->find(['_id' => $id]);


// Update the document in the collection
$updateResult = $collection->updateOne(
    ['_id' => $id],
    ['$set' => [
        'firmaAfiliacion' => $firmaAfiliacion,
        'nombre' => $nombre,
        'tipoDocumento' => $tipoDocumento,
        'numeroDocumento' => $numeroDocumento,
        'direccion' => $direccion,
        'telefonoFijo' => $telefonoFijo,
        'telefonoMovil' => $telefonoMovil,
        'correo' => $correo,
        'edad' => $edad,
        'ciudad' => $ciudad,
        'archivada' => $archivada,
        'afiliado' => $afiliado
    ]]
);

// Check if the update was successful
if ($updateResult->getModifiedCount() > 0) {
    //echo "Update successful";
    header('Location: ../afiliaciones.php');
    exit;
} else {
    echo "Update failed";
}

require '../footer.php'; // Requiere el archivo footer.php
?>
