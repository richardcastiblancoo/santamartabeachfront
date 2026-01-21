<?php
require_once 'conexion_be.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Verificar si el email existe
    $stmt = $conn->prepare("SELECT id, usuario FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userId = $row['id'];
        $usuario = $row['usuario'];

        // Generar token único
        $token = bin2hex(random_bytes(32));
        $tokenHash = hash("sha256", $token);
        
        // Expiración en 1 hora
        $expiry = date("Y-m-d H:i:s", time() + 60 * 60);

        // Guardar hash y expiración en la base de datos
        $updateStmt = $conn->prepare("UPDATE usuarios SET reset_token_hash = ?, reset_token_expires_at = ? WHERE id = ?");
        $updateStmt->bind_param("ssi", $tokenHash, $expiry, $userId);
        
        if ($updateStmt->execute()) {
            // Construir el enlace de recuperación
            // Detectar protocolo y host dinámicamente
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $host = $_SERVER['HTTP_HOST'];
            $link = "$protocol://$host/auth/restablecer_password.php?token=$token&email=$email";

            // En un entorno real, aquí se enviaría el correo.
            // Por ahora, simularemos el envío y mostraremos el link en pantalla para pruebas.
            
            $to = $email;
            $subject = "Recuperación de Contraseña - Santamartabeachfront";
            $message = "Hola $usuario,\n\nHas solicitado restablecer tu contraseña. Haz clic en el siguiente enlace:\n$link\n\nEste enlace expirará en 1 hora.";
            $headers = "From: no-reply@santamartabeachfront.com";

            // Intentar enviar correo (puede fallar en local si no hay servidor SMTP configurado)
            @mail($to, $subject, $message, $headers);

            // Mostrar mensaje de éxito (y el link para pruebas)
            ?>
            <!DOCTYPE html>
            <html class="dark" lang="es">
            <head>
                <meta charset="utf-8" />
                <meta content="width=device-width, initial-scale=1.0" name="viewport" />
                <title>Correo Enviado</title>
                <script src="https://cdn.tailwindcss.com"></script>
                <script>
                    tailwind.config = { darkMode: "class" }
                </script>
            </head>
            <body class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center min-h-screen p-4">
                <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl max-w-md w-full text-center">
                    <div class="mb-4 text-green-500">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">¡Correo Enviado!</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Hemos enviado las instrucciones a <strong><?php echo htmlspecialchars($email); ?></strong>.</p>
                    
                    <div class="bg-yellow-100 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-700 p-4 rounded-lg mb-6 text-left">
                        <p class="text-xs text-yellow-800 dark:text-yellow-200 font-mono break-all">
                            <strong>[MODO DESARROLLO]</strong><br>
                            Si no tienes servidor de correo local, usa este enlace:<br>
                            <a href="<?php echo $link; ?>" class="underline text-blue-600 dark:text-blue-400 hover:text-blue-800"><?php echo $link; ?></a>
                        </p>
                    </div>

                    <a href="login.php" class="inline-block bg-blue-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-600 transition-colors">Volver al Login</a>
                </div>
            </body>
            </html>
            <?php
        } else {
            echo "Error al generar el token.";
        }
    } else {
        // Por seguridad, no decimos si el correo no existe, pero mostramos el mismo mensaje de éxito simulado
        // Opcionalmente podemos decir que no existe si preferimos UX sobre seguridad estricta en este caso.
        // Vamos a decir que no existe para facilitar pruebas al usuario.
        ?>
        <!DOCTYPE html>
        <html class="dark" lang="es">
        <head>
            <script src="https://cdn.tailwindcss.com"></script>
        </head>
        <body class="bg-gray-900 flex items-center justify-center min-h-screen text-white">
            <div class="text-center">
                <h2 class="text-xl font-bold text-red-500">Correo no encontrado</h2>
                <p class="mt-2">El correo <?php echo htmlspecialchars($email); ?> no está registrado.</p>
                <a href="recuperar_password.php" class="mt-4 inline-block text-blue-400 hover:underline">Intentar de nuevo</a>
            </div>
        </body>
        </html>
        <?php
    }
    $stmt->close();
}
$conn->close();
?>