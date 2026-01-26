<style>
    /* Estilos para el scroll infinito */
    @keyframes infinite-scroll {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-50%);
        }
    }

    .animate-infinite-scroll {
        display: flex;
        width: max-content;
        animation: infinite-scroll 100s linear infinite;
        /* Velocidad ajustada para lectura */
    }

    .animate-infinite-scroll:hover {
        animation-play-state: paused;
    }

    .mask-fade-edges {
        mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
    }
</style>

<section class="py-32 bg-[#101c22] overflow-hidden" aria-labelledby="testimonios-title">
    <div class="max-w-7xl mx-auto mb-16 px-6">
        <header class="text-center">
            <span class="text-blue-500 font-bold uppercase tracking-[0.3em] text-xs block mb-3">Airbnb Reviews</span>
            <h2 id="testimonios-title" class="text-4xl md:text-5xl font-bold text-white mb-6">Experiencias de Huéspedes</h2>
        </header>
    </div>

    <div class="relative w-full overflow-hidden mask-fade-edges">
        <div class="animate-infinite-scroll flex gap-6" id="testimonial-track">
        </div>
    </div>
</section>

<script>
    // LISTA DE RESEÑAS REALES (Sin fotos, usando iniciales)
    const reseñas = [{
            nombre: "Fabian",
            ubicacion: "Barrancabermeja, Colombia",
            texto: "Excelente estancia. El alojamiento es muy cómodo, limpio y cumplió plenamente con lo ofrecido.",
            inicial: "F"
        },
        {
            nombre: "Henry",
            ubicacion: "Nueva York, USA",
            texto: "Una experiencia increíble. El apartamento está decorado con mucho gusto. El punto culminante fue la piscina privada y el acceso directo a la playa.",
            inicial: "H"
        },
        {
            nombre: "Melissa",
            ubicacion: "Nueva York, USA",
            texto: "¿Estás listo para que te mimen? No puedes igualar esa vista y el valor que tiene este apartamento; es como un mini resort.",
            inicial: "M"
        },
        {
            nombre: "Jonathan",
            ubicacion: "Manizales, Colombia",
            texto: "Todo tal cual la descripción, la ubicación es muy buena, las áreas comunes del edificio son excelentes, el servicio es oportuno y rápido.",
            inicial: "J"
        },
        {
            nombre: "Leyder",
            ubicacion: "California, USA",
            texto: "¡Qué joya de lugar! El apartamento lo tiene todo y más. Las fotos no le hacen justicia. Desayunamos frente al mar todos los días.",
            inicial: "L"
        },
        {
            nombre: "Maria",
            ubicacion: "Montana, USA",
            texto: "Nos encantó el apartamento, especialmente la cocina. El lugar estaba impecable y la señora que nos recibió fue muy amable.",
            inicial: "M"
        },
        {
            nombre: "Cliff",
            ubicacion: "Oregon, USA",
            texto: "El apartamento es superior. Perfectamente limpio, bien equipado y comunicación instantánea. El anfitrión cumplió con todas las solicitudes.",
            inicial: "C"
        },
        {
            nombre: "Tatiana Paola",
            ubicacion: "Barranquilla, Colombia",
            texto: "Excelente apartamento, cómodo, hermoso y muy acogedor.",
            inicial: "T"
        },
        {
            nombre: "Andres",
            ubicacion: "Medellín, Colombia",
            texto: "Excepcional. La propiedad tiene todas las comodidades, acceso directo al mar y anfitriones atentos. Perfecto para relajarse.",
            inicial: "A"
        },
        {
            nombre: "Lizeth",
            ubicacion: "Bogotá, Colombia",
            texto: "Un lugar tal cual las fotos. Olvidamos un computador y nos ayudaron inmensamente a recuperarlo. Lo tendremos en cuenta para la próxima.",
            inicial: "L"
        },
        {
            nombre: "Diego",
            ubicacion: "Rionegro, Colombia",
            texto: "Maravilloso apartamento, mucho mejor que en las fotos. El condominio es espectacular, no necesitas salir para pasar los mejores días.",
            inicial: "D"
        }
    ];

    function renderResenas() {
        const track = document.getElementById('testimonial-track');

        const cardsHTML = reseñas.map(r => `
            <article class="w-[350px] md:w-[450px] bg-[#1e2930]/30 p-8 rounded-3xl border border-white/5 backdrop-blur-md flex flex-col justify-between shrink-0">
                <div>
                    <div class="flex text-yellow-500 mb-5">
                        <span class="material-symbols-outlined">star</span>
                        <span class="material-symbols-outlined">star</span>
                        <span class="material-symbols-outlined">star</span>
                        <span class="material-symbols-outlined">star</span>
                        <span class="material-symbols-outlined">star</span>
                    </div>
                    <blockquote class="text-gray-200 text-lg italic leading-relaxed mb-8">
                        "${r.texto}"
                    </blockquote>
                </div>
                <footer class="flex items-center gap-4">
                    <div class="size-12 rounded-full bg-blue-600/20 border border-blue-500/40 flex items-center justify-center text-blue-400 font-bold text-xl">
                        ${r.inicial}
                    </div>
                    <div>
                        <cite class="not-italic font-bold text-white block">${r.nombre}</cite>
                        <span class="text-xs text-blue-400 uppercase font-semibold tracking-wider">${r.ubicacion}</span>
                    </div>
                </footer>
            </article>
        `).join('');

        track.innerHTML = `
            <div class="flex gap-6">${cardsHTML}</div>
            <div class="flex gap-6" aria-hidden="true">${cardsHTML}</div>
        `;
    }

    document.addEventListener('DOMContentLoaded', renderResenas);
</script>