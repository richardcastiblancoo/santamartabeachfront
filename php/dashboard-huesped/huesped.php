<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo '<script>alert("Por favor inicia sesión"); window.location = "../../auth/login.php";</script>';
    die();
}

include '../../auth/conexion_be.php';

// Obtener apartamentos publicados
$sql_apartamentos = "SELECT * FROM apartamentos ORDER BY fecha_creacion DESC";
$result_apartamentos = $conn->query($sql_apartamentos);

// Obtener PQR del usuario
$usuario_id = $_SESSION['id'];
$sql_pqr = "SELECT * FROM pqr WHERE usuario_id = '$usuario_id' ORDER BY fecha_creacion DESC";
$result_pqr = $conn->query($sql_pqr);

$pqr_list = [];
$num_pqr_activas = 0;
if ($result_pqr && $result_pqr->num_rows > 0) {
    while($row = $result_pqr->fetch_assoc()) {
        $pqr_list[] = $row;
        if($row['estado'] != 'Resuelto') {
            $num_pqr_activas++;
        }
    }
}
?>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Panel de Control - Santamartabeachfront</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #475569;
        }
        
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
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

<body class="bg-background-light dark:bg-background-dark font-display text-[#111618] dark:text-white flex flex-col min-h-screen overflow-x-hidden">
    <header class="sticky top-0 z-50 flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#e5e7eb] dark:border-b-gray-800 bg-white dark:bg-[#1a2c35] px-4 md:px-10 py-3 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="size-8 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl">beach_access</span>
            </div>
            <h2 class="hidden md:block text-[#111618] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Santamartabeachfront</h2>
        </div>

        <div class="flex flex-1 justify-end gap-4 md:gap-8 items-center">
            <div class="flex bg-gray-100 dark:bg-gray-800 p-1 rounded-lg">
                <button onclick="changeLanguage('es')" id="btn-es" class="px-3 py-1 text-xs font-bold rounded-md transition-all bg-primary text-white">ES</button>
                <button onclick="changeLanguage('en')" id="btn-en" class="px-3 py-1 text-xs font-bold rounded-md transition-all text-gray-500 hover:text-primary">EN</button>
            </div>

            <nav class="hidden md:flex items-center gap-6">
                <a data-key="nav-reservations" class="text-[#111618] dark:text-gray-200 text-sm font-medium hover:text-primary transition-colors" href="#">Mis Reservas</a>
                <a data-key="nav-favorites" class="text-[#111618] dark:text-gray-200 text-sm font-medium hover:text-primary transition-colors" href="#">Favoritos</a>
            </nav>
            <div class="flex items-center gap-3 relative">
                <button id="notification-btn" class="flex items-center justify-center rounded-full size-10 hover:bg-gray-100 dark:hover:bg-gray-800 text-[#111618] dark:text-white transition-colors relative" onclick="toggleNotifications()">
                    <span class="material-symbols-outlined">notifications</span>
                    <span id="notification-badge" class="absolute top-2 right-2 size-2 bg-red-500 rounded-full border border-white dark:border-[#1a2c35] hidden"></span>
                </button>
                
                <!-- Dropdown de Notificaciones -->
                <div id="notification-dropdown" class="absolute top-12 right-0 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 hidden z-50 overflow-hidden">
                    <div class="p-3 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-bold text-sm text-[#111618] dark:text-white">Notificaciones</h3>
                        <span class="text-xs text-primary font-medium cursor-pointer hover:underline" onclick="markAllRead()">Marcar leídas</span>
                    </div>
                    <div id="notification-list" class="max-h-[300px] overflow-y-auto">
                        <!-- Items insertados vía JS -->
                    </div>
                </div>

                <div onclick="openConfigModal()" class="bg-center bg-no-repeat bg-cover rounded-full size-10 border-2 border-white dark:border-gray-700 shadow-sm cursor-pointer transition-transform hover:scale-105" style='background-image: url("<?php echo !empty($_SESSION['imagen']) ? '../../' . $_SESSION['imagen'] : 'https://avatar.iran.liara.run/public/30'; ?>");'>
                </div>
                <a href="../../auth/cerrar_sesion.php" class="flex items-center justify-center rounded-full size-10 hover:bg-red-50 dark:hover:bg-red-900/20 text-gray-500 hover:text-red-600 transition-colors" title="Cerrar Sesión">
                    <span class="material-symbols-outlined">logout</span>
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1 w-full max-w-[1200px] mx-auto px-4 md:px-6 lg:px-8 py-8 space-y-8">
        <section class="flex flex-col gap-2">
            <p class="text-[#111618] dark:text-white text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">
                <span data-key="welcome-user">Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
            </p>
            <p data-key="welcome-sub" class="text-[#617c89] dark:text-gray-400 text-base font-normal">Bienvenido a tu panel de control. Tu próxima aventura te espera.</p>
        </section>

        <section class="relative overflow-hidden rounded-2xl shadow-lg group">
            <div class="flex min-h-[400px] flex-col gap-6 bg-cover bg-center bg-no-repeat items-start justify-end px-6 pb-10 md:px-10 md:pb-12 transition-transform duration-700 hover:scale-[1.01]" style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.6) 100%), url("https://images.unsplash.com/photo-1512100356956-c1226c3af3e8?q=80&w=1964&auto=format&fit=crop");'>
                <div class="absolute top-6 right-6 bg-white/90 dark:bg-black/80 backdrop-blur-sm px-4 py-2 rounded-lg shadow-md flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">schedule</span>
                    <span data-key="checkin-days" class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-white">Check-in: 3 Días</span>
                </div>
                <div class="flex flex-col gap-2 text-left max-w-2xl">
                    <h1 data-key="hero-title" class="text-white text-3xl md:text-5xl font-black leading-tight tracking-[-0.033em] drop-shadow-md">
                        Tu escapada a Santa Marta
                    </h1>
                    <h2 data-key="hero-sub" class="text-gray-100 text-base md:text-lg font-medium leading-normal drop-shadow-sm mb-4">
                        Apartamento Vista al Mar - Edificio El Rodadero. Todo está listo para tu llegada.
                    </h2>
                    <div class="flex flex-wrap gap-3">
                        <button class="flex items-center justify-center rounded-lg h-12 px-6 bg-primary hover:bg-sky-500 text-white text-base font-bold transition-all shadow-md hover:shadow-lg">
                            <span class="mr-2 material-symbols-outlined">key</span>
                            <span data-key="btn-arrival">Ver detalles de llegada</span>
                        </button>
                        <button class="flex items-center justify-center rounded-lg h-12 px-6 bg-white/20 hover:bg-white/30 backdrop-blur-md text-white border border-white/40 text-base font-bold transition-all">
                            <span class="mr-2 material-symbols-outlined">menu_book</span>
                            <span data-key="btn-guide">Guía de la casa</span>
                        </button>
                    </div>
                </div>

                <!-- Sección de Apartamentos Disponibles -->
                <div class="mt-8 border-t border-[#dbe2e6] dark:border-gray-700 pt-6">
                    <h3 data-key="available-apartments" class="text-[#111618] dark:text-white text-xl font-bold mb-4">Apartamentos Disponibles</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php if ($result_apartamentos->num_rows > 0): ?>
                            <?php while($apto = $result_apartamentos->fetch_assoc()): ?>
                                <div class="flex flex-col rounded-xl bg-white dark:bg-[#1a2c35] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden group hover:shadow-md transition-all">
                                    <div class="w-full h-48 bg-center bg-no-repeat bg-cover relative" style="background-image: url('../../assets/img/apartamentos/<?php echo htmlspecialchars($apto['imagen_principal']); ?>');">
                                        <div class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded shadow">
                                            $<?php echo number_format($apto['precio'], 0, ',', '.'); ?>
                                        </div>
                                    </div>
                                    <div class="flex flex-col p-4 gap-3">
                                        <h3 class="text-[#111618] dark:text-white text-lg font-bold leading-tight"><?php echo htmlspecialchars($apto['titulo']); ?></h3>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2"><?php echo htmlspecialchars($apto['descripcion']); ?></p>
                                        
                                        <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">bed</span> <?php echo $apto['habitaciones']; ?></span>
                                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">shower</span> <?php echo $apto['banos']; ?></span>
                                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">group</span> <?php echo $apto['capacidad']; ?></span>
                                        </div>
                                        
                                        <a href="../reserva-apartamento/apartamento.php?id=<?php echo $apto['id']; ?>" data-key="view-details" class="w-full mt-2 py-2 bg-primary text-white font-bold rounded-lg hover:bg-sky-600 transition-colors text-center">
                                            Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p data-key="no-apartments" class="col-span-2 text-center text-gray-500">No hay apartamentos disponibles en este momento.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 flex flex-col gap-6">
                <div class="border-b border-[#dbe2e6] dark:border-gray-700">
                    <div class="flex gap-8">
                        <a class="group flex items-center gap-2 border-b-[3px] border-b-primary pb-3 pt-2 cursor-pointer" href="#">
                            <span class="material-symbols-outlined text-primary text-[20px]">calendar_month</span>
                            <p data-key="tab-upcoming" class="text-[#111618] dark:text-white text-sm font-bold tracking-[0.015em]">Próximas reservas</p>
                        </a>
                        <a class="group flex items-center gap-2 border-b-[3px] border-b-transparent hover:border-b-gray-300 pb-3 pt-2 cursor-pointer transition-colors" href="#">
                            <span class="material-symbols-outlined text-[#617c89] group-hover:text-gray-600 dark:text-gray-500 text-[20px]">history</span>
                            <p data-key="tab-past" class="text-[#617c89] group-hover:text-gray-600 dark:text-gray-400 dark:group-hover:text-gray-300 text-sm font-bold tracking-[0.015em]">Estancias pasadas</p>
                        </a>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <div class="flex flex-col md:flex-row items-stretch rounded-xl bg-white dark:bg-[#1a2c35] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden group hover:shadow-md transition-all">
                        <div class="w-full md:w-64 md:min-w-64 h-48 md:h-auto bg-center bg-no-repeat bg-cover relative" style='background-image: url("https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?q=80&w=2070&auto=format&fit=crop");'>
                            <div data-key="status-confirmed" class="absolute top-2 left-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded shadow">Confirmada</div>
                        </div>
                        <div class="flex flex-1 flex-col justify-between p-5 gap-3">
                            <div>
                                <div class="flex justify-between items-start">
                                    <h3 data-key="card1-title" class="text-[#111618] dark:text-white text-lg font-bold leading-tight">Apartamento de Lujo en Pozos Colorados</h3>
                                    <button class="text-gray-400 hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined">favorite</span>
                                    </button>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">location_on</span>
                                    Pozos Colorados, Santa Marta
                                </p>
                            </div>
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center gap-3 text-sm text-[#617c89] dark:text-gray-300 bg-gray-50 dark:bg-gray-800 p-2 rounded-lg border border-gray-100 dark:border-gray-700">
                                    <span class="material-symbols-outlined text-primary">date_range</span>
                                    <span>15 Oct - 20 Oct, 2024</span>
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                    <span data-key="card1-guests">2 Huéspedes</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100 dark:border-gray-700 mt-1">
                                <button class="flex items-center gap-1 text-primary hover:text-sky-600 text-sm font-bold px-3 py-2 rounded transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">edit_note</span>
                                    <span data-key="btn-review">Escribir reseña</span>
                                </button>
                                <button data-key="btn-manage" class="flex items-center justify-center rounded-lg h-9 px-4 bg-primary text-white text-sm font-medium shadow-sm hover:bg-sky-500 transition-colors">
                                    Gestionar reserva
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-8">
                <div class="bg-white dark:bg-[#1a2c35] rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-5">
                    <h3 data-key="side-services" class="text-[#111618] dark:text-white font-bold text-base mb-4">Servicios del Apartamento</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex flex-col items-center justify-center p-4 rounded-lg bg-[#f0f3f4] dark:bg-gray-800 border border-transparent hover:border-primary/20 transition-all group">
                            <span class="material-symbols-outlined text-3xl mb-2 text-primary">wifi</span>
                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300 text-center">WiFi</span>
                        </div>
                        <div class="flex flex-col items-center justify-center p-4 rounded-lg bg-[#f0f3f4] dark:bg-gray-800 border border-transparent hover:border-primary/20 transition-all group">
                            <span class="material-symbols-outlined text-3xl mb-2 text-primary">ac_unit</span>
                            <span data-key="service-ac" class="text-xs font-bold text-gray-700 dark:text-gray-300 text-center">Aire Acondicionado</span>
                        </div>
                        <div class="flex flex-col items-center justify-center p-4 rounded-lg bg-[#f0f3f4] dark:bg-gray-800 border border-transparent hover:border-primary/20 transition-all group">
                            <span class="material-symbols-outlined text-3xl mb-2 text-primary">pool</span>
                            <span data-key="service-pool" class="text-xs font-bold text-gray-700 dark:text-gray-300 text-center">Piscina</span>
                        </div>
                        <div class="flex flex-col items-center justify-center p-4 rounded-lg bg-[#f0f3f4] dark:bg-gray-800 border border-transparent hover:border-primary/20 transition-all group">
                            <span class="material-symbols-outlined text-3xl mb-2 text-primary">local_parking</span>
                            <span data-key="service-parking" class="text-xs font-bold text-gray-700 dark:text-gray-300 text-center">Estacionamiento</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-[#1a2c35] rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-0 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h3 data-key="pqr-title" class="text-[#111618] dark:text-white font-bold text-base">Mis Solicitudes (PQR)</h3>
                        <?php if($num_pqr_activas > 0): ?>
                            <span class="bg-primary/10 text-primary text-xs font-bold px-2 py-1 rounded"><?php echo $num_pqr_activas; ?> Activa<?php echo $num_pqr_activas > 1 ? 's' : ''; ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="max-h-[300px] overflow-y-auto">
                        <?php if (!empty($pqr_list)): ?>
                            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                                <?php foreach($pqr_list as $pqr): 
                                    $estadoClass = '';
                                    if($pqr['estado'] == 'Pendiente') $estadoClass = 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400';
                                    elseif($pqr['estado'] == 'En Progreso') $estadoClass = 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400';
                                    else $estadoClass = 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400';
                                ?>
                                <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors cursor-pointer" onclick="verDetallePQR(<?php echo $pqr['id']; ?>)">
                                    <div class="flex justify-between items-start mb-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-bold text-gray-500">#<?php echo $pqr['id']; ?></span>
                                            <span class="text-[10px] font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-1.5 py-0.5 rounded border border-gray-200 dark:border-gray-600"><?php echo htmlspecialchars($pqr['tipo'] ?? 'Petición'); ?></span>
                                        </div>
                                        <span class="<?php echo $estadoClass; ?> text-[10px] font-bold px-2 py-0.5 rounded-full uppercase"><?php echo $pqr['estado']; ?></span>
                                    </div>
                                    <h4 class="text-sm font-bold text-[#111618] dark:text-white mb-1 line-clamp-1"><?php echo htmlspecialchars($pqr['asunto']); ?></h4>
                                    <p class="text-xs text-gray-500 line-clamp-2"><?php echo htmlspecialchars($pqr['mensaje']); ?></p>
                                    <div class="mt-2 text-[10px] text-gray-400 text-right">
                                        <?php echo date('d M Y', strtotime($pqr['fecha_creacion'])); ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="p-6 text-center text-gray-500 text-sm">
                                No tienes solicitudes registradas.
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="p-4 bg-gray-50 dark:bg-gray-800/30 border-t border-gray-100 dark:border-gray-700">
                        <button onclick="openPQRModal()" class="w-full flex items-center justify-center gap-2 rounded-lg h-10 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-[#111618] dark:text-white text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <span class="material-symbols-outlined text-lg">add_circle</span>
                            <span data-key="btn-new-pqr">Nueva Solicitud</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

        <div class="hidden fixed inset-0 z-50 bg-black/50 items-center justify-center p-4 backdrop-blur-sm" id="view-pqr-modal">
            <div class="bg-white dark:bg-[#1a2c35] w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center shrink-0">
                    <h3 class="text-xl font-bold text-[#111618] dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">chat</span>
                        Detalle de Solicitud
                    </h3>
                    <a class="text-gray-500 hover:text-primary transition-colors cursor-pointer" onclick="closeViewPQRModal()">
                        <span class="material-symbols-outlined">close</span>
                    </a>
                </div>
                
                <div class="flex-1 overflow-y-auto p-6 space-y-6" id="pqr-detail-content">
                    <!-- Contenido dinámico cargado por JS -->
                    <div class="flex justify-center p-10">
                        <span class="material-symbols-outlined animate-spin text-primary text-4xl">progress_activity</span>
                    </div>
                </div>

                <div class="p-6 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700 flex justify-end shrink-0">
                    <button class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-[#111618] dark:text-white text-sm font-bold rounded-lg transition-colors" onclick="closeViewPQRModal()">Cerrar</button>
                </div>
            </div>
        </div>

        <div class="hidden fixed inset-0 z-50 bg-black/50 items-center justify-center p-4 backdrop-blur-sm" id="new-pqr-modal">
            <div class="bg-white dark:bg-[#1a2c35] w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                <form action="guardar_pqr_be.php" method="POST">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-[#111618] dark:text-white flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">add_circle</span>
                            Nueva Solicitud (PQR)
                        </h3>
                        <a class="text-gray-500 hover:text-primary transition-colors cursor-pointer" onclick="closePQRModal()">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-[#111618] dark:text-white mb-2">Tipo de Solicitud</label>
                            <select name="tipo" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary text-[#111618] dark:text-white" required>
                                <option value="Petición">Petición</option>
                                <option value="Queja">Queja</option>
                                <option value="Reclamo">Reclamo</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#111618] dark:text-white mb-2">Asunto</label>
                            <input name="asunto" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary text-[#111618] dark:text-white placeholder:text-gray-400" placeholder="Ej: Problema con el aire acondicionado" type="text" required />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#111618] dark:text-white mb-2">Mensaje</label>
                            <textarea name="mensaje" rows="4" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary text-[#111618] dark:text-white placeholder:text-gray-400" placeholder="Describe tu solicitud detalladamente..." required></textarea>
                        </div>
                    </div>
                    <div class="p-6 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3">
                        <a class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-[#111618] dark:hover:text-white transition-colors cursor-pointer" onclick="closePQRModal()">Cancelar</a>
                        <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-sky-600 text-white text-sm font-bold rounded-lg shadow-lg shadow-primary/30 transition-all">Enviar Solicitud</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="hidden absolute top-20 right-4 md:right-10 z-[100] w-full max-w-md bg-white dark:bg-[#1a2c35] rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 animate-in fade-in zoom-in duration-200 origin-top-right" id="config-modal">
            <div class="max-h-[80vh] overflow-y-auto custom-scrollbar">
                <form action="actualizar_perfil_be.php" method="POST" enctype="multipart/form-data">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center sticky top-0 bg-white dark:bg-[#1a2c35] z-10">
                        <h3 class="text-lg font-bold text-[#111618] dark:text-white flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">settings</span>
                            Configuración
                        </h3>
                        <a class="text-gray-500 hover:text-primary transition-colors cursor-pointer" onclick="closeConfigModal()">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="flex flex-col items-center gap-3">
                             <div class="w-20 h-20 rounded-full bg-cover bg-center border-4 border-gray-100 dark:border-gray-700 relative overflow-hidden group shadow-sm">
                                <img id="preview-image" src="<?php echo !empty($_SESSION['imagen']) ? '../../' . $_SESSION['imagen'] : 'https://avatar.iran.liara.run/public/30'; ?>" class="w-full h-full object-cover">
                                <label for="imagen-upload" class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                                    <span class="material-symbols-outlined text-white text-xl">edit</span>
                                </label>
                             </div>
                             <input type="file" id="imagen-upload" name="imagen" class="hidden" accept="image/*" onchange="previewImage(this)">
                             <label for="imagen-upload" class="text-xs font-bold text-primary cursor-pointer hover:underline">Cambiar foto</label>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-[#111618] dark:text-white mb-1.5">Nombre</label>
                                <input name="nombre" value="<?php echo $_SESSION['nombre']; ?>" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-primary text-[#111618] dark:text-white" type="text" required />
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#111618] dark:text-white mb-1.5">Apellido</label>
                                <input name="apellido" value="<?php echo $_SESSION['apellido']; ?>" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-primary text-[#111618] dark:text-white" type="text" required />
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-[#111618] dark:text-white mb-1.5">Usuario</label>
                            <input name="usuario" value="<?php echo $_SESSION['usuario']; ?>" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-primary text-[#111618] dark:text-white" type="text" required />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#111618] dark:text-white mb-1.5">Correo (Gmail)</label>
                            <input name="email" value="<?php echo $_SESSION['email']; ?>" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-primary text-[#111618] dark:text-white" type="email" required />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#111618] dark:text-white mb-1.5">Nueva Contraseña</label>
                            <input name="password" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-primary text-[#111618] dark:text-white" type="password" placeholder="••••••••" />
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-2 sticky bottom-0 z-10">
                        <a class="px-4 py-2 text-xs font-bold text-gray-500 hover:text-[#111618] dark:hover:text-white transition-colors cursor-pointer" onclick="closeConfigModal()">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-primary hover:bg-sky-600 text-white text-xs font-bold rounded-lg shadow-md transition-all">Guardar</button>
                    </div>
                </form>
            </div>
        </div>

    <script>
        function openPQRModal() {
            const modal = document.getElementById('new-pqr-modal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }

        function closePQRModal() {
            const modal = document.getElementById('new-pqr-modal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }

        function closeViewPQRModal() {
            const modal = document.getElementById('view-pqr-modal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }

        function verDetallePQR(id) {
            const modal = document.getElementById('view-pqr-modal');
            const content = document.getElementById('pqr-detail-content');
            
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            
            // Mostrar loader
            content.innerHTML = `
                <div class="flex justify-center p-10">
                    <span class="material-symbols-outlined animate-spin text-primary text-4xl">progress_activity</span>
                </div>
            `;

            // Fetch data
            fetch(`obtener_detalle_pqr.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if(data.error) {
                        content.innerHTML = `<p class="text-red-500 text-center">${data.error}</p>`;
                        return;
                    }

                    const pqr = data.pqr;
                    const respuestas = data.respuestas;

                    let estadoColor = 'text-red-600 bg-red-100 dark:bg-red-900/30 dark:text-red-400';
                    if (pqr.estado === 'En Progreso') estadoColor = 'text-yellow-600 bg-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-400';
                    if (pqr.estado === 'Resuelto') estadoColor = 'text-green-600 bg-green-100 dark:bg-green-900/30 dark:text-green-400';

                    let html = `
                        <div class="flex flex-col gap-4">
                            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Solicitud #${pqr.id}</span>
                                        <span class="text-[10px] font-medium bg-white dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-0.5 rounded border border-gray-200 dark:border-gray-600 uppercase tracking-wider">${pqr.tipo || 'Petición'}</span>
                                    </div>
                                    <span class="${estadoColor} text-xs px-2 py-0.5 rounded-full font-bold uppercase">${pqr.estado}</span>
                                </div>
                                <h4 class="text-lg font-bold text-[#111618] dark:text-white mb-2">${pqr.asunto}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">${pqr.mensaje}</p>
                                <p class="text-xs text-gray-400 mt-2 text-right">${new Date(pqr.fecha_creacion).toLocaleString()}</p>
                            </div>
                    `;

                    if (respuestas.length > 0) {
                        html += `<div class="relative pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-6 mt-4">`;
                        
                        respuestas.forEach(res => {
                            let adminImg = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(res.nombre + ' ' + res.apellido) + '&background=13a4ec&color=fff';
                            if (res.imagen && res.imagen.trim() !== '') {
                                adminImg = res.imagen.startsWith('assets/') ? '../../' + res.imagen : '../../assets/img/usuarios/' + res.imagen;
                            }
                            
                            html += `
                                <div class="relative">
                                    <div class="absolute -left-[25px] top-0 w-4 h-4 rounded-full bg-primary border-2 border-white dark:border-[#1a2c35]"></div>
                                    <div class="flex gap-3">
                                        <div class="w-10 h-10 rounded-full bg-cover bg-center shrink-0 border border-gray-200 dark:border-gray-600" style="background-image: url('${adminImg}');"></div>
                                        <div class="flex-1">
                                            <div class="flex items-baseline justify-between mb-1">
                                                <span class="text-sm font-bold text-[#111618] dark:text-white">${res.nombre} ${res.apellido} <span class="text-xs font-normal text-gray-500">(Admin)</span></span>
                                                <span class="text-xs text-gray-400">${new Date(res.fecha_respuesta).toLocaleString()}</span>
                                            </div>
                                            <div class="bg-white dark:bg-gray-700 p-3 rounded-lg rounded-tl-none border border-gray-100 dark:border-gray-600 shadow-sm">
                                                <p class="text-sm text-gray-700 dark:text-gray-200">${res.mensaje}</p>
                                                ${res.archivo ? `
                                                    <a href="../../${res.archivo}" target="_blank" class="flex items-center gap-2 mt-3 p-2 bg-gray-50 dark:bg-gray-800 rounded border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors group">
                                                        <span class="material-symbols-outlined text-red-500 group-hover:scale-110 transition-transform">description</span>
                                                        <span class="text-xs font-bold text-gray-600 dark:text-gray-300">Ver archivo adjunto</span>
                                                    </a>
                                                ` : ''}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        html += `</div>`;
                    } else {
                        html += `
                            <div class="flex flex-col items-center justify-center p-8 text-center text-gray-400 border-t border-gray-100 dark:border-gray-700 mt-2">
                                <span class="material-symbols-outlined text-4xl mb-2 opacity-50">schedule</span>
                                <p class="text-sm">Aún no hay respuestas del administrador.</p>
                            </div>
                        `;
                    }

                    html += `</div>`;
                    content.innerHTML = html;
                })
                .catch(err => {
                    content.innerHTML = `<p class="text-red-500 text-center">Error al cargar la información.</p>`;
                    console.error(err);
                });
        }

        const translations = {
            es: {
                "nav-reservations": "Mis Reservas",
                "nav-favorites": "Favoritos",
                "welcome-user": "Hola, Daniel",
                "welcome-sub": "Bienvenido a tu panel de control. Tu próxima aventura te espera.",
                "checkin-days": "Check-in: 3 Días",
                "hero-title": "Tu escapada a Santa Marta",
                "hero-sub": "Apartamento Vista al Mar - Edificio El Rodadero. Todo está listo para tu llegada.",
                "btn-arrival": "Ver detalles de llegada",
                "btn-guide": "Guía de la casa",
                "tab-upcoming": "Próximas reservas",
                "tab-past": "Estancias pasadas",
                "status-confirmed": "Confirmada",
                "card1-title": "Apartamento de Lujo en Pozos Colorados",
                "card1-guests": "2 Huéspedes",
                "btn-review": "Escribir reseña",
                "btn-manage": "Gestionar reserva",
                "side-services": "Servicios del Apartamento",
                "service-ac": "Aire Acondicionado",
                "service-pool": "Piscina",
                "service-parking": "Estacionamiento",
                "pqr-title": "Mis Solicitudes (PQR)",
                "pqr-active": "1 Activa",
                "btn-new-pqr": "Nueva Solicitud"
            },
            en: {
                "nav-reservations": "My Bookings",
                "nav-favorites": "Favorites",
                "welcome-user": "Hello, Daniel",
                "welcome-sub": "Welcome to your dashboard. Your next adventure awaits.",
                "checkin-days": "Check-in: 3 Days",
                "hero-title": "Your Santa Marta Getaway",
                "hero-sub": "Ocean View Apartment - El Rodadero Building. Everything is ready for you.",
                "btn-arrival": "View Arrival Details",
                "btn-guide": "House Guide",
                "tab-upcoming": "Upcoming Bookings",
                "tab-past": "Past Stays",
                "status-confirmed": "Confirmed",
                "card1-title": "Luxury Apartment in Pozos Colorados",
                "card1-guests": "2 Guests",
                "btn-review": "Write a Review",
                "btn-manage": "Manage Booking",
                "side-services": "Apartment Amenities",
                "service-ac": "Air Conditioning",
                "service-pool": "Swimming Pool",
                "service-parking": "Parking Lot",
                "pqr-title": "My Requests (PQR)",
                "pqr-active": "1 Active",
                "btn-new-pqr": "New Request",
                "available-apartments": "Available Apartments",
                "no-apartments": "No apartments available at the moment.",
                "view-details": "View Details"
            }
        };

        function changeLanguage(lang) {
            // Cambiar textos
            const elements = document.querySelectorAll('[data-key]');
            elements.forEach(el => {
                const key = el.getAttribute('data-key');
                if (translations[lang][key]) {
                    el.innerText = translations[lang][key];
                }
            });

            // Actualizar estilo de botones
            const btnEs = document.getElementById('btn-es');
            const btnEn = document.getElementById('btn-en');

            if (lang === 'es') {
                btnEs.classList.add('bg-primary', 'text-white');
                btnEs.classList.remove('text-gray-500');
                btnEn.classList.remove('bg-primary', 'text-white');
                btnEn.classList.add('text-gray-500');
                document.documentElement.lang = "es";
            } else {
                btnEn.classList.add('bg-primary', 'text-white');
                btnEn.classList.remove('text-gray-500');
                btnEs.classList.remove('bg-primary', 'text-white');
                btnEs.classList.add('text-gray-500');
                document.documentElement.lang = "en";
            }
        }

        function openConfigModal() {
            const modal = document.getElementById('config-modal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }

        function closeConfigModal() {
            const modal = document.getElementById('config-modal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
        
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Notificaciones y Alertas
        let lastNotificationCountHuesped = 0;
        let currentNotificationsHuesped = [];

        function requestNotificationPermission() {
            if ("Notification" in window && Notification.permission !== "granted") {
                Notification.requestPermission();
            }
        }

        function checkNotificationsHuesped() {
            fetch('check_notifications_huesped.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const badge = document.getElementById('notification-badge');
                        const list = document.getElementById('notification-list');
                        
                        // Actualizar badge
                        if (data.count > 0) {
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                        
                        // Alerta y Notificación del sistema
                        // Nota: Para mejorar la experiencia, en un sistema real deberíamos rastrear IDs de notificaciones ya vistas
                        // Aquí usamos un contador simple que funciona si llegan nuevas y el total aumenta
                        if (data.count > lastNotificationCountHuesped) {
                            // Reproducir sonido
                            try {
                                const audio = new Audio('../../assets/sounds/notification.mp3');
                                audio.play().catch(e => {});
                            } catch (e) {}

                            // Mostrar notificación nativa
                            if ("Notification" in window && Notification.permission === "granted") {
                                const newResp = data.notifications[0];
                                if (newResp) {
                                    let adminImg = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(newResp.nombre + ' ' + newResp.apellido) + '&background=13a4ec&color=fff';
                                    if (newResp.imagen && newResp.imagen.trim() !== '') {
                                        adminImg = newResp.imagen.startsWith('assets/') ? '../../' + newResp.imagen : '../../assets/img/usuarios/' + newResp.imagen;
                                    }

                                    new Notification("Nueva respuesta de soporte", {
                                        body: `${newResp.nombre} ha respondido a tu PQR: ${newResp.asunto}`,
                                        icon: adminImg,
                                        image: adminImg
                                    });
                                }
                            }
                        }
                        lastNotificationCountHuesped = data.count;
                        currentNotificationsHuesped = data.notifications;

                        // Actualizar lista dropdown
                        if (data.notifications.length > 0) {
                            let html = '';
                            data.notifications.forEach((notif, index) => {
                                let adminImg = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(notif.nombre + ' ' + notif.apellido) + '&background=13a4ec&color=fff';
                                if (notif.imagen && notif.imagen.trim() !== '') {
                                    adminImg = notif.imagen.startsWith('assets/') ? '../../' + notif.imagen : '../../assets/img/usuarios/' + notif.imagen;
                                }
                                
                                const time = new Date(notif.fecha_respuesta).toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit'});
                                
                                html += `
                                    <div class="p-3 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-colors" onclick="abrirNotificacionHuesped(${index})">
                                        <div class="flex gap-3">
                                            <div class="w-10 h-10 rounded-full bg-cover bg-center shrink-0" style="background-image: url('${adminImg}');"></div>
                                            <div class="flex-1 overflow-hidden">
                                                <div class="flex justify-between items-start">
                                                    <p class="text-sm font-bold text-[#111618] dark:text-white truncate">${notif.nombre} ${notif.apellido}</p>
                                                    <span class="text-[10px] text-gray-400">${time}</span>
                                                </div>
                                                <p class="text-xs text-primary font-medium mb-0.5">Respuesta a PQR #${notif.pqr_id}</p>
                                                <p class="text-xs text-gray-500 truncate">${notif.mensaje}</p>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                            list.innerHTML = html;
                        } else {
                            list.innerHTML = '<div class="p-4 text-center text-xs text-gray-500">No tienes notificaciones nuevas</div>';
                        }
                    }
                })
                .catch(err => console.error('Error notifications:', err));
        }

        function abrirNotificacionHuesped(index) {
            const notif = currentNotificationsHuesped[index];
            if (notif) {
                verDetallePQR(notif.pqr_id);
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

        // Iniciar al cargar
        document.addEventListener('DOMContentLoaded', () => {
            requestNotificationPermission();
            checkNotificationsHuesped();
            setInterval(checkNotificationsHuesped, 10000); // Polling cada 10s
        });
    </script>
</body>

</html>