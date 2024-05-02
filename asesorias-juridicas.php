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


        <div class="col-12 mt-2" style="text-align: right; padding-right: 1%;">
            <!-- Formulario de búsqueda -->
            <form method="GET">
                <input type="text" name="search" placeholder="Buscar...">
                <input type="submit" value="Buscar" class="btn btn-primary btn-sm mt-3">
            </form>
        </div>
        
        


         



            <div class="card-body p-3">
              <div class="row">
                <div class="col-12">

<?php

try {
    $collection = $database->conversations; 
    

    // Get the page number from the URL, or default to 1
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // Define how many documents to display per page
    $docsPerPage = 10;

    // Calculate the skip amount
    $skip = ($page - 1) * $docsPerPage;

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    if (!empty($search) && preg_match('/^[a-f\d]{24}$/i', $search)) {
        $searchObjectId = new MongoDB\BSON\ObjectId($search);
        $totalDocs = $collection->count(['created_by' => $searchObjectId]);
    } else {
        $totalDocs = $collection->count();
    }
    
   


    $cursor = $collection->find([], ['skip' => $skip, 'limit' => $docsPerPage, 'sort' => ['_id' => -1]]);
    

        // Convertir los resultados a un array
        $documents = iterator_to_array($cursor);


        // Imprimir los datos devueltos
       // echo "<pre>";
       // var_dump(iterator_to_array($documents));
       // echo "</pre>";

    // Mostrar los datos
    echo "<h3 class='text-center'>Asesorias juridicas</h3>";
    echo "<div class='table-responsive'>";
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Fecha</th>";
    echo "<th>Mensaje</th>";
    echo "<th>Ver</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
   
    $usersCollection = $client->unidappDB->users;

    foreach ($documents as $document) {
        echo "<tr>";


        $userId = new MongoDB\BSON\ObjectId($document['created_by']->__toString());
        $user = $usersCollection->findOne(['_id' => $userId]);
        $userName = $user['nombre'];

       // echo "<td>" . $userName . "</td>";
    

        $timestamp = $document['updatedAt']->toDateTime()->getTimestamp();
        $date = date('Y-m-d H:i:s', $timestamp);
        echo "<td>" . $date . "</td>";

        echo "<td>";
        foreach (array_reverse($document['messages']->getArrayCopy()) as $message) {
            echo $message['message'] . ", ";
        }
        echo "</td>";
        echo "<td><a href='asesoria.php?id_asesoria=" . $document['_id'] . "'>Editar</a></td>";
        echo "</tr>";
    }

    
    
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    // Get the total number of documents in the collection




    // Calculate the total number of pages
    $totalPages = ceil($totalDocs / $docsPerPage);

    // Display the pagination
    echo '<nav aria-label="Page navigation">';
    echo '<ul class="pagination justify-content-center">'; // Add the "justify-content-center" class to center the pagination

    // Display previous page link
    if ($page > 1) {
        echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&search=' . urlencode($search) . '" style="border: none;
        margin-left: -44%;">Anterior</a></li>';
    }

    // Display page links
    for ($i = max(1, $page - 5); $i <= min($page + 5, $totalPages); $i++) {
        if ($i == $page) {
            echo '<li class="page-item active"><a class="page-link" href="?page=' . $i . '&search=' . urlencode($search) . '">' . $i . '</a></li>';
        } else {
            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '&search=' . urlencode($search) . '">' . $i . '</a></li>';
        }
    }

    // Display next page link
    if ($page < $totalPages) {
        echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&search=' . urlencode($search) . '" style="border: none;
        margin-left: 44%;">Siguiente</a></li>';
    }

    echo '</ul>';
    echo '</nav>';
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