<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Login</title>
    <link rel="shortcut icon" href="/public/img/logo-def-Photoroom.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13a4ec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101c22"
                    },

                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                },
            },
        }
    </script>

    <style>
        .side-logo img {
            height: 120px;
            width: auto;
            object-fit: contain;
            transform: translateY(15px);
        }

        .side-brand-text {
            margin-left: -15px;
            margin-top: 10px;
        }

        .lang-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

</head>

<body class="bg-background-light dark:bg-background-dark text-[#111618] dark:text-white min-h-screen flex flex-col font-display antialiased overflow-x-hidden">
    <header class="fixed top-0 left-0 w-full z-50 flex items-center justify-end px-6 py-4 md:px-10">
        <!-- Menú Escritorio -->
        <div class="hidden md:block relative">
            <button
                onclick="toggleLangHeaderDesktop(event)"
                id="langBtnDesktop"
                class="flex items-center gap-2 bg-white/10 backdrop-blur-md px-3 py-2 rounded-xl border border-white/20 shadow-lg text-white text-xs font-bold hover:bg-white/20 transition-all">
                <svg class="w-4 h-4 rounded-full object-cover flex-shrink-0" viewBox="0 0 900 600">
                    <rect width="900" height="300" fill="#FCD116" />
                    <rect width="900" height="150" y="300" fill="#003893" />
                    <rect width="900" height="150" y="450" fill="#CE1126" />
                </svg>
                <span id="currentLangDesktopText">ES</span>
                <span class="material-symbols-outlined text-sm">
                    expand_more
                </span>
            </button>
            <ul
                id="langMenuDesktop"
                class="hidden absolute right-0 mt-2 w-40 bg-slate-900/95 backdrop-blur-xl border border-white/10 rounded-xl py-2 shadow-2xl z-50">
                <li>
                    <button
                        onclick="selectLanguage('es')"
                        class="flex items-center gap-2.5 w-full text-left px-4 py-2 text-[11px] text-white font-bold hover:bg-blue-600 transition-colors">
                        <svg class="w-4 h-4 rounded-full object-cover flex-shrink-0" viewBox="0 0 900 600">
                            <rect width="900" height="300" fill="#FCD116" />
                            <rect width="900" height="150" y="300" fill="#003893" />
                            <rect width="900" height="150" y="450" fill="#CE1126" />
                        </svg>
                        <span>ESPAÑOL</span>
                    </button>
                </li>
                <li>
                    <button
                        onclick="selectLanguage('en')"
                        class="flex items-center gap-2.5 w-full text-left px-4 py-2 text-[11px] text-white font-bold hover:bg-blue-600 transition-colors">
                        <svg class="w-4 h-4 rounded-full object-cover flex-shrink-0" viewBox="0 0 741 390">
                            <rect width="741" height="390" fill="#b22234" />
                            <path d="M0 30h741M0 90h741M0 150h741M0 210h741M0 270h741M0 330h741" stroke="#fff" stroke-width="30" />
                            <rect width="296.4" height="210" fill="#3c3b6e" />
                        </svg>
                        <span>ENGLISH</span>
                    </button>
                </li>
                <li>
                    <button
                        onclick="selectLanguage('fr')"
                        class="flex items-center gap-2.5 w-full text-left px-4 py-2 text-[11px] text-white font-bold hover:bg-blue-600 transition-colors">
                        <svg class="w-4 h-4 rounded-full object-cover flex-shrink-0" viewBox="0 0 3 2">
                            <rect width="1" height="2" fill="#002395" />
                            <rect width="1" height="2" x="1" fill="#fff" />
                            <rect width="1" height="2" x="2" fill="#ed2939" />
                        </svg>
                        <span>FRANÇAIS</span>
                    </button>
                </li>
                <li>
                    <button
                        onclick="selectLanguage('it')"
                        class="flex items-center gap-2.5 w-full text-left px-4 py-2 text-[11px] text-white font-bold hover:bg-blue-600 transition-colors">
                        <svg class="w-4 h-4 rounded-full object-cover flex-shrink-0" viewBox="0 0 3 2">
                            <rect width="1" height="2" fill="#009246" />
                            <rect width="1" height="2" x="1" fill="#fff" />
                            <rect width="1" height="2" x="2" fill="#ce2b37" />
                        </svg>
                        <span>ITALIANO</span>
                    </button>
                </li>
                <li>
                    <!-- OPCIÓN PORTUGUÊS CORREGIDA CON BANDERA DE PORTUGAL -->
                    <button
                        onclick="selectLanguage('pt')"
                        class="flex items-center gap-2.5 w-full text-left px-4 py-2 text-[11px] text-white font-bold hover:bg-blue-600 transition-colors">
                        <svg class="w-4 h-4 rounded-full object-cover flex-shrink-0" viewBox="0 0 600 400">
                            <rect width="240" height="400" fill="#046A38" />
                            <rect width="360" height="400" x="240" fill="#DA291C" />
                            <circle cx="240" cy="200" r="70" fill="#F2C94C" />
                            <rect width="50" height="60" x="215" y="170" fill="#FFFFFF" rx="3" />
                            <path d="M215 210 Q240 240 265 210 Z" fill="#FFFFFF" />
                            <rect width="50" height="60" x="215" y="170" fill="none" stroke="#DA291C" stroke-width="8" rx="3" />
                        </svg>
                        <span>PORTUGUÊS</span>
                    </button>
                </li>
            </ul>
        </div>

        <button
            id="menuBtn"
            onclick="toggleMenu()"
            class="md:hidden p-2 text-primary bg-white dark:bg-gray-800 rounded-lg shadow-md z-[60]">
            <span id="menuIcon" class="material-symbols-outlined text-2xl">
                menu
            </span>
        </button>
    </header>

    <!-- Menú Móvil -->
    <div
        id="mobileMenu"
        class="fixed inset-0 bg-black/95 z-50 hidden flex flex-col items-center justify-center gap-8 text-white md:hidden backdrop-blur-lg">
        <a href="/" data-key="nav-home" class="text-2xl font-bold hover:text-primary transition">
            Inicio
        </a>
        <div class="flex flex-col items-center gap-4 w-full px-10">
            <hr class="w-full border-white/10 mb-2">
            <p class="text-xs font-bold tracking-widest text-white/50 uppercase">
                Seleccionar Idioma
            </p>
            <div class="relative w-full max-w-[200px]">
                <button
                    onclick="toggleLangHeaderMobile(event)"
                    id="langBtnMobileHeader"
                    class="flex items-center justify-between w-full bg-white/5 border border-white/20 px-4 py-3 rounded-2xl text-white font-bold text-sm">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 rounded-full object-cover flex-shrink-0" viewBox="0 0 900 600">
                            <rect width="900" height="300" fill="#FCD116" />
                            <rect width="900" height="150" y="300" fill="#003893" />
                            <rect width="900" height="150" y="450" fill="#CE1126" />
                        </svg>
                        <span>ESPAÑOL</span>
                    </div>
                    <span class="material-symbols-outlined">
                        expand_more
                    </span>
                </button>
                <ul
                    id="langMenuMobileHeader"
                    class="hidden absolute left-0 right-0 mt-2 bg-slate-900/98 border border-white/10 rounded-2xl py-2 shadow-2xl z-50">
                    <li>
                        <button
                            onclick="selectLanguage('es')"
                            class="flex items-center gap-2.5 w-full text-left px-4 py-2.5 text-xs text-white font-bold hover:bg-blue-600 transition-colors">
                            <svg class="w-5 h-5 rounded-full object-cover flex-shrink-0" viewBox="0 0 900 600">
                                <rect width="900" height="300" fill="#FCD116" />
                                <rect width="900" height="150" y="300" fill="#003893" />
                                <rect width="900" height="150" y="450" fill="#CE1126" />
                            </svg>
                            <span>ESPAÑOL</span>
                        </button>
                    </li>
                    <li>
                        <button
                            onclick="selectLanguage('en')"
                            class="flex items-center gap-2.5 w-full text-left px-4 py-2.5 text-xs text-white font-bold hover:bg-blue-600 transition-colors">
                            <svg class="w-5 h-5 rounded-full object-cover flex-shrink-0" viewBox="0 0 741 390">
                                <rect width="741" height="390" fill="#b22234" />
                                <path d="M0 30h741M0 90h741M0 150h741M0 210h741M0 270h741M0 330h741" stroke="#fff" stroke-width="30" />
                                <rect width="296.4" height="210" fill="#3c3b6e" />
                            </svg>
                            <span>ENGLISH</span>
                        </button>
                    </li>
                    <li>
                        <button
                            onclick="selectLanguage('fr')"
                            class="flex items-center gap-2.5 w-full text-left px-4 py-2.5 text-xs text-white font-bold hover:bg-blue-600 transition-colors">
                            <svg class="w-5 h-5 rounded-full object-cover flex-shrink-0" viewBox="0 0 3 2">
                                <rect width="1" height="2" fill="#002395" />
                                <rect width="1" height="2" x="1" fill="#fff" />
                                <rect width="1" height="2" x="2" fill="#ed2939" />
                            </svg>
                            <span>FRANÇAIS</span>
                        </button>
                    </li>
                    <li>
                        <button
                            onclick="selectLanguage('it')"
                            class="flex items-center gap-2.5 w-full text-left px-4 py-2.5 text-xs text-white font-bold hover:bg-blue-600 transition-colors">
                            <svg class="w-5 h-5 rounded-full object-cover flex-shrink-0" viewBox="0 0 3 2">
                                <rect width="1" height="2" fill="#009246" />
                                <rect width="1" height="2" x="1" fill="#fff" />
                                <rect width="1" height="2" x="2" fill="#ce2b37" />
                            </svg>
                            <span>ITALIANO</span>
                        </button>
                    </li>
                    <li>
                        <!-- OPCIÓN PORTUGUÊS MÓVIL CORREGIDA -->
                        <button
                            onclick="selectLanguage('pt')"
                            class="flex items-center gap-2.5 w-full text-left px-4 py-2.5 text-xs text-white font-bold hover:bg-blue-600 transition-colors">
                            <svg class="w-5 h-5 rounded-full object-cover flex-shrink-0" viewBox="0 0 600 400">
                                <rect width="240" height="400" fill="#046A38" />
                                <rect width="360" height="400" x="240" fill="#DA291C" />
                                <circle cx="240" cy="200" r="70" fill="#F2C94C" />
                                <rect width="50" height="60" x="215" y="170" fill="#FFFFFF" rx="3" />
                                <path d="M215 210 Q240 240 265 210 Z" fill="#FFFFFF" />
                                <rect width="50" height="60" x="215" y="170" fill="none" stroke="#DA291C" stroke-width="8" rx="3" />
                            </svg>
                            <span>PORTUGUÊS</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <button
            onclick="toggleMenu()"
            class="mt-4 px-8 py-2 border border-white/30 rounded-full text-sm font-bold hover:bg-white/10 transition-all">
            <span data-key="btn-close">
                Cerrar
            </span>
        </button>
    </div>
    <div class="flex flex-1 w-full min-h-screen">
        <div
            class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gray-200 dark:bg-gray-900">
            <img
                src="/public/img/portada-reserva.webp"
                alt="Santamartabeachfront View"
                class="absolute inset-0 w-full h-full object-cover opacity-60">
            <div
                class="absolute inset-0 bg-gradient-to-t from-[#101c22] via-[#101c22]/20 to-transparent">
            </div>
            <a
                href="/"
                class="absolute top-10 left-10 z-20 flex items-center side-logo">
                <img
                    src="/public/img/logo-def-Photoroom.png"
                    alt="Logo">
                <h1
                    class="side-brand-text text-white text-xl font-black tracking-tighter uppercase">
                    Santamarta<span class="text-[#0369a1]">beachfront</span>
                </h1>
            </a>
            <div
                class="relative z-10 flex flex-col justify-end p-16 h-full w-full max-w-[720px] mx-auto">
                <div class="mb-8">
                    <h1
                        data-key="hero-title"
                        class="text-white text-5xl font-black leading-tight tracking-[-0.033em] mb-4">
                        Bienvenido al paraíso
                    </h1>
                    <p
                        data-key="hero-desc"
                        class="text-white/90 text-lg font-medium leading-relaxed max-w-md">
                        Gestiona tus reservas, planifica tus vacaciones o administra tus propiedades frente al mar en Santa Marta de forma segura.
                    </p>
                </div>
                <div
                    class="flex items-center gap-4 py-4 px-6 bg-white/10 backdrop-blur-md rounded-2xl border border-white/10 w-fit text-white">
                    <div class="flex -space-x-2">
                        <div
                            class="size-8 rounded-full bg-primary/40 border-2 border-white flex items-center justify-center text-[10px]">
                            SB
                        </div>
                        <div
                            class="size-8 rounded-full bg-blue-400 border-2 border-white flex items-center justify-center text-[10px]">
                            ST
                        </div>
                    </div>
                    <span
                        data-key="social-proof"
                        class="text-sm font-bold">
                        +100 Usuarios confían en nosotros
                    </span>
                </div>
            </div>
        </div>
        <div
            class="flex w-full lg:w-1/2 flex-col justify-center items-center p-6 sm:p-12 lg:p-24 bg-white dark:bg-background-dark">
            <div
                class="w-full max-w-[480px] flex flex-col gap-8">
                <div class="flex flex-col gap-2">
                    <h2
                        data-key="form-title"
                        class="text-3xl font-bold tracking-tight text-[#111618] dark:text-white">
                        Acceso a la plataforma de Huéspedes
                    </h2>
                    <p
                        data-key="form-subtitle"
                        class="text-[#617c89] dark:text-gray-400">
                        Ingresa tus datos para continuar explorando.
                    </p>
                </div>
                <div
                    class="flex border-b border-[#dbe2e6] dark:border-gray-700 w-full">
                    <a
                        class="flex flex-1 items-center justify-center border-b-[3px] border-b-primary text-[#111618] dark:text-white pb-3 pt-2 cursor-pointer">
                        <p
                            data-key="tab-login"
                            class="text-sm font-bold leading-normal">
                            Iniciar Sesión
                        </p>
                    </a>
                    <a
                        href="/auth/registro.php"
                        class="flex flex-1 items-center justify-center border-b-[3px] border-b-transparent text-[#617c89] dark:text-gray-500 pb-3 pt-2 hover:text-primary transition-colors">
                        <p
                            data-key="tab-register"
                            class="text-sm font-bold leading-normal">
                            Registrarse
                        </p>
                    </a>
                </div>
                <form
                    action="login_usuario_be.php"
                    method="POST"
                    class="flex flex-col gap-5">
                    <label class="flex flex-col gap-2">
                        <p
                            data-key="label-user"
                            class="text-sm font-bold text-[#111618] dark:text-white">
                            Usuario
                        </p>
                        <div class="relative">
                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-[#617c89] material-symbols-outlined">
                                person
                            </span>
                            <input
                                name="usuario"
                                data-key="placeholder-user"
                                class="form-input w-full rounded-xl border-[#dbe2e6] dark:border-gray-600 dark:bg-[#1a2c34] h-12 pl-11 focus:ring-primary dark:text-white"
                                placeholder="Ej: JuanPerez"
                                type="text"
                                required />
                        </div>
                    </label>
                    <label class="flex flex-col gap-2">
                        <div class="flex justify-between">
                            <p
                                data-key="label-pass"
                                class="text-sm font-bold text-[#111618] dark:text-white">
                                Contraseña
                            </p>
                        </div>
                        <div class="relative">
                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-[#617c89] material-symbols-outlined">
                                lock
                            </span>
                            <input
                                id="passwordInput"
                                name="password"
                                data-key="placeholder-pass"
                                class="form-input w-full rounded-xl border-[#dbe2e6] dark:border-gray-600 dark:bg-[#1a2c34] h-12 pl-11 pr-12 focus:ring-primary dark:text-white"
                                placeholder="••••••••"
                                type="password"
                                required />
                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#617c89] hover:text-primary transition-colors"
                                aria-label="Mostrar contraseña">
                                <span
                                    id="passwordIcon"
                                    class="material-symbols-outlined">
                                    visibility
                                </span>
                            </button>
                        </div>
                    </label>

                    <!-- Widget de Cloudflare Turnstile integrado dentro del formulario -->
                    <!-- Widget de Cloudflare Turnstile en modo interactivo manual -->
                    <div class="cf-turnstile" data-sitekey="0x4AAAAAADOhGMjKIxGqA8YD" data-theme="dark"></div>

                    <button
                        type="submit"
                        class="w-full rounded-xl h-12 bg-primary text-white font-bold shadow-md hover:shadow-lg hover:bg-[#0f8bc7] transition-all">
                        <span data-key="btn-enter">
                            Entrar
                        </span>
                    </button>
                </form>

                <p
                    class="text-center text-sm text-[#617c89] dark:text-gray-400">
                    <span data-key="no-account">
                        ¿No tienes una cuenta?
                    </span>
                    <a
                        data-key="link-register"
                        class="text-primary font-bold hover:underline"
                        href="/auth/registro.php">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script src="/js/login.js"></script>

    <script>
        function toggleLangHeaderDesktop(e) {
            e.stopPropagation();
            document
                .getElementById('langMenuDesktop')
                .classList
                .toggle('hidden');
        }

        function toggleLangHeaderMobile(e) {
            e.stopPropagation();
            document
                .getElementById('langMenuMobileHeader')
                .classList
                .toggle('hidden');
        }

        function selectLanguage(lang) {
            document
                .getElementById('langMenuDesktop')
                ?.classList
                .add('hidden');
            document
                .getElementById('langMenuMobileHeader')
                ?.classList
                .add('hidden');
            if (typeof changeLanguage === 'function') {
                changeLanguage(lang);
            }
        }
        window.addEventListener('click', () => {
            document
                .getElementById('langMenuDesktop')
                ?.classList
                .add('hidden');
            document
                .getElementById('langMenuMobileHeader')
                ?.classList
                .add('hidden');
        });

        function togglePassword() {
            const passwordInput =
                document.getElementById('passwordInput');
            const passwordIcon =
                document.getElementById('passwordIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                passwordIcon.textContent = 'visibility';

            }
        }
    </script>
</body>

</html>