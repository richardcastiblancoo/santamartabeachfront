<style>
    /* Animación optimizada */
    @keyframes infiniteScroll {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); } /* Se mueve exactamente la mitad */
    }

    .carousel-track {
        display: flex;
        width: max-content;
        gap: 1.5rem; /* gap-6 */
        animation: infiniteScroll 40s linear infinite;
        will-change: transform;
    }

    .carousel-track:hover {
        animation-play-state: paused;
    }

    .star-fill {
        font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }

    .mask-fade-edges {
        mask-image: linear-gradient(to right, transparent 0%, black 15%, black 85%, transparent 100%);
        -webkit-mask-image: linear-gradient(to right, transparent 0%, black 15%, black 85%, transparent 100%);
    }
</style>

<section class="py-32 bg-[#101c22] overflow-hidden" aria-labelledby="testimonios-title">
    <div class="max-w-7xl mx-auto mb-16 px-6">
        <header class="text-center">
            <span class="text-blue-500 font-bold uppercase tracking-[0.3em] text-xs block mb-3">Comunidad</span>
            <h2 id="testimonios-title" class="text-4xl md:text-5xl font-bold text-white mb-6">Experiencias Inolvidables</h2>
            <p class="text-gray-400 max-w-2xl mx-auto text-lg leading-relaxed">
                Únete a los cientos de viajeros que han confiado en <strong>Reserva del Mar</strong>.
            </p>
        </header>
    </div>

    <div class="relative w-full overflow-hidden mask-fade-edges">
        <div class="carousel-track">
            
            <div class="flex gap-6">
                <article class="w-[380px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between">
                    <div>
                        <div class="flex text-yellow-500 mb-5">
                            <span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span>
                        </div>
                        <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8">"¡Simplemente espectacular! La vista desde el balcón es inigualable y la brisa del mar te relaja al instante."</blockquote>
                    </div>
                    <footer class="flex items-center gap-4">
                        <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=carolina" alt="">
                        <div><cite class="not-italic font-bold text-white block">Carolina Méndez</cite><span class="text-xs text-blue-400 uppercase font-semibold">Bogotá, COL</span></div>
                    </footer>
                </article>

                <article class="w-[380px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between">
                    <div>
                        <div class="flex text-yellow-500 mb-5">
                            <span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span>
                        </div>
                        <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8">"La ubicación es envidiable. Estar a un paso de la playa Salguero y tener restaurantes cerca lo es todo."</blockquote>
                    </div>
                    <footer class="flex items-center gap-4">
                        <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=david" alt="">
                        <div><cite class="not-italic font-bold text-white block">David Johnson</cite><span class="text-xs text-blue-400 uppercase font-semibold">Miami, USA</span></div>
                    </footer>
                </article>

                <article class="w-[380px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between">
                    <div>
                        <div class="flex text-yellow-500 mb-5">
                            <span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span>
                        </div>
                        <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8">"Como nómada digital, el WiFi funcionó perfecto. Trabajar con esa vista al mar fue una experiencia increíble."</blockquote>
                    </div>
                    <footer class="flex items-center gap-4">
                        <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=sofia" alt="">
                        <div><cite class="not-italic font-bold text-white block">Sofía Ramírez</cite><span class="text-xs text-blue-400 uppercase font-semibold">Medellín, COL</span></div>
                    </footer>
                </article>
            </div>

            <div class="flex gap-6" aria-hidden="true">
                <article class="w-[380px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between">
                    <div>
                        <div class="flex text-yellow-500 mb-5"><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span></div>
                        <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8">"¡Simplemente espectacular! La vista desde el balcón es inigualable..."</blockquote>
                    </div>
                    <footer class="flex items-center gap-4">
                        <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=carolina" alt="">
                        <div><cite class="not-italic font-bold text-white block">Carolina Méndez</cite><span class="text-xs text-blue-400 uppercase font-semibold">Bogotá, COL</span></div>
                    </footer>
                </article>

                <article class="w-[380px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between">
                    <div>
                        <div class="flex text-yellow-500 mb-5"><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span></div>
                        <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8">"La ubicación es envidiable. Estar a un paso de la playa Salguero y tener restaurantes cerca."</blockquote>
                    </div>
                    <footer class="flex items-center gap-4">
                        <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=david" alt="">
                        <div><cite class="not-italic font-bold text-white block">David Johnson</cite><span class="text-xs text-blue-400 uppercase font-semibold">Miami, USA</span></div>
                    </footer>
                </article>

                <article class="w-[380px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between">
                    <div>
                        <div class="flex text-yellow-500 mb-5"><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span><span class="material-symbols-outlined star-fill">star</span></div>
                        <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8">"Como nómada digital, el WiFi funcionó perfecto. Trabajar con esa vista al mar fue increíble."</blockquote>
                    </div>
                    <footer class="flex items-center gap-4">
                        <img class="size-12 rounded-full border-2 border-blue-500/20 object-cover" src="https://i.pravatar.cc/150?u=sofia" alt="">
                        <div><cite class="not-italic font-bold text-white block">Sofía Ramírez</cite><span class="text-xs text-blue-400 uppercase font-semibold">Medellín, COL</span></div>
                    </footer>
                </article>
            </div>

        </div>
    </div>
</section>