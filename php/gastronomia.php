<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Lugares Recomendados</title>
    <link rel="shortcut icon" href="/public/img/logo-definitivo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#000000",
                        "accent": "#c26647",
                        "background-light": "#fdfaf8",
                        "background-dark": "#0a0a0a",
                    },
                    fontFamily: {
                        "sans": ["Plus Jakarta Sans", "sans-serif"],
                        "display": ["Cormorant Garamond", "serif"]
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        }
                    },
                    animation: {
                        fadeInUp: 'fadeInUp 0.6s ease-out forwards',
                    }
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 20;
        }
        .restaurant-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
        }
        .restaurant-card.visible {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .restaurant-card:hover {
            border-color: #c26647;
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -10px rgba(194, 102, 71, 0.1);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-sans text-[#111618] dark:text-gray-100 transition-colors duration-300">
    <div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">

            <header class="flex items-center justify-between border-b border-gray-100 dark:border-gray-900 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md px-6 md:px-12 py-5 sticky top-0 z-50">
                <div class="flex items-center gap-12">
                    <a class="flex items-center gap-3 text-black dark:text-white" href="/index.php">
                        <div class="size-8">
                            <img src="/public/img/logo-definitivo.png" alt="logo" class="object-contain w-full h-full">
                        </div>
                        <h2 class="text-lg font-bold tracking-tight uppercase">Santamartabeachfront</h2>
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <button onclick="changeLanguage('es')" class="text-[10px] font-bold uppercase tracking-widest hover:text-accent transition-colors">ES</button>
                    <span class="text-gray-300 dark:text-gray-800">|</span>
                    <button onclick="changeLanguage('en')" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-accent transition-colors">EN</button>
                </div>
            </header>

            <main class="flex-1 max-w-[1400px] mx-auto w-full px-6 md:px-12 py-20">
                <div class="mb-16 text-center md:text-left animate-fadeInUp">
                    <h1 class="font-display text-5xl md:text-7xl text-black dark:text-white mb-6 italic" data-key="hero-title">Lugares Recomendados</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-lg font-light max-w-xl leading-relaxed" data-key="hero-subtitle">Selección exclusiva de experiencias gastronómicas en Santa Marta.</p>
                </div>
                <div id="restaurant-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-24">
                </div>
            </main>

        </div>
    </div>

    <script>
        const translations = {
            es: {
                "hero-title": "Lugares Recomendados",
                "hero-subtitle": "Selección exclusiva de experiencias gastronómicas en Santa Marta.",
                "restaurants": [{
                        name: "Ouzo Santa Marta",
                        addr: "Carrera 3 #19-29, Centro",
                        tel: "+57 304 666 7788"
                    },
                    {
                        name: "Donde Chucho Gourmet",
                        addr: "Calle 19 #2-17, Centro",
                        tel: "+57 318 555 6677"
                    },
                    {
                        name: "Tsuki Sushi Bar",
                        addr: "Carrera 3 #16-44, Centro",
                        tel: "+57 301 222 3344"
                    },
                    {
                        name: "Burukuka",
                        addr: "Edificio El Rodadero",
                        tel: "+57 315 888 9900"
                    },
                    {
                        name: "Mar y Zielo",
                        addr: "Calle 15 #3-05, Centro",
                        tel: "+57 300 444 5566"
                    },
                    {
                        name: "Radio Salsa",
                        addr: "Calle 17 #2-44, Centro",
                        tel: "+57 310 111 2233"
                    },
                    {
                        name: "Soul Food",
                        addr: "Calle 16 #2-58, Centro",
                        tel: "+57 302 999 8877"
                    },
                    {
                        name: "Porthos Steakhouse",
                        addr: "Carrera 3 #17-26, Centro",
                        tel: "+57 311 444 5566"
                    },
                    {
                        name: "Guasimo",
                        addr: "Calle 12 #3-87, Centro",
                        tel: "+57 305 777 8899"
                    },
                    {
                        name: "Lulo",
                        addr: "Carrera 3 #16-34, Centro",
                        tel: "+57 320 666 5544"
                    }
                ]
            },
            en: {
                "hero-title": "Recommended Places",
                "hero-subtitle": "Exclusive selection of gastronomic experiences in Santa Marta.",
                "restaurants": [{
                        name: "Ouzo Santa Marta",
                        addr: "3rd Ave #19-29, Downtown",
                        tel: "+57 304 666 7788"
                    },
                    {
                        name: "Donde Chucho Gourmet",
                        addr: "19th St #2-17, Downtown",
                        tel: "+57 318 555 6677"
                    },
                    {
                        name: "Tsuki Sushi Bar",
                        addr: "3rd Ave #16-44, Downtown",
                        tel: "+57 301 222 3344"
                    },
                    {
                        name: "Burukuka",
                        addr: "El Rodadero Building",
                        tel: "+57 315 888 9900"
                    },
                    {
                        name: "Mar y Zielo",
                        addr: "15th St #3-05, Downtown",
                        tel: "+57 300 444 5566"
                    },
                    {
                        name: "Radio Salsa",
                        addr: "17th St #2-44, Downtown",
                        tel: "+57 310 111 2233"
                    },
                    {
                        name: "Soul Food",
                        addr: "16th St #2-58, Downtown",
                        tel: "+57 302 999 8877"
                    },
                    {
                        name: "Porthos Steakhouse",
                        addr: "3rd Ave #17-26, Downtown",
                        tel: "+57 311 444 5566"
                    },
                    {
                        name: "Guasimo",
                        addr: "12th St #3-87, Downtown",
                        tel: "+57 305 777 8899"
                    },
                    {
                        name: "Lulo",
                        addr: "3rd Ave #16-34, Downtown",
                        tel: "+57 320 666 5544"
                    }
                ]
            }
        };

        function changeLanguage(lang) {
            document.documentElement.lang = lang;
            document.querySelectorAll('[data-key]').forEach(el => {
                const key = el.getAttribute('data-key');
                if (translations[lang][key]) el.innerText = translations[lang][key];
            });
            renderRestaurants(lang);
        }

        function renderRestaurants(lang) {
            const grid = document.getElementById('restaurant-grid');
            grid.innerHTML = '';

            translations[lang].restaurants.forEach((res, index) => {
                const card = document.createElement('div');
                card.className = `restaurant-card bg-white dark:bg-gray-950 border border-gray-100 dark:border-gray-900 p-8 flex flex-col gap-4`;
                card.style.animationDelay = `${index * 0.1}s`;

                card.innerHTML = `
                    <h3 class="font-display text-2xl text-black dark:text-white leading-tight">${res.name}</h3>
                    <div class="space-y-2 mt-2">
                        <p class="text-gray-500 dark:text-gray-400 text-xs font-medium flex items-center gap-2">
                            <span class="material-symbols-outlined !text-sm text-accent">location_on</span> ${res.addr}
                        </p>
                        <p class="text-gray-400 dark:text-gray-500 text-[11px] tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined !text-sm">call</span> ${res.tel}
                        </p>
                    </div>
                `;
                grid.appendChild(card);
                setTimeout(() => card.classList.add('visible'), 50);
            });
        }

        document.addEventListener('DOMContentLoaded', () => changeLanguage('es'));
    </script>
</body>

</html>