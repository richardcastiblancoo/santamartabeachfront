<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Santamartabeachfront - reservas del mar</title>
    <link rel="shortcut icon" href="/public/img/logo-portada.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
                        "2xl": "1rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
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
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#111618] dark:text-white transition-colors duration-200">
    <div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">

        <?php include 'include/header.php'; ?>

        <?php include 'include/serviciosofresidos.php'; ?>
       
       <?php include 'include/Consultadisponibilidadentiemporeal.php'; ?>
        

         <!-- reseñas -->
        <?php include 'include/apartamentos.php'; ?>


        <!-- reseñas -->
        <?php include 'include/testimonios.php'; ?>


        <!-- Ubicación -->
        <section class="grid grid-cols-1 lg:grid-cols-2 min-h-[650px] bg-[#101c22] overflow-hidden" id="ubicacion">

            <article class="p-10 lg:p-20 flex flex-col justify-center order-2 lg:order-1">
                <header>
                    <div class="flex items-center gap-2 text-blue-500 font-bold mb-6">
                        <span class="material-symbols-outlined text-3xl">location_on</span>
                        <span class="uppercase tracking-[0.3em] text-sm">Ubicación Privilegiada</span>
                    </div>
                    <h2 class="text-4xl lg:text-5xl font-bold mb-8 text-white leading-tight">
                        Playa Salguero: <br><span class="text-blue-500">El corazón de Santa Marta</span>
                    </h2>
                </header>

                <p class="text-gray-400 mb-10 text-xl leading-relaxed max-w-xl">
                    Descubre la tranquilidad de <strong>Reserva del Mar</strong>, ubicado en la zona más exclusiva y con acceso directo al mar.
                </p>

                <address class="not-italic mb-10 space-y-3 border-l-4 border-blue-600 pl-6 py-2 bg-blue-900/10 rounded-r-xl max-w-md">
                    <p class="text-2xl font-black text-white">Reserva del Mar - Torre 4</p>
                    <p class="text-lg text-slate-300">Apartamento 1730</p>
                    <p class="text-sm text-slate-500 uppercase tracking-[0.2em]">Santa Marta, Colombia</p>
                </address>

                <ul class="space-y-6 mb-12" role="list">
                    <li class="flex items-center gap-4 group">
                        <div class="size-11 shrink-0 rounded-full bg-cyan-900/30 flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-xl">beach_access</span>
                        </div>
                        <span class="text-gray-300 font-medium text-lg">A solo 1 minuto de la playa</span>
                    </li>
                    <li class="flex items-center gap-4 group">
                        <div class="size-11 shrink-0 rounded-full bg-green-900/30 flex items-center justify-center text-green-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-xl">flight</span>
                        </div>
                        <span class="text-gray-300 font-medium text-lg">15 min del Aeropuerto Internacional</span>
                    </li>
                    <li class="flex items-center gap-4 group">
                        <div class="size-11 shrink-0 rounded-full bg-blue-900/30 flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-xl">restaurant</span>
                        </div>
                        <span class="text-gray-300 font-medium text-lg">5 min de la Zona Gastronómica</span>
                    </li>
                </ul>

                <a href="https://www.google.com/maps/search/?api=1&query=Reserva+del+Mar+Torre+4+Santa+Marta" target="_blank" class="self-start px-10 py-4 bg-blue-600 text-white font-bold rounded-full hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-500/20 active:scale-95">
                    Abrir en Google Maps
                </a>
            </article>

            <aside class="relative w-full min-h-[500px] lg:min-h-full order-1 lg:order-2">
                <div id="map-ubicacion" class="absolute inset-0 w-full h-full"></div>

                <div class="absolute top-6 left-6 z-[1000] bg-[#101c22]/90 px-5 py-3 rounded-2xl border border-white/10 backdrop-blur-md shadow-2xl">
                    <div class="flex items-center gap-3">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-600"></span>
                        </span>
                        <p id="map-status" class="text-[10px] font-black text-white uppercase tracking-[0.2em] whitespace-nowrap">Localizando...</p>
                    </div>
                </div>
            </aside>
        </section>


        <?php include 'include/footer.php'; ?>


    </div>

    <script src="/js/main.js"></script>

</body>

</html>