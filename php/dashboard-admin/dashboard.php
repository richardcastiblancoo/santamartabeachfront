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
// $total_apartamentos = $conn->query("SELECT COUNT(*) as count FROM apartamentos")->fetch_assoc()['count']; // Si se necesitara el total

// Obtener apartamentos
$apartamentos_res = $conn->query("SELECT * FROM apartamentos LIMIT 6");

// Obtener reservas recientes
$reservas_res = $conn->query("SELECT r.*, u.nombre, u.apellido, u.email, a.titulo, a.imagen_principal FROM reservas r JOIN usuarios u ON r.usuario_id = u.id JOIN apartamentos a ON r.apartamento_id = a.id ORDER BY r.fecha_creacion DESC LIMIT 10");

// Obtener PQR recientes
$pqr_res = $conn->query("SELECT p.*, u.nombre, u.apellido, u.imagen FROM pqr p JOIN usuarios u ON p.usuario_id = u.id ORDER BY p.fecha_creacion DESC LIMIT 5");

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
                        <button class="relative size-10 flex items-center justify-center rounded-full hover:bg-background-light dark:hover:bg-gray-800 text-text-secondary transition-colors">
                            <span class="material-symbols-outlined">notifications</span>
                            <span class="absolute top-2.5 right-2.5 size-2 bg-red-500 rounded-full border border-white dark:border-gray-900"></span>
                        </button>
                        <button class="size-10 flex items-center justify-center rounded-full hover:bg-background-light dark:hover:bg-gray-800 text-text-secondary transition-colors">
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
                            <a class="mt-4 text-xs font-bold text-primary hover:underline flex items-center gap-1 group/link" href="#bookings-section">
                                Gestionar reservas
                                <span class="material-symbols-outlined text-xs group-hover/link:translate-x-0.5 transition-transform">arrow_forward</span>
                            </a>
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
                            <a class="mt-4 text-xs font-bold text-primary hover:underline flex items-center gap-1 group/link" href="#pqr-section">
                                Atender solicitudes
                                <span class="material-symbols-outlined text-xs group-hover/link:translate-x-0.5 transition-transform">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </section>
                <section class="pt-8 border-t border-[#f0f3f4] dark:border-gray-800" id="apartments-section">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-text-main dark:text-white flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">apartment</span>
                            Gestión de Apartamentos
                        </h2>
                        <div class="flex gap-2">
                            <button class="px-4 py-2 text-xs font-medium text-text-secondary bg-white border border-[#f0f3f4] hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 rounded-lg transition-colors">Filtros</button>
                            <button class="px-4 py-2 text-xs font-medium text-white bg-primary hover:bg-primary-hover rounded-lg transition-colors flex items-center gap-2 shadow-lg shadow-primary/20">
                                <span class="material-symbols-outlined text-sm">add</span> Nuevo Apartamento
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        <?php while ($apt = $apartamentos_res->fetch_assoc()): ?>
                        <div class="bg-card-light dark:bg-card-dark p-4 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm flex items-center gap-4 hover:border-primary/30 transition-colors">
                            <div class="w-20 h-20 rounded-lg bg-cover bg-center shrink-0" style='background-image: url("<?php echo !empty($apt['imagen_principal']) ? $apt['imagen_principal'] : 'https://placehold.co/400'; ?>");'></div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <div class="truncate">
                                        <h4 class="font-bold text-text-main dark:text-white truncate"><?php echo $apt['titulo']; ?></h4>
                                        <p class="text-[11px] text-text-secondary"><?php echo $apt['ubicacion']; ?> • <?php echo $apt['habitaciones']; ?> Hab • <?php echo $apt['capacidad']; ?> Pax</p>
                                    </div>
                                    <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded-full font-bold">Activo</span>
                                </div>
                                <div class="mt-2 flex gap-3">
                                    <button class="text-[11px] font-medium text-text-secondary hover:text-primary flex items-center gap-1"><span class="material-symbols-outlined text-xs">edit</span> Editar</button>
                                    <button class="text-[11px] font-medium text-text-secondary hover:text-primary flex items-center gap-1"><span class="material-symbols-outlined text-xs">visibility</span> Ver</button>
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
                                                <div class="w-8 h-8 rounded bg-cover bg-center shrink-0" style='background-image: url("<?php echo !empty($reserva['imagen_principal']) ? $reserva['imagen_principal'] : 'https://placehold.co/100'; ?>");'></div>
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
                        <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">3 Nuevas</span>
                    </div>
                    <div class="bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm flex flex-col divide-y divide-[#f0f3f4] dark:divide-gray-800">
                        <?php while ($pqr = $pqr_res->fetch_assoc()): ?>
                        <div class="p-4 hover:bg-background-light dark:hover:bg-gray-800 transition-colors cursor-pointer relative group flex items-start gap-4">
                            <div class="bg-cover bg-center rounded-full size-10 shrink-0 border border-gray-100 shadow-sm" style='background-image: url("<?php echo !empty($pqr['imagen']) ? '../../assets/img/usuarios/' . $pqr['imagen'] : 'https://placehold.co/100'; ?>");'></div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-baseline mb-0.5">
                                    <p class="font-bold text-sm text-text-main dark:text-white"><?php echo $pqr['nombre'] . ' ' . $pqr['apellido']; ?></p>
                                    <p class="text-[10px] text-text-secondary font-medium uppercase"><?php echo date('d M H:i', strtotime($pqr['fecha_creacion'])); ?></p>
                                </div>
                                <h5 class="text-xs font-semibold text-text-main mb-0.5"><?php echo $pqr['asunto']; ?></h5>
                                <p class="text-xs text-text-secondary dark:text-gray-400 line-clamp-1"><?php echo $pqr['mensaje']; ?></p>
                                <div class="mt-2 flex gap-2">
                                    <button class="text-[10px] font-bold bg-primary text-white px-3 py-1 rounded hover:bg-primary-hover transition-colors">Responder</button>
                                    <button class="text-[10px] font-bold bg-gray-100 dark:bg-gray-700 text-text-secondary px-3 py-1 rounded hover:bg-gray-200 transition-colors">Ver hilo</button>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </section>
            </main>
        </div>
    </div>

</body>

</html>