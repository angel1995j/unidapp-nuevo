<?php
require 'header.php'; // Requiere el archivo header.php
require 'global.php'; 

$collection = $database->preguntasfrecuentes; 

$id_pregunta = $_GET['id'];

// Convert the string id to an ObjectId
$id = new MongoDB\BSON\ObjectId($id_pregunta);

// Consulta a la colección
$documents = $collection->find(['_id' => $id]);


// Mostrar los datos
//echo "<h1>Datos de " . $id . "</h1>";
foreach ($documents as $document) {

    $titulo = $document['titulo'];
    $detalles = isset($document['detalles']) ? $document['detalles'] : null;
}?>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    
                    <form action="updates/preguntas.php" method="POST">
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $titulo; ?>">
                            <input type="hidden" class="form-control" id="id_pregunta" name="id_pregunta" value="<?php echo $id_pregunta; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="detalle">Detalle</label>
                            <textarea class="form-control" id="detalles" name="detalles"><?php echo $detalles; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require 'footer.php'; // Requiere el archivo footer.php
?>

