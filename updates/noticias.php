<?php
require '../global.php'; 

$collection = $database->noticias; 

$id_noticia = $_POST['id_noticia'];
$titulo = $_POST['titulo'];
$contenido = $_POST['contenido'];

// Procesar la imagen si se ha proporcionado
if (!empty($_FILES["imagen"]["tmp_name"])) {
    // Obtener la extensión de la imagen
    $extension = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
    
    // Generar un nombre único para la imagen
    $nombreImagen = uniqid() . '.' . $extension;
    
    // Ruta de destino para guardar la imagen
    $rutaImagen = '../assets/img/' . $nombreImagen;
    
    // Mover la imagen al directorio de destino
    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaImagen)) {
        echo "Error al subir la imagen.";
        exit;
    }
    
    // Obtener la URL completa de la imagen
    $rutaImagenBD = 'http://143.198.136.60/unidapp/assets/img/' . $nombreImagen;
} else {
    // Si no se proporciona una nueva imagen, mantener la imagen existente
    $rutaImagenBD = null;
}

// Actualizar el documento en la colección de noticias
$updateResult = $collection->updateOne(
    ['_id' => new MongoDB\BSON\ObjectId($id_noticia)],
    ['$set' => [
        'titulo' => $titulo,
        'contenido' => $contenido,
        'updatedAt' => new MongoDB\BSON\UTCDateTime() // Actualizar fecha y hora de actualización
    ]]
);

// Verificar si la actualización fue exitosa
if ($updateResult->getModifiedCount() > 0) {
    //echo "Update successful";
    header('Location: ../noticias.php');
    exit;
} else {
    echo "Update failed";
}
?>
