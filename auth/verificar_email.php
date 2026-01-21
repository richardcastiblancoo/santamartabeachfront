<?php
include 'conexion_be.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Buscar usuario con ese token
    $sql = "SELECT * FROM usuarios WHERE token = '$token' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        if ($user['is_verified'] == 1) {
             echo '
                <script>
                    alert("Tu cuenta ya ha sido verificada anteriormente. Puedes iniciar sesión.");
                    window.location = "login.php";
                </script>
            ';
        } else {
            // Verificar cuenta
            $update_sql = "UPDATE usuarios SET is_verified = 1 WHERE token = '$token'";
            if (mysqli_query($conn, $update_sql)) {
                 echo '
                    <script>
                        alert("¡Cuenta verificada exitosamente! Ahora puedes iniciar sesión.");
                        window.location = "login.php";
                    </script>
                ';
            } else {
                echo "Error al verificar la cuenta.";
            }
        }
    } else {
        echo '
            <script>
                alert("Token inválido o expirado.");
                window.location = "login.php";
            </script>
        ';
    }
} else {
    echo "No se proporcionó ningún token.";
}
?>