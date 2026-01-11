<section class="grid grid-cols-1 lg:grid-cols-2 min-h-[650px] bg-[#101c22] overflow-hidden" id="ubicacion">
    
    <article class="p-10 lg:p-20 flex flex-col justify-center order-2 lg:order-1">
        <header>
            <div class="flex items-center gap-2 text-blue-500 font-bold mb-6"> 
                <span class="material-symbols-outlined text-3xl">location_on</span>
                <span class="uppercase tracking-[0.3em] text-sm">Ubicación Privilegiada</span>
            </div>
            <h2 class="text-4xl lg:text-5xl font-bold mb-8 text-white leading-tight">
                Playa Salguero: <br><span class="text-blue-500">El corazón de Santa Marta</span>
            </h2>
        </header>

        <p class="text-gray-400 mb-10 text-xl leading-relaxed max-w-xl">
            Descubre la tranquilidad de <strong>Reserva del Mar</strong>, ubicado en la zona más exclusiva y con acceso directo al mar.
        </p>

        <address class="not-italic mb-10 space-y-3 border-l-4 border-blue-600 pl-6 py-2 bg-blue-900/10 rounded-r-xl max-w-md">
            <p class="text-2xl font-black text-white">Reserva del Mar - Torre 4</p>
            <p class="text-lg text-slate-300">Apartamento 1730</p>
            <p class="text-sm text-slate-500 uppercase tracking-[0.2em]">Santa Marta, Colombia</p>
        </address>

        <ul class="space-y-6 mb-12" role="list">
            <li class="flex items-center gap-4 group">
                <div class="size-11 shrink-0 rounded-full bg-cyan-900/30 flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-xl">beach_access</span>
                </div>
                <span class="text-gray-300 font-medium text-lg">A solo 1 minuto de la playa</span>
            </li>
            <li class="flex items-center gap-4 group">
                <div class="size-11 shrink-0 rounded-full bg-green-900/30 flex items-center justify-center text-green-400 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-xl">flight</span>
                </div>
                <span class="text-gray-300 font-medium text-lg">15 min del Aeropuerto Internacional</span>
            </li>
            <li class="flex items-center gap-4 group">
                <div class="size-11 shrink-0 rounded-full bg-blue-900/30 flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-xl">restaurant</span>
                </div>
                <span class="text-gray-300 font-medium text-lg">5 min de la Zona Gastronómica</span>
            </li>
        </ul>

        <a href="https://www.google.com/maps/search/?api=1&query=Reserva+del+Mar+Torre+4+Santa+Marta" target="_blank" class="self-start px-10 py-4 bg-blue-600 text-white font-bold rounded-full hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-500/20 active:scale-95">
            Abrir en Google Maps
        </a>
    </article>

    <aside class="relative w-full min-h-[500px] lg:min-h-full order-1 lg:order-2">
        <div id="map-ubicacion" class="absolute inset-0 w-full h-full"></div>
        
        <div class="absolute top-6 left-6 z-[1000] bg-[#101c22]/90 px-5 py-3 rounded-2xl border border-white/10 backdrop-blur-md shadow-2xl">
            <div class="flex items-center gap-3">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-600"></span>
                </span>
                <p id="map-status" class="text-[10px] font-black text-white uppercase tracking-[0.2em] whitespace-nowrap">Localizando...</p>
            </div>
        </div>
    </aside>
</section>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    (function() {
        // Coordenadas exactas para Reserva del Mar
        const coordsFinal = [11.1911119, -74.2311344]; 
        const coordsColombia = [4.5709, -74.2973];
        const coordsEspacio = [20, 0];

        const map = L.map('map-ubicacion', {
            zoomControl: false,
            attributionControl: false,
            scrollWheelZoom: false 
        }).setView(coordsEspacio, 2);

        // Capa Satélite Google
        L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(map);

        function fixMap() {
            setTimeout(() => { map.invalidateSize(); }, 600);
        }

        async function animarMapa() {
            const status = document.getElementById('map-status');
            const markerLayer = L.layerGroup().addTo(map);

            while(true) {
                if(!document.getElementById('map-ubicacion')) break;

                status.innerText = "Planeta Tierra";
                map.setView(coordsEspacio, 2);
                markerLayer.clearLayers();
                await new Promise(r => setTimeout(r, 2500));

                status.innerText = "Colombia";
                map.flyTo(coordsColombia, 6, { duration: 3 });
                await new Promise(r => setTimeout(r, 4000));

                status.innerText = "Llegando a reservas del mar santa marta";
                map.flyTo(coordsFinal, 18, { duration: 4 });
                await new Promise(r => setTimeout(r, 5000));

                L.marker(coordsFinal).addTo(markerLayer)
                    .bindPopup('<div class="text-center p-1"><b class="text-blue-500">Reserva del Mar</b><br><span class="text-xs">Torre 4 - A 1 min del mar</span></div>')
                    .openPopup();
                
                status.innerText = "Destino Alcanzado";
                await new Promise(r => setTimeout(r, 8000));
            }
        }

        window.addEventListener('load', fixMap);
        fixMap();
        animarMapa();
    })();
</script>

<style>
    #map-ubicacion { background: #0b141a; }
    .leaflet-popup-content-wrapper { 
        background: #101c22 !important; 
        color: white !important; 
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .leaflet-popup-tip { background: #101c22 !important; }
    .shrink-0 { flex-shrink: 0; }
</style>