<?php
require_once __DIR__ . '/env_loader.php';

// Credenciales de Google API
// Obtener en: https://console.cloud.google.com/apis/credentials
define('GOOGLE_CLIENT_ID', getenv('GOOGLE_CLIENT_ID'));
define('GOOGLE_CLIENT_SECRET', getenv('GOOGLE_CLIENT_SECRET'));
define('GOOGLE_REDIRECT_URL', getenv('GOOGLE_REDIRECT_URL'));
?>
