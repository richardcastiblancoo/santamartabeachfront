<?php
session_start();
include '../../auth/conexion_be.php';

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Admin') {
    echo '<script>alert("Acceso denegado. Por favor, inicia sesión como administrador."); window.location = "../../auth/login.php";</script>';
    exit;
}

// Obtener estadísticas
$stats_query = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN estado = 'Pendiente' THEN 1 ELSE 0 END) as pendientes,
    SUM(CASE WHEN estado = 'Confirmada' THEN 1 ELSE 0 END) as confirmadas,
    SUM(CASE WHEN estado = 'Cancelada' THEN 1 ELSE 0 END) as canceladas,
    SUM(CASE WHEN estado = 'Completada' THEN 1 ELSE 0 END) as completadas
    FROM reservas";
$stats_result = mysqli_query($conn, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);

// VERIFICAR Y AUTO-GENERAR DATOS DE PRUEBA SI LA TABLA ESTÁ VACÍA
if ($stats['total'] == 0) {
    $u_check = mysqli_query($conn, "SELECT id FROM usuarios LIMIT 1");
    $a_check = mysqli_query($conn, "SELECT id, precio FROM apartamentos LIMIT 1");

    if (mysqli_num_rows($u_check) > 0 && mysqli_num_rows($a_check) > 0) {
        $u_id = mysqli_fetch_assoc($u_check)['id'];
        $a_row = mysqli_fetch_assoc($a_check);
        $a_id = $a_row['id'];
        $precio = $a_row['precio'];

        $sql_insert = "INSERT INTO reservas (usuario_id, apartamento_id, fecha_inicio, fecha_fin, total, estado) VALUES 
        ($u_id, $a_id, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 5 DAY), " . ($precio * 5) . ", 'Confirmada'),
        ($u_id, $a_id, DATE_ADD(CURDATE(), INTERVAL 10 DAY), DATE_ADD(CURDATE(), INTERVAL 13 DAY), " . ($precio * 3) . ", 'Pendiente')";
        mysqli_query($conn, $sql_insert);

        // Recargar estadísticas
        $stats_result = mysqli_query($conn, $stats_query);
        $stats = mysqli_fetch_assoc($stats_result);
    }
}

// Obtener término de búsqueda
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$where_clause = "";
if (!empty($search)) {
    $where_clause = " WHERE (r.id LIKE '%$search%' 
                        OR r.nombre_cliente LIKE '%$search%' 
                        OR r.apellido_cliente LIKE '%$search%'
                        OR u.nombre LIKE '%$search%' 
                        OR u.apellido LIKE '%$search%' 
                        OR u.email LIKE '%$search%')";
}

// Obtener reservas con datos relacionados
$query = "SELECT r.*, 
          COALESCE(r.nombre_cliente, u.nombre) as nombre_final,
          COALESCE(r.apellido_cliente, u.apellido) as apellido_final,
          COALESCE(r.email_cliente, u.email) as email_final,
          r.telefono_cliente,
          u.imagen as usuario_imagen, 
          a.titulo as apartamento_titulo, a.descripcion as apartamento_descripcion, a.imagen_principal as apartamento_imagen 
          FROM reservas r 
          LEFT JOIN usuarios u ON r.usuario_id = u.id 
          LEFT JOIN apartamentos a ON r.apartamento_id = a.id 
          $where_clause
          ORDER BY r.fecha_creacion DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Gestión de Reservas</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link rel="shortcut icon" href="/public/img/logo_santamartabeachfront-removebg-preview.png" type="image/x-icon">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "<?php echo isset($_SESSION['tema']) ? $_SESSION['tema'] : '#13a4ec'; ?>",
                        "primary-hover": "<?php echo isset($_SESSION['tema']) ? $_SESSION['tema'] : '#0e8ac7'; ?>",
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
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            font-size: 24px;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .table-fixed-header thead th {
            position: sticky;
            top: 0;
            z-index: 10;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-text-main dark:text-white font-display overflow-hidden">
    <div class="flex h-screen w-full">
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity opacity-0"></div>

        <aside class="w-72 bg-card-light dark:bg-card-dark border-r border-[#f0f3f4] dark:border-gray-800 flex flex-col h-full hidden md:flex shrink-0 z-20">
            <div class="p-6 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="bg-primary/10 p-3 rounded-lg">
                        <img src="/public/img/logo-definitivo.webp" alt="logo" class="w-16 h-16 object-contain">
                    </div>
                    <div>
                        <h1 class="text-base font-bold text-text-main dark:text-white leading-none">Santamarta</h1>
                        <p class="text-xs text-text-secondary dark:text-gray-400 mt-1">Beachfront Admin</p>
                    </div>
                </div>
                <!-- Botón cerrar menú en móvil -->
                <button onclick="toggleSidebar()" class="md:hidden text-text-secondary hover:text-red-500">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto px-4 py-2 space-y-1">
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/dashboard.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">dashboard</span>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/apartamentos.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">apartment</span>
                    <span class="text-sm font-medium">Apartamentos</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-primary/10 text-primary" href="#">
                    <span class="material-symbols-outlined fill-1">calendar_month</span>
                    <span class="text-sm font-semibold">Reservas</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/usuarios.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">group</span>
                    <span class="text-sm font-medium">Usuarios</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/pqr.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">mail</span>
                    <span class="text-sm font-medium">PQR</span>
                </a>
                <div class="pt-4 mt-4 border-t border-[#f0f3f4] dark:border-gray-800">
                    <p class="px-3 text-xs font-semibold text-text-secondary uppercase tracking-wider mb-2">Sistema</p>
                    <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/configuracion.php">
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
                    <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 shrink-0" style='background-image: url("<?php echo !empty($_SESSION['imagen']) ? '../../assets/img/usuarios/' . $_SESSION['imagen'] : 'https://ui-avatars.com/api/?name=' . $_SESSION['nombre'] . '+' . $_SESSION['apellido']; ?>");'></div>
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-sm font-bold truncate dark:text-white"><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?></span>
                        <span class="text-xs text-text-secondary dark:text-gray-400 truncate"><?php echo $_SESSION['email']; ?></span>
                    </div>
                </div>
            </div>
        </aside>


        <div class="flex flex-col flex-1 min-w-0">
            <header class="h-16 bg-card-light dark:bg-card-dark border-b border-[#f0f3f4] dark:border-gray-800 flex items-center justify-between px-6 sticky top-0 z-10">
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-text-secondary hover:text-primary">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h2 class="text-lg font-bold text-text-main dark:text-white">Sección de Reservas</h2>
                </div>
                <div class="flex items-center gap-4">
                    <form method="GET" action="" class="hidden sm:flex items-center bg-background-light dark:bg-gray-800 rounded-lg px-3 py-1.5 border border-transparent focus-within:border-primary/50 transition-all">
                        <span class="material-symbols-outlined text-text-secondary text-lg">search</span>
                        <input name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" class="bg-transparent border-none focus:ring-0 text-sm w-48 text-text-main dark:text-white placeholder:text-text-secondary" placeholder="Buscar por ID o huésped..." type="text" />
                    </form>
                    <button class="relative size-10 flex items-center justify-center rounded-full hover:bg-background-light dark:hover:bg-gray-800 text-text-secondary transition-colors">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute top-2.5 right-2.5 size-2 bg-red-500 rounded-full border border-white dark:border-gray-900"></span>
                    </button>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-4 md:p-8 space-y-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Total -->
                    <div class="bg-card-light dark:bg-card-dark p-4 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg">
                                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl">calendar_today</span>
                            </div>
                            <div>
                                <p class="text-text-secondary dark:text-gray-400 text-[10px] font-semibold uppercase tracking-wider">Total</p>
                                <h3 class="text-xl font-bold text-text-main dark:text-white"><?php echo $stats['total']; ?></h3>
                            </div>
                        </div>
                    </div>

                    <!-- Pendientes -->
                    <div class="bg-card-light dark:bg-card-dark p-4 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="bg-yellow-100 dark:bg-yellow-900/30 p-2 rounded-lg">
                                <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-400 text-xl">pending_actions</span>
                            </div>
                            <div>
                                <p class="text-text-secondary dark:text-gray-400 text-[10px] font-semibold uppercase tracking-wider">Pendientes</p>
                                <h3 class="text-xl font-bold text-text-main dark:text-white"><?php echo $stats['pendientes']; ?></h3>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmadas -->
                    <div class="bg-card-light dark:bg-card-dark p-4 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="bg-green-100 dark:bg-green-900/30 p-2 rounded-lg">
                                <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-xl">check_circle</span>
                            </div>
                            <div>
                                <p class="text-text-secondary dark:text-gray-400 text-[10px] font-semibold uppercase tracking-wider">Confirmadas</p>
                                <h3 class="text-xl font-bold text-text-main dark:text-white"><?php echo $stats['confirmadas']; ?></h3>
                            </div>
                        </div>
                    </div>

                    <!-- Completadas -->
                    <div class="bg-card-light dark:bg-card-dark p-4 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="bg-purple-100 dark:bg-purple-900/30 p-2 rounded-lg">
                                <span class="material-symbols-outlined text-purple-600 dark:text-purple-400 text-xl">task_alt</span>
                            </div>
                            <div>
                                <p class="text-text-secondary dark:text-gray-400 text-[10px] font-semibold uppercase tracking-wider">Completadas</p>
                                <h3 class="text-xl font-bold text-text-main dark:text-white"><?php echo $stats['completadas']; ?></h3>
                            </div>
                        </div>
                    </div>

                    <!-- Canceladas -->
                    <div class="bg-card-light dark:bg-card-dark p-4 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="bg-red-100 dark:bg-red-900/30 p-2 rounded-lg">
                                <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-xl">cancel</span>
                            </div>
                            <div>
                                <p class="text-text-secondary dark:text-gray-400 text-[10px] font-semibold uppercase tracking-wider">Canceladas</p>
                                <h3 class="text-xl font-bold text-text-main dark:text-white"><?php echo $stats['canceladas']; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-[#f0f3f4] dark:border-gray-800 bg-background-light/30 dark:bg-gray-800/20">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <div class="flex items-center gap-2 bg-white dark:bg-gray-800 px-3 py-2 rounded-lg border border-[#e5e7eb] dark:border-gray-700">
                                    <span class="material-symbols-outlined text-text-secondary text-sm">calendar_month</span>
                                    <input id="date-range" class="bg-transparent border-none p-0 text-sm focus:ring-0 text-text-main dark:text-white w-48" placeholder="Seleccionar fechas" type="text" />
                                </div>
                                <div class="relative min-w-[160px]">
                                    <select class="w-full bg-white dark:bg-gray-800 border-[#e5e7eb] dark:border-gray-700 rounded-lg text-sm text-text-main dark:text-white focus:ring-primary focus:border-primary">
                                        <option value="">Apartamento</option>
                                        <?php
                                        // Opcional: Cargar apartamentos dinámicamente para el filtro
                                        ?>
                                    </select>
                                </div>
                                <div class="relative min-w-[140px]">
                                    <select class="w-full bg-white dark:bg-gray-800 border-[#e5e7eb] dark:border-gray-700 rounded-lg text-sm text-text-main dark:text-white focus:ring-primary focus:border-primary">
                                        <option value="">Estado</option>
                                        <option value="Confirmada">Confirmada</option>
                                        <option value="Pendiente">Pendiente</option>
                                        <option value="Cancelada">Cancelada</option>
                                        <option value="Completada">Completada</option>
                                    </select>
                                </div>
                                <button class="bg-white dark:bg-gray-800 border border-[#e5e7eb] dark:border-gray-700 px-4 py-2 rounded-lg text-sm font-medium text-text-main dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">filter_alt_off</span>
                                    Limpiar
                                </button>
                            </div>
                            <a href="exportar_reservas_csv.php" class="bg-primary hover:bg-primary-hover text-white px-5 py-2 rounded-lg font-semibold text-sm transition-all shadow-md flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-lg">download</span>
                                Exportar CSV
                            </a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse table-fixed-header">
                            <thead>
                                <tr class="bg-background-light dark:bg-gray-800/50 text-text-secondary dark:text-gray-400 text-xs uppercase tracking-wider">
                                    <th class="px-6 py-4 font-bold w-24">ID Reserva</th>
                                    <th class="px-6 py-4 font-bold">Huésped</th>
                                    <th class="px-6 py-4 font-bold">Contacto</th>
                                    <th class="px-6 py-4 font-bold">Ocupantes</th>
                                    <th class="px-6 py-4 font-bold">Apartamento</th>
                                    <th class="px-6 py-4 font-bold">Fechas</th>
                                    <th class="px-6 py-4 font-bold">Total</th>
                                    <th class="px-6 py-4 font-bold">Estado</th>
                                    <th class="px-6 py-4 font-bold text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#f0f3f4] dark:divide-gray-800 text-sm">
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Calcular noches
                                        $fecha_inicio = new DateTime($row['fecha_inicio']);
                                        $fecha_fin = new DateTime($row['fecha_fin']);
                                        $noches = $fecha_inicio->diff($fecha_fin)->days;

                                        // Clases por estado
                                        $estado_class = '';
                                        $dot_class = '';
                                        switch ($row['estado']) {
                                            case 'Confirmada':
                                                $estado_class = 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400';
                                                $dot_class = 'bg-green-500';
                                                break;
                                            case 'Pendiente':
                                                $estado_class = 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400';
                                                $dot_class = 'bg-yellow-500';
                                                break;
                                            case 'Completada':
                                                $estado_class = 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400';
                                                $dot_class = 'bg-blue-500';
                                                break;
                                            case 'Cancelada':
                                                $estado_class = 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400';
                                                $dot_class = 'bg-red-500';
                                                break;
                                            default:
                                                $estado_class = 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400';
                                                $dot_class = 'bg-gray-500';
                                        }

                                        // Imágenes
                                        $usuario_img = !empty($row['usuario_imagen']) ? '../../assets/img/usuarios/' . $row['usuario_imagen'] : 'https://ui-avatars.com/api/?name=' . $row['nombre_final'] . '+' . $row['apellido_final'];
                                        $apartamento_img = !empty($row['apartamento_imagen']) ? '../../assets/img/apartamentos/' . $row['apartamento_imagen'] : 'https://placehold.co/400x300?text=No+Image';

                                        // Datos de contacto
                                        $email_contacto = $row['email_final'];
                                        $telefono_contacto = !empty($row['telefono_cliente']) ? $row['telefono_cliente'] : 'No registrado';

                                        // Composición de ocupantes
                                        $ocupantes = [];
                                        if ($row['adultos'] > 0) $ocupantes[] = $row['adultos'] . ' Adul.';
                                        if ($row['ninos'] > 0) $ocupantes[] = $row['ninos'] . ' Niñ.';
                                        if ($row['bebes'] > 0) $ocupantes[] = $row['bebes'] . ' Beb.';
                                        if ($row['perro_guia'] == 1) $ocupantes[] = '🦮';
                                        $ocupantes_str = implode(', ', $ocupantes);
                                ?>
                                        <tr class="group hover:bg-background-light/50 dark:hover:bg-gray-800/50 transition-colors">
                                            <td class="px-6 py-4 text-text-secondary font-mono">#RS-<?php echo $row['id']; ?></td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col">
                                                    <span class="font-bold text-text-main dark:text-white"><?php echo htmlspecialchars($row['nombre_final'] . ' ' . $row['apellido_final']); ?></span>
                                                    <span class="text-[10px] text-text-secondary">
                                                        <?php echo !empty($row['usuario_id']) ? '#USR-' . $row['usuario_id'] : 'Invitado'; ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col text-xs text-text-secondary">
                                                    <div class="flex items-center gap-1" title="<?php echo htmlspecialchars($email_contacto); ?>">
                                                        <span class="material-symbols-outlined text-[14px]">mail</span>
                                                        <span class="truncate max-w-[120px]"><?php echo htmlspecialchars($email_contacto); ?></span>
                                                    </div>
                                                    <div class="flex items-center gap-1 mt-0.5">
                                                        <span class="material-symbols-outlined text-[14px]">call</span>
                                                        <span><?php echo htmlspecialchars($telefono_contacto); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-semibold text-text-main dark:text-white"><?php echo $ocupantes_str; ?></span>
                                                    <?php if (!empty($row['nombres_huespedes'])): ?>
                                                        <span class="text-[10px] text-text-secondary truncate max-w-[100px]" title="<?php echo htmlspecialchars($row['nombres_huespedes']); ?>">
                                                            <?php echo htmlspecialchars($row['nombres_huespedes']); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <div class="size-8 rounded bg-cover bg-center shrink-0" style='background-image: url("<?php echo $apartamento_img; ?>");'></div>
                                                    <span class="font-medium text-text-main dark:text-white truncate max-w-[150px]"><?php echo $row['apartamento_titulo']; ?></span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-text-main dark:text-white">
                                                <div class="flex flex-col">
                                                    <span class="flex items-center gap-1 text-xs"><?php echo $fecha_inicio->format('d M') . ' - ' . $fecha_fin->format('d M'); ?></span>
                                                    <span class="text-[10px] text-text-secondary"><?php echo $noches; ?> noches</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 font-bold text-text-main dark:text-white">$<?php echo number_format($row['total'], 2); ?></td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold <?php echo $estado_class; ?>">
                                                    <span class="size-1.5 <?php echo $dot_class; ?> rounded-full mr-1.5"></span>
                                                    <?php echo $row['estado']; ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex justify-center items-center gap-2">
                                                    <button onclick='openModal(<?php echo json_encode([
                                                                                    "id" => $row["id"],
                                                                                    "huesped" => $row["nombre_final"] . " " . $row["apellido_final"],
                                                                                    "email" => $email_contacto,
                                                                                    "telefono" => $telefono_contacto,
                                                                                    "apartamento" => $row["apartamento_titulo"],
                                                                                    "fecha_inicio" => $fecha_inicio->format("d M Y"),
                                                                                    "fecha_fin" => $fecha_fin->format("d M Y"),
                                                                                    "noches" => $noches,
                                                                                    "ocupantes" => $ocupantes_str,
                                                                                    "nombres_huespedes" => $row["nombres_huespedes"],
                                                                                    "total" => number_format($row["total"], 2),
                                                                                    "estado" => $row["estado"],
                                                                                    "imagen_usuario" => $usuario_img,
                                                                                    "imagen_apartamento" => $apartamento_img
                                                                                ]); ?>)' class="size-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-text-secondary hover:text-primary transition-colors" title="Ver detalle">
                                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="9" class="px-6 py-4 text-center text-text-secondary">No se encontraron reservas.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-[#f0f3f4] dark:border-gray-800 flex items-center justify-between">
                        <p class="text-xs text-text-secondary">Mostrando <span class="font-bold text-text-main dark:text-white"><?php echo mysqli_num_rows($result); ?></span> reservas</p>
                        <!-- Paginación estática por ahora -->
                        <div class="flex items-center gap-2">
                            <button class="size-8 flex items-center justify-center rounded-lg border border-[#e5e7eb] dark:border-gray-700 text-text-secondary hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <span class="material-symbols-outlined text-lg">chevron_left</span>
                            </button>
                            <button class="size-8 flex items-center justify-center rounded-lg bg-primary text-white font-bold text-xs">1</button>
                            <button class="size-8 flex items-center justify-center rounded-lg border border-[#e5e7eb] dark:border-gray-700 text-text-secondary hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <span class="material-symbols-outlined text-lg">chevron_right</span>
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal de Detalle de Reserva -->
    <div id="reservationModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Background backdrop -->
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-card-light dark:bg-card-dark text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-[#f0f3f4] dark:border-gray-800">

                    <!-- Header -->
                    <div class="bg-background-light/50 dark:bg-gray-800/50 px-4 py-3 sm:px-6 flex justify-between items-center border-b border-[#f0f3f4] dark:border-gray-800">
                        <h3 class="text-base font-semibold leading-6 text-text-main dark:text-white" id="modal-title">Detalle de Reserva #<span id="modal-id"></span></h3>
                        <button type="button" onclick="closeModal()" class="text-text-secondary hover:text-text-main dark:hover:text-white transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="px-4 py-5 sm:p-6 space-y-6">
                        <!-- Huesped Info -->
                        <div class="flex items-center gap-4">
                            <div id="modal-user-img" class="size-16 rounded-full bg-cover bg-center border-2 border-white dark:border-gray-700 shadow-sm"></div>
                            <div>
                                <h4 class="text-lg font-bold text-text-main dark:text-white" id="modal-huesped"></h4>
                                <div class="flex flex-col text-sm text-text-secondary">
                                    <div class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[16px]">mail</span>
                                        <span id="modal-email"></span>
                                    </div>
                                    <div class="flex items-center gap-1 mt-0.5">
                                        <span class="material-symbols-outlined text-[16px]">call</span>
                                        <span id="modal-telefono"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ocupantes Info -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3 border border-gray-100 dark:border-gray-700">
                            <h5 class="text-xs font-semibold text-text-secondary uppercase tracking-wider mb-2">Detalles de Ocupación</h5>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-text-main dark:text-white" id="modal-ocupantes"></span>
                            </div>
                            <p class="text-xs text-text-secondary italic" id="modal-nombres-huespedes"></p>
                        </div>

                        <!-- Apartamento Info -->
                        <div class="bg-background-light dark:bg-gray-800 rounded-xl p-4">
                            <div class="flex gap-4">
                                <div id="modal-apt-img" class="w-24 h-24 rounded-lg bg-cover bg-center shrink-0"></div>
                                <div class="flex flex-col justify-center">
                                    <span class="text-xs font-semibold text-primary uppercase tracking-wider mb-1">Apartamento</span>
                                    <h4 class="font-bold text-text-main dark:text-white leading-tight mb-2" id="modal-apartamento"></h4>
                                    <div class="flex items-center gap-1 text-xs text-text-secondary">
                                        <span class="material-symbols-outlined text-sm">night_shelter</span>
                                        <span id="modal-noches"></span> noches
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fechas y Costos -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-3 rounded-lg border border-[#f0f3f4] dark:border-gray-700">
                                <span class="text-xs text-text-secondary block mb-1">Check-in</span>
                                <span class="text-sm font-semibold text-text-main dark:text-white" id="modal-checkin"></span>
                            </div>
                            <div class="p-3 rounded-lg border border-[#f0f3f4] dark:border-gray-700">
                                <span class="text-xs text-text-secondary block mb-1">Check-out</span>
                                <span class="text-sm font-semibold text-text-main dark:text-white" id="modal-checkout"></span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-[#f0f3f4] dark:border-gray-800">
                            <div>
                                <span class="text-xs text-text-secondary block">Estado</span>
                                <select id="modal-estado-select" onchange="updateStatus(this.value)" class="bg-transparent border border-gray-300 dark:border-gray-600 rounded-md text-xs font-bold mt-1 py-1 pl-2 pr-8 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Confirmada">Confirmada</option>
                                    <option value="Completada">Completada</option>
                                    <option value="Cancelada">Cancelada</option>
                                </select>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-text-secondary block">Total Pagado</span>
                                <span class="text-2xl font-bold text-text-main dark:text-white">$<span id="modal-total"></span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-background-light/30 dark:bg-gray-800/30 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                        <button type="button" onclick="closeModal()" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white dark:bg-gray-800 px-3 py-2 text-sm font-semibold text-text-main dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto transition-colors">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/reserva.js"></script>

</body>

</html>