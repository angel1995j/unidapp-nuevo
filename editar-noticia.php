<?php
require 'header.php'; // Requiere el archivo header.php
require 'global.php'; 

$collection = $database->noticias; 

$id_noticia = $_GET['id'];

// Convert the string id to an ObjectId
$id = new MongoDB\BSON\ObjectId($id_noticia);

// Consulta a la colección
$document = $collection->findOne(['_id' => $id]);

// Mostrar los datos
$titulo = $document['titulo'];
$contenido = isset($document['contenido']) ? $document['contenido'] : null;
?>

<!-- Incluir archivos de TinyMCE -->
<script src="https://cdn.tiny.cloud/1/r1kitv1wp3qt559ie6k1yhqm9b01zag23cnfocgskjc04k1o/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="updates/noticias.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $titulo; ?>">
                            <input type="hidden" class="form-control" id="id_noticia" name="id_noticia" value="<?php echo $id_noticia; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="contenido">Contenido</label>
                            <textarea class="form-control" id="contenido" name="contenido"><?php echo $contenido; ?></textarea>
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

<?php
require 'footer.php'; // Requiere el archivo footer.php
?>

<script>
    // Inicializar TinyMCE
    tinymce.init({
        selector: '#contenido',
        plugins: 'lists link image',
        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        height: 300 // Altura del editor
    });
</script>
