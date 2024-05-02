<?php
// Configuración para manejo de errores
ini_set('display_errors', 1); // Desactiva la visualización de errores en pantalla
ini_set('log_errors', 1); // Activa el registro de errores en archivo

error_reporting(E_ALL);

require 'global.php'; 
require 'header.php'; 



?>


<div class="container mt-3" style="text-align: right;">
<!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" >
    Nuevo registro
</button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
            <div class="card">
                                <div class="card-body">
                                <form action="inserts/afiliacion.php" method="POST">
                                    <div class="form-group">
                                        <label for="firmaAfiliacion">Firma Afiliación</label>
                                        <input type="text" class="form-control" id="firmaAfiliacion" name="firmaAfiliacion" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="tipoDocumento">Tipo de Documento</label>
                                        <input type="text" class="form-control" id="tipoDocumento" name="tipoDocumento" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="numeroDocumento">Número de Documento</label>
                                        <input type="text" class="form-control" id="numeroDocumento" name="numeroDocumento" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="direccion">Dirección</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="telefonoFijo">Teléfono Fijo</label>
                                        <input type="text" class="form-control" id="telefonoFijo" name="telefonoFijo" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="telefonoMovil">Teléfono Móvil</label>
                                        <input type="text" class="form-control" id="telefonoMovil" name="telefonoMovil" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="correo">Correo</label>
                                        <input type="email" class="form-control" id="correo" name="correo" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="edad">Edad</label>
                                        <input type="number" class="form-control" id="edad" name="edad" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="ciudad">Ciudad</label>
                                        <input type="text" class="form-control" id="ciudad" name="ciudad" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="archivada">Archivada</label>
                                        <select class="form-control" id="archivada" name="archivada">
                                            <option value="si">Si</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="afiliado">Afiliado</label>
                                        <select class="form-control" id="afiliado" name="afiliado">
                                            <option value="si">Si</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </form>
                                      
                                </div>
                                </div>
                        </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Modal -->




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
    
    $collection = $database->afiliacions; 

    // Get the page number from the URL, or default to 1
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // Define how many documents to display per page
    $docsPerPage = 5;

    // Calculate the skip amount
    $skip = ($page - 1) * $docsPerPage;

    // Get the search term from the URL
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Consulta a la colección
    $documents = $collection->find(['nombre' => new MongoDB\BSON\Regex($search, 'i')], ['skip' => $skip, 'limit' => $docsPerPage, 'sort' => ['_id' => -1]]);

    // Mostrar los datos
    echo "<h3 class='text-center'>Afiliaciones</h3>";
    echo "<div class='table-responsive'>";
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Nombre</th>";
    echo "<th>Correo</th>";
    echo "<th>Editar</th>";
    echo "<th>Eliminar</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($documents as $document) {
        echo "<tr>";
        echo "<td>" . $document['_id'] . "</td>";
        echo "<td>" . $document['nombre'] . "</td>";
        echo "<td>" . $document['correo'] . "</td>";
        echo "<td><a href='editar-afiliacion.php?id=" . $document['_id'] . "'>Editar</a></td>";
        echo "<td><a class='btn' href='deletes/afiliacion.php?id_afiliacion=" . $document['_id'] . "' onclick='return confirm(\"¿Estás seguro de eliminar esta pregunta frecuente?\")'>Eliminar</a></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    // Get the total number of documents in the collection
    $totalDocs = $collection->count(['nombre' => new MongoDB\BSON\Regex($search, 'i')]);

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