<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Registro de Usuario</title>
    <link rel="shortcut icon" href="/public/img/logo-definitivo.webp" type="image/x-icon">
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

    <style>
        /* Ajuste para que el logo se vea bien sobre la imagen */
        .side-logo img {
            height: 140px;
            width: auto;
            object-fit: contain;
            transform: translateY(15px);
        }

        .side-brand-text {
            margin-left: -35px;
            margin-top: 10px;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#111618] dark:text-white min-h-screen flex flex-col font-display antialiased overflow-x-hidden">

    <header class="fixed top-0 left-0 w-full z-50 flex items-center justify-end px-6 py-4 md:px-10">
        <div class="hidden md:flex items-center gap-4 bg-white/10 backdrop-blur-md p-1 rounded-xl border border-white/20 shadow-lg">
            <button onclick="changeLanguage('es')" id="btn-es" class="flex items-center gap-2 px-3 py-1.5 text-xs font-bold rounded-lg transition-all">
                <img src="https://flagcdn.com/w40/co.png" class="w-4 h-4 rounded-full object-cover" alt="ES"> ES
            </button>
            <button onclick="changeLanguage('en')" id="btn-en" class="flex items-center gap-2 px-3 py-1.5 text-xs font-bold rounded-lg transition-all">
                <img src="https://flagcdn.com/w40/us.png" class="w-4 h-4 rounded-full object-cover" alt="EN"> EN
            </button>
        </div>

        <button id="menuBtn" class="md:hidden p-2 text-primary bg-white dark:bg-gray-800 rounded-lg shadow-md z-[60]">
            <span id="menuIcon" class="material-symbols-outlined text-2xl">menu</span>
        </button>
    </header>

    <div class="flex flex-1 w-full min-h-screen">
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gray-900">
            <img src="/public/img/portada-reserva.webp" alt="Santamartabeachfront" class="absolute inset-0 w-full h-full object-cover opacity-60">

            <div class="absolute inset-0 bg-gradient-to-t from-[#101c22] via-[#101c22]/30 to-transparent"></div>

            <div class="absolute top-10 left-10 z-20 flex items-center side-logo">
                <img src="/public/img/logo-definitivo.webp" alt="Logo">
                <h1 class="side-brand-text text-white text-xl font-black tracking-tighter uppercase">
                    Santamarta<span class="text-[#0369a1]">beachfront</span>
                </h1>
            </div>

            <div class="relative z-10 flex flex-col justify-end p-16 h-full w-full max-w-[720px] mx-auto">
                <div class="mb-8">
                    <h1 data-key="hero-title" class="text-white text-5xl font-black leading-tight tracking-[-0.033em] mb-4">Bienvenido al paraíso</h1>
                    <p data-key="hero-desc" class="text-white/90 text-lg font-medium leading-relaxed max-w-md">
                        Gestiona tus reservas, planifica tus vacaciones o administra tus propiedades frente al mar en Santa Marta de forma segura.
                    </p>
                </div>
                <div class="flex items-center gap-4 py-4 px-6 bg-white/10 backdrop-blur-md rounded-2xl border border-white/10 w-fit text-white">
                    <span data-key="social-proof" class="text-sm font-bold">+100 Usuarios confían en nosotros</span>
                </div>
            </div>
        </div>

        <div class="flex w-full lg:w-1/2 flex-col justify-center items-center p-6 sm:p-12 lg:p-24 bg-white dark:bg-background-dark pt-24 md:pt-12">
            <div class="w-full max-w-[480px] flex flex-col gap-6">
                <div class="flex flex-col gap-2">
                    <h2 data-key="reg-title" class="text-3xl font-bold tracking-tight text-[#111618] dark:text-white">Crea tu cuenta</h2>
                    <p data-key="reg-subtitle" class="text-[#617c89] dark:text-gray-400">Únete a nuestra comunidad para empezar.</p>
                </div>

                <div class="flex border-b border-[#dbe2e6] dark:border-gray-700 w-full">
                    <a href="login.php" class="flex flex-1 items-center justify-center border-b-[3px] border-b-transparent pb-3 pt-2 text-[#617c89] dark:text-gray-500 hover:text-primary transition-colors">
                        <p data-key="tab-login" class="text-sm font-bold leading-normal">Iniciar Sesión</p>
                    </a>
                    <a class="flex flex-1 items-center justify-center border-b-[3px] border-b-primary text-[#111618] dark:text-white pb-3 pt-2">
                        <p data-key="tab-register" class="text-sm font-bold leading-normal">Registrarse</p>
                    </a>
                </div>

                <form action="registro_usuario_be.php" method="POST" class="flex flex-col gap-4">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <label class="flex flex-col flex-1 gap-2">
                            <p data-key="label-name" class="text-sm font-bold text-[#111618] dark:text-white">Nombre</p>
                            <input name="nombre" class="form-input w-full rounded-xl border-[#dbe2e6] dark:border-gray-600 dark:bg-[#1a2c34] h-12 px-4 focus:ring-primary" placeholder="Juan" type="text" required />
                        </label>
                        <label class="flex flex-col flex-1 gap-2">
                            <p data-key="label-lastname" class="text-sm font-bold text-[#111618] dark:text-white">Apellido</p>
                            <input name="apellido" class="form-input w-full rounded-xl border-[#dbe2e6] dark:border-gray-600 dark:bg-[#1a2c34] h-12 px-4 focus:ring-primary" placeholder="Pérez" type="text" required />
                        </label>
                    </div>

                    <label class="flex flex-col gap-2">
                        <p data-key="label-username" class="text-sm font-bold text-[#111618] dark:text-white">Nombre de usuario</p>
                        <input name="usuario" class="form-input w-full rounded-xl border-[#dbe2e6] dark:border-gray-600 dark:bg-[#1a2c34] h-12 px-4 focus:ring-primary" placeholder="Ej: Juan77" type="text" required />
                    </label>

                    <label class="flex flex-col gap-2">
                        <p data-key="label-email" class="text-sm font-bold text-[#111618] dark:text-white">Correo electrónico</p>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#617c89] material-symbols-outlined">mail</span>
                            <input name="email" class="form-input w-full rounded-xl border-[#dbe2e6] dark:border-gray-600 dark:bg-[#1a2c34] h-12 pl-11 focus:ring-primary" placeholder="correo@ejemplo.com" type="email" required />
                        </div>
                    </label>

                    <label class="flex flex-col gap-2">
                        <p data-key="label-pass" class="text-sm font-bold text-[#111618] dark:text-white">Contraseña</p>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#617c89] material-symbols-outlined">lock</span>
                            <input name="password" class="form-input w-full rounded-xl border-[#dbe2e6] dark:border-gray-600 dark:bg-[#1a2c34] h-12 pl-11 focus:ring-primary" placeholder="••••••••" type="password" required />
                        </div>
                    </label>

                    <button class="w-full rounded-xl h-12 bg-primary text-white font-bold shadow-md hover:bg-[#0f8bc7] transition-all mt-4">
                        <span data-key="btn-create">Crear cuenta</span>
                    </button>
                </form>

                <p class="text-center text-sm text-[#617c89] dark:text-gray-400">
                    <span data-key="have-account">¿Ya tienes una cuenta?</span> <a data-key="link-login" class="text-primary font-bold hover:underline" href="login.php">Inicia sesión aquí</a>
                </p>
            </div>
        </div>
    </div>

    <script src="/js/registro.js"></script>
</body>

</html>