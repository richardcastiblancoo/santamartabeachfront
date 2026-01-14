<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title id="page-title">Políticas y Términos - Santamartabeachfront</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="/css/style.css">
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
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .sidebar-sticky {
            position: sticky;
            top: 5rem;
            height: fit-content;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#111618] dark:text-white transition-colors duration-200">
    <div class="layout-container flex h-full grow flex-col">
        <header class="flex items-center justify-between border-b border-solid border-b-[#f0f3f4] dark:border-b-gray-800 bg-white dark:bg-background-dark px-6 md:px-10 py-4 sticky top-0 z-50">
            <div class="flex items-center gap-4 text-[#111618] dark:text-white">
                <div class="size-12 md:size-16 text-primary flex items-center justify-center">
                    <img src="/public/img/logo-portada.png" class="w-full h-auto" alt="Logo">
                </div>
                <h2 class="hidden md:block text-[#111618] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Santamartabeachfront</h2>
            </div>

            <nav class="hidden lg:flex items-center gap-8">
                <a href="/" class="text-sm font-bold text-[#111618] dark:text-gray-300 hover:text-primary transition-colors" data-key="nav-inicio">Inicio</a>
                <a href="/apartamentos" class="text-sm font-bold text-[#111618] dark:text-gray-300 hover:text-primary transition-colors" data-key="nav-apartamentos">Apartamentos</a>
                <a href="/nosotros" class="text-sm font-bold text-[#111618] dark:text-gray-300 hover:text-primary transition-colors" data-key="nav-nosotros">Nosotros</a>
            </nav>

            <div class="flex items-center gap-4">
                <div class="flex items-center bg-gray-100 dark:bg-gray-800 rounded-full p-1">
                    <div class="relative lang-dropdown">
                        <button class="flex items-center gap-2 text-[#111618] dark:text-white text-sm font-medium h-10 px-3 rounded-lg hover:bg-black/5 dark:hover:bg-white/10 transition-colors">
                            <span id="currentLang">ES</span>
                            <span class="material-symbols-outlined text-sm">expand_more</span>
                        </button>
                        <div class="lang-menu hidden absolute top-full right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-xl shadow-2xl py-2 z-[60]">
                            <a href="#" data-lang="ES" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-[#111618] dark:text-white text-sm">Español</a>
                            <a href="#" data-lang="EN" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-[#111618] dark:text-white text-sm">English</a>
                        </div>
                    </div>
                </div>

                <button id="menuBtn" class="lg:hidden p-2 text-gray-600 dark:text-gray-300">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </header>

        <main class="flex-1 max-w-[1280px] mx-auto w-full px-4 md:px-10 py-8">
            <div class="flex flex-wrap justify-between items-end gap-3 mb-8 border-b border-gray-100 dark:border-gray-800 pb-6">
                <div class="flex min-w-72 flex-col gap-2">
                    <h1 class="text-[#111618] dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]" data-key="titulo-principal">Políticas y Términos</h1>
                    <p class="text-[#617c89] dark:text-gray-400 text-base font-normal" data-key="ultima-actualizacion">Última actualización: 1 de febrero, 2026</p>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-12">
                <aside class="w-full lg:w-72 flex-shrink-0">
                    <div class="sidebar-sticky flex flex-col gap-6 bg-white dark:bg-background-dark p-6 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                        <div class="flex flex-col gap-1">
                            <h3 class="text-[#111618] dark:text-white text-base font-bold" data-key="aside-nav">Navegación</h3>
                            <p class="text-[#617c89] dark:text-gray-400 text-xs uppercase tracking-wider font-semibold" data-key="aside-legal">Secciones legales</p>
                        </div>
                        <nav class="flex flex-col gap-1">
                            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary/10 text-primary font-semibold transition-all" href="#intro">
                                <span class="material-symbols-outlined text-xl">info</span>
                                <span class="text-sm" data-key="link-intro">Introducción</span>
                            </a>
                            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#111618] dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all" href="#data">
                                <span class="material-symbols-outlined text-xl">database</span>
                                <span class="text-sm" data-key="link-data">Uso de Datos</span>
                            </a>
                            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#111618] dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all" href="#cancel">
                                <span class="material-symbols-outlined text-xl">calendar_month</span>
                                <span class="text-sm" data-key="link-cancel">Cancelaciones</span>
                            </a>
                            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#111618] dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all" href="#resp">
                                <span class="material-symbols-outlined text-xl">verified_user</span>
                                <span class="text-sm" data-key="link-resp">Responsabilidades</span>
                            </a>
                            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#111618] dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all" href="#intellect">
                                <span class="material-symbols-outlined text-xl">gavel</span>
                                <span class="text-sm" data-key="link-intellect">Propiedad Intelectual</span>
                            </a>
                        </nav>
                        <div class="mt-4 pt-6 border-t border-gray-100 dark:border-gray-800">
                            <div class="bg-primary/5 p-4 rounded-lg">
                                <p class="text-xs text-primary font-bold mb-2 uppercase" data-key="ayuda-titulo">¿Necesitas ayuda?</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed" data-key="ayuda-desc">Si tienes dudas sobre nuestras políticas, contáctanos a 17clouds@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </aside>

                <div class="flex-1 bg-white dark:bg-background-dark rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-8 md:p-12 overflow-hidden">

                    <section class="mb-12 scroll-mt-24" id="intro">
                        <h2 class="text-[#111618] dark:text-white tracking-tight text-2xl font-bold leading-tight mb-4 flex items-center gap-2">
                            <span class="text-primary">1.</span> <span data-key="sec1-titulo">Introducción</span>
                        </h2>
                        <div class="space-y-4">
                            <p class="text-[#111618] dark:text-gray-300 text-base font-normal leading-relaxed" data-key="sec1-p1">
                                Bienvenido a Santamartabeachfront. Al utilizar nuestros servicios de alquiler de apartamentos frente al mar, usted acepta cumplir con los siguientes términos y condiciones. Estos términos rigen su relación con nuestra plataforma y las estancias en nuestras propiedades.
                            </p>
                            <p class="text-[#111618] dark:text-gray-300 text-base font-normal leading-relaxed" data-key="sec1-p2">
                                Este acuerdo es vinculante para todos los huéspedes que reserven a través de nuestro sitio web, aplicaciones móviles o canales de terceros afiliados. Le recomendamos leer cuidadosamente cada sección antes de proceder con su pago.
                            </p>
                        </div>
                    </section>

                    <section class="mb-12 scroll-mt-24" id="data">
                        <h2 class="text-[#111618] dark:text-white tracking-tight text-2xl font-bold leading-tight mb-4 flex items-center gap-2">
                            <span class="text-primary">2.</span> <span data-key="sec2-titulo">Uso de Datos y Privacidad</span>
                        </h2>
                        <p class="text-[#111618] dark:text-gray-300 text-base font-normal leading-relaxed mb-4" data-key="sec2-p1">
                            Valoramos su privacidad y nos comprometemos a proteger su información personal. Los datos recopilados se utilizan exclusivamente para:
                        </p>
                        <ul class="space-y-3 pl-2">
                            <li class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-primary text-xl mt-0.5">check_circle</span>
                                <span class="text-[#111618] dark:text-gray-300 text-base" data-key="sec2-item1">Procesamiento de reservas y pagos seguros.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-primary text-xl mt-0.5">check_circle</span>
                                <span class="text-[#111618] dark:text-gray-300 text-base" data-key="sec2-item2">Comunicación directa sobre el estado de su estancia y llegada.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-primary text-xl mt-0.5">check_circle</span>
                                <span class="text-[#111618] dark:text-gray-300 text-base" data-key="sec2-item3">Mejora de nuestros servicios mediante análisis estadístico anónimo.</span>
                            </li>
                        </ul>
                    </section>

                    <section class="mb-12 scroll-mt-24" id="cancel">
                        <h2 class="text-[#111618] dark:text-white tracking-tight text-2xl font-bold leading-tight mb-4 flex items-center gap-2">
                            <span class="text-primary">3.</span> <span data-key="sec3-titulo">Cancelaciones y Reembolsos</span>
                        </h2>
                        <p class="text-[#111618] dark:text-gray-300 text-base font-normal leading-relaxed mb-6" data-key="sec3-p1">
                            Entendemos que los planes pueden cambiar. Nuestra política de reembolso se basa en el tiempo de antelación con el que se realice la cancelación:
                        </p>
                        <div class="overflow-hidden rounded-xl border border-gray-100 dark:border-gray-800">
                            <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800">
                                <thead class="bg-gray-50 dark:bg-gray-900/50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider" data-key="table-h1">Antelación</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider" data-key="table-h2">Reembolso</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-background-dark divide-y divide-gray-50 dark:divide-gray-800">
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-[#111618] dark:text-gray-300" data-key="table-r1-c1">Más de 30 días</td>
                                        <td class="px-6 py-4 text-sm font-bold text-green-600" data-key="table-r1-c2">100% Reembolsable</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-[#111618] dark:text-gray-300" data-key="table-r2-c1">15 a 29 días</td>
                                        <td class="px-6 py-4 text-sm font-bold text-primary" data-key="table-r2-c2">50% Reembolsable</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-[#111618] dark:text-gray-300" data-key="table-r3-c1">Menos de 14 días</td>
                                        <td class="px-6 py-4 text-sm font-bold text-red-500" data-key="table-r3-c2">No Reembolsable</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section class="mb-12 scroll-mt-24" id="resp">
                        <h2 class="text-[#111618] dark:text-white tracking-tight text-2xl font-bold leading-tight mb-4 flex items-center gap-2">
                            <span class="text-primary">4.</span> <span data-key="sec4-titulo">Responsabilidades del Huésped</span>
                        </h2>
                        <p class="text-[#111618] dark:text-gray-300 text-base font-normal leading-relaxed mb-4" data-key="sec4-p1">
                            Para garantizar una convivencia armoniosa y el mantenimiento de nuestras propiedades, el huésped se compromete a:
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800">
                                <p class="font-bold text-sm mb-1 text-[#111618] dark:text-white" data-key="sec4-item1-t">Cuidado del Inmueble</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400" data-key="sec4-item1-d">Mantener el mobiliario y las instalaciones en buen estado durante su estancia.</p>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800">
                                <p class="font-bold text-sm mb-1 text-[#111618] dark:text-white" data-key="sec4-item2-t">Normas de Convivencia</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400" data-key="sec4-item2-d">Respetar los niveles de ruido y las zonas comunes del edificio/complejo.</p>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800">
                                <p class="font-bold text-sm mb-1 text-[#111618] dark:text-white" data-key="sec4-item3-t">Capacidad Máxima</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400" data-key="sec4-item3-d">No exceder el número de personas registradas al momento de la reserva.</p>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800">
                                <p class="font-bold text-sm mb-1 text-[#111618] dark:text-white" data-key="sec4-item4-t">Registro de Identidad</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400" data-key="sec4-item4-d">Presentar documentos de identidad válidos para todos los ocupantes.</p>
                            </div>
                        </div>
                    </section>

                    <section class="scroll-mt-24" id="intellect">
                        <h2 class="text-[#111618] dark:text-white tracking-tight text-2xl font-bold leading-tight mb-4 flex items-center gap-2">
                            <span class="text-primary">5.</span> <span data-key="sec5-titulo">Propiedad Intelectual</span>
                        </h2>
                        <p class="text-[#111618] dark:text-gray-300 text-base font-normal leading-relaxed" data-key="sec5-p1">
                            Todo el contenido de este sitio web, incluyendo textos, logotipos, imágenes y diseño de interfaz, es propiedad exclusiva de Santamartabeachfront o sus licenciantes. Queda prohibida su reproducción total o parcial sin autorización expresa.
                        </p>
                    </section>

                </div>
            </div>
        </main>
    </div>

    <script>
        // Diccionario de traducciones completo
        const translations = {
            'ES': {
                'nav-inicio': 'Inicio',
                'nav-apartamentos': 'Apartamentos',
                'nav-nosotros': 'Nosotros',
                'titulo-principal': 'Políticas y Términos',
                'ultima-actualizacion': 'Última actualización: 1 de febrero, 2026',
                'aside-nav': 'Navegación',
                'aside-legal': 'Secciones legales',
                'link-intro': 'Introducción',
                'link-data': 'Uso de Datos',
                'link-cancel': 'Cancelaciones',
                'link-resp': 'Responsabilidades',
                'link-intellect': 'Propiedad Intelectual',
                'ayuda-titulo': '¿Necesitas ayuda?',
                'ayuda-desc': 'Si tienes dudas sobre nuestras políticas, contáctanos a 17clouds@gmail.com',
                'sec1-titulo': 'Introducción',
                'sec1-p1': 'Bienvenido a Santamartabeachfront. Al utilizar nuestros servicios de alquiler de apartamentos frente al mar, usted acepta cumplir con los siguientes términos y condiciones.',
                'sec1-p2': 'Este acuerdo es vinculante para todos los huéspedes que reserven a través de nuestro sitio web, aplicaciones móviles o canales de terceros afiliados.',
                'sec2-titulo': 'Uso de Datos y Privacidad',
                'sec2-p1': 'Valoramos su privacidad y nos comprometemos a proteger su información personal. Los datos recopilados se utilizan exclusivamente para:',
                'sec2-item1': 'Procesamiento de reservas y pagos seguros.',
                'sec2-item2': 'Comunicación directa sobre el estado de su estancia y llegada.',
                'sec2-item3': 'Mejora de nuestros servicios mediante análisis estadístico anónimo.',
                'sec3-titulo': 'Cancelaciones y Reembolsos',
                'sec3-p1': 'Entendemos que los planes pueden cambiar. Nuestra política de reembolso se basa en el tiempo de antelación con el que se realice la cancelación:',
                'table-h1': 'Antelación',
                'table-h2': 'Reembolso',
                'table-r1-c1': 'Más de 30 días', 'table-r1-c2': '100% Reembolsable',
                'table-r2-c1': '15 a 29 días', 'table-r2-c2': '50% Reembolsable',
                'table-r3-c1': 'Menos de 14 días', 'table-r3-c2': 'No Reembolsable',
                'sec4-titulo': 'Responsabilidades del Huésped',
                'sec4-p1': 'Para garantizar una convivencia armoniosa y el mantenimiento de nuestras propiedades, el huésped se compromete a:',
                'sec4-item1-t': 'Cuidado del Inmueble', 'sec4-item1-d': 'Mantener el mobiliario y las instalaciones en buen estado durante su estancia.',
                'sec4-item2-t': 'Normas de Convivencia', 'sec4-item2-d': 'Respetar los niveles de ruido y las zonas comunes del edificio/complejo.',
                'sec4-item3-t': 'Capacidad Máxima', 'sec4-item3-d': 'No exceder el número de personas registradas al momento de la reserva.',
                'sec4-item4-t': 'Registro de Identidad', 'sec4-item4-d': 'Presentar documentos de identidad válidos para todos los ocupantes.',
                'sec5-titulo': 'Propiedad Intelectual',
                'sec5-p1': 'Todo el contenido de este sitio web es propiedad exclusiva de Santamartabeachfront. Queda prohibida su reproducción total o parcial.'
            },
            'EN': {
                'nav-inicio': 'Home',
                'nav-apartamentos': 'Apartments',
                'nav-nosotros': 'About Us',
                'titulo-principal': 'Policies and Terms',
                'ultima-actualizacion': 'Last update: February 1, 2026',
                'aside-nav': 'Navigation',
                'aside-legal': 'Legal Sections',
                'link-intro': 'Introduction',
                'link-data': 'Data Usage',
                'link-cancel': 'Cancellations',
                'link-resp': 'Responsibilities',
                'link-intellect': 'Intellectual Property',
                'ayuda-titulo': 'Need help?',
                'ayuda-desc': 'If you have questions about our policies, contact us at 17clouds@gmail.com',
                'sec1-titulo': 'Introduction',
                'sec1-p1': 'Welcome to Santamartabeachfront. By using our beachfront apartment rental services, you agree to comply with the following terms and conditions.',
                'sec1-p2': 'This agreement is binding for all guests booking through our website, mobile apps, or affiliated third-party channels.',
                'sec2-titulo': 'Data Usage and Privacy',
                'sec2-p1': 'We value your privacy and are committed to protecting your personal information. Collected data is used exclusively for:',
                'sec2-item1': 'Processing reservations and secure payments.',
                'sec2-item2': 'Direct communication regarding your stay and arrival status.',
                'sec2-item3': 'Improving our services through anonymous statistical analysis.',
                'sec3-titulo': 'Cancellations and Refunds',
                'sec3-p1': 'We understand plans can change. Our refund policy is based on how far in advance the cancellation is made:',
                'table-h1': 'Notice Period',
                'table-h2': 'Refund',
                'table-r1-c1': 'Over 30 days', 'table-r1-c2': '100% Refundable',
                'table-r2-c1': '15 to 29 days', 'table-r2-c2': '50% Refundable',
                'table-r3-c1': 'Less than 14 days', 'table-r3-c2': 'Non-Refundable',
                'sec4-titulo': 'Guest Responsibilities',
                'sec4-p1': 'To ensure harmonious coexistence and property maintenance, the guest agrees to:',
                'sec4-item1-t': 'Property Care', 'sec4-item1-d': 'Keep furniture and facilities in good condition during your stay.',
                'sec4-item2-t': 'Coexistence Rules', 'sec4-item2-d': 'Respect noise levels and common areas of the building/complex.',
                'sec4-item3-t': 'Maximum Capacity', 'sec4-item3-d': 'Do not exceed the number of people registered at the time of booking.',
                'sec4-item4-t': 'ID Registration', 'sec4-item4-d': 'Present valid identity documents for all occupants.',
                'sec5-titulo': 'Intellectual Property',
                'sec5-p1': 'All content on this website is the exclusive property of Santamartabeachfront. Total or partial reproduction is prohibited.'
            }
        };

        const langBtn = document.querySelector(".lang-dropdown button");
        const langMenu = document.querySelector(".lang-menu");
        const currentLangLabel = document.getElementById("currentLang");
        const menuBtn = document.getElementById("menuBtn");

        // Función para cambiar idioma sin recargar
        function setLang(lang) {
            localStorage.setItem("lang", lang);
            currentLangLabel.textContent = lang;
            
            // Recorrer todos los elementos con data-key y traducir
            document.querySelectorAll('[data-key]').forEach(el => {
                const key = el.getAttribute('data-key');
                if (translations[lang][key]) {
                    el.textContent = translations[lang][key];
                }
            });
        }

        langBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            langMenu.classList.toggle("hidden");
        });

        document.querySelectorAll(".lang-menu a").forEach((item) => {
            item.addEventListener("click", (e) => {
                e.preventDefault();
                setLang(item.dataset.lang);
                langMenu.classList.add("hidden");
            });
        });

        document.addEventListener("click", () => {
            langMenu.classList.add("hidden");
        });

        // Inicializar con el idioma guardado o español por defecto
        const savedLang = localStorage.getItem("lang") || "ES";
        setLang(savedLang);

    </script>
</body>
</html>