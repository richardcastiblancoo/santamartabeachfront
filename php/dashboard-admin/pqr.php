<?php
session_start();
include '../../auth/conexion_be.php';

// Obtener todas las PQR con información del usuario y la última respuesta
$sql = "SELECT pqr.*, usuarios.nombre, usuarios.apellido, usuarios.imagen, usuarios.email,
        (SELECT mensaje FROM respuestas_pqr WHERE pqr_id = pqr.id ORDER BY id DESC LIMIT 1) as respuesta_mensaje,
        (SELECT archivo FROM respuestas_pqr WHERE pqr_id = pqr.id ORDER BY id DESC LIMIT 1) as respuesta_archivo,
        (SELECT fecha_respuesta FROM respuestas_pqr WHERE pqr_id = pqr.id ORDER BY id DESC LIMIT 1) as respuesta_fecha
        FROM pqr 
        JOIN usuarios ON pqr.usuario_id = usuarios.id 
        ORDER BY pqr.fecha_creacion DESC";
$result = mysqli_query($conn, $sql);

// Contadores
$total_sql = "SELECT COUNT(*) as count FROM pqr";
$total_res = mysqli_query($conn, $total_sql);
$total_pqr = mysqli_fetch_assoc($total_res)['count'];

$nuevas_sql = "SELECT COUNT(*) as count FROM pqr WHERE estado = 'Pendiente'";
$nuevas_res = mysqli_query($conn, $nuevas_sql);
$nuevas_pqr = mysqli_fetch_assoc($nuevas_res)['count'];

$progreso_sql = "SELECT COUNT(*) as count FROM pqr WHERE estado = 'En Progreso'";
$progreso_res = mysqli_query($conn, $progreso_sql);
$progreso_pqr = mysqli_fetch_assoc($progreso_res)['count'];

$resueltas_sql = "SELECT COUNT(*) as count FROM pqr WHERE estado = 'Resuelto'";
$resueltas_res = mysqli_query($conn, $resueltas_sql);
$resueltas_pqr = mysqli_fetch_assoc($resueltas_res)['count'];
?>
<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Panel Admin. (Gestión de PQR)</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link rel="shortcut icon" href="/public/img/logo-def-Photoroom.png" type="image/x-icon">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css" />
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
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
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-text-main dark:text-white font-display overflow-hidden">
    <div class="flex h-screen w-full">
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity opacity-0"></div>

        <aside class="w-72 bg-card-light dark:bg-card-dark border-r border-[#f0f3f4] dark:border-gray-800 flex flex-col h-full hidden md:flex shrink-0 z-20">
            <div class="p-6 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="bg-primary/10 p-3 rounded-lg">
                        <img src="/public/img/logo-def-Photoroom.png" alt="logo" class="w-16 h-16 object-contain">
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
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/reservas.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">calendar_month</span>
                    <span class="text-sm font-medium">Reservas</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/usuarios.php">
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
                    <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 shrink-0" style='background-image: url("<?php echo !empty($_SESSION['imagen']) ? '../../assets/img/usuarios/' . $_SESSION['imagen'] : 'https://ui-avatars.com/api/?name=' . urlencode($_SESSION['nombre'] . ' ' . $_SESSION['apellido']) . '&background=random'; ?>");'></div>
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
                    <h2 class="text-lg font-bold text-text-main dark:text-white hidden sm:block">Gestión de PQR</h2>
                </div>
                <div class="flex items-center gap-4 flex-1 justify-end">
                    <button id="start-tour-btn" class="group flex items-center justify-center gap-2 bg-[#4a4a4a] hover:bg-[#333333] text-white px-5 py-2 rounded-full font-medium transition-all duration-300 ease-in-out shadow-[0_4px_14px_0_rgba(0,0,0,0.25)] hover:shadow-[0_6px_20px_rgba(0,0,0,0.3)] active:scale-95 text-sm tracking-wide">
                        <span class="material-symbols-outlined text-[19px] transition-transform group-hover:rotate-12">help</span>
                        <span class="hidden sm:inline">Guía del Panel</span>
                    </button>
                    <div class="flex items-center gap-2 relative">
                        <!-- Dropdown de Notificaciones 
                        <button id="notification-btn" class="relative size-10 flex items-center justify-center rounded-full hover:bg-background-light dark:hover:bg-gray-800 text-text-secondary transition-colors" onclick="toggleNotifications()">
                            <span class="material-symbols-outlined">notifications</span>
                            <span id="notification-badge" class="absolute top-2.5 right-2.5 size-2 bg-red-500 rounded-full border border-white dark:border-gray-900 hidden"></span>
                        </button>
                        -->
                        <!-- Dropdown de Notificaciones -->
                        <div id="notification-dropdown" class="absolute top-12 right-0 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-[#f0f3f4] dark:border-gray-700 hidden z-50 overflow-hidden">
                            <div class="p-3 border-b border-[#f0f3f4] dark:border-gray-700 flex justify-between items-center">
                                <h3 class="font-bold text-sm text-text-main dark:text-white">Notificaciones</h3>
                                <span class="text-xs text-primary font-medium cursor-pointer hover:underline" onclick="markAllRead()">Marcar leídas</span>
                            </div>
                            <div id="notification-list" class="max-h-[300px] overflow-y-auto">
                                <!-- Items insertados vía JS -->
                            </div>
                            <div class="p-2 border-t border-[#f0f3f4] dark:border-gray-700 text-center">
                                <a href="#" class="text-xs text-text-secondary hover:text-primary transition-colors">Ver todas las notificaciones</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-4 md:p-6 space-y-6 scroll-smooth bg-background-light dark:bg-background-dark">
                <div class="flex flex-col lg:flex-row h-[calc(100vh-8rem)] gap-6">
                    <div class="lg:w-2/5 xl:w-1/3 flex flex-col bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm overflow-hidden h-full">
                        <div class="p-4 border-b border-[#f0f3f4] dark:border-gray-800">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-bold text-text-main dark:text-white">Bandeja de Entrada</h2>
                                <button onclick="location.reload()" class="bg-primary hover:bg-primary-hover text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors shadow-sm flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">refresh</span>
                                    Refrescar
                                </button>
                            </div>
                            <!-- Cambiar estado a eliminado -->
                            <div class="flex gap-2 mb-4 overflow-x-auto pb-2 scrollbar-hide">
                                <button onclick="filterPQR('all', this)" class="filter-tab px-3 py-1.5 rounded-full text-xs font-semibold bg-primary text-white whitespace-nowrap transition-colors">Todas (<?php echo $total_pqr; ?>)</button>
                                <button onclick="filterPQR('Pendiente', this)" class="filter-tab px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-100 text-text-secondary hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 whitespace-nowrap transition-colors">Nuevas (<?php echo $nuevas_pqr; ?>)</button>
                                <button onclick="filterPQR('En Progreso', this)" class="filter-tab px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-100 text-text-secondary hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 whitespace-nowrap transition-colors">En Progreso (<?php echo $progreso_pqr; ?>)</button>
                                <button onclick="filterPQR('Resuelto', this)" class="filter-tab px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-100 text-text-secondary hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 whitespace-nowrap transition-colors">Resueltas (<?php echo $resueltas_pqr; ?>)</button>
                            </div>
                        </div>
                        <div class="flex-1 overflow-y-auto divide-y divide-[#f0f3f4] dark:divide-gray-800">
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $imagen_usuario = !empty($row['imagen'])
                                        ? (strpos($row['imagen'], 'assets/') === 0 ? '../../' . $row['imagen'] : '../../assets/img/usuarios/' . $row['imagen'])
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($row['nombre'] . ' ' . $row['apellido']) . '&background=random';
                                    $estado_color = '';
                                    $estado_dot = '';

                                    if ($row['estado'] == 'Pendiente') {
                                        $estado_color = 'text-red-500';
                                        $estado_dot = 'bg-red-500';
                                        $bg_class = 'hover:bg-background-light dark:hover:bg-gray-800 border-transparent'; // Por defecto
                                        // Si quieres resaltar las nuevas, podrías usar lógica adicional aquí
                                    } elseif ($row['estado'] == 'En Progreso') {
                                        $estado_color = 'text-yellow-600 dark:text-yellow-400';
                                        $estado_dot = 'bg-yellow-500';
                                        $bg_class = 'hover:bg-background-light dark:hover:bg-gray-800 border-transparent';
                                    } else {
                                        $estado_color = 'text-green-600 dark:text-green-400';
                                        $estado_dot = 'bg-green-500';
                                        $bg_class = 'hover:bg-background-light dark:hover:bg-gray-800 border-transparent opacity-60';
                                    }

                                    // Cálculo de tiempo relativo
                                    $fecha_pqr = strtotime($row['fecha_creacion']);
                                    $ahora = time();
                                    $diferencia = $ahora - $fecha_pqr;

                                    if ($diferencia < 60) {
                                        $tiempo = "Hace instantes";
                                    } elseif ($diferencia < 3600) {
                                        $tiempo = "Hace " . floor($diferencia / 60) . " min";
                                    } elseif ($diferencia < 86400) {
                                        $tiempo = "Hace " . floor($diferencia / 3600) . " h";
                                    } else {
                                        $tiempo = date('d M', $fecha_pqr);
                                    }

                                    echo '
                                    <div class="pqr-item p-4 cursor-pointer border-l-4 transition-colors ' . $bg_class . '" data-status="' . $row['estado'] . '" onclick="verDetallePQR(' . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ')">
                                        <div class="flex justify-between items-start mb-1">
                                            <div class="flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full ' . $estado_dot . '"></span>
                                                <span class="text-xs font-bold ' . $estado_color . ' uppercase">PQR #' . $row['id'] . '</span>
                                                <span class="text-[10px] font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-1.5 py-0.5 rounded border border-gray-200 dark:border-gray-600 ml-1">' . htmlspecialchars($row['tipo'] ?? 'Petición') . '</span>
                                            </div>
                                            <span class="text-xs text-text-secondary">' . $tiempo . '</span>
                                        </div>
                                        <h3 class="text-sm font-bold text-text-main dark:text-white mb-1 line-clamp-1">' . htmlspecialchars($row['asunto']) . '</h3>
                                        <p class="text-xs text-text-secondary mb-2 line-clamp-2">' . htmlspecialchars($row['mensaje']) . '</p>
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-5 rounded-full bg-cover bg-center" style="background-image: url(\'' . $imagen_usuario . '\');"></div>
                                            <span class="text-xs text-text-main dark:text-gray-300">' . htmlspecialchars($row['nombre'] . ' ' . $row['apellido']) . '</span>
                                        </div>
                                    </div>
                                    ';
                                }
                            } else {
                                echo '<div class="p-8 text-center text-text-secondary">No hay solicitudes registradas.</div>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm overflow-hidden h-full">
                        <!-- Header estático eliminado -->
                        <div class="flex-1 overflow-y-auto p-6 space-y-6 flex items-center justify-center" id="detalle-pqr-placeholder">
                            <div class="text-center text-text-secondary">
                                <span class="material-symbols-outlined text-4xl mb-2 opacity-50">inbox</span>
                                <p>Selecciona una PQR para ver la conversación completa.</p>
                            </div>
                        </div>

                        <!-- Conversación -->
                        <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-white dark:bg-gray-900" id="conversacion-container" style="display: none;">
                            <!-- El contenido inicial de la PQR se moverá aquí dinámicamente -->
                            <div id="mensaje-inicial-container"></div>

                            <!-- Las respuestas se cargarán aquí -->
                            <div id="respuestas-list" class="space-y-6 pt-6 border-t border-[#f0f3f4] dark:border-gray-800"></div>
                        </div>

                        <div class="p-6 border-t border-[#f0f3f4] dark:border-gray-800 bg-background-light/50 dark:bg-gray-900/30 hidden" id="respuesta-pqr-container">
                            <form action="responder_pqr_be.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="pqr_id" id="respuesta-pqr-id">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-text-main dark:text-white mb-2">Responder al usuario</label>
                                    <div class="relative">
                                        <textarea name="mensaje" class="w-full bg-card-light dark:bg-gray-800 border border-[#dbe2e6] dark:border-gray-700 rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary text-text-main dark:text-white min-h-[120px] resize-none" placeholder="Escribe tu respuesta aquí..." required></textarea>
                                        <div class="absolute bottom-2 left-2 flex gap-1 items-center">
                                            <label class="cursor-pointer p-1.5 text-text-secondary hover:text-primary hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition-colors" title="Adjuntar archivo (PDF, JPG, PNG)">
                                                <span class="material-symbols-outlined text-xl">attach_file</span>
                                                <input type="file" name="adjunto" class="hidden" accept=".pdf,.jpg,.jpeg,.png" onchange="document.getElementById('file-name').textContent = this.files[0].name">
                                            </label>
                                            <span id="file-name" class="text-xs text-text-secondary truncate max-w-[150px]"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm text-text-secondary">Cambiar estado a:</span>
                                            <select name="estado" id="respuesta-estado" class="bg-card-light dark:bg-gray-800 border border-[#dbe2e6] dark:border-gray-700 rounded-md text-sm py-1.5 pl-2 pr-8 focus:ring-1 focus:ring-primary text-text-main dark:text-white">
                                                <option value="En Progreso">En Progreso</option>
                                                <option value="Resuelto">Resuelto</option>
                                                <option value="Pendiente">Pendiente</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="bg-primary hover:bg-primary-hover text-white px-6 py-2 rounded-lg font-semibold transition-all shadow-lg shadow-primary/30 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm">send</span>
                                        Enviar Respuesta
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="/js/pqr.js"></script>

</body>

</html>