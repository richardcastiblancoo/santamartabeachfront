<?php
// DIAGNÓSTICO DE ERRORES
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verificación de seguridad
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Admin') {
    echo '<script>alert("Acceso denegado. Por favor, inicia sesión como administrador."); window.location = "../../auth/login.php";</script>';
    die();
}

include '../../auth/conexion_be.php';

// Verificación de conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// --- CONSULTAS PARA LAS TARJETAS ---
$total_reservas = 0;
$total_pqr = 0;
$pqr_pendientes = 0;
$total_usuarios = 0;

$res = $conn->query("SELECT COUNT(*) as count FROM reservas");
if ($res) {
    $total_reservas = $res->fetch_assoc()['count'];
}

$res = $conn->query("SELECT COUNT(*) as count FROM pqr");
if ($res) {
    $total_pqr = $res->fetch_assoc()['count'];
}

$res = $conn->query("SELECT COUNT(*) as count FROM pqr WHERE estado = 'Pendiente'");
if ($res) {
    $pqr_pendientes = $res->fetch_assoc()['count'];
}

$res = $conn->query("SELECT COUNT(*) as count FROM usuarios WHERE rol != 'Admin'");
if ($res) {
    $total_usuarios = $res->fetch_assoc()['count'];
}

// Obtener apartamentos
$apartamentos_res = $conn->query("SELECT * FROM apartamentos LIMIT 6");

// Obtener PQR recientes
$pqr_res = $conn->query("SELECT p.*, u.nombre, u.apellido, u.imagen AS usuario_imagen 
                         FROM pqr p 
                         JOIN usuarios u ON p.usuario_id = u.id 
                         ORDER BY p.fecha_creacion DESC LIMIT 5");
?>
<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Panel de Administrador</title>
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

        .card-hover-effect:hover {
            transform: translateY(-2px);
            transition: all 0.2s ease;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-text-main dark:text-white font-display overflow-hidden">
    <div class="flex h-screen w-full">
        <!-- Overlay para móvil -->
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity opacity-0"></div>

        <aside id="sidebar" class="w-72 bg-card-light dark:bg-card-dark border-r border-[#f0f3f4] dark:border-gray-800 flex flex-col h-full fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out z-50 shrink-0">
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
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-primary/10 text-primary" href="/php/dashboard-admin/dashboard.php">
                    <span class="material-symbols-outlined fill-1">dashboard</span>
                    <span class="text-sm font-semibold">Dashboard</span>
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
                    <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 shrink-0" style='background-image: url("<?php echo !empty($_SESSION['imagen']) ? '../../assets/img/usuarios/' . $_SESSION['imagen'] : 'https://ui-avatars.com/api/?name=' . urlencode($_SESSION['nombre']); ?>");'></div>
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
                    <button id="mobile-menu-btn" onclick="toggleSidebar()" class="md:hidden text-text-secondary hover:text-primary">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h2 class="text-lg font-bold text-text-main dark:text-white hidden sm:block">Panel de Control</h2>
                </div>
                <div class="flex items-center gap-4 flex-1 justify-end">
                    <div class="flex items-center gap-2">
                        <button
                            id="start-tour"
                            class="flex items-center justify-center gap-2 h-10 px-4 rounded-full bg-gray-600 text-white hover:bg-gray-700 transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>

                            <span class="font-medium text-sm">
                                Guía del Panel</span>
                        </button>
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-4 md:p-8 space-y-8 scroll-smooth">
                <section id="dashboard-section">
                    <div class="mb-8">
                        <h1 class="text-2xl font-extrabold text-text-main dark:text-white tracking-tight">Resumen Administrativo</h1>
                        <p class="text-text-secondary text-sm mt-1">Indicadores clave de rendimiento para hoy.</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
                        <div class="bg-card-light dark:bg-card-dark p-5 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm flex flex-col justify-between card-hover-effect group">
                            <div class="flex justify-between items-start mb-4">
                                <div class="size-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-xl">calendar_month</span>
                                </div>

                            </div>
                            <div>
                                <h3 class="text-text-secondary dark:text-gray-400 text-sm font-medium">Total de Reservas</h3>
                                <div class="flex items-baseline gap-2 mt-1">
                                    <span class="text-3xl font-bold text-text-main dark:text-white"><?php echo $total_reservas; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-card-light dark:bg-card-dark p-5 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm flex flex-col justify-between card-hover-effect group">
                            <div class="flex justify-between items-start mb-4">
                                <div class="size-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-orange-600 text-xl">contact_support</span>
                                </div>

                            </div>
                            <div>
                                <h3 class="text-text-secondary dark:text-gray-400 text-sm font-medium">Total de PQR</h3>
                                <div class="flex items-baseline gap-2 mt-1">
                                    <span class="text-3xl font-bold text-text-main dark:text-white"><?php echo $total_pqr; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-card-light dark:bg-card-dark p-5 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm flex flex-col justify-between card-hover-effect group">
                            <div class="flex justify-between items-start mb-4">
                                <div class="size-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-blue-600 text-xl">group</span>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-text-secondary dark:text-gray-400 text-sm font-medium">Huéspedes Registrados</h3>
                                <div class="flex items-baseline gap-2 mt-1">
                                    <span class="text-3xl font-bold text-text-main dark:text-white"><?php echo $total_usuarios; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="pt-8 border-t border-[#f0f3f4] dark:border-gray-800" id="apartments-section">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-text-main dark:text-white flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">apartment</span>
                            Gestión de Apartamentos
                        </h2>

                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        <?php if ($apartamentos_res && $apartamentos_res->num_rows > 0): ?>
                            <?php while ($apt = $apartamentos_res->fetch_assoc()): ?>
                                <div class="bg-card-light dark:bg-card-dark p-4 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm flex items-center gap-4 hover:border-primary/30 transition-colors">
                                    <div class="w-20 h-20 rounded-lg bg-cover bg-center shrink-0" style='background-image: url("<?php echo !empty($apt['imagen_principal']) ? '../../assets/img/apartamentos/' . $apt['imagen_principal'] : 'https://placehold.co/400'; ?>");'></div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start">
                                            <div class="truncate">
                                                <h4 class="font-bold text-text-main dark:text-white truncate"><?php echo htmlspecialchars($apt['titulo']); ?></h4>
                                                <p class="text-[11px] text-text-secondary"><?php echo htmlspecialchars($apt['ubicacion']); ?> • <?php echo $apt['habitaciones']; ?> Hab • <?php echo $apt['capacidad']; ?> Pax</p>
                                            </div>
                                            <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded-full font-bold">Activo</span>
                                        </div>
                                        <div class="mt-2 flex gap-3">
                                            <button onclick="openViewModal(<?php echo $apt['id']; ?>)" class="text-[11px] font-medium text-text-secondary hover:text-primary flex items-center gap-1"><span class="material-symbols-outlined text-xs">visibility</span> Ver</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="col-span-3 text-center py-8 text-text-secondary">
                                No hay apartamentos disponibles
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <section class="pt-8 border-t border-[#f0f3f4] dark:border-gray-800 pb-16" id="pqr-section">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-text-main dark:text-white flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">mail</span>
                            Bandeja de PQR
                        </h2>
                        <?php if ($pqr_pendientes > 0): ?>
                            <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full"><?php echo $pqr_pendientes; ?> Nuevas</span>
                        <?php endif; ?>
                    </div>
                    <div class="bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm flex flex-col divide-y divide-[#f0f3f4] dark:divide-gray-800">
                        <?php if ($pqr_res && $pqr_res->num_rows > 0): ?>
                            <?php while ($pqr = $pqr_res->fetch_assoc()): ?>
                                <?php
                                $userImg = !empty($pqr['usuario_imagen']) ? '../../assets/img/usuarios/' . $pqr['usuario_imagen'] : 'https://placehold.co/100';
                                ?>
                                <div class="p-4 hover:bg-background-light dark:hover:bg-gray-800 transition-colors cursor-pointer relative group flex items-start gap-4">

                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-baseline mb-0.5">
                                            <p class="font-bold text-sm text-text-main dark:text-white"><?php echo htmlspecialchars($pqr['nombre'] . ' ' . $pqr['apellido']); ?></p>
                                            <p class="text-[10px] text-text-secondary dark:text-gray-400 font-medium uppercase"><?php echo date('d M H:i', strtotime($pqr['fecha_creacion'])); ?></p>
                                        </div>
                                        <h5 class="text-xs font-semibold text-text-main dark:text-gray-200 mb-0.5"><?php echo htmlspecialchars($pqr['asunto']); ?></h5>
                                        <p class="text-xs text-text-secondary dark:text-gray-400 line-clamp-1"><?php echo htmlspecialchars($pqr['mensaje']); ?></p>
                                        <div class="mt-2 flex gap-2">
                                            <button onclick="openResponseModal(<?php echo $pqr['id']; ?>, '<?php echo addslashes(htmlspecialchars($pqr['asunto'])); ?>', '<?php echo addslashes(htmlspecialchars($pqr['nombre'] . ' ' . $pqr['apellido'])); ?>')" class="text-[10px] font-bold bg-primary text-white px-3 py-1 rounded hover:bg-primary-hover transition-colors">Responder</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="p-8 text-center text-text-secondary">
                                No hay PQR pendientes
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <div id="viewModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeViewModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-card-dark rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="relative h-64 w-full bg-gray-100">
                    <div id="view_image_container" class="h-full w-full bg-cover bg-center"></div>
                </div>
                <div class="px-6 py-4">
                    <h3 class="text-2xl font-bold mb-2" id="view_titulo"></h3>
                    <p class="text-sm text-gray-500 mb-4 flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">location_on</span> <span id="view_ubicacion"></span>
                    </p>
                    <div id="view_descripcion" class="text-gray-600 dark:text-gray-300 mb-6"></div>
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <div class="text-2xl font-bold text-primary" id="view_precio"></div>
                        <button onclick="closeViewModal()" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-md">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="responseModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeResponseModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-card-dark rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="responseForm" action="responder_pqr_be.php" method="POST">
                    <input type="hidden" name="pqr_id" id="modal_pqr_id">
                    <div class="px-4 pt-5 pb-4 sm:p-6">
                        <h3 class="text-lg font-medium mb-4">Responder PQR</h3>
                        <p class="text-sm text-gray-500 mb-4">Respondiendo a: <span id="modal_user_name" class="font-bold"></span></p>
                        <textarea name="mensaje" rows="4" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white" placeholder="Escribe tu respuesta aquí..." required></textarea>
                        <select name="estado" class="mt-4 w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white">
                            <option value="En Progreso">En Progreso</option>
                            <option value="Resuelto">Resuelto</option>
                        </select>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center bg-primary text-white px-4 py-2 rounded-md">Enviar Respuesta</button>
                        <button type="button" onclick="closeResponseModal()" class="mt-3 w-full sm:mt-0 sm:mr-3 px-4 py-2">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
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

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }

        function closeResponseModal() {
            document.getElementById('responseModal').classList.add('hidden');
        }

        function openViewModal(id) {
            fetch(`obtener_apartamento.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('view_titulo').textContent = data.titulo;
                    document.getElementById('view_ubicacion').textContent = data.ubicacion;
                    document.getElementById('view_descripcion').textContent = data.descripcion;
                    document.getElementById('view_precio').textContent = `$${data.precio}/noche`;
                    document.getElementById('view_image_container').style.backgroundImage = `url('${data.imagen_principal ? '../../assets/img/apartamentos/' + data.imagen_principal : 'https://placehold.co/400'}')`;
                    document.getElementById('viewModal').classList.remove('hidden');
                });
        }

        function openResponseModal(id, asunto, nombre) {
            document.getElementById('modal_pqr_id').value = id;
            document.getElementById('modal_user_name').textContent = nombre;
            document.getElementById('responseModal').classList.remove('hidden');
        }

        // Tour guiado
        document.getElementById('start-tour').addEventListener('click', function() {
            const driver = window.driver.js.driver({
                showProgress: true,
                steps: [{
                        element: '#dashboard-section',
                        popover: {
                            title: 'Dashboard',
                            description: 'Bienvenido al panel de administración. Aquí verás las estadísticas principales.',
                            side: "left",
                            align: 'start'
                        }
                    },
                    {
                        element: '#apartments-section',
                        popover: {
                            title: 'Apartamentos',
                            description: 'Gestiona todos los apartamentos disponibles.',
                            side: "left",
                            align: 'start'
                        }
                    },
                    {
                        element: '#pqr-section',
                        popover: {
                            title: 'PQR',
                            description: 'Responde a las preguntas, quejas o reclamos de los usuarios.',
                            side: "left",
                            align: 'start'
                        }
                    }
                ]
            });

            driver.drive();
        });
    </script>
</body>

</html>