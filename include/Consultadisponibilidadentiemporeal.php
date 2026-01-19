<section class="py-16 px-6 md:px-20 bg-[#101c22]" id="disponibilidad">
    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-12 items-center">

        <div class="flex-1 space-y-6">
            <span class="text-blue-500 font-bold uppercase tracking-wider text-sm">Planifica tu viaje</span>
            <h2 class="text-3xl md:text-5xl font-bold text-white leading-tight">
                Consulta disponibilidad en tiempo real
            </h2>
            <p class="text-gray-400 text-lg">
                Nuestros apartamentos son muy solicitados. Revisa el calendario para asegurar tus fechas ideales para unas vacaciones inolvidables.
            </p>

            <div class="flex flex-col gap-4 pt-4">
                <div class="flex items-center gap-3">
                    <div class="size-3 rounded-full bg-blue-600"></div>
                    <span class="text-sm font-medium text-gray-300">Fechas Disponibles</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="size-3 rounded-full bg-gray-700"></div>
                    <span class="text-sm font-medium text-gray-300">No Disponible</span>
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

                <div id="calendar-container" class="flex flex-col md:flex-row gap-6 justify-center transition-opacity duration-300">

                    <div class="flex min-w-[280px] flex-1 flex-col gap-2">
                        <div class="flex items-center p-1 justify-between mb-2">
                            <button onclick="prevMonth()" class="hover:bg-gray-700 text-white rounded-full p-1 transition-colors">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </button>
                            <p id="month1-name" class="text-white text-base font-bold text-center w-full">Enero 2026</p>
                        </div>
                        <div class="grid grid-cols-7 gap-y-2 text-center" id="grid-month1">
                        </div>
                    </div>

                    <div class="h-px w-full bg-gray-700 md:hidden"></div>

                    <div class="flex min-w-[280px] flex-1 flex-col gap-2">
                        <div class="flex items-center p-1 justify-between mb-2">
                            <p id="month2-name" class="text-white text-base font-bold text-center w-full">Febrero 2026</p>
                            <button onclick="nextMonth()" class="hover:bg-gray-700 text-white rounded-full p-1 transition-colors">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </button>
                        </div>
                        <div class="grid grid-cols-7 gap-y-2 text-center" id="grid-month2">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let currentStartMonth = 0; // 0 = Enero
    const year = 2026;
    const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    function renderCalendar() {
        const container = document.getElementById('calendar-container');
        container.style.opacity = 0;

        setTimeout(() => {
            updateMonth(currentStartMonth, 'month1-name', 'grid-month1');
            updateMonth(currentStartMonth + 1, 'month2-name', 'grid-month2');
            container.style.opacity = 1;
        }, 200);
    }

    function updateMonth(mIndex, nameId, gridId) {
        // Manejo de desbordamiento de meses (ej: Diciembre + 1)
        const displayMonth = mIndex % 12;
        const displayYear = year + Math.floor(mIndex / 12);

        document.getElementById(nameId).innerText = `${monthNames[displayMonth]} ${displayYear}`;

        const grid = document.getElementById(gridId);
        grid.innerHTML = `
            <p class="text-gray-500 text-xs font-bold">D</p>
            <p class="text-gray-500 text-xs font-bold">L</p>
            <p class="text-gray-500 text-xs font-bold">M</p>
            <p class="text-gray-500 text-xs font-bold">M</p>
            <p class="text-gray-500 text-xs font-bold">J</p>
            <p class="text-gray-500 text-xs font-bold">V</p>
            <p class="text-gray-500 text-xs font-bold">S</p>
        `;

        const firstDay = new Date(displayYear, displayMonth, 1).getDay();
        const daysInMonth = new Date(displayYear, displayMonth + 1, 0).getDate();

        // Celdas vacías iniciales
        for (let i = 0; i < firstDay; i++) {
            grid.innerHTML += '<span></span>';
        }

        // Renderizado de días
        for (let d = 1; d <= daysInMonth; d++) {
            // Ejemplo visual de estados (puedes adaptar esta lógica a tus datos reales)
            if (displayMonth === 0 && d === 5) {
                grid.innerHTML += `<span class="flex items-center justify-center h-8 w-8 mx-auto rounded-full bg-blue-600 text-white text-sm font-bold shadow-md shadow-blue-500/40">${d}</span>`;
            } else if (displayMonth === 0 && (d === 6 || d === 7)) {
                grid.innerHTML += `<span class="flex items-center justify-center h-8 w-8 mx-auto bg-blue-500/10 text-blue-400 text-sm font-medium rounded-full">${d}</span>`;
            } else if (displayMonth === 0 && d >= 8 && d <= 10) {
                grid.innerHTML += `<span class="flex items-center justify-center h-8 w-8 mx-auto text-sm text-gray-600 line-through">${d}</span>`;
            } else {
                grid.innerHTML += `<span class="flex items-center justify-center h-8 w-8 mx-auto text-sm text-gray-300 hover:bg-white/5 rounded-full cursor-pointer transition-colors">${d}</span>`;
            }
        }
    }

    function nextMonth() {
        if (currentStartMonth < 10) { // Límite hasta Nov-Dic
            currentStartMonth++;
            renderCalendar();
        }
    }

    function prevMonth() {
        if (currentStartMonth > 0) {
            currentStartMonth--;
            renderCalendar();
        }
    }

    document.addEventListener('DOMContentLoaded', renderCalendar);
</script>