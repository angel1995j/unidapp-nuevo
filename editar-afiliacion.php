<?php
require 'header.php'; // Requiere el archivo header.php
require 'global.php'; 

$collection = $database->afiliacions; 

$id_afiliación = $_GET['id'];

// Convert the string id to an ObjectId
$id = new MongoDB\BSON\ObjectId($id_afiliación);

// Consulta a la colección
$documents = $collection->find(['_id' => $id]);


// Mostrar los datos
//echo "<h1>Datos de " . $id . "</h1>";
foreach ($documents as $document) {

    $firmaAfiliacion = $document['firmaAfiliacion'];
    $nombre = $document['nombre'];
    $tipoDocumento = $document['tipoDocumento'];
    $numeroDocumento = $document['numeroDocumento'];
    $direccion = $document['direccion'];
    $telefonoFijo = $document['telefonoFijo'];
    $telefonoMovil = $document['telefonoMovil'];
    $correo = $document['correo'];
    $edad = $document['edad'];
    $ciudad = $document['ciudad'];
    $archivada = $document['archivada'];
    $afiliado = isset($document['afiliado']) ? $document['afiliado'] : null;
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Editar Afiliación</h5>
                    <form action="updates/afiliacion.php" method="POST">
                            <input type="hidden" class="form-control" id="firmaAfiliacion" name="firmaAfiliacion" value="<?php echo $firmaAfiliacion; ?>">
                            <input type="hidden" class="form-control" id="id_afiliación" name="id_afiliación" value="<?php echo $id_afiliación; ?>">
                      
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
                        </div>
                        <div class="form-group">
                            <label for="tipoDocumento">Tipo de Documento</label>
                            <input type="text" class="form-control" id="tipoDocumento" name="tipoDocumento" value="<?php echo $tipoDocumento; ?>">
                        </div>
                        <div class="form-group">
                            <label for="numeroDocumento">Número de Documento</label>
                            <input type="text" class="form-control" id="numeroDocumento" name="numeroDocumento" value="<?php echo $numeroDocumento; ?>">
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>">
                        </div>
                        <div class="form-group">
                            <label for="telefonoFijo">Teléfono Fijo</label>
                            <input type="text" class="form-control" id="telefonoFijo" name="telefonoFijo" value="<?php echo $telefonoFijo; ?>">
                        </div>
                        <div class="form-group">
                            <label for="telefonoMovil">Teléfono Móvil</label>
                            <input type="text" class="form-control" id="telefonoMovil" name="telefonoMovil" value="<?php echo $telefonoMovil; ?>">
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $correo; ?>">
                        </div>
                        <div class="form-group">
                            <label for="edad">Edad</label>
                            <input type="number" class="form-control" id="edad" name="edad" value="<?php echo $edad; ?>">
                        </div>
                        <div class="form-group">
                            <label for="ciudad">Ciudad</label>
                            <input type="text" class="form-control" id="ciudad" name="ciudad" value="<?php echo $ciudad; ?>">
                        </div>
                        <div class="form-group">
                            <label for="archivada">Archivada</label>
                            <select class="form-control" id="archivada" name="archivada">
                                <option value="si" <?php if($archivada == 'si') echo 'selected'; ?>>Si</option>
                                <option value="no" <?php if($archivada == 'no') echo 'selected'; ?>>No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="afiliado">Afiliado</label>
                            <select class="form-control" id="afiliado" name="afiliado">
                                <option value="si" <?php if($afiliado == 'si') echo 'selected'; ?>>Si</option>
                                <option value="no" <?php if($afiliado == 'no') echo 'selected'; ?>>No</option>
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

<?php
require 'footer.php'; // Requiere el archivo footer.php
?>
