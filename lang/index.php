<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santamartabeachfront - Beachfront Apartment Rentals</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
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
        <style>
            :root {
                scroll-behavior: auto;
            }

            /* Prevents automatic scroll */

            .hero-title {
                font-size: clamp(2rem, 5vw, 4rem);
                line-height: 1.1;
                letter-spacing: -0.05em;
                min-height: 2.2em;
            }

            .cursor {
                display: inline-block;
                width: 3px;
                background-color: #3b82f6;
                margin-left: 4px;
                animation: blink 1s infinite;
            }

            @keyframes blink {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0;
                }
            }

            .glass-booking {
                background: rgba(15, 23, 42, 0.85);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .glass-input {
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.1);
                color: white;
                transition: all 0.3s ease;
            }

            #mobile-menu {
                transform: translateY(-100%);
                transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            #mobile-menu.active {
                transform: translateY(0);
            }

            input[type="date"]::-webkit-calendar-picker-indicator {
                filter: invert(1) opacity(0.5);
            }
        </style>

        <header id="main-header" class="fixed top-0 left-0 w-full z-50 flex items-center justify-between px-6 py-4 md:px-10 transition-all duration-300">
            <div class="flex items-center gap-3">
                <a href="/" class="flex items-center gap-3 group">
                    <img
                        src="/public/img/logo-definitivo.png"
                        alt="Logo"
                        class="size-14 md:size-20 object-contain">

                    <h1 class="flex items-center text-white text-base md:text-lg font-black tracking-tighter uppercase leading-none hidden md:inline-block">
                        Santamarta<span class="text-blue-400">beachfront</span>
                    </h1>
                </a>
            </div>

            <nav class="hidden md:flex items-center gap-8">
                <ul class="flex items-center gap-6 list-none">
                    <li><a class="text-white/70 text-[11px] font-bold uppercase tracking-widest hover:text-white transition-colors" href="#apartamentos">Apartments</a></li>
                    <li><a class="text-white/70 text-[11px] font-bold uppercase tracking-widest hover:text-white transition-colors" href="#ubicacion">Location</a></li>
                    <li><a class="text-white/70 text-[11px] font-bold uppercase tracking-widest hover:text-white transition-colors" href="#contacto">Contact</a></li>
                </ul>

                <div class="flex items-center gap-4 border-l border-white/20 pl-6">
                    <div class="relative group">
                        <button class="flex items-center gap-2 text-white text-[11px] font-bold uppercase tracking-widest h-9 px-3 rounded-lg hover:bg-white/10 transition-colors">
                            <img class="w-4 h-4 rounded-full object-cover" src="https://flagcdn.com/w40/us.png" alt="EN">
                            <span>EN</span>
                            <span class="material-symbols-outlined text-sm">expand_more</span>
                        </button>
                        <ul class="hidden group-hover:block absolute top-full right-0 mt-1 w-32 bg-slate-900 border border-white/10 rounded-xl py-2 shadow-2xl">
                            <li><button onclick="changeLanguage('ES')" class="w-full text-left px-4 py-2 text-[11px] text-white font-bold hover:bg-blue-600">SPANISH</button></li>
                            <li><button onclick="changeLanguage('EN')" class="w-full text-left px-4 py-2 text-[11px] text-white font-bold hover:bg-blue-600">ENGLISH</button></li>
                        </ul>
                    </div>
                    <a href="/auth/login.php" class="h-9 px-6 bg-blue-600 text-white text-[11px] font-black uppercase tracking-widest rounded-full flex items-center hover:bg-blue-500 transition-all shadow-lg shadow-blue-600/20">Login</a>
                </div>
            </nav>

            <button onclick="toggleMobileMenu(true)" class="md:hidden text-white p-2">
                <span class="material-symbols-outlined text-3xl">menu</span>
            </button>
        </header>

        <div id="mobile-menu" class="fixed inset-0 bg-slate-950/98 backdrop-blur-xl z-[100] flex flex-col md:hidden">
            <div class="flex justify-between items-center p-6 border-b border-white/10">
                <div class="flex gap-4">
                    <button onclick="changeLanguage('ES')" class="text-white/40 font-bold text-xs border border-white/10 px-3 py-1 rounded">ES</button>
                    <button onclick="changeLanguage('EN')" class="text-white font-bold text-xs border border-white/20 px-3 py-1 rounded">EN</button>
                </div>
                <button onclick="toggleMobileMenu(false)" class="text-white">
                    <span class="material-symbols-outlined text-4xl">close</span>
                </button>
            </div>
            <nav class="flex flex-col items-center justify-center flex-grow gap-8">
                <a href="#apartamentos" onclick="toggleMobileMenu(false)" class="text-white text-2xl font-black uppercase tracking-widest">Apartments</a>
                <a href="#ubicacion" onclick="toggleMobileMenu(false)" class="text-white text-2xl font-black uppercase tracking-widest">Location</a>
                <a href="#contacto" onclick="toggleMobileMenu(false)" class="text-white text-2xl font-black uppercase tracking-widest">Contact</a>
                <a href="/auth/login.php" class="mt-4 px-12 py-4 bg-blue-600 text-white rounded-full font-black uppercase tracking-widest">Login</a>
            </nav>
        </div>

        <main>
            <section class="relative w-full min-h-screen flex items-center justify-center overflow-hidden">
                <div class="absolute inset-0 z-0">
                    <div class="absolute inset-0 bg-black/50 z-10"></div>
                    <video class="w-full h-full object-cover" autoplay muted loop playsinline aria-hidden="true">
                        <source src="/public/video/santamarta-video-tayrona.mp4" type="video/mp4">
                    </video>
                </div>

                <div class="relative z-20 w-full max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center pt-24 pb-12">
                    <div class="text-left">
                        <h2 class="hero-title font-black text-white">
                            <span id="typewriter"></span><span class="cursor"></span><br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">
                                Santa Marta Beachfront
                            </span>
                        </h2>
                        <p class="text-white text-sm md:text-base mt-6 max-w-sm leading-relaxed">
                            Exclusivity and comfort in the best apartments on the Caribbean coast.
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <div class="glass-booking w-full max-w-md p-8 rounded-3xl shadow-2xl">
                            <h3 class="text-white text-lg font-bold mb-6 flex items-center gap-2">
                                <span class="material-symbols-outlined text-blue-400">event_available</span>
                                Book your stay
                            </h3>

                            <form id="reservaForm" class="space-y-4">
                                <div class="space-y-1">
                                    <label for="full-name" class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">Full Name</label>
                                    <input id="full-name" type="text" placeholder="Your name" class="glass-input w-full rounded-xl px-4 py-3 text-sm text-white bg-white/10 border border-white/20" required>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label for="whatsapp" class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">WhatsApp</label>
                                        <input id="whatsapp" type="tel" placeholder="+57..." class="glass-input w-full rounded-xl px-4 py-3 text-sm text-white bg-white/10 border border-white/20" required>
                                    </div>
                                    <div class="space-y-1">
                                        <label for="email" class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">Email</label>
                                        <input id="email" type="email" placeholder="you@email.com" class="glass-input w-full rounded-xl px-4 py-3 text-sm text-white bg-white/10 border border-white/20" required>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label for="accommodation" class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">Accommodation</label>
                                    <select id="accommodation" class="glass-input w-full rounded-xl px-4 py-3 text-sm text-white bg-slate-800 border border-white/20 appearance-none">
                                        <option value="Reserva del Mar - Apartment 1730">Reserva del Mar - Apartment 1730</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label for="check-in" class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">Check-in</label>
                                        <input id="check-in" type="date" class="glass-input w-full rounded-xl px-4 py-3 text-sm text-white bg-white/10 border border-white/20" required>
                                    </div>
                                    <div class="space-y-1">
                                        <label for="check-out" class="text-blue-300 text-[9px] font-black uppercase tracking-widest ml-1">Check-out</label>
                                        <input id="check-out" type="date" class="glass-input w-full rounded-xl px-4 py-3 text-sm text-white bg-white/10 border border-white/20" required>
                                    </div>
                                </div>

                                <button type="submit" class="w-full h-14 bg-blue-600 hover:bg-blue-500 text-white font-black uppercase tracking-widest text-[11px] rounded-xl transition-all shadow-xl shadow-blue-600/30 mt-4">
                                    Send to WhatsApp
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <script>
            //---------------------------
            // WhatsApp form logic
            document.getElementById('reservaForm').addEventListener('submit', function(e) {
                e.preventDefault();

                // 1. Get field values
                const name = document.getElementById('full-name').value;
                const tel = document.getElementById('whatsapp').value;
                const email = document.getElementById('email').value;
                const accommodation = document.getElementById('accommodation').value;
                const checkIn = document.getElementById('check-in').value;
                const checkOut = document.getElementById('check-out').value;

                // 2. Define phone number (no spaces or symbols)
                const salesPhone = "573183813381";

                // 3. Create formatted message
                const message = `*New Booking Request*%0A` +
                    `---------------------------------%0A` +
                    `*Name:* ${name}%0A` +
                    `*WhatsApp:* ${tel}%0A` +
                    `*Email:* ${email}%0A` +
                    `*Accommodation:* ${accommodation}%0A` +
                    `*Check-in Date:* ${checkIn}%0A` +
                    `*Check-out Date:* ${checkOut}%0A` +
                    `---------------------------------%0A` +
                    `Hello! I would like to confirm availability.`;

                // 4. Build WhatsApp URL
                const urlWhatsApp = `https://wa.me/${salesPhone}?text=${message}`;

                // 5. Open in new tab
                window.open(urlWhatsApp, '_blank');
            });
        </script>


        <section class="py-20 px-6 md:px-20 bg-background-light dark:bg-background-dark" id="about">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#111618] dark:text-white mb-4">Why choose us?</h2>
                    <p class="text-gray-500 dark:text-gray-400 max-w-xl mx-auto">Enjoy the best location, luxury amenities and personalized service.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-[#1e2930] p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition-shadow">
                        <div class="size-14 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-6">
                            <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1, 'wght' 400;">beach_access</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 dark:text-white">Beach Access</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                            Step out of your apartment and onto the golden sand. Privileged location facing the Caribbean Sea.
                        </p>
                    </div>
                    <div class="bg-white dark:bg-[#1e2930] p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition-shadow">
                        <div class="size-14 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-6">
                            <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1, 'wght' 400;">pool</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 dark:text-white">Infinity Pool</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                            Relax in our pools with panoramic ocean views and solarium area.
                        </p>
                    </div>
                    <div class="bg-white dark:bg-[#1e2930] p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition-shadow">
                        <div class="size-14 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-6">
                            <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1, 'wght' 400;">verified_user</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 dark:text-white">24/7 Security</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                            Your peace of mind is our priority. Monitored buildings and 24-hour reception.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-16 px-6 md:px-20 bg-white dark:bg-[#101c22]" id="availability">
            <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-12 items-center">
                <div class="flex-1 space-y-6">
                    <span class="text-primary font-bold uppercase tracking-wider text-sm">Plan your trip</span>
                    <h2 class="text-3xl md:text-5xl font-bold text-[#111618] dark:text-white leading-tight">
                        Check real-time availability
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">
                        Our apartments are highly requested. Check the calendar to secure your ideal dates for an unforgettable vacation.
                    </p>
                    <div class="flex flex-col gap-4 pt-4">
                        <div class="flex items-center gap-3">
                            <div class="size-3 rounded-full bg-primary"></div>
                            <span class="text-sm font-medium dark:text-gray-300">Available Dates</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="size-3 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                            <span class="text-sm font-medium dark:text-gray-300">Not Available</span>
                        </div>
                    </div>
                    <button class="mt-8 flex items-center gap-2 text-primary font-bold hover:gap-3 transition-all">
                        View full calendar <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
                <div class="flex-1 w-full flex justify-center lg:justify-end">
                    <div class="bg-white dark:bg-[#1e2930] rounded-2xl shadow-2xl p-6 border border-gray-100 dark:border-gray-700 max-w-2xl w-full">
                        <div class="flex flex-col md:flex-row gap-6 justify-center">
                            <div class="flex min-w-[280px] flex-1 flex-col gap-2">
                                <div class="flex items-center p-1 justify-between mb-2">
                                    <button class="hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full p-1"><span class="material-symbols-outlined dark:text-white">chevron_left</span></button>
                                    <p class="text-[#111618] dark:text-white text-base font-bold text-center">January 2024</p>
                                    <div class="w-8"></div>
                                </div>
                                <div class="grid grid-cols-7 gap-y-2 text-center">
                                    <p class="text-gray-400 text-xs font-bold">S</p>
                                    <p class="text-gray-400 text-xs font-bold">M</p>
                                    <p class="text-gray-400 text-xs font-bold">T</p>
                                    <p class="text-gray-400 text-xs font-bold">W</p>
                                    <p class="text-gray-400 text-xs font-bold">T</p>
                                    <p class="text-gray-400 text-xs font-bold">F</p>
                                    <p class="text-gray-400 text-xs font-bold">S</p>
                                    <span class="col-start-4 flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">1</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">2</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">3</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">4</span>
                                    <span class="flex items-center justify-center h-8 w-8 rounded-full bg-primary text-white text-sm font-bold shadow-md shadow-primary/40">5</span>
                                    <span class="flex items-center justify-center h-8 w-8 bg-primary/10 text-primary text-sm font-medium rounded-full">6</span>
                                    <span class="flex items-center justify-center h-8 w-8 bg-primary/10 text-primary text-sm font-medium rounded-full">7</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm text-gray-400 line-through">8</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm text-gray-400 line-through">9</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm text-gray-400 line-through">10</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">11</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">12</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">13</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">14</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">15</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">16</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">17</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">18</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">19</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">20</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">21</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">22</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">23</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">24</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">25</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">26</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">27</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">28</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">29</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">30</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">31</span>
                                </div>
                            </div>
                            <div class="h-px w-full bg-gray-100 dark:bg-gray-700 md:hidden"></div>
                            <div class="flex min-w-[280px] flex-1 flex-col gap-2">
                                <div class="flex items-center p-1 justify-between mb-2">
                                    <div class="w-8"></div>
                                    <p class="text-[#111618] dark:text-white text-base font-bold text-center">February 2024</p>
                                    <button class="hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full p-1"><span class="material-symbols-outlined dark:text-white">chevron_right</span></button>
                                </div>
                                <div class="grid grid-cols-7 gap-y-2 text-center">
                                    <p class="text-gray-400 text-xs font-bold">S</p>
                                    <p class="text-gray-400 text-xs font-bold">M</p>
                                    <p class="text-gray-400 text-xs font-bold">T</p>
                                    <p class="text-gray-400 text-xs font-bold">W</p>
                                    <p class="text-gray-400 text-xs font-bold">T</p>
                                    <p class="text-gray-400 text-xs font-bold">F</p>
                                    <p class="text-gray-400 text-xs font-bold">S</p>
                                    <span class="col-start-5 flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">1</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">2</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">3</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">4</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">5</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">6</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">7</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">8</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">9</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">10</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">11</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">12</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">13</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">14</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">15</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">16</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">17</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">18</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">19</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">20</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">21</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">22</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">23</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">24</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">25</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">26</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">27</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">28</span>
                                    <span class="flex items-center justify-center h-8 w-8 text-sm dark:text-gray-300">29</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20 bg-background-light dark:bg-background-dark" id="apartments">
            <div class="px-6 md:px-20 mb-12 text-center">
                <h2 class="text-3xl font-bold text-[#111618] dark:text-white mb-2">Featured Apartment</h2>
                <p class="text-gray-500 dark:text-gray-400">Our best property for an unforgettable stay</p>
            </div>
            <div class="flex justify-center px-6 md:px-20">
                <div class="max-w-[420px] w-full bg-white dark:bg-[#1e2930] rounded-2xl overflow-hidden shadow-2xl group border border-gray-100 dark:border-gray-700">
                    <div class="relative h-72 overflow-hidden">
                        <div class="absolute top-4 right-4 z-10 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-gray-800 flex items-center gap-1 shadow-sm">
                            <span class="material-symbols-outlined text-yellow-500 text-sm" style="font-variation-settings: 'FILL' 1;">star</span> 5.0
                        </div>
                        <div class="h-full w-full bg-cover bg-center group-hover:scale-110 transition-transform duration-700" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDhr-fja2E9oqdW3FeI503YhZXCPEnOJ34yXhATmDRax6RvUtXR9_eoJUbYx6EnOIEBRlfT-n5Lm7cAmW4TdhEEg2CZTdot2tDAeJVpKdZFVPa2mr_j_H0Rr1Ch8-atttcHQXDqxmq88aXJm6kKarN2geXSWHwJTwm9KKqowzPZTLx_CDcwuyj5QbBGTsy5nFJtSVhcea4WvOFsS-dRRyjJDI8m1dEnYEeSgIcv6YlxLk2VrCukZJSRiVae4DykJUmwqInWo07FO3U');"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                            <button class="w-full bg-white text-primary font-bold py-2 rounded-lg text-sm">Book Now</button>
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="text-xs font-bold text-primary uppercase tracking-wide mb-2">Reserva del Mar</div>
                        <h3 class="text-2xl font-bold dark:text-white mb-3">Luxury Family Suite</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-6 leading-relaxed">
                            Luxury in every detail. Gourmet kitchen, private terrace with unobstructed ocean views and premium finishes for the ultimate comfort of your family.
                        </p>
                        <div class="grid grid-cols-3 gap-4 text-sm text-gray-500 dark:text-gray-400 mb-8">
                            <div class="flex flex-col items-center gap-1">
                                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">bed</span>
                                <span>2 Bed</span>
                            </div>
                            <div class="flex flex-col items-center gap-1">
                                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">shower</span>
                                <span>2 Bath</span>
                            </div>
                            <div class="flex flex-col items-center gap-1">
                                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">groups</span>
                                <span>5 Guests</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-6 border-t border-gray-100 dark:border-gray-700">
                            <div>
                                <span class="text-2xl font-extrabold text-[#111618] dark:text-white">$210</span>
                                <span class="text-gray-500 text-sm">/night</span>
                            </div>
                            <button class="bg-primary/10 text-primary hover:bg-primary hover:text-white px-5 py-2 rounded-xl font-bold text-sm transition-colors">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20 px-6 md:px-20 bg-white dark:bg-[#101c22]">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <span class="text-primary font-bold uppercase tracking-wider text-sm">Testimonials</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-[#111618] dark:text-white mt-2 mb-4">Featured Reviews</h2>
                    <p class="text-gray-500 dark:text-gray-400 max-w-xl mx-auto">Real experiences from people who have enjoyed an unforgettable vacation with us.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-background-light dark:bg-[#1e2930] p-8 rounded-2xl relative border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300">
                        <span class="material-symbols-outlined text-6xl text-primary/10 absolute top-4 right-4" style="font-variation-settings: 'FILL' 1;">format_quote</span>
                        <div class="flex items-center gap-1 mb-4">
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed relative z-10">
                            "Simply spectacular! The view from the balcony is unmatched and the apartment was impeccable. We will definitely return next year."
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="size-12 rounded-full bg-gray-300 overflow-hidden">
                                <img alt="User profile picture" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBnX6ygSDb930yDP1K7KdVCihWUaYhnvUhYRvaACepRJEYQk5ftenPc9j9YXbwj2zL3OzIldl5pkSlWOeMS8B3RQpWQUqNwYT48m5CypnmYGB8HEh8_8Xeofj3yDKAlxYDfab-e8h7sb9TAlnrrorOu7cGZyvbGV4UakhE9mUaktiT1XuYBAuCSWMj-rCwgI5Zf7-k9IG7nAqDA3kCfdfJtySHhGzHSYGZMiu_nU8YURqt4iS9PcpxfRoANPR__2hIIU8VTXBeQwe8" />
                            </div>
                            <div>
                                <h4 class="font-bold text-[#111618] dark:text-white">Carolina Méndez</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Bogotá, Colombia</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-background-light dark:bg-[#1e2930] p-8 rounded-2xl relative border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300">
                        <span class="material-symbols-outlined text-6xl text-primary/10 absolute top-4 right-4" style="font-variation-settings: 'FILL' 1;">format_quote</span>
                        <div class="flex items-center gap-1 mb-4">
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'wght' 400;">star_half</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed relative z-10">
                            "The location is perfect, close to restaurants and supermarkets. The building's pool is amazing for relaxing after the beach."
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="size-12 rounded-full bg-gray-300 overflow-hidden">
                                <img alt="User profile picture" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBI5wBUYd3ZoplAFKAZsnZzl9A4yjX53yVmp67V30taKJf7yxiAi8o9UxlO4Bp8RcX9JptlHjCTTq8EZIAJbsT5AcQNOaKtWMwpUQuI_NUbImnSjz726-XLyydAyCZ5qHvXg_DXzh89_WDs315cEAFZa410_9JbWH3QL9rQvNsKYU1RAdHIl5QOAvON0zcDZaTnGW9gyOvhx-WqLjrqIdCDYUyVBUJmiMmTNjgDdjJ6T2irxncca8INGsaX9l1QXGUFLyAT-gOkU34" />
                            </div>
                            <div>
                                <h4 class="font-bold text-[#111618] dark:text-white">David Johnson</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Miami, USA</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-background-light dark:bg-[#1e2930] p-8 rounded-2xl relative border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300">
                        <span class="material-symbols-outlined text-6xl text-primary/10 absolute top-4 right-4" style="font-variation-settings: 'FILL' 1;">format_quote</span>
                        <div class="flex items-center gap-1 mb-4">
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-yellow-500 text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed relative z-10">
                            "First-class service from the moment of reservation. The apartment exceeded our expectations, very modern and comfortable."
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="size-12 rounded-full bg-gray-300 overflow-hidden">
                                <img alt="User profile picture" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCIVOf4FxfS4L2VMX-MzvCAweEr1dlJGrW4FlVxeHThaYfYgpJenfN3sV0Y8zaiGh5T95YnWKaKAE7tPEkz23_h09Ka4rHPwfyQZN5ikR683fzv-Xu4MyREtZgKCvL7r_rjYrRysWZPPU2GgFWNTT7fv6aBd5GZ9Wz99LuaIOYWU30jT7nVTJqYrhQGEcHmc0bexmwdY8tKcqWUf1629_amnupnSWTM8y7D5L3BsWowHY2P78mGSPuLSOajNmU_Dj-NzASh5NQPVbc" />
                            </div>
                            <div>
                                <h4 class="font-bold text-[#111618] dark:text-white">Sofía Ramírez</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Medellín, Colombia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="grid grid-cols-1 lg:grid-cols-2 min-h-[500px]" id="location">
            <div class="bg-white dark:bg-[#101c22] p-10 lg:p-20 flex flex-col justify-center">
                <div class="flex items-center gap-2 text-primary font-bold mb-4">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">explore</span>
                    <span>STRATEGIC LOCATION</span>
                </div>
                <h2 class="text-4xl font-bold mb-6 text-[#111618] dark:text-white">Close to everything that matters</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-8 text-lg">
                    We are located in the heart of the tourist area, a few minutes from the airport and with direct access to the main beaches and restaurants.
                </p>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center gap-3">
                        <div class="size-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                            <span class="material-symbols-outlined text-sm">flight</span>
                        </div>
                        <span class="dark:text-gray-300">15 min from International Airport</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="size-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                            <span class="material-symbols-outlined text-sm">restaurant</span>
                        </div>
                        <span class="dark:text-gray-300">5 min from Dining Area</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="size-8 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600 dark:text-orange-400">
                            <span class="material-symbols-outlined text-sm">forest</span>
                        </div>
                        <span class="dark:text-gray-300">20 min from Tayrona Park</span>
                    </li>
                </ul>
                <button class="self-start text-primary font-bold underline decoration-2 underline-offset-4 hover:text-primary/80">
                    Open in Google Maps
                </button>
            </div>
            <div class="relative h-[400px] lg:h-auto w-full bg-gray-200">
                <div class="w-full h-full bg-cover bg-center grayscale hover:grayscale-0 transition-all duration-500" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCIYZaqX3SugCDpS7l5OcQt3kLA8qqIsHw6iRh6XF3Pr6xnU2xaMAuioSSwDCx9fWO_a3G0FA_AZuYNOLcFW0TWiyInCOWeOdH1XMaWZsQAzonXmd4_PgKPY9-Yppyei8aFRo8qsNR-oWIFB_FjYbOLjEaG8pAp5LbG5Lzxz4R2aZuhpyCVSK7h9G2vcWtWts8A4cCa_c4_Rq__lg52WI5JeRp17SjquBBHVmiaiuqSjdrm8zg93DuUhpTsGB3Ma9j2UMuWTvXgLKE');">
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col items-center">
                        <div class="bg-white px-3 py-1 rounded-lg shadow-md mb-2 text-xs font-bold text-gray-800 animate-bounce">
                            Santamartabeachfront
                        </div>
                        <span class="material-symbols-outlined text-primary text-5xl drop-shadow-lg" style="font-variation-settings: 'FILL' 1;">location_on</span>
                    </div>
                </div>
            </div>
        </section>
        <footer class="bg-[#101c22] text-white pt-20 pb-10" id="contact">
            <div class="max-w-7xl mx-auto px-6 md:px-10">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center pb-16 border-b border-gray-800 gap-8">
                    <div class="text-left">
                        <h2 class="text-3xl font-bold mb-2">Ready for your vacation?</h2>
                        <p class="text-gray-400">Book today and secure the best guaranteed price.</p>
                    </div>
                    <button class="bg-primary hover:bg-primary/90 text-white font-bold py-4 px-10 rounded-xl shadow-lg shadow-primary/20 transition-all transform hover:-translate-y-1">
                        Book Now
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 py-16">
                    <div class="space-y-6">
                        <div class="flex items-center gap-2 text-primary">
                            <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">apartment</span>
                            <span class="text-xl font-bold text-white">Santamartabeachfront</span>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
                            The leading platform for luxury vacation rentals in Santa Marta. Unique experiences, superior comfort and the best views of the Colombian Caribbean.
                        </p>
                    </div>
                    <div>
                        <h4 class="font-bold mb-6 text-white uppercase tracking-wider text-sm">Contact Information</h4>
                        <ul class="space-y-4 text-sm text-gray-400">
                            <li class="flex items-start gap-3 hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">mail</span>
                                <span>info@santamartabeachfront.com</span>
                            </li>
                            <li class="flex items-start gap-3 hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">call</span>
                                <span>+57 300 123 4567</span>
                            </li>
                            <li class="flex items-start gap-3 hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">location_on</span>
                                <span>Rodadero Reservado, Santa Marta, Magdalena, Colombia</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold mb-6 text-white uppercase tracking-wider text-sm">Follow Us</h4>
                        <div class="flex gap-4">
                            <a class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center hover:bg-primary transition-all duration-300 group" href="#" title="Instagram">
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path>
                                </svg>
                            </a>
                            <a class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center hover:bg-primary transition-all duration-300 group" href="#" title="Facebook">
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"></path>
                                </svg>
                            </a>
                            <a class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center hover:bg-primary transition-all duration-300 group" href="#" title="Twitter">
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-gray-800 text-xs text-gray-500 gap-4">
                    <p>© 2024 Santamarta Beachfront. All rights reserved.</p>
                    <div class="flex gap-8">
                        <a class="hover:text-white transition-colors" href="#">Privacy Policy</a>
                        <a class="hover:text-white transition-colors" href="#">Terms and Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

</body>

</html>