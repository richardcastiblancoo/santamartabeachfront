<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="description" content="Alquila un apartamento frente al mar en Santamarta. Disponible para todo tipo de eventos.">
    <meta name="keywords" content="alquiler, apartamentos, Santamarta, eventos, mar, frente al mar">
    <meta name="author" content="santamartabeachfront">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://www.santamartabeachfront.com">
    <title>santamartabeachfront - Alquiler de Apartamentos</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="shortcut icon" href="/public/img/olas.webp" type="image/x-icon">
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

</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#111618] dark:text-white transition-colors duration-200">

    <?php include 'include/main-portada.php'; ?>

    <?php include 'include/Consultadisponibilidadentiemporeal.php'; ?>

    <section class="py-20 bg-background-light dark:bg-background-dark" id="apartamentos">
        <div class="px-6 md:px-20 mb-10 flex items-end justify-between">
            <div>
                <h2 class="text-3xl font-bold text-[#111618] dark:text-white mb-2">Apartamentos Destacados</h2>
                <p class="text-gray-500 dark:text-gray-400">Encuentra el espacio perfecto para tus vacaciones</p>
            </div>
            <div class="hidden md:flex gap-2">
                <button class="size-10 rounded-full border border-gray-300 dark:border-gray-600 flex items-center justify-center hover:bg-white dark:hover:bg-gray-800 dark:text-white transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                </button>
                <button class="size-10 rounded-full border border-gray-300 dark:border-gray-600 flex items-center justify-center hover:bg-white dark:hover:bg-gray-800 dark:text-white transition-colors">
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
        </div>
        <div class="flex overflow-x-auto gap-6 px-6 md:px-20 pb-10 scrollbar-hide snap-x">
            <div class="min-w-[320px] md:min-w-[380px] bg-white dark:bg-[#1e2930] rounded-2xl overflow-hidden shadow-lg group snap-center border border-gray-100 dark:border-gray-700">
                <div class="relative h-60 overflow-hidden">
                    <div class="absolute top-4 right-4 z-10 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-gray-800 flex items-center gap-1 shadow-sm">
                        <span class="material-symbols-outlined text-yellow-500 text-sm">star</span> 4.9
                    </div>
                    <div class="h-full w-full bg-cover bg-center group-hover:scale-110 transition-transform duration-500" data-alt="Modern bright apartment living room with ocean view" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCgU9C9lJKWagyFbWvyT4IQnxaWgMyGskYBaxjCLFV33A8NhbqKE-k9vx2ecgP0-TceIM9-tBVAct69YxSdYGNlLscKYBkWYI7Prf7HqQ847IUmbfpQHbTwWkH4iS60qOwaUUMHy0xNvnImvF-yXFvlDbLiiBdF6bC6G0AWMbgH2xxbn1aMcRBW4ggZLUG2n9oySCp7DT5qanudP-r65QCRWbwp0Lolwu8_FIRPW6JD9XibqYfqyax4Iih9z_QaoBKIwEJfGGT3LVM');"></div>
                </div>
                <div class="p-6">
                    <div class="text-xs font-bold text-primary uppercase tracking-wide mb-2">Edificio Alborada</div>
                    <h3 class="text-xl font-bold dark:text-white mb-2">Penthouse Vista al Mar</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                        Espacioso apartamento de 3 habitaciones con balcón panorámico. Ideal para familias grandes.
                    </p>
                    <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-6">
                        <div class="flex items-center gap-1"><span class="material-symbols-outlined text-lg">bed</span> 3 Hab</div>
                        <div class="flex items-center gap-1"><span class="material-symbols-outlined text-lg">shower</span> 2 Baños</div>
                        <div class="flex items-center gap-1"><span class="material-symbols-outlined text-lg">person</span> 6 Huéspedes</div>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                        <div>
                            <span class="text-lg font-bold text-[#111618] dark:text-white">$150</span>
                            <span class="text-gray-500 text-sm">/noche</span>
                        </div>
                        <button class="text-primary font-bold text-sm hover:underline">Ver detalles</button>
                    </div>
                </div>
            </div>
            <div class="min-w-[320px] md:min-w-[380px] bg-white dark:bg-[#1e2930] rounded-2xl overflow-hidden shadow-lg group snap-center border border-gray-100 dark:border-gray-700">
                <div class="relative h-60 overflow-hidden">
                    <div class="absolute top-4 right-4 z-10 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-gray-800 flex items-center gap-1 shadow-sm">
                        <span class="material-symbols-outlined text-yellow-500 text-sm">star</span> 4.8
                    </div>
                    <div class="h-full w-full bg-cover bg-center group-hover:scale-110 transition-transform duration-500" data-alt="Cozy bedroom with minimalist decor and soft lighting" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDyPt4iX-zz6l3Mr1RZgnOvx9Z4sOCFNRaZHOGDMtFzMlF6ywhEMxl74k9Zr5HaMJNJY32L1eJApKtoqz7l8e2jBHgVPb6C60oOPujYMdReYqC7Myp2O6lLhDTxvajUwQ2Q8I8S4ZffDgR6zRqYzZfYnhV0de4LQEAHLQ8NO7XjY_2dd_kyC2Ufl1rilq118usMk1KVZO5rGdNMFsEXkh0gdEERC_-DvUDRA3wAeGkGD3c9GmAfmtVsw5Vstf6imajH0x0gvNhUMbw');"></div>
                </div>
                <div class="p-6">
                    <div class="text-xs font-bold text-primary uppercase tracking-wide mb-2">Edificio Cristales</div>
                    <h3 class="text-xl font-bold dark:text-white mb-2">Studio Moderno</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                        Perfecto para parejas. Diseño contemporáneo y acceso directo a la zona comercial.
                    </p>
                    <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-6">
                        <div class="flex items-center gap-1"><span class="material-symbols-outlined text-lg">bed</span> 1 Hab</div>
                        <div class="flex items-center gap-1"><span class="material-symbols-outlined text-lg">shower</span> 1 Baño</div>
                        <div class="flex items-center gap-1"><span class="material-symbols-outlined text-lg">person</span> 2 Huéspedes</div>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                        <div>
                            <span class="text-lg font-bold text-[#111618] dark:text-white">$85</span>
                            <span class="text-gray-500 text-sm">/noche</span>
                        </div>
                        <button class="text-primary font-bold text-sm hover:underline">Ver detalles</button>
                    </div>
                </div>
            </div>
            <div class="min-w-[320px] md:min-w-[380px] bg-white dark:bg-[#1e2930] rounded-2xl overflow-hidden shadow-lg group snap-center border border-gray-100 dark:border-gray-700">
                <div class="relative h-60 overflow-hidden">
                    <div class="absolute top-4 right-4 z-10 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-gray-800 flex items-center gap-1 shadow-sm">
                        <span class="material-symbols-outlined text-yellow-500 text-sm">star</span> 5.0
                    </div>
                    <div class="h-full w-full bg-cover bg-center group-hover:scale-110 transition-transform duration-500" data-alt="Luxury kitchen and dining area in a large apartment" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDhr-fja2E9oqdW3FeI503YhZXCPEnOJ34yXhATmDRax6RvUtXR9_eoJUbYx6EnOIEBRlfT-n5Lm7cAmW4TdhEEg2CZTdot2tDAeJVpKdZFVPa2mr_j_H0Rr1Ch8-atttcHQXDqxmq88aXJm6kKarN2geXSWHwJTwm9KKqowzPZTLx_CDcwuyj5QbBGTsy5nFJtSVhcea4WvOFsS-dRRyjJDI8m1dEnYEeSgIcv6YlxLk2VrCukZJSRiVae4DykJUmwqInWo07FO3U');"></div>
                </div>
                <div class="p-6">
                    <div class="text-xs font-bold text-primary uppercase tracking-wide mb-2">Reserva del Mar</div>
                    <h3 class="text-xl font-bold dark:text-white mb-2">Suite Familiar de Lujo</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                        Lujo en cada detalle. Cocina gourmet, terraza privada y acabados premium.
                    </p>
                    <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-6">
                        <div class="flex items-center gap-1"><span class="material-symbols-outlined text-lg">bed</span> 2 Hab</div>
                        <div class="flex items-center gap-1"><span class="material-symbols-outlined text-lg">shower</span> 2 Baños</div>
                        <div class="flex items-center gap-1"><span class="material-symbols-outlined text-lg">person</span> 5 Huéspedes</div>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                        <div>
                            <span class="text-lg font-bold text-[#111618] dark:text-white">$210</span>
                            <span class="text-gray-500 text-sm">/noche</span>
                        </div>
                        <button class="text-primary font-bold text-sm hover:underline">Ver detalles</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="grid grid-cols-1 lg:grid-cols-2 min-h-[500px]" id="ubicacion">
        <div class="bg-white dark:bg-[#101c22] p-10 lg:p-20 flex flex-col justify-center">
            <div class="flex items-center gap-2 text-primary font-bold mb-4">
                <span class="material-symbols-outlined">map</span>
                <span>UBICACIÓN ESTRATÉGICA</span>
            </div>
            <h2 class="text-4xl font-bold mb-6 text-[#111618] dark:text-white">Cerca de todo lo que importa</h2>
            <p class="text-gray-500 dark:text-gray-400 mb-8 text-lg">
                Estamos ubicados en el corazón de la zona turística, a pocos minutos del Aeropuerto y con acceso directo a las principales playas y restaurantes.
            </p>
            <ul class="space-y-4 mb-8">
                <li class="flex items-center gap-3">
                    <div class="size-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                        <span class="material-symbols-outlined text-sm">flight</span>
                    </div>
                    <span class="dark:text-gray-300">15 min del Aeropuerto Internacional</span>
                </li>
                <li class="flex items-center gap-3">
                    <div class="size-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <span class="material-symbols-outlined text-sm">restaurant</span>
                    </div>
                    <span class="dark:text-gray-300">5 min de Zona Gastronómica</span>
                </li>
                <li class="flex items-center gap-3">
                    <div class="size-8 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600 dark:text-orange-400">
                        <span class="material-symbols-outlined text-sm">park</span>
                    </div>
                    <span class="dark:text-gray-300">20 min del Parque Tayrona</span>
                </li>
            </ul>
            <button class="self-start text-primary font-bold underline decoration-2 underline-offset-4 hover:text-primary/80">
                Abrir en Google Maps
            </button>
        </div>
        <div class="relative h-[400px] lg:h-auto w-full bg-gray-200">
            <div class="w-full h-full bg-cover bg-center grayscale hover:grayscale-0 transition-all duration-500" data-location="Santa Marta Map View" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCIYZaqX3SugCDpS7l5OcQt3kLA8qqIsHw6iRh6XF3Pr6xnU2xaMAuioSSwDCx9fWO_a3G0FA_AZuYNOLcFW0TWiyInCOWeOdH1XMaWZsQAzonXmd4_PgKPY9-Yppyei8aFRo8qsNR-oWIFB_FjYbOLjEaG8pAp5LbG5Lzxz4R2aZuhpyCVSK7h9G2vcWtWts8A4cCa_c4_Rq__lg52WI5JeRp17SjquBBHVmiaiuqSjdrm8zg93DuUhpTsGB3Ma9j2UMuWTvXgLKE');">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col items-center">
                    <div class="bg-white px-3 py-1 rounded-lg shadow-md mb-2 text-xs font-bold text-gray-800 animate-bounce">
                        Santamartabeachfront
                    </div>
                    <span class="material-symbols-outlined text-primary text-5xl drop-shadow-lg">location_on</span>
                </div>
            </div>
        </div>
    </section>
    <footer class="bg-[#101c22] text-white pt-20 pb-10" id="contacto">
        <div class="max-w-6xl mx-auto px-6 md:px-10">
            <div class="flex flex-col md:flex-row justify-between items-center pb-16 border-b border-gray-800">
                <div class="mb-8 md:mb-0 text-center md:text-left">
                    <h2 class="text-3xl font-bold mb-2">¿Listo para tus vacaciones?</h2>
                    <p class="text-gray-400">Reserva hoy y asegura el mejor precio garantizado.</p>
                </div>
                <button class="bg-primary hover:bg-primary/90 text-white font-bold py-4 px-8 rounded-xl shadow-lg shadow-primary/20 transition-all transform hover:-translate-y-1">
                    Reservar Ahora
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 py-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-4 text-primary">
                        <span class="material-symbols-outlined text-3xl">apartment</span>
                        <span class="text-xl font-bold text-white">Santamarta</span>
                    </div>
                    <p class="text-gray-500 text-sm max-w-sm">
                        La plataforma líder en alquileres vacacionales de lujo en Santa Marta. Experiencias únicas, confort y las mejores vistas del Caribe.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-gray-300">Enlaces Rápidos</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a class="hover:text-primary transition-colors" href="#">Apartamentos</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Disponibilidad</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Servicios</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Blog de Viajes</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-gray-300">Contacto</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-xs">mail</span> info@santamarta.com</li>
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-xs">call</span> +57 300 123 4567</li>
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-xs">pin_drop</span> Rodadero, Santa Marta</li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center pt-8 text-xs text-gray-600">
                <p>© <span id="year"></span> Santamarta Beachfront. Todos los derechos reservados.</p>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <a class="hover:text-white" href="#">Política de Privacidad</a>
                    <a class="hover:text-white" href="#">Términos y Condiciones</a>
                </div>
            </div>
        </div>
    </footer>
    </div>

    <script src="/js/main.js"></script>

</body>

</html>