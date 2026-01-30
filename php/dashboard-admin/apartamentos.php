<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Admin') {
    echo '<script>alert("Acceso denegado."); window.location = "../../auth/login.php";</script>';
    die();
}
include '../../auth/conexion_be.php';
?>



<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Panel de Administrador</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link rel="shortcut icon" href="/public/img/logo-definitivo.webp" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "<?php echo isset($_SESSION['tema']) ? $_SESSION['tema'] : '#13a4ec'; ?>",
                        "primary-hover": "<?php echo isset($_SESSION['tema']) ? $_SESSION['tema'] : '#0e8ac7'; ?>",
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
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity opacity-0"></div>

        <aside class="w-72 bg-card-light dark:bg-card-dark border-r border-[#f0f3f4] dark:border-gray-800 flex flex-col h-full hidden md:flex shrink-0 z-20">
            <div class="p-6 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="bg-primary/10 p-3 rounded-lg">
                        <img src="/public/img/logo-definitivo.webp" alt="logo" class="w-16 h-16 object-contain">
                    </div>
                    <div>
                        <h1 class="text-base font-bold text-text-main dark:text-white leading-none">Santamarta</h1>
                        <p class="text-xs text-text-secondary dark:text-gray-400 mt-1">Beachfront Admin</p>
                    </div>
                </div>
                <!-- Botón cerrar menú en móvil -->
                <button onclick="toggleSidebar()" class="md:hidden text-text-secondary hover:text-red-500">
                    <span class="material-symbols-outlined">close</span>
                </button>
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
                    <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 shrink-0" style='background-image: url("<?php echo !empty($_SESSION['imagen']) ? '../../assets/img/usuarios/' . $_SESSION['imagen'] : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCzvH7sb1-qStnSjyW_73yFZuyDV7-Ez2-2LB3V9LiRgrVaP0tp_Kk2bt9RvnuHLpnRQe7JiDm7bwq_2wnzXuXZ-R-5XcOiQI8b3n76MYdNVwUFnHzbUBz8DnJ3mOJqVBJB3XZLkdjkLWIA3bK2AZVnmo-mlgAWRk_hf_1QVYuCIa9mk0_SN_rZwpFYSMXx9CGSEZ-Q5GtTTRX-vx3RJZ8qzgct2lexQnXKpF0xitcnMVaPElXaFz5LeT0rtCIzJ-EXlYRcbDbwcMM'; ?>");'></div>
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-sm font-bold truncate dark:text-white"><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?></span>
                        <span class="text-xs text-text-secondary dark:text-gray-400 truncate"><?php echo $_SESSION['email']; ?></span>
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

            </header>
            <main class="flex-1 overflow-y-auto p-4 md:p-8 space-y-8 scroll-smooth">
                <section class="space-y-6" id="apartments-section">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-text-main dark:text-white">Inventario de Propiedades</h2>
                            <p class="text-text-secondary text-sm mt-1">Gestiona los detalles, precios, multimedia y disponibilidad.</p>
                        </div>
                        <div class="flex gap-3">
                            <a class="flex items-center justify-center gap-2 bg-primary hover:bg-primary-hover text-white px-5 py-2.5 rounded-lg font-semibold transition-all shadow-lg shadow-primary/30" href="#apartment-modal" onclick="limpiarFormulario()">
                                <span class="material-symbols-outlined text-xl">add</span>
                                <span>Añadir Nuevo</span>
                            </a>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <?php
                        $sql = "SELECT * FROM apartamentos ORDER BY fecha_creacion DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $row_json = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                        ?>
                                <div class="bg-card-light dark:bg-card-dark rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm p-4 hover:shadow-md transition-shadow">
                                    <div class="flex flex-col md:flex-row gap-4">
                                        <div class="w-full md:w-48 h-32 rounded-lg bg-cover bg-center shrink-0 relative" style='background-image: url("../../assets/img/apartamentos/<?php echo $row["imagen_principal"]; ?>");'>
                                            <div class="m-2 absolute bottom-0 left-0 bg-black/50 backdrop-blur-sm text-white text-xs font-bold px-2 py-1 rounded">
                                                $<?php echo number_format($row['precio'], 0, ',', '.'); ?> / noche
                                            </div>
                                        </div>
                                        <div class="flex-1 flex flex-col justify-between">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <h3 class="text-lg font-bold text-text-main dark:text-white"><?php echo $row['titulo']; ?></h3>
                                                        <span class="bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-xs px-2 py-0.5 rounded-full font-bold border border-green-200 dark:border-green-900">Publicado</span>
                                                    </div>
                                                    <div class="flex items-center gap-1 text-text-secondary text-sm mb-2">
                                                        <span class="material-symbols-outlined text-sm">location_on</span>
                                                        <?php echo $row['ubicacion']; ?>
                                                    </div>
                                                    <div class="flex items-center gap-4 text-sm text-text-secondary">
                                                        <span class="flex items-center gap-1 bg-background-light dark:bg-gray-800 px-2 py-1 rounded"><span class="material-symbols-outlined text-sm">bed</span> <?php echo $row['habitaciones']; ?> Hab</span>
                                                        <span class="flex items-center gap-1 bg-background-light dark:bg-gray-800 px-2 py-1 rounded"><span class="material-symbols-outlined text-sm">shower</span> <?php echo $row['banos']; ?> Baños</span>
                                                        <span class="flex items-center gap-1 bg-background-light dark:bg-gray-800 px-2 py-1 rounded"><span class="material-symbols-outlined text-sm">group</span> <?php echo $row['capacidad']; ?> Pax</span>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <a class="p-2 text-text-secondary hover:text-primary hover:bg-primary/10 rounded-lg transition-colors cursor-pointer" onclick='verApartamento(<?php echo $row_json; ?>)' title="Vista Previa">
                                                        <span class="material-symbols-outlined">visibility</span>
                                                    </a>
                                                    <a class="p-2 text-text-secondary hover:text-primary hover:bg-primary/10 rounded-lg transition-colors cursor-pointer" onclick='editarApartamento(<?php echo $row_json; ?>)' href="#apartment-modal" title="Editar">
                                                        <span class="material-symbols-outlined">edit</span>
                                                    </a>
                                                    <button class="p-2 text-text-secondary hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" onclick="eliminarApartamento(<?php echo $row['id']; ?>)" title="Eliminar">
                                                        <span class="material-symbols-outlined">delete</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mt-4 pt-4 border-t border-[#f0f3f4] dark:border-gray-800 flex justify-between items-center">
                                                <div class="text-xs text-text-secondary">
                                                    Publicado: <span class="font-medium text-text-main dark:text-white"><?php echo date('d/m/Y', strtotime($row['fecha_creacion'])); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo '<p class="text-center text-text-secondary">No hay apartamentos registrados aún.</p>';
                        }
                        ?>
                    </div>
                </section>
            </main>
            <div class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm justify-end transition-opacity" id="apartment-modal">
                <div class="w-full max-w-2xl h-full bg-card-light dark:bg-card-dark shadow-2xl overflow-y-auto border-l border-[#f0f3f4] dark:border-gray-800 flex flex-col">
                    <form action="guardar_apartamento_be.php" method="POST" enctype="multipart/form-data" class="flex flex-col h-full" id="form-apartamento">
                        <input type="hidden" name="id" id="apartamento_id">
                        <div class="px-6 py-4 border-b border-[#f0f3f4] dark:border-gray-800 flex justify-between items-center bg-card-light dark:bg-card-dark sticky top-0 z-10">
                            <div>
                                <h3 class="text-xl font-bold text-text-main dark:text-white" id="modal-title">Gestionar Apartamento</h3>
                                <p class="text-xs text-text-secondary">Configura detalles y archivos multimedia.</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <a class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors text-text-secondary" href="#">
                                    <span class="material-symbols-outlined">close</span>
                                </a>
                            </div>
                        </div>
                        <div class="p-6 space-y-8 flex-1">
                            <section class="space-y-4">
                                <h4 class="text-sm font-bold text-text-main dark:text-white uppercase tracking-wider">Imagen Principal</h4>
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-6 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-background-light dark:hover:bg-gray-800 transition-colors group">
                                    <input type="file" name="imagen" id="imagen_input" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" />
                                </div>
                            </section>

                            <section class="space-y-4">
                                <h4 class="text-sm font-bold text-text-main dark:text-white uppercase tracking-wider">Galería de Imágenes (Opcional)</h4>
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-6 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-background-light dark:hover:bg-gray-800 transition-colors group">
                                    <input type="file" name="imagenes_galeria[]" multiple accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" />
                                    <p class="mt-2 text-xs text-text-secondary">Selecciona varias imágenes para agregar a la galería.</p>
                                </div>
                                <div id="galeria-imagenes-existentes" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-4">
                                    <!-- Las imágenes existentes se cargarán aquí -->
                                </div>
                            </section>

                            <section class="space-y-4">
                                <h4 class="text-sm font-bold text-text-main dark:text-white uppercase tracking-wider">Videos (Opcional)</h4>
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-6 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-background-light dark:hover:bg-gray-800 transition-colors group">
                                    <input type="file" name="videos_galeria[]" multiple accept="video/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" />
                                    <p class="mt-2 text-xs text-text-secondary">Selecciona videos para cargar (mp4, webm, ogg).</p>
                                </div>
                                <div id="galeria-videos-existentes" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                                    <!-- Los videos existentes se cargarán aquí -->
                                </div>
                            </section>

                            <section class="space-y-4">
                                <h4 class="text-sm font-bold text-text-main dark:text-white uppercase tracking-wider">Detalles Generales</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="text-xs font-semibold text-text-secondary">Nombre de la Propiedad</label>
                                        <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 px-3 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white" placeholder="Ej: Suite Panorámica" type="text" name="titulo" required />
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-semibold text-text-secondary">Precio por Noche</label>
                                        <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 px-3 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white" placeholder="Ej: 450000" type="number" name="precio" required />
                                    </div>
                                    <div class="space-y-2 md:col-span-2">
                                        <label class="text-xs font-semibold text-text-secondary">Ubicación</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-2.5 text-text-secondary text-sm">location_on</span>
                                            <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 pl-9 pr-3 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white" placeholder="Ej: Edificio Rodadero Real, Piso 12" type="text" name="ubicacion" required />
                                        </div>
                                    </div>
                                    <div class="space-y-2 md:col-span-2">
                                        <label class="text-xs font-semibold text-text-secondary">Descripción</label>
                                        <textarea class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white h-24 resize-none" placeholder="Describe las características principales..." name="descripcion" required></textarea>
                                    </div>
                                    <div class="space-y-2 md:col-span-2">
                                        <label class="text-xs font-semibold text-text-secondary">Servicios y Amenidades</label>
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 bg-background-light dark:bg-gray-800 p-4 rounded-lg h-64 overflow-y-auto">
                                            <?php
                                            $lista_servicios = [
                                                "Acomodación y dormitorios" => "bed",
                                                "Entretenimiento" => "theater_comedy",
                                                "Aire acondicionado" => "ac_unit",
                                                "Vistas panorámicas" => "panorama",
                                                "Agua caliente" => "water_drop",
                                                "Amenities" => "soap",
                                                "Lavadora y Secadora" => "local_laundry_service",
                                                "Atención 24/7" => "support_agent",
                                                "Seguridad 24/7" => "local_police",
                                                "Coworking" => "work",
                                                "Wifi" => "wifi",
                                                "Televisión" => "tv",
                                                "Gimnasio" => "fitness_center",
                                                "Piscinas" => "pool",
                                                "Vista a la bahía" => "water",
                                                "Vista a la playa" => "beach_access",
                                                "Vista a las montañas" => "landscape",
                                                "Vista al mar" => "sailing",
                                                "Beneficios para huéspedes" => "loyalty",
                                                "Admitimos mascotas" => "pets",
                                                "Estadías largas" => "calendar_month",
                                                "Limpieza (cargo adicional)" => "cleaning_services",
                                                "Estacionamiento gratuito" => "local_parking",
                                                "Cafe · Bar Piso 1" => "coffee",
                                                "Cafetería Piso 18" => "coffee_maker",
                                                "Servicio de restaurantes" => "restaurant",
                                                "Check in 15:00 - 18:00 Hr" => "login",
                                                "Check out 11:00 Hr" => "logout",
                                                "Horas de silencio 23:00 - 7:00 Hr" => "volume_off"
                                            ];
                                            foreach ($lista_servicios as $servicio => $icono) {
                                                echo '<label class="flex items-center gap-2 cursor-pointer group">';
                                                echo '<input type="checkbox" name="servicios[]" value="' . $servicio . '" class="rounded border-gray-300 text-primary focus:ring-primary/50 dark:bg-gray-700 dark:border-gray-600">';
                                                echo '<span class="material-symbols-outlined text-text-secondary group-hover:text-primary text-lg">' . $icono . '</span>';
                                                echo '<span class="text-xs text-text-main dark:text-gray-300 group-hover:text-primary transition-colors">' . $servicio . '</span>';
                                                echo '</label>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="space-y-4">
                                <h4 class="text-sm font-bold text-text-main dark:text-white uppercase tracking-wider">Características</h4>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-xs font-semibold text-text-secondary">Habitaciones</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-2.5 text-text-secondary text-sm">bed</span>
                                            <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 pl-9 pr-3 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white" type="number" name="habitaciones" required />
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-semibold text-text-secondary">Baños</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-2.5 text-text-secondary text-sm">shower</span>
                                            <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 pl-9 pr-3 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white" type="number" name="banos" required />
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-semibold text-text-secondary">Capacidad (Pax)</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-2.5 text-text-secondary text-sm">group</span>
                                            <input class="w-full bg-background-light dark:bg-gray-800 border-none rounded-lg h-10 pl-9 pr-3 text-sm focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white" type="number" name="capacidad" required />
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="p-6 border-t border-[#f0f3f4] dark:border-gray-800 bg-card-light dark:bg-card-dark sticky bottom-0 z-10 flex justify-end gap-3">
                            <a class="px-4 py-2 text-sm font-bold text-text-secondary hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors" href="#">Cancelar</a>
                            <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-primary hover:bg-primary-hover rounded-lg shadow-lg shadow-primary/30 transition-all">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Vista Previa -->
    <div class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm justify-center items-center transition-opacity p-4" id="preview-modal">
        <div class="w-full max-w-4xl bg-card-light dark:bg-card-dark rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="relative h-64 md:h-80 shrink-0">
                <img id="preview-image" src="" alt="Vista previa" class="w-full h-full object-cover">
                <button onclick="cerrarPreview()" class="absolute top-4 right-4 bg-black/50 hover:bg-black/70 text-white rounded-full p-2 transition-colors backdrop-blur-sm">
                    <span class="material-symbols-outlined">close</span>
                </button>
                <div class="absolute bottom-4 left-4 right-4 flex justify-between items-end">
                    <div class="bg-black/50 backdrop-blur-sm p-4 rounded-xl text-white">
                        <h3 class="text-2xl font-bold" id="preview-title"></h3>
                        <div class="flex items-center gap-1 text-gray-200 text-sm mt-1">
                            <span class="material-symbols-outlined text-sm">location_on</span>
                            <span id="preview-location"></span>
                        </div>
                    </div>
                    <div class="bg-primary text-white px-4 py-2 rounded-xl font-bold text-lg shadow-lg" id="preview-price">
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 overflow-y-auto">
                <div class="grid grid-cols-3 gap-4 mb-8">
                    <div class="bg-background-light dark:bg-gray-800 p-4 rounded-xl flex flex-col items-center justify-center text-center gap-2">
                        <span class="material-symbols-outlined text-primary text-3xl">bed</span>
                        <span class="font-bold text-text-main dark:text-white" id="preview-habitaciones"></span>
                    </div>
                    <div class="bg-background-light dark:bg-gray-800 p-4 rounded-xl flex flex-col items-center justify-center text-center gap-2">
                        <span class="material-symbols-outlined text-primary text-3xl">shower</span>
                        <span class="font-bold text-text-main dark:text-white" id="preview-banos"></span>
                    </div>
                    <div class="bg-background-light dark:bg-gray-800 p-4 rounded-xl flex flex-col items-center justify-center text-center gap-2">
                        <span class="material-symbols-outlined text-primary text-3xl">group</span>
                        <span class="font-bold text-text-main dark:text-white" id="preview-capacidad"></span>
                    </div>
                </div>

                <!-- Galería en Vista Previa -->
                <div class="mb-8 hidden" id="preview-gallery-container">
                    <h4 class="text-lg font-bold text-text-main dark:text-white mb-3">Galería</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4" id="preview-gallery-grid">
                        <!-- Se llena dinámicamente -->
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-bold text-text-main dark:text-white mb-3">Descripción</h4>
                    <p class="text-text-secondary leading-relaxed whitespace-pre-line" id="preview-description"></p>
                </div>

                <div id="preview-services-container" class="mt-8 hidden">
                    <h4 class="text-lg font-bold text-text-main dark:text-white mb-3">Servicios y Amenidades</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3" id="preview-services-grid">
                        <!-- Servicios se cargarán aquí -->
                    </div>
                </div>
            </div>

            <div class="p-4 border-t border-[#f0f3f4] dark:border-gray-800 flex justify-end bg-card-light dark:bg-card-dark">
                <button onclick="cerrarPreview()" class="px-6 py-2 bg-gray-100 dark:bg-gray-800 text-text-main dark:text-white font-bold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <script src="/js/apartamento-noche.js"></script>

</body>

</html>