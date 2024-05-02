<?php
// Configuración para manejo de errores
ini_set('display_errors', 1); // Desactiva la visualización de errores en pantalla
ini_set('log_errors', 1); // Activa el registro de errores en archivo

error_reporting(E_ALL);

require 'vendor/autoload.php'; // Requiere el autoload generado por Composer

use MongoDB\Client;

try {
    // Conexión a MongoDB
    $client = new Client("mongodb+srv://uniAdmin:2.die.4Kele1489.@cluster0.vfeys.mongodb.net/unidappDB?retryWrites=true&w=majority");
    
    $database = $client->unidappDB;
    //$collection = $database->afiliacions; 

} catch (Exception $e) {
    // Manejo de excepciones
    echo 'Error: ' . $e->getMessage();
    // Además, puedes registrar el error en un archivo de registro si lo deseas
    error_log('Error en MongoDB: ' . $e->getMessage());
}

?>