<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Gestión de Usuarios</title>
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

        #add-user-modal:target {
            display: flex;
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
                    <h1 class="text-base font-bold text-text-main dark:text-white leading-none">Santamartabeachfront</h1>
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
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-primary/10 text-primary" href="#users-section">
                    <span class="material-symbols-outlined fill-1">group</span>
                    <span class="text-sm font-semibold">Usuarios</span>
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
                    <h2 class="text-lg font-bold text-text-main dark:text-white hidden sm:block">Gestión de Usuarios</h2>
                </div>
                <div class="flex items-center gap-4 flex-1 justify-end">
                    <div class="hidden md:flex max-w-md w-full relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">search</span>
                        <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white placeholder:text-text-secondary" placeholder="Buscar por nombre, correo o rol..." type="text" />
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="relative size-10 flex items-center justify-center rounded-full hover:bg-background-light dark:hover:bg-gray-800 text-text-secondary transition-colors">
                            <span class="material-symbols-outlined">notifications</span>
                            <span class="absolute top-2.5 right-2.5 size-2 bg-red-500 rounded-full border border-white dark:border-gray-900"></span>
                        </button>
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-4 md:p-8 space-y-6 scroll-smooth">
                <section id="users-header">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-text-main dark:text-white">Usuarios y Roles</h1>
                            <p class="text-text-secondary text-sm mt-1">Administra el acceso y los permisos de todos los miembros de la plataforma.</p>
                        </div>
                        <a class="flex items-center justify-center gap-2 bg-primary hover:bg-primary-hover text-white px-5 py-2.5 rounded-lg font-semibold transition-all shadow-lg shadow-primary/30" href="#add-user-modal">
                            <span class="material-symbols-outlined text-xl">person_add</span>
                            <span>Agregar Nuevo Administrador</span>
                        </a>
                    </div>
                </section>
                <section class="space-y-4">
                    <div class="flex flex-col sm:flex-row justify-between items-end sm:items-center border-b border-[#f0f3f4] dark:border-gray-800">
                        <nav class="flex gap-8 overflow-x-auto no-scrollbar">
                            <button class="pb-4 text-sm font-bold text-primary border-b-2 border-primary whitespace-nowrap">Todos <span class="ml-1 px-2 py-0.5 bg-primary/10 rounded-full text-[10px]">92</span></button>
                            <button class="pb-4 text-sm font-medium text-text-secondary hover:text-text-main dark:hover:text-white whitespace-nowrap transition-colors">Huéspedes <span class="ml-1 px-2 py-0.5 bg-gray-100 dark:bg-gray-800 rounded-full text-[10px]">86</span></button>
                            <button class="pb-4 text-sm font-medium text-text-secondary hover:text-text-main dark:hover:text-white whitespace-nowrap transition-colors">Administradores <span class="ml-1 px-2 py-0.5 bg-gray-100 dark:bg-gray-800 rounded-full text-[10px]">6</span></button>
                        </nav>
                        <div class="pb-3 flex gap-2">
                            <button class="p-2 text-text-secondary hover:text-primary transition-colors bg-white dark:bg-card-dark border border-[#f0f3f4] dark:border-gray-800 rounded-lg shadow-sm">
                                <span class="material-symbols-outlined text-xl">filter_list</span>
                            </button>
                        </div>
                    </div>
                </section>
                <section id="users-section">
                    <div class="bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse min-w-[800px]">
                                <thead>
                                    <tr class="bg-background-light dark:bg-gray-800/50 text-text-secondary dark:text-gray-400 text-xs uppercase tracking-wider">
                                        <th class="px-6 py-4 font-semibold">Nombre</th>
                                        <th class="px-6 py-4 font-semibold">Correo</th>
                                        <th class="px-6 py-4 font-semibold text-center">Rol</th>
                                        <th class="px-6 py-4 font-semibold">Fecha Registro</th>
                                        <th class="px-6 py-4 font-semibold">Estado</th>
                                        <th class="px-6 py-4 font-semibold text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#f0f3f4] dark:divide-gray-800 text-sm">
                                    <tr class="group hover:bg-background-light dark:hover:bg-gray-800 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="size-9 rounded-full bg-cover bg-center shrink-0 border border-gray-100 dark:border-gray-700" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBuGo_s_B3c96-GNEevJ0wwb26ABomNHRlHb_7qNVixCpCkcTAQdWrc6UxekK6s0oF4ENkAEkcGVvn3ga6cGa5fcMUrlylSYonUcNQRZIzzJg6KKIVIYk1xlz_UkzMhIlmJvH5blRsSRy82ab4U5Qog1Vz7ysbOItgghn0joazIcv-XFmSJrF9-USDCCCv8vOJsCwdq1Ps1Hz4U9lnYW9zI4_TJ8H2h-06oqOpi10QndSJuhFeBVa4Jj-kawNNggHFQLQHRDcQECZ0");'></div>
                                                <span class="font-bold text-text-main dark:text-white">Laura Gómez</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-text-secondary dark:text-gray-300">laura.admin@santamarta.com</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 uppercase">Administrador</span>
                                        </td>
                                        <td class="px-6 py-4 text-text-secondary dark:text-gray-400">12 Ene 2024</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-full text-xs font-medium text-green-600 bg-green-50 dark:bg-green-900/20 dark:text-green-400">
                                                <span class="size-1.5 rounded-full bg-green-600"></span>
                                                Activo
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-1">
                                                <button class="p-2 hover:bg-primary/10 text-text-secondary hover:text-primary rounded-lg transition-colors" title="Editar">
                                                    <span class="material-symbols-outlined text-lg">edit</span>
                                                </button>
                                                <button class="p-2 hover:bg-red-50 text-text-secondary hover:text-red-500 rounded-lg transition-colors" title="Dar de baja">
                                                    <span class="material-symbols-outlined text-lg">person_remove</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="group hover:bg-background-light dark:hover:bg-gray-800 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="size-9 rounded-full bg-cover bg-center shrink-0 border border-gray-100 dark:border-gray-700" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuC3jXy2e9ABdjf6vfsQA2OpYwQ7m6k4I4J0SkEl1PbnAMSbikKGICJGz7Lp3LwuvyW9Eo1U0y9dEPZcYnpjhVRG_7X62_ikh5LI8Ck5n009mufPtMJXDhVvzqn9p42Cw07OIS3xAVjSOBkcbzqopBLmbam1pDx5UWLWAsecFWnIatsTt722Ey3C0T0VcxhgdoPLb3CDogSWDQyTL43dgRoeKafZeLmvC383mMzDs8Nq94m1qvxWYITEfsfqXxMT247MkNGjNYGjnQc");'></div>
                                                <span class="font-bold text-text-main dark:text-white">Pedro Alvarez</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-text-secondary dark:text-gray-300">pedro.alvarez@gmail.com</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 uppercase">Huésped</span>
                                        </td>
                                        <td class="px-6 py-4 text-text-secondary dark:text-gray-400">15 Feb 2024</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-full text-xs font-medium text-green-600 bg-green-50 dark:bg-green-900/20 dark:text-green-400">
                                                <span class="size-1.5 rounded-full bg-green-600"></span>
                                                Activo
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-1">
                                                <button class="p-2 hover:bg-primary/10 text-text-secondary hover:text-primary rounded-lg transition-colors" title="Editar">
                                                    <span class="material-symbols-outlined text-lg">edit</span>
                                                </button>
                                                <button class="p-2 hover:bg-red-50 text-text-secondary hover:text-red-500 rounded-lg transition-colors" title="Dar de baja">
                                                    <span class="material-symbols-outlined text-lg">person_remove</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="group hover:bg-background-light dark:hover:bg-gray-800 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="size-9 rounded-full bg-cover bg-center shrink-0 border border-gray-100 dark:border-gray-700 grayscale" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCkt-6r3iuswTFaKexpdZFqCCBrXa5Z2rQeVfODjqUm7P9qlMVu2fw2kL0IqtQi7WNI7GMZJHr7q8KCdJOxHVOK09R2anAgSSu3FcLTE_FHeaCmkaSzKJ7zjWehMtTkLZoLEC4iWD95FCTWF7b70ae1-UZDb4FczwUTdMVLDCi94shtUbbfigVvVTRTn-KSjcY2YDMdX4N3Z9PpnBq0BYGxqR2nJANxxTXqHmbVyO_sTIxAV4p9Y5NJl3rz9BEFHySButmaVDpHFZQ");'></div>
                                                <span class="font-bold text-text-secondary dark:text-gray-400">Julián Torres</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-text-secondary dark:text-gray-300">julian.t@gmail.com</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 uppercase">Huésped</span>
                                        </td>
                                        <td class="px-6 py-4 text-text-secondary dark:text-gray-400">02 Dic 2023</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-full text-xs font-medium text-gray-500 bg-gray-50 dark:bg-gray-800 dark:text-gray-400">
                                                <span class="size-1.5 rounded-full bg-gray-400"></span>
                                                Inactivo
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-1">
                                                <button class="p-2 hover:bg-primary/10 text-text-secondary hover:text-primary rounded-lg transition-colors" title="Editar">
                                                    <span class="material-symbols-outlined text-lg">edit</span>
                                                </button>
                                                <button class="p-2 hover:bg-green-50 text-text-secondary hover:text-green-600 rounded-lg transition-colors" title="Activar">
                                                    <span class="material-symbols-outlined text-lg">person_check</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-4 border-t border-[#f0f3f4] dark:border-gray-800 flex flex-col sm:flex-row justify-between items-center gap-4">
                            <p class="text-xs text-text-secondary font-medium">Mostrando <span class="font-bold text-text-main dark:text-white">3</span> de <span class="font-bold text-text-main dark:text-white">92</span> usuarios</p>
                            <div class="flex gap-2">
                                <button class="px-4 py-1.5 text-xs font-semibold border border-[#f0f3f4] dark:border-gray-700 rounded-lg hover:bg-background-light dark:hover:bg-gray-800 transition-colors disabled:opacity-50" disabled="">Anterior</button>
                                <button class="px-4 py-1.5 text-xs font-semibold border border-[#f0f3f4] dark:border-gray-700 rounded-lg hover:bg-background-light dark:hover:bg-gray-800 transition-colors">Siguiente</button>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
        <div class="hidden fixed inset-0 z-50 bg-black/50 items-center justify-center p-4 backdrop-blur-sm" id="add-user-modal">
            <div class="bg-card-light dark:bg-card-dark w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                <div class="p-6 border-b border-[#f0f3f4] dark:border-gray-800 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-text-main dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">person_add</span>
                        Nuevo Administrador
                    </h3>
                    <a class="text-text-secondary hover:text-primary transition-colors" href="#">
                        <span class="material-symbols-outlined">close</span>
                    </a>
                </div>
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Nombre Completo</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">person</span>
                                <input class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white transition-shadow" placeholder="Ej: Juan Sebastian Pérez" type="text" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Correo Electrónico</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">mail</span>
                                <input class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white transition-shadow" placeholder="juan@ejemplo.com" type="email" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-text-main dark:text-white mb-2">Asignar Rol</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">badge</span>
                                <select class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-gray-800 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm text-text-main dark:text-white appearance-none cursor-pointer">
                                    <option value="guest">Huésped</option>
                                    <option value="admin">Administrador</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-text-secondary pointer-events-none">expand_more</span>
                            </div>
                            <p class="text-[11px] text-text-secondary mt-2">Los administradores tienen acceso total al panel de control.</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-background-light dark:bg-gray-800/50 border-t border-[#f0f3f4] dark:border-gray-800 flex justify-end gap-3">
                    <a class="px-6 py-2.5 text-sm font-bold text-text-secondary hover:text-text-main transition-colors" href="#">Cancelar</a>
                    <button class="px-6 py-2.5 bg-primary hover:bg-primary-hover text-white text-sm font-bold rounded-lg shadow-lg shadow-primary/30 transition-all">Crear Administrador</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>