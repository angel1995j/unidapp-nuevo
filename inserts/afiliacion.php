<?php
require '../header.php'; // Requiere el archivo header.php
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
$archivada = $_POST['archivada'];
$afiliado = $_POST['afiliado'];

// Insert the document in the collection
$insertResult = $collection->insertOne([
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
]);

// Check if the insert was successful
if ($insertResult->getInsertedCount() > 0) {
    //echo "Insert successful";
    header('Location: ../afiliaciones.php');
    exit;
} else {
    echo "Insert failed";
}

require '../footer.php'; // Requiere el archivo footer.php
?>