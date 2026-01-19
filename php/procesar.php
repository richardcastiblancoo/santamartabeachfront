
<?php
if (isset($_POST['enviar'])) {
    // 1. Configura tu número de teléfono (con código de país, sin el signo +)
    $telefono = "572025453611"; 

    // 2. Recibe los datos del formulario
    $nombre = $_POST['nombre'];
    $producto = $_POST['producto'];
    $mensaje_usuario = $_POST['mensaje'];

    // 3. Crea el cuerpo del mensaje
    $texto = "Hola, mi nombre es *{$nombre}* \n";
    $texto .= "Estoy interesado en: *{$producto}* \n";
    $texto .= "Detalles: {$mensaje_usuario}";

    // 4. Codifica el texto para la URL
    $mensaje_final = urlencode($texto);

    // 5. Construye la URL de WhatsApp
    $url = "https://api.whatsapp.com/send?phone={$telefono}&text={$mensaje_final}";

    // 6. Redirige al usuario
    header("Location: $url");
    exit();
}
?>