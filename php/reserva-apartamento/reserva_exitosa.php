<?php
session_start();
include '../../auth/conexion_be.php';

$isEmbed = isset($_GET['embed']) && $_GET['embed'] === '1';
$id_reserva = isset($_GET['id']) ? intval($_GET['id']) : 0;

$reserva = null;
if ($id_reserva > 0) {
    $sql = "SELECT r.*, a.titulo 
            FROM reservas r 
            JOIN apartamentos a ON r.apartamento_id = a.id 
            WHERE r.id = $id_reserva LIMIT 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $reserva = $result->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Reserva Exitosa - Santamartabeachfront</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .lang-btn {
            cursor: pointer;
            transition: all 0.2s;
            filter: grayscale(100%);
            opacity: 0.5;
        }

        .lang-btn.active {
            filter: grayscale(0%);
            opacity: 1;
            transform: scale(1.1);
        }
    </style>
</head>

<body class="bg-[#f6f7f8] dark:bg-[#101c22] text-[#111618] dark:text-white flex flex-col items-center justify-center min-h-screen p-4">

    <div class="flex items-center gap-4 mb-6 bg-white dark:bg-slate-900 p-2 px-4 rounded-full shadow-sm border border-slate-200 dark:border-slate-800">
        <div class="flex items-center gap-2">
            <img src="https://flagcdn.com/w40/co.png" onclick="setLanguage('es')" id="btn-es" class="lang-btn active w-6 h-4 object-cover rounded-sm" title="Español">
            <img src="https://flagcdn.com/w40/us.png" onclick="setLanguage('en')" id="btn-en" class="lang-btn w-6 h-4 object-cover rounded-sm" title="English">
        </div>
        <div class="h-4 w-[1px] bg-slate-300"></div>
        <span class="text-[10px] font-black uppercase tracking-widest opacity-70" data-key="status_title">Estado de Solicitud</span>
    </div>

    <div class="bg-white dark:bg-slate-900 p-8 md:p-12 rounded-3xl shadow-2xl text-center max-w-lg w-full border border-slate-200 dark:border-slate-800">
        <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-5xl">check_circle</span>
        </div>

        <h1 class="text-3xl font-black mb-4" data-key="success_h1">¡Solicitud Enviada!</h1>
        <p class="text-slate-600 dark:text-slate-400 text-lg mb-8">
            <span data-key="success_greeting">Hola</span> <span class="font-bold text-primary"><?php echo $reserva ? htmlspecialchars($reserva['nombre_cliente']) : 'viajero'; ?></span>,
            <span data-key="success_msg">tu solicitud para</span> <strong><?php echo $reserva ? htmlspecialchars($reserva['titulo']) : 'el apartamento'; ?></strong> <span data-key="success_received">ha sido recibida.</span>
        </p>

        <div class="bg-slate-50 dark:bg-slate-800 p-6 rounded-2xl mb-8 text-left space-y-3">
            <div class="flex justify-between border-b border-slate-200 dark:border-slate-700 pb-2">
                <span class="text-sm text-slate-500" data-key="label_id">ID de Solicitud</span>
                <span class="font-mono font-bold text-primary">#<?php echo str_pad($id_reserva, 6, '0', STR_PAD_LEFT); ?></span>
            </div>
            <?php if ($reserva): ?>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500 font-bold" data-key="label_arrival">Llegada:</span>
                    <span class="font-semibold"><?php echo date('d M, Y', strtotime($reserva['fecha_checkin'])); ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500 font-bold" data-key="label_departure">Salida:</span>
                    <span class="font-semibold"><?php echo date('d M, Y', strtotime($reserva['fecha_checkout'])); ?></span>
                </div>
                <div class="flex justify-between text-sm pt-2 border-t border-slate-200 dark:border-slate-700">
                    <span class="font-bold" data-key="label_total">Total estimado:</span>
                    <span class="font-bold text-lg">$<?php echo number_format($reserva['precio_total'], 0, ',', '.'); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <p class="text-sm text-slate-500 mb-8 italic" data-key="footer_note">
            El administrador revisará la disponibilidad y te contactará al correo proporcionado.
        </p>

        <?php if ($isEmbed): ?>
            <button onclick="notifyParentAndClose()" class="block w-full py-4 bg-primary text-white rounded-xl font-bold text-lg hover:bg-primary/90 transition-all shadow-lg" data-key="btn_panel">
                Volver al Panel
            </button>
        <?php else: ?>
            <a href="/" class="block w-full py-4 bg-primary text-white rounded-xl font-bold text-lg hover:bg-primary/90 transition-all shadow-lg" data-key="btn_home">
                Finalizar y Volver
            </a>
        <?php endif; ?>
    </div>

    <script>
        const translations = {
            es: {
                status_title: "Estado de Solicitud",
                success_h1: "¡Solicitud Enviada!",
                success_greeting: "Hola",
                success_msg: "tu solicitud para",
                success_received: "ha sido recibida.",
                label_id: "ID de Solicitud",
                label_arrival: "Llegada:",
                label_departure: "Salida:",
                label_total: "Total estimado:",
                footer_note: "El administrador revisará la disponibilidad y te contactará al correo proporcionado.",
                btn_panel: "Volver al Panel",
                btn_home: "Finalizar y Volver"
            },
            en: {
                status_title: "Request Status",
                success_h1: "Request Sent!",
                success_greeting: "Hi",
                success_msg: "your request for",
                success_received: "has been received.",
                label_id: "Request ID",
                label_arrival: "Arrival:",
                label_departure: "Departure:",
                label_total: "Estimated Total:",
                footer_note: "The admin will review availability and contact you via the email provided.",
                btn_panel: "Back to Panel",
                btn_home: "Finish and Return"
            }
        };

        function setLanguage(lang) {
            document.getElementById('btn-es').classList.toggle('active', lang === 'es');
            document.getElementById('btn-en').classList.toggle('active', lang === 'en');

            document.querySelectorAll('[data-key]').forEach(el => {
                const key = el.getAttribute('data-key');
                if (translations[lang][key]) el.innerText = translations[lang][key];
            });
            localStorage.setItem('preferredLang', lang);
        }

        function notifyParentAndClose() {
            if (window.parent) {
                window.parent.postMessage({
                    type: 'reservation_completed',
                    id: '<?php echo $id_reserva; ?>'
                }, "*");
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const savedLang = localStorage.getItem('preferredLang') || 'es';
            setLanguage(savedLang);
            <?php if ($isEmbed): ?>
                setTimeout(notifyParentAndClose, 5000);
            <?php endif; ?>
        });
    </script>
</body>

</html>