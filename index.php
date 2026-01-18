<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="description" content="Disfruta de un apartamento de lujo frente al mar en Santa Marta para toda tu familia, nuestro condominio con vista a la playa combinan diseño y comodidad, con espacios amplios, servicio personalizado y todas las amenidades de un hotel Reserva del Mar Santa Marta">
    <meta name="keywords" content="Reserva del Mar Santa Marta, apartamentos frente al mar, Santa Marta, Reserva del Mar, apartamentos de lujo, condominio con vista a la playa, espacios amplios, servicio personalizado, amenidades de hotel">
    <title>Santamartabeachfront - reservas del mar</title>
    <link rel="shortcut icon" href="/public/img/logo-portada.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .lang-dropdown:hover .lang-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .lang-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.2s ease;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#111618] dark:text-white transition-colors duration-200">
    <div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">

        <?php include 'include/header.php'; ?>

        <?php include 'include/serviciosofresidos.php'; ?>
       
       <?php include 'include/Consultadisponibilidadentiemporeal.php'; ?>
        

         <!-- reseñas -->
        

        <!-- reseñas -->
        <?php include 'include/testimonios.php'; ?>


        <!-- Ubicación -->
        <?php include 'include/ubicacion.php'; ?>


        <?php include 'include/footer.php'; ?>


    </div>

    <script src="/js/main.js"></script>

</body>

</html>