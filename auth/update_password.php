<?php
require_once 'conexion_be.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        die("Las contraseñas no coinciden. <a href='restablecer_password.php?token=$token&email=$email'>Intentar de nuevo</a>");
    }

    $tokenHash = hash("sha256", $token);

    // Verificar token nuevamente
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ? AND reset_token_hash = ? AND reset_token_expires_at > NOW()");
    $stmt->bind_param("ss", $email, $tokenHash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userId = $row['id'];

        // Hashear nueva contraseña
        $newPasswordHash = password_hash($password, PASSWORD_DEFAULT);

        // Actualizar contraseña y limpiar token
        $updateStmt = $conn->prepare("UPDATE usuarios SET password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = ?");
        $updateStmt->bind_param("si", $newPasswordHash, $userId);

        if ($updateStmt->execute()) {
            // Éxito
            ?>
            <!DOCTYPE html>
            <html class="dark" lang="es">
            <head>
                <meta charset="utf-8" />
                <meta content="width=device-width, initial-scale=1.0" name="viewport" />
                <title>Contraseña Actualizada</title>
                <script src="https://cdn.tailwindcss.com"></script>
                <script>
                    tailwind.config = { darkMode: "class" }
                </script>
            </head>
            <body class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center min-h-screen p-4">
                <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl max-w-md w-full text-center">
                    <div class="mb-4 text-green-500">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">¡Contraseña Actualizada!</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Tu contraseña ha sido restablecida exitosamente. Ahora puedes iniciar sesión con tus nuevas credenciales.</p>
                    
                    <a href="login.php" class="inline-block bg-primary bg-blue-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-600 transition-colors">Ir al Login</a>
                </div>
            </body>
            </html>
            <?php
        } else {
            echo "Error al actualizar la contraseña: " . $conn->error;
        }
    } else {
        echo "Error: El enlace de recuperación es inválido o ha expirado.";
    }
    $stmt->close();
}
$conn->close();
?>