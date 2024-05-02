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
        Nuevo usuario
    </button>

    <a class="btn btn-warning" href="administradores.php">
        Administradores del panel
    </a>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form action="inserts/usuarios.php" method="POST">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="">
                            </div>
                            <div class="form-group">
                                <label for="afiliado">Afiliado</label>
                                <input type="text" class="form-control" id="afiliado" name="afiliado" value="">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="form-group">
                                <label for="sexo">Sexo</label>
                                <select class="form-control" id="sexo" name="sexo">
                                    <option value="masculino">Masculino</option>
                                    <option value="femenino">Femenino</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nacionalidad">Nacionalidad</label>
                                <input type="text" class="form-control" id="nacionalidad" name="nacionalidad">
                            </div>
                            <div class="form-group">
                                <label for="departamento">Departamento</label>
                                <input type="text" class="form-control" id="departamento" name="departamento">
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password">
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
                                $collection = $database->users; 

                                // Obtener el número de página de la URL, o por defecto 1
                                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                                // Definir cuántos documentos mostrar por página
                                $docsPerPage = 5;

                                // Calcular la cantidad de documentos a saltar
                                $skip = ($page - 1) * $docsPerPage;

                                // Obtener el término de búsqueda de la URL
                                $search = isset($_GET['search']) ? $_GET['search'] : '';

                                // Consulta a la colección
                                $documents = $collection->find(['nombre' => new MongoDB\BSON\Regex($search, 'i')], ['skip' => $skip, 'limit' => $docsPerPage, 'sort' => ['_id' => -1]]);

                                // Mostrar los datos
                                echo "<h3 class='text-center'>Usuarios</h3>";
                                echo "<div class='table-responsive'>";
                                echo "<table class='table'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>Nombre</th>";
                                echo "<th>Email</th>";
                                echo "<th>Teléfono</th>";
                                echo "<th>Acciones</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                foreach ($documents as $document) {
                                    echo "<tr>";
                                    echo "<td>" . $document['nombre'] . "</td>";
                                    echo "<td>" . $document['email'] . "</td>";
                                    echo "<td>" . $document['telefono'] . "</td>";
                                    echo "<td><a class='btn' href='deletes/usuarios.php?id_usuario=" . $document['_id'] . "' onclick='return confirm(\"¿Estás seguro de eliminar este usuaurio?\")'>Eliminar</a></td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                echo "</table>";
                                echo "</div>";

                                // Obtener el número total de documentos en la colección
                                $totalDocs = $collection->count(['nombre' => new MongoDB\BSON\Regex($search, 'i')]);

                                // Calcular el número total de páginas
                                $totalPages = ceil($totalDocs / $docsPerPage);

                                // Mostrar la paginación
                                echo '<nav aria-label="Page navigation">';
                                echo '<ul class="pagination justify-content-center">'; // Agregar la clase "justify-content-center" para centrar la paginación

                                // Mostrar enlace de página anterior
                                if ($page > 1) {
                                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&search=' . urlencode($search) . '" style="border: none; margin-left: -44%;">Anterior</a></li>';
                                }

                                // Mostrar enlaces de página
                                for ($i = max(1, $page - 5); $i <= min($page + 5, $totalPages); $i++) {
                                    if ($i == $page) {
                                        echo '<li class="page-item active"><a class="page-link" href="?page=' . $i . '&search=' . urlencode($search) . '">' . $i . '</a></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '&search=' . urlencode($search) . '">' . $i . '</a></li>';
                                    }
                                }

                                // Mostrar enlace de página siguiente
                                if ($page < $totalPages) {
                                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&search=' . urlencode($search) . '" style="border: none; margin-left: 44%;">Siguiente</a></li>';
                                }

                                echo '</ul>';
                                echo '</nav>';
                            } catch (Exception $e) {
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
