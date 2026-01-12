<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Registro de Usuario</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="/public/img/logo-portada.png" type="image/x-icon">
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
    <style>
        body {
            font-family: "Plus Jakarta Sans", sans-serif;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#111618] dark:text-white min-h-screen flex flex-col font-display antialiased overflow-x-hidden">

    <div class="fixed top-6 right-6 z-50 flex bg-white/80 dark:bg-[#1a2c34]/80 backdrop-blur-md p-1 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg">
        <button onclick="changeLanguage('es')" id="btn-es" class="px-4 py-2 text-xs font-bold rounded-lg transition-all bg-primary text-white">ES</button>
        <button onclick="changeLanguage('en')" id="btn-en" class="px-4 py-2 text-xs font-bold rounded-lg transition-all text-gray-500 hover:text-primary">EN</button>
    </div>

    <div class="flex flex-1 w-full min-h-screen">
        <div class="hidden lg:flex lg:w-1/2 relative bg-cover bg-center overflow-hidden" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBWVtxYa1avv64bBzqotfC8pjpzIr4jca_ofoOoOj_UPB4Ya82CXS4F9WZNkL69W0Y_S2j62YH1uNTHCMazuQ3srBhQTV5bj3d3uBkMHuP8KoRfAB3ZvpM0N9SIiYNbG5_ChRUAFAGcF_R8E_ndyc9tpNEG8CysRAjP5K4x-53k6OSS4OExhb5LKLmiGHuILRp2acfeR3OeG4wjHQ_IBk6scY6jytclW7JBEHNQGhHexEC0rkYHWb0QPFof8JoCFueNBj2wnV_h2-A");'>
            <div class="absolute inset-0 bg-gradient-to-t from-[#101c22]/90 via-[#101c22]/20 to-transparent"></div>
            <div class="relative z-10 flex flex-col justify-end p-16 h-full w-full max-w-[720px] mx-auto">
                <div class="mb-8">
                    <div class="size-12 mb-6 text-white bg-primary/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/20">
                        <img src="/public/img/logo-portada.png" alt="">
                    </div>
                    <h1 data-key="hero-title" class="text-white text-5xl font-black leading-tight tracking-[-0.033em] mb-4">Bienvenido al paraíso</h1>
                    <p data-key="hero-desc" class="text-white/90 text-lg font-medium leading-relaxed max-w-md">
                        Gestiona tus reservas, planifica tus vacaciones o administra tus propiedades frente al mar en Santa Marta de forma segura.
                    </p>
                </div>

                <div class="flex items-center gap-4 py-4 px-6 bg-white/10 backdrop-blur-md rounded-2xl border border-white/10 w-fit">
                    <div class="flex -space-x-2">
                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBbUG04qRTNI5kxz4aqg6RoetrUSiF9GtBe-_D8t_4Hm6T3ILoA4pbqKP4_jXxq8xwYYVSSruKIP2TAQF9GNwkn1SWaOhz2q0K7Ck37-hCZemZ_OWj82dA9WJgHAlhp4W2ut6SRil_CPDDmYjcGvR8bGN8HqvQz_Y1htr_V9aoxVIClIDdaLqaIJhLVZ6PntDe9UXHHx2zVBseaDiMyzjaD80OxhMXa4lfOQL2J8FPaVsU05RKCrvhw5gROumwOEAoQpBuPK_7zA9s" alt="User 1" />
                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCuA8Xom8tvZc3BotC7Bce579WVGBi_9TmqLPtXf-PFSVpkqavv5wHjiexc_lwwrktRepzScE-78X6XX6F0SF7V-XfCcfSLFb_iNT6CJShB7YrojBVHslPavQ5aTmUmPfAnd9n1_-GVwysheRGH3vMTQs3J9ZQ3VTsXgKI5EQftjFZO79V3R4oxBeHAkKdLihTmOx3ON0rTTIfoVZ9_PqQtfb1LdQjkrKaMee9HyMshx97-Qg9OX9yyuoG6DZqv7RlCg8CLK1EJ2Y8" alt="User 2" />
                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBjZkSD4ZHhn3qnkt76WJuEFWrYw-qlK7_kpnjZ1SwUoF9eVfZHBL0BzW2ZJB7wU86-nKHg1pkKDClnQjWfj52PUXYB18al_ApS3PhcVnVcpf66x57KaWgyLmv1DMySC-gkLJ1Xfhfx8baYIKQOmPwXtGqPq5icO9zz50165ErOdU8KIP81s_D2HKXmY5S9ax4WqIaPSxDf-KkT0bOTOedvSuKsl0dii-0mJ6cq8biTzDgNAje7ZmVexSIc6XHtLKy8z65fHTQ59-Y" alt="User 3" />
                    </div>
                    <span data-key="social-proof" class="text-sm font-bold text-white">+1k Usuarios confían en nosotros</span>
                </div>
            </div>
        </div>

        <div class="flex w-full lg:w-1/2 flex-col justify-center items-center p-6 sm:p-12 lg:p-24 bg-white dark:bg-background-dark relative">
            <div class="lg:hidden absolute top-6 left-6 flex items-center gap-2">
                <img src="/public/img/logo-portada.png" width="40" alt="">
                <span class="font-bold text-xl tracking-tight">Santamartabeachfront</span>
            </div>

            <div class="w-full max-w-[480px] flex flex-col gap-6">
                <div class="flex flex-col gap-2">
                    <div class="hidden lg:flex items-center gap-2 mb-2 text-primary">
                        <img src="/public/img/logo-portada.png" width="40" alt="">
                        <span class="font-bold text-lg tracking-tight text-[#111618] dark:text-white">Santamartabeachfront</span>
                    </div>
                    <h2 data-key="reg-title" class="text-3xl font-bold tracking-tight text-[#111618] dark:text-white">Crea tu cuenta</h2>
                    <p data-key="reg-subtitle" class="text-[#617c89] dark:text-gray-400">Únete a nuestra comunidad para empezar.</p>
                </div>

                <div class="flex border-b border-[#dbe2e6] dark:border-gray-700 w-full">
                    <a href="login.php" class="flex flex-1 items-center justify-center border-b-[3px] border-b-transparent pb-3 pt-2 transition-colors">
                        <p data-key="tab-login" class="text-sm font-bold leading-normal tracking-[0.015em] text-[#111618] dark:text-white">Iniciar Sesión</p>
                    </a>
                    <a class="flex flex-1 items-center justify-center border-b-[3px] border-b-[#111618] dark:border-b-primary text-[#111618] dark:text-white pb-3 pt-2">
                        <p data-key="tab-register" class="text-sm font-bold leading-normal tracking-[0.015em]">Registrarse</p>
                    </a>
                </div>

                <form class="flex flex-col gap-4">
                    <div class="flex gap-4">
                        <label class="flex flex-col flex-1 gap-2">
                            <p data-key="label-username" class="text-[#111618] dark:text-white text-sm font-bold">Nombre de usuario</p>
                            <input class="form-input w-full rounded-xl border-[#dbe2e6] dark:border-gray-600 dark:bg-[#1a2c34] h-12 px-4 focus:ring-primary focus:border-primary" placeholder="Ej: Juan77" type="text" />
                        </label>
                        <label class="flex flex-col flex-1 gap-2">
                            <p data-key="label-lastname" class="text-[#111618] dark:text-white text-sm font-bold">Apellido</p>
                            <input class="form-input w-full rounded-xl border-[#dbe2e6] dark:border-gray-600 dark:bg-[#1a2c34] h-12 px-4 focus:ring-primary focus:border-primary" placeholder="Pérez" type="text" />
                        </label>
                    </div>

                    <label class="flex flex-col gap-2">
                        <p data-key="label-email" class="text-[#111618] dark:text-white text-sm font-bold">Correo electrónico</p>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-[#617c89] dark:text-gray-400">
                                <span class="material-symbols-outlined text-[20px]">mail</span>
                            </div>
                            <input class="form-input w-full rounded-xl border-[#dbe2e6] dark:border-gray-600 dark:bg-[#1a2c34] h-12 pl-11 focus:ring-primary" placeholder="nombre@ejemplo.com" type="email" />
                        </div>
                    </label>

                    <label class="flex flex-col gap-2">
                        <p data-key="label-pass" class="text-[#111618] dark:text-white text-sm font-bold">Contraseña</p>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-[#617c89] dark:text-gray-400">
                                <span class="material-symbols-outlined text-[20px]">lock</span>
                            </div>
                            <input class="form-input w-full rounded-xl border-[#dbe2e6] dark:border-gray-600 dark:bg-[#1a2c34] h-12 pl-11 focus:ring-primary" placeholder="••••••••" type="password" />
                        </div>
                    </label>

                    <label class="flex flex-col gap-2">
                        <p data-key="label-confirm" class="text-[#111618] dark:text-white text-sm font-bold">Confirmar contraseña</p>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-[#617c89] dark:text-gray-400">
                                <span class="material-symbols-outlined text-[20px]">lock_reset</span>
                            </div>
                            <input class="form-input w-full rounded-xl border-[#dbe2e6] dark:border-gray-600 dark:bg-[#1a2c34] h-12 pl-11 focus:ring-primary" placeholder="••••••••" type="password" />
                        </div>
                    </label>

                    <button class="w-full rounded-xl h-12 bg-primary text-white font-bold shadow-md hover:bg-[#0f8bc7] transition-all mt-2">
                        <span data-key="btn-create">Crear cuenta</span>
                    </button>
                </form>

                <div class="flex flex-col items-center gap-4 mt-2">
                    <p class="text-sm text-[#617c89] dark:text-gray-400">
                        <span data-key="have-account">¿Ya tienes una cuenta?</span> <a data-key="link-login" class="text-primary font-bold hover:underline" href="login.php">Inicia sesión aquí</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const translations = {
            es: {
                "hero-title": "Bienvenido al paraíso",
                "hero-desc": "Gestiona tus reservas, planifica tus vacaciones o administra tus propiedades frente al mar en Santa Marta de forma segura.",
                "social-proof": "+1k Usuarios confían en nosotros",
                "reg-title": "Crea tu cuenta",
                "reg-subtitle": "Únete a nuestra comunidad para empezar.",
                "tab-login": "Iniciar Sesión",
                "tab-register": "Registrarse",
                "label-username": "Nombre de usuario",
                "label-lastname": "Apellido",
                "label-email": "Correo electrónico",
                "label-pass": "Contraseña",
                "label-confirm": "Confirmar contraseña",
                "btn-create": "Crear cuenta",
                "have-account": "¿Ya tienes una cuenta?",
                "link-login": "Inicia sesión aquí"
            },
            en: {
                "hero-title": "Welcome to Paradise",
                "hero-desc": "Manage your reservations, plan your vacations, or manage your beachfront properties in Santa Marta securely.",
                "social-proof": "+1k Users trust us",
                "reg-title": "Create your account",
                "reg-subtitle": "Join our community to get started.",
                "tab-login": "Login",
                "tab-register": "Sign Up",
                "label-username": "Username",
                "label-lastname": "Last Name",
                "label-email": "Email Address",
                "label-pass": "Password",
                "label-confirm": "Confirm Password",
                "btn-create": "Create account",
                "have-account": "Already have an account?",
                "link-login": "Login here"
            }
        };

        function changeLanguage(lang) {
            document.querySelectorAll('[data-key]').forEach(el => {
                const key = el.getAttribute('data-key');
                if (translations[lang][key]) el.innerText = translations[lang][key];
            });
            document.getElementById('btn-es').className = lang === 'es' ? 'px-4 py-2 text-xs font-bold rounded-lg transition-all bg-primary text-white' : 'px-4 py-2 text-xs font-bold rounded-lg transition-all text-gray-500 hover:text-primary';
            document.getElementById('btn-en').className = lang === 'en' ? 'px-4 py-2 text-xs font-bold rounded-lg transition-all bg-primary text-white' : 'px-4 py-2 text-xs font-bold rounded-lg transition-all text-gray-500 hover:text-primary';
        }
    </script>
</body>

</html>