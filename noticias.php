<?php

// Configuración para manejo de errores
ini_set('display_errors', 1); // Desactiva la visualización de errores en pantalla
ini_set('log_errors', 1); // Activa el registro de errores en archivo

error_reporting(E_ALL);

require 'global.php'; 
require 'header.php'; 

?>
<!-- Incluir archivos de TinyMCE -->
<script src="https://cdn.tiny.cloud/1/r1kitv1wp3qt559ie6k1yhqm9b01zag23cnfocgskjc04k1o/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<div class="container mt-3" style="text-align: right;">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
        Nueva noticia
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                    <form action="inserts/noticias.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="titulo">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" value="">
                            </div>
                            <div class="form-group">
                                <label for="contenido">Contenido</label>
                                <!-- Cambiado el ID a "contenido" -->
                                <textarea class="form-control" id="contenido" name="contenido"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="imagen">Imagen</label>
                                <input type="file" class="form-control-file" id="imagen" name="imagen">
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
                                $collection = $database->noticias; 

                                // Obtener el número de página de la URL, o por defecto 1
                                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                                // Definir cuántos documentos mostrar por página
                                $docsPerPage = 5;

                                // Calcular la cantidad de documentos a saltar
                                $skip = ($page - 1) * $docsPerPage;

                                // Obtener el término de búsqueda de la URL
                                $search = isset($_GET['search']) ? $_GET['search'] : '';

                                // Consulta a la colección
                                $documents = $collection->find(['titulo' => new MongoDB\BSON\Regex($search, 'i')], ['skip' => $skip, 'limit' => $docsPerPage, 'sort' => ['_id' => -1]]);

                                // Mostrar los datos
                                echo "<h3 class='text-center'>Noticias</h3>";
                                echo "<div class='table-responsive'>";
                                echo "<table class='table'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>Título</th>";
                                echo "<th>Fecha de Creación</th>";
                                echo "<th>Acciones</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                foreach ($documents as $document) {
                                    echo "<tr>";
                                    echo "<td>" . $document['titulo'] . "</td>";
                                    //echo "<td>" . $document['contenido'] . "</td>";
                                    $createdAt = $document['createdAt']->toDateTime();
                                    $fecha = $createdAt->format('Y-m-d');
                                    echo "<td class='text-center'>" . $fecha . "</td>"; 

                                    echo "<td><a class='btn' href='editar-noticia.php?id=" . $document['_id'] . "'>Editar</a></td>";
                                    echo "<td><a class='btn' href='deletes/noticia.php?id_noticia=" . $document['_id'] . "' onclick='return confirm(\"¿Estás seguro de eliminar esta pregunta frecuente?\")'>Eliminar</a></td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                echo "</table>";
                                echo "</div>";

                                // Obtener el número total de documentos en la colección
                                $totalDocs = $collection->count(['titulo' => new MongoDB\BSON\Regex($search, 'i')]);

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

<script>
    // Inicializar TinyMCE en el campo de texto de contenido
    tinymce.init({
        selector: '#contenido', // Selector del campo de texto de contenido
        plugins: 'lists link image',
        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        height: 300 // Altura del editor
    });
</script>
