<?php
include '../../auth/conexion_be.php';

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
?>
<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Penthouse Vista Coral - Detalle del Apartamento</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#111618] dark:text-white transition-colors duration-300">
    <header class="sticky top-0 z-50 w-full bg-white dark:bg-background-dark border-b border-solid border-[#f0f3f4] dark:border-slate-800 px-4 md:px-10 lg:px-40 py-3">
        <div class="flex items-center justify-between max-w-[1280px] mx-auto">
            <div class="flex items-center gap-2 text-[#111618] dark:text-white">
                <div class="size-6 text-primary">
                    <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" d="M24 0.757355L47.2426 24L24 47.2426L0.757355 24L24 0.757355ZM21 35.7574V12.2426L9.24264 24L21 35.7574Z" fill="currentColor" fill-rule="evenodd"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-extrabold leading-tight tracking-tight">Santamartabeachfront</h2>
            </div>
            <div class="flex items-center gap-4 lg:gap-6">
                <div class="relative group flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <img alt="Español" class="rounded-sm" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAxxlgeU8soFuqw2qtJ07pCDDED-p1nZmRh8L9lRoq1h35ucDX1FwO0GbCscHsVI2WX3rqAOKEn_1WKnHKt16VDin2HD-l-hwtTpJJmKN1f6dyH7I4GG9ezkLwLYeBCy8ewhHQjvqWwNPQhFbvBukJkIaLuNMybTBO72GMeVmUx19umRsQzJFZ6lTTc-THsYxnD03Yfl9_-k7Y_CVkm3X51Irp4v2jecsMt4JOoZXhncQlGx4htJphUwaKqeGWvk35MJaEK-8ypdWE" width="20" />
                    <span class="text-sm font-medium">ES</span>
                    <span class="material-symbols-outlined text-[18px]">expand_more</span>
                </div>
                <div class="flex items-center gap-2">
                    <button class="px-4 py-2 text-sm font-bold hover:text-primary transition-colors">
                        Iniciar sesión
                    </button>
                    <button class="px-5 py-2 rounded-lg bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-all shadow-sm">
                        Registrarse
                    </button>
                </div>
            </div>
        </div>
    </header>
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
                <button class="flex items-center gap-2 px-4 py-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm font-bold hover:bg-slate-50 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">share</span> Compartir
                </button>
            </div>
        </div>
        
        <?php 
        $ruta_img = '/assets/img/apartamentos/' . $apartamento['imagen_principal'];
        ?>
        
        <div class="grid grid-cols-1 md:grid-cols-4 grid-rows-2 gap-3 h-[400px] md:h-[550px] mt-4 rounded-2xl overflow-hidden relative">
            <div class="md:col-span-2 md:row-span-2 relative group overflow-hidden">
                <div class="w-full h-full bg-center bg-no-repeat bg-cover transition-transform duration-700 group-hover:scale-105" data-alt="<?php echo $apartamento['titulo']; ?>" style='background-image: url("<?php echo $ruta_img; ?>");'></div>
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black/20 cursor-pointer">
                    <div class="w-16 h-16 rounded-full bg-white/30 backdrop-blur-md flex items-center justify-center border border-white/50">
                        <span class="material-symbols-outlined text-white text-4xl">fullscreen</span>
                    </div>
                </div>
            </div>
            <!-- Imágenes secundarias (placeholders por ahora, ya que solo subimos una) -->
            <div class="hidden md:block relative group overflow-hidden cursor-pointer">
                <div class="w-full h-full bg-center bg-no-repeat bg-cover grayscale-[30%] group-hover:grayscale-0 transition-all duration-500" style='background-image: url("<?php echo $ruta_img; ?>");'></div>
            </div>
            <div class="hidden md:block group overflow-hidden">
                <div class="w-full h-full bg-center bg-no-repeat bg-cover transition-transform duration-500 group-hover:scale-105" style='background-image: url("<?php echo $ruta_img; ?>");'></div>
            </div>
            <div class="hidden md:block group overflow-hidden">
                <div class="w-full h-full bg-center bg-no-repeat bg-cover transition-transform duration-500 group-hover:scale-105" style='background-image: url("<?php echo $ruta_img; ?>");'></div>
            </div>
            <div class="hidden md:block relative group overflow-hidden">
                <div class="w-full h-full bg-center bg-no-repeat bg-cover transition-transform duration-500 group-hover:scale-105" style='background-image: url("<?php echo $ruta_img; ?>");'></div>
                <div class="absolute bottom-4 right-4 flex flex-col gap-2">
                    <button class="bg-white/95 backdrop-blur-sm px-4 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 border border-slate-200 shadow-xl hover:bg-white transition-all transform active:scale-95">
                        <span class="material-symbols-outlined text-[18px]">photo_library</span> Ver fotos
                    </button>
                </div>
            </div>
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
                    <button class="mt-4 text-primary font-bold flex items-center gap-1 hover:underline">
                        Mostrar más <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </section>

                <?php if (!empty($apartamento['video'])): 
                    $video_url = $apartamento['video'];
                    $embed_url = str_replace("watch?v=", "embed/", $video_url);
                    $embed_url = str_replace("youtu.be/", "youtube.com/embed/", $embed_url);
                ?>
                <section class="mb-10">
                    <h3 class="text-xl font-bold mb-4">Video del alojamiento</h3>
                    <div class="aspect-video rounded-xl overflow-hidden bg-black">
                        <iframe class="w-full h-full" src="<?php echo $embed_url; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </section>
                <?php endif; ?>
                <section class="mb-10 pt-8 border-t border-slate-200 dark:border-slate-800">
                    <h3 class="text-xl font-bold mb-6">Lo que este lugar ofrece</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center gap-4 py-2">
                            <span class="material-symbols-outlined text-primary text-2xl">waves</span>
                            <span class="text-base font-medium">Vistas al mar</span>
                        </div>
                        <div class="flex items-center gap-4 py-2">
                            <span class="material-symbols-outlined text-primary text-2xl">wifi</span>
                            <span class="text-base font-medium">WiFi de alta velocidad</span>
                        </div>
                        <div class="flex items-center gap-4 py-2">
                            <span class="material-symbols-outlined text-primary text-2xl">ac_unit</span>
                            <span class="text-base font-medium">Aire acondicionado central</span>
                        </div>
                        <div class="flex items-center gap-4 py-2">
                            <span class="material-symbols-outlined text-primary text-2xl">pool</span>
                            <span class="text-base font-medium">Piscina privada</span>
                        </div>
                        <div class="flex items-center gap-4 py-2">
                            <span class="material-symbols-outlined text-primary text-2xl">kitchen</span>
                            <span class="text-base font-medium">Cocina equipada</span>
                        </div>
                        <div class="flex items-center gap-4 py-2">
                            <span class="material-symbols-outlined text-primary text-2xl">tv</span>
                            <span class="text-base font-medium">Smart TV 65"</span>
                        </div>
                    </div>
                    <button class="mt-8 w-full md:w-auto px-6 py-3 rounded-xl border border-slate-900 dark:border-white font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        Ver los 32 servicios
                    </button>
                </section>
                <section class="mb-10 pt-8 border-t border-slate-200 dark:border-slate-800">
                    <div class="flex items-center gap-2 mb-6">
                        <span class="material-symbols-outlined text-primary fill-1">star</span>
                        <h3 class="text-xl font-bold"><?php echo $apartamento['total_resenas'] > 0 ? number_format($apartamento['promedio_calificacion'], 1) . ' · ' . $apartamento['total_resenas'] . ' reseñas' : 'Sin reseñas'; ?></h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-cover" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDFjOSwcrkJIBZH81_BEkH80-3ArPgvXqH3avVroM7VMawp2tUA9_w9Og5FPbZYqpDGMwxYxS0s14P9ztpaLEG-c4InwUwLYn1WyruKNgWlf6_I6XjmNznFttThGt0xR3krjCONSDx7nkfaxOpa3s077eARhl1srZprpzbV1PRcOn7_dOz6YnrRx-sOQpxUf41qM9KIWUD1-TUHtZktrX5ho8sPh18dlmLBw5nkh2y3zc9T_nQ1DyEtAjejLxF_AequtLYaFtlRj0Q');"></div>
                                <div>
                                    <p class="font-bold">Maria Fernanda</p>
                                    <p class="text-xs text-[#617c89]">Enero de 2024</p>
                                </div>
                            </div>
                            <p class="text-sm text-[#4b5563] dark:text-slate-300">
                                "La vista es absolutamente increíble. El apartamento está impecable y tiene todo lo necesario para una estancia de lujo. ¡Definitivamente volveremos!"
                            </p>
                        </div>
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-cover" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDtw8eg-hsreQj9uI8e2VrpQZdb88bJakn9oihNRHy8qRCNTfUBeLUF3QKkaQdQ6bRAMYz2ghVyLlO00GPm8bKhl3jbcriSttPfLL9_JTmvPT8hfWsrnu-IAdgf8GfLaGYzqqxAjqZhnn2tjKBCPJHOavsrSLW0F2oCSfYsE7j8YPqhq_sdZSUnZJCRKP2bRf0WzZgkBQOVHIymCdnumTe5_Teblef8SkVH-JJGIhlsiT0jnYxd2ZYs-YCRRbmnDZrcEnt8AHpvDxM');"></div>
                                <div>
                                    <p class="font-bold">Juan Carlos</p>
                                    <p class="text-xs text-[#617c89]">Diciembre de 2023</p>
                                </div>
                            </div>
                            <p class="text-sm text-[#4b5563] dark:text-slate-300">
                                "Excelente ubicación y servicio por parte del anfitrión. Las instalaciones del edificio son de primera categoría."
                            </p>
                        </div>
                    </div>
                    <button class="mt-8 text-primary font-bold hover:underline">Mostrar todas las reseñas</button>
                </section>
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
                    <div class="rounded-xl border border-slate-300 dark:border-slate-700 overflow-hidden mb-4">
                        <div class="grid grid-cols-2 border-b border-slate-300 dark:border-slate-700">
                            <div class="p-3 border-r border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer">
                                <p class="text-[10px] font-black uppercase text-[#111618] dark:text-white">Llegada</p>
                                <input type="date" class="w-full bg-transparent border-none p-0 text-sm font-medium focus:ring-0" />
                            </div>
                            <div class="p-3 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer">
                                <p class="text-[10px] font-black uppercase text-[#111618] dark:text-white">Salida</p>
                                <input type="date" class="w-full bg-transparent border-none p-0 text-sm font-medium focus:ring-0" />
                            </div>
                        </div>
                        <div class="p-3 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer">
                            <p class="text-[10px] font-black uppercase text-[#111618] dark:text-white">Huéspedes</p>
                            <select class="w-full bg-transparent border-none p-0 text-sm font-medium focus:ring-0">
                                <?php for($i = 1; $i <= $apartamento['capacidad']; $i++): ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?> Huésped<?php echo $i > 1 ? 'es' : ''; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <button class="w-full py-4 bg-primary text-white rounded-xl font-bold text-lg hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 mb-4">
                        Reservar ahora
                    </button>
                    <p class="text-center text-sm text-[#617c89] mb-6">No se te cobrará nada todavía</p>
                    
                    <?php 
                    $precio = $apartamento['precio'];
                    $noches = 5; // Ejemplo
                    $subtotal = $precio * $noches;
                    $limpieza = 80000;
                    $servicio = 120000;
                    $total = $subtotal + $limpieza + $servicio;
                    ?>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-base">
                            <span class="underline text-[#4b5563] dark:text-slate-300">$<?php echo number_format($precio, 0, ',', '.'); ?> x <?php echo $noches; ?> noches</span>
                            <span class="font-medium">$<?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                        </div>
                        <div class="flex justify-between text-base">
                            <span class="underline text-[#4b5563] dark:text-slate-300">Tarifa de limpieza</span>
                            <span class="font-medium">$<?php echo number_format($limpieza, 0, ',', '.'); ?></span>
                        </div>
                        <div class="flex justify-between text-base">
                            <span class="underline text-[#4b5563] dark:text-slate-300">Comisión de servicio</span>
                            <span class="font-medium">$<?php echo number_format($servicio, 0, ',', '.'); ?></span>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex justify-between items-center font-bold text-lg">
                        <span>Total</span>
                        <span>$<?php echo number_format($total, 0, ',', '.'); ?></span>
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

</body>

</html>