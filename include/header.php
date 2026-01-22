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