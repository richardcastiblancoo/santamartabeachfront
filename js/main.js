/**
 * ==========================================
 * 4. NAVEGACIÓN Y MENÚ MÓVIL (VERSIÓN 1)
 * ==========================================
 */

/**
 * Controla la apertura y cierre del menú móvil con animaciones de Tailwind.
 * Si el menú está oculto, lo muestra y anima los elementos de navegación uno a uno.
 */
function toggleMobileMenu() {
  const mobileMenu = document.getElementById("mobileMenu");
  const items = document.querySelectorAll(".mobile-nav-item");
  // Verifica si el menú está actualmente cerrado buscando la clase de traslación
  const isOpening = mobileMenu.classList.contains("-translate-y-full");

  if (isOpening) {
    // Abrir menú: elimina clases de ocultación
    mobileMenu.classList.remove(
      "-translate-y-full",
      "opacity-0",
      "pointer-events-none",
    );
    // Bloquea el scroll del cuerpo para que el usuario no se desplace mientras el menú está abierto
    document.body.style.overflow = "hidden";

    // Anima cada ítem del menú con un pequeño retraso (stagger effect)
    items.forEach((item, index) => {
      setTimeout(
        () => {
          item.classList.remove("translate-y-4", "opacity-0");
        },
        80 * (index + 1),
      );
    });
  } else {
    closeMobileMenu();
  }
}

/**
 * Oculta el menú móvil y restablece los estados visuales y de scroll.
 */
function closeMobileMenu() {
  const mobileMenu = document.getElementById("mobileMenu");
  const items = document.querySelectorAll(".mobile-nav-item");
  if (mobileMenu) {
    mobileMenu.classList.add(
      "-translate-y-full",
      "opacity-0",
      "pointer-events-none",
    );
    // Restablece el scroll normal de la página
    document.body.style.overflow = "";
    // Resetea la posición de los ítems para la próxima apertura
    items.forEach((item) => item.classList.add("translate-y-4", "opacity-0"));
  }
}

/**
 * ==========================================
 * 5. GESTIÓN DEL CALENDARIO
 * ==========================================
 */

/**
 * Renderiza los dos meses visibles en la sección de disponibilidad.
 */
function renderCalendar() {
  // Renderiza el mes actual
  updateMonth(currentStartMonth, "month1-name", "grid-month1", "grid-header-1");
  // Renderiza el mes siguiente
  updateMonth(
    currentStartMonth + 1,
    "month2-name",
    "grid-month2",
    "grid-header-2",
  );
}

/**
 * Actualiza el contenido HTML de un mes específico.
 * @param {number} mIndex - Índice del mes.
 * @param {string} nameId - ID del contenedor del nombre del mes.
 * @param {string} gridId - ID del contenedor de los días.
 * @param {string} headerId - ID del contenedor de cabeceras (días de la semana).
 */
function updateMonth(mIndex, nameId, gridId, headerId) {
  const monthNames = translations[currentLang].months;
  const dayNames = translations[currentLang].days;
  const nameEl = document.getElementById(nameId);
  const gridEl = document.getElementById(gridId);
  const headerEl = document.getElementById(headerId);

  if (!nameEl || !gridEl) return;

  // Controlar desbordamiento de meses (índice 0-11) usando módulo
  const displayIndex = mIndex % 12;

  // Insertar nombre del mes y año
  nameEl.innerText = `${monthNames[displayIndex]} ${year}`;

  // Renderizar cabecera de días (D L M M J V S)
  if (headerEl)
    headerEl.innerHTML = dayNames.map((d) => `<span>${d}</span>`).join("");

  // Calcular primer día de la semana y total de días
  const firstDay = new Date(year, displayIndex, 1).getDay();
  const daysInMonth = new Date(year, displayIndex + 1, 0).getDate();

  let html = "";
  // Crear espacios vacíos para los días antes del día 1
  for (let i = 0; i < firstDay; i++) html += "<span></span>";
  // Crear cada día del mes
  for (let d = 1; d <= daysInMonth; d++) {
    html += `<span class="flex items-center justify-center h-8 w-8 mx-auto text-sm text-gray-300 hover:bg-white/5 rounded-full cursor-pointer">${d}</span>`;
  }
  gridEl.innerHTML = html;
}

/**
 * ==========================================
 * 6. MAPA Y TESTIMONIOS
 * ==========================================
 */

/**
 * Inicializa la animación secuencial de Leaflet (Mapa interactivo).
 * Realiza un zoom desde el mundo hasta una ubicación específica en Colombia.
 */
function initMapAnimation() {
  const mapContainer = document.getElementById("map-ubicacion");
  if (!mapContainer) return;

  const coordsFinal = [11.1911119, -74.2311344]; // Coordenadas del destino

  // Configuración inicial del mapa
  const map = L.map("map-ubicacion", {
    zoomControl: false,
    attributionControl: false,
    scrollWheelZoom: false,
  }).setView([20, 0], 2);

  // Capas de Google Maps Satellite
  L.tileLayer("https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}", {
    maxZoom: 20,
    subdomains: ["mt0", "mt1", "mt2", "mt3"],
  }).addTo(map);

  const markerLayer = L.layerGroup().addTo(map);

  /**
   * Ciclo infinito de animación del mapa
   */
  async function sequence() {
    while (true) {
      const m = translations[currentLang].map;
      const status = document.getElementById("map-status");

      // 1. Vista Global
      if (status) status.innerText = m.planet;
      map.setView([20, 0], 2);
      markerLayer.clearLayers();
      await new Promise((r) => setTimeout(r, 3000));

      // 2. Acercamiento al País (Colombia)
      if (status) status.innerText = m.country;
      map.flyTo([4.5709, -74.2973], 6, { duration: 3 });
      await new Promise((r) => setTimeout(r, 4500));

      // 3. Acercamiento al Destino Final
      if (status) status.innerText = m.arriving;
      map.flyTo(coordsFinal, 18, { duration: 4 });
      await new Promise((r) => setTimeout(r, 5000));

      // 4. Mostrar Marcador y Pop-up
      L.marker(coordsFinal)
        .addTo(markerLayer)
        .bindPopup(
          `<div class="text-center"><b>${m.popup_title}</b><br>${m.popup_desc}</div>`,
        )
        .openPopup();
      if (status) status.innerText = m.destination;

      // Espera antes de reiniciar el ciclo
      await new Promise((r) => setTimeout(r, 10000));
    }
  }
  sequence();
}

/**
 * Duplica el contenido del track de testimonios para permitir un scroll infinito fluido.
 */
function initTestimonialLoop() {
  const track = document.getElementById("testimonial-track");
  if (track) track.innerHTML += track.innerHTML;
}

/**
 * ==========================================
 * 7. INICIALIZACIÓN GLOBAL Y EVENTOS
 * ==========================================
 */

document.addEventListener("DOMContentLoaded", () => {
  // Configuración inicial
  changeLanguage(currentLang);
  initMapAnimation();
  initTestimonialLoop();

  // Listener para el menú desplegable de idiomas
  document.getElementById("langBtn")?.addEventListener("click", (e) => {
    e.stopPropagation();
    document.getElementById("langMenu")?.classList.toggle("hidden");
  });

  // Listeners para el menú móvil
  document
    .getElementById("menuBtn")
    .addEventListener("click", toggleMobileMenu);
  document
    .getElementById("closeBtn")
    .addEventListener("click", closeMobileMenu);

  // Cerrar menús al hacer click fuera
  document.addEventListener("click", () =>
    document.getElementById("langMenu")?.classList.add("hidden"),
  );

  // Efecto visual del Header al hacer scroll
  window.addEventListener("scroll", () => {
    const header = document.getElementById("main-header");
    if (window.scrollY > 40) {
      header.classList.add(
        "bg-slate-950/90",
        "backdrop-blur-md",
        "py-4",
        "shadow-2xl",
      );
      header.classList.remove("py-6");
    } else {
      header.classList.remove(
        "bg-slate-950/90",
        "backdrop-blur-md",
        "py-4",
        "shadow-2xl",
      );
      header.classList.add("py-6");
    }
  });
});

/**
 * ==========================================
 * 8. API GLOBAL (Accesible desde HTML)
 * ==========================================
 */

window.changeLanguage = changeLanguage;
window.toggleMobileMenu = toggleMobileMenu;

/**
 * Navegación del calendario hacia adelante
 */
window.nextMonth = () => {
  if (currentStartMonth < 10) {
    currentStartMonth++;
    renderCalendar();
  }
};

/**
 * Navegación del calendario hacia atrás
 */
window.prevMonth = () => {
  if (currentStartMonth > 0) {
    currentStartMonth--;
    renderCalendar();
  }
};

// --- ANIMACIÓN TYPEWRITER ---
/**
 * Crea el efecto de escritura en el Hero section.
 */
const textElement = document.getElementById("typewriter");
const text = "Vive la experiencia en";
let index = 0;
let isDeleting = false;
let speed = 100;

function type() {
  const currentText = text.substring(0, index);
  textElement.textContent = currentText;

  if (!isDeleting && index < text.length) {
    index++;
    speed = 100;
  } else if (isDeleting && index > 0) {
    index--;
    speed = 50;
  } else {
    isDeleting = !isDeleting;
    speed = isDeleting ? 2500 : 700; // Pausa larga al terminar de escribir
  }
  setTimeout(type, speed);
}
type();

// --- MENÚ MÓVIL (VERSIÓN 2 / REDUNDANTE) ---
/**
 * Segunda implementación del menú móvil (usa clases CSS 'active' en lugar de Tailwind directo)
 */
function toggleMobileMenu(open) {
  const menu = document.getElementById("mobile-menu");
  if (open) {
    menu.classList.add("active");
    document.body.style.overflow = "hidden";
  } else {
    menu.classList.remove("active");
    document.body.style.overflow = "auto";
  }
}

// --- HEADER SCROLL (VERSIÓN 2 / REDUNDANTE) ---
/**
 * Segunda implementación del cambio de estilo del header al hacer scroll.
 */
window.addEventListener("scroll", () => {
  const header = document.getElementById("main-header");
  if (window.scrollY > 50) {
    header.style.background = "rgba(15, 23, 42, 0.95)";
    header.classList.add("py-2", "shadow-2xl");
  } else {
    header.style.background = "transparent";
    header.classList.remove("py-2", "shadow-2xl");
  }
});

//----------------------------------------------------------------

/******** */




//**------------------------------------------------------------- */