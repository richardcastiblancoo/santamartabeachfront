/**
 * ==========================================
 * MAIN JAVASCRIPT
 * ==========================================
 */

/**
 * Controla la apertura y cierre del menú móvil.
 * Compatible con index.php (usa clases CSS 'active' y onclick inline).
 */
function toggleMobileMenu(open) {
  const menu = document.getElementById("mobile-menu");
  if (!menu) return; // Null check

  if (open) {
    menu.classList.add("active");
    document.body.style.overflow = "hidden";
  } else {
    menu.classList.remove("active");
    document.body.style.overflow = "auto";
  }
}
// Exponer a window para que funcione con onclick="..."
window.toggleMobileMenu = toggleMobileMenu;

/**
 * ==========================================
 * MAPA Y TESTIMONIOS
 * ==========================================
 */

/**
 * Inicializa la animación secuencial de Leaflet (Mapa interactivo).
 */
function initMapAnimation() {
  const mapContainer = document.getElementById("map-ubicacion");
  if (!mapContainer) return;

  if (typeof L === "undefined") return;

  // Verificar si existen las traducciones necesarias
  if (
    typeof translations === "undefined" ||
    typeof currentLang === "undefined"
  ) {
    // Si no están definidas, no ejecutar la animación para evitar errores
    return;
  }

  const coordsFinal = [11.1911119, -74.2311344];

  const map = L.map("map-ubicacion", {
    zoomControl: false,
    attributionControl: false,
    scrollWheelZoom: false,
  }).setView([20, 0], 2);

  L.tileLayer("https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}", {
    maxZoom: 20,
    subdomains: ["mt0", "mt1", "mt2", "mt3"],
  }).addTo(map);

  const markerLayer = L.layerGroup().addTo(map);

  async function sequence() {
    while (true) {
      if (typeof translations === "undefined") break;

      const m = translations[currentLang].map;
      const status = document.getElementById("map-status");

      if (status) status.innerText = m.planet;
      map.setView([20, 0], 2);
      markerLayer.clearLayers();
      await new Promise((r) => setTimeout(r, 3000));

      if (status) status.innerText = m.country;
      map.flyTo([4.5709, -74.2973], 6, { duration: 3 });
      await new Promise((r) => setTimeout(r, 4500));

      if (status) status.innerText = m.arriving;
      map.flyTo(coordsFinal, 18, { duration: 4 });
      await new Promise((r) => setTimeout(r, 5000));

      L.marker(coordsFinal)
        .addTo(markerLayer)
        .bindPopup(
          `<div class="text-center"><b>${m.popup_title}</b><br>${m.popup_desc}</div>`,
        )
        .openPopup();
      if (status) status.innerText = m.destination;

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
 * INICIALIZACIÓN Y EVENTOS
 * ==========================================
 */

document.addEventListener("DOMContentLoaded", () => {
  // Configuración inicial
  initMapAnimation();
  initTestimonialLoop();

  // Listener para el menú desplegable de idiomas
  const langBtn = document.getElementById("langBtn");
  if (langBtn) {
    langBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      document.getElementById("langMenu")?.classList.toggle("hidden");
    });
  }

  // Cerrar menús al hacer click fuera
  document.addEventListener("click", () =>
    document.getElementById("langMenu")?.classList.add("hidden"),
  );

  // Efecto visual del Header al hacer scroll
  const header = document.getElementById("main-header");
  if (header) {
    window.addEventListener("scroll", () => {
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
  }

  // --- ANIMACIÓN TYPEWRITER ---
  const textElement = document.getElementById("typewriter");
  if (textElement) {
    const text = "Vive la experiencia en";
    let index = 0;
    let isDeleting = false;
    let speed = 100;

    function type() {
      if (!textElement) return;

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
  }
});
//----------------------------

//-----------------------
//*** calendario */
let currentDate = new Date();

function renderCalendars() {
  const month1Name = document.getElementById("month1-name");
  const month2Name = document.getElementById("month2-name");
  const gridMonth1 = document.getElementById("grid-month1");
  const gridMonth2 = document.getElementById("grid-month2");

  // Limpiar grids
  gridMonth1.innerHTML = "";
  gridMonth2.innerHTML = "";

  // Configurar fechas para ambos meses
  const date1 = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
  const date2 = new Date(
    currentDate.getFullYear(),
    currentDate.getMonth() + 1,
    1,
  );

  const months = [
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre",
  ];

  // Actualizar Títulos
  month1Name.innerText = `${months[date1.getMonth()]} ${date1.getFullYear()}`;
  month2Name.innerText = `${months[date2.getMonth()]} ${date2.getFullYear()}`;

  // Renderizar cada mes
  renderMonth(date1, gridMonth1);
  renderMonth(date2, gridMonth2);
}

function renderMonth(date, container) {
  const daysOfWeek = ["Lu", "Ma", "Mi", "Ju", "Vi", "Sá", "Do"];

  // Crear encabezados de días
  daysOfWeek.forEach((day) => {
    const dayEl = document.createElement("div");
    dayEl.className = "text-gray-500 text-xs font-bold py-2";
    dayEl.innerText = day;
    container.appendChild(dayEl);
  });

  const year = date.getFullYear();
  const month = date.getMonth();

  // El primer día del mes (0 es domingo en JS, ajustamos a lunes = 0)
  let firstDayIndex = new Date(year, month, 1).getDay() - 1;
  if (firstDayIndex === -1) firstDayIndex = 6; // Ajuste para Domingo

  const daysInMonth = new Date(year, month + 1, 0).getDate();

  // Espacios vacíos antes del primer día
  for (let x = 0; x < firstDayIndex; x++) {
    const emptyDiv = document.createElement("div");
    container.appendChild(emptyDiv);
  }

  // Días del mes
  for (let i = 1; i <= daysInMonth; i++) {
    const dayEl = document.createElement("div");
    dayEl.className = "py-2 text-sm relative";

    // Simulación de disponibilidad (Aquí podrías conectar con una API)
    // Ejemplo: días pares disponibles, impares no disponibles
    const isAvailable = i % 2 === 0;

    const statusClass = isAvailable
      ? "text-white hover:bg-blue-600/20 cursor-pointer rounded-full"
      : "text-gray-600 line-through";

    const dotClass = isAvailable ? "bg-blue-600" : "bg-gray-700";

    dayEl.innerHTML = `
            <div class="flex flex-col items-center gap-1 ${statusClass}">
                <span>${i}</span>
                <div class="size-1 rounded-full ${dotClass}"></div>
            </div>
        `;
    container.appendChild(dayEl);
  }
}

function prevMonth() {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendars();
}

function nextMonth() {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendars();
}

// Inicializar al cargar la página
document.addEventListener("DOMContentLoaded", renderCalendars);

//-----------------------

// año actual en el footer

const yearElement = document.getElementById("current-year");
const currentYear = new Date().getFullYear();
yearElement.textContent = currentYear;
yearElement.setAttribute("datetime", currentYear);
//-----------------------