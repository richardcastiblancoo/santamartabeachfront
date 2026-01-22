<style>
    /* Estilos para el scroll infinito */
    @keyframes infinite-scroll {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-50%);
        }

        /* Se desplaza la mitad (el contenido original) */
    }

    .animate-infinite-scroll {
        display: flex;
        width: max-content;
        /* Importante para que no se corte */
        animation: infinite-scroll 40s linear infinite;
    }

    /* Pausar al pasar el mouse */
    .animate-infinite-scroll:hover {
        animation-play-state: paused;
    }

    /* Degradado en los bordes para que las tarjetas aparezcan/desaparezcan suavemente */
    .mask-fade-edges {
        mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
    }
</style>

<section class="py-32 bg-[#101c22] overflow-hidden" aria-labelledby="testimonios-title">
    <div class="max-w-7xl mx-auto mb-16 px-6">
        <header class="text-center">
            <span class="text-blue-500 font-bold uppercase tracking-[0.3em] text-xs block mb-3" data-i18n="test_tag">Comunidad</span>
            <h2 id="testimonios-title" class="text-4xl md:text-5xl font-bold text-white mb-6" data-i18n="test_title">Experiencias Inolvidables</h2>
            <p class="text-gray-400 max-w-2xl mx-auto text-lg leading-relaxed" data-i18n="test_desc">
                Únete a los cientos de viajeros que han confiado en <strong>Reserva del Mar</strong>.
            </p>
        </header>
    </div>

    <div class="relative w-full overflow-hidden mask-fade-edges">
        <div class="animate-infinite-scroll flex gap-6" id="testimonial-track">

            <div class="flex gap-6">
                <article class="w-[350px] md:w-[400px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between shrink-0">
                    <div>
                        <div class="flex text-yellow-500 mb-5"><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span></div>
                        <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8">"¡Simplemente espectacular! La vista desde el balcón es inigualable."</blockquote>
                    </div>
                    <footer class="flex items-center gap-4">
                        <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=carolina" alt="Carolina">
                        <div><cite class="not-italic font-bold text-white block">Carolina Méndez</cite><span class="text-xs text-blue-400 uppercase font-semibold">Bogotá, COL</span></div>
                    </footer>
                </article>

                <article class="w-[350px] md:w-[400px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between shrink-0">
                    <div>
                        <div class="flex text-yellow-500 mb-5"><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span></div>
                        <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8">"La ubicación es envidiable. Estar a un paso de la playa Salguero lo es todo."</blockquote>
                    </div>
                    <footer class="flex items-center gap-4">
                        <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=david" alt="David">
                        <div><cite class="not-italic font-bold text-white block">David Johnson</cite><span class="text-xs text-blue-400 uppercase font-semibold">Miami, USA</span></div>
                    </footer>
                </article>

                <article class="w-[350px] md:w-[400px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between shrink-0">
                    <div>
                        <div class="flex text-yellow-500 mb-5"><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span></div>
                        <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8">"El apartamento estaba impecable. Los atardeceres desde la piscina son de otro mundo."</blockquote>
                    </div>
                    <footer class="flex items-center gap-4">
                        <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=lucia" alt="Lucía">
                        <div><cite class="not-italic font-bold text-white block">Lucía Ferreyra</cite><span class="text-xs text-blue-400 uppercase font-semibold">Buenos Aires, ARG</span></div>
                    </footer>
                </article>

                <article class="w-[350px] md:w-[400px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between shrink-0">
                    <div>
                        <div class="flex text-yellow-500 mb-5"><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span></div>
                        <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8">"Como nómada digital, el WiFi funcionó perfecto. Trabajar aquí fue increíble."</blockquote>
                    </div>
                    <footer class="flex items-center gap-4">
                        <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=sofia" alt="Sofía">
                        <div><cite class="not-italic font-bold text-white block">Sofía Ramírez</cite><span class="text-xs text-blue-400 uppercase font-semibold">Medellín, COL</span></div>
                    </footer>
                </article>
            </div>

            <div class="flex gap-6" aria-hidden="true">
                <article class="w-[350px] md:w-[400px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between shrink-0">
                    <div>
                        <div class="flex text-yellow-500 mb-5"><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span></div>
                        <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8">"¡Simplemente espectacular! La vista desde el balcón es inigualable."</blockquote>
                    </div>
                    <footer class="flex items-center gap-4">
                        <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=carolina" alt="Carolina">
                        <div><cite class="not-italic font-bold text-white block">Carolina Méndez</cite><span class="text-xs text-blue-400 uppercase font-semibold">Bogotá, COL</span></div>
                    </footer>
                </article>

                <article class="w-[350px] md:w-[400px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between shrink-0">
                    <div>
                        <div class="flex text-yellow-500 mb-5"><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span></div>
                        <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8">"La ubicación es envidiable. Estar a un paso de la playa Salguero lo es todo."</blockquote>
                    </div>
                    <footer class="flex items-center gap-4">
                        <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=david" alt="David">
                        <div><cite class="not-italic font-bold text-white block">David Johnson</cite><span class="text-xs text-blue-400 uppercase font-semibold">Miami, USA</span></div>
                    </footer>
                </article>

                <article class="w-[350px] md:w-[400px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between shrink-0">
                    <div>
                        <div class="flex text-yellow-500 mb-5"><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span></div>
                        <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8">"El apartamento estaba impecable. Los atardeceres desde la piscina son de otro mundo."</blockquote>
                    </div>
                    <footer class="flex items-center gap-4">
                        <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=lucia" alt="Lucía">
                        <div><cite class="not-italic font-bold text-white block">Lucía Ferreyra</cite><span class="text-xs text-blue-400 uppercase font-semibold">Buenos Aires, ARG</span></div>
                    </footer>
                </article>

                <article class="w-[350px] md:w-[400px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between shrink-0">
                    <div>
                        <div class="flex text-yellow-500 mb-5"><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span></div>
                        <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8">"Como nómada digital, el WiFi funcionó perfecto. Trabajar aquí fue increíble."</blockquote>
                    </div>
                    <footer class="flex items-center gap-4">
                        <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=sofia" alt="Sofía">
                        <div><cite class="not-italic font-bold text-white block">Sofía Ramírez</cite><span class="text-xs text-blue-400 uppercase font-semibold">Medellín, COL</span></div>
                    </footer>
                </article>
            </div>

        </div>
    </div>
</section>