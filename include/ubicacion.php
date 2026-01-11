<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<section class="grid grid-cols-1 lg:grid-cols-2 min-h-[700px] py-20 bg-gray-50 dark:bg-[#0b141a]" id="ubicacion">
    
    <article class="bg-white dark:bg-[#101c22] p-10 lg:p-24 flex flex-col justify-center shadow-sm lg:rounded-l-3xl">
        <header>
            <div class="flex items-center gap-2 text-blue-600 font-bold mb-6" style="color: #007bff;"> 
                <span class="material-symbols-outlined text-3xl">location_on</span>
                <span class="uppercase tracking-[0.3em] text-sm">Ubicación Privilegiada</span>
            </div>
            <h2 class="text-4xl lg:text-5xl font-bold mb-8 text-[#111618] dark:text-white leading-tight">
                Playa Salguero: <br><span class="text-blue-600">El corazón de Santa Marta</span>
            </h2>
        </header>

        <p class="text-gray-500 dark:text-gray-400 mb-10 text-xl leading-relaxed">
            Descubre la tranquilidad de <strong>Reserva del Mar</strong>, ubicado en la zona más exclusiva y con acceso directo al mar.
        </p>

        <address class="not-italic mb-10 space-y-3 border-l-4 border-blue-600 pl-6 py-2 bg-blue-50/50 dark:bg-blue-900/10 rounded-r-xl">
            <p class="text-2xl font-black text-slate-800 dark:text-white">Reserva del Mar - Torre 4</p>
            <p class="text-lg text-slate-600 dark:text-slate-300">Apartamento 1730</p>
            <p class="text-sm text-slate-400 uppercase tracking-[0.2em]">Santa Marta, Colombia</p>
        </address>

        <ul class="space-y-6 mb-12" role="list">
            <li class="flex items-center gap-4 group">
                <div class="size-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-xl">flight</span>
                </div>
                <span class="dark:text-gray-300 font-medium text-lg">15 min del Aeropuerto Internacional</span>
            </li>
            <li class="flex items-center gap-4 group">
                <div class="size-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-xl">restaurant</span>
                </div>
                <span class="dark:text-gray-300 font-medium text-lg">5 min de la Zona Gastronómica</span>
            </li>
            <li class="flex items-center gap-4 group">
                <div class="size-10 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600 dark:text-orange-400 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-xl">park</span>
                </div>
                <span class="dark:text-gray-300 font-medium text-lg">20 min del Parque Tayrona</span>
            </li>
        </ul>

        <a href="https://maps.google.com/?q=Reserva+del+Mar+Torre+4+Santa+Marta" target="_blank" class="self-start px-8 py-4 bg-[#007bff] text-white font-bold rounded-full hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-500/30 active:scale-95">
            Abrir en Google Maps
        </a>
    </article>

    <aside class="relative h-[600px] lg:h-auto w-full bg-[#050505] overflow-hidden lg:rounded-r-3xl shadow-2xl">
        <div id="map" class="w-full h-full"></div>
        
        <div class="absolute top-8 left-8 z-[1000] bg-white/95 dark:bg-[#101c22]/95 px-5 py-3 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-800 backdrop-blur-md">
            <div class="flex items-center gap-3">
                <span class="flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-600"></span>
                </span>
                <p id="map-status" class="text-[10px] font-black text-gray-800 dark:text-white uppercase tracking-[0.2em]">Localizando...</p>
            </div>
        </div>
    </aside>
</section>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Coordenadas actualizadas: Reserva del Mar - Torre 4
    const coordsFinal = [11.1911119, -74.2311344]; 
    const coordsColombia = [4.5709, -74.2973];
    const coordsEspacio = [20, 0];

    const map = L.map('map', {
        zoomControl: false,
        attributionControl: false,
        scrollWheelZoom: false 
    }).setView(coordsEspacio, 2);

    // Satélite Google a todo Color
    L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
    }).addTo(map);

    async function animarMapa() {
        const status = document.getElementById('map-status');

        while(true) {
            status.innerText = "Planeta Tierra";
            map.setView(coordsEspacio, 2);
            await new Promise(r => setTimeout(r, 3000));

            status.innerText = "Hacia Colombia";
            map.flyTo(coordsColombia, 6, { duration: 4, easeLinearity: 0.25 });
            await new Promise(r => setTimeout(r, 5000));

            status.innerText = "Reserva del Mar - Torre 4";
            map.flyTo(coordsFinal, 19, { duration: 5, easeLinearity: 0.25 });
            await new Promise(r => setTimeout(r, 6000));

            const marker = L.marker(coordsFinal).addTo(map)
                .bindPopup('<div class="p-1"><b class="text-blue-600">Torre 4 - Apto 1730</b><br><span class="text-xs">Reserva del Mar</span></div>')
                .openPopup();
            
            status.innerText = "Destino Alcanzado";
            
            await new Promise(r => setTimeout(r, 8000));
            map.removeLayer(marker);
        }
    }

    window.onload = animarMapa;
</script>

<style>
    .leaflet-container { background: #0b141a !important; }
    .leaflet-popup-content-wrapper {
        border-radius: 12px;
        padding: 4px;
        font-family: inherit;
    }
</style>