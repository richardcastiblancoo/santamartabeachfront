<?php
session_start();
include '../../auth/conexion_be.php';

$isEmbed = isset($_GET['embed']) && $_GET['embed'] === '1';

// Obtener el ID del apartamento de la URL
$id_apartamento = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consultar la base de datos con promedio de calificaciones
$sql = "SELECT a.*, 
        COALESCE(AVG(r.calificacion), 0) as promedio_calificacion, 
        COUNT(r.id) as total_resenas 
        FROM apartamentos a 
        LEFT JOIN resenas r ON a.id = r.apartamento_id 
        WHERE a.id = $id_apartamento 
        GROUP BY a.id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $apartamento = $result->fetch_assoc();
} else {
    // Redirigir o mostrar mensaje si no se encuentra
    $apartamento = null;
}

$resenas = [];
$resenas_total = 0;
$resenas_fecha_col = null;

$fechaColResult = $conn->query("SHOW COLUMNS FROM resenas LIKE 'fecha_creacion'");
if ($fechaColResult && $fechaColResult->num_rows > 0) {
    $resenas_fecha_col = 'fecha_creacion';
} else {
    $fechaColResult2 = $conn->query("SHOW COLUMNS FROM resenas LIKE 'created_at'");
    if ($fechaColResult2 && $fechaColResult2->num_rows > 0) {
        $resenas_fecha_col = 'created_at';
    }
}

if ($id_apartamento > 0) {
    $orderBy = $resenas_fecha_col ? "r.$resenas_fecha_col DESC" : "r.id DESC";
    $sql_resenas = "SELECT r.*, u.nombre, u.apellido, u.imagen
                    FROM resenas r
                    LEFT JOIN usuarios u ON r.usuario_id = u.id
                    WHERE r.apartamento_id = $id_apartamento
                    ORDER BY $orderBy";
    $result_resenas = $conn->query($sql_resenas);
    if ($result_resenas && $result_resenas->num_rows > 0) {
        while ($row = $result_resenas->fetch_assoc()) {
            $resenas[] = $row;
        }
    }
    $resenas_total = count($resenas);
}

$puede_resenar = false;
if (isset($_SESSION['id']) && $id_apartamento > 0) {
    $usuario_id = (int)$_SESSION['id'];
    $fecha_actual = date('Y-m-d');
    $sql_puede = "SELECT COUNT(*) as c FROM reservas
                  WHERE usuario_id = $usuario_id
                  AND apartamento_id = $id_apartamento
                  AND fecha_fin < '$fecha_actual'";
    $res_puede = $conn->query($sql_puede);
    if ($res_puede) {
        $puede_resenar = ((int)$res_puede->fetch_assoc()['c']) > 0;
    }
}

$rangos_ocupados = [];
if ($id_apartamento > 0) {
    $sql_rangos = "SELECT fecha_checkin, fecha_checkout FROM reservas WHERE apartamento_id = $id_apartamento AND estado <> 'cancelada' AND fecha_checkout > CURDATE()";
    $res_rangos = $conn->query($sql_rangos);
    if ($res_rangos && $res_rangos->num_rows > 0) {
        while ($row = $res_rangos->fetch_assoc()) {
            $from = $row['fecha_inicio'] ?? null;
            $to = $row['fecha_fin'] ?? null;
            if (!$from || !$to) continue;
            try {
                $toMinus = (new DateTime($to))->modify('-1 day')->format('Y-m-d');
            } catch (Exception $e) {
                continue;
            }
            if ($toMinus >= $from) {
                $rangos_ocupados[] = ['from' => $from, 'to' => $toMinus];
            }
        }
    }
}

// Consultar galería de imágenes
$sql_imagenes = "SELECT * FROM galeria_apartamentos WHERE apartamento_id = $id_apartamento AND tipo = 'imagen'";
$result_imagenes = $conn->query($sql_imagenes);
$imagenes_galeria = [];
if ($result_imagenes && $result_imagenes->num_rows > 0) {
    while ($row = $result_imagenes->fetch_assoc()) {
        $imagenes_galeria[] = $row['ruta'];
    }
}

// Consultar galería de videos
$sql_videos = "SELECT * FROM galeria_apartamentos WHERE apartamento_id = $id_apartamento AND tipo = 'video'";
$result_videos = $conn->query($sql_videos);
$videos_galeria = [];
if ($result_videos && $result_videos->num_rows > 0) {
    while ($row = $result_videos->fetch_assoc()) {
        $videos_galeria[] = $row['ruta'];
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
    <link rel="shortcut icon" href="/public/img/logo-definitivo.webp" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="shortcut icon" href="/public/img/logo-def-Photoroom.png" type="image/x-icon">
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
    <script>
        const translations = {
            es: {
                "Santamartabeachfront": "Santamartabeachfront",
                "Iniciar sesión": "Iniciar sesión",
                "Registrarse": "Registrarse",
                "Menú": "Menú",
                "Idioma": "Idioma",
                "Español": "Español",
                "English": "English",
                "Compartir": "Compartir",
                "Sin reseñas": "Sin reseñas",
                "reseñas": "reseñas",
                "Descripción": "Descripción",
                "Servicios": "Servicios",
                "Disponibilidad": "Disponibilidad",
                "Reseñas": "Reseñas",
                "Precio por noche": "Precio por noche",
                "Reservar ahora": "Reservar ahora",
                "Selecciona fechas": "Selecciona fechas",
                "Fecha de llegada": "Fecha de llegada",
                "Fecha de salida": "Fecha de salida",
                "Número de huéspedes": "Número de huéspedes",
                "Adultos": "Adultos",
                "Niños": "Niños",
                "Bebés": "Bebés",
                "Total": "Total",
                "Impuestos": "Impuestos",
                "Tarifa de servicio": "Tarifa de servicio",
                "Noches": "Noches",
                "No hay reseñas aún.": "No hay reseñas aún.",
                "Escribe una reseña": "Escribe una reseña",
                "Tu calificación": "Tu calificación",
                "Tu reseña": "Tu reseña",
                "Enviar reseña": "Enviar reseña",
                "Califica tu experiencia": "Califica tu experiencia",
                "Escribe tu comentario": "Escribe tu comentario",
                "No se encontraron apartamentos.": "No se encontraron apartamentos.",
                "No se encontraron videos.": "No se encontraron videos.",
                "No se encontraron imágenes.": "No se encontraron imágenes.",
                "No se encontraron servicios.": "No se encontraron servicios.",
                "No se encontraron reseñas.": "No se encontraron reseñas.",
                "No se encontraron rangos ocupados.": "No se encontraron rangos ocupados.",
                "No se encontraron galerías.": "No se encontraron galerías.",
                "No se encontraron datos del apartamento.": "No se encontraron datos del apartamento.",
                "No se encontraron datos de la reserva.": "No se encontraron datos de la reserva.",
                "No se encontraron datos del usuario.": "No se encontraron datos del usuario.",
                "No se encontraron datos de la conexión.": "No se encontraron datos de la conexión.",
                "No se encontraron datos de la sesión.": "No se encontraron datos de la sesión.",
                "No se encontraron datos de la URL.": "No se encontraron datos de la URL.",
                "No se encontraron datos de la base de datos.": "No se encontraron datos de la base de datos.",
                "No se encontraron datos de la consulta.": "No se encontraron datos de la consulta.",
                "No se encontraron datos del resultado.": "No se encontraron datos del resultado.",
                "No se encontraron datos de la fila.": "No se encontraron datos de la fila.",
                "No se encontraron datos de la columna.": "No se encontraron datos de la columna.",
                "No se encontraron datos de la fecha.": "No se encontraron datos de la fecha.",
                "No se encontraron datos del ID.": "No se encontraron datos del ID.",
                "No se encontraron datos del tipo.": "No se encontraron datos del tipo.",
                "No se encontraron datos de la ruta.": "No se encontraron datos de la ruta.",
                "No se encontraron datos del estado.": "No se encontraron datos del estado.",
                "No se encontraron datos del promedio.": "No se encontraron datos del promedio.",
                "No se encontraron datos del total.": "No se encontraron datos del total.",
                "No se encontraron datos del nombre.": "No se encontraron datos del nombre.",
                "No se encontraron datos del apellido.": "No se encontraron datos del apellido.",
                "No se encontraron datos de la imagen.": "No se encontraron datos de la imagen.",
                "No se encontraron datos de la calificación.": "No se encontraron datos de la calificación.",
                "No se encontraron datos del comentario.": "No se encontraron datos del comentario.",
                "No se encontraron datos del usuario.": "No se encontraron datos del usuario.",
                "No se encontraron datos del apartamento.": "No se encontraron datos del apartamento.",
                "No se encontraron datos de la reserva.": "No se encontraron datos de la reserva.",
                "No se encontraron datos de la fecha de inicio.": "No se encontraron datos de la fecha de inicio.",
                "No se encontraron datos de la fecha de fin.": "No se encontraron datos de la fecha de fin.",
                "No se encontraron datos del estado.": "No se encontraron datos del estado.",
                "No se encontraron datos de la fecha actual.": "No se encontraron datos de la fecha actual.",
                "No se encontraron datos del conteo.": "No se encontraron datos del conteo.",
                "No se encontraron datos del resultado de la consulta.": "No se encontraron datos del resultado de la consulta.",
                "No se encontraron datos del resultado de la fila.": "No se encontraron datos del resultado de la fila.",
                "No se encontraron datos del resultado de la columna.": "No se encontraron datos del resultado de la columna.",
                "No se encontraron datos del resultado de la fecha.": "No se encontraron datos del resultado de la fecha.",
                "No se encontraron datos del resultado del ID.": "No se encontraron datos del resultado del ID.",
                "No se encontraron datos del resultado del tipo.": "No se encontraron datos del resultado del tipo.",
                "No se encontraron datos del resultado de la ruta.": "No se encontraron datos del resultado de la ruta.",
                "No se encontraron datos del resultado del estado.": "No se encontraron datos del resultado del estado.",
                "No se encontraron datos del resultado del promedio.": "No se encontraron datos del resultado del promedio.",
                "No se encontraron datos del resultado del total.": "No se encontraron datos del resultado del total.",
                "No se encontraron datos del resultado del nombre.": "No se encontraron datos del resultado del nombre.",
                "No se encontraron datos del resultado del apellido.": "No se encontraron datos del resultado del apellido.",
                "No se encontraron datos del resultado de la imagen.": "No se encontraron datos del resultado de la imagen.",
                "No se encontraron datos del resultado de la calificación.": "No se encontraron datos del resultado de la calificación.",
                "No se encontraron datos del resultado del comentario.": "No se encontraron datos del resultado del comentario.",
                "No se encontraron datos del resultado del usuario.": "No se encontraron datos del resultado del usuario.",
                "No se encontraron datos del resultado del apartamento.": "No se encontraron datos del resultado del apartamento.",
                "No se encontraron datos del resultado de la reserva.": "No se encontraron datos del resultado de la reserva.",
                "No se encontraron datos del resultado de la fecha de inicio.": "No se encontraron datos del resultado de la fecha de inicio.",
                "No se encontraron datos del resultado de la fecha de fin.": "No se encontraron datos del resultado de la fecha de fin.",
                "No se encontraron datos del resultado del estado.": "No se encontraron datos del resultado del estado.",
                "No se encontraron datos del resultado de la fecha actual.": "No se encontraron datos del resultado de la fecha actual.",
                "No se encontraron datos del resultado del conteo.": "No se encontraron datos del resultado del conteo."
            },
            en: {
                "Santamartabeachfront": "Santamartabeachfront",
                "Iniciar sesión": "Login",
                "Registrarse": "Register",
                "Menú": "Menu",
                "Idioma": "Language",
                "Español": "Spanish",
                "English": "English",
                "Compartir": "Share",
                "Sin reseñas": "No reviews",
                "reseñas": "reviews",
                "Descripción": "Description",
                "Servicios": "Amenities",
                "Disponibilidad": "Availability",
                "Reseñas": "Reviews",
                "Precio por noche": "Price per night",
                "Reservar ahora": "Book now",
                "Selecciona fechas": "Select dates",
                "Fecha de llegada": "Check-in date",
                "Fecha de salida": "Check-out date",
                "Número de huéspedes": "Number of guests",
                "Adultos": "Adults",
                "Niños": "Children",
                "Bebés": "Infants",
                "Total": "Total",
                "Impuestos": "Taxes",
                "Tarifa de servicio": "Service fee",
                "Noches": "Nights",
                "No hay reseñas aún.": "No reviews yet.",
                "Escribe una reseña": "Write a review",
                "Tu calificación": "Your rating",
                "Tu reseña": "Your review",
                "Enviar reseña": "Submit review",
                "Califica tu experiencia": "Rate your experience",
                "Escribe tu comentario": "Write your comment",
                "No se encontraron apartamentos.": "No apartments found.",
                "No se encontraron videos.": "No videos found.",
                "No se encontraron imágenes.": "No images found.",
                "No se encontraron servicios.": "No amenities found.",
                "No se encontraron reseñas.": "No reviews found.",
                "No se encontraron rangos ocupados.": "No occupied ranges found.",
                "No se encontraron galerías.": "No galleries found.",
                "No se encontraron datos del apartamento.": "No apartment data found.",
                "No se encontraron datos de la reserva.": "No booking data found.",
                "No se encontraron datos del usuario.": "No user data found.",
                "No se encontraron datos de la conexión.": "No connection data found.",
                "No se encontraron datos de la sesión.": "No session data found.",
                "No se encontraron datos de la URL.": "No URL data found.",
                "No se encontraron datos de la base de datos.": "No database data found.",
                "No se encontraron datos de la consulta.": "No query data found.",
                "No se encontraron datos del resultado.": "No result data found.",
                "No se encontraron datos de la fila.": "No row data found.",
                "No se encontraron datos de la columna.": "No column data found.",
                "No se encontraron datos de la fecha.": "No date data found.",
                "No se encontraron datos del ID.": "No ID data found.",
                "No se encontraron datos del tipo.": "No type data found.",
                "No se encontraron datos de la ruta.": "No path data found.",
                "No se encontraron datos del estado.": "No status data found.",
                "No se encontraron datos del promedio.": "No average data found.",
                "No se encontraron datos del total.": "No total data found.",
                "No se encontraron datos del nombre.": "No name data found.",
                "No se encontraron datos del apellido.": "No last name data found.",
                "No se encontraron datos de la imagen.": "No image data found.",
                "No se encontraron datos de la calificación.": "No rating data found.",
                "No se encontraron datos del comentario.": "No comment data found.",
                "No se encontraron datos del usuario.": "No user data found.",
                "No se encontraron datos del apartamento.": "No apartment data found.",
                "No se encontraron datos de la reserva.": "No booking data found.",
                "No se encontraron datos de la fecha de inicio.": "No start date data found.",
                "No se encontraron datos de la fecha de fin.": "No end date data found.",
                "No se encontraron datos del estado.": "No status data found.",
                "No se encontraron datos de la fecha actual.": "No current date data found.",
                "No se encontraron datos del conteo.": "No count data found.",
                "No se encontraron datos del resultado de la consulta.": "No query result data found.",
                "No se encontraron datos del resultado de la fila.": "No row result data found.",
                "No se encontraron datos del resultado de la columna.": "No column result data found.",
                "No se encontraron datos del resultado de la fecha.": "No date result data found.",
                "No se encontraron datos del resultado del ID.": "No ID result data found.",
                "No se encontraron datos del resultado del tipo.": "No type result data found.",
                "No se encontraron datos del resultado de la ruta.": "No path result data found.",
                "No se encontraron datos del resultado del estado.": "No status result data found.",
                "No se encontraron datos del resultado del promedio.": "No average result data found.",
                "No se encontraron datos del resultado del total.": "No total result data found.",
                "No se encontraron datos del resultado del nombre.": "No name result data found.",
                "No se encontraron datos del resultado del apellido.": "No last name result data found.",
                "No se encontraron datos del resultado de la imagen.": "No image result data found.",
                "No se encontraron datos del resultado de la calificación.": "No rating result data found.",
                "No se encontraron datos del resultado del comentario.": "No comment result data found.",
                "No se encontraron datos del resultado del usuario.": "No user result data found.",
                "No se encontraron datos del resultado del apartamento.": "No apartment result data found.",
                "No se encontraron datos del resultado de la reserva.": "No booking result data found.",
                "No se encontraron datos del resultado de la fecha de inicio.": "No start date result data found.",
                "No se encontraron datos del resultado de la fecha de fin.": "No end date result data found.",
                "No se encontraron datos del resultado del estado.": "No status result data found.",
                "No se encontraron datos del resultado de la fecha actual.": "No current date result data found.",
                "No se encontraron datos del resultado del conteo.": "No count result data found."
            }
        };
    </script>
    <style type="text/tailwindcss">
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        
        /* Custom Flatpickr Theme */
        .flatpickr-calendar {
            background-color: #1e293b !important; /* dark:bg-slate-800 equivalent */
            border-radius: 1rem !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5), 0 8px 10px -6px rgba(0, 0, 0, 0.5) !important;
            border: 1px solid #334155 !important; /* dark:border-slate-700 */
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
        .flatpickr-day {
            color: #f8fafc !important; /* text-slate-50 */
        }
        .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange, .flatpickr-day.selected.inRange, .flatpickr-day.startRange.inRange, .flatpickr-day.endRange.inRange, .flatpickr-day.focus, .flatpickr-day:hover, .flatpickr-day.prevMonthDay:hover, .flatpickr-day.nextMonthDay:hover, .flatpickr-day:focus, .flatpickr-day.prevMonthDay:focus, .flatpickr-day.nextMonthDay:focus {
            background: #13a4ec !important;
            border-color: #13a4ec !important;
            color: white !important;
        }
        .flatpickr-day.inRange {
            box-shadow: -5px 0 0 #0c4a6e, 5px 0 0 #0c4a6e !important;
            background: #0c4a6e !important;
            border-color: #0c4a6e !important;
            color: #e0f2fe !important;
        }
        .flatpickr-months .flatpickr-month {
            background: transparent !important;
            color: #f8fafc !important;
            fill: #f8fafc !important;
        }
        .flatpickr-current-month .flatpickr-monthDropdown-months {
            font-weight: 700 !important;
            color: #f8fafc !important;
        }
        .flatpickr-current-month input.cur-year {
            color: #f8fafc !important;
        }
        .flatpickr-weekday {
            font-weight: 600 !important;
            color: #94a3b8 !important; /* text-slate-400 */
        }
        .flatpickr-calendar.arrowTop:before, .flatpickr-calendar.arrowTop:after {
            border-bottom-color: #1e293b !important;
        }
        /* --- LOGO 150PX Y TEXTO PEGADO --- */
        .logo-container img {
            height: 140px;
            width: auto;
            object-fit: contain;
            transform: translateY(20px);
        }

        .brand-text {
            margin-left: -40px;
            margin-top: 10px;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#111618] dark:text-white transition-colors duration-300">
    <?php if (!$isEmbed): ?>

        <header class="sticky top-0 z-50 w-full bg-white dark:bg-background-dark border-b border-solid border-[#f0f3f4] dark:border-slate-800 px-4 md:px-10 lg:px-40 py-3">
            <div class="flex items-center justify-between max-w-[1280px] mx-auto">
                <div class="flex items-center h-full">
                    <a href="/" class="flex items-center group logo-container">
                        <img src="/public/img/logo-definitivo.webp" alt="Logo" class="h-8 w-auto">
                        <h1 class="brand-text text-white text-base md:text-lg font-black tracking-tighter uppercase hidden md:inline-block ml-2" data-i18n="Santamartabeachfront">
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
                            <button onclick="selectLang('ES', 'https://flagcdn.com/co.svg')" class="w-full flex items-center gap-3 px-4 py-3 text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                <img src="https://flagcdn.com/co.svg" class="w-5 h-5 rounded-full object-cover" alt="ES">
                                <span class="font-medium text-slate-700 dark:text-slate-200" data-i18n="Español">Español</span>
                            </button>
                            <button onclick="selectLang('EN', 'https://flagcdn.com/us.svg')" class="w-full flex items-center gap-3 px-4 py-3 text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                <img src="https://flagcdn.com/us.svg" class="w-5 h-5 rounded-full object-cover" alt="EN">
                                <span class="font-medium text-slate-700 dark:text-slate-200" data-i18n="English">English</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="/auth/login.php" class="px-4 py-2 text-sm font-bold hover:text-primary transition-colors" data-i18n="Iniciar sesión">Iniciar sesión</a>
                        <a href="/auth/registro.php" class="px-5 py-2 rounded-lg bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-all shadow-sm" data-i18n="Registrarse">Registrarse</a>
                    </div>
                </div>

                <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-slate-600 dark:text-slate-300">
                    <span class="material-symbols-outlined text-3xl" id="menu-icon">menu</span>
                </button>
            </div>

            <div id="mobile-menu" class="fixed inset-0 bg-white dark:bg-background-dark z-[60] flex flex-col p-6 translate-x-full transition-transform duration-300 ease-in-out md:hidden">
                <div class="flex justify-between items-center mb-10">
                    <span class="font-bold text-xl uppercase tracking-tighter" data-i18n="Menú">Menú</span>
                    <button onclick="toggleMobileMenu()" class="p-2">
                        <span class="material-symbols-outlined text-3xl">close</span>
                    </button>
                </div>

                <nav class="flex flex-col gap-6">
                    <div class="border-b border-slate-100 dark:border-slate-800">
                        <button onclick="toggleLangMobile()" class="w-full flex items-center justify-between py-4">
                            <span class="font-medium" data-i18n="Idioma">Idioma</span>
                            <span class="font-bold text-primary flex items-center gap-2">
                                <img id="mobile-current-flag" src="https://flagcdn.com/co.svg" class="w-5 h-5 rounded-full object-cover" alt="CO">
                                <span id="mobile-current-text">ES</span>
                                <span class="material-symbols-outlined">expand_more</span>
                            </span>
                        </button>
                        <div id="mobile-lang-options" class="hidden flex flex-col pb-4 pl-4 gap-5">
                            <button onclick="selectLang('ES', 'https://flagcdn.com/co.svg')" class="flex items-center gap-3 text-lg font-medium text-slate-700 dark:text-slate-200">
                                <img src="https://flagcdn.com/co.svg" class="w-6 h-6 rounded-full object-cover" alt="ES"> <span data-i18n="Español">Español</span>
                            </button>
                            <button onclick="selectLang('EN', 'https://flagcdn.com/us.svg')" class="flex items-center gap-3 text-lg font-medium text-slate-700 dark:text-slate-200">
                                <img src="https://flagcdn.com/us.svg" class="w-6 h-6 rounded-full object-cover" alt="EN"> <span data-i18n="English">English</span>
                            </button>
                        </div>
                    </div>

                    <a href="/auth/login.php" class="text-2xl font-bold py-2" data-i18n="Iniciar sesión">Iniciar sesión</a>
                    <a href="/auth/registro.php" class="text-2xl font-bold py-2 text-primary" data-i18n="Registrarse">Registrarse</a>
                </nav>
            </div>
        </header>



        <script>
            //idioma
            function applyTranslations(lang) {
                document.querySelectorAll('[data-i18n]').forEach(element => {
                    const key = element.getAttribute('data-i18n');
                    if (translations[lang] && translations[lang][key]) {
                        element.innerText = translations[lang][key];
                    }
                });
            }

            // Función para el menú principal móvil (la que ya tenías)
            function toggleMobileMenu() {
                const menu = document.getElementById('mobile-menu');
                const isHidden = menu.classList.contains('translate-x-full');
                if (isHidden) {
                    menu.classList.remove('translate-x-full');
                    document.body.style.overflow = 'hidden';
                } else {
                    menu.classList.add('translate-x-full');
                    document.body.style.overflow = 'auto';
                }
            }

            function toggleLangDesktop() {
                const dropdown = document.getElementById('lang-dropdown');
                dropdown.classList.toggle('hidden');

                // Cerrar si hacen clic fuera del menú
                const closeDropdown = (e) => {
                    if (!e.target.closest('.relative')) {
                        dropdown.classList.add('hidden');
                        window.removeEventListener('click', closeDropdown);
                    }
                };
                setTimeout(() => window.addEventListener('click', closeDropdown), 10);
            }

            function toggleLangMobile() {
                const options = document.getElementById('mobile-lang-options');
                options.classList.toggle('hidden');
            }

            function selectLang(lang, flagUrl) {
                // Actualizar UI Escritorio
                document.getElementById('current-lang-text').innerText = lang;
                document.getElementById('current-lang-flag').src = flagUrl;

                // Actualizar UI Móvil
                document.getElementById('mobile-current-text').innerText = lang;
                document.getElementById('mobile-current-flag').src = flagUrl;

                // Cerrar menús
                document.getElementById('lang-dropdown').classList.add('hidden');
                if (window.innerWidth < 768) {
                    // Opcional: cerrar el menú móvil completo tras elegir idioma
                    // toggleMobileMenu();
                }

                console.log("Idioma seleccionado: " + lang);
                applyTranslations(lang.toLowerCase()); // Apply translations
            }

            // Apply translations on page load
            document.addEventListener('DOMContentLoaded', () => {
                applyTranslations('es'); // Default language
            });
        </script>

    <?php endif; ?>
    <main class="max-w-[1280px] mx-auto px-4 md:px-10 lg:px-40 py-6">
        <?php if ($apartamento): ?>
            <div class="flex flex-wrap justify-between items-end gap-4 py-4">
                <div class="flex flex-col gap-2">
                    <h1 class="text-[#111618] dark:text-white text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]"><?php echo $apartamento['titulo']; ?></h1>
                    <div class="flex items-center gap-2 text-[#617c89] dark:text-slate-400">
                        <span class="material-symbols-outlined text-sm">location_on</span>
                        <p class="text-base font-normal"><?php echo $apartamento['ubicacion']; ?> · ★ <?php echo $apartamento['total_resenas'] > 0 ? number_format($apartamento['promedio_calificacion'], 1) : '0 (Sin reseñas)'; ?> (<?php echo $apartamento['total_resenas']; ?> reseñas)</p>
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

            <div class="grid grid-cols-1 md:grid-cols-4 grid-rows-2 gap-3 h-[400px] md:h-[550px] mt-4 rounded-2xl overflow-hidden relative">
                <div class="md:col-span-2 md:row-span-2 relative group overflow-hidden" onclick="openGallery()">
                    <div class="w-full h-full bg-center bg-no-repeat bg-cover transition-transform duration-700 group-hover:scale-105 cursor-pointer" data-alt="<?php echo $apartamento['titulo']; ?>" style='background-image: url("<?php echo $ruta_img; ?>");'></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black/20 cursor-pointer">
                        <div class="w-16 h-16 rounded-full bg-white/30 backdrop-blur-md flex items-center justify-center border border-white/50">
                            <span class="material-symbols-outlined text-white text-4xl">fullscreen</span>
                        </div>
                    </div>
                </div>

                <?php
                // Lógica para mostrar las siguientes 4 imágenes o videos
                // Combinamos imágenes y videos para llenar la cuadrícula
                $media_items = [];
                foreach ($imagenes_galeria as $img) {
                    $media_items[] = ['type' => 'image', 'src' => '/assets/img/apartamentos/' . $img];
                }
                foreach ($videos_galeria as $vid) {
                    $media_items[] = ['type' => 'video', 'src' => '/assets/video/apartamentos/' . $vid];
                }

                // Si no hay suficientes items, rellenamos con la principal (o dejamos vacío si prefieres, pero el diseño original tenía 5 slots)
                // Aquí mostraremos hasta 4 items adicionales.
                for ($i = 0; $i < 4; $i++):
                    if (isset($media_items[$i])):
                        $item = $media_items[$i];
                ?>
                        <div class="hidden md:block relative group overflow-hidden cursor-pointer" onclick="openGallery()">
                            <?php if ($item['type'] == 'image'): ?>
                                <div class="w-full h-full bg-center bg-no-repeat bg-cover transition-transform duration-500 group-hover:scale-105" style='background-image: url("<?php echo $item['src']; ?>");'></div>
                            <?php else: ?>
                                <div class="w-full h-full bg-black relative">
                                    <video src="<?php echo $item['src']; ?>" class="w-full h-full object-cover opacity-80"></video>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-white text-3xl drop-shadow-lg">play_circle</span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($i == 3): // Botón en el último elemento 
                                $total_fotos = count($imagenes_galeria) + ($apartamento['imagen_principal'] ? 1 : 0);
                                $total_videos = count($videos_galeria);
                            ?>
                                <div class="absolute bottom-4 right-4 flex flex-col gap-2 z-10">
                                    <button onclick="openGallery()" class="bg-[#111618] px-4 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 border border-[#111618] text-white shadow-xl hover:bg-black/90 transition-all transform active:scale-95">
                                        <span class="material-symbols-outlined text-[18px]">photo_library</span> <span data-i18n="Fotos"><?php echo $total_fotos; ?> Fotos</span>
                                    </button>
                                    <?php if ($total_videos > 0): ?>
                                        <button onclick="openGallery()" class="bg-[#111618] px-4 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 border border-[#111618] text-white shadow-xl hover:bg-black/90 transition-all transform active:scale-95">
                                            <span class="material-symbols-outlined text-[18px]">play_circle</span> <span data-i18n="Videos"><?php echo $total_videos; ?> Videos</span>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <!-- Placeholder si no hay imagen (o repetir la principal difuminada) -->
                        <div class="hidden md:block relative group overflow-hidden bg-gray-100 dark:bg-slate-800">
                            <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-slate-700">
                                <span class="material-symbols-outlined text-4xl">image</span>
                            </div>
                            <?php if ($i == 3):
                                $total_fotos = count($imagenes_galeria) + ($apartamento['imagen_principal'] ? 1 : 0);
                                $total_videos = count($videos_galeria);
                            ?>
                                <div class="absolute bottom-4 right-4 flex flex-col gap-2 z-10">
                                    <button onclick="openGallery()" class="bg-[#111618] px-4 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 border border-[#111618] text-white shadow-xl hover:bg-black/90 transition-all transform active:scale-95">
                                        <span class="material-symbols-outlined text-[18px]">photo_library</span> <?php echo $total_fotos; ?> Fotos
                                    </button>
                                    <?php if ($total_videos > 0): ?>
                                        <button onclick="openGallery()" class="bg-[#111618] px-4 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 border border-[#111618] text-white shadow-xl hover:bg-black/90 transition-all transform active:scale-95">
                                            <span class="material-symbols-outlined text-[18px]">play_circle</span> <?php echo $total_videos; ?> Videos
                                        </button>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                <?php
                    endif;
                endfor;
                ?>
            </div>


            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 py-10">
                <div class="lg:col-span-2">
                    <div class="border-b border-slate-200 dark:border-slate-800 pb-6 mb-8">
                        <h2 class="text-2xl font-bold mb-2" data-i18n="Alojamiento Completo">Alojamiento Completo: <?php echo $apartamento['titulo']; ?></h2>
                        <p class="text-[#617c89] dark:text-slate-400"><?php echo $apartamento['capacidad']; ?> <span data-i18n="Huéspedes">Huéspedes</span> · <?php echo $apartamento['habitaciones']; ?> <span data-i18n="Dormitorios">habitaciónes</span> · <?php echo $apartamento['banos']; ?> <span data-i18n="Baños">Baños</span></p>
                    </div>
                    <section class="mb-10">
                        <h3 class="text-xl font-bold mb-4" data-i18n="Sobre este apartamento">Sobre este apartamento</h3>
                        <p class="text-[#4b5563] dark:text-slate-300 leading-relaxed">
                            <?php echo nl2br($apartamento['descripcion']); ?>
                        </p>
                    </section>

                    <section class="mb-10 pt-8 border-t border-slate-200 dark:border-slate-800">
                        <h3 class="text-xl font-bold mb-6" data-i18n="Lo que este lugar ofrece">Lo que este lugar ofrece</h3>
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
                                            <span class="text-base font-medium" data-i18n="<?php echo $servicio; ?>"><?php echo $servicio; ?></span>
                                        </div>
                                    <?php
                                    }

                                    if (count($servicios) > 8) {
                                    ?>
                                        <div class="md:col-span-2 mt-4">
                                            <button id="toggle-services-btn" onclick="toggleServices()" class="border border-slate-900 dark:border-white text-slate-900 dark:text-white px-6 py-2.5 rounded-lg font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-sm tracking-wide" data-i18n="Mostrar más">
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
                    <section class="mb-10 pt-8 border-t border-slate-200 dark:border-slate-800">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="material-symbols-outlined text-primary fill-1">star</span>
                            <h3 class="text-xl font-bold"><?php echo $apartamento['total_resenas'] > 0 ? number_format($apartamento['promedio_calificacion'], 1) . ' · ' . $apartamento['total_resenas'] . ' <span data-i18n="reseñas">reseñas</span>' : '<span data-i18n="Sin reseñas">Sin reseñas</span>'; ?></h3>
                        </div>
                        <?php if ($puede_resenar): ?>
                            <div class="mb-6">
                                <button onclick="openReviewModal()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-[18px]">rate_review</span>
                                    <span data-i18n="Escribir reseña">Escribir reseña</span>
                                </button>
                            </div>
                        <?php endif; ?>

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
                            <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                                <p class="text-sm text-slate-600 dark:text-slate-400" data-i18n="Aún no hay reseñas para este apartamento.">Aún no hay reseñas para este apartamento.</p>
                            </div>
                        <?php endif; ?>
                    </section>
                    <?php if ($puede_resenar): ?>
                        <div class="hidden fixed inset-0 z-50 bg-black/50 items-center justify-center p-4 backdrop-blur-sm" id="review-modal">
                            <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden">
                                <form id="review-form" onsubmit="submitReview(event)">
                                    <input type="hidden" name="apartamento_id" value="<?php echo (int)$id_apartamento; ?>">
                                    <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
                                        <h3 class="text-xl font-bold text-[#111618] dark:text-white flex items-center gap-2" data-i18n="Escribir Reseña">
                                            <span class="material-symbols-outlined text-primary">rate_review</span>
                                            Escribir Reseña
                                        </h3>
                                        <a class="text-slate-500 hover:text-primary transition-colors cursor-pointer" onclick="closeReviewModal()">
                                            <span class="material-symbols-outlined">close</span>
                                        </a>
                                    </div>
                                    <div class="p-8 space-y-6">
                                        <div class="flex justify-center gap-2" id="star-rating">
                                            <input type="hidden" name="calificacion" id="review-calificacion" required>
                                            <button type="button" class="material-symbols-outlined text-4xl text-slate-300 hover:text-yellow-400 transition-colors" onclick="setRating(1)">star</button>
                                            <button type="button" class="material-symbols-outlined text-4xl text-slate-300 hover:text-yellow-400 transition-colors" onclick="setRating(2)">star</button>
                                            <button type="button" class="material-symbols-outlined text-4xl text-slate-300 hover:text-yellow-400 transition-colors" onclick="setRating(3)">star</button>
                                            <button type="button" class="material-symbols-outlined text-4xl text-slate-300 hover:text-yellow-400 transition-colors" onclick="setRating(4)">star</button>
                                            <button type="button" class="material-symbols-outlined text-4xl text-slate-300 hover:text-yellow-400 transition-colors" onclick="setRating(5)">star</button>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-bold text-[#111618] dark:text-white mb-2" data-i18n="Comentario">Comentario</label>
                                            <textarea name="comentario" id="review-comentario" rows="4" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary text-[#111618] dark:text-white placeholder:text-slate-400" placeholder="Comparte tu experiencia..." data-i18n-placeholder="Comparte tu experiencia..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="p-6 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-800 flex justify-end gap-3">
                                        <a class="px-6 py-2.5 text-sm font-bold text-slate-500 hover:text-[#111618] dark:hover:text-white transition-colors cursor-pointer" onclick="closeReviewModal()">Cancelar</a>
                                        <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary/90 text-white text-sm font-bold rounded-lg shadow-lg shadow-primary/30 transition-all" data-i18n="Enviar Reseña">Enviar Reseña</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>

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
                                <p class="font-bold text-lg text-slate-900 dark:text-white leading-tight" data-i18n="Pozos Colorados, Santa Marta">Calle 22 # 1 - 67 Playa Salguero, Santa Marta</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1" data-i18n="Reserva del Mar - Torre 4. Un sector exclusivo y tranquilo.">
                                    Apartamento 1730 - Torre 4 - Reserva del Mar 1
                                </p>
                            </div>
                        </div>
                    </section>

                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

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
                            marker.bindPopup("<b style='font-family: sans-serif;'>Reserva del Mar 1</b><br>Torre 4").openPopup();
                        });
                    </script>

                    <style>
                        /* Suavizar los bordes de Leaflet */
                        .leaflet-container {
                            font-family: inherit;
                            background: #f8fafc;
                            /* Color de carga antes del mapa */
                        }

                        /* Pequeño ajuste para que el popup se vea más moderno */
                        .leaflet-popup-content-wrapper {
                            border-radius: 12px;
                            padding: 5px;
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                        }

                        /* Opcional: Si quieres que el mapa sea grisáceo en modo oscuro */
                        .dark .leaflet-tile-container {
                            filter: grayscale(0.5) brightness(0.8);
                        }
                    </style>
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
                                <span class="underline text-[#4b5563] dark:text-slate-300">$<span id="base-price-display">0</span> x <span id="nights-display">0</span> noches</span>
                                <span class="font-medium">$<span id="subtotal-display">0</span></span>
                            </div>
                            <div class="flex justify-between text-base">
                                <span class="underline text-[#4b5563] dark:text-slate-300" data-i18n="Tarifa de limpieza">Tarifa de limpieza</span>
                                <span class="font-medium">$<span id="cleaning-fee-display">0</span></span>
                            </div>
                            <div class="flex justify-between text-base">
                                <span class="underline text-[#4b5563] dark:text-slate-300">Comisión de servicio</span>
                                <span class="font-medium">$<span id="service-fee-display">0</span></span>
                            </div>
                            <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex justify-between items-center font-bold text-lg">
                                <span>Total</span>
                                <span>$<span id="total-display">0</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="text-center py-20">
                <h1 class="text-3xl font-bold mb-4">Apartamento no encontrado</h1>
                <p class="mb-8">El apartamento que buscas no existe o ha sido eliminado.</p>
                <a href="/" class="bg-primary text-white px-6 py-3 rounded-lg font-bold">Volver al inicio</a>
            </div>
        <?php endif; ?>
    </main>



    <?php if ($apartamento): ?>

        <!-- footer -->
        <footer class="bg-[#101c22] text-white pt-10 pb-10 mt-[-2rem]" id="contacto">
            <div class="max-w-7xl mx-auto px-6 md:px-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 lg:gap-24 py-16 items-start border-t border-white/5">
                    <section class="flex flex-col items-center md:items-start text-center md:text-left">
                        <a href="/" class="flex flex-col md:flex-row items-center group w-fit md:-ml-4">
                            <div class="w-[100px] h-[100px] md:w-[130px] md:h-[130px] shrink-0">
                                <img src="/public/img/logo-definitivo.webp" alt="logo" class="w-full h-full object-contain">
                            </div>
                            <span class="text-2xl md:text-3xl font-bold text-white tracking-tighter mt-[-20px] md:mt-0 md:-ml-9 mb-2">
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
                                <li><a href="mailto:17clouds@gmail.com" class="flex items-center justify-center md:justify-start gap-3">
                                        <span class="material-symbols-outlined text-blue-400">mail</span> 17clouds@gmail.com</a></li>
                                <li><a href="https://wa.me/573183813381" class="flex items-center justify-center md:justify-start gap-3">
                                        <span class="material-symbols-outlined text-blue-400">call</span> +57 318 3813381</a></li>
                                <li class="flex items-start justify-center md:justify-start gap-3">
                                    <span class="material-symbols-outlined text-blue-400 shrink-0">location_on</span>
                                    <span>Apartamento 1730 - Torre 4 - Reserva del Mar 1<br> Calle 22 # 1 - 67 Playa Salguero, Santa Marta</span>
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
                        Hecho por <a href="https://richardcastiblanco.vercel.app/" target="_blank" rel="noopener noreferrer" style="text-decoration: none; color: inherit; font-weight: bold;">Richard Castiblanco</a>
                    </p>

                    <nav aria-label="Enlaces legales">
                        <ul class="flex gap-8 list-none p-0">
                            <li><a class="hover:text-white transition-colors" href="/php/politica-terminos/politica-privacidad.php" data-key="foo_privacy">Políticas de Privacidad</a></li>
                            <li><a class="hover:text-white transition-colors" href="/php/politica-terminos/politica-privacidad.php" data-key="foo_terms">Términos y Condiciones</a></li>
                        </ul>
                    </nav>
                </aside>
            </div>
        </footer>

        <div id="gallery-modal" class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-xl hidden flex-col transition-all duration-300">
            <div class="p-4 flex justify-between items-center text-white border-b border-white/10 bg-black/20 sticky top-0 w-full z-20">
                <button onclick="closeGallery()" class="p-2 hover:bg-white/10 rounded-full transition-all group">
                    <span class="material-symbols-outlined group-hover:rotate-90 transition-transform">close</span>
                </button>
                <div class="flex flex-col items-center">
                    <span class="font-bold text-lg tracking-wide">Galería del Apartamento</span>
                    <span class="text-xs text-white/50 uppercase tracking-widest">Explora los espacios</span>
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
                                <p class="text-white text-sm font-light">Vista principal</p>
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
                                <span class="text-[10px] text-white/70 mt-2 font-bold tracking-tighter uppercase">Video Tour</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="py-20 text-center">
                    <p class="text-white/20 text-sm italic">Fin de la galería</p>
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

        <script>
            function shareApartment() {
                if (navigator.share) {
                    navigator.share({
                        title: <?php echo json_encode($apartamento['titulo'] ?? 'Apartamento'); ?>,
                        text: 'Mira este increíble apartamento en Santa Marta',
                        url: window.location.href
                    }).catch(console.error);
                } else {
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        alert('¡Enlace copiado al portapapeles!');
                    });
                }
            }

            function toggleServices() {
                const extras = document.querySelectorAll('.service-item-extra');
                const btn = document.getElementById('toggle-services-btn');
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

                btn.textContent = isHidden ? 'Mostrar más' : 'Mostrar menos';
            }

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
                document.getElementById('gallery-modal').classList.remove('hidden');
                document.getElementById('gallery-modal').classList.add('flex');
                document.body.style.overflow = 'hidden';
            }

            function closeGallery() {
                document.getElementById('gallery-modal').classList.add('hidden');
                document.getElementById('gallery-modal').classList.remove('flex');
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

                // Detener videos anteriores si existen
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
                // Detener video al cerrar
                const video = content.querySelector('video');
                if (video) video.pause();
                content.innerHTML = '';
            }

            // Teclado
            document.addEventListener('keydown', function(e) {
                if (document.getElementById('lightbox-modal').classList.contains('hidden')) return;
                if (e.key === 'ArrowLeft') changeSlide(-1);
                if (e.key === 'ArrowRight') changeSlide(1);
                if (e.key === 'Escape') closeLightbox();
            });

            // --- Nueva Lógica de Reserva ---
            const basePrice = <?php echo $apartamento['precio']; ?>;
            // Se define un límite de 8 personas como máximo, pero no puede exceder la capacidad real del apartamento si esta es menor,
            // a menos que se desee permitir sobrecupo explícito.
            // Asumiendo que el usuario quiere ver "hasta 8" incluso si la capacidad es menor para probar, o limitarlo al max real.
            // Usaremos 8 como límite duro si la capacidad de la base de datos es menor, para cumplir el requerimiento del usuario "hasta 8".
            // O mejor: Math.max(<?php echo $apartamento['capacidad']; ?>, 8);
            const maxCapacity = 8;
            const cleaningFee = 80000;
            const serviceFeeBase = 0.10; // 10% comisión

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

            // Inicializar Flatpickr
            const fp = flatpickr("#checkin-input", {
                locale: "es",
                minDate: "today",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                mode: "range",
                disable: bookedRanges,
                onChange: function(dates) {
                    if (dates.length === 2) {
                        selectedDates.checkin = dates[0];
                        selectedDates.checkout = dates[1];
                        document.getElementById('checkout-input').value = fp.formatDate(dates[1], "d/m/Y");
                        calculatePrice();
                    } else {
                        selectedDates.checkin = dates[0] || null;
                        selectedDates.checkout = null;
                        document.getElementById('checkout-input').value = "";
                        document.getElementById('price-breakdown').classList.add('hidden');
                    }
                }
            });

            // Sincronizar el segundo input con el mismo flatpickr
            document.getElementById('checkout-container').addEventListener('click', () => fp.open());

            // Manejo de Huéspedes
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

                // Lógica específica por tipo
                if (type === 'adults') {
                    // Adultos: mínimo 1, y la suma con niños no puede exceder capacidad
                    if (newValue >= 1 && (newValue + guests.children) <= maxCapacity) {
                        guests.adults = newValue;
                    }
                } else if (type === 'children') {
                    // Niños: mínimo 0, y la suma con adultos no puede exceder capacidad
                    if (newValue >= 0 && (guests.adults + newValue) <= maxCapacity) {
                        guests.children = newValue;
                    }
                } else if (type === 'infants') {
                    // Bebés: mínimo 0, máximo 5 (por poner un límite razonable), no cuentan para capacidad principal
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
                document.getElementById('count-adults').textContent = guests.adults;
                document.getElementById('count-children').textContent = guests.children;
                document.getElementById('count-infants').textContent = guests.infants;

                let totalGuests = guests.adults + guests.children;
                let summary = `${totalGuests} Huésped${totalGuests > 1 ? 'es' : ''}`;

                if (guests.infants > 0) {
                    summary += `, ${guests.infants} Bebé${guests.infants > 1 ? 's' : ''}`;
                }
                if (guests.guideDog) {
                    summary += `, Perro de guía`;
                }

                document.getElementById('guest-summary').textContent = summary;

                // Bloquear/Desbloquear botones
                document.getElementById('btn-adults-minus').disabled = guests.adults <= 1;
                document.getElementById('btn-children-minus').disabled = guests.children <= 0;
                document.getElementById('btn-infants-minus').disabled = guests.infants <= 0;

                const atMax = (guests.adults + guests.children) >= maxCapacity;
                document.getElementById('btn-adults-plus').disabled = atMax;
                document.getElementById('btn-children-plus').disabled = atMax;

                // Bebés tienen sus propios límites
                document.getElementById('btn-infants-plus').disabled = guests.infants >= 5;
            }

            function closeGuestDropdown() {
                guestDropdown.classList.add('hidden');
            }

            function calculatePrice() {
                if (!selectedDates.checkin || !selectedDates.checkout) return;

                const timeDiff = Math.abs(selectedDates.checkout.getTime() - selectedDates.checkin.getTime());
                const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));

                if (nights > 0) {
                    const subtotal = basePrice * nights;
                    const serviceFee = Math.round(subtotal * serviceFeeBase);
                    const total = subtotal + cleaningFee + serviceFee;

                    document.getElementById('base-price-display').textContent = basePrice.toLocaleString('es-CO');
                    document.getElementById('nights-display').textContent = nights;
                    document.getElementById('subtotal-display').textContent = subtotal.toLocaleString('es-CO');
                    document.getElementById('cleaning-fee-display').textContent = cleaningFee.toLocaleString('es-CO');
                    document.getElementById('service-fee-display').textContent = serviceFee.toLocaleString('es-CO');
                    document.getElementById('total-display').textContent = total.toLocaleString('es-CO');

                    document.getElementById('price-breakdown').classList.remove('hidden');
                }
            }

            function goToReservation() {
                if (!selectedDates.checkin || !selectedDates.checkout) {
                    alert('Por favor, selecciona las fechas de llegada y salida.');
                    // Abrir calendario automáticamente si falta fecha
                    fp.open();
                    return;
                }

                const checkinStr = fp.formatDate(selectedDates.checkin, "Y-m-d");
                const checkoutStr = fp.formatDate(selectedDates.checkout, "Y-m-d");

                const params = new URLSearchParams({
                    id: <?php echo $id_apartamento; ?>,
                    checkin: checkinStr,
                    checkout: checkoutStr,
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

            function toggleReviews() {
                const extra = document.querySelectorAll('.review-item-extra');
                const btn = document.getElementById('toggle-reviews-btn');
                if (!btn) return;

                const isHidden = extra.length > 0 && extra[0].classList.contains('hidden');
                extra.forEach(el => el.classList.toggle('hidden'));
                btn.textContent = isHidden ? 'Mostrar menos' : 'Mostrar todas las reseñas';
            }

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
                if (!form) return;
                const formData = new FormData(form);
                const rating = formData.get('calificacion');
                if (!rating || rating === '0') {
                    alert('Por favor selecciona una calificación');
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
                            alert('Error: ' + (data.message || 'No se pudo guardar la reseña'));
                        }
                    })
                    .catch(() => alert('Ocurrió un error al enviar la reseña'));
            }
        </script>

    <?php endif; ?>
</body>

</html>