<?php
require_once 'google_config.php';

// Verificar que se hayan configurado las credenciales
if (GOOGLE_CLIENT_ID === 'PON_AQUI_TU_CLIENT_ID') {
    die('Por favor configura el CLIENT_ID en auth/google_config.php');
}

$params = [
    'response_type' => 'code',
    'client_id' => GOOGLE_CLIENT_ID,
    'redirect_uri' => GOOGLE_REDIRECT_URL,
    'scope' => 'email profile',
    'access_type' => 'online'
];

$url = 'https://accounts.google.com/o/oauth2/auth?' . http_build_query($params);
header('Location: ' . $url);
exit;
?>
