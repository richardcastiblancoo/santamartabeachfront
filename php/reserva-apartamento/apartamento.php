<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Conexión / Connection (Asegúrate de que $conn sea un objeto mysqli / Ensure $conn is a mysqli object)
include '../../auth/conexion_be.php';

$isEmbed = isset($_GET['embed']) && $_GET['embed'] === '1';

// Obtener y asegurar el ID del apartamento / Get and secure the apartment ID
$id_apartamento = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Inicialización de variables / Variable initialization
$apartamento = null;
$resenas = [];
$resenas_total = 0;
$resenas_fecha_col = 'fecha_creacion';
$puede_resenar = false;
$rangos_ocupados = [];
$imagenes_galeria = [];
$videos_galeria = [];
if ($id_apartamento > 0) {

    // 1. Consultar datos del apartamento y promedio de calificaciones / Query apartment data and average ratings (Sentencia Preparada / Prepared Statement)
    $stmt_apt = $conn->prepare("SELECT a.*, 
            COALESCE(AVG(r.calificacion), 0) as promedio_calificacion, 
            COUNT(r.id) as total_resenas 
            FROM apartamentos a 
            LEFT JOIN resenas r ON a.id = r.apartamento_id 
            WHERE a.id = ? 
            GROUP BY a.id");
    $stmt_apt->bind_param("i", $id_apartamento);
    $stmt_apt->execute();
    $result_apt = $stmt_apt->get_result();
    $apartamento = $result_apt->fetch_assoc();

    if ($apartamento) {
        // 2. Consultar Reseñas / Query Reviews
        $stmt_res = $conn->prepare("SELECT r.*, u.nombre, u.apellido, u.imagen
                            FROM resenas r
                            LEFT JOIN usuarios u ON r.usuario_id = u.id
                            WHERE r.apartamento_id = ?
                            ORDER BY r.id DESC"); // Ordena por el ID de la reseña
        $stmt_res->bind_param("i", $id_apartamento);
        $stmt_res->execute();
        $result_resenas = $stmt_res->get_result();
        while ($row = $result_resenas->fetch_assoc()) {
            $resenas[] = $row;
        }
        $resenas_total = count($resenas);

        // 3. Verificar si el usuario puede reseñar / Check if user can review (Seguro contra manipulación de sesión / Secure against session manipulation)
        if (isset($_SESSION['email'])) {
            $email_usuario = $_SESSION['email'];
            $fecha_actual = date('Y-m-d');
            $stmt_p = $conn->prepare("SELECT COUNT(*) as c FROM reservas
                                      WHERE email_cliente = ?
                                      AND apartamento_id = ?
                                      AND fecha_checkout < ?
                                      AND estado = 'confirmada'");
            $stmt_p->bind_param("sis", $email_usuario, $id_apartamento, $fecha_actual);
            $stmt_p->execute();
            $res_puede = $stmt_p->get_result()->fetch_assoc();
            $puede_resenar = ($res_puede['c'] > 0);
        }

        // 4. Rangos Ocupados para el Calendario / Occupied ranges for the calendar
        $stmt_r = $conn->prepare("SELECT fecha_checkin, fecha_checkout 
                                  FROM reservas 
                                  WHERE apartamento_id = ? 
                                  AND estado <> 'cancelada' 
                                  AND fecha_checkout > CURDATE()");
        $stmt_r->bind_param("i", $id_apartamento);
        $stmt_r->execute();
        $res_rangos = $stmt_r->get_result();

        while ($row = $res_rangos->fetch_assoc()) {
            $from = $row['fecha_checkin'];
            $to = $row['fecha_checkout'];
            if (!$from || !$to) continue;

            try {
                // Ajuste para que el día de salida aparezca como disponible / Adjustment so the departure day appears as available
                $toMinus = (new DateTime($to))->modify('-1 day')->format('Y-m-d');
                if ($toMinus >= $from) {
                    $rangos_ocupados[] = ['from' => $from, 'to' => $toMinus];
                }
            } catch (Exception $e) {
                continue;
            }
        }

        // 5 y 6. Consultar Galería / Query Gallery (Imagen y Video en una sola consulta / Image and Video in a single query)
        $stmt_g = $conn->prepare("SELECT ruta, tipo FROM galeria_apartamentos WHERE apartamento_id = ?");
        $stmt_g->bind_param("i", $id_apartamento);
        $stmt_g->execute();
        $res_galeria = $stmt_g->get_result();

        while ($row = $res_galeria->fetch_assoc()) {
            if ($row['tipo'] === 'video') {
                $videos_galeria[] = $row['ruta'];
            } else {
                $imagenes_galeria[] = $row['ruta'];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront | reserva</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <link rel="stylesheet" href="/css/apartamento-main.css">
    <link rel="shortcut icon" href="/public/img/logo-definitivo.webp" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="shortcut icon" href="/public/img/logo-def-Photoroom.png" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="/js/apartamento-main.js"></script>
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
                        "display": ["Plus Jakarta Sans"]
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
</head>

<body class="bg-background-light dark:bg-background-dark text-[#111618] dark:text-white transition-colors duration-300">
    <?php if (!$isEmbed): ?>
        <header class="w-full bg-white dark:bg-background-dark border-b border-solid border-[#f0f3f4] dark:border-slate-800 px-4 md:px-10 lg:px-40 py-3">
            <div class="flex items-center justify-between max-w-[1280px] mx-auto">
                <div class="flex items-center h-full">
                    <a href="/" class="flex items-center gap-2 logo-container">
                        <img src="/public/img/logo-def-Photoroom.png" alt="Logo" class="h-10 md:h-8 w-auto">
                        <h1 class="hidden md:block brand-text text-slate-900 dark:text-white text-lg font-black tracking-tighter uppercase" data-i18n="Santamartabeachfront">
                            Santamarta<span class="text-blue-400">beachfront</span>
                        </h1>
                    </a>
                </div>

                <div class="hidden md:flex items-center gap-4 lg:gap-6">
                    <div class="relative">
                        <button onclick="toggleLangDesktop()" class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            <img id="current-lang-flag" src="https://flagcdn.com/co.svg" class="w-5 h-5 rounded-full object-cover" alt="Colombia">
                            <span id="current-lang-text" class="text-sm font-medium text-slate-700 dark:text-slate-200">ES</span>
                            <span class="material-symbols-outlined text-[18px] text-slate-400">expand_more</span>
                        </button>
                        <div id="lang-dropdown" class="hidden absolute right-0 mt-2 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl overflow-hidden z-50">
                            <button onclick="selectLang('ES', 'https://flagcdn.com/co.svg')" class="w-full flex items-center gap-3 px-4 py-3 text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors text-slate-700 dark:text-slate-200">
                                <img src="https://flagcdn.com/co.svg" class="w-5 h-5 rounded-full object-cover" alt="ES">
                                <span data-i18n="Español">Español</span>
                            </button>
                            <button onclick="selectLang('EN', 'https://flagcdn.com/us.svg')" class="w-full flex items-center gap-3 px-4 py-3 text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors text-slate-700 dark:text-slate-200">
                                <img src="https://flagcdn.com/us.svg" class="w-5 h-5 rounded-full object-cover" alt="EN">
                                <span data-i18n="English">English</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="/auth/login.php" class="px-4 py-2 text-sm font-bold text-slate-700 dark:text-white hover:text-primary transition-colors" data-i18n="Iniciar sesión">Iniciar sesión</a>
                        <a href="/auth/registro.php" class="px-5 py-2 rounded-lg bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-all shadow-sm" data-i18n="Registrarse">Registrarse</a>
                    </div>
                </div>

                <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-slate-600 dark:text-slate-300">
                    <span class="material-symbols-outlined text-3xl">menu</span>
                </button>
            </div>
        </header>

        <div id="mobile-menu" class="fixed inset-0 z-[100] bg-white dark:bg-background-dark transform translate-x-full transition-transform duration-300 md:hidden flex flex-col">
            <div class="flex items-center justify-between p-4 border-b border-slate-100 dark:border-slate-800">

                <button onclick="toggleMobileMenu()" class="p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                    <span class="material-symbols-outlined text-2xl">close</span>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-4 flex flex-col gap-6">
                <div class="border rounded-xl border-slate-200 dark:border-slate-700 p-4">
                    <button onclick="toggleLangMobile()" class="w-full flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-medium text-slate-500 dark:text-slate-400" data-i18n="Idioma">Idioma</span>
                            <div class="flex items-center gap-2 px-2 py-1 bg-slate-100 dark:bg-slate-800 rounded-lg">
                                <img id="mobile-current-flag" src="https://flagcdn.com/co.svg" class="w-4 h-4 rounded-full object-cover" alt="Flag">
                                <span id="mobile-current-text" class="text-sm font-bold text-slate-700 dark:text-slate-200">ES</span>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-slate-400">expand_more</span>
                    </button>
                    <div id="mobile-lang-options" class="hidden mt-4 space-y-2 border-t border-slate-100 dark:border-slate-700 pt-4">
                        <button onclick="selectLang('ES', 'https://flagcdn.com/co.svg')" class="w-full flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            <img src="https://flagcdn.com/co.svg" class="w-5 h-5 rounded-full object-cover" alt="ES">
                            <span class="text-slate-700 dark:text-slate-200 font-medium" data-i18n="Español">Español</span>
                        </button>
                        <button onclick="selectLang('EN', 'https://flagcdn.com/us.svg')" class="w-full flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            <img src="https://flagcdn.com/us.svg" class="w-5 h-5 rounded-full object-cover" alt="EN">
                            <span class="text-slate-700 dark:text-slate-200 font-medium" data-i18n="English">English</span>
                        </button>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <a href="/auth/login.php" class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-white font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        <span class="material-symbols-outlined text-slate-400">login</span>
                        <span data-i18n="Iniciar sesión">Iniciar sesión</span>
                    </a>
                    <a href="/auth/registro.php" class="flex items-center gap-3 p-4 rounded-xl bg-primary text-white font-bold shadow-lg shadow-primary/30 hover:bg-primary/90 transition-all">
                        <span class="material-symbols-outlined">person_add</span>
                        <span data-i18n="Registrarse">Registrarse</span>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <main class="max-w-[1280px] mx-auto px-4 md:px-10 lg:px-40 py-6">
        <?php if ($apartamento): ?>
            <div class="flex flex-wrap justify-between items-end gap-4 py-4">
                <div class="flex flex-col gap-2">
                    <h1 class="text-[#111618] dark:text-white text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]"><?php echo $apartamento['titulo']; ?></h1>
                    <div class="flex items-center gap-2 text-[#617c89] dark:text-slate-400">
                        <span class="material-symbols-outlined text-sm">location_on</span>
                        <p class="text-base font-normal">Torre 4 - Reserva del Mar 1 Calle 22 # 1 - 67 Playa Salguero, Santa Marta· ★ <?php echo $apartamento['total_resenas'] > 0 ? number_format($apartamento['promedio_calificacion'], 1) : '0 (Sin reseñas)'; ?> (<?php echo $apartamento['total_resenas']; ?> reseñas)</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button onclick="shareApartment()" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-[#111618] text-white border border-[#111618] text-sm font-bold hover:bg-black/90 transition-colors shadow-lg">
                        <span class="material-symbols-outlined text-[20px]">share</span> <span data-i18n="Compartir">Compartir</span>
                    </button>
                </div>
            </div>

            <?php
            $ruta_img = '/assets/img/apartamentos/' . $apartamento['imagen_principal'];
            ?>

            <div class="grid grid-cols-2 md:grid-cols-4 grid-rows-2 gap-3 h-[600px] md:h-[550px] mt-4 rounded-2xl overflow-hidden relative">

                <div class="col-span-2 md:row-span-2 relative group overflow-hidden" onclick="openGallery()">
                    <div class="w-full h-full bg-center bg-no-repeat bg-cover transition-transform duration-700 group-hover:scale-105 cursor-pointer"
                        data-alt="<?php echo $apartamento['titulo']; ?>"
                        style='background-image: url("<?php echo $ruta_img; ?>");'></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black/20 cursor-pointer">
                        <div class="w-16 h-16 rounded-full bg-white/30 backdrop-blur-md flex items-center justify-center border border-white/50">
                            <span class="material-symbols-outlined text-white text-4xl">fullscreen</span>
                        </div>
                    </div>
                </div>
                <?php
                $media_items = [];
                foreach ($imagenes_galeria as $img) {
                    $media_items[] = ['type' => 'image', 'src' => '/assets/img/apartamentos/' . $img];
                }
                foreach ($videos_galeria as $vid) {
                    $media_items[] = ['type' => 'video', 'src' => '/assets/video/apartamentos/' . $vid];
                }

                for ($i = 0; $i < 4; $i++):
                    if (isset($media_items[$i])):
                        $item = $media_items[$i];
                ?>
                        <div class="relative group overflow-hidden cursor-pointer h-full min-h-[120px]" onclick="openGallery()">
                            <?php if ($item['type'] == 'image'): ?>
                                <div class="w-full h-full bg-center bg-no-repeat bg-cover transition-transform duration-500 group-hover:scale-105"
                                    style='background-image: url("<?php echo $item['src']; ?>");'></div>
                            <?php else: ?>
                                <div class="w-full h-full bg-black relative">
                                    <video src="<?php echo $item['src']; ?>" class="w-full h-full object-cover opacity-80"></video>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-white text-2xl drop-shadow-lg">play_circle</span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($i == 3): // Botones de conteo 
                            ?>
                                <?php
                                $total_fotos = count($imagenes_galeria) + ($apartamento['imagen_principal'] ? 1 : 0);
                                $total_videos = count($videos_galeria);
                                ?>
                                <div class="absolute bottom-2 right-2 md:bottom-4 md:right-4 flex flex-col gap-1 md:gap-2 z-10">
                                    <button onclick="openGallery()" class="bg-[#111618] px-2 py-1.5 md:px-4 md:py-2.5 rounded-lg md:rounded-xl text-[10px] md:text-xs font-bold flex items-center gap-1 md:gap-2 text-white shadow-xl">
                                        <span class="material-symbols-outlined text-[14px] md:text-[18px]">photo_library</span>
                                        <span><?php echo $total_fotos; ?> <span class="hidden xs:inline" data-i18n="Fotos">Fotos</span></span>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="relative group overflow-hidden bg-gray-100 dark:bg-slate-800 flex items-center justify-center min-h-[120px]">
                            <span class="material-symbols-outlined text-gray-300 text-2xl">image</span>
                        </div>
                <?php
                    endif;
                endfor;
                ?>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 py-10">
                <div class="lg:col-span-2">
                    <div class="border-b border-slate-200 dark:border-slate-800 pb-6 mb-8">
                        <h2 class="text-2xl font-bold mb-2">Alojamiento Completo: <?php echo $apartamento['titulo']; ?></h2>
                        <p class="text-[#617c89] dark:text-slate-400"><?php echo $apartamento['capacidad']; ?> Huéspedes · <?php echo $apartamento['habitaciones']; ?> habitaciones · 6 camas . <?php echo $apartamento['banos']; ?> Baños</p>
                    </div>
                    <section class="mb-10">
                        <h3 class="text-xl font-bold mb-4">Sobre este apartamento</h3>
                        <p class="text-[#4b5563] dark:text-slate-300 leading-relaxed">
                            <?php echo nl2br($apartamento['descripcion']); ?>
                        </p>
                    </section>

                    <section class="mb-10 pt-8 border-t border-slate-200 dark:border-slate-800">
                        <h3 class="text-xl font-bold mb-6">Lo que este lugar ofrece</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php
                            if (!empty($apartamento['servicios'])) {
                                $servicios = json_decode($apartamento['servicios'], true);

                                $iconMap = [
                                    "Acomodación y dormitorios" => "bed",
                                    "Entretenimiento" => "theater_comedy",
                                    "Aire acondicionado" => "ac_unit",
                                    "Vistas panorámicas" => "panorama",
                                    "Agua caliente" => "water_drop",
                                    "Amenities" => "soap",
                                    "Lavadora y Secadora" => "local_laundry_service",
                                    "Atención 24/7" => "support_agent",
                                    "Seguridad 24/7" => "local_police",
                                    "Coworking" => "work",
                                    "Wifi" => "wifi",
                                    "Televisión" => "tv",
                                    "Gimnasio" => "fitness_center",
                                    "Piscinas" => "pool",
                                    "Vista a la bahía" => "water",
                                    "Vista a la playa" => "beach_access",
                                    "Vista a las montañas" => "landscape",
                                    "Vista al mar" => "sailing",
                                    "Beneficios para huéspedes" => "loyalty",
                                    "Admitimos mascotas" => "pets",
                                    "Estadías largas" => "calendar_month",
                                    "Limpieza (cargo adicional)" => "cleaning_services",
                                    "Estacionamiento gratuito" => "local_parking",
                                    "Cafe · Bar Piso 1" => "coffee",
                                    "Cafetería Piso 18" => "coffee_maker",
                                    "Servicio de restaurantes" => "restaurant",
                                    "Check in 15:00 - 18:00 Hr" => "login",
                                    "Check out 11:00 Hr" => "logout",
                                    "Horas de silencio 23:00 - 7:00 Hr" => "volume_off"
                                ];

                                if (is_array($servicios)) {
                                    $count = 0;
                                    foreach ($servicios as $servicio) {
                                        $count++;
                                        $hiddenClass = ($count > 8) ? 'hidden service-item-extra' : '';
                                        $icono = isset($iconMap[$servicio]) ? $iconMap[$servicio] : 'check_circle';
                            ?>
                                        <div class="flex items-center gap-4 py-2 <?php echo $hiddenClass; ?>">
                                            <span class="material-symbols-outlined text-primary text-2xl"><?php echo $icono; ?></span>
                                            <span class="text-base font-medium"><?php echo $servicio; ?></span>
                                        </div>
                                    <?php
                                    }

                                    if (count($servicios) > 8) {
                                    ?>
                                        <div class="md:col-span-2 mt-4">
                                            <button id="toggle-services-btn" onclick="toggleServices()" class="border border-slate-900 dark:border-white text-slate-900 dark:text-white px-6 py-2.5 rounded-lg font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-sm tracking-wide">
                                                Mostrar más
                                            </button>
                                        </div>
                            <?php
                                    }
                                }
                            } else {
                                echo '<p class="text-slate-500">No hay servicios especificados.</p>';
                            }
                            ?>
                        </div>
                    </section>

                    <div class="max-w-[600px] mx-auto bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden font-sans text-gray-800">

                        <div class="p-8 pb-6 bg-white">
                            <h2 id="status-text" class="text-3xl font-bold text-gray-900 transition-all duration-300">Seleccione su llegada</h2>
                            <p id="helper-text" class="text-gray-500 mt-2">Apartamento 1730 Reserva del Mar 1</p>
                        </div>

                        <div class="px-8 pb-8">
                            <div class="flex justify-between items-center mb-6">
                                <h3 id="calendar-month-year" class="font-bold text-lg text-gray-700"></h3>
                                <div class="flex space-x-2">
                                    <button id="prev-month" class="p-2 hover:bg-gray-100 rounded-full border border-gray-200 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </button>
                                    <button id="next-month" class="p-2 hover:bg-gray-100 rounded-full border border-gray-200 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-7 mb-2 border-b border-gray-50 pb-2">
                                <?php foreach (['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'] as $d): ?>
                                    <div class="text-center text-xs font-bold text-gray-400 uppercase tracking-widest"><?= $d ?></div>
                                <?php endforeach; ?>
                            </div>

                            <div class="grid grid-cols-7" id="custom-calendar-grid">
                                <!-- Generado por JS -->
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col gap-3">
                                <div class="flex justify-between items-center">
                                    <button id="custom-reset-btn" class="text-sm font-bold underline text-black hover:bg-gray-50 px-4 py-2 rounded-lg">Borrar fechas</button>
                                </div>
                                <p class="text-center text-sm text-gray-500">No se te cobrará nada todavía</p>
                            </div>
                        </div>
                    </div>

                    <style>
                        /* Estilos Airbnb */
                        .selected-point {
                            background-color: #222222 !important;
                            color: white !important;
                        }

                        .range-bg-active {
                            background-color: #f7f7f7 !important;
                            display: block !important;
                        }
                    </style>

                    <!-- Reseñas -->
                    <section class="mb-10 pt-8 border-t border-slate-200 dark:border-slate-800">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="material-symbols-outlined text-primary fill-1">star</span>
                            <h3 class="text-xl font-bold" id="resenas-header">
                                <?php if ($apartamento['total_resenas'] > 0): ?>
                                    <?php echo number_format($apartamento['promedio_calificacion'], 1); ?> · <?php echo $apartamento['total_resenas']; ?> <span data-i18n="reseñas">reseñas</span>
                                <?php else: ?>
                                    <span data-i18n="Sin reseñas">Sin reseñas</span>
                                <?php endif; ?>
                            </h3>
                        </div>

                        <?php if ($resenas_total > 0): ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8" id="reviews-grid">
                                <?php
                                $max_initial = 4;
                                $index = 0;
                                foreach ($resenas as $resena):
                                    $index++;
                                    $hiddenClass = ($index > $max_initial) ? 'hidden review-item-extra' : '';
                                    $nombre = trim(($resena['nombre'] ?? '') . ' ' . ($resena['apellido'] ?? ''));
                                    if ($nombre === '') $nombre = '<span data-i18n="Huésped">Huésped</span>';

                                    $img = '';
                                    if (!empty($resena['imagen'])) {
                                        $img = $resena['imagen'];
                                        if (str_starts_with($img, 'assets/')) {
                                            $img = '/' . ltrim($img, '/');
                                        } else {
                                            $img = '/assets/img/usuarios/' . ltrim($img, '/');
                                        }
                                    } else {
                                        $img = 'https://ui-avatars.com/api/?name=' . urlencode($nombre) . '&background=13a4ec&color=fff';
                                    }

                                    $fechaTexto = '';
                                    if ($resenas_fecha_col && !empty($resena[$resenas_fecha_col])) {
                                        $fechaTexto = date('F Y', strtotime($resena[$resenas_fecha_col]));
                                    }
                                    $cal = (int)($resena['calificacion'] ?? 0);
                                    if ($cal < 0) $cal = 0;
                                    if ($cal > 5) $cal = 5;
                                    $comentario = htmlspecialchars($resena['comentario'] ?? '');
                                ?>
                                    <div class="flex flex-col gap-3 <?php echo $hiddenClass; ?>">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-full bg-cover bg-center border border-slate-200 dark:border-slate-800" style="background-image: url('<?php echo htmlspecialchars($img); ?>');"></div>
                                            <div>
                                                <p class="font-bold"><?php echo htmlspecialchars($nombre); ?></p>
                                                <div class="flex items-center gap-2 text-xs text-[#617c89] dark:text-slate-400">
                                                    <div class="flex items-center gap-0.5">
                                                        <?php for ($s = 1; $s <= 5; $s++): ?>
                                                            <span class="material-symbols-outlined text-[16px] <?php echo $s <= $cal ? 'text-primary' : 'text-slate-300 dark:text-slate-600'; ?>">star</span>
                                                        <?php endfor; ?>
                                                    </div>
                                                    <?php if ($fechaTexto !== ''): ?>
                                                        <span class="w-1 h-1 bg-slate-300 dark:bg-slate-600 rounded-full"></span>
                                                        <span><?php echo htmlspecialchars($fechaTexto); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-sm text-[#4b5563] dark:text-slate-300"><?php echo $comentario; ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if ($resenas_total > 4): ?>
                                <button id="toggle-reviews-btn" onclick="toggleReviews()" class="mt-8 text-primary font-bold hover:underline" data-i18n="Mostrar todas las reseñas">Mostrar todas las reseñas</button>
                            <?php endif; ?>
                        <?php else: ?>
                            <div id="no-reviews-container" class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                                <p class="text-sm text-slate-600 dark:text-slate-400" data-i18n="Aún no hay reseñas para este apartamento.">Aún no hay reseñas para este apartamento.</p>
                            </div>
                        <?php endif; ?>
                    </section>

                    <!-- inicio del del mapa -->
                    <section class="pt-8 border-t border-slate-200 dark:border-slate-800">
                        <h3 class="text-xl font-bold mb-6 text-slate-900 dark:text-white" data-i18n="Dónde te quedarás">Dónde te quedarás</h3>

                        <div class="relative w-full h-80 rounded-2xl overflow-hidden shadow-inner border border-slate-200 dark:border-slate-700">
                            <div id="map" class="w-full h-full z-0"></div>

                            <a href="https://www.google.com/maps/dir/?api=1&destination=11.1909354,-74.2306332"
                                target="_blank"
                                class="absolute bottom-4 right-4 z-[1000] bg-white/90 backdrop-blur-sm dark:bg-slate-900/90 text-slate-800 dark:text-white px-4 py-2 rounded-xl shadow-lg text-xs font-bold flex items-center gap-2 hover:bg-white transition-all border border-slate-100 dark:border-slate-800">
                                <span class="material-symbols-outlined text-[18px]">directions</span>
                                <span data-i18n="Cómo llegar">Cómo llegar</span>
                            </a>
                        </div>

                        <div class="mt-5 flex items-start gap-3">
                            <span class="material-symbols-outlined text-blue-500 mt-1">location_on</span>
                            <div>
                                <p class="font-bold text-lg text-slate-900 dark:text-white leading-tight" data-i18n="">Apartamento 1730 - Torre 4 - Reserva del Mar 1</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1" data-i18n="">
                                    Calle 22 # 1 - 67 Playa Salguero, Santa Marta
                                </p>
                            </div>
                        </div>
                    </section>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const lat = 11.1909354;
                            const lng = -74.2306332;

                            // Inicializar mapa sin zoom de scroll molesto
                            const map = L.map('map', {
                                scrollWheelZoom: false,
                                zoomControl: false // Opcional: quita los botones +/- para un look más limpio
                            }).setView([lat, lng], 16);

                            // Capa de Mapa "Voyager": Colores suaves y amigables
                            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                                attribution: '© CartoDB'
                            }).addTo(map);

                            // Añadir control de zoom en una posición menos invasiva
                            L.control.zoom({
                                position: 'topright'
                            }).addTo(map);

                            // Marcador con un estilo azul amigable
                            const marker = L.marker([lat, lng]).addTo(map);
                            const lang = localStorage.getItem('preferredLang') || 'es';
                            const towerText = (translations[lang] && translations[lang]['Torre 4']) || 'Torre 4';
                            const resText = (translations[lang] && translations[lang]['Reserva del Mar 1']) || 'Reserva del Mar 1';
                            marker.bindPopup(`<b style='font-family: sans-serif;'>${resText}</b><br>${towerText}`).openPopup();
                        });
                    </script>
                    <!-- Fin del mapa -->
                </div>

                <!-- Sidebar de Reserva -->
                <div class="lg:col-span-1">
                    <div class="sticky top-28 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-2xl p-6">
                        <div class="flex justify-between items-baseline mb-6">
                            <div>
                                <span class="text-2xl font-black">$<?php echo number_format($apartamento['precio'], 0, ',', '.'); ?></span>
                                <span class="text-[#617c89] text-base" data-i18n="/ noche"> / noche</span>
                            </div>
                            <div class="flex items-center gap-1 text-sm font-semibold">
                                <span class="material-symbols-outlined text-primary text-[18px] fill-1">star</span> <?php echo $apartamento['total_resenas'] > 0 ? number_format($apartamento['promedio_calificacion'], 1) : '0'; ?>
                            </div>
                        </div>
                        <div class="rounded-xl border border-slate-300 dark:border-slate-700 mb-4 relative">
                            <div class="grid grid-cols-2 border-b border-slate-300 dark:border-slate-700">
                                <div class="p-3 border-r border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer relative rounded-tl-xl">
                                    <p class="text-[10px] font-black uppercase text-[#111618] dark:text-white" data-i18n="Llegada">Llegada</p>
                                    <input id="checkin-input" type="text" placeholder="Agrega fecha" data-i18n-placeholder="Agrega fecha" class="w-full bg-transparent border-none p-0 text-sm font-medium focus:ring-0 placeholder:text-slate-500" />
                                </div>
                                <div class="p-3 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer relative rounded-tr-xl" id="checkout-container">
                                    <p class="text-[10px] font-black uppercase text-[#111618] dark:text-white" data-i18n="Salida">Salida</p>
                                    <input id="checkout-input" type="text" placeholder="Agrega fecha" data-i18n-placeholder="Agrega fecha" class="w-full bg-transparent border-none p-0 text-sm font-medium focus:ring-0 placeholder:text-slate-500" readonly />
                                </div>
                            </div>
                            <div class="relative">
                                <div id="guest-selector-trigger" class="p-3 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer flex justify-between items-center rounded-b-xl">
                                    <div>
                                        <p class="text-[10px] font-black uppercase text-[#111618] dark:text-white" data-i18n="Huéspedes">Huéspedes</p>
                                        <p id="guest-summary" class="text-sm font-medium text-slate-700 dark:text-slate-300">1 <span data-i18n="Huésped">Huésped</span></p>
                                    </div>
                                    <span class="material-symbols-outlined text-slate-500">expand_more</span>
                                </div>

                                <div id="guest-dropdown" class="absolute top-full left-0 w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl p-4 mt-2 z-20 hidden">
                                    <div class="flex justify-between items-center mb-4">
                                        <div>
                                            <p class="font-bold text-sm" data-i18n="Adultos">Adultos</p>
                                            <p class="text-xs text-slate-500" data-i18n="Edad 13+">Edad 13+</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <button id="btn-adults-minus" onclick="updateGuest('adults', -1)" class="w-8 h-8 rounded-full border border-slate-300 flex items-center justify-center hover:border-black disabled:opacity-30 disabled:hover:border-slate-300">
                                                <span class="material-symbols-outlined text-base">remove</span>
                                            </button>
                                            <span id="count-adults" class="w-4 text-center font-medium">1</span>
                                            <button id="btn-adults-plus" onclick="updateGuest('adults', 1)" class="w-8 h-8 rounded-full border border-slate-300 flex items-center justify-center hover:border-black disabled:opacity-30 disabled:hover:border-slate-300">
                                                <span class="material-symbols-outlined text-base">add</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center mb-4">
                                        <div>
                                            <p class="font-bold text-sm" data-i18n="Niños">Niños</p>
                                            <p class="text-xs text-slate-500" data-i18n="Edad 2-12">Edad 2-12</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <button id="btn-children-minus" onclick="updateGuest('children', -1)" class="w-8 h-8 rounded-full border border-slate-300 flex items-center justify-center hover:border-black disabled:opacity-30 disabled:hover:border-slate-300" disabled>
                                                <span class="material-symbols-outlined text-base">remove</span>
                                            </button>
                                            <span id="count-children" class="w-4 text-center font-medium">0</span>
                                            <button id="btn-children-plus" onclick="updateGuest('children', 1)" class="w-8 h-8 rounded-full border border-slate-300 flex items-center justify-center hover:border-black disabled:opacity-30 disabled:hover:border-slate-300">
                                                <span class="material-symbols-outlined text-base">add</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center mb-4">
                                        <div>
                                            <p class="font-bold text-sm" data-i18n="Bebés">Bebés</p>
                                            <p class="text-xs text-slate-500" data-i18n="Menos de 2 años">Menos de 2 años</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <button id="btn-infants-minus" onclick="updateGuest('infants', -1)" class="w-8 h-8 rounded-full border border-slate-300 flex items-center justify-center hover:border-black disabled:opacity-30 disabled:hover:border-slate-300" disabled>
                                                <span class="material-symbols-outlined text-base">remove</span>
                                            </button>
                                            <span id="count-infants" class="w-4 text-center font-medium">0</span>
                                            <button id="btn-infants-plus" onclick="updateGuest('infants', 1)" class="w-8 h-8 rounded-full border border-slate-300 flex items-center justify-center hover:border-black disabled:opacity-30 disabled:hover:border-slate-300">
                                                <span class="material-symbols-outlined text-base">add</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center mb-4">
                                        <div>
                                            <p class="font-bold text-sm" data-i18n="Perro de guía">Perro de guía</p>
                                            <p class="text-xs text-slate-500" data-i18n="¿Tienes un perro de guía?">¿Tienes un perro de guía?</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" id="guide-dog-toggle" class="sr-only peer" onchange="toggleGuideDog(this.checked)">
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button onclick="closeGuestDropdown()" class="text-sm font-bold underline hover:text-primary" data-i18n="Cerrar">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button onclick="goToReservation()" class="w-full py-4 bg-primary text-white rounded-xl font-bold text-lg hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 mb-4" data-i18n="Reservar ahora">
                            Reservar ahora
                        </button>
                        <p class="text-center text-sm text-[#617c89] mb-6" data-i18n="No se te cobrará nada todavía">No se te cobrará nada todavía</p>

                        <div id="price-breakdown" class="hidden space-y-3 mb-6">
                            <div class="flex justify-between text-base">
                                <span class="underline text-[#4b5563] dark:text-slate-300">$<span id="base-price-display">0</span> x <span id="nights-display">0</span> <span id="nights-text" data-i18n="noches">noches</span></span>
                                <span class="font-medium">$<span id="subtotal-display">0</span></span>
                            </div>
                            <div class="flex justify-between text-base">
                                <span class="underline text-[#4b5563] dark:text-slate-300" data-i18n="Tarifa de limpieza">Tarifa de limpieza</span>
                                <span class="font-medium">$<span id="cleaning-fee-display">0</span></span>
                            </div>

                            <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex justify-between items-center font-bold text-lg">
                                <span data-i18n="Total">Total</span>
                                <span>$<span id="total-display">0</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="text-center py-20">
                <h1 class="text-3xl font-bold mb-4" data-i18n="Apartamento no encontrado">Apartamento no encontrado</h1>
                <p class="mb-8" data-i18n="El apartamento que buscas no existe o ha sido eliminado.">El apartamento que buscas no existe o ha sido eliminado.</p>
                <a href="/" class="bg-primary text-white px-6 py-3 rounded-lg font-bold" data-i18n="Volver al inicio">Volver al inicio</a>
            </div>
        <?php endif; ?>
    </main>

    <?php if ($apartamento): ?>
        <!-- footer -->
        <footer class="bg-[#101c22] text-white pt-10 pb-10 mt-[-2rem]" id="contacto">
            <div class="max-w-7xl mx-auto px-6 md:px-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 lg:gap-24 py-16 items-start border-t border-white/5">

                    <section class="flex flex-col items-center md:items-start text-center md:text-left">
                        <a href="/" class="flex items-center gap-1 group w-fit mb-6">

                            <div class="w-24 h-24 md:w-32 md:h-32 shrink-0">
                                <img src="/public/img/logo-def-Photoroom.png" alt="logo" class="w-full h-full object-contain">
                            </div>

                            <span class="text-xl md:text-2xl font-bold text-white tracking-tighter -ml-2 md:-ml-4">
                                Santamarta<span class="text-blue-400">beachfront</span>
                            </span>
                        </a>

                        <p class="text-gray-300 text-sm leading-relaxed max-w-xs md:pl-5 md:border-l md:border-blue-400/20" data-i18n="footer-desc">
                            La plataforma líder en alquileres vacacionales de lujo en Santa Marta. Experiencias únicas, confort superior y las mejores vistas del Caribe colombiano.
                        </p>
                    </section>

                    <section class="lg:pl-12 flex flex-col items-center md:items-start">
                        <h2 class="font-bold mb-8 text-white uppercase tracking-widest text-xs" data-i18n="footer-contact-title">Información de Contacto</h2>
                        <address class="not-italic">
                            <ul class="space-y-5 text-sm text-gray-300 text-center md:text-left">
                                <li>
                                    <a href="mailto:17clouds@gmail.com" class="flex items-center justify-center md:justify-start gap-3 hover:text-blue-400 transition-colors">
                                        <span class="material-symbols-outlined text-blue-400">mail</span> 17clouds@gmail.com
                                    </a>
                                </li>
                                <li>
                                    <a href="https://wa.me/573183813381" class="flex items-center justify-center md:justify-start gap-3 hover:text-blue-400 transition-colors">
                                        <span class="material-symbols-outlined text-blue-400">call</span> +57 318 3813381
                                    </a>
                                </li>
                                <li class="flex items-start justify-center md:justify-start gap-3">
                                    <span class="material-symbols-outlined text-blue-400 shrink-0">location_on</span>
                                    <span>
                                        Apartamento 1730 - Torre 4 - Reserva del Mar 1<br>
                                        Calle 22 # 1 - 67 Playa Salguero,<br>
                                        Santa Marta, Colombia
                                    </span>
                                </li>
                            </ul>
                        </address>
                    </section>

                    <section class="lg:items-end flex flex-col">
                        <div class="w-fit lg:text-right">
                            <h2 class="font-bold mb-8 text-white uppercase tracking-wider text-xs" data-i18n="foo_social_title">Síguenos</h2>
                            <nav aria-label="Redes sociales">
                                <ul class="flex gap-4 list-none p-0 lg:justify-end">
                                    <li>
                                        <a class="w-12 h-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center hover:bg-gradient-to-tr hover:from-[#f09433] hover:via-[#dc2743] hover:to-[#bc1888] transition-all duration-300 group" href="#" target="_blank" rel="noopener" aria-label="Instagram">
                                            <i class="fa-brands fa-instagram text-xl text-gray-300 group-hover:text-white"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="w-12 h-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center hover:bg-black transition-all duration-300 group" href="#" target="_blank" rel="noopener" aria-label="Twitter">
                                            <i class="fa-brands fa-x-twitter text-xl text-gray-300 group-hover:text-white"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="w-12 h-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center hover:bg-[#ff0050] transition-all duration-300 group" href="#" target="_blank" rel="noopener" aria-label="TikTok">
                                            <i class="fa-brands fa-tiktok text-xl text-gray-300 group-hover:text-white"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </section>
                </div>

                <aside class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-gray-800 text-xs text-gray-400 text-center gap-4">
                    <p>
                        © <time id="current-year" datetime="2026">2026</time> Santamarta Beachfront.
                        <span data-i18n="foo_rights">Todos los derechos reservados.</span> |
                        <span data-i18n="Hecho por">Hecho por</span> <a href="https://richardcastiblanco.vercel.app/" target="_blank" rel="noopener noreferrer" class="font-bold hover:text-white">Richard Castiblanco</a>
                    </p>

                    <nav aria-label="Enlaces legales">
                        <ul class="flex gap-8 list-none p-0">
                            <li><a class="hover:text-white transition-colors" href="/php/politica-terminos/politica-privacidad.php" data-i18n="foo_privacy">Políticas de Privacidad</a></li>
                            <li><a class="hover:text-white transition-colors" href="/php/politica-terminos/politica-privacidad.php" data-i18n="foo_terms">Términos y Condiciones</a></li>
                        </ul>
                    </nav>
                </aside>
            </div>
        </footer>

        <script>
            const yearElement = document.getElementById('current-year');
            const currentYear = new Date().getFullYear();
            yearElement.textContent = currentYear;
            yearElement.setAttribute('datetime', currentYear);
        </script>

        <div id="gallery-modal" class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-xl hidden flex-col transition-all duration-300">
            <div class="p-4 flex justify-between items-center text-white border-b border-white/10 bg-black/20 sticky top-0 w-full z-20">
                <button onclick="closeGallery()" class="p-2 hover:bg-white/10 rounded-full transition-all group">
                    <span class="material-symbols-outlined group-hover:rotate-90 transition-transform">close</span>
                </button>
                <div class="flex flex-col items-center">
                    <span class="font-bold text-lg tracking-wide" data-i18n="Galería del Apartamento">Galería del Apartamento</span>
                    <span class="text-xs text-white/50 uppercase tracking-widest" data-i18n="Explora los espacios">Explora los espacios</span>
                </div>
                <div class="w-10"></div>
            </div>

            <div class="flex-1 overflow-y-auto p-4 md:p-8 lg:p-12">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 max-w-7xl mx-auto auto-rows-[150px] md:auto-rows-[200px]">
                    <?php $globalIndex = 0; ?>

                    <?php if ($apartamento['imagen_principal']): ?>
                        <div class="col-span-2 row-span-2 relative rounded-2xl overflow-hidden cursor-pointer group shadow-2xl"
                            onclick="openLightbox(<?php echo $globalIndex++; ?>)">
                            <img src="<?php echo $ruta_img; ?>"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                alt="Principal">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                                <p class="text-white text-sm font-light" data-i18n="Vista principal">Vista principal</p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php foreach ($imagenes_galeria as $img): ?>
                        <div class="relative rounded-xl md:rounded-2xl overflow-hidden cursor-pointer group shadow-lg"
                            onclick="openLightbox(<?php echo $globalIndex++; ?>)">
                            <img src="/assets/img/apartamentos/<?php echo $img; ?>"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                alt="Galería">
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                        </div>
                    <?php endforeach; ?>

                    <?php foreach ($videos_galeria as $vid): ?>
                        <div class="relative rounded-xl md:rounded-2xl overflow-hidden bg-zinc-900 cursor-pointer group shadow-lg border border-white/5"
                            onclick="openLightbox(<?php echo $globalIndex++; ?>)">
                            <video src="/assets/video/apartamentos/<?php echo $vid; ?>"
                                class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity"></video>

                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-white/10 backdrop-blur-md border border-white/30 group-hover:scale-110 group-hover:bg-white/20 transition-all">
                                    <span class="material-symbols-outlined text-white text-3xl">play_arrow</span>
                                </div>
                                <span class="text-[10px] text-white/70 mt-2 font-bold tracking-tighter uppercase" data-i18n="Video Tour">Video Tour</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="py-20 text-center">
                    <p class="text-white/20 text-sm italic" data-i18n="Fin de la galería">Fin de la galería</p>
                </div>
            </div>
        </div>

        <!-- Modal para ver imagen/video individual en grande -->
        <div id="lightbox-modal" class="fixed inset-0 z-[110] bg-black/95 hidden flex justify-center items-center p-4">
            <button onclick="closeLightbox()" class="absolute top-4 right-4 p-2 text-white hover:bg-white/20 rounded-full transition-colors z-30">
                <span class="material-symbols-outlined text-3xl">close</span>
            </button>

            <button onclick="changeSlide(-1)" class="absolute left-4 p-2 text-white hover:bg-white/20 rounded-full transition-colors z-30 hidden md:block">
                <span class="material-symbols-outlined text-5xl">chevron_left</span>
            </button>

            <div id="lightbox-content" class="w-full max-w-6xl h-full flex justify-center items-center relative p-4">
                <!-- Contenido dinámico -->
            </div>

            <button onclick="changeSlide(1)" class="absolute right-4 p-2 text-white hover:bg-white/20 rounded-full transition-colors z-30 hidden md:block">
                <span class="material-symbols-outlined text-5xl">chevron_right</span>
            </button>
        </div>


    <?php endif; ?>


    <script>
        // --- 1. UTILIDADES Y COMPARTIR ---
        function shareApartment() {
            const lang = localStorage.getItem('preferredLang') || 'es';
            const shareText = (translations[lang] && translations[lang]['Mira este increíble apartamento en Santa Marta']) || 'Mira este increíble apartamento en Santa Marta';
            const copyText = (translations[lang] && translations[lang]['¡Enlace copiado al portapapeles!']) || '¡Enlace copiado al portapapeles!';

            if (navigator.share) {
                navigator.share({
                    title: <?php echo json_encode($apartamento['titulo'] ?? 'Apartamento'); ?>,
                    text: shareText,
                    url: window.location.href
                }).catch(console.error);
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert(copyText);
                });
            }
        }

        function toggleServices() {
            const extras = document.querySelectorAll('.service-item-extra');
            const btn = document.getElementById('toggle-services-btn');
            const lang = localStorage.getItem('preferredLang') || 'es';
            let isHidden = true;

            extras.forEach(item => {
                if (item.classList.contains('hidden')) {
                    item.classList.remove('hidden');
                    isHidden = false;
                } else {
                    item.classList.add('hidden');
                    isHidden = true;
                }
            });

            btn.setAttribute('data-i18n', isHidden ? 'Mostrar más' : 'Mostrar menos');

            if (typeof applyTranslations === 'function') {
                applyTranslations(lang);
            }
        }

        // --- 2. GALERÍA Y LIGHTBOX ---
        const galleryItems = [
            <?php if ($apartamento['imagen_principal']): ?> {
                    type: 'image',
                    src: <?php echo json_encode($ruta_img); ?>
                },
            <?php endif; ?>
            <?php foreach ($imagenes_galeria as $img): ?> {
                    type: 'image',
                    src: <?php echo json_encode('/assets/img/apartamentos/' . $img); ?>
                },
            <?php endforeach; ?>
            <?php foreach ($videos_galeria as $vid): ?> {
                    type: 'video',
                    src: <?php echo json_encode('/assets/video/apartamentos/' . $vid); ?>
                },
            <?php endforeach; ?>
        ];

        let currentIndex = 0;

        function openGallery() {
            const modal = document.getElementById('gallery-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeGallery() {
            const modal = document.getElementById('gallery-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        function openLightbox(index) {
            currentIndex = index;
            updateLightboxContent();
            document.getElementById('lightbox-modal').classList.remove('hidden');
        }

        function updateLightboxContent() {
            const item = galleryItems[currentIndex];
            const content = document.getElementById('lightbox-content');

            // Detener videos anteriores
            const oldVideo = content.querySelector('video');
            if (oldVideo) oldVideo.pause();

            if (item.type === 'image') {
                content.innerHTML = `<img src="${item.src}" class="max-w-full max-h-full object-contain shadow-2xl rounded-lg">`;
            } else {
                content.innerHTML = `<video src="${item.src}" controls autoplay class="max-w-full max-h-full shadow-2xl rounded-lg"></video>`;
            }
        }

        function changeSlide(direction) {
            currentIndex += direction;
            if (currentIndex < 0) currentIndex = galleryItems.length - 1;
            if (currentIndex >= galleryItems.length) currentIndex = 0;
            updateLightboxContent();
        }

        function closeLightbox() {
            document.getElementById('lightbox-modal').classList.add('hidden');
            const content = document.getElementById('lightbox-content');
            const video = content.querySelector('video');
            if (video) video.pause();
            content.innerHTML = '';
        }

        // Navegación por teclado
        document.addEventListener('keydown', function(e) {
            if (document.getElementById('lightbox-modal').classList.contains('hidden')) return;
            if (e.key === 'ArrowLeft') changeSlide(-1);
            if (e.key === 'ArrowRight') changeSlide(1);
            if (e.key === 'Escape') closeLightbox();
        });

        // --- 3. LÓGICA DE RESERVA Y PRECIOS ---
        const basePrice = <?php echo $apartamento['precio']; ?>;
        const maxCapacity = 8;
        const cleaningFee = 80000;

        let guests = {
            adults: 1,
            children: 0,
            infants: 0,
            guideDog: false
        };

        let selectedDates = {
            checkin: null,
            checkout: null
        };

        const bookedRanges = <?php echo json_encode($rangos_ocupados, JSON_UNESCAPED_SLASHES); ?>;

        // Variable para controlar si el datepicker está abierto
        let isDatePickerOpen = false;

        const fp = flatpickr("#checkin-input", {
            locale: "es",
            minDate: "today",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            mode: "range",
            disable: bookedRanges,
            onOpen: function() {
                isDatePickerOpen = true;
            },
            onClose: function() {
                isDatePickerOpen = false;
            },
            onChange: function(dates) {
                if (dates.length === 2) {
                    selectedDates.checkin = dates[0];
                    selectedDates.checkout = dates[1];
                    document.getElementById('checkout-input').value = fp.formatDate(dates[1], "d/m/Y");
                    calculatePrice();
                    // Cuando se completan las fechas, ya no mostramos advertencia
                    isDatePickerOpen = false;
                    
                    // Actualizar calendario personalizado
                    if(document.getElementById('status-text')) document.getElementById('status-text').innerText = "¡Listo!";
                } else {
                    selectedDates.checkin = dates[0] || null;
                    selectedDates.checkout = null;
                    document.getElementById('checkout-input').value = "";
                    document.getElementById('price-breakdown').classList.add('hidden');
                    
                    // Actualizar texto estado
                    if(document.getElementById('status-text')) document.getElementById('status-text').innerText = selectedDates.checkin ? "Seleccione su salida" : "Seleccione su llegada";
                }
                // Siempre renderizar el calendario para mostrar selección
                if (typeof renderCustomCalendar === 'function') {
                    renderCustomCalendar(currMonth, currYear);
                }
            }
        });

        // Evento para prevenir que el usuario salga mientras selecciona fechas
        window.addEventListener('beforeunload', function(e) {
            if (isDatePickerOpen) {
                e.preventDefault();
                e.returnValue = '¿Estás seguro de que quieres salir? Los cambios que hayas hecho podrían no guardarse.';
                return '¿Estás seguro de que quieres salir? Los cambios que hayas hecho podrían no guardarse.';
            }
        });

        document.getElementById('checkout-container').addEventListener('click', () => fp.open());

        // Manejo de desplegable de huéspedes
        const guestTrigger = document.getElementById('guest-selector-trigger');
        const guestDropdown = document.getElementById('guest-dropdown');

        guestTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            guestDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!guestDropdown.contains(e.target) && e.target !== guestTrigger) {
                guestDropdown.classList.add('hidden');
            }
        });

        function updateGuest(type, change) {
            const newValue = guests[type] + change;

            if (type === 'adults') {
                if (newValue >= 1 && (newValue + guests.children) <= maxCapacity) {
                    guests.adults = newValue;
                }
            } else if (type === 'children') {
                if (newValue >= 0 && (guests.adults + newValue) <= maxCapacity) {
                    guests.children = newValue;
                }
            } else if (type === 'infants') {
                if (newValue >= 0 && newValue <= 5) {
                    guests.infants = newValue;
                }
            }
            updateGuestUI();
        }

        function toggleGuideDog(checked) {
            guests.guideDog = checked;
            updateGuestUI();
        }

        function updateGuestUI() {
            const lang = localStorage.getItem('preferredLang') || 'es';
            document.getElementById('count-adults').textContent = guests.adults;
            document.getElementById('count-children').textContent = guests.children;
            document.getElementById('count-infants').textContent = guests.infants;

            let totalGuests = guests.adults + guests.children;
            let guestText = totalGuests > 1 ?
                (translations[lang] && translations[lang]['Huéspedes'] || 'Huéspedes') :
                (translations[lang] && translations[lang]['Huésped'] || 'Huésped');

            let summary = `${totalGuests} ${guestText}`;

            if (guests.infants > 0) {
                let infantText = guests.infants > 1 ?
                    (translations[lang] && translations[lang]['Bebés'] || 'Bebés') :
                    (translations[lang] && translations[lang]['Bebé'] || 'Bebé');
                summary += `, ${guests.infants} ${infantText}`;
            }
            if (guests.guideDog) {
                let guideDogText = (translations[lang] && translations[lang]['Perro de guía'] || 'Perro de guía');
                summary += `, ${guideDogText}`;
            }

            document.getElementById('guest-summary').textContent = summary;

            // Estado de botones
            document.getElementById('btn-adults-minus').disabled = guests.adults <= 1;
            document.getElementById('btn-children-minus').disabled = guests.children <= 0;
            document.getElementById('btn-infants-minus').disabled = guests.infants <= 0;

            const atMax = (guests.adults + guests.children) >= maxCapacity;
            document.getElementById('btn-adults-plus').disabled = atMax;
            document.getElementById('btn-children-plus').disabled = atMax;
            document.getElementById('btn-infants-plus').disabled = guests.infants >= 5;
        }

        function calculatePrice() {
            if (!selectedDates.checkin || !selectedDates.checkout) return;

            const timeDiff = Math.abs(selectedDates.checkout.getTime() - selectedDates.checkin.getTime());
            const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));

            if (nights > 0) {
                const subtotal = basePrice * nights;
                const total = subtotal + cleaningFee;

                document.getElementById('base-price-display').textContent = basePrice.toLocaleString('es-CO');
                document.getElementById('nights-display').textContent = nights;
                document.getElementById('subtotal-display').textContent = subtotal.toLocaleString('es-CO');
                document.getElementById('cleaning-fee-display').textContent = cleaningFee.toLocaleString('es-CO');
                document.getElementById('total-display').textContent = total.toLocaleString('es-CO');

                const nightsText = document.getElementById('nights-text');
                if (nightsText) {
                    nightsText.setAttribute('data-i18n', nights > 1 ? 'noches' : 'noche');
                    const lang = localStorage.getItem('preferredLang') || 'es';
                    if (typeof applyTranslations === 'function') {
                        applyTranslations(lang);
                    }
                }
                document.getElementById('price-breakdown').classList.remove('hidden');
            }
        }

        function goToReservation() {
            if (!selectedDates.checkin || !selectedDates.checkout) {
                const lang = localStorage.getItem('preferredLang') || 'es';
                const alertMsg = (translations[lang] && translations[lang]['Por favor, selecciona las fechas de llegada y salida.']) || 'Por favor, selecciona las fechas de llegada y salida.';
                alert(alertMsg);
                fp.open();
                return;
            }

            const params = new URLSearchParams({
                id: <?php echo $id_apartamento; ?>,
                checkin: fp.formatDate(selectedDates.checkin, "Y-m-d"),
                checkout: fp.formatDate(selectedDates.checkout, "Y-m-d"),
                adults: guests.adults,
                children: guests.children,
                infants: guests.infants,
                guideDog: guests.guideDog
            });

            <?php if ($isEmbed): ?>
                params.set('embed', '1');
            <?php endif; ?>

            window.location.href = 'reservar.php?' + params.toString();
        }

        // --- 4. SISTEMA DE RESEÑAS ---
        function toggleReviews() {
            const extra = document.querySelectorAll('.review-item-extra');
            const btn = document.getElementById('toggle-reviews-btn');
            const lang = localStorage.getItem('preferredLang') || 'es';
            if (!btn) return;

            const isHidden = extra.length > 0 && extra[0].classList.contains('hidden');
            extra.forEach(el => el.classList.toggle('hidden'));

            btn.setAttribute('data-i18n', isHidden ? 'Mostrar menos' : 'Mostrar todas las reseñas');

            if (typeof applyTranslations === 'function') {
                applyTranslations(lang);
            }
        }

        // --- 5. LOGICA CALENDARIO PERSONALIZADO (Integrada) ---
        // Variables globales para el calendario personalizado
        const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        let currDate = new Date();
        let currMonth = currDate.getMonth();
        let currYear = currDate.getFullYear();

        const calendarGrid = document.getElementById('custom-calendar-grid');
        const monthYearLabel = document.getElementById('calendar-month-year');
        const statusText = document.getElementById('status-text');

        function formatDateISO(date) {
            return date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
        }

        function initCustomCalendar() {
            if (!calendarGrid) return;
            renderCustomCalendar(currMonth, currYear);

            // Event Listeners para navegación
            const prevBtn = document.getElementById('prev-month');
            const nextBtn = document.getElementById('next-month');
            const resetBtn = document.getElementById('custom-reset-btn');

            if (prevBtn) prevBtn.addEventListener('click', () => {
                currMonth--;
                if (currMonth < 0) {
                    currMonth = 11;
                    currYear--;
                }
                renderCustomCalendar(currMonth, currYear);
            });

            if (nextBtn) nextBtn.addEventListener('click', () => {
                currMonth++;
                if (currMonth > 11) {
                    currMonth = 0;
                    currYear++;
                }
                renderCustomCalendar(currMonth, currYear);
            });

            if (resetBtn) resetBtn.addEventListener('click', () => {
                // Limpiar Flatpickr también limpiará el calendario personalizado a través de onChange
                fp.clear();
                statusText.innerText = "Seleccione su llegada";
            });
        }

        function renderCustomCalendar(month, year) {
            if (!calendarGrid) return;
            monthYearLabel.innerText = `${monthNames[month]} ${year}`;
            calendarGrid.innerHTML = "";

            const firstDay = new Date(year, month, 1).getDay(); // 0 = Sun
            const adjustedFirstDay = firstDay === 0 ? 7 : firstDay; // 1 = Mon
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            // Rellenar días vacíos
            for (let i = 1; i < adjustedFirstDay; i++) {
                const div = document.createElement('div');
                calendarGrid.appendChild(div);
            }

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            for (let d = 1; d <= daysInMonth; d++) {
                const date = new Date(year, month, d);
                const dateStr = formatDateISO(date);

                // Check past
                const isPast = date < today;

                // Check booked
                let isBooked = false;
                bookedRanges.forEach(range => {
                    if (dateStr >= range.from && dateStr <= range.to) isBooked = true;
                });

                const cellWrapper = document.createElement('div');
                cellWrapper.className = 'relative flex justify-center items-center py-4';

                const cell = document.createElement('div');
                cell.className = 'day-cell z-10 w-12 h-12 flex items-center justify-center rounded-full text-base transition-all';
                cell.innerText = d;

                const rangeBg = document.createElement('div');
                rangeBg.className = 'range-bg absolute inset-0 hidden';

                // Styles
                if (isPast || isBooked) {
                    cell.className += " text-gray-300 cursor-not-allowed line-through";
                } else {
                    cell.className += " text-gray-700 hover:ring-2 hover:ring-black cursor-pointer bg-white";
                    cell.onclick = () => handleCustomDateClick(date);
                }

                // Selection styles from Global State (selectedDates)
                const sCheckin = selectedDates.checkin;
                const sCheckout = selectedDates.checkout;

                // Comparar fechas ignorando hora
                const dateTime = date.getTime();
                const checkinTime = sCheckin ? new Date(sCheckin.getFullYear(), sCheckin.getMonth(), sCheckin.getDate()).getTime() : null;
                const checkoutTime = sCheckout ? new Date(sCheckout.getFullYear(), sCheckout.getMonth(), sCheckout.getDate()).getTime() : null;

                if (checkinTime && dateTime === checkinTime) {
                    cell.classList.add('selected-point');
                }
                if (checkoutTime && dateTime === checkoutTime) {
                    cell.classList.add('selected-point');
                }

                // Range style
                if (checkinTime && checkoutTime) {
                    if (dateTime > checkinTime && dateTime < checkoutTime) {
                        rangeBg.classList.add('range-bg-active');
                    }
                }

                cellWrapper.appendChild(rangeBg);
                cellWrapper.appendChild(cell);
                calendarGrid.appendChild(cellWrapper);
            }
        }

        function handleCustomDateClick(date) {
            // Lógica para actualizar Flatpickr
            // Flatpickr se encargará de validar rangos ocupados a través de su config 'disable'
            
            let newCheckin = selectedDates.checkin;
            let newCheckout = selectedDates.checkout;

            if (!newCheckin || (newCheckin && newCheckout)) {
                // Nueva selección
                newCheckin = date;
                newCheckout = null;
                statusText.innerText = "Seleccione su salida";
                fp.setDate([date], true); // true dispara onChange
            } else if (date > newCheckin) {
                // Completar rango
                // Validar si hay reservas en medio (Flatpickr lo hace, pero validamos aquí para UX inmediata)
                // Simplemente intentamos setear en fp, si falla o recorta, fp se encarga
                fp.setDate([newCheckin, date], true);
                statusText.innerText = "¡Listo!";
            } else {
                // Reiniciar con nueva fecha si es anterior
                newCheckin = date;
                newCheckout = null;
                statusText.innerText = "Seleccione su salida";
                fp.setDate([date], true);
            }
        }

        // Inicializar calendario al cargar
        initCustomCalendar();

        function openReviewModal() {
            const modal = document.getElementById('review-modal');
            if (!modal) return;
            setRating(0);
            const comment = document.getElementById('review-comentario');
            if (comment) comment.value = '';
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }

        function closeReviewModal() {
            const modal = document.getElementById('review-modal');
            if (!modal) return;
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }

        function setRating(rating) {
            const input = document.getElementById('review-calificacion');
            if (input) input.value = rating;
            const starsWrap = document.getElementById('star-rating');
            if (!starsWrap) return;
            const stars = starsWrap.children;
            for (let i = 1; i < stars.length; i++) {
                if (i <= rating) {
                    stars[i].classList.add('text-yellow-400');
                    stars[i].classList.remove('text-slate-300');
                } else {
                    stars[i].classList.remove('text-yellow-400');
                    stars[i].classList.add('text-slate-300');
                }
            }
        }

        function submitReview(e) {
            e.preventDefault();
            const form = document.getElementById('review-form');
            const lang = localStorage.getItem('preferredLang') || 'es';
            if (!form) return;

            const formData = new FormData(form);
            const rating = formData.get('calificacion');

            if (!rating || rating === '0') {
                alert((translations[lang] && translations[lang]['Por favor selecciona una calificación']) || 'Por favor selecciona una calificación');
                return;
            }

            fetch('../dashboard-huesped/guardar_resena_be.php', {
                    method: 'POST',
                    body: formData
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        closeReviewModal();
                        window.location.reload();
                    } else {
                        const errorMsg = (translations[lang] && translations[lang]['Error: No se pudo guardar la reseña']) || 'Error: No se pudo guardar la reseña';
                        alert(errorMsg + (data.message ? ': ' + data.message : ''));
                    }
                })
                .catch(() => {
                    const errorMsg = (translations[lang] && translations[lang]['Ocurrió un error al enviar la reseña']) || 'Ocurrió un error al enviar la reseña';
                    alert(errorMsg);
                });
        }
    </script>

</body>

</html>