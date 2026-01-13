<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Gestión de Reservas</title>
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

        .table-fixed-header thead th {
            position: sticky;
            top: 0;
            z-index: 10;
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
                <div class="overflow-hidden">
                    <h1 class="text-base font-bold text-text-main dark:text-white leading-none truncate">Santamartabeachfront</h1>
                    <p class="text-xs text-text-secondary dark:text-gray-400 mt-1">Panel de Control</p>
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
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-primary/10 text-primary" href="#">
                    <span class="material-symbols-outlined fill-1">calendar_month</span>
                    <span class="text-sm font-semibold">Reservas</span>
                    <span class="ml-auto bg-primary text-white text-xs font-bold px-2 py-0.5 rounded-full">4</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/usuarios.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">group</span>
                    <span class="text-sm font-medium">Usuarios</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/pqr.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">mail</span>
                    <span class="text-sm font-medium">PQR</span>
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
                    <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 shrink-0" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAOfx1jkgxwm9zlbZR0lOOKNhursPzJEX_HrEdIhkTEAmjxdc8YohVFqVhIrGODj9bhufn3wlx1TXrYwuqV35s_rxnnDGvEOZV7f8APW_tjqYTFunDTA7i61UgYWImcEh6m02qTbC1saZBlLUZ2wH2g4rt5nbidTdo36LEtRAI0YaTbfoHsaMJZuJui-uLAPbzK2uYCsjY8PmjBc757NdZ38WBJRDSJ8ffLT8urkrI3oAOo8ep6E1v19WCUenhDDx-4AtHwvTmgnSA");'></div>
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
                    <h2 class="text-lg font-bold text-text-main dark:text-white">Sección de Reservas</h2>
                </div>
                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex items-center bg-background-light dark:bg-gray-800 rounded-lg px-3 py-1.5 border border-transparent focus-within:border-primary/50 transition-all">
                        <span class="material-symbols-outlined text-text-secondary text-lg">search</span>
                        <input class="bg-transparent border-none focus:ring-0 text-sm w-48 text-text-main dark:text-white placeholder:text-text-secondary" placeholder="Buscar por ID o huésped..." type="text" />
                    </div>
                    <button class="relative size-10 flex items-center justify-center rounded-full hover:bg-background-light dark:hover:bg-gray-800 text-text-secondary transition-colors">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute top-2.5 right-2.5 size-2 bg-red-500 rounded-full border border-white dark:border-gray-900"></span>
                    </button>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-4 md:p-8 space-y-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">calendar_today</span>
                            </div>
                            <div>
                                <p class="text-text-secondary dark:text-gray-400 text-xs font-semibold uppercase tracking-wider">Total Reservas</p>
                                <h3 class="text-2xl font-bold text-text-main dark:text-white">1,284</h3>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center gap-1 text-green-600 text-xs font-bold">
                            <span class="material-symbols-outlined text-sm">trending_up</span>
                            <span>+12.5% este mes</span>
                        </div>
                    </div>
                    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="bg-orange-100 dark:bg-orange-900/30 p-3 rounded-lg">
                                <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">pending_actions</span>
                            </div>
                            <div>
                                <p class="text-text-secondary dark:text-gray-400 text-xs font-semibold uppercase tracking-wider">Pendientes</p>
                                <h3 class="text-2xl font-bold text-text-main dark:text-white">18</h3>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center gap-1 text-orange-600 text-xs font-bold">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            <span>Requieren atención inmediata</span>
                        </div>
                    </div>
                    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg">
                                <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">check_circle</span>
                            </div>
                            <div>
                                <p class="text-text-secondary dark:text-gray-400 text-xs font-semibold uppercase tracking-wider">Completadas</p>
                                <h3 class="text-2xl font-bold text-text-main dark:text-white">942</h3>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center gap-1 text-text-secondary text-xs font-bold">
                            <span class="material-symbols-outlined text-sm">history</span>
                            <span>Histórico acumulado</span>
                        </div>
                    </div>
                </div>
                <div class="bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-[#f0f3f4] dark:border-gray-800 bg-background-light/30 dark:bg-gray-800/20">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <div class="flex items-center gap-2 bg-white dark:bg-gray-800 px-3 py-2 rounded-lg border border-[#e5e7eb] dark:border-gray-700">
                                    <span class="material-symbols-outlined text-text-secondary text-sm">calendar_month</span>
                                    <input class="bg-transparent border-none p-0 text-sm focus:ring-0 text-text-main dark:text-white" placeholder="Check-in" type="date" />
                                    <span class="text-text-secondary text-xs">a</span>
                                    <input class="bg-transparent border-none p-0 text-sm focus:ring-0 text-text-main dark:text-white" placeholder="Check-out" type="date" />
                                </div>
                                <div class="relative min-w-[160px]">
                                    <select class="w-full bg-white dark:bg-gray-800 border-[#e5e7eb] dark:border-gray-700 rounded-lg text-sm text-text-main dark:text-white focus:ring-primary focus:border-primary">
                                        <option value="">Apartamento</option>
                                        <option value="1">Suite Panorámica 201</option>
                                        <option value="2">Penthouse Vista Mar</option>
                                        <option value="3">Estudio Brisa Marina</option>
                                    </select>
                                </div>
                                <div class="relative min-w-[140px]">
                                    <select class="w-full bg-white dark:bg-gray-800 border-[#e5e7eb] dark:border-gray-700 rounded-lg text-sm text-text-main dark:text-white focus:ring-primary focus:border-primary">
                                        <option value="">Estado</option>
                                        <option value="confirmed">Confirmada</option>
                                        <option value="pending">Pendiente</option>
                                        <option value="cancelled">Cancelada</option>
                                        <option value="completed">Completada</option>
                                    </select>
                                </div>
                                <button class="bg-white dark:bg-gray-800 border border-[#e5e7eb] dark:border-gray-700 px-4 py-2 rounded-lg text-sm font-medium text-text-main dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">filter_alt_off</span>
                                    Limpiar
                                </button>
                            </div>
                            <button class="bg-primary hover:bg-primary-hover text-white px-5 py-2 rounded-lg font-semibold text-sm transition-all shadow-md flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-lg">download</span>
                                Exportar CSV
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse table-fixed-header">
                            <thead>
                                <tr class="bg-background-light dark:bg-gray-800/50 text-text-secondary dark:text-gray-400 text-xs uppercase tracking-wider">
                                    <th class="px-6 py-4 font-bold w-24">ID</th>
                                    <th class="px-6 py-4 font-bold">Huésped</th>
                                    <th class="px-6 py-4 font-bold">Apartamento</th>
                                    <th class="px-6 py-4 font-bold">Fechas</th>
                                    <th class="px-6 py-4 font-bold">Total</th>
                                    <th class="px-6 py-4 font-bold">Estado</th>
                                    <th class="px-6 py-4 font-bold text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#f0f3f4] dark:divide-gray-800 text-sm">
                                <tr class="group hover:bg-background-light/50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="px-6 py-4 text-text-secondary font-mono">#RS-8421</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-text-main dark:text-white">Mariana Restrepo</span>
                                            <span class="text-xs text-text-secondary">mariana.r@example.com</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="size-8 rounded bg-cover bg-center shrink-0" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDJsRhoDPSUkrg1TXKAJGqmSmswPsjOFi5b7Fj0Z6cQb0bNJSOkXqCDruxUeX4eKkomczP03BjMwQrYBp7WE7jqlcRGu92uNF0xcJiqK3lWUVN4g_C_pB-KIcUkgodrVOOLBK1M8K32--h8RxvrHi6Cs4fXmemFarxo45qV8lwAhh3lziMl86NSkZpOceZYgbLz4zSbGgkyh5S2k5a1baUtW3Oj_9QIiYdoPSSCtz7Z200grK9YwVr5PW63fPBXCgltMRHJN-oBA0c");'></div>
                                            <span class="font-medium text-text-main dark:text-white truncate max-w-[150px]">Suite Panorámica 201</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-text-main dark:text-white">
                                        <div class="flex flex-col">
                                            <span class="flex items-center gap-1 text-xs">15 Oct - 20 Oct</span>
                                            <span class="text-[10px] text-text-secondary">5 noches • 2 personas</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-text-main dark:text-white">$1,250.00</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                            <span class="size-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                            Confirmada
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <button class="size-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-text-secondary hover:text-primary transition-colors" title="Ver detalle">
                                                <span class="material-symbols-outlined text-lg">visibility</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="group hover:bg-background-light/50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="px-6 py-4 text-text-secondary font-mono">#RS-8422</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-text-main dark:text-white">Carlos Vives</span>
                                            <span class="text-xs text-text-secondary">c.vives@music.com</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="size-8 rounded bg-cover bg-center shrink-0" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCb2X-Eex6B48RtwIM9J6ZojRw2j6gFsMWUl1F_Oj8DCgqbSdYvWPZ2MdJkSujwTYUOzzJoVaw3csjI2XVmV18Pki0wbr-CpjHp6b5DBg_u5qMdEs3DFkn0M3jj2tnSSMyKRzF5svGwD2NextX4bU9H1dYYF7YS5hOpvno4e6g0QO621qwc9fw7zwidnlIOxCPXacYmiHf-t7Fnhxu5gJ8QKKHdAORwdKRCkQIei1FaqNUeu2JaTG7LAnAWXcRRbuh609yfmF8Nri8");'></div>
                                            <span class="font-medium text-text-main dark:text-white truncate max-w-[150px]">Penthouse Vista Mar</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-text-main dark:text-white">
                                        <div class="flex flex-col">
                                            <span class="flex items-center gap-1 text-xs">22 Oct - 25 Oct</span>
                                            <span class="text-[10px] text-text-secondary">3 noches • 4 personas</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-text-main dark:text-white">$2,100.00</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                                            <span class="size-1.5 bg-yellow-500 rounded-full mr-1.5"></span>
                                            Pendiente
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <button class="size-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-text-secondary hover:text-primary transition-colors" title="Ver detalle">
                                                <span class="material-symbols-outlined text-lg">visibility</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="group hover:bg-background-light/50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="px-6 py-4 text-text-secondary font-mono">#RS-8423</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-text-main dark:text-white">Lucía Méndez</span>
                                            <span class="text-xs text-text-secondary">lucia.m@web.co</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="size-8 rounded bg-cover bg-center shrink-0" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD3RyyhDtcExthP4nweByKLcW_0fZJZv90FImn8nZf978lSX9Z83jw0UogJLa4xnQpLrEiF0w1Cd63cphjaln66maFM6vfOivzMCKe21JhgVWOn7N88gOqwQtImpv70wOiusdrBV9wlOA81-_X6hn9Dhy_TbZoWA2jV3muXXCzkUOFu_59cCX5Qj4MpPZ-ey90iGOcrAi89ormuqPaG-Bardw-4CKqdkpsJooP2izswwRacfdxnPrHzjXhUcDsbY4TEvIjWWI9tGaU");'></div>
                                            <span class="font-medium text-text-main dark:text-white truncate max-w-[150px]">Estudio Brisa Marina</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-text-main dark:text-white">
                                        <div class="flex flex-col">
                                            <span class="flex items-center gap-1 text-xs">05 Nov - 10 Nov</span>
                                            <span class="text-[10px] text-text-secondary">5 noches • 1 persona</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-text-main dark:text-white">$650.00</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                            <span class="size-1.5 bg-blue-500 rounded-full mr-1.5"></span>
                                            Completada
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <button class="size-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-text-secondary hover:text-primary transition-colors" title="Ver detalle">
                                                <span class="material-symbols-outlined text-lg">visibility</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="group hover:bg-background-light/50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="px-6 py-4 text-text-secondary font-mono">#RS-8424</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-text-main dark:text-white">Jorge Isaacs</span>
                                            <span class="text-xs text-text-secondary">jorge.i@mail.com</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="size-8 rounded bg-cover bg-center shrink-0" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCJ6c7T-MKs3zCrGDGJorBmC_Zejtem0sP_yBxRYPa73SV9M1gJ9MskKO1R03jZs4YKmdlpRKJ_V-xAcnkwUKNbyEKBVavMYmLTJKPZwySEaiFfw6VdKNFR0DqIFCFSgMaFg7umzSKu-IfHyb6yO7JtT8uUoeDDmL_5dfATNrmLrFwvUZnyGowygpi_hKJ4c-97FEHHbGF4cPBumWwyB2EHApJNkaR01tSHnyvb7lh4uS8pWyqdT-YEsFv6ckhDlFpQEOftz2_Bj_w");'></div>
                                            <span class="font-medium text-text-main dark:text-white truncate max-w-[150px]">Suite Panorámica 201</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-text-main dark:text-white">
                                        <div class="flex flex-col">
                                            <span class="flex items-center gap-1 text-xs">10 Dic - 15 Dic</span>
                                            <span class="text-[10px] text-text-secondary">5 noches • 2 personas</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-text-main dark:text-white">$1,250.00</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                            <span class="size-1.5 bg-red-500 rounded-full mr-1.5"></span>
                                            Cancelada
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <button class="size-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-text-secondary hover:text-primary transition-colors" title="Ver detalle">
                                                <span class="material-symbols-outlined text-lg">visibility</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-[#f0f3f4] dark:border-gray-800 flex items-center justify-between">
                        <p class="text-xs text-text-secondary">Mostrando <span class="font-bold text-text-main dark:text-white">1-10</span> de <span class="font-bold text-text-main dark:text-white">1,284</span> reservas</p>
                        <div class="flex items-center gap-2">
                            <button class="size-8 flex items-center justify-center rounded-lg border border-[#e5e7eb] dark:border-gray-700 text-text-secondary hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <span class="material-symbols-outlined text-lg">chevron_left</span>
                            </button>
                            <button class="size-8 flex items-center justify-center rounded-lg bg-primary text-white font-bold text-xs">1</button>
                            <button class="size-8 flex items-center justify-center rounded-lg border border-[#e5e7eb] dark:border-gray-700 text-text-secondary hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors text-xs font-bold">2</button>
                            <button class="size-8 flex items-center justify-center rounded-lg border border-[#e5e7eb] dark:border-gray-700 text-text-secondary hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors text-xs font-bold">3</button>
                            <button class="size-8 flex items-center justify-center rounded-lg border border-[#e5e7eb] dark:border-gray-700 text-text-secondary hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <span class="material-symbols-outlined text-lg">chevron_right</span>
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>

</html>