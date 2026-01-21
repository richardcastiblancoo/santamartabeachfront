<!DOCTYPE html>
<html class="light" lang="es-CO">

<head>
    <!-- los metadatos -->
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="description" content="Vive la experiencia frente al mar lo mejores apartamentos en Santamartabeachfront te esperan. Despierta con el sonido de las olas.">
    <meta name="keywords" content="apartamentos Santa Marta,
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
    <title>santamartabeachfront - Reserva del Mar</title>
    <!-- links css y logo -->
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="canonical" href="https://santamartabeachfront.com">
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link rel="stylesheet" href="/css/style.css">
    <link rel="shortcut icon" href="/public/img/logo-definitivo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <!-- los scripts -->
    <script defer src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <script defer src="https://cdn.tailwindcss.com"></script>
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
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WWFXJJRB"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#111618] dark:text-white transition-colors duration-200">



    <style>
        :root {
            scroll-behavior: auto;
        }

        /* Evita scroll automático */

        .hero-title {
            font-size: clamp(2rem, 5vw, 4rem);
            line-height: 1.1;
            letter-spacing: -0.05em;
            min-height: 2.2em;
        }

        .cursor {
            display: inline-block;
            width: 3px;
            background-color: #3b82f6;
            margin-left: 4px;
            animation: blink 1s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }

        .glass-booking {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }

        #mobile-menu {
            transform: translateY(-100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #mobile-menu.active {
            transform: translateY(0);
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1) opacity(0.5);
        }
    </style>

    <header id="main-header" class="fixed top-0 left-0 w-full z-50 flex items-center justify-between px-6 py-4 md:px-10 transition-all duration-300">
        <div class="flex items-center gap-3">
            <a href="/" class="flex items-center gap-3 group">
                <img
                    src="/public/img/logo-definitivo.png"
                    alt="Logo"
                    class="size-14 md:size-20 object-contain">

                <h1 class="flex items-center text-white text-base md:text-lg font-black tracking-tighter uppercase leading-none hidden md:inline-block">
                    Santamarta<span class="text-blue-400">beachfront</span>
                </h1>
            </a>
        </div>



        <nav class="hidden md:flex items-center gap-8">
            <ul class="flex items-center gap-6 list-none">
                <li><a class="text-white/70 text-[11px] font-bold uppercase tracking-widest hover:text-white transition-colors" href="#apartamentos">Apartamentos</a></li>
                <li><a class="text-white/70 text-[11px] font-bold uppercase tracking-widest hover:text-white transition-colors" href="#ubicacion">Ubicación</a></li>
                <li><a class="text-white/70 text-[11px] font-bold uppercase tracking-widest hover:text-white transition-colors" href="#contacto">Contacto</a></li>
            </ul>

            <div class="flex items-center gap-4 border-l border-white/20 pl-6">
                <div class="relative group">
                    <button class="flex items-center gap-2 text-white text-[11px] font-bold uppercase tracking-widest h-9 px-3 rounded-lg hover:bg-white/10 transition-colors">
                        <img class="w-4 h-4 rounded-full object-cover" src="https://flagcdn.com/w40/co.png" alt="ES">
                        <span>ES</span>
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </button>
                    <ul class="hidden group-hover:block absolute top-full right-0 mt-1 w-32 bg-slate-900 border border-white/10 rounded-xl py-2 shadow-2xl">
                        <li><button onclick="changeLanguage('ES')" class="w-full text-left px-4 py-2 text-[11px] text-white font-bold hover:bg-blue-600">ESPAÑOL</button></li>
                        <li><button onclick="changeLanguage('EN')" class="w-full text-left px-4 py-2 text-[11px] text-white font-bold hover:bg-blue-600">ENGLISH</button></li>
                    </ul>
                </div>
                <a href="/auth/login.php" class="h-9 px-6 bg-blue-600 text-white text-[11px] font-black uppercase tracking-widest rounded-full flex items-center hover:bg-blue-500 transition-all shadow-lg shadow-blue-600/20">Inicio Sesión</a>
            </div>
        </nav>

        <button onclick="toggleMobileMenu(true)" class="md:hidden text-white p-2">
            <span class="material-symbols-outlined text-3xl">menu</span>
        </button>
    </header>

    <div id="mobile-menu" class="fixed inset-0 bg-slate-950/98 backdrop-blur-xl z-[100] flex flex-col md:hidden">
        <div class="flex justify-between items-center p-6 border-b border-white/10">
            <div class="flex gap-4">
                <button onclick="changeLanguage('ES')" class="text-white font-bold text-xs border border-white/20 px-3 py-1 rounded">ES</button>
                <button onclick="changeLanguage('EN')" class="text-white/40 font-bold text-xs border border-white/10 px-3 py-1 rounded">EN</button>
            </div>
            <button onclick="toggleMobileMenu(false)" class="text-white">
                <span class="material-symbols-outlined text-4xl">close</span>
            </button>
        </div>
        <nav class="flex flex-col items-center justify-center flex-grow gap-8">
            <a href="#apartamentos" onclick="toggleMobileMenu(false)" class="text-white text-2xl font-black uppercase tracking-widest">Apartamentos</a>
            <a href="#ubicacion" onclick="toggleMobileMenu(false)" class="text-white text-2xl font-black uppercase tracking-widest">Ubicación</a>
            <a href="#contacto" onclick="toggleMobileMenu(false)" class="text-white text-2xl font-black uppercase tracking-widest">Contacto</a>
            <a href="/auth/login.php" class="mt-4 px-12 py-4 bg-blue-600 text-white rounded-full font-black uppercase tracking-widest">Inicio Sesión</a>
        </nav>
    </div>
    <main>
        <section class="relative w-full min-h-screen flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0 bg-black/50 z-10"></div>
                <video class="w-full h-full object-cover" autoplay muted loop playsinline aria-hidden="true">
                    <source src="/public/video/santamarta-video-tayrona.mp4" type="video/mp4">
                </video>
            </div>

            <div class="relative z-20 w-full max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center pt-24 pb-12">
                <div class="text-left">
                    <h2 class="hero-title font-black text-white">
                        <span id="typewriter"></span><span class="cursor"></span><br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">
                            Santa Marta frente al mar
                        </span>
                    </h2>
                    <p class="text-white text-sm md:text-base mt-6 max-w-sm leading-relaxed">
                        Exclusividad y confort en los mejores apartamentos de la costa caribeña.
                    </p>
                </div>

                <div class="flex justify-end">
                    <div class="glass-booking w-full max-w-md p-8 rounded-3xl shadow-2xl">
                        <h3 class="text-white text-lg font-bold mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-400">event_available</span>
                            Reserva tu estancia
                        </h3>

                        <form id="reservaForm" class="space-y-4">
                            <div class="space-y-1">
                                <label for="full-name" class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">Nombre Completo</label>
                                <input id="full-name" type="text" placeholder="Tu nombre" class="glass-input w-full rounded-xl px-4 py-3 text-sm text-white bg-white/10 border border-white/20" required>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label for="whatsapp" class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">WhatsApp</label>
                                    <input id="whatsapp" type="tel" placeholder="+57..." class="glass-input w-full rounded-xl px-4 py-3 text-sm text-white bg-white/10 border border-white/20" required>
                                </div>
                                <div class="space-y-1">
                                    <label for="email" class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">Correo</label>
                                    <input id="email" type="email" placeholder="tu@email.com" class="glass-input w-full rounded-xl px-4 py-3 text-sm text-white bg-white/10 border border-white/20" required>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label for="accommodation" class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">Alojamiento</label>
                                <select id="accommodation" class="glass-input w-full rounded-xl px-4 py-3 text-sm text-white bg-slate-800 border border-white/20 appearance-none">
                                    <option value="Reserva del Mar - Apartamento 1730">Reserva del Mar - Apartamento 1730</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label for="check-in" class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">Entrada</label>
                                    <input id="check-in" type="date" class="glass-input w-full rounded-xl px-4 py-3 text-sm text-white bg-white/10 border border-white/20" required>
                                </div>
                                <div class="space-y-1">
                                    <label for="check-out" class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">Salida</label>
                                    <input id="check-out" type="date" class="glass-input w-full rounded-xl px-4 py-3 text-sm text-white bg-white/10 border border-white/20" required>
                                </div>
                            </div>

                            <button type="submit" class="w-full h-14 bg-blue-600 hover:bg-blue-500 text-white font-black uppercase tracking-widest text-[11px] rounded-xl transition-all shadow-xl shadow-blue-600/30 mt-4">
                                Enviar a WhatsApp
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>



    <script>
        //---------------------------
        // formulario de whasapp
        document.getElementById('reservaForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // 1. Obtener los valores de los campos
            const nombre = document.getElementById('full-name').value;
            const tel = document.getElementById('whatsapp').value;
            const email = document.getElementById('email').value;
            const alojamiento = document.getElementById('accommodation').value;
            const entrada = document.getElementById('check-in').value;
            const salida = document.getElementById('check-out').value;

            // 2. Definir el número de teléfono (sin espacios ni símbolos)
            const telefonoVentas = "573183813381";

            // 3. Crear el mensaje con formato amigable
            const mensaje = `*Nueva Solicitud de Reserva*%0A` +
                `---------------------------------%0A` +
                `*Nombre:* ${nombre}%0A` +
                `*WhatsApp:* ${tel}%0A` +
                `*Correo:* ${email}%0A` +
                `*Alojamiento:* ${alojamiento}%0A` +
                `*Fecha Entrada:* ${entrada}%0A` +
                `*Fecha Salida:* ${salida}%0A` +
                `---------------------------------%0A` +
                `¡Hola! Me gustaría confirmar disponibilidad.`;

            // 4. Construir la URL de WhatsApp
            const urlWhatsApp = `https://wa.me/${telefonoVentas}?text=${mensaje}`;

            // 5. Abrir en una nueva pestaña
            window.open(urlWhatsApp, '_blank');
        });
    </script>


    <!-- serviciosofresidos -->
    <?php include 'include/serviciosofresidos.php'; ?>

    <!-- disponibilidad -->
    <section class="py-16 px-6 md:px-20 bg-[#101c22]" id="disponibilidad">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-12 items-center">

            <div class="flex-1 space-y-6">
                <span class="text-blue-400 font-bold uppercase tracking-wider text-sm">Planifica tu viaje</span>
                <h2 class="text-3xl md:text-5xl font-bold text-white leading-tight">
                    Consulta disponibilidad en tiempo real
                </h2>
                <p class="text-gray-400 text-lg">
                    Nuestros apartamentos son muy solicitados. Revisa el calendario para asegurar tus fechas ideales para unas vacaciones inolvidables.
                </p>

                <div class="flex flex-col gap-4 pt-4">
                    <div class="flex items-center gap-3">
                        <div class="size-3 rounded-full bg-blue-600"></div>
                        <span class="text-sm font-medium text-gray-300">Fechas Disponibles</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="size-3 rounded-full bg-gray-700"></div>
                        <span class="text-sm font-medium text-gray-300">No Disponible</span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 pt-6">
                    <a href="https://wa.me/573183813381?text=Hola!%20Me%20gustaría%20consultar%20disponibilidad%20para%20una%20reserva."
                        target="_blank"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-blue-600/20 active:scale-95">
                        <span class="material-symbols-outlined">calendar_add_on</span>
                        Reservar por WhatsApp
                    </a>
                </div>
            </div>

            <div class="flex-1 w-full flex justify-center lg:justify-end">
                <div class="bg-[#1e2930] rounded-2xl shadow-2xl p-6 border border-white/10 max-w-2xl w-full relative overflow-hidden">

                    <div id="calendar-container" class="flex flex-col md:flex-row gap-6 justify-center transition-opacity duration-300">

                        <div class="flex min-w-[280px] flex-1 flex-col gap-2">
                            <div class="flex items-center p-1 justify-between mb-2">
                                <button onclick="prevMonth()" class="hover:bg-gray-700 text-white rounded-full p-1 transition-colors">
                                    <span class="material-symbols-outlined">chevron_left</span>
                                </button>
                                <p id="month1-name" class="text-white text-base font-bold text-center w-full">Enero 2026</p>
                            </div>
                            <div class="grid grid-cols-7 gap-y-2 text-center" id="grid-month1">
                            </div>
                        </div>

                        <div class="h-px w-full bg-gray-700 md:hidden"></div>

                        <div class="flex min-w-[280px] flex-1 flex-col gap-2">
                            <div class="flex items-center p-1 justify-between mb-2">
                                <p id="month2-name" class="text-white text-base font-bold text-center w-full">Febrero 2026</p>
                                <button onclick="nextMonth()" class="hover:bg-gray-700 text-white rounded-full p-1 transition-colors">
                                    <span class="material-symbols-outlined">chevron_right</span>
                                </button>
                            </div>
                            <div class="grid grid-cols-7 gap-y-2 text-center" id="grid-month2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- apartamento -->
    <?php include 'include/apartamentos.php'; ?>

    <!-- testimonios -->
    <?php include 'include/testimonios.php'; ?>

    <!-- ubicacion -->
    <?php include 'include/ubicacion.php'; ?>

    <!-- footer -->
    <footer class="bg-[#101c22] text-white pt-20 pb-10" id="contacto" itemscope itemtype="https://schema.org/Organization">
        <hr class="border-t border-gray-800 my-12" aria-hidden="true">

        <div class="max-w-7xl mx-auto px-6 md:px-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 py-16">

                <section class="space-y-6">
                    <a href="/" class="flex items-center gap-2 group" aria-label="Ir al inicio">
                        <div class="size-10 md:size-12 transition-transform group-hover:scale-105">
                            <img src="/public/img/logo-definitivo.png" alt="logo" class="w-full h-full object-cover">
                        </div>
                        <span class="text-xl font-bold text-white tracking-tight" itemprop="name">
                            Santamarta<span class="text-blue-400">beachfront</span>
                        </span>
                    </a>
                    <p class="text-gray-300 text-sm leading-relaxed max-w-xs" itemprop="description" data-i18n="foo_desc">
                        La plataforma líder en alquileres vacacionales de lujo en Santa Marta. Experiencias únicas, confort superior y las mejores vistas del Caribe colombiano.
                    </p>
                </section>

                <section>
                    <h2 class="font-bold mb-6 text-white uppercase tracking-wider text-xs" data-i18n="foo_contact_title">Información de Contacto</h2>
                    <address class="not-italic">
                        <ul class="space-y-4 text-sm text-gray-300">
                            <li>
                                <a href="mailto:17clouds@gmail.com" class="flex items-center gap-3 hover:text-white transition-colors group" itemprop="email">
                                    <span class="material-symbols-outlined text-blue-400 group-hover:scale-110 transition-transform" aria-hidden="true">mail</span>
                                    <span>17clouds@gmail.com</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://wa.me/573183813381" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 hover:text-white transition-colors group" itemprop="telephone">
                                    <span class="material-symbols-outlined text-blue-400 group-hover:scale-110 transition-transform" aria-hidden="true">call</span>
                                    <span>+57 318 3813381</span>
                                </a>
                            </li>
                            <li class="flex items-start gap-3" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                                <span class="material-symbols-outlined text-blue-400" aria-hidden="true">location_on</span>
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
                                <a class="w-12 h-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center hover:bg-gradient-to-tr hover:from-[#f09433] hover:via-[#dc2743] hover:to-[#bc1888] transition-all duration-300 group" href="#" target="_blank" rel="noopener" aria-label="Instagram">
                                    <i class="fa-brands fa-instagram text-xl text-gray-300 group-hover:text-white"></i>
                                </a>
                            </li>
                            <li>
                                <a class="w-12 h-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center hover:bg-black transition-all duration-300 group" href="#" target="_blank" rel="noopener" aria-label="Twitter">
                                    <i class="fa-brands fa-x-twitter text-xl text-gray-300 group-hover:text-white"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </section>
            </div>

            <aside class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-gray-800 text-[11px] sm:text-xs text-gray-400 gap-4">
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

    <!-- ================= SCRIPT =============== -->
    <script src="/js/main.js"></script>
    <script src="sw.js"></script>

    <script>
        /**
         * ==========================================
         * CALENDARIO INTERACTIVO
         * ==========================================
         */
        let currentStartMonth = 0; // 0 = Enero
        const year = 2026;
        const monthNames = [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
        ];

        function renderCalendar() {
            const container = document.getElementById("calendar-container");
            container.style.opacity = 0;

            setTimeout(() => {
                updateMonth(currentStartMonth, "month1-name", "grid-month1");
                updateMonth(currentStartMonth + 1, "month2-name", "grid-month2");
                container.style.opacity = 1;
            }, 200);
        }

        function updateMonth(mIndex, nameId, gridId) {
            // Manejo de desbordamiento de meses (ej: Diciembre + 1)
            const displayMonth = mIndex % 12;
            const displayYear = year + Math.floor(mIndex / 12);

            document.getElementById(nameId).innerText =
                `${monthNames[displayMonth]} ${displayYear}`;

            const grid = document.getElementById(gridId);
            grid.innerHTML = `
            <p class="text-gray-500 text-xs font-bold">D</p>
            <p class="text-gray-500 text-xs font-bold">L</p>
            <p class="text-gray-500 text-xs font-bold">M</p>
            <p class="text-gray-500 text-xs font-bold">M</p>
            <p class="text-gray-500 text-xs font-bold">J</p>
            <p class="text-gray-500 text-xs font-bold">V</p>
            <p class="text-gray-500 text-xs font-bold">S</p>
        `;

            const firstDay = new Date(displayYear, displayMonth, 1).getDay();
            const daysInMonth = new Date(displayYear, displayMonth + 1, 0).getDate();

            // Celdas vacías iniciales
            for (let i = 0; i < firstDay; i++) {
                grid.innerHTML += "<span></span>";
            }

            // Renderizado de días
            for (let d = 1; d <= daysInMonth; d++) {
                // Ejemplo visual de estados (puedes adaptar esta lógica a tus datos reales)
                if (displayMonth === 0 && d === 5) {
                    grid.innerHTML += `<span class="flex items-center justify-center h-8 w-8 mx-auto rounded-full bg-blue-600 text-white text-sm font-bold shadow-md shadow-blue-500/40">${d}</span>`;
                } else if (displayMonth === 0 && (d === 6 || d === 7)) {
                    grid.innerHTML += `<span class="flex items-center justify-center h-8 w-8 mx-auto bg-blue-500/10 text-blue-400 text-sm font-medium rounded-full">${d}</span>`;
                } else if (displayMonth === 0 && d >= 8 && d <= 10) {
                    grid.innerHTML += `<span class="flex items-center justify-center h-8 w-8 mx-auto text-sm text-gray-400 line-through">${d}</span>`;
                } else {
                    grid.innerHTML += `<span class="flex items-center justify-center h-8 w-8 mx-auto text-sm text-gray-300 hover:bg-white/5 rounded-full cursor-pointer transition-colors">${d}</span>`;
                }
            }
        }

        function nextMonth() {
            if (currentStartMonth < 10) {
                // Límite hasta Nov-Dic
                currentStartMonth++;
                renderCalendar();
            }
        }

        function prevMonth() {
            if (currentStartMonth > 0) {
                currentStartMonth--;
                renderCalendar();
            }
        }

        document.addEventListener("DOMContentLoaded", renderCalendar);
    </script>

</body>
</html>