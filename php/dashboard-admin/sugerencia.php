<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Admin') {
    echo '<script>alert("Acceso denegado. Por favor, inicia sesión como administrador."); window.location = "../../auth/login.php";</script>';
    die();
}

include '../../auth/conexion_be.php';

// Consultas de contadores (Información valiosa conservada)
$total_reservas = $conn->query("SELECT COUNT(*) as count FROM reservas")->fetch_assoc()['count'];
$total_pqr = $conn->query("SELECT COUNT(*) as count FROM pqr")->fetch_assoc()['count'];
$pqr_pendientes = $conn->query("SELECT COUNT(*) as count FROM pqr WHERE estado = 'Pendiente'")->fetch_assoc()['count'];
$total_usuarios = $conn->query("SELECT COUNT(*) as count FROM usuarios WHERE rol != 'Admin'")->fetch_assoc()['count'];

// Obtener sugerencias
$sugerencias_query = "SELECT s.*, u.nombre, u.apellido, u.imagen as usuario_imagen 
                      FROM sugerencias s 
                      JOIN usuarios u ON s.usuario_id = u.id 
                      ORDER BY s.fecha_creacion DESC";
$sugerencias_res = $conn->query($sugerencias_query);
?>
<!DOCTYPE html>
<html class="dark" lang="es-CO">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Sugerencias</title>
    <link rel="shortcut icon" href="/public/img/logo-def-Photoroom.png" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css" />
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "<?php echo isset($_SESSION['tema']) ? $_SESSION['tema'] : '#13a4ec'; ?>",
                        "primary-hover": "<?php echo isset($_SESSION['tema']) ? $_SESSION['tema'] : '#0e8ac7'; ?>",
                        "background-dark": "#101c22",
                        "card-dark": "#1a2c35",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    }
                },
            },
        }
    </script>
    <style>
        body {
            background-color: #101c22;
            scrollbar-gutter: stable;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        #sidebar {
            transition: transform 0.3s ease-in-out;
        }

        /* Clase para ocultar scrollbar si es necesario */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-background-dark text-gray-200 font-display overflow-hidden">
    <div class="flex h-screen overflow-hidden">

        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 hidden md:hidden transition-opacity"></div>

        <aside id="sidebar" class="w-72 bg-card-dark border-r border-gray-800 flex flex-col h-full fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 z-50 shrink-0">
            <div class="p-6 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="bg-primary/10 p-3 rounded-lg">
                        <img src="/public/img/logo-def-Photoroom.png" alt="logo" class="w-16 h-16 object-contain">
                    </div>
                    <div>
                        <h1 class="text-base font-bold text-text-main dark:text-white leading-none">Santamarta</h1>
                        <p class="text-xs text-text-secondary dark:text-gray-400 mt-1">Beachfront Admin</p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="md:hidden text-text-secondary hover:text-red-500">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-4 py-2 space-y-1">
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-gray-400 hover:bg-gray-800 transition-colors group" href="/php/dashboard-admin/dashboard.php">
                    <span class="material-symbols-outlined group-hover:text-primary">dashboard</span>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-gray-400 hover:bg-gray-800 transition-colors group" href="/php/dashboard-admin/apartamentos.php">
                    <span class="material-symbols-outlined group-hover:text-primary">apartment</span>
                    <span class="text-sm font-medium">Apartamentos</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-gray-400 hover:bg-gray-800 transition-colors group" href="/php/dashboard-admin/reservas.php">
                    <span class="material-symbols-outlined group-hover:text-primary">calendar_month</span>
                    <span class="text-sm font-medium">Reservas</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-gray-400 hover:bg-gray-800 transition-colors group" href="/php/dashboard-admin/usuarios.php">
                    <span class="material-symbols-outlined group-hover:text-primary">group</span>
                    <span class="text-sm font-medium">Usuarios</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-gray-400 hover:bg-gray-800 transition-colors group" href="/php/dashboard-admin/pqr.php">
                    <span class="material-symbols-outlined group-hover:text-primary">mail</span>
                    <span class="text-sm font-medium">PQR</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-primary/10 text-primary border border-primary/20" href="#">
                    <span class="material-symbols-outlined fill-1">lightbulb</span>
                    <span class="text-sm font-semibold">Sugerencias</span>
                </a>

                <div class="pt-4 mt-4 border-t border-gray-800">
                    <p class="px-3 text-xs font-semibold text-text-secondary uppercase tracking-wider mb-2">Sistema</p>
                    <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-background-light dark:hover:bg-gray-800 dark:text-gray-400 hover:text-text-main transition-colors group" href="/php/dashboard-admin/configuracion.php">
                        <span class="material-symbols-outlined group-hover:text-primary transition-colors">settings</span>
                        <span class="text-sm font-medium">Configuración</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-gray-400 hover:bg-red-900/20 hover:text-red-500 transition-colors" href="../../auth/cerrar_sesion.php">
                        <span class="material-symbols-outlined">logout</span>
                        <span class="text-sm font-medium">Cerrar Sesión</span>
                    </a>
                </div>
            </div>

            <div class="p-4 border-t border-gray-800">
                <div class="flex items-center gap-3 bg-gray-900/50 p-3 rounded-xl border border-gray-800">
                    <img class="size-10 rounded-full object-cover" src="<?php echo !empty($_SESSION['imagen']) ? '../../assets/img/usuarios/' . $_SESSION['imagen'] : 'https://ui-avatars.com/api/?name=Admin'; ?>">
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-white truncate"><?php echo $_SESSION['nombre']; ?></p>
                        <p class="text-[10px] text-gray-500 truncate"><?php echo $_SESSION['email']; ?></p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 flex flex-col bg-background-dark overflow-hidden">

            <header class="h-16 bg-card-dark border-b border-gray-800 flex items-center justify-between px-4 md:px-8 shrink-0">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="md:hidden text-white p-2 hover:bg-gray-800 rounded-lg">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h1 class="text-lg font-bold text-white hidden sm:block">Sugerencias del Sistema</h1>

                    <button id="btn-guide" class="flex items-center gap-2 px-3 py-1.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg text-xs font-bold transition-all border border-gray-600 ml-4">
                        <span class="material-symbols-outlined text-[16px]">help</span>
                        Guía
                    </button>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-4 md:p-8">

                <div id="table-container" class="bg-card-dark rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">
                    <div class="p-5 border-b border-gray-800 bg-gray-800/20 flex flex-col md:flex-row gap-4 items-center justify-between">

                        <div id="filter-container" class="flex gap-2 w-full md:w-auto">
                            <button id="filter-all" class="flex-1 md:flex-none px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold transition-colors">Todas</button>
                            <button id="filter-new" class="flex-1 md:flex-none px-4 py-2 text-gray-400 hover:text-white text-sm font-semibold transition-colors">Nuevas</button>
                        </div>

                        <div class="relative w-full max-w-md">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">search</span>
                            <input id="realTimeSearch" class="w-full pl-10 pr-4 py-2.5 bg-background-dark border border-gray-700 rounded-xl text-sm text-white focus:ring-2 focus:ring-primary outline-none transition-all" placeholder="Buscar por nombre o mensaje..." type="text" />
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="sugerenciasTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-900/50 text-gray-500 text-[11px] uppercase tracking-widest font-black">
                                    <th class="px-6 py-4">Huésped</th>
                                    <th class="px-6 py-4">Fecha</th>
                                    <th class="px-6 py-4">Sugerencia</th>
                                    <th class="px-6 py-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                <?php if ($sugerencias_res && $sugerencias_res->num_rows > 0): ?>
                                    <?php while ($sug = $sugerencias_res->fetch_assoc()):
                                        $img = !empty($sug['usuario_imagen']) ? '../../assets/img/usuarios/' . $sug['usuario_imagen'] : 'https://ui-avatars.com/api/?name=' . urlencode($sug['nombre']);
                                    ?>
                                        <tr class="suggestion-row group hover:bg-primary/5 transition-all">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <img class="w-9 h-9 rounded-full object-cover border border-gray-700" src="<?php echo $img; ?>">
                                                    <span class="text-sm font-bold text-gray-200 user-name"><?php echo $sug['nombre'] . ' ' . $sug['apellido']; ?></span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-xs text-gray-500 date-col"><?php echo date('d/m/Y', strtotime($sug['fecha_creacion'])); ?></td>
                                            <td class="px-6 py-4">
                                                <p class="text-sm text-gray-400 truncate max-w-xs sug-text"><?php echo $sug['mensaje']; ?></p>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <button onclick="openModal('<?php echo addslashes($sug['nombre'] . ' ' . $sug['apellido']); ?>', '<?php echo $sug['fecha_creacion']; ?>', '<?php echo addslashes($sug['mensaje']); ?>', '<?php echo $img; ?>')" class="p-2 hover:bg-primary/20 rounded-lg text-primary transition-colors action-btn">
                                                    <span class="material-symbols-outlined">visibility</span>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-gray-600">No se encontraron sugerencias.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="suggestionModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4">
        <div id="modalBackdrop" class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity opacity-0"></div>

        <div id="modalContent" class="relative bg-card-dark border border-gray-700 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden scale-95 opacity-0 translate-y-4 transition-all duration-300">
            <div class="p-6 border-b border-gray-800 flex justify-between items-center bg-gray-800/20">
                <h2 class="font-bold text-white flex items-center gap-2"><span class="material-symbols-outlined text-primary">chat</span> Detalle</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-white"><span class="material-symbols-outlined">close</span></button>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center gap-4">
                    <img id="modalImg" class="w-14 h-14 rounded-full border-2 border-primary/20">
                    <div>
                        <h3 id="modalName" class="font-bold text-white text-lg"></h3>
                        <p id="modalDate" class="text-xs text-primary font-medium"></p>
                    </div>
                </div>
                <div class="bg-background-dark p-4 rounded-xl border border-gray-800">
                    <p id="modalText" class="text-gray-300 text-sm leading-relaxed whitespace-pre-line"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            /* =========================================
               1. LÓGICA DEL MODAL (Corregida)
               ========================================= */
            const modal = document.getElementById("suggestionModal");
            const modalBackdrop = document.getElementById("modalBackdrop");
            const modalContent = document.getElementById("modalContent");

            // Definimos funciones en window para acceso global desde HTML (onclick)
            window.openModal = function(name, date, message, img) {
                // 1. Llenar datos
                document.getElementById("modalName").textContent = name;
                document.getElementById("modalDate").textContent = 'Enviado: ' + date;
                document.getElementById("modalText").textContent = message;
                document.getElementById("modalImg").src = img;

                // 2. Mostrar contenedor principal
                modal.classList.remove("hidden");

                // 3. Animación de entrada (pequeño delay para aplicar estilos CSS)
                setTimeout(() => {
                    if (modalBackdrop) modalBackdrop.classList.remove("opacity-0");
                    if (modalContent) {
                        modalContent.classList.remove("opacity-0", "translate-y-4", "scale-95");
                        modalContent.classList.add("translate-y-0", "scale-100");
                    }
                }, 10);
            };

            window.closeModal = function() {
                // 1. Animación de salida
                if (modalBackdrop) modalBackdrop.classList.add("opacity-0");
                if (modalContent) {
                    modalContent.classList.remove("translate-y-0", "scale-100");
                    modalContent.classList.add("opacity-0", "translate-y-4", "scale-95");
                }

                // 2. Ocultar contenedor después de la animación
                setTimeout(() => {
                    modal.classList.add("hidden");
                }, 300);
            };

            // Event Listener para cerrar al hacer clic fuera
            if (modalBackdrop) {
                modalBackdrop.addEventListener("click", window.closeModal);
            }

            // Event Listener para tecla Escape
            document.addEventListener("keydown", (e) => {
                if (e.key === "Escape" && !modal.classList.contains("hidden")) {
                    window.closeModal();
                }
            });

            /* =========================================
               2. MENÚ SIDEBAR (Móvil)
               ========================================= */
            window.toggleSidebar = function() {
                const sidebar = document.getElementById("sidebar");
                const overlay = document.getElementById("sidebar-overlay");

                sidebar.classList.toggle("-translate-x-full");
                overlay.classList.toggle("hidden");

                if (!overlay.classList.contains("hidden")) {
                    setTimeout(() => overlay.classList.remove("opacity-0"), 10);
                } else {
                    overlay.classList.add("opacity-0");
                }
            };

            /* =========================================
               3. FILTROS Y BUSCADOR
               ========================================= */

            const btnAll = document.getElementById("filter-all");
            const btnNew = document.getElementById("filter-new");

            if (btnAll && btnNew) {
                btnAll.addEventListener("click", () => {
                    updateFilterStyles(btnAll, btnNew);
                    filterTableByDate("todas");
                });

                btnNew.addEventListener("click", () => {
                    updateFilterStyles(btnNew, btnAll);
                    filterTableByDate("nuevas");
                });
            }

            function updateFilterStyles(active, inactive) {
                active.className = "flex-1 md:flex-none px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold transition-colors";
                inactive.className = "flex-1 md:flex-none px-4 py-2 text-gray-400 hover:text-white text-sm font-semibold transition-colors";
            }

            const searchInput = document.getElementById("realTimeSearch");
            if (searchInput) {
                searchInput.addEventListener("keyup", () => {
                    const term = searchInput.value.toLowerCase();
                    const rows = document.querySelectorAll(".suggestion-row");

                    rows.forEach(row => {
                        const name = row.querySelector(".user-name").textContent.toLowerCase();
                        const msg = row.querySelector(".sug-text").textContent.toLowerCase();

                        if (name.includes(term) || msg.includes(term)) {
                            row.style.display = "";
                        } else {
                            row.style.display = "none";
                        }
                    });
                });
            }

            function filterTableByDate(type) {
                const rows = document.querySelectorAll(".suggestion-row");
                const today = new Date();

                rows.forEach(row => {
                    if (type === "todas") {
                        row.style.display = "";
                        return;
                    }
                    const dateText = row.querySelector(".date-col").textContent.trim(); // dd/mm/yyyy
                    const [day, month, year] = dateText.split("/");
                    const rowDate = new Date(year, month - 1, day);

                    const diffTime = Math.abs(today - rowDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    if (diffDays <= 7) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }

            /* =========================================
               4. GUÍA INTERACTIVA (DRIVER.JS)
               ========================================= */
            const driver = window.driver.js.driver;

            const driverObj = driver({
                showProgress: true,
                nextBtnText: "Siguiente",
                prevBtnText: "Anterior",
                doneBtnText: "Finalizar",
                steps: [{
                        element: "#sidebar",
                        popover: {
                            title: "Menú Lateral",
                            description: "Navega entre las secciones del sistema."
                        }
                    },
                    {
                        element: "#table-container",
                        popover: {
                            title: "Lista de Sugerencias",
                            description: "Aquí ves todos los comentarios de los usuarios."
                        }
                    },
                    {
                        element: "#filter-container",
                        popover: {
                            title: "Filtros",
                            description: "Alterna entre ver todas o solo las recientes."
                        }
                    },
                    {
                        element: "#realTimeSearch",
                        popover: {
                            title: "Buscador",
                            description: "Busca rápidamente por nombre o mensaje."
                        }
                    },
                    {
                        element: ".action-btn",
                        popover: {
                            title: "Ver Detalle",
                            description: "Click para leer el mensaje completo."
                        }
                    }
                ]
            });

            const btnGuide = document.getElementById("btn-guide");
            if (btnGuide) {
                btnGuide.addEventListener("click", () => driverObj.drive());
            }
        });
    </script>
</body>

</html>