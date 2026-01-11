<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<footer class="bg-[#101c22] text-white pt-20 pb-10" id="contacto">
    <div class="max-w-7xl mx-auto px-6 md:px-10">

        <section class="flex flex-col lg:flex-row justify-between items-start lg:items-center pb-16 border-b border-gray-800 gap-8">
            <header>
                <h2 class="text-3xl font-bold mb-2">¿Listo para tus vacaciones?</h2>
                <p class="text-gray-400">Reserva hoy y asegura el mejor precio garantizado.</p>
            </header>
            <a href="#reservas" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-10 rounded-xl shadow-lg shadow-blue-900/20 transition-all transform hover:-translate-y-1 text-center">
                Reservar Ahora
            </a>
        </section>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 py-16">

            <section class="space-y-6">
                <figure class="flex items-center gap-2 text-blue-500">
                    <img src="/public/img/logo-portada.png" width="50px" alt="">
                    <figcaption class="text-xl font-bold text-white tracking-tight">
                        Santamarta<span class="text-blue-500">beachfront</span>
                    </figcaption>
                </figure>
                <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
                    La plataforma líder en alquileres vacacionales de lujo en Santa Marta. Experiencias únicas, confort superior y las mejores vistas del Caribe colombiano.
                </p>
            </section>

            <section>
                <h3 class="font-bold mb-6 text-white uppercase tracking-wider text-xs">Información de Contacto</h3>
                <address class="not-italic">
                    <ul class="space-y-4 text-sm text-gray-400">
                        <li>
                            <a href="mailto:17clouds@gmail.com" class="flex items-center gap-3 hover:text-white transition-colors group">
                                <span class="material-symbols-outlined text-blue-500 group-hover:scale-110 transition-transform" aria-hidden="true">mail</span>
                                <span>17clouds@gmail.com</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/573183813381" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 hover:text-white transition-colors group">
                                <span class="material-symbols-outlined text-blue-500 group-hover:scale-110 transition-transform" aria-hidden="true">call</span>
                                <span>+57 318 3813381</span>
                            </a>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-blue-500" aria-hidden="true">location_on</span>
                            <span>
                                Apartamento 1730 - Torre 4<br>
                                Reserva del Mar, Playa Salguero<br>
                                Santa Marta, Colombia
                            </span>
                        </li>
                    </ul>
                </address>
            </section>

            <section>
                <h3 class="font-bold mb-6 text-white uppercase tracking-wider text-xs">Síguenos</h3>
                <nav aria-label="Redes sociales">
                    <div class="flex gap-4">
                        <a class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-gradient-to-tr hover:from-[#f09433] hover:via-[#dc2743] hover:to-[#bc1888] transition-all duration-300 group" href="#" aria-label="Instagram">
                            <i class="fa-brands fa-instagram text-xl text-gray-400 group-hover:text-white"></i>
                        </a>
                        <a class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-black transition-all duration-300 group" href="#" aria-label="X (Twitter)">
                            <i class="fa-brands fa-x-twitter text-xl text-gray-400 group-hover:text-white"></i>
                        </a>
                        <a class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#1877F2] transition-all duration-300 group" href="#" aria-label="Facebook">
                            <i class="fa-brands fa-facebook-f text-xl text-gray-400 group-hover:text-white"></i>
                        </a>
                    </div>
                </nav>
            </section>
        </div>

        <aside class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-gray-800 text-[10px] sm:text-xs text-gray-500 gap-4">
            <p>© <time id="year"></time> Santamarta Beachfront. Todos los derechos reservados.</p>
            <nav class="flex gap-8" aria-label="Enlaces legales">
                <a class="hover:text-white transition-colors" href="/php/politica-terminos/politica-privacidad.php">Políticas de Privacidad</a>
                <a class="hover:text-white transition-colors" href="/php/politica-terminos/politica-privacidad.php">Términos y Condiciones</a>
            </nav>
        </aside>
    </div>
</footer>

<script>
    document.getElementById("year").textContent = new Date().getFullYear();
</script>