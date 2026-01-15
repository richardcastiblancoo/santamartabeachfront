<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Admin') {
    echo '<script>alert("Acceso denegado. Por favor, inicia sesión como administrador."); window.location = "../../auth/login.php";</script>';
    die();
}

include '../../auth/conexion_be.php';

// Consultas para las tarjetas y secciones
$total_reservas = $conn->query("SELECT COUNT(*) as count FROM reservas")->fetch_assoc()['count'];
$total_pqr = $conn->query("SELECT COUNT(*) as count FROM pqr")->fetch_assoc()['count'];
$pqr_pendientes = $conn->query("SELECT COUNT(*) as count FROM pqr WHERE estado = 'Pendiente'")->fetch_assoc()['count'];
$total_usuarios = $conn->query("SELECT COUNT(*) as count FROM usuarios WHERE rol != 'Admin'")->fetch_assoc()['count'];
// $total_apartamentos = $conn->query("SELECT COUNT(*) as count FROM apartamentos")->fetch_assoc()['count']; // Si se necesitara el total

// Obtener apartamentos
$apartamentos_res = $conn->query("SELECT * FROM apartamentos LIMIT 6");

// Obtener reservas recientes
$reservas_res = $conn->query("SELECT r.*, u.nombre, u.apellido, u.email, a.titulo, a.imagen_principal FROM reservas r JOIN usuarios u ON r.usuario_id = u.id JOIN apartamentos a ON r.apartamento_id = a.id ORDER BY r.fecha_creacion DESC LIMIT 10");

// Obtener PQR recientes
$pqr_res = $conn->query("SELECT p.*, u.nombre, u.apellido, u.imagen AS usuario_imagen FROM pqr p JOIN usuarios u ON p.usuario_id = u.id ORDER BY p.fecha_creacion DESC LIMIT 5");

?>
<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Panel de Administrador</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>
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
                    <span class="ml-auto bg-primary text-white text-xs font-bold px-2 py-0.5 rounded-full">4</span>
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
                    <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 shrink-0" style='background-image: url("<?php echo !empty($_SESSION['imagen']) ? '../../assets/img/usuarios/' . $_SESSION['imagen'] : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCzvH7sb1-qStnSjyW_73yFZuyDV7-Ez2-2LB3V9LiRgrVaP0tp_Kk2bt9RvnuHLpnRQe7JiDm7bwq_2wnzXuXZ-R-5XcOiQI8b3n76MYdNVwUFnHzbUBz8DnJ3mOJqVBJB3XZLkdjkLWIA3bK2AZVnmo-mlgAWRk_hf_1QVYuCIa9mk0_SN_rZwpFYSMXx9CGSEZ-Q5GtTTRX-vx3RJZ8qzgct2lexQnXKpF0xitcnMVaPElXaFz5LeT0rtCIzJ-EXlYRcbDbwcMM'; ?>");'></div>
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
                    <h2 class="text-lg font-bold text-text-main dark:text-white hidden sm:block">Panel de Control</h2>
                </div>
                <div class="flex items-center gap-4 flex-1 justify-end">

                    <div class="flex items-center gap-2">
                        <button id="start-tour" class="size-10 flex items-center justify-center rounded-full hover:bg-background-light dark:hover:bg-gray-800 text-text-secondary transition-colors">
                            <span class="material-symbols-outlined">help</span>
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
                        <?php while ($apt = $apartamentos_res->fetch_assoc()): ?>
                        <div class="bg-card-light dark:bg-card-dark p-4 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm flex items-center gap-4 hover:border-primary/30 transition-colors">
                            <div class="w-20 h-20 rounded-lg bg-cover bg-center shrink-0" style='background-image: url("<?php echo !empty($apt['imagen_principal']) ? '../../assets/img/apartamentos/' . $apt['imagen_principal'] : 'https://placehold.co/400'; ?>");'></div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <div class="truncate">
                                        <h4 class="font-bold text-text-main dark:text-white truncate"><?php echo $apt['titulo']; ?></h4>
                                        <p class="text-[11px] text-text-secondary"><?php echo $apt['ubicacion']; ?> • <?php echo $apt['habitaciones']; ?> Hab • <?php echo $apt['capacidad']; ?> Pax</p>
                                    </div>
                                    <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded-full font-bold">Activo</span>
                                </div>
                                <div class="mt-2 flex gap-3">
                                    <button onclick="openViewModal(<?php echo $apt['id']; ?>)" class="text-[11px] font-medium text-text-secondary hover:text-primary flex items-center gap-1"><span class="material-symbols-outlined text-xs">visibility</span> Ver</button>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </section>
                <section class="pt-8 border-t border-[#f0f3f4] dark:border-gray-800" id="bookings-section">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-text-main dark:text-white flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">calendar_month</span>
                            Control de Reservas
                        </h2>
                        <div class="relative">
                            <select class="pl-4 pr-10 py-2 text-xs border-none bg-white dark:bg-gray-800 rounded-lg focus:ring-1 focus:ring-primary shadow-sm appearance-none">
                                <option>Todas las reservas</option>
                                <option>Confirmadas</option>
                                <option>Pendientes</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-text-secondary text-base pointer-events-none">expand_more</span>
                        </div>
                    </div>
                    <div class="bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-background-light dark:bg-gray-800/50 text-text-secondary dark:text-gray-400 text-[10px] uppercase tracking-wider">
                                        <th class="px-6 py-3 font-semibold">Propiedad</th>
                                        <th class="px-6 py-3 font-semibold">Huésped</th>
                                        <th class="px-6 py-3 font-semibold">Fechas</th>
                                        <th class="px-6 py-3 font-semibold">Estado</th>
                                        <th class="px-6 py-3 font-semibold text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#f0f3f4] dark:divide-gray-800 text-sm">
                                    <?php if ($reservas_res->num_rows > 0): ?>
                                    <?php while ($reserva = $reservas_res->fetch_assoc()): ?>
                                    <tr class="group hover:bg-background-light dark:hover:bg-gray-800 transition-colors">
                                        <td class="px-6 py-3">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded bg-cover bg-center shrink-0" style='background-image: url("<?php echo !empty($reserva['imagen_principal']) ? '../../assets/img/apartamentos/' . $reserva['imagen_principal'] : 'https://placehold.co/100'; ?>");'></div>
                                                <span class="font-bold text-xs text-text-main dark:text-white"><?php echo $reserva['titulo']; ?></span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-3">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-xs text-text-main dark:text-white"><?php echo $reserva['nombre'] . ' ' . $reserva['apellido']; ?></span>
                                                <span class="text-[10px] text-text-secondary"><?php echo $reserva['email']; ?></span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-text-main dark:text-white font-medium text-xs">
                                            <?php echo date('d M', strtotime($reserva['fecha_inicio'])) . ' - ' . date('d M', strtotime($reserva['fecha_fin'])); ?>
                                        </td>
                                        <td class="px-6 py-3">
                                            <?php
                                            $estadoClass = '';
                                            switch($reserva['estado']) {
                                                case 'Confirmada': $estadoClass = 'bg-green-100 text-green-800'; break;
                                                case 'Pendiente': $estadoClass = 'bg-yellow-100 text-yellow-800'; break;
                                                case 'Cancelada': $estadoClass = 'bg-red-100 text-red-800'; break;
                                                case 'Completada': $estadoClass = 'bg-blue-100 text-blue-800'; break;
                                                default: $estadoClass = 'bg-gray-100 text-gray-800';
                                            }
                                            ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold <?php echo $estadoClass; ?>"><?php echo $reserva['estado']; ?></span>
                                        </td>
                                        <td class="px-6 py-3 text-right">
                                            <button class="bg-primary/10 text-primary hover:bg-primary/20 px-2.5 py-1 rounded text-[10px] font-bold transition-colors">Detalles</button>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-text-secondary dark:text-gray-400">
                                            <div class="flex flex-col items-center gap-2">
                                                <span class="material-symbols-outlined text-4xl opacity-20">calendar_month</span>
                                                <span class="text-sm">No hay reservas recientes</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
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
                        <?php while ($pqr = $pqr_res->fetch_assoc()): ?>
                        <?php 
                            $userImg = !empty($pqr['usuario_imagen']) ? '../../assets/img/usuarios/' . $pqr['usuario_imagen'] : 'https://placehold.co/100';
                        ?>
                        <div class="p-4 hover:bg-background-light dark:hover:bg-gray-800 transition-colors cursor-pointer relative group flex items-start gap-4">
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-baseline mb-0.5">
                                    <p class="font-bold text-sm text-text-main dark:text-white"><?php echo $pqr['nombre'] . ' ' . $pqr['apellido']; ?></p>
                                    <p class="text-[10px] text-text-secondary dark:text-gray-400 font-medium uppercase"><?php echo date('d M H:i', strtotime($pqr['fecha_creacion'])); ?></p>
                                </div>
                                <h5 class="text-xs font-semibold text-text-main dark:text-gray-200 mb-0.5"><?php echo $pqr['asunto']; ?></h5>
                                <p class="text-xs text-text-secondary dark:text-gray-400 line-clamp-1"><?php echo $pqr['mensaje']; ?></p>
                                <div class="mt-2 flex gap-2">
                                    <button onclick="openResponseModal(<?php echo $pqr['id']; ?>, '<?php echo addslashes($pqr['asunto']); ?>', '<?php echo addslashes($pqr['nombre'] . ' ' . $pqr['apellido']); ?>')" class="text-[10px] font-bold bg-primary text-white px-3 py-1 rounded hover:bg-primary-hover transition-colors">Responder</button>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <!-- Edit Apartment Modal -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeEditModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-card-dark rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="editForm" action="actualizar_apartamento.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="px-4 pt-5 pb-4 bg-white dark:bg-card-dark sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Editar Apartamento</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título</label>
                                <input type="text" name="titulo" id="edit_titulo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ubicación</label>
                                    <input type="text" name="ubicacion" id="edit_ubicacion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio</label>
                                    <input type="number" name="precio" id="edit_precio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Habitaciones</label>
                                    <input type="number" name="habitaciones" id="edit_habitaciones" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Baños</label>
                                    <input type="number" name="banos" id="edit_banos" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Capacidad</label>
                                    <input type="number" name="capacidad" id="edit_capacidad" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                                <textarea name="descripcion" id="edit_descripcion" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">Guardar Cambios</button>
                        <button type="button" onclick="closeEditModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Apartment Modal -->
    <div id="viewModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeViewModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-card-dark rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white dark:bg-card-dark">
                    <div class="relative h-64 w-full bg-gray-100 dark:bg-gray-800 group">
                        <div id="view_image_container" class="h-full w-full bg-cover bg-center transition-opacity duration-300"></div>
                        <div id="view_video_container" class="hidden h-full w-full flex items-center justify-center bg-black"></div>
                        
                        <!-- Navigation Arrows -->
                        <button id="prev-slide" onclick="prevSlide()" class="absolute left-0 top-0 bottom-0 px-4 flex items-center justify-center bg-gradient-to-r from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:from-black/70">
                            <span class="material-symbols-outlined text-white text-3xl">chevron_left</span>
                        </button>
                        <button id="next-slide" onclick="nextSlide()" class="absolute right-0 top-0 bottom-0 px-4 flex items-center justify-center bg-gradient-to-l from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:from-black/70">
                            <span class="material-symbols-outlined text-white text-3xl">chevron_right</span>
                        </button>
                        
                        <!-- Counter -->
                        <div class="absolute bottom-4 right-4 bg-black/60 backdrop-blur-sm text-white text-xs font-medium px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1">
                            <span class="material-symbols-outlined text-[10px]">photo_library</span>
                            <span id="slide-counter">1/1</span>
                        </div>
                    </div>
                    <div class="px-6 py-4">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2" id="view_titulo"></h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">location_on</span>
                            <span id="view_ubicacion"></span>
                        </p>
                        <div class="flex gap-4 mb-6 text-sm text-gray-600 dark:text-gray-300">
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">bed</span> <span id="view_habitaciones"></span> Hab</span>
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">bathtub</span> <span id="view_banos"></span> Baños</span>
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">group</span> <span id="view_capacidad"></span> Personas</span>
                        </div>
                        <div class="prose dark:prose-invert max-w-none mb-6">
                            <p id="view_descripcion" class="text-gray-600 dark:text-gray-300"></p>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="text-2xl font-bold text-primary" id="view_precio"></div>
                            <button type="button" onclick="closeViewModal()" class="inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:w-auto sm:text-sm">
                                Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PQR Response Modal -->
    <div id="responseModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeResponseModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-card-dark rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="responseForm" action="responder_pqr_be.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="pqr_id" id="modal_pqr_id">
                    <div class="px-4 pt-5 pb-4 bg-white dark:bg-card-dark sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full mt-3 text-center sm:mt-0 sm:text-left">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">Responder PQR</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                        Respondiendo a: <span id="modal_user_name" class="font-bold"></span><br>
                                        Asunto: <span id="modal_subject" class="font-bold"></span>
                                    </p>
                                    <div class="mb-4">
                                        <label for="mensaje" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tu Respuesta</label>
                                        <textarea id="mensaje" name="mensaje" rows="4" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" required></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Actualizar Estado</label>
                                        <select id="estado" name="estado" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                            <option value="En Progreso">En Progreso</option>
                                            <option value="Resuelto">Resuelto</option>
                                            <option value="Pendiente">Pendiente</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label for="adjunto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adjuntar Archivo (Opcional)</label>
                                        <input type="file" id="adjunto" name="adjunto" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                            Enviar Respuesta
                        </button>
                        <button type="button" onclick="closeResponseModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
    <script>
        function openResponseModal(id, subject, name) {
            document.getElementById('modal_pqr_id').value = id;
            document.getElementById('modal_subject').textContent = subject;
            document.getElementById('modal_user_name').textContent = name;
            document.getElementById('responseModal').classList.remove('hidden');
        }

        function closeResponseModal() {
            document.getElementById('responseModal').classList.add('hidden');
            document.getElementById('responseForm').reset();
        }

        // Edit Modal Functions
        function openEditModal(id) {
            fetch(`get_apartamento.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        document.getElementById('edit_id').value = data.id;
                        document.getElementById('edit_titulo').value = data.titulo;
                        document.getElementById('edit_ubicacion').value = data.ubicacion;
                        document.getElementById('edit_precio').value = data.precio;
                        document.getElementById('edit_habitaciones').value = data.habitaciones;
                        document.getElementById('edit_banos').value = data.banos;
                        document.getElementById('edit_capacidad').value = data.capacidad;
                        document.getElementById('edit_descripcion').value = data.descripcion;
                        document.getElementById('editModal').classList.remove('hidden');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // View Modal Functions
        let currentGalleryIndex = 0;
        let currentGalleryItems = [];

        function openViewModal(id) {
            // Reset state
            currentGalleryIndex = 0;
            currentGalleryItems = [];
            
            fetch(`get_apartamento.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        document.getElementById('view_titulo').textContent = data.titulo;
                        document.getElementById('view_ubicacion').textContent = data.ubicacion;
                        document.getElementById('view_precio').textContent = '$' + new Intl.NumberFormat().format(data.precio) + ' / noche';
                        document.getElementById('view_habitaciones').textContent = data.habitaciones;
                        document.getElementById('view_banos').textContent = data.banos;
                        document.getElementById('view_capacidad').textContent = data.capacidad;
                        document.getElementById('view_descripcion').textContent = data.descripcion;
                        
                        // Add main image first
                        if (data.imagen_principal) {
                            currentGalleryItems.push({
                                type: 'imagen',
                                fullPath: `../../assets/img/apartamentos/${data.imagen_principal}`
                            });
                        } else {
                            currentGalleryItems.push({
                                type: 'imagen',
                                fullPath: "https://placehold.co/600x400"
                            });
                        }
                        
                        // Fetch gallery items
                        return fetch(`obtener_galeria_be.php?id=${id}`);
                    }
                })
                .then(response => {
                    if(response) return response.json();
                })
                .then(galleryData => {
                    if (galleryData && Array.isArray(galleryData)) {
                        galleryData.forEach(item => {
                            let path = '';
                            if(item.tipo === 'imagen') path = `../../assets/img/apartamentos/${item.ruta}`;
                            else if(item.tipo === 'video') path = `../../assets/video/apartamentos/${item.ruta}`;
                            
                            currentGalleryItems.push({
                                type: item.tipo,
                                fullPath: path
                            });
                        });
                    }
                    
                    updateCarousel();
                    document.getElementById('viewModal').classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
        }

        function updateCarousel() {
            if (currentGalleryItems.length === 0) return;
            
            const item = currentGalleryItems[currentGalleryIndex];
            const imgContainer = document.getElementById('view_image_container');
            const vidContainer = document.getElementById('view_video_container');
            const counter = document.getElementById('slide-counter');
            const prevBtn = document.getElementById('prev-slide');
            const nextBtn = document.getElementById('next-slide');
            
            // Update counter
            counter.textContent = `${currentGalleryIndex + 1}/${currentGalleryItems.length}`;
            
            // Toggle buttons visibility
            if (currentGalleryItems.length > 1) {
                prevBtn.classList.remove('hidden');
                nextBtn.classList.remove('hidden');
            } else {
                prevBtn.classList.add('hidden');
                nextBtn.classList.add('hidden');
            }
            
            if (item.type === 'imagen') {
                imgContainer.style.backgroundImage = `url('${item.fullPath}')`;
                imgContainer.classList.remove('hidden');
                vidContainer.classList.add('hidden');
                vidContainer.innerHTML = ''; // Stop any playing video
            } else {
                imgContainer.classList.add('hidden');
                vidContainer.classList.remove('hidden');
                vidContainer.innerHTML = `<video src="${item.fullPath}" controls class="h-full w-full object-contain" autoplay></video>`;
            }
        }

        function nextSlide() {
            if (currentGalleryItems.length <= 1) return;
            currentGalleryIndex = (currentGalleryIndex + 1) % currentGalleryItems.length;
            updateCarousel();
        }

        function prevSlide() {
            if (currentGalleryItems.length <= 1) return;
            currentGalleryIndex = (currentGalleryIndex - 1 + currentGalleryItems.length) % currentGalleryItems.length;
            updateCarousel();
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
            // Stop any video playing
            document.getElementById('view_video_container').innerHTML = '';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const driver = window.driver.js.driver;

            const driverObj = driver({
                showProgress: true,
                animate: true,
                nextBtnText: 'Siguiente',
                prevBtnText: 'Anterior',
                doneBtnText: 'Finalizar',
                steps: [
                    { 
                        element: 'body', 
                        popover: { 
                            title: 'Bienvenido al Panel de Administrador', 
                            description: 'Este es un recorrido rápido para familiarizarte con las funcionalidades principales del dashboard.' 
                        } 
                    },
                    { 
                        element: 'aside', 
                        popover: { 
                            title: 'Menú de Navegación', 
                            description: 'Desde aquí puedes acceder a todas las secciones del sistema: Apartamentos, Reservas, Usuarios y Configuración.' 
                        } 
                    },
                    { 
                        element: '#dashboard-section', 
                        popover: { 
                            title: 'Resumen Administrativo', 
                            description: 'Visualiza rápidamente los indicadores clave como el total de reservas y PQR pendientes.' 
                        } 
                    },
                    { 
                        element: '#apartments-section', 
                        popover: { 
                            title: 'Gestión de Apartamentos', 
                            description: 'Administra tus propiedades. Puedes ver el listado, filtrar, agregar nuevos apartamentos o editar los existentes.' 
                        } 
                    },
                    { 
                        element: '#bookings-section', 
                        popover: { 
                            title: 'Control de Reservas', 
                            description: 'Gestiona las reservas. Revisa el estado (Confirmada, Pendiente, etc.), detalles del huésped y fechas.' 
                        } 
                    },
                    { 
                        element: '#pqr-section', 
                        popover: { 
                            title: 'Bandeja de PQR', 
                            description: 'Atiende las Peticiones, Quejas y Reclamos de los usuarios. Puedes ver el detalle y responder directamente.' 
                        } 
                    },
                    { 
                        element: '#start-tour', 
                        popover: { 
                            title: 'Ayuda y Recorrido', 
                            description: 'Si necesitas ver este recorrido nuevamente, puedes hacer clic en este botón de ayuda.' 
                        } 
                    }
                ]
            });

            const startTourBtn = document.getElementById('start-tour');
            if (startTourBtn) {
                startTourBtn.addEventListener('click', function() {
                    driverObj.drive();
                });
            }
            
            // Opcional: Iniciar automáticamente si es la primera vez (puedes usar localStorage)
            // if (!localStorage.getItem('tour_visto')) {
            //     driverObj.drive();
            //     localStorage.setItem('tour_visto', 'true');
            // }
        });
    </script>
</body>

</html>