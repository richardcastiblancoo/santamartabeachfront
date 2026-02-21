<?php
session_start();
include '../../auth/conexion_be.php';

if (!isset($_SESSION['usuario'])) {
    die('<div class="p-8 text-center">Por favor inicia sesión para reservar. <a href="../../auth/login.php" class="text-blue-500 underline">Ir al login</a></div>');
}

$id_apartamento = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_apartamento <= 0) die("ID de apartamento no válido.");

// 1. Obtener datos del apartamento
$stmt = $conn->prepare("SELECT * FROM apartamentos WHERE id = ?");
$stmt->bind_param("i", $id_apartamento);
$stmt->execute();
$apt = $stmt->get_result()->fetch_assoc();
if (!$apt) die("Apartamento no encontrado.");

// 2. Obtener rangos ocupados
$rangos_ocupados = [];
$stmt_r = $conn->prepare("SELECT fecha_checkin, fecha_checkout FROM reservas WHERE apartamento_id = ? AND estado <> 'cancelada' AND fecha_checkout > CURDATE()");
$stmt_r->bind_param("i", $id_apartamento);
$stmt_r->execute();
$res_rangos = $stmt_r->get_result();
while ($row = $res_rangos->fetch_assoc()) {
    $from = $row['fecha_checkin'];
    $to = $row['fecha_checkout'];
    try {
        // Ajuste para liberar el día de salida
        $toMinus = (new DateTime($to))->modify('-1 day')->format('Y-m-d');
        if ($toMinus >= $from) {
            $rangos_ocupados[] = ['from' => $from, 'to' => $toMinus];
        }
    } catch (Exception $e) {
    }
}

// 3. Datos del usuario logueado
$nombre = $_SESSION['nombre'] ?? '';
$apellido = $_SESSION['apellido'] ?? '';
$email = $_SESSION['email'] ?? '';
$telefono = '';

// Obtener teléfono de la última reserva (si existe)
$uid = $_SESSION['id'];
$u_sql = "SELECT telefono FROM reservas WHERE usuario_id = '$uid' AND telefono IS NOT NULL AND telefono != '' ORDER BY id DESC LIMIT 1";
$u_res = $conn->query($u_sql);
if ($u_res && $row = $u_res->fetch_assoc()) {
    $telefono = $row['telefono'];
}

$cleaningFee = 80000;
?>
<!DOCTYPE html>
<html lang="es" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Apartamento</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13a4ec",
                        "background-dark": "#101c22",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Ocultar scrollbar pero permitir scroll */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }

        .step-active {
            @apply border-primary text-primary;
        }

        .step-inactive {
            @apply border-gray-200 text-gray-400 dark:border-gray-700;
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* --- MEJORAS CALENDARIO FLATPICKR (ESPACIOSO) --- */
        .flatpickr-calendar {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
            width: 100% !important;
            margin: 0 auto;
        }
        
        .flatpickr-innerContainer {
            width: 100% !important;
        }

        .flatpickr-rContainer {
            width: 100% !important;
        }

        .flatpickr-days {
            width: 100% !important;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 15px !important; /* Más padding interno */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex !important;
            flex-direction: column;
        }

        .dark .flatpickr-days {
            background: #1e293b;
            border-color: #334155;
        }

        .dayContainer {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            display: flex !important;
            justify-content: space-between !important;
            gap: 2px; /* Espacio horizontal */
        }

        .flatpickr-day {
            border-radius: 8px !important;
            height: 44px !important; /* Más altos */
            line-height: 44px !important;
            margin: 4px 0 !important; /* Espacio vertical entre filas */
            font-weight: 600 !important;
            color: #374151 !important;
            max-width: 14.28% !important; /* Forzar ancho exacto */
            flex-basis: 14.28% !important;
        }

        .dark .flatpickr-day {
            color: #cbd5e1 !important;
        }

        .flatpickr-day.selected, 
        .flatpickr-day.startRange, 
        .flatpickr-day.endRange, 
        .flatpickr-day.selected.inRange, 
        .flatpickr-day.startRange.inRange, 
        .flatpickr-day.endRange.inRange {
            background: #13a4ec !important;
            border-color: #13a4ec !important;
            color: white !important;
            box-shadow: 0 4px 6px -1px rgba(19, 164, 236, 0.3) !important;
        }

        .flatpickr-day.inRange {
            background: #e0f2fe !important;
            border-color: #e0f2fe !important;
            color: #0284c7 !important;
            box-shadow: -5px 0 0 #e0f2fe, 5px 0 0 #e0f2fe !important;
        }

        .dark .flatpickr-day.inRange {
            background: rgba(19, 164, 236, 0.2) !important;
            border-color: transparent !important;
            color: #38bdf8 !important;
            box-shadow: -5px 0 0 rgba(19, 164, 236, 0.2), 5px 0 0 rgba(19, 164, 236, 0.2) !important;
        }

        /* DÍAS OCUPADOS / DESHABILITADOS - ESTILO ROJO FUERTE */
        .flatpickr-day.disabled, 
        .flatpickr-day.disabled:hover {
            color: #ef4444 !important; /* Rojo texto */
            background: repeating-linear-gradient(
                45deg,
                #fee2e2,
                #fee2e2 10px,
                #fecaca 10px,
                #fecaca 20px
            ) !important; /* Fondo rayado rojo claro */
            font-weight: bold !important;
            text-decoration: line-through;
            opacity: 1 !important; /* Totalmente visible */
            cursor: not-allowed !important;
            border: 1px solid #fca5a5 !important;
        }

        .dark .flatpickr-day.disabled, 
        .dark .flatpickr-day.disabled:hover {
            color: #fca5a5 !important;
            background: repeating-linear-gradient(
                45deg,
                #450a0a,
                #450a0a 10px,
                #7f1d1d 10px,
                #7f1d1d 20px
            ) !important; /* Fondo rayado rojo oscuro */
            border: 1px solid #7f1d1d !important;
        }

        .flatpickr-weekday {
            font-weight: 800 !important;
            color: #6b7280 !important;
            font-size: 0.8rem !important;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .dark .flatpickr-weekday {
            color: #94a3b8 !important;
        }

        .flatpickr-month {
            margin-bottom: 15px !important;
        }
        
        .flatpickr-current-month {
            font-size: 1.2rem !important;
            padding-top: 10px !important;
            font-weight: 800 !important;
        }
        
        .flatpickr-weekdays {
            margin-bottom: 10px !important;
        }
        
        span.flatpickr-weekday {
            background: transparent !important;
        }
    </style>
</head>

<body class="bg-white dark:bg-[#1a2c35] text-[#111618] dark:text-white min-h-screen flex flex-col">

    <!-- Header simple -->
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center gap-4 bg-white dark:bg-[#1a2c35] sticky top-0 z-20">
        <div class="w-12 h-12 rounded-lg bg-cover bg-center shrink-0" style="background-image: url('../../assets/img/apartamentos/<?php echo $apt['imagen_principal']; ?>');"></div>
        <div>
            <h1 class="font-bold text-sm md:text-base leading-tight"><?php echo htmlspecialchars($apt['titulo']); ?></h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">$<?php echo number_format($apt['precio'], 0, ',', '.'); ?> / noche</p>
        </div>
    </div>

    <?php if (isset($_GET['error']) && $_GET['error'] == 'fechas'): ?>
        <div class="mx-6 mt-4 p-4 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-sm font-bold rounded-xl flex items-center gap-2 animate-pulse">
            <span class="material-symbols-outlined">error</span>
            <p>Las fechas seleccionadas no están disponibles. Por favor selecciona otras.</p>
        </div>
    <?php endif; ?>

    <form id="bookingForm" action="../reserva-apartamento/procesar_reserva.php" method="POST" enctype="multipart/form-data" class="flex-1 flex flex-col">
        <input type="hidden" name="id_apartamento" value="<?php echo $id_apartamento; ?>">
        <input type="hidden" name="embed" value="1">
        <input type="hidden" name="total_price" id="input_total_price" value="0">

        <!-- Progress Bar -->
        <div class="px-6 py-4">
            <div class="flex items-center justify-between max-w-xl mx-auto relative">
                <div class="absolute left-0 top-1/2 w-full h-0.5 bg-gray-100 dark:bg-gray-700 -z-10"></div>
                
                <div class="flex flex-col items-center gap-1 bg-white dark:bg-[#1a2c35] px-2 z-10 step-indicator active" data-step="1">
                    <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm transition-colors duration-300">1</div>
                    <span class="text-[10px] font-bold uppercase text-primary">Fechas</span>
                </div>
                
                <div class="flex flex-col items-center gap-1 bg-white dark:bg-[#1a2c35] px-2 z-10 step-indicator" data-step="2">
                    <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 flex items-center justify-center font-bold text-sm transition-colors duration-300">2</div>
                    <span class="text-[10px] font-bold uppercase text-gray-400">Datos</span>
                </div>
                
                <div class="flex flex-col items-center gap-1 bg-white dark:bg-[#1a2c35] px-2 z-10 step-indicator" data-step="3">
                    <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 flex items-center justify-center font-bold text-sm transition-colors duration-300">3</div>
                    <span class="text-[10px] font-bold uppercase text-gray-400">Pago</span>
                </div>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto px-6 py-2">
            
            <!-- PASO 1: FECHAS Y HUESPEDES -->
            <div id="step-1" class="step-content animate-fade-in max-w-2xl mx-auto space-y-6">
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="font-bold text-lg mb-4">Selecciona tus fechas</h3>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="relative">
                            <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Llegada</label>
                            <input id="checkin" name="checkin" type="text" placeholder="Seleccionar" class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3 text-sm font-bold focus:ring-primary focus:border-primary" readonly required>
                        </div>
                        <div class="relative">
                            <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Salida</label>
                            <input id="checkout" name="checkout" type="text" placeholder="Seleccionar" class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3 text-sm font-bold focus:ring-primary focus:border-primary" readonly required>
                        </div>
                    </div>

                    <div id="calendar-container" class="mb-4"></div>
                    
                    <div class="flex items-center justify-center gap-4 text-[10px] uppercase font-bold text-gray-500 mb-2">
                        <div class="flex items-center gap-1">
                            <span class="w-3 h-3 rounded bg-white border border-gray-300"></span> Disponible
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="w-3 h-3 rounded bg-primary"></span> Seleccionado
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="w-3 h-3 rounded bg-red-100 border border-red-300 relative overflow-hidden">
                                <span class="absolute inset-0 bg-[linear-gradient(45deg,transparent_25%,rgba(239,68,68,0.2)_50%,transparent_75%,transparent_100%)] bg-[length:4px_4px]"></span>
                            </span> Ocupado
                        </div>
                    </div>

                    <p class="text-center text-xs text-gray-400">Estancia mínima: 1 noche</p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="font-bold text-lg mb-4">Huéspedes</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-bold text-sm">Adultos</p>
                                <p class="text-xs text-gray-500">Edad 13+</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button type="button" onclick="updateGuest('adults', -1)" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-600">-</button>
                                <input type="number" name="adults" id="adults" value="1" readonly class="w-10 text-center bg-transparent border-none font-bold p-0">
                                <button type="button" onclick="updateGuest('adults', 1)" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-600">+</button>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-bold text-sm">Niños</p>
                                <p class="text-xs text-gray-500">Edad 2-12</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button type="button" onclick="updateGuest('children', -1)" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-600">-</button>
                                <input type="number" name="children" id="children" value="0" readonly class="w-10 text-center bg-transparent border-none font-bold p-0">
                                <button type="button" onclick="updateGuest('children', 1)" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-600">+</button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-bold text-sm">Bebés</p>
                                <p class="text-xs text-gray-500">Menos de 2 años</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button type="button" onclick="updateGuest('infants', -1)" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-600">-</button>
                                <input type="number" name="infants" id="infants" value="0" readonly class="w-10 text-center bg-transparent border-none font-bold p-0">
                                <button type="button" onclick="updateGuest('infants', 1)" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-600">+</button>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <div>
                                <p class="font-bold text-sm">¿Perro guía?</p>
                                <p class="text-xs text-gray-500">Servicio de asistencia</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="guideDog" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Price Summary Preview -->
                <div id="price-preview" class="hidden bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-100 dark:border-blue-800">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-600 dark:text-gray-300">$<span id="prev-base">0</span> x <span id="prev-nights">0</span> noches</span>
                        <span class="font-bold">$<span id="prev-subtotal">0</span></span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-600 dark:text-gray-300">Limpieza</span>
                        <span class="font-bold">$<span id="prev-cleaning">0</span></span>
                    </div>
                    <div class="border-t border-blue-200 dark:border-blue-800 pt-2 mt-2 flex justify-between items-center text-lg font-black text-primary">
                        <span>Total</span>
                        <span>$<span id="prev-total">0</span></span>
                    </div>
                </div>
            </div>

            <!-- PASO 2: DATOS PERSONALES -->
            <div id="step-2" class="step-content hidden animate-fade-in max-w-2xl mx-auto space-y-6">
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 space-y-4">
                    <h3 class="font-bold text-lg">Tus Datos</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Nombre</label>
                            <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3 text-sm focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Apellido</label>
                            <input type="text" name="apellido" value="<?php echo htmlspecialchars($apellido); ?>" required class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3 text-sm focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                    
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3 text-sm focus:ring-primary focus:border-primary">
                    </div>
                    
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Teléfono / WhatsApp</label>
                        <input type="tel" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3 text-sm focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-lg">Acompañantes</h3>
                        <button type="button" onclick="addGuestField()" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">person_add</span> Agregar
                        </button>
                    </div>
                    <p class="text-xs text-gray-500">Opcional. Escribe el nombre completo de tus acompañantes.</p>
                    
                    <div id="guests-list" class="space-y-2">
                        <!-- Campos dinámicos -->
                        <div class="flex gap-2">
                            <input type="text" name="huespedes[]" placeholder="Nombre completo del acompañante" class="flex-1 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3 text-sm focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                </div>
            </div>

            <!-- PASO 3: PAGO Y DOCUMENTOS -->
            <div id="step-3" class="step-content hidden animate-fade-in max-w-2xl mx-auto space-y-6">
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 space-y-4">
                    <h3 class="font-bold text-lg">Método de Pago</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer hover:bg-white dark:hover:bg-gray-700 border-gray-200 dark:border-gray-600 transition-all has-[:checked]:border-primary has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <input type="radio" name="metodo_pago" value="efectivo" required class="text-primary focus:ring-primary w-5 h-5">
                            <span class="font-bold text-sm">Efectivo</span>
                        </label>
                        <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer hover:bg-white dark:hover:bg-gray-700 border-gray-200 dark:border-gray-600 transition-all has-[:checked]:border-primary has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <input type="radio" name="metodo_pago" value="transferencia" class="text-primary focus:ring-primary w-5 h-5">
                            <span class="font-bold text-sm">Transferencia</span>
                        </label>
                    </div>
                    <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg flex gap-3 items-start">
                        <span class="material-symbols-outlined text-primary text-lg mt-0.5">info</span>
                        <p class="text-xs text-blue-800 dark:text-blue-200 leading-relaxed">
                            <strong>IMPORTANTE:</strong> Al enviar esta solicitud, nos comunicaremos contigo para coordinar el pago según tu elección.
                        </p>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 space-y-4">
                    <h3 class="font-bold text-lg">Documentos y Garantía</h3>
                    
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">Foto Cédula o Pasaporte</label>
                        <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-primary transition-colors bg-white dark:bg-gray-700">
                            <input type="file" name="documento_id[]" required multiple accept="image/*,.pdf" onchange="updateFileList(this)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <span class="material-symbols-outlined text-3xl text-gray-400 mb-2">cloud_upload</span>
                            <p class="text-xs font-bold text-gray-500 dark:text-gray-300" id="file-label">Haz clic para subir archivos</p>
                            <div id="file-list" class="mt-2 text-[10px] text-primary font-bold"></div>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Cuenta para devolución de depósito</label>
                        <input type="text" name="cuenta_devolucion" placeholder="Banco - Tipo - Número" class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3 text-sm focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer Actions -->
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-[#1a2c35] sticky bottom-0 z-20">
            <div class="max-w-2xl mx-auto flex items-center justify-between gap-4">
                <div id="footer-price" class="hidden flex-col">
                    <span class="text-xs text-gray-500">Total a pagar</span>
                    <span class="font-black text-xl text-primary">$<span id="footer-total-display">0</span></span>
                </div>
                
                <div class="flex-1 flex justify-end gap-3">
                    <button type="button" id="btn-back" onclick="changeStep(-1)" class="hidden px-6 py-3 rounded-xl border border-gray-200 dark:border-gray-600 font-bold text-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Atrás
                    </button>
                    
                    <button type="button" id="btn-next" onclick="changeStep(1)" class="px-8 py-3 rounded-xl bg-primary text-white font-bold text-sm shadow-lg shadow-primary/30 hover:bg-sky-600 transition-all flex items-center gap-2">
                        Siguiente
                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </button>

                    <button type="submit" id="btn-submit" class="hidden px-8 py-3 rounded-xl bg-green-600 text-white font-bold text-sm shadow-lg shadow-green-600/30 hover:bg-green-700 transition-all flex items-center gap-2">
                        Confirmar Reserva
                        <span class="material-symbols-outlined text-base">check</span>
                    </button>
                </div>
            </div>
            <p class="text-center text-[10px] text-gray-400 mt-2">No se te cobrará nada todavía</p>
        </div>
    </form>

    <script>
        // CONFIGURACIÓN Y ESTADO
        const basePrice = <?php echo $apt['precio']; ?>;
        const cleaningFee = <?php echo $cleaningFee; ?>;
        const bookedRanges = <?php echo json_encode($rangos_ocupados, JSON_UNESCAPED_SLASHES); ?>;
        let currentStep = 1;
        let guests = { adults: 1, children: 0, infants: 0 };

        // FLATPICKR
        const fp = flatpickr("#calendar-container", {
            locale: "es",
            inline: true,
            minDate: "<?php echo date('Y-m-d'); ?>",
            mode: "range",
            dateFormat: "Y-m-d",
            disable: bookedRanges,
            showMonths: 1,
            animate: true,
            onChange: function(selectedDates) {
                if (selectedDates.length === 2) {
                    document.getElementById('checkin').value = fp.formatDate(selectedDates[0], "Y-m-d");
                    document.getElementById('checkout').value = fp.formatDate(selectedDates[1], "Y-m-d");
                    calculatePrice(selectedDates[0], selectedDates[1]);
                } else {
                    document.getElementById('checkin').value = "";
                    document.getElementById('checkout').value = "";
                    hidePrice();
                }
            }
        });

        // FUNCIONES LÓGICAS
        function calculatePrice(start, end) {
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays > 0) {
                const subtotal = basePrice * diffDays;
                const total = subtotal + cleaningFee;

                // Update Hidden Input
                document.getElementById('input_total_price').value = total;

                // Update Preview Step 1
                document.getElementById('prev-base').innerText = basePrice.toLocaleString('es-CO');
                document.getElementById('prev-nights').innerText = diffDays;
                document.getElementById('prev-subtotal').innerText = subtotal.toLocaleString('es-CO');
                document.getElementById('prev-cleaning').innerText = cleaningFee.toLocaleString('es-CO');
                document.getElementById('prev-total').innerText = total.toLocaleString('es-CO');
                document.getElementById('price-preview').classList.remove('hidden');

                // Update Footer
                document.getElementById('footer-total-display').innerText = total.toLocaleString('es-CO');
                document.getElementById('footer-price').classList.remove('hidden');
                document.getElementById('footer-price').classList.add('flex');
            }
        }

        function hidePrice() {
            document.getElementById('price-preview').classList.add('hidden');
            document.getElementById('footer-price').classList.add('hidden');
            document.getElementById('footer-price').classList.remove('flex');
        }

        function updateGuest(type, delta) {
            const input = document.getElementById(type);
            let val = parseInt(input.value) + delta;
            if (val < 0) val = 0;
            if (type === 'adults' && val < 1) val = 1;
            input.value = val;
            guests[type] = val;
        }

        function changeStep(delta) {
            const nextStep = currentStep + delta;
            
            // Validaciones
            if (delta > 0) {
                if (currentStep === 1) {
                    if (!document.getElementById('checkin').value || !document.getElementById('checkout').value) {
                        alert("Por favor selecciona las fechas de llegada y salida.");
                        return;
                    }
                }
                if (currentStep === 2) {
                    // Validar campos requeridos html5
                    const required = document.querySelectorAll('#step-2 [required]');
                    let valid = true;
                    required.forEach(el => {
                        if (!el.value) {
                            el.classList.add('border-red-500');
                            valid = false;
                        } else {
                            el.classList.remove('border-red-500');
                        }
                    });
                    if (!valid) {
                        alert("Por favor completa los campos obligatorios.");
                        return;
                    }
                }
            }

            // Cambiar vista
            document.getElementById(`step-${currentStep}`).classList.add('hidden');
            document.getElementById(`step-${nextStep}`).classList.remove('hidden');
            
            // Actualizar indicadores
            document.querySelectorAll('.step-indicator').forEach(el => {
                const step = parseInt(el.dataset.step);
                const circle = el.querySelector('div');
                const text = el.querySelector('span');
                
                if (step === nextStep) {
                    circle.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-500');
                    circle.classList.add('bg-primary', 'text-white');
                    text.classList.remove('text-gray-400');
                    text.classList.add('text-primary');
                } else if (step < nextStep) {
                    circle.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-500', 'bg-primary');
                    circle.classList.add('bg-green-500', 'text-white'); // Completado
                    text.classList.remove('text-primary', 'text-gray-400');
                    text.classList.add('text-green-500');
                } else {
                    circle.classList.remove('bg-primary', 'text-white', 'bg-green-500');
                    circle.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-500');
                    text.classList.remove('text-primary', 'text-green-500');
                    text.classList.add('text-gray-400');
                }
            });

            currentStep = nextStep;

            // Botones Footer
            document.getElementById('btn-back').classList.toggle('hidden', currentStep === 1);
            
            if (currentStep === 3) {
                document.getElementById('btn-next').classList.add('hidden');
                document.getElementById('btn-submit').classList.remove('hidden');
            } else {
                document.getElementById('btn-next').classList.remove('hidden');
                document.getElementById('btn-submit').classList.add('hidden');
            }
        }

        function addGuestField() {
            const container = document.getElementById('guests-list');
            const div = document.createElement('div');
            div.className = 'flex gap-2 animate-fade-in';
            div.innerHTML = `
                <input type="text" name="huespedes[]" placeholder="Nombre completo" class="flex-1 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3 text-sm focus:ring-primary focus:border-primary">
                <button type="button" onclick="this.parentElement.remove()" class="p-3 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors">
                    <span class="material-symbols-outlined">delete</span>
                </button>
            `;
            container.appendChild(div);
        }

        function updateFileList(input) {
            const list = document.getElementById('file-list');
            const label = document.getElementById('file-label');
            if (input.files.length > 0) {
                label.innerText = input.files.length + " archivo(s)";
                list.innerHTML = Array.from(input.files).map(f => `<div>• ${f.name}</div>`).join('');
            } else {
                label.innerText = "Haz clic para subir archivos";
                list.innerHTML = "";
            }
        }
    </script>
</body>
</html>
