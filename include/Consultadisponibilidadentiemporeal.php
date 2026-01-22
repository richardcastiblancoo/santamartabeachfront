 <!-- disponible? -->
 <section class="py-16 px-6 md:px-20 bg-[#101c22]" id="disponibilidad">
     <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-12 items-center">

         <div class="flex-1 space-y-6">
             <span class="text-blue-400 font-bold uppercase tracking-wider text-sm">Planifica tu viaje</span>
             <h2 class="text-3xl md:text-5xl font-bold text-white leading-tight">
                 Consulta disponibilidad en tiempo real
             </h2>
             <p class="text-gray-400 text-lg">
                 Nuestros apartamentos son muy solicitados. Revisa el calendario para asegurar tus fechas ideales.
             </p>

             <div class="flex flex-col gap-4 pt-4">
                 <div class="flex items-center gap-3">
                     <div class="size-3 rounded-full bg-blue-600"></div>
                     <span class="text-sm font-medium text-gray-300">Fechas Disponibles</span>
                 </div>
                 <div class="flex items-center gap-3">
                     <div class="size-3 rounded-full bg-gray-700"></div>
                     <span class="text-sm font-medium text-gray-300">No Disponible / Pasado</span>
                 </div>
             </div>

             <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 pt-6">
                 <a href="https://wa.me/573183813381?text=Hola!%20Me%20gustaría%20consultar%20disponibilidad%20para%20una%20reserva."
                     target="_blank"
                     class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-blue-600/20 active:scale-95">
                     <span class="material-symbols-outlined">calendar_add_on</span>
                     Reservar por WhatsApp
                 </a>
             </div>
         </div>

         <div class="flex-1 w-full flex justify-center lg:justify-end">
             <div class="bg-[#1e2930] rounded-2xl shadow-2xl p-6 border border-white/10 max-w-2xl w-full relative overflow-hidden">

                 <div id="calendar-container" class="flex flex-col md:flex-row gap-8 justify-center transition-opacity duration-300">

                     <div class="flex min-w-[280px] flex-1 flex-col gap-2">
                         <div class="flex items-center p-1 justify-between mb-2">
                             <button onclick="changeMonth(-1)" class="hover:bg-gray-700 text-white rounded-full p-1 transition-colors">
                                 <span class="material-symbols-outlined">chevron_left</span>
                             </button>
                             <p id="month1-name" class="text-white text-base font-bold text-center w-full capitalize"></p>
                             <div class="md:hidden"> <button onclick="changeMonth(1)" class="hover:bg-gray-700 text-white rounded-full p-1 transition-colors">
                                     <span class="material-symbols-outlined">chevron_right</span>
                                 </button>
                             </div>
                         </div>
                         <div class="grid grid-cols-7 gap-y-2 text-center" id="grid-month1"></div>
                     </div>

                     <div class="h-px w-full bg-gray-700 md:hidden"></div>

                     <div class="flex min-w-[280px] flex-1 flex-col gap-2">
                         <div class="flex items-center p-1 justify-between mb-2">
                             <div class="hidden md:block w-8"></div>
                             <p id="month2-name" class="text-white text-base font-bold text-center w-full capitalize"></p>
                             <button onclick="changeMonth(1)" class="hover:bg-gray-700 text-white rounded-full p-1 transition-colors">
                                 <span class="material-symbols-outlined">chevron_right</span>
                             </button>
                         </div>
                         <div class="grid grid-cols-7 gap-y-2 text-center" id="grid-month2"></div>
                     </div>
                 </div>

             </div>
         </div>
     </div>
 </section>

 <script>
     let currentViewDate = new Date(); // Fecha de referencia para la vista

     function renderCalendars() {
         const grid1 = document.getElementById('grid-month1');
         const grid2 = document.getElementById('grid-month2');
         const name1 = document.getElementById('month1-name');
         const name2 = document.getElementById('month2-name');

         const date1 = new Date(currentViewDate.getFullYear(), currentViewDate.getMonth(), 1);
         const date2 = new Date(currentViewDate.getFullYear(), currentViewDate.getMonth() + 1, 1);

         const options = {
             month: 'long',
             year: 'numeric'
         };
         name1.innerText = date1.toLocaleDateString('es-ES', options);
         name2.innerText = date2.toLocaleDateString('es-ES', options);

         renderMonth(date1, grid1);
         renderMonth(date2, grid2);
     }

     function renderMonth(date, container) {
         container.innerHTML = '';
         const daysOfWeek = ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá', 'Do'];
         const today = new Date();
         today.setHours(0, 0, 0, 0);

         // Headers
         daysOfWeek.forEach(day => {
             const d = document.createElement('div');
             d.className = 'text-gray-500 text-xs font-bold py-2';
             d.innerText = day;
             container.appendChild(d);
         });

         const year = date.getFullYear();
         const month = date.getMonth();
         let firstDay = new Date(year, month, 1).getDay() - 1;
         if (firstDay === -1) firstDay = 6; // Domingo

         const totalDays = new Date(year, month + 1, 0).getDate();

         // Relleno inicial
         for (let i = 0; i < firstDay; i++) {
             container.appendChild(document.createElement('div'));
         }

         // Días del mes
         for (let day = 1; day <= totalDays; day++) {
             const dateObj = new Date(year, month, day);
             const isPast = dateObj < today;

             // Simulación: Días ocupados (ejemplo: múltiplos de 5 o si es pasado)
             const isOccupied = isPast || (day % 7 === 0 || day % 8 === 0);

             const dayDiv = document.createElement('div');
             dayDiv.className = 'py-2 flex flex-col items-center gap-1';

             const textClass = isOccupied ? 'text-gray-600 line-through' : 'text-white font-medium';
             const dotClass = isOccupied ? 'bg-gray-700' : 'bg-blue-600';

             dayDiv.innerHTML = `
                <span class="${textClass} text-sm">${day}</span>
                <div class="size-1 rounded-full ${dotClass}"></div>
            `;
             container.appendChild(dayDiv);
         }
     }

     function changeMonth(offset) {
         currentViewDate.setMonth(currentViewDate.getMonth() + offset);
         renderCalendars();
     }

     // Inicializar
     document.addEventListener('DOMContentLoaded', renderCalendars);
 </script>