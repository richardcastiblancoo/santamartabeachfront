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
    $sql_rangos = "SELECT fecha_inicio, fecha_fin FROM reservas WHERE apartamento_id = $id_apartamento AND estado <> 'Cancelada' AND fecha_fin > CURDATE()";
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
    <title>Penthouse Vista Coral - Detalle del Apartamento</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="/public/img/logo-portada.png" type="image/x-icon">
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
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#111618] dark:text-white transition-colors duration-300">
    <?php if (!$isEmbed): ?>
        <header class="sticky top-0 z-50 w-full bg-white dark:bg-background-dark border-b border-solid border-[#f0f3f4] dark:border-slate-800 px-4 md:px-10 lg:px-40 py-3">
            <div class="flex items-center justify-between max-w-[1280px] mx-auto">
                <div class="flex items-center gap-2 text-[#111618] dark:text-white">
                    <div class="size-6 text-primary">
                       <img src="" alt="">
                    </div>
                    <h2 class="text-xl font-extrabold leading-tight tracking-tight">Santamartabeachfront</h2>
                </div>
                <div class="flex items-center gap-4 lg:gap-6">
                    <div class="relative group flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">

                        <span class="text-sm font-medium">ES</span>
                        <span class="material-symbols-outlined text-[18px]">expand_more</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="/auth/login.php" class="px-4 py-2 text-sm font-bold hover:text-primary transition-colors">
                            Iniciar sesión
                        </a>
                        <a href="/auth/registro.php" class="px-5 py-2 rounded-lg bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-all shadow-sm">
                            Registrarse
                        </a>
                    </div>
                </div>
            </div>
        </header>
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
                        <span class="material-symbols-outlined text-[20px]">share</span> Compartir
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
                        <h2 class="text-2xl font-bold mb-2">Alojamiento entero: <?php echo $apartamento['titulo']; ?></h2>
                        <p class="text-[#617c89] dark:text-slate-400"><?php echo $apartamento['capacidad']; ?> Huéspedes · <?php echo $apartamento['habitaciones']; ?> Dormitorios · <?php echo $apartamento['banos']; ?> Baños</p>
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
                    <section class="mb-10 pt-8 border-t border-slate-200 dark:border-slate-800">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="material-symbols-outlined text-primary fill-1">star</span>
                            <h3 class="text-xl font-bold"><?php echo $apartamento['total_resenas'] > 0 ? number_format($apartamento['promedio_calificacion'], 1) . ' · ' . $apartamento['total_resenas'] . ' reseñas' : 'Sin reseñas'; ?></h3>
                        </div>
                        <?php if ($puede_resenar): ?>
                            <div class="mb-6">
                                <button onclick="openReviewModal()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-[18px]">rate_review</span>
                                    Escribir reseña
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
                                    if ($nombre === '') $nombre = 'Huésped';

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
                                <button id="toggle-reviews-btn" onclick="toggleReviews()" class="mt-8 text-primary font-bold hover:underline">Mostrar todas las reseñas</button>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                                <p class="text-sm text-slate-600 dark:text-slate-400">Aún no hay reseñas para este apartamento.</p>
                            </div>
                        <?php endif; ?>
                    </section>
                    <?php if ($puede_resenar): ?>
                        <div class="hidden fixed inset-0 z-50 bg-black/50 items-center justify-center p-4 backdrop-blur-sm" id="review-modal">
                            <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden">
                                <form id="review-form" onsubmit="submitReview(event)">
                                    <input type="hidden" name="apartamento_id" value="<?php echo (int)$id_apartamento; ?>">
                                    <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
                                        <h3 class="text-xl font-bold text-[#111618] dark:text-white flex items-center gap-2">
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
                                            <label class="block text-sm font-bold text-[#111618] dark:text-white mb-2">Comentario</label>
                                            <textarea name="comentario" id="review-comentario" rows="4" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary text-[#111618] dark:text-white placeholder:text-slate-400" placeholder="Comparte tu experiencia..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="p-6 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-800 flex justify-end gap-3">
                                        <a class="px-6 py-2.5 text-sm font-bold text-slate-500 hover:text-[#111618] dark:hover:text-white transition-colors cursor-pointer" onclick="closeReviewModal()">Cancelar</a>
                                        <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary/90 text-white text-sm font-bold rounded-lg shadow-lg shadow-primary/30 transition-all">Enviar Reseña</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                    <section class="pt-8 border-t border-slate-200 dark:border-slate-800">
                        <h3 class="text-xl font-bold mb-6">Dónde te quedarás</h3>
                        <div class="w-full h-80 bg-slate-200 dark:bg-slate-800 rounded-2xl relative overflow-hidden group shadow-inner">
                            <div class="absolute inset-0 bg-center bg-cover opacity-80" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBogzmN5Q8LXqsfOCaEMjpdSo36ABt_jb6ztWaSOQXRijjl2E3fBoi3-zGbihFqvYRokk12bhpJOQehtfso2B7mY_O8Sm9hsJCb44Wc1zC9nKe27a2o1Z1fQN0ztxq3HFtf9x7KAzqZLT3yyzvELY5Hxr-9tcc-2V178-crAp0lhS6zujXtGCQJkrcb3Ohaii3WViIrAY45LiN1VdUJ1LzAQVupCW8_9R8A3D5SORYtpNEN-RevNmduibjZXwSDFN3lygeMEaYjNhU');"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="bg-primary text-white p-4 rounded-full shadow-2xl animate-pulse">
                                    <span class="material-symbols-outlined text-4xl">location_on</span>
                                </div>
                            </div>
                        </div>
                        <p class="mt-4 font-bold text-lg">Pozos Colorados, Santa Marta</p>
                        <p class="text-sm text-[#617c89] dark:text-slate-400 mt-1">Un sector exclusivo y tranquilo, perfecto para disfrutar del mar sin multitudes.</p>
                    </section>


                    <section class="pt-12 mt-12 border-t border-slate-200 dark:border-slate-800">
                        <h3 class="text-xl font-bold mb-6">Restaurantes Recomendados</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
                                <div class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-4">
                                    <span class="material-symbols-outlined">restaurant</span>
                                </div>
                                <h4 class="font-bold text-lg mb-2">Mar y Brasa</h4>
                                <div class="space-y-2 text-sm text-[#617c89] dark:text-slate-400">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-base">location_on</span>
                                        <span>Calle 15 # 4-22, El Rodadero</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-base">call</span>
                                        <span>+57 (605) 421-1234</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
                                <div class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-4">
                                    <span class="material-symbols-outlined">flatware</span>
                                </div>
                                <h4 class="font-bold text-lg mb-2">Bahía Gourmet</h4>
                                <div class="space-y-2 text-sm text-[#617c89] dark:text-slate-400">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-base">location_on</span>
                                        <span>Carrera 2 # 11-54, Centro Histórico</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-base">call</span>
                                        <span>+57 (605) 432-5678</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
                                <div class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-4">
                                    <span class="material-symbols-outlined">set_meal</span>
                                </div>
                                <h4 class="font-bold text-lg mb-2">El Galeón del Sabor</h4>
                                <div class="space-y-2 text-sm text-[#617c89] dark:text-slate-400">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-base">location_on</span>
                                        <span>Vía Troncal del Caribe, Km 12</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-base">call</span>
                                        <span>+57 (605) 438-9012</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>


                <!-- Sidebar de Reserva -->
                <div class="lg:col-span-1">
                    <div class="sticky top-28 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-2xl p-6">
                        <div class="flex justify-between items-baseline mb-6">
                            <div>
                                <span class="text-2xl font-black">$<?php echo number_format($apartamento['precio'], 0, ',', '.'); ?></span>
                                <span class="text-[#617c89] text-base"> / noche</span>
                            </div>
                            <div class="flex items-center gap-1 text-sm font-semibold">
                                <span class="material-symbols-outlined text-primary text-[18px] fill-1">star</span> <?php echo $apartamento['total_resenas'] > 0 ? number_format($apartamento['promedio_calificacion'], 1) : '0'; ?>
                            </div>
                        </div>
                        <div class="rounded-xl border border-slate-300 dark:border-slate-700 mb-4 relative">
                            <div class="grid grid-cols-2 border-b border-slate-300 dark:border-slate-700">
                                <div class="p-3 border-r border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer relative rounded-tl-xl">
                                    <p class="text-[10px] font-black uppercase text-[#111618] dark:text-white">Llegada</p>
                                    <input id="checkin-input" type="text" placeholder="Agrega fecha" class="w-full bg-transparent border-none p-0 text-sm font-medium focus:ring-0 placeholder:text-slate-500" />
                                </div>
                                <div class="p-3 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer relative rounded-tr-xl" id="checkout-container">
                                    <p class="text-[10px] font-black uppercase text-[#111618] dark:text-white">Salida</p>
                                    <input id="checkout-input" type="text" placeholder="Agrega fecha" class="w-full bg-transparent border-none p-0 text-sm font-medium focus:ring-0 placeholder:text-slate-500" readonly />
                                </div>
                            </div>
                            <div class="relative">
                                <div id="guest-selector-trigger" class="p-3 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer flex justify-between items-center rounded-b-xl">
                                    <div>
                                        <p class="text-[10px] font-black uppercase text-[#111618] dark:text-white">Huéspedes</p>
                                        <p id="guest-summary" class="text-sm font-medium text-slate-700 dark:text-slate-300">1 Huésped</p>
                                    </div>
                                    <span class="material-symbols-outlined text-slate-500">expand_more</span>
                                </div>

                                <div id="guest-dropdown" class="absolute top-full left-0 w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl p-4 mt-2 z-20 hidden">
                                    <div class="flex justify-between items-center mb-4">
                                        <div>
                                            <p class="font-bold text-sm">Adultos</p>
                                            <p class="text-xs text-slate-500">Edad 13+</p>
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
                                            <p class="font-bold text-sm">Niños</p>
                                            <p class="text-xs text-slate-500">Edad 2-12</p>
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
                                            <p class="font-bold text-sm">Bebés</p>
                                            <p class="text-xs text-slate-500">Menos de 2 años</p>
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
                                            <p class="font-bold text-sm">Perro de guía</p>
                                            <p class="text-xs text-slate-500">¿Tienes un perro de guía?</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" id="guide-dog-toggle" class="sr-only peer" onchange="toggleGuideDog(this.checked)">
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button onclick="closeGuestDropdown()" class="text-sm font-bold underline hover:text-primary">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button onclick="goToReservation()" class="w-full py-4 bg-primary text-white rounded-xl font-bold text-lg hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 mb-4">
                            Reservar ahora
                        </button>
                        <p class="text-center text-sm text-[#617c89] mb-6">No se te cobrará nada todavía</p>

                        <div id="price-breakdown" class="hidden space-y-3 mb-6">
                            <div class="flex justify-between text-base">
                                <span class="underline text-[#4b5563] dark:text-slate-300">$<span id="base-price-display">0</span> x <span id="nights-display">0</span> noches</span>
                                <span class="font-medium">$<span id="subtotal-display">0</span></span>
                            </div>
                            <div class="flex justify-between text-base">
                                <span class="underline text-[#4b5563] dark:text-slate-300">Tarifa de limpieza</span>
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
        <footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 pt-16 pb-8">
            <div class="max-w-[1280px] mx-auto px-4 md:px-10 lg:px-40">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
                    <div class="col-span-1">
                        <div class="flex items-center gap-2 mb-6">
                            <div class="size-6 text-primary">
                                <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                    <path clip-rule="evenodd" d="M24 0.757355L47.2426 24L24 47.2426L0.757355 24L24 0.757355ZM21 35.7574V12.2426L9.24264 24L21 35.7574Z" fill="currentColor" fill-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-extrabold leading-tight tracking-tight">Santamartabeachfront</h2>
                        </div>
                        <p class="text-[#617c89] dark:text-slate-400 text-sm leading-relaxed mb-6">
                            Los mejores apartamentos de lujo frente al mar en Santa Marta. Disfruta de una experiencia inolvidable en el Caribe.
                        </p>
                        <div class="flex gap-4">
                            <a class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-primary hover:text-white hover:border-primary transition-all" href="#">
                                <svg class="size-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
                                </svg>
                            </a>
                            <a class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-primary hover:text-white hover:border-primary transition-all" href="#">
                                <svg class="size-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path>
                                </svg>
                            </a>
                            <a class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-primary hover:text-white hover:border-primary transition-all" href="#">
                                <svg class="size-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="col-span-1">
                        <h4 class="font-bold mb-6 text-slate-900 dark:text-white uppercase text-xs tracking-wider">Contacto</h4>
                        <div class="space-y-4 text-sm font-medium text-[#617c89] dark:text-slate-400">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary text-xl">mail</span>
                                <span>hola@santamartabeach.com</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary text-xl">phone_iphone</span>
                                <span>+57 300 123 4567</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary text-xl">location_on</span>
                                <span>Pozos Colorados, Santa Marta, Colombia</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row justify-between items-center gap-6 pt-8 border-t border-slate-200 dark:border-slate-800 text-xs text-[#617c89]">
                    <p>© 2024 Santamartabeachfront. Todos los derechos reservados.</p>
                    <div class="flex gap-8">
                        <a class="hover:text-primary transition-colors font-medium" href="#">Privacidad</a>
                        <a class="hover:text-primary transition-colors font-medium" href="#">Términos</a>
                    </div>
                </div>
            </div>
        </footer>

        <div id="gallery-modal" class="fixed inset-0 z-[100] bg-black hidden flex-col">
            <div class="p-4 flex justify-between items-center text-white bg-black/50 backdrop-blur-sm absolute top-0 w-full z-10">
                <button onclick="closeGallery()" class="p-2 hover:bg-white/20 rounded-full transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
                <span class="font-bold text-lg">Galería</span>
                <div class="w-10"></div> <!-- Espaciador -->
            </div>
            <div class="flex-1 overflow-y-auto p-4 md:p-10 pt-20 flex justify-center">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-w-7xl w-full">
                    <?php
                    $globalIndex = 0;
                    ?>
                    <!-- Imagen Principal -->
                    <?php if ($apartamento['imagen_principal']): ?>
                        <div class="aspect-[4/3] relative rounded-lg overflow-hidden cursor-pointer group" onclick="openLightbox(<?php echo $globalIndex++; ?>)">
                            <img src="<?php echo $ruta_img; ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Principal">
                        </div>
                    <?php endif; ?>

                    <!-- Imágenes de Galería -->
                    <?php foreach ($imagenes_galeria as $img): ?>
                        <div class="aspect-[4/3] relative rounded-lg overflow-hidden cursor-pointer group" onclick="openLightbox(<?php echo $globalIndex++; ?>)">
                            <img src="/assets/img/apartamentos/<?php echo $img; ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Galería">
                        </div>
                    <?php endforeach; ?>

                    <!-- Videos de Galería -->
                    <?php foreach ($videos_galeria as $vid): ?>
                        <div class="aspect-[4/3] relative rounded-lg overflow-hidden bg-black cursor-pointer group" onclick="openLightbox(<?php echo $globalIndex++; ?>)">
                            <video src="/assets/video/apartamentos/<?php echo $vid; ?>" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity"></video>
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <span class="material-symbols-outlined text-white text-5xl drop-shadow-lg">play_circle</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
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