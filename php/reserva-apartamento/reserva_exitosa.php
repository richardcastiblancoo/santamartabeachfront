<?php
session_start();
include '../../auth/conexion_be.php';

$isEmbed = isset($_GET['embed']) && $_GET['embed'] === '1';
$id_reserva = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consultar datos de la reserva para mostrar un resumen
$reserva = null;
if ($id_reserva > 0) {
    $sql = "SELECT r.*, a.titulo 
            FROM reservas r 
            JOIN apartamentos a ON r.apartamento_id = a.id 
            WHERE r.id = $id_reserva LIMIT 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $reserva = $result->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Reserva Exitosa - Santamartabeachfront</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="/public/img/logo-def-Photoroom.png" type="image/x-icon">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13a4ec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101c22",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans"]
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#111618] dark:text-white flex items-center justify-center min-h-screen p-4">

    <div class="bg-white dark:bg-slate-900 p-8 md:p-12 rounded-3xl shadow-2xl text-center max-w-lg w-full border border-slate-200 dark:border-slate-800">
        <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-5xl">check_circle</span>
        </div>

        <h1 class="text-3xl font-black mb-4">¡Solicitud Enviada!</h1>
        <p class="text-slate-600 dark:text-slate-400 text-lg mb-8">
            Hola <span class="font-bold text-primary"><?php echo $reserva ? htmlspecialchars($reserva['nombre_cliente']) : 'viajero'; ?></span>, tu solicitud para <strong><?php echo $reserva ? htmlspecialchars($reserva['titulo']) : 'el apartamento'; ?></strong> ha sido recibida.
        </p>

        <div class="bg-slate-50 dark:bg-slate-800 p-6 rounded-2xl mb-8 text-left space-y-3">
            <div class="flex justify-between border-b border-slate-200 dark:border-slate-700 pb-2">
                <span class="text-sm text-slate-500">ID de Solicitud</span>
                <span class="font-mono font-bold text-primary">#<?php echo str_pad($id_reserva, 6, '0', STR_PAD_LEFT); ?></span>
            </div>
            <?php if ($reserva): ?>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Check-in:</span>
                    <span class="font-semibold"><?php echo date('d M, Y', strtotime($reserva['fecha_checkin'])); ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Check-out:</span>
                    <span class="font-semibold"><?php echo date('d M, Y', strtotime($reserva['fecha_checkout'])); ?></span>
                </div>
                <div class="flex justify-between text-sm pt-2 border-t border-slate-200 dark:border-slate-700">
                    <span class="font-bold">Total estimado:</span>
                    <span class="font-bold text-lg">$<?php echo number_format($reserva['precio_total'], 0, ',', '.'); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <p class="text-sm text-slate-500 mb-8 italic">
            El administrador revisará la disponibilidad y te contactará al correo proporcionado.
        </p>

        <?php if ($isEmbed): ?>
            <button onclick="notifyParentAndClose()" class="block w-full py-4 bg-primary text-white rounded-xl font-bold text-lg hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                Volver al Panel
            </button>
        <?php else: ?>
            <a href="/" class="block w-full py-4 bg-primary text-white rounded-xl font-bold text-lg hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                Finalizar y Volver
            </a>
        <?php endif; ?>
    </div>

    <script>
        function notifyParentAndClose() {
            if (window.parent) {
                // Notifica al padre que la reserva terminó
                window.parent.postMessage({
                    type: 'reservation_completed',
                    id: '<?php echo $id_reserva; ?>'
                }, "*");
            }
        }

        // Si es embed, intentamos notificar automáticamente tras 5 segundos
        <?php if ($isEmbed): ?>
            setTimeout(notifyParentAndClose, 5000);
        <?php endif; ?>
    </script>

</body>

</html>