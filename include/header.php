<style>
    :root {
        scroll-behavior: auto;
    }

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
        background: #13a4ec;
        /* Blue primary color */
        border-radius: 0px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #0f8bc7;
    }


    /* --- COMPORTAMIENTO HEADER --- */
    #main-header {
        transition: background-color 0.4s ease;
        height: 100px;
        display: flex;
        align-items: center;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }

    @media (min-width: 769px) {
        #main-header {
            position: absolute;
            top: 0;
            background: transparent !important;
        }
    }

    @media (max-width: 768px) {
        #main-header {
            position: fixed;
            height: 80px;
            top: 0;
        }

        .header-scrolled-mobile {
            background: rgba(15, 23, 42, 0.98) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
    }

    /* --- LOGO 150PX Y TEXTO PEGADO --- */
    .logo-container img {
        height: 120px;
        width: auto;
        object-fit: contain;
        transform: translateY(20px);
    }

    .brand-text {
        margin-left: -25px;
        margin-top: 20px;
    }

    /* --- MENÚ FULL BLANCO --- */
    .nav-link {
        color: #FFFFFF !important;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        transition: opacity 0.3s ease;
    }

    .nav-link:hover {
        opacity: 0.8;
    }

    /* --- HERO Y OTROS --- */
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
    }

    #mobile-menu {
        transform: translateY(-100%);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #mobile-menu.active {
        transform: translateY(0);
    }

    .lang-dropdown {
        display: none;
    }

    .lang-dropdown.active {
        display: block;
    }

    /* NUEVO DISEÑO BOTÓN LOGIN (PARA EL INCLUDE) */
    .btn-login-premium {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-login-premium:hover {
        background: rgba(59, 130, 246, 0.1);
        border-color: rgba(59, 130, 246, 0.5);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -10px rgba(59, 130, 246, 0.3);
    }
</style>

<header id="main-header" class="left-0 w-full z-50 justify-between px-0 md:pr-10">
    <div class="flex items-center h-full">
        <a href="/" class="flex items-center group logo-container">
            <img src="/public/img/logo-def-Photoroom.png" alt="Logo" class="h-8 w-auto mr-2">
            <h1 class="brand-text text-white text-lg md:text-xl font-black tracking-tighter uppercase hidden md:inline-block">
                Santamarta<span class="bg-gradient-to-r from-blue-800 to-indigo-900 bg-clip-text text-transparent">
                    beachfront
                </span>
            </h1>
        </a>
    </div>

    <nav class="hidden md:flex items-center gap-8 h-full">
        <ul class="flex items-center gap-6 list-none">
            <li><a class="nav-link" href="/php/bienvenidosantamarta.php">¡Bienvenidos a Santa Marta!</a></li>
            <li><a class="nav-link" href="#apartamentos">Apartamento</a></li>
            <li><a class="nav-link" href="#ubicacion">Ubicación</a></li>
            <li><a class="nav-link" href="/php/gastronomia.php">Guía Gastronómica</a></li>
        </ul>

        <div class="flex items-center gap-4 border-l border-white/20 pl-6">
            <div class="relative">
                <button id="langBtn" onclick="toggleLang(event)" class="flex items-center gap-2 text-white text-[11px] font-bold uppercase tracking-widest h-9 px-3 rounded-lg hover:bg-white/10 transition-colors">
                    <img class="w-4 h-4 rounded-full object-cover" src="https://flagcdn.com/w40/co.png" alt="ES">
                    <span>ES</span>
                    <span class="material-symbols-outlined text-sm">expand_more</span>
                </button>
                <ul id="langMenu" class="lang-dropdown absolute top-full right-0 mt-1 w-32 bg-slate-900 border border-white/10 rounded-xl py-2 shadow-2xl">
                    <li><a href="index.php" class="block w-full text-left px-4 py-2 text-[11px] text-white font-bold hover:bg-blue-600">ESPAÑOL</a></li>
                    <li><a href="/lang/en/index.php" class="block w-full text-left px-4 py-2 text-[11px] text-white font-bold hover:bg-blue-600">ENGLISH</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <button onclick="toggleMobileMenu(true)" class="md:hidden text-white p-6">
        <span class="material-symbols-outlined text-3xl">menu</span>
    </button>
</header>

<div id="mobile-menu" class="fixed inset-0 bg-slate-950/98 backdrop-blur-xl z-[100] flex flex-col md:hidden">
    <div class="flex justify-between items-center p-6 border-b border-white/10">
        <div class="relative">
            <button onclick="toggleLangMobile(event)" class="flex items-center gap-2 text-white text-[11px] font-bold">
                <img class="w-4 h-4 rounded-full" src="https://flagcdn.com/w40/co.png" alt="ES"> ES
            </button>
            <ul id="langMenuMobile" class="lang-dropdown absolute left-0 mt-2 w-32 bg-slate-900 border border-white/10 rounded-xl py-2">
                <li><a href="index.php" class="block px-4 py-2 text-white text-[11px]">ESPAÑOL</a></li>
                <li><a href="/lang/en/index.php" class="block px-4 py-2 text-white text-[11px]">ENGLISH</a></li>
            </ul>
        </div>
        <button onclick="toggleMobileMenu(false)" class="text-white">
            <span class="material-symbols-outlined text-4xl">close</span>
        </button>
    </div>
    <nav class="flex flex-col items-center justify-center flex-grow gap-8 text-center">
        <a href="/php/bienvenidosantamarta.php" onclick="toggleMobileMenu(false)" class="text-white text-2xl font-black uppercase tracking-widest">¡Bienvenidos a Santa Marta!</a>
        <a href="#apartamentos" onclick="toggleMobileMenu(false)" class="text-white text-2xl font-black uppercase tracking-widest">Apartamento</a>
        <a href="#ubicacion" onclick="toggleMobileMenu(false)" class="text-white text-2xl font-black uppercase tracking-widest">Ubicación</a>
        <a href="/php/gastronomia.php" onclick="toggleMobileMenu(false)" class="text-white text-2xl font-black uppercase tracking-widest">Guía Gastronómica</a>
        <a href="/auth/login.php" class="mt-4 px-12 py-4 bg-blue-600 text-white rounded-full font-black uppercase tracking-widest">Inicio Sesión</a>
    </nav>
</div>

<main>
    <section class="relative w-full min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-black/20 z-10"></div>
            <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                <source src="/public/video/santamarta-video-tayrona.mp4" type="video/mp4">
            </video>
        </div>

        <div class="relative z-20 w-full max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center pt-24 pb-12">
            <div class="text-left">
                <h2 class="hero-title font-black text-white drop-shadow-xl text-3xl md:text-5xl">
                    Vive&nbsp;&nbsp;y&nbsp;&nbsp;<span class="text-amber-400">Disfruta</span> la experiencia en<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-800">
                        Santa Marta frente al mar
                    </span>
                </h2>
                <p class="text-white text-sm md:text-base mt-6 max-w-sm leading-relaxed drop-shadow-lg">
                    Exclusividad y Confort en los Mejores Apartamentos de la Costa Caribeña Colombiana.
                </p>
            </div>

            <div class="flex flex-col items-end gap-6">
                <div class="glass-booking w-full max-w-md p-8 rounded-3xl shadow-2xl">
                    <h3 class="text-white text-lg font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-400">event_available</span>
                        Reserva tu estancia
                    </h3>
                    <form id="reservaForm" class="space-y-4">
                        <div class="space-y-1">
                            <label class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">Nombre Completo</label>
                            <input id="full-name" type="text" placeholder="Tu nombre" class="glass-input w-full rounded-xl px-4 py-3 text-sm" required>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">WhatsApp</label>
                                <input id="whatsapp" type="tel" placeholder="+57..." class="glass-input w-full rounded-xl px-4 py-3 text-sm" required>
                            </div>
                            <div class="space-y-1">
                                <label class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">Correo</label>
                                <input id="email" type="email" placeholder="tu@email.com" class="glass-input w-full rounded-xl px-4 py-3 text-sm" required>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">Alojamiento</label>
                            <select id="accommodation" class="glass-input w-full rounded-xl px-4 py-3 text-sm bg-slate-800">
                                <option value="Reserva del Mar - Apartamento 1730">Apartamentos 1730 - Torre 4 - Reserva del Mar 1</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">Llegada | Salida</label>
                            <div class="relative">
                                <input id="date-range" type="text" placeholder="Selecciona las fechas" class="glass-input w-full rounded-xl px-4 py-3 text-sm cursor-pointer" readonly required>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-white/30 pointer-events-none">calendar_month</span>
                            </div>
                        </div>
                        <button type="submit" class="w-full h-14 bg-blue-600 hover:bg-blue-500 text-white font-black uppercase tracking-widest text-[11px] rounded-xl transition-all shadow-xl shadow-blue-600/30 mt-4">
                            Enviar a WhatsApp
                        </button>
                    </form>
                </div>

                <div class="w-full max-w-md">
                    <a href="/auth/login.php" class="btn-login-premium w-full h-12 rounded-2xl flex items-center justify-center gap-3 text-white/80 hover:text-white group">
                        <span class="material-symbols-outlined text-blue-400 group-hover:rotate-12 transition-transform">person</span>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em]">Inicio Sesión</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

<script>
    // Scroll Header effect
    window.addEventListener('scroll', function() {
        const header = document.getElementById('main-header');
        if (window.innerWidth <= 768) {
            if (window.scrollY > 40) {
                header.classList.add('header-scrolled-mobile');
            } else {
                header.classList.remove('header-scrolled-mobile');
            }
        }
    });

    // Datepicker init
    flatpickr("#date-range", {
        mode: "range",
        minDate: "today",
        dateFormat: "Y-m-d",
        locale: "es",
        showMonths: window.innerWidth > 900 ? 2 : 1,
        animate: true,
        disableMobile: "true"
    });

    // Language toggles
    function toggleLang(event) {
        event.stopPropagation();
        document.getElementById('langMenu').classList.toggle('active');
    }

    function toggleLangMobile(event) {
        event.stopPropagation();
        document.getElementById('langMenuMobile').classList.toggle('active');
    }

    document.addEventListener('click', function(e) {
        const menu = document.getElementById('langMenu');
        const menuMobile = document.getElementById('langMenuMobile');
        if (menu && !e.target.closest('#langBtn')) menu.classList.remove('active');
        if (menuMobile && !e.target.closest('#langMenuMobile')) menuMobile.classList.remove('active');
    });

    function toggleMobileMenu(open) {
        const menu = document.getElementById('mobile-menu');
        if (open) menu.classList.add('active');
        else menu.classList.remove('active');
    }

    // Form handler
    document.getElementById('reservaForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const nombre = document.getElementById('full-name').value;
        const tel = document.getElementById('whatsapp').value;
        const email = document.getElementById('email').value;
        const alojamiento = document.getElementById('accommodation').value;
        const fechas = document.getElementById('date-range').value;
        const telefonoVentas = "573183813381";
        const mensaje = `*Nueva Solicitud de Reserva*%0A---------------------------------%0A*Nombre:* ${nombre}%0A*WhatsApp:* ${tel}%0A*Correo:* ${email}%0A*Alojamiento:* ${alojamiento}%0A*Fechas:* ${fechas}%0A---------------------------------%0A¡Hola! Me gustaría confirmar disponibilidad.`;
        window.open(`https://wa.me/${telefonoVentas}?text=${mensaje}`, '_blank');
    });
</script>