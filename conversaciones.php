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
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
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
                        <form action="inserts/asesoria.php" method="POST">
                            <div class="form-group">
                                <label for="usuario">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" value="">
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" value="">
                            </div>
                            <div class="form-group">
                                <label for="file">File</label>
                                <input type="file" class="form-control-file" id="file" name="file">
                            </div>
                            <div class="form-group">
                                <label for="opciones">Opciones</label>
                                <input type="text" class="form-control" id="opciones" name="opciones" value="">
                            </div>
                            <div class="form-group">
                                <label for="archivada">Archivada</label>
                                <select class="form-control" id="archivada" name="archivada">
                                    <option value="si">Si</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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
                                $collection = $database->asesorias; 
                                $docsPerPage = 5;
                                $search = isset($_GET['search']) ? $_GET['search'] : '';

                                // Contar el total de usuarios que coinciden con la búsqueda
                                $totalUsers = $collection->distinct('usuario', ['descripcion' => new MongoDB\BSON\Regex($search, 'i')]);
                                $totalPages = ceil(count($totalUsers) / $docsPerPage);
                                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                $skip = ($page - 1) * $docsPerPage;

                                // Obtener los usuarios para la página actual
                                $currentUsers = array_slice($totalUsers, $skip, $docsPerPage);

                                // Obtener el último registro para cada usuario en la página actual
                                $pipeline = [
                                    ['$match' => ['usuario' => ['$in' => $currentUsers], 'descripcion' => new MongoDB\BSON\Regex($search, 'i')]],
                                    ['$sort' => ['_id' => -1]],
                                    ['$group' => [
                                        '_id' => '$usuario',
                                        'ultimoRegistro' => ['$first' => '$$ROOT']
                                    ]]
                                ];
                                $documents = $collection->aggregate($pipeline);

                                echo "<h3 class='text-center'>Asesorías</h3>";
                                echo "<div class='table-responsive'>";
                                echo "<table class='table'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>ID</th>";
                                echo "<th>Usuario</th>";
                                echo "<th>Descripción</th>";
                                echo "<th>Ver</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";

                                foreach ($documents as $document) {
                                    echo "<tr>";
                                    echo "<td>" . $document['ultimoRegistro']['_id'] . "</td>";
                                    echo "<td>" . $document['ultimoRegistro']['usuario'] . "</td>";
                                    echo "<td>" . substr($document['ultimoRegistro']['descripcion'], 0, 100) . "</td>";
                                    //echo "<td>" . $document['ultimoRegistro']['opciones'] . "</td>";
                                    //echo "<td>" . $document['ultimoRegistro']['archivada'] . "</td>";
                                    echo "<td><a href='conversacion.php?usuario=" . $document['ultimoRegistro']['usuario'] . "' class='btn btn-primary'>Ver</a></td>";
                                    echo "</tr>";
                                }

                                echo "</tbody>";
                                echo "</table>";
                                echo "</div>";

                                // Mostrar la paginación
                                echo '<nav aria-label="Page navigation">';
                                echo '<ul class="pagination justify-content-center">';

                                if ($page > 1) {
                                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&search=' . urlencode($search) . '" style="border: none; margin-left: -44%;">Anterior</a></li>';
                                }

                                for ($i = 1; $i <= $totalPages; $i++) {
                                    if ($i == $page) {
                                        echo '<li class="page-item active"><a class="page-link" href="?page=' . $i . '&search=' . urlencode($search) . '">' . $i . '</a></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '&search=' . urlencode($search) . '">' . $i . '</a></li>';
                                    }
                                }

                                if ($page < $totalPages) {
                                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&search=' . urlencode($search) . '" style="border: none; margin-left: 44%;">Siguiente</a></li>';
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
