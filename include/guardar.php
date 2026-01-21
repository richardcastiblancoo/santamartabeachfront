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
    <link href="/css/style.css" rel="stylesheet" />
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

    <script src="/public/dist/main.js"></script>

</body>

</html>
