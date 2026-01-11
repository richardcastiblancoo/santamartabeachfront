<header class="absolute top-0 left-0 w-full z-50 flex items-center justify-between whitespace-nowrap px-6 py-6 md:px-10 transition-all duration-300">
    <div class="flex items-center gap-4 text-white">
        <div class="size-8 text-primary">
            <span class="material-symbols-outlined text-3xl font-variation-fill">apartment</span>
        </div>
        <h2 class="text-white text-xl font-bold leading-tight tracking-[-0.015em] whitespace-nowrap">
            Santamartabeachfront
        </h2>
    </div>

    <div class="hidden md:flex flex-1 justify-end gap-8">
        <div class="flex items-center gap-9">
            <a class="text-white text-sm font-medium hover:text-primary transition-colors" href="#apartamentos">Apartamentos</a>
            <a class="text-white text-sm font-medium hover:text-primary transition-colors" href="#ubicacion">Ubicación</a>
            <a class="text-white text-sm font-medium hover:text-primary transition-colors" href="#nosotros">Nosotros</a>
            <a class="text-white text-sm font-medium hover:text-primary transition-colors" href="#contacto">Contacto</a>
        </div>

        <div class="flex items-center gap-6 border-l border-white/30 pl-6">
            <div class="relative lang-dropdown">
                <button class="flex items-center gap-2 text-white text-sm font-medium h-10 px-3 rounded-lg hover:bg-white/10 transition-colors">
                    <span id="currentLang">ES</span>
                    <span class="material-symbols-outlined text-sm">expand_more</span>
                </button>
                <div class="lang-menu hidden absolute top-full right-0 mt-2 w-40 bg-white rounded-xl shadow-2xl py-2 z-[60]">
                    <a href="#" data-lang="ES" class="block px-4 py-2 hover:bg-gray-100 text-sm">Español</a>
                    <a href="#" data-lang="EN" class="block px-4 py-2 hover:bg-gray-100 text-sm">English</a>
                </div>
            </div>
            <a href="/auth/login.php" class="flex items-center justify-center h-10 px-7 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90 transition-all duration-300 shadow-lg hover:shadow-primary/30">
                Iniciar sesión
            </a>
        </div>
    </div>

    <button id="menuBtn" class="md:hidden text-white">
        <span class="material-symbols-outlined text-3xl">menu</span>
    </button>
</header>

<div id="mobileMenu" class="fixed inset-0 bg-black/95 z-40 hidden flex-col items-center justify-center gap-8 text-white text-xl md:hidden">
    <a href="#apartamentos" onclick="closeMobile()">Apartamentos</a>
    <a href="#ubicacion" onclick="closeMobile()">Ubicación</a>
    <a href="#nosotros" onclick="closeMobile()">Nosotros</a>
    <a href="#contacto" onclick="closeMobile()">Contacto</a>
    <div class="flex gap-6 mt-6">
        <button onclick="setLang('ES')" class="border px-5 py-2 rounded-lg">ES</button>
        <button onclick="setLang('EN')" class="border px-5 py-2 rounded-lg">EN</button>
    </div>
    <a href="/php/login.php" class="mt-8 px-8 py-3 bg-primary rounded-xl font-bold text-white hover:bg-primary/90 transition">
        Iniciar sesión
    </a>
</div>

<section class="relative w-full h-screen flex items-center justify-center overflow-hidden bg-gray-900">
    <div class="absolute inset-0 z-0">
       <video class="w-full h-full object-cover" autoplay muted loop playsinline>
            <source src="/public/video/santamarta-video-tayrona.mp4" type="video/mp4">
        </video>
    </div>

    <div class="relative z-10 flex flex-col items-center gap-8 text-center px-4 max-w-5xl mx-auto pt-20">
        <h1 class="text-white text-5xl md:text-7xl lg:text-8xl font-black leading-tight tracking-tight">
            Vive la experiencia en<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-cyan-300 animate-back-and-forth inline-block">
               Santa marta frente al mar
            </span>
        </h1>

        <p class="text-white/95 text-lg md:text-2xl font-medium max-w-3xl">
            Los mejores apartamentos en Santamartabeachfront te esperan.
            Despierta con el sonido de las olas.
        </p>

        <div class="flex flex-col sm:flex-row gap-5 w-full justify-center pt-6">
            <a href="#apartamentos" class="flex items-center justify-center h-14 min-w-[180px] bg-primary hover:bg-primary/90 text-white font-bold text-lg rounded-xl px-8">
                Visualizar
            </a>
            <a href="#contacto" class="flex items-center justify-center h-14 min-w-[180px] bg-white/10 border border-white/80 hover:bg-white hover:text-primary text-white font-bold text-lg rounded-xl px-8 transition">
                Contactar
            </a>
        </div>
    </div>
</section>


<!-- ================= SCRIPT ================= -->
<script>
    const langBtn = document.querySelector(".lang-dropdown button");
    const langMenu = document.querySelector(".lang-menu");
    const currentLang = document.getElementById("currentLang");
    const menuBtn = document.getElementById("menuBtn");
    const mobileMenu = document.getElementById("mobileMenu");

    const savedLang = localStorage.getItem("lang") || "ES";
    currentLang.textContent = savedLang;

    langBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        langMenu.classList.toggle("hidden");
    });

    document.querySelectorAll(".lang-menu a").forEach((item) => {
        item.addEventListener("click", (e) => {
            e.preventDefault();
            setLang(item.dataset.lang);
            langMenu.classList.add("hidden");
        });
    });

    function setLang(lang) {
        localStorage.setItem("lang", lang);
        currentLang.textContent = lang;
        mobileMenu.classList.add("hidden");
    }

    menuBtn.addEventListener("click", () => {
        mobileMenu.classList.toggle("hidden");
    });

    function closeMobile() {
        mobileMenu.classList.add("hidden");
    }

    document.addEventListener("click", () => {
        langMenu.classList.add("hidden");
    });


    //para el idioma
    function setLang(lang) {
        if (lang === 'EN') {
            // Redirige a la carpeta de inglés
            window.location.href = '/en/index.php';
        } else {
            // Redirige a la raíz o carpeta de español
            window.location.href = '/index.php';
        }
    }
    
</script>

