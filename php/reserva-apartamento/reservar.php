<?php
session_start();
include '../../auth/conexion_be.php';

$isEmbed = isset($_GET['embed']) && $_GET['embed'] === '1';

// Obtener datos de la reserva desde la URL
$id_apartamento = isset($_GET['id']) ? intval($_GET['id']) : 0;
$checkin = isset($_GET['checkin']) ? $_GET['checkin'] : '';
$checkout = isset($_GET['checkout']) ? $_GET['checkout'] : '';
$adults = isset($_GET['adults']) ? intval($_GET['adults']) : 1;
$children = isset($_GET['children']) ? intval($_GET['children']) : 0;
$infants = isset($_GET['infants']) ? intval($_GET['infants']) : 0;
$guideDog = isset($_GET['guideDog']) && $_GET['guideDog'] === 'true';

// Validar datos mínimos
if ($id_apartamento === 0 || empty($checkin) || empty($checkout)) {
    header('Location: /');
    exit;
}

// Consultar detalles del apartamento
$sql = "SELECT a.*, 
        COALESCE(AVG(r.calificacion), 0) as promedio_calificacion, 
        COUNT(r.id) as total_resenas 
        FROM apartamentos a 
        LEFT JOIN resenas r ON a.id = r.apartamento_id 
        WHERE a.id = $id_apartamento 
        GROUP BY a.id";
$result = $conn->query($sql);
$apartamento = ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;

if (!$apartamento) {
    die("Apartamento no encontrado.");
}

// LÓGICA DE PRECIOS
$fecha_inicio = new DateTime($checkin);
$fecha_fin = new DateTime($checkout);
$noches = $fecha_inicio->diff($fecha_fin)->days;

$basePrice = $apartamento['precio'];
$subtotal = $basePrice * $noches;
$cleaningFee = 80000;
$total = $subtotal + $cleaningFee;
?>

<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reserva Segura - Santamartabeachfront</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .step-active {
            color: #13a4ec;
            border-color: #13a4ec;
        }

        .step-inactive {
            color: #64748b;
            border-color: #e2e8f0;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-[#f8fafc] dark:bg-[#0f172a] text-slate-900 dark:text-slate-100">

    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-8">
            <button onclick="window.history.back()" class="flex items-center gap-2 text-sm font-bold text-primary">
                <span class="material-symbols-outlined">arrow_back</span> Regresar
            </button>
            <div class="flex items-center gap-2">
                <span class="text-xs font-black uppercase tracking-widest opacity-50">Solicitud de Reserva</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2">
                <div class="flex items-center justify-between mb-8 bg-white dark:bg-slate-900 p-5 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-800">
                    <div class="step-item step-active flex items-center gap-3" id="step1-label">
                        <span class="size-9 rounded-full border-2 flex items-center justify-center font-bold text-sm">1</span>
                        <span class="text-[10px] font-black uppercase tracking-tighter hidden md:block">Contacto</span>
                    </div>
                    <div class="h-[1px] flex-1 bg-slate-100 dark:bg-slate-800 mx-4"></div>
                    <div class="step-item step-inactive flex items-center gap-3" id="step2-label">
                        <span class="size-9 rounded-full border-2 flex items-center justify-center font-bold text-sm">2</span>
                        <span class="text-[10px] font-black uppercase tracking-tighter hidden md:block">Acompañantes</span>
                    </div>
                    <div class="h-[1px] flex-1 bg-slate-100 dark:bg-slate-800 mx-4"></div>
                    <div class="step-item step-inactive flex items-center gap-3" id="step3-label">
                        <span class="size-9 rounded-full border-2 flex items-center justify-center font-bold text-sm">3</span>
                        <span class="text-[10px] font-black uppercase tracking-tighter hidden md:block">Garantía</span>
                    </div>
                </div>

                <form action="procesar_reserva.php" method="POST" enctype="multipart/form-data" id="reservaForm">
                    <input type="hidden" name="id_apartamento" value="<?php echo $id_apartamento; ?>">
                    <input type="hidden" name="checkin" value="<?php echo $checkin; ?>">
                    <input type="hidden" name="checkout" value="<?php echo $checkout; ?>">
                    <input type="hidden" name="adults" value="<?php echo $adults; ?>">
                    <input type="hidden" name="children" value="<?php echo $children; ?>">
                    <input type="hidden" name="infants" value="<?php echo $infants; ?>">
                    <input type="hidden" name="guideDog" value="<?php echo $guideDog ? '1' : '0'; ?>">
                    <input type="hidden" name="total_price" value="<?php echo $total; ?>">
                    <?php if ($isEmbed): ?><input type="hidden" name="embed" value="1"><?php endif; ?>

                    <div class="tab-content active" id="step1">
                        <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-xl space-y-6">
                            <h2 class="text-2xl font-black">Información Personal</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase text-slate-400">Nombre</label>
                                    <input type="text" name="nombre" required class="w-full rounded-2xl border-slate-200 dark:bg-slate-800 dark:border-slate-700 p-4" placeholder="Tu nombre">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase text-slate-400">Apellido</label>
                                    <input type="text" name="apellido" required class="w-full rounded-2xl border-slate-200 dark:bg-slate-800 dark:border-slate-700 p-4" placeholder="Tu apellido">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-slate-400">Correo Electrónico</label>
                                <input type="email" name="email" required class="w-full rounded-2xl border-slate-200 dark:bg-slate-800 dark:border-slate-700 p-4" placeholder="ejemplo@correo.com">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-slate-400">Teléfono</label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-4 rounded-l-2xl border border-r-0 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-500 font-bold">+57</span>
                                    <input type="tel" name="telefono" required class="w-full rounded-r-2xl border-slate-200 dark:bg-slate-800 dark:border-slate-700 p-4" placeholder="300 123 4567">
                                </div>
                            </div>
                            <button type="button" onclick="nextStep(2)" class="w-full py-5 bg-primary text-white rounded-2xl font-black shadow-lg shadow-primary/30 transition-transform hover:scale-[1.01]">Siguiente Paso</button>
                        </div>
                    </div>

                    <div class="tab-content" id="step2">
                        <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-xl space-y-6">
                            <h2 class="text-2xl font-black">Lista de Acompañantes</h2>
                            <p class="text-slate-500 text-sm">Por favor, escribe el nombre completo de cada persona que ingresará al edificio.</p>

                            <div id="huespedes-container" class="space-y-4">
                                <div class="flex gap-3">
                                    <input type="text" name="huespedes[]" required class="flex-1 rounded-2xl border-slate-200 dark:bg-slate-800 dark:border-slate-700 p-4" placeholder="Nombre completo del huésped">
                                    <button type="button" onclick="addHuesped()" class="size-14 rounded-2xl bg-primary text-white flex items-center justify-center shadow-lg shadow-primary/20">
                                        <span class="material-symbols-outlined">person_add</span>
                                    </button>
                                </div>
                            </div>

                            <div class="flex gap-4 pt-6">
                                <button type="button" onclick="nextStep(1)" class="flex-1 py-5 border border-slate-200 dark:border-slate-700 rounded-2xl font-bold">Atrás</button>
                                <button type="button" onclick="nextStep(3)" class="flex-[2] py-5 bg-primary text-white rounded-2xl font-black shadow-lg shadow-primary/30">Continuar</button>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content" id="step3">
                        <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-xl space-y-8">
                            <div>
                                <h2 class="text-2xl font-black mb-2">Garantía y Seguridad</h2>
                                <p class="text-slate-500 text-sm">Información requerida para el registro oficial de la propiedad.</p>
                            </div>

                            <div class="space-y-6">
                                <div class="bg-blue-50 dark:bg-blue-900/10 p-5 rounded-2xl border border-blue-100 dark:border-blue-800 flex gap-4">
                                    <span class="material-symbols-outlined text-primary">info</span>
                                    <p class="text-[11px] text-blue-700 dark:text-blue-300 leading-relaxed">
                                        <strong>AVISO DE NO PAGO:</strong> Tu reserva se enviará como una solicitud. No se te cobrará nada en este momento. Coordinaremos el pago directamente contigo.
                                    </p>
                                </div>

                                <div class="space-y-3">
                                    <label class="text-[10px] font-black uppercase text-slate-400">Foto Cédula o Pasaporte (Anverso)</label>
                                    <div class="relative border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl p-8 text-center hover:border-primary transition-colors">
                                        <input type="file" name="documento_id" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">cloud_upload</span>
                                        <p class="text-xs text-slate-400 font-bold">Haz clic o arrastra tu archivo aquí</p>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase text-slate-400">Cuenta bancaria para devolución de depósito</label>
                                    <input type="text" name="cuenta_devolucion" class="w-full rounded-2xl border-slate-200 dark:bg-slate-800 dark:border-slate-700 p-4" placeholder="Banco, Tipo y # de Cuenta">
                                </div>
                            </div>

                            <div class="p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl space-y-4">
                                <h4 class="text-xs font-black uppercase">Reglas del Alojamiento</h4>
                                <ul class="text-[11px] space-y-2 text-slate-500">
                                    <li class="flex gap-2"><span>•</span> Prohibido el ingreso de personas no registradas.</li>
                                    <li class="flex gap-2"><span>•</span> No se permiten fiestas ni ruidos después de las 10:00 PM.</li>
                                    <li class="flex gap-2"><span>•</span> El depósito se devuelve tras verificar el estado del apto.</li>
                                </ul>
                                <div class="flex items-center gap-3 pt-2">
                                    <input type="checkbox" required class="rounded border-slate-300 text-primary">
                                    <label class="text-xs font-bold">Acepto los términos y reglas</label>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <button type="button" onclick="nextStep(2)" class="flex-1 py-5 border border-slate-200 dark:border-slate-700 rounded-2xl font-bold">Atrás</button>
                                <button type="submit" class="flex-[2] py-5 bg-green-600 text-white rounded-2xl font-black shadow-lg shadow-green-600/30">Enviar Mi Reserva</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-10 space-y-6">
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-xl overflow-hidden">
                        <img src="/assets/img/apartamentos/<?php echo $apartamento['imagen_principal']; ?>" class="w-full h-44 object-cover rounded-2xl mb-6">

                        <div class="space-y-4">
                            <div>
                                <h3 class="font-black text-lg leading-tight"><?php echo $apartamento['titulo']; ?></h3>
                                <div class="flex items-center gap-1 mt-2">
                                    <span class="material-symbols-outlined text-primary text-sm fill-1">star</span>
                                    <span class="text-xs font-bold"><?php echo number_format($apartamento['promedio_calificacion'], 1); ?></span>
                                    <span class="text-xs text-slate-400 font-medium">(<?php echo $apartamento['total_resenas']; ?> reseñas)</span>
                                </div>
                            </div>

                            <div class="py-4 border-y border-slate-50 dark:border-slate-800 space-y-3">
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-slate-400">Check-in</span>
                                    <span><?php echo date('d M, Y', strtotime($checkin)); ?></span>
                                </div>
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-slate-400">Check-out</span>
                                    <span><?php echo date('d M, Y', strtotime($checkout)); ?></span>
                                </div>
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-slate-400">Huéspedes</span>
                                    <span><?php echo ($adults + $children); ?> pers. <?php if ($infants > 0) echo "+ $infants bebé(s)"; ?></span>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-400">$<?php echo number_format($basePrice, 0, ',', '.'); ?> x <?php echo $noches; ?> noches</span>
                                    <span class="font-bold">$<?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-400">Tarifa limpieza</span>
                                    <span class="font-bold">$<?php echo number_format($cleaningFee, 0, ',', '.'); ?></span>
                                </div>
                                <div class="flex justify-between pt-4 font-black text-2xl text-primary">
                                    <span>Total</span>
                                    <span>$<?php echo number_format($total, 0, ',', '.'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 bg-green-500/10 rounded-2xl flex gap-3 items-center">
                        <span class="material-symbols-outlined text-green-500">lock</span>
                        <p class="text-[10px] font-bold text-green-600 uppercase tracking-widest">Reserva segura y encriptada</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function nextStep(step) {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            document.getElementById('step' + step).classList.add('active');

            for (let i = 1; i <= 3; i++) {
                const label = document.getElementById('step' + i + '-label');
                if (i <= step) {
                    label.classList.replace('step-inactive', 'step-active');
                } else {
                    label.classList.replace('step-active', 'step-inactive');
                }
            }
        }

        function addHuesped() {
            const container = document.getElementById('huespedes-container');
            const newRow = document.createElement('div');
            newRow.className = 'flex gap-3 animate-fadeIn';
            newRow.innerHTML = `
                <input type="text" name="huespedes[]" required class="flex-1 rounded-2xl border-slate-200 dark:bg-slate-800 dark:border-slate-700 p-4" placeholder="Nombre completo del huésped">
                <button type="button" onclick="this.parentElement.remove()" class="size-14 rounded-2xl bg-red-50 text-red-500 flex items-center justify-center">
                    <span class="material-symbols-outlined">delete</span>
                </button>
            `;
            container.appendChild(newRow);
        }
    </script>
</body>

</html>