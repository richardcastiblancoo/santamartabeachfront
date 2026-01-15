<?php
session_start();
include '../../auth/conexion_be.php';

// Verificar si es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Admin') {
    echo "Acceso denegado";
    exit;
}

// Configurar cabeceras para descarga CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=reservas_' . date('Y-m-d') . '.csv');

// Crear puntero de salida
$output = fopen('php://output', 'w');

// Agregar BOM para correcta visualización de caracteres especiales en Excel
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Encabezados de columna
fputcsv($output, array('ID Reserva', 'Huesped', 'Email', 'Telefono', 'ID Usuario', 'Apartamento', 'Fecha Inicio', 'Fecha Fin', 'Total', 'Estado', 'Fecha Creacion'));

// Consulta SQL (misma lógica que en reservas.php pero sin paginación si la hubiera)
$query = "SELECT r.*, 
          COALESCE(r.nombre_cliente, u.nombre) as nombre_final,
          COALESCE(r.apellido_cliente, u.apellido) as apellido_final,
          COALESCE(r.email_cliente, u.email) as email_final,
          r.telefono_cliente,
          a.titulo as apartamento_titulo
          FROM reservas r 
          LEFT JOIN usuarios u ON r.usuario_id = u.id 
          LEFT JOIN apartamentos a ON r.apartamento_id = a.id 
          ORDER BY r.fecha_creacion DESC";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    // Preparar datos para CSV
    $linea = array(
        $row['id'],
        $row['nombre_final'] . ' ' . $row['apellido_final'],
        $row['email_final'],
        !empty($row['telefono_cliente']) ? $row['telefono_cliente'] : 'No registrado',
        !empty($row['usuario_id']) ? $row['usuario_id'] : 'Invitado',
        $row['apartamento_titulo'],
        $row['fecha_inicio'],
        $row['fecha_fin'],
        $row['total'],
        $row['estado'],
        $row['fecha_creacion']
    );
    
    fputcsv($output, $linea);
}

fclose($output);
exit;
?>