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

        #apartment-modal {
            display: none;
        }

        #apartment-modal:target {
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
                    <p class="text-xs text-text-secondary dark:text-gray-400 mt-1">Admin Dashboard</p>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto px-4 py-2 space-y-1">
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/dashboard.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">dashboard</span>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-primary/10 text-primary transition-colors group" href="#apartments-section">
                    <span class="material-symbols-outlined fill-1">apartment</span>
                    <span class="text-sm font-semibold">Apartamentos</span>
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
                    <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 shrink-0" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCzvH7sb1-qStnSjyW_73yFZuyDV7-Ez2-2LB3V9LiRgrVaP0tp_Kk2bt9RvnuHLpnRQe7JiDm7bwq_2wnzXuXZ-R-5XcOiQI8b3n76MYdNVwUFnHzbUBz8DnJ3mOJqVBJB3XZLkdjkLWIA3bK2AZVnmo-mlgAWRk_hf_1QVYuCIa9mk0_SN_rZwpFYSMXx9CGSEZ-Q5GtTTRX-vx3RJZ8qzgct2lexQnXKpF0xitcnMVaPElXaFz5LeT0rtCIzJ-EXlYRcbDbwcMM");'></div>
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-sm font-bold truncate dark:text-white">Carlos Admin</span>
                        <span class="text-xs text-text-secondary dark:text-gray-400 truncate">admin@santamarta.com</span>
                    </div>
                </div>
            </div>
        </aside>
        <div class="flex flex-col flex-1 min-w-0 relative">
            <header class="h-16 bg-card-light dark:bg-card-dark border-b border-[#f0f3f4] dark:border-gray-800 flex items-center justify-between px-6 sticky top-0 z-10">
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-text-secondary hover:text-primary">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h2 class="text-lg font-bold text-text-main dark:text-white hidden sm:block">Apartamentos</h2>
                </div>
                <div class="flex items-center gap-4 flex-1 justify-end">
                    <div class="hidden md:flex max-w-md w-full relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-lg">search</span>
                        <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white placeholder:text-text-secondary" placeholder="Buscar por nombre o ubicación..." type="text" />
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="relative size-10 flex items-center justify-center rounded-full hover:bg-background-light dark:hover:bg-gray-800 text-text-secondary transition-colors">
                            <span class="material-symbols-outlined">notifications</span>
                            <span class="absolute top-2.5 right-2.5 size-2 bg-red-500 rounded-full border border-white dark:border-gray-900"></span>
                        </button>
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-4 md:p-8 space-y-8 scroll-smooth">
                <section class="space-y-6" id="apartments-section">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-text-main dark:text-white">Inventario de Propiedades</h2>
                            <p class="text-text-secondary text-sm mt-1">Gestiona los detalles, precios, multimedia y disponibilidad.</p>
                        </div>
                        <div class="flex gap-3">
                            <a class="flex items-center justify-center gap-2 bg-primary hover:bg-primary-hover text-white px-5 py-2.5 rounded-lg font-semibold transition-all shadow-lg shadow-primary/30" href="#apartment-modal">
                                <span class="material-symbols-outlined text-xl">add</span>
                                <span>Añadir Nuevo</span>
                            </a>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div class="bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm p-4 hover:shadow-md transition-shadow">
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="w-full md:w-48 h-32 rounded-lg bg-cover bg-center shrink-0 relative" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuB2nUO0stMlK7B-JmGLBQUNZkVnyyJqNVZEiQEkzpBC7GwYEoNfZzHvpy7SP2904tIst4IJX2LVed9GhcZq4AczfeG9qtATUKxP9RiUKJdIzlFxsuWhkc_6V7id5p4oM-8MQPKqoH5PrVm0IijfYQDGsGvOSF3Gbwmt6Iu9KFZEc4GyPVBZzzGAvRP3ZwEKxCq63y5zN9T4xt-MWJKiUVsjHrJtzKlKLil4eNF7w4bwtipLBq14ierFj2TDQzSjmjSFGv9tZaB6Ekg");'>
                                    <div class="absolute top-2 left-2 bg-black/50 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-0.5 rounded flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs">videocam</span> HD Video
                                    </div>
                                    <div class="m-2 absolute bottom-0 left-0 bg-black/50 backdrop-blur-sm text-white text-xs font-bold px-2 py-1 rounded">
                                        $450.000 / noche
                                    </div>
                                </div>
                                <div class="flex-1 flex flex-col justify-between">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <h3 class="text-lg font-bold text-text-main dark:text-white">Suite Panorámica 201</h3>
                                                <span class="bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-xs px-2 py-0.5 rounded-full font-bold border border-green-200 dark:border-green-900">Publicado</span>
                                            </div>
                                            <div class="flex items-center gap-1 text-text-secondary text-sm mb-2">
                                                <span class="material-symbols-outlined text-sm">location_on</span>
                                                Edificio Rodadero Real, Piso 12
                                            </div>
                                            <div class="flex items-center gap-4 text-sm text-text-secondary">
                                                <span class="flex items-center gap-1 bg-background-light dark:bg-gray-800 px-2 py-1 rounded"><span class="material-symbols-outlined text-sm">bed</span> 2 Hab</span>
                                                <span class="flex items-center gap-1 bg-background-light dark:bg-gray-800 px-2 py-1 rounded"><span class="material-symbols-outlined text-sm">shower</span> 2 Baños</span>
                                                <span class="flex items-center gap-1 bg-background-light dark:bg-gray-800 px-2 py-1 rounded"><span class="material-symbols-outlined text-sm">group</span> 4 Pax</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <a class="p-2 text-text-secondary hover:text-primary hover:bg-primary/10 rounded-lg transition-colors" href="#apartment-modal" title="Editar">
                                                <span class="material-symbols-outlined">edit</span>
                                            </a>
                                            <button class="p-2 text-text-secondary hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Eliminar">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-[#f0f3f4] dark:border-gray-800 flex justify-between items-center">
                                        <div class="text-xs text-text-secondary">
                                            Actualizado: <span class="font-medium text-text-main dark:text-white">Hace 2 horas</span>
                                        </div>
                                        <div class="flex gap-3">
                                            <button class="text-xs font-semibold text-primary hover:text-primary-hover flex items-center gap-1">
                                                <span class="material-symbols-outlined text-sm">video_library</span> Multimedia (12 Fotos, 2 Videos)
                                            </button>
                                            <button class="text-xs font-semibold text-primary hover:text-primary-hover flex items-center gap-1">
                                                <span class="material-symbols-outlined text-sm">calendar_month</span> Disponibilidad
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
            <div class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm justify-end transition-opacity" id="apartment-modal">
                <div class="w-full max-w-2xl h-full bg-card-light dark:bg-card-dark shadow-2xl overflow-y-auto border-l border-[#f0f3f4] dark:border-gray-800 flex flex-col">
                    <div class="px-6 py-4 border-b border-[#f0f3f4] dark:border-gray-800 flex justify-between items-center bg-card-light dark:bg-card-dark sticky top-0 z-10">
                        <div>
                            <h3 class="text-xl font-bold text-text-main dark:text-white">Gestionar Apartamento</h3>
                            <p class="text-xs text-text-secondary">Configura detalles y archivos multimedia.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg">
                                <button class="px-3 py-1 text-xs font-bold bg-white dark:bg-card-dark shadow-sm rounded text-green-600">Publicado</button>
                                <button class="px-3 py-1 text-xs font-medium text-text-secondary hover:text-text-main">Borrador</button>
                            </div>
                            <a class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors text-text-secondary" href="#">
                                <span class="material-symbols-outlined">close</span>
                            </a>
                        </div>
                    </div>
                    <div class="p-6 space-y-8">
                        <section class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-bold text-text-main dark:text-white uppercase tracking-wider">Multimedia (Fotos y Videos)</h4>
                                <div class="flex gap-2">
                                    <button class="text-xs font-medium text-primary bg-primary/10 px-2 py-1 rounded flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs">add_photo_alternate</span> Añadir Fotos
                                    </button>
                                    <button class="text-xs font-medium text-primary bg-primary/10 px-2 py-1 rounded flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs">videocam</span> Añadir Videos
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-6 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-background-light dark:hover:bg-gray-800 transition-colors group h-40">
                                    <span class="material-symbols-outlined text-4xl text-gray-400 group-hover:text-primary mb-2 transition-colors">upload_file</span>
                                    <p class="text-sm font-medium text-text-main dark:text-white">Subir archivos multimedia</p>
                                    <p class="text-xs text-text-secondary">Imágenes (JPG, PNG) o Video (MP4)</p>
                                </div>
                                <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 space-y-3 bg-gray-50 dark:bg-gray-800/40">
                                    <p class="text-xs font-bold text-text-secondary uppercase">Link de Video Externo</p>
                                    <div class="relative">
                                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-text-secondary text-sm">link</span>
                                        <input class="w-full bg-white dark:bg-gray-800 border-none rounded-lg pl-9 pr-3 py-2 text-xs text-text-main dark:text-white focus:ring-2 focus:ring-primary/50" placeholder="Ej: YouTube o Vimeo URL" type="text" />
                                    </div>
                                    <p class="text-[10px] text-text-secondary italic">Ideal para videos de alta duración o tours 360.</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-4 gap-2">
                                <div class="aspect-square rounded-lg bg-cover bg-center relative group" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuB2nUO0stMlK7B-JmGLBQUNZkVnyyJqNVZEiQEkzpBC7GwYEoNfZzHvpy7SP2904tIst4IJX2LVed9GhcZq4AczfeG9qtATUKxP9RiUKJdIzlFxsuWhkc_6V7id5p4oM-8MQPKqoH5PrVm0IijfYQDGsGvOSF3Gbwmt6Iu9KFZEc4GyPVBZzzGAvRP3ZwEKxCq63y5zN9T4xt-MWJKiUVsjHrJtzKlKLil4eNF7w4bwtipLBq14ierFj2TDQzSjmjSFGv9tZaB6Ekg");'>
                                    <button class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-0.5 opacity-0 group-hover:opacity-100 transition-opacity"><span class="material-symbols-outlined text-xs">close</span></button>
                                </div>
                                <div class="aspect-square rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center relative group overflow-hidden">
                                    <span class="material-symbols-outlined text-gray-500 text-3xl">play_circle</span>
                                    <div class="absolute bottom-0 inset-x-0 bg-black/60 text-[10px] text-white p-1 text-center">Video_01.mp4</div>
                                    <button class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-0.5 opacity-0 group-hover:opacity-100 transition-opacity z-10"><span class="material-symbols-outlined text-xs">close</span></button>
                                </div>
                                <div class="aspect-square rounded-lg bg-cover bg-center relative group" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBH5a1VYfABPsvW73_GQfTc-eXT7aTVSJprnKRP3RM0TW3qIS2MklHlU9zyV-Dynlj8jRurZ4SRX6Ui5HFmrMN6j5uYfs1ZwyRTNjsDnAG2k9wLSSf-_Yj9YWZf2W3Z-k7a_bJD_uIc16wPYckC-cdoRg3-B0M_6OkA87D-5lumZlqOMmpC06h3nyTr0vTZRMHqgTAdTmSBO3J_mLJaGWveCLqK2bHFb8PDejNRkCLeRDuOGqTAyqf5WOeEsf0RI8r_KI-P53I4sKE");'>
                                    <button class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-0.5 opacity-0 group-hover:opacity-100 transition-opacity"><span class="material-symbols-outlined text-xs">close</span></button>
                                </div>
                                <div class="aspect-square rounded-lg border border-gray-200 dark:border-gray-700 flex items-center justify-center text-gray-400 hover:text-primary hover:border-primary cursor-pointer transition-colors">
                                    <span class="material-symbols-outlined">add</span>
                                </div>
                            </div>
                        </section>
                        <section class="space-y-4">
                            <h4 class="text-sm font-bold text-text-main dark:text-white uppercase tracking-wider">Información Básica</h4>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-text-secondary mb-1">Nombre del Apartamento</label>
                                    <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg px-3 py-2 text-sm text-text-main dark:text-white focus:ring-2 focus:ring-primary/50" type="text" value="Suite Panorámica 201" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-text-secondary mb-1">Ubicación / Dirección</label>
                                    <div class="relative">
                                        <span class="material-symbols-outlined absolute left-3 top-2 text-text-secondary text-sm">location_on</span>
                                        <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg pl-9 pr-3 py-2 text-sm text-text-main dark:text-white focus:ring-2 focus:ring-primary/50" type="text" value="Edificio Rodadero Real, Piso 12" />
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-text-secondary mb-1">Descripción</label>
                                    <textarea class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg px-3 py-2 text-sm text-text-main dark:text-white focus:ring-2 focus:ring-primary/50" rows="4">Espectacular suite con vista directa al mar, recién remodelada con acabados de lujo y excelente iluminación natural.</textarea>
                                </div>
                            </div>
                        </section>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <section class="space-y-4">
                                <h4 class="text-sm font-bold text-text-main dark:text-white uppercase tracking-wider">Características</h4>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-text-secondary mb-1">Habitaciones</label>
                                        <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg px-3 py-2 text-sm focus:ring-primary/50" type="number" value="2" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-text-secondary mb-1">Baños</label>
                                        <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg px-3 py-2 text-sm focus:ring-primary/50" type="number" value="2" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-text-secondary mb-1">Max Huéspedes</label>
                                        <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg px-3 py-2 text-sm focus:ring-primary/50" type="number" value="4" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-text-secondary mb-1">Área (m²)</label>
                                        <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg px-3 py-2 text-sm focus:ring-primary/50" type="number" value="85" />
                                    </div>
                                </div>
                            </section>
                            <section class="space-y-4">
                                <h4 class="text-sm font-bold text-text-main dark:text-white uppercase tracking-wider">Precios</h4>
                                <div>
                                    <label class="block text-xs font-medium text-text-secondary mb-1">Precio por Noche (COP)</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2 text-text-secondary text-sm">$</span>
                                        <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg pl-7 pr-3 py-2 text-sm font-bold text-text-main dark:text-white focus:ring-2 focus:ring-primary/50" type="number" value="450000" />
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-text-secondary mb-1">Tarifa de Limpieza</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2 text-text-secondary text-sm">$</span>
                                        <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg pl-7 pr-3 py-2 text-sm text-text-main dark:text-white focus:ring-2 focus:ring-primary/50" type="number" value="60000" />
                                    </div>
                                </div>
                            </section>
                        </div>
                        <section class="space-y-4">
                            <h4 class="text-sm font-bold text-text-main dark:text-white uppercase tracking-wider">Disponibilidad (Marzo 2024)</h4>
                            <div class="border border-[#f0f3f4] dark:border-gray-800 rounded-lg p-4 bg-background-light dark:bg-gray-800/50">
                                <div class="grid grid-cols-7 gap-1 text-center mb-2">
                                    <span class="text-xs font-bold text-text-secondary">L</span>
                                    <span class="text-xs font-bold text-text-secondary">M</span>
                                    <span class="text-xs font-bold text-text-secondary">X</span>
                                    <span class="text-xs font-bold text-text-secondary">J</span>
                                    <span class="text-xs font-bold text-text-secondary">V</span>
                                    <span class="text-xs font-bold text-text-secondary">S</span>
                                    <span class="text-xs font-bold text-text-secondary">D</span>
                                </div>
                                <div class="grid grid-cols-7 gap-1 text-center text-sm">
                                    <span class="text-gray-300 dark:text-gray-700 py-1">27</span>
                                    <span class="text-gray-300 dark:text-gray-700 py-1">28</span>
                                    <span class="text-text-main dark:text-white py-1 hover:bg-gray-200 dark:hover:bg-gray-700 rounded cursor-pointer">1</span>
                                    <span class="text-text-main dark:text-white py-1 hover:bg-gray-200 dark:hover:bg-gray-700 rounded cursor-pointer">2</span>
                                    <span class="text-text-main dark:text-white py-1 hover:bg-gray-200 dark:hover:bg-gray-700 rounded cursor-pointer">3</span>
                                    <span class="bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-300 rounded py-1 cursor-not-allowed">4</span>
                                    <span class="bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-300 rounded py-1 cursor-not-allowed">5</span>
                                    <span class="text-text-main dark:text-white py-1 hover:bg-gray-200 dark:hover:bg-gray-700 rounded cursor-pointer">6</span>
                                    <span class="text-text-main dark:text-white py-1 hover:bg-gray-200 dark:hover:bg-gray-700 rounded cursor-pointer">7</span>
                                    <span class="bg-primary text-white rounded py-1">8</span>
                                    <span class="bg-primary text-white rounded py-1">9</span>
                                    <span class="bg-primary text-white rounded py-1">10</span>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="p-6 border-t border-[#f0f3f4] dark:border-gray-800 bg-background-light dark:bg-gray-900 sticky bottom-0 z-10 mt-auto">
                        <div class="flex justify-end gap-3">
                            <a class="px-5 py-2.5 rounded-lg border border-[#dbe2e6] dark:border-gray-700 text-text-secondary font-semibold hover:bg-white dark:hover:bg-gray-800 transition-colors" href="#">Cancelar</a>
                            <button class="px-5 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white font-bold shadow-lg shadow-primary/30 transition-all transform active:scale-95">Guardar Cambios</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>