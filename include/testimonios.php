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
            <div class="flex justify-center mb-6">
                <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 fill-[#FF5A5F]" aria-hidden="true">
                    <path d="M16 1c2.008 0 3.463.963 4.751 3.269l.533 1.025c1.954 3.83 6.114 12.54 7.1 14.836l.145.353c.667 1.591.91 2.472.96 3.396l.01.415.001.228c0 4.062-2.877 6.478-6.357 6.478-2.224 0-4.556-1.258-6.709-3.386l-.257-.26-.172-.179h-.011l-.176.185c-2.044 2.1-4.392 3.42-6.72 3.42-3.481 0-6.358-2.416-6.358-6.478l.002-.23c.011-.94.254-1.822.928-3.398l.145-.352c.987-2.297 5.147-11.007 7.1-14.836l.533-1.025C12.537 1.963 13.992 1 16 1zm0 2c-1.239 0-2.053.539-2.987 2.21l-.523 1.008c-1.926 3.776-6.06 12.43-7.031 14.692l-.145.352c-.527 1.255-.744 2.008-.799 2.726l-.015.393-.001.164c0 2.893 1.802 4.478 4.358 4.478 1.877 0 3.873-1.08 5.761-3.022l.247-.254.171-.174.001-.001c.027-.027.067-.027.094 0l.001.001.171.174.247.254c1.888 1.942 3.884 3.022 5.761 3.022 2.556 0 4.357-1.585 4.357-4.478l-.001-.165-.015-.392c-.055-.718-.272-1.47-.799-2.726l-.145-.352c-.971-2.262-5.105-10.916-7.031-14.692l-.523-1.008C18.053 3.539 17.24 3 16 3zm0.01 10.316c3.01 0 5.451 2.48 5.451 5.541 0 3.06-2.441 5.541-5.451 5.541s-5.451-2.481-5.451-5.541c0-3.06 2.441-5.541 5.451-5.541zm0 2c-1.907 0-3.451 1.585-3.451 3.541s1.544 3.541 3.451 3.541 3.451-1.585 3.451-3.541-1.544-3.541-3.451-3.541z"></path>
                </svg>
            </div>
            <span class="text-blue-500 font-bold uppercase tracking-[0.3em] text-xs block mb-3">Airbnb Reseñas</span>
            <h2 id="testimonios-title" class="text-4xl md:text-5xl font-bold text-white mb-6">Experiencias de Huéspedes</h2>
        </header>
    </div>

    <div class="relative w-full overflow-hidden mask-fade-edges">
        <div class="animate-infinite-scroll flex gap-6" id="testimonial-track">
        </div>
    </div>
</section>

<script>
    // LISTA DE RESEÑAS REALES (Sin cambios)
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