<?php
session_start();
include '../../auth/conexion_be.php';

$isEmbed = isset($_GET['embed']) && $_GET['embed'] === '1';

// Obtener datos de la reserva desde la URL
$id_apartamento = isset($_GET['id']) ? intval($_GET['id']) : 0;
$checkin = isset($_GET['checkin']) ? $_GET['checkin'] : '';
$checkout = isset($_GET['checkout']) ? $_GET['checkout'] : '';
$adults = isset($_GET['adults']) ? intval($_GET['adults']) : 1;
$children = isset($_GET['children']) ? intval($_GET['children']) : 0;
$infants = isset($_GET['infants']) ? intval($_GET['infants']) : 0;
$guideDog = isset($_GET['guideDog']) && $_GET['guideDog'] === 'true';

// Validar datos mínimos
if ($id_apartamento === 0 || empty($checkin) || empty($checkout)) {
    // Redirigir si faltan datos
    header('Location: /');
    exit;
}

// Consultar detalles del apartamento con promedio de calificaciones
$sql = "SELECT a.*, 
        COALESCE(AVG(r.calificacion), 0) as promedio_calificacion, 
        COUNT(r.id) as total_resenas 
        FROM apartamentos a 
        LEFT JOIN resenas r ON a.id = r.apartamento_id 
        WHERE a.id = $id_apartamento 
        GROUP BY a.id";
$result = $conn->query($sql);
$apartamento = ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;

if (!$apartamento) {
    die("Apartamento no encontrado.");
}

// Cálculos de precio (reproducir lógica de JS en PHP para mostrar resumen inicial)
$fecha_inicio = new DateTime($checkin);
$fecha_fin = new DateTime($checkout);
$diferencia = $fecha_inicio->diff($fecha_fin);
$noches = $diferencia->days;

$basePrice = $apartamento['precio'];
$subtotal = $basePrice * $noches;
$cleaningFee = 80000;
$serviceFee = round($subtotal * 0.10);
$total = $subtotal + $cleaningFee + $serviceFee;
?>
<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Confirmar Reserva - Santamartabeachfront</title>
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
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
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

<body class="bg-background-light dark:bg-background-dark text-[#111618] dark:text-white transition-colors duration-300">
    <?php if (!$isEmbed): ?>
        <header class="sticky top-0 z-50 w-full bg-white dark:bg-background-dark border-b border-solid border-[#f0f3f4] dark:border-slate-800 px-4 md:px-10 lg:px-40 py-3">
            <div class="flex items-center justify-between max-w-[1280px] mx-auto">
                <div class="flex items-center gap-2 text-[#111618] dark:text-white cursor-pointer" onclick="window.history.back()">
                    <div class="size-6 text-primary">
                        <span class="material-symbols-outlined">arrow_back_ios</span>
                    </div>
                    <h2 class="text-xl font-extrabold leading-tight tracking-tight">Solicitar Reserva</h2>
                </div>
            </div>
        </header>
    <?php endif; ?>

    <main class="max-w-[1280px] mx-auto px-4 md:px-10 lg:px-40 py-10">
        <?php if (isset($_GET['error']) && $_GET['error'] === 'fechas'): ?>
            <div class="mb-6 rounded-xl border border-red-200 dark:border-red-900/40 bg-red-50 dark:bg-red-900/20 p-4">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400">error</span>
                    <div>
                        <p class="font-bold text-red-800 dark:text-red-200">Esas fechas ya no están disponibles.</p>
                        <p class="text-sm text-red-700 dark:text-red-300">Vuelve al apartamento y selecciona otras fechas.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Formulario de Datos -->
            <div>
                <h2 class="text-2xl font-bold mb-6">Tus datos</h2>
                <form action="procesar_reserva.php" method="POST" class="space-y-6">
                    <!-- Datos ocultos para enviar -->
                    <input type="hidden" name="id_apartamento" value="<?php echo $id_apartamento; ?>">
                    <input type="hidden" name="checkin" value="<?php echo $checkin; ?>">
                    <input type="hidden" name="checkout" value="<?php echo $checkout; ?>">
                    <input type="hidden" name="adults" value="<?php echo $adults; ?>">
                    <input type="hidden" name="children" value="<?php echo $children; ?>">
                    <input type="hidden" name="infants" value="<?php echo $infants; ?>">
                    <input type="hidden" name="guideDog" value="<?php echo $guideDog ? '1' : '0'; ?>">
                    <input type="hidden" name="total_price" value="<?php echo $total; ?>">
                    <?php if ($isEmbed): ?>
                        <input type="hidden" name="embed" value="1">
                    <?php endif; ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <label class="block text-sm font-bold mb-2">Nombre</label>
                            <input type="text" name="nombre" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg p-3 focus:ring-primary focus:border-primary" placeholder="Tu nombre">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-sm font-bold mb-2">Apellido</label>
                            <input type="text" name="apellido" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg p-3 focus:ring-primary focus:border-primary" placeholder="Tu apellido">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2">Correo electrónico</label>
                        <input type="email" name="email" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg p-3 focus:ring-primary focus:border-primary" placeholder="ejemplo@correo.com">
                        <p class="text-xs text-slate-500 mt-1">Te enviaremos la confirmación a este correo.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2">Número de teléfono</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-500 text-sm">
                                +57
                            </span>
                            <input type="tel" name="telefono" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-r-lg p-3 focus:ring-primary focus:border-primary" placeholder="300 123 4567">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-200 dark:border-slate-800">
                        <h3 class="text-lg font-bold mb-4">Detalles de los huéspedes</h3>
                        <p class="text-sm text-slate-500 mb-4">Por favor, indica los nombres completos de todos los huéspedes que se alojarán (incluyéndote si aplica).</p>
                        <textarea name="huespedes_nombres" rows="4" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg p-3 focus:ring-primary focus:border-primary" placeholder="Ej: Juan Pérez, María Gómez, Niño (Pedro)..." required></textarea>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full py-4 bg-primary text-white rounded-xl font-bold text-lg hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                            Confirmar reserva
                        </button>
                    </div>
                </form>
            </div>

            <!-- Resumen de Reserva -->
            <div>
                <div class="sticky top-28 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xl p-6">
                    <div class="flex gap-4 mb-6 pb-6 border-b border-slate-200 dark:border-slate-800">
                        <img src="/assets/img/apartamentos/<?php echo $apartamento['imagen_principal']; ?>" class="w-28 h-28 object-cover rounded-xl shadow-md">
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Alojamiento entero</p>
                            <h3 class="font-bold text-sm mb-1"><?php echo $apartamento['titulo']; ?></h3>
                            <div class="flex items-center gap-1 text-xs">
                                <span class="material-symbols-outlined text-primary text-[14px] fill-1">star</span>
                                <span><?php echo number_format($apartamento['promedio_calificacion'], 1); ?> (<?php echo $apartamento['total_resenas']; ?> reseñas)</span>
                            </div>
                        </div>
                    </div>

                    <h3 class="font-bold text-xl mb-4">Información del precio</h3>
                    
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-600 dark:text-slate-400">$<?php echo number_format($basePrice, 0, ',', '.'); ?> x <?php echo $noches; ?> noches</span>
                            <span class="font-medium">$<?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600 dark:text-slate-400">Tarifa de limpieza</span>
                            <span class="font-medium">$<?php echo number_format($cleaningFee, 0, ',', '.'); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600 dark:text-slate-400">Comisión de servicio</span>
                            <span class="font-medium">$<?php echo number_format($serviceFee, 0, ',', '.'); ?></span>
                        </div>
                        
                        <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex justify-between items-center font-bold text-lg">
                            <span>Total (COP)</span>
                            <span>$<?php echo number_format($total, 0, ',', '.'); ?></span>
                        </div>
                    </div>

                    <div class="mt-6 bg-slate-50 dark:bg-slate-800 p-4 rounded-xl">
                        <h4 class="font-bold text-sm mb-2">Tu viaje</h4>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-slate-500">Fechas</span>
                            <span class="font-medium"><?php echo date('d M', strtotime($checkin)); ?> - <?php echo date('d M', strtotime($checkout)); ?></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Huéspedes</span>
                            <span class="font-medium">
                                <?php 
                                $total_pax = $adults + $children;
                                echo $total_pax . " huésped" . ($total_pax > 1 ? 'es' : '');
                                if ($infants > 0) echo ", " . $infants . " bebé" . ($infants > 1 ? 's' : '');
                                if ($guideDog) echo ", Perro guía";
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
