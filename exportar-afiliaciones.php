<?php

// Configuración para manejo de errores
ini_set('display_errors', 1); // Desactiva la visualización de errores en pantalla
ini_set('log_errors', 1); // Activa el registro de errores en archivo

error_reporting(E_ALL);

require 'global.php'; 

// Nombre del archivo CSV a generar
$csvFile = 'usuarios.csv';

// Abrir el archivo CSV en modo escritura
$file = fopen($csvFile, 'w');

// Escribir la cabecera en el archivo CSV
$header = ['_id', 'rol', 'estado', 'facebook', 'pagado', 'email', 'password', 'nombre', 'telefono', 'img', 'created_at', 'updatedAt'];
fputcsv($file, $header);

try {
    // Obtener la colección de usuarios
    $collection = $database->users;
    
    // Consulta a la colección
    $documents = $collection->find();
    
    // Escribir cada documento en el archivo CSV
    foreach ($documents as $document) {

        // Verificar si los campos están definidos antes de acceder a ellos
        $facebook = isset($document['facebook']) ? $document['facebook'] : '';
        $created_at = isset($document['created_at']) ? $document['created_at'] : '';
        $updatedAt = isset($document['updatedAt']) ? $document['updatedAt'] : '';
        $img = isset($document['img']) ? $document['img'] : '';

        // Preparar los datos para escribir en el CSV
        $rowData = [
            $document['_id'],
            $document['rol'],
            $document['estado'],
            $facebook,
            $document['pagado'],
            $document['email'],
            $document['password'],
            $document['nombre'],
            $document['telefono'],
            $img,
            $created_at,
            $updatedAt
        ];
        
        // Escribir la fila en el archivo CSV
        fputcsv($file, $rowData);
    }
    
    // Cerrar el archivo CSV
    fclose($file);
    
    echo "<div style='text-align:center; margin-top:2%;'>";
    echo "<h1>Exportación completada. Puedes descargar el archivo <a href='$csvFile' download>aquí</a></h1>";
    echo "<h3>También puedes <a href='exportar.php'>Volver a sección exportación</a></h3>";
    echo "</div>";
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

?>
