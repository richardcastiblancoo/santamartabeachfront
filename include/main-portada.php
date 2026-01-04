<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
        
        <header class="absolute top-0 left-0 z-50 w-full flex items-center justify-between bg-transparent px-6 py-4 md:px-10">
            <div class="flex items-center gap-4">
                <div class="size-8 text-primary" aria-hidden="true">
                    <span class="material-symbols-outlined text-3xl">waves</span>
                </div>
                <span class="text-white text-xl font-bold leading-tight tracking-[-0.015em] drop-shadow-lg">
                    santamartabeachfront
                </span>
            </div>

            <nav class="hidden md:flex flex-1 justify-end gap-8" aria-label="Navegación principal">
                <div class="flex items-center gap-9">
                    <a class="text-white text-sm font-medium hover:text-primary transition-colors drop-shadow-md" href="#apartamentos">Apartamentos</a>
                    <a class="text-white text-sm font-medium hover:text-primary transition-colors drop-shadow-md" href="#ubicacion">Ubicación</a>
                    <a class="text-white text-sm font-medium hover:text-primary transition-colors drop-shadow-md" href="#nosotros">Nosotros</a>
                    <a class="text-white text-sm font-medium hover:text-primary transition-colors drop-shadow-md" href="#contacto">Contacto</a>
                </div>

                <div class="flex items-center gap-4 border-l border-white/20 pl-6">
                    <div class="flex items-center gap-1 text-sm font-medium text-white" role="group" aria-label="Seleccionar idioma">
                        <button class="hover:text-primary font-bold" aria-pressed="true">ES</button>
                        <span class="text-white/50" aria-hidden="true">/</span>
                        <button class="text-white/70 hover:text-primary transition-colors" aria-pressed="false">EN</button>
                    </div>
                    <a href="/php/login.php" class="flex min-w-[84px] items-center justify-center rounded-lg h-10 px-6 bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-colors shadow-lg shadow-primary/30">
                        Login
                    </a>
                </div>
            </nav>

            <button class="md:hidden text-white" aria-label="Abrir menú de navegación">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </header>

        <main>
            <section class="relative w-full h-screen flex items-center justify-center overflow-hidden bg-gray-900">
                <div class="absolute inset-0 z-0">
                    <video autoplay loop muted playsinline class="w-full h-full object-cover">
                        <source src="/public/video/santamarta.mp4" type="video/mp4" />
                        Tu navegador no soporta videos.
                    </video>
                    <div class="absolute inset-0 bg-black/30 bg-gradient-to-b from-black/70 via-transparent to-black/40" aria-hidden="true"></div>
                </div>

                <div class="relative z-10 flex flex-col items-center gap-8 text-center px-4 max-w-4xl mt-[-40px]">
                    <h1 class="text-white text-5xl md:text-7xl font-black leading-tight drop-shadow-2xl">
                        Vive la experiencia <br />
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-cyan-300">frente al mar</span>
                    </h1>
                    <p class="text-white/95 text-lg md:text-2xl font-medium max-w-2xl drop-shadow-lg leading-relaxed">
                        Los mejores apartamentos en Santamartabeachfront te esperan. Despierta con el sonido de las olas.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 w-full justify-center pt-4">
                        <a class="flex items-center justify-center h-12 min-w-[160px] bg-primary hover:bg-primary/90 text-white font-bold rounded-lg px-8 shadow-xl shadow-primary/30 transition-all transform hover:-translate-y-1" href="#apartamentos">
                            Visualizar
                        </a>
                        <a class="flex items-center justify-center h-12 min-w-[160px] bg-transparent border-2 border-white hover:bg-white/10 text-white font-bold rounded-lg px-8 backdrop-blur-sm transition-all transform hover:-translate-y-1" href="#contacto">
                            Contactar
                        </a>
                    </div>
                </div>
            </section>

            <section class="py-20 px-6 md:px-20 bg-background-light dark:bg-[#0b1215]" id="nosotros">
                <div class="max-w-6xl mx-auto">
                    <header class="text-center mb-12">
                        <h2 class="text-3xl md:text-4xl font-bold text-[#111618] dark:text-white mb-4">¿Por qué elegirnos?</h2>
                        <p class="text-gray-500 dark:text-gray-400 max-w-xl mx-auto">Disfruta de la mejor ubicación, comodidades de lujo y un servicio personalizado.</p>
                    </header>

                    <ul class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <li class="bg-white dark:bg-[#1e2930] p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition-shadow">
                            <article>
                                <div class="size-14 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-6" aria-hidden="true">
                                    <span class="material-symbols-outlined text-3xl">beach_access</span>
                                </div>
                                <h3 class="text-xl font-bold mb-3 dark:text-white">Acceso a la Playa</h3>
                                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Sal de tu apartamento y pisa la arena dorada. Ubicación privilegiada frente al mar caribe.
                                </p>
                            </article>
                        </li>
                        <li class="bg-white dark:bg-[#1e2930] p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition-shadow">
                            <article>
                                <div class="size-14 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-6" aria-hidden="true">
                                    <span class="material-symbols-outlined text-3xl">pool</span>
                                </div>
                                <h3 class="text-xl font-bold mb-3 dark:text-white">Piscina Infinita</h3>
                                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Relájate en nuestras piscinas con vista panorámica al océano y zona de solarium.
                                </p>
                            </article>
                        </li>
                        <li class="bg-white dark:bg-[#1e2930] p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition-shadow">
                            <article>
                                <div class="size-14 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-6" aria-hidden="true">
                                    <span class="material-symbols-outlined text-3xl">security</span>
                                </div>
                                <h3 class="text-xl font-bold mb-3 dark:text-white">Seguridad 24/7</h3>
                                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Tu tranquilidad es nuestra prioridad. Edificios monitoreados y recepción 24 horas.
                                </p>
                            </article>
                        </li>
                    </ul>
                </div>
            </section>
        </main>
    </div>