<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Inicio de Sesión</title>
    <link rel="shortcut icon" href="/public/img/logo-portada.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
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
                },
            },
        }
    </script>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#111618] dark:text-white min-h-screen flex flex-col font-display antialiased overflow-x-hidden">

    <header class="fixed top-0 left-0 w-full z-50 flex items-center justify-between px-6 py-4 md:px-10">
        <a href="/" class="flex items-center gap-2">
            <img src="" class="h-10 w-auto" alt="">
            <span class="hidden sm:block font-bold text-lg tracking-tight text-[#111618] dark:text-white lg:text-white">Santamartabeachfront</span>
        </a>

        <div class="hidden md:flex items-center gap-4 bg-white/10 backdrop-blur-md p-1 rounded-xl border border-white/20 shadow-lg">
            <button onclick="changeLanguage('es')" id="btn-es" class="flex items-center gap-2 px-3 py-1.5 text-xs font-bold rounded-lg transition-all bg-primary text-white">
                <img src="https://flagcdn.com/w40/co.png" class="w-4 h-4 rounded-full object-cover" alt="ES"> ES
            </button>
            <button onclick="changeLanguage('en')" id="btn-en" class="flex items-center gap-2 px-3 py-1.5 text-xs font-bold rounded-lg transition-all text-gray-500 hover:bg-white/10">
                <img src="https://flagcdn.com/w40/us.png" class="w-4 h-4 rounded-full object-cover" alt="EN"> EN
            </button>
        </div>

        <button id="menuBtn" class="md:hidden p-2 text-primary bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <span id="menuIcon" class="material-symbols-outlined text-2xl">menu</span>
        </button>
    </header>

    <div id="mobileMenu" class="fixed inset-0 bg-black/95 z-40 hidden flex flex-col items-center justify-center gap-8 text-white md:hidden">
        <a href="/" class="text-xl font-bold hover:text-primary transition">Inicio</a>
        <div class="flex gap-4">
            <button onclick="changeLanguage('es')" class="flex flex-col items-center gap-2 group">
                <img src="https://flagcdn.com/w80/co.png" class="w-14 h-14 rounded-full border-2 border-transparent group-hover:border-primary transition" alt="ES">
                <span class="text-sm font-bold">ESPAÑOL</span>
            </button>
            <button onclick="changeLanguage('en')" class="flex flex-col items-center gap-2 group">
                <img src="https://flagcdn.com/w80/us.png" class="w-14 h-14 rounded-full border-2 border-transparent group-hover:border-primary transition" alt="EN">
                <span class="text-sm font-bold">ENGLISH</span>
            </button>
        </div>
        <button onclick="toggleMenu()" class="mt-8 px-6 py-2 border border-white/30 rounded-full text-sm">Cerrar</button>
    </div>

    <div class="flex flex-1 w-full min-h-screen">
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gray-200 dark:bg-gray-900">
            <img src="/public/img/torre-imagen.jpeg"
                alt="Santamartabeachfront View"
                class="absolute inset-0 w-full h-full object-cover">

            <div class="absolute inset-0 bg-gradient-to-t from-[#101c22]/90 via-[#101c22]/30 to-transparent"></div>

            <div class="relative z-10 flex flex-col justify-end p-16 h-full w-full max-w-[720px] mx-auto">
                <div class="mb-8">
                    <h1 data-key="hero-title" class="text-white text-5xl font-black leading-tight tracking-[-0.033em] mb-4">
                        Bienvenido al paraíso
                    </h1>
                    <p data-key="hero-desc" class="text-white/90 text-lg font-medium leading-relaxed max-w-md">
                        Gestiona tus reservas, planifica tus vacaciones o administra tus propiedades frente al mar en Santa Marta de forma segura.
                    </p>
                </div>

                <div class="flex items-center gap-4 py-4 px-6 bg-white/10 backdrop-blur-md rounded-2xl border border-white/10 w-fit text-white">
                    <div class="flex -space-x-2">
                        <div class="size-8 rounded-full bg-primary/40 border-2 border-white flex items-center justify-center text-[10px]">SB</div>
                        <div class="size-8 rounded-full bg-blue-400 border-2 border-white flex items-center justify-center text-[10px]">ST</div>
                    </div>
                    <span data-key="social-proof" class="text-sm font-bold">+100 Usuarios confían en nosotros</span>
                </div>
            </div>
        </div>

        <div class="flex w-full lg:w-1/2 flex-col justify-center items-center p-6 sm:p-12 lg:p-24 bg-white dark:bg-background-dark">
            <div class="w-full max-w-[480px] flex flex-col gap-8">
                <div class="flex flex-col gap-2">
                    <h2 data-key="form-title" class="text-3xl font-bold tracking-tight text-[#111618] dark:text-white">Acceso a la plataforma</h2>
                    <p data-key="form-subtitle" class="text-[#617c89] dark:text-gray-400">Ingresa tus datos para continuar explorando.</p>
                </div>

                <div class="flex border-b border-[#dbe2e6] dark:border-gray-700 w-full">
                    <a class="flex flex-1 items-center justify-center border-b-[3px] border-b-primary text-[#111618] dark:text-white pb-3 pt-2">
                        <p data-key="tab-login" class="text-sm font-bold leading-normal">Iniciar Sesión</p>
                    </a>
                    <a href="/auth/registro.php" class="flex flex-1 items-center justify-center border-b-[3px] border-b-transparent text-[#617c89] dark:text-gray-500 pb-3 pt-2 hover:text-primary transition-colors">
                        <p data-key="tab-register" class="text-sm font-bold leading-normal">Registrarse</p>
                    </a>
                </div>

                <form action="login_usuario_be.php" method="POST" class="flex flex-col gap-5">
                    <label class="flex flex-col gap-2">
                        <p data-key="label-user" class="text-sm font-bold text-[#111618] dark:text-white">Usuario</p>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#617c89] material-symbols-outlined">person</span>
                            <input name="usuario" class="form-input w-full rounded-xl border-[#dbe2e6] dark:border-gray-600 dark:bg-[#1a2c34] h-12 pl-11 focus:ring-primary" placeholder="Ej: JuanPerez" type="text" required />
                        </div>
                    </label>

                    <label class="flex flex-col gap-2">
                        <div class="flex justify-between">
                            <p data-key="label-pass" class="text-sm font-bold text-[#111618] dark:text-white">Contraseña</p>
                            <a data-key="forgot-pass" class="text-primary text-xs font-bold hover:underline" href="#">¿Olvidaste tu contraseña?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#617c89] material-symbols-outlined">lock</span>
                            <input name="password" class="form-input w-full rounded-xl border-[#dbe2e6] dark:border-gray-600 dark:bg-[#1a2c34] h-12 pl-11 focus:ring-primary" placeholder="••••••••" type="password" required />
                        </div>
                    </label>

                    <button class="w-full rounded-xl h-12 bg-primary text-white font-bold shadow-md hover:shadow-lg hover:bg-[#0f8bc7] transition-all">
                        <span data-key="btn-enter">Entrar</span>
                    </button>
                </form>

                <p class="text-center text-sm text-[#617c89] dark:text-gray-400">
                    <span data-key="no-account">¿No tienes una cuenta?</span> <a data-key="link-register" class="text-primary font-bold hover:underline" href="/auth/registro.php">Regístrate aquí</a>
                </p>
            </div>
        </div>
    </div>

    <script src="/public/dist/login.js"></script>
</body>

</html>
