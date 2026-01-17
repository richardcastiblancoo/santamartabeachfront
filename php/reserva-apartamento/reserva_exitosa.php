<?php
$isEmbed = isset($_GET['embed']) && $_GET['embed'] === '1';
?>
<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Reserva Exitosa - Santamartabeachfront</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="/public/img/logo-portada.png" type="image/x-icon">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13a4ec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101c22",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans"]
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#111618] dark:text-white flex items-center justify-center min-h-screen p-4">

    <div class="bg-white dark:bg-slate-900 p-8 md:p-12 rounded-3xl shadow-2xl text-center max-w-lg w-full border border-slate-200 dark:border-slate-800">
        <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-5xl">check_circle</span>
        </div>
        
        <h1 class="text-3xl font-black mb-4">¡Solicitud Enviada!</h1>
        <p class="text-slate-600 dark:text-slate-400 text-lg mb-8">
            Tu solicitud de reserva ha sido recibida correctamente. El administrador revisará tu solicitud y se pondrá en contacto contigo pronto.
        </p>

        <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-xl mb-8 text-left">
            <p class="text-sm text-slate-500 mb-1">ID de Solicitud</p>
            <p class="font-mono font-bold text-xl tracking-wider">#<?php echo isset($_GET['id']) ? str_pad($_GET['id'], 6, '0', STR_PAD_LEFT) : 'PENDIENTE'; ?></p>
        </div>

        <?php if ($isEmbed): ?>
            <button onclick="notifyParentAndClose()" class="block w-full py-4 bg-primary text-white rounded-xl font-bold text-lg hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                Volver al Panel
            </button>
        <?php else: ?>
            <a href="/" class="block w-full py-4 bg-primary text-white rounded-xl font-bold text-lg hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                Volver al Inicio
            </a>
        <?php endif; ?>
    </div>

    <?php if ($isEmbed): ?>
        <script>
            function notifyParentAndClose() {
                if (window.parent) {
                    window.parent.postMessage({ type: 'reservation_completed' }, window.location.origin);
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                notifyParentAndClose();
            });
        </script>
    <?php endif; ?>

</body>
</html>
