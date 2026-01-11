<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Panel de Administrador</title>
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

        .card-hover-effect:hover {
            transform: translateY(-2px);
            transition: all 0.2s ease;
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
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-primary/10 text-primary" href="#">
                    <span class="material-symbols-outlined fill-1">dashboard</span>
                    <span class="text-sm font-semibold">Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="#apartments-section">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">apartment</span>
                    <span class="text-sm font-medium">Apartamentos</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="#bookings-section">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">calendar_month</span>
                    <span class="text-sm font-medium">Reservas</span>
                    <span class="ml-auto bg-primary text-white text-xs font-bold px-2 py-0.5 rounded-full">4</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="#users-section">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">group</span>
                    <span class="text-sm font-medium">Usuarios</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="#pqr-section">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">mail</span>
                    <span class="text-sm font-medium">PQR</span>
                </a>
                <div class="pt-4 mt-4 border-t border-[#f0f3f4] dark:border-gray-800">
                    <p class="px-3 text-xs font-semibold text-text-secondary uppercase tracking-wider mb-2">Sistema</p>
                    <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="#config-section">
                        <span class="material-symbols-outlined group-hover:text-primary transition-colors">settings</span>
                        <span class="text-sm font-medium">Configuración</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-red-50 hover:text-red-600 transition-colors group" href="#">
                        <span class="material-symbols-outlined group-hover:text-red-600 transition-colors">logout</span>
                        <span class="text-sm font-medium">Cerrar Sesión</span>
                    </a>
                </div>
            </div>
            <div class="p-4 border-t border-[#f0f3f4] dark:border-gray-800">
                <div class="flex items-center gap-3 bg-background-light dark:bg-gray-800 p-3 rounded-lg">
                    <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 shrink-0" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCzvH7sb1-qStnSjyW_73yFZuyDV7-Ez2-2LB3V9LiRgrVaP0tp_Kk2bt9RvnuHLpnRQe7JiDm7bwq_2wnzXuXZ-R-5XcOiQI8b3n76MYdNVwUFnHzbUBz8DnJ3mOJqVBJB3XZLkdjkLWIA3bK2AZVnmo-mlgAWRk_hf_1QVYuCIa9mk0_SN_rZwpFYSMXx9CGSEZ-Q5GtTTRX-vx3RJZ8qzgct2lexQnXKpF0xitcnMVaPElXaFz5LeT0rtCIzJ-EXlYRcbDbwcMM");'></div>
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
                    <h2 class="text-lg font-bold text-text-main dark:text-white hidden sm:block">Panel de Control</h2>
                </div>
                <div class="flex items-center gap-4 flex-1 justify-end">
                    <div class="hidden md:flex max-w-md w-full relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">search</span>
                        <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white placeholder:text-text-secondary" placeholder="Buscar..." type="text" />
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="relative size-10 flex items-center justify-center rounded-full hover:bg-background-light dark:hover:bg-gray-800 text-text-secondary transition-colors">
                            <span class="material-symbols-outlined">notifications</span>
                            <span class="absolute top-2.5 right-2.5 size-2 bg-red-500 rounded-full border border-white dark:border-gray-900"></span>
                        </button>
                        <button class="size-10 flex items-center justify-center rounded-full hover:bg-background-light dark:hover:bg-gray-800 text-text-secondary transition-colors">
                            <span class="material-symbols-outlined">help</span>
                        </button>
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-4 md:p-8 space-y-8 scroll-smooth">
                <section id="dashboard-section">
                    <div class="mb-8">
                        <h1 class="text-2xl font-extrabold text-text-main dark:text-white tracking-tight">Resumen Administrativo</h1>
                        <p class="text-text-secondary text-sm mt-1">Indicadores clave de rendimiento para hoy.</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
                        <div class="bg-card-light dark:bg-card-dark p-5 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm flex flex-col justify-between card-hover-effect group">
                            <div class="flex justify-between items-start mb-4">
                                <div class="size-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-xl">calendar_month</span>
                                </div>
                                <span class="text-green-500 text-xs font-bold flex items-center gap-0.5">
                                    <span class="material-symbols-outlined text-xs">trending_up</span> +12%
                                </span>
                            </div>
                            <div>
                                <h3 class="text-text-secondary dark:text-gray-400 text-sm font-medium">Total de Reservas</h3>
                                <div class="flex items-baseline gap-2 mt-1">
                                    <span class="text-3xl font-bold text-text-main dark:text-white">1,284</span>
                                </div>
                            </div>
                            <a class="mt-4 text-xs font-bold text-primary hover:underline flex items-center gap-1 group/link" href="#bookings-section">
                                Gestionar reservas
                                <span class="material-symbols-outlined text-xs group-hover/link:translate-x-0.5 transition-transform">arrow_forward</span>
                            </a>
                        </div>
                        <div class="bg-card-light dark:bg-card-dark p-5 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm flex flex-col justify-between card-hover-effect group">
                            <div class="flex justify-between items-start mb-4">
                                <div class="size-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-orange-600 text-xl">contact_support</span>
                                </div>
                                <span class="bg-red-100 text-red-600 text-[10px] px-1.5 py-0.5 rounded-full font-bold">8 Urgentes</span>
                            </div>
                            <div>
                                <h3 class="text-text-secondary dark:text-gray-400 text-sm font-medium">Total de PQR</h3>
                                <div class="flex items-baseline gap-2 mt-1">
                                    <span class="text-3xl font-bold text-text-main dark:text-white">42</span>
                                </div>
                            </div>
                            <a class="mt-4 text-xs font-bold text-primary hover:underline flex items-center gap-1 group/link" href="#pqr-section">
                                Atender solicitudes
                                <span class="material-symbols-outlined text-xs group-hover/link:translate-x-0.5 transition-transform">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </section>
                <section class="pt-8 border-t border-[#f0f3f4] dark:border-gray-800" id="apartments-section">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-text-main dark:text-white flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">apartment</span>
                            Gestión de Apartamentos
                        </h2>
                        <div class="flex gap-2">
                            <button class="px-4 py-2 text-xs font-medium text-text-secondary bg-white border border-[#f0f3f4] hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 rounded-lg transition-colors">Filtros</button>
                            <button class="px-4 py-2 text-xs font-medium text-white bg-primary hover:bg-primary-hover rounded-lg transition-colors flex items-center gap-2 shadow-lg shadow-primary/20">
                                <span class="material-symbols-outlined text-sm">add</span> Nuevo Apartamento
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        <div class="bg-card-light dark:bg-card-dark p-4 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm flex items-center gap-4 hover:border-primary/30 transition-colors">
                            <div class="w-20 h-20 rounded-lg bg-cover bg-center shrink-0" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuB2nUO0stMlK7B-JmGLBQUNZkVnyyJqNVZEiQEkzpBC7GwYEoNfZzHvpy7SP2904tIst4IJX2LVed9GhcZq4AczfeG9qtATUKxP9RiUKJdIzlFxsuWhkc_6V7id5p4oM-8MQPKqoH5PrVm0IijfYQDGsGvOSF3Gbwmt6Iu9KFZEc4GyPVBZzzGAvRP3ZwEKxCq63y5zN9T4xt-MWJKiUVsjHrJtzKlKLil4eNF7w4bwtipLBq14ierFj2TDQzSjmjSFGv9tZaB6Ekg");'></div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <div class="truncate">
                                        <h4 class="font-bold text-text-main dark:text-white truncate">Suite Panorámica 201</h4>
                                        <p class="text-[11px] text-text-secondary">Rodadero • 2 Hab • 4 Pax</p>
                                    </div>
                                    <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded-full font-bold">Activo</span>
                                </div>
                                <div class="mt-2 flex gap-3">
                                    <button class="text-[11px] font-medium text-text-secondary hover:text-primary flex items-center gap-1"><span class="material-symbols-outlined text-xs">edit</span> Editar</button>
                                    <button class="text-[11px] font-medium text-text-secondary hover:text-primary flex items-center gap-1"><span class="material-symbols-outlined text-xs">visibility</span> Ver</button>
                                </div>
                            </div>
                        </div>
                        <div class="bg-card-light dark:bg-card-dark p-4 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm flex items-center gap-4 hover:border-primary/30 transition-colors">
                            <div class="w-20 h-20 rounded-lg bg-cover bg-center shrink-0" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBH5a1VYfABPsvW73_GQfTc-eXT7aTVSJprnKRP3RM0TW3qIS2MklHlU9zyV-Dynlj8jRurZ4SRX6Ui5HFmrMN6j5uYfs1ZwyRTNjsDnAG2k9wLSSf-_Yj9YWZf2W3Z-k7a_bJD_uIc16wPYckC-cdoRg3-B0M_6OkA87D-5lumZlqOMmpC06h3nyTr0vTZRMHqgTAdTmSBO3J_mLJaGWveCLqK2bHFb8PDejNRkCLeRDuOGqTAyqf5WOeEsf0RI8r_KI-P53I4sKE");'></div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <div class="truncate">
                                        <h4 class="font-bold text-text-main dark:text-white truncate">Penthouse Vista Mar</h4>
                                        <p class="text-[11px] text-text-secondary">Pozos Colorados • 3 Hab • 8 Pax</p>
                                    </div>
                                    <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded-full font-bold">Activo</span>
                                </div>
                                <div class="mt-2 flex gap-3">
                                    <button class="text-[11px] font-medium text-text-secondary hover:text-primary flex items-center gap-1"><span class="material-symbols-outlined text-xs">edit</span> Editar</button>
                                    <button class="text-[11px] font-medium text-text-secondary hover:text-primary flex items-center gap-1"><span class="material-symbols-outlined text-xs">visibility</span> Ver</button>
                                </div>
                            </div>
                        </div>
                        <div class="bg-card-light dark:bg-card-dark p-4 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm flex items-center gap-4 hover:border-primary/30 transition-colors">
                            <div class="w-20 h-20 rounded-lg bg-cover bg-center shrink-0" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuB2nUO0stMlK7B-JmGLBQUNZkVnyyJqNVZEiQEkzpBC7GwYEoNfZzHvpy7SP2904tIst4IJX2LVed9GhcZq4AczfeG9qtATUKxP9RiUKJdIzlFxsuWhkc_6V7id5p4oM-8MQPKqoH5PrVm0IijfYQDGsGvOSF3Gbwmt6Iu9KFZEc4GyPVBZzzGAvRP3ZwEKxCq63y5zN9T4xt-MWJKiUVsjHrJtzKlKLil4eNF7w4bwtipLBq14ierFj2TDQzSjmjSFGv9tZaB6Ekg");'></div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <div class="truncate">
                                        <h4 class="font-bold text-text-main dark:text-white truncate">Estudio Moderno 4B</h4>
                                        <p class="text-[11px] text-text-secondary">Bello Horizonte • 1 Hab • 2 Pax</p>
                                    </div>
                                    <span class="bg-yellow-100 text-yellow-700 text-[10px] px-2 py-0.5 rounded-full font-bold">Mantenimiento</span>
                                </div>
                                <div class="mt-2 flex gap-3">
                                    <button class="text-[11px] font-medium text-text-secondary hover:text-primary flex items-center gap-1"><span class="material-symbols-outlined text-xs">edit</span> Editar</button>
                                    <button class="text-[11px] font-medium text-text-secondary hover:text-primary flex items-center gap-1"><span class="material-symbols-outlined text-xs">visibility</span> Ver</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="pt-8 border-t border-[#f0f3f4] dark:border-gray-800" id="bookings-section">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-text-main dark:text-white flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">calendar_month</span>
                            Control de Reservas
                        </h2>
                        <div class="relative">
                            <select class="pl-4 pr-10 py-2 text-xs border-none bg-white dark:bg-gray-800 rounded-lg focus:ring-1 focus:ring-primary shadow-sm appearance-none">
                                <option>Todas las reservas</option>
                                <option>Confirmadas</option>
                                <option>Pendientes</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-text-secondary text-base pointer-events-none">expand_more</span>
                        </div>
                    </div>
                    <div class="bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-background-light dark:bg-gray-800/50 text-text-secondary dark:text-gray-400 text-[10px] uppercase tracking-wider">
                                        <th class="px-6 py-3 font-semibold">Propiedad</th>
                                        <th class="px-6 py-3 font-semibold">Huésped</th>
                                        <th class="px-6 py-3 font-semibold">Fechas</th>
                                        <th class="px-6 py-3 font-semibold">Estado</th>
                                        <th class="px-6 py-3 font-semibold text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#f0f3f4] dark:divide-gray-800 text-sm">
                                    <tr class="group hover:bg-background-light dark:hover:bg-gray-800 transition-colors">
                                        <td class="px-6 py-3">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded bg-cover bg-center shrink-0" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuB2nUO0stMlK7B-JmGLBQUNZkVnyyJqNVZEiQEkzpBC7GwYEoNfZzHvpy7SP2904tIst4IJX2LVed9GhcZq4AczfeG9qtATUKxP9RiUKJdIzlFxsuWhkc_6V7id5p4oM-8MQPKqoH5PrVm0IijfYQDGsGvOSF3Gbwmt6Iu9KFZEc4GyPVBZzzGAvRP3ZwEKxCq63y5zN9T4xt-MWJKiUVsjHrJtzKlKLil4eNF7w4bwtipLBq14ierFj2TDQzSjmjSFGv9tZaB6Ekg");'></div>
                                                <span class="font-bold text-xs text-text-main dark:text-white">Suite 201</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-3">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-xs text-text-main dark:text-white">Ana García</span>
                                                <span class="text-[10px] text-text-secondary">ana.garcia@email.com</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-text-main dark:text-white font-medium text-xs">12 Mar - 15 Mar</td>
                                        <td class="px-6 py-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800">Confirmada</span>
                                        </td>
                                        <td class="px-6 py-3 text-right">
                                            <button class="bg-primary/10 text-primary hover:bg-primary/20 px-2.5 py-1 rounded text-[10px] font-bold transition-colors">Detalles</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <section class="pt-8 border-t border-[#f0f3f4] dark:border-gray-800 pb-16" id="pqr-section">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-text-main dark:text-white flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">mail</span>
                            Bandeja de PQR
                        </h2>
                        <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">3 Nuevas</span>
                    </div>
                    <div class="bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm flex flex-col divide-y divide-[#f0f3f4] dark:divide-gray-800">
                        <div class="p-4 hover:bg-background-light dark:hover:bg-gray-800 transition-colors cursor-pointer relative group flex items-start gap-4">
                            <div class="bg-cover bg-center rounded-full size-10 shrink-0 border border-gray-100 shadow-sm" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCkt-6r3iuswTFaKexpdZFqCCBrXa5Z2rQeVfODjqUm7P9qlMVu2fw2kL0IqtQi7WNI7GMZJHr7q8KCdJOxHVOK09R2anAgSSu3FcLTE_FHeaCmkaSzKJ7zjWehMtTkLZoLEC4iWD95FCTWF7b70ae1-UZDb4FczwUTdMVLDCi94shtUbbfigVvVTRTn-KSjcY2YDMdX4N3Z9PpnBq0BYGxqR2nJANxxTXqHmbVyO_sTIxAV4p9Y5NJl3rz9BEFHySButmaVDpHFZQ");'></div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-baseline mb-0.5">
                                    <p class="font-bold text-sm text-text-main dark:text-white">Roberto Gómez</p>
                                    <p class="text-[10px] text-text-secondary font-medium uppercase">Hace 2 horas</p>
                                </div>
                                <h5 class="text-xs font-semibold text-text-main mb-0.5">Aire acondicionado - Suite 201</h5>
                                <p class="text-xs text-text-secondary dark:text-gray-400 line-clamp-1">Problema con el aire acondicionado en la suite 201, por favor revisar urgente.</p>
                                <div class="mt-2 flex gap-2">
                                    <button class="text-[10px] font-bold bg-primary text-white px-3 py-1 rounded hover:bg-primary-hover transition-colors">Responder</button>
                                    <button class="text-[10px] font-bold bg-gray-100 dark:bg-gray-700 text-text-secondary px-3 py-1 rounded hover:bg-gray-200 transition-colors">Ver hilo</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>

</body>

</html>