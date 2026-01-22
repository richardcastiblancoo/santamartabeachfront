<section class="grid grid-cols-1 lg:grid-cols-[1.5fr_1fr] min-h-[500px] bg-[#101c22] overflow-hidden" id="ubicacion">

    <article class="p-10 lg:p-16 flex flex-col justify-center order-2 lg:order-1">
        <header>
            <div class="flex items-center gap-2 text-blue-400 font-bold mb-6">
                <span class="material-symbols-outlined text-3xl">location_on</span>
                <span class="uppercase tracking-[0.3em] text-sm">Ubicación Privilegiada</span>
            </div>
            <h2 class="text-3xl lg:text-5xl font-bold mb-8 text-white leading-tight">
                Playa Salguero: <br><span class="text-blue-400">El corazón de Santa Marta</span>
            </h2>
        </header>

        <p class="text-gray-400 mb-10 text-lg leading-relaxed max-w-xl">
            Descubre la tranquilidad de <strong>Reserva del Mar</strong>, ubicado en la zona más exclusiva y con acceso directo al mar.
        </p>

        <address class="not-italic mb-10 space-y-3 border-l-4 border-blue-600 pl-6 py-2 bg-blue-900/10 rounded-r-xl max-w-md">
            <p class="text-xl font-black text-white">Reserva del Mar - Torre 4</p>
            <p class="text-lg text-slate-300">Apartamento 1730</p>
            <p class="text-sm text-slate-400 uppercase tracking-[0.2em]">Santa Marta, Colombia</p>
        </address>

        <ul class="space-y-4 mb-10" role="list">
            <li class="flex items-center gap-4 group">
                <div class="size-10 shrink-0 rounded-full bg-cyan-900/30 flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-xl">beach_access</span>
                </div>
                <span class="text-gray-300 font-medium text-base">A solo 1 minuto de la playa</span>
            </li>
            <li class="flex items-center gap-4 group">
                <div class="size-10 shrink-0 rounded-full bg-green-900/30 flex items-center justify-center text-green-400 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-xl">flight</span>
                </div>
                <span class="text-gray-300 font-medium text-base">15 min del Aeropuerto Internacional</span>
            </li>
            <li class="flex items-center gap-4 group">
                <div class="size-10 shrink-0 rounded-full bg-blue-900/30 flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-xl">restaurant</span>
                </div>
                <span class="text-gray-300 font-medium text-base">5 min de la Zona Gastronómica</span>
            </li>
        </ul>

        <a href="https://www.google.com/maps/search/?api=1&query=11.1911119,-74.2311344" target="_blank" class="self-start px-10 py-4 bg-blue-600 text-white font-bold rounded-full hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-500/20 active:scale-95 text-center">
            ¿Cómo llegar? (Google Maps)
        </a>
    </article>

    <aside class="relative w-full min-h-[400px] lg:min-h-full order-1 lg:order-2">
        <div id="map-ubicacion" class="absolute inset-0 w-full h-full bg-[#0b141a]"></div>

        <div class="absolute top-6 left-6 z-[1000] bg-[#101c22]/90 px-4 py-2 rounded-2xl border border-white/10 backdrop-blur-md shadow-2xl">
            <div class="flex items-center gap-3">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                </span>
                <p id="map-status" class="text-[9px] font-black text-white uppercase tracking-[0.2em] whitespace-nowrap">Iniciando satélite...</p>
            </div>
        </div>
    </aside>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof L === 'undefined') return;

        // Coordenadas
        const coords = {
            planeta: [20, 0],
            colombia: [4.5709, -74.2973],
            santaMarta: [11.2404, -74.1990],
            reservaMar: [11.1911119, -74.2311344]
        };

        const map = L.map('map-ubicacion', {
            zoomControl: false,
            attributionControl: false,
            scrollWheelZoom: false,
            dragging: false,
            doubleClickZoom: false
        }).setView(coords.planeta, 2);

        // Capa Satelital Natural (ESRI)
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}').addTo(map);

        // Capa de Etiquetas en Español/Multilingüe (CartoDB)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
            opacity: 0.8
        }).addTo(map);

        const status = document.getElementById('map-status');
        const markerLayer = L.layerGroup().addTo(map);

        async function iniciarTour() {
            while (true) {
                // PASO 1: EL PLANETA
                status.innerText = "1. Planeta Tierra";
                markerLayer.clearLayers();
                map.setView(coords.planeta, 2);
                await new Promise(r => setTimeout(r, 4000));

                // PASO 2: COLOMBIA
                status.innerText = "2. Colombia";
                map.flyTo(coords.colombia, 6, {
                    duration: 7,
                    easeLinearity: 0.25
                });
                await new Promise(r => setTimeout(r, 8000));

                // PASO 3: SANTA MARTA
                status.innerText = "3. Santa Marta";
                map.flyTo(coords.santaMarta, 12, {
                    duration: 6,
                    easeLinearity: 0.25
                });
                await new Promise(r => setTimeout(r, 7000));

                // PASO 4: RESERVA DEL MAR
                status.innerText = "4. Reserva del Mar";
                map.flyTo(coords.reservaMar, 18, {
                    duration: 8,
                    easeLinearity: 0.25
                });
                await new Promise(r => setTimeout(r, 10000));

                // Marcador final
                L.marker(coords.reservaMar).addTo(markerLayer)
                    .bindPopup('<div class="text-center"><b>Reserva del Mar</b><br>Torre 4 - Apto 1730</div>')
                    .openPopup();

                await new Promise(r => setTimeout(r, 10000));
            }
        }

        setTimeout(() => {
            map.invalidateSize();
            iniciarTour();
        }, 500);
    });
</script>

<style>
    .leaflet-tile-container {
        filter: contrast(1.05) brightness(0.9);
    }

    .leaflet-popup-content-wrapper {
        background: #101c22 !important;
        color: white !important;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .leaflet-popup-tip {
        background: #101c22 !important;
    }
</style>