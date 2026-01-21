<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Recuperar Contraseña</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link rel="shortcut icon" href="/public/img/logo-definitivo.png" type="image/x-icon">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
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
        <a href="/" class="flex items-center gap-3">
            <img src="/public/img/logo-definitivo.png" class="h-16 md:h-24 w-auto object-contain" alt="logo">
            <span class="hidden sm:block font-bold text-lg md:text-xl tracking-tight text-blue-500">
                Santamartabeachfront
            </span>
        </a>
    </header>

    <div class="flex flex-1 w-full min-h-screen">
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gray-200 dark:bg-gray-900">
            <img src="/public/img/torre-portada-login.webp" alt="Santamartabeachfront View" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-[#101c22]/90 via-[#101c22]/30 to-transparent"></div>
            <div class="relative z-10 flex flex-col justify-end p-16 h-full w-full max-w-[720px] mx-auto">
                <div class="mb-8">
                    <h1 class="text-white text-5xl font-black leading-tight tracking-[-0.033em] mb-4">
                        Recupera tu acceso
                    </h1>
                    <p class="text-white/90 text-lg font-medium leading-relaxed max-w-md">
                        Te ayudaremos a restablecer tu contraseña para que puedas seguir disfrutando de tus vacaciones.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex w-full lg:w-1/2 flex-col justify-center items-center p-6 sm:p-12 lg:p-24 bg-white dark:bg-background-dark">
            <div class="w-full max-w-[480px] flex flex-col gap-8">
                <div class="flex flex-col gap-2">
                    <h2 class="text-3xl font-bold tracking-tight text-[#111618] dark:text-white">¿Olvidaste tu contraseña?</h2>
                    <p class="text-[#617c89] dark:text-gray-400">Ingresa tu correo electrónico y te enviaremos instrucciones para restablecerla.</p>
                </div>

                <form action="enviar_link_recuperacion.php" method="POST" class="flex flex-col gap-5">
                    <label class="flex flex-col gap-2">
                        <p class="text-sm font-bold text-[#111618] dark:text-white">Correo Electrónico</p>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#617c89] material-symbols-outlined">mail</span>
                            <input name="email" class="form-input w-full rounded-xl border-[#dbe2e6] dark:border-gray-600 dark:bg-[#1a2c34] h-12 pl-11 focus:ring-primary" placeholder="ejemplo@correo.com" type="email" required />
                        </div>
                    </label>

                    <button class="w-full rounded-xl h-12 bg-primary text-white font-bold shadow-md hover:shadow-lg hover:bg-[#0f8bc7] transition-all">
                        Enviar enlace de recuperación
                    </button>
                </form>

                <div class="text-center">
                    <a href="login.php" class="text-primary font-bold hover:underline flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-sm">arrow_back</span> Volver al inicio de sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>