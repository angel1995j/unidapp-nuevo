<?php
// Configuración para manejo de errores
ini_set('display_errors', 1); // Desactiva la visualización de errores en pantalla
ini_set('log_errors', 1); // Activa el registro de errores en archivo

error_reporting(E_ALL);

require 'global.php'; 
require 'header.php'; 

?>

<div class="container-fluid py-4">
    <div class="row">    
        <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-12">

<?php

try {
    $collection = $database->conversations; 

    $id_asesoria = isset($_GET['id_asesoria']) ? $_GET['id_asesoria'] : '';

    if (!empty($id_asesoria) && preg_match('/^[a-f\d]{24}$/i', $id_asesoria)) {
        $id_asesoriaObjectId = new MongoDB\BSON\ObjectId($id_asesoria);
        $document = $collection->findOne(['_id' => $id_asesoriaObjectId]);

        if ($document) {
            echo "<h3 class='text-center'>Asesorias juridicas</h3>";
            echo "<div class='table-responsive'>";
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Fecha</th>";
            echo "<th>Mensaje</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            
            $usersCollection = $client->unidappDB->users;

            echo "<tr>";

            $userId = new MongoDB\BSON\ObjectId($document['created_by']->__toString());
            $user = $usersCollection->findOne(['_id' => $userId]);
            $userName = $user['nombre'];

            $timestamp = $document['updatedAt']->toDateTime()->getTimestamp();
            $date = date('Y-m-d H:i:s', $timestamp);
            echo "<td>" . $date . "</td>";

            echo "<td>";
            foreach (array_reverse($document['messages']->getArrayCopy()) as $message) {
                echo $message['message'] . ", ";
            }
            echo "</td>";
            echo "</tr>";
            
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "No se encontró el documento con el id proporcionado.";
        }
    } else {
        echo "El id proporcionado no es válido.";
    }
}
catch (Exception $e) {
    die("Error: " . $e);
}
?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require 'footer.php'; // Requiere el archivo header.php
?>