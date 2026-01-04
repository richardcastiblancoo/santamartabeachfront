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

if ($_SESSION['rol'] != 'Admin') {
    echo '
        <script>
            alert("No tienes permisos de administrador");
            window.location = "../index.php";
        </script>
    ';
    die();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Santamartabeachfront</title>
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
            <span class="font-bold text-lg tracking-tight text-[#111618] dark:text-white">Admin Panel</span>
        </div>
        <div class="flex items-center gap-4">
            <span class="font-medium">Hola, <?php echo $_SESSION['nombre']; ?></span>
            <a href="cerrar_sesion.php" class="text-sm font-bold text-red-500 hover:text-red-700">Cerrar Sesión</a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto p-6 md:p-10">
        <h1 class="text-3xl font-bold mb-8">Gestión de Cuenta</h1>

        <div class="bg-white dark:bg-[#1a2c34] rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">lock_reset</span>
                Cambiar Contraseña
            </h2>
            
            <form action="cambiar_password_be.php" method="POST" class="max-w-md flex flex-col gap-4">
                <label class="flex flex-col flex-1 gap-2">
                    <p class="text-sm font-bold">Contraseña Actual</p>
                    <input name="password_actual" type="password" required class="form-input rounded-xl border border-gray-300 dark:border-gray-600 bg-transparent px-4 h-12" placeholder="••••••••" />
                </label>
                
                <label class="flex flex-col flex-1 gap-2">
                    <p class="text-sm font-bold">Nueva Contraseña</p>
                    <input name="password_nueva" type="password" required class="form-input rounded-xl border border-gray-300 dark:border-gray-600 bg-transparent px-4 h-12" placeholder="••••••••" />
                </label>
                
                <label class="flex flex-col flex-1 gap-2">
                    <p class="text-sm font-bold">Confirmar Nueva Contraseña</p>
                    <input name="password_confirmar" type="password" required class="form-input rounded-xl border border-gray-300 dark:border-gray-600 bg-transparent px-4 h-12" placeholder="••••••••" />
                </label>

                <button type="submit" class="bg-primary hover:bg-[#0f8bc7] text-white font-bold h-12 rounded-xl mt-2 transition-colors">
                    Actualizar Contraseña
                </button>
            </form>
        </div>
    </div>

</body>
</html>
