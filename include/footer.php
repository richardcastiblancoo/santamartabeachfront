 <footer class="bg-[#101c22] text-white pt-10 pb-10 mt-[-2rem]" id="contacto">
     <div class="max-w-7xl mx-auto px-6 md:px-10">
         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 lg:gap-24 py-16 items-start border-t border-white/5">

             <section class="flex flex-col items-center md:items-start text-center md:text-left">
                 <a href="/" class="flex items-center gap-4 group w-fit mb-6">
                     <div class="w-16 h-16 md:w-20 md:h-20 shrink-0">
                         <img src="/public/img/logo-def-Photoroom.png" alt="logo" class="w-full h-full object-contain">
                     </div>
                     <span class="text-xl md:text-2xl font-bold text-white tracking-tighter">
                         Santamarta<span class="text-blue-400">beachfront</span>
                     </span>
                 </a>
                 <p class="text-gray-300 text-sm leading-relaxed max-w-xs md:pl-5 md:border-l md:border-blue-400/20" data-i18n="footer-desc">
                     La plataforma líder en alquileres vacacionales de lujo en Santa Marta. Experiencias únicas, confort superior y las mejores vistas del Caribe colombiano.
                 </p>
             </section>

             <section class="lg:pl-12 flex flex-col items-center md:items-start">
                 <h2 class="font-bold mb-8 text-white uppercase tracking-widest text-xs" data-i18n="footer-contact-title">Información de Contacto</h2>
                 <address class="not-italic">
                     <ul class="space-y-5 text-sm text-gray-300 text-center md:text-left">
                         <li>
                             <a href="mailto:17clouds@gmail.com" class="flex items-center justify-center md:justify-start gap-3 hover:text-blue-400 transition-colors">
                                 <span class="material-symbols-outlined text-blue-400">mail</span> 17clouds@gmail.com
                             </a>
                         </li>
                         <li>
                             <a href="https://wa.me/573183813381" class="flex items-center justify-center md:justify-start gap-3 hover:text-blue-400 transition-colors">
                                 <span class="material-symbols-outlined text-blue-400">call</span> +57 318 3813381
                             </a>
                         </li>
                         <li class="flex items-start justify-center md:justify-start gap-3">
                             <span class="material-symbols-outlined text-blue-400 shrink-0">location_on</span>
                             <span>
                                 Apartamento 1730 - Torre 4 - Reserva del Mar 1<br>
                                 Calle 22 # 1 - 67 Playa Salguero,<br>
                                 Santa Marta, Colombia
                             </span>
                         </li>
                     </ul>
                 </address>
             </section>

             <section class="lg:items-end flex flex-col">
                 <div class="w-fit lg:text-right">
                     <h2 class="font-bold mb-8 text-white uppercase tracking-wider text-xs" data-i18n="foo_social_title">Síguenos</h2>
                     <nav aria-label="Redes sociales">
                         <ul class="flex gap-4 list-none p-0 lg:justify-end">
                             <li>
                                 <a class="w-12 h-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center hover:bg-gradient-to-tr hover:from-[#f09433] hover:via-[#dc2743] hover:to-[#bc1888] transition-all duration-300 group" href="#" target="_blank" rel="noopener" aria-label="Instagram">
                                     <i class="fa-brands fa-instagram text-xl text-gray-300 group-hover:text-white"></i>
                                 </a>
                             </li>
                             <li>
                                 <a class="w-12 h-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center hover:bg-black transition-all duration-300 group" href="#" target="_blank" rel="noopener" aria-label="Twitter">
                                     <i class="fa-brands fa-x-twitter text-xl text-gray-300 group-hover:text-white"></i>
                                 </a>
                             </li>
                             <li>
                                 <a class="w-12 h-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center hover:bg-[#ff0050] transition-all duration-300 group" href="#" target="_blank" rel="noopener" aria-label="TikTok">
                                     <i class="fa-brands fa-tiktok text-xl text-gray-300 group-hover:text-white"></i>
                                 </a>
                             </li>
                         </ul>
                     </nav>
                 </div>
             </section>
         </div>

         <aside class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-gray-800 text-xs text-gray-400 text-center gap-4">
             <p>
                 © <time id="current-year" datetime="2026">2026</time> Santamarta Beachfront.
                 <span data-i18n="foo_rights">Todos los derechos reservados.</span> |
                 Hecho por <a href="https://richardcastiblanco.vercel.app/" target="_blank" rel="noopener noreferrer" class="font-bold hover:text-white">Richard Castiblanco</a>
             </p>

             <nav aria-label="Enlaces legales">
                 <ul class="flex gap-8 list-none p-0">
                     <li><a class="hover:text-white transition-colors" href="/php/politica-terminos/politica-privacidad.php" data-key="foo_privacy">Políticas de Privacidad</a></li>
                     <li><a class="hover:text-white transition-colors" href="/php/politica-terminos/politica-privacidad.php" data-key="foo_terms">Términos y Condiciones</a></li>
                 </ul>
             </nav>
         </aside>
     </div>
 </footer>

 <script>
     const yearElement = document.getElementById('current-year');
     const currentYear = new Date().getFullYear();
     yearElement.textContent = currentYear;
     yearElement.setAttribute('datetime', currentYear);
 </script>