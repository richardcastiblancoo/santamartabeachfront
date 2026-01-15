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
    <title>Santamartabeachfront - Panel Admin. (Gestión de PQR Simplificada)</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
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
        <aside class="w-72 bg-card-light dark:bg-card-dark border-r border-[#f0f3f4] dark:border-gray-800 flex flex-col h-full hidden md:flex shrink-0 z-20">
            <div class="p-6 flex items-center gap-3">
                <div class="bg-primary/10 p-2 rounded-lg">
                    <span class="material-symbols-outlined text-primary">beach_access</span>
                </div>
                <div>
                    <h1 class="text-base font-bold text-text-main dark:text-white leading-none">Santamarta</h1>
                    <p class="text-xs text-text-secondary dark:text-gray-400 mt-1">Beachfront Admin</p>
                </div>
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
                    <span class="ml-auto bg-primary text-white text-xs font-bold px-2 py-0.5 rounded-full">4</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/usuarios.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">group</span>
                    <span class="text-sm font-medium">Usuarios</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-primary/10 text-primary font-semibold" href="/php/dashboard-admin/pqr.php">
                    <span class="material-symbols-outlined fill-1">mail</span>
                    <span class="text-sm">PQR</span>
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
                    <div class="flex items-center gap-2 relative">
                        <button id="notification-btn" class="relative size-10 flex items-center justify-center rounded-full hover:bg-background-light dark:hover:bg-gray-800 text-text-secondary transition-colors" onclick="toggleNotifications()">
                            <span class="material-symbols-outlined">notifications</span>
                            <span id="notification-badge" class="absolute top-2.5 right-2.5 size-2 bg-red-500 rounded-full border border-white dark:border-gray-900 hidden"></span>
                        </button>
                        
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
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-sm">filter_list</span>
                                <select class="w-full pl-9 pr-4 py-2 text-sm border border-[#f0f3f4] dark:border-gray-700 bg-background-light dark:bg-gray-900 rounded-lg focus:ring-1 focus:ring-primary text-text-secondary">
                                    <option>Todos los tipos</option>
                                    <option>Petición</option>
                                    <option>Queja</option>
                                    <option>Reclamo</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex-1 overflow-y-auto divide-y divide-[#f0f3f4] dark:divide-gray-800">
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
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

    <script>
        let currentPqrId = null;

        let lastNotificationCount = 0;
        let currentNotifications = [];

        function requestNotificationPermission() {
            if ("Notification" in window && Notification.permission !== "granted") {
                Notification.requestPermission();
            }
        }

        function checkNotifications() {
            fetch('check_notifications.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const badge = document.getElementById('notification-badge');
                        const list = document.getElementById('notification-list');
                        
                        // Actualizar badge
                        if (data.count > 0) {
                            badge.classList.remove('hidden');
                            badge.textContent = ''; 
                        } else {
                            badge.classList.add('hidden');
                        }
                        
                        // Alerta y Notificación del sistema
                        if (data.count > lastNotificationCount) {
                            // Reproducir sonido si es posible
                            try {
                                const audio = new Audio('../../assets/sounds/notification.mp3');
                                audio.play().catch(e => console.log('Audio autoplay blocked'));
                            } catch (e) {}

                            // Mostrar notificación del navegador
                            if ("Notification" in window && Notification.permission === "granted") {
                                const newPqr = data.notifications[0];
                                if (newPqr) {
                                    let imagenUsuario = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(newPqr.nombre + ' ' + newPqr.apellido) + '&background=random';
                                    if (newPqr.imagen) {
                                        imagenUsuario = newPqr.imagen.startsWith('assets/') ? '../../' + newPqr.imagen : '../../assets/img/usuarios/' + newPqr.imagen;
                                    }
                                    
                                    // Para notificaciones nativas, la imagen debe ser una URL absoluta o relativa válida accesible
                                    // Nota: Las notificaciones del sistema a veces no muestran imágenes grandes dependiendo del OS
                                    new Notification("Nueva PQR Recibida", {
                                        body: `${newPqr.nombre} ${newPqr.apellido}: ${newPqr.asunto}`,
                                        icon: imagenUsuario, // Intentar mostrar la foto del usuario en la notificación
                                        image: imagenUsuario // Algunos navegadores soportan esto para imagen grande
                                    });
                                }
                            }
                        }
                        lastNotificationCount = data.count;

                        // Guardar notificaciones actuales
                        currentNotifications = data.notifications;

                        // Actualizar lista
                        if (data.notifications.length > 0) {
                            let html = '';
                            data.notifications.forEach((notif, index) => {
                                let imagenUsuario = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(notif.nombre + ' ' + notif.apellido) + '&background=random';
                                if (notif.imagen) {
                                    imagenUsuario = notif.imagen.startsWith('assets/') ? '../../' + notif.imagen : '../../assets/img/usuarios/' + notif.imagen;
                                }
                                const time = new Date(notif.fecha_creacion).toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit'});
                                
                                html += `
                                    <div class="p-3 border-b border-[#f0f3f4] dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-colors" onclick="abrirNotificacion(${index})">
                                        <div class="flex gap-3">
                                            <div class="w-10 h-10 rounded-full bg-cover bg-center shrink-0" style="background-image: url('${imagenUsuario}');"></div>
                                            <div class="flex-1 overflow-hidden">
                                                <div class="flex justify-between items-start">
                                                    <p class="text-sm font-bold text-text-main dark:text-white truncate">${notif.nombre} ${notif.apellido}</p>
                                                    <span class="text-[10px] text-text-secondary">${time}</span>
                                                </div>
                                                <p class="text-xs text-primary font-medium mb-0.5">Nueva PQR #${notif.id}</p>
                                                <p class="text-xs text-text-secondary truncate">${notif.asunto}</p>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                            list.innerHTML = html;
                        } else {
                            list.innerHTML = '<div class="p-4 text-center text-xs text-text-secondary">No tienes nuevas notificaciones</div>';
                        }
                    }
                })
                .catch(err => console.error('Error checking notifications:', err));
        }

        function abrirNotificacion(index) {
            const notif = currentNotifications[index];
            if (notif) {
                verDetallePQR(notif);
                toggleNotifications();
            }
        }

        function toggleNotifications() {
            const dropdown = document.getElementById('notification-dropdown');
            dropdown.classList.toggle('hidden');
        }
        
        function markAllRead() {
            document.getElementById('notification-badge').classList.add('hidden');
        }

        // Solicitar permiso al cargar
        document.addEventListener('DOMContentLoaded', requestNotificationPermission);

        // Iniciar polling
        setInterval(checkNotifications, 10000); 
        checkNotifications();

        function filterPQR(status, btn) {
            // Actualizar estado activo de los botones
            document.querySelectorAll('.filter-tab').forEach(tab => {
                tab.classList.remove('bg-primary', 'text-white');
                tab.classList.add('bg-gray-100', 'text-text-secondary', 'hover:bg-gray-200', 'dark:bg-gray-800', 'dark:hover:bg-gray-700');
            });
            
            // Si btn no está definido (carga inicial o llamada externa), buscar el botón correspondiente
            if (!btn) {
                // Lógica opcional si se necesitara persistir el filtro
                return;
            }

            btn.classList.remove('bg-gray-100', 'text-text-secondary', 'hover:bg-gray-200', 'dark:bg-gray-800', 'dark:hover:bg-gray-700');
            btn.classList.add('bg-primary', 'text-white');

            // Filtrar items
            const items = document.querySelectorAll('.pqr-item');
            let visibleCount = 0;
            items.forEach(item => {
                if (status === 'all' || item.dataset.status === status) {
                    item.classList.remove('hidden');
                    visibleCount++;
                } else {
                    item.classList.add('hidden');
                }
            });
        }
        
        // Función cambiarEstadoHeader eliminada

        function verDetallePQR(pqr) {
            currentPqrId = pqr.id;
            const placeholder = document.getElementById('detalle-pqr-placeholder');
            const conversacionContainer = document.getElementById('conversacion-container');
            const mensajeInicialContainer = document.getElementById('mensaje-inicial-container');
            const respuestasList = document.getElementById('respuestas-list');
            const respuestaContainer = document.getElementById('respuesta-pqr-container');
            
            // Ocultar placeholder y mostrar conversación
            placeholder.style.display = 'none';
            conversacionContainer.style.display = 'block';
            respuestaContainer.classList.remove('hidden');
            
            // Asignar ID al formulario de respuesta
            document.getElementById('respuesta-pqr-id').value = pqr.id;
            
            // Establecer estado actual en el select
            const selectEstado = document.getElementById('respuesta-estado');
            for(let i = 0; i < selectEstado.options.length; i++) {
                if(selectEstado.options[i].value === pqr.estado) {
                    selectEstado.selectedIndex = i;
                    break;
                }
            }

            // Imagen del usuario
            let imagenUsuario = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(pqr.nombre + ' ' + pqr.apellido) + '&background=random';
            if (pqr.imagen) {
                imagenUsuario = pqr.imagen.startsWith('assets/') ? '../../' + pqr.imagen : '../../assets/img/usuarios/' + pqr.imagen;
            }
            
            // Estado y color
            let estadoColor = 'text-red-600 dark:text-red-400';
            let estadoBg = 'bg-red-100 dark:bg-red-900/30';
            
            if (pqr.estado === 'En Progreso') {
                estadoColor = 'text-yellow-600 dark:text-yellow-400';
                estadoBg = 'bg-yellow-100 dark:bg-yellow-900/30';
            } else if (pqr.estado === 'Resuelto') {
                estadoColor = 'text-green-600 dark:text-green-400';
                estadoBg = 'bg-green-100 dark:bg-green-900/30';
            }

            const fecha = new Date(pqr.fecha_creacion);
            const fechaFormateada = fecha.toLocaleDateString('es-ES', { day: 'numeric', month: 'long', year: 'numeric' }) + ' a las ' + fecha.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });

            // Renderizar mensaje inicial
            mensajeInicialContainer.innerHTML = `
                <div class="bg-background-light dark:bg-gray-800 p-4 rounded-lg flex items-center gap-4 border border-[#f0f3f4] dark:border-gray-700 mb-6">
                    <div class="w-12 h-12 rounded-full bg-cover bg-center shrink-0 border-2 border-white dark:border-gray-700 shadow-sm" style="background-image: url('${imagenUsuario}');"></div>
                    <div class="flex-1">
                        <h4 class="font-bold text-text-main dark:text-white">${pqr.nombre} ${pqr.apellido}</h4>
                        <p class="text-sm text-text-secondary">${pqr.email}</p>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                        <div class="${estadoBg} ${estadoColor} text-xs px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">${pqr.estado}</div>
                        <span class="text-xs text-text-secondary">ID: #${pqr.id}</span>
                        <span class="text-[10px] font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-1.5 py-0.5 rounded border border-gray-200 dark:border-gray-600 uppercase tracking-wider mt-1">${pqr.tipo || 'Petición'}</span>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-cover bg-center shrink-0 mt-1" style="background-image: url('${imagenUsuario}');"></div>
                    <div class="flex-1 space-y-2">
                        <div class="flex items-baseline justify-between">
                            <span class="font-bold text-text-main dark:text-white">${pqr.nombre} ${pqr.apellido}</span>
                            <span class="text-xs text-text-secondary">${fechaFormateada}</span>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-r-xl rounded-bl-xl text-text-main dark:text-gray-200 text-sm leading-relaxed border border-blue-100 dark:border-blue-800/50">
                            <p class="mb-2 font-bold text-primary">Asunto: ${pqr.asunto}</p>
                            <p>${pqr.mensaje}</p>
                        </div>
                    </div>
                </div>
            `;
            
            // Cargar respuestas
            respuestasList.innerHTML = '<div class="flex justify-center p-4"><div class="animate-spin rounded-full h-6 w-6 border-b-2 border-primary"></div></div>';
            
            fetch(`obtener_respuestas_pqr.php?pqr_id=${pqr.id}`)
                .then(response => response.json())
                .then(respuestas => {
                    respuestasList.innerHTML = '';
                    
                    if (respuestas.length === 0) {
                        respuestasList.innerHTML = '<p class="text-center text-xs text-text-secondary py-4 italic">No hay respuestas aún. Sé el primero en responder.</p>';
                        return;
                    }

                    respuestas.forEach(resp => {
                        const fechaResp = new Date(resp.fecha_respuesta);
                        const fechaRespFormateada = fechaResp.toLocaleDateString('es-ES', { day: 'numeric', month: 'long', year: 'numeric' }) + ' a las ' + fechaResp.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
                        
                        // Determinar si es respuesta de admin (siempre lo es por ahora en respuestas_pqr, pero preparamos por si acaso)
                        // Como respuestas_pqr tiene admin_id, asumimos que es el admin actual o cualquier admin
                        const esAdmin = true; 
                        
                        let archivoHtml = '';
                        if (resp.archivo) {
                            const nombreArchivo = resp.archivo.split('/').pop();
                            const extension = nombreArchivo.split('.').pop().toLowerCase();
                            const esImagen = ['jpg', 'jpeg', 'png', 'gif'].includes(extension);
                            
                            if (esImagen) {
                                archivoHtml = `
                                    <div class="mt-3">
                                        <a href="../../${resp.archivo}" target="_blank" class="block max-w-xs rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:opacity-90 transition-opacity">
                                            <img src="../../${resp.archivo}" alt="Adjunto" class="w-full h-auto object-cover">
                                        </a>
                                    </div>
                                `;
                            } else {
                                archivoHtml = `
                                    <div class="mt-3">
                                        <a href="../../${resp.archivo}" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                                            <div class="p-1.5 bg-primary/10 rounded-md group-hover:bg-primary/20 transition-colors">
                                                <span class="material-symbols-outlined text-primary text-sm">description</span>
                                            </div>
                                            <span class="text-sm text-text-main dark:text-gray-300 font-medium">${nombreArchivo}</span>
                                            <span class="material-symbols-outlined text-text-secondary text-sm">open_in_new</span>
                                        </a>
                                    </div>
                                `;
                            }
                        }

                        // Admin avatar (usar el del admin que respondió o uno genérico si no se encuentra)
                        // Asegurar que usamos la imagen del admin devuelta por el backend
                        let adminImg = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(resp.nombre || 'Admin') + '&background=13a4ec&color=fff';
                        if (resp.imagen && resp.imagen.trim() !== '') {
                            adminImg = resp.imagen.startsWith('assets/') ? '../../' + resp.imagen : '../../assets/img/usuarios/' + resp.imagen;
                        }

                        const html = `
                             <div class="flex gap-4 flex-row-reverse">
                                 <div class="w-10 h-10 rounded-full bg-cover bg-center shrink-0 mt-1 ring-2 ring-primary/20" style="background-image: url('${adminImg}');" title="${resp.nombre} ${resp.apellido}"></div>
                                 <div class="flex-1 space-y-2 flex flex-col items-end">
                                     <div class="flex items-baseline justify-between w-full flex-row-reverse">
                                         <span class="font-bold text-text-main dark:text-white">${resp.nombre} ${resp.apellido} <span class="text-xs font-normal text-primary ml-1">(Admin)</span></span>
                                         <span class="text-xs text-text-secondary">${fechaRespFormateada}</span>
                                     </div>
                                     <div class="bg-white dark:bg-gray-800 p-4 rounded-l-xl rounded-br-xl text-text-main dark:text-gray-200 text-sm leading-relaxed border border-[#f0f3f4] dark:border-gray-700 shadow-sm w-full">
                                         <p class="whitespace-pre-wrap">${resp.mensaje}</p>
                                         ${archivoHtml}
                                     </div>
                                 </div>
                             </div>
                         `;
                        
                        respuestasList.insertAdjacentHTML('beforeend', html);
                    });
                    
                    // Scroll al fondo
                    conversacionContainer.scrollTop = conversacionContainer.scrollHeight;
                })
                .catch(err => {
                    console.error('Error cargando respuestas:', err);
                    respuestasList.innerHTML = '<p class="text-center text-xs text-red-500 py-4">Error al cargar la conversación.</p>';
                });
        }
    </script>
</body>

</html>