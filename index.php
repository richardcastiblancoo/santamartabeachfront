<!DOCTYPE html>
<html class="light" lang="es-CO">

<head>
    <!-- los metadatos -->
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="description" content="Vive la experiencia rente al mar lo mejores apartamentos en Santamartabeachfront te esperan. Despierta con el sonido de las olas.">
    <meta name="keywords" content="apartamentos Santa Marta, alquiler turístico Santa Marta, apartamentos frente al mar, hoteles Santa Marta, hospedaje Rodadero, alojamiento playa Salguero, apartamentos con piscina Santa Marta, turismo Santa Marta, vacaciones Caribe colombiano">
    <meta name="author" content="santamartabeachfront">
    <meta name="robots" content="index, follow">
    <!-- opengraph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.santamartabeachfront.com">
    <meta property="og:title" content="Santamartabeachfront">
    <meta property="og:description" content="Vive la experiencia rente al mar lo mejores apartamentos en Santamartabeachfront te esperan. Despierta con el sonido de las olas.">
    <meta property="og:image" content="https://www.tusitio.com/imagen-de-portada.jpg">
    <!-- opengraph twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://www.tusitio.com/">
    <meta name="twitter:title" content="Título de tu Página">
    <meta name="twitter:description" content="Descripción para Twitter.">
    <meta name="twitter:image" content="https://www.tusitio.com/imagen-de-portada.jpg">
    <!-- titulo -->
    <title>santamartabeachfront - Alquiler de Apartamentos</title>
    <!-- links css y logo -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#000000">

    <link rel="canonical" href="https://www.santamartabeachfront.com">
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link rel="stylesheet" href="/css/style.css">
    <link rel="shortcut icon" href="/public/img/logo-portada.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <!-- los scripts -->
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

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('Service Worker registrado', reg))
                    .catch(err => console.warn('Error al registrar SW', err));
            });
        }
    </script>

</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#111618] dark:text-white transition-colors duration-200">

    <?php include 'include/header.php'; ?>

    <?php include 'include/serviciosofresidos.php'; ?>

    <?php include 'include/Consultadisponibilidadentiemporeal.php'; ?>

    <?php include 'include/apartamentos.php'; ?>

    <?php include 'include/testimonios.php'; ?>

    <?php include 'include/ubicacion.php'; ?>

    <?php include 'include/footer.php'; ?>

    <script src="sw.js"></script>

</body>

</html>