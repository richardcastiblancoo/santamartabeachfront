<!DOCTYPE html>
<html class="light" lang="es-CO">

<head>
    <!-- los metadatos -->
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="description" content="Vive la experiencia rente al mar lo mejores apartamentos en Santamartabeachfront te esperan. Despierta con el sonido de las olas.">
    <meta name="keywords" content="apartamentos Santa Marta, alquiler turístico Santa Marta, apartamentos frente al mar, hoteles Santa Marta, hospedaje Rodadero, alojamiento playa Salguero, apartamentos con piscina Santa Marta, turismo Santa Marta, vacaciones Caribe colombiano">
    <meta name="author" content="santamartabeachfront">
    <meta name="robots" content="index, follow">
    <!-- opengraph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.santamartabeachfront.com">
    <meta property="og:title" content="Santamartabeachfront">
    <meta property="og:description" content="Vive la experiencia rente al mar lo mejores apartamentos en Santamartabeachfront te esperan. Despierta con el sonido de las olas.">
    <meta property="og:image" content="https://www.tusitio.com/imagen-de-portada.jpg">
    <!-- opengraph twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://www.tusitio.com/">
    <meta name="twitter:title" content="Título de tu Página">
    <meta name="twitter:description" content="Descripción para Twitter.">
    <meta name="twitter:image" content="https://www.tusitio.com/imagen-de-portada.jpg">
    <meta name="theme-color" content="#000000">
    <!-- titulo -->
    <title>santamartabeachfront - Alquiler de Apartamentos</title>
    <!-- links css y logo -->
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="canonical" href="https://www.santamartabeachfront.com">
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link rel="stylesheet" href="/css/style.css">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <!-- los scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
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

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('Service Worker registrado', reg))
                    .catch(err => console.warn('Error al registrar SW', err));
            });
        }
    </script>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-WWFXJJRB');
    </script>
    <!-- End Google Tag Manager -->

</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#111618] dark:text-white transition-colors duration-200">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WWFXJJRB"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <header class="absolute top-0 left-0 w-full z-50 flex items-center justify-between px-6 py-6 md:px-10 transition-all duration-300">
        <div class="flex items-center gap-4">
            <a href="/" class="flex items-center gap-4 group">
                <div class="size-16 md:size-20 flex items-center justify-center transition-transform group-hover:scale-105">
                    <img src="" class="w-full h-auto" alt="">
                </div>
                <h1 class="hidden md:block text-white text-xl font-bold">
                    Santamarta<span class="text-blue-500">beachfront</span>
                </h1>
            </a>
        </div>

        <nav class="hidden md:flex flex-1 justify-end gap-8">
            <ul class="flex items-center gap-9 list-none">
                <li><a class="text-white text-sm font-medium hover:text-primary transition-colors" href="#apartamentos" data-i18n="nav_apartments">Apartamentos</a></li>
                <li><a class="text-white text-sm font-medium hover:text-primary transition-colors" href="#ubicacion" data-i18n="nav_location">Ubicación</a></li>
                <li><a class="text-white text-sm font-medium hover:text-primary transition-colors" href="#nosotros" data-i18n="nav_about">Nosotros</a></li>
                <li><a class="text-white text-sm font-medium hover:text-primary transition-colors" href="#contacto" data-i18n="nav_contact">Contacto</a></li>
            </ul>

            <div class="flex items-center gap-6 border-l border-white/30 pl-6">
                <div class="relative">
                    <button id="langBtn" class="flex items-center gap-2 text-white text-sm font-medium h-10 px-3 rounded-lg hover:bg-white/10 transition-colors">
                        <img id="currentFlag" src="https://flagcdn.com/w40/co.png" class="w-5 h-5 rounded-full object-cover" alt="Flag">
                        <span id="currentLangText">ES</span>
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </button>

                    <ul id="langMenu" class="hidden absolute top-full right-0 mt-2 w-40 bg-white rounded-xl shadow-2xl py-2 z-[60] list-none">
                        <li>
                            <a href="javascript:void(0)" onclick="changeLanguage('ES')" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 text-sm text-gray-800">
                                <img src="https://flagcdn.com/w40/co.png" class="w-5 h-5 rounded-full object-cover">
                                <span>Español</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="changeLanguage('EN')" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 text-sm text-gray-800">
                                <img src="https://flagcdn.com/w40/us.png" class="w-5 h-5 rounded-full object-cover">
                                <span>English</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <a href="/auth/login.php" class="h-10 px-7 bg-primary text-white text-sm font-bold rounded-lg flex items-center" data-i18n="nav_login">Iniciar sesión</a>
            </div>
        </nav>
    </header>

    <section class="relative w-full h-screen flex items-center justify-center overflow-hidden bg-gray-900">
        <div class="absolute inset-0 z-0">
            <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                <source src="/public/video/santamarta-video-tayrona.mp4" type="video/mp4">
            </video>
        </div>

        <div class="relative z-10 text-center px-4 max-w-5xl mx-auto pt-20">
            <h2 class="text-white text-5xl md:text-7xl lg:text-8xl font-black">
                <span data-i18n="hero_title_top">Vive la experiencia en</span><br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-cyan-300 inline-block" data-i18n="hero_title_accent">
                    Santa marta frente al mar
                </span>
            </h2>
            <p class="text-white/95 text-lg md:text-2xl mt-8" data-i18n="hero_desc">
                Los mejores apartamentos en Santamartabeachfront te esperan.
            </p>
            <div class="flex flex-col sm:flex-row gap-5 justify-center mt-10">
                <a href="#apartamentos" class="bg-primary text-white font-bold h-14 px-8 rounded-xl flex items-center justify-center" data-i18n="btn_view">Visualizar</a>
                <a href="#contacto" class="bg-white/10 border border-white/80 text-white font-bold h-14 px-8 rounded-xl flex items-center justify-center" data-i18n="btn_contact">Contactar</a>
            </div>
        </div>
    </section>



    <section class="py-24 px-6 md:px-20 bg-[#101c22]" id="nosotros" aria-labelledby="about-title">
        <div class="max-w-7xl mx-auto">
            <header class="text-center mb-16">
                <span class="text-blue-500 font-bold uppercase tracking-[0.3em] text-xs block mb-3" data-i18n="am_tag">Amenidades</span>
                <h2 id="about-title" class="text-3xl md:text-5xl font-bold text-white mb-6" data-i18n="am_title">
                    ¿Por qué elegirnos?
                </h2>
                <p class="text-gray-400 max-w-2xl mx-auto text-lg leading-relaxed" data-i18n="am_subtitle">
                    Disfruta de una experiencia inigualable con instalaciones de clase mundial diseñadas para tu confort y bienestar frente al Caribe.
                </p>
            </header>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <article class="bg-[#1e2930]/30 p-6 rounded-2xl border border-white/5 hover:border-blue-500/30 hover:bg-[#1e2930]/50 transition-all duration-300 group">
                    <div class="size-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-400 mb-5 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl star-fill">beach_access</span>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-white" data-i18n="am_card1_t">Salida directa al mar</h3>
                    <p class="text-gray-400 text-sm leading-relaxed" data-i18n="am_card1_d">Acceso privado a la playa. Sal de tu apartamento y pisa la arena dorada al instante.</p>
                </article>

                <article class="bg-[#1e2930]/30 p-6 rounded-2xl border border-white/5 hover:border-blue-500/30 hover:bg-[#1e2930]/50 transition-all duration-300 group">
                    <div class="size-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-400 mb-5 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl star-fill">pool</span>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-white" data-i18n="am_card2_t">Piscina de Adultos</h3>
                    <p class="text-gray-400 text-sm leading-relaxed" data-i18n="am_card2_d">Piscina principal diseñada para la relajación con vistas panorámicas al océano.</p>
                </article>

                <article class="bg-[#1e2930]/30 p-6 rounded-2xl border border-white/5 hover:border-blue-500/30 hover:bg-[#1e2930]/50 transition-all duration-300 group">
                    <div class="size-12 bg-yellow-500/10 rounded-xl flex items-center justify-center text-yellow-500 mb-5 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl star-fill">child_care</span>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-white" data-i18n="am_card3_t">Piscina de Niños</h3>
                    <p class="text-gray-400 text-sm leading-relaxed" data-i18n="am_card3_d">Un área segura, controlada y divertida para que los más pequeños disfruten al máximo.</p>
                </article>

                <article class="bg-[#1e2930]/30 p-6 rounded-2xl border border-white/5 hover:border-blue-500/30 hover:bg-[#1e2930]/50 transition-all duration-300 group">
                    <div class="size-12 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-400 mb-5 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl star-fill">hot_tub</span>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-white" data-i18n="am_card4_t">Jacuzzi Premium</h3>
                    <p class="text-gray-400 text-sm leading-relaxed" data-i18n="am_card4_d">Zona de hidromasaje con vistas espectaculares, ideal para desconectar al atardecer.</p>
                </article>

                <article class="bg-[#1e2930]/30 p-6 rounded-2xl border border-white/5 hover:border-blue-500/30 hover:bg-[#1e2930]/50 transition-all duration-300 group">
                    <div class="size-12 bg-red-500/10 rounded-xl flex items-center justify-center text-red-400 mb-5 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl star-fill">spa</span>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-white" data-i18n="am_card5_t">Sauna y Turco</h3>
                    <p class="text-gray-400 text-sm leading-relaxed" data-i18n="am_card5_d">Circuito de bienestar con sauna finlandesa y baño turco de lujo para tu salud.</p>
                </article>

                <article class="bg-[#1e2930]/30 p-6 rounded-2xl border border-white/5 hover:border-blue-500/30 hover:bg-[#1e2930]/50 transition-all duration-300 group">
                    <div class="size-12 bg-orange-500/10 rounded-xl flex items-center justify-center text-orange-400 mb-5 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl star-fill">fitness_center</span>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-white" data-i18n="am_card6_t">Gimnasio 24/7</h3>
                    <p class="text-gray-400 text-sm leading-relaxed" data-i18n="am_card6_d">Equipamiento moderno de cardio y fuerza disponible a cualquier hora del día.</p>
                </article>

                <article class="bg-[#1e2930]/30 p-6 rounded-2xl border border-white/5 hover:border-blue-500/30 hover:bg-[#1e2930]/50 transition-all duration-300 group">
                    <div class="size-12 bg-purple-500/10 rounded-xl flex items-center justify-center text-purple-400 mb-5 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl star-fill">local_bar</span>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-white" data-i18n="am_card7_t">Sky Bar</h3>
                    <p class="text-gray-400 text-sm leading-relaxed" data-i18n="am_card7_d">Bar en la azotea con coctelería premium y la mejor vista panorámica de la costa.</p>
                </article>

                <article class="bg-[#1e2930]/30 p-6 rounded-2xl border border-white/5 hover:border-blue-500/30 hover:bg-[#1e2930]/50 transition-all duration-300 group">
                    <div class="size-12 bg-green-500/10 rounded-xl flex items-center justify-center text-green-400 mb-5 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl star-fill">verified_user</span>
                    </div>
                    <h3 class="text-lg font-bold mb-2 text-white" data-i18n="am_card8_t">Seguridad 24/7</h3>
                    <p class="text-gray-400 text-sm leading-relaxed" data-i18n="am_card8_d">Vigilancia profesional y control de acceso constante para tu total tranquilidad.</p>
                </article>

                <div class="sm:col-span-2 lg:col-span-3 xl:col-span-4 mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="flex items-center gap-3 p-4 bg-[#1e2930]/20 rounded-xl border border-dashed border-white/10">
                        <span class="material-symbols-outlined text-blue-500">wifi</span>
                        <span class="text-sm font-medium text-gray-300" data-i18n="am_wifi">WiFi Fibra Óptica</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-[#1e2930]/20 rounded-xl border border-dashed border-white/10">
                        <span class="material-symbols-outlined text-blue-500">directions_car</span>
                        <span class="text-sm font-medium text-gray-300" data-i18n="am_parking">Parking Incluido</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-[#1e2930]/20 rounded-xl border border-dashed border-white/10">
                        <span class="material-symbols-outlined text-blue-500">outdoor_grill</span>
                        <span class="text-sm font-medium text-gray-300" data-i18n="am_bbq">Zona BBQ</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-[#1e2930]/20 rounded-xl border border-dashed border-white/10">
                        <span class="material-symbols-outlined text-blue-500">sports_esports</span>
                        <span class="text-sm font-medium text-gray-300" data-i18n="am_games">Salón de Juegos</span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="py-16 px-6 md:px-20 bg-[#101c22]" id="disponibilidad" aria-labelledby="disponibilidad-title" itemscope itemtype="https://schema.org/Accommodation">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-12 items-center">

            <article class="flex-1 space-y-6">
                <header>
                    <span class="text-blue-500 font-bold uppercase tracking-wider text-sm block mb-2" data-i18n="dispo_tag">Disponibilidad Inmediata</span>
                    <h2 id="disponibilidad-title" class="text-3xl md:text-5xl font-bold text-white leading-tight" itemprop="name">
                        <span data-i18n="dispo_title">Consulta disponibilidad</span> <span class="text-blue-400" data-i18n="dispo_title_accent">en tiempo real</span>
                    </h2>
                </header>

                <p class="text-gray-400 text-lg leading-relaxed" data-i18n="dispo_desc">
                    Asegura tu estancia en los exclusivos apartamentos de <strong>Reserva del Mar</strong>. Revisa los días disponibles en el calendario y agenda tu visita a Playa Salguero, Santa Marta.
                </p>

                <div class="flex flex-col gap-4 pt-4" aria-hidden="true">
                    <div class="flex items-center gap-3">
                        <div class="size-3 rounded-full bg-blue-600"></div>
                        <span class="text-sm font-medium text-gray-300" data-i18n="dispo_legend_avail">Días Disponibles</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="size-3 rounded-full bg-gray-700"></div>
                        <span class="text-sm font-medium text-gray-300" data-i18n="dispo_legend_reser">Días Reservados</span>
                    </div>
                </div>

                <div class="pt-6">
                    <a href="https://wa.me/573183813381?text=Hola!%20Me%20gustaría%20reservar%20mi%20estancia%20en%20Santamarta%20Beachfront.%20¿Hay%20disponibilidad%20para%20mis%20fechas?"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-4 bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 px-10 rounded-xl transition-all transform hover:-translate-y-1 shadow-lg shadow-blue-900/40 group"
                        aria-label="Reservar estancia por WhatsApp">

                        <span class="text-lg tracking-tight" data-i18n="dispo_btn_wa">Reservar por WhatsApp</span>

                        <span class="material-symbols-outlined transition-transform group-hover:rotate-12 text-2xl" aria-hidden="true">
                            calendar_add_on
                        </span>
                    </a>
                </div>
            </article>

            <div class="flex-1 w-full flex justify-center lg:justify-end">
                <div class="bg-[#1e2930] rounded-2xl shadow-2xl p-6 border border-white/10 max-w-2xl w-full relative overflow-hidden" role="region" aria-label="Calendario de ocupación">
                    <div id="calendar-container" class="flex flex-col md:flex-row gap-8 justify-center transition-opacity duration-300">

                        <div class="flex min-w-[280px] flex-1 flex-col gap-2">
                            <div class="flex items-center p-1 justify-between mb-4">
                                <button onclick="prevMonth()" class="hover:bg-gray-700 text-white rounded-full p-2 transition-colors">
                                    <span class="material-symbols-outlined">chevron_left</span>
                                </button>
                                <time id="month1-name" class="text-white text-base font-bold uppercase tracking-widest"></time>
                                <div class="md:hidden"></div>
                            </div>
                            <div id="grid-header-1" class="grid grid-cols-7 text-center text-[11px] text-blue-400 font-extrabold mb-2 uppercase">
                            </div>
                            <div class="grid grid-cols-7 gap-1 text-center" id="grid-month1"></div>
                        </div>

                        <div class="h-px w-full bg-gray-700 md:hidden"></div>

                        <div class="flex min-w-[280px] flex-1 flex-col gap-2">
                            <div class="flex items-center p-1 justify-between mb-4">
                                <div class="md:hidden"></div>
                                <time id="month2-name" class="text-white text-base font-bold uppercase tracking-widest"></time>
                                <button onclick="nextMonth()" class="hover:bg-gray-700 text-white rounded-full p-2 transition-colors">
                                    <span class="material-symbols-outlined">chevron_right</span>
                                </button>
                            </div>
                            <div id="grid-header-2" class="grid grid-cols-7 text-center text-[11px] text-blue-400 font-extrabold mb-2 uppercase">
                            </div>
                            <div class="grid grid-cols-7 gap-1 text-center" id="grid-month2"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- apartamento -->
    <section class="py-20 bg-[#101c22]" id="apartamentos">
        <div class="px-6 md:px-20 mb-10 text-center">
            <h2 class="text-3xl font-bold text-white mb-2" data-i18n="ap_title">Apartamentos Destacados</h2>
            <p class="text-gray-400 text-sm" data-i18n="ap_subtitle">Nuestras mejores propiedades para una estancia inolvidable</p>
        </div>

        <div class="flex flex-wrap justify-center gap-6 px-6 md:px-20">
            <?php
            $ruta_conexion = 'auth/conexion_be.php';
            if (!file_exists($ruta_conexion)) {
                $ruta_conexion = '../auth/conexion_be.php';
                if (!file_exists($ruta_conexion)) {
                    $ruta_conexion = '../../auth/conexion_be.php';
                }
            }
            include_once $ruta_conexion;

            $sql = "SELECT a.*, COALESCE(AVG(r.calificacion), 0) as promedio_calificacion 
                FROM apartamentos a 
                LEFT JOIN resenas r ON a.id = r.apartamento_id 
                GROUP BY a.id 
                ORDER BY a.fecha_creacion DESC LIMIT 6";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $ruta_web_img = '/assets/img/apartamentos/' . $row['imagen_principal'];
            ?>
                    <article class="max-w-[360px] w-full bg-[#1e2930]/40 backdrop-blur-md rounded-3xl overflow-hidden shadow-2xl group border border-white/10 transition-all duration-300 hover:border-blue-500/30">
                        <div class="relative h-60 overflow-hidden">
                            <div class="absolute top-3 right-3 z-10 bg-[#101c22]/80 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold text-white flex items-center gap-1 border border-white/5">
                                <span class="material-symbols-outlined text-yellow-500 text-xs" style="font-variation-settings: 'FILL' 1;">star</span> <?php echo number_format($row['promedio_calificacion'], 1); ?>
                            </div>

                            <div class="h-full w-full bg-cover bg-center group-hover:scale-105 transition-transform duration-500"
                                style="background-image: url('<?php echo $ruta_web_img; ?>');">
                            </div>

                            <div class="absolute inset-0 bg-gradient-to-t from-[#101c22]/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
                                <button class="w-full bg-blue-600 text-white font-bold py-2 rounded-xl text-xs uppercase tracking-wider shadow-lg" data-i18n="ap_btn_book">
                                    Reservar Ahora
                                </button>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-1"><?php echo $row['ubicacion']; ?></div>
                            <h3 class="text-xl font-bold text-white mb-2"><?php echo $row['titulo']; ?></h3>
                            <p class="text-gray-400 text-xs mb-6 leading-relaxed line-clamp-2"><?php echo $row['descripcion']; ?></p>

                            <div class="grid grid-cols-3 gap-2 text-[10px] text-gray-400 mb-6">
                                <div class="flex flex-col items-center gap-1 p-2 bg-white/5 rounded-xl">
                                    <span class="material-symbols-outlined text-blue-400 text-lg">bed</span>
                                    <span><?php echo $row['habitaciones']; ?> <span data-i18n="ap_unit_bed">Hab</span></span>
                                </div>
                                <div class="flex flex-col items-center gap-1 p-2 bg-white/5 rounded-xl">
                                    <span class="material-symbols-outlined text-blue-400 text-lg">shower</span>
                                    <span><?php echo $row['banos']; ?> <span data-i18n="ap_unit_bath">Baños</span></span>
                                </div>
                                <div class="flex flex-col items-center gap-1 p-2 bg-white/5 rounded-xl">
                                    <span class="material-symbols-outlined text-blue-400 text-lg">groups</span>
                                    <span><?php echo $row['capacidad']; ?> <span data-i18n="ap_unit_pers">Pers</span></span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-5 border-t border-white/5">
                                <div>
                                    <span class="text-xl font-black text-white">$<?php echo number_format($row['precio'], 0, ',', '.'); ?></span>
                                    <span class="text-gray-500 text-[10px]" data-i18n="ap_night">/noche</span>
                                </div>
                                <a href="/php/reserva-apartamento/apartamento.php?id=<?php echo $row['id']; ?>"
                                    class="bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white px-4 py-2 rounded-lg font-bold text-[11px] transition-all" data-i18n="ap_btn_details">
                                    Ver detalles
                                </a>
                            </div>
                        </div>
                    </article>
            <?php
                }
            } else {
                echo '<p class="text-gray-400 w-full text-center" data-i18n="ap_empty">No hay apartamentos disponibles por el momento.</p>';
            }
            ?>
        </div>
    </section>

    <!-- testimonios -->
    <section class="py-32 bg-[#101c22] overflow-hidden" aria-labelledby="testimonios-title">
        <div class="max-w-7xl mx-auto mb-16 px-6">
            <header class="text-center">
                <span class="text-blue-500 font-bold uppercase tracking-[0.3em] text-xs block mb-3" data-i18n="test_tag">Comunidad</span>
                <h2 id="testimonios-title" class="text-4xl md:text-5xl font-bold text-white mb-6" data-i18n="test_title">Experiencias Inolvidables</h2>
                <p class="text-gray-400 max-w-2xl mx-auto text-lg leading-relaxed" data-i18n="test_desc">
                    Únete a los cientos de viajeros que han confiado en <strong>Reserva del Mar</strong>.
                </p>
            </header>
        </div>

        <div class="relative w-full overflow-hidden mask-fade-edges">
            <div class="animate-infinite-scroll gap-6" id="testimonial-track">
                <div class="flex gap-6">
                    <article class="w-[350px] md:w-[400px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between shrink-0">
                        <div>
                            <div class="flex text-yellow-500 mb-5"><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span></div>
                            <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8" data-i18n="test_1_quote">"¡Simplemente espectacular! La vista desde el balcón es inigualable."</blockquote>
                        </div>
                        <footer class="flex items-center gap-4">
                            <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=carolina" alt="Carolina">
                            <div><cite class="not-italic font-bold text-white block">Carolina Méndez</cite><span class="text-xs text-blue-400 uppercase font-semibold">Bogotá, COL</span></div>
                        </footer>
                    </article>

                    <article class="w-[350px] md:w-[400px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between shrink-0">
                        <div>
                            <div class="flex text-yellow-500 mb-5"><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span></div>
                            <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8" data-i18n="test_2_quote">"La ubicación es envidiable. Estar a un paso de la playa Salguero lo es todo."</blockquote>
                        </div>
                        <footer class="flex items-center gap-4">
                            <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=david" alt="David">
                            <div><cite class="not-italic font-bold text-white block">David Johnson</cite><span class="text-xs text-blue-400 uppercase font-semibold">Miami, USA</span></div>
                        </footer>
                    </article>

                    <article class="w-[350px] md:w-[400px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between shrink-0">
                        <div>
                            <div class="flex text-yellow-500 mb-5"><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span></div>
                            <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8" data-i18n="test_3_quote">"El apartamento estaba impecable. Los atardeceres desde la piscina son de otro mundo."</blockquote>
                        </div>
                        <footer class="flex items-center gap-4">
                            <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=lucia" alt="Lucía">
                            <div><cite class="not-italic font-bold text-white block">Lucía Ferreyra</cite><span class="text-xs text-blue-400 uppercase font-semibold">Buenos Aires, ARG</span></div>
                        </footer>
                    </article>

                    <article class="w-[350px] md:w-[400px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between shrink-0">
                        <div>
                            <div class="flex text-yellow-500 mb-5"><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span></div>
                            <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8" data-i18n="test_4_quote">"Como nómada digital, el WiFi funcionó perfecto. Trabajar aquí fue increíble."</blockquote>
                        </div>
                        <footer class="flex items-center gap-4">
                            <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=sofia" alt="Sofía">
                            <div><cite class="not-italic font-bold text-white block">Sofía Ramírez</cite><span class="text-xs text-blue-400 uppercase font-semibold">Medellín, COL</span></div>
                        </footer>
                    </article>

                    <article class="w-[350px] md:w-[400px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between shrink-0">
                        <div>
                            <div class="flex text-yellow-500 mb-5"><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span></div>
                            <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8" data-i18n="test_5_quote">"Excelente atención del personal. Sin duda volveremos con toda mi familia."</blockquote>
                        </div>
                        <footer class="flex items-center gap-4">
                            <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=roberto" alt="Roberto">
                            <div><cite class="not-italic font-bold text-white block">Roberto Gómez</cite><span class="text-xs text-blue-400 uppercase font-semibold">Cali, COL</span></div>
                        </footer>
                    </article>
                </div>
            </div>
        </div>
    </section>


    <!-- ubicacion -->
    <section class="grid grid-cols-1 lg:grid-cols-2 min-h-[650px] bg-[#101c22] overflow-hidden" id="ubicacion">
        <article class="p-10 lg:p-20 flex flex-col justify-center order-2 lg:order-1">
            <header>
                <div class="flex items-center gap-2 text-blue-500 font-bold mb-6">
                    <span class="material-symbols-outlined text-3xl">location_on</span>
                    <span class="uppercase tracking-[0.3em] text-sm" data-i18n="loc_tag">Ubicación Privilegiada</span>
                </div>
                <h2 class="text-4xl lg:text-5xl font-bold mb-8 text-white leading-tight">
                    <span data-i18n="loc_title_city">Playa Salguero:</span> <br>
                    <span class="text-blue-500" data-i18n="loc_title_accent">El corazón de Santa Marta</span>
                </h2>
            </header>
            <p class="text-gray-400 mb-10 text-xl leading-relaxed max-w-xl" data-i18n="loc_desc">
                Descubre la tranquilidad de <strong>Reserva del Mar</strong>, ubicado en la zona más exclusiva y con acceso directo al mar.
            </p>
            <address class="not-italic mb-10 space-y-3 border-l-4 border-blue-600 pl-6 py-2 bg-blue-900/10 rounded-r-xl max-w-md">
                <p class="text-2xl font-black text-white">Reserva del Mar - Torre 4</p>
                <p class="text-lg text-slate-300" data-i18n="loc_apt">Apartamento 1730</p>
                <p class="text-sm text-slate-500 uppercase tracking-[0.2em]">Santa Marta, Colombia</p>
            </address>
            <ul class="space-y-6 mb-12" role="list">
                <li class="flex items-center gap-4 group">
                    <div class="size-11 shrink-0 rounded-full bg-cyan-900/30 flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-xl">beach_access</span>
                    </div>
                    <span class="text-gray-300 font-medium text-lg" data-i18n="loc_dist1">A solo 1 minuto de la playa</span>
                </li>
                <li class="flex items-center gap-4 group">
                    <div class="size-11 shrink-0 rounded-full bg-green-900/30 flex items-center justify-center text-green-400 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-xl">flight</span>
                    </div>
                    <span class="text-gray-300 font-medium text-lg" data-i18n="loc_dist2">15 min del Aeropuerto Internacional</span>
                </li>
                <li class="flex items-center gap-4 group">
                    <div class="size-11 shrink-0 rounded-full bg-blue-900/30 flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-xl">restaurant</span>
                    </div>
                    <span class="text-gray-300 font-medium text-lg" data-i18n="loc_dist3">5 min de la Zona Gastronómica</span>
                </li>
            </ul>
            <a href="https://maps.google.com" target="_blank" class="self-start px-10 py-4 bg-blue-600 text-white font-bold rounded-full hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-500/20 active:scale-95" data-i18n="loc_btn_maps">
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
                    <p id="map-status" class="text-[10px] font-black text-white uppercase tracking-[0.2em] whitespace-nowrap" data-i18n="map_loading">Localizando...</p>
                </div>
            </div>
        </aside>
    </section>

    <!-- footer -->
    <footer class="bg-[#101c22] text-white pt-20 pb-10" id="contacto" itemscope itemtype="https://schema.org/Organization">
        <hr class="border-t border-gray-800 my-12" aria-hidden="true">

        <div class="max-w-7xl mx-auto px-6 md:px-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 py-16">

                <section class="space-y-6">
                    <a href="/" class="flex items-center gap-2 group" aria-label="Ir al inicio">
                        <span class="text-xl font-bold text-white tracking-tight" itemprop="name">
                            Santamarta<span class="text-blue-500">beachfront</span>
                        </span>
                    </a>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-xs" itemprop="description" data-i18n="foo_desc">
                        La plataforma líder en alquileres vacacionales de lujo en Santa Marta. Experiencias únicas, confort superior y las mejores vistas del Caribe colombiano.
                    </p>
                </section>

                <section>
                    <h2 class="font-bold mb-6 text-white uppercase tracking-wider text-xs" data-i18n="foo_contact_title">Información de Contacto</h2>
                    <address class="not-italic">
                        <ul class="space-y-4 text-sm text-gray-400">
                            <li>
                                <a href="mailto:17clouds@gmail.com" class="flex items-center gap-3 hover:text-white transition-colors group" itemprop="email">
                                    <span class="material-symbols-outlined text-blue-500 group-hover:scale-110 transition-transform" aria-hidden="true">mail</span>
                                    <span>17clouds@gmail.com</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://wa.me/573183813381" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 hover:text-white transition-colors group" itemprop="telephone">
                                    <span class="material-symbols-outlined text-blue-500 group-hover:scale-110 transition-transform" aria-hidden="true">call</span>
                                    <span>+57 318 3813381</span>
                                </a>
                            </li>
                            <li class="flex items-start gap-3" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                                <span class="material-symbols-outlined text-blue-500" aria-hidden="true">location_on</span>
                                <span class="leading-relaxed">
                                    <span itemprop="streetAddress" data-i18n="foo_address">Apartamento 1730 - Torre 4, Reserva del Mar, Playa Salguero</span><br>
                                    <span itemprop="addressLocality">Santa Marta</span>, <span itemprop="addressCountry" data-i18n="foo_country">Colombia</span>
                                </span>
                            </li>
                        </ul>
                    </address>
                </section>

                <section>
                    <h2 class="font-bold mb-6 text-white uppercase tracking-wider text-xs" data-i18n="foo_social_title">Síguenos</h2>
                    <nav aria-label="Redes sociales">
                        <ul class="flex gap-4 list-none p-0">
                            <li>
                                <a class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-gradient-to-tr hover:from-[#f09433] hover:via-[#dc2743] hover:to-[#bc1888] transition-all duration-300 group" href="#" target="_blank" rel="noopener">
                                    <i class="fa-brands fa-instagram text-xl text-gray-400 group-hover:text-white"></i>
                                </a>
                            </li>
                            <li>
                                <a class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-black transition-all duration-300 group" href="#" target="_blank" rel="noopener">
                                    <i class="fa-brands fa-x-twitter text-xl text-gray-400 group-hover:text-white"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </section>
            </div>

            <aside class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-gray-800 text-[10px] sm:text-xs text-gray-500 gap-4">
                <p>© <time datetime="2026">2026</time> Santamarta Beachfront. <span data-i18n="foo_rights">Todos los derechos reservados.</span></p>
                <nav aria-label="Enlaces legales">
                    <ul class="flex gap-8 list-none p-0">
                        <li><a class="hover:text-white transition-colors" href="/php/politica-terminos/politica-privacidad.php" data-i18n="foo_privacy">Políticas de Privacidad</a></li>
                        <li><a class="hover:text-white transition-colors" href="/php/politica-terminos/politica-privacidad.php" data-i18n="foo_terms">Términos y Condiciones</a></li>
                    </ul>
                </nav>
            </aside>
        </div>
    </footer>

    <!-- ================= SCRIPT ================= -->
    <script src="/js/main.js"></script>
    <script src="sw.js"></script>

</body>

</html>