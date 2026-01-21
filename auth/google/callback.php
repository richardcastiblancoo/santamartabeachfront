<?php
session_start();
include '../../auth/conexion_be.php';
require_once '../../auth/google_config.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // 1. Intercambiar el código por un token de acceso (cURL manual)
    $token_url = 'https://oauth2.googleapis.com/token';
    $post_data = [
        'code' => $code,
        'client_id' => GOOGLE_CLIENT_ID,
        'client_secret' => GOOGLE_CLIENT_SECRET,
        'redirect_uri' => GOOGLE_REDIRECT_URL,
        'grant_type' => 'authorization_code'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // IMPORTANTE: En producción, deberías tener certificados SSL válidos. 
    // Para XAMPP local a veces es necesario desactivar la verificación si no está configurado.
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    $response = curl_exec($ch);
    
    if(curl_errno($ch)){
        die('Error cURL: ' . curl_error($ch));
    }
    curl_close($ch);

    $token_data = json_decode($response, true);

    if (isset($token_data['access_token'])) {
        $access_token = $token_data['access_token'];

        // 2. Obtener información del usuario de Google
        $user_info_url = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $access_token;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $user_info_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $user_info_response = curl_exec($ch);
        curl_close($ch);

        $google_user = json_decode($user_info_response, true);

        // Datos del usuario
        $email = mysqli_real_escape_string($conn, $google_user['email']);
        $google_id = mysqli_real_escape_string($conn, $google_user['id']);
        $nombre = mysqli_real_escape_string($conn, isset($google_user['given_name']) ? $google_user['given_name'] : 'Usuario');
        $apellido = mysqli_real_escape_string($conn, isset($google_user['family_name']) ? $google_user['family_name'] : 'Google');
        $imagen = mysqli_real_escape_string($conn, isset($google_user['picture']) ? $google_user['picture'] : '');

        // 3. Verificar si el usuario ya existe en la base de datos
        
        // Verificar si la columna google_id existe antes de usarla
        $col_check = mysqli_query($conn, "SHOW COLUMNS FROM usuarios LIKE 'google_id'");
        $google_id_exists = (mysqli_num_rows($col_check) > 0);
        
        // Estrategia de búsqueda:
        // 1. Buscar por Email (siempre seguro)
        $check_query = "SELECT * FROM usuarios WHERE email = '$email'";
        $result = mysqli_query($conn, $check_query);
        
        // 2. Si no se encuentra por email y tenemos google_id column, buscar por ID
        if (mysqli_num_rows($result) == 0 && $google_id_exists) {
            $check_query = "SELECT * FROM usuarios WHERE google_id = '$google_id'";
            $result = mysqli_query($conn, $check_query);
        }

        if (mysqli_num_rows($result) > 0) {
            // --- USUARIO EXISTENTE ---
            $row = mysqli_fetch_assoc($result);
            
            // Actualizar google_id si falta
            if ($google_id_exists && empty($row['google_id'])) {
                $update_sql = "UPDATE usuarios SET google_id = '$google_id' WHERE id = " . $row['id'];
                mysqli_query($conn, $update_sql);
            }
            
            // SIEMPRE actualizar la imagen si viene de Google para asegurar que tenemos la URL más reciente
            // y corregir posibles URLs truncadas antiguas.
            if (!empty($imagen)) {
                 $update_img = "UPDATE usuarios SET imagen = '$imagen' WHERE id = " . $row['id'];
                 mysqli_query($conn, $update_img);
                 $row['imagen'] = $imagen;
            }

            // Asegurar que si es usuario de Google, esté marcado como verificado
            if ($google_id_exists) {
                // Verificar si existe columna is_verified
                $check_ver = mysqli_query($conn, "SHOW COLUMNS FROM usuarios LIKE 'is_verified'");
                if (mysqli_num_rows($check_ver) > 0) {
                     $update_ver = "UPDATE usuarios SET is_verified = 1 WHERE id = " . $row['id'];
                     mysqli_query($conn, $update_ver);
                }
            }

            // Iniciar sesión
            $_SESSION['id'] = $row['id'];
            $_SESSION['usuario'] = $row['usuario'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['apellido'] = $row['apellido'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['imagen'] = $row['imagen'];
            $_SESSION['rol'] = $row['rol'];
            $_SESSION['tema'] = isset($row['tema']) ? $row['tema'] : '#13a4ec';

            // Redirección
            // Si el usuario quiere ir SIEMPRE al dashboard de huesped, usamos esa ruta.
            // Si es Admin, generalmente debería ir al dashboard admin, pero respetaremos la solicitud
            // de "la idea era que me dirija a /php/dashboard-huesped/huesped.php".
            // Sin embargo, para mantener coherencia, si es admin lo mandamos al admin, si no al huesped.
            // Voy a usar rutas absolutas para evitar problemas.
            
            if ($row['rol'] == 'Admin') {
                header("location: /php/dashboard-admin/dashboard.php");
            } else {
                header("location: /php/dashboard-huesped/huesped.php");
            }
            exit;

        } else {
            // --- USUARIO NUEVO (REGISTRO) ---
            
            // Generar nombre de usuario único
            $base_username = strtolower(explode('@', $email)[0]);
            $username = $base_username;
            $counter = 1;
            
            while(mysqli_num_rows(mysqli_query($conn, "SELECT id FROM usuarios WHERE usuario = '$username'")) > 0) {
                $username = $base_username . $counter;
                $counter++;
            }

            $password = password_hash(bin2hex(random_bytes(10)), PASSWORD_DEFAULT);
            $rol = 'Huesped';

            if ($google_id_exists) {
                $insert_sql = "INSERT INTO usuarios (nombre, apellido, usuario, email, password, rol, google_id, imagen) 
                               VALUES ('$nombre', '$apellido', '$username', '$email', '$password', '$rol', '$google_id', '$imagen')";
            } else {
                $insert_sql = "INSERT INTO usuarios (nombre, apellido, usuario, email, password, rol, imagen) 
                               VALUES ('$nombre', '$apellido', '$username', '$email', '$password', '$rol', '$imagen')";
            }
            
            if (mysqli_query($conn, $insert_sql)) {
                $user_id = mysqli_insert_id($conn);
                
                $_SESSION['id'] = $user_id;
                $_SESSION['usuario'] = $username;
                $_SESSION['nombre'] = $nombre;
                $_SESSION['apellido'] = $apellido;
                $_SESSION['email'] = $email;
                $_SESSION['imagen'] = $imagen;
                $_SESSION['rol'] = $rol;
                $_SESSION['tema'] = '#13a4ec';

                header("location: /php/dashboard-huesped/huesped.php");
                exit;
            } else {
                echo "Error al registrar usuario: " . mysqli_error($conn);
            }
        }

    } else {
        echo "Error obteniendo token de acceso.<br>";
        echo "<a href='../login.php'>Volver</a>";
    }
} else {
    header('Location: ../../auth/login.php');
}
?>
