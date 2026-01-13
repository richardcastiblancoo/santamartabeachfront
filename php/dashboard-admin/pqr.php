<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Panel Admin. (Gestión de PQR Simplificada)</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13a4ec",
                        "primary-hover": "#0e8ac7",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101c22",
                        "card-light": "#ffffff",
                        "card-dark": "#1a2c35",
                        "text-main": "#111618",
                        "text-secondary": "#617c89",
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
            font-size: 24px;
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

<body class="bg-background-light dark:bg-background-dark text-text-main dark:text-white font-display overflow-hidden">
    <div class="flex h-screen w-full">
        <aside class="w-72 bg-card-light dark:bg-card-dark border-r border-[#f0f3f4] dark:border-gray-800 flex flex-col h-full hidden md:flex shrink-0 z-20">
            <div class="p-6 flex items-center gap-3">
                <div class="bg-primary/10 p-2 rounded-lg">
                    <span class="material-symbols-outlined text-primary">beach_access</span>
                </div>
                <div>
                    <h1 class="text-base font-bold text-text-main dark:text-white leading-none">Santamarta</h1>
                    <p class="text-xs text-text-secondary dark:text-gray-400 mt-1">Beachfront Admin</p>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto px-4 py-2 space-y-1">
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/dashboard.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">dashboard</span>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/apartamentos.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">apartment</span>
                    <span class="text-sm font-medium">Apartamentos</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/reservas.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">calendar_month</span>
                    <span class="text-sm font-medium">Reservas</span>
                    <span class="ml-auto bg-primary text-white text-xs font-bold px-2 py-0.5 rounded-full">4</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/usuarios.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">group</span>
                    <span class="text-sm font-medium">Usuarios</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-primary/10 text-primary font-semibold" href="/php/dashboard-admin/pqr.php">
                    <span class="material-symbols-outlined fill-1">mail</span>
                    <span class="text-sm">PQR</span>
                </a>
                <div class="pt-4 mt-4 border-t border-[#f0f3f4] dark:border-gray-800">
                    <p class="px-3 text-xs font-semibold text-text-secondary uppercase tracking-wider mb-2">Sistema</p>
                    <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/configuracion.php">
                        <span class="material-symbols-outlined group-hover:text-primary transition-colors">settings</span>
                        <span class="text-sm font-medium">Configuración</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-red-50 hover:text-red-600 transition-colors group" href="../../auth/cerrar_sesion.php">
                        <span class="material-symbols-outlined group-hover:text-red-600 transition-colors">logout</span>
                        <span class="text-sm font-medium">Cerrar Sesión</span>
                    </a>
                </div>
            </div>
            <div class="p-4 border-t border-[#f0f3f4] dark:border-gray-800">
                <div class="flex items-center gap-3 bg-background-light dark:bg-gray-800 p-3 rounded-lg">
                    <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 shrink-0" data-alt="Admin profile picture showing a professional headshot" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCzvH7sb1-qStnSjyW_73yFZuyDV7-Ez2-2LB3V9LiRgrVaP0tp_Kk2bt9RvnuHLpnRQe7JiDm7bwq_2wnzXuXZ-R-5XcOiQI8b3n76MYdNVwUFnHzbUBz8DnJ3mOJqVBJB3XZLkdjkLWIA3bK2AZVnmo-mlgAWRk_hf_1QVYuCIa9mk0_SN_rZwpFYSMXx9CGSEZ-Q5GtTTRX-vx3RJZ8qzgct2lexQnXKpF0xitcnMVaPElXaFz5LeT0rtCIzJ-EXlYRcbDbwcMM");'></div>
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-sm font-bold truncate dark:text-white">Carlos Admin</span>
                        <span class="text-xs text-text-secondary dark:text-gray-400 truncate">admin@santamarta.com</span>
                    </div>
                </div>
            </div>
        </aside>
        <div class="flex flex-col flex-1 min-w-0">
            <header class="h-16 bg-card-light dark:bg-card-dark border-b border-[#f0f3f4] dark:border-gray-800 flex items-center justify-between px-6 sticky top-0 z-10">
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-text-secondary hover:text-primary">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h2 class="text-lg font-bold text-text-main dark:text-white hidden sm:block">Gestión de PQR</h2>
                </div>
                <div class="flex items-center gap-4 flex-1 justify-end">
                    <div class="hidden md:flex max-w-md w-full relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">search</span>
                        <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white placeholder:text-text-secondary" placeholder="Buscar por ticket, usuario o asunto..." type="text" />
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="relative size-10 flex items-center justify-center rounded-full hover:bg-background-light dark:hover:bg-gray-800 text-text-secondary transition-colors">
                            <span class="material-symbols-outlined">notifications</span>
                            <span class="absolute top-2.5 right-2.5 size-2 bg-red-500 rounded-full border border-white dark:border-gray-900"></span>
                        </button>
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-4 md:p-6 space-y-6 scroll-smooth bg-background-light dark:bg-background-dark">
                <div class="flex flex-col lg:flex-row h-[calc(100vh-8rem)] gap-6">
                    <div class="lg:w-2/5 xl:w-1/3 flex flex-col bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm overflow-hidden h-full">
                        <div class="p-4 border-b border-[#f0f3f4] dark:border-gray-800">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-bold text-text-main dark:text-white">Bandeja de Entrada</h2>
                                <button class="text-primary hover:text-primary-hover p-1 rounded-md hover:bg-primary/10">
                                    <span class="material-symbols-outlined">refresh</span>
                                </button>
                            </div>
                            <div class="flex gap-2 mb-4 overflow-x-auto pb-2 scrollbar-hide">
                                <button class="px-3 py-1.5 rounded-full text-xs font-semibold bg-primary text-white whitespace-nowrap">Todas (12)</button>
                                <button class="px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-100 text-text-secondary hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 whitespace-nowrap">Nuevas (5)</button>
                                <button class="px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-100 text-text-secondary hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 whitespace-nowrap">En Progreso (4)</button>
                                <button class="px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-100 text-text-secondary hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 whitespace-nowrap">Resueltas (3)</button>
                            </div>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-sm">filter_list</span>
                                <select class="w-full pl-9 pr-4 py-2 text-sm border border-[#f0f3f4] dark:border-gray-700 bg-background-light dark:bg-gray-900 rounded-lg focus:ring-1 focus:ring-primary text-text-secondary">
                                    <option>Todos los tipos</option>
                                    <option>Petición</option>
                                    <option>Queja</option>
                                    <option>Reclamo</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex-1 overflow-y-auto divide-y divide-[#f0f3f4] dark:divide-gray-800">
                            <div class="p-4 hover:bg-blue-50/50 dark:hover:bg-blue-900/10 cursor-pointer border-l-4 border-primary bg-blue-50/30 dark:bg-blue-900/5 transition-colors">
                                <div class="flex justify-between items-start mb-1">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                        <span class="text-xs font-bold text-red-500 uppercase">Queja #2023</span>
                                    </div>
                                    <span class="text-xs text-text-secondary">Hace 2h</span>
                                </div>
                                <h3 class="text-sm font-bold text-text-main dark:text-white mb-1 line-clamp-1">Problema con el aire acondicionado Suite 201</h3>
                                <p class="text-xs text-text-secondary mb-2 line-clamp-2">Hola, reporto que el aire acondicionado de la habitación principal no está enfriando correctamente...</p>
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-full bg-cover bg-center" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCkt-6r3iuswTFaKexpdZFqCCBrXa5Z2rQeVfODjqUm7P9qlMVu2fw2kL0IqtQi7WNI7GMZJHr7q8KCdJOxHVOK09R2anAgSSu3FcLTE_FHeaCmkaSzKJ7zjWehMtTkLZoLEC4iWD95FCTWF7b70ae1-UZDb4FczwUTdMVLDCi94shtUbbfigVvVTRTn-KSjcY2YDMdX4N3Z9PpnBq0BYGxqR2nJANxxTXqHmbVyO_sTIxAV4p9Y5NJl3rz9BEFHySButmaVDpHFZQ");'></div>
                                    <span class="text-xs text-text-main dark:text-gray-300">Roberto Gómez</span>
                                </div>
                            </div>
                            <div class="p-4 hover:bg-background-light dark:hover:bg-gray-800 cursor-pointer border-l-4 border-transparent transition-colors">
                                <div class="flex justify-between items-start mb-1">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                        <span class="text-xs font-bold text-yellow-600 dark:text-yellow-400 uppercase">Petición #2022</span>
                                    </div>
                                    <span class="text-xs text-text-secondary">Ayer</span>
                                </div>
                                <h3 class="text-sm font-bold text-text-main dark:text-white mb-1 line-clamp-1">Solicitud de Late Checkout</h3>
                                <p class="text-xs text-text-secondary mb-2 line-clamp-2">Quisiera saber si es posible extender mi salida hasta las 3pm el próximo domingo debido a mi vuelo...</p>
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-full bg-cover bg-center" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuACg-r7Wd05y8DXmahhHh-zKiimuDL6S_mq-YmVslUIxJEz985ccsMcirRJv7fuuSYELswWR8QsFBjuSpkiM-dz2p8oXFvDSQq3w-vYkEsEm9onBXH9Tihjl27UPlTczZ4d56BQUNWu98j4FIutvX6sVTiAt5WI3puaKaHobFYJS4y4Oqr3EKxDOfQO_BPFi55dW7kBpD9R6O6kK-5BNLyc4fskCZQlNILCgXaYFwO76zvwv2PzNuPtwOHccnvOU2PyC6wOuCri6Wo");'></div>
                                    <span class="text-xs text-text-main dark:text-gray-300">Laura Martínez</span>
                                </div>
                            </div>
                            <div class="p-4 hover:bg-background-light dark:hover:bg-gray-800 cursor-pointer border-l-4 border-transparent transition-colors">
                                <div class="flex justify-between items-start mb-1">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                        <span class="text-xs font-bold text-green-600 dark:text-green-400 uppercase">Reclamo #2020</span>
                                    </div>
                                    <span class="text-xs text-text-secondary">15 Mar</span>
                                </div>
                                <h3 class="text-sm font-bold text-text-main dark:text-white mb-1 line-clamp-1">Cobro adicional no reconocido</h3>
                                <p class="text-xs text-text-secondary mb-2 line-clamp-2">En mi factura aparece un cobro por minibar que no consumí. Solicito revisión inmediata de la cuenta.</p>
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-full bg-cover bg-center" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBuGo_s_B3c96-GNEevJ0wwb26ABomNHRlHb_7qNVixCpCkcTAQdWrc6UxekK6s0oF4ENkAEkcGVvn3ga6cGa5fcMUrlylSYonUcNQRZIzzJg6KKIVIYk1xlz_UkzMhIlmJvH5blRsSRy82ab4U5Qog1Vz7ysbOItgghn0joazIcv-XFmSJrF9-USDCCCv8vOJsCwdq1Ps1Hz4U9lnYW9zI4_TJ8H2h-06oqOpi10QndSJuhFeBVa4Jj-kawNNggHFQLQHRDcQECZ0");'></div>
                                    <span class="text-xs text-text-main dark:text-gray-300">Carlos Rodriguez</span>
                                </div>
                            </div>
                            <div class="p-4 hover:bg-background-light dark:hover:bg-gray-800 cursor-pointer border-l-4 border-transparent transition-colors opacity-60">
                                <div class="flex justify-between items-start mb-1">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold text-gray-500 uppercase">Petición #2019</span>
                                    </div>
                                    <span class="text-xs text-text-secondary">14 Mar</span>
                                </div>
                                <h3 class="text-sm font-bold text-text-main dark:text-white mb-1 line-clamp-1">Consulta sobre disponibilidad diciembre</h3>
                                <p class="text-xs text-text-secondary mb-2 line-clamp-2">Buenas tardes, quisiera reservar el Penthouse para las fechas de navidad...</p>
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-full bg-cover bg-center" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuB2nUO0stMlK7B-JmGLBQUNZkVnyyJqNVZEiQEkzpBC7GwYEoNfZzHvpy7SP2904tIst4IJX2LVed9GhcZq4AczfeG9qtATUKxP9RiUKJdIzlFxsuWhkc_6V7id5p4oM-8MQPKqoH5PrVm0IijfYQDGsGvOSF3Gbwmt6Iu9KFZEc4GyPVBZzzGAvRP3ZwEKxCq63y5zN9T4xt-MWJKiUVsjHrJtzKlKLil4eNF7w4bwtipLBq14ierFj2TDQzSjmjSFGv9tZaB6Ekg");'></div>
                                    <span class="text-xs text-text-main dark:text-gray-300">Ana Lopez</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm overflow-hidden h-full">
                        <div class="p-6 border-b border-[#f0f3f4] dark:border-gray-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <h2 class="text-xl font-bold text-text-main dark:text-white">Queja #2023</h2>
                                    <span class="bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400 text-xs px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Nueva</span>
                                </div>
                                <p class="text-sm text-text-secondary">Creado el 20 de Marzo, 2024 a las 10:30 AM</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-text-secondary bg-background-light hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-lg">history</span>
                                    Historial
                                </button>
                                <button class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors shadow-sm">
                                    <span class="material-symbols-outlined text-lg">check_circle</span>
                                    Marcar Resuelto
                                </button>
                            </div>
                        </div>
                        <div class="flex-1 overflow-y-auto p-6 space-y-6">
                            <div class="bg-background-light dark:bg-gray-900/50 p-4 rounded-lg flex items-center gap-4 border border-[#f0f3f4] dark:border-gray-800">
                                <div class="w-12 h-12 rounded-full bg-cover bg-center shrink-0 border-2 border-white dark:border-gray-700 shadow-sm" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCkt-6r3iuswTFaKexpdZFqCCBrXa5Z2rQeVfODjqUm7P9qlMVu2fw2kL0IqtQi7WNI7GMZJHr7q8KCdJOxHVOK09R2anAgSSu3FcLTE_FHeaCmkaSzKJ7zjWehMtTkLZoLEC4iWD95FCTWF7b70ae1-UZDb4FczwUTdMVLDCi94shtUbbfigVvVTRTn-KSjcY2YDMdX4N3Z9PpnBq0BYGxqR2nJANxxTXqHmbVyO_sTIxAV4p9Y5NJl3rz9BEFHySButmaVDpHFZQ");'></div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-text-main dark:text-white">Roberto Gómez</h4>
                                    <p class="text-sm text-text-secondary">Huésped • Suite Panorámica 201 • Reserva #BK-9821</p>
                                </div>
                                <div class="flex gap-2">
                                    <button class="p-2 text-text-secondary hover:text-primary hover:bg-white dark:hover:bg-gray-800 rounded-full transition-colors" title="Ver Perfil">
                                        <span class="material-symbols-outlined">person</span>
                                    </button>
                                    <button class="p-2 text-text-secondary hover:text-primary hover:bg-white dark:hover:bg-gray-800 rounded-full transition-colors" title="Ver Reserva">
                                        <span class="material-symbols-outlined">calendar_month</span>
                                    </button>
                                </div>
                            </div>
                            <div class="space-y-6">
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 rounded-full bg-cover bg-center shrink-0 mt-1" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCkt-6r3iuswTFaKexpdZFqCCBrXa5Z2rQeVfODjqUm7P9qlMVu2fw2kL0IqtQi7WNI7GMZJHr7q8KCdJOxHVOK09R2anAgSSu3FcLTE_FHeaCmkaSzKJ7zjWehMtTkLZoLEC4iWD95FCTWF7b70ae1-UZDb4FczwUTdMVLDCi94shtUbbfigVvVTRTn-KSjcY2YDMdX4N3Z9PpnBq0BYGxqR2nJANxxTXqHmbVyO_sTIxAV4p9Y5NJl3rz9BEFHySButmaVDpHFZQ");'></div>
                                    <div class="flex-1 space-y-2">
                                        <div class="flex items-baseline justify-between">
                                            <span class="font-bold text-text-main dark:text-white">Roberto Gómez</span>
                                            <span class="text-xs text-text-secondary">Hoy, 10:30 AM</span>
                                        </div>
                                        <div class="bg-background-light dark:bg-gray-800 p-4 rounded-r-xl rounded-bl-xl text-text-main dark:text-gray-200 text-sm leading-relaxed border border-[#f0f3f4] dark:border-gray-700">
                                            <p class="mb-2 font-bold">Asunto: Problema con el aire acondicionado Suite 201</p>
                                            <p>Hola, reporto que el aire acondicionado de la habitación principal no está enfriando correctamente. Hace un ruido extraño y solo sale aire a temperatura ambiente. Por favor revisar urgente ya que hace mucho calor.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 border-t border-[#f0f3f4] dark:border-gray-800 bg-background-light/50 dark:bg-gray-900/30">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-text-main dark:text-white mb-2">Responder al usuario</label>
                                <div class="relative">
                                    <textarea class="w-full bg-card-light dark:bg-gray-800 border border-[#dbe2e6] dark:border-gray-700 rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary text-text-main dark:text-white min-h-[120px] resize-none" placeholder="Escribe tu respuesta aquí..."></textarea>
                                    <div class="absolute bottom-2 left-2 flex gap-1">
                                        <button class="p-1.5 text-text-secondary hover:text-primary hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition-colors" title="Adjuntar archivo">
                                            <span class="material-symbols-outlined text-xl">attach_file</span>
                                        </button>
                                        <button class="p-1.5 text-text-secondary hover:text-primary hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition-colors" title="Plantillas de respuesta">
                                            <span class="material-symbols-outlined text-xl">description</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-text-secondary">Cambiar estado a:</span>
                                        <select class="bg-card-light dark:bg-gray-800 border border-[#dbe2e6] dark:border-gray-700 rounded-md text-sm py-1.5 pl-2 pr-8 focus:ring-1 focus:ring-primary text-text-main dark:text-white">
                                            <option>En Progreso</option>
                                            <option>Resuelto</option>
                                            <option>Pendiente Información</option>
                                        </select>
                                    </div>
                                </div>
                                <button class="bg-primary hover:bg-primary-hover text-white px-6 py-2 rounded-lg font-semibold transition-all shadow-lg shadow-primary/30 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">send</span>
                                    Enviar Respuesta
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>

</html>