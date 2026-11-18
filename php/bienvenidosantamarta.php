<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamarta Beachfront | Galería</title>
    <link rel="shortcut icon" href="/public/img/logo-def-Photoroom.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13a4ec",
                        "background-light": "#fcfcfc",
                        "background-dark": "#101c22",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "premium": "1.25rem"
                    }
                },
            },
        }
    </script>

    <style type="text/tailwindcss">
        body { font-family: "Plus Jakarta Sans", sans-serif; }

        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        ::-webkit-scrollbar { width: 12px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #13a4ec; border-radius: 0px; }
        ::-webkit-scrollbar-thumb:hover { background: #0f8bc7; }

        .grid-symmetric {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        @media (min-width: 1024px) {
            .grid-symmetric { grid-template-columns: repeat(3, 1fr); gap: 1.25rem; }
        }

        .gallery-card { 
            @apply relative overflow-hidden rounded-premium bg-slate-800 cursor-zoom-in transition-all duration-500 shadow-lg aspect-square w-full;
        }
        .gallery-card img { @apply absolute inset-0 w-full h-full object-cover transition-transform duration-700; }
        .gallery-card:hover img { @apply scale-110; }

        .pic-panoramic { @apply w-full rounded-premium overflow-hidden cursor-zoom-in shadow-lg mb-6; }
        
        .logo-header img { height: 90px; width: auto; @apply transition-transform duration-300; }
        @media (min-width: 768px) { .logo-header img { height: 120px; } }
        
        .modal-active { overflow: hidden; }
        .nav-modal-btn { @apply absolute top-1/2 -translate-y-1/2 text-white/40 hover:text-white text-6xl transition-all z-[120] px-4 cursor-pointer select-none hidden lg:block; }
        
        @keyframes zoom { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        .animate-zoom { animation: zoom 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white min-h-screen">

    <div id="gallery-modal" class="fixed inset-0 z-[100] hidden bg-black/95 backdrop-blur-xl flex items-center justify-center p-4">
        <button onclick="closeModal()" class="absolute top-6 right-6 text-white/70 hover:text-white text-5xl z-[130] transition-colors">&times;</button>
        <span onclick="prevMedia()" class="nav-modal-btn left-4">‹</span>
        <span onclick="nextMedia()" class="nav-modal-btn right-4">›</span>
        <div id="modal-content" class="w-full h-full flex items-center justify-center transition-opacity duration-300"></div>
    </div>

    <header class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-white/5">
        <div class="max-w-[1600px] mx-auto px-6 h-24 md:h-32 flex items-center justify-between">

            <!-- Logo -->
            <a href="/" class="flex items-center gap-1 logo-header">
                <img src="/public/img/logo-def-Photoroom.png" alt="Logo" class="h-12 md:h-16 w-auto object-contain">
                <h1 class="text-white text-lg md:text-xl font-black tracking-tighter uppercase hidden sm:block -ml-2">
                    Santamarta<span class="text-blue-400">beachfront</span>
                </h1>
            </a>

            <!-- Menú Desktop (Visión de escritorio) -->
            <div class="hidden md:flex items-center gap-6">
                <a href="/" class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">home</span> <span data-i18n="nav-home">Inicio</span>
                </a>

                <!-- Desplegable de Idiomas (Desktop) -->
                <div class="relative border-l border-white/10 pl-6">
                    <button id="lang-menu-btn" onclick="toggleLangMenu()" class="flex items-center gap-2.5 bg-slate-800/80 hover:bg-slate-700/80 border border-white/10 text-white px-3.5 py-2 rounded-full transition-all text-xs font-semibold shadow-lg backdrop-blur-sm">
                        <img id="active-flag" src="https://flagcdn.com/w80/co.png" class="w-5 h-5 rounded-full object-cover shrink-0 shadow-inner" alt="Bandera">
                        <span id="active-lang-text" class="tracking-wide">Español</span>
                        <span class="material-symbols-outlined text-sm text-slate-400 transition-transform duration-300" id="lang-arrow">expand_more</span>
                    </button>

                    <!-- Menú Flotante Idiomas -->
                    <div id="lang-dropdown" class="hidden absolute right-0 mt-3 w-44 bg-[#101c22]/95 border border-white/10 rounded-2xl shadow-2xl backdrop-blur-xl z-50 overflow-hidden transform opacity-0 scale-95 transition-all duration-200">
                        <div class="py-1.5">
                            <button onclick="changeLang('es')" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs text-slate-300 hover:text-white hover:bg-primary/20 transition-colors">
                                <img src="https://flagcdn.com/w80/co.png" class="w-5 h-5 rounded-full object-cover shrink-0" alt="ES">
                                <span>Español</span>
                            </button>
                            <button onclick="changeLang('en')" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs text-slate-300 hover:text-white hover:bg-primary/20 transition-colors">
                                <img src="https://flagcdn.com/w80/us.png" class="w-5 h-5 rounded-full object-cover shrink-0" alt="EN">
                                <span>English</span>
                            </button>
                            <button onclick="changeLang('fr')" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs text-slate-300 hover:text-white hover:bg-primary/20 transition-colors">
                                <img src="https://flagcdn.com/w80/fr.png" class="w-5 h-5 rounded-full object-cover shrink-0" alt="FR">
                                <span>Français</span>
                            </button>
                            <button onclick="changeLang('it')" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs text-slate-300 hover:text-white hover:bg-primary/20 transition-colors">
                                <img src="https://flagcdn.com/w80/it.png" class="w-5 h-5 rounded-full object-cover shrink-0" alt="IT">
                                <span>Italiano</span>
                            </button>
                            <button onclick="changeLang('pt')" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs text-slate-300 hover:text-white hover:bg-primary/20 transition-colors">
                                <img src="https://flagcdn.com/w80/pt.png" class="w-5 h-5 rounded-full object-cover shrink-0" alt="PT">
                                <span>Português</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón Menú Hamburguesa (Mobile) -->
            <button id="mobile-menu-btn" onclick="toggleMobileMenu()" class="md:hidden text-white p-2 focus:outline-none flex items-center justify-center">
                <span id="mobile-menu-icon" class="material-symbols-outlined text-3xl transition-transform duration-300">menu</span>
            </button>

        </div>

        <!-- Panel Desplegable Móvil -->
        <div id="mobile-menu" class="hidden md:hidden bg-[#101c22]/98 border-b border-white/10 backdrop-blur-2xl transition-all duration-300 opacity-0 -translate-y-2">
            <div class="px-6 py-6 space-y-6">

                <!-- Link Inicio -->
                <a href="/" class="flex items-center gap-3 text-sm font-bold uppercase tracking-widest text-white hover:text-blue-400 transition-colors">
                    <span class="material-symbols-outlined">home</span>
                    <span data-i18n="nav-home">Inicio</span>
                </a>

                <div class="border-t border-white/10 pt-4">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-3">Seleccionar Idioma</p>

                    <!-- Lista de Idiomas Móvil -->
                    <div class="grid grid-cols-2 gap-2">
                        <button onclick="selectMobileLang('es')" class="flex items-center gap-3 p-2.5 rounded-xl bg-white/5 border border-white/5 text-xs text-slate-200 hover:bg-primary/20 transition-all">
                            <img src="https://flagcdn.com/w80/co.png" class="w-5 h-5 rounded-full object-cover" alt="ES">
                            <span>Español</span>
                        </button>
                        <button onclick="selectMobileLang('en')" class="flex items-center gap-3 p-2.5 rounded-xl bg-white/5 border border-white/5 text-xs text-slate-200 hover:bg-primary/20 transition-all">
                            <img src="https://flagcdn.com/w80/us.png" class="w-5 h-5 rounded-full object-cover" alt="EN">
                            <span>English</span>
                        </button>
                        <button onclick="selectMobileLang('fr')" class="flex items-center gap-3 p-2.5 rounded-xl bg-white/5 border border-white/5 text-xs text-slate-200 hover:bg-primary/20 transition-all">
                            <img src="https://flagcdn.com/w80/fr.png" class="w-5 h-5 rounded-full object-cover" alt="FR">
                            <span>Français</span>
                        </button>
                        <button onclick="selectMobileLang('it')" class="flex items-center gap-3 p-2.5 rounded-xl bg-white/5 border border-white/5 text-xs text-slate-200 hover:bg-primary/20 transition-all">
                            <img src="https://flagcdn.com/w80/it.png" class="w-5 h-5 rounded-full object-cover" alt="IT">
                            <span>Italiano</span>
                        </button>
                        <button onclick="selectMobileLang('pt')" class="flex items-center gap-3 p-2.5 rounded-xl bg-white/5 border border-white/5 text-xs text-slate-200 hover:bg-primary/20 transition-all col-span-2">
                            <img src="https://flagcdn.com/w80/pt.png" class="w-5 h-5 rounded-full object-cover" alt="PT">
                            <span>Português</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <main class="max-w-[1600px] mx-auto px-4 md:px-12 pt-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-10">
            <div class="lg:col-span-8 grid grid-cols-2 gap-4 md:gap-6">
                <div onclick="openGallery(0)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-1.webp"></div>
                <div onclick="openGallery(1)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-2.webp"></div>
                <div onclick="openGallery(2)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-3.webp"></div>
                <div onclick="openGallery(3)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-4.webp"></div>
            </div>

            <div class="lg:col-span-4">
                <div onclick="openGallery(4)" class="group relative w-full h-full min-h-[400px] overflow-hidden rounded-premium bg-black cursor-pointer shadow-2xl">
                    <video class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-1000" autoplay muted loop playsinline>
                        <source src="/public/video/video-reserva-del-mar.mp4" type="video/mp4">
                    </video>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-8 left-8">
                        <h3 class="text-3xl font-bold text-white tracking-tighter">Reserva del Mar 1 <span class="text-blue-400">Torre 4</span></h3>
                        <p class="text-white/60 text-xs font-bold uppercase tracking-widest mt-2" data-i18n="click-expand">Click para ampliar video</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-10">
            <div onclick="openGallery(32)" class="pic-panoramic h-[250px] md:h-[400px] relative group overflow-hidden">
                <img src="/public/img/©️SantaMartaBeachFront-compressed-32.webp" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000">
                <div class="absolute inset-0 bg-black/10"></div>
            </div>
        </div>

        <div class="grid-symmetric">
            <div onclick="openGallery(5)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-5.webp" loading="lazy"></div>
            <div onclick="openGallery(6)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-6.webp" loading="lazy"></div>
            <div onclick="openGallery(10)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-10.webp" loading="lazy"></div>

            <div onclick="openGallery(8)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-8.webp" loading="lazy"></div>
            <div onclick="openGallery(7)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-7.webp" loading="lazy"></div>
            <div onclick="openGallery(9)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-9.webp" loading="lazy"></div>

            <div onclick="openGallery(11)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-11.webp" loading="lazy"></div>
            <div onclick="openGallery(19)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-19.webp" loading="lazy"></div>
            <div onclick="openGallery(13)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-13.webp" loading="lazy"></div>

            <div onclick="openGallery(14)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-14.webp" loading="lazy"></div>
            <div onclick="openGallery(16)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-16.webp" loading="lazy"></div>
            <div onclick="openGallery(15)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-15.webp" loading="lazy"></div>

            <div onclick="openGallery(18)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-18.webp" loading="lazy"></div>
            <div onclick="openGallery(17)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-17.webp" loading="lazy"></div>
            <div onclick="openGallery(12)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-12.webp" loading="lazy"></div>

            <div onclick="openGallery(35)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront.com©️35.png" loading="lazy"></div>
            <div onclick="openGallery(21)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-21.webp" loading="lazy"></div>
            <div onclick="openGallery(22)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-22.webp" loading="lazy"></div>

            <div onclick="openGallery(23)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-23.webp" loading="lazy"></div>
            <div onclick="openGallery(34)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront.com©️34.png" loading="lazy"></div>
            <div onclick="openGallery(25)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-25.webp" loading="lazy"></div>

            <div onclick="openGallery(26)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-26.webp" loading="lazy"></div>
            <div onclick="openGallery(28)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-28.webp" loading="lazy"></div>
            <div onclick="openGallery(27)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-27.webp" loading="lazy"></div>

            <div onclick="openGallery(29)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-29.webp" loading="lazy"></div>
            <div onclick="openGallery(30)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-30.webp" loading="lazy"></div>
            <div onclick="openGallery(31)" class="gallery-card"><img src="/public/img/©️SantaMartaBeachFront-compressed-31.webp" loading="lazy"></div>
        </div>

        <section class="mt-20 mb-20">
            <div class="bg-slate-100 dark:bg-white/5 rounded-[2rem] md:rounded-[2.5rem] p-6 md:p-14 flex flex-col md:flex-row items-center justify-between gap-8 md:gap-12 relative z-10">
                <div class="max-w-xl text-center md:text-left">
                    <h2 class="text-3xl md:text-5xl font-bold tracking-tighter mb-4" data-i18n="cta-title">¿Listo para vivir la experiencia?</h2>
                    <p class="text-slate-600 dark:text-slate-400 text-base md:text-lg" data-i18n="cta-desc">Reserva tu estancia en la Torre 4 de Reserva del Mar 1 y despierta frente al mar Caribe.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                    <a href="https://wa.me/573183813381" target="_blank" class="bg-primary text-white px-8 md:px-10 py-4 md:py-5 rounded-full font-bold uppercase tracking-widest text-[10px] md:text-xs hover:bg-blue-500 transition-all shadow-xl shadow-primary/20 text-center" data-i18n="btn-ws">Reservar por WhatsApp</a>
                    <a href="tel:+573183813381" class="bg-white/10 text-white px-8 md:px-10 py-4 md:py-5 rounded-full font-bold uppercase tracking-widest text-[10px] md:text-xs text-center" data-i18n="btn-call">Llamar ahora</a>
                </div>
            </div>
        </section>
    </main>

    <!-- footer -->
    <footer class="bg-[#101c22] text-white pt-10 pb-10 mt-[-2rem]" id="contacto">
        <div class="max-w-7xl mx-auto px-6 md:px-10">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-y-14 gap-x-10 xl:gap-x-16 py-16 items-start border-t border-white/5">

                <!-- LOGO -->
                <section class="lg:col-span-4 flex flex-col items-center md:items-start text-center md:text-left">
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

                <!-- CONTACTO -->
                <section class="lg:col-span-4 flex flex-col items-center md:items-start">
                    <h2 class="font-bold mb-8 text-white uppercase tracking-widest text-xs" data-i18n="footer-contact-title">
                        Información de Contacto
                    </h2>
                    <address class="not-italic">
                        <ul class="space-y-5 text-sm text-gray-300 text-center md:text-left">
                            <li>
                                <a href="mailto:17clouds@gmail.com" class="flex items-center justify-center md:justify-start gap-3 hover:text-blue-400 transition-colors">
                                    <span class="material-symbols-outlined text-blue-400">mail</span>
                                    17clouds@gmail.com
                                </a>
                            </li>
                            <li>
                                <a href="https://wa.me/573183813381" class="flex items-center justify-center md:justify-start gap-3 hover:text-blue-400 transition-colors">
                                    <span class="material-symbols-outlined text-blue-400">call</span>
                                    +57 318 3813381
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

                <!-- REDES SOCIALES -->
                <section class="lg:col-span-2 flex flex-col items-center lg:items-start">
                    <h2 class="font-bold mb-8 text-white uppercase tracking-wider text-xs" data-i18n="foo_social_title">
                        Síguenos
                    </h2>
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
                            <li>
                                <a class="w-12 h-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center hover:bg-[#ff0050] transition-all duration-300 group" href="#" target="_blank" rel="noopener" aria-label="TikTok">
                                    <i class="fa-brands fa-tiktok text-xl text-gray-300 group-hover:text-white"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </section>

                <!-- QR / RESEÑAS -->
                <section class="lg:col-span-2 flex flex-col items-center lg:items-start text-center lg:text-left">
                    <h2 class="font-bold mb-5 text-white uppercase tracking-wider text-xs" data-i18n="qr-title">
                        Comparte y califícanos
                    </h2>
                    <div class="bg-white p-3 rounded-2xl shadow-xl">
                        <div id="qrcode-footer"></div>
                    </div>
                    <p class="text-gray-300 text-xs leading-relaxed mt-4 max-w-[180px]">
                        <span data-i18n="qr-desc-1">Escanea el código QR para visitar nuestro perfil en Google y</span>
                        <span class="text-blue-400 font-semibold block mt-1" data-i18n="qr-desc-2">dejar tu reseña.</span>
                    </p>
                </section>

            </div>

            <!-- PARTE INFERIOR -->
            <aside class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-gray-800 text-xs text-gray-400 text-center gap-4">
                <p>
                    © <time id="current-year" datetime="2026">2026</time> Santamarta Beachfront.
                    <span data-i18n="foo_rights">Todos los derechos reservados.</span> |
                    <span data-i18n="foo_made_by">Hecho por</span>
                    <a href="https://richardcastiblanco.xyz/" target="_blank" rel="noopener noreferrer" class="font-bold hover:text-white">Richard Castiblanco</a>
                </p>

                <nav aria-label="Enlaces legales">
                    <ul class="flex flex-wrap justify-center gap-x-8 gap-y-3 list-none p-0">
                        <li>
                            <a class="hover:text-white transition-colors" href="/php/politica-terminos/politica-privacidad.php" data-i18n="foo_privacy">
                                Políticas de Privacidad
                            </a>
                        </li>
                        <li>
                            <a class="hover:text-white transition-colors" href="/php/politica-terminos/politica-privacidad.php" data-i18n="foo_terms">
                                Términos y Condiciones
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>

        </div>
    </footer>

    <!-- LIBRERÍA QR -->
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

    <!-- GENERACIÓN DEL QR -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const qrContainer = document.getElementById("qrcode-footer");
            if (qrContainer) {
                new QRCode(qrContainer, {
                    text: "https://share.google/7p47kpoNR6FN3WJRe",
                    width: 150,
                    height: 150,
                    colorDark: "#101c22",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
            }
        });
    </script>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('mobile-menu-icon');

            if (menu.classList.contains('hidden')) {
                // Abrir menú
                menu.classList.remove('hidden');
                setTimeout(() => {
                    menu.classList.remove('opacity-0', '-translate-y-2');
                    menu.classList.add('opacity-100', 'translate-y-0');
                }, 10);
                icon.textContent = 'close';
            } else {
                // Cerrar menú
                menu.classList.remove('opacity-100', 'translate-y-0');
                menu.classList.add('opacity-0', '-translate-y-2');
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 300);
                icon.textContent = 'menu';
            }
        }

        function selectMobileLang(lang) {
            changeLang(lang); // Reutiliza tu función original para cambiar de idioma
            toggleMobileMenu(); // Cierra el menú al seleccionar un idioma
        }
    </script>

    <!-- IMPORTACIÓN DE SCRIPT -->
    <script src="/js/galeria.js"></script>
</body>

</html>