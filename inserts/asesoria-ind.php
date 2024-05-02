<?php

//require '../header.php'; // Requiere el archivo header.php
require '../global.php'; 

$collection = $database->asesorias; 

$usuario = $_POST['usuario'];
$descripcion = $_POST['descripcion'];
$opciones = 'admin';
$archivada = '';

// Insertar el documento en la colección
$insertResult = $collection->insertOne([
    'usuario' => $usuario,
    'descripcion' => $descripcion,
    'opciones' => $opciones,
    'archivada' => $archivada
]);

// Verificar si la inserción fue exitosa
if ($insertResult->getInsertedCount() > 0) {
    // Envío del correo electrónico
    $to = $usuario; 
    $subject = "¡Respondimos tu asesoría!";
    $message = "Te enviamos un mensaje en Unidapp. Gracias por tu preferencia.\nEl equipo de Unidapp";
    $headers = "From: no-responder@unidapp.com" . "\r\n" .
               "Reply-To: administracion@unidapp.com" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // Envío del correo electrónico
    mail($to, $subject, $message, $headers);

    // Redirección después de enviar el correo electrónico
    header('Location: ../conversacion.php?usuario=' . $usuario);
    exit;
} else {
    echo "Insert failed";
}

?>
