<?php
// Configuración para manejo de errores
ini_set('display_errors', 1); // Desactiva la visualización de errores en pantalla
ini_set('log_errors', 1); // Activa el registro de errores en archivo

error_reporting(E_ALL);

require 'global.php'; 
require 'header.php'; 
?>

<style>
    .mensaje {
    border: 1px solid red;
    margin-top: 4%;
    width: 91%;
    margin-left: 4%;
    padding-top: 1%;
    padding-left: 2%;
    padding-bottom: 1%;
    padding-right: 2%;
    border-radius: 19px;
    text-align: right;
}
</style>

<div class="container mt-3" style="text-align: right;">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
        Nueva respuesta
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $correo = isset($_GET['usuario']) ? $_GET['usuario'] : '';
                        ?>
                        <form action="inserts/asesoria-ind.php" method="POST">
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $correo; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
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
                </div>

                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-12">
                            <?php
                            try {
                                $collection = $database->asesorias; 
                                $search = isset($_GET['search']) ? $_GET['search'] : '';
                                $usuario = isset($_GET['usuario']) ? $_GET['usuario'] : '';

                                // Construir la consulta para traer todos los registros del usuario
                                $filter = [
                                    'usuario' => $usuario,
                                    'descripcion' => new MongoDB\BSON\Regex($search, 'i')
                                ];

                                // Obtener los documentos para el usuario y la búsqueda especificados
                                $documents = $collection->find($filter);

                                echo "<h4 class='text-center'>Mensajes del usuario: " . $usuario. "</h4>";

                                foreach ($documents as $document) {
                                    $remitente = $document['opciones'];
                                    if ($remitente == 'admin') {
                                        echo "<div class='row mensaje' style='background-color: red;color:white;'>";
                                    } else {
                                        echo "<div class='row mensaje'>";
                                    }
                                    echo "<small style='font-size:11px;'>" . $document['_id'] . "</small>";
                                    //echo "<td>" . $document['usuario'] . "</td>";
                                    echo "<div>" . substr($document['descripcion'], 0, 100) . "</div>";
                                    echo "</div>";
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
