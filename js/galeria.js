// 1. Configuración de los elementos de la galería
const mediaItems = [];

// Llenamos el array con la lógica de tus archivos (1-32 fotos)
// Nota: El video está en la posición 4 (index 4) según tu HTML original
for (let i = 1; i <= 32; i++) {
  if (i === 5) {
    // Si el archivo 5 es el video especial
    mediaItems.push({
      type: "video",
      src: "/public/video/video-reserva-del-mar.mp4",
    });
  }
  mediaItems.push({
    type: "image",
    src: `/public/img/©️SantaMartaBeachFront-compressed-${i}.webp`,
  });
}

let currentIndex = 0;

// 2. Función para abrir el modal
function openGallery(index) {
  currentIndex = index;
  updateModal();
  document.getElementById("gallery-modal").classList.remove("hidden");
  document.body.classList.add("modal-active"); // Evita el scroll de fondo
}

// 3. Función para actualizar el contenido del modal
function updateModal() {
  const item = mediaItems[currentIndex];
  const content = document.getElementById("modal-content");

  // Efecto suave de transición
  content.style.opacity = "0";

  setTimeout(() => {
    if (item.type === "image") {
      content.innerHTML = `
                    <img src="${item.src}" 
                         class="max-w-[95vw] max-h-[85vh] object-contain animate-zoom rounded-xl shadow-2xl">`;
    } else {
      content.innerHTML = `
                    <video controls autoplay class="max-w-[95vw] max-h-[80vh] rounded-xl shadow-2xl">
                        <source src="${item.src}" type="video/mp4">
                    </video>`;
    }
    content.style.opacity = "1";
  }, 150);
}

// 4. Controles de navegación
function nextMedia() {
  currentIndex = (currentIndex + 1) % mediaItems.length;
  updateModal();
}

function prevMedia() {
  currentIndex = (currentIndex - 1 + mediaItems.length) % mediaItems.length;
  updateModal();
}

function closeModal() {
  document.getElementById("gallery-modal").classList.add("hidden");
  document.body.classList.remove("modal-active");

  // Pausar cualquier video que se esté reproduciendo al cerrar
  const content = document.getElementById("modal-content");
  content.innerHTML = "";
}

// 5. Atajos de teclado
document.addEventListener("keydown", (e) => {
  if (document.getElementById("gallery-modal").classList.contains("hidden"))
    return;

  if (e.key === "Escape") closeModal();
  if (e.key === "ArrowRight") nextMedia();
  if (e.key === "ArrowLeft") prevMedia();
});
//-----------------------------

// 1. Diccionario de traducciones
const translations = {
  es: {
    "nav-home": "Inicio",
    "click-expand": "Click para ampliar video",
    "cta-title": "¿Listo para vivir la experiencia?",
    "cta-desc":
      "Reserva tu estancia en la Torre 4 de Reserva del Mar 1 y despierta frente al mar Caribe.",
    "btn-call": "Llamar ahora",
    "footer-contact-title": "Información de Contacto",
    "footer-desc":
      "La plataforma líder en alquileres vacacionales de lujo en Santa Marta. Experiencias únicas, confort superior y las mejores vistas del Caribe colombiano.",
    foo_social_title: "Síguenos",
    foo_rights: "Todos los derechos reservados.",
    foo_privacy: "Políticas de Privacidad",
    foo_terms: "Términos y Condiciones",
  },
  en: {
    "nav-home": "Home",
    "click-expand": "Click to expand video",
    "cta-title": "Ready to live the experience?",
    "cta-desc":
      "Book your stay at Tower 4 of Reserva del Mar 1 and wake up facing the Caribbean Sea.",
    "btn-call": "Call now",
    "footer-contact-title": "Contact Information",
    "footer-desc":
      "The leading platform for luxury vacation rentals in Santa Marta. Unique experiences, superior comfort, and the best views of the Colombian Caribbean.",
    foo_social_title: "Follow us",
    foo_rights: "All rights reserved.",
    foo_privacy: "Privacy Policies",
    foo_terms: "Terms and Conditions",
  },
};

// 2. Función para cambiar el idioma
function changeLang(lang) {
  // Guardar preferencia en el navegador
  localStorage.setItem("preferredLang", lang);

  // Actualizar todos los elementos con el atributo data-i18n
  document.querySelectorAll("[data-i18n]").forEach((el) => {
    const key = el.getAttribute("data-i18n");
    if (translations[lang][key]) {
      el.textContent = translations[lang][key];
    }
  });

  // También actualizar los que usan data-key (si usaste esa variante en los links legales)
  document.querySelectorAll("[data-key]").forEach((el) => {
    const key = el.getAttribute("data-key");
    if (translations[lang][key]) {
      el.textContent = translations[lang][key];
    }
  });

  // Actualizar estado visual de las banderas
  document.getElementById("btn-es").classList.remove("flag-active");
  document.getElementById("btn-en").classList.remove("flag-active");
  document.getElementById(`btn-${lang}`).classList.add("flag-active");

  // Opcional: Cambiar el atributo lang del HTML para SEO
  document.documentElement.lang = lang;
}

// 3. Cargar idioma preferido al iniciar la página
document.addEventListener("DOMContentLoaded", () => {
  const savedLang = localStorage.getItem("preferredLang") || "es";
  changeLang(savedLang);
});
