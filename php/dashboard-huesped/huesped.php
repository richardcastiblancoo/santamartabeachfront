<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Panel de Control - Santamartabeachfront</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#111618] dark:text-white flex flex-col min-h-screen overflow-x-hidden">
    <header class="sticky top-0 z-50 flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#e5e7eb] dark:border-b-gray-800 bg-white dark:bg-[#1a2c35] px-4 md:px-10 py-3 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="size-8 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl">beach_access</span>
            </div>
            <h2 class="hidden md:block text-[#111618] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Santamartabeachfront</h2>
        </div>
        <div class="flex flex-1 justify-end gap-4 md:gap-8 items-center">
            <nav class="hidden md:flex items-center gap-6">
                <a class="text-[#111618] dark:text-gray-200 text-sm font-medium hover:text-primary transition-colors" href="#">Mis Reservas</a>
                <a class="text-[#111618] dark:text-gray-200 text-sm font-medium hover:text-primary transition-colors" href="#">Favoritos</a>
            </nav>
            <div class="flex items-center gap-3">
                <button class="flex items-center justify-center rounded-full size-10 hover:bg-gray-100 dark:hover:bg-gray-800 text-[#111618] dark:text-white transition-colors relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2 right-2 size-2 bg-red-500 rounded-full border border-white dark:border-[#1a2c35]"></span>
                </button>
                <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 border-2 border-white dark:border-gray-700 shadow-sm cursor-pointer" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuANTtDzy3yDPc3ukQeN31HRqwzlP-TMAXHMOm25xp-8qUMSLr4AW9dTN2AyEwQpuExdJckqpcloaE6J8YJWk2za3kDF7r_M_by2z5htraPpPfD_GjSKM2fzcK4LeswQqevE7VMquKIr_xxYx3a8OtRW8sECr2l-MvL8JdSgwFAMUnxztaK09fLiAMRFzuUt0HISefvv4C-0-FmiaBxBl7QL9L7q315vUote36yNgTj7aqMFHW5679w0HPAkBYDy_diuGM0GOV3008Q");'>
                </div>
            </div>
        </div>
    </header>
    <main class="flex-1 w-full max-w-[1200px] mx-auto px-4 md:px-6 lg:px-8 py-8 space-y-8">
        <section class="flex flex-col gap-2">
            <p class="text-[#111618] dark:text-white text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">Hola, Daniel</p>
            <p class="text-[#617c89] dark:text-gray-400 text-base font-normal">Bienvenido a tu panel de control. Tu próxima aventura te espera.</p>
        </section>
        <section class="relative overflow-hidden rounded-2xl shadow-lg group">
            <div class="flex min-h-[400px] flex-col gap-6 bg-cover bg-center bg-no-repeat items-start justify-end px-6 pb-10 md:px-10 md:pb-12 transition-transform duration-700 hover:scale-[1.01]" style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.6) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuBrfoVzmpeTleJ-mpjmBAEBcDNHpX7hqa9HNydfKi2GglidRoQYxZINf8raTTy3DUDVPYa3OgjSg6lYCoEM8OcRJGD8O-grfNuqHoeOFjPPCTWTD6VRsfmM-6WdZQzgcshrd_yO0ci8SCGeeurr5TgA8H1xQkUQf9vV9t1v1tzlqoaOd4BbNU02v11pXUrEXDXmaubZdIYrJtcIkt0fHiUmxAIFYZHRXju2RaHJ1Dz19_RT3VufCmnHZC0ZR75LMTPyPGUi777CsJc");'>
                <div class="absolute top-6 right-6 bg-white/90 dark:bg-black/80 backdrop-blur-sm px-4 py-2 rounded-lg shadow-md flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">schedule</span>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-white">Check-in: 3 Días</span>
                </div>
                <div class="flex flex-col gap-2 text-left max-w-2xl">
                    <h1 class="text-white text-3xl md:text-5xl font-black leading-tight tracking-[-0.033em] drop-shadow-md">
                        Tu escapada a Santa Marta
                    </h1>
                    <h2 class="text-gray-100 text-base md:text-lg font-medium leading-normal drop-shadow-sm mb-4">
                        Apartamento Vista al Mar - Edificio El Rodadero. Todo está listo para tu llegada.
                    </h2>
                    <div class="flex flex-wrap gap-3">
                        <button class="flex items-center justify-center rounded-lg h-12 px-6 bg-primary hover:bg-sky-500 text-white text-base font-bold transition-all shadow-md hover:shadow-lg">
                            <span class="mr-2 material-symbols-outlined">key</span>
                            Ver detalles de llegada
                        </button>
                        <button class="flex items-center justify-center rounded-lg h-12 px-6 bg-white/20 hover:bg-white/30 backdrop-blur-md text-white border border-white/40 text-base font-bold transition-all">
                            <span class="mr-2 material-symbols-outlined">menu_book</span>
                            Guía de la casa
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 flex flex-col gap-6">
                <div class="border-b border-[#dbe2e6] dark:border-gray-700">
                    <div class="flex gap-8">
                        <a class="group flex items-center gap-2 border-b-[3px] border-b-primary pb-3 pt-2 cursor-pointer" href="#">
                            <span class="material-symbols-outlined text-primary text-[20px]">calendar_month</span>
                            <p class="text-[#111618] dark:text-white text-sm font-bold tracking-[0.015em]">Próximas reservas</p>
                        </a>
                        <a class="group flex items-center gap-2 border-b-[3px] border-b-transparent hover:border-b-gray-300 pb-3 pt-2 cursor-pointer transition-colors" href="#">
                            <span class="material-symbols-outlined text-[#617c89] group-hover:text-gray-600 dark:text-gray-500 text-[20px]">history</span>
                            <p class="text-[#617c89] group-hover:text-gray-600 dark:text-gray-400 dark:group-hover:text-gray-300 text-sm font-bold tracking-[0.015em]">Estancias pasadas</p>
                        </a>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col md:flex-row items-stretch rounded-xl bg-white dark:bg-[#1a2c35] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden group hover:shadow-md transition-all">
                        <div class="w-full md:w-64 md:min-w-64 h-48 md:h-auto bg-center bg-no-repeat bg-cover relative" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDaxpzvI1FWkCIf3NLVafs9TDBd7S97Vx5_lbyhB7w5MZA7Q2Pv6Ru8tMnQTwCwAeEVsAyQ_81toilYI08qYHYAk0RwB_Y4u_UBdR_iyZKfkvwOmSOyemsQr1pUjbbLCPWjQXBCBVKRFW8DW0uhaVWtvcwWz2m1chsxujxy08kRfsByBNJ-PHADVXny8kH4e0kxwkXGgTsKuIPVEgDTQ18P0_tBv1fF1_Ap6eTyKuuUJUTPAFpyH7mudMlLntYqC5ObmSFwLxvdNUI");'>
                            <div class="absolute top-2 left-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded shadow">Confirmada</div>
                        </div>
                        <div class="flex flex-1 flex-col justify-between p-5 gap-3">
                            <div>
                                <div class="flex justify-between items-start">
                                    <h3 class="text-[#111618] dark:text-white text-lg font-bold leading-tight">Apartamento de Lujo en Pozos Colorados</h3>
                                    <button class="text-gray-400 hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined">favorite</span>
                                    </button>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">location_on</span>
                                    Pozos Colorados, Santa Marta
                                </p>
                            </div>
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center gap-3 text-sm text-[#617c89] dark:text-gray-300 bg-gray-50 dark:bg-gray-800 p-2 rounded-lg border border-gray-100 dark:border-gray-700">
                                    <span class="material-symbols-outlined text-primary">date_range</span>
                                    <span>15 Oct - 20 Oct, 2024</span>
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                    <span>2 Huéspedes</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100 dark:border-gray-700 mt-1">
                                <button class="flex items-center gap-1 text-primary hover:text-sky-600 text-sm font-bold px-3 py-2 rounded transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">edit_note</span>
                                    Escribir reseña
                                </button>
                                <button class="flex items-center justify-center rounded-lg h-9 px-4 bg-primary text-white text-sm font-medium shadow-sm hover:bg-sky-500 transition-colors">
                                    Gestionar reserva
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row items-stretch rounded-xl bg-white dark:bg-[#1a2c35] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden opacity-90 hover:opacity-100 transition-all">
                        <div class="w-full md:w-64 md:min-w-64 h-48 md:h-auto bg-center bg-no-repeat bg-cover filter grayscale-[30%] hover:grayscale-0 transition-all" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuADzzgno89ibQ2PGCNgYnD_Sd6B80dPregili6grHdHki77wigy1-J-_5sKnnVjpsvKU6bhvgwdsK0Qs1HV_0LYSf4fIlkNsqNqqjGjz2woZ6JCbPQeilaMxat4kJnpKYeT9TNWLyepg6MZJ1LG86EJUPnunZjpN1ml7jZ0qwHvW8DdnPUp5j2gQutHxk6C4R0N-ZAmTSmlcd-JoGQskF2BY5IwgnI0bRcQos8YDY0fOppdaLPROMEA6yG6wTSLfJ5ZVamfjm_rGJM");'>
                            <div class="absolute top-2 left-2 bg-gray-500 text-white text-xs font-bold px-2 py-1 rounded shadow">Finalizada</div>
                        </div>
                        <div class="flex flex-1 flex-col justify-between p-5 gap-3">
                            <div>
                                <h3 class="text-[#111618] dark:text-white text-lg font-bold leading-tight">Estudio Centro Histórico</h3>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Ene 10 - Ene 14, 2024</p>
                            </div>
                            <div class="flex items-center justify-between pt-2 mt-1">
                                <div class="flex items-center gap-1 text-yellow-500">
                                    <span class="material-symbols-outlined text-lg">star</span>
                                    <span class="material-symbols-outlined text-lg">star</span>
                                    <span class="material-symbols-outlined text-lg">star</span>
                                    <span class="material-symbols-outlined text-lg">star</span>
                                    <span class="material-symbols-outlined text-lg">star</span>
                                </div>
                                <button class="flex items-center justify-center rounded-lg h-9 px-4 border border-[#dbe2e6] dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 text-[#111618] dark:text-white text-sm font-medium transition-colors">
                                    <span class="mr-2 material-symbols-outlined text-sm">edit</span>
                                    Escribir reseña
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-8">
                <div class="bg-white dark:bg-[#1a2c35] rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-5">
                    <h3 class="text-[#111618] dark:text-white font-bold text-base mb-4">Servicios del Apartamento</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex flex-col items-center justify-center p-4 rounded-lg bg-[#f0f3f4] dark:bg-gray-800 border border-transparent hover:border-primary/20 transition-all group">
                            <span class="material-symbols-outlined text-3xl mb-2 text-primary">wifi</span>
                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300 text-center">WiFi</span>
                        </div>
                        <div class="flex flex-col items-center justify-center p-4 rounded-lg bg-[#f0f3f4] dark:bg-gray-800 border border-transparent hover:border-primary/20 transition-all group">
                            <span class="material-symbols-outlined text-3xl mb-2 text-primary">ac_unit</span>
                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300 text-center">Aire Acondicionado</span>
                        </div>
                        <div class="flex flex-col items-center justify-center p-4 rounded-lg bg-[#f0f3f4] dark:bg-gray-800 border border-transparent hover:border-primary/20 transition-all group">
                            <span class="material-symbols-outlined text-3xl mb-2 text-primary">pool</span>
                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300 text-center">Piscina</span>
                        </div>
                        <div class="flex flex-col items-center justify-center p-4 rounded-lg bg-[#f0f3f4] dark:bg-gray-800 border border-transparent hover:border-primary/20 transition-all group">
                            <span class="material-symbols-outlined text-3xl mb-2 text-primary">local_parking</span>
                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300 text-center">Estacionamiento</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-[#1a2c35] rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-0 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-[#111618] dark:text-white font-bold text-base">Mis Solicitudes (PQR)</h3>
                        <span class="bg-primary/10 text-primary text-xs font-bold px-2 py-1 rounded">1 Activa</span>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-start gap-3 p-4 border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors cursor-pointer">
                            <div class="mt-1 size-2 rounded-full bg-yellow-400 shadow-[0_0_4px_rgba(250,204,21,0.6)]"></div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-[#111618] dark:text-white">Aire Acondicionado</p>
                                <p class="text-xs text-gray-500 mt-1">Reportado: Hoy, 10:30 AM</p>
                                <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1 font-medium">En revisión</p>
                            </div>
                            <span class="material-symbols-outlined text-gray-400 text-sm">chevron_right</span>
                        </div>
                        <div class="flex items-start gap-3 p-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors cursor-pointer opacity-70">
                            <div class="mt-1 size-2 rounded-full bg-green-500"></div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-[#111618] dark:text-white">Toallas Extra</p>
                                <p class="text-xs text-gray-500 mt-1">Reportado: Ayer</p>
                                <p class="text-xs text-green-600 dark:text-green-400 mt-1 font-medium">Resuelto</p>
                            </div>
                            <span class="material-symbols-outlined text-gray-400 text-sm">chevron_right</span>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/30">
                        <button class="w-full flex items-center justify-center gap-2 rounded-lg h-10 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-[#111618] dark:text-white text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <span class="material-symbols-outlined text-lg">add_circle</span>
                            Nueva Solicitud
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>