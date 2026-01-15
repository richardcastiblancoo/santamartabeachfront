<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth/conexion_be.php';

echo "<h1>Diagnóstico de Base de Datos</h1>";

// 1. Verificar Usuarios
$res_users = $conn->query("SELECT count(*) as total FROM usuarios");
$users_count = $res_users ? $res_users->fetch_assoc()['total'] : 0;
echo "Usuarios encontrados: $users_count<br>";

if ($users_count > 0) {
    $u = $conn->query("SELECT id, nombre, email FROM usuarios LIMIT 3");
    echo "<pre>Ejemplos de usuarios:\n";
    while($row = $u->fetch_assoc()) print_r($row);
    echo "</pre>";
}

// 2. Verificar Apartamentos
$res_apt = $conn->query("SELECT count(*) as total FROM apartamentos");
$apt_count = $res_apt ? $res_apt->fetch_assoc()['total'] : 0;
echo "Apartamentos encontrados: $apt_count<br>";

if ($apt_count > 0) {
    $a = $conn->query("SELECT id, titulo FROM apartamentos LIMIT 3");
    echo "<pre>Ejemplos de apartamentos:\n";
    while($row = $a->fetch_assoc()) print_r($row);
    echo "</pre>";
}

// 3. Verificar Reservas
$res_res = $conn->query("SELECT count(*) as total FROM reservas");
$res_count = $res_res ? $res_res->fetch_assoc()['total'] : 0;
echo "Reservas encontradas: $res_count<br>";

if ($res_count > 0) {
    $r = $conn->query("SELECT * FROM reservas LIMIT 3");
    echo "<pre>Ejemplos de reservas:\n";
    while($row = $r->fetch_assoc()) print_r($row);
    echo "</pre>";
} else {
    echo "<b>La tabla de reservas está vacía.</b><br>";
    
    // Intentar insertar datos de prueba si hay usuarios y apartamentos
    if ($users_count > 0 && $apt_count > 0) {
        echo "Insertando datos de prueba...<br>";
        
        $u_id = $conn->query("SELECT id FROM usuarios LIMIT 1")->fetch_assoc()['id'];
        $a_id = $conn->query("SELECT id, precio FROM apartamentos LIMIT 1")->fetch_assoc();
        
        $precio = $a_id['precio'];
        $apartamento_id = $a_id['id'];
        
        $sql_insert = "INSERT INTO reservas (usuario_id, apartamento_id, fecha_inicio, fecha_fin, total, estado) VALUES 
        ($u_id, $apartamento_id, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 3 DAY), " . ($precio * 3) . ", 'Pendiente'),
        ($u_id, $apartamento_id, DATE_ADD(CURDATE(), INTERVAL 5 DAY), DATE_ADD(CURDATE(), INTERVAL 10 DAY), " . ($precio * 5) . ", 'Confirmada')";
        
        if ($conn->query($sql_insert)) {
            echo "Datos de prueba insertados correctamente.<br>";
        } else {
            echo "Error insertando datos: " . $conn->error . "<br>";
        }
    } else {
        echo "No se pueden insertar datos de prueba porque faltan usuarios o apartamentos.<br>";
    }
}

// 4. Probar la consulta JOIN exacta que usa reservas.php
echo "<h3>Probando consulta JOIN principal:</h3>";
$query = "SELECT r.*, u.nombre, u.apellido, u.email, u.imagen as usuario_imagen, 
          a.titulo as apartamento_titulo, a.imagen_principal as apartamento_imagen 
          FROM reservas r 
          JOIN usuarios u ON r.usuario_id = u.id 
          JOIN apartamentos a ON r.apartamento_id = a.id 
          ORDER BY r.fecha_creacion DESC";
$result = $conn->query($query);

if ($result) {
    echo "Filas devueltas por JOIN: " . $result->num_rows . "<br>";
    if ($result->num_rows > 0) {
        echo "<pre>";
        print_r($result->fetch_assoc());
        echo "</pre>";
    } else {
        echo "La consulta JOIN no devolvió filas. Verificar que los ID de usuario y apartamento en la tabla 'reservas' existan en sus respectivas tablas.<br>";
    }
} else {
    echo "Error en consulta JOIN: " . $conn->error;
}
?>