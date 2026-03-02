<?php
// Habilitar visualización de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verificar si el usuario está logueado y es admin
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Admin') {
    echo '<script>alert("Acceso denegado. Por favor, inicia sesión como administrador."); window.location = "../../auth/login.php";</script>';
    die();
}

include '../../auth/conexion_be.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// 1. OBTENER ESTADÍSTICAS REALES - CON VERIFICACIÓN DE ERRORES
$total_res = 0;
$pendientes = 0;
$confirmadas = 0;
$canceladas = 0;
$finalizadas = 0;

$result = $conn->query("SELECT COUNT(*) as total FROM reservas");
if ($result) {
    $total_res = $result->fetch_assoc()['total'];
}

$result = $conn->query("SELECT COUNT(*) as total FROM reservas WHERE estado = 'pendiente'");
if ($result) {
    $pendientes = $result->fetch_assoc()['total'];
}

$result = $conn->query("SELECT COUNT(*) as total FROM reservas WHERE estado = 'confirmada'");
if ($result) {
    $confirmadas = $result->fetch_assoc()['total'];
}

$result = $conn->query("SELECT COUNT(*) as total FROM reservas WHERE estado = 'cancelada'");
if ($result) {
    $canceladas = $result->fetch_assoc()['total'];
}

$result = $conn->query("SELECT COUNT(*) as total FROM reservas WHERE estado = 'finalizada'");
if ($result) {
    $finalizadas = $result->fetch_assoc()['total'];
}

// 2. CONSULTA DE RESERVAS - CORREGIDA SEGÚN LOS CAMPOS REALES DE TU BD
// IMPORTANTE: Ajusta estos campos según los nombres reales en tu tabla 'reservas'
$sql = "SELECT r.*, a.titulo as apto_nombre, a.imagen_principal 
        FROM reservas r 
        LEFT JOIN apartamentos a ON r.apartamento_id = a.id 
        ORDER BY r.id DESC";
$resultado = $conn->query($sql);

// Verificar si la consulta tuvo éxito
if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}
?>
<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Gestión de Reservas</title>
    <link rel="shortcut icon" href="/public/img/logo-def-Photoroom.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13a4ec",
                        "primary-hover": "#0e8ac7",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101c22",
                        "card-light": "#ffffff",
                        "card-dark": "#1a2c35",
                        "text-main": "#111618",
                        "text-secondary": "#617c89",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            font-size: 24px;
        }

        .table-fixed-header thead th {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        @keyframes pulse-red {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .notif-active {
            animation: pulse-red 2s infinite;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-text-main dark:text-white font-display overflow-hidden">
    <div class="flex h-screen w-full">
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity opacity-0"></div>

        <aside id="sidebar" class="w-72 bg-card-light dark:bg-card-dark border-r border-[#f0f3f4] dark:border-gray-800 flex flex-col h-full fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out z-50 shrink-0">
            <div class="p-6 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="bg-primary/10 p-3 rounded-lg" id="tour-logo">
                        <img src="/public/img/logo-def-Photoroom.png" alt="logo" class="w-16 h-16 object-contain">
                    </div>
                    <div>
                        <h1 class="text-base font-bold text-text-main dark:text-white leading-none">Santamarta</h1>
                        <p class="text-xs text-text-secondary dark:text-gray-400 mt-1">Beachfront Admin</p>
                    </div>
                </div>

                <button onclick="toggleSidebar()" class="md:hidden text-text-secondary hover:text-red-500">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-4 py-2 space-y-1" id="tour-menu">
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 transition-colors group" href="/php/dashboard-admin/dashboard.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">dashboard</span>
                    <span class="text-sm font-semibold">Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 transition-colors group" href="/php/dashboard-admin/apartamentos.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">apartment</span>
                    <span class="text-sm font-medium">Apartamentos</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-primary/10 text-primary" href="/php/dashboard-admin/reservas.php">
                    <span class="material-symbols-outlined">calendar_month</span>
                    <span class="text-sm font-medium">Reservas</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 transition-colors group" href="/php/dashboard-admin/usuarios.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">group</span>
                    <span class="text-sm font-medium">Usuarios</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/pqr.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">mail</span>
                    <span class="text-sm font-medium">PQR</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/sugerencia.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">lightbulb</span>
                    <span class="text-sm font-medium">Sugerencias</span>
                </a>

                <div class="pt-4 mt-4 border-t border-[#f0f3f4] dark:border-gray-800">
                    <p class="px-3 text-xs font-semibold text-text-secondary uppercase tracking-wider mb-2">Sistema</p>
                    <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 transition-colors group" href="/php/dashboard-admin/configuracion.php">
                        <span class="material-symbols-outlined group-hover:text-primary transition-colors">settings</span>
                        <span class="text-sm font-medium">Configuración</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-red-50 hover:text-red-600 transition-colors group" href="../../auth/cerrar_sesion.php">
                        <span class="material-symbols-outlined group-hover:text-red-600 transition-colors">logout</span>
                        <span class="text-sm font-medium">Cerrar Sesión</span>
                    </a>
                </div>
            </div>

            <div class="p-4 border-t border-[#f0f3f4] dark:border-gray-800">
                <div class="flex items-center gap-3 bg-background-light dark:bg-gray-800 p-3 rounded-lg">
                    <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 shrink-0" style='background-image: url("<?php echo !empty($_SESSION['imagen']) ? '../../assets/img/usuarios/' . $_SESSION['imagen'] : 'https://ui-avatars.com/api/?name=' . urlencode($_SESSION['nombre']); ?>");'></div>
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-sm font-bold truncate dark:text-white"><?php echo htmlspecialchars($_SESSION['nombre'] . ' ' . $_SESSION['apellido']); ?></span>
                        <span class="text-xs text-text-secondary dark:text-gray-400 truncate"><?php echo htmlspecialchars($_SESSION['email']); ?></span>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex flex-col flex-1 min-w-0">
            <header class="h-16 bg-card-light dark:bg-card-dark border-b border-[#f0f3f4] dark:border-gray-800 flex items-center justify-between px-6 sticky top-0 z-10">
                <div class="flex items-center gap-4 flex-1">
                    <button onclick="toggleSidebar()" class="md:hidden text-text-secondary"><span class="material-symbols-outlined">menu</span></button>
                    <h2 class="text-lg font-bold text-text-main dark:text-white hidden sm:block">Gestión de
                        Reservas</h2>
                    <div class="relative w-full max-w-md" id="tour-search">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">search</span>
                        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Buscar por nombre, ID o apartamento..."
                            class="w-full pl-10 pr-4 py-2 bg-background-light dark:bg-gray-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary">
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button onclick="startTour()"
                        class="group flex items-center gap-2 bg-[#4a4a4a] hover:bg-[#333333] text-white px-4 py-2 rounded-full transition-all duration-300 ease-in-out shadow-[0_4px_12px_rgba(0,0,0,0.2)] hover:shadow-[0_6px_18px_rgba(0,0,0,0.3)] active:scale-95 border border-white/10"
                        title="Ayuda">
                        <span class="material-symbols-outlined text-[20px] transition-transform group-hover:scale-110">help</span>
                        <span class="text-sm font-medium tracking-wide">Centro de Ayuda</span>
                    </button>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 md:p-8 space-y-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4" id="tour-stats">
                    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg"><span class="material-symbols-outlined text-blue-600 dark:text-blue-400">calendar_today</span></div>
                            <div>
                                <p class="text-text-secondary dark:text-gray-400 text-[10px] font-semibold uppercase tracking-wider">Total</p>
                                <h3 class="text-xl font-bold"><?php echo $total_res; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-orange-50 dark:bg-orange-900/10 p-6 rounded-xl border border-orange-100 dark:border-orange-900/20 shadow-sm ring-1 ring-orange-500/20">
                        <div class="flex items-center gap-4">
                            <div class="bg-orange-100 dark:bg-orange-900/30 p-3 rounded-lg"><span class="material-symbols-outlined text-orange-600 dark:text-orange-400">pending_actions</span></div>
                            <div>
                                <p class="text-text-secondary dark:text-gray-400 text-[10px] font-semibold uppercase tracking-wider">Pendientes</p>
                                <h3 class="text-xl font-bold"><?php echo $pendientes; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-lg"><span class="material-symbols-outlined text-green-600 dark:text-green-400">check_circle</span></div>
                            <div>
                                <p class="text-text-secondary dark:text-gray-400 text-[10px] font-semibold uppercase tracking-wider">Confirmadas</p>
                                <h3 class="text-xl font-bold"><?php echo $confirmadas; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="bg-red-100 dark:bg-red-900/30 p-3 rounded-lg"><span class="material-symbols-outlined text-red-600 dark:text-red-400">cancel</span></div>
                            <div>
                                <p class="text-text-secondary dark:text-gray-400 text-[10px] font-semibold uppercase tracking-wider">Canceladas</p>
                                <h3 class="text-xl font-bold"><?php echo $canceladas; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg"><span class="material-symbols-outlined text-gray-600 dark:text-gray-300">task_alt</span></div>
                            <div>
                                <p class="text-text-secondary dark:text-gray-400 text-[10px] font-semibold uppercase tracking-wider">Finalizadas</p>
                                <h3 class="text-xl font-bold"><?php echo $finalizadas; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm overflow-hidden flex flex-col" id="tour-table">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse" id="reservasTable">
                            <thead>
                                <tr class="bg-background-light dark:bg-gray-800/50 text-text-secondary dark:text-gray-400 text-xs uppercase tracking-wider">
                                    <th class="px-6 py-4 font-bold">ID</th>
                                    <th class="px-6 py-4 font-bold">Cliente</th>
                                    <th class="px-6 py-4 font-bold">Apartamento</th>
                                    <th class="px-6 py-4 font-bold">Fechas</th>
                                    <th class="px-6 py-4 font-bold">Total</th>
                                    <th class="px-6 py-4 font-bold">Estado</th>
                                    <th class="px-6 py-4 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#f0f3f4] dark:divide-gray-800 text-sm">
                                <?php if ($resultado && $resultado->num_rows > 0): ?>
                                    <?php while ($row = $resultado->fetch_assoc()):
                                        // Verificar que los campos existan antes de usarlos
                                        $nombre_completo = isset($row['nombre_cliente']) && isset($row['apellido_cliente'])
                                            ? $row['nombre_cliente'] . " " . $row['apellido_cliente']
                                            : (isset($row['usuario_id']) ? "Usuario #" . $row['usuario_id'] : "Cliente no especificado");

                                        $email = isset($row['email_cliente']) ? $row['email_cliente'] : 'Email no disponible';
                                        $apto_nombre = isset($row['apto_nombre']) ? $row['apto_nombre'] : 'No asignado';
                                        $estado = isset($row['estado']) ? $row['estado'] : 'pendiente';

                                        $row_json = json_encode($row);
                                        $status_color = match ($estado) {
                                            'confirmada' => "bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400",
                                            'cancelada' => "bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400",
                                            'finalizada' => "bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400",
                                            default => "bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400",
                                        };
                                        $dot_color = match ($estado) {
                                            'confirmada' => "bg-green-500",
                                            'cancelada' => "bg-red-500",
                                            'finalizada' => "bg-blue-500",
                                            default => "bg-orange-500",
                                        };
                                    ?>
                                        <tr class="reserva-row group hover:bg-background-light/50 dark:hover:bg-gray-800/50 transition-colors">
                                            <td class="px-6 py-4 font-mono text-xs">#RS-<?php echo str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?></td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col">
                                                    <span class="font-bold"><?php echo htmlspecialchars($nombre_completo); ?></span>
                                                    <span class="text-xs text-text-secondary"><?php echo htmlspecialchars($email); ?></span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium"><?php echo htmlspecialchars($apto_nombre); ?></td>
                                            <td class="px-6 py-4 text-xs font-semibold">
                                                <?php
                                                $fecha_in = isset($row['fecha_checkin']) ? date('d M', strtotime($row['fecha_checkin'])) : 'N/A';
                                                $fecha_out = isset($row['fecha_checkout']) ? date('d M', strtotime($row['fecha_checkout'])) : 'N/A';
                                                echo $fecha_in . ' - ' . $fecha_out;
                                                ?>
                                            </td>
                                            <td class="px-6 py-4 font-bold text-sm">
                                                $<?php echo isset($row['precio_total']) ? number_format($row['precio_total'], 0, ',', '.') : '0'; ?>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase <?php echo $status_color; ?>">
                                                    <span class="size-1.5 <?php echo $dot_color; ?> rounded-full mr-1.5"></span>
                                                    <?php echo $estado; ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <button onclick='verDetalle(<?php echo htmlspecialchars($row_json, ENT_QUOTES, 'UTF-8'); ?>)' class="size-8 inline-flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-text-secondary hover:text-primary transition-colors">
                                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-text-secondary">
                                            No hay reservas registradas
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div id="modalReserva" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="cerrarModal()"></div>
        <div class="bg-card-light dark:bg-card-dark w-full max-w-lg rounded-2xl shadow-2xl z-10 overflow-hidden relative border border-gray-200 dark:border-gray-800">
            <div class="p-6 border-b dark:border-gray-800 flex justify-between items-center">
                <h3 class="text-lg font-bold" id="m-codigo">Detalle de Reserva</h3>
                <button onclick="cerrarModal()" class="text-text-secondary hover:text-red-500 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="p-6 space-y-6" id="m-contenido"></div>
            <div class="p-6 bg-gray-50 dark:bg-gray-800/50 flex justify-end gap-3">
                <button onclick="cerrarModal()" class="px-4 py-2 text-sm font-bold text-text-secondary hover:text-text-main">Cerrar</button>
            </div>
        </div>
    </div>

    <script>
        // 1. TOUR CON DRIVER.JS
        const driver = window.driver.js.driver;
        const driverObj = driver({
            showProgress: true,
            nextBtnText: 'Siguiente',
            prevBtnText: 'Anterior',
            doneBtnText: 'Finalizar',
            steps: [{
                    element: '#tour-logo',
                    popover: {
                        title: 'Panel de Control',
                        description: 'Bienvenido al administrador de Santamarta Beachfront.'
                    }
                },
                {
                    element: '#tour-menu',
                    popover: {
                        title: 'Navegación',
                        description: 'Aquí puedes moverte entre apartamentos, usuarios y PQRs.'
                    }
                },
                {
                    element: '#tour-search',
                    popover: {
                        title: 'Buscador Inteligente',
                        description: 'Busca cualquier reserva por nombre del huésped, ID de reserva o apartamento.'
                    }
                },
                {
                    element: '#tour-stats',
                    popover: {
                        title: 'Estadísticas Rápidas',
                        description: 'Resumen en tiempo real de todos los estados de reserva.'
                    }
                },
                {
                    element: '#tour-table',
                    popover: {
                        title: 'Listado Detallado',
                        description: 'Aquí gestionas cada reserva, ves detalles y cambias estados.'
                    }
                },
            ]
        });

        function startTour() {
            driverObj.drive();
        }

        // 2. BUSCADOR EN TIEMPO REAL
        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('.reserva-row');

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        }

        // 3. FUNCIONES DE LÓGICA EXISTENTES
        function verDetalle(reserva) {
            const modal = document.getElementById('modalReserva');
            const contenido = document.getElementById('m-contenido');
            const codigo = document.getElementById('m-codigo');

            // Verificar que la reserva tenga los datos necesarios
            if (!reserva) {
                alert('Error: Datos de reserva no disponibles');
                return;
            }

            const id = reserva.id || 'N/A';
            codigo.innerText = `Reserva #RS-${id.toString().padStart(4, '0')}`;

            // Formatear fechas si existen
            let fechaIn = 'No disponible';
            let fechaOut = 'No disponible';

            if (reserva.fecha_checkin) {
                try {
                    fechaIn = new Date(reserva.fecha_checkin).toLocaleDateString('es-ES', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                } catch (e) {
                    fechaIn = reserva.fecha_checkin;
                }
            }

            if (reserva.fecha_checkout) {
                try {
                    fechaOut = new Date(reserva.fecha_checkout).toLocaleDateString('es-ES', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                } catch (e) {
                    fechaOut = reserva.fecha_checkout;
                }
            }

            const precio = reserva.precio_total ?
                new Intl.NumberFormat('es-CO', {
                    style: 'currency',
                    currency: 'COP',
                    maximumFractionDigits: 0
                })
                .format(reserva.precio_total) :
                '$0';

            const nombreCliente = (reserva.nombre_cliente && reserva.apellido_cliente) ?
                `${reserva.nombre_cliente} ${reserva.apellido_cliente}` :
                (reserva.nombre_cliente || 'Cliente no especificado');

            contenido.innerHTML = `
                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/40 rounded-xl">
                        <p class="text-xs font-bold text-primary mb-2">DATOS DEL CLIENTE</p>
                        <p class="font-bold">${nombreCliente}</p>
                        <p class="text-sm text-text-secondary">${reserva.email_cliente || 'Email no disponible'}</p>
                        <p class="text-sm text-text-secondary">${reserva.telefono || 'Teléfono no disponible'}</p>
                    </div>
                    
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/40 rounded-xl">
                        <p class="text-xs font-bold text-primary mb-2">APARTAMENTO</p>
                        <p class="font-bold">${reserva.apto_nombre || 'No asignado'}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 dark:bg-gray-800/40 rounded-xl">
                            <p class="text-xs font-bold text-primary mb-2">ENTRADA</p>
                            <p class="text-sm">${fechaIn}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-800/40 rounded-xl">
                            <p class="text-xs font-bold text-primary mb-2">SALIDA</p>
                            <p class="text-sm">${fechaOut}</p>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-primary text-white rounded-xl">
                        <p class="text-xs font-bold mb-1">TOTAL</p>
                        <p class="text-2xl font-black">${precio}</p>
                    </div>
                </div>
            `;

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function cerrarModal() {
            document.getElementById('modalReserva').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.toggle('-translate-x-full');

            if (window.innerWidth < 768) {
                overlay.classList.toggle('hidden');
                setTimeout(() => {
                    overlay.classList.toggle('opacity-0');
                    overlay.classList.toggle('opacity-100');
                }, 10);
            }
        }

        // Iniciar tour automáticamente la primera vez (opcional)
        if (!localStorage.getItem('tour_visto')) {
            setTimeout(() => {
                startTour();
                localStorage.setItem('tour_visto', 'true');
            }, 1000);
        }
    </script>
</body>

</html>