<?php
session_start();
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

$isEmbed = isset($_POST['embed']) && $_POST['embed'] === '1';
$usuario_id = isset($_SESSION['id']) ? intval($_SESSION['id']) : null;

$nombre = trim((string)($_POST['nombre'] ?? ''));
$apellido = trim((string)($_POST['apellido'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$telefono = trim((string)($_POST['telefono'] ?? ''));
$huespedes_nombres = trim((string)($_POST['huespedes_nombres'] ?? ''));

$checkin_dt = DateTime::createFromFormat('Y-m-d', $checkin);
$checkout_dt = DateTime::createFromFormat('Y-m-d', $checkout);

$isValidDates = $checkin_dt && $checkout_dt && $checkin_dt->format('Y-m-d') === $checkin && $checkout_dt->format('Y-m-d') === $checkout;
if (
    $id_apartamento <= 0 ||
    !$isValidDates ||
    $checkout_dt <= $checkin_dt ||
    $adults < 1 ||
    $children < 0 ||
    $infants < 0 ||
    $nombre === '' ||
    $apellido === '' ||
    $email === '' ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    $telefono === '' ||
    $huespedes_nombres === ''
) {
    header('Location: /');
    exit;
}

$overlapStmt = $conn->prepare("SELECT COUNT(*) FROM reservas WHERE apartamento_id = ? AND estado <> 'Cancelada' AND fecha_inicio < ? AND fecha_fin > ?");
if (!$overlapStmt) {
    echo 'Error al validar disponibilidad.';
    exit;
}

$overlapStmt->bind_param('iss', $id_apartamento, $checkout, $checkin);
$overlapStmt->execute();
$overlapStmt->bind_result($overlapCount);
$overlapStmt->fetch();
$overlapStmt->close();

if (((int)$overlapCount) > 0) {
    $embedParam = $isEmbed ? '&embed=1' : '';
    $guideDogParam = $guideDog ? 'true' : 'false';
    header("Location: reservar.php?id=$id_apartamento&checkin=$checkin&checkout=$checkout&adults=$adults&children=$children&infants=$infants&guideDog=$guideDogParam&error=fechas$embedParam");
    exit;
}

// Estado inicial de la reserva
$estado = 'Pendiente';

$insertStmt = $conn->prepare(
    "INSERT INTO reservas (
        usuario_id,
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
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        NOW()
    )"
);

if ($insertStmt) {
    $insertStmt->bind_param(
        'iissssssiiiisds',
        $usuario_id,
        $id_apartamento,
        $nombre,
        $apellido,
        $email,
        $telefono,
        $checkin,
        $checkout,
        $adults,
        $children,
        $infants,
        $guideDog,
        $huespedes_nombres,
        $total_price,
        $estado
    );

    if ($insertStmt->execute()) {
        $id_reserva = $conn->insert_id;
        $insertStmt->close();
    // Redirigir a una página de éxito
    $embedParam = $isEmbed ? '&embed=1' : '';
    header("Location: reserva_exitosa.php?id=$id_reserva$embedParam");
    exit;
    }

    $insertStmt->close();
}

echo "Error al crear la reserva.";

$conn->close();
?>
