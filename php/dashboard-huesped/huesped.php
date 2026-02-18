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

// Verificar si es usuario de Google
$sql_user_check = "SELECT google_id, is_verified FROM usuarios WHERE id = '$usuario_id'";
$result_user_check = $conn->query($sql_user_check);
$user_data_check = $result_user_check->fetch_assoc();
$is_google_user = !empty($user_data_check['google_id']);
$is_verified = !empty($user_data_check['is_verified']) && $user_data_check['is_verified'] == 1;

// Si es Google user, asumimos verificado para efectos visuales
if ($is_google_user) {
    $is_verified = true;
}

$sql_pqr = "SELECT * FROM pqr WHERE usuario_id = '$usuario_id' ORDER BY fecha_creacion DESC";
$result_pqr = $conn->query($sql_pqr);

$pqr_list = [];
$num_pqr_activas = 0;
if ($result_pqr && $result_pqr->num_rows > 0) {
    while ($row = $result_pqr->fetch_assoc()) {
        $pqr_list[] = $row;
        if ($row['estado'] != 'Resuelto') {
            $num_pqr_activas++;
        }
    }
}

// Obtener próximas reservas
$fecha_actual = date('Y-m-d');
$sql_reservas = "SELECT r.*, a.titulo, a.ubicacion, a.imagen_principal 
                 FROM reservas r 
                 JOIN apartamentos a ON r.apartamento_id = a.id 
                 WHERE r.usuario_id = '$usuario_id' 
                 AND r.fecha_inicio >= '$fecha_actual' 
                 ORDER BY r.fecha_inicio ASC";
$result_reservas = $conn->query($sql_reservas);

// Obtener reservas pasadas
$sql_reservas_pasadas = "SELECT r.*, a.titulo, a.ubicacion, a.imagen_principal 
                 FROM reservas r 
                 JOIN apartamentos a ON r.apartamento_id = a.id 
                 WHERE r.usuario_id = '$usuario_id' 
                 AND r.fecha_fin < '$fecha_actual' 
                 ORDER BY r.fecha_inicio DESC";
$result_reservas_pasadas = $conn->query($sql_reservas_pasadas);

// Determinar imagen de perfil (Google vs Local)
$profile_image = 'https://avatar.iran.liara.run/public/30';
if (!empty($_SESSION['imagen'])) {
    $img_session = trim($_SESSION['imagen']);
    // Verificar si es una URL completa (http/https)
    if (strpos($img_session, 'http') === 0) {
        $profile_image = $img_session;
    } else {
        // Es una imagen local
        $profile_image = '../../' . $img_session;
    }
}
?>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link rel="shortcut icon" href="/public/img/logo-def-Photoroom.png" type="image/x-icon">
    <title>Panel de Control - Santamartabeachfront</title>
    <link rel="shortcut icon" href="/public/img/logo_santamartabeachfront-removebg-preview.png" type="image/x-icon">
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
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

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

        /* ---------------------------------- */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #13a4ec;
            /* Blue primary color */
            border-radius: 0px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #0f8bc7;
        }

        /* Animación de sacudida */
        .shake-horizontal {
            animation: shake 0.4s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
        }

        /* Animación de menu */
        .lang-dropdown:hover .lang-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .lang-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.2s ease;
        }

        /* ---------------------------------- */
    </style>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css" />
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#111618] dark:text-white flex flex-col min-h-screen overflow-x-hidden">
    <header class="sticky top-0 z-50 w-full border-b border-gray-200 dark:border-gray-800 bg-white dark:bg-[#1a2c35] shadow-sm">
        <div class="flex items-center justify-between px-4 md:px-10 py-4">

            <div class="flex items-center gap-4">
                <div class="h-12 w-auto flex items-center justify-center overflow-hidden">
                    <img src="/public/img/logo-def-Photoroom.png" alt="logo" class="h-full w-auto object-contain">
                </div>
                <h2 class="hidden lg:block text-[#111618] dark:text-white text-xl font-bold leading-tight tracking-[-0.015em]">
                    Santamartabeachfront
                </h2>
            </div>

            <div class="hidden md:flex flex-1 justify-end gap-6 items-center">

                <div class="flex bg-gray-100 dark:bg-gray-800 p-1 rounded-lg">
                    <button onclick="changeLanguage('es')" id="btn-es" class="px-3 py-1 text-xs font-bold rounded-md transition-all bg-primary text-white">ES</button>
                    <button onclick="changeLanguage('en')" id="btn-en" class="px-3 py-1 text-xs font-bold rounded-md transition-all text-gray-500 hover:text-primary">EN</button>
                </div>

                <div class="flex items-center gap-4">
                    <button id="notification-btn" class="relative p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-[#111618] dark:text-white transition-colors" onclick="toggleNotifications()">
                        <span class="material-symbols-outlined text-2xl">notifications</span>
                        <span id="notification-badge" class="absolute top-2 right-2 size-2.5 bg-red-500 rounded-full border border-white dark:border-[#1a2c35] hidden"></span>
                    </button>

                    <div onclick="openConfigModal()" class="size-10 rounded-full border-2 border-gray-200 dark:border-gray-600 hover:border-primary cursor-pointer overflow-hidden transition-all">
                        <img src="<?php echo $profile_image; ?>" class="w-full h-full object-cover" referrerpolicy="no-referrer" alt="Perfil">
                    </div>

                    <a href="../../auth/cerrar_sesion.php" class="flex items-center justify-center size-10 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 text-gray-500 hover:text-red-600 transition-colors" title="Cerrar Sesión">
                        <span class="material-symbols-outlined">logout</span>
                    </a>
                </div>
            </div>

            <div class="flex md:hidden items-center">
                <button onclick="toggleMobileMenu()" class="p-2 text-[#111618] dark:text-white focus:outline-none">
                    <span class="material-symbols-outlined text-4xl" id="menu-icon">menu</span>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 w-full bg-white dark:bg-[#1a2c35] border-t border-gray-100 dark:border-gray-700 shadow-xl z-40 transition-all duration-300 ease-in-out">
            <div class="flex flex-col p-6 space-y-6">

                <div class="flex items-center gap-4 pb-4 border-b border-gray-100 dark:border-gray-700" onclick="openConfigModal()">
                    <div class="size-14 rounded-full border-2 border-primary overflow-hidden">
                        <img src="<?php echo $profile_image; ?>" class="w-full h-full object-cover" alt="Perfil">
                    </div>
                    <div>
                        <p class="text-lg font-bold text-[#111618] dark:text-white">Mi Perfil</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Ver configuración</p>
                    </div>
                </div>

                <div class="grid gap-4">
                    <button onclick="toggleNotifications()" class="flex items-center justify-between w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <div class="flex items-center gap-3 text-[#111618] dark:text-white">
                            <span class="material-symbols-outlined text-primary">notifications</span>
                            <span class="font-medium">Notificaciones</span>
                        </div>
                        <span id="notification-badge-mobile" class="hidden px-2 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full">New</span>
                    </button>

                    <div class="flex items-center justify-between w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50">
                        <div class="flex items-center gap-3 text-[#111618] dark:text-white">
                            <span class="material-symbols-outlined text-primary">language</span>
                            <span class="font-medium">Idioma</span>
                        </div>
                        <div class="flex bg-white dark:bg-gray-700 rounded-lg p-1 shadow-sm">
                            <button onclick="changeLanguage('es')" class="px-4 py-1 text-xs font-bold rounded bg-primary text-white">ES</button>
                            <button onclick="changeLanguage('en')" class="px-4 py-1 text-xs font-bold rounded text-gray-500 dark:text-gray-300">EN</button>
                        </div>
                    </div>
                </div>

                <a href="../../auth/cerrar_sesion.php" class="flex items-center justify-center w-full gap-2 p-3 text-red-600 bg-red-50 dark:bg-red-900/10 dark:text-red-400 font-bold rounded-xl transition-colors hover:bg-red-100 dark:hover:bg-red-900/30">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Cerrar Sesión</span>
                </a>
            </div>
        </div>
    </header>

    <div id="notification-dropdown" class="absolute top-20 right-4 md:right-10 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 hidden z-50 overflow-hidden">
        <div class="p-3 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
            <h3 class="font-bold text-sm text-[#111618] dark:text-white">Notificaciones</h3>
            <span class="text-xs text-primary font-medium cursor-pointer hover:underline" onclick="markAllRead()">Marcar leídas</span>
        </div>
        <div id="notification-list" class="max-h-[300px] overflow-y-auto">
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('menu-icon');

            if (menu.classList.contains('hidden')) {
                // Abrir menú
                menu.classList.remove('hidden');
                icon.textContent = 'close'; // Cambia ícono a X
                // Bloquear scroll del body si quieres que no se mueva el fondo
                // document.body.style.overflow = 'hidden'; 
            } else {
                // Cerrar menú
                menu.classList.add('hidden');
                icon.textContent = 'menu'; // Cambia ícono a hamburguesa
                // document.body.style.overflow = 'auto';
            }
        }

        // Cerrar el menú si la pantalla cambia de tamaño (rotación de móvil a tablet, etc)
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                document.getElementById('mobile-menu').classList.add('hidden');
                document.getElementById('menu-icon').textContent = 'menu';
            }
        });
    </script>


    <main class="flex-1 w-full max-w-[1200px] mx-auto px-4 md:px-6 lg:px-8 py-8 space-y-8">
        <section id="welcome-section" class="flex flex-col gap-2">
            <?php if (isset($_SESSION['show_verify_alert']) && $_SESSION['show_verify_alert']): ?>
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded shadow-sm flex justify-between items-center" role="alert">
                    <div>
                        <p class="font-bold">Cuenta no verificada</p>
                        <p>Por favor verifica tu correo electrónico para acceder a todas las funciones. Revisa tu Configuración.</p>
                    </div>
                    <button onclick="openConfigModal()" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded text-sm transition-colors">
                        Verificar ahora
                    </button>
                </div>
                <?php unset($_SESSION['show_verify_alert']); ?>
            <?php endif; ?>

            <p class="text-[#111618] dark:text-white text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">
                <span data-key="welcome-user">Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
            </p>
            <p data-key="welcome-sub" class="text-[#617c89] dark:text-gray-400 text-base font-normal">Bienvenido a tu panel de control. Tu próxima aventura te espera.</p>
        </section>

        <section class="relative overflow-hidden rounded-2xl shadow-lg group">
            <div class="flex min-h-[400px] flex-col gap-6 bg-cover bg-center bg-no-repeat items-start justify-end px-6 pb-10 md:px-10 md:pb-12 transition-transform duration-700 hover:scale-[1.01]" style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.6) 100%), url("https://images.unsplash.com/photo-1544376798-89aa6b82c6cd?q=80&w=1964&auto=format&fit=crop");'>
                <div class="flex flex-col gap-2 text-left max-w-2xl">
                    <h1 data-key="hero-title" class="text-white text-3xl md:text-5xl font-black leading-tight tracking-[-0.033em] drop-shadow-md">
                        Tu escapada a Santa Marta
                    </h1>
                    <h2 data-key="hero-sub" class="text-gray-100 text-base md:text-lg font-medium leading-normal drop-shadow-sm mb-4">Apartamento Reserva del Mar 1 - Edificio Torre 4. Todo está listo para tu llegada.</h2>
                    <div class="flex flex-wrap gap-3">
                        <button onclick="startTour()" class="flex items-center justify-center rounded-lg h-12 px-6 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 text-base font-bold transition-all" title="Ver tutorial">
                            <span class="mr-2 material-symbols-outlined">help</span>
                            Ayuda
                        </button>

                        <!-- Botón para dejar reseña -->
                        <button type="button"
                            <?php if (isset($reserva['apartamento_id'])): ?>
                            onclick="prepararYAbrirModal(<?php echo intval($reserva['apartamento_id']); ?>)"
                            <?php else: ?>
                            onclick="prepararYAbrirModal(1)"
                            <?php endif; ?>
                            class="flex items-center justify-center rounded-lg h-12 px-6 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 text-base font-bold transition-all">
                            <span class="mr-2 material-symbols-outlined text-yellow-400">star</span>
                            Dejar una reseña
                        </button>

                        <button type="button" onclick="toggleSugerenciaModal()"
                            class="flex items-center justify-center rounded-lg h-12 px-6 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 text-base font-bold transition-all shadow-lg group">
                            <span class="material-symbols-outlined group-hover:text-primary transition-colors">lightbulb</span>
                            Dejar Sugerencia
                        </button>

                        <div id="modalSugerencia"
                            class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-0 transition-all duration-300"
                            role="dialog" aria-modal="true">

                            <div id="modalBackdrop"
                                class="fixed inset-0 bg-black/80 backdrop-blur-sm opacity-0 transition-opacity duration-300"
                                onclick="toggleSugerenciaModal()"></div>

                            <div id="modalContent"
                                class="relative transform scale-95 opacity-0 transition-all duration-300 w-full max-w-lg rounded-2xl bg-[#1a2c35] border border-white/10 shadow-2xl overflow-hidden">

                                <form action="guardar_sugerencia.php" method="POST" class="m-0">
                                    <div class="p-6">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-yellow-400/10 sm:mx-0 sm:h-10 sm:w-10">
                                                <span class="material-symbols-outlined text-yellow-400">lightbulb</span>
                                            </div>
                                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                                <h3 class="text-xl font-bold text-white">Tu opinión nos importa</h3>
                                                <p class="text-sm text-gray-400 mt-1 mb-4">Ayúdanos a mejorar Santamarta Beachfront.</p>

                                                <textarea name="mensaje" rows="4" required
                                                    class="w-full rounded-xl bg-black/30 border border-white/10 text-white placeholder-gray-500 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 p-4 text-sm resize-none outline-none transition-all"
                                                    placeholder="Escribe aquí tu sugerencia..."></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-black/40 px-6 py-4 flex flex-col-reverse sm:flex-row justify-end gap-3">
                                        <button type="button" onclick="toggleSugerenciaModal()"
                                            class="px-5 py-2.5 text-sm font-semibold text-white bg-white/5 border border-white/10 rounded-lg hover:bg-white/10 transition-all">
                                            Cancelar
                                        </button>
                                        <button type="submit"
                                            class="px-5 py-2.5 text-sm font-bold text-black bg-yellow-400 rounded-lg hover:bg-yellow-300 hover:scale-[1.02] active:scale-[0.98] transition-all">
                                            Enviar Sugerencia
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <script>
                            function toggleSugerenciaModal() {
                                const modal = document.getElementById('modalSugerencia');
                                const backdrop = document.getElementById('modalBackdrop');
                                const content = document.getElementById('modalContent');

                                if (modal.classList.contains('hidden')) {
                                    // 1. Mostrar el contenedor (está invisible pero ocupa espacio)
                                    modal.classList.remove('hidden');
                                    modal.classList.add('flex');

                                    // Evitar scroll en el fondo
                                    document.body.style.overflow = 'hidden';

                                    // 2. Pequeña pausa para activar la animación de entrada
                                    setTimeout(() => {
                                        backdrop.classList.replace('opacity-0', 'opacity-100');
                                        content.classList.replace('opacity-0', 'opacity-100');
                                        content.classList.replace('scale-95', 'scale-100');
                                    }, 10);
                                } else {
                                    // 1. Iniciar animación de salida
                                    backdrop.classList.replace('opacity-100', 'opacity-0');
                                    content.classList.replace('opacity-100', 'opacity-0');
                                    content.classList.replace('scale-100', 'scale-95');

                                    // 2. Esperar a que termine la animación (300ms) antes de ocultar
                                    setTimeout(() => {
                                        modal.classList.replace('flex', 'hidden');
                                        document.body.style.overflow = 'auto';
                                    }, 300);
                                }
                            }
                        </script>

                    </div>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 flex flex-col gap-6">
                <div class="border-b border-[#dbe2e6] dark:border-gray-700">
                    <div class="flex gap-4 md:gap-8 overflow-x-auto no-scrollbar">
                        <a onclick="switchTab('upcoming')" id="tab-upcoming" class="group flex items-center gap-2 border-b-[3px] border-b-primary pb-3 pt-2 cursor-pointer shrink-0" href="javascript:void(0)">
                            <span class="material-symbols-outlined text-primary text-[20px]">calendar_month</span>
                            <p data-key="tab-upcoming" class="text-[#111618] dark:text-white text-sm font-bold tracking-[0.015em]">Próximas reservas</p>
                        </a>
                        <a onclick="switchTab('past')" id="tab-past" class="group flex items-center gap-2 border-b-[3px] border-b-transparent hover:border-b-gray-300 pb-3 pt-2 cursor-pointer transition-colors shrink-0" href="javascript:void(0)">
                            <span class="material-symbols-outlined text-[#617c89] group-hover:text-gray-600 dark:text-gray-500 text-[20px]">history</span>
                            <p data-key="tab-past" class="text-[#617c89] group-hover:text-gray-600 dark:text-gray-400 dark:group-hover:text-gray-300 text-sm font-bold tracking-[0.015em]">Estancias pasadas</p>
                        </a>
                        <a onclick="switchTab('apartments')" id="tab-apartments" class="group flex items-center gap-2 border-b-[3px] border-b-transparent hover:border-b-gray-300 pb-3 pt-2 cursor-pointer transition-colors shrink-0" href="javascript:void(0)">
                            <span class="material-symbols-outlined text-[#617c89] group-hover:text-gray-600 dark:text-gray-500 text-[20px]">apartment</span>
                            <p data-key="tab-apartments" class="text-[#617c89] group-hover:text-gray-600 dark:text-gray-400 dark:group-hover:text-gray-300 text-sm font-bold tracking-[0.015em]">Apartamentos</p>
                        </a>
                    </div>
                </div>

                <div id="upcoming-bookings" class="flex flex-col gap-4">
                    <div class="flex items-center justify-end">
                        <button onclick="switchTab('apartments')" class="flex items-center gap-2 text-primary hover:text-sky-600 text-sm font-bold px-3 py-2 rounded-lg hover:bg-sky-50 dark:hover:bg-sky-900/10 transition-colors">
                            <span class="material-symbols-outlined text-[18px]">add_circle</span>
                            Nueva reserva
                        </button>
                    </div>
                    <?php if ($result_reservas && $result_reservas->num_rows > 0): ?>
                        <?php while ($reserva = $result_reservas->fetch_assoc()):
                            $estadoColor = 'bg-yellow-500';
                            $estadoTexto = 'Pendiente';

                            if ($reserva['estado'] == 'Confirmada') {
                                $estadoColor = 'bg-green-500';
                                $estadoTexto = 'Confirmada';
                            } elseif ($reserva['estado'] == 'Cancelada') {
                                $estadoColor = 'bg-red-500';
                                $estadoTexto = 'Cancelada';
                            } else {
                                $estadoTexto = $reserva['estado'];
                            }

                            $fecha_inicio = date('d M', strtotime($reserva['fecha_inicio']));
                            $fecha_fin = date('d M, Y', strtotime($reserva['fecha_fin']));
                            $huespedes = $reserva['adultos'] + $reserva['ninos'];
                        ?>
                            <div class="flex flex-col md:flex-row items-stretch rounded-xl bg-white dark:bg-[#1a2c35] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden group hover:shadow-md transition-all">
                                <div class="w-full md:w-64 md:min-w-64 h-48 md:h-auto bg-center bg-no-repeat bg-cover relative" style='background-image: url("../../assets/img/apartamentos/<?php echo htmlspecialchars($reserva['imagen_principal']); ?>");'>
                                    <div class="absolute top-2 left-2 <?php echo $estadoColor; ?> text-white text-xs font-bold px-2 py-1 rounded shadow"><?php echo $estadoTexto; ?></div>
                                </div>
                                <div class="flex flex-1 flex-col justify-between p-5 gap-3">
                                    <div>
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-[#111618] dark:text-white text-lg font-bold leading-tight"><?php echo htmlspecialchars($reserva['titulo']); ?></h3>
                                            <button class="text-gray-400 hover:text-primary transition-colors">
                                                <span class="material-symbols-outlined">favorite</span>
                                            </button>
                                        </div>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">location_on</span>
                                            <?php echo htmlspecialchars($reserva['ubicacion']); ?>
                                        </p>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <div class="flex items-center gap-3 text-sm text-[#617c89] dark:text-gray-300 bg-gray-50 dark:bg-gray-800 p-2 rounded-lg border border-gray-100 dark:border-gray-700">
                                            <span class="material-symbols-outlined text-primary">date_range</span>
                                            <span><?php echo $fecha_inicio; ?> - <?php echo $fecha_fin; ?></span>
                                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                            <span><?php echo $huespedes; ?> Huéspedes</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100 dark:border-gray-700 mt-1">
                                        <button onclick="openApartmentModal(<?php echo $reserva['apartamento_id']; ?>, '<?php echo htmlspecialchars($reserva['titulo'], ENT_QUOTES); ?>')" class="flex items-center justify-center rounded-lg h-9 px-4 bg-primary text-white text-sm font-medium shadow-sm hover:bg-sky-500 transition-colors">
                                            Ver y reservar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="flex flex-col items-center justify-center p-8 bg-white dark:bg-[#1a2c35] rounded-xl border border-gray-100 dark:border-gray-800 text-center">
                            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-full mb-4">
                                <span class="material-symbols-outlined text-4xl text-gray-400">event_busy</span>
                            </div>
                            <h3 class="text-lg font-bold text-[#111618] dark:text-white mb-2">No tienes próximas reservas</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-6 max-w-xs mx-auto">Explora nuestros apartamentos y planifica tu próxima escapada a Santa Marta.</p>
                            <button onclick="switchTab('apartments')" class="bg-primary text-white px-6 py-2.5 rounded-lg font-bold hover:bg-sky-600 transition-colors">
                                Ver apartamentos
                            </button>
                        </div>
                    <?php endif; ?>
                </div>

                <div id="past-bookings" class="flex flex-col gap-4 hidden">
                    <?php if ($result_reservas_pasadas && $result_reservas_pasadas->num_rows > 0): ?>
                        <?php while ($reserva = $result_reservas_pasadas->fetch_assoc()):
                            $fecha_inicio = date('d M', strtotime($reserva['fecha_inicio']));
                            $fecha_fin = date('d M, Y', strtotime($reserva['fecha_fin']));
                            $huespedes = $reserva['adultos'] + $reserva['ninos'];
                        ?>
                            <div class="flex flex-col md:flex-row items-stretch rounded-xl bg-white dark:bg-[#1a2c35] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden group hover:shadow-md transition-all">
                                <div class="w-full md:w-64 md:min-w-64 h-48 md:h-auto bg-center bg-no-repeat bg-cover relative grayscale" style='background-image: url("../../assets/img/apartamentos/<?php echo htmlspecialchars($reserva['imagen_principal']); ?>");'>
                                    <div class="absolute top-2 left-2 bg-gray-500 text-white text-xs font-bold px-2 py-1 rounded shadow">Completada</div>
                                </div>
                                <div class="flex flex-1 flex-col justify-between p-5 gap-3">
                                    <div>
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-[#111618] dark:text-white text-lg font-bold leading-tight"><?php echo htmlspecialchars($reserva['titulo']); ?></h3>
                                        </div>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">location_on</span>
                                            <?php echo htmlspecialchars($reserva['ubicacion']); ?>
                                        </p>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <div class="flex items-center gap-3 text-sm text-[#617c89] dark:text-gray-300 bg-gray-50 dark:bg-gray-800 p-2 rounded-lg border border-gray-100 dark:border-gray-700">
                                            <span class="material-symbols-outlined text-primary">date_range</span>
                                            <span><?php echo $fecha_inicio; ?> - <?php echo $fecha_fin; ?></span>
                                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                            <span><?php echo $huespedes; ?> Huéspedes</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100 dark:border-gray-700 mt-1">
                                        <button onclick="prepararYAbrirModal(<?php echo $reserva['apartamento_id']; ?>)" class="flex items-center justify-center rounded-lg h-9 px-4 bg-yellow-500 text-white text-sm font-medium shadow-sm hover:bg-yellow-600 transition-colors">
                                            <span class="mr-1 material-symbols-outlined text-sm">star</span>
                                            Dejar reseña
                                        </button>
                                        <button onclick="openApartmentModal(<?php echo $reserva['apartamento_id']; ?>, '<?php echo htmlspecialchars($reserva['titulo'], ENT_QUOTES); ?>')" class="flex items-center justify-center rounded-lg h-9 px-4 bg-primary text-white text-sm font-medium shadow-sm hover:bg-sky-500 transition-colors">
                                            Reservar de nuevo
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="flex flex-col items-center justify-center p-8 bg-white dark:bg-[#1a2c35] rounded-xl border border-gray-100 dark:border-gray-800 text-center">
                            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-full mb-4">
                                <span class="material-symbols-outlined text-4xl text-gray-400">history_toggle_off</span>
                            </div>
                            <h3 class="text-lg font-bold text-[#111618] dark:text-white mb-2">No tienes estancias pasadas</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-6 max-w-xs mx-auto">Tus viajes completados aparecerán aquí para que puedas recordarlos.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div id="apartments-content" class="flex flex-col gap-4 hidden">
                    <div class="flex items-center justify-between">
                        <h3 data-key="available-apartments" class="text-[#111618] dark:text-white text-lg font-bold">Apartamentos disponibles</h3>
                        <button onclick="switchTab('upcoming')" class="text-primary hover:text-sky-600 text-sm font-bold">Volver</button>
                    </div>

                    <?php if ($result_apartamentos && $result_apartamentos->num_rows > 0): ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="apartamentos-list">
                            <?php while ($apt = $result_apartamentos->fetch_assoc()):
                                $apt_id = (int)($apt['id'] ?? 0);
                                $apt_titulo = htmlspecialchars($apt['titulo'] ?? 'Apartamento');
                                $apt_titulo_js = htmlspecialchars($apt['titulo'] ?? 'Apartamento', ENT_QUOTES);
                                $apt_ubicacion = htmlspecialchars($apt['ubicacion'] ?? '');
                                $apt_precio = isset($apt['precio']) ? (float)$apt['precio'] : 0;
                                $apt_imagen = htmlspecialchars($apt['imagen_principal'] ?? '');
                            ?>
                                <div class="flex flex-col rounded-xl bg-white dark:bg-[#1a2c35] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-all">
                                    <div class="w-full h-44 bg-center bg-no-repeat bg-cover" style='background-image: url("../../assets/img/apartamentos/<?php echo $apt_imagen; ?>");'></div>
                                    <div class="p-5 flex flex-col gap-3">
                                        <div>
                                            <h4 class="text-[#111618] dark:text-white font-bold text-base leading-tight line-clamp-2"><?php echo $apt_titulo; ?></h4>
                                            <?php if (!empty($apt_ubicacion)): ?>
                                                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-sm">location_on</span>
                                                    <?php echo $apt_ubicacion; ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                <span class="font-bold text-[#111618] dark:text-white">$<?php echo number_format($apt_precio, 0, ',', '.'); ?></span>
                                                <span class=""> / noche</span>
                                            </div>
                                            <button onclick="openApartmentModal(<?php echo $apt_id; ?>, '<?php echo $apt_titulo_js; ?>')" class="flex items-center justify-center rounded-lg h-9 px-4 bg-primary text-white text-sm font-medium shadow-sm hover:bg-sky-500 transition-colors">
                                                Ver y reservar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="flex flex-col items-center justify-center p-8 bg-white dark:bg-[#1a2c35] rounded-xl border border-gray-100 dark:border-gray-800 text-center">
                            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-full mb-4">
                                <span class="material-symbols-outlined text-4xl text-gray-400">apartment</span>
                            </div>
                            <h3 data-key="no-apartments" class="text-lg font-bold text-[#111618] dark:text-white mb-2">No hay apartamentos disponibles</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-0 max-w-xs mx-auto">Vuelve a intentarlo más tarde.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


            <div class="bg-white dark:bg-[#1a2c35] rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-0 overflow-hidden">
                <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 data-key="pqr-title" class="text-[#111618] dark:text-white font-bold text-base">Mis Solicitudes (PQR)</h3>
                    <?php if ($num_pqr_activas > 0): ?>
                        <span class="bg-primary/10 text-primary text-xs font-bold px-2 py-1 rounded"><?php echo $num_pqr_activas; ?> Activa<?php echo $num_pqr_activas > 1 ? 's' : ''; ?></span>
                    <?php endif; ?>
                </div>

                <div class="max-h-[300px] overflow-y-auto">
                    <?php if (!empty($pqr_list)): ?>
                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            <?php foreach ($pqr_list as $pqr):
                                $estadoClass = '';
                                if ($pqr['estado'] == 'Pendiente') $estadoClass = 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400';
                                elseif ($pqr['estado'] == 'En Progreso') $estadoClass = 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400';
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
                            <img id="preview-image" src="<?php echo $profile_image; ?>" class="w-full h-full object-cover" referrerpolicy="no-referrer">
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
                        <input name="email" value="<?php echo $_SESSION['email']; ?>" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-primary text-[#111618] dark:text-white <?php echo $is_google_user ? 'opacity-70 cursor-not-allowed' : ''; ?>" type="email" required <?php echo $is_google_user ? 'readonly' : ''; ?> />

                        <div class="mt-2">
                            <?php if ($is_verified): ?>
                                <div class="w-full flex items-center justify-center gap-2 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 px-3 py-2 rounded-lg border border-green-100 dark:border-green-800" title="Cuenta verificada">
                                    <span class="material-symbols-outlined text-base">verified</span>
                                    <span class="text-xs font-bold">Correo verificado</span>
                                </div>
                            <?php else: ?>
                                <button type="button" onclick="enviarVerificacion()" class="w-full bg-yellow-100 hover:bg-yellow-200 text-yellow-800 text-xs font-bold px-3 py-2 rounded-lg transition-colors flex items-center justify-center gap-2 border border-yellow-200" title="Haz clic para verificar tu correo">
                                    <span class="material-symbols-outlined text-base">mark_email_unread</span>
                                    Enviar correo de verificación
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!$is_google_user): ?>
                        <div>
                            <label class="block text-xs font-bold text-[#111618] dark:text-white mb-1.5">Nueva Contraseña</label>
                            <input name="password" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-primary text-[#111618] dark:text-white" type="password" placeholder="••••••••" />
                        </div>
                    <?php endif; ?>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-2 sticky bottom-0 z-10">
                    <a class="px-4 py-2 text-xs font-bold text-gray-500 hover:text-[#111618] dark:hover:text-white transition-colors cursor-pointer" onclick="closeConfigModal()">Cancelar</a>
                    <button type="submit" class="px-4 py-2 bg-primary hover:bg-sky-600 text-white text-xs font-bold rounded-lg shadow-md transition-all">Guardar</button>
                </div>
            </form>
        </div>
    </div>



    <div class="hidden fixed inset-0 z-50 bg-black/60 items-center justify-center p-4 backdrop-blur-sm" id="apartment-modal">
        <div class="bg-white dark:bg-[#1a2c35] w-full max-w-6xl rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center shrink-0">
                <h3 id="apartment-modal-title" class="text-lg font-bold text-[#111618] dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">apartment</span>
                    <span id="apartment-modal-title-text">Apartamento</span>
                </h3>
                <a class="text-gray-500 hover:text-primary transition-colors cursor-pointer" onclick="closeApartmentModal()">
                    <span class="material-symbols-outlined">close</span>
                </a>
            </div>
            <div class="flex-1 bg-background-light dark:bg-background-dark">
                <iframe id="apartment-modal-iframe" title="Detalle de apartamento" class="w-full h-[80vh] bg-white dark:bg-background-dark" src="about:blank"></iframe>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('message', (event) => {
            if (!event || !event.data) return;
            if (event.origin !== window.location.origin) return;
            if (event.data.type === 'reservation_completed') {
                closeApartmentModal();
                switchTab('upcoming');
                window.location.reload();
            }
        });

        function switchTab(tab) {
            const upcomingContent = document.getElementById('upcoming-bookings');
            const pastContent = document.getElementById('past-bookings');
            const apartmentsContent = document.getElementById('apartments-content');

            const upcomingTab = document.getElementById('tab-upcoming');
            const pastTab = document.getElementById('tab-past');
            const apartmentsTab = document.getElementById('tab-apartments');

            const contents = {
                upcoming: upcomingContent,
                past: pastContent,
                apartments: apartmentsContent
            };

            const tabs = {
                upcoming: upcomingTab,
                past: pastTab,
                apartments: apartmentsTab
            };

            Object.values(contents).forEach(el => el.classList.add('hidden'));
            Object.values(tabs).forEach(el => {
                el.classList.remove('border-b-primary');
                el.classList.add('border-b-transparent', 'hover:border-b-gray-300');
            });

            if (contents[tab]) {
                contents[tab].classList.remove('hidden');
            }
            if (tabs[tab]) {
                tabs[tab].classList.add('border-b-primary');
                tabs[tab].classList.remove('border-b-transparent', 'hover:border-b-gray-300');
            }
        }

        function openApartmentModal(apartmentId, title) {
            const modal = document.getElementById('apartment-modal');
            const iframe = document.getElementById('apartment-modal-iframe');
            const modalTitleText = document.getElementById('apartment-modal-title-text');

            modalTitleText.textContent = title ? title : 'Apartamento';
            iframe.src = `../reserva-apartamento/apartamento.php?id=${apartmentId}&embed=1`;
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }

        function closeApartmentModal() {
            const modal = document.getElementById('apartment-modal');
            const iframe = document.getElementById('apartment-modal-iframe');
            iframe.src = 'about:blank';
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }



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
                    if (data.error) {
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
                "welcome-user": "Hola, Daniel",
                "welcome-sub": "Bienvenido a tu panel de control. Tu próxima aventura te espera.",
                "checkin-days": "Check-in: 3 Días",
                "hero-title": "Tu escapada a Santa Marta",
                "hero-sub": "Apartamento Vista al Mar - Edificio El Rodadero. Todo está listo para tu llegada.",
                "btn-arrival": "Ver detalles de llegada",
                "btn-guide": "Guía de la casa",
                "tab-upcoming": "Próximas reservas",
                "tab-past": "Estancias pasadas",
                "tab-apartments": "Apartamentos",
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
                "btn-new-pqr": "Nueva Solicitud",
                "available-apartments": "Apartamentos disponibles",
                "no-apartments": "No hay apartamentos disponibles"
            },
            en: {
                "welcome-user": "Hello, Daniel",
                "welcome-sub": "Welcome to your dashboard. Your next adventure awaits.",
                "checkin-days": "Check-in: 3 Days",
                "hero-title": "Your Santa Marta Getaway",
                "hero-sub": "Ocean View Apartment - El Rodadero Building. Everything is ready for you.",
                "btn-arrival": "View Arrival Details",
                "btn-guide": "House Guide",
                "tab-upcoming": "Upcoming Bookings",
                "tab-past": "Past Stays",
                "tab-apartments": "Apartments",
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

        window.addEventListener('message', (event) => {
            if (!event || !event.data) return;
            if (event.data.type === 'reservation_completed') {
                closeApartmentModal();
                switchTab('upcoming');
                window.location.reload();
            }
            if (event.data.type === 'close_apartment_modal') {
                closeApartmentModal();
            }
        });

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

        function enviarVerificacion() {
            if (!confirm("¿Deseas enviar un correo de verificación a tu dirección de email actual?")) return;

            fetch('enviar_verificacion_be.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // En localhost, mostramos el link directamente para facilitar
                        if (data.debug_link) {
                            let link = data.debug_link;
                            // Crear un modal o prompt temporal
                            let mensaje = "Correo 'enviado'.\n\nComo estás en un entorno de pruebas (Localhost), es probable que el correo no llegue realmente.\n\nCopia y pega este enlace en tu navegador para verificar:";
                            prompt(mensaje, link);
                            console.log("LINK DE VERIFICACIÓN: " + link);
                        } else {
                            alert(data.message);
                        }
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Ocurrió un error al intentar enviar la verificación.");
                });
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

                                const time = new Date(notif.fecha_respuesta).toLocaleTimeString('es-ES', {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });

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

            // Iniciar tour si no se ha visto
            if (!localStorage.getItem('huesped_tour_v1')) {
                setTimeout(startTour, 1000);
            }
        });

        function startTour() {
            const driver = window.driver.js.driver;

            const driverObj = driver({
                showProgress: true,
                animate: true,
                steps: [{
                        element: '#welcome-section',
                        popover: {
                            title: '¡Bienvenido!',
                            description: 'Este es tu panel de control principal donde podrás gestionar toda tu estancia.',
                            side: "bottom",
                            align: 'start'
                        }
                    },
                    {
                        element: '#hero-section',
                        popover: {
                            title: 'Próxima Aventura',
                            description: 'Aquí verás los detalles más importantes de tu próxima llegada o reserva activa.',
                            side: "bottom",
                            align: 'start'
                        }
                    },
                    {
                        element: '#tabs-navigation',
                        popover: {
                            title: 'Navegación',
                            description: 'Alterna entre tus reservas futuras, historial de viajes y explora nuevos apartamentos.',
                            side: "bottom",
                            align: 'start'
                        }
                    },
                    {
                        element: '#notification-btn',
                        popover: {
                            title: 'Notificaciones',
                            description: 'Recibe alertas sobre tus reservas y respuestas a tus solicitudes aquí.',
                            side: "bottom",
                            align: 'end'
                        }
                    },
                    {
                        element: '#profile-btn',
                        popover: {
                            title: 'Tu Perfil',
                            description: 'Configura tu cuenta, verifica tu correo y actualiza tus datos personales.',
                            side: "bottom",
                            align: 'end'
                        }
                    },
                    {
                        element: '#pqr-section',
                        popover: {
                            title: 'Centro de Ayuda (PQR)',
                            description: '¿Tienes alguna duda o inconveniente? Crea solicitudes de soporte aquí mismo.',
                            side: "top",
                            align: 'start'
                        }
                    }
                ],
                onDestroyed: () => {
                    localStorage.setItem('huesped_tour_v1', 'true');
                }
            });

            driverObj.drive();
        }
    </script>
    <!-- Modal de Reseña -->
    <div id="contenedorModalResena" style="display: none;" class="fixed inset-0 z-[9999] items-center justify-center bg-black/70 backdrop-blur-sm p-4">
        <div class="bg-white dark:bg-[#1a2c35] rounded-2xl p-6 w-full max-w-md shadow-2xl border border-gray-100 dark:border-gray-800">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-[#111618] dark:text-white">Calificar estadía</h3>
                <button type="button" onclick="cerrarLaModal()" class="text-gray-400 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form action="guardar_resena_be.php" method="POST">
                <input type="hidden" name="id_apartamento" id="modal_id_apartamento">
                <div class="flex flex-col items-center mb-6">
                    <div class="flex gap-1 mb-2">
                        <span onclick="marcarEstrellas(1)" class="js-estrella cursor-pointer text-4xl text-gray-300 material-symbols-outlined">star</span>
                        <span onclick="marcarEstrellas(2)" class="js-estrella cursor-pointer text-4xl text-gray-300 material-symbols-outlined">star</span>
                        <span onclick="marcarEstrellas(3)" class="js-estrella cursor-pointer text-4xl text-gray-300 material-symbols-outlined">star</span>
                        <span onclick="marcarEstrellas(4)" class="js-estrella cursor-pointer text-4xl text-gray-300 material-symbols-outlined">star</span>
                        <span onclick="marcarEstrellas(5)" class="js-estrella cursor-pointer text-4xl text-gray-300 material-symbols-outlined">star</span>
                    </div>
                    <input type="hidden" name="calificacion" id="input_estrellas_valor" required>
                </div>
                <textarea name="comentario" rows="4" required class="w-full p-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#111618] dark:text-white mb-4 placeholder:text-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" placeholder="Escribe tu opinión sobre tu estancia..."></textarea>
                <button type="submit" class="w-full py-3 bg-yellow-500 text-white rounded-xl font-bold hover:bg-yellow-600 shadow-lg shadow-yellow-500/20 transition-all">Enviar reseña</button>
            </form>
        </div>
    </div>

    <script>
        // Funciones para la Modal de Reseña
        window.prepararYAbrirModal = function(id) {
            console.log("Abriendo modal para ID:", id);
            var modal = document.getElementById('contenedorModalResena');
            var inputId = document.getElementById('modal_id_apartamento');

            if (modal && inputId) {
                inputId.value = id;
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            } else {
                console.error("No se encontró la modal.");
            }
        };

        window.cerrarLaModal = function() {
            var modal = document.getElementById('contenedorModalResena');
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        };

        window.marcarEstrellas = function(n) {
            var stars = document.querySelectorAll('.js-estrella');
            document.getElementById('input_estrellas_valor').value = n;
            stars.forEach((s, i) => {
                s.style.color = (i < n) ? '#facc15' : '#d1d5db';
                if (i < n) {
                    s.classList.add('fill-1');
                } else {
                    s.classList.remove('fill-1');
                }
            });
        };
    </script>
</body>

</html>