<!DOCTYPE html>
<html class="light" lang="es-CO">

<head>
    <!-- los metadatos -->
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="description" content="Vive la experiencia frente al mar lo mejores apartamentos en Santamartabeachfront te esperan. Despierta con el sonido de las olas.">
    <meta name="keywords" content="
    apartamentos Santa Marta,
    alquiler de apartamentos en Santa Marta,
    apartamentos turísticos Santa Marta,
    apartamentos frente al mar Santa Marta,
    apartamentos con vista al mar,
    apartamentos en Rodadero,
    apartamentos playa Salguero,
    alojamiento en Santa Marta,
    hospedaje Santa Marta,
    hoteles en Santa Marta,
    apartahoteles Santa Marta,
    arriendo vacacional Santa Marta,
    alquiler por días Santa Marta,
    alquiler por noches Santa Marta,
    vacaciones en Santa Marta,
    turismo en Santa Marta,
    Caribe colombiano,
    playas de Santa Marta,
    playa Salguero Santa Marta,
    Rodadero Santa Marta,
    apartamentos con piscina,
    apartamentos familiares Santa Marta,
    alojamiento económico Santa Marta,
    alojamiento de lujo Santa Marta,
    apartamentos amoblados Santa Marta,
    apartamentos vacacionales Colombia,
    turismo de playa Colombia,
    viajar a Santa Marta,
    donde hospedarse en Santa Marta,
    mejores apartamentos Santa Marta,
    reservas del mar,
    reservas del mar Santa Marta,
    reservas del mar apartamentos,
    reservas del mar playa Salguero,
    apartamento reservas del mar,
    apartamento turístico Santa Marta,
    alquiler vacaciones Caribe,
    apartamentos cerca del mar,
    apartamentos modernos Santa Marta,
    apartamentos con aire acondicionado,
    apartamentos con wifi Santa Marta,
    apartamentos con parqueadero,
    apartamentos con balcón,
    apartamentos con vista panorámica,
    apartamentos para parejas,
    apartamentos para familias,
    apartamentos para grupos,
    apartamentos pet friendly Santa Marta,
    alojamiento cerca del aeropuerto Santa Marta,
    alojamiento cerca del centro histórico,
    turismo Magdalena,
    vacaciones en el Magdalena,
    alojamiento playa privada,
    apartamentos con seguridad 24 horas,
    edificio reservas del mar,
    hospedaje frente al mar Santa Marta,
    turismo internacional Santa Marta,
    viajes al Caribe colombiano,
    playas del Caribe colombiano,
    apartamentos para descanso,
    alquiler temporal Santa Marta,
    apartamentos cerca del Rodadero,
    apartamentos en primera línea de playa,
    alquiler de lujo Santa Marta,
    apartamentos exclusivos Santa Marta,
    turismo familiar Santa Marta,
    alojamiento premium Santa Marta,
    vacaciones inolvidables Santa Marta,
    reservar apartamento Santa Marta
    ">
    <meta name="author" content="santamartabeachfront">
    <meta name="robots" content="index, follow">
    <!-- opengraph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.santamartabeachfront.com">
    <meta property="og:title" content="Santamartabeachfront">
    <meta property="og:description" content="Vive la experiencia rente al mar lo mejores apartamentos en Santamartabeachfront te esperan. Despierta con el sonido de las olas.">
    <meta property="og:image" content="https://santamartabeachfront.com/public/img/logo-portada.png">
    <!-- opengraph twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://www.santamartabeachfront.com/">
    <meta name="twitter:title" content="santamartabeachfront - Alquiler de Apartamentos">
    <meta name="twitter:description" content="Vive la experiencia frente al mar lo mejores apartamentos en Santamartabeachfront te esperan. Despierta con el sonido de las olas.">
    <meta name="twitter:image" content="https://santamartabeachfront.com/public/img/logo-portada.png">
    <meta name="theme-color" content="#63b5f8ff">
    <!-- titulo -->
    <title>santamartabeachfront - Alquiler de Apartamentos</title>
    <!-- links css y logo -->
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="canonical" href="https://santamartabeachfront.com">
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

    <style>
        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4rem);
            /* Tamaño fluido y compacto */
            line-height: 1.1;
            letter-spacing: -0.05em;
        }

        .glass-booking {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Estilo para el input date en modo oscuro */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1) opacity(0.5);
        }
    </style>

    <header id="main-header" class="fixed top-0 left-0 w-full z-50 flex items-center justify-between px-6 py-4 md:px-10 transition-all duration-300">
        <div class="flex items-center gap-3">
            <a href="/" class="flex items-center gap-3 group">
                <div class="size-10 md:size-12 transition-transform group-hover:scale-105">

                </div>
                <h1 class="text-white text-base md:text-lg font-black tracking-tighter uppercase">
                    Santamarta<span class="text-blue-500">beachfront</span>
                </h1>
            </a>
        </div>

        <nav class="hidden md:flex items-center gap-8">
            <ul class="flex items-center gap-6 list-none">
                <li><a class="text-white/70 text-[11px] font-bold uppercase tracking-[0.2em] hover:text-white transition-colors" href="#apartamentos" data-i18n="nav_apartments">Apartamentos</a></li>
                <li><a class="text-white/70 text-[11px] font-bold uppercase tracking-[0.2em] hover:text-white transition-colors" href="#ubicacion" data-i18n="nav_location">Ubicación</a></li>
                <li><a class="text-white/70 text-[11px] font-bold uppercase tracking-[0.2em] hover:text-white transition-colors" href="#contacto" data-i18n="nav_contact">Contacto</a></li>
            </ul>

            <div class="flex items-center gap-4 border-l border-white/20 pl-6">
                <div class="relative group">
                    <button class="flex items-center gap-2 text-white text-[11px] font-bold uppercase tracking-widest h-9 px-3 rounded-lg hover:bg-white/10 transition-colors">
                        <img class="w-4 h-4 rounded-full object-cover" src="https://flagcdn.com/w40/co.png">
                        <span>ES</span>
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </button>
                    <ul class="hidden group-hover:block absolute top-full right-0 mt-1 w-32 bg-slate-900 border border-white/10 rounded-xl py-2 list-none shadow-2xl">
                        <li><a href="#" onclick="changeLanguage('ES')" class="block px-4 py-2 text-[11px] text-white font-bold hover:bg-blue-600">ESPAÑOL</a></li>
                        <li><a href="#" onclick="changeLanguage('EN')" class="block px-4 py-2 text-[11px] text-white font-bold hover:bg-blue-600">ENGLISH</a></li>
                    </ul>
                </div>
                <a href="/auth/login.php" class="h-9 px-6 bg-blue-600 text-white text-[11px] font-black uppercase tracking-widest rounded-full flex items-center hover:bg-blue-500 transition-all">Login</a>
            </div>
        </nav>

        <button onclick="toggleMobileMenu()" class="md:hidden text-white p-2">
            <span class="material-symbols-outlined text-3xl">menu</span>
        </button>
    </header>

    <section class="relative w-full min-h-screen flex items-center justify-center overflow-hidden font-sans">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-black/60 z-10"></div>
            <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                <source src="/public/video/santamarta-video-tayrona.mp4" type="video/mp4">
            </video>
        </div>

        <div class="relative z-20 w-full max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center pt-20">

            <div class="text-left">
                <h2 class="text-4xl md:text-6xl font-black text-white leading-tight">
                    Vive la experiencia en<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">
                        Santa Marta frente al mar
                    </span>
                </h2>
                <p class="text-white/80 text-sm md:text-base mt-4 max-w-sm leading-relaxed">
                    Exclusividad y confort en los mejores apartamentos de la costa caribeña.
                </p>
            </div>

            <div class="flex justify-end">
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 w-full max-w-md p-8 rounded-3xl shadow-2xl">
                    <h3 class="text-white text-xl font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-400">send</span>
                        Solicitar Reserva
                    </h3>

                    <form class="space-y-4">
                        <div class="space-y-1">
                            <label class="text-blue-400 text-[9px] font-black uppercase tracking-widest ml-1">Nombre Completo</label>
                            <input type="text" id="nombre" required placeholder="Tu nombre"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-blue-500 transition-all placeholder:text-white/20">
                        </div>

                        <div class="space-y-1">
                            <label class="text-blue-400 text-[9px] font-black uppercase tracking-widest ml-1">Apartamento</label>
                            <select id="producto" class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-blue-500">
                                <option value="Suite Vista Mar">Suite Vista Mar</option>
                                <option value="Penthouse Deluxe">Penthouse Deluxe</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-blue-400 text-[9px] font-black uppercase tracking-widest ml-1">Entrada</label>
                                <input type="date" id="checkin" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-[12px] focus:outline-none">
                            </div>
                            <div class="space-y-1">
                                <label class="text-blue-400 text-[9px] font-black uppercase tracking-widest ml-1">Salida</label>
                                <input type="date" id="checkout" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-[12px] focus:outline-none">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-blue-400 text-[9px] font-black uppercase tracking-widest ml-1">Mensaje adicional</label>
                            <textarea id="mensaje" rows="2" placeholder="Comentarios..."
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-blue-500 transition-all placeholder:text-white/20"></textarea>
                        </div>

                        <button type="button" onclick="enviarAWhatsApp()"
                            class="w-full h-14 bg-blue-600 hover:bg-blue-500 text-white font-black uppercase tracking-[0.2em] text-[10px] rounded-xl transition-all shadow-xl shadow-blue-600/20 mt-2">
                            Enviar a WhatsApp
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        function enviarAWhatsApp() {
            // 1. TU NÚMERO AQUÍ (sin el +)
            const miNumero = "573022315451";

            // 2. RECOGER DATOS
            const nom = document.getElementById('nombre').value;
            const pro = document.getElementById('producto').value;
            const ent = document.getElementById('checkin').value;
            const sal = document.getElementById('checkout').value;
            const msg = document.getElementById('mensaje').value;

            if (!nom || !ent || !sal) {
                alert("Por favor rellena nombre y fechas.");
                return;
            }

            // 3. ARMAR MENSAJE
            const mensajeFinal = `*SOLICITUD DE RESERVA*%0A` +
                `*Nombre:* ${nom}%0A` +
                `*Apartamento:* ${pro}%0A` +
                `*Entrada:* ${ent}%0A` +
                `*Salida:* ${sal}%0A` +
                `*Mensaje:* ${msg || 'Sin mensaje'}`;

            // 4. ABRIR WHATSAPP
            window.open(`https://api.whatsapp.com/send?phone=${miNumero}&text=${mensajeFinal}`, '_blank');
        }
    </script>

    <style>
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }
    </style>



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
    <?php include 'include/apartamentos.php'; ?>

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
    <?php include 'include/footer.php'; ?>

    <!-- ================= SCRIPT ================= -->
    <script src="/public/dist/main.js"></script>
    <script src="sw.js"></script>

</body>

</html>