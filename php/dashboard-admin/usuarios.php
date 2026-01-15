<?php
session_start();
include '../../auth/conexion_be.php';

// Configuración de paginación y filtros
$limit = 11;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$role_filter = isset($_GET['role']) ? $_GET['role'] : 'all';
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Construir la consulta base
$where_clause = "WHERE 1=1";

if ($role_filter === 'guest') {
    $where_clause .= " AND (rol = 'Huésped' OR rol = 'guest')";
} elseif ($role_filter === 'admin') {
    $where_clause .= " AND (rol = 'Admin' OR rol = 'admin')";
}

if (!empty($search_query)) {
    $where_clause .= " AND (nombre LIKE '%$search_query%' OR apellido LIKE '%$search_query%' OR usuario LIKE '%$search_query%' OR email LIKE '%$search_query%')";
}

// Obtener total de registros para paginación
$count_sql = "SELECT COUNT(*) as total FROM usuarios $where_clause";
$count_result = mysqli_query($conn, $count_sql);
$total_rows = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_rows / $limit);

// Obtener usuarios con paginación
$sql = "SELECT * FROM usuarios $where_clause ORDER BY reg_date DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

// Contadores globales (para las pestañas)
$total_users_sql = "SELECT COUNT(*) as count FROM usuarios";
$total_users_res = mysqli_query($conn, $total_users_sql);
$total_users = mysqli_fetch_assoc($total_users_res)['count'];

$total_guests_sql = "SELECT COUNT(*) as count FROM usuarios WHERE rol='Huésped' OR rol='guest'";
$total_guests_res = mysqli_query($conn, $total_guests_sql);
$total_guests = mysqli_fetch_assoc($total_guests_res)['count'];

$total_admins_sql = "SELECT COUNT(*) as count FROM usuarios WHERE rol='Admin' OR rol='admin'";
$total_admins_res = mysqli_query($conn, $total_admins_sql);
$total_admins = mysqli_fetch_assoc($total_admins_res)['count'];
?>
<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Gestión de Usuarios</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>
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

        #add-user-modal:target {
            display: flex;
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
                    <h1 class="text-base font-bold text-text-main dark:text-white leading-none">Santamartabeachfront</h1>
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
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-primary/10 text-primary" href="#users-section">
                    <span class="material-symbols-outlined fill-1">group</span>
                    <span class="text-sm font-semibold">Usuarios</span>
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
                    <h2 class="text-lg font-bold text-text-main dark:text-white hidden sm:block">Gestión de Usuarios</h2>
                </div>
                <div class="flex items-center gap-4 flex-1 justify-end">
                    <button id="start-tour-btn" class="flex items-center justify-center gap-2 bg-white dark:bg-gray-800 border border-[#f0f3f4] dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-text-main dark:text-white px-3 py-1.5 rounded-lg font-semibold transition-all shadow-sm text-sm">
                        <span class="material-symbols-outlined text-lg">help</span>
                        <span class="hidden sm:inline">Ayuda</span>
                    </button>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-4 md:p-8 space-y-6 scroll-smooth">
                <section id="users-header">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-text-main dark:text-white">Usuarios y Roles</h1>
                            <p class="text-text-secondary text-sm mt-1">Administra el acceso y los permisos de todos los miembros de la plataforma.</p>
                        </div>
                        <a id="add-user-btn" class="flex items-center justify-center gap-2 bg-primary hover:bg-primary-hover text-white px-5 py-2.5 rounded-lg font-semibold transition-all shadow-lg shadow-primary/30" href="#add-user-modal">
                            <span class="material-symbols-outlined text-xl">person_add</span>
                            <span>Agregar Nuevo Administrador</span>
                        </a>
                    </div>
                </section>
                <section class="space-y-4">
                    <div class="flex flex-col sm:flex-row justify-between items-end sm:items-center border-b border-[#f0f3f4] dark:border-gray-800">
                        <nav id="filter-tabs" class="flex gap-8 overflow-x-auto no-scrollbar">
                            <a href="?role=all" class="pb-4 text-sm font-bold <?php echo $role_filter == 'all' ? 'text-primary border-b-2 border-primary' : 'text-text-secondary hover:text-text-main dark:hover:text-white'; ?> whitespace-nowrap transition-colors">Todos <span class="ml-1 px-2 py-0.5 bg-primary/10 rounded-full text-[10px]"><?php echo $total_users; ?></span></a>
                            <a href="?role=guest" class="pb-4 text-sm font-medium <?php echo $role_filter == 'guest' ? 'text-primary border-b-2 border-primary' : 'text-text-secondary hover:text-text-main dark:hover:text-white'; ?> whitespace-nowrap transition-colors">Huéspedes <span class="ml-1 px-2 py-0.5 bg-gray-100 dark:bg-gray-800 rounded-full text-[10px]"><?php echo $total_guests; ?></span></a>
                            <a href="?role=admin" class="pb-4 text-sm font-medium <?php echo $role_filter == 'admin' ? 'text-primary border-b-2 border-primary' : 'text-text-secondary hover:text-text-main dark:hover:text-white'; ?> whitespace-nowrap transition-colors">Administradores <span class="ml-1 px-2 py-0.5 bg-gray-100 dark:bg-gray-800 rounded-full text-[10px]"><?php echo $total_admins; ?></span></a>
                        </nav>
                        <div class="pb-3 flex gap-2 items-center flex-1 justify-end">
                            <div class="flex max-w-md w-full relative">
                                <form id="search-form" action="" method="GET" class="w-full relative">
                                    <input type="hidden" name="role" value="<?php echo htmlspecialchars($role_filter); ?>">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">search</span>
                                    <input id="search_input" name="search" value="<?php echo htmlspecialchars($search_query); ?>" class="w-full bg-white dark:bg-card-dark border border-[#f0f3f4] dark:border-gray-800 rounded-lg h-10 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white placeholder:text-text-secondary" placeholder="Buscar por nombre, correo o rol..." type="text" />
                                </form>
                            </div>
                            <button id="filter-btn" class="p-2 text-text-secondary hover:text-primary transition-colors bg-white dark:bg-card-dark border border-[#f0f3f4] dark:border-gray-800 rounded-lg shadow-sm h-10 w-10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-xl">filter_list</span>
                            </button>
                        </div>
                    </div>
                </section>
                <section id="users-section">
                    <div class="bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse min-w-[800px]">
                                <thead>
                                    <tr class="bg-background-light dark:bg-gray-800/50 text-text-secondary dark:text-gray-400 text-xs uppercase tracking-wider">
                                        <th class="px-6 py-4 font-semibold">ID</th>
                                        <th class="px-6 py-4 font-semibold">Nombre</th>
                                        <th class="px-6 py-4 font-semibold">Correo</th>
                                        <th class="px-6 py-4 font-semibold text-center">Rol</th>
                                        <th class="px-6 py-4 font-semibold">Fecha Registro</th>
                                        <th class="px-6 py-4 font-semibold">Estado</th>
                                        <th class="px-6 py-4 font-semibold text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#f0f3f4] dark:divide-gray-800 text-sm">
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            // Manejo de la imagen
                                            $imagen = !empty($row['imagen']) ? (strpos($row['imagen'], 'assets/') === 0 ? '../../' . $row['imagen'] : '../../assets/img/usuarios/' . $row['imagen']) : 'https://ui-avatars.com/api/?name=' . urlencode($row['nombre'] . ' ' . $row['apellido']) . '&background=random';

                                            // Estilos según rol
                                            $rol_class = ($row['rol'] == 'Admin' || $row['rol'] == 'admin') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300';

                                            echo '
                                            <tr class="group hover:bg-background-light dark:hover:bg-gray-800 transition-colors">
                                                <td class="px-6 py-4 text-text-secondary dark:text-gray-400">#' . $row['id'] . '</td>
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div class="size-11 rounded-full bg-cover bg-center shrink-0 border border-gray-100 dark:border-gray-700 shadow-sm" style="background-image: url(\'' . $imagen . '\');"></div>
                                                        <span class="font-bold text-text-main dark:text-white">' . htmlspecialchars($row['nombre'] . ' ' . $row['apellido']) . '</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-text-secondary dark:text-gray-300">' . htmlspecialchars($row['email']) . '</td>
                                                <td class="px-6 py-4 text-center">
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold ' . $rol_class . ' uppercase">' . htmlspecialchars($row['rol']) . '</span>
                                                </td>
                                                <td class="px-6 py-4 text-text-secondary dark:text-gray-400">' . date('d M Y', strtotime($row['reg_date'])) . '</td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-full text-xs font-medium text-green-600 bg-green-50 dark:bg-green-900/20 dark:text-green-400">
                                                        <span class="size-1.5 rounded-full bg-green-600"></span>
                                                        Activo
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <div class="flex justify-end gap-1">
                                                        <button class="p-2 hover:bg-primary/10 text-text-secondary hover:text-primary rounded-lg transition-colors" title="Ver perfil" 
                                                            onclick="openPreviewModal(' . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ')">
                                                            <span class="material-symbols-outlined text-lg">visibility</span>
                                                        </button>
                                                        <button class="p-2 hover:bg-primary/10 text-text-secondary hover:text-primary rounded-lg transition-colors" title="Editar"
                                                            onclick="openEditModal(' . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ')">
                                                            <span class="material-symbols-outlined text-lg">edit</span>
                                                        </button>
                                                        <button class="p-2 hover:bg-red-50 text-text-secondary hover:text-red-500 rounded-lg transition-colors" title="Dar de baja" 
                                                            onclick="openDeleteModal(' . $row['id'] . ')">
                                                            <span class="material-symbols-outlined text-lg">person_remove</span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            ';
                                        }
                                    } else {
                                        echo '<tr><td colspan="6" class="px-6 py-4 text-center text-text-secondary">No hay usuarios registrados.</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-4 border-t border-[#f0f3f4] dark:border-gray-800 flex flex-col sm:flex-row justify-between items-center gap-4">
                            <p class="text-xs text-text-secondary font-medium">
                                Mostrando <span class="font-bold text-text-main dark:text-white"><?php echo min($limit, $total_rows) > 0 ? ($offset + 1) : 0; ?></span>
                                a <span class="font-bold text-text-main dark:text-white"><?php echo min($offset + $limit, $total_rows); ?></span>
                                de <span class="font-bold text-text-main dark:text-white"><?php echo $total_rows; ?></span> usuarios
                            </p>
                            <div class="flex gap-2">
                                <?php if ($page > 1): ?>
                                    <a href="?page=<?php echo $page - 1; ?>&role=<?php echo $role_filter; ?>&search=<?php echo urlencode($search_query); ?>" class="px-4 py-1.5 text-xs font-semibold border border-[#f0f3f4] dark:border-gray-700 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 transition-colors">Anterior</a>
                                <?php else: ?>
                                    <button class="px-4 py-1.5 text-xs font-semibold border border-[#f0f3f4] dark:border-gray-700 rounded-lg text-text-secondary opacity-50 cursor-not-allowed" disabled>Anterior</button>
                                <?php endif; ?>

                                <?php if ($page < $total_pages): ?>
                                    <a href="?page=<?php echo $page + 1; ?>&role=<?php echo $role_filter; ?>&search=<?php echo urlencode($search_query); ?>" class="px-4 py-1.5 text-xs font-semibold border border-[#f0f3f4] dark:border-gray-700 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 transition-colors">Siguiente</a>
                                <?php else: ?>
                                    <button class="px-4 py-1.5 text-xs font-semibold border border-[#f0f3f4] dark:border-gray-700 rounded-lg text-text-secondary opacity-50 cursor-not-allowed" disabled>Siguiente</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
        <div class="hidden fixed inset-0 z-50 bg-black/50 items-center justify-center p-4 backdrop-blur-sm" id="add-user-modal">
            <div class="bg-card-light dark:bg-card-dark w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200 max-h-[90vh] overflow-y-auto">
                <form action="guardar_usuario_be.php" method="POST" enctype="multipart/form-data">
                    <div class="p-6 border-b border-[#f0f3f4] dark:border-gray-800 flex justify-between items-center sticky top-0 bg-card-light dark:bg-card-dark z-10">
                        <h3 class="text-xl font-bold text-text-main dark:text-white flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">person_add</span>
                            Nuevo Usuario
                        </h3>
                        <a class="text-text-secondary hover:text-primary transition-colors" href="#">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Nombre</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">person</span>
                                    <input name="nombre" class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white transition-shadow" placeholder="Nombre" type="text" required />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Apellido</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">person</span>
                                    <input name="apellido" class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white transition-shadow" placeholder="Apellido" type="text" required />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Usuario</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">account_circle</span>
                                    <input name="usuario" class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white transition-shadow" placeholder="Usuario" type="text" required />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Correo Electrónico</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">mail</span>
                                    <input name="email" class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white transition-shadow" placeholder="juan@ejemplo.com" type="email" required />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Contraseña</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">lock</span>
                                    <input name="password" class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white transition-shadow" placeholder="******" type="password" required />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Asignar Rol</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">badge</span>
                                    <select name="rol" class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white appearance-none cursor-pointer">
                                        <option value="Admin">Administrador</option>
                                    </select>
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-text-secondary pointer-events-none">expand_more</span>
                                </div>
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Imagen de Perfil</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">image</span>
                                    <input name="imagen" class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white transition-shadow" type="file" accept="image/*" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-background-light dark:bg-gray-800/50 border-t border-[#f0f3f4] dark:border-gray-800 flex justify-end gap-3 sticky bottom-0 z-10">
                        <a class="px-6 py-2.5 text-sm font-bold text-text-secondary hover:text-text-main transition-colors" href="#">Cancelar</a>
                        <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-hover text-white text-sm font-bold rounded-lg shadow-lg shadow-primary/30 transition-all">Guardar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="hidden fixed inset-0 z-50 bg-black/50 items-center justify-center p-4 backdrop-blur-sm" id="edit-user-modal">
            <div class="bg-card-light dark:bg-card-dark w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200 max-h-[90vh] overflow-y-auto">
                <form action="editar_usuario_be.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="p-6 border-b border-[#f0f3f4] dark:border-gray-800 flex justify-between items-center sticky top-0 bg-card-light dark:bg-card-dark z-10">
                        <h3 class="text-xl font-bold text-text-main dark:text-white flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">edit</span>
                            Editar Usuario
                        </h3>
                        <a class="text-text-secondary hover:text-primary transition-colors cursor-pointer" onclick="closeEditModal()">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Nombre</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">person</span>
                                    <input name="nombre" id="edit-nombre" class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white transition-shadow" placeholder="Nombre" type="text" required />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Apellido</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">person</span>
                                    <input name="apellido" id="edit-apellido" class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white transition-shadow" placeholder="Apellido" type="text" required />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Usuario</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">account_circle</span>
                                    <input name="usuario" id="edit-usuario" class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white transition-shadow" placeholder="Usuario" type="text" required />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Correo Electrónico</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">mail</span>
                                    <input name="email" id="edit-email" class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white transition-shadow" placeholder="juan@ejemplo.com" type="email" required />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Nueva Contraseña (Opcional)</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">lock</span>
                                    <input name="password" class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white transition-shadow" placeholder="******" type="password" />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Asignar Rol</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">badge</span>
                                    <select name="rol" id="edit-rol" class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white appearance-none cursor-pointer">
                                        <option value="Admin">Administrador</option>
                                    </select>
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-text-secondary pointer-events-none">expand_more</span>
                                </div>
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Cambiar Imagen</label>
                                <div class="flex items-center gap-4">
                                    <div id="edit-image-preview" class="size-12 rounded-full bg-cover bg-center border border-gray-200 dark:border-gray-700 shrink-0"></div>
                                    <div class="relative flex-1">
                                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">image</span>
                                        <input name="imagen" class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white transition-shadow" type="file" accept="image/*" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-background-light dark:bg-gray-800/50 border-t border-[#f0f3f4] dark:border-gray-800 flex justify-end gap-3 sticky bottom-0 z-10">
                        <a class="px-6 py-2.5 text-sm font-bold text-text-secondary hover:text-text-main transition-colors cursor-pointer" onclick="closeEditModal()">Cancelar</a>
                        <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-hover text-white text-sm font-bold rounded-lg shadow-lg shadow-primary/30 transition-all">Actualizar Usuario</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="hidden fixed inset-0 z-50 bg-black/50 items-center justify-center p-4 backdrop-blur-sm" id="preview-user-modal">
            <div class="bg-card-light dark:bg-card-dark w-full max-w-md rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                <div class="p-6 border-b border-[#f0f3f4] dark:border-gray-800 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-text-main dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">visibility</span>
                        Detalles del Usuario
                    </h3>
                    <a class="text-text-secondary hover:text-primary transition-colors cursor-pointer" onclick="closePreviewModal()">
                        <span class="material-symbols-outlined">close</span>
                    </a>
                </div>
                <div class="p-8 flex flex-col items-center">
                    <div id="preview-image" class="size-24 rounded-full bg-cover bg-center border-4 border-white shadow-lg mb-4"></div>
                    <h2 id="preview-name" class="text-2xl font-bold text-text-main dark:text-white mb-1"></h2>
                    <span id="preview-role" class="px-3 py-1 rounded-full text-xs font-bold uppercase mb-6"></span>

                    <div class="w-full space-y-4">
                        <div class="flex items-center gap-4 p-3 bg-background-light dark:bg-gray-800 rounded-lg">
                            <div class="bg-primary/10 p-2 rounded-lg text-primary">
                                <span class="material-symbols-outlined">mail</span>
                            </div>
                            <div>
                                <p class="text-xs text-text-secondary">Correo Electrónico</p>
                                <p id="preview-email" class="text-sm font-medium text-text-main dark:text-white"></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-3 bg-background-light dark:bg-gray-800 rounded-lg">
                            <div class="bg-primary/10 p-2 rounded-lg text-primary">
                                <span class="material-symbols-outlined">account_circle</span>
                            </div>
                            <div>
                                <p class="text-xs text-text-secondary">Usuario</p>
                                <p id="preview-username" class="text-sm font-medium text-text-main dark:text-white"></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-3 bg-background-light dark:bg-gray-800 rounded-lg">
                            <div class="bg-primary/10 p-2 rounded-lg text-primary">
                                <span class="material-symbols-outlined">calendar_today</span>
                            </div>
                            <div>
                                <p class="text-xs text-text-secondary">Fecha de Registro</p>
                                <p id="preview-date" class="text-sm font-medium text-text-main dark:text-white"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-background-light dark:bg-gray-800/50 border-t border-[#f0f3f4] dark:border-gray-800 flex justify-center">
                    <button class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-bold rounded-lg transition-all" onclick="closePreviewModal()">Cerrar</button>
                </div>
            </div>
        </div>

        <div class="hidden fixed inset-0 z-50 bg-black/50 items-center justify-center p-4 backdrop-blur-sm" id="delete-user-modal">
            <div class="bg-card-light dark:bg-card-dark w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                <div class="p-6 text-center space-y-4">
                    <div class="size-14 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto">
                        <span class="material-symbols-outlined text-3xl">warning</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-text-main dark:text-white mb-2">¿Eliminar Usuario?</h3>
                        <p class="text-text-secondary text-sm">Esta acción no se puede deshacer. El usuario y todos sus datos serán eliminados permanentemente.</p>
                    </div>
                </div>
                <div class="p-6 bg-background-light dark:bg-gray-800/50 border-t border-[#f0f3f4] dark:border-gray-800 flex justify-center gap-3">
                    <button class="px-6 py-2.5 text-sm font-bold text-text-secondary hover:text-text-main transition-colors" onclick="closeDeleteModal()">Cancelar</button>
                    <a id="confirm-delete-btn" href="#" class="px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-lg shadow-lg shadow-red-500/30 transition-all">Eliminar</a>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('search_input');
                if (searchInput) {
                    searchInput.addEventListener('keyup', function() {
                        let query = this.value;
                        let role = "<?php echo $role_filter; ?>";
                        
                        let formData = new FormData();
                        formData.append('search', query);
                        formData.append('role', role);
                        
                        fetch('buscar_usuarios_be.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            document.querySelector('tbody').innerHTML = data;
                        })
                        .catch(error => console.error('Error:', error));
                    });
                }
            });

            function openDeleteModal(id) {
                const modal = document.getElementById('delete-user-modal');
                const confirmBtn = document.getElementById('confirm-delete-btn');
                confirmBtn.href = `eliminar_usuario_be.php?id=${id}`;
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            }

            function closeDeleteModal() {
                const modal = document.getElementById('delete-user-modal');
                modal.classList.add('hidden');
                modal.style.display = 'none';
            }

            function openEditModal(data) {
                document.getElementById('edit-id').value = data.id;
                document.getElementById('edit-nombre').value = data.nombre;
                document.getElementById('edit-apellido').value = data.apellido;
                document.getElementById('edit-usuario').value = data.usuario;
                document.getElementById('edit-email').value = data.email;

                // Seleccionar el rol correcto
                const rolSelect = document.getElementById('edit-rol');
                const rol = data.rol.charAt(0).toUpperCase() + data.rol.slice(1).toLowerCase(); // Capitalizar
                for (let i = 0; i < rolSelect.options.length; i++) {
                    if (rolSelect.options[i].value.toLowerCase() === data.rol.toLowerCase()) {
                        rolSelect.selectedIndex = i;
                        break;
                    }
                }

                // Previsualizar imagen actual
                let imagenUrl = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.nombre + ' ' + data.apellido) + '&background=random';
                if (data.imagen) {
                    imagenUrl = data.imagen.startsWith('assets/') ? '../../' + data.imagen : '../../assets/img/usuarios/' + data.imagen;
                }
                document.getElementById('edit-image-preview').style.backgroundImage = `url('${imagenUrl}')`;

                const modal = document.getElementById('edit-user-modal');
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            }

            function closeEditModal() {
                const modal = document.getElementById('edit-user-modal');
                modal.classList.add('hidden');
                modal.style.display = 'none';
            }

            function openPreviewModal(data) {
                document.getElementById('preview-name').textContent = data.nombre + ' ' + data.apellido;
                document.getElementById('preview-email').textContent = data.email;
                document.getElementById('preview-username').textContent = data.usuario;
                document.getElementById('preview-date').textContent = new Date(data.reg_date).toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                // Imagen
                let imagenUrl = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.nombre + ' ' + data.apellido) + '&background=random';
                if (data.imagen) {
                    imagenUrl = data.imagen.startsWith('assets/') ? '../../' + data.imagen : '../../assets/img/usuarios/' + data.imagen;
                }
                document.getElementById('preview-image').style.backgroundImage = `url('${imagenUrl}')`;

                // Rol y estilos
                const roleBadge = document.getElementById('preview-role');
                roleBadge.textContent = data.rol;
                if (data.rol.toLowerCase() === 'admin') {
                    roleBadge.className = 'px-3 py-1 rounded-full text-xs font-bold uppercase mb-6 bg-blue-100 text-blue-700';
                } else {
                    roleBadge.className = 'px-3 py-1 rounded-full text-xs font-bold uppercase mb-6 bg-gray-100 text-gray-700';
                }

                const modal = document.getElementById('preview-user-modal');
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            }

            function closePreviewModal() {
                const modal = document.getElementById('preview-user-modal');
                modal.classList.add('hidden');
                modal.style.display = 'none';
            }

            // Driver.js Tour
            document.addEventListener('DOMContentLoaded', function() {
                const driver = window.driver.js.driver;

                const driverObj = driver({
                    showProgress: true,
                    nextBtnText: 'Siguiente',
                    prevBtnText: 'Anterior',
                    doneBtnText: 'Finalizar',
                    steps: [
                        { element: '#users-header', popover: { title: 'Gestión de Usuarios', description: 'Aquí puedes administrar todos los usuarios registrados en la plataforma.' } },
                        { element: '#add-user-btn', popover: { title: 'Nuevo Usuario', description: 'Haz clic aquí para registrar manualmente un nuevo administrador o usuario.' } },
                        { element: '#filter-tabs', popover: { title: 'Filtros Rápidos', description: 'Navega fácilmente entre todos los usuarios, solo huéspedes o solo administradores.' } },
                        { element: '#search-form', popover: { title: 'Búsqueda Avanzada', description: 'Encuentra usuarios rápidamente por su nombre, correo electrónico o nombre de usuario.' } },
                        { element: '#users-section table', popover: { title: 'Lista de Usuarios', description: 'Consulta la información detallada, roles y estado de cada usuario en esta tabla.' } },
                        { element: '#users-section table tbody tr:first-child td:last-child', popover: { title: 'Acciones', description: 'Usa estos botones para ver detalles, editar información o eliminar un usuario.' } }
                    ]
                });

                document.getElementById('start-tour-btn').addEventListener('click', () => {
                    driverObj.drive();
                });
            });
        </script>
    </div>

</body>

</html>