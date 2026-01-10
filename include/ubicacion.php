<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<section class="grid grid-cols-1 lg:grid-cols-2 min-h-[500px]" id="ubicacion">
    <div class="bg-white dark:bg-[#101c22] p-10 lg:p-20 flex flex-col justify-center">
        <div class="flex items-center gap-2 text-primary font-bold mb-4" style="color: #007bff;"> <span class="material-symbols-outlined">map</span>
            <span>UBICACIÓN ESTRATÉGICA</span>
        </div>
        <h2 class="text-4xl font-bold mb-6 text-[#111618] dark:text-white">Cerca de todo lo que importa</h2>
        <p class="text-gray-500 dark:text-gray-400 mb-8 text-lg">
            Estamos ubicados en el corazón de la zona turística, a pocos minutos del Aeropuerto y con acceso directo a las principales playas y restaurantes.
        </p>
        <ul class="space-y-4 mb-8">
            <li class="flex items-center gap-3">
                <div class="size-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                    <span class="material-symbols-outlined text-sm">flight</span>
                </div>
                <span class="dark:text-gray-300">15 min del Aeropuerto Internacional</span>
            </li>
            <li class="flex items-center gap-3">
                <div class="size-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                    <span class="material-symbols-outlined text-sm">restaurant</span>
                </div>
                <span class="dark:text-gray-300">5 min de Zona Gastronómica</span>
            </li>
            <li class="flex items-center gap-3">
                <div class="size-8 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600 dark:text-orange-400">
                    <span class="material-symbols-outlined text-sm">park</span>
                </div>
                <span class="dark:text-gray-300">20 min del Parque Tayrona</span>
            </li>
        </ul>
        <a href="https://maps.google.com/?q=11.190734,-74.225449" target="_blank" class="self-start text-primary font-bold underline decoration-2 underline-offset-4 hover:text-primary/80" style="color: #007bff;">
            Abrir en Google Maps
        </a>
    </div>

    <div class="relative h-[500px] lg:h-auto w-full bg-[#050505]">
        <div id="map" class="w-full h-full grayscale hover:grayscale-0 transition-all duration-700"></div>
        
        <div class="absolute bottom-6 left-6 z-[1000] bg-white/90 dark:bg-[#101c22]/90 p-3 rounded-lg shadow-lg backdrop-blur-sm pointer-events-none">
            <p id="map-status" class="text-xs font-bold text-gray-800 dark:text-white uppercase tracking-widest">Iniciando viaje...</p>
        </div>
    </div>
</section>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const coordsFinal = [11.190734, -74.225449]; // Coordenadas de Reservas del Mar que me pasaste
    const coordsColombia = [4.5709, -74.2973];
    const coordsEspacio = [20, 0];

    const map = L.map('map', {
        zoomControl: false,
        attributionControl: false,
        scrollWheelZoom: false // Para no interrumpir el scroll de la web
    }).setView(coordsEspacio, 2);

    // Capa satelital estilo Google
    L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
    }).addTo(map);

    async function animarMapa() {
        const status = document.getElementById('map-status');

        while(true) {
            // 1. Reset al Mundo
            status.innerText = "Nuestro Planeta";
            map.setView(coordsEspacio, 2);
            await new Promise(r => setTimeout(r, 3000));

            // 2. Vuelo a Colombia
            status.innerText = "Destino: Colombia";
            map.flyTo(coordsColombia, 6, { duration: 4, easeLinearity: 0.25 });
            await new Promise(r => setTimeout(r, 5000));

            // 3. Vuelo Final a Santa Marta - Reserva del Mar
            status.innerText = "Reserva del Mar, Santa Marta";
            map.flyTo(coordsFinal, 17, { duration: 5, easeLinearity: 0.25 });
            await new Promise(r => setTimeout(r, 6000));

            // Añadir marcador temporal
            const marker = L.marker(coordsFinal).addTo(map);
            status.innerText = "¡Llegamos al paraíso!";
            
            await new Promise(r => setTimeout(r, 8000));
            map.removeLayer(marker);
        }
    }

    // Iniciar cuando la sección sea visible (opcional pero recomendado)
    window.onload = animarMapa;
</script>

<style>
    /* Aseguramos que el mapa no se vea cortado y tenga transiciones suaves */
    .leaflet-container {
        background: #0b141a !important;
    }
    #map {
        cursor: default;
    }
</style>