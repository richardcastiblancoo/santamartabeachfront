<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Admin') {
    echo '<script>alert("Acceso denegado. Por favor, inicia sesión como administrador."); window.location = "../../auth/login.php";</script>';
    exit;
}
?>
<!DOCTYPE html>
<html class="dark" lang="es">

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
    <style type="text/tailwindcss">
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
        .color-swatch-active {
            @apply ring-2 ring-offset-2 ring-primary;
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
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/pqr.php">
                    <span class="material-symbols-outlined group-hover:text-primary transition-colors">mail</span>
                    <span class="text-sm font-medium">PQR</span>
                </a>
                <div class="pt-4 mt-4 border-t border-[#f0f3f4] dark:border-gray-800">
                    <p class="px-3 text-xs font-semibold text-text-secondary uppercase tracking-wider mb-2">Sistema</p>
                    <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-primary/10 text-primary" href="/php/dashboard-admin/configuracion.php">
                        <span class="material-symbols-outlined fill-1">settings</span>
                        <span class="text-sm font-semibold">Configuración</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-red-50 hover:text-red-600 transition-colors group" href="../../auth/cerrar_sesion.php">
                        <span class="material-symbols-outlined group-hover:text-red-600 transition-colors">logout</span>
                        <span class="text-sm font-medium">Cerrar Sesión</span>
                    </a>
                </div>
            </div>
            <div class="p-4 border-t border-[#f0f3f4] dark:border-gray-800">
                <div class="flex items-center gap-3 bg-background-light dark:bg-gray-800 p-3 rounded-lg">
                    <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 shrink-0" style='background-image: url("<?php echo !empty($_SESSION['imagen']) ? '../../assets/img/usuarios/' . $_SESSION['imagen'] : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCzvH7sb1-qStnSjyW_73yFZuyDV7-Ez2-2LB3V9LiRgrVaP0tp_Kk2bt9RvnuHLpnRQe7JiDm7bwq_2wnzXuXZ-R-5XcOiQI8b3n76MYdNVwUFnHzbUBz8DnJ3mOJqVBJB3XZLkdjkLWIA3bK2AZVnmo-mlgAWRk_hf_1QVYuCIa9mk0_SN_rZwpFYSMXx9CGSEZ-Q5GtTTRX-vx3RJZ8qzgct2lexQnXKpF0xitcnMVaPElXaFz5LeT0rtCIzJ-EXlYRcbDbwcMM'; ?>");'></div>
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-sm font-bold truncate dark:text-white"><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?></span>
                        <span class="text-xs text-text-secondary dark:text-gray-400 truncate"><?php echo $_SESSION['email']; ?></span>
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
                    <h2 class="text-lg font-bold text-text-main dark:text-white hidden sm:block">Ajustes de Cuenta</h2>
                </div>
                <div class="flex items-center gap-4 flex-1 justify-end">
                    
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-4 md:p-8 space-y-8 scroll-smooth bg-background-light dark:bg-background-dark">
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="w-full lg:w-64 shrink-0 space-y-1">
                        <h3 class="px-4 py-2 text-xs font-semibold text-text-secondary uppercase tracking-wider mb-2">Administración</h3>
                        <button class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-card-light dark:bg-card-dark text-primary border-l-4 border-primary shadow-sm" id="btn-profile" onclick="showTab('profile')">
                            <span class="material-symbols-outlined">person</span>
                            <span class="text-sm font-semibold">Perfil Personal</span>
                        </button>
                        <button class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary hover:bg-card-light dark:hover:bg-card-dark hover:text-text-main transition-colors group" id="btn-appearance" onclick="showTab('appearance')">
                            <span class="material-symbols-outlined group-hover:text-primary transition-colors">palette</span>
                            <span class="text-sm font-medium">Personalización</span>
                        </button>
                        <button class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary hover:bg-card-light dark:hover:bg-card-dark hover:text-text-main transition-colors group" id="btn-security" onclick="showTab('security')">
                            <span class="material-symbols-outlined group-hover:text-primary transition-colors">lock</span>
                            <span class="text-sm font-medium">Seguridad</span>
                        </button>
                    </div>
                    <div class="flex-1">
                        <div class="space-y-6" id="profile-settings">
                            <div class="bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm p-6">
                                <div class="mb-8 pb-4 border-b border-[#f0f3f4] dark:border-gray-800">
                                    <h2 class="text-xl font-bold text-text-main dark:text-white">Perfil Personal</h2>
                                    <p class="text-sm text-text-secondary mt-1">Actualiza tu información pública y datos de contacto.</p>
                                </div>
                                <form action="actualizar_perfil_be.php" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-8">
                                    <input type="hidden" name="update_profile" value="1">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="relative group">
                                            <div class="size-32 rounded-full overflow-hidden bg-background-light dark:bg-gray-800 border-2 border-[#f0f3f4] dark:border-gray-700">
                                                <img alt="Profile" class="w-full h-full object-cover" src="<?php echo !empty($_SESSION['imagen']) ? '../../assets/img/usuarios/' . $_SESSION['imagen'] : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCzvH7sb1-qStnSjyW_73yFZuyDV7-Ez2-2LB3V9LiRgrVaP0tp_Kk2bt9RvnuHLpnRQe7JiDm7bwq_2wnzXuXZ-R-5XcOiQI8b3n76MYdNVwUFnHzbUBz8DnJ3mOJqVBJB3XZLkdjkLWIA3bK2AZVnmo-mlgAWRk_hf_1QVYuCIa9mk0_SN_rZwpFYSMXx9CGSEZ-Q5GtTTRX-vx3RJZ8qzgct2lexQnXKpF0xitcnMVaPElXaFz5LeT0rtCIzJ-EXlYRcbDbwcMM'; ?>" />
                                            </div>
                                            <label for="file-upload" class="absolute bottom-0 right-0 bg-primary hover:bg-primary-hover text-white p-2 rounded-full shadow-lg border-2 border-white dark:border-gray-900 transition-all scale-90 group-hover:scale-100 cursor-pointer">
                                                <span class="material-symbols-outlined text-sm">photo_camera</span>
                                            </label>
                                            <input id="file-upload" name="imagen" type="file" class="hidden" accept="image/*" onchange="this.form.submit()">
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xs text-text-secondary">Sube una imagen de al menos 400x400px</p>
                                            <button type="submit" name="borrar_imagen" value="1" class="mt-2 text-xs font-bold text-primary hover:underline">Eliminar foto</button>
                                        </div>
                                    </div>
                                    <div class="flex-1 space-y-5">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="space-y-2">
                                                <label class="block text-sm font-medium text-text-main dark:text-white">Nombre</label>
                                                <input name="nombre" class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 px-4 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white" type="text" value="<?php echo $_SESSION['nombre']; ?>" />
                                            </div>
                                            <div class="space-y-2">
                                                <label class="block text-sm font-medium text-text-main dark:text-white">Apellido</label>
                                                <input name="apellido" class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 px-4 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white" type="text" value="<?php echo $_SESSION['apellido']; ?>" />
                                            </div>
                                            <div class="space-y-2 md:col-span-2">
                                                <label class="block text-sm font-medium text-text-main dark:text-white">Correo Electrónico</label>
                                                <input name="email" class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 px-4 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white" type="email" value="<?php echo $_SESSION['email']; ?>" />
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-end pt-4">
                                            <button class="bg-primary hover:bg-primary-hover text-white px-6 py-2 rounded-lg font-semibold transition-colors" type="submit">Guardar Cambios</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="space-y-6 hidden" id="appearance-settings">
                            <div class="bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm p-6">
                                <div class="mb-6 pb-4 border-b border-[#f0f3f4] dark:border-gray-800">
                                    <h2 class="text-xl font-bold text-text-main dark:text-white">Personalización de Tema</h2>
                                    <p class="text-sm text-text-secondary mt-1">Ajusta los colores y el modo visual de la plataforma.</p>
                                </div>
                                <div class="space-y-8">
                                    <div>
                                        <h3 class="text-sm font-bold text-text-main dark:text-white mb-4">Modo de Interfaz</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <button class="flex flex-col gap-3 p-4 rounded-xl border-2 border-primary bg-background-light dark:bg-gray-800 transition-all">
                                                <div class="w-full h-24 rounded-lg bg-white border border-gray-200 flex flex-col p-2 gap-1 shadow-sm">
                                                    <div class="w-full h-2 bg-gray-100 rounded"></div>
                                                    <div class="w-3/4 h-2 bg-gray-100 rounded"></div>
                                                    <div class="mt-auto flex justify-between">
                                                        <div class="size-4 rounded-full bg-primary"></div>
                                                        <div class="w-8 h-4 bg-gray-100 rounded"></div>
                                                    </div>
                                                </div>
                                                <span class="text-sm font-semibold flex items-center justify-center gap-2">
                                                    <span class="material-symbols-outlined text-sm">light_mode</span> Modo Claro
                                                </span>
                                            </button>
                                            <button class="flex flex-col gap-3 p-4 rounded-xl border-2 border-transparent bg-background-light dark:bg-gray-800 hover:border-gray-300 dark:hover:border-gray-600 transition-all">
                                                <div class="w-full h-24 rounded-lg bg-gray-900 border border-gray-800 flex flex-col p-2 gap-1 shadow-sm">
                                                    <div class="w-full h-2 bg-gray-800 rounded"></div>
                                                    <div class="w-3/4 h-2 bg-gray-800 rounded"></div>
                                                    <div class="mt-auto flex justify-between">
                                                        <div class="size-4 rounded-full bg-primary"></div>
                                                        <div class="w-8 h-4 bg-gray-800 rounded"></div>
                                                    </div>
                                                </div>
                                                <span class="text-sm font-medium flex items-center justify-center gap-2">
                                                    <span class="material-symbols-outlined text-sm">dark_mode</span> Modo Oscuro
                                                </span>
                                            </button>
                                            <button class="flex flex-col gap-3 p-4 rounded-xl border-2 border-transparent bg-background-light dark:bg-gray-800 hover:border-gray-300 dark:hover:border-gray-600 transition-all">
                                                <div class="w-full h-24 rounded-lg bg-gradient-to-br from-white to-gray-900 border border-gray-200 flex flex-col p-2 gap-1 shadow-sm overflow-hidden">
                                                    <div class="w-full h-2 bg-gray-200/50 rounded"></div>
                                                    <div class="w-3/4 h-2 bg-gray-200/50 rounded"></div>
                                                </div>
                                                <span class="text-sm font-medium flex items-center justify-center gap-2">
                                                    <span class="material-symbols-outlined text-sm">settings_brightness</span> Sistema
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-text-main dark:text-white mb-4">Color de Marca Personalizado</h3>
                                        <div class="flex flex-wrap gap-4">
                                            <button class="size-10 rounded-full bg-[#13a4ec] color-swatch-active"></button>
                                            <button class="size-10 rounded-full bg-[#34d399]"></button>
                                            <button class="size-10 rounded-full bg-[#f87171]"></button>
                                            <button class="size-10 rounded-full bg-[#fbbf24]"></button>
                                            <button class="size-10 rounded-full bg-[#818cf8]"></button>
                                            <button class="size-10 rounded-full bg-[#ec4899]"></button>
                                            <button class="size-10 rounded-full bg-white border border-gray-300 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-sm text-text-secondary">add</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-8 pt-4 border-t border-[#f0f3f4] dark:border-gray-800 flex justify-end">
                                    <button class="bg-primary hover:bg-primary-hover text-white px-6 py-2 rounded-lg font-semibold transition-colors" type="button">Aplicar Tema</button>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-6 hidden" id="security-settings">
                            <div class="bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm p-6">
                                <div class="mb-6 pb-4 border-b border-[#f0f3f4] dark:border-gray-800">
                                    <h2 class="text-xl font-bold text-text-main dark:text-white">Cambio de Usuario</h2>
                                    <p class="text-sm text-text-secondary mt-1">Actualiza tu nombre de usuario.</p>
                                </div>
                                <form action="actualizar_perfil_be.php" method="POST" class="space-y-4 max-w-lg">
                                    <input type="hidden" name="update_username" value="1">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-text-main dark:text-white">Usuario</label>
                                        <div class="relative">
                                            <input id="new_username" name="new_username" class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 pl-4 pr-10 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white" placeholder="Nombre de usuario" type="password" required value="<?php echo $_SESSION['usuario']; ?>" />
                                            <button type="button" onclick="togglePassword('new_username')" class="absolute right-3 top-1/2 -translate-y-1/2 text-text-secondary hover:text-text-main">
                                                <span class="material-symbols-outlined text-lg">visibility</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="pt-2">
                                        <button class="bg-primary hover:bg-primary-hover text-white px-6 py-2 rounded-lg font-semibold transition-colors" type="submit">Actualizar Usuario</button>
                                    </div>
                                </form>
                            </div>

                            <div class="bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm p-6">
                                <div class="mb-6 pb-4 border-b border-[#f0f3f4] dark:border-gray-800">
                                    <h2 class="text-xl font-bold text-text-main dark:text-white">Cambio de Contraseña</h2>
                                    <p class="text-sm text-text-secondary mt-1">Asegúrate de usar una contraseña segura para proteger tu cuenta.</p>
                                </div>
                                <form action="actualizar_perfil_be.php" method="POST" class="space-y-4 max-w-lg">
                                    <input type="hidden" name="update_password" value="1">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-text-main dark:text-white">Contraseña Actual</label>
                                        <input name="current_password" class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 px-4 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white" placeholder="••••••••" type="password" required />
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-text-main dark:text-white">Nueva Contraseña</label>
                                        <input name="new_password" class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 px-4 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white" placeholder="Mínimo 8 caracteres" type="password" required />
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-text-main dark:text-white">Confirmar Nueva Contraseña</label>
                                        <input name="confirm_password" class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 px-4 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white" placeholder="Repite la contraseña" type="password" required />
                                    </div>
                                    <div class="pt-2">
                                        <button class="bg-primary hover:bg-primary-hover text-white px-6 py-2 rounded-lg font-semibold transition-colors" type="submit">Actualizar Contraseña</button>
                                    </div>
                                </form>
                            </div>




                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        function showTab(tabName) {
            // IDs of setting containers
            const containers = ['profile-settings', 'appearance-settings', 'security-settings'];
            // IDs of buttons
            const buttons = ['btn-profile', 'btn-appearance', 'btn-security'];
            containers.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.add('hidden');
            });
            buttons.forEach(id => {
                const btn = document.getElementById(id);
                if (btn) {
                    btn.classList.remove('bg-card-light', 'dark:bg-card-dark', 'text-primary', 'border-l-4', 'border-primary', 'shadow-sm');
                    btn.classList.add('text-text-secondary', 'hover:bg-card-light', 'dark:hover:bg-card-dark', 'hover:text-text-main');
                    const span = btn.querySelector('span:last-child');
                    if (span) span.classList.remove('font-semibold');
                    if (span) span.classList.add('font-medium');
                }
            });
            // Show active container
            const activeContainer = document.getElementById(tabName + '-settings');
            if (activeContainer) activeContainer.classList.remove('hidden');
            // Active active button
            const activeBtn = document.getElementById('btn-' + tabName);
            if (activeBtn) {
                activeBtn.classList.remove('text-text-secondary', 'hover:bg-card-light', 'dark:hover:bg-card-dark', 'hover:text-text-main');
                activeBtn.classList.add('bg-card-light', 'dark:bg-card-dark', 'text-primary', 'border-l-4', 'border-primary', 'shadow-sm');
                const span = activeBtn.querySelector('span:last-child');
                if (span) span.classList.remove('font-medium');
                if (span) span.classList.add('font-semibold');
            }
        }

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            const icon = button.querySelector('span');
            
            if (input.type === "password") {
                input.type = "text";
                icon.textContent = "visibility_off";
            } else {
                input.type = "password";
                icon.textContent = "visibility";
            }
        }
    </script>

</body>

</html>