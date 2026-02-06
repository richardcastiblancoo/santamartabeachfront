<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="keywords" content="reserva del mar 1, Santamartabeachfront, apartamentos, beachfront, mar, reserva, Santa Marta Colombia, Playa Salguero, El Rodadero, sur de Santa Marta, sector exclusivo Playa Salguero, edificios frente al mar, zona turística, cerca del Aeropuerto Santa Marta, salida directa al mar, zona residencial tranquila, renta vacacional Playa Salguero, condominios de lujo, alojamiento cerca de Arrecife, vista al mar Caribe, atardeceres en Santa Marta, vacaciones frente al océano, apartamentos modernos con vista, experiencia premium, despertar frente al mar, turismo de sol y playa Colombia, lujo asequible, confort y mar, piscina con vista al mar, edificio con jacuzzi y sauna, gimnasio frente al mar, zona BBQ, parqueadero privado, seguridad 24 horas, acceso privado a la playa,  salón social, zonas verdes, vigilancia permanente, apartamentos familiares, vacaciones con niños, alojamiento para grupos, apartamentos pet-friendly, cocina equipada, alojamiento seguro, alquiler por días, estancias largas, nómadas digitales, retiro de fin de semana, hospedaje para parejas, buceo Santa Marta, restaurantes Playa Salguero, vida nocturna El Rodadero,  Marina de Santa Marta, centro histórico, gastronomía costeña, guía turística, kayak, alquiler vacacional, Airbnb Santa Marta, Booking Reserva del Mar 1, apartamentos amoblados, renta por temporada, short term rentals, luxury rentals Colombia, best beachfront condos, holiday rentals, inmobiliaria Santa Marta, condominio Reserva del Mar 1, apartamentos turísticos, propiedad raíz, La Perla de América, playas de Santa Marta, Caribe Colombiano vacaciones, clima Santa Marta, playas tranquilas, Sierra Nevada de Santa Marta, experiencia caribeña auténtica, Reserva del Mar 1 Colombia">
    <meta name="author" content="Santamartabeachfront">
    <meta name="robots" content="index, follow">
    <meta name="description" content="Reserva del Mar 1: Apartamentos de lujo frente al mar en Playa Salguero, Santa Marta. Piscina infinita, acceso directo a la playa y confort total. ¡Reserva ya!">
    <title>Santamartabeachfront | Galería</title>
    <link rel="shortcut icon" href="/public/img/logo-definitivo.webp" type="image/x-icon">
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
        /* ---------------------------------- */
        body { font-family: "Plus Jakarta Sans", sans-serif; -webkit-font-smoothing: antialiased; }
        .media-overlay-subtle { background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 50%); }
        .glass-btn { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.2); }
        .video-cover { width: 100%; height: 100%; object-fit: cover; }
        .logo-container img { height: 80px; width: auto; object-fit: contain; }
        @media (min-width: 768px) {
            .logo-container img { height: 140px; transform: translateY(20px); }
            .brand-text { margin-left: -40px; margin-top: 10px; }
        }
        .modal-active { overflow: hidden; }
        .nav-modal-btn { @apply absolute top-1/2 -translate-y-1/2 text-white/50 hover:text-white text-7xl transition-all z-[120] px-4 cursor-pointer select-none hidden lg:block; }
        .flag-btn { @apply w-8 h-8 rounded-full overflow-hidden border-2 border-transparent hover:border-primary transition-all cursor-pointer shrink-0; }
        .flag-active { @apply border-primary scale-110; }
        
        @keyframes zoom { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        .animate-zoom { animation: zoom 0.3s ease-out forwards; }
        /* ---------------------------------- */
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
        background: #13a4ec; /* Blue primary color */
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
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white min-h-screen">

    <div id="gallery-modal" class="fixed inset-0 z-[100] hidden bg-black/95 backdrop-blur-md flex items-center justify-center p-2 md:p-4">
        <button onclick="closeModal()" class="absolute top-4 right-4 md:top-6 md:right-6 text-white/70 hover:text-white text-4xl md:text-5xl z-[130] transition-colors">&times;</button>
        <span onclick="prevMedia()" class="nav-modal-btn left-2">‹</span>
        <span onclick="nextMedia()" class="nav-modal-btn right-2">›</span>
        <div id="modal-content" class="w-full h-full flex items-center justify-center">
        </div>
    </div>

    <header class="sticky top-0 z-50 bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-xl border-b border-slate-200/60 dark:border-white/5">
        <div class="max-w-[1600px] mx-auto px-4 md:px-8 lg:px-12 flex items-center justify-between h-20">
            <a href="/" class="flex items-center group logo-container">
                <img src="/public/img/logo-definitivo.webp" alt="Logo">
                <h1 class="brand-text text-white text-sm md:text-lg font-black tracking-tighter uppercase hidden sm:inline-block">
                    Santamarta<span class="text-blue-400">beachfront</span>
                </h1>
            </a>

            <div class="flex items-center gap-4 md:gap-8">
                <a href="/" class="flex items-center gap-2 text-[10px] md:text-xs font-bold uppercase tracking-widest hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-lg">home</span>
                    <span data-i18n="nav-home">Inicio</span>
                </a>
                <div class="flex gap-2 md:gap-4 items-center border-l border-white/10 pl-4 md:pl-8">
                    <button onclick="changeLang('es')" id="btn-es" class="flag-btn flag-active">
                        <img src="https://flagcdn.com/w80/co.png" class="w-full h-full object-cover" alt="Colombia">
                    </button>
                    <button onclick="changeLang('en')" id="btn-en" class="flag-btn">
                        <img src="https://flagcdn.com/w80/us.png" class="w-full h-full object-cover" alt="USA">
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-[1500px] mx-auto px-4 md:px-8 lg:px-12 pt-8 md:pt-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 md:gap-8 items-stretch">
            <div class="lg:col-span-8 flex flex-col gap-4 md:gap-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8">
                    <div onclick="openGallery(0)" class="md:col-span-2 group relative overflow-hidden rounded-premium bg-slate-100 dark:bg-slate-900 aspect-[16/10] cursor-zoom-in shadow-2xl">
                        <img src="/public/img/©️SantaMartaBeachFront-compressed-1.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                    </div>
                    <div onclick="openGallery(1)" class="group relative overflow-hidden rounded-premium bg-slate-100 dark:bg-slate-900 aspect-square md:aspect-auto cursor-zoom-in shadow-lg">
                        <img src="/public/img/©️SantaMartaBeachFront-compressed-2.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-10 gap-4 md:gap-8">
                    <div onclick="openGallery(2)" class="md:col-span-6 group relative overflow-hidden rounded-premium bg-slate-100 dark:bg-slate-900 aspect-[16/9] cursor-zoom-in shadow-xl">
                        <img src="/public/img/©️SantaMartaBeachFront-compressed-3.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                    </div>
                    <div onclick="openGallery(3)" class="md:col-span-4 group relative overflow-hidden rounded-premium bg-slate-100 dark:bg-slate-900 aspect-[16/9] cursor-zoom-in shadow-xl">
                        <img src="/public/img/©️SantaMartaBeachFront-compressed-4.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 h-full">
                <div onclick="openGallery(4)" class="group relative w-full h-full min-h-[350px] lg:min-h-[600px] overflow-hidden rounded-premium bg-black shadow-2xl cursor-pointer">
                    <video class="video-cover transition-transform duration-1000 group-hover:scale-105" autoplay muted loop playsinline>
                        <source src="/public/video/video-reserva-del-mar.mp4" type="video/mp4">
                    </video>
                    <div class="absolute inset-0 media-overlay-subtle z-10 pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 p-6 md:p-10 w-full z-20">
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-2 tracking-tighter leading-none">
                            Reserva del Mar 1 <span class="block text-lg md:text-xl font-light text-white/90 mt-1">Torre 4</span>
                        </h3>
                        <p class="text-white/60 text-[10px] font-semibold uppercase tracking-[0.2em]" data-i18n="click-expand">Click para ampliar video</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 md:gap-4 mt-12 md:mt-16 auto-rows-[150px] md:auto-rows-[220px]">
            <div onclick="openGallery(5)" class="group relative overflow-hidden rounded-premium bg-slate-100 col-span-2 row-span-2 shadow-lg cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-5.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(6)" class="group relative overflow-hidden rounded-premium bg-slate-100 col-span-1 row-span-2 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-6.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(7)" class="group relative overflow-hidden rounded-premium bg-slate-100 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-7.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(8)" class="group relative overflow-hidden rounded-premium bg-slate-100 col-span-2 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-8.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(9)" class="group relative overflow-hidden rounded-premium bg-slate-100 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-9.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(10)" class="group relative overflow-hidden rounded-premium bg-slate-100 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-10.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(11)" class="group relative overflow-hidden rounded-premium bg-slate-100 col-span-2 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-11.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(12)" class="group relative overflow-hidden rounded-premium bg-slate-100 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-12.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(13)" class="group relative overflow-hidden rounded-premium bg-slate-100 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-13.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(14)" class="group relative overflow-hidden rounded-premium bg-slate-100 row-span-2 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-14.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(15)" class="group relative overflow-hidden rounded-premium bg-slate-100 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-15.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(16)" class="group relative overflow-hidden rounded-premium bg-slate-100 col-span-2 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-16.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(17)" class="group relative overflow-hidden rounded-premium bg-slate-100 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-17.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(18)" class="group relative overflow-hidden rounded-premium bg-slate-100 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-18.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(19)" class="group relative overflow-hidden rounded-premium bg-slate-100 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-19.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(20)" class="group relative overflow-hidden rounded-premium bg-slate-100 col-span-2 row-span-2 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-20.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(21)" class="group relative overflow-hidden rounded-premium bg-slate-100 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-21.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(22)" class="group relative overflow-hidden rounded-premium bg-slate-100 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-22.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(23)" class="group relative overflow-hidden rounded-premium bg-slate-100 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-23.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(24)" class="group relative overflow-hidden rounded-premium bg-slate-100 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-24.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
            <div onclick="openGallery(25)" class="group relative overflow-hidden rounded-premium bg-slate-100 shadow-md cursor-zoom-in"><img src="/public/img/©️SantaMartaBeachFront-compressed-25.webp" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
        </div>

        <section class="mt-16 md:mt-20">
            <div class="bg-slate-100 dark:bg-white/5 rounded-[2rem] md:rounded-[2.5rem] p-6 md:p-14 flex flex-col md:flex-row items-center justify-between gap-8 md:gap-12 relative z-10">
                <div class="max-w-xl text-center md:text-left">
                    <h2 class="text-3xl md:text-5xl font-bold tracking-tighter mb-4" data-i18n="cta-title">¿Listo para vivir la experiencia?</h2>
                    <p class="text-slate-600 dark:text-slate-400 text-base md:text-lg" data-i18n="cta-desc">Reserva tu estancia en la Torre 4 de Reserva del Mar 1 y despierta frente al mar Caribe.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                    <a href="https://wa.me/573183813381" target="_blank" class="bg-primary text-white px-8 md:px-10 py-4 md:py-5 rounded-full font-bold uppercase tracking-widest text-[10px] md:text-xs hover:bg-blue-500 transition-all shadow-xl shadow-primary/20 text-center" data-i18n="btn-wa">Reservar por WhatsApp</a>
                    <a href="tel:+573183813381" class="glass-btn dark:bg-white/10 text-slate-900 dark:text-white px-8 md:px-10 py-4 md:py-5 rounded-full font-bold uppercase tracking-widest text-[10px] md:text-xs text-center" data-i18n="btn-call">Llamar ahora</a>
                </div>
            </div>
        </section>
    </main>

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
            </aside>
        </div>
    </footer>

    <script>
        const mediaItems = [{
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-1.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-2.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-3.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-4.webp'
            },
            {
                type: 'video',
                src: '/public/video/video-reserva-del-mar.mp4'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-5.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-6.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-7.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-8.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-9.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-10.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-11.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-12.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-13.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-14.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-15.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-16.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-17.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-18.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-19.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-20.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-21.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-22.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-23.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-24.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-25.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-26.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-27.webp'
            },
            {
                type: 'image',
                src: '/public/img/©️SantaMartaBeachFront-compressed-28.webp'
            }
        ];

        let currentIndex = 0;

        function openGallery(index) {
            currentIndex = index;
            updateModal();
            document.getElementById('gallery-modal').classList.remove('hidden');
            document.body.classList.add('modal-active');
        }

        function updateModal() {
            const item = mediaItems[currentIndex];
            const content = document.getElementById('modal-content');
            content.innerHTML = item.type === 'image' ?
                `<img src="${item.src}" class="max-w-[95vw] max-h-[85vh] object-contain animate-zoom pointer-events-auto rounded-lg shadow-2xl">` :
                `<video controls autoplay class="max-w-[95vw] max-h-[80vh] pointer-events-auto rounded-lg shadow-2xl"><source src="${item.src}" type="video/mp4"></video>`;
        }

        function nextMedia() {
            currentIndex = (currentIndex + 1) % mediaItems.length;
            updateModal();
        }

        function prevMedia() {
            currentIndex = (currentIndex - 1 + mediaItems.length) % mediaItems.length;
            updateModal();
        }

        function closeModal() {
            document.getElementById('gallery-modal').classList.add('hidden');
            document.body.classList.remove('modal-active');
        }

        const translations = {
            es: {
                "nav-home": "Inicio",
                "click-expand": "Click para ampliar video",
                "cta-title": "¿Listo para vivir la experiencia?",
                "cta-desc": "Reserva tu estancia en la Torre 4 de Reserva del Mar 1 y despierta frente al mar Caribe.",
                "btn-wa": "Reservar por WhatsApp",
                "btn-call": "Llamar ahora",
                "footer-desc": "La plataforma líder en alquileres vacacionales de lujo en Santa Marta. Experiencias únicas, confort superior y las mejores vistas del Caribe colombiano.",
                "footer-contact-title": "Información de Contacto",
                "footer-follow": "Síguenos"
            },
            en: {
                "nav-home": "Home",
                "click-expand": "Click to expand video",
                "cta-title": "Ready for the experience?",
                "cta-desc": "Book your stay in Tower 4 of Reserva del Mar 1 and wake up facing the Caribbean Sea.",
                "btn-wa": "Book on WhatsApp",
                "btn-call": "Call now",
                "footer-desc": "The leading platform for luxury vacation rentals in Santa Marta. Unique experiences, superior comfort and the best views of the Colombian Caribbean.",
                "footer-contact-title": "Contact Information",
                "footer-follow": "Follow us"
            }
        };

        function changeLang(lang) {
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                el.innerText = translations[lang][key];
            });
            document.querySelectorAll('.flag-btn').forEach(btn => btn.classList.remove('flag-active'));
            document.getElementById(`btn-${lang}`).classList.add('flag-active');
        }

        // Navegación por teclado
        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape") closeModal();
            if (e.key === "ArrowRight") nextMedia();
            if (e.key === "ArrowLeft") prevMedia();
        });

        // Soporte para gestos táctiles (Swipe)
        let touchstartX = 0;
        let touchendX = 0;
        const modal = document.getElementById('gallery-modal');

        modal.addEventListener('touchstart', e => {
            touchstartX = e.changedTouches[0].screenX;
        }, {
            passive: true
        });

        modal.addEventListener('touchend', e => {
            touchendX = e.changedTouches[0].screenX;
            if (touchendX < touchstartX - 50) nextMedia();
            if (touchendX > touchstartX + 50) prevMedia();
        }, {
            passive: true
        });
    </script>
</body>

</html>