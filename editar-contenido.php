<?php
require 'header.php'; // Requiere el archivo header.php
require 'global.php'; 

$collection = $database->contenidoformacions; 

$id_contenidoformacion = $_GET['id'];

// Convert the string id to an ObjectId
$id = new MongoDB\BSON\ObjectId($id_contenidoformacion);

// Consulta a la colección
$documents = $collection->find(['_id' => $id]);

// Mostrar los datos
foreach ($documents as $document) {
    $titulo = $document['titulo'];
    $detalle = $document['detalle'];
    $video = $document['video'];
}
?>

<!-- Incluir archivos de TinyMCE -->
<script src="https://cdn.tiny.cloud/1/r1kitv1wp3qt559ie6k1yhqm9b01zag23cnfocgskjc04k1o/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="updates/contenidos.php" method="POST">
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $titulo; ?>">
                            <input type="hidden" class="form-control" id="id_contenidoformacion" name="id_contenidoformacion" value="<?php echo $id_contenidoformacion; ?>">
                        </div>
                        <div class="form-group">
                            <label for="detalle">Detalle</label>
                            <!-- Textarea se reemplaza con un editor TinyMCE -->
                            <textarea id="detalle" name="detalle"><?php echo $detalle; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="video">Video</label>
                            <input type="text" class="form-control" id="video" name="video" value="<?php echo $video; ?>">
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

<script>
    // Inicializar TinyMCE
    tinymce.init({
        selector: '#detalle',
        plugins: 'lists link image',
        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        height: 300 // Altura del editor
    });
</script>
