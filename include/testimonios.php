<style>
    /* Definimos la animación de desplazamiento */
    @keyframes infiniteScroll {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-50%);
        }

        /* Se desplaza la mitad (el primer set de 8) */
    }

    .carousel-track {
        display: flex;
        width: max-content;
        animation: infiniteScroll 60s linear infinite;
        /* Ajusta los segundos para velocidad */
    }

    /* Pausa al pasar el mouse para facilitar la lectura */
    .carousel-track:hover {
        animation-play-state: paused;
    }

    /* Helper para estrellas rellenas */
    .star-fill {
        font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 48;
    }
</style>

<section class="py-32 px-6 bg-white dark:bg-[#101c22] overflow-hidden">
    <div class="max-w-7xl mx-auto mb-16">
        <header class="text-center">
            <span class="text-primary font-bold uppercase tracking-wider text-sm block mb-2">Testimonios</span>
            <h2 class="text-3xl md:text-5xl font-bold text-[#111618] dark:text-white mb-4">Experiencias Inolvidables</h2>
            <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                Únete a los cientos de viajeros que han confiado en nosotros para sus mejores momentos.
            </p>
        </header>
    </div>

    <div class="relative w-full overflow-hidden">
        <div class="carousel-track gap-6">

            <article class="w-[350px] bg-gray-50 dark:bg-[#1e2930] p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shrink-0">
                <div class="flex text-yellow-500 mb-4"><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span></div>
                <p class="text-gray-600 dark:text-gray-300 mb-6 italic">"¡Simplemente espectacular! La vista desde el balcón es inigualable."</p>
                <footer class="flex items-center gap-4">
                    <img class="size-10 rounded-full" src="https://i.pravatar.cc/100?u=1" alt="Carolina">
                    <div>
                        <h4 class="font-bold text-sm dark:text-white">Carolina Méndez</h4>
                        <p class="text-xs text-gray-500">Bogotá</p>
                    </div>
                </footer>
            </article>
            <article class="w-[350px] bg-gray-50 dark:bg-[#1e2930] p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shrink-0">
                <div class="flex text-yellow-500 mb-4"><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined">star_half</span></div>
                <p class="text-gray-600 dark:text-gray-300 mb-6 italic">"La ubicación es perfecta, cerca de restaurantes y supermercados."</p>
                <footer class="flex items-center gap-4">
                    <img class="size-10 rounded-full" src="https://i.pravatar.cc/100?u=2" alt="David">
                    <div>
                        <h4 class="font-bold text-sm dark:text-white">David Johnson</h4>
                        <p class="text-xs text-gray-500">Miami</p>
                    </div>
                </footer>
            </article>
            <article class="w-[350px] bg-gray-50 dark:bg-[#1e2930] p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shrink-0">
                <div class="flex text-yellow-500 mb-4"><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span></div>
                <p class="text-gray-600 dark:text-gray-300 mb-6 italic">"Atención de primera clase desde el momento de la reserva."</p>
                <footer class="flex items-center gap-4">
                    <img class="size-10 rounded-full" src="https://i.pravatar.cc/100?u=3" alt="Sofía">
                    <div>
                        <h4 class="font-bold text-sm dark:text-white">Sofía Ramírez</h4>
                        <p class="text-xs text-gray-500">Medellín</p>
                    </div>
                </footer>
            </article>
            <article class="w-[350px] bg-gray-50 dark:bg-[#1e2930] p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shrink-0">
                <div class="flex text-yellow-500 mb-4"><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span></div>
                <p class="text-gray-600 dark:text-gray-300 mb-6 italic">"El mejor apartamento en el que me he hospedado. Todo moderno."</p>
                <footer class="flex items-center gap-4">
                    <img class="size-10 rounded-full" src="https://i.pravatar.cc/100?u=4" alt="Andrés">
                    <div>
                        <h4 class="font-bold text-sm dark:text-white">Andrés Castro</h4>
                        <p class="text-xs text-gray-500">Cali</p>
                    </div>
                </footer>
            </article>
            <article class="w-[350px] bg-gray-50 dark:bg-[#1e2930] p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shrink-0">
                <div class="flex text-yellow-500 mb-4"><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span></div>
                <p class="text-gray-600 dark:text-gray-300 mb-6 italic">"Increíble para nómadas digitales. El WiFi vuela."</p>
                <footer class="flex items-center gap-4">
                    <img class="size-10 rounded-full" src="https://i.pravatar.cc/100?u=5" alt="Laura">
                    <div>
                        <h4 class="font-bold text-sm dark:text-white">Laura Gómez</h4>
                        <p class="text-xs text-gray-500">Madrid</p>
                    </div>
                </footer>
            </article>
            <article class="w-[350px] bg-gray-50 dark:bg-[#1e2930] p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shrink-0">
                <div class="flex text-yellow-500 mb-4"><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span></div>
                <p class="text-gray-600 dark:text-gray-300 mb-6 italic">"La piscina del último piso tiene una puesta de sol mágica."</p>
                <footer class="flex items-center gap-4">
                    <img class="size-10 rounded-full" src="https://i.pravatar.cc/100?u=6" alt="Robert">
                    <div>
                        <h4 class="font-bold text-sm dark:text-white">Robert Smith</h4>
                        <p class="text-xs text-gray-500">Toronto</p>
                    </div>
                </footer>
            </article>
            <article class="w-[350px] bg-gray-50 dark:bg-[#1e2930] p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shrink-0">
                <div class="flex text-yellow-500 mb-4"><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span></div>
                <p class="text-gray-600 dark:text-gray-300 mb-6 italic">"Viajamos con niños y el espacio fue muy seguro y cómodo."</p>
                <footer class="flex items-center gap-4">
                    <img class="size-10 rounded-full" src="https://i.pravatar.cc/100?u=7" alt="Elena">
                    <div>
                        <h4 class="font-bold text-sm dark:text-white">Elena Ortiz</h4>
                        <p class="text-xs text-gray-500">Valencia</p>
                    </div>
                </footer>
            </article>
            <article class="w-[350px] bg-gray-50 dark:bg-[#1e2930] p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shrink-0">
                <div class="flex text-yellow-500 mb-4"><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span></div>
                <p class="text-gray-600 dark:text-gray-300 mb-6 italic">"Volveré sin duda. La relación calidad-precio es insuperable."</p>
                <footer class="flex items-center gap-4">
                    <img class="size-10 rounded-full" src="https://i.pravatar.cc/100?u=8" alt="Felipe">
                    <div>
                        <h4 class="font-bold text-sm dark:text-white">Felipe Ruiz</h4>
                        <p class="text-xs text-gray-500">Bogotá</p>
                    </div>
                </footer>
            </article>

            <div class="flex gap-6" aria-hidden="true">
            </div>
        </div>
    </div>
</section>