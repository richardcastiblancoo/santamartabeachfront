<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo '
        <script>
            alert("Por favor debes iniciar sesión");
            window.location = "login.php";
        </script>
    ';
    session_destroy();
    die();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido Huésped - Santamartabeachfront</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="../css/style.css">
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
                },
            },
        }
    </script>
</head>
<body class="bg-background-light dark:bg-background-dark text-[#111618] dark:text-white font-display">
    
    <nav class="bg-white dark:bg-[#1a2c34] shadow-md px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2 text-primary">
            <span class="material-symbols-outlined text-3xl">waves</span>
            <span class="font-bold text-lg tracking-tight text-[#111618] dark:text-white">Santamartabeachfront</span>
        </div>
        <div class="flex items-center gap-4">
            <span class="font-medium">Hola, <?php echo $_SESSION['nombre']; ?></span>
            <a href="cerrar_sesion.php" class="text-sm font-bold text-red-500 hover:text-red-700">Cerrar Sesión</a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto p-6 md:p-10">
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-bold mb-4">¡Bienvenido a tu experiencia en Santa Marta!</h1>
            <p class="text-xl text-gray-500 dark:text-gray-400">Nos alegra tenerte con nosotros.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Tarjeta 1 -->
            <div class="bg-white dark:bg-[#1a2c34] rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="h-48 bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCgU9C9lJKWagyFbWvyT4IQnxaWgMyGskYBaxjCLFV33A8NhbqKE-k9vx2ecgP0-TceIM9-tBVAct69YxSdYGNlLscKYBkWYI7Prf7HqQ847IUmbfpQHbTwWkH4iS60qOwaUUMHy0xNvnImvF-yXFvlDbLiiBdF6bC6G0AWMbgH2xxbn1aMcRBW4ggZLUG2n9oySCp7DT5qanudP-r65QCRWbwp0Lolwu8_FIRPW6JD9XibqYfqyax4Iih9z_QaoBKIwEJfGGT3LVM');"></div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">Mis Reservas</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Consulta el estado de tus reservas actuales y pasadas.</p>
                    <button class="text-primary font-bold hover:underline">Ver Reservas</button>
                </div>
            </div>

            <!-- Tarjeta 2 -->
            <div class="bg-white dark:bg-[#1a2c34] rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="h-48 bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDyPt4iX-zz6l3Mr1RZgnOvx9Z4sOCFNRaZHOGDMtFzMlF6ywhEMxl74k9Zr5HaMJNJY32L1eJApKtoqz7l8e2jBHgVPb6C60oOPujYMdReYqC7Myp2O6lLhDTxvajUwQ2Q8I8S4ZffDgR6zRqYzZfYnhV0de4LQEAHLQ8NO7XjY_2dd_kyC2Ufl1rilq118usMk1KVZO5rGdNMFsEXkh0gdEERC_-DvUDRA3wAeGkGD3c9GmAfmtVsw5Vstf6imajH0x0gvNhUMbw');"></div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">Explorar Apartamentos</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Encuentra el lugar perfecto para tu próxima estadía.</p>
                    <a href="../index.php#apartamentos" class="text-primary font-bold hover:underline">Ver Catálogo</a>
                </div>
            </div>

            <!-- Tarjeta 3 -->
            <div class="bg-white dark:bg-[#1a2c34] rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="h-48 bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDhr-fja2E9oqdW3FeI503YhZXCPEnOJ34yXhATmDRax6RvUtXR9_eoJUbYx6EnOIEBRlfT-n5Lm7cAmW4TdhEEg2CZTdot2tDAeJVpKdZFVPa2mr_j_H0Rr1Ch8-atttcHQXDqxmq88aXJm6kKarN2geXSWHwJTwm9KKqowzPZTLx_CDcwuyj5QbBGTsy5nFJtSVhcea4WvOFsS-dRRyjJDI8m1dEnYEeSgIcv6YlxLk2VrCukZJSRiVae4DykJUmwqInWo07FO3U');"></div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">Servicios Adicionales</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Transporte, tours y experiencias exclusivas.</p>
                    <button class="text-primary font-bold hover:underline">Ver Servicios</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
