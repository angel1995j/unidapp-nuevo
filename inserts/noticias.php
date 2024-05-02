<?php
require '../global.php'; 

$collection = $database->noticias; 

$titulo = $_POST['titulo'];
$contenido = $_POST['contenido'];

// Procesar la imagen
$imagen = $_FILES["imagen"]["tmp_name"];

// Si se ha seleccionado una imagen
if ($imagen) {
    // Obtener la extensión de la imagen
    $extension = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
    
    // Generar un nombre único para la imagen
    $nombreImagen = uniqid() . '.' . $extension;
    
    // Ruta de destino para guardar la imagen
    $rutaImagen = '../assets/img/' . $nombreImagen;
    
    // Mover la imagen al directorio de destino
    if (move_uploaded_file($imagen, $rutaImagen)) {
        // Guardar la ruta completa de la imagen (incluyendo el dominio)
        $rutaImagenBD = 'http://143.198.136.60/unidapp/assets/img/' . $nombreImagen;
    } else {
        echo "Error al subir la imagen.";
        exit;
    }
}

// Insertar el documento en la colección de noticias
$insertResult = $collection->insertOne([
    'titulo' => $titulo,
    'contenido' => $contenido,
    'images' => [$rutaImagenBD], // Guardar la ruta completa de la imagen en la base de datos
    'createdAt' => new MongoDB\BSON\UTCDateTime(), // Insertar fecha y hora actual
    'updatedAt' => new MongoDB\BSON\UTCDateTime() // Insertar fecha y hora actual
]);

// Verificar si la inserción fue exitosa
if ($insertResult->getInsertedCount() > 0) {
    //echo "Insert successful";
    header('Location: ../noticias.php');
    exit;
} else {
    echo "Insert failed";
}
?>
