<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Alquiler de Apartamentos Frente al Mar</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
                        "2xl": "1rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
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
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#111618] dark:text-white transition-colors duration-200">
    <div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
        <header class="absolute top-0 left-0 w-full z-50 flex items-center justify-between whitespace-nowrap px-6 py-6 md:px-10 transition-all duration-300">
            <div class="flex items-center gap-4 text-white">
                <div class="size-8 text-primary">
                    <span class="material-symbols-outlined text-3xl font-variation-fill">apartment</span>
                </div>
                <h2 class="text-white text-xl font-bold leading-tight tracking-[-0.015em] whitespace-nowrap">Santamartabeachfront</h2>
            </div>
            <div class="hidden md:flex flex-1 justify-end gap-8">
                <div class="flex items-center gap-9">
                    <a class="text-white text-sm font-medium leading-normal hover:text-primary transition-colors drop-shadow-sm" href="#apartamentos">Apartamentos</a>
                    <a class="text-white text-sm font-medium leading-normal hover:text-primary transition-colors drop-shadow-sm" href="#ubicacion">Ubicación</a>
                    <a class="text-white text-sm font-medium leading-normal hover:text-primary transition-colors drop-shadow-sm" href="#nosotros">Nosotros</a>
                    <a class="text-white text-sm font-medium leading-normal hover:text-primary transition-colors drop-shadow-sm" href="#contacto">Contacto</a>
                </div>
                <div class="flex items-center gap-6 border-l border-white/30 pl-6">
                    <div class="relative lang-dropdown">
                        <button class="flex items-center gap-2 text-white text-sm font-medium py-2 px-3 rounded-lg hover:bg-white/10 transition-colors">
                            <img alt="Español" class="size-5 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAitXXKe6t7Pm8JEXUTAAgSTU2PMm9xHuU4CQT_G_mNPbCi1kvkZr6GpVA5nv-qlon7RigKBGCd1CpHe0Eu98g1bqq85Tca4EbIojeaav7Ufe7vfDsqx8Y3wdJlsaZWZhAl1it3kkNZKBzGCZ-zoxOgYlnBiEwyt-wLkkpx0uTn76pL2ZppQgKZWquPEvCX5VY6up4eKem35aa2axafEF8WfPKkN-7aifxFMvUHjHUhgFtQHPPu29rNL07XVHDQjyXjsfLTqY-iEIc" />
                            <span>ES</span>
                            <span class="material-symbols-outlined text-sm">expand_more</span>
                        </button>
                        <div class="lang-menu absolute top-full right-0 mt-2 w-40 bg-white dark:bg-[#1e2930] rounded-xl shadow-2xl border border-gray-100 dark:border-gray-700 py-2 z-[60]">
                            <a class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors" href="#">
                                <img alt="Español" class="size-5 rounded-full object-cover shadow-sm" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAitXXKe6t7Pm8JEXUTAAgSTU2PMm9xHuU4CQT_G_mNPbCi1kvkZr6GpVA5nv-qlon7RigKBGCd1CpHe0Eu98g1bqq85Tca4EbIojeaav7Ufe7vfDsqx8Y3wdJlsaZWZhAl1it3kkNZKBzGCZ-zoxOgYlnBiEwyt-wLkkpx0uTn76pL2ZppQgKZWquPEvCX5VY6up4eKem35aa2axafEF8WfPKkN-7aifxFMvUHjHUhgFtQHPPu29rNL07XVHDQjyXjsfLTqY-iEIc" />
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Español</span>
                            </a>
                            <a class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors" href="#">
                                <img alt="English" class="size-5 rounded-full object-cover shadow-sm" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCst0Z7IrPskw7qs-bKK41stk9g7lPMS2CC1HQb9vVHxo3Zho9JInRxZqAEuDWl5ia8T7ej2JYvZm_Z-okQEK4uoClhQkjbhejSln2G08D9It80N_mbCh6kXSwGnk99jEwK-IaX9uAExO3YUGs58NUuxiUK2NGeF8sQNDYYwEEEXO95-CCH24bp8TdB9as2XYkIE1Z0XvVVJCdTsBmnWmfttrwaJaHIt03i_dN0IgYzUJOfHmEDPV7yiL1zQksCA1pZnYdhuhfLznI" />
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">English</span>
                            </a>
                        </div>
                    </div>
                    <button class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-6 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors shadow-lg shadow-primary/30 border border-transparent">
                        <span class="truncate">Iniciar Sesión</span>
                    </button>
                </div>
            </div>
            <button class="md:hidden text-white">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </header>
        <section class="relative w-full h-screen flex items-center justify-center overflow-hidden bg-gray-900">
            <div class="absolute inset-0 z-0">
                <img alt="Santa Marta beach view" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDBptge_9LlH-1lRNvm2cBtLsIvPMw8E7sKdb75a6I4lEfS6tsHD4SNLkSt9nREwwUSB7jPxwwufaFyAdsvzR6gPMr6RHxXGX1xODD-ubjRq-PSMZiRlHM5OSv9J0jHpHSRpw-O9mWdA7Glmy_Mxw5n8lP8UXUo2l8RlCJ0uGiJ7-avidnhFvZDpd-T0-aaWEjBdcM3a7Oh4s-1alK31fjFohpbjKRPpfrOo1G0YQqp8klCowN0PvMJvxMBQ2zfHanxYXheyFpPaSY" />
                <div class="absolute inset-0 bg-black/40"></div>
            </div>
            <div class="relative z-10 flex flex-col items-center gap-8 text-center px-4 max-w-5xl mx-auto pt-20">
                <h1 class="text-white text-5xl md:text-7xl lg:text-8xl font-black leading-tight tracking-tight drop-shadow-2xl">
                    Vive la experiencia <br /> <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-cyan-300">frente al mar</span>
                </h1>
                <p class="text-white/95 text-lg md:text-2xl font-medium max-w-3xl drop-shadow-lg leading-relaxed">
                    Los mejores apartamentos en Santamartabeachfront te esperan. Despierta con el sonido de las olas.
                </p>
                <div class="flex flex-col sm:flex-row gap-5 w-full justify-center pt-6">
                    <a class="flex items-center justify-center h-14 min-w-[180px] bg-primary hover:bg-primary/90 text-white font-bold text-lg rounded-xl px-8 shadow-xl shadow-primary/30 transition-all transform hover:-translate-y-1 hover:shadow-2xl hover:shadow-primary/40" href="#apartamentos">
                        Visualizar
                    </a>
                    <a class="flex items-center justify-center h-14 min-w-[180px] bg-white/10 border border-white/80 hover:bg-white hover:text-primary text-white font-bold text-lg rounded-xl px-8 backdrop-blur-md transition-all transform hover:-translate-y-1 shadow-lg" href="#contacto">
                        Contactar
                    </a>
                </div>
            </div>
        </section>
        <section class="py-20 px-6 md:px-20 bg-background-light dark:bg-background-dark" id="nosotros">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#111618] dark:text-white mb-4">¿Por qué elegirnos?</h2>
                    <p class="text-gray-500 dark:text-gray-400 max-w-xl mx-auto">Disfruta de la mejor ubicación, comodidades de lujo y un servicio personalizado.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-[#1e2930] p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition-shadow">
                        <div class="size-14 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-6">
                            <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1, 'wght' 400;">beach_access</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 dark:text-white">Acceso a la Playa</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                            Sal de tu apartamento y pisa la arena dorada. Ubicación privilegiada frente al mar caribe.
                        </p>
                    </div>
                    <div class="bg-white dark:bg-[#1e2930] p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition-shadow">
                        <div class="size-14 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-6">
                            <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1, 'wght' 400;">pool</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 dark:text-white">Piscina Infinita</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                            Relájate en nuestras piscinas con vista panorámica al océano y zona de solarium.
                        </p>
                    </div>
                    <div class="bg-white dark:bg-[#1e2930] p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition-shadow">
                        <div class="size-14 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-6">
                            <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1, 'wght' 400;">verified_user</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 dark:text-white">Seguridad 24/7</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                            Tu tranquilidad es nuestra prioridad. Edificios monitoreados y recepción 24 horas.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-16 px-6 md:px-20 bg-white dark:bg-[#101c22]" id="disponibilidad">
            <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-12 items-center">
                <div class="flex-1 space-y-6">
                    <span class="text-primary font-bold uppercase tracking-wider text-sm">Planifica tu viaje</span>
                    <h2 class="text-3xl md:text-5xl font-bold text-[#111618] dark:text-white leading-tight">
                        Consulta disponibilidad en tiempo real
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">
                        Nuestros apartamentos son muy solicitados. Revisa el calendario para asegurar tus fechas ideales para unas vacaciones inolvidables.
                    </p>
                    <div class="flex flex-col gap-4 pt-4">
                        <div class="flex items-center gap-3">
                            <div class="size-3 rounded-full bg-primary"></div>
                            <span class="text-sm font-medium dark:text-gray-300">Fechas Disponibles</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="size-3 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                            <span class="text-sm font-medium dark:text-gray-300">No Disponible</span>
                        </div>
                    </div>
                    <button class="mt-8 flex items-center gap-2 text-primary font-bold hover:gap-3 transition-all">
                        Ver calendario completo <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
                <div class="flex-1 w-full flex justify-center lg:justify-end">
                    <div class="bg-white dark:bg-[#1e2930] rounded-2xl shadow-2xl p-6 border border-gray-100 dark:border-gray-700 max-w-2xl w-full">
                        <div class="flex flex-col md:flex-row gap-6 justify-center">
                            <div class="flex min-w-[280px] flex-1 flex-col gap-2">
                                <div class="flex items-center p-1 justify-between mb-2">
                                    <button class="hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full p-1"><span class="material-symbols-outlined dark:text-white">chevron_left</span></button>
                                    <p class="text-[#111618] dark:text-white text-base font-bold text-center">Enero 2024</p>
                                    <div class="w-8"></div>
                                </div>
                                <div class="grid grid-cols-7 gap-y-2 text-center">
                                    <p class="text-gray-400 text-xs font-bold">D</p>
                                    <p class="text-gray-400 text-xs font-bold">L</p>
                                    <p class="text-gray-400 text-xs font-bold">M</p>
                                    <p class="text-gray-400 text-xs font-bold">M</p>
                                    <p class="text-gray-400 text-xs font-bold">J</p>
                                    <p class="text-gray-400 text-xs font-bold">V</p>
                                    <p class="text-gray-400 text-xs font-bold">S</p>
                                    <span class="col-start-4 flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">1</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">2</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">3</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">4</span>
                                    <span class="flex items-center justify-center h-8 w-8 rounded-full bg-primary text-white text-sm font-bold shadow-md shadow-primary/40">5</span>
                                    <span class="flex items-center justify-center h-8 w-8 bg-primary/10 text-primary text-sm font-medium rounded-full">6</span>
                                    <span class="flex items-center justify-center h-8 w-8 bg-primary/10 text-primary text-sm font-medium rounded-full">7</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm text-gray-400 line-through">8</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm text-gray-400 line-through">9</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm text-gray-400 line-through">10</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">11</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">12</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">13</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">14</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">15</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">16</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">17</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">18</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">19</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">20</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">21</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">22</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">23</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">24</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">25</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">26</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">27</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">28</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">29</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">30</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">31</span>
                                </div>
                            </div>
                            <div class="h-px w-full bg-gray-100 dark:bg-gray-700 md:hidden"></div>
                            <div class="flex min-w-[280px] flex-1 flex-col gap-2">
                                <div class="flex items-center p-1 justify-between mb-2">
                                    <div class="w-8"></div>
                                    <p class="text-[#111618] dark:text-white text-base font-bold text-center">Febrero 2024</p>
                                    <button class="hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full p-1"><span class="material-symbols-outlined dark:text-white">chevron_right</span></button>
                                </div>
                                <div class="grid grid-cols-7 gap-y-2 text-center">
                                    <p class="text-gray-400 text-xs font-bold">D</p>
                                    <p class="text-gray-400 text-xs font-bold">L</p>
                                    <p class="text-gray-400 text-xs font-bold">M</p>
                                    <p class="text-gray-400 text-xs font-bold">M</p>
                                    <p class="text-gray-400 text-xs font-bold">J</p>
                                    <p class="text-gray-400 text-xs font-bold">V</p>
                                    <p class="text-gray-400 text-xs font-bold">S</p>
                                    <span class="col-start-5 flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">1</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">2</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">3</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">4</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">5</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">6</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">7</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">8</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">9</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">10</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">11</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">12</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">13</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">14</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">15</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">16</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">17</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">18</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">19</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">20</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">21</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">22</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">23</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">24</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">25</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">26</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">27</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">28</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">29</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20 bg-background-light dark:bg-background-dark" id="apartamentos">
            <div class="px-6 md:px-20 mb-12 text-center">
                <h2 class="text-3xl font-bold text-[#111618] dark:text-white mb-2">Apartamento Destacado</h2>
                <p class="text-gray-500 dark:text-gray-400">Nuestra mejor propiedad para una estancia inolvidable</p>
            </div>
            <div class="flex justify-center px-6 md:px-20">
                <div class="max-w-[420px] w-full bg-white dark:bg-[#1e2930] rounded-2xl overflow-hidden shadow-2xl group border border-gray-100 dark:border-gray-700">
                    <div class="relative h-72 overflow-hidden">
                        <div class="absolute top-4 right-4 z-10 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-gray-800 flex items-center gap-1 shadow-sm">
                            <span class="material-symbols-outlined text-yellow-500 text-sm" style="font-variation-settings: 'FILL' 1;">star</span> 5.0
                        </div>
                        <div class="h-full w-full bg-cover bg-center group-hover:scale-110 transition-transform duration-700" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDhr-fja2E9oqdW3FeI503YhZXCPEnOJ34yXhATmDRax6RvUtXR9_eoJUbYx6EnOIEBRlfT-n5Lm7cAmW4TdhEEg2CZTdot2tDAeJVpKdZFVPa2mr_j_H0Rr1Ch8-atttcHQXDqxmq88aXJm6kKarN2geXSWHwJTwm9KKqowzPZTLx_CDcwuyj5QbBGTsy5nFJtSVhcea4WvOFsS-dRRyjJDI8m1dEnYEeSgIcv6YlxLk2VrCukZJSRiVae4DykJUmwqInWo07FO3U');"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                            <button class="w-full bg-white text-primary font-bold py-2 rounded-lg text-sm">Reservar Ahora</button>
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="text-xs font-bold text-primary uppercase tracking-wide mb-2">Reserva del Mar</div>
                        <h3 class="text-2xl font-bold dark:text-white mb-3">Suite Familiar de Lujo</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-6 leading-relaxed">
                            Lujo en cada detalle. Cocina gourmet, terraza privada con vista despejada al océano y acabados premium para el máximo confort de tu familia.
                        </p>
                        <div class="grid grid-cols-3 gap-4 text-sm text-gray-500 dark:text-gray-400 mb-8">
                            <div class="flex flex-col items-center gap-1">
                                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">bed</span>
                                <span>2 Hab</span>
                            </div>
                            <div class="flex flex-col items-center gap-1">
                                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">shower</span>
                                <span>2 Baños</span>
                            </div>
                            <div class="flex flex-col items-center gap-1">
                                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">groups</span>
                                <span>5 Huéspedes</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-6 border-t border-gray-100 dark:border-gray-700">
                            <div>
                                <span class="text-2xl font-extrabold text-[#111618] dark:text-white">$210</span>
                                <span class="text-gray-500 text-sm">/noche</span>
                            </div>
                            <button class="bg-primary/10 text-primary hover:bg-primary hover:text-white px-5 py-2 rounded-xl font-bold text-sm transition-colors">
                                Ver detalles
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20 px-6 md:px-20 bg-white dark:bg-[#101c22]">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <span class="text-primary font-bold uppercase tracking-wider text-sm">Testimonios</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-[#111618] dark:text-white mt-2 mb-4">Reseñas Destacadas</h2>
                    <p class="text-gray-500 dark:text-gray-400 max-w-xl mx-auto">Experiencias reales de personas que han disfrutado de unas vacaciones inolvidables con nosotros.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-background-light dark:bg-[#1e2930] p-8 rounded-2xl relative border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300">
                        <span class="material-symbols-outlined text-6xl text-primary/10 absolute top-4 right-4" style="font-variation-settings: 'FILL' 1;">format_quote</span>
                        <div class="flex items-center gap-1 mb-4">
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed relative z-10">
                            "¡Simplemente espectacular! La vista desde el balcón es inigualable y el apartamento estaba impecable. Definitivamente volveremos el próximo año."
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="size-12 rounded-full bg-gray-300 overflow-hidden">
                                <img alt="Foto de perfil usuario" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBnX6ygSDb930yDP1K7KdVCihWUaYhnvUhYRvaACepRJEYQk5ftenPc9j9YXbwj2zL3OzIldl5pkSlWOeMS8B3RQpWQUqNwYT48m5CypnmYGB8HEh8_8Xeofj3yDKAlxYDfab-e8h7sb9TAlnrrorOu7cGZyvbGV4UakhE9mUaktiT1XuYBAuCSWMj-rCwgI5Zf7-k9IG7nAqDA3kCfdfJtySHhGzHSYGZMiu_nU8YURqt4iS9PcpxfRoANPR__2hIIU8VTXBeQwe8" />
                            </div>
                            <div>
                                <h4 class="font-bold text-[#111618] dark:text-white">Carolina Méndez</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Bogotá, Colombia</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-background-light dark:bg-[#1e2930] p-8 rounded-2xl relative border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300">
                        <span class="material-symbols-outlined text-6xl text-primary/10 absolute top-4 right-4" style="font-variation-settings: 'FILL' 1;">format_quote</span>
                        <div class="flex items-center gap-1 mb-4">
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'wght' 400;">star_half</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed relative z-10">
                            "La ubicación es perfecta, cerca de restaurantes y supermercados. La piscina del edificio es increíble para relajarse después de la playa."
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="size-12 rounded-full bg-gray-300 overflow-hidden">
                                <img alt="Foto de perfil usuario" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBI5wBUYd3ZoplAFKAZsnZzl9A4yjX53yVmp67V30taKJf7yxiAi8o9UxlO4Bp8RcX9JptlHjCTTq8EZIAJbsT5AcQNOaKtWMwpUQuI_NUbImnSjz726-XLyydAyCZ5qHvXg_DXzh89_WDs315cEAFZa410_9JbWH3QL9rQvNsKYU1RAdHIl5QOAvON0zcDZaTnGW9gyOvhx-WqLjrqIdCDYUyVBUJmiMmTNjgDdjJ6T2irxncca8INGsaX9l1QXGUFLyAT-gOkU34" />
                            </div>
                            <div>
                                <h4 class="font-bold text-[#111618] dark:text-white">David Johnson</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Miami, USA</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-background-light dark:bg-[#1e2930] p-8 rounded-2xl relative border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300">
                        <span class="material-symbols-outlined text-6xl text-primary/10 absolute top-4 right-4" style="font-variation-settings: 'FILL' 1;">format_quote</span>
                        <div class="flex items-center gap-1 mb-4">
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed relative z-10">
                            "Atención de primera clase desde el momento de la reserva. El apartamento superó nuestras expectativas, muy moderno y cómodo."
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="size-12 rounded-full bg-gray-300 overflow-hidden">
                                <img alt="Foto de perfil usuario" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCIVOf4FxfS4L2VMX-MzvCAweEr1dlJGrW4FlVxeHThaYfYgpJenfN3sV0Y8zaiGh5T95YnWKaKAE7tPEkz23_h09Ka4rHPwfyQZN5ikR683fzv-Xu4MyREtZgKCvL7r_rjYrRysWZPPU2GgFWNTT7fv6aBd5GZ9Wz99LuaIOYWU30jT7nVTJqYrhQGEcHmc0bexmwdY8tKcqWUf1629_amnupnSWTM8y7D5L3BsWowHY2P78mGSPuLSOajNmU_Dj-NzASh5NQPVbc" />
                            </div>
                            <div>
                                <h4 class="font-bold text-[#111618] dark:text-white">Sofía Ramírez</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Medellín, Colombia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <section class="grid grid-cols-1 lg:grid-cols-2 min-h-[650px] bg-[#101c22] overflow-hidden" id="ubicacion">

            <article class="p-10 lg:p-20 flex flex-col justify-center order-2 lg:order-1">
                <header>
                    <div class="flex items-center gap-2 text-blue-500 font-bold mb-6">
                        <span class="material-symbols-outlined text-3xl">location_on</span>
                        <span class="uppercase tracking-[0.3em] text-sm">Ubicación Privilegiada</span>
                    </div>
                    <h2 class="text-4xl lg:text-5xl font-bold mb-8 text-white leading-tight">
                        Playa Salguero: <br><span class="text-blue-500">El corazón de Santa Marta</span>
                    </h2>
                </header>

                <p class="text-gray-400 mb-10 text-xl leading-relaxed max-w-xl">
                    Descubre la tranquilidad de <strong>Reserva del Mar</strong>, ubicado en la zona más exclusiva y con acceso directo al mar.
                </p>

                <address class="not-italic mb-10 space-y-3 border-l-4 border-blue-600 pl-6 py-2 bg-blue-900/10 rounded-r-xl max-w-md">
                    <p class="text-2xl font-black text-white">Reserva del Mar - Torre 4</p>
                    <p class="text-lg text-slate-300">Apartamento 1730</p>
                    <p class="text-sm text-slate-500 uppercase tracking-[0.2em]">Santa Marta, Colombia</p>
                </address>

                <ul class="space-y-6 mb-12" role="list">
                    <li class="flex items-center gap-4 group">
                        <div class="size-11 shrink-0 rounded-full bg-cyan-900/30 flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-xl">beach_access</span>
                        </div>
                        <span class="text-gray-300 font-medium text-lg">A solo 1 minuto de la playa</span>
                    </li>
                    <li class="flex items-center gap-4 group">
                        <div class="size-11 shrink-0 rounded-full bg-green-900/30 flex items-center justify-center text-green-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-xl">flight</span>
                        </div>
                        <span class="text-gray-300 font-medium text-lg">15 min del Aeropuerto Internacional</span>
                    </li>
                    <li class="flex items-center gap-4 group">
                        <div class="size-11 shrink-0 rounded-full bg-blue-900/30 flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-xl">restaurant</span>
                        </div>
                        <span class="text-gray-300 font-medium text-lg">5 min de la Zona Gastronómica</span>
                    </li>
                </ul>

                <a href="https://www.google.com/maps/search/?api=1&query=Reserva+del+Mar+Torre+4+Santa+Marta" target="_blank" class="self-start px-10 py-4 bg-blue-600 text-white font-bold rounded-full hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-500/20 active:scale-95">
                    Abrir en Google Maps
                </a>
            </article>

            <aside class="relative w-full min-h-[500px] lg:min-h-full order-1 lg:order-2">
                <div id="map-ubicacion" class="absolute inset-0 w-full h-full"></div>

                <div class="absolute top-6 left-6 z-[1000] bg-[#101c22]/90 px-5 py-3 rounded-2xl border border-white/10 backdrop-blur-md shadow-2xl">
                    <div class="flex items-center gap-3">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-600"></span>
                        </span>
                        <p id="map-status" class="text-[10px] font-black text-white uppercase tracking-[0.2em] whitespace-nowrap">Localizando...</p>
                    </div>
                </div>
            </aside>
        </section>

        <script>
            (function() {
                // Coordenadas exactas para Reserva del Mar
                const coordsFinal = [11.1911119, -74.2311344];
                const coordsColombia = [4.5709, -74.2973];
                const coordsEspacio = [20, 0];

                const map = L.map('map-ubicacion', {
                    zoomControl: false,
                    attributionControl: false,
                    scrollWheelZoom: false
                }).setView(coordsEspacio, 2);

                // Capa Satélite Google
                L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }).addTo(map);

                function fixMap() {
                    setTimeout(() => {
                        map.invalidateSize();
                    }, 600);
                }

                async function animarMapa() {
                    const status = document.getElementById('map-status');
                    const markerLayer = L.layerGroup().addTo(map);

                    while (true) {
                        if (!document.getElementById('map-ubicacion')) break;

                        status.innerText = "Planeta Tierra";
                        map.setView(coordsEspacio, 2);
                        markerLayer.clearLayers();
                        await new Promise(r => setTimeout(r, 2500));

                        status.innerText = "Colombia";
                        map.flyTo(coordsColombia, 6, {
                            duration: 3
                        });
                        await new Promise(r => setTimeout(r, 4000));

                        status.innerText = "Llegando a reservas del mar santa marta";
                        map.flyTo(coordsFinal, 18, {
                            duration: 4
                        });
                        await new Promise(r => setTimeout(r, 5000));

                        L.marker(coordsFinal).addTo(markerLayer)
                            .bindPopup('<div class="text-center p-1"><b class="text-blue-500">Reserva del Mar</b><br><span class="text-xs">Torre 4 - A 1 min del mar</span></div>')
                            .openPopup();

                        status.innerText = "Destino Alcanzado";
                        await new Promise(r => setTimeout(r, 8000));
                    }
                }

                window.addEventListener('load', fixMap);
                fixMap();
                animarMapa();
            })();
        </script>

        <style>
            #map-ubicacion {
                background: #0b141a;
            }

            .leaflet-popup-content-wrapper {
                background: #101c22 !important;
                color: white !important;
                border-radius: 12px;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .leaflet-popup-tip {
                background: #101c22 !important;
            }

            .shrink-0 {
                flex-shrink: 0;
            }
        </style>



        <footer class="bg-[#101c22] text-white pt-20 pb-10" id="contacto">
            <div class="max-w-7xl mx-auto px-6 md:px-10">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center pb-16 border-b border-gray-800 gap-8">
                    <div class="text-left">
                        <h2 class="text-3xl font-bold mb-2">¿Listo para tus vacaciones?</h2>
                        <p class="text-gray-400">Reserva hoy y asegura el mejor precio garantizado.</p>
                    </div>
                    <button class="bg-primary hover:bg-primary/90 text-white font-bold py-4 px-10 rounded-xl shadow-lg shadow-primary/20 transition-all transform hover:-translate-y-1">
                        Reservar Ahora
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 py-16">
                    <div class="space-y-6">
                        <div class="flex items-center gap-2 text-primary">
                            <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">apartment</span>
                            <span class="text-xl font-bold text-white">Santamartabeachfront</span>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
                            La plataforma líder en alquileres vacacionales de lujo en Santa Marta. Experiencias únicas, confort superior y las mejores vistas del Caribe colombiano.
                        </p>
                    </div>
                    <div>
                        <h4 class="font-bold mb-6 text-white uppercase tracking-wider text-sm">Información de Contacto</h4>
                        <ul class="space-y-4 text-sm text-gray-400">
                            <li class="flex items-start gap-3 hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">mail</span>
                                <span>info@santamartabeachfront.com</span>
                            </li>
                            <li class="flex items-start gap-3 hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">call</span>
                                <span>+57 300 123 4567</span>
                            </li>
                            <li class="flex items-start gap-3 hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">location_on</span>
                                <span>Rodadero Reservado, Santa Marta, Magdalena, Colombia</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold mb-6 text-white uppercase tracking-wider text-sm">Síguenos</h4>
                        <div class="flex gap-4">
                            <a class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center hover:bg-primary transition-all duration-300 group" href="#" title="Instagram">
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path>
                                </svg>
                            </a>
                            <a class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center hover:bg-primary transition-all duration-300 group" href="#" title="Facebook">
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"></path>
                                </svg>
                            </a>
                            <a class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center hover:bg-primary transition-all duration-300 group" href="#" title="Twitter">
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-gray-800 text-xs text-gray-500 gap-4">
                    <p>© 2024 Santamarta Beachfront. Todos los derechos reservados.</p>
                    <div class="flex gap-8">
                        <a class="hover:text-white transition-colors" href="#">Políticas de Privacidad</a>
                        <a class="hover:text-white transition-colors" href="#">Términos y Condiciones</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

</body>

</html>