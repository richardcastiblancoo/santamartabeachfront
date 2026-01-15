<?php
include '../../auth/conexion_be.php';

// Validar que se recibieron datos por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /');
    exit;
}

// Recibir datos del formulario
$id_apartamento = intval($_POST['id_apartamento']);
$checkin = $_POST['checkin'];
$checkout = $_POST['checkout'];
$adults = intval($_POST['adults']);
$children = intval($_POST['children']);
$infants = intval($_POST['infants']);
$guideDog = intval($_POST['guideDog']);
$total_price = floatval($_POST['total_price']);

$nombre = $conn->real_escape_string($_POST['nombre']);
$apellido = $conn->real_escape_string($_POST['apellido']);
$email = $conn->real_escape_string($_POST['email']);
$telefono = $conn->real_escape_string($_POST['telefono']);
$huespedes_nombres = $conn->real_escape_string($_POST['huespedes_nombres']);

// Estado inicial de la reserva
$estado = 'pendiente'; // Puede ser 'pendiente', 'confirmada', 'cancelada'

// Preparar la consulta SQL para insertar la reserva
$sql = "INSERT INTO reservas (
            apartamento_id, 
            nombre_cliente, 
            apellido_cliente, 
            email_cliente, 
            telefono_cliente, 
            fecha_inicio, 
            fecha_fin, 
            adultos, 
            ninos, 
            bebes, 
            perro_guia, 
            nombres_huespedes, 
            total, 
            estado, 
            fecha_creacion
        ) VALUES (
            $id_apartamento, 
            '$nombre', 
            '$apellido', 
            '$email', 
            '$telefono', 
            '$checkin', 
            '$checkout', 
            $adults, 
            $children, 
            $infants, 
            $guideDog, 
            '$huespedes_nombres', 
            $total_price, 
            '$estado', 
            NOW()
        )";

if ($conn->query($sql) === TRUE) {
    $id_reserva = $conn->insert_id;
    // Redirigir a una página de éxito
    header("Location: reserva_exitosa.php?id=$id_reserva");
    exit;
} else {
    echo "Error al crear la reserva: " . $conn->error;
    // Opcional: Log del error o redirigir a página de error
}

$conn->close();
?>