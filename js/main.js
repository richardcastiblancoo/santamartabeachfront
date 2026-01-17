/**
 * 1. DICCIONARIO DE TRADUCCIONES UNIFICADO
 */
const translations = {
    "ES": {
        // Nav & Hero
        "nav_apartments": "Apartamentos", "nav_location": "Ubicación", "nav_about": "Nosotros", "nav_contact": "Contacto", "nav_login": "Iniciar sesión",
        "hero_title_top": "Vive la experiencia en", "hero_title_accent": "Santa Marta frente al mar", "hero_desc": "Los mejores apartamentos en Santamartabeachfront te esperan. Despierta con el sonido de las olas.",
        "btn_view": "Visualizar", "btn_contact": "Contactar",

        // Apartamentos
        "ap_title": "Apartamentos Destacados", "ap_subtitle": "Nuestras mejores propiedades para una estancia inolvidable",
        "ap_btn_book": "Reservar Ahora", "ap_btn_details": "Ver detalles", "ap_unit_bed": "Hab", "ap_unit_bath": "Baños", "ap_unit_pers": "Pers", "ap_night": "/noche", "ap_empty": "No hay apartamentos disponibles.",

        // Testimonios
        "test_tag": "Comunidad", "test_title": "Experiencias Inolvidables", "test_desc": "Únete a los cientos de viajeros que han confiado en Reserva del Mar.",
        "test_1_quote": "¡Simplemente espectacular! La vista desde el balcón es inigualable.",
        "test_2_quote": "La ubicación es envidiable. Estar a un paso de la playa Salguero lo es todo.",
        "test_3_quote": "El apartamento estaba impecable. Los atardeceres desde la piscina son de otro mundo.",
        "test_4_quote": "Como nómada digital, el WiFi funcionó perfecto. Trabajar aquí fue increíble.",
        "test_5_quote": "Excelente atención del personal. Sin duda volveremos con toda mi familia.",

        // Footer
        "foo_desc": "La plataforma líder en alquileres vacacionales de lujo en Santa Marta. Experiencias únicas, confort superior y las mejores vistas del Caribe colombiano.",
        "foo_contact_title": "Información de Contacto",
        "foo_address": "Apartamento 1730 - Torre 4, Reserva del Mar, Playa Salguero",
        "foo_country": "Colombia",
        "foo_social_title": "Síguenos",
        "foo_rights": "Todos los derechos reservados.",
        "foo_privacy": "Políticas de Privacidad",
        "foo_terms": "Términos y Condiciones",

        // Mapa & Calendario
        "map": { "planet": "Planeta Tierra", "country": "Colombia", "arriving": "Llegando a Reserva del Mar", "destination": "Destino Alcanzado", "popup_title": "Reserva del Mar", "popup_desc": "Torre 4 - A 1 min del mar" },
        "months": ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        "days": ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"]
    },
    "EN": {
        // Nav & Hero
        "nav_apartments": "Apartments", "nav_location": "Location", "nav_about": "About Us", "nav_contact": "Contact", "nav_login": "Login",
        "hero_title_top": "Live the experience at", "hero_title_accent": "Santa Marta Beachfront", "hero_desc": "The best apartments in Santamartabeachfront are waiting for you. Wake up to the waves.",
        "btn_view": "View More", "btn_contact": "Contact Us",

        // Apartments
        "ap_title": "Featured Apartments", "ap_subtitle": "Our best properties for an unforgettable stay",
        "ap_btn_book": "Book Now", "ap_btn_details": "View Details", "ap_unit_bed": "Beds", "ap_unit_bath": "Baths", "ap_unit_pers": "Guests", "ap_night": "/night", "ap_empty": "No apartments available.",

        // Testimonials
        "test_tag": "Community", "test_title": "Unforgettable Experiences", "test_desc": "Join the hundreds of travelers who have trusted Reserva del Mar.",
        "test_1_quote": "Simply spectacular! The view from the balcony is unmatched.",
        "test_2_quote": "Enviable location. Being a step away from Salguero beach is everything.",
        "test_3_quote": "The apartment was spotless. The sunsets from the pool are out of this world.",
        "test_4_quote": "As a digital nomad, the WiFi worked perfectly. Working here was incredible.",
        "test_5_quote": "Excellent staff attention. We will definitely return with my whole family.",

        // Footer
        "foo_desc": "The leading platform for luxury vacation rentals in Santa Marta. Unique experiences, superior comfort, and the best views of the Colombian Caribbean.",
        "foo_contact_title": "Contact Information",
        "foo_address": "Apartment 1730 - Tower 4, Reserva del Mar, Salguero Beach",
        "foo_country": "Colombia",
        "foo_social_title": "Follow Us",
        "foo_rights": "All rights reserved.",
        "foo_privacy": "Privacy Policy",
        "foo_terms": "Terms & Conditions",

        // Map & Calendar
        "map": { "planet": "Planet Earth", "country": "Colombia", "arriving": "Arriving at Reserva del Mar", "destination": "Destination Reached", "popup_title": "Reserva del Mar", "popup_desc": "Tower 4 - 1 min from sea" },
        "months": ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        "days": ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]
    }
};

/**
 * 2. LÓGICA DE ESTADO
 */
let currentLang = localStorage.getItem("selectedLang") || "ES";
let currentStartMonth = new Date().getMonth();
const year = 2026;

/**
 * 3. MOTOR DE TRADUCCIÓN Y CAMBIO DE BANDERA
 */
function changeLanguage(lang) {
    currentLang = lang;
    localStorage.setItem("selectedLang", lang);
    const texts = translations[lang];

    // Traducir elementos con data-i18n
    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        if (texts[key]) el.innerHTML = texts[key];
    });

    // Cambiar texto e imagen del botón de idioma
    const langBtnText = document.getElementById('currentLangText');
    const langFlag = document.getElementById('currentFlag');
    if (langBtnText) langBtnText.innerText = lang;
    if (langFlag) {
        langFlag.src = (lang === 'ES') ? "https://flagcdn.com/w40/co.png" : "https://flagcdn.com/w40/us.png";
    }

    renderCalendar();
    
    // Cerrar menús desplegables
    document.getElementById('langMenu')?.classList.add('hidden');
    document.getElementById('mobileMenu')?.classList.add('hidden');
}

/**
 * 4. GESTIÓN DEL CALENDARIO
 */
function renderCalendar() {
    updateMonth(currentStartMonth, "month1-name", "grid-month1", "grid-header-1");
    updateMonth(currentStartMonth + 1, "month2-name", "grid-month2", "grid-header-2");
}

function updateMonth(mIndex, nameId, gridId, headerId) {
    const monthNames = translations[currentLang].months;
    const dayNames = translations[currentLang].days;
    const nameEl = document.getElementById(nameId);
    const gridEl = document.getElementById(gridId);
    const headerEl = document.getElementById(headerId);
    
    if (!nameEl || !gridEl) return;

    nameEl.innerText = `${monthNames[mIndex]} ${year}`;
    if (headerEl) {
        headerEl.innerHTML = dayNames.map(d => `<span>${d}</span>`).join('');
    }

    const firstDay = new Date(year, mIndex, 1).getDay();
    const daysInMonth = new Date(year, mIndex + 1, 0).getDate();

    let html = "";
    for (let i = 0; i < firstDay; i++) html += "<span></span>";
    for (let d = 1; d <= daysInMonth; d++) {
        html += `<span class="flex items-center justify-center h-8 w-8 mx-auto text-sm text-gray-300 hover:bg-white/5 rounded-full cursor-pointer">${d}</span>`;
    }
    gridEl.innerHTML = html;
}

/**
 * 5. ANIMACIÓN DEL MAPA (LEAFLET)
 */
function initMapAnimation() {
    const mapContainer = document.getElementById("map-ubicacion");
    if (!mapContainer) return;

    const coordsFinal = [11.1911119, -74.2311344];
    const map = L.map("map-ubicacion", { zoomControl: false, attributionControl: false, scrollWheelZoom: false }).setView([20, 0], 2);

    L.tileLayer("https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}", {
        maxZoom: 20,
        subdomains: ["mt0", "mt1", "mt2", "mt3"],
    }).addTo(map);

    const markerLayer = L.layerGroup().addTo(map);

    async function sequence() {
        while (true) {
            const m = translations[currentLang].map;
            const status = document.getElementById("map-status");

            if (status) status.innerText = m.planet;
            map.setView([20, 0], 2);
            markerLayer.clearLayers();
            await new Promise(r => setTimeout(r, 3000));

            if (status) status.innerText = m.country;
            map.flyTo([4.5709, -74.2973], 6, { duration: 3 });
            await new Promise(r => setTimeout(r, 4500));

            if (status) status.innerText = m.arriving;
            map.flyTo(coordsFinal, 18, { duration: 4 });
            await new Promise(r => setTimeout(r, 5000));

            L.marker(coordsFinal).addTo(markerLayer)
                .bindPopup(`<div class="text-center"><b>${m.popup_title}</b><br>${m.popup_desc}</div>`).openPopup();

            if (status) status.innerText = m.destination;
            await new Promise(r => setTimeout(r, 10000));
        }
    }
    sequence();
}

/**
 * 6. LOOP INFINITO DE TESTIMONIOS
 */
function initTestimonialLoop() {
    const track = document.getElementById('testimonial-track');
    if (track) {
        const content = track.innerHTML;
        track.innerHTML = content + content; // Duplicar contenido para scroll fluido
    }
}

/**
 * 7. INICIALIZACIÓN GLOBAL
 */
document.addEventListener("DOMContentLoaded", () => {
    // Aplicar idioma y bandera al cargar
    changeLanguage(currentLang);
    
    // Iniciar componentes visuales
    initMapAnimation();
    initTestimonialLoop();

    // Eventos del selector de idiomas
    const langBtn = document.getElementById("langBtn");
    if (langBtn) {
        langBtn.onclick = (e) => {
            e.stopPropagation();
            document.getElementById("langMenu")?.classList.toggle("hidden");
        };
    }
    document.addEventListener("click", () => document.getElementById("langMenu")?.classList.add("hidden"));
});

// Exponer funciones globales
window.changeLanguage = changeLanguage;
window.nextMonth = () => { if (currentStartMonth < 10) { currentStartMonth++; renderCalendar(); } };
window.prevMonth = () => { if (currentStartMonth > 0) { currentStartMonth--; renderCalendar(); } };